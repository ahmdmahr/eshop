<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
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

    public function updateSettings(UpdateSettingsRequest $request){
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

    // Simple Mail Transfer Protocol -> SMTP
    public function smtp(){
        return view('backend.settings.smtp');
    }

    public function overWriteEnvFile($variable,$value){
        $path = base_path('.env');
        if(file_exists($path)){
            $value = "\"".trim($value)."\"";
            if(strpos(file_get_contents($path),$variable)>0){
                file_put_contents($path,str_replace(
                    $variable."=\"".env($variable)."\"",$variable."=".$value,file_get_contents($path)
                ));
            }
            else{
                file_put_contents($path,file_get_contents($path)."\r\n".$variable."=".$value);
            }
        }
    }

    public function updateSmtp(Request $request){
        // return ($request->all());
        foreach($request->env as $variable){
            $this->overWriteEnvFile($variable,$request[$variable]);
        }
        return back()->with('success','SMTP configuration updated successfully!');
    }

    public function payment(){
        return view('backend.settings.payment');
    }

    public function updatePaypalSettings(Request $request){
        // return $request->all();
        foreach($request->paypal as $variable){
            $this->overWriteEnvFile($variable,$request[$variable]);
        }
        $settings = Settings::first();
        if($request->has('paypal_sandbox')){
            $settings->paypal_sandbox = 1;
        }
        else{
            $settings->paypal_sandbox = 0;
        }
        $settings->save();
        return back()->with('success','Paypal settings updated successfully');
    }
}
