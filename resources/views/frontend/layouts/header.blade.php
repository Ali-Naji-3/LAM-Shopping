<header class="version_1">
    <div class="layer"></div><!-- Mobile menu overlay mask -->
    <div class="main_header">
        <div class="container">
            <div class="row small-gutters">
                <div class="col-xl-3 col-lg-3 d-lg-flex align-items-center">
                    <div id="logo">
                        <a href="{{ url('/') }}"><img src="img/logo.svg" alt="" width="100"
                                height="35"></a>
                    </div>
                </div>
                <nav class="col-xl-6 col-lg-7">
                    <a class="open_close" href="javascript:void(0);">
                        <div class="hamburger hamburger--spin">
                            <div class="hamburger-box">
                                <div class="hamburger-inner"></div>
                            </div>
                        </div>
                    </a>
                    <!-- Mobile menu button -->
                    <div class="main-menu">
                        <div id="header_menu">
                            <a href="{{ url('/') }}"><img src="img/logo_black.svg" alt="" width="100"
                                    height="35"></a>
                            <a href="#" class="open_close" id="close_in"><i class="ti-close"></i></a>
                        </div>
                        <ul>
                            <li>
                                <a href="{{ url('/') }}">Home</a>
                            </li>
                            <li>
                                <a href="{{ url('listing-grid-3') }}">Men</a>
                            </li>
                            <li>
                                <a href="{{ url('listing-grid-1-full') }}">Woman</a>
                            </li>
                            <li>
                                <a href="{{ url('listing-grid-2-full') }}">Boys</a>
                            </li>
                            <li>
                                <a href="{{ url('girls') }}">Girls</a>
                            </li>
                        </ul>
                    </div>
                    <!--/main-menu -->
                </nav>
                <div class="col-xl-3 col-lg-2 d-lg-flex align-items-center justify-content-end text-end">
                    <a class="phone_top" href="tel://9438843343"><strong><span>Need Help?</span>+94
                            423-23-221</strong></a>
                </div>
            </div>
            <!-- /row -->
        </div>
    </div>
    <!-- /main_header -->

    <div class="main_nav Sticky">
        <div class="container">
            <div class="row small-gutters">
                <div class="col-xl-3 col-lg-3 col-md-3">
                    <nav class="categories">
                        <ul class="clearfix">
                            <li><span>
                                    <a href="#">
                                        <span class="hamburger hamburger--spin">
                                            <span class="hamburger-box">
                                                <span class="hamburger-inner"></span>
                                            </span>
                                        </span>
                                        Categories
                                    </a>
                                </span>
                                <div id="menu">
                                    <ul>
                                        <li><span><a
                                                    href="{{ url('listing-grid-7-sidebar-right') }}">Collections</a></span>
                                        </li>
                                        <li><span><a href="{{ url('listing-grid-3') }}">Men</a></span></li>
                                        <li><span><a href="{{ url('listing-grid-1-full') }}">Women</a></span></li>
                                        <li><span><a href="{{ url('listing-grid-2-full') }}">Boys</a></span></li>
                                        <li><span><a href="{{ url('girls') }}">Girls</a></span></li>
                                    </ul>
                                </div>
                            </li>
                        </ul>
                    </nav>
                </div>
                <div class="col-xl-6 col-lg-7 col-md-6 d-none d-md-block">
                    <div class="custom-search-input">
                        <input type="text" placeholder="Search over 10.000 products">
                        <button type="submit"><i class="header-icon_search_custom"></i></button>
                    </div>
                </div>
                <div class="col-xl-3 col-lg-2 col-md-3">
                    <ul class="top_tools">
                        <li>
                            <div class="dropdown dropdown-cart">
                                <a href="{{ url('cart') }}" class="cart_bt">
       <span id="cart-count" class="badge"
          data-count="{{ collect(session('cart', []))->sum('qty') ?? 0 }}"
          aria-hidden="{{ collect(session('cart', []))->sum('qty') ? 'false' : 'true' }}">
        {{ collect(session('cart', []))->sum('qty') ?? 0 }}
    </span>


                                </a>
                                <div class="dropdown-menu">
                                    <ul>
                                        <li>
                                            <a href="{{ url('product-detail-2') }}">
                                                <figure><img src="img/products/product_placeholder_square_small.jpg"
                                                        data-src="img/products/shoes/thumb/1.jpg" alt=""
                                                        width="50" height="50" class="lazy"></figure>
                                                <strong><span>1x Armor Air x Fear</span>$90.00</strong>
                                            </a>
                                            <a href="#0" class="action"><i class="ti-trash"></i></a>
                                        </li>
                                        <li>
                                            <a href="{{ url('product-detail-2') }}">
                                                <figure><img src="img/products/product_placeholder_square_small.jpg"
                                                        data-src="img/products/shoes/thumb/2.jpg" alt=""
                                                        width="50" height="50" class="lazy"></figure>
                                                <strong><span>1x Armor Okwahn II</span>$110.00</strong>
                                            </a>
                                            <a href="0" class="action"><i class="ti-trash"></i></a>
                                        </li>
                                    </ul>
                                    <div class="total_drop">
                                        <div class="clearfix"><strong>Total</strong><span>$200.00</span></div>
                                        <a href="{{ url('cart') }}" class="btn_1 outline">View Cart</a><a
                                            href="{{ url('checkout') }}" class="btn_1">Checkout</a>
                                    </div>
                                </div>
                            </div>
                            <!-- /dropdown-cart-->
                        </li>
                        <li>
                            <a href="{{ url('my-wishlist') }}" class="wishlist"><span>Wishlist</span></a>
                        </li>
                        <li>
                            <div class="dropdown dropdown-access">
                                <a href="{{ url('login') }}" class="access_link"><span>Account</span></a>
                                <div class="dropdown-menu">
                                    <a href="{{ url('login') }}" class="btn_1">Sign In or Sign Up</a>
                                    <ul>
                                        <li>
                                            <a href="{{ url('track-order') }}"><i class="ti-truck"></i>Track your
                                                Order</a>
                                        </li>
                                        <li>
                                            <a href="{{ url('my-orders') }}"><i class="ti-package"></i>My Orders</a>
                                        </li>
                                        <li>
                                            <a href="{{ url('profile-page') }}"><i class="ti-user"></i>My Profile</a>
                                        </li>
                                        <li>
                                            <a href="{{ url('help') }}"><i class="ti-help-alt"></i>Help and Faq</a>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                            <!-- /dropdown-access-->
                        </li>
                        <li>
                            <a href="javascript:void(0);" class="btn_search_mob"><span>Search</span></a>
                        </li>
                        <li>
                            <a href="#menu" class="btn_cat_mob">
                                <div class="hamburger hamburger--spin" id="hamburger">
                                    <div class="hamburger-box">
                                        <div class="hamburger-inner"></div>
                                    </div>
                                </div>
                                Categories
                            </a>
                        </li>
                    </ul>
                </div>
            </div>
            <!-- /row -->
        </div>
        <div class="search_mob_wp">
            <input type="text" class="form-control" placeholder="Search over 10.000 products">
            <input type="submit" class="btn_1 full-width" value="Search">
        </div>
        <!-- /search_mobile -->
    </div>
    <!-- /main_nav -->
</header>
