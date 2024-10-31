@extends('frontend.layouts.master')

@section('content')

<!-- Welcome Slides Area -->
@if(count($banners)>0)
<section class="welcome_area">
    <div class="welcome_slides owl-carousel">
    @foreach ($banners as $banner)
        <!-- Single Slide -->
        <div class="single_slide bg-img" style="background-image: url('{{$banner->photo}}');">
            <div class="container h-100">
                <div class="row h-100 align-items-center">
                    <div class="col-7 col-md-8">
                        <div class="welcome_slide_text">
                            <p data-animation="fadeInUp" data-delay="0">Special Offer</p>
                            <h2 data-animation="fadeInUp" data-delay="300ms">{{$banner->title}}</h2>
                            <h4 data-animation="fadeInUp" data-delay="600ms">{!!html_entity_decode($banner->description)!!}</h4>
                            <a href="#" class="btn btn-primary" data-animation="fadeInUp" data-delay="1s">Buy
                                Now</a>
                        </div>
                    </div>
                    <div class="col-5 col-md-4">
                        <div class="welcome_slide_image">
                            <img src="frontend/img/bg-img/slide-1.png" alt="" data-animation="bounceInUp" data-delay="500ms">
                            <div class="discount_badge" data-animation="bounceInDown" data-delay="1.2s">
                                <span>30%<br>OFF</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        @endforeach
    </div>
</section>
@endif

<!-- Welcome Slides Area -->


<!-- Top Catagory Area -->
@if(count($categories)>0)
<div class="top_catagory_area mt-50 clearfix">
    <div class="container">
        <div class="row">
            <!-- Single Catagory -->
            @foreach ($categories as $category)
            <div class="col-12 col-md-4">
                <div class="single_catagory_area mt-50">
                    <a href="{{route('category.products',$category->slug)}}">
                        {{-- {{$category->id}} --}}
                        <img src="{{$category->photo}}" alt="category photo">
                    </a>
                </div>
            </div>
            @endforeach
        </div>
    </div>
</div>
@endif
<!-- Top Catagory Area -->

<!-- New Arrivals Area -->
@if(count($new_products)>0)
<section class="new_arrivals_area section_padding_100 clearfix">
    <div class="container">
        <div class="row">
            <div class="col-12">
                <div class="section_heading new_arrivals">
                    <h5>New Arrivals</h5>
                </div>
            </div>
        </div>

        <div class="row">
            @foreach ($new_products as $item)
                <div class="col-12 col-sm-6 col-md-4 col-lg-3">
                @include('frontend.pages.products.single-product',['item'=>$item])
                </div>
            @endforeach
        </div>
    </div>
</section>
@endif
<!-- New Arrivals Area -->

<!-- Featured Products Area -->
@if(count($featured_products)>0)
<section class="featured_product_area">
    <div class="container">
        <div class="row">
            <!-- Featured Offer Area -->
            <div class="col-12 col-lg-6">
                <div class="featured_offer_area d-flex align-items-center"
                    style="background-image: url('{{asset($promo_banner->photo)}}');">
                    <div class="featured_offer_text">
                        <p>Summer 2018</p>
                        <h2>{!!$promo_banner->description!!}</h2>
                        <h4>{{$promo_banner->title}}</h4>
                        <a href="{{$promo_banner->slug}}" class="btn btn-primary btn-sm mt-3">Shop Now</a>
                    </div>
                </div>
            </div>

            <!-- Featured Product Area -->
            <div class="col-12 col-lg-6">
                <div class="section_heading featured">
                    <h5>Featured Products</h5>
                </div>

                <!-- Featured Product Slides -->
                <div class="featured_product_slides owl-carousel">
                    @foreach($featured_products as $item)
                    <div class="single-product-area">
                        <div class="product_image">
                            <!-- Product Image -->
                            @php
                                $images = [];
                                $i = 0;
                                foreach($item->images as $image){
                                    $images[$i++] = $image->url;
                                }
                            @endphp
                            <img class="normal_img" src="{{$images[0]}}" alt="product photo">
                            <img class="hover_img"  src="{{$images[1]}}" alt="category photo">
                
                            <!-- Product Badge -->
                            <div class="product_badge">
                                <span>{{$item->condition}}</span>
                            </div>
                
                            <!-- Wishlist -->
                            <div class="product_wishlist">
                                <a href="" class="add-to-wishlist" data-quantity="1" data-id="{{$item->id}}" id="add-to-wishlist-{{$item->id}}"><i class="icofont-heart"></i></a>
                            </div>
                
                            <!-- Compare -->
                            <div class="product_compare">
                                <a href="compare.html"><i class="icofont-exchange"></i></a>
                            </div>
                        </div>
                
                        <!-- Product Description -->
                        <div class="product_description">
                            <!-- Add to cart -->
                            <div class="product_add_to_cart">
                                <a href="" data-quantity="1" data-product-id="{{$item->id}}" class="add-to-cart" id="add-to-cart{{$item->id}}"><i class="icofont-shopping-cart"></i> Add to Cart</a>
                            </div>
                
                            <!-- Quick View -->
                            <div class="product_quick_view">
                                <a href="#" data-toggle="modal" data-target="#quickview1{{$item->id}}"><i class="icofont-eye-alt"></i> Quick View</a>
                            </div>
                
                            <p class="brand_name">{{$item->brand->title}}</p>
                            <a href="{{route('products.details',$item->slug)}}">{{$item->title}}</a>
                            @php
                                $price = \App\Utilities\Helper::currency_conventer($item->price);
                                $offer_price = \App\Utilities\Helper::currency_conventer($item->offer_price);
                                $symbol = session('system_default_currency_info')->symbol;
                            @endphp
                            <h6 class="product-price">{{$offer_price}}{{$symbol}} <small><del class="text-danger">{{$price}}{{$symbol}}</del></small></h6>
                        </div>
                </div>
                
                <!-- Quick View Modal Area -->
                {{-- <div class="modal fade" id="quickview1{{$item->id}}" tabindex="-1" role="dialog" aria-labelledby="quickview1" aria-hidden="true" data-backdrop="false" style="background:rgba(0, 0, 0, 0.5);z-index:99999999999;">
                    <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
                      <div class="modal-content">
                        <button type="button" class="close btn" data-dismiss="modal" aria-label="Close">
                          <span aria-hidden="true">&times;</span>
                        </button>
                        <div class="modal-body">
                          <div class="quickview_body">
                            <div class="container">
                              <div class="row">
                                <div class="col-12 col-lg-5">
                                  <div class="quickview_pro_img">
                                    <img class="first_img" src="{{$images[1]}}" alt="product photo">
                                    <img class="hover_img" src="{{$images[0]}}" alt="product photo">
                                    <div class="product_badge">
                                      <span>{{$item->condition}}</span>
                                    </div>
                                  </div>
                                </div>
                                <div class="col-12 col-lg-7">
                                  <div class="quickview_pro_des">
                                    <h4 class="title">{{$item->title}}</h4>
                                    <div class="top_seller_product_rating mb-15">
                                      <i class="fa fa-star" aria-hidden="true"></i>
                                      <i class="fa fa-star" aria-hidden="true"></i>
                                      <i class="fa fa-star" aria-hidden="true"></i>
                                      <i class="fa fa-star" aria-hidden="true"></i>
                                      <i class="fa fa-star" aria-hidden="true"></i>
                                    </div>
                                    <h5 class="price">$120.99 <span>$130</span></h5>
                                    <p>{!! html_entity_decode($item->summary)!!}</p>
                                    <a href="{{route('products.details',$item->slug)}}">View Details</a>
                                    <div class="d-flex align-items-center mt-15">
                                      <div class="quantity me-2">
                                        <input type="number" class="qty-text form-control" id="qty2" step="1" min="1" max="12" name="quantity" value="1" style="width: 70px;">
                                      </div>
                                      <a href="#" data-quantity="1" data-product-id="{{$item->id}}" class="add-to-cart btn btn-primary me-2 py-1">
                                        <i class="icofont-shopping-cart"></i> Add to Cart
                                      </a>
                                      <div class="modal_pro_wishlist me-2">
                                        <a href="" class="add-to-wishlist" data-quantity="1" data-id="{{$item->id}}" id="add-to-wishlist-{{$item->id}}"><i class="icofont-heart"></i></a>
                                      </div>
                                      <div class="modal_pro_compare">
                                        <a href="compare.html"><i class="icofont-exchange"></i></a>
                                      </div>
                                    </div>
                                    <div class="share_wf mt-15">
                                      <p>Share with friends</p>
                                      <div class="_icon">
                                        <a href="#"><i class="fab fa-facebook" aria-hidden="true"></i></a>
                                        <a href="#"><i class="fab fa-twitter" aria-hidden="true"></i></a>
                                        <a href="#"><i class="fab fa-pinterest" aria-hidden="true"></i></a>
                                        <a href="#"><i class="fab fa-linkedin" aria-hidden="true"></i></a>
                                        <a href="#"><i class="fab fa-instagram" aria-hidden="true"></i></a>
                                        <a href="#"><i class="fab fa-envelope-o" aria-hidden="true"></i></a>
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
                  </div> --}}
                  <!-- Quick View Modal Area -->
                @endforeach
                </div>
            </div>
        </div>
    </div>
</section>
@endif
<!-- Featured Products Area -->

<!-- Best Rated/Onsale/Top Sale Product Area -->
<section class="best_rated_onsale_top_sellares section_padding_100_70">
    <div class="container">
        <div class="row">
            <div class="col-12">
                <div class="tabs_area">
                    <!-- Tabs -->
                    <ul class="nav nav-tabs" role="tablist" id="product-tab">
                        <li class="nav-item">
                            <a href="#top-sellers" class="nav-link active" data-toggle="tab" role="tab">Top Sellings</a>
                        </li>
                        <li class="nav-item">
                            <a href="#best-rated" class="nav-link" data-toggle="tab" role="tab">Best Rated</a>
                        </li>
                    </ul>

                    <div class="tab-content">
                        <div role="tabpanel" class="tab-pane fade active" id="top-sellers">
                            <div class="top_sellers_area">
                                <div class="row">
                                    @foreach ($best_sellings as $item)                                        
                                    <div class="col-12 col-sm-6 col-lg-4">
                                        <div class="single_top_sellers">
                                            <div class="top_seller_image">
                
                                                <img src="{{asset($item->images->first()->url)}}" alt="Top-Sellers">
                                            </div>
                                            <div class="top_seller_desc">
                                                <h5>{{$item->title}}</h5>
                                                @php
                                                $price = \App\Utilities\Helper::currency_conventer($item->price);
                                                $offer_price = \App\Utilities\Helper::currency_conventer($item->offer_price);
                                                $symbol = session('system_default_currency_info')->symbol;
                                            @endphp
                                            <h6 class="product-price">{{$offer_price}}{{$symbol}} <small><del class="text-danger">{{$price}}{{$symbol}}</del></small></h6>
                                                <div class="top_seller_product_rating">
                                                    @php
                                                    $reviews = $item->reviews;
                                                    $total_stars = 0;
                                                    foreach ($reviews as $review) {
                                                        $total_stars += $review->stars;
                                                    }
                                                    $avg_rating = 0;
                                                    if(count($reviews))
                                                    $avg_rating = $total_stars/count($reviews);
                                                @endphp
                                                    @for ($i = 0 ; $i < 5 ; $i++)
                                                    @if ($i<$avg_rating)
                                                      <i class="fa fa-star" aria-hidden="true"></i>
                                                    @else
                                                      <i class="far fa-star" aria-hidden="true"></i>
                                                    @endif
                                                    @endfor
                                                   <span class="text-muted">({{count($item->reviews)}} Reviews)</span>
                                                </div>
                
                                                <!-- Info -->
                                                <div
                                                    class="ts_product_add_to_cart_info mt-3 d-flex align-items-center justify-content-between">
                                                    <!-- Add to cart -->
                                                    <div class="ts_product_add_to_cart">
                                                        <a href="" data-quantity="1" data-product-id="{{$item->id}}" class="add-to-cart btn btn-primary me-2 py-1" data-toggle="tooltip" data-placement="top"
                                                            title="Add To Cart"><i
                                                                class="icofont-shopping-cart"></i></a>
                                                    </div>
                
                                                    <!-- Wishlist -->
                                                    <div class="ts_product_wishlist">
                                                        <a href="" class="add-to-wishlist" data-quantity="1" data-id="{{$item->id}}" id="add-to-wishlist-{{$item->id}}" data-toggle="tooltip"
                                                            data-placement="top" title="Wishlist"><i
                                                                class="icofont-heart"></i></a>
                                                    </div>
                
                                                    <!-- Compare -->
                                                    <div class="ts_product_compare">
                                                        <a href="compare.html" data-toggle="tooltip"
                                                            data-placement="top" title="Compare"><i
                                                                class="icofont-exchange"></i></a>
                                                    </div>
                
                                                    <!-- Quick View -->
                                                    <div class="ts_product_quick_view">
                                                        <a href="#" data-toggle="modal" data-target="#quickview{{$item->id}}"><i
                                                                class="icofont-eye-alt"></i></a>
                                                    </div>

                                    <!-- Quick View Modal Area -->
                                    <div class="modal fade" id="quickview{{$item->id}}" tabindex="-1" role="dialog" aria-labelledby="quickview" aria-hidden="true" data-backdrop="false" style="background:rgba(0, 0, 0, 0.5);z-index:99999999999;">
                                        <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
                                        <div class="modal-content">
                                            <button type="button" class="close btn" data-dismiss="modal" aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                            </button>
                                            <div class="modal-body">
                                            <div class="quickview_body">
                                                <div class="container">
                                                <div class="row">
                                                    <div class="col-12 col-lg-5">
                                                    <div class="quickview_pro_img">
                                                        <img class="first_img" src="{{$images[1]}}" alt="product photo">
                                                        <img class="hover_img" src="{{$images[0]}}" alt="product photo">
                                                        <div class="product_badge">
                                                        <span>{{$item->condition}}</span>
                                                        </div>
                                                    </div>
                                                    </div>
                                                    <div class="col-12 col-lg-7">
                                                    <div class="quickview_pro_des">
                                                        <h4 class="title">{{$item->title}}</h4>
                                                        <div class="top_seller_product_rating mb-15">
                                                        <i class="fa fa-star" aria-hidden="true"></i>
                                                        <i class="fa fa-star" aria-hidden="true"></i>
                                                        <i class="fa fa-star" aria-hidden="true"></i>
                                                        <i class="fa fa-star" aria-hidden="true"></i>
                                                        <i class="fa fa-star" aria-hidden="true"></i>
                                                        </div>
                                                        <h5 class="price">$120.99 <span>$130</span></h5>
                                                        <p>{!! html_entity_decode($item->summary)!!}</p>
                                                        <a href="{{route('products.details',$item->slug)}}">View Details</a>
                                                        <div class="d-flex align-items-center mt-15">
                                                        <div class="quantity me-2">
                                                            <input type="number" class="qty-text form-control" id="qty2" step="1" min="1" max="12" name="quantity" value="1" style="width: 70px;">
                                                        </div>
                                                        <a href="#" data-quantity="1" data-product-id="{{$item->id}}" class="add-to-cart btn btn-primary me-2 py-1">
                                                            <i class="icofont-shopping-cart"></i> Add to Cart
                                                        </a>
                                                        <div class="modal_pro_wishlist me-2">
                                                            <a href="" class="add-to-wishlist" data-quantity="1" data-id="{{$item->id}}" id="add-to-wishlist-{{$item->id}}"><i class="icofont-heart"></i></a>
                                                        </div>
                                                        <div class="modal_pro_compare">
                                                            <a href="compare.html"><i class="icofont-exchange"></i></a>
                                                        </div>
                                                        </div>
                                                        <div class="share_wf mt-15">
                                                        <p>Share with friends</p>
                                                        <div class="_icon">
                                                            <a href="#"><i class="fab fa-facebook" aria-hidden="true"></i></a>
                                                            <a href="#"><i class="fab fa-twitter" aria-hidden="true"></i></a>
                                                            <a href="#"><i class="fab fa-pinterest" aria-hidden="true"></i></a>
                                                            <a href="#"><i class="fab fa-linkedin" aria-hidden="true"></i></a>
                                                            <a href="#"><i class="fab fa-instagram" aria-hidden="true"></i></a>
                                                            <a href="#"><i class="fab fa-envelope-o" aria-hidden="true"></i></a>
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
                                    </div>
                                    <!-- Quick View Modal Area -->
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    @endforeach
                                </div>
                            </div>
                        </div>

                        <div role="tabpanel" class="tab-pane fade" id="best-rated">
                            <div class="best_rated_area">
                                <div class="row">
                                    @foreach ($best_rated as $item)    
                                    <div class="col-12 col-sm-6 col-lg-4">
                                        <div class="single_top_sellers">
                                            <div class="top_seller_image">
                
                                                <img src="{{asset($item->images->first()->url)}}" alt="Top-Sellers">
                                            </div>
                                            <div class="top_seller_desc">
                                                <h5>{{$item->title}}</h5>
                                                @php
                                                $price = \App\Utilities\Helper::currency_conventer($item->price);
                                                $offer_price = \App\Utilities\Helper::currency_conventer($item->offer_price);
                                                $symbol = session('system_default_currency_info')->symbol;
                                            @endphp
                                            <h6 class="product-price">{{$offer_price}}{{$symbol}} <small><del class="text-danger">{{$price}}{{$symbol}}</del></small></h6>
                                                <div class="top_seller_product_rating">
                                                    @php
                                                    $reviews = $item->reviews;
                                                    $total_stars = 0;
                                                    foreach ($reviews as $review) {
                                                        $total_stars += $review->stars;
                                                    }
                                                    $avg_rating = 0;
                                                    if(count($reviews))
                                                    $avg_rating = $total_stars/count($reviews);
                                                @endphp
                                                    @for ($i = 0 ; $i < 5 ; $i++)
                                                    @if ($i<$avg_rating)
                                                      <i class="fa fa-star" aria-hidden="true"></i>
                                                    @else
                                                      <i class="far fa-star" aria-hidden="true"></i>
                                                    @endif
                                                    @endfor
                                                   <span class="text-muted">({{count($item->reviews)}} Reviews)</span>
                                                </div>
                
                                                <!-- Info -->
                                                <div
                                                    class="ts_product_add_to_cart_info mt-3 d-flex align-items-center justify-content-between">
                                                    <!-- Add to cart -->
                                                    <div class="ts_product_add_to_cart">
                                                        <a href="" data-quantity="1" data-product-id="{{$item->id}}" class="add-to-cart btn btn-primary me-2 py-1" data-toggle="tooltip" data-placement="top"
                                                            title="Add To Cart"><i
                                                                class="icofont-shopping-cart"></i></a>
                                                    </div>
                
                                                    <!-- Wishlist -->
                                                    <div class="ts_product_wishlist">
                                                        <a href="" class="add-to-wishlist" data-quantity="1" data-id="{{$item->id}}" id="add-to-wishlist-{{$item->id}}" data-toggle="tooltip"
                                                            data-placement="top" title="Wishlist"><i
                                                                class="icofont-heart"></i></a>
                                                    </div>
                
                                                    <!-- Compare -->
                                                    <div class="ts_product_compare">
                                                        <a href="compare.html" data-toggle="tooltip"
                                                            data-placement="top" title="Compare"><i
                                                                class="icofont-exchange"></i></a>
                                                    </div>
                
                                                    <!-- Quick View -->
                                                    <div class="ts_product_quick_view">
                                                        <a href="#" data-toggle="modal" data-target="#quickview{{$item->id}}"><i
                                                                class="icofont-eye-alt"></i></a>
                                                    </div>

                                    <!-- Quick View Modal Area -->
                                    <div class="modal fade" id="quickview{{$item->id}}" tabindex="-1" role="dialog" aria-labelledby="quickview" aria-hidden="true" data-backdrop="false" style="background:rgba(0, 0, 0, 0.5);z-index:99999999999;">
                                        <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
                                        <div class="modal-content">
                                            <button type="button" class="close btn" data-dismiss="modal" aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                            </button>
                                            <div class="modal-body">
                                            <div class="quickview_body">
                                                <div class="container">
                                                <div class="row">
                                                    <div class="col-12 col-lg-5">
                                                    <div class="quickview_pro_img">
                                                        <img class="first_img" src="{{$images[1]}}" alt="product photo">
                                                        <img class="hover_img" src="{{$images[0]}}" alt="product photo">
                                                        <div class="product_badge">
                                                        <span>{{$item->condition}}</span>
                                                        </div>
                                                    </div>
                                                    </div>
                                                    <div class="col-12 col-lg-7">
                                                    <div class="quickview_pro_des">
                                                        <h4 class="title">{{$item->title}}</h4>
                                                        <div class="top_seller_product_rating mb-15">
                                                        <i class="fa fa-star" aria-hidden="true"></i>
                                                        <i class="fa fa-star" aria-hidden="true"></i>
                                                        <i class="fa fa-star" aria-hidden="true"></i>
                                                        <i class="fa fa-star" aria-hidden="true"></i>
                                                        <i class="fa fa-star" aria-hidden="true"></i>
                                                        </div>
                                                        <h5 class="price">$120.99 <span>$130</span></h5>
                                                        <p>{!! html_entity_decode($item->summary)!!}</p>
                                                        <a href="{{route('products.details',$item->slug)}}">View Details</a>
                                                        <div class="d-flex align-items-center mt-15">
                                                        <div class="quantity me-2">
                                                            <input type="number" class="qty-text form-control" id="qty2" step="1" min="1" max="12" name="quantity" value="1" style="width: 70px;">
                                                        </div>
                                                        <a href="#" data-quantity="1" data-product-id="{{$item->id}}" class="add-to-cart btn btn-primary me-2 py-1">
                                                            <i class="icofont-shopping-cart"></i> Add to Cart
                                                        </a>
                                                        <div class="modal_pro_wishlist me-2">
                                                            <a href="" class="add-to-wishlist" data-quantity="1" data-id="{{$item->id}}" id="add-to-wishlist-{{$item->id}}"><i class="icofont-heart"></i></a>
                                                        </div>
                                                        <div class="modal_pro_compare">
                                                            <a href="compare.html"><i class="icofont-exchange"></i></a>
                                                        </div>
                                                        </div>
                                                        <div class="share_wf mt-15">
                                                        <p>Share with friends</p>
                                                        <div class="_icon">
                                                            <a href="#"><i class="fab fa-facebook" aria-hidden="true"></i></a>
                                                            <a href="#"><i class="fab fa-twitter" aria-hidden="true"></i></a>
                                                            <a href="#"><i class="fab fa-pinterest" aria-hidden="true"></i></a>
                                                            <a href="#"><i class="fab fa-linkedin" aria-hidden="true"></i></a>
                                                            <a href="#"><i class="fab fa-instagram" aria-hidden="true"></i></a>
                                                            <a href="#"><i class="fab fa-envelope-o" aria-hidden="true"></i></a>
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
                                    </div>
                                    <!-- Quick View Modal Area -->
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    @endforeach
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<!-- Best Rated/Onsale/Top Sale Product Area -->

<!-- Offer Area -->
<section class="offer_area">
    <div class="container">
        <div class="row">
            <!-- Beach Offer -->
            <div class="col-12 col-md-6 col-lg-4">
                <div class="beach_offer_area mb-4 mb-md-0">
                    <img src="frontend/img/product-img/beach.png" alt="beach-offer">
                    <div class="beach_offer_info">
                        <p>Upto 70% OFF</p>
                        <h3>Beach Item</h3>
                        <a href="#" class="btn btn-primary btn-sm mt-15">SHOP NOW</a>
                    </div>
                </div>
            </div>

            <div class="col-12 col-md-6 col-lg-4">
                <!-- Apparels Offer -->
                <div class="apparels_offer_area">
                    <img src="frontend/img/product-img/apparels.jpg" alt="Beach-Offer">
                    <div class="apparels_offer_info d-flex align-items-center">
                        <div class="apparels-offer-content">
                            <h4>Apparel &amp; <br><span>Garments</span></h4>
                            <a href="#" class="btn">Buy Now <i class="icofont-rounded-right"></i></a>
                        </div>
                    </div>
                </div>

                <!-- Deals of the Week -->
                <div class="weekly_deals_area mt-30">
                    <img src="frontend/img/product-img/weekly-offer.jpg" alt="weekly-deals">
                    <div class="weekly_deals_info">
                        <h4>Deals of the Week</h4>
                        <div class="deals_timer">
                            <ul data-countdown="2021/02/14 14:21:38">
                                <!-- Please use event time this format: YYYY/MM/DD hh:mm:ss -->
                                <li><span class="days">00</span>days</li>
                                <li><span class="hours">00</span>hours</li>
                                <li class="d-block blank-timer"></li>
                                <li><span class="minutes">00</span>min</li>
                                <li><span class="seconds">00</span>sec</li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-12 col-lg-4">
                <div class="row">
                    <div class="col-12 col-sm-6 col-lg-12">
                        <!-- Elect Offer -->
                        <div class="elect_offer_area mt-30 mt-lg-0">
                            <img src="frontend/img/product-img/elect.jpg" alt="Elect-Offer">
                            <div class="elect_offer_info d-flex align-items-center">
                                <div class="elect-offer-content">
                                    <h4>Electronics</h4>
                                    <a href="#" class="btn">Buy Now <i class="icofont-rounded-right"></i></a>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-12 col-sm-6 col-lg-12">
                        <!-- Backpack Offer -->
                        <div class="backpack_offer_area mt-30">
                            <img src="frontend/img/product-img/backpack.jpg" alt="Backpack-Offer">
                            <div class="backpack_offer_info">
                                <h4>Backpacks</h4>
                                <a href="#" class="btn">Buy Now <i class="icofont-rounded-right"></i></a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<!-- Offer Area End -->

<!-- Popular Brands Area -->
@if(count($brands)>0)
<section class="popular_brands_area section_padding_100 ">
    <div class="container">
        <div class="row">
            <div class="col-12">
                <div class="popular_section_heading mb-50">
                    <h5>Popular Brands</h5>
                </div>
            </div>
            <div class="col-12">
                <div class="popular_brands_slide owl-carousel">
                    @foreach ($brands as $item)
                        
                    @endforeach
                    <div class="single_brands">
                        <img src="{{asset($item->photo)}}" alt="{{$item->title}}">
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
@endif
<!-- Popular Brands Area -->

<!-- Special Featured Area -->
<section class="special_feature_area pt-5">
    <div class="container">
        <div class="row">
            <!-- Single Feature Area -->
            <div class="col-12 col-sm-6 col-lg-3">
                <div class="single_feature_area mb-5 d-flex align-items-center">
                    <div class="feature_icon">
                        <i class="icofont-ship"></i>
                        <span><i class="icofont-check-alt"></i></span>
                    </div>
                    <div class="feature_content">
                        <h6>Free Shipping</h6>
                        <p>For orders above $100</p>
                    </div>
                </div>
            </div>

            <!-- Single Feature Area -->
            <div class="col-12 col-sm-6 col-lg-3">
                <div class="single_feature_area mb-5 d-flex align-items-center">
                    <div class="feature_icon">
                        <i class="icofont-box"></i>
                        <span><i class="icofont-check-alt"></i></span>
                    </div>
                    <div class="feature_content">
                        <h6>Happy Returns</h6>
                        <p>7 Days free Returns</p>
                    </div>
                </div>
            </div>

            <!-- Single Feature Area -->
            <div class="col-12 col-sm-6 col-lg-3">
                <div class="single_feature_area mb-5 d-flex align-items-center">
                    <div class="feature_icon">
                        <i class="icofont-money"></i>
                        <span><i class="icofont-check-alt"></i></span>
                    </div>
                    <div class="feature_content">
                        <h6>100% Money Back</h6>
                        <p>If product is damaged</p>
                    </div>
                </div>
            </div>

            <!-- Single Feature Area -->
            <div class="col-12 col-sm-6 col-lg-3">
                <div class="single_feature_area mb-5 d-flex align-items-center">
                    <div class="feature_icon">
                        <i class="icofont-live-support"></i>
                        <span><i class="icofont-check-alt"></i></span>
                    </div>
                    <div class="feature_content">
                        <h6>Dedicated Support</h6>
                        <p>We provide support 24/7</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<!-- Special Featured Area -->
@endsection



@section('scripts')

{{-- Add To Cart --}}
<script>
    $(document).on('click','.add-to-cart',function(e){
        e.preventDefault();
        var product_id = $(this).data('product-id');
        var product_qty = $(this).data('quantity');

        // alert(product_qty);

        var token = "{{csrf_token()}}";
        var path = "{{route('user.cart.store')}}";

        $.ajax({
            url:path,
            type:"POST",
            data:{
                '_token':token,
                'product_id':product_id,
                'product_qty':product_qty
            },
            beforeSend:function(){
                $('#add-to-cart'+product_id).html('<i class="fa fa-spinner fa-spin"></i> loading...');
            },
            complete:function(){
                $('#add-to-cart'+product_id).html('<i class="fa fa-cart-plus"></i> Add to cart');
            },
            success:function(data){
                // console.log(data);
                if(data['status']){
                    $('body #header-ajax').html(data['header']);
                    $('body #cart_counter').html(data['cart_count']);
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

{{-- Add To Wishlist --}}
<script>
    $(document).on('click','.add-to-wishlist',function(e){
        e.preventDefault();
        var product_id = $(this).data('id');
        var product_qty = $(this).data('quantity');

        // alert(product_qty);

        var token = "{{csrf_token()}}";
        var path = "{{route('user.wishlist.store')}}";

        $.ajax({
            url:path,
            type:"POST",
            data:{
                '_token':token,
                'product_id':product_id,
                'product_qty':product_qty
            },
            beforeSend:function(){
                $('#add-to-wishlist-'+product_id).html('<i class="fa fa-spinner fa-spin"></i>');
            },
            complete:function(){
                $('#add-to-wishlist-'+product_id).html('<i class="fas fa-heart"></i> Add to cart');
            },
            success:function(data){
                // console.log(data);
                if(data['status']){
                    $('body #header-ajax').html(data['header']);
                    $('body #wishlist_counter').html(data['wishlist_count']);
                    swal({
                    title: "Good job!",
                    text: data['message'],
                    icon: "success",
                    button: "Ok!",
                    });
                }
                else if(data['exists']){
                    $('body #header-ajax').html(data['header']);
                    $('body #wishlist_counter').html(data['wishlist_count']);
                    swal({
                    title: "Good job!",
                    text: data['message'],
                    icon: "warning",
                    button: "Ok!",
                    });
                }
                else{
                    swal({
                    title: "Sorry!",
                    text: "You can't add that product",
                    icon: "error",
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
@endsection