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
            $response['total'] = Cart::instance('shopping')->subtotal();
            $response['cart_count'] = Cart::instance('shopping')->count();
            $response['message'] = "Item was added to your cart!";
        }

        if($request->ajax()){
            $header = view('frontend.layouts.header')->render();
            $response['header'] = $header;
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
        // dd($request->all());
        $this->validate($request,[
            'product_qty' => 'required|numeric'
        ]);
        $product_id = $request->input('product_id');
        $product_qty = $request->input('product_qty');
        $product_stock = $request->input('product_stock');

        if($product_qty > $product_stock){
            $message = "We currently do not have enough items in stock!";
            $response['status'] = false;
        }
        elseif($product_qty<1){
            $message = "You can't add < 1 quantity!";
            $response['status'] = false;
        }
        else{
            Cart::instance('shopping')->update($product_id,$product_qty);
            $message = "Quantity was updated successfully!";
            $response['status'] = true;
            $response['total'] = Cart::instance('shopping')->subtotal();
            $response['cart_count'] = Cart::instance('shopping')->count();
        }

        if($request->ajax()){
            $header = view('frontend.layouts.header')->render();
            $cart_list = view('frontend.pages.cart.cart-list')->render();
            $response['header'] = $header;
            $response['cart_list'] = $cart_list;
            $response['message'] = $message;
        }

        return response()->json($response);
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
        $response['total'] = Cart::instance('shopping')->subtotal();
        $response['cart_count'] = Cart::instance('shopping')->count();
        $response['message'] = "item successfully removed!";

        if($request->ajax()){
            $header = view('frontend.layouts.header')->render();
            $response['header'] = $header;
        }

        return response()->json($response);
    }

}
