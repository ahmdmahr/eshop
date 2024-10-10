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
        // dd($new_products);
        return view('frontend.index',compact(['banners','categories','new_products']));
    }

    public function categoryProducts($slug){
        // Product::with('images') this would retrieve all images along with their associated products in a single query using relationship in product model
        $category= Category::where('slug',$slug)->first();
        $products = Product::with('images')->where('category_id',$category->id)->get();
        return view('frontend.pages.products.category-products',compact(['category','products']));
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
