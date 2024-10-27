<?php

namespace App\Http\Controllers;

use App\Models\Settings;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use App\Http\Requests\UpdateSettingsRequest;

class SettingsController extends Controller
{
    public function settings(){
        $current_settings = Settings::first();
        return view('backend.settings.settings',compact('current_settings'));
    }

    public function update(UpdateSettingsRequest $request){
        $current_settings = Settings::first();

        $data = $request->validated();

        if($request->hasFile('logo')){
            $imagePath = $request->file('logo')->store('logos','public');

            if($current_settings->logo && Storage::disk('public')->exists($current_settings->logo))
               Storage::disk('public')->delete($current_settings->logo);
            
            $data['logo'] = Storage::url($imagePath);
        }

        if($request->hasFile('favicon')){
            $imagePath = $request->file('favicon')->store('favicons','public');

            if($current_settings->favicon && Storage::disk('public')->exists($current_settings->favicon))
               Storage::disk('public')->delete($current_settings->favicon);
            
            $data['favicon'] = Storage::url($imagePath);
        }

        $status = $current_settings->update($data);

        if($status){
            return back()->with('success','Settings updated successfully.');
        }
        else{
            return back()->with('error','Something went wrong!');
        }

    }
}
