@extends('backend.layouts.master')

@section('content')

<div id="main-content">
    <div class="container-fluid">
        <div class="block-header">
            <div class="row">
                <div class="col-lg-6 col-md-8 col-sm-12">
                    <h2><a href="javascript:void(0);" class="btn btn-xs btn-link btn-toggle-fullwidth"><i class="fa fa-arrow-left"></i></a>Edit About Us</h2>
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
                        <form action="{{route('admin.about.us.update')}}" method="POST" enctype="multipart/form-data">
                            @csrf
                            @method('PUT')
                            <div class="row clearfix">
                            <div class="col-lg-12 col-md-12">
                                <div class="form-group">
                                    <lable for="">Heading <span class="text-danger">*</span></lable>
                                    <input type="text" class="form-control" placeholder="Heading" name="heading" value="{{$about_us->heading}}">
                                </div>
                            </div>
                            <div class="col-lg-12 col-md-12">
                                <div class="form-group">
                                    <lable for="">Content</lable>
                                    <textarea name="content"  rows="5" class="form-control" placeholder="Write some text...">{{$about_us->content}}</textarea>
                                </div>
                            </div>
                            <div class="col-lg-12 col-md-12">
                                <div class="form-group">
                                   <lable for="">Image <span class="text-danger">*</span></lable>
                                   <br>
                                   <input type="file" name="images[]"/>
                                   <br><br>
                                   <img src="{{asset($about_us->image1)}}" alt="about us photo" style="max-height:150px;
                                   max-width:150px">
                                </div>
                            </div>


                            <div class="col-lg-6 col-md-12">
                                <div class="form-group">
                                    <lable for="">Years of Experience <span class="text-danger">*</span></lable>
                                    <input type="text" class="form-control" placeholder="4" name="years_of_experience" value="{{$about_us->years_of_experience}}">
                                </div>
                            </div>

                            <div class="col-lg-6 col-md-12">
                                <div class="form-group">
                                    <lable for="">Happy Customers <span class="text-danger">*</span></lable>
                                    <input type="text" class="form-control" placeholder="200" name="happy_customers" value="{{$about_us->happy_customers}}">
                                </div>
                            </div>

                            <div class="col-lg-6 col-md-12">
                                <div class="form-group">
                                    <lable for="">Parteners <span class="text-danger">*</span></lable>
                                    <input type="text" class="form-control" placeholder="80" name="parteners" value="{{$about_us->parteners}}">
                                </div>
                            </div>

                            <div class="col-lg-6 col-md-12">
                                <div class="form-group">
                                    <lable for="">Growth <span class="text-danger">*</span></lable>
                                    <input type="text" class="form-control" placeholder="64%" name="growth" value="{{$about_us->growth}}">
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
