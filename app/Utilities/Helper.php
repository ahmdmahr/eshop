<?php

namespace App\Utilities;

use App\Models\Currency;
use App\Models\Product;


class Helper {
    public static $previous_exchange_rate = 1; 
    public static function userDefaultImage() {
        return asset('frontend/img/default-profile.png');
    }

    public static function minPrice(){
        return floor(Product::min('offer_price'));
    }

    public static function maxPrice(){
        return floor(Product::max('offer_price'));
    }

    public static function currency_load(){
        if (!session()->has('system_default_currency_info')) {
            $defaultCurrency = Currency::first();
            
            if($defaultCurrency) {
                session()->put('system_default_currency_info', $defaultCurrency);
            }
        }
    }

    public static function currency_conventer($price){
        self::currency_load();
        $defaultCurrency = session('system_default_currency_info');

        $price = $price/self::$previous_exchange_rate;

        if(session()->has('currency_data') && $defaultCurrency->id != session('currency_data')->id){
            $defaultCurrency = session('currency_data');
            self::$previous_exchange_rate = session('system_default_currency_info')->exchange_rate;
            session(['system_default_currency_info' => $defaultCurrency]);
        }
        $price*=$defaultCurrency->exchange_rate;
        return $price;
    }

    
  
}
