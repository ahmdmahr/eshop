@extends('backend.layouts.master')

@section('content')

<div id="main-content">
    <div class="container-fluid">
        <div class="block-header">
            <div class="row">
                <div class="col-lg-6 col-md-8 col-sm-12">
                    <h2><a href="javascript:void(0);" class="btn btn-xs btn-link btn-toggle-fullwidth"><i class="fa fa-arrow-left"></i></a>Edit Settings</h2>
                </div> 
            </div>
        </div>
        
        <div class="row clearfix">
            <div class="col-md-12">
                @include('backend.layouts.notification')
                
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
                        <form action="{{route('admin.settings.update')}}" method="POST" enctype="multipart/form-data">
                            @csrf
                            @method('PUT')
                            <div class="row clearfix">
                            <div class="col-lg-12 col-md-12">
                                <div class="form-group">
                                    <lable for=""> App Title <span class="text-danger">*</span></lable>
                                    <input type="text" class="form-control" placeholder="Title" name="title" value="{{$current_settings->title}}">
                                </div>
                            </div>
                            <div class="col-lg-12 col-md-12">
                                <div class="form-group">
                                    <lable for="">Meta Description</lable>
                                    <textarea name="meta_description"  rows="5" class="form-control" placeholder="Write some text...">{{$current_settings->meta_description}}</textarea>
                                </div>
                            </div>
                            <div class="col-lg-12 col-md-12">
                                <div class="form-group">
                                    <lable for="">Meta Keywords</lable>
                                    <textarea name="meta_keywords" rows="5" class="form-control" placeholder="Write some keywords...">{{$current_settings->meta_keywords}}</textarea>
                                </div>
                            </div>
                            <div class="col-lg-6 col-md-12">
                                <div class="form-group">
                                   <lable for="">Logo <span class="text-danger">*</span></lable>
                                   <br>
                                   <input type="file" name="logo"/>
                                   <br><br>
                                   <img src="{{$current_settings->logo}}" alt="logo photo" style="max-height:150px;
                                   max-width:150px">
                                </div>
                            </div>

                            <div class="col-lg-6 col-md-12">
                                <div class="form-group">
                                   <lable for="">Favicon <span class="text-danger">*</span></lable>
                                   <br>
                                   <input type="file" name="favicon"/>
                                   <img src="{{$current_settings->favicon}}" alt="favicon photo" style="max-height:150px;
                                   max-width:150px">
                                </div>
                            </div>

                            <div class="col-lg-12 col-md-12">
                                <div class="form-group">
                                    <lable for="">Email <span class="text-danger">*</span></lable>
                                    <input type="text" class="form-control" placeholder="ahmadmaher@eshop.io" name="email" value="{{$current_settings->email}}">
                                </div>
                            </div>

                            <div class="col-lg-12 col-md-12">
                                <div class="form-group">
                                    <lable for="">Phone <span class="text-danger">*</span></lable>
                                    <input type="text" class="form-control" placeholder="+987654321" name="phone" value="{{$current_settings->phone}}">
                                </div>
                            </div>

                            <div class="col-lg-12 col-md-12">
                                <div class="form-group">
                                    <lable for="">Address <span class="text-danger">*</span></lable>
                                    <input type="text" class="form-control" placeholder="Cairo,Egypt" name="address" value="{{$current_settings->address}}">
                                </div>
                            </div>

                            <div class="col-lg-12 col-md-12">
                                <div class="form-group">
                                    <lable for="">Fax <span class="text-danger">*</span></lable>
                                    <input type="text" class="form-control" placeholder="903 5838 294923" name="fax" value="{{$current_settings->fax}}">
                                </div>
                            </div>

                            <div class="col-lg-12 col-md-12">
                                <div class="form-group">
                                    <lable for="">Footer <span class="text-danger">*</span></lable>
                                    <input type="text" class="form-control" placeholder="Google .inc" name="footer" value="{{$current_settings->footer}}">
                                </div>
                            </div>

                            <div class="col-lg-12 col-md-12">
                                <div class="form-group">
                                    <lable for="">Facebook</lable>
                                    <input type="text" class="form-control" placeholder="link/id=?" name="facebook" value="{{$current_settings->facebook}}">
                                </div>
                            </div>

                            <div class="col-lg-12 col-md-12">
                                <div class="form-group">
                                    <lable for="">Twitter</lable>
                                    <input type="text" class="form-control" placeholder="link/id=?" name="twitter" value="{{$current_settings->twitter}}">
                                </div>
                            </div>

                            <div class="col-lg-12 col-md-12">
                                <div class="form-group">
                                    <lable for="">Linkedin</lable>
                                    <input type="text" class="form-control" placeholder="link/id=?" name="linkedin" value="{{$current_settings->linkedin}}">
                                </div>
                            </div>

                            <div class="col-lg-12 col-md-12">
                                <div class="form-group">
                                    <lable for="">Pinterest</lable>
                                    <input type="text" class="form-control" placeholder="link/id=?" name="pinterest" value="{{$current_settings->pinterest}}">
                                </div>
                            </div>

                        </div>
                        <button type="submit" class="btn btn-primary">Update</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection
