<?php

namespace App\Http\Controllers\Frontend;

use App\Models\Product;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\StoreCartRequest;
use Gloudemans\Shoppingcart\Facades\Cart;

class CartController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('frontend.pages.cart.index');
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
    public function store(StoreCartRequest $request)
    {
        $data = $request->validated();
        $product = Product::where('id',$data['product_id'])->first();
        $price = $product->offer_price;
        $product_qty = $request->input('product_qty');
        
        $cart_array = [];
        foreach(Cart::instance('shopping')->content() as $item){
            $cart_array[] = $item->id;
        }

        $added = Cart::instance('shopping')->add($product->id,$product->title,$product_qty,$price)->associate(Product::class);

        if($added){
            $response['status'] = true;
            $response['product_id'] = $product->id;
            $response['total'] = Cart::subtotal();
            $response['cart_count'] = Cart::instance('shopping')->count();
            $response['message'] = "Item was added to your cart!";
        }

        if($request->ajax()){
            $header = view('frontend.layouts.header')->render();
        }

        $response['header'] = $header;


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
    public function destroy(string $id,Request $request)
    {
        // dd($request->all());
        $id = $request->input('product_id');
        
        Cart::instance('shopping')->remove($id);

        $response['status'] = true;
        $response['product_id'] = $id;
        $response['total'] = Cart::subtotal();
        $response['cart_count'] = Cart::instance('shopping')->count();
        $response['message'] = "item successfully removed!";

        if($request->ajax()){
            $header = view('frontend.layouts.header')->render();
        }

        $response['header'] = $header;


        return response()->json($response);
    }
}
