<!-- Single Product -->
@foreach ($products as $item)
<div class="col-12 col-sm-6 col-md-4 col-lg-3">
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
                <a href="#" data-toggle="modal" data-target="#quickview"><i class="icofont-eye-alt"></i> Quick View</a>
            </div>

            <p class="brand_name">{{$item->brand->title}}</p>
            <a href="{{route('products.details',$item->slug)}}">{{$item->title}}</a>
            <h6 class="product-price">{{$item->offer_price}}$ <small><del class="text-danger">{{$item->price}}$</del></small></h6>
        </div>
    </div>
</div>
@endforeach