<?php

namespace App\Http\Controllers;

use App\Http\Filters\SuggestionsFilter;
use App\Models\Department;
use App\Models\Status;
use App\Models\Suggestion;
use App\Models\SuggestionImageProblem;
use App\Models\SuggestionImageSolution;
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
                'images_problem'  => 'nullable|array',
                'images_solution' => 'nullable|array',
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
            if(isset($validated['images_problem'])){
                foreach ($validated['images_problem'] as $problemImage) {
                    $filePath = Storage::disk('public')->put('/images', $problemImage);
                    $imageProblem = new SuggestionImageProblem([
                        'file_path' => $filePath,
                        'sugg_id'   => $suggestion->id
                    ]);
                    $imageProblem->save();
                }
            }

            if(isset($validated['images_solution'])){
                foreach ($validated['images_solution'] as $solutionImage) {
                    $filePath = Storage::disk('public')->put('/images', $solutionImage);
                    $imageSolution = new SuggestionImageSolution([
                        'file_path' => $filePath,
                        'sugg_id'   => $suggestion->id
                    ]);
                    $imageSolution->save();
                }

            }

            // Если все в порядке, фиксируем транзакцию
            DB::commit();

            // Перенаправление с сообщением об успехе
            return redirect()->route('app');
        } catch (\Exception $e) {
            DB::rollback();
            dd($e->getMessage());
            //return redirect()->route('app');
        }
    }

    public function filter(Request $request)
    {
        $filters = SuggestionsFilter::getFilters();

        $query = Suggestion::query();
        $queryStatuses = Status::query();
        $queryDepartments = Department::query();

        $field = $request->input('field');
        $search = $request->input('search');

        if (isset($field) && isset($search)) {
            if($field === 'status') {
                $foreignId = SuggestionsFilter::getForeignIdByQuery($queryStatuses, $search);
                $query->whereIn('status_id', $foreignId);
            }
            else if($field === 'department') {
                $foreignId = SuggestionsFilter::getForeignIdByQuery($queryDepartments, $search);
                $query->whereIn('depart_id', $foreignId);
            }
            else {
                $query->where($field, 'ilike', '%' . $search . '%');
            }

            $suggestions = $query->paginate(10);
        } else {
            //ошибка
            $suggestions = [];
        }

        return view('layouts.suggestions', compact('suggestions', 'filters'));
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
        $statuses = Status::all();
        $filters = SuggestionsFilter::getFilters();

        return view('layouts.suggestions', compact('suggestions', 'filters',  'statuses'));
    }
}
