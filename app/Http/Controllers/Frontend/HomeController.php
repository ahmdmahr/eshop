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

    public function categoryProducts(Request $request,$slug){
        // Product::with('images') this would retrieve all images along with their associated products in a single query using relationship in product model        

        $category= Category::where('slug',$slug)->first();

        $sort = '';


        // dd($request->sortBy);
        
        if($request->sortBy!=null){
            $sort = $request->sortBy;
        }
        
        // dd($request->sortBy);

        if($category == null){
            return view('errors.404');
        }
        else{
            $products = Product::with('images')->where('category_id',$category->id);
            if($sort == 'priceAsc'){
                $products->orderBy('offer_price','ASC');
            }
            elseif($sort == 'priceDesc'){
                $products->orderBy('offer_price','DESC');
            }
            elseif($sort == 'discAsc'){
                $products->select('products.*') // Add other columns you need
                ->selectRaw('price - offer_price AS price_difference')
                ->orderBy('price_difference', 'ASC');
            }
            elseif($sort == 'discDesc'){
                $products->select('products.*') 
                ->selectRaw('price - offer_price AS price_difference')
                ->orderBy('price_difference', 'DESC');
            }
            elseif($sort == 'titleAsc'){
                $products->orderBy('title','ASC');
            }
            elseif($sort == 'titleDesc'){
                $products->orderBy('title','DESC');
            }
        }

        $products = $products->paginate(4);


        if($request->ajax()){
            $view = view('frontend.pages.products.products-list',compact('products'))->render();
            return response()->json(['html'=>$view]);
        }

        return view('frontend.pages.products.category-products',compact(['category','products']));
    }

    public function productDetails($slug){
        $product = Product::with('related_products')->where('slug',$slug)->first();
        if($product){
            return view('frontend.pages.products.product-details',compact(['product']));
        }
        else{
            return 'Product not found';
        }
    }
}
