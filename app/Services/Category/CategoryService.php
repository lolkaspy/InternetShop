<?php

namespace App\Services\Category;

use App\Http\Filters\FilterInterface;
use App\Http\Requests\CategoryRequest;
use App\Models\Category;
use App\Models\Order;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Request;

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

    public function getCategoryData(Builder $productsQuery, CategoryRequest $request): array
    {
        $minPriceQuery = clone $productsQuery;
        $maxPriceQuery = clone $productsQuery;

        $minPrice = round($minPriceQuery->min('price'));
        $maxPrice = round($maxPriceQuery->max('price'));

        $sortBy = $request->get('sort_by', 'id');
        $sortOrder = $request->get('sort_order', 'asc');

        $products = $productsQuery->orderBy($sortBy, $sortOrder)->paginate(50);

        return compact('products', 'minPrice', 'maxPrice');
    }


}
