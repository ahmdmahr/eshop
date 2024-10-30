<?php

namespace App\Http\Controllers\Vendor;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Brand;
use App\Models\Product;
use App\Models\Category;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Models\ProductImage; 
use App\Models\ProductAttribute;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use App\Http\Requests\StoreProductRequest;
use App\Http\Requests\AddAttributesRequest;
use App\Http\Requests\UpdateProductRequest;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $products = Product::where(['status'=>'active','vendor_id'=>auth()->user()->id])->get();
        return view('seller.products.index',compact('products'));
    }

    public function changeStatus(Request $request){
        $product = DB::table('products')->where('id',$request->input('id'))->first();
        if($product->status == 'inactive'){
            DB::table('products')->where('id', $request->input('id'))->update(['status' => 'active']);
        }
        else{
            DB::table('products')->where('id', $request->input('id'))->update(['status' => 'inactive']);
        }
        return response()->json(['success'=>'Status updated successfully','status'=>true]);
    }
    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        if(auth()->user()->is_verified){
            $brands = Brand::get();
            $parent_categories = Category::where('is_parent', 1)->get();
            $child_categories = Category::where('is_parent', 0)->get();
            $vendors = User::where('role','vendor')->get();
            return view('seller.products.create',compact('brands','parent_categories','child_categories','vendors'));
        }
        else{
            return back()->with('error','You need to verfiy your account first');
        }
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreProductRequest $request)
    {
        $data = $request->validated();
        
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

        if($product){
            return redirect()->route('vendor.products.index')->with('success','Product created successfully.');
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
        $product = Product::find($id);
        $productAttributes = ProductAttribute::where('product_id',$id)->orderBy('id','DESC')->get();
        if($product){
            return view('seller.products.product-attributes',compact('product','productAttributes'));
        }
        else{
            return back()->with('error','Product not found');
        }
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        if(auth()->user()->is_verified){
            $brands = Brand::get();
            $parent_categories = Category::where('is_parent', 1)->get();
            $child_categories = Category::where('is_parent', 0)->get();
            $vendors = User::where('role','vendor')->get();
            $product = Product::find($id);
            if($product){
            return view('seller.products.edit',compact('product','brands','parent_categories','child_categories','vendors'));
            }
            else{
                return back()->with('error','Product not found!');
            }
        }
        else{
            return back()->with('error','You need to verfiy your account first');
        }
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
                return redirect()->route('vendor.products.index')->with('success','Product updated successfully.');
            }
            else{
                return back()->with('error','Something went wrong!');
            }
        }
        else{
            return back()->with('error','Category not found!');
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
            
            if($status){
                return redirect()->route('vendor.products.index')->with('success','Product deleted successfully');
            }
            else{
                return back()->with('error','Something went wrong');
            }
        }
        else{
            return back()->with('error','Data not found');
        }
    }

    //Enable AddAttributesRequest later
    public function addAttributes(Request $request,$id){
        // return $request->all();
        $data = $request->all();
        foreach($data['price'] as $key => $price){
            $attributes = [];

            $attributes['product_id'] = $id;
            $attributes['size'] = $data['size'][$key];
            $attributes['price'] = $price;
            $attributes['offer_price'] = $data['offer_price'][$key];
            $attributes['stock'] = $data['stock'][$key];

            ProductAttribute::create($attributes);
        }
        return redirect()->back()->with('success','Products attributes added successfully!');
    }

    public function deleteAttribute($product_id,$attribute_id){
        $productAttribute = ProductAttribute::find($attribute_id);
        if($productAttribute){
            $status = $productAttribute->delete();
            
            if($status){
                return redirect()->route('vendor.products.show',$product_id)->with('success','Product  attribute deleted successfully');
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
