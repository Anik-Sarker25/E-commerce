
 <!-- Block  bestseller products-->
 <div class="block-sidebar block-sidebar-categorie">
    <p class="user">hello, {{ $user->name }}</p>

    <div class="block-content">
        <ul class="custom-menu">
            <li class="list-item">
                <a class="upper-item {{ (Request::is('customer/dashboard')) ? 'active' : '' }}" href="{{ route('customer.dashboard') }}">Manage Account</a>
                <ul>
                    <li>
                        <a class="lower-item {{ (Request::is('customer/profile*')) ? 'active' : '' }}" href="{{ route('customer.profile.index') }}">My Profile</a>
                    </li>
                    <li>
                        <a class="lower-item  {{ (Request::is('customer/address-book*')) ? 'active' : '' }}" href="{{ route('customer.addressBook.index') }}">Address Book</a>
                    </li>
                </ul>
            </li>
            <li class="list-item">
                <a class="upper-item {{ (Request::is('customer/order')) ? 'active' : '' }}" href="{{ route('customer.order.index') }}">My Orders</a>
                <ul>
                    <li><a href="#">My Returns</a></li>
                    <li><a href="#">Order Cancellations</a></li>
                </ul>
            </li>
            <li class="list-item">
                <a class="upper-item" href="#">My Reviews</a>
            </li>
            <li class="list-item">
                <a class="upper-item" href="#">My Wishlists</a>
            </li>
            <li class="list-item">
                <a class="upper-item" href="{{ route('logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                Logout
                </a>
                <form id="logout-form" method="POST" action="{{ route('logout') }}">
                    @csrf
                </form>
            </li>

        </ul>
    </div>
</div>
<!-- Block  bestseller products-->
