<ul>
    <li class="{{ url()->current() == route('user.dashboard') ? 'active' : '' }}"><a href="{{route('user.dashboard')}}">Dashboard</a></li>
    <li class="{{ url()->current() == route('user.orders.show') ? 'active' : '' }}"><a href="{{route('user.orders.show')}}">Orders</a></li>
    <li class="{{ url()->current() == route('user.addresses.show') ? 'active' : '' }}"><a href="{{route('user.addresses.show')}}">Addresses</a></li>
    <li class="{{ url()->current() == route('user.account.show') ? 'active' : '' }}"><a href="{{route('user.account.show')}}">Account Details</a></li>
    <li><a href="{{route('logout')}}">Logout</a></li>
</ul>