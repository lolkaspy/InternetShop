<?php

use App\Http\Controllers\CatalogController;
use App\Http\Controllers\CategoryController;
use Illuminate\Support\Facades\Route;


//Catalog
Route::get('/catalog', CatalogController::class)->name('catalog');

//Category
Route::get('category/{category:slug}', [CategoryController::class, 'index'])->name('category.index');

