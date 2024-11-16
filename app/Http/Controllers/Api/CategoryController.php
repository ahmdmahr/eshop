<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Category;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;
use App\Http\Requests\StoreCategoryRequest;
use App\Http\Requests\UpdateCategoryRequest;
use App\Http\Resources\CategoryResource;

class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $categories = Category::orderBy('id','DESC')->get();
        if ($categories->isEmpty()) {
            return response()->json([
                'success' => false,
                'message' => 'No categories found.'
            ], 404); // Return 404 if no categories are found
        }
    
        return response()->json([
            'success' => true,
            'message' => 'categories retrieved successfully.',
            'data' => CategoryResource::collection($categories)
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
    public function store(StoreCategoryRequest $request)
    {
        $data = $request->validated();

        $slug = Str::slug($request->input('title'));
        $slug_count = Category::where('slug',$slug)->count();
        if($slug_count>0){
            $slug = time().'-'.$slug;
        }
        $data['slug'] = $slug;

        if($request->hasFile('photo')) {
            $imagePath = $request->file('photo')->store('categories', 'public');
            $data['photo'] = Storage::url($imagePath);
        }
        
        $data['is_parent'] = $request->has('is_parent') ? 1 : 0;

        $category = Category::create($data);

        if ($category) {
            return response()->json([
                'success' => true,
                'message' => 'category created successfully.',
                'data' => new CategoryResource($category),  // Returning the newly created category
            ], 201);  // HTTP status code 201 indicates 'Created'
        } else {
            return response()->json([
                'success' => false,
                'message' => 'Something went wrong while creating the category.',
            ], 400);  // HTTP status code 400 for Bad Request
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $category = Category::find($id);
        if ($category) {

            return response()->json([
                'success' => true,
                'category' => new CategoryResource($category),
            ], 200); // HTTP status code 200 (OK)
        } else {
            return response()->json([
                'success' => false,
                'message' => 'Category not found'
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
    public function update(UpdateCategoryRequest $request, string $id)
    {
        
        $category = Category::find($id);
        if($category){
            $data = $request->validated();
    
            if($request->hasFile('photo')){
                $imagePath = $request->file('photo')->store('categories','public');

                if($category->photo && Storage::disk('public')->exists($category->photo))
                   Storage::disk('public')->delete($category->photo);
             
                $data['photo'] = Storage::url($imagePath);
            }
    
            $data['is_parent'] = $request->has('is_parent') ? 1 : 0;

            $status = $category->update($data);
    
            if($status){
                return response()->json([
                    'success' => true,
                    'message' => 'Category updated successfully.',
                    'data' => new CategoryResource($category),  // Returning the updated category
                ], 200);  // HTTP status code 200 for success update operation
            }
            else{
                return response()->json([
                    'success' => false,
                    'message' => 'Something went wrong while updating the category.',
                ], 400); // HTTP status code 400 for Bad Request
            }
        }
        else{
            return response()->json([
                'success' => false,
                'message' => 'Category not found'
            ], 404); // HTTP status code 404 (Not Found)
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $category = Category::find($id);
        $child_category_id = Category::where('parent_id',$id)->pluck('id')->toArray();
        if($category){
            $status = $category->delete();
            if($status){
                if($category->photo && Storage::disk('public')->exists($category->photo))
                  Storage::disk('public')->delete($category->photo);
                  
                if(count($child_category_id)){
                    Category::shiftChild($child_category_id);
                }
                return response()->json([
                    'success' => true,
                    'message' => 'Category and associated images deleted successfully.'
                ], 200); // HTTP status 200 for successful deletion
            }
            else{
                return response()->json([
                    'success' => false,
                    'message' => 'Something went wrong while deleting the product.'
                ], 500); // HTTP status 500 for internal server error
            }
        }
        else{
            return response()->json([
                'success' => false,
                'message' => 'Category not found.'
            ], 404); // HTTP status 404 for resource not found
        }
    }
}
