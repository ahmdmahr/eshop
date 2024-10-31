    <!-- Top Header Area -->
    <div class="top-header-area">
        <div class="container h-100">
            <div class="row h-100 align-items-center">
                <div class="col-6">
                    <div class="welcome-note">
                        @php
                            use App\Models\Settings;
                            $currrent_settings = Settings::first();
                        @endphp
                        <span class="popover--text" data-toggle="popover"
                            data-content="Welcome to Bigshop ecommerce template."><i
                                class="icofont-info-square"></i></span>
                        <span class="text">Welcome to {{$currrent_settings->title}}</span>
                    </div>
                </div>
                <div class="col-6">
                    <div class="language-currency-dropdown d-flex align-items-center justify-content-end">
                        <!-- Language Dropdown -->
                        <div class="language-dropdown">
                            <div class="dropdown">
                                <a class="btn btn-sm dropdown-toggle" href="#" role="button" id="dropdownMenu1"
                                    data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                    English
                                </a>
                                <div class="dropdown-menu dropdown-menu-right" aria-labelledby="dropdownMenu1">
                                    <a class="dropdown-item" href="#">Arabic</a>
                                </div>
                            </div>
                        </div>

                        @php
                            use App\Models\Currency;
                            $currencies = Currency::where('status','active')->get();
                            \App\Utilities\Helper::currency_load();
                            $current_currency = session('currency_data');
                            if(empty($current_currency)){
                                $current_currency = session('system_default_currency_info');
                            }
                            // echo count($currencies);
                        @endphp
                        <!-- Currency Dropdown -->
                        <div class="currency-dropdown">
                            <div class="dropdown">
                                <a class="btn btn-sm dropdown-toggle" href="#" role="button" id="dropdownMenu2"
                                    data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                    {{$current_currency->symbol}} {{$current_currency->code}}
                                </a>
                                <div class="dropdown-menu dropdown-menu-right" aria-labelledby="dropdownMenu2">
                                    
                                    @foreach ($currencies as $item)
                                    <a class="dropdown-item" href="javascript:;" onclick="change_currency('{{$item->code}}');">{{$item->symbol}} {{$item->code}}</a>
                                    @endforeach
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Main Menu -->
    <div class="bigshop-main-menu">
        <div class="container">
            <div class="classy-nav-container breakpoint-off">
                <nav class="classy-navbar" id="bigshopNav">

                    <!-- Nav Brand -->
                    <a href="{{url('/')}}" class="nav-brand"><img src="{{$currrent_settings->logo}}" style="max-height:100px;max-width:100px" alt="logo"></a>

                    <!-- Toggler -->
                    <div class="classy-navbar-toggler">
                        <span class="navbarToggler"><span></span><span></span><span></span></span>
                    </div>

                    <!-- Menu -->
                    <div class="classy-menu">
                        <!-- Close -->
                        <div class="classycloseIcon">
                            <div class="cross-wrap"><span class="top"></span><span class="bottom"></span></div>
                        </div>

                        <!-- Nav -->
                        <div class="classynav">
                            <ul>
                                <li><a href="{{route('home')}}">Home</a>
                                </li>
                                <li><a href="{{route('shop.index')}}">Shop</a>
                                </li>
                                <li><a href="{{route('about.us')}}">About Us</a></li>
                                <li><a href="#">Pages</a>
                                    <div class="megamenu">
                                        <ul class="single-mega cn-col-4">
                                            <li><a href="faq.html">- FAQ</a></li>
                                            <li><a href="contact.html">- Contact</a></li>
                                            <li><a href="login.html">- Login &amp; Register</a></li>
                                            <li><a href="404.html">- 404</a></li>
                                            <li><a href="500.html">- 500</a></li>
                                        </ul>
                                        <ul class="single-mega cn-col-4">
                                            <li><a href="my-account.html">- Dashboard</a></li>
                                            <li><a href="order-list.html">- Orders</a></li>
                                            <li><a href="downloads.html">- Downloads</a></li>
                                            <li><a href="addresses.html">- Addresses</a></li>
                                            <li><a href="account-details.html">- Account Details</a></li>
                                            <li><a href="coming-soon.html">- Coming Soon</a></li>
                                        </ul>
                                        <div class="single-mega cn-col-2">
                                            <div class="megamenu-slides owl-carousel">
                                                <a href="shop-grid-left-sidebar.html">
                                                    <img src="frontend/img/bg-img/mega-slide-2.jpg" alt="">
                                                </a>
                                                <a href="shop-list-left-sidebar.html">
                                                    <img src="frontend/img/bg-img/mega-slide-1.jpg" alt="">
                                                </a>
                                            </div>
                                        </div>
                                    </div>
                                </li>
                                <li><a href="#">Blog</a>
                                    <ul class="dropdown">
                                        <li><a href="blog-with-left-sidebar.html">Blog Left Sidebar</a></li>
                                        <li><a href="blog-with-right-sidebar.html">Blog Right Sidebar</a></li>
                                        <li><a href="blog-with-no-sidebar.html">Blog No Sidebar</a></li>
                                        <li><a href="single-blog.html">Single Blog</a></li>
                                    </ul>
                                </li>
                                <li><a href="contact.html">Contact</a></li>
                            </ul>
                        </div>
                    </div>

                    <!-- Hero Meta -->
                    <div class="hero_meta_area ml-auto d-flex align-items-center justify-content-end">
                        <!-- Search -->
                        <div class="search-area">
                            <div class="search-btn"><i class="icofont-search"></i></div>
                            <!-- Form -->
                             <form action="{{route('products.search')}}" method="GET">
                                <div class="search-form">
                                    <input type="search" id="search_text" name="query" class="form-control" placeholder="Search">
                                    <button type="submit" class="btn btn-primary" style="margin-left: 5px;">
                                        Search
                                    </button>
    
                                    <style>
                                        .search-area {
                                            width: 100%;
                                        }
                                    
                                        .search-form {
                                            display: flex;
                                            align-items: center;
                                        }
                                    
                                        .form-control {
                                            flex-grow: 1;
                                            margin-right: 5px;
                                            padding: 10px;
                                        }
                                    
                                        .btn-primary {
                                            background-color: blue;
                                            color: white;
                                            border: none;
                                            padding: 10px 15px;
                                            cursor: pointer;
                                            display: flex; 
                                            align-items: center; 
                                            justify-content: center; 
                                            height: 100%; 
                                        }
                                    </style>
                                </div>
                             </form>
                        </div>
                        @php
                            use App\Models\Product;
                            use Gloudemans\Shoppingcart\Facades\Cart;
                            $wishlist_items = Cart::instance('wishlist')->content();
                        @endphp
                        <!-- Wishlist -->
                        <div class="wishlist-area">
                            <a href="{{route('user.wishlist.index')}}" class="wishlist-btn" id="wishlist_counter"><i class="icofont-heart"> </i></a>
                        </div>
                        <!-- Cart -->
                        @php
                            $cart_items = Cart::instance('shopping')->content();
                            $subtotal = Cart::instance('shopping')->subtotal();
                            // Convert to float from string
                            $subtotal = trim($subtotal); 
                            $subtotal = preg_replace('/[^\d.]/', '', $subtotal); 
                            $total = is_numeric($subtotal) ? (float)$subtotal : 0.0;
                            //End of Convert to float from string
                            $couponValue = session('coupon')['value'] ?? 0;
                        @endphp
                        <div class="cart-area">
                            <div class="cart--btn"><i class="icofont-cart"></i> <span class="cart_quantity" id="cart_counter">{{$cart_items->count()}}</span>
                            </div>

                            <!-- Cart Dropdown Content -->
                            <div class="cart-dropdown-content">
                                <ul class="cart-list">
                                    @foreach ($cart_items as $item)
                                        <li>
                                            <div class="cart-item-desc">
                                                <a href="#" class="image">
                                                    <img src="{{$item->model->images->first()->url}}" class="cart-thumb" alt="">
                                                </a>
                                                <div>
                                                    <a href="{{route('products.details',$item->model->slug)}}">{{$item->name}}</a>
                                                    <p>{{$item->qty}} x - <span class="price">${{$item->price}}</span></p>
                                                </div>
                                            </div>
                                            <span class="dropdown-product-remove delete-from-cart" data-id="{{$item->rowId}}"><i class="icofont-bin"></i></span>
                                        </li>
                                    @endforeach  
                                </ul>
                                <div class="cart-pricing my-4">
                                    <ul>
                                        <li>
                                            <span>Sub Total:</span>
                                            <span>${{$total}}</span>
                                        </li>
                                        <li>
                                            <span>Shipping:</span>
                                            <span>$30</span>
                                        </li>
                                        <li>
                                            <span>Discount:</span>
                                            <span>${{$couponValue}}</span>
                                        </li>
                                        <li>
                                            <span>Total:</span>
                                            @if(session()->has('coupon'))
                                              {{-- {{gettype($total)}} --}}
                                              <span>${{$total-$couponValue+30}}</span>
                                            @else
                                              <span>${{$total+30}}</span>
                                            @endif
                                        </li>
                                    </ul>
                                </div>
                                <div class="cart-box d-flex">

                                    <a href="{{route('user.cart.index')}}" class="btn btn-success btn-sm">Cart</a>
                                    <a href="{{route('user.checkout1')}}" class="btn btn-primary btn-sm " style="margin-left: auto;">Checkout</a>

                                </div>
                            </div>
                        </div>

                        <!-- Account -->

                        @php
                          use App\Utilities\Helper;
                        @endphp
                        
                        <div class="account-area">
                            <div class="user-thumbnail">
                            @auth
                                @if(auth()->user()->photo)
                                  <img src="{{auth()->user()->photo}}" alt="">   
                                @else
                                  <img src="{{Helper::userDefaultImage()}}" alt="">   
                                @endif
                            @endauth
                            @guest
                              <img src="{{asset('frontend/img/guest.png')}}" alt="">
                            @endguest
                            </div>
                            <ul class="user-meta-dropdown">
                                @if(Auth::check())   
                                @php
                                    $name = explode(' ',Auth::user()->full_name);
                                @endphp   
                                <li class="user-title"><span>Hello,</span> {{$name[0]}}!</li>
                                <li><a href="{{route('user.dashboard')}}">My Account</a></li>
                                <li><a href="{{route('user.orders.show')}}">Orders List</a></li>
                                <li><a href="wishlist.html">Wishlist</a></li>
                                <li>
                                    <a href="{{route('home')}}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                                        <i class="fas fa-sign-out-alt" aria-hidden="true"></i> Logout
                                    </a>
                                    <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                                        @csrf
                                    </form>
                                </li>
                                @else
                                <li><a href="{{route('login')}}"> Login</a></li>
                                <li><a href="{{route('register')}}">Sign Up</a></li>
                                @endif
                            </ul>
                        </div>
                    </div>
                </nav>
            </div>
        </div>
    </div>

@include('backend.layouts.notification')
