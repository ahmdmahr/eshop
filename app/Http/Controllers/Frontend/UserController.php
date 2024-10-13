<?php

namespace App\Http\Controllers\Frontend;

use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

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

    public function editAddress(Request $request,$id){

        $user = User::where('id',$id)->update(['country'=>$request->country,'state'=>$request->state,'city'=>$request->city,'postcode'=>$request->postcode,'address'=>$request->address]);
        if($user){
            return back()->with('success','Billing Address updated successfully ');
        }
        else{
            return back()->with('error','Something went wrong!');
        }
    }

    public function editShippingAddress(Request $request,$id){
        $user = User::where('id',$id)->update(['shipping_country'=>$request->shipping_country,'state'=>$request->state,'shipping_city'=>$request->shipping_city,'shipping_postcode'=>$request->shipping_postcode,'shipping_address'=>$request->shipping_address]);
        if($user){
            return back()->with('success','Shipping Address updated successfully ');
        }
        else{
            return back()->with('error','Something went wrong!');
        }
    }

    public function updateAccount(Request $request,$id){
        $this->validate($request,[
            'full_name' => 'required|string',
            'username' => 'nullable|string',
            'phone' => 'required|string',
            'oldpassword' =>'nullable|string',
            'newpassword' =>'string|min:4'
        ]);

        if($request->oldpassword == null && $request->newpassword == null){
            User::where('id',$id)->update(['full_name'=>$request->full_name,'username'=>$request->username,'phone'=>$request->phone]);
            return back()->with('success','Account updated successfully');
        }
        else{
            $hashedPassword = Auth::user()->password;
            if(Hash::check($request->oldpassword,$hashedPassword)){
                if(!Hash::check($request->newpassword,$hashedPassword)){
                    $new_password = Hash::make($request->newpassword);
                    User::where('id',$id)->update(['full_name'=>$request->full_name,'username'=>$request->username,'phone'=>$request->phone,'password'=>$new_password]);
                    return back()->with('success','Account updated successfully');
                }
                else{
                    return back()->with('error','New password can not be same as old');
                }
            }
            else{
                return back()->with('error','Old password is incorrect');
            }
        }
    }
}
