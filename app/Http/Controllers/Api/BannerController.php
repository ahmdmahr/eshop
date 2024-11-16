<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Banner;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;
use App\Http\Requests\StoreBannerRequest;
use App\Http\Requests\UpdateBannerRequest;
use App\Http\Resources\BannerResource;

class BannerController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $banners = Banner::orderBy('id','DESC')->get();
        if ($banners->isEmpty()) {
            return response()->json([
                'success' => false,
                'message' => 'No banners found.'
            ], 404); // Return 404 if no banners are found
        }
    
        return response()->json([
            'success' => true,
            'message' => 'banners retrieved successfully.',
            'data' => BannerResource::collection($banners)
        ], 200); // HTTP status 200 for success
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreBannerRequest $request)
    {
        $data = $request->validated();

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

        $banner = Banner::create($data);

        if ($banner) {
            return response()->json([
                'success' => true,
                'message' => 'banner created successfully.',
                'data' => new BannerResource($banner),  // Returning the newly created banner
            ], 201);  // HTTP status code 201 indicates 'Created'
        } else {
            return response()->json([
                'success' => false,
                'message' => 'Something went wrong while creating the banner.',
            ], 400);  // HTTP status code 400 for Bad Request
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $banner = Banner::find($id);
        if ($banner) {
            return response()->json([
                'success' => true,
                'banner' =>  new BannerResource($banner),
            ], 200); // HTTP status code 200 (OK)
        } else {
            return response()->json([
                'success' => false,
                'message' => 'Banner not found'
            ], 404); // HTTP status code 404 (Not Found)
        }
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
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
                return response()->json([
                    'success' => true,
                    'message' => 'Banner updated successfully.',
                    'data' =>  new BannerResource($banner),  // Returning the updated category
                ], 200);  // HTTP status code 200 for success update operation
            }
            else{
                return response()->json([
                    'success' => false,
                    'message' => 'Something went wrong while updating the banner.',
                ], 400); // HTTP status code 400 for Bad Request
            }
        }
        else{
            return response()->json([
                'success' => false,
                'message' => 'Banner not found'
            ], 404); // HTTP status code 404 (Not Found)
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
                return response()->json([
                    'success' => true,
                    'message' => 'Banner and associated image deleted successfully.'
                ], 200); // HTTP status 200 for successful deletion
            }
            else{
                return response()->json([
                    'success' => false,
                    'message' => 'Something went wrong while deleting the banner.'
                ], 500); // HTTP status 500 for internal server error
            }
        }
        else{
            return response()->json([
                'success' => false,
                'message' => 'Banner not found.'
            ], 404); // HTTP status 404 for resource not found
        }
    }
}
