@extends('frontend.layouts.master')

@section('content')

<!-- Quick View Modal Area -->
<div class="modal fade" id="quickview" tabindex="-1" role="dialog" aria-labelledby="quickview" aria-hidden="true">
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
                                    <img class="first_img" src="img/product-img/new-1-back.png" alt="">
                                    <img class="hover_img" src="img/product-img/new-1.png" alt="">
                                    <!-- Product Badge -->
                                    <div class="product_badge">
                                        <span class="badge-new">New</span>
                                    </div>
                                </div>
                            </div>
                            <div class="col-12 col-lg-7">
                                <div class="quickview_pro_des">
                                    <h4 class="title">Boutique Silk Dress</h4>
                                    <div class="top_seller_product_rating mb-15">
                                        <i class="fa fa-star" aria-hidden="true"></i>
                                        <i class="fa fa-star" aria-hidden="true"></i>
                                        <i class="fa fa-star" aria-hidden="true"></i>
                                        <i class="fa fa-star" aria-hidden="true"></i>
                                        <i class="fa fa-star" aria-hidden="true"></i>
                                    </div>
                                    <h5 class="price">$120.99 <span>$130</span></h5>
                                    <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Mollitia expedita quibusdam aspernatur, sapiente consectetur accusantium perspiciatis praesentium eligendi, in fugiat?</p>
                                    <a href="#">View Full Product Details</a>
                                </div>
                                <!-- Add to Cart Form -->
                                <form class="cart" method="post">
                                    <div class="quantity">
                                        <input type="number" class="qty-text" id="qty" step="1" min="1" max="12" name="quantity" value="1">
                                    </div>
                                    <button type="submit" name="addtocart" value="5" class="cart-submit">Add to cart</button>
                                    <!-- Wishlist -->
                                    <div class="modal_pro_wishlist">
                                        <a href="wishlist.html"><i class="icofont-heart"></i></a>
                                    </div>
                                    <!-- Compare -->
                                    <div class="modal_pro_compare">
                                        <a href="compare.html"><i class="icofont-exchange"></i></a>
                                    </div>
                                </form>
                                <!-- Share -->
                                <div class="share_wf mt-30">
                                    <p>Share with friends</p>
                                    <div class="_icon">
                                        <a href="#"><i class="fa fa-facebook" aria-hidden="true"></i></a>
                                        <a href="#"><i class="fa fa-twitter" aria-hidden="true"></i></a>
                                        <a href="#"><i class="fa fa-pinterest" aria-hidden="true"></i></a>
                                        <a href="#"><i class="fa fa-linkedin" aria-hidden="true"></i></a>
                                        <a href="#"><i class="fa fa-instagram" aria-hidden="true"></i></a>
                                        <a href="#"><i class="fa fa-envelope-o" aria-hidden="true"></i></a>
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

<!-- Breadcumb Area -->
<div class="breadcumb_area">
    <div class="container h-100">
        <div class="row h-100 align-items-center">
            <div class="col-12">
                <h5>Shop Grid</h5>
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="index.html">Home</a></li>
                    <li class="breadcrumb-item active">Shop Grid</li>
                </ol>
            </div>
        </div>
    </div>
</div>
<!-- Breadcumb Area -->

<section class="shop_grid_area section_padding_100">
    <div class="container">
        <form id="filterForm" action="{{route('shop.filter')}}" method="POST">
            @csrf
            <div class="row">
                    <div class="col-12 col-sm-5 col-md-4 col-lg-3">
                        
                            <div class="shop_sidebar_area">
                                @if(count($categories) > 0)
                                <!-- Single Widget -->
                                <div class="widget catagory mb-30">
                                    <h6 class="widget-title">Product Categories</h6>
                                    <div class="widget-desc">
                                        @if(!empty($_GET['category']))
                                            @php
                                                $filter_categories = explode(',',$_GET['category']);
                                            @endphp
                                        @endif
                                        @foreach ($categories as $item)
                                        <!-- Single Checkbox -->
                                        <div class="custom-control custom-checkbox d-flex align-items-center mb-2">
                                            <input type="checkbox" {{!empty($filter_categories) && in_array($item->slug,$filter_categories)?'checked':''}} class="custom-control-input" id="{{$item->slug}}" name="category[]" onchange="this.form.submit();" value="{{$item->slug}}">
                                            <label class="custom-control-label" for="{{$item->slug}}">{{$item->title}} <span class="text-muted">({{count($item->products)}})</span></label>
                                        </div>
                                        @endforeach
                                    </div>
                                </div>
                                @endif

                                @php
                                    use App\Utilities\Helper;
                                @endphp

                                <!-- Single Widget -->
                                <div class="widget price mb-30">
                                    <h6 class="widget-title">Filter by Price</h6>
                                        <div class="widget-desc">
                                            <div class="slider-range">
                                                @php
                                                    $price = !empty($_GET['price']) ? explode('-', $_GET['price']) : [Helper::minPrice(), Helper::maxPrice()];
                                                    $minPrice = $price[0];
                                                    $maxPrice = $price[1];
                                                @endphp
                                                <div id="slider-range" 
                                                    data-min="{{ Helper::minPrice() }}" 
                                                    data-max="{{ Helper::maxPrice() }}" 
                                                    data-unit="$" 
                                                    class="slider-range-price ui-slider ui-slider-horizontal ui-widget ui-widget-content ui-corner-all">
                                                    <div class="ui-slider-range ui-widget-header ui-corner-all"></div>
                                                    <span class="ui-slider-handle ui-state-default ui-corner-all" tabindex="0"></span>
                                                    <span class="ui-slider-handle ui-state-default ui-corner-all" tabindex="0"></span>
                                                </div>
                                    
                                                <div class="d-flex mt-2 align-items-center justify-content-between">
                                                    <input type="hidden" id="minPrice" name="min_price" value="{{ $minPrice }}">
                                                    <input type="hidden" id="maxPrice" name="max_price" value="{{ $maxPrice }}">
                                                    <div class="range-price mx-2">
                                                        Price: $<span id="priceMin">{{ $minPrice }}</span> - $<span id="priceMax">{{ $maxPrice }}</span>
                                                    </div>
                                                    <button type="submit" class="btn btn-sm btn-primary">Filter</button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    {{-- CSS --}}
                                    <style>
                                                .widget {
                                                    background-color: #f8f9fa;
                                                    padding: 15px;
                                                    border-radius: 5px;
                                                    box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
                                                }
                                                
                                                .slider-range-price {
                                                    margin-bottom: 20px;
                                                }
                                                
                                                .ui-slider-range {
                                                    background: #007bff; /* Bootstrap primary color */
                                                }
                                                
                                                .ui-slider-handle {
                                                    background: #ffffff;
                                                    border: 2px solid #007bff; /* Bootstrap primary color */
                                                    width: 20px;
                                                    height: 20px;
                                                    cursor: pointer;
                                                }
                                                
                                                .range-price {
                                                    font-weight: bold;
                                                    font-size: 1.1em;
                                                    margin-right: auto; /* Pushes the button to the right */
                                                }
                                                
                                                .btn {
                                                    height: 30px; /* Match button height to the slider */
                                                }
                                                </style>
                                    {{-- End of CSS --}}
            
                                <!-- Single Widget -->
                                <div class="widget color mb-30">
                                    <h6 class="widget-title">Filter by Color</h6>
                                    <div class="widget-desc">
                                        <!-- Single Checkbox -->
                                        <div class="custom-control custom-checkbox d-flex align-items-center mb-2">
                                            <input type="checkbox" class="custom-control-input" id="customCheck6">
                                            <label class="custom-control-label black" for="customCheck6">Black <span class="text-muted">(9)</span></label>
                                        </div>
                                        <!-- Single Checkbox -->
                                        <div class="custom-control custom-checkbox d-flex align-items-center mb-2">
                                            <input type="checkbox" class="custom-control-input" id="customCheck7">
                                            <label class="custom-control-label pink" for="customCheck7">Pink <span class="text-muted">(6)</span></label>
                                        </div>
                                        <!-- Single Checkbox -->
                                        <div class="custom-control custom-checkbox d-flex align-items-center mb-2">
                                            <input type="checkbox" class="custom-control-input" id="customCheck8">
                                            <label class="custom-control-label red" for="customCheck8">Red <span class="text-muted">(8)</span></label>
                                        </div>
                                        <!-- Single Checkbox -->
                                        <div class="custom-control custom-checkbox d-flex align-items-center mb-2">
                                            <input type="checkbox" class="custom-control-input" id="customCheck9">
                                            <label class="custom-control-label purple" for="customCheck9">Purple <span class="text-muted">(4)</span></label>
                                        </div>
                                        <!-- Single Checkbox -->
                                        <div class="custom-control custom-checkbox d-flex align-items-center">
                                            <input type="checkbox" class="custom-control-input" id="customCheck10">
                                            <label class="custom-control-label orange" for="customCheck10">Orange <span class="text-muted">(7)</span></label>
                                        </div>
                                    </div>
                                </div>

                                @if(count($brands) > 0)
                                <!-- Single Widget -->
                                <div class="widget brands mb-30">
                                    <h6 class="widget-title">Filter by brands</h6>
                                    <div class="widget-desc">
                                        @if(!empty($_GET['brand']))
                                            @php
                                                $filter_brands = explode(',',$_GET['brand']);
                                            @endphp
                                        @endif
                                        @foreach($brands as $item)
                                        <!-- Single Checkbox -->
                                        <div class="custom-control custom-checkbox d-flex align-items-center">
                                            <input type="checkbox" {{!empty($filter_brands) && in_array($item->slug,$filter_brands)?'checked':''}} class="custom-control-input" id="{{$item->slug}}" name="brand[]" value="{{$item->slug}}" onchange="this.form.submit();">
                                            <label class="custom-control-label" for="{{$item->slug}}">{{$item->title}} <span class="text-muted">({{count($item->products)}})</span></label>
                                        </div>
                                        @endforeach
                                    </div>
                                </div>
                                @endif
            
                                <!-- Single Widget -->
                                <div class="widget rating mb-30">
                                    <h6 class="widget-title">Average Rating</h6>
                                    <div class="widget-desc">
                                        <ul>
                                            <li><a href="#"><i class="fa fa-star" aria-hidden="true"></i> <i class="fa fa-star" aria-hidden="true"></i> <i class="fa fa-star" aria-hidden="true"></i> <i class="fa fa-star" aria-hidden="true"></i> <i class="fa fa-star" aria-hidden="true"></i> <span class="text-muted">(103)</span></a></li>
            
                                            <li><a href="#"><i class="fa fa-star" aria-hidden="true"></i> <i class="fa fa-star" aria-hidden="true"></i> <i class="fa fa-star" aria-hidden="true"></i> <i class="fa fa-star" aria-hidden="true"></i> <i class="fa fa-star-o" aria-hidden="true"></i> <span class="text-muted">(78)</span></a></li>
            
                                            <li><a href="#"><i class="fa fa-star" aria-hidden="true"></i> <i class="fa fa-star" aria-hidden="true"></i> <i class="fa fa-star" aria-hidden="true"></i> <i class="fa fa-star-o" aria-hidden="true"></i> <i class="fa fa-star-o" aria-hidden="true"></i> <span class="text-muted">(47)</span></a></li>
            
                                            <li><a href="#"><i class="fa fa-star" aria-hidden="true"></i> <i class="fa fa-star" aria-hidden="true"></i> <i class="fa fa-star-o" aria-hidden="true"></i> <i class="fa fa-star-o" aria-hidden="true"></i> <i class="fa fa-star-o" aria-hidden="true"></i> <span class="text-muted">(9)</span></a></li>
            
                                            <li><a href="#"><i class="fa fa-star" aria-hidden="true"></i> <i class="fa fa-star-o" aria-hidden="true"></i> <i class="fa fa-star-o" aria-hidden="true"></i> <i class="fa fa-star-o" aria-hidden="true"></i> <i class="fa fa-star-o" aria-hidden="true"></i> <span class="text-muted">(3)</span></a></li>
                                        </ul>
                                    </div>
                                </div>
            
                                <!-- Single Widget -->
                                <div class="widget size mb-30">
                                    <h6 class="widget-title">Filter by Size</h6>
                                    <div class="widget-desc">
                                        <ul class="list-inline">
                                            <li class="list-inline-item">
                                                <a href="" onclick="setSizeAndSubmit('S'); return false;">S</a>
                                            </li>
                                            <li class="list-inline-item">
                                                <a href="" onclick="setSizeAndSubmit('M'); return false;">M</a>
                                            </li>
                                            <li class="list-inline-item">
                                                <a href="" onclick="setSizeAndSubmit('L'); return false;">L</a>
                                            </li>
                                            <li class="list-inline-item">
                                                <a href="" onclick="setSizeAndSubmit('XL'); return false;">XL</a>
                                            </li>
                                        </ul>
                                        <input type="hidden" name="size" id="selectedSize" value="">
                                    </div>
                                </div>
                            </div>
                    </div>

                    <div class="col-12 col-sm-7 col-md-8 col-lg-9">
                        <!-- Shop Top Sidebar -->
                        <div class="shop_top_sidebar_area d-flex flex-wrap align-items-center justify-content-between">
                            <div class="view_area d-flex">
                                <div class="grid_view">
                                    <a href="shop-grid-left-sidebar.html" data-toggle="tooltip" data-placement="top" title="Grid View"><i class="icofont-layout"></i></a>
                                </div>
                                <div class="list_view ml-3">
                                    <a href="shop-list-left-sidebar.html" data-toggle="tooltip" data-placement="top" title="List View"><i class="icofont-listine-dots"></i></a>
                                </div>
                            </div>
                            <select  name="sortBy" value="discAsc" onchange="this.form.submit();" class="small right">
                                <option value="" disabled {{ empty($_GET['sortBy']) ? 'selected' : '' }}>Default</option>
                                <option value="priceAsc" {{!empty($_GET['sortBy']) && $_GET['sortBy'] == 'priceAsc'?'selected':''}} >Price - Lower to Higher</option>
                                <option value="priceDesc" {{!empty($_GET['sortBy']) && $_GET['sortBy'] == 'priceDesc'?'selected':''}} >Price - Higher to Lower</option>
                                <option value="titleAsc" {{!empty($_GET['sortBy']) && $_GET['sortBy'] == 'titleAsc'?'selected':''}} >Alphabetical Ascending</option>
                                <option value="titleDesc" {{!empty($_GET['sortBy']) && $_GET['sortBy'] == 'titleDesc'?'selected':''}} >Alphabetical Descending</option>
                                <option value="discAsc" {{!empty($_GET['sortBy']) && $_GET['sortBy'] == 'discAsc'?'selected':''}} >Discount - Lower to Higher</option>
                                <option value="discDesc" {{!empty($_GET['sortBy']) && $_GET['sortBy'] == 'discDesc'?'selected':''}} >Discount - Higher to Lower</option>
                            </select>
                        </div>

                        <p>Total products : {{$products->total()}}</p>
        
                        <div class="shop_grid_product_area">
                            <div class="row justify-content-center">
                                @if(count($products)>0)
                                    @foreach ($products as $item)
                                        <div class="col-12 col-sm-6 col-md-4 col-lg-3">
                                        @include('frontend.pages.products.single-product',['item'=>$item])
                                        </div>
                                    @endforeach
                                @else
                                <p>No products found!</p>
                                @endif
                            </div>
                        </div>

                        <!-- Shop Pagination Area -->
                        <div class="shop_pagination_area mt-30">
                            <nav aria-label="Page navigation">
                                {{ $products->appends($_GET)->links() }} 
                            </nav>
                        </div>

                    </div>
            </div>
        </form>

    </div>
</section>

@endsection


@section('scripts')


{{-- Size select --}}

<script>
    function setSizeAndSubmit(size) {
        document.getElementById('selectedSize').value = size;
        document.getElementById('filterForm').submit();
    }
</script>

{{-- Price Slider --}}

<script>
    $(document).ready(function() {
        // Get the min and max values from the data attributes
        var minPrice = parseInt($("#minPrice").val());
        var maxPrice = parseInt($("#maxPrice").val());
    
        // Get the slider's min and max values
        var sliderMin = parseInt($("#slider-range").data("min"));
        var sliderMax = parseInt($("#slider-range").data("max"));
    
        // Initialize the slider
        $("#slider-range").slider({
            range: true,
            min: sliderMin,
            max: sliderMax,
            values: [minPrice, maxPrice],
            slide: function(event, ui) {
                // Update the hidden inputs and displayed price range
                $("#minPrice").val(ui.values[0]);
                $("#maxPrice").val(ui.values[1]);
                $("#priceMin").text(ui.values[0]);
                $("#priceMax").text(ui.values[1]);
            }
        });
    
        // Set initial values for the displayed price range
        $("#priceMin").text(minPrice);
        $("#priceMax").text(maxPrice);
    });
    </script>

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