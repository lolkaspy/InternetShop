<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Contracts\Support\Renderable;

class CatalogController extends Controller
{
    public function __invoke(): Renderable
    {
        $categories = Category::all();

        return view('catalog', compact('categories'));
    }
}
