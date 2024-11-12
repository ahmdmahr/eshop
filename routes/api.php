<?php


use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\ProductController;
use App\Http\Controllers\Api\CategoryController;
use App\Http\Controllers\Api\BrandController;
use App\Http\Controllers\Api\BannerController;
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


Route::resource('products', ProductController::class)->only([
    'index', 'store', 'show', 'update', 'destroy'
]);


Route::resource('categories', CategoryController::class)->only([
    'index', 'store', 'show', 'update', 'destroy'
]);

Route::resource('brands', BrandController::class)->only([
    'index', 'store', 'show', 'update', 'destroy'
]);

Route::resource('banners', BannerController::class)->only([
    'index', 'store', 'show', 'update', 'destroy'
]);

