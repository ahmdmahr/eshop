<?php
namespace App;

use App\Http\Controllers\AboutUsController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\BrandController;
use App\Http\Controllers\BannerController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\CouponController;
use App\Http\Controllers\CurrencyController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\SettingsController;
use App\Http\Controllers\ShippingController;
use App\Http\Controllers\UserController;

Route::group(['prefix'=>'admin','middleware'=>['auth','admin'],'as'=>'admin.'],function(){

// Admin dashboard Section
Route::get('',[AdminController::class,'index'])->name('dashboard');

// About us Section
Route::get('about-us',[AboutUsController::class,'aboutUs'])->name('about.us');
Route::put('about-us',[AboutUsController::class,'update'])->name('about.us.update');

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

// Product attribute Section
Route::post('products/{product}/attributes',[ProductController::class,'addAttributes'])->name('products.attributes.add');
Route::delete('products/{product}/attributes/{attribute}', [ProductController::class, 'deleteAttribute'])->name('products.attributes.delete');

 // User Section
 Route::resource('users',UserController::class);
 Route::post('userstatus',[UserController::class,'changeStatus'])->name('users.status');
 Route::post('changeverification',[UserController::class,'changeVerification'])->name('users.verification');

 

  // Coupon Section
  Route::resource('coupons',CouponController::class);
  Route::post('couponstatus',[CouponController::class,'changeStatus'])->name('coupons.status');

  // Shipping Section
  Route::resource('shippings',ShippingController::class);
  Route::post('shippingstatus',[ShippingController::class,'changeStatus'])->name('shippings.status');

  // Currency Section
  Route::resource('currencies',CurrencyController::class);
  Route::post('currenciestatus',[CurrencyController::class,'changeStatus'])->name('currencies.status');

  // Order Section
  Route::resource('orders',OrderController::class);
  Route::post('ordercondition',[OrderController::class,'changeCondition'])->name('orders.condition');

  // Settings Section
  Route::get('settings',[SettingsController::class,'settings'])->name('settings');
  Route::put('settings',[SettingsController::class,'updateSettings'])->name('settings.update');

   // SMTP Section
   Route::get('smtp',[SettingsController::class,'smtp'])->name('smtp');
   Route::put('smtp',[SettingsController::class,'updateSmtp'])->name('smtp.update');
});