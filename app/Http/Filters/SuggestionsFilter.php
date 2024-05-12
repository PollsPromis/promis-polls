<?php

namespace App\Http\Filters;

class SuggestionsFilter
{
    private static array $filters = [
        'id' => 'Номер предложения',
        'date' => 'Дата создания',
        'author' => 'Автор',
        'collaborator' => 'Соавтор',
        'department' => 'Отдел',
        'status' => 'Статус предложения',
    ];

    public static function getForeignIdByQuery($query, $search)
    {
        $status = $query
            ->where('title', 'ilike', '%' . $search . '%')
            ->get();

        return $status->map(function ($item) {
            return $item->id;
        });
    }

    /**
     * @return array
     */
    public static function getFilters(): array
    {
        return self::$filters;
    }
}
