<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Order;
use App\Models\Product;
use App\Models\Category;
use Illuminate\Http\Request;

class AdminController extends Controller
{
    public function index(){
        $categories = Category::where('status','active')->get();
        $products = Product::where('status','active')->get();
        $customers = User::where(['status'=>'active','role'=>'customer'])->get();
        $orders = Order::orderBy('id','DESC')->get();
        return view('backend.index',compact('categories','products','customers','orders'));
    }
}
