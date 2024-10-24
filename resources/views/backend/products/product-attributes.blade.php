@extends('backend.layouts.master')

@section('content')

<div id="main-content">
    <div class="container-fluid">
        <div class="block-header">
            <div class="row">
                <div class="col-lg-12 col-md-12 col-sm-12">
                    <h2><a href="javascript:void(0);" class="btn btn-xs btn-link btn-toggle-fullwidth"><i class="fa fa-arrow-left"></i></a> Products</h2>
                    <ul class="breadcrumb float-left">
                        <li class="breadcrumb-item"><a href="{{route('admin.dashboard')}}"><i class="icon-home"></i></a></li>                            
                        <li class="breadcrumb-item active">Product Attributes</li>
                    </ul>
                </div>            
            </div>
        </div>
        
        <div class="row clearfix">
            <div class="col-lg-12">
                @if($errors->any())
                <div class="alert alert-danger">
                    <ul>
                        @foreach ($errors->all() as $error)
                           <ul>{{$error}}</ul>
                       @endforeach
                    </ul>
                </div>
                @endif
                @include('backend.layouts.notification')
            </div>
            <div class="col-lg-12">
                <div class="card">
                    <div class="header">
                        <h2><strong>{{ucfirst($product->title)}}</strong></h2>
                        <div class="row">
                            <div class="col-md-7">
                                <form action="{{route('admin.products.attributes.add',$product->id)}}" method="POST">
                                    @csrf
                                    <div id="product_attributes" class="content" data-mfield-options='{"section": ".group","btnAdd":"#btnAdd-1","btnRemove":".btnRemove"}'>
                                        <div class="row">
                                            <div class="col-md-12"><button type="button" id="btnAdd-1" class="btn btn-sm my-2 btn-primary"><i class="fas fa-plus-circle"></i></button></div>
                                        </div>
                                        <div class="row group">
                                            <div class="col-md-2">
                                                <label for="">Size</label>
                                                <input class="form-control form-control-sm" name="size[]" placeholder="S" type="text">
                                            </div>
                                            <div class="col-md-3">
                                                <label for="">Original Price</label>
                                                <input class="form-control form-control-sm" name="price[]" placeholder="1200$" step ="any" type="number">
                                            </div>
                                            <div class="col-md-3">
                                                <label for="">Offer Price</label>
                                                <input class="form-control form-control-sm" name="offer_price[]" placeholder="1000$" step ="any" type="number">
                                            </div>
                                            <div class="col-md-2">
                                                <label for="">Stock</label>
                                                <input class="form-control form-control-sm" name="stock[]" placeholder="5" type="number">
                                            </div>
                                            <div class="col-md-2">
                                                <button type="button" class="mt-4 btn btn-sm btn-danger btnRemove"><i class="fas fa-trash-alt"></i>
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                    <button type="submit" class="btn btn-sm btn-info">Submit</button>
                                </form>
                            </div>
                            <div class="col-md-5">
                                <div class="table-responsive">
                                    <table class="table table-bordered table-striped table-hover">
                                        <thead>
                                            <tr>
                                                <th>Size</th>
                                                <th>Original Price</th>
                                                <th>Offer Price</th>
                                                <th>Stock</th>
                                                <th>Action</th>
                                            </tr>
                                        </thead>                            
                                        <tbody>
                                            @if(count($productAttributes)>0)
                                               @foreach ($productAttributes as $item)
                                                <tr>
                                                    <td>{{$item->size}}</td>
                                                    <td>${{$item->price}}</td>
                                                    <td>${{$item->offer_price}}</td>
                                                    <td>{{$item->stock}}</td>
                                                    <td>
                                                        <form  action="{{route('admin.products.attributes.delete',[$product->id,$item->id])}}" method="POST" class="d-inline">
                                                            @csrf
                                                            @method('DELETE')
                                                            <a href="" data-toggle="tooltip" class="  dltBtn btn btn-sm btn-outline-danger" title="delete" data-id="{{$item->id}}" data-placement="bottom"><i class="fas fa-trash-alt "></i></a>
                                                        </form>
                                                    </td>
                                                </tr>
                                               @endforeach
                                            @endif
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="body">
                       
                    </div>
                </div>                   
            </div>
        </div>

    </div>
</div>

@endsection

@section('scripts')

<script src="{{asset('backend/assets/js/jquery.multifield.js')}}"></script>
<script>
    $('#product_attributes').multifield();
</script>

<script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>

<script>
    $.ajaxSetup({
    headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    }
    });
    $('.dltBtn').click(function (e){
        var form=$(this).closest('form');
        var dataID=$(this).data('id');
        e.preventDefault();
        swal({
            title: "Are you sure?",
            text: "Once deleted, you will not be able to recover this imaginary file!",
            icon: "warning",
            buttons: true,
            dangerMode: true,
            })
            .then((willDelete) => {
            if (willDelete) {
                form.submit();
                swal("Poof! Your imaginary file has been deleted!", {
                icon: "success",
                });
            } else {
                swal("Your imaginary file is safe!");
            }
        });
    });
</script>

@endsection