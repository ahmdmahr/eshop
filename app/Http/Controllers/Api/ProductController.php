<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Product;
use Illuminate\Support\Str;
use App\Models\ProductImage; 
use App\Models\ProductAttribute;
use Illuminate\Support\Facades\Storage;
use App\Http\Requests\StoreProductRequest;
use App\Http\Requests\UpdateProductRequest;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $products = Product::orderBy('id','DESC')->get();
        if ($products->isEmpty()) {
            return response()->json([
                'success' => false,
                'message' => 'No products found.'
            ], 404); // Return 404 if no products are found
        }
    
        return response()->json([
            'success' => true,
            'message' => 'Products retrieved successfully.',
            'data' => $products
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
    public function store(StoreProductRequest $request)
    {
        $data = $request->validated();
        // dd($data);
        $slug = Str::slug($request->input('title'));
        $slug_count = Product::where('slug',$slug)->count();
        if($slug_count>0){
            $slug = time().'-'.$slug;
        }
        $data['slug'] = $slug;

        $offer_price = $data['price']-($data['price']*($data['discount']/100));

        $data['offer_price'] = $offer_price;

         // Create the product first
         $product = Product::create($data);

         // Handle multiple images
         if ($request->hasFile('images')) {
             foreach ($request->file('images') as $image) {
                 $imagePath = $image->store('products', 'public');
                 ProductImage::create([
                     'product_id' => $product->id,
                     'url' => Storage::url($imagePath), // Save the public URL
                 ]);
             }
         }
        if ($product) {
            return response()->json([
                'success' => true,
                'message' => 'Product created successfully.',
                'data' => $product,  // Returning the newly created product
            ], 201);  // HTTP status code 201 indicates 'Created'
        } else {
            return response()->json([
                'success' => false,
                'message' => 'Something went wrong while creating the product.',
            ], 400);  // HTTP status code 400 for Bad Request
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $product = Product::find($id);
        if ($product) {
            $productAttributes = ProductAttribute::where('product_id', $id)->orderBy('id', 'DESC')->get();

            return response()->json([
                'success' => true,
                'product' => $product,
                'product_attributes' => $productAttributes
            ], 200); // HTTP status code 200 (OK)
        } else {
            return response()->json([
                'success' => false,
                'message' => 'Product not found'
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
    public function update(UpdateProductRequest $request, string $id)
    {
        $product = Product::find($id);
        if($product){
            $data = $request->validated();
            if ($request->hasFile('images')) {
                // Delete old images from storage
                foreach ($product->images as $image) {
                    if ($image->url && Storage::disk('public')->exists($image->url)) {
                        Storage::disk('public')->delete($image->url);
                    }
                }
                // Clear old images from the database
                ProductImage::where('product_id', $product->id)->delete(); // Clear old images
                // Store new images
                foreach($request->file('images') as $image) {
                    $imagePath = $image->store('products', 'public');
                    ProductImage::create([
                        'product_id' => $product->id,
                        'url' => Storage::url($imagePath), // Save the public URL
                    ]);
                }
            }

            $offer_price = $data['price']-($data['price']*($data['discount']/100));

            $data['offer_price'] = $offer_price;
    
            $status = $product->update($data);
    
            if($status){
                return response()->json([
                    'success' => true,
                    'message' => 'Product updated successfully.',
                    'data' => $product,  // Returning the updated product
                ], 200);  // HTTP status code 200 for success update operation
            }
            else{
                return response()->json([
                    'success' => false,
                    'message' => 'Something went wrong while updating the product.',
                ], 400); // HTTP status code 400 for Bad Request
            }
        }
        else{
            return response()->json([
                'success' => false,
                'message' => 'Product not found'
            ], 404); // HTTP status code 404 (Not Found)
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $product = Product::find($id);
        if($product){
            foreach ($product->images as $image) {
                if ($image->url && Storage::disk('public')->exists($image->url)) {
                    Storage::disk('public')->delete($image->url);
                }
            }
               
            ProductImage::where('product_id', $product->id)->delete();

            $status = $product->delete();
            
            if ($status) {
                return response()->json([
                    'success' => true,
                    'message' => 'Product and associated images deleted successfully.'
                ], 200); // HTTP status 200 for successful deletion
            } else {
                return response()->json([
                    'success' => false,
                    'message' => 'Something went wrong while deleting the product.'
                ], 500); // HTTP status 500 for internal server error
            }
        }
        else {
            return response()->json([
                'success' => false,
                'message' => 'Product not found.'
            ], 404); // HTTP status 404 for resource not found
        }
    }
}
