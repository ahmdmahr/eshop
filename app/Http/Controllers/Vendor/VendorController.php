<?php

namespace App\Http\Controllers\Vendor;

use App\Models\User;
use App\Models\Order;
use App\Models\Product;
use App\Models\Category;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\OrderItem;

class VendorController extends Controller
{
    public function index(){
        $user_id = auth()->user()->id;

        $vendorProducts = Product::where(['status'=>'active','vendor_id'=>$user_id])->get();

        $vendorCategoryIds = Product::where(['status'=>'active','vendor_id'=>$user_id])->pluck('category_id')->toArray();

        $vedorCategories = Category::whereIn('id',$vendorCategoryIds)->get();

        $vendorProductIds = $vendorProducts->pluck('id')->toArray();

        // join('order_items', 'orders.id', '=', 'order_items.order_id'): This performs an inner join on the order_items table, matching records where orders.id equals order_items.order_id.

        // new cols = [order_id,user_id,product_id]
        $vendorOrderedItems = OrderItem::join('orders', 'order_items.order_id', '=',
         'orders.id')->whereIn('order_items.product_id', $vendorProductIds)
                     ->select('orders.id as order_id', 'orders.user_id', 'order_items.id as product_id')
                     ->get();

        $vendorCustomerIds = $vendorOrderedItems->pluck('user_id')->toArray();

        $vendorCustomers = User::whereIn('id',$vendorCustomerIds)->get();

        return view('seller.index',compact('vedorCategories', 'vendorProducts', 'vendorCustomers', 'vendorOrderedItems'));
    }
}
