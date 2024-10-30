<?php
namespace App;

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Vendor\VendorController;
use App\Http\Controllers\Vendor\ProductController;




Route::group(['prefix'=>'vendor','middleware'=>['auth','vendor'],'as'=>'vendor.'],function(){
    Route::get('',[VendorController::class,'index'])->name('dashboard');
    
    // Product Section
    Route::resource('products',ProductController::class);
    Route::post('productstatus',[ProductController::class,'changeStatus'])->name('products.status');

});
