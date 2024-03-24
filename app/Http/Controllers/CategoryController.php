<?php

namespace App\Http\Controllers;

use App\Models\Category;

use App\Models\Product;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    public function index($category, Request $request){
        $currentCategory = Category::where('slug',$category)->first();
        $productsQuery = Product::query()->where('category_id',$currentCategory->id);


        if($request->filled('name')){
            $productsQuery->where('name','like',"%{$request->name}%");
        }

        if($request->filled('low_price')){
            $productsQuery->where('price','>=',$request->low_price);
        }

        if($request->filled('high_price')){
            $productsQuery->where('price','<=',$request->high_price);
        }
        $minPriceQuery = clone $productsQuery;
        $maxPriceQuery = clone $productsQuery;

        $minPrice = $minPriceQuery->min('price');
        $maxPrice = $maxPriceQuery->max('price');

        $sortBy = $request->get('sort_by', 'id');
        $sortOrder = $request->get('sort_order', 'asc');

        $products = $productsQuery->orderBy($sortBy, $sortOrder)->paginate(50);

        return view('category', compact('products','currentCategory','minPrice','maxPrice'));
    }

//    public function create(){
//
//    }
//    public function update()
//    {
//        $category = Category::all()->find(3);
//        $category->update(['name'=>'Садовые инструменты']);
//    }
//    public function delete()
//    {
//        $category = Category::all()->find(3);
//        $category->delete();
//    }
//    public function restore(){
//        $category = Category::withTrashed()->find(3);
//        $category->restore();
//    }

    //firstOrCreate()
    //updateOrCreate()
}
