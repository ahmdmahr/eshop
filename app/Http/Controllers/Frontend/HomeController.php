<?php

namespace App\Http\Controllers\Frontend;

use App\Models\Banner;
use App\Models\Category;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class HomeController extends Controller
{
    public function home(){
        $banners = Banner::where(['status'=>'active','condition'=>'banner'])->orderBy('id','DESC')->limit(4)->get();
        $categories = Category::where(['status'=>'active','is_parent'=>1])->orderBy('id','DESC')->limit(3)->get();
        return view('frontend.index',compact('banners','categories'));
    }

    public function categoryproducts($slug){
        // Category::with('products') this would retrieve all categories along with their associated products in a single query using relationship in category model
        $category = Category::with('products')->where('slug',$slug)->first();
        return view('frontend.pages.category-products',compact(['category']));
    }
}
