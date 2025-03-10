

        <!-- alert banner top -->
        {{-- <div role="alert" class="qc-top-site qc-top-site1 alert  fade in" style="background-image: url({{ asset('frontend/assets/images/media/index1/bg-qc-top.jpg') }});">
            <div class="container">
                <button class="close" type="button"><span aria-hidden="true">×</span></button>
                <div class="description">
                    <span class="title">Special Offer!</span>
                    <span class="subtitle">Rewarding all customers with a 15% discount. </span>
                    <span class="des">This offer is available from 9th December to 19th December 2015.</span>

                </div>
            </div>
        </div> --}}
        <!-- alert banner top -->


        <!-- HEADER -->
        <header class="site-header header-opt-1 cate-show">

            <!-- header-top -->
            <div class="header-top">
                <div class="container">

                    <!-- nav-left -->
                    <ul class="nav-left" >
                        <li ><span><i class="fa fa-phone" aria-hidden="true"></i>{{ siteInfo()->phone ?? '00-62-658-658' }}</span></li>
                        <li ><span><i class="fa fa-envelope" aria-hidden="true"></i> Contact us today !</span></li>
                        {{-- <li class="dropdown switcher  switcher-currency">
                            <a data-toggle="dropdown" role="button" href="#" class="dropdown-toggle switcher-trigger"><span>USD</span> <i aria-hidden="true" class="fa fa-angle-down"></i></a>
                            <ul class="dropdown-menu switcher-options ">
                                <li class="switcher-option">
                                    <a href="#">
                                        <i class="fa fa-usd" aria-hidden="true"></i> USD
                                    </a>
                                </li>
                                <li class="switcher-option">
                                    <a href="#">
                                        <i class="fa fa-eur" aria-hidden="true"></i> eur
                                    </a>
                                </li>
                                <li class="switcher-option">
                                    <a href="#">
                                        <i class="fa fa-gbp" aria-hidden="true"></i> gbp
                                    </a>
                                </li>
                            </ul>
                        </li> --}}
                        {{-- <li class="dropdown switcher  switcher-language">
                            <a data-toggle="dropdown" role="button" href="#" class="dropdown-toggle switcher-trigger" aria-expanded="false">
                                <img class="switcher-flag" alt="flag" src="{{ asset('frontend/assets/images/flags/flag_english.png') }}">
                                <span>English</span>
                                <i aria-hidden="true" class="fa fa-angle-down"></i>
                            </a>
                            <ul class="dropdown-menu switcher-options ">
                                <li class="switcher-option">
                                    <a href="#">
                                        <img class="switcher-flag" alt="flag" src="{{ asset('frontend/assets/images/flags/flag_english.png') }}">English
                                    </a>
                                </li>
                                <li class="switcher-option">
                                    <a href="#">
                                        <img class="switcher-flag" alt="flag" src="{{ asset('frontend/assets/images/flags/flag_french.png') }}">French
                                    </a>
                                </li>
                                <li class="switcher-option">
                                    <a href="#">
                                        <img class="switcher-flag" alt="flag" src="{{ asset('frontend/assets/images/flags/flag_germany.png') }}">Germany
                                    </a>
                                </li>
                            </ul>
                        </li> --}}
                    </ul>
                    <!-- nav-left -->

                    <!-- nav-right -->
                    <ul class="nav-right">
                        @if (Auth::check())
                            <li class="dropdown setting">
                                <a data-toggle="dropdown" role="button" href="#" class="dropdown-toggle"><span>My Account</span> <i aria-hidden="true" class="fa fa-angle-down"></i></a>
                                <div class="dropdown-menu">
                                    <ul class="account">
                                        <li><a href="{{ route('customer.dashboard') }}">My Account</a></li>
                                        <li><a href="">Wishlist</a></li>
                                        <li><a href="{{ route('checkout.index') }}">Checkout</a></li>
                                        <li>
                                            <a href="{{ route('logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                                            Logout
                                            </a>
                                        </li>
                                        <form id="logout-form" method="POST" action="{{ route('logout') }}">
                                            @csrf
                                        </form>
                                    </ul>
                                </div>
                            </li>
                        @else
                            <li><a href="{{ route('login') }}">Login/Register</a></li>
                        @endif
                        <li><a href="">Services</a></li>
                        <li><a href="">Support</a></li>
                    </ul>

                    <!-- nav-right -->

                </div>
            </div><!-- header-top -->

            <!-- header-content -->
            <div class="header-content">
                <div class="container">

                    <div class="row">

                        <div class="col-md-3 nav-left">

                            <!-- logo -->
                            <strong class="logo">
                                <a href="{{ route('home') }}"><img src="{{ asset(siteInfo()->site_logo ?? 'frontend/assets/images/media/index1/logo.png') }}" alt="logo"></a>
                            </strong>

                        </div>

                        <div class="nav-right">

                            <!-- block mini cart -->
                            <div class="block-minicart dropdown">
                                <a class="dropdown-toggle" href="#" role="button" data-toggle="dropdown">
                                    <span class="cart-icon"></span>
                                    <span class="counter qty">
                                        <span class="cart-text">Shopping Cart</span>
                                        <span class="counter-number">0</span>
                                        <span class="counter-label">0 <span>Items</span></span>
                                        <span class="counter-price">$0.00</span>
                                    </span>
                                </a>
                                <div class="dropdown-menu">
                                    <form>
                                        <div  class="minicart-content-wrapper" >
                                            <div class="subtitle">
                                                You have 0 item(s) in your cart
                                            </div>
                                            <div class="minicart-items-wrapper">
                                                <ol class="minicart-items">
                                                    <li class="product-item">
                                                        <p class="text-center">No Item...</p>
                                                    </li>
                                                </ol>
                                            </div>
                                            <div class="subtotal">
                                                <span class="label">Total</span>
                                                <span class="price">$0</span>
                                            </div>
                                            <div class="actions">
                                                <a href="{{ route('checkout.index') }}" class="btn btn-default mt-20">Checkout</a>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                            </div>

                        </div>

                        <div class="nav-mind">

                            <!-- block search -->
                            <div class="block-search">
                                <div class="block-title">
                                    <span>Search</span>
                                </div>
                                <div class="block-content">
                                    <div class="categori-search  ">
                                        <select data-placeholder="All Categories" class="categori-search-option">
                                            <option value="">All Categories</option>
                                            @foreach ($categories as $key => $category)
                                                <option value="{{ $category->id }}">{{ $category->name }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="form-search">
                                        <form>
                                            <div class="box-group">
                                                <input type="text" class="form-control" placeholder="i'm Searching for...">
                                                <button class="btn btn-search" type="button"><span>search</span></button>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>

                        </div>

                    </div>

                </div>
            </div><!-- header-content -->

            <!-- header-nav -->
            <div class="header-nav mid-header">
                <div class="container">

                    <div class="box-header-nav">

                        <!-- btn categori mobile -->
                        <span data-action="toggle-nav-cat" class="nav-toggle-menu nav-toggle-cat"><span>Categories</span></span>

                        <!-- btn menu mobile -->
                        <span data-action="toggle-nav" class="nav-toggle-menu"><span>Menu</span></span>

                        <!--categori  -->
                        <div class="block-nav-categori">

                            <div class="block-title">
                                <span>Categories</span>
                            </div>

                            <div class="block-content">
                                <div class="clearfix"><span data-action="close-cat" class="close-cate"><span>Categories</span></span></div>
                                <ul class="ui-categori">
                                    @foreach (category() as $key => $category)
                                        <!-- Apply 'cat-link-orther' class to items after the 10th one -->
                                        <li class="parent {{ $key >= 11 ? 'cat-link-orther' : '' }}">
                                            <a href="{{ route('category.show', $category->slug) }}?cat_id={{ $category->id }}">
                                                <span class="icon">
                                                    <img src="{{ asset($category->image) }}" alt="{{ $category->name }}">
                                                </span>
                                                {{ $category->name }}
                                            </a>

                                            @if ($category->subcategories->isNotEmpty())
                                                <span class="toggle-submenu"></span>
                                                <div class="submenu" style="">
                                                    <ul class="categori-list clearfix">
                                                        @foreach ($category->subcategories as $subcategory)
                                                        <li class="col-sm-3">
                                                            <strong class="title"><a href="{{ route('subcategory.show', $subcategory->slug) }}?subcat_id={{ $subcategory->id }}">{{ $subcategory->name }}</a></strong>

                                                            @if ($subcategory->childcategories->isNotEmpty())
                                                                <ul>
                                                                    @foreach ($subcategory->childcategories as $childcategory)
                                                                        <li><a href="{{ route('childcategory.show', $childcategory->slug) }}?childcat_id={{ $childcategory->id }}">{{ $childcategory->name }}</a></li>

                                                                    @endforeach
                                                                </ul>
                                                            @endif
                                                        </li>
                                                        @endforeach
                                                    </ul>
                                                </div>
                                            @else
                                                <span class="toggle-submenu"></span>
                                                <div class="submenu">
                                                    <p class="text-center text-danger mb-0">Category Not Found!</p>
                                                </div>
                                            @endif
                                        </li>
                                    @endforeach
                                </ul>

                                <div class="view-all-categori">
                                    <a  class="open-cate btn-view-all">All Categories</a>
                                </div>

                            </div>

                        </div><!--categori  -->

                        <!-- menu -->
                        <div class="block-nav-menu">
                            <div class="clearfix"><span data-action="close-nav" class="close-nav"><span>close</span></span></div>

                            <ul class="ui-menu">
                                <li class="{{ Route::currentRouteName() == 'home' ? 'active' : '' }}">
                                    <a href="{{ route('home') }}">Home</a>
                                </li>
                                <li class="{{ Route::currentRouteName() == 'shop' ? 'active' : '' }}">
                                    <a href="{{ route('shop') }}">Shop</a>
                                </li>

                                @foreach (category() as $category)

                                    <li class="parent parent-megamenu {{ request()->get('cat_id') == $category->id ? 'active' : '' }}">
                                        <a href="{{ route('category.show', $category->slug) }}?cat_id={{ $category->id }}" >{{ $category->name }}  <span class="label-menu"></span></a>

                                        @if ($category->subcategories->isNotEmpty())
                                            <span class="toggle-submenu"></span>
                                            <div class="megamenu drop-menu">
                                                <ul>
                                                    @foreach ($category->subcategories as $subcategory)
                                                        <li class="col-md-3">
                                                            <div class="img-categori">
                                                                <a href="{{ route('subcategory.show', $subcategory->slug) }}?subcat_id={{ $subcategory->id }}"><img alt="img" src="{{ asset($subcategory->image ?? 'frontend/assets/images/media/index1/img-categori1.jpg') }}"></a>
                                                            </div>
                                                            <strong class="title"><a href="{{ route('subcategory.show', $subcategory->slug) }}?subcat_id={{ $subcategory->id }}"><span>{{ $subcategory->name }}</span></a></strong>
                                                            <ul class="list-submenu">
                                                                @foreach ($subcategory->childcategories as $childcategory )
                                                                    <li><a href="{{ route('childcategory.show', $childcategory->slug) }}?childcat_id={{ $childcategory->id }}">{{ $childcategory->name }}</a></li>
                                                                @endforeach
                                                            </ul>
                                                        </li>
                                                    @endforeach
                                                </ul>
                                            </div>
                                        @endif
                                    </li>

                                @endforeach

                                <li class="{{ Route::currentRouteName() == 'checkout.index' ? 'active' : '' }}">
                                    <a href="{{ route('checkout.index') }}">Checkout</a>
                                </li>

                            </ul>

                        </div><!-- menu -->

                        <!-- mini cart -->
                        <div class="block-minicart dropdown ">

                            <a class="dropdown-toggle" href="#" role="button" data-toggle="dropdown">
                                <span class="cart-icon"></span>
                                <span class="counter qty">
                                    <span class="counter-number floating">0</span>
                                </span>
                            </a>

                            <div class="dropdown-menu">
                                <form>
                                    <div  class="minicart-content-wrapper">
                                        <div class="subtitle">
                                            You have 0 item(s) in your cart
                                        </div>
                                        <div class="minicart-items-wrapper">
                                            <ol class="minicart-items">
                                                <li class="product-item">
                                                    <p class="text-center">No Item...</p>
                                                </li>
                                            </ol>
                                        </div>
                                        <div class="subtotal">
                                            <span class="label">Total</span>
                                            <span class="price">$0</span>
                                        </div>
                                        <div class="actions">
                                            <a href="{{ route('checkout.index') }}" class="btn btn-default mt-20">Checkout</a>
                                        </div>
                                    </div>
                                </form>
                            </div>

                        </div>

                        <!-- search -->
                        <div class="block-search">
                            <div class="block-title">
                                <span>Search</span>
                            </div>
                            <div class="block-content">
                                <div class="form-search">
                                    <form>
                                        <div class="box-group">
                                            <input type="text" class="form-control" placeholder="i'm Searching for...">
                                            <button class="btn btn-search" type="button"><span>search</span></button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div><!-- search -->

                        <!--setting  -->
                        <div class="dropdown setting">
                            <a data-toggle="dropdown" role="button" href="#" class="dropdown-toggle "><span>Settings</span> <i aria-hidden="true" class="fa fa-user"></i></a>
                            <div class="dropdown-menu  ">
                                <div class="switcher  switcher-language">
                                    <strong class="title">Select language</strong>
                                    <ul class="switcher-options ">
                                        <li class="switcher-option">
                                            <a href="#">
                                                <img class="switcher-flag" alt="flag" src="{{ asset('frontend/assets/images/flags/flag_french.png') }}">
                                            </a>
                                        </li>
                                        <li class="switcher-option">
                                            <a href="#">
                                                <img class="switcher-flag" alt="flag" src="{{ asset('frontend/assets/images/flags/flag_germany.png') }}">
                                            </a>
                                        </li>
                                        <li class="switcher-option">
                                            <a href="#">
                                                <img class="switcher-flag" alt="flag" src="{{ asset('frontend/assets/images/flags/flag_english.png') }}">
                                            </a>
                                        </li>
                                        <li class="switcher-option switcher-active">
                                            <a href="#">
                                                <img class="switcher-flag" alt="flag" src="{{ asset('frontend/assets/images/flags/flag_spain.png') }}">
                                            </a>
                                        </li>
                                    </ul>
                                </div>
                                <div class="switcher  switcher-currency">
                                    <strong class="title">SELECT CURRENCIES</strong>
                                    <ul class="switcher-options ">
                                        <li class="switcher-option">
                                            <a href="#">
                                                <i class="fa fa-usd" aria-hidden="true"></i>
                                            </a>
                                        </li>
                                        <li class="switcher-option switcher-active">
                                            <a href="#">
                                                <i class="fa fa-eur" aria-hidden="true"></i>
                                            </a>
                                        </li>
                                        <li class="switcher-option">
                                            <a href="#">
                                                <i class="fa fa-gbp" aria-hidden="true"></i>
                                            </a>
                                        </li>

                                    </ul>
                                </div>
                                <ul class="account">
                                    <li><a href="">Wishlist</a></li>
                                    <li><a href="">My Account</a></li>
                                    <li><a href="{{ route('checkout.index') }}">Checkout</a></li>
                                    <li><a href="">Compare</a></li>
                                    <li><a href="{{ route('login') }}">Login/Register</a></li>
                                </ul>
                            </div>
                        </div><!--setting  -->

                    </div>
                </div>
            </div><!-- header-nav -->

        </header><!-- end HEADER -->
