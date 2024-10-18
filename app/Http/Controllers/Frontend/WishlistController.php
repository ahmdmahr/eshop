<?php

namespace App\Http\Controllers\Frontend;

use App\Models\Product;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Gloudemans\Shoppingcart\Facades\Cart;
use App\Http\Requests\StoreWishlistRequest;

class WishlistController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('frontend.pages.wishlist.index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreWishlistRequest $request)
    {
        $data = $request->validated();
        $product = Product::where('id',$data['product_id'])->first();
        // dd($product);
        $product_qty = $data['product_qty'];
        $price = $product->offer_price;
        $itemExists = false;
        foreach(Cart::instance('wishlist')->content() as $item){
            if ($item->id == $product->id) {
                $itemExists = true;
                break; 
            }
        }
        if($itemExists){
            $response['exists'] = true;
            $response['message'] = "Item is already in your wishlist";
        }
        else{
            $added = Cart::instance('wishlist')->add($product->id,$product->title,$product_qty,$price)->associate(Product::class);
            if($added){
                $response['status'] = true;
                $response['message'] = "Item has been saved in your wishlist";
                $response['wishlist_count'] = Cart::instance('wishlist')->count();
            }
        }
        return response()->json($response);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request,string $id)
    {
        $product_id = $request->input('product_id');
        Cart::instance('wishlist')->remove($product_id);

        $response['status'] = true;
        $response['message'] = "Item successfully removed form your wishlist";
        $response['cart_count'] = Cart::instance('shopping')->count();

        if($request->ajax()){
            $header = view('frontend.layouts.header')->render();
            $wishlist = view('frontend.pages.wishlist.wishlist_items')->render();
            $response['header'] = $header;
            $response['wishlist_items'] = $wishlist;
        }

        return response()->json($response);

    }

    public function moveToCart(Request $request){
        // dd($request->all());
        $product_id = $request->input('product_id');
        $item = Cart::instance('wishlist')->get($product_id);
        Cart::instance('wishlist')->remove($product_id);
        $result = Cart::instance('shopping')->add($item->id,$item->name,1,$item->price)->associate(Product::class);
        if($result){
            $response['status'] = true;
            $response['message'] = "Item has been moved to cart";
            $response['cart_count'] = Cart::instance('shopping')->count();
        }

        if($request->ajax()){
            $header = view('frontend.layouts.header')->render();
            $wishlist = view('frontend.pages.wishlist.wishlist_items')->render();
            $response['header'] = $header;
            $response['wishlist_items'] = $wishlist;
        }

        return response()->json($response);

    }
}
