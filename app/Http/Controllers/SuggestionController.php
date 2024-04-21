<?php
    namespace App\Http\Controllers;

    use Illuminate\Http\Request;
    use App\Models\Suggestion;
    use App\Models\SuggestionImageBefore;
    use App\Models\SuggestionImageAfter;
    use Illuminate\Support\Facades\DB;
    use Illuminate\Support\Facades\Storage;

    class SuggestionController extends Controller
    {
        public function store(Request $request)
        {
            // Старт транзакции
            DB::beginTransaction();
            try {
                // Валидация данных запроса
                $validated = $request->validate([
                    'author' => 'required',
                    'collaborator' => 'nullable',
                    'department' => 'required|exists:departments,depart_id',
                    'type' => 'required|exists:types,type_id',
                    'description' => 'required',
                    'photo_problem' => 'nullable|image',
                    'photo_solution' => 'nullable|image',
                ]);

                // Создание новой записи предложения
                $suggestion = new Suggestion([
                    'author' => $validated['author'],
                    'date' => 'required|date|before:tomorrow',
                    'collaborator' => $validated['collaborator'] ?? '',
                    'depart_id' => $validated['department'],
                    'type_id' => $validated['type'],
                    'suggestion_content' => $validated['description'],
                ]);
                $suggestion->save();

                // Сохранение фотографий, если они загружены
                if ($request->hasFile('photo_problem')) {
                    $path = $request->file('photo_problem')->store('public/images');
                    $imageBefore = new SuggestionImageBefore([
                        'file_path' => Storage::url($path),
                        'sugg_id' => $suggestion->sugg_id
                    ]);
                    $imageBefore->save();
                }

                if ($request->hasFile('photo_solution')) {
                    $path = $request->file('photo_solution')->store('public/images');
                    $imageAfter = new SuggestionImageAfter([
                        'file_path' => Storage::url($path),
                        'sugg_id' => $suggestion->sugg_id
                    ]);
                    $imageAfter->save();
                }

                // Если все в порядке, фиксируем транзакцию
                DB::commit();

                // Перенаправление с сообщением об успехе
                return redirect()->back()->with('success', 'Предложение успешно отправлено.');
            } catch (\Exception $e) {
                DB::rollback();
                return redirect()->back()->withErrors('Произошла ошибка при сохранении данных.');
            }
        }
    }
