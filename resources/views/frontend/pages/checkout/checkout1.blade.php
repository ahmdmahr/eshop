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

    <!-- Checkout Step Area -->
    <div class="checkout_steps_area">
        <a class="active" href="{{route('user.checkout1')}}"><i class="icofont-check-circled"></i> Billing</a>
        <a class="active" href="{{route('user.checkout2')}}"><i class="icofont-check-circled"></i> Shipping</a>
        <a class="active" href="{{route('user.checkout3')}}"><i class="icofont-check-circled"></i> Payment</a>
        <a href="checkout-5.html"><i class="icofont-check-circled"></i> Review</a>
    </div>
    <!-- Checkout Area -->
    <div class="checkout_area section_padding_100">
        <div class="container">
            <div class="row">
                <div class="col-12">
                    @if($errors->any())
                    <div class="alert alert-danger">
                        <ul>
                            @foreach ($errors->all() as $error)
                                <li>{{$error}}</li>
                            @endforeach
                        </ul>
                    </div>
                    @endif
                </div>
            </div>
            <form action="{{route('user.checkout1.store')}}" method="post">
                @csrf
            <div class="row">
                    <div class="col-12">
                        <div class="checkout_details_area clearfix">
                            <h5 class="mb-4">Billing Details</h5>
                            
                                <div class="row">
                                    <div class="col-md-6 mb-3">
                                        <label for="email_address">Email Address</label>
                                        <input type="email" class="form-control" id="email" placeholder="Email Address" value="{{$user->email}}" readonly name="email">
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <label for="phone_number">Phone Number</label>
                                        <input type="text" class="form-control" id="phone" min="0" value="{{$user->phone}}" name="phone" placeholder="Phone number">
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <label for="country">Country</label>
                                        <input type="text" class="form-control" name="country" value="{{$user->country}}" placeholder="UK">
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <label for="street_address">Street address</label>
                                        <input type="text" class="form-control" id="address" placeholder="Street Address" value="{{$user->address}}" name="address">
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <label for="city">Town/City</label>
                                        <input type="text" class="form-control" id="city" placeholder="Town/City" value="{{$user->city}}" name="city">
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <label for="state">State</label>
                                        <input type="text" class="form-control" id="state" placeholder="State" value="{{$user->state}}" name="state">
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <label for="postcode">Postcode/Zip</label>
                                        <input type="text" class="form-control" id="postcode" placeholder="Postcode / Zip" value="{{$user->postcode}}" name="postcode">
                                    </div>
                                    <div class="col-md-12">
                                        <label for="order-notes">Order Notes</label>
                                        <textarea class="form-control" id="notes" cols="30" rows="10" placeholder="Notes about your order, e.g. special notes for delivery." name="notes"></textarea>
                                    </div>
                                </div>

                                <!-- Different Shipping Address -->
                                <div class="different-address mt-50">
                                    <div class="ship-different-title mb-3">
                                        <div class="custom-control custom-checkbox">
                                            <input type="checkbox" class="custom-control-input" id="customCheck1">
                                            <label class="custom-control-label" for="customCheck1">Ship to a different address?</label>
                                        </div>
                                    </div>
                                    <div class="row shipping_input_field">
                                        <div class="col-md-6 mb-3">
                                            <label for="email_address">Email Address</label>
                                            <input type="email" class="form-control" id="shipping_email" placeholder="Email Address" value="{{$user->email}}" readonly name="email">
                                        </div>
                                        <div class="col-md-6 mb-3">
                                            <label for="phone_number">Phone Number</label>
                                            <input type="text" class="form-control" id="shipping_phone" min="0" value="{{$user->phone}}" name="phone" placeholder="Phone number">
                                        </div>
                                        <div class="col-md-6 mb-3">
                                            <label for="country">Country</label>
                                            <input type="text" class="form-control" name="shipping_country" value="{{$user->shipping_country}}" placeholder="UK" id="shipping_country">
                                        </div>
                                        <div class="col-md-6 mb-3">
                                            <label for="street_address">Street address</label>
                                            <input type="text" class="form-control" id="shipping_address" placeholder="Street Address" value="{{$user->shipping_address}}" name="shipping_address">
                                        </div>
                                        <div class="col-md-6 mb-3">
                                            <label for="city">Town/City</label>
                                            <input type="text" class="form-control" id="shipping_city" placeholder="Town/City" value="{{$user->shipping_city}}" name="shipping_city">
                                        </div>
                                        <div class="col-md-6 mb-3">
                                            <label for="state">State</label>
                                            <input type="text" class="form-control" id="shipping_state" placeholder="State" value="{{$user->shipping_state}}" name="shipping_state">
                                        </div>
                                        <div class="col-md-6 mb-3">
                                            <label for="postcode">Postcode/Zip</label>
                                            <input type="text" class="form-control" id="shipping_postcode" placeholder="Postcode / Zip" value="{{$user->shipping_postcode}}" name="shipping_postcode">
                                        </div>
                                        <div class="col-md-12">
                                            <label for="order-notes">Order Notes</label>
                                            <textarea class="form-control" id="notes" cols="30" rows="10" placeholder="Notes about your order, e.g. special notes for delivery." name="notes"></textarea>
                                        </div>
                                    </div>
                                </div>
                        </div>
                    </div>

                    <div class="col-12">
                        @php
                        use App\Models\Product;
                        use Gloudemans\Shoppingcart\Facades\Cart;
                        $subtotal = Cart::instance('shopping')->subtotal();
                        // Convert to float from string
                        $subtotal = trim($subtotal); 
                        $subtotal = preg_replace('/[^\d.]/', '', $subtotal); 
                        $total = is_numeric($subtotal) ? (float)$subtotal : 0.0;
                        //End of Convert to float from string
                        @endphp
                        <input type="hidden" name="subtotal" value="{{$subtotal}}">
                        <input type="hidden" name="total" value="{{$subtotal}}">
                        <div class="checkout_pagination d-flex justify-content-end mt-50">
                            <a href="{{route('user.cart.index')}}" class="btn btn-primary mt-2 ml-2">Go Back</a>
                            <button type="submit" class="btn btn-primary mt-2 ml-2">Continue</a>
                        </div>
                    </div>
            </div>
         </form>
        </div>
    </div>
    <!-- Checkout Area -->
@endsection

@section('scripts')

<script>
$('#customCheck1').on('change',function(e){
    e.preventDefault();
    if(this.checked){
        $('#shipping_email').val($('#shipping_email').val());
        $('#shipping_phone').val($('#shipping_phone').val());
        $('#shipping_country').val($('#shipping_country').val());
        $('#shipping_address').val($('#shipping_address').val());
        $('#shipping_city').val($('#shipping_city').val());
        $('#shipping_state').val($('#shipping_state').val());
        $('#shipping_postcode').val($('#shipping_postcode').val());
    }
    else{
        $('#shipping_email').val("");
        $('#shipping_phone').val("");
        $('#shipping_country').val("");
        $('#shipping_address').val("");
        $('#shipping_city').val("");
        $('#shipping_state').val("");
        $('#shipping_postcode').val("");
    }
});
</script>

@endsection