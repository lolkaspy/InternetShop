<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;

class CatalogController extends Controller
{
    public function __invoke()
    {
        $categories = Category::all();
        return view('catalog', compact('categories'));
    }
}
