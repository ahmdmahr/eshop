<?php
namespace App;

use App\Http\Controllers\AdminController;
use App\Http\Controllers\BannerController;
use App\Http\Controllers\BrandController;
use App\Http\Controllers\CategoryController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use Illuminate\Support\Facades\Bus;

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

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

Route::get('/home', [HomeController::class, 'index'])->name('home');

// Admin Dashboard
Route::group(['prefix'=>'admin','middleware'=>['auth','admin'],'as'=>'admin.'],function(){

    Route::get('',[AdminController::class,'index'])->name('dashboard');


    // Banner Section
    Route::resource('banners',BannerController::class);
    Route::post('bannerstatus',[BannerController::class,'changeStatus'])->name('banners.status');

    // Category Section
    Route::resource('categories',CategoryController::class);
    Route::post('categorystatus',[CategoryController::class,'changeStatus'])->name('categories.status');

    // Brand Section
    Route::resource('brands',BrandController::class);
    Route::post('brandstatus',[BrandController::class,'changeStatus'])->name('brands.status');
});
