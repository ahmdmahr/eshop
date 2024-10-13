<?php

namespace App\Http\Controllers\Frontend;

use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\UpdateAccountRequest;
use App\Http\Requests\UpdateBillingAddressRequest;
use App\Http\Requests\UpdateShippingAddressRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AccountController extends Controller
{
    public function dashboard(){
        $user = Auth::user();
        return view('frontend.user.dashboard',compact('user'));
    }

    public function ordersList(){
        $user = Auth::user();
        return view('frontend.user.orders-list',compact('user'));
    }

    public function getAddress(){
        $user = Auth::user();
        return view('frontend.user.addresses',compact('user'));
    }

    public function accountDetails(){
        $user = Auth::user();
        return view('frontend.user.account-details',compact('user'));
    }

    public function updateBillingAddress(UpdateBillingAddressRequest $request,$id){
        $data =  $request->validated();
        $user = User::where('id',$id)->update($data);
        if($user){
            return back()->with('success','Billing Address updated successfully ');
        }
        else{
            return back()->with('error','Something went wrong!');
        }
    }

    public function updateShippingAddress(UpdateShippingAddressRequest $request,$id){
        $data = $request->validated();
        $user = User::where('id',$id)->update($data);
        if($user){
            return back()->with('success','Shipping Address updated successfully ');
        }
        else{
            return back()->with('error','Something went wrong!');
        }
    }

    public function updateAccount(UpdateAccountRequest $request,$id){
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
