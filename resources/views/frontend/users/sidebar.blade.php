<ul>
    <li class="{{ url()->current() == route('users.dashboard') ? 'active' : '' }}"><a href="{{route('users.dashboard')}}">Dashboard</a></li>
    <li class="{{ url()->current() == route('users.orderlist') ? 'active' : '' }}"><a href="{{route('users.orderlist')}}">Orders</a></li>
    <li class="{{ url()->current() == route('users.addresses') ? 'active' : '' }}"><a href="{{route('users.addresses')}}">Addresses</a></li>
    <li class="{{ url()->current() == route('users.account-details') ? 'active' : '' }}"><a href="{{route('users.account-details')}}">Account Details</a></li>
    <li><a href="{{route('logout')}}">Logout</a></li>
</ul>