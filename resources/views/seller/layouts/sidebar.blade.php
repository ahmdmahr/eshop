<div id="left-sidebar" class="sidebar">
    <div class="sidebar-scroll">
        <div class="user-account">
            <img src="{{asset('backend/assets/images/user.png')}}" class="rounded-circle user-photo" alt="User Profile Picture">
            <div class="dropdown">
                <span>Welcome,</span>
                <a href="" class="user-name" ><strong>{{auth()->user()->full_name}}</strong><span> @if(auth()->check() && auth()->user()->is_verified == 1)<i class="fas fa-check-circle text-success" data-toggle="tooltip" title="verified" data-placement="button"></i> @else <i class="fas fa-times-circle text-danger" data-toggle="tooltip" title="unverified" data-placement="bottom"></i>@endif</span></a>
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


                <li><a href="javascript:void(0);" class="has-arrow"><i class="icon-drawer"></i><span>Products Management</span> </a>
                    <ul>
                        <li><a href="{{route('vendor.products.index')}}">All Products</a></li>
                        <li><a href="{{route('vendor.products.create')}}">Add Product</a></li>
                    </ul>
                </li>
                
            </ul>
        </nav>
    </div>
</div>