<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;

Route::get('/',[\App\Http\Controllers\MainController::class,'index'])->name('main.index');
Route::get('/profile', [\App\Http\Controllers\ProfileController::class,'index'])->name('profile.index');
Route::get('/success', [App\Http\Controllers\SuccessController::class, 'index'])->name('success');
Route::get('/cart', [App\Http\Controllers\CartController::class, 'index'])->name('cart.index')->middleware('user');;
Auth::routes();


