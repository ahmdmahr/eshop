<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreCurrencyRequest;
use App\Http\Requests\UpdateCurrencyRequest;
use App\Models\Currency;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class CurrencyController extends Controller
{
     /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $currencies = Currency::orderBy('id','DESC')->get();
        return view('backend.currencies.index',compact('currencies'));
    }

    public function changeStatus(Request $request){
        $currency = DB::table('currencies')->where('id',$request->input('id'))->first();
        if($currency->status == 'inactive'){
            DB::table('currencies')->where('id', $request->input('id'))->update(['status' => 'active']);
        }
        else{
            DB::table('currencies')->where('id', $request->input('id'))->update(['status' => 'inactive']);
        }
        return response()->json(['success'=>'Currency updated successfully','status'=>true]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('backend.currencies.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreCurrencyRequest $request)
    {
        $data = $request->validated();


        $status = Currency::create($data);

        if($status){
            return redirect()->route('admin.currencies.index')->with('success','Currency created successfully.');
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
        $currency = Currency::find($id);
        if($currency){
            return view('backend.currencies.edit',compact('currency'));
        }
        else{
            return back()->with('error','Data not found');
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateCurrencyRequest $request, string $id)
    {
        $currency = Currency::find($id);
        if($currency){
            $data = $request->validated();

            $status = $currency->update($data);

            if($status){
                return redirect()->route('admin.currencies.index')->with('success','Currency updated successfully.');
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
        $currency = Currency::find($id);
        if($currency){
            $status = $currency->delete();
            if($status){
                return redirect()->route('admin.currencies.index')->with('success','Currency deleted successfully');
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
