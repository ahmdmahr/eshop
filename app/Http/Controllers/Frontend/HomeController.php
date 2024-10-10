<?php

namespace App\Http\Controllers\Frontend;

use App\Models\Banner;
use App\Models\Product;
use App\Models\Category;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class HomeController extends Controller
{
    public function home(){
        $banners = Banner::where(['status'=>'active','condition'=>'banner'])->orderBy('id','DESC')->limit(4)->get();
        $categories = Category::where(['status'=>'active','is_parent'=>1])->orderBy('id','DESC')->limit(3)->get();
        $new_products = Product::where(['status'=>'active','condition'=>'new'])->orderBy('id','DESC')->limit(10)->get();
        return view('frontend.index',compact(['banners','categories','new_products']));
    }

    public function categoryProducts($slug){
        // Category::with('products') this would retrieve all categories along with their associated products in a single query using relationship in category model
        $category = Category::with('products')->where('slug',$slug)->first();
        return view('frontend.pages.products.category-products',compact(['category']));
    }

    public function productDetails($slug){
        $product = Product::where('slug',$slug)->first();
        if($product){
            return view('frontend.pages.products.product-details',compact(['product']));
        }
        else{
            return 'Product not found';
        }
    }
}
