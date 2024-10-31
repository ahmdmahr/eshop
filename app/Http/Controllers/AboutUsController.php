<?php

namespace App\Http\Controllers;

use App\Models\AboutUs;
use Illuminate\Http\Request;
use App\Http\Requests\UpdateAboutUsRequest;

class AboutUsController extends Controller
{
    public function aboutUs(){
        $about_us = AboutUs::first();
        return view('backend.about.index',compact('about_us'));
    }

    public function update(UpdateAboutUsRequest $request){
        $about_us = AboutUs::first();
        $data = $request->validated();

        if(array_key_exists('images',$data)){
            $data['image1'] = $data['images'][0];
            $data['image2'] = $data['images'][1];
            $data['image3'] = $data['images'][2];
            $data['image4'] = $data['images'][3];
        }

        $status = $about_us->update($data);

        if($status){
            return back()->with('success','About Us updated successfully.');
        }
        else{
            return back()->with('error','Something went wrong!');
        }
    }
}
