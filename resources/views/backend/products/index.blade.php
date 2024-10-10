@extends('backend.layouts.master')

@section('content')

<div id="main-content">
    <div class="container-fluid">
        <div class="block-header">
            <div class="row">
                <div class="col-lg-12 col-md-12 col-sm-12">
                    <h2><a href="javascript:void(0);" class="btn btn-xs btn-link btn-toggle-fullwidth"><i class="fa fa-arrow-left"></i></a> Products <a href="{{route('admin.products.create')}}" class="btn btn-sm btn-outline-secondary"><i class="icon-plus"></i> Create Product</a></h2>
                    <ul class="breadcrumb float-left">
                        <li class="breadcrumb-item"><a href="{{route('admin.dashboard')}}"><i class="icon-home"></i></a></li>                            
                        <li class="breadcrumb-item active">Products</li>
                    </ul>
                    <p class="float-right">Total Products:{{$products->count()}}</p>
                </div>            
            </div>
        </div>
        
        <div class="row clearfix">
            <div class="col-lg-12">
                @include('backend.layouts.notification')
            </div>
            <div class="col-lg-12">
                <div class="card">
                    <div class="header">
                        <h2><strong>Product</strong> List</h2>
                    </div>
                    <div class="body">
                        <div class="table-responsive">
                            <table class="table table-bordered table-striped table-hover js-basic-example dataTable">
                                <thead>
                                    <tr>
                                        <th>S.N</th>
                                        <th>Title</th>
                                        <th>Photo</th>
                                        <th>Price</th>
                                        <th>Discount</th>
                                        <th>Size</th>
                                        <th>condition</th>
                                        <th>Status</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>                            
                                <tbody>
                                    @foreach ($products as $item)
                                    <tr>
                                        <td>{{$loop->iteration}}</td>
                                        <td>{{$item->title}}</td>
                                        {{-- {{ $item->photo }}  --}}
                                        <td>
                                            <img src="{{$item->images->first()->url}}" alt="product image" style="max-height:150px;
                                            max-width:150px">
                                        </td>
                                        <td>{{$item->price}}$</td>
                                        <td>{{$item->discount}}%</td>
                                        <td>{{$item->size}}</td>
                                        <td>
                                            @if($item->condition == 'new')
                                            <span class="badge badge-success">{{$item->condition}}</span>
                                            @elseif($item->condition == 'popular')
                                            <span class="badge badge-warning">{{$item->condition}}</span>
                                            @else
                                            <span class="badge badge-primary">{{$item->condition}}</span>
                                            @endif
                                        </td>
                                        <td>
                                            <input type="checkbox"  name="toogle" value="{{$item->id}}" data-toggle="switchbutton"  {{$item->status == 'active'?'checked':''}} data-onlabel="Active" data-offlabel="Inactive" 
                                            data-size="sm"
                                            data-onstyle="success" data-offstyle="danger">
                                        </td>
                                        <td>
                                            <a href="{{route('admin.products.edit',$item->id)}}" data-toggle="tooltip" class="btn btn-sm btn-outline-primary mr-2" title="view" data-placement="bottom"><i class="fas fa-edit"></i></a>

                                            <a href="#" data-toggle="modal" data-target="#productID{{$item->id}}"  data-toggle="tooltip" class="btn btn-sm btn-outline-secondary mr-2" title="edit" data-placement="bottom"><i class="fas fa-eye"></i></a>

                                            <form  action="{{route('admin.products.destroy',$item->id)}}" method="POST" class="d-inline">
                                                @csrf
                                                @method('DELETE')
                                                <a href="" data-toggle="tooltip" class="  dltBtn btn btn-sm btn-outline-danger" title="delete" data-id="{{$item->id}}" data-placement="bottom"><i class="fas fa-trash-alt "></i></a>
                                            </form>
                                        </td>
                                        <!-- Modal -->
                                        <div class="modal fade" id="productID{{$item->id}}" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
                                            <div class="modal-dialog modal-dialog-centered" role="document">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                <h5 class="modal-title" id="exampleModalLongTitle">{{strtoupper($item->title)}}</h5>
                                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                    <span aria-hidden="true">&times;</span>
                                                </button>
                                                </div>
                                                <div class="modal-body">

                                                <strong>Vendor:</strong>
                                                <p>{{$item->vendor_id}}</p>

                                                <strong>Summary:</strong>
                                                {{-- {{ }} syntax automatically escapes output to prevent XSS attacks, which means that HTML entities won't be decoded as you expect. To decode HTML entities while still outputting them safely, you should use the {!! !!} syntax. --}}
                                                <p>{!!html_entity_decode($item->summary)!!}</p>

                                                <strong>Description:</strong>
                                                <p>{!!html_entity_decode($item->description)!!}</p>

                                                <div class="row">
                                                    <div class="col-md-4">
                                                        <strong>Price:</strong>
                                                        <p>{{$item->price}}$</p>
                                                    </div>
                                                    <div class="col-md-4">
                                                        <strong>Offer Price:</strong>
                                                       <p>{{$item->offer_price}}$</p>
                                                    </div>
                                                    <div class="col-md-4">
                                                        <strong>Stock:</strong>
                                                       <p>{{$item->stock}}</p>
                                                    </div>
                                                </div>

                                                
                                                <div class="row">
                                                    <div class="col-md-6">
                                                        <strong>Size:</strong>
                                                        <p class="badge badge-success">{{$item->size}}</p>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <strong>Category:</strong>
                                                       <p>{{$item->category_id}}</p>
                                                    </div>
                                                </div>

                                                <div class="row">
                                                    <div class="col-md-6">
                                                        <strong>Child Category:</strong>
                                                       <p>{{$item->category_child_id}}</p>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <strong>Brand:</strong>
                                                       <p>{{$item->brand_id}}</p>
                                                    </div>
                                                </div>

                                                <div class="row">
                                                    <div class="col-md-6">
                                                        <strong>Status:</strong>
                                                       <p class="badge badge-warning">{{$item->status}}</p>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <strong>Condition:</strong>
                                                       <p class="badge badge-primary">{{$item->condition}}</p>
                                                    </div>
                                                </div>
                                                

                                                </div>
                                                <div class="modal-footer">
                                                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                                <button type="button" class="btn btn-primary">Save changes</button>
                                                </div>
                                            </div>
                                            </div>
                                        </div>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>                   
            </div>
        </div>

    </div>
</div>

@endsection

@section('scripts')
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
<script>
    $('input[name=toogle]').change(function(){
        var mode = $(this).prop('checked');
        var id = $(this).val();
        // alert(mode);
        $.ajax({
            url:"{{ route('admin.products.status') }}",
            type:"POST",
            data:{
                _token:'{{ csrf_token() }}',
                'id':id
            },
            success:function(response){
                if(response.status){
                    alert(response.success)
                }
                else{
                    alert('Please try again!')
                }
            }
        })
    });
</script>
@endsection