<?php

namespace App\Http\Controllers;

use App\Models\Category;

use App\Models\Product;
use App\Services\Category\CategoryService;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    private $categoryService;
    public function __construct(CategoryService $categoryService)
    {
        $this->categoryService = $categoryService;
    }
    public function index(Request $request, $category)
    {
        $currentCategory = Category::where('slug', $category)->first();
        $productsQuery = Product::query()->where('category_id', $currentCategory->id);

        $this->categoryService->applyFilters($productsQuery,$request);
        return view('category', compact( 'currentCategory'),
            $this->categoryService->getCategoryData($productsQuery,$request));
    }

}
