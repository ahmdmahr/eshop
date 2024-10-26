@extends('backend.layouts.master')

@section('content')

<div id="main-content">
    <div class="container-fluid">
        
        <div class="row clearfix">
            <div class="col-lg-12">
                @include('backend.layouts.notification')
            </div>
            <div class="col-lg-12">
                <div class="card">
                    <div class="header">
                        <h2><strong>Order</strong> {{$order->order_number}}</h2>
                    </div>
                    <div class="body">
                        <div class="table-responsive">
                            <table class="table table-bordered table-striped">
                                <thead>
                                    <tr>
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
                                    <tr>
                                        <td>{{$order->user->full_name}}</td>
                                        <td>{{$order->user->email}}</td>
                                        <td>{{$order->payment_method}}</td>
                                        <td>{{ucfirst($order->payment_status)}}</td>
                                        <td>${{$order->total}}</td>
                                        @php
                                            $badge = '';
                                            if($order->condition == 'pending'){
                                              $badge = 'badge-info';
                                            }
                                            elseif($order->condition == 'processing'){
                                                $badge = 'badge-primary';
                                            }
                                            elseif($order->condition == 'delivered'){
                                                $badge = 'badge-success';
                                            }
                                            else{
                                                $badge = 'badge-danger';
                                            }
                                        @endphp
                                        <td><span class="badge {{$badge}}"></span>{{$order->condition}}</td>
                                        <td>
                                            <a href="{{route('admin.orders.show',$order->id)}}" data-toggle="tooltip" class="btn btn-sm btn-outline-primary mr-2" title="download" data-placement="bottom"><i class="fas fa-download"></i></a>
                                            <form  action="{{route('admin.orders.destroy',$order->id)}}" method="POST" class="d-inline">
                                                @csrf
                                                @method('DELETE')
                                                <a href="" data-toggle="tooltip" class="  dltBtn btn btn-sm btn-outline-danger" title="delete" data-id="{{$order->id}}" data-placement="bottom"><i class="fas fa-trash-alt "></i></a>
                                            </form>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                        <div class="table-responsive">
                            <table class="table table-bordered table-striped">
                                <thead>
                                    <tr>
                                        <th>S.N</th>
                                        <th>Image</th>
                                        <th>Product Name</th>
                                        <th>Quantity</th>
                                        <th>Price</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($order->order_items as $item)
                                        <tr>
                                            <td>{{$loop->iteration}}</td>
                                            <td><img src="{{$item->product->images->first()->url}}" alt="product image" style="max-width: 100px"></td>
                                            <td>{{$item->product->title}}</td>
                                            <td>{{$order->quantity}}</td>
                                            <td>${{ucfirst($order->price)}}</td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-6"></div>
                        <div class="col-5 border py-3">
                            <p>
                              <strong>Subtotal: </strong>${{$order->subtotal}}
                            </p>
                            @if($order->delivery_charge>0)
                            <p>
                              <strong>Shipping Cost: </strong>${{$order->delivery_charge}}
                            </p>
                            @endif
                            @if($order->coupon>0)
                            <p>
                              <strong>Coupon: </strong>${{$order->coupon}}
                            </p>
                            @endif
                            <hr>
                            <p>
                                <strong>Total: </strong>${{$order->total}}
                            </p>
                            <form action="{{route('admin.orders.condition')}}" method="POST">
                                @csrf
                                <input type="hidden" name="order_id" value="{{$order->id}}">
                                <strong>Condition</strong>
                                <select name="condition" class="form-control" id="">
                                    <option value="pending" {{$order->condition == 'delivered'||$order->condition == 'cancelled'?'disabled':''}}  {{$order->condition == 'pending'?'active':''}}>Pending</option>
                                    <option value="processing" {{$order->condition == 'delivered'||$order->condition == 'cancelled'?'disabled':''}} {{ $order->condition == 'processing' ? 'selected' : '' }}>Processing</option>
                                    <option value="delivered" {{$order->condition == 'cancelled'?'disabled':''}} {{ $order->condition == 'delivered' ? 'selected' : '' }}>Delivered</option>
                                    <option value="cancelled" {{$order->condition == 'delivered'?'disabled':''}} {{ $order->condition == 'cancelled' ? 'selected' : '' }}>Cancelled</option>
                                </select>
                                <button class="btn btn-sm btn-success">Update</button>
                            </form>
                        </div>
                        <div class="col-1">

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