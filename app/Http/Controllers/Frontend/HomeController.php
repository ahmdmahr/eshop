<?php

namespace App\Http\Controllers\Frontend;

use App\Models\Brand;
use App\Models\Banner;
use App\Models\Review;
use App\Models\AboutUs;
use App\Models\Product;
use App\Models\Category;
use App\Models\OrderItem;
use Illuminate\Http\Request;
use App\Models\ProductAttribute;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Gloudemans\Shoppingcart\Facades\Cart;

class HomeController extends Controller
{
    public function home(){
        $banners = Banner::where(['status'=>'active','condition'=>'banner'])->orderBy('id','DESC')->limit(4)->get();
        $promo_banner = Banner::where(['status'=>'active','condition'=>'promotion'])->orderBy('id','DESC')->first();
        $categories = Category::where(['status'=>'active','is_parent'=>1])->orderBy('id','DESC')->limit(3)->get();
        $new_products = Product::where(['status'=>'active','condition'=>'new'])->orderBy('id','DESC')->limit(12)->get();
        $featured_products = Product::where(['status'=>'active','condition'=>'popular'])->orderBy('id','DESC')->limit(6)->get();
        $brands = Brand::where('status','active')->orderBy('id','DESC')->get();

        // Best selling products

        // this DB raw will take each product_id and find all occurence sum all quantities all in one.
        $best_sellingIds = OrderItem::select('product_id', DB::raw('SUM(quantity) as total_count'))->groupBy('product_id')
                      ->orderBy('total_count', 'desc')
                      ->get();
        // return $best_sellingIds;
        $product_ids = [];
        foreach($best_sellingIds as $item){
           array_push($product_ids,$item['product_id']);
        }
        $best_sellings = Product::whereIn('id',$product_ids)->limit(6)->get();

        //Best rated products
        $best_ratedIds = Review::select('product_id', DB::raw('SUM(stars) as total_count'))->groupBy('product_id')
        ->orderBy('total_count', 'desc')
        ->get();
        // return $best_ratedIds;
        $product_ids = [];
        foreach($best_ratedIds as $item){
           array_push($product_ids,$item['product_id']);
        }
        $best_rated = Product::whereIn('id',$product_ids)->limit(6)->get();

        return view('frontend.index',compact(['banners','categories','new_products','featured_products','promo_banner','brands','best_sellings','best_rated']));
    }

    public function aboutUs(){
        $about_us = AboutUs::first();
        $brands = Brand::where('status','active')->orderBy('id','DESC')->get();
        return view('frontend.pages.about-us',compact('about_us','brands'));
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

        $products = $products->paginate(8);


        if($request->ajax()){
            $view = view('frontend.pages.products.products-list',compact('products'))->render();
            return response()->json(['html'=>$view]);
        }

        
        return view('frontend.pages.products.category-products',compact(['category','products']));
    }

    public function productDetails(Request $request,$slug){
        // return $request->all();
        $product = Product::with('related_products')->where('slug',$slug)->first();
        $size = $request->input('size')??null;
        $attribute = null;
        if($size)
          $attribute = ProductAttribute::where(['product_id'=>$product->id,'size'=>$size])->first();
        if($product){
            return view('frontend.pages.products.product-details',compact(['product','size','attribute']));
        }
        else{
            return 'Product not found';
        }
    }

    public function shop(Request $request){
        $products = Product::query();
        
        if(!empty($_GET['category'])){
            $slugs = explode(',',$_GET['category']);
            $categories =  Category::select('id')->whereIn('slug',$slugs)->pluck('id')->toArray();
            $products = $products->whereIn('category_id',$categories);
        }

        if(!empty($_GET['brand'])){
            $slugs = explode(',',$_GET['brand']);
            $brands =  Brand::select('id')->whereIn('slug',$slugs)->pluck('id')->toArray();
            $products = $products->whereIn('brand_id',$brands);
        }

        $size = $_GET['size']??null;
        if(!empty($size)){
            $products = $products->where('size',$size);
        }

        $sortBy = $_GET['sortBy'] ?? null;
        if(!empty($sortBy)){
            if($sortBy == 'priceAsc'){
                $products = $products->orderBy('offer_price','ASC');
            }
            elseif($sortBy == 'priceDesc'){
                $products = $products->orderBy('offer_price','DESC');
            }
            elseif($sortBy == 'discAsc'){
                $products = $products->select('products.*') // Add other columns you need
                ->selectRaw('price - offer_price AS price_difference')
                ->orderBy('price_difference', 'ASC');
            }
            elseif($sortBy == 'discDesc'){
                $products = $products->select('products.*') 
                ->selectRaw('price - offer_price AS price_difference')
                ->orderBy('price_difference', 'DESC');
            }
            elseif($sortBy == 'titleAsc'){
                $products = $products->orderBy('title','ASC');
            }
            elseif($sortBy == 'titleDesc'){
                $products = $products->orderBy('title','DESC');
            }
        }

        if(!empty($_GET['price'])){
            // price = [min,max]
            $price = explode('-',$_GET['price']);
            $products = $products->whereBetween('offer_price',$price);
        }

        $products = $products->paginate(9);

        $categories = Category::where(['status' => 'active','is_parent' => 1])->orderBy('title','ASC')->get();
        $brands = Brand::where('status','active')->orderBy('title','ASC')->get();
        return view('frontend.pages.products.shop',compact('products','categories','brands'));
    }

    public function shopFilter(Request $request){

        // return dd($request->all());

        $data = $request->all();

        // Category Filter
        $categoryUrl = '';

        if(!empty($data['category'])){
            foreach($data['category'] as $category){
                if(empty($categoryUrl)){
                    $categoryUrl .= '&category=' . $category;
                }
                else{
                    $categoryUrl .= ',' . $category;
                }
            }
        }   

        // Sort Filter 
        $sortByUrl = '';
        if(!empty($data['sortBy'])){
           $sortByUrl .= '&sortBy=' . $data['sortBy'];
        }

         // Price Filter 
         $priceRangeUrl = '';
         if(!empty($data['min_price']) && !empty($data['max_price'])){
            $price_range = $data['min_price'].'-'.$data['max_price'];
            $priceRangeUrl .= '&price=' . $price_range;
            // dd($priceRangeUrl);
         }

        // Brand Filter 
        $brandUrl = '';
        if(!empty($data['brand'])){
            foreach($data['brand'] as $brand){
                if(empty($brandUrl)){
                    $brandUrl .= '&brand=' . $brand;
                }
                else{
                    $brandUrl .= ',' . $brand;
                }
            }
        }

        // Size Filter 
        $sizeUrl = '';
        if(!empty($data['size'])){
            $sizeUrl .= '&size=' . $data['size'];
        }

        return redirect()->route('shop.index',$sortByUrl.$categoryUrl.$brandUrl.$priceRangeUrl.$sizeUrl);
    }

    public function autoSearch(Request $request){
        // '' for put it as default is not defined.
        $query = $request->get('term','');
        $products = Product::where('title','LIKE','%'.$query.'%')->get();
        $data = [];
        $i = 0;
        foreach($products as $product){
            $data[$i++] = ['id'=>$product->id,'value'=>$product->title];
        }
        if(count($data)>0){
            return $data;
        }
        else{
            return ['id'=>'','value'=>"No Result Found!"];
        }
    }

    public function searchProducts(Request $request){
        $query = $request->input('query');
        $products = Product::where('title','LIKE','%'.$query.'%')->orderBy('id','DESC')->paginate(9);
        $categories = Category::where(['status' => 'active','is_parent' => 1])->orderBy('title','ASC')->get();
        $brands = Brand::where('status','active')->orderBy('title','ASC')->get();
        return view('frontend.pages.products.shop',compact('products','categories','brands'));
    }
}
