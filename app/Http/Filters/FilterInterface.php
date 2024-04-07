<?php

namespace App\Http\Filters;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Database\Eloquent\Builder;
interface FilterInterface
{
    public function applyFilters(Builder $query, FormRequest $request): Builder;
}
