@extends('backend.layouts.master')

@section('content')

<div id="main-content">
    <div class="container-fluid">
        <div class="block-header">
            <div class="row">
                <div class="col-lg-6 col-md-8 col-sm-12">
                    <h2><a href="javascript:void(0);" class="btn btn-xs btn-link btn-toggle-fullwidth"><i class="fa fa-arrow-left"></i></a>Edit Currencies</h2>
                    <ul class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{route('admin.dashboard')}}"><i class="icon-home"></i></a></li>                            
                        <li class="breadcrumb-item">Currencies</li>
                        <li class="breadcrumb-item active">Edit Currency</li>
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
                        <form action="{{route('admin.currencies.update',$currency->id)}}" method="POST" enctype="multipart/form-data">
                            @csrf
                            @method('PUT')
                            <div class="row clearfix">
                                <div class="col-lg-12 col-md-12">
                                    <div class="form-group">
                                        <lable for=""> Currency Name <span class="text-danger">*</span></lable>
                                        <input type="text" class="form-control" placeholder="Currency Name" name="name" value="{{$currency->name}}">
                                    </div>
                                </div> 
                                <div class="col-lg-12 col-md-12">
                                    <div class="form-group">
                                        <lable for="">Symbol<span class="text-danger">*</span></lable>
                                        <input type="text" class="form-control" placeholder="Currency Symbol" name="symbol" value="{{$currency->symbol}}">
                                    </div>
                                </div> 
                                <div class="col-lg-12 col-md-12">
                                    <div class="form-group">
                                        <lable for="">Exchange Rate<span class="text-danger">*</span></lable>
                                        <input type="number" step="any" class="form-control" placeholder="1usd = 50egp" name="exchange_rate" value="{{$currency->exchange_rate}}">
                                    </div>
                                </div> 
                                <div class="col-lg-12 col-md-12">
                                    <div class="form-group">
                                        <lable for="">Code<span class="text-danger">*</span></lable>
                                        <input type="text" class="form-control" placeholder="USD" name="code" value="{{$currency->code}}">
                                    </div>
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
@endsection