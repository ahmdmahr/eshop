@extends('backend.layouts.master')

@section('content')

<div id="main-content">
    <div class="container-fluid">
        <div class="block-header">
            <div class="row">
                <div class="col-lg-12 col-md-12 col-sm-12">
                    <h2><a href="javascript:void(0);" class="btn btn-xs btn-link btn-toggle-fullwidth"><i class="fa fa-arrow-left"></i></a> Orders</h2>
                    <ul class="breadcrumb float-left">
                        <li class="breadcrumb-item"><a href="{{route('admin.dashboard')}}"><i class="icon-home"></i></a></li>                            
                        <li class="breadcrumb-item active">Orders</li>
                    </ul>
                    <p class="float-right">Total Orders:{{$orders->count()}}</p>
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
                        <h2><strong>Order</strong> List</h2>
                    </div>
                    <div class="body">
                        <div class="table-responsive">
                            <table class="table table-bordered table-striped table-hover js-basic-example dataTable">
                                <thead>
                                    <tr>
                                        <th style="width:60px;">S.N</th>
                                        <th>Name</th>
                                        <th>Email</th>
                                        <th>Payment method</th>
                                        <th>payment status</th>
                                        <th>Total</th>
                                        <th>Condition</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($orders as $item)
                                    <tr>
                                        <td>{{$loop->iteration}}</td>
                                        <td>{{$item->user->full_name}}</td>
                                        <td>{{$item->user->email}}</td>
                                        <td>{{$item->payment_method}}</td>
                                        <td>{{ucfirst($item->payment_status)}}</td>
                                        <td>${{$item->total}}</td>
                                        @php
                                            $badge = match($item->condition) {
                                            'pending' => 'badge-info',
                                            'processing' => 'badge-primary',
                                            'delivered' => 'badge-success',
                                            default => 'badge-danger',
                                            };
                                        @endphp
                                        <td><span class="badge {{$badge}}">{{$item->condition}}</span></td>
                                        <td>
                                            <a href="{{route('admin.orders.show',$item->id)}}" data-toggle="tooltip" class="btn btn-sm btn-outline-primary mr-2" title="view" data-placement="bottom"><i class="fas fa-eye"></i></a>
                                            <form  action="{{route('admin.orders.destroy',$item->id)}}" method="POST" class="d-inline">
                                                @csrf
                                                @method('DELETE')
                                                <a href="" data-toggle="tooltip" class="  dltBtn btn btn-sm btn-outline-danger" title="delete" data-id="{{$item->id}}" data-placement="bottom"><i class="fas fa-trash-alt "></i></a>
                                            </form>
                                        </td>
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
            url:"{{ route('admin.coupons.status') }}",
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