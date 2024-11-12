<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use App\Http\Requests\StoreUserRequest;
use App\Http\Requests\UpdateUserRequest;
use Illuminate\Support\Facades\Storage;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $users = User::orderBy('id','DESC')->get();
        return view('backend.users.index',compact('users'));
    }

    

    public function changeStatus(Request $request){
        $user = DB::table('users')->where('id',$request->input('id'))->first();
        if($user->status == 'inactive'){
            DB::table('users')->where('id', $request->input('id'))->update(['status' => 'active']);
        }
        else{
            DB::table('users')->where('id', $request->input('id'))->update(['status' => 'inactive']);
        }
        return response()->json(['success'=>'Status updated successfully','status'=>true]);
    }

    public function changeVerification(Request $request){
        $user = DB::table('users')->where('id',$request->input('id'))->first();
        if($user->is_verified == 1){
            DB::table('users')->where('id', $request->input('id'))->update(['is_verified' => 0]);
        }
        else{
            DB::table('users')->where('id', $request->input('id'))->update(['is_verified' => 1]);
        }
        
        return response()->json(['success'=>"Verification updated successfully",'status'=>true]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('backend.users.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreUserRequest $request)
    {
        $data = $request->validated();

        $data['password'] = Hash::make($data['password']);

        if($request->hasFile('photo')) {
            $imagePath = $request->file('photo')->store('users', 'public');
            $data['photo'] = Storage::url($imagePath);
        }
        

        $status = User::create($data);

        if($status){
            return redirect()->route('admin.users.index')->with('success','User created successfully.');
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
        $user = User::find($id);
        if($user){
          return view('backend.users.edit',compact('user'));
        }
        else{
            return back()->with('error','User not found!');
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateUserRequest $request, string $id)
    {
        $user = User::find($id);
        if($user){
            $data = $request->validated();
    
            if($request->hasFile('photo')){
                $imagePath = $request->file('photo')->store('users','public');

                if($user->photo && Storage::disk('public')->exists($user->photo))
                    Storage::disk('public')->delete($user->photo);
             
                $data['photo'] = Storage::url($imagePath);
            }
    
            $status = $user->update($data);
    
            if($status){
                return redirect()->route('admin.users.index')->with('success','User updated successfully.');
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
        $user = User::find($id);
        if($user){
            if($user->photo && Storage::disk('public')->exists($user->photo))
               Storage::disk('public')->delete($user->photo);
               
            $status = $user->delete();
            if($status){
                return redirect()->route('admin.users.index')->with('success','User deleted successfully');
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
