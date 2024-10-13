<?php

namespace App\Http\Controllers\Frontend;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{
    public function dashboard(){
        $user = Auth::user();
        return view('frontend.users.dashboard',compact('user'));
    }

    public function orderList(){
        $user = Auth::user();
        return view('frontend.users.orderlist',compact('user'));
    }

    public function getAddress(){
        $user = Auth::user();
        return view('frontend.users.address',compact('user'));
    }

    public function accountDetails(){
        $user = Auth::user();
        return view('frontend.users.account-details',compact('user'));
    }
}
