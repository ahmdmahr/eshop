<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\Product;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $orders = Order::orderBy('id','DESC')->get();
        return view('backend.orders.index',compact('orders'));
    }

    public function changeCondition(Request $request){
        $order_id = $request->input('order_id');
        $condition = $request->input('condition');
        $order = Order::find($order_id);
        if($order){
            if($condition == 'delivered'){
                foreach($order->order_items as $item){
                    $product = Product::where('id',$item->product_id)->first();
                    $stock = $product->stock;
                    $stock-=$item->quantity;
                    $product->update(['stock'=>$stock]);
                }
                Order::where('id',$order_id)->update(['payment_status'=>'paid']);
            }
            $status = Order::where('id',$order_id)->update(['condition'=>$condition]);
            if($status){
                return back()->with('success','Order condition updated successfully');
            }  
            else{
                return back()->with('error','Something went wrong!');
            }
        }
        else{
            return back();
        }
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
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $order = Order::find($id);
        if($order){
            return view('backend.orders.show',compact('order'));
        }
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
    public function destroy(string $id)
    {
        $order = Order::find($id);
        if($order){
            $status = $order->delete();
            if($status){
                return redirect()->route('admin.orders.index')->with('success','Order deleted successfully');
            }
            else{
                return back()->with('error','Something went wrong');
            }
        }
        else{
            return back()->with('error','Data not found');
        }
    }
}
