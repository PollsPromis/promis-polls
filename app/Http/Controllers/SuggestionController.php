<?php

    namespace App\Http\Controllers;

    use App\Models\Status;
    use App\Models\Suggestion;
    use App\Models\SuggestionImageAfter;
    use App\Models\SuggestionImageBefore;
    use Illuminate\Http\RedirectResponse;
    use Illuminate\Http\Request;
    use Illuminate\Support\Facades\DB;
    use Illuminate\Support\Facades\Storage;

    class SuggestionController extends Controller
    {
        public function store(Request $request): RedirectResponse
        {
            // Старт транзакции
            DB::beginTransaction();
            try {
                // Валидация данных запроса
                $validated = $request->validate([
                    'author'         => 'required',
                    'date'           => 'required|date',
                    'collaborator'   => 'nullable',
                    'department'     => 'required|exists:departments,id',
                    'email'          => 'nullable|email',
                    'phone_number'   => 'nullable',
                    'type'           => 'nullable',
                    'description'    => 'required',
                    'photo_problem'  => 'nullable|image',
                    'photo_solution' => 'nullable|image',
                ]);

                // Создание новой записи предложения
                $suggestion = new Suggestion([
                    'author'             => $validated['author'],
                    'date'               => $validated['date'],
                    'collaborator'       => $validated['collaborator'] ?? '',
                    'email'              => $validated['email'],
                    'depart_id'          => $validated['department'],
                    'phone_number'       => $validated['phone_number'],
                    'status_id'          => 1,
                    'type_id'            => 1,
                    'suggestion_content' => $validated['description'],
                ]);
                $suggestion->save();

                // Сохранение фотографий, если они загружены
                if ($request->hasFile('photo_problem')) {
                    $path = $request->file('photo_problem')->store('public/images');
                    $imageBefore = new SuggestionImageBefore([
                        'file_path' => Storage::url($path),
                        'sugg_id'   => $suggestion->sugg_id
                    ]);
                    $imageBefore->save();
                }

                if ($request->hasFile('photo_solution')) {
                    $path = $request->file('photo_solution')->store('public/images');
                    $imageAfter = new SuggestionImageAfter([
                        'file_path' => Storage::url($path),
                        'sugg_id'   => $suggestion->sugg_id
                    ]);
                    $imageAfter->save();
                }

                // Если все в порядке, фиксируем транзакцию
                DB::commit();

                // Перенаправление с сообщением об успехе
                return redirect()->route('app');
            } catch (\Exception $e) {
                DB::rollback();
                return redirect()->route('app');
            }
        }

        public function filter(Request $request)
        {
            $query = Suggestion::query();

            $filter = $request->input('filter');
            $search = $request->input('search');


            if ($filter) {
                if($filter === 'date') {
                    $query->whereDate($filter, 'like', '%' . $search . '%');
                } else {
                    $query->where($filter, 'like', '%' . $search . '%');
                }
            }

            $suggestions = $query->get();

            return view('layouts.suggestions', compact('suggestions'), [
                'suggestions' => $suggestions,
            ]);
        }

        public function index(Request $request)
        {
            // Получение статуса из запроса, если он есть
            $statusId = $request->get('status');

            // Построение запроса с учетом фильтра, если он применяется
            $query = Suggestion::with('department', 'status');

            if ($statusId) {
                $query->where('status_id', $statusId);
            }

            $suggestions = $query->paginate(10); // Пагинация
            $statuses = Status::all(); // Получение всех отделов для фильтра

            return view('layouts.suggestions', compact('suggestions'), [
                'suggestions' => $suggestions,
                'statuses' => $statuses,
            ]);
        }
    }
