<?php

namespace App\Http\Controllers;

use App\Models\Shipping;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use App\Http\Requests\StoreShippingRequest;
use App\Http\Requests\UpdateShippingRequest;

class ShippingController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $shippings = Shipping::orderBy('id','DESC')->get();
        return view('backend.shippings.index',compact('shippings'));
    }

    public function changeStatus(Request $request){
        $shipping = DB::table('shippings')->where('id',$request->input('id'))->first();
        // dd($banner->select('status')->get());
        if($shipping->status == 'inactive'){
            DB::table('shippings')->where('id', $request->input('id'))->update(['status' => 'active']);
        }
        else{
            DB::table('shippings')->where('id', $request->input('id'))->update(['status' => 'inactive']);
        }
        return response()->json(['success'=>'Status updated successfully','status'=>true]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('backend.shippings.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreShippingRequest $request)
    {
        $data = $request->validated();

        $status = Shipping::create($data);

        if($status){
            return redirect()->route('admin.shippings.index')->with('success','Shipping created successfully.');
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
        $shipping = Shipping::find($id);
        if($shipping){
            return view('backend.shippings.edit',compact('shipping'));
        }
        else{
            return back()->with('error','Data not found');
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateShippingRequest $request, string $id)
    {
        $shipping = Shipping::find($id);
        if($shipping){
            $data = $request->validated();

            $status = $shipping->update($data);

            if($status){
                return redirect()->route('admin.shippings.index')->with('success','Shipping updated successfully.');
            }
            else{
                return back()->with('error','Something went wrong!');
            }
       }
        else{
            return back()->with('error','Data not found');
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $shipping = Shipping::find($id);
        if($shipping){
            $status = $shipping->delete();
            if($status){
                return redirect()->route('admin.shippings.index')->with('success','Shipping deleted successfully');
            }
            else{
                return back()->with('error','Something went wrong');
            }
        }
        else{
            return back()->with('error','Data not found');
        }
    }
}
