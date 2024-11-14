<?php

namespace App\Http\Controllers\Api;

use App\Models\Order;
use App\Models\Coupon;
use App\Models\Product;
use App\Models\OrderItem;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\StoreOrderRequest;
use App\Http\Requests\UpdateOrderRequest;

class OrderController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $orders = Order::with('order_items')->orderBy('id','DESC')->get();
        if ($orders->isEmpty()) {
            return response()->json([
                'success' => false,
                'message' => 'No orders found.'
            ], 404); // Return 404 if no orders are found
        }
    
        return response()->json([
            'success' => true,
            'message' => 'Orders retrieved successfully.',
            'data' => $orders
        ], 200); // HTTP status 200 for success
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreOrderRequest $request)
    {

        $data = $request->validated();

        // dd($data);

        $products = Product::whereIn('id',$data['product_ids'])->get();

        $quantities = $data['product_quantities'];

        $subtotal = 0;
        foreach($products as $index=>$product){
            $subtotal+=$product->offer_price*$quantities[$index];
        }
        
        // create the order in the db
        $order_data = [
            'user_id'=>$data['user_id'],
            'order_number' => Str::upper('ord-'.Str::random(6)),
            'coupon' => $data['coupon'],
            'payment_method' => $data['payment_method'],
            'payment_status' => $data['payment_status'],
            'condition' => $data['condition'],
            'delivery_charge' => $data['delivery_charge'],
            'subtotal' => $subtotal,
            'total' => $subtotal-$data['coupon']+$data['delivery_charge'],
            'notes' => $data['notes'],
            'payment_details' => $data['payment_details']
        ];

        $order = Order::create($order_data);

        // save associated products in order_items db
        foreach($products as $index => $product){
            OrderItem::create([
                'order_id' => $order->id,
                'product_id' => $product->id,
                'price' => $product->price,
                'quantity' => $quantities[$index]
            ]);
        }

        if($order) {
            return response()->json([
                'success' => true,
                'message' => 'order created successfully.',
                'data' => $order,  // Returning the newly created order
            ], 201);  // HTTP status code 201 indicates 'Created'
        } else {
            return response()->json([
                'success' => false,
                'message' => 'Something went wrong while creating the order.',
            ], 400);  // HTTP status code 400 for Bad Request
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $order = Order::with('order_items')->find($id);
        if ($order) {
            return response()->json([
                'success' => true,
                'order' => $order,
            ], 200); // HTTP status code 200 (OK)
        } else {
            return response()->json([
                'success' => false,
                'message' => 'Order not found'
            ], 404); // HTTP status code 404 (Not Found)
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
    public function update(UpdateOrderRequest $request, string $id)
    {
        $order = Order::with('order_items')->find($id);

        if($order){
           $data = $request->validated();

            // get unwanted order items and still needed ones
            $deleted = [];
            $deleted_quantities = [];
            foreach($order->order_items as $item){
                $index = array_search($item->product_id,$data['product_ids']);
                if($index && $data['add_or_remove'][$index] == '-'){
                array_push($deleted,$item->product_id);
                array_push($deleted_quantities,$data['quantities'][$index]);
                }
            }

            // get new added ones
            $new_added = [];
            $new_added_quantities = [];

            $order_item_product_ids = [];
            foreach($order->order_items as $item){
                array_push($order_item_product_ids,$item->product_id);
            }

            foreach($data['add_or_remove'] as $index => $val){
                if($val == '+'){
                    if(array_search($data['product_ids'][$index],$order_item_product_ids) == 0){
                        array_push($new_added,$data['product_ids'][$index]);
                        array_push($new_added_quantities,$data['product_quantities'][$index]);
                    }
                }
            }

            // dd($deleted);

            $subtotal = $order->subtotal;
            foreach($new_added as $index => $item){
                $product = Product::find($item);
                $subtotal+=$product->offer_price*$new_added_quantities[$index];
            }

            foreach($deleted as $index => $item){
                $product = Product::find($item);
                $subtotal-=$product->offer_price*$deleted_quantities[$index];
            }

            
            // create the order in the db
            $order_data = [
                'user_id'=>$data['user_id']??$order->user_id,
                'order_number' => Str::upper('ord-'.Str::random(6)),
                'coupon' => $data['coupon']??$order->coupon,
                'payment_method' => $data['payment_method']??$order->payment_method,
                'payment_status' => $data['payment_status']??$order->payment_status,
                'condition' => $data['condition']??$order->condition,
                'delivery_charge' => $data['delivery_charge']??$order->delivery_charge,
                'subtotal' => $subtotal,
                'total' => $subtotal-$data['coupon']??$order->coupon+$data['delivery_charge']??$order->delivery_charge,
                'notes' => $data['notes']??$order->notes,
                'payment_details' => $data['payment_details']??$order->order_details
            ];

            $order->update($order_data);

            // save associated new_added in order_items db
            foreach($new_added as $index => $item){
                OrderItem::create([
                    'order_id' => $order->id,
                    'product_id' => $item,
                    'price' => $product->price,
                    'quantity' => $new_added_quantities[$index]
                ]);
            }
            // delete cancelled products
            foreach($deleted as $index => $product){
                $order_item = OrderItem::where('product_id',$product);
                $order_item->delete();
            }

            $new_order = Order::with('order_items')->find($order->id);
            if($new_order){
                return response()->json([
                    'success' => true,
                    'message' => 'Order updated successfully.',
                    'data' => $order,  // Returning the updated order
                ], 200);  // HTTP status code 200 for success update operation
            }
            else{
                return response()->json([
                    'success' => false,
                    'message' => 'Something went wrong while updating the order.',
                ], 400); // HTTP status code 400 for Bad Request
            }
        }
        else{
            return response()->json([
                'success' => false,
                'message' => 'Order not found'
            ], 404); // HTTP status code 404 (Not Found)
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $order = Order::find($id);
        if($order){
            foreach ($order->order_items as $item) {
                $item->delete();
            }
               

            $status = $order->delete();
            
            if ($status) {
                return response()->json([
                    'success' => true,
                    'message' => 'Order and associated product items deleted successfully.'
                ], 200); // HTTP status 200 for successful deletion
            } else {
                return response()->json([
                    'success' => false,
                    'message' => 'Something went wrong while deleting the order.'
                ], 500); // HTTP status 500 for internal server error
            }
        }
        else {
            return response()->json([
                'success' => false,
                'message' => 'Order not found.'
            ], 404); // HTTP status 404 for resource not found
        }
    }
}
