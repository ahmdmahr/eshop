<?php
namespace App;

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Vendor\VendorController;



Route::group(['prefix'=>'vendor','middleware'=>['auth','vendor'],'as'=>'vendor.'],function(){

    Route::get('',[VendorController::class,'index'])->name('dashboard');

});
