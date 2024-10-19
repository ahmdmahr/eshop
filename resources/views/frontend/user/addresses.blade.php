@extends('frontend.layouts.master')
@section('content')
 <!-- Breadcumb Area -->
 <div class="breadcumb_area">
    <div class="container h-100">
        <div class="row h-100 align-items-center">
            <div class="col-12">
                <h5>My Account</h5>
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{route('home')}}">Home</a></li>
                    <li class="breadcrumb-item active">My Account</li>
                </ol>
            </div>
        </div>
    </div>
</div>
<!-- Breadcumb Area -->

<!-- My Account Area -->
<section class="my-account-area section_padding_100_50">
    <div class="container">
        <div class="row">
            <div class="col-12 col-lg-3">
                <div class="my-account-navigation mb-50">
                    @include('frontend.user.sidebar')
                </div>
            </div>
            <div class="col-12 col-lg-9">
                <div class="my-account-content mb-50">
                    <p>The following addresses will be used on the checkout page by default.</p>

                    <div class="row">
                        <div class="col-12 col-lg-6 mb-5 mb-lg-0">
                            <h6 class="mb-3">Billing Address</h6>
                            <address>
                                {{$user->phone}} <br>
                                {{$user->address}} <br>
                                {{$user->city}} <br>
                                {{$user->state}} <br>
                                {{$user->country}} <br>
                                {{$user->postcode}}
                            </address>
                            <a href="" class="btn btn-primary btn-sm" data-toggle="modal" data-target="#editAddress">Edit Billing Address</a>
                        
                            <!-- Address Modal -->
                            <div class="modal fade" id="editAddress" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true" data-backdrop="false" style="background:rgba(0,0,0,0.5);">
                                <div class="modal-dialog modal-dialog-centered" role="document">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title" id="exampleModalLongTitle">Edit Billing Address</h5>
                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                <span aria-hidden="true">&times;</span>
                                            </button>
                                        </div>
                                        <div class="modal-body">
                                            <form  action="{{route('user.billing-address.update', $user->id)}}" method="POST">
                                                @csrf
                                                @method('PUT')
                                                <div class="form-group">
                                                    <label for="phone">Phone</label>
                                                    <textarea name="phone" id="phone" class="form-control" placeholder="+201227555769">{{ $user->phone }}</textarea>
                                                </div>
                                                <div class="form-group">
                                                    <label for="address">Address</label>
                                                    <textarea name="address" id="address" class="form-control" placeholder="Write your address..">{{ $user->address }}</textarea>
                                                </div>
                                                <div class="form-group">
                                                    <label for="country">Country</label>
                                                    <input name="country" id="country" class="form-control" placeholder="Egypt" value="{{ $user->country }}">
                                                </div>
                                                <div class="form-group">
                                                    <label for="state">State</label>
                                                    <input name="state" id="state" class="form-control" placeholder="Menofia" value="{{ $user->state }}">
                                                </div>
                                                <div class="form-group">
                                                    <label for="city">City</label>
                                                    <input name="city" id="city" class="form-control" placeholder="Menof" value="{{ $user->city }}">
                                                </div>
                                                <div class="form-group">
                                                    <label for="postcode">Postcode</label>
                                                    <input name="postcode" id="postcode" class="form-control" placeholder="44600" value="{{ $user->postcode }}">
                                                </div>
                                                <div class="modal-footer">
                                                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                                    <button type="submit" class="btn btn-primary">Save changes</button>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                        <div class="col-12 col-lg-6">
                            <h6 class="mb-3">Shipping Address</h6>
                            <address>
                                {{$user->shipping_address}} <br>
                                {{$user->shipping_city}} <br>
                                {{$user->shipping_state}} <br>
                                {{$user->shipping_country}} <br>
                                {{$user->shipping_postcode}}
                            </address>
                            <a href="" class="btn btn-primary btn-sm" data-toggle="modal" data-target="#editShippingAddress">Edit  Shipping Address</a>
                            
                            <!-- Shipping Address Modal -->
                            <div class="modal fade" id="editShippingAddress" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true" data-backdrop="false" style="background:rgba(0,0,0,0.5);">
                                <div class="modal-dialog modal-dialog-centered" role="document">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title">Edit Shipping Address</h5>
                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                <span aria-hidden="true">&times;</span>
                                            </button>
                                        </div>
                                        <div class="modal-body">
                                            <form action="{{route('user.shipping-address.update', $user->id)}}" method="POST">
                                                @csrf
                                                @method('PUT')
                                                <div class="form-group">
                                                    <label for="">Address</label>
                                                    <textarea name="shipping_address" class="form-control" placeholder="Write your address..">{{ $user->shipping_address }}</textarea>
                                                </div>
                                                <div class="form-group">
                                                    <label for="">Country</label>
                                                    <input name="shipping_country" class="form-control" placeholder="Egypt" value="{{ $user->shipping_country }}">
                                                </div>
                                                <div class="form-group">
                                                    <label for="">State</label>
                                                    <input name="shipping_state" class="form-control" placeholder="Menofia" value="{{ $user->shipping_state }}">
                                                </div>
                                                <div class="form-group">
                                                    <label for="">City</label>
                                                    <input name="shipping_city" class="form-control" placeholder="Menof" value="{{ $user->shipping_city }}">
                                                </div>
                                                <div class="form-group">
                                                    <label for="">Postcode</label>
                                                    <input name="shipping_postcode" class="form-control" placeholder="44600" value="{{ $user->shipping_postcode }}">
                                                </div>
                                                <div class="modal-footer">
                                                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                                    <button type="submit" class="btn btn-primary">Save changes</button>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<!-- My Account Area -->
@endsection
