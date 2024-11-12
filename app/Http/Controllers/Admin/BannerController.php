<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Banner;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use App\Http\Requests\StoreBannerRequest;
use App\Http\Requests\UpdateBannerRequest;

class BannerController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $banners = Banner::orderBy('id','DESC')->get();
        return view('backend.banners.index',compact('banners'));
    }

    public function changeStatus(Request $request){
        $banner = DB::table('banners')->where('id',$request->input('id'))->first();
        // dd($banner->select('status')->get());
        if($banner->status == 'inactive'){
            DB::table('banners')->where('id', $request->input('id'))->update(['status' => 'active']);
        }
        else{
            DB::table('banners')->where('id', $request->input('id'))->update(['status' => 'inactive']);
        }
        return response()->json(['success'=>'Status updated successfully','status'=>true]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('backend.banners.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreBannerRequest $request)
    {
        $data = $request->validated();

        // Str::slug() is used to create a URL-friendly string by converting a given string into a slug format, replacing spaces with hyphens and removing special characters. For example, calling Str::slug('Hello World!') will return 'hello-world'. This is ultimate for generating SEO-friendly URLs and improving readability.
        $slug = Str::slug($request->input('title'));
        $slug_count = Banner::where('slug',$slug)->count();
        if($slug_count>0){
            $slug = time().'-'.$slug;
        }
        $data['slug'] = $slug;

        if($request->hasFile('photo')) {
                $imagePath = $request->file('photo')->store('banners', 'public');
                $data['photo'] = Storage::url($imagePath);
        }

        $status = Banner::create($data);

        if($status){
            return redirect()->route('admin.banners.index')->with('success','Banner created successfully.');
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
        $banner = Banner::find($id);
        if($banner){
            return view('backend.banners.edit',compact('banner'));
        }
        else{
            return back()->with('error','Data not found');
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateBannerRequest $request, string $id)
    {
        $banner = Banner::find($id);
        if($banner){
            $data = $request->validated();

            if($request->hasFile('photo')){
                $imagePath = $request->file('photo')->store('banners','public');

                if($banner->photo && Storage::disk('public')->exists($banner->photo))
                   Storage::disk('public')->delete($banner->photo);
                
                $data['photo'] = Storage::url($imagePath);
            }

            $status = $banner->update($data);

            if($status){
                return redirect()->route('admin.banners.index')->with('success','Banner updated successfully.');
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
        $banner = Banner::find($id);
        if($banner){
            if($banner->photo && Storage::disk('public')->exists($banner->photo))
               Storage::disk('public')->delete($banner->photo);
            $status = $banner->delete();
            if($status){
                return redirect()->route('admin.banners.index')->with('success','Banner deleted successfully');
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
