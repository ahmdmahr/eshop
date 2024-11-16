<?php

namespace App\Http\Controllers\Api;

use App\Models\AboutUs;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Storage;
use App\Http\Requests\StoreAboutUsRequest;
use App\Http\Requests\UpdateAboutUsRequest;
use App\Http\Resources\AboutUsResource;

class AboutUsController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $all_about_us = AboutUs::orderBy('id','DESC')->get();
        if ($all_about_us->isEmpty()) {
            return response()->json([
                'success' => false,
                'message' => 'No about us found.'
            ], 404); // Return 404 if no about us are found
        }
    
        return response()->json([
            'success' => true,
            'message' => 'About Us records retrieved successfully.',
            'data' => AboutUsResource::collection($all_about_us)
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
    public function store(StoreAboutUsRequest $request)
    {
        $data = $request->validated();

        $about_us = AboutUs::create($data);

        if ($about_us) {
            return response()->json([
                'success' => true,
                'message' => 'aboutUs created successfully.',
                'data' => new AboutUsResource($about_us),  // Returning the newly created about_us
            ], 201);  // HTTP status code 201 indicates 'Created'
        } else {
            return response()->json([
                'success' => false,
                'message' => 'Something went wrong while creating the about_us.',
            ], 400);  // HTTP status code 400 for Bad Request
        }   
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $about_us = AboutUs::find($id);
        if ($about_us) {
            return response()->json([
                'success' => true,
                'about us' => new AboutUsResource($about_us),
            ], 200); // HTTP status code 200 (OK)
        } else {
            return response()->json([
                'success' => false,
                'message' => 'About Us not found'
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
    public function update(UpdateAboutUsRequest $request, string $id)
    {
        $about_us = AboutUs::find($id);

        if($about_us){
        $data = $request->validated();


        if(array_key_exists('images',$data)){
            $data['image1'] = $data['images'][0];
            $data['image2'] = $data['images'][1];
            $data['image3'] = $data['images'][2];
            $data['image4'] = $data['images'][3];
        }

        $status = $about_us->update($data);
        if($status){
                return response()->json([
                    'success' => true,
                    'message' => 'about_us updated successfully.',
                    'data' => new AboutUsResource($about_us),  // Returning the updated category
                ], 200);  // HTTP status code 200 for success update operation
            }
            else{
                return response()->json([
                    'success' => false,
                    'message' => 'Something went wrong while updating the about_us.',
                ], 400); // HTTP status code 400 for Bad Request
            }
        }
        else{
            return response()->json([
                'success' => false,
                'message' => 'about_us not found'
            ], 404); // HTTP status code 404 (Not Found)
        }

        
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $about_us = AboutUs::find($id);
        if($about_us){

            if($about_us->image1 && Storage::disk('public')->exists($about_us->image1))
               Storage::disk('public')->delete($about_us->image1);
            if($about_us->image2 && Storage::disk('public')->exists($about_us->image2))
               Storage::disk('public')->delete($about_us->image2);
            if($about_us->image3 && Storage::disk('public')->exists($about_us->image3))
               Storage::disk('public')->delete($about_us->image3);
            if($about_us->image4 && Storage::disk('public')->exists($about_us->image4))
               Storage::disk('public')->delete($about_us->image4);

            $status = $about_us->delete();
            if($status){
                return response()->json([
                    'success' => true,
                    'message' => 'about_us and associated image deleted successfully.'
                ], 200); // HTTP status 200 for successful deletion
            }
            else{
                return response()->json([
                    'success' => false,
                    'message' => 'Something went wrong while deleting the about_us.'
                ], 500); // HTTP status 500 for internal server error
            }
        }
        else{
            return response()->json([
                'success' => false,
                'message' => 'about_us not found.'
            ], 404); // HTTP status 404 for resource not found
        }
    }
}
