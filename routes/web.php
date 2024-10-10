<?php
namespace App;

use Illuminate\Support\Facades\Bus;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\BrandController;
use App\Http\Controllers\BannerController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\Frontend\HomeController as FrontendHomeController;
use App\Http\Controllers\UserController;

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



// Frontend section

Route::get('/',[FrontendHomeController::class,'home'])->name('home');

// category products

Route::get('/categories/{category}/products', [FrontendHomeController::class, 'categoryProducts'])->name('category.products');

Route::get('/products/{product}', [FrontendHomeController::class, 'productDetails'])->name('products.details');


// End of Frontend section

Auth::routes();


// Admin Dashboard
Route::group(['prefix'=>'admin','middleware'=>['auth','admin'],'as'=>'admin.'],function(){

    Route::get('',[AdminController::class,'index'])->name('dashboard');


    // Banner Section
    Route::resource('banners',BannerController::class);
    Route::post('bannerstatus',[BannerController::class,'changeStatus'])->name('banners.status');

    // Category Section
    Route::resource('categories',CategoryController::class);
    Route::post('categorystatus',[CategoryController::class,'changeStatus'])->name('categories.status');
    Route::get('categories/{id}/child',[CategoryController::class,'getChildByParentID'])->name('categories.getchild');

    // Brand Section
    Route::resource('brands',BrandController::class);
    Route::post('brandstatus',[BrandController::class,'changeStatus'])->name('brands.status');

    // Product Section
    Route::resource('products',ProductController::class);
    Route::post('productstatus',[ProductController::class,'changeStatus'])->name('products.status');

     // User Section
     Route::resource('users',UserController::class);
     Route::post('userstatus',[UserController::class,'changeStatus'])->name('users.status');
});
