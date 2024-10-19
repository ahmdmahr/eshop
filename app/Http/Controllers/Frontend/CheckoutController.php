<?php

namespace App\Http\Controllers\Frontend;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class CheckoutController extends Controller
{
    public function checkout1(){
        $user = Auth::user();
        return view('frontend.pages.checkout.checkout1',compact('user'));
    }
}
