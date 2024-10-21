@extends('frontend.layouts.master')

@section('content')



    <!-- Breadcumb Area -->
    <div class="breadcumb_area">
        <div class="container h-100">
            <div class="row h-100 align-items-center">
                <div class="col-12">
                    <h5>Checkout</h5>
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{route('home')}}">Home</a></li>
                        <li class="breadcrumb-item active">Checkout</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>
    <!-- Breadcumb Area -->
    <div class="checkout_steps_area">
        <a class="complated" href="{{route('user.checkout1')}}"><i class="icofont-check-circled"></i> Billing</a>
        <a class="complated" href="{{route('user.checkout2')}}"><i class="icofont-check-circled"></i> Shipping</a>
        <a class="complated" href="{{route('user.checkout3')}}"><i class="icofont-check-circled"></i> Payment</a>
        <a href="checkout-5.html"><i class="icofont-check-circled"></i> Review</a>
    </div>
   <!-- Checkout Area -->
   <div class="checkout_area section_padding_100">
    <div class="container">
        <div class="row">
            <div class="col-12">
                <div class="checkout_details_area clearfix">
                    <h5 class="mb-30">Review Your Order</h5>
                    <div class="cart-table">
                        <div class="table-responsive">
                            <table class="table table-bordered mb-30">
                                <thead>
                                    <tr>
                                        <th scope="col">Image</th>
                                        <th scope="col">Product</th>
                                        <th scope="col">Unit Price</th>
                                        <th scope="col">Quantity</th>
                                        <th scope="col">Total</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @php
                                        use App\Models\Product;
                                        use Gloudemans\Shoppingcart\Facades\Cart;
                                        $cart_items = Cart::instance('shopping')->content();
                                        $subtotal = Cart::instance('shopping')->subtotal();
                                        // Convert to float from string
                                        $subtotal = trim($subtotal); 
                                        $subtotal = preg_replace('/[^\d.]/', '', $subtotal); 
                                        $total = is_numeric($subtotal) ? (float)$subtotal : 0.0;
                                        //End of Convert to float from string
                                        $couponValue = session('coupon')['value'] ?? 0;
                                        $deliveryCharge = session('checkout')[0]['delivery_charge'] ?? 0;
                                    @endphp
                                    @foreach ($cart_items as $item)
                                    <tr>
                                        <td>
                                            <img src="{{$item->model->images->first()->url}}" alt="Product">
                                        </td>
                                        <td>
                                            <a href="{{route('products.details',$item->model->slug)}}">{{$item->name}}</a>
                                        </td>
                                        <td>${{$item->price}}</td>
                                        <td>
                                            {{$item->qty}}
                                        </td>
                                        <td>${{$item->subtotal()}}</td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-12 col-lg-7 ml-auto">
                <div class="cart-total-area">
                    <form action="{{route('user.checkout.store')}}" method="POST">
                    @csrf
                    <h5 class="mb-3">Cart Totals</h5>
                    <div class="table-responsive">
                        <table class="table mb-0">
                            <tbody>
                                <tr>
                                    <td>Sub Total</td>
                                    <td>${{$total}}</td>
                                </tr>
                                <tr>
                                    <td>Shipping</td>
                                    <td>${{$deliveryCharge}}</td>
                                </tr>
                                <tr>
                                    <td>Coupon</td>
                                    <td>${{$couponValue}}</td>
                                </tr>
                                <tr>
                                    <td>Total</td>
                                    <td>${{$total+$deliveryCharge-$couponValue}}</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                    <div class="checkout_pagination d-flex justify-content-end mt-3">
                        <a href="{{route('user.checkout3')}}" class="btn btn-primary mt-2 ml-2 d-none d-sm-inline-block">Go Back</a>
                        <button type="submit" class="btn btn-primary mt-2 ml-2">Confirm</a>
                    </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- Checkout Area End -->
@endsection
