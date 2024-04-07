<?php

namespace App\Http\Filters;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Foundation\Http\FormRequest;

interface FilterInterface
{
    public function applyFilters(Builder $query, FormRequest $request): Builder;
}
