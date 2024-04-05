<?php

namespace App\Services\Category;

use App\Models\Order;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;

class CategoryService
{
    public function applyFilters(Builder $productsQuery, Request $request)
    {
        if ($request->filled('name')) {
            $productsQuery->where('name', 'like', "%{$request->name}%");
        }

        if ($request->filled('low_price')) {
            $productsQuery->where('price', '>=', $request->low_price);
        }

        if ($request->filled('high_price')) {
            $productsQuery->where('price', '<=', $request->high_price);
        }

        return $productsQuery;
    }

    public function getCategoryData(Builder $productsQuery, Request $request)
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
