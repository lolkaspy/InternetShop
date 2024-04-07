<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

//роуты для категорий
include 'CategoryRoute/CategoryRoute.php';
//роуты для товаров
include 'ProductRoute/ProductRoute.php';
//роуты для заказов
include 'OrderRoute/OrderRoute.php';
//мейн роуты для магазина в целом
include 'ShopRoute/ShopRoute.php';
