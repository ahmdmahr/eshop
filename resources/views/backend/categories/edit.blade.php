@extends('backend.layouts.master')

@section('content')

<div id="main-content">
    <div class="container-fluid">
        <div class="block-header">
            <div class="row">
                <div class="col-lg-6 col-md-8 col-sm-12">
                    <h2><a href="javascript:void(0);" class="btn btn-xs btn-link btn-toggle-fullwidth"><i class="fa fa-arrow-left"></i></a>Edit Categories</h2>
                    <ul class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{route('admin.dashboard')}}"><i class="icon-home"></i></a></li>                            
                        <li class="breadcrumb-item">Categories</li>
                        <li class="breadcrumb-item active">Edit Categories</li>
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
                        <form action="{{route('admin.categories.update',$category->id)}}" method="POST" enctype="multipart/form-data">
                            @csrf
                            @method('PUT')
                            <div class="row clearfix">
                                <div class="col-lg-12 col-md-12">
                                    <div class="form-group">
                                        <lable for=""> Title <span class="text-danger">*</span></lable>
                                        <input type="text" class="form-control" placeholder="Title" name="title" value="{{$category->title}}">
                                    </div>
                                </div>
                                <div class="col-lg-12 col-md-12">
                                    <div class="form-group">
                                        <lable for="">Summary</lable>
                                        <textarea id="summary" name="summary" class="form-control" placeholder="Write some text...">{{$category->summary}}</textarea>
                                    </div>
                                </div>
                                <div class="col-lg-12 col-md-12">
                                    <div class="form-group">
                                       <lable for="">Photo <span class="text-danger">*</span></lable>
                                       <br>
                                       <input type="file" name="photo">
                                       <br><br>
                                       <img src="{{$category->photo}}" alt="category photo" style="max-height:150px;
                                        max-width:150px">
                                    </div>
                                </div>
    
                                <div class="col-lg-12 col-md-12">
                                    <div class="form-group">
                                        <lable for="">Is Parent : </lable>
                                        <input id="is_parent" type="checkbox" name="is_parent" value="{{$category->is_parent}}"  {{$category->is_parent == 1?'checked':''}}> Yes
                                    </div>
                                </div>
    
                                <div class="col-lg-12 col-sm-12 d-none" id="parent_category">  
                                    <label for="parent_id">Parent Category</label>                              
                                    <select name="parent_id" class="form-control show-tick">
                                        <option value="">--Parent Category--</option>
                                        @foreach ($parent_categories as $pcat)
                                            <option value="{{$pcat->id}}" {{$pcat->id == $category->parent_id?'selected':''}}>{{$pcat->title}}</option>
                                        @endforeach
                                    </select>
                                </div> 
                            </div>    
                            <button type="submit" class="btn btn-primary">Update</button>
                            <button type="submit" class="btn btn-outline-secondary">Cancel</button>
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
      $('#summary').summernote();
    });
</script>
<script>
    $('#is_parent').change(function(e){
        e.preventDefault();
        var is_checked=$('#is_parent').prop('checked');
        // alert(is_checked);
        if(is_checked){
            $('#parent_category').addClass('d-none');
            $('#parent_category').val('');
        }
        else{
            $('#parent_category').removeClass('d-none');
        }
    });
</script>
@endsection