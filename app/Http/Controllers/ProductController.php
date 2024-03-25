<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use App\Models\Category;
use App\Models\Product;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class ProductController extends Controller
{
    public function index(Request $request)
    {
        $categories = Category::all();
        $productsQuery = Product::query();

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

        $minPriceQuery = clone $productsQuery;
        $maxPriceQuery = clone $productsQuery;

        $minPrice = $minPriceQuery->min('price');
        $maxPrice = $maxPriceQuery->max('price');

        $sortBy = $request->get('sort_by', 'id');
        $sortOrder = $request->get('sort_order', 'asc');

        $products = $productsQuery->orderBy($sortBy, $sortOrder)->paginate(50);

        return view('products/products', compact('products', 'categories', 'productsQuery', 'minPrice', 'maxPrice'));
    }

    public function show(Product $product)
    {
        return view('products/product', compact('product'));
    }

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
}
