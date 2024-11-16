<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Brand;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use App\Http\Requests\StoreBrandRequest;
use App\Http\Requests\UpdateBrandRequest;
use App\Http\Resources\BrandResource;

class BrandController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $brands = Brand::orderBy('id','DESC')->get();
        if ($brands->isEmpty()) {
            return response()->json([
                'success' => false,
                'message' => 'No brands found.'
            ], 404); // Return 404 if no brands are found
        }
    
        return response()->json([
            'success' => true,
            'message' => 'brands retrieved successfully.',
            'data' => BrandResource::collection($brands)
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

        $brand = Brand::create($data);

        if ($brand) {
            return response()->json([
                'success' => true,
                'message' => 'brand created successfully.',
                'data' => new BrandResource($brand),  // Returning the newly created brand
            ], 201);  // HTTP status code 201 indicates 'Created'
        } else {
            return response()->json([
                'success' => false,
                'message' => 'Something went wrong while creating the brand.',
            ], 400);  // HTTP status code 400 for Bad Request
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $brand = Brand::find($id);
        if ($brand) {

            return response()->json([
                'success' => true,
                'brand' => new BrandResource($brand),
            ], 200); // HTTP status code 200 (OK)
        } else {
            return response()->json([
                'success' => false,
                'message' => 'Brand not found'
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
                return response()->json([
                    'success' => true,
                    'message' => 'Brand updated successfully.',
                    'data' => new BrandResource($brand),  // Returning the updated category
                ], 200);  // HTTP status code 200 for success update operation
            }
            else{
                return response()->json([
                    'success' => false,
                    'message' => 'Something went wrong while updating the brand.',
                ], 400); // HTTP status code 400 for Bad Request
            }
        }
        else{
            return response()->json([
                'success' => false,
                'message' => 'Brand not found'
            ], 404); // HTTP status code 404 (Not Found)
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
                return response()->json([
                    'success' => true,
                    'message' => 'Brand and associated image deleted successfully.'
                ], 200); // HTTP status 200 for successful deletion
            }
            else{
                return response()->json([
                    'success' => false,
                    'message' => 'Something went wrong while deleting the brand.'
                ], 500); // HTTP status 500 for internal server error
            }
        }
        else{
            return response()->json([
                'success' => false,
                'message' => 'Brand not found.'
            ], 404); // HTTP status 404 for resource not found
        }
    }
}
