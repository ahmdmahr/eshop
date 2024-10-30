<div class="single-product-area mb-30">
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
                <a href="#" data-toggle="modal" data-target="#quickview{{$item->id}}"><i class="icofont-eye-alt"></i> Quick View</a>
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
<div class="modal fade" id="quickview{{$item->id}}" tabindex="-1" role="dialog" aria-labelledby="quickview"  aria-hidden="true" data-backdrop="false" style="background:rgba(0, 0, 0, 0.5);z-index:99999999999;">
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
                                                        
                                                        <!-- Product Badge -->
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
                                                        <p>{!! html_entity_decode($item->summary) !!}</p>
                                                        <a href="{{route('products.details',$item->slug)}}">View Full Product Details</a>
                                                    </div>
                                                    <!-- Add to Cart Form -->
                                                    <div class="d-flex align-items-center">
                                                        <div class="quantity me-2">
                                                            <input type="number" class="qty-text form-control" id="qty2" step="1" min="1" max="12" name="quantity" value="1" style="width: 70px;">
                                                        </div>
                                                        <a href="#" data-quantity="1" data-product-id="{{$item->id}}" class="add-to-cart btn btn-primary">
                                                            <i class="icofont-shopping-cart"></i> Add to Cart
                                                        </a>
                                                    </div>                                                    
                                                    <hr>

                                                    <!-- Wishlist -->
                                                    <div class="modal_pro_wishlist mb-2">
                                                        <a href="" class="add-to-wishlist" data-quantity="1" data-id="{{$item->id}}" id="add-to-wishlist-{{$item->id}}"><i class="icofont-heart"></i></a>
                                                    </div>
                                                        <!-- Compare -->
                                                        <div class="modal_pro_compare">
                                                            <a href="compare.html"><i class="icofont-exchange"></i></a>
                                                        </div>
                                                    
                                                    <!-- Share -->
                                                    <div class="share_wf mt-30">
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
                    <!-- Quick View Modal Area -->