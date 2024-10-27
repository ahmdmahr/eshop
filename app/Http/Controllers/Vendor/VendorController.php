<?php

namespace App\Http\Controllers\Vendor;


use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class VendorController extends Controller
{
    public function index(){
        return view('vendor.index');
    }
}
