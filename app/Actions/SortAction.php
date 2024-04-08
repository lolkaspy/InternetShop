<?php

namespace App\Actions;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Foundation\Http\FormRequest;

class SortAction
{
    public static function sort(Builder $query, FormRequest $request, ?string $column = null): Builder
    {
        if (! isset($column)) {
            $sortBy = $request->get('sort_by', 'id');
        } else {
            $sortBy = $request->get('sort_by', $column);
        }

        $sortOrder = $request->get('sort_order', 'asc');

        //->paginate(50)
        return $query->orderBy($sortBy, $sortOrder);
    }
}
