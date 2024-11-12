<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Settings;
use PayPal\Http\PayPalClient;
use App\Models\Order as OrderDB;
use PayPal\Checkout\Orders\Item;
use PayPal\Checkout\Orders\Order;
use PayPal\Checkout\Orders\PurchaseUnit;
use PayPal\Checkout\Orders\AmountBreakdown;
use PayPal\Http\Environment\SandboxEnvironment;
use PayPal\Checkout\Requests\OrderCreateRequest;
use PayPal\Checkout\Requests\OrderCaptureRequest;
use PayPal\Http\Environment\ProductionEnvironment;
use App\Http\Controllers\Frontend\CheckoutController;

class PaypalController extends Controller
{
    public function getCheckout(){
        $clientID = env('PAYPAL_CLIENT_ID');
        $clientSecret = env('PAYPAL_CLIENT_SECRET');

        $settings = Settings::first();

        $environment = null;
        if($settings->paypal_sandbox == 1){
            $environment = new SandboxEnvironment($clientID,$clientSecret);
        }
        else{
            $environment = new ProductionEnvironment($clientID,$clientSecret);
        }

        $client = new PayPalClient($environment);

        $order_from_DB = OrderDB::findOrFail(session()->get('order_id'));


        $amount = $order_from_DB->total;
        $currency = session('system_currency_default_info');

        $amountBreakdown = AmountBreakdown::of($amount);

        $purchase_unit = new PurchaseUnit($amountBreakdown);

        foreach ($order_from_DB->order_items as $item) {
            $purchase_unit->addItem(Item::make($item->name, $item->price, $currency, $item->quantity));
        }

        $order = (new Order())->addPurchaseUnit($purchase_unit);

        $response = $client->send(new OrderCreateRequest($order));

    
        if ($response->getStatusCode() === 201) {
            $responseBody = json_decode($response->getBody(), true);
            return redirect()->route('user.paypal.success', ['details' => $responseBody]);
        } else {
            return  redirect()->route('user.paypal.cancel');
        }
    } 

    public function getCancel(){
        session()->forget('order_id');
        return redirect()->route('home')->with('error','Try again later');
    }

    public function getSuccess()
{
    $clientID = env('PAYPAL_CLIENT_ID');
    $clientSecret = env('PAYPAL_CLIENT_SECRET');

    $settings = Settings::first();

    $environment = null;
    if ($settings->paypal_sandbox == 1) {
        $environment = new SandboxEnvironment($clientID, $clientSecret);
    } else {
        $environment = new ProductionEnvironment($clientID, $clientSecret);
    }

    $client = new PayPalClient($environment);

    $orderId = session()->get('order_id');

    $request = new OrderCaptureRequest($orderId);

    $response = $client->send($request);

    if ($response->getStatusCode() === 201) {
            $checkout = new CheckoutController;
            return $checkout->checkout_done($orderId, json_encode($response));
        } 
}
}







