<div id="left-sidebar" class="sidebar">
    <div class="sidebar-scroll">
        <div class="user-account">
            <img src="{{asset('backend/assets/images/user.png')}}" class="rounded-circle user-photo" alt="User Profile Picture">
            <div class="dropdown">
                <span>Welcome,</span>
                <a href="" class="user-name" ><strong>{{auth()->user()->full_name}}</strong></a>
            </div>
            <hr>
        </div>

        <!-- Tab panes -->
        <nav class="sidebar-nav">
            <ul class="main-menu metismenu">
                
                <li><a href="javascript:void(0);" class="has-arrow"><i class="icon-grid"></i><span>Dashboard</span> </a>
                    <ul>
                        <li><a href="departments.html">All Departments</a></li>
                        <li><a href="add-departments.html">Add Department</a></li>
                    </ul>
                </li>

                <li><a href="javascript:void(0);" class="has-arrow"><i class="fas fa-images"></i><span>Banners Management</span> </a>
                    <ul>
                        <li><a href="{{route('admin.banners.index')}}">All Banners</a></li>
                        <li><a href="{{route('admin.banners.create')}}">Add Banner</a></li>
                    </ul>
                </li>

                <li><a href="javascript:void(0);" class="has-arrow"><i class="fas fa-table"></i><span>Category Management</span> </a>
                    <ul>
                        <li><a href="{{route('admin.categories.index')}}">All Categories</a></li>
                        <li><a href="{{route('admin.categories.create')}}">Add Category</a></li>
                    </ul>
                </li>

                <li><a href="javascript:void(0);" class="has-arrow"><i class="icon-handbag"></i><span>Brand Management</span> </a>
                    <ul>
                        <li><a href="{{route('admin.brands.index')}}">All Brands</a></li>
                        <li><a href="{{route('admin.brands.create')}}">Add Brand</a></li>
                    </ul>
                </li>

                <li><a href="javascript:void(0);" class="has-arrow"><i class="icon-users"></i><span>Products Management</span> </a>
                    <ul>
                        <li><a href="{{route('admin.products.index')}}">All Products</a></li>
                        <li><a href="{{route('admin.products.create')}}">Add Product</a></li>
                    </ul>
                </li>


                <li><a href="javascript:void(0);" class="has-arrow"><i class="fas fa-truck"></i><span>Shippings Management</span> </a>
                    <ul>
                        <li><a href="{{route('admin.shippings.index')}}">All Shippings</a></li>
                        <li><a href="{{route('admin.shippings.create')}}">Add Shipping</a></li>
                    </ul>
                </li>

                <li><a href="javascript:void(0);" class="has-arrow"><i class="fas fa-money-bill-alt"></i><span>Currencies Management</span> </a>
                    <ul>
                        <li><a href="{{route('admin.currencies.index')}}">All currencies</a></li>
                        <li><a href="{{route('admin.currencies.create')}}">Add Currency</a></li>
                    </ul>
                </li>

                <li><a href="{{route('admin.orders.index')}}"><i class="icon-layers"></i>Order Management</a></li>


                <li><a href="javascript:void(0);" class="has-arrow"><i class="fas fa-sitemap"></i><span>Post Category</span> </a>
                    <ul>
                        <li><a href="departments.html">All Banners</a></li>
                        <li><a href="add-departments.html">Add Banner</a></li>
                    </ul>
                </li>

                <li><a href="javascript:void(0);" class="has-arrow"><i class="icon-tag"></i><span>Post Tags</span> </a>
                    <ul>
                        <li><a href="departments.html">All Banners</a></li>
                        <li><a href="add-departments.html">Add Banner</a></li>
                    </ul>
                </li>

                <li><a href="javascript:void(0);" class="has-arrow"><i class="icon-bulb"></i><span>Post Management</span> </a>
                    <ul>
                        <li><a href="departments.html">All Banners</a></li>
                        <li><a href="add-departments.html">Add Banner</a></li>
                    </ul>
                </li>

                <li><a href="javascript:void(0);" class="has-arrow"><i class="icon-star"></i><span>Review Management</span> </a>
                    <ul>
                        <li><a href="departments.html">All Banners</a></li>
                        <li><a href="add-departments.html">Add Banner</a></li>
                    </ul>
                </li>

                <li><a href="javascript:void(0);" class="has-arrow"><i class="icon-magic-wand"></i><span>Coupon Management</span> </a>
                    <ul>
                        <li><a href="{{route('admin.coupons.index')}}">All Coupons</a></li>
                        <li><a href="{{route('admin.coupons.create')}}">Add Coupon</a></li>
                    </ul>
                </li>

                <li><a href="javascript:void(0);" class="has-arrow"><i class="fas fa-users"></i><span>User Management</span> </a>
                    <ul>
                        <li><a href="{{route('admin.users.index')}}">All Users</a></li>
                        <li><a href="{{route('admin.users.create')}}">Add User</a></li>
                    </ul>
                </li>

                <li><a href="javascript:void(0);" class="has-arrow"><i class="fas fa-comments"></i><span>Comments Management</span> </a>
                    <ul>
                        <li><a href="departments.html">All Banners</a></li>
                        <li><a href="add-departments.html">Add Banner</a></li>
                    </ul>
                </li>

                <li><a href="{{route('admin.settings')}}"><i class="icon-settings"></i>Settings</a></li>

            </ul>
        </nav>
    </div>
</div>