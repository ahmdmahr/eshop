<?php
namespace App;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\CouponController;
use App\Http\Controllers\Admin\CurrencyController;
use App\Http\Controllers\Frontend\HomeController;
use App\Http\Controllers\Frontend\AccountController;
use App\Http\Controllers\Frontend\CartController;
use App\Http\Controllers\Frontend\CheckoutController;
use App\Http\Controllers\Frontend\WishlistController;
use App\Http\Controllers\Admin\PaypalController;
use App\Http\Controllers\Admin\ReviewController;

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


Auth::routes();

Route::post('currency_load',[CurrencyController::class,'currencyLoad'])->name('currencies.load');

// Home page Section
Route::get('/',[HomeController::class,'home'])->name('home');

Route::get('about-us',[HomeController::class,'aboutUs'])->name('about.us');

Route::get('contact-us',[HomeController::class,'contactUs'])->name('contact.us');
Route::post('contact-submit',[HomeController::class,'contactUsSubmit'])->name('contact.us.submit');

Route::get('/categories/{category}/products', [HomeController::class, 'categoryProducts'])->name('category.products');

Route::get('/products/{product}', [HomeController::class, 'productDetails'])->name('products.details');

Route::get('shop',[HomeController::class,'shop'])->name('shop.index');
Route::post('shop-filter',[HomeController::class,'shopFilter'])->name('shop.filter');

Route::get('auto-search',[HomeController::class,'autoSearch'])->name('products.autosearch');
Route::get('search',[HomeController::class,'searchProducts'])->name('products.search');


Route::group(['prefix'=>'user','middleware'=>'auth','as'=>'user.'],function(){
    // User Info Section
    Route::get('dashboard',[AccountController::class,'dashboard'])->name('dashboard');

    Route::get('orders',[AccountController::class,'ordersList'])->name('orders.show');

    Route::get('addresses',[AccountController::class,'getAddress'])->name('addresses.show');

    Route::put('billing-address/{user}',[AccountController::class,'updateBillingAddress'])->name('billing-address.update');
    Route::put('shoppinng-address/{user}',[AccountController::class,'updateShippingAddress'])->name('shipping-address.update');

    Route::get('account-details',[AccountController::class,'accountDetails'])->name('account.show');
    Route::put('account/{user}',[AccountController::class,'updateAccount'])->name('account.update');

    // Cart Section
    Route::resource('cart',CartController::class);

    // Coupon Section
    Route::post('coupons/apply',[CouponController::class,'apply'])->name('coupons.apply');

    // Wishlist Section

    Route::resource('wishlist',WishlistController::class);
    Route::post('wishlist/move-to-cart',[WishlistController::class,'moveToCart'])->name('wishlist.move');

    // Checkout Section
    Route::get('checkout1',[CheckoutController::class,'checkout1'])->name('checkout1');
    Route::post('checkout1',[CheckoutController::class,'checkout1Store'])->name('checkout1.store');

    Route::get('checkout2',[CheckoutController::class,'checkout2'])->name('checkout2');
    Route::post('checkout2',[CheckoutController::class,'checkout2Store'])->name('checkout2.store');

    Route::get('checkout3',[CheckoutController::class,'checkout3'])->name('checkout3');
    Route::post('checkout3',[CheckoutController::class,'checkout3Store'])->name('checkout3.store');

    Route::post('checkout',[CheckoutController::class,'checkoutStore'])->name('checkout.store');

    Route::get('complete-checkout/{order}',[CheckoutController::class,'complete'])->name('checkout.complete');

    // Paypal payment Section
    Route::get('paypal/success', [PaypalController::class, 'getSuccess'])->name('paypal.success');
    Route::get('paypal/cancel', [PaypalController::class, 'getCancel'])->name('paypal.cancel');

    // Review Section
    Route::post('products/{product}/review',[ReviewController::class,'store'])->name('products.review');

});