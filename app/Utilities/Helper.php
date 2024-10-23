<?php

namespace App\Utilities;

use App\Models\Product;

class Helper {
    public static function userDefaultImage() {
        return asset('frontend/img/default-profile.png');
    }

    public static function minPrice(){
        return floor(Product::min('offer_price'));
    }

    public static function maxPrice(){
        return floor(Product::max('offer_price'));
    }
}
