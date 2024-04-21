<?php
    namespace App\Http\Controllers;

    use Illuminate\Http\Request;
    use App\Models\Suggestion;
    use App\Models\SuggestionImageBefore;
    use App\Models\SuggestionImageAfter;
    use Illuminate\Support\Facades\DB;
    use Illuminate\Support\Facades\Storage;
    use \Illuminate\Http\RedirectResponse;
    class SuggestionController extends Controller
    {
        public function store(Request $request): RedirectResponse
        {
            // Старт транзакции
            DB::beginTransaction();
            try {
                // Валидация данных запроса
                $validated = $request->validate([
                    'author' => 'required',
                    'date' => 'required|date',
                    'collaborator' => 'nullable',
                    'department' => 'required|exists:departments,id',
                    'email' => 'required|email',
                    'phone' => 'nullable',
                    'type' => 'nullable',
                    'description' => 'required',
                    'photo_problem' => 'nullable|image',
                    'photo_solution' => 'nullable|image',
                ]);

                // Создание новой записи предложения
                $suggestion = new Suggestion([
                    'author' => $validated['author'],
                    'date' => $validated['date'],
                    'collaborator' => $validated['collaborator'] ?? '',
                    'email' => $validated['email'],
                    'depart_id' => $validated['department'],
                    'phone_number' => $validated['phone'],
                    'status_id' => 1,
                    'type_id' => 1,
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
                return redirect()->route('app');
            }
            catch (\Exception $e) {
                DB::rollback();
                dd($e->getMessage());
                //return redirect()->route('app');
            }
        }
    }
