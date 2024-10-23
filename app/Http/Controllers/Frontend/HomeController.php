<?php

namespace App\Http\Controllers\Frontend;

use App\Models\Banner;
use App\Models\Product;
use App\Models\Category;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Gloudemans\Shoppingcart\Facades\Cart;

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

        $products = $products->paginate(8);


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

    public function shop(Request $request){
        $products = Product::query();
        
        if(!empty($_GET['category'])){
            $slugs = explode(',',$_GET['category']);
            $categories_ids =  Category::select('id')->whereIn('slug',$slugs)->pluck('id')->toArray();
            $products = $products->whereIn('category_id',$categories_ids);
            // return $products;
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
        return view('frontend.pages.products.shop',compact('products','categories'));
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

        //  dd($priceRangeUrl);

        return redirect()->route('shop.index',$sortByUrl.$categoryUrl.$priceRangeUrl);
    }
}
