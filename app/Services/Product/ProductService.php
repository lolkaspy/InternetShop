<?php

namespace App\Services\Product;

use App\Models\Cart;
use App\Models\Product;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ProductService
{
    public function addToCart(Request $request)
    {
        $productId = $request->get('product_id');
        $product = Product::find($productId);

        $cart = Cart::where('product_id', $productId)->where('user_id', Auth::id())->first();

        if ($cart) {
            if ($cart->quantity < $product->available_quantity) {
                $cart->quantity += 1;
                $cart->save();
            } else {

                return redirect()->back()->with('error', 'Вы не можете добавить больше этого товара в корзину');
            }
        } else {
            if ($product->available_quantity > 0) {
                Cart::create([
                    'product_id' => $productId,
                    'user_id' => Auth::id(),
                    'quantity' => 1,
                ]);
            } else {
                return redirect()->back()->with('error', 'Этот товар в настоящее время недоступен');
            }
        }

        return redirect()->back()->with('success', 'Товар успешно добавлен в корзину');
    }

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

        if ($request->filled('category')) {
            $productsQuery->whereHas('category', function (Builder $query) use ($request) {
                $query->where('slug', '=', $request->category);
            });
        }

        return $productsQuery;
    }

    public function getProductsData(Builder $productsQuery, Request $request)
    {
        $minPriceQuery = clone $productsQuery;
        $maxPriceQuery = clone $productsQuery;

        $minPrice = round($minPriceQuery->min('price'));
        $maxPrice = round($maxPriceQuery->max('price'));

        $sortBy = $request->get('sort_by', 'id');
        $sortOrder = $request->get('sort_order', 'asc');

        $products = $productsQuery->orderBy($sortBy, $sortOrder)->paginate(50);

        return compact('products', 'productsQuery', 'minPrice', 'maxPrice');
    }

}
