<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Banner;
use App\Models\Category;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use App\Http\Requests\StoreCategoryRequest;
use App\Http\Requests\UpdateCategoryRequest;

class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $categories = Category::orderBy('id','DESC')->get();
        return view('backend.categories.index',compact('categories'));
    }

    public function changeStatus(Request $request){
        $category = DB::table('categories')->where('id',$request->input('id'))->first();
        if($category->status == 'inactive'){
            DB::table('categories')->where('id', $request->input('id'))->update(['status' => 'active']);
        }
        else{
            DB::table('categories')->where('id', $request->input('id'))->update(['status' => 'inactive']);
        }
        return response()->json(['success'=>'Status updated successfully','status'=>true]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $parent_categories = Category::where('is_parent',1)->orderBy('title','ASC')->get();
        return view('backend.categories.create',compact('parent_categories'));
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

        $status = Category::create($data);

        if($status){
            return redirect()->route('admin.categories.index')->with('success','Category created successfully.');
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
        $category = Category::find($id);
        $parent_categories = Category::where('is_parent',1)->orderBy('title','ASC')->get();
        if($category){
          return view('backend.categories.edit',compact('category','parent_categories'));
        }
        else{
            return back()->with('error','Category not found!');
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateCategoryRequest $request, string $id)
    {
        // return $request->all();

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
                return redirect()->route('admin.categories.index')->with('success','Category updated successfully.');
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
                return redirect()->route('admin.categories.index')->with('success','Categroy deleted successfully');
            }
            else{
                return back()->with('error','Something went wrong');
            }
        }
        else{
            return back()->with('error','Data not found');
        }
    }

    public function getChildByParentID(Request $request,$id){
        // dd($request->all());
        // dd($id);

        $category = Category::find($request->id);
        if($category){
            $child_id = Category::getChildByParentID($id);
            // dd($child_id);
            if(count($child_id)>0){
                return response()->json(['status'=>true,'data'=>$child_id,'msg'=>'']);
            }
            else{
                return response()->json(['status'=>false,'data'=>'null','msg'=>'']);
            }
        }
        else{
            return response()->json(['status'=>false,'data'=>'null','msg'=>'Category not found']);
        }
    }
}
