<?php

namespace App\Http\Controllers\Frontend;

use App\Models\Order;
use App\Models\Shipping;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use App\Http\Requests\StoreCheckout1Request;

class CheckoutController extends Controller
{
    public function checkout1(){
        $user = Auth::user();
        return view('frontend.pages.checkout.checkout1',compact('user'));
    }

    public function checkout1Store(StoreCheckout1Request $request){
        $data = $request->validated();
        Session::put('checkout',$data);
        $shippings = Shipping::where('status','active')->orderBy('shipping_address','ASC')->get();
        return view('frontend.pages.checkout.checkout2',compact('shippings'));
    }

    public function checkout2(){
        $user = Auth::user();
        return view('frontend.pages.checkout.checkout2',compact('user'));
    }

    public function checkout2Store(Request $request){
        $request->validate([
            'delivery_charge' => 'nullable|numeric'
        ]);
    
        Session::push('checkout',[
            'delivery_charge'=>$request->delivery_charge
        ]);
        return view('frontend.pages.checkout.checkout3');
    }

    public function checkout3(){
        $user = Auth::user();
        return view('frontend.pages.checkout.checkout3',compact('user'));
    }

    public function checkout3Store(Request $request){
        $request->validate([
            'payment_method' => 'required|string',
            'payment_status' => 'string|in:paid,unpaid'
        ]);
        Session::push('checkout',[
            'payment_method'=>$request->payment_method,
            'payment_status'=>'paid'
        ]);
        return view('frontend.pages.checkout.checkout4');
    }

    public function checkoutStore(){

        // return Session::get('checkout');

        $checkout = Session::get('checkout');

        $coupon = Session::get('coupon')[0] ?? 0;

        // order related data
        $order_data = [
            'user_id' => Auth::user()->id,
            'order_number' => Str::upper('ord-'.Str::random(6)),
            'coupon' => $coupon,
            'payment_method' => $checkout[1]['payment_method'],
            'payment_status' => $checkout[1]['payment_status'],
            'condition' => 'pending',
            'delivery_charge' => $checkout[0]['delivery_charge'],
            'sub_total' => $checkout['sub_total'],
            'total' => $checkout['sub_total']-$coupon+$checkout[0]['delivery_charge'],
            'notes' => $checkout['notes'],
        ];

        // user related data
        $user_data = [
            'email' => $checkout['email'],
            'phone' => $checkout['phone'],
            'country' => $checkout['country'],
            'state' => $checkout['state'],
            'city' => $checkout['city'],
            'postcode' => $checkout['postcode'],
            'address' => $checkout['address'],
            'shipping_country' => $checkout['shipping_country'],
            'shipping_state' => $checkout['shipping_state'],
            'shipping_city' => $checkout['shipping_city'],
            'shipping_postcode' => $checkout['shipping_postcode'],
            'shipping_address' => $checkout['shipping_address']
        ];
        
        // $user = User::find(Auth::user()->id);

        // $user->update($user_data);

        $status = Order::create($order_data);

        if($status){
            Session::forget('coupon');
            Session::forget('checkout');
            $order_id = $order_data['order_number'];
            return redirect()->route('user.checkout.complete',$order_id);
        }
        else{
            return redirect()->route('user.checkout1')->with('error','Please try again');
        }
        
    }

    public function complete($order_id){
        return view('frontend.pages.checkout.complete',compact('order_id'));
    }
}