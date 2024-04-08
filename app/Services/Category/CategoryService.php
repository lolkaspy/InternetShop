<?php

namespace App\Services\Category;

use App\Actions\PriceLimiterAction;
use App\Actions\SortAction;
use App\Http\Filters\FilterInterface;
use App\Http\Requests\CategoryRequest;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Foundation\Http\FormRequest;

class CategoryService implements FilterInterface
{
    public function applyFilters(Builder $query, FormRequest $request): Builder
    {
        if ($request->filled('name')) {
            $query->where('name', 'like', "%{$request->name}%");
        }

        if ($request->filled('low_price')) {
            $query->where('price', '>=', $request->low_price);
        }

        if ($request->filled('high_price')) {
            $query->where('price', '<=', $request->high_price);
        }

        return $query;
    }

    public function getCategoryData(Builder $categoriesQuery, CategoryRequest $request): array
    {
        $minLimit = PriceLimiterAction::getMinLimit($categoriesQuery, 'price');
        $maxLimit = PriceLimiterAction::getMaxLimit($categoriesQuery, 'price');

        $products = SortAction::sort($categoriesQuery, $request)->paginate(50);

        return compact('products', 'minLimit', 'maxLimit');
    }
}
