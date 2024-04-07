<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProductRequest;
use App\Models\Category;
use App\Models\Product;
use App\Services\Product\ProductService;
use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\RedirectResponse;

class ProductController extends Controller
{
    private $productService;

    public function __construct(ProductService $productService)
    {
        $this->productService = $productService;
    }

    public function index(ProductRequest $request): Renderable
    {
        $categories = Category::all();
        $productsQuery = Product::query();

        $this->productService->applyFilters($productsQuery, $request);

        return view('products/products', compact('categories'),
            $this->productService->getProductsData($productsQuery, $request));
    }

    public function show(Product $product): Renderable
    {
        return view('products/product', compact('product'));
    }

    public function addToCart(ProductRequest $request): RedirectResponse
    {
        return $this->productService->addToCart($request);
    }
}
