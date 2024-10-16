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
use App\Http\Controllers\CouponController;
use App\Http\Controllers\Frontend\HomeController as FrontendHomeController;
use App\Http\Controllers\Frontend\AccountController;
use App\Http\Controllers\Frontend\CartController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\VendorController;

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



// Main frontend Section

Route::get('/',[FrontendHomeController::class,'home'])->name('home');


Route::get('/categories/{category}/products', [FrontendHomeController::class, 'categoryProducts'])->name('category.products');

Route::get('/products/{product}', [FrontendHomeController::class, 'productDetails'])->name('products.details');


// End of Frontend section

Auth::routes();


// Admin Section
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

      // Coupon Section
      Route::resource('coupons',CouponController::class);
      Route::post('couponstatus',[CouponController::class,'changeStatus'])->name('coupons.status');
});


// Vendor Section
Route::group(['prefix'=>'vendor','middleware'=>['auth','vendor'],'as'=>'vendor.'],function(){

    Route::get('',[VendorController::class,'index'])->name('dashboard');

});


// User Section

Route::group(['prefix'=>'user','middleware'=>'auth','as'=>'user.'],function(){
    // Main Info Section
    Route::get('dashboard',[AccountController::class,'dashboard'])->name('dashboard');

    Route::get('orders',[AccountController::class,'ordersList'])->name('orders.show');

    Route::get('addresses',[AccountController::class,'getAddress'])->name('addresses.show');

    Route::post('billing-address/{user}/edit',[AccountController::class,'updateBillingAddress'])->name('billing-address.update');
    Route::post('shoppinng-address/{user}/edit',[AccountController::class,'updateShippingAddress'])->name('shipping-address.update');

    Route::get('account-details',[AccountController::class,'accountDetails'])->name('account.show');
    Route::put('account/{user}',[AccountController::class,'updateAccount'])->name('account.update');

    // Cart Section

    Route::resource('cart',CartController::class);
});

