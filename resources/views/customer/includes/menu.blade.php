<div class="card card-body">
    <div class="list-group">
        <a href="{{ route('customer.dashboard') }}" class="list-group-item list-group-item-action {{ \Request::route()->getName() == 'customer.dashboard' ? 'active' : '' }}">Dashboard</a>
        <a href="{{ route('customer.profile') }}" class="list-group-item list-group-item-action {{ \Request::route()->getName() == 'customer.profile' ? 'active' : '' }}">Profile</a>
        <a href="{{ route('customer.order') }}" class="list-group-item list-group-item-action {{ \Request::route()->getName() == 'customer.order' ? 'active' : '' }}">Order</a>
        <a href="{{ route('customer.change.password') }}" class="list-group-item list-group-item-action {{ \Request::route()->getName() == 'customer.change.password' ? 'active' : '' }}">Change Password</a>
        <a href="{{ route('customer.logout') }}" class="list-group-item list-group-item-action {{ \Request::route()->getName() == 'customer.logout' ? 'active' : '' }}">Logout</a>
    </div>
</div>
