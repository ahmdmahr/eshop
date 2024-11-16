<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\ProductController;
use App\Http\Controllers\Api\CategoryController;
use App\Http\Controllers\Api\BrandController;
use App\Http\Controllers\Api\BannerController;
use App\Http\Controllers\Api\AboutUsController;
use App\Http\Controllers\Api\OrderController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});


Route::resource('products', ProductController::class)->except(['create','edit']);


Route::resource('categories', CategoryController::class)->except(['create','edit']);

Route::resource('brands', BrandController::class)->except(['create','edit']);

Route::resource('banners', BannerController::class)->except(['create','edit']);

Route::resource('about-us', AboutUsController::class)->except(['create','edit']);

Route::resource('orders', OrderController::class)->except(['create','edit']);
