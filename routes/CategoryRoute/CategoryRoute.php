<?php

use App\Http\Controllers\CatalogController;
use App\Http\Controllers\CategoryController;
use Illuminate\Support\Facades\Route;


//Catalog
Route::get('/catalog', [CatalogController::class, 'index'])->name('catalog.index');

//Category
Route::get('category/{category:slug}', [CategoryController::class, 'index'])->name('category.index');

