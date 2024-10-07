@extends('backend.layouts.master')

@section('content')

<div id="main-content">
    <div class="container-fluid">
        <div class="block-header">
            <div class="row">
                <div class="col-lg-6 col-md-8 col-sm-12">
                    <h2><a href="javascript:void(0);" class="btn btn-xs btn-link btn-toggle-fullwidth"><i class="fa fa-arrow-left"></i></a>Add Banners</h2>
                    <ul class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{route('admin.dashboard')}}"><i class="icon-home"></i></a></li>                            
                        <li class="breadcrumb-item">Banners</li>
                        <li class="breadcrumb-item active">Add Banners</li>
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
                        <form action="{{route('admin.banners.store')}}" method="POST" enctype="multipart/form-data">
                            @csrf
                            <div class="col-lg-12 col-md-12">
                                <div class="form-group">
                                    <lable for=""> Title <span class="text-danger">*</span></lable>
                                    <input type="text" class="form-control" placeholder="Title" name="title" value="{{old('title')}}">
                                </div>
                            </div>
                            <div class="col-lg-12 col-md-12">
                                <div class="form-group">
                                    <lable for="">Description</lable>
                                    <textarea id="description" name="description" class="form-control" placeholder="Write some text...">{{old('description')}}</textarea>
                                </div>
                            </div>
                            <div class="col-lg-12 col-md-12">
                                <div class="form-group">
                                   <lable for="">Photo <span class="text-danger">*</span></lable>
                                   <br>
                                   <input type="file" name="photo"/>
                                </div>
                            </div>

                            <div class="col-lg-12 col-sm-12">                                
                                <select name="condition" class="form-control show-tick">
                                    <option value="">--Condition--</option>
                                    <option value="banner" {{old('condition')=='banner'?'selected':''}}>Banner</option>
                                    <option value="promotion" {{old('condition')=='promotion'?'selected':''}}>Promotion</option>
                                </select>
                            </div> 
                            <div class="col-lg-12 col-sm-12">                                
                                <select name="status" class="form-control show-tick">
                                    <option value="">--Status--</option>
                                    <option value="active" {{old('status')=='active'?'selected':''}}>Active</option>
                                    <option value="inactive" {{old('status')=='inactive'?'selected':''}}>Inactive</option>
                                </select>
                            </div> 
                            <div class="col-sm-12">
                                <button type="submit" class="btn btn-primary">Submit</button>
                                <button type="submit" class="btn btn-outline-secondary">Cancel</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection

@section('scripts')
<script>
    $(document).ready(function() {
      $('#description').summernote();
    });
</script>
@endsection