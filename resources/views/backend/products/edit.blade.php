@extends('backend.layouts.master')

@section('content')

<div id="main-content">
    <div class="container-fluid">
        <div class="block-header">
            <div class="row">
                <div class="col-lg-6 col-md-8 col-sm-12">
                    <h2><a href="javascript:void(0);" class="btn btn-xs btn-link btn-toggle-fullwidth"><i class="fa fa-arrow-left"></i></a>Edit Products</h2>
                    <ul class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{route('admin.dashboard')}}"><i class="icon-home"></i></a></li>                            
                        <li class="breadcrumb-item">Products</li>
                        <li class="breadcrumb-item active">Edit Products</li>
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
                        <form action="{{route('admin.products.update',$product->id)}}" method="POST" enctype="multipart/form-data">
                            @csrf
                            @method('PUT')
                            <div class="row clearfix">
                            <div class="col-lg-12 col-md-12">
                                <div class="form-group">
                                    <lable for=""> Title <span class="text-danger">*</span></lable>
                                    <input type="text" class="form-control" placeholder="Title" name="title" value="{{$product->title}}">
                                </div>
                            </div>
                            <div class="col-lg-12 col-md-12">
                                <div class="form-group">
                                    <lable for="">Summary <span class="text-danger">*</span></lable>
                                    <textarea id="summary" name="summary" class="form-control" placeholder="Write some text...">{{$product->summary}}</textarea>
                                </div>
                            </div>
                            <div class="col-lg-12 col-md-12">
                                <div class="form-group">
                                    <lable for="">Description</lable>
                                    <textarea id="description" name="description" class="form-control" placeholder="Write some text...">{{$product->description}}</textarea>
                                </div>
                            </div>
                            <div class="col-lg-12 col-md-12">
                                <div class="form-group">
                                    <lable for=""> Stock <span class="text-danger">*</span></lable>
                                    <input type="number" class="form-control" placeholder="Stock" name="stock" value="{{$product->stock}}">
                                </div>
                            </div>
                            <div class="col-lg-12 col-md-12">
                                <div class="form-group">
                                    <lable for=""> Price <span class="text-danger">*</span></lable>
                                    {{-- step="any" for writing floats --}}
                                    <input type="number" step="any" class="form-control" placeholder="Price" name="price" value="{{$product->price}}">
                                </div>
                            </div>
                            <div class="col-lg-12 col-md-12">
                                <div class="form-group">
                                    <lable for=""> Discount </lable>
                                    <input type="number" step="any" class="form-control" placeholder="Discount" name="discount" value="{{$product->discount}}">
                                </div>
                            </div>
                            <div class="col-lg-12 col-md-12">
                                <div class="form-group">
                                   <lable for="">Photo <span class="text-danger">*</span></lable>
                                   <br>
                                   <input type="file" name="images[]" multiple>
                                   <br><br>
                                   <img src="{{$product->images->first()->url}}" alt="product image" style="max-height:150px;
                                   max-width:150px">
                                </div>
                            </div>
                            <div class="col-lg-12 col-sm-12">     
                                <label for="">Brand</label>                            
                                <select name="brand_id" class="form-control show-tick">
                                    <option value="">--Brand--</option>
                                    @foreach ($brands as $item)
                                        <option value="{{$item->id}}" {{$item->id == $product->brand_id ? 'selected':''}}>{{$item->title}}</option>
                                    @endforeach
                                </select>
                            </div> 
                            <div class="col-lg-12 col-sm-12">     
                                <label for="">Category</label>                            
                                <select id="category_id" name="category_id" class="form-control show-tick">
                                    <option value="">--Category--</option>
                                    @foreach ($parent_categories as $item)
                                        <option value="{{$item->id}}" {{$item->id == $product->category_id ? 'selected':''}}>{{$item->title}}</option>
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
                                    <option value="" >--Size--</option>
                                    <option value="S" {{$product->size=='S'?'selected':''}}>Small</option>
                                    <option value="M" {{$product->size=='M'?'selected':''}}>Medium</option>
                                    <option value="L" {{$product->size=='L'?'selected':''}}>Large</option>
                                    <option value="XL" {{$product->size=='XL'?'selected':''}}>Extra Large</option>
                                </select>
                            </div> 
                            <div class="col-lg-12 col-sm-12">     
                                <label for="">Condition</label>                            
                                <select name="condition" class="form-control show-tick">
                                    <option value="">--Condition--</option>
                                    <option value="new" {{$product->condition=='new'?'selected':''}}>New</option>
                                    <option value="popular" {{$product->condition=='popular'?'selected':''}}>Popular</option>
                                    <option value="winter" {{$product->condition=='Winter'?'selected':''}}>Winter</option>
                                </select>
                            </div> 
                            <div class="col-lg-12 col-sm-12">     
                                <label for="">Vendor</label>                            
                                <select name="vendor_id" class="form-control show-tick">
                                    <option value="">--Vendor--</option>
                                    @foreach ($vendors as $item)
                                        <option value="{{$item->id}}" {{$item->id == $product->vendor_id ? 'selected':''}}>{{$item->full_name}}</option>
                                    @endforeach
                                </select>
                            </div> 
                            <div class="col-lg-12 col-sm-12">    
                                <label for="status">Status</label>                            
                                <select name="status" class="form-control show-tick">
                                    <option value="">--Status--</option>
                                    <option value="active" {{$product->status=='active'?'selected':''}}>Active</option>
                                    <option value="inactive" {{$product->status=='inactive'?'selected':''}}>Inactive</option>
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
      $('#description').summernote();
    });
</script>

<script>
    $(document).ready(function() {
      $('#summary').summernote();
    });
</script>
<script>
    /* 
    When the Blade template is compiled, it converts the PHP expression into its output.
    If the variable is NULL, Blade simply doesn't output anything for that variable.
    so we use ?? operator to set null if there's no value
   */

    var category_child_id = {{$product->category_child_id ?? 'null'}};
    
    $('#category_id').change(function(){
            var category_id=$(this).val();
            // alert(category_id);
            if(category_id){
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
                            var isSelected = category_child_id == id ? 'selected' : '';
                            html_option += `<option value="${id}" ${isSelected}> ${title} </option>`;
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

    if(category_child_id != 'null'){
        $('#category_id').change();
    }
</script>
@endsection