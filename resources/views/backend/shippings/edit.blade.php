@extends('backend.layouts.master')

@section('content')

<div id="main-content">
    <div class="container-fluid">
        <div class="block-header">
            <div class="row">
                <div class="col-lg-6 col-md-8 col-sm-12">
                    <h2><a href="javascript:void(0);" class="btn btn-xs btn-link btn-toggle-fullwidth"><i class="fa fa-arrow-left"></i></a>Edit Shippings Mehtods</h2>
                    <ul class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{route('admin.dashboard')}}"><i class="icon-home"></i></a></li>                            
                        <li class="breadcrumb-item">Shippings Mehtods</li>
                        <li class="breadcrumb-item active">Edit Shipping Mehtod</li>
                    </ul>
                </div> 
            </div>
        </div>
        
        <div class="row clearfix">
            <div class="col-md-12">
                @if($errors->any())
                <div class="alert alert-danger">
                    <ul>
                        @foreach ($errors->all() as $error)
                           <ul>{{$error}}</ul>
                       @endforeach
                    </ul>
                </div>
                @endif
            </div>
            <div class="col-lg-12 col-md-12 col-sm-12">
                <div class="card">
                    <div class="body">
                        <form action="{{route('admin.shippings.update',$shipping->id)}}" method="POST" enctype="multipart/form-data">
                            @csrf
                            @method('PUT')
                            <div class="row clearfix">
                            <div class="col-lg-12 col-md-12">
                                <div class="form-group">
                                    <lable for="">Shipping Method<span class="text-danger">*</span></lable>
                                    <input type="text" class="form-control" placeholder="Shipping Method" name="shipping_method" value="{{$shipping->shipping_method}}">
                                </div>
                            </div>
                            <div class="col-lg-12 col-md-12">
                                <div class="form-group">
                                    <lable for="">Delivery Time<span class="text-danger">*</span></lable>
                                    <input type="text" class="form-control" placeholder="Delivery Time" name="delivery_time" value="{{$shipping->delivery_time}}">
                                </div>
                            </div>
                            <div class="col-lg-12 col-md-12">
                                <div class="form-group">
                                    <lable for="">Delivery Charge</lable>
                                    <input type="number" step="any" class="form-control" placeholder="Delivery Charge" name="delivery_charge" value="{{$shipping->delivery_charge}}">
                                </div>
                            </div>
                         </div>
                         <button type="submit" class="btn btn-primary">Submit</button>
                        <button type="submit" class="btn btn-outline-secondary">Cancel</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection

