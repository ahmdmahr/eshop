<?php

namespace App\Http\Controllers;

use App\Models\Coupon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Requests\ApplyCouponRequest;
use App\Http\Requests\StoreCouponRequest;
use Gloudemans\Shoppingcart\Facades\Cart;
use App\Http\Requests\UpdateCouponRequest;

class CouponController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $coupons = Coupon::orderBy('id','DESC')->get();
        return view('backend.coupons.index',compact('coupons'));
    }

    public function changeStatus(Request $request){
        $coupon = DB::table('coupons')->where('id',$request->input('id'))->first();
        if($coupon->status == 'inactive'){
            DB::table('coupons')->where('id', $request->input('id'))->update(['status' => 'active']);
        }
        else{
            DB::table('coupons')->where('id', $request->input('id'))->update(['status' => 'inactive']);
        }
        return response()->json(['success'=>'Status updated successfully','status'=>true]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('backend.coupons.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreCouponRequest $request)
    {
        $data = $request->validated();

        $status = Coupon::create($data);

        if($status){
            return redirect()->route('admin.coupons.index')->with('success','Coupon created successfully.');
        }
        else{
            return back()->with('error','Something went wrong!');
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $coupon = Coupon::find($id);
        if($coupon){
          return view('backend.coupons.edit',compact('coupon'));
        }
        else{
            return back()->with('error','Coupon not found!');
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateCouponRequest $request, string $id)
    {
        $coupon = Coupon::find($id);
        if($coupon){
            $data = $request->validated();
    
            $status = $coupon->update($data);
    
            if($status){
                return redirect()->route('admin.coupons.index')->with('success','Coupon updated successfully.');
            }
            else{
                return back()->with('error','Something went wrong!');
            }
        }
        else{
            return back()->with('error','Coupon not found!');
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $coupon = Coupon::find($id);
        if($coupon){
            $status = $coupon->delete();
            if($status){
                return redirect()->route('admin.coupons.index')->with('success','Coupon deleted successfully');
            }
            else{
                return back()->with('error','Something went wrong');
            }
        }
        else{
            return back()->with('error','Data not found');
        }
    }

    public function apply(ApplyCouponRequest $request){
        $data = $request->validated();
        $coupon = Coupon::where('code',$data['code'])->first();
        if(!$coupon){
            return back()->with('error','Invalid coupon');
        }
        else{
            $total_price = Cart::instance('shopping')->subtotal();
            //  session()->put('coupon',[]) is using Laravel's session management to store coupon information
            session()->put('coupon',[
                'id'=>$coupon->id,
                'code'=>$coupon->code,
                'value'=>$coupon->discount($total_price)
            ]);
            return back()->with('success','Coupon applied successfully!');
        }
    }
}
