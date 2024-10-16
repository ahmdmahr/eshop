@extends('backend.layouts.master')

@section('content')

<div id="main-content">
    <div class="container-fluid">
        <div class="block-header">
            <div class="row">
                <div class="col-lg-6 col-md-8 col-sm-12">
                    <h2><a href="javascript:void(0);" class="btn btn-xs btn-link btn-toggle-fullwidth"><i class="fa fa-arrow-left"></i></a>Add Coupons</h2>
                    <ul class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{route('admin.dashboard')}}"><i class="icon-home"></i></a></li>                            
                        <li class="breadcrumb-item">Coupons</li>
                        <li class="breadcrumb-item active">Add Coupons</li>
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
                        <form action="{{route('admin.coupons.store')}}" method="POST" enctype="multipart/form-data">
                            @csrf
                            <div class="row clearfix">
                            <div class="col-lg-12 col-md-12">
                                <div class="form-group">
                                    <lable for=""> Code <span class="text-danger">*</span></lable>
                                    <input type="text" class="form-control" placeholder="New@123" name="code" value="{{old('code')}}">
                                </div>
                            </div>
                            <div class="col-lg-12 col-md-12">
                                <div class="form-group">
                                    <lable for=""> Value <span class="text-danger">*</span></lable>
                                    <input type="text" class="form-control" placeholder="10% or 10.00$" name="value" value="{{old('value')}}">
                                </div>
                            </div>
                            <div class="col-lg-12 col-sm-12">     
                                <label for="status">Type</label>                            
                                <select name="type" class="form-control show-tick">
                                    <option value="">--Type--</option>
                                    <option value="fixed" {{old('type')=='fixed'?'selected':''}}>Fixed</option>
                                    <option value="percent" {{old('type')=='percent'?'selected':''}}>Percentage</option>
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
@endsection