<?php

use Illuminate\Support\Facades\Route;


//Catalog
Route::get('/catalog', [\App\Http\Controllers\CatalogController::class,'index'])->name('catalog.index');

//Category
Route::get('category/{category:slug}', [\App\Http\Controllers\CategoryController::class,'index'])->name('category.index');

