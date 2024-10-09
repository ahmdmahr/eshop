@extends('backend.layouts.master')

@section('content')

<div id="main-content">
    <div class="container-fluid">
        <div class="block-header">
            <div class="row">
                <div class="col-lg-6 col-md-8 col-sm-12">
                    <h2><a href="javascript:void(0);" class="btn btn-xs btn-link btn-toggle-fullwidth"><i class="fa fa-arrow-left"></i></a>Add Products</h2>
                    <ul class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{route('admin.dashboard')}}"><i class="icon-home"></i></a></li>                            
                        <li class="breadcrumb-item">Products</li>
                        <li class="breadcrumb-item active">Add Products</li>
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
                        <form action="{{route('admin.products.store')}}" method="POST" enctype="multipart/form-data">
                            @csrf
                            <div class="row clearfix">
                            <div class="col-lg-12 col-md-12">
                                <div class="form-group">
                                    <lable for=""> Title <span class="text-danger">*</span></lable>
                                    <input type="text" class="form-control" placeholder="Title" name="title" value="{{old('title')}}">
                                </div>
                            </div>
                            <div class="col-lg-12 col-md-12">
                                <div class="form-group">
                                    <lable for="">Summary <span class="text-danger">*</span></lable>
                                    <textarea id="summary" name="summary" class="form-control" placeholder="Write some text...">{{old('summary')}}</textarea>
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
                                    <lable for=""> Stock <span class="text-danger">*</span></lable>
                                    <input type="number" class="form-control" placeholder="Stock" name="stock" value="{{old('stock')}}">
                                </div>
                            </div>
                            <div class="col-lg-12 col-md-12">
                                <div class="form-group">
                                    <lable for=""> Price <span class="text-danger">*</span></lable>
                                    {{-- step="any" for writing floats --}}
                                    <input type="number" step="any" class="form-control" placeholder="Price" name="price" value="{{old('price')}}">
                                </div>
                            </div>
                            <div class="col-lg-12 col-md-12">
                                <div class="form-group">
                                    <lable for=""> Discount </lable>
                                    <input type="number" step="any" class="form-control" placeholder="Discount" name="discount" value="{{old('discount')}}">
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
                                <label for="">Brand</label>                            
                                <select name="brand_id" class="form-control show-tick">
                                    <option value="">--Brand--</option>
                                    @foreach ($brands as $item)
                                        <option value="{{$item->id}} {{old('brand_id') == $item->id ? 'selected':''}}">{{$item->title}}</option>
                                    @endforeach
                                </select>
                            </div> 
                            <div class="col-lg-12 col-sm-12">     
                                <label for="">Category</label>                            
                                <select id="category_id" name="category_id" class="form-control show-tick">
                                    <option value="">--Category--</option>
                                    @foreach ($parent_categories as $item)
                                        <option value="{{$item->id}}" {{old('category_id') == $item->id ? 'selected':''}}>{{$item->title}}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-lg-12 col-sm-12 d-none" id="category_child">     
                                <label for="">Category Child</label>                            
                                <select id="category_child_id" name="category_child_id" class="form-control show-tick">
                                </select>
                            </div>
                            <div class="col-lg-12 col-sm-12">     
                                <label for="">Size</label>                            
                                <select name="size" class="form-control show-tick">
                                    <option value="">--Size--</option>
                                    <option value="S" {{old('size')=='S'?'selected':''}}>Small</option>
                                    <option value="M" {{old('size')=='M'?'selected':''}}>Medium</option>
                                    <option value="L" {{old('size')=='L'?'selected':''}}>Large</option>
                                    <option value="XL" {{old('size')=='XL'?'selected':''}}>Extra Large</option>
                                </select>
                            </div> 
                            <div class="col-lg-12 col-sm-12">     
                                <label for="">Condition</label>                            
                                <select name="condition" class="form-control show-tick">
                                    <option value="">--Condition--</option>
                                    <option value="new" {{old('condition')=='new'?'selected':''}}>New</option>
                                    <option value="popular" {{old('condition')=='popular'?'selected':''}}>Popular</option>
                                    <option value="winter" {{old('condition')=='Winter'?'selected':''}}>Winter</option>
                                </select>
                            </div> 
                            <div class="col-lg-12 col-sm-12">     
                                <label for="">Vendor</label>                            
                                <select name="vendor_id" class="form-control show-tick">
                                    <option value="">--Vendor--</option>
                                    @foreach ($vendors as $item)
                                        <option value="{{$item->id}}" {{old('vendor_id') == $item->id ? 'selected':''}}>{{$item->full_name}}</option>
                                    @endforeach
                                </select>
                            </div> 
                            <div class="col-lg-12 col-sm-12">    
                                <label for="status">Status</label>                            
                                <select name="status" class="form-control show-tick">
                                    <option value="">--Status--</option>
                                    <option value="active" {{old('status')=='active'?'selected':''}}>Active</option>
                                    <option value="inactive" {{old('status')=='inactive'?'selected':''}}>Inactive</option>
                                </select>
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

@section('scripts')
<script>
    $(document).ready(function() {
      $('#description').summernote();
    });
</script>

<script>
    $(document).ready(function() {
      $('#summary').summernote();
    });
</script>
<script>
    $('#category_id').change(function(){
            var category_id=$(this).val();
            // alert(category_id);
            if(category_id != null){
                $.ajax({
                    url:"{{route('admin.categories.getchild',':id') }}".replace(':id', category_id),
                    type:"GET",
                    data:{
                        _token:"{{csrf_token()}}",
                        category_id:category_id
                    },
                    success:function(response){
                       var html_option=`<option value="">--Child Category--</option>`;
                       if(response.status){
                           $('#category_child').removeClass('d-none');
                           /*
                             id: This represents the key in the response.data object (the category ID).
                             title: This represents the value (the category title).
                           */
                           $.each(response.data,function(id,title){
                            html_option += `<option value="${id}"> ${title} </option>`;
                           });
                       }
                       else{
                          $('#category_child').addClass('d-none');
                       }
                       $('#category_child_id').html(html_option);
                    }
                });
            }
    });
</script>
@endsection