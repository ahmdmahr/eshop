@extends('frontend.layouts.master')

@section('content')

<!-- Breadcumb Area -->
<div class="breadcumb_area">
    <div class="container h-100">
        <div class="row h-100 align-items-center">
            <div class="col-12">
                <h5>Cart</h5>
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{route('home')}}">Home</a></li>
                    <li class="breadcrumb-item active">Cart</li>
                </ol>
            </div>
        </div>
    </div>
</div>
<!-- Breadcumb Area -->

<!-- Cart Area -->
<div class="cart_area section_padding_100_70 clearfix">
    <div class="container">
        <div class="row justify-content-between">
            <div class="col-12">
                <div class="cart-table">
                    <div class="table-responsive" id="cart_list">
                       @include('frontend.pages.cart.cart-list')
                    </div>
                </div>
            </div>

            <div class="col-12 col-lg-6">
                <div class="cart-apply-coupon mb-30">
                    <h6>Have a Coupon?</h6>
                    <p>Enter your coupon code here &amp; get awesome discounts!</p>
                    <!-- Form -->
                    <div class="coupon-form">
                        <form action="{{route('user.coupons.apply')}}" id="coupon-form" method="POST">
                            @csrf
                            <input type="text" class="form-control" name="code" placeholder="Enter Your Coupon Code">
                            <button type="submit" class="coupon-btn btn btn-primary">Apply Coupon</button>
                        </form>
                    </div>
                </div>
            </div>

            @php
                $subtotal = Cart::instance('shopping')->subtotal();
                // Convert to float from string
                $subtotal = trim($subtotal); 
                $subtotal = preg_replace('/[^\d.]/', '', $subtotal); 
                $total = is_numeric($subtotal) ? (float)$subtotal : 0.0;
                //End of Convert to float from string
                $couponValue = session('coupon')['value'] ?? 0;
            @endphp

            <div class="col-12 col-lg-5">
                <div class="cart-total-area mb-30">
                    <h5 class="mb-3">Cart Totals</h5>
                    <div class="table-responsive">
                        <table class="table mb-3">
                            <tbody>
                                <tr>
                                    <td>Sub Total</td>
                                    <td>${{$total}}</td>
                                </tr>
                                <tr>
                                    <td>Shipping</td>
                                    <td>$30</td>
                                </tr>
                                <tr>
                                    <td>Save Amount</td>
                                    <td>{{$couponValue}}</td>
                                </tr>
                                <tr>
                                    <td>Total</td>
                                    <td>${{$total+30-$couponValue}}</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                    <a href="{{route('user.checkout1')}}" class="btn btn-primary d-block">Proceed To Checkout</a>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- Cart Area End -->

@endsection


@section('scripts')

<script>
    $(document).on('click','.coupon-btn',function(e){
        e.preventDefault();
        var code=$('input[name=code]').val();
        // alert(code);
        $('.coupon-btn').html('<i class="fas fa-spinner fa-spin"></i> Applying...');
        $('#coupon-form').submit();
    });
</script>

<script>
    $(document).on('click','.delete-from-cart',function(e){
        e.preventDefault();
        var product_id = $(this).data('id');    
        // alert(product_id);

        var token = "{{csrf_token()}}";
        var path = "{{ route('user.cart.destroy', ':product_id') }}".replace(':product_id', product_id);

        $.ajax({
            url:path,
            type:"DELETE",
            data:{
                '_token':token,
                'product_id':product_id,
            },
            success:function(data){
                if(data['status']){
                    $('body #header-ajax').html(data['header']);
                    swal({
                    title: "Good job!",
                    text: data['message'],
                    icon: "success",
                    button: "Ok!",
                    });
                }
            },
            error:function(err){
                console.log(err);
            }
        });
    });
</script>

<script>
    $(document).on('click','.qty-text',function(){
        var id=$(this).data('id');

        // alert(id);

        // value of quantity
        var spinner=$(this),input=spinner.closest("div.quantity").find('input[type="number"]'); 

        // alert(input.val());

        if(input.val() == 1){
            return false;
        }
        else{
            var newVal = parseInt(input.val());
            $('#qty-input-'+id).val(newVal);
        }

        console.log($("#update-cart-" + id));

        var productStock = $("#update-cart-" + id).data('product-stock');

        // alert(productStock);

        update_cart(id,productStock);
    });
    function update_cart(id,productStock){
        var product_id = id;
        var product_qty = $("#qty-input-"+product_id).val();
        var token = "{{csrf_token()}}";
        var path = "{{route('user.cart.update', ':product_id') }}".replace(':product_id', product_id);
        $.ajax({
            url:path,
            type:"PUT",
            data:{
                _token:token,
                product_id:product_id,
                product_qty:product_qty,
                product_stock:productStock
            },
            success:function(data){
                // console.log(data);
                // alert(data['status']);
                if(data['status']){
                    $('body #header-ajax').html(data['header']);
                    $('body #cart_list').html(data['cart_list']);
                    swal({
                    title: "Good job!",
                    text: data['message'],
                    icon: "success",
                    button: "Ok!",
                    });
                }
            }
        });
    }
</script>

@endsection