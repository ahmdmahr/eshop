<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Brand;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use App\Http\Requests\StoreBrandRequest;
use App\Http\Requests\UpdateBrandRequest;

class BrandController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $brands = Brand::orderBy('id','DESC')->get();
        return view('backend.brands.index',compact('brands'));
    }

    public function changeStatus(Request $request){
        $brand = DB::table('brands')->where('id',$request->input('id'))->first();
        if($brand->status == 'inactive'){
            DB::table('brands')->where('id', $request->input('id'))->update(['status' => 'active']);
        }
        else{
            DB::table('brands')->where('id', $request->input('id'))->update(['status' => 'inactive']);
        }
        return response()->json(['success'=>'Status updated successfully','status'=>true]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('backend.brands.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreBrandRequest $request)
    {
        $data = $request->validated();

        $slug = Str::slug($request->input('title'));
        $slug_count = Brand::where('slug',$slug)->count();
        if($slug_count>0){
            $slug = time().'-'.$slug;
        }
        $data['slug'] = $slug;

        if ($request->hasFile('photo')) {
            $imagePath = $request->file('photo')->store('brands', 'public');
            $data['photo'] = Storage::url($imagePath);
        }

        $status = Brand::create($data);

        if($status){
            return redirect()->route('admin.brands.index')->with('success','Brand created successfully.');
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
        $brand = Brand::find($id);
        if($brand){
            return view('backend.brands.edit',compact('brand'));
        }
        else{
            return back()->with('error','Data not found');
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateBrandRequest $request, string $id)
    {
        $brand = Brand::find($id);
        if($brand){
            $data = $request->validated();

            if($request->hasFile('photo')){
                $imagePath = $request->file('photo')->store('brands','public');

                if($brand->photo && Storage::disk('public')->exists($brand->photo))
                   Storage::disk('public')->delete($brand->photo);
                
                $data['photo'] = Storage::url($imagePath);
            }

            $status = $brand->update($data);

            if($status){
                return redirect()->route('admin.brands.index')->with('success','Brand updated successfully.');
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
        $brand = Brand::find($id);
        if($brand){
            if($brand->photo && Storage::disk('public')->exists($brand->photo))
               Storage::disk('public')->delete($brand->photo);
            $status = $brand->delete();
            if($status){
                return redirect()->route('admin.brands.index')->with('success','Brand deleted successfully');
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
