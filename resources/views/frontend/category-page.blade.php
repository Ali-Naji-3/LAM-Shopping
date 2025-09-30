{{-- <!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="Ansonika">
    <title>{{ $category->name }} Collection | Allaia</title>

    <!-- Favicons-->
    <link rel="shortcut icon" href="img/favicon.ico" type="image/x-icon">
    <link rel="apple-touch-icon" type="image/x-icon" href="img/apple-touch-icon-57x57-precomposed.png">
    <link rel="apple-touch-icon" type="image/x-icon" sizes="72x72" href="img/apple-touch-icon-72x72-precomposed.png">
    <link rel="apple-touch-icon" type="image/x-icon" sizes="114x114" href="img/apple-touch-icon-114x114-precomposed.png">
    <link rel="apple-touch-icon" type="image/x-icon" sizes="144x144" href="img/apple-touch-icon-144x144-precomposed.png">

    <!-- GOOGLE WEB FONT -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
	<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
	<link href="https://fonts.googleapis.com/css2?family=Roboto:wght@300;400;500;700&display=swap" rel="stylesheet">

    <!-- BASE CSS -->
    <link href="css/bootstrap.min.css" rel="stylesheet">
    <link href="css/style.css" rel="stylesheet">

	<!-- SPECIFIC CSS -->
    <link href="css/listing.css" rel="stylesheet">

    <!-- PROFESSIONAL PRODUCT IMAGES CSS -->
    <link href="css/product-images.css" rel="stylesheet">

    <!-- YOUR CUSTOM CSS -->
    <link href="css/custom.css" rel="stylesheet">

</head>

<body>

	<div id="page">

	<header class="version_1">
		<div class="layer"></div><!-- Mobile menu overlay mask -->
		<div class="main_header">
			<div class="container">
				<div class="row small-gutters">
					<div class="col-xl-3 col-lg-3 d-lg-flex align-items-center">
						<div id="logo">
							<a href="{{ url('/') }}"><img src="img/logo.svg" alt="" width="100" height="35"></a>
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
						<!-- /open_close -->
						<div class="main-menu">
							<div id="header_menu">
								<a class="open_close" href="javascript:void(0);">
									<div class="hamburger hamburger--spin">
										<div class="hamburger-box">
											<div class="hamburger-inner"></div>
										</div>
									</div>
								</a>
								<a href="{{ url('/') }}"><img src="img/logo.svg" alt="" width="100" height="35"></a>
							</div>
							<ul>
								<li class="submenu">
									<a href="{{ url('/') }}" class="show-submenu">Home</a>
								</li>
								<li class="submenu">
									<a href="{{ url('/men') }}" class="show-submenu {{ request()->is('men') ? 'active' : '' }}">Men</a>
								</li>
								<li class="submenu">
									<a href="{{ url('/women') }}" class="show-submenu {{ request()->is('women') ? 'active' : '' }}">Women</a>
								</li>
								<li class="submenu">
									<a href="{{ url('/body') }}" class="show-submenu {{ request()->is('body') ? 'active' : '' }}">Body</a>
								</li>
								<li class="submenu">
									<a href="{{ url('/girl') }}" class="show-submenu {{ request()->is('girl') ? 'active' : '' }}">Girl</a>
								</li>
							</ul>
						</div>
						<!-- /main-menu -->
					</nav>
					<div class="col-xl-3 col-lg-2 d-lg-flex align-items-center justify-content-end text-end">
						<a class="phone_top" href="tel://9438843343"><strong><span>Need Help?</span>+94 423-23-221</strong></a>
					</div>
				</div>
				<!-- /row -->
			</div>
		</div>
		<!-- /main_header -->
		<div class="main_nav">
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
											<span>Categories</span>
										</a>
									</span>
									<ul>
										<li><a href="{{ url('/men') }}">Men</a></li>
										<li><a href="{{ url('/women') }}">Women</a></li>
										<li><a href="{{ url('/body') }}">Body</a></li>
										<li><a href="{{ url('/girl') }}">Girl</a></li>
									</ul>
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
									<a href="{{ url('cart') }}" class="cart_bt"><strong>2</strong></a>
									<div class="dropdown-menu">
										<ul>
											<li>
												<a href="{{ url('product-detail-2') }}">
													<figure><img src="img/products/product_placeholder_square_medium.jpg" data-src="img/products/shoes/thumb/1.jpg" alt="" width="50" height="50" class="lazy"></figure>
													<strong><span>1x Armor Air x Fear</span>$90.00</strong>
												</a>
												<a href="#0" class="action"><i class="ti-trash"></i></a>
											</li>
											<li>
												<a href="{{ url('product-detail-2') }}">
													<figure><img src="img/products/product_placeholder_square_medium.jpg" data-src="img/products/shoes/thumb/2.jpg" alt="" width="50" height="50" class="lazy"></figure>
													<strong><span>1x Armor Okwahn II</span>$110.00</strong>
												</a>
												<a href="#0" class="action"><i class="ti-trash"></i></a>
											</li>
										</ul>
										<div class="total_drop">
											<div class="clearfix"><strong>Total</strong><span>$200.00</span></div>
											<a href="{{ url('cart') }}" class="btn_1 outline">View Cart</a><a href="{{ url('checkout') }}" class="btn_1">Checkout</a>
										</div>
									</div>
									<!-- /dropdown-menu-->
								</div>
								<!-- /dropdown-cart-->
							</li>
							<li>
								<a href="#" class="wishlist"><span>Wishlist</span></a>
							</li>
							<li>
								<div class="dropdown dropdown-access">
									<a href="#" class="access_link"><span>Account</span></a>
									<div class="dropdown-menu">
										<a href="{{ url('login') }}" class="btn_1">Sign In</a>
										<a href="{{ url('register') }}" class="btn_1">Sign Up</a>
									</div>
								</div>
								<!-- /dropdown-access-->
							</li>
							<li>
								<a href="javascript:void(0);" class="btn_search_mob"><span>Search</span></a>
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
	<!-- /header -->

	<main>

		<div class="container margin_30">
		    <div class="top_banner version_2">
		        <div class="opacity-mask d-flex align-items-center" data-opacity-mask="rgba(0, 0, 0, 0)">
		            <div class="container">
		                <div class="d-flex justify-content-center">
		                    <h1>{{ $category->name }} Collection</h1>
		                </div>
		            </div>
		        </div>
		        @if($category->image)
		            <img src="{{ asset('storage/' . $category->image) }}" class="img-fluid" alt="{{ $category->name }}">
		        @else
		            <img src="img/bg_cat_shoes.jpg" class="img-fluid" alt="{{ $category->name }}">
		        @endif
		    </div>
		    <!-- /top_banner -->
		    <div id="stick_here"></div>
		    <div class="toolbox elemento_stick version_2">
		        <div class="container">
		            <ul class="clearfix">
		                <li>
		                    <div class="sort_select">
		                        <select name="sort" id="sort">
		                            <option value="popularity" selected="selected">Sort by popularity</option>
		                            <option value="rating">Sort by average rating</option>
		                            <option value="date">Sort by newness</option>
		                            <option value="price">Sort by price: low to high</option>
		                            <option value="price-desc">Sort by price: high to low</option>
		                        </select>
		                    </div>
		                </li>
		                <li>
		                    <a href="#0"><i class="ti-view-grid"></i></a>
		                    <a href="listing-row-1-sidebar-left.html"><i class="ti-view-list"></i></a>
		                </li>
		                <li>
		                    <a data-bs-toggle="collapse" href="#filters" role="button" aria-expanded="false" aria-controls="filters">
		                        <i class="ti-filter"></i><span>Filters</span>
		                    </a>
		                </li>
		            </ul>
		        </div>
		    </div>
		    <!-- /toolbox -->
		    <div class="collapse" id="filters">
		        <div class="row small-gutters filters_listing_1">
		            @if($subcategories->count() > 0)
		            <div class="col-lg-3 col-md-6 col-sm-6">
		                <div class="dropdown">
		                    <a href="#" data-bs-toggle="dropdown" class="drop">Subcategories</a>
		                    <div class="dropdown-menu">
		                        <div class="filter_type">
		                            <ul>
		                                @foreach($subcategories as $subcategory)
		                                <li>
		                                    <label class="container_check">{{ $subcategory->name }}
		                                        <input type="checkbox">
		                                        <span class="checkmark"></span>
		                                    </label>
		                                </li>
		                                @endforeach
		                            </ul>
		                        </div>
		                    </div>
		                    <!-- /dropdown -->
		                </div>
		            </div>
		            @endif
		            <div class="col-lg-3 col-md-6 col-sm-6">
		                <div class="dropdown">
		                    <a href="#" data-bs-toggle="dropdown" class="drop">Brand</a>
		                    <div class="dropdown-menu">
		                        <div class="filter_type">
		                            <ul>
		                                @foreach($brands as $brand)
		                                <li>
		                                    <label class="container_check">{{ $brand->name }}
		                                        <input type="checkbox">
		                                        <span class="checkmark"></span>
		                                    </label>
		                                </li>
		                                @endforeach
		                            </ul>
		                        </div>
		                    </div>
		                    <!-- /dropdown -->
		                </div>
		            </div>
		            <div class="col-lg-3 col-md-6 col-sm-6">
		                <div class="dropdown">
		                    <a href="#" data-bs-toggle="dropdown" class="drop">Price</a>
		                    <div class="dropdown-menu">
		                        <div class="filter_type">
		                            <ul>
		                                <li>
		                                    <label class="container_check">$0 — $50 <small>({{ $products->where('regular_price', '<=', 50)->count() }})</small>
		                                        <input type="checkbox">
		                                        <span class="checkmark"></span>
		                                    </label>
		                                </li>
		                                <li>
		                                    <label class="container_check">$50 — $100 <small>({{ $products->where('regular_price', '>', 50)->where('regular_price', '<=', 100)->count() }})</small>
		                                        <input type="checkbox">
		                                        <span class="checkmark"></span>
		                                    </label>
		                                </li>
		                                <li>
		                                    <label class="container_check">$100 — $200 <small>({{ $products->where('regular_price', '>', 100)->where('regular_price', '<=', 200)->count() }})</small>
		                                        <input type="checkbox">
		                                        <span class="checkmark"></span>
		                                    </label>
		                                </li>
		                                <li>
		                                    <label class="container_check">$200+ <small>({{ $products->where('regular_price', '>', 200)->count() }})</small>
		                                        <input type="checkbox">
		                                        <span class="checkmark"></span>
		                                    </label>
		                                </li>
		                            </ul>
		                        </div>
		                    </div>
		                    <!-- /dropdown -->
		                </div>
		            </div>
		        </div>
		        <!-- /filters_listing_1 -->
		    </div>
		    <!-- /filters -->
			<div class="row small-gutters">
				@forelse($products as $product)
				<div class="col-6 col-md-4 col-xl-3">
					<div class="grid_item">
						<figure>
							@if($product->sale_price && $product->sale_price < $product->regular_price)
								@php
									$discount = round((($product->regular_price - $product->sale_price) / $product->regular_price) * 100);
								@endphp
								<span class="ribbon off">-{{ $discount }}%</span>
							@elseif($product->featured)
								<span class="ribbon hot">Hot</span>
							@elseif($product->created_at->diffInDays() < 7)
								<span class="ribbon new">New</span>
							@endif
							<a href="{{ route('product.detail', $product->slug) }}">
								@if($product->image)
									<img class="img-fluid lazy" src="{{ asset('storage/' . $product->image) }}" alt="{{ $product->name }}">
								@else
									<img class="img-fluid lazy" src="img/products/product_placeholder_square_medium.jpg" alt="{{ $product->name }}">
								@endif
							</a>
							@if($product->enable_countdown && $product->countdown_date)
								<div data-countdown="{{ $product->countdown_date->format('Y/m/d') }}" class="countdown"></div>
							@endif
						</figure>
						<a href="{{ route('product.detail', $product->slug) }}">
							<h3>{{ $product->name }}</h3>
						</a>
						<div class="price_box">
							@if($product->sale_price && $product->sale_price < $product->regular_price)
								<span class="new_price">${{ number_format($product->sale_price, 2) }}</span>
								<span class="old_price">${{ number_format($product->regular_price, 2) }}</span>
							@else
								<span class="new_price">${{ number_format($product->regular_price, 2) }}</span>
							@endif
						</div>
						<ul>
							<li><a href="#0" class="tooltip-1" data-bs-toggle="tooltip" data-bs-placement="left" title="Add to favorites"><i class="ti-heart"></i><span>Add to favorites</span></a></li>
							<li><a href="#0" class="tooltip-1" data-bs-toggle="tooltip" data-bs-placement="left" title="Add to compare"><i class="ti-control-shuffle"></i><span>Add to compare</span></a></li>
							<li><a href="#0" class="tooltip-1" data-bs-toggle="tooltip" data-bs-placement="left" title="Add to cart"><i class="ti-shopping-cart"></i><span>Add to cart</span></a></li>
							<li><a href="{{ route('frontend.leave-review', ['product' => $product->id]) }}" class="tooltip-1" data-bs-toggle="tooltip" data-bs-placement="left" title="Leave a review"><i class="ti-star"></i><span>Leave a review</span></a></li>
						</ul>
					</div>
					<!-- /grid_item -->
				</div>
				<!-- /col -->
				@empty
				<div class="col-12">
					<div class="text-center py-5">
						<h3>No {{ $category->name }} products found</h3>
						<p>We're working on adding more {{ $category->name }} products. Check back soon!</p>
						<a href="{{ url('/') }}" class="btn_1">Back to Home</a>
					</div>
				</div>
				@endforelse
			</div>
			<!-- /row -->

			<!-- Pagination -->
			@if($products->hasPages())
			<div class="pagination__wrapper">
				<ul class="pagination">
					@if($products->onFirstPage())
						<li class="disabled"><span>&laquo;</span></li>
					@else
						<li><a href="{{ $products->previousPageUrl() }}">&laquo;</a></li>
					@endif

					@foreach($products->getUrlRange(1, $products->lastPage()) as $page => $url)
						@if($page == $products->currentPage())
							<li class="active"><span>{{ $page }}</span></li>
						@else
							<li><a href="{{ $url }}">{{ $page }}</a></li>
						@endif
					@endforeach

					@if($products->hasMorePages())
						<li><a href="{{ $products->nextPageUrl() }}">&raquo;</a></li>
					@else
						<li class="disabled"><span>&raquo;</span></li>
					@endif
				</ul>
			</div>
			@endif
			<!-- /pagination -->
		</div>
		<!-- /container -->
	</main>
	<!-- /main -->

	<footer>
		<div class="container">
			<div class="row">
				<div class="col-lg-3 col-md-6">
					<h3 data-bs-target="#collapse_1">Quick Links</h3>
					<div class="collapse dont-collapse-sm links" id="collapse_1">
						<ul>
							<li><a href="about.html">About us</a></li>
							<li><a href="{{ url('help') }}">Faq</a></li>
							<li><a href="{{ url('help') }}">Help</a></li>
							<li><a href="{{ url('help') }}">My account</a></li>
							<li><a href="{{ url('help') }}">Create account</a></li>
							<li><a href="{{ url('help') }}">Contacts</a></li>
						</ul>
					</div>
				</div>
				<div class="col-lg-3 col-md-6">
					<h3 data-bs-target="#collapse_2">Categories</h3>
					<div class="collapse dont-collapse-sm links" id="collapse_2">
						<ul>
							<li><a href="{{ url('/men') }}">Men</a></li>
							<li><a href="{{ url('/women') }}">Women</a></li>
							<li><a href="{{ url('/body') }}">Body</a></li>
							<li><a href="{{ url('/girl') }}">Girl</a></li>
						</ul>
					</div>
				</div>
				<div class="col-lg-3 col-md-6">
						<h3 data-bs-target="#collapse_3">Contacts</h3>
					<div class="collapse dont-collapse-sm contacts" id="collapse_3">
						<ul>
							<li><i class="ti-home"></i>97845 Baker st. 567<br>Los Angeles - US</li>
							<li><i class="ti-headphone-alt"></i>+94 423-23-221</li>
							<li><i class="ti-email"></i>info@allaia.com</li>
						</ul>
					</div>
				</div>
				<div class="col-lg-3 col-md-6">
						<h3 data-bs-target="#collapse_4">Keep in touch</h3>
					<div class="collapse dont-collapse-sm" id="collapse_4">
						<div id="newsletter">
						    <div class="form-group">
						        <input type="email" name="email_newsletter" id="email_newsletter" class="form-control" placeholder="Your email">
						        <button type="submit" id="submit-newsletter">Submit</button>
						    </div>
						</div>
						<div class="follow_us">
							<ul>
								<li><a href="#0"><i class="ti-facebook"></i></a></li>
								<li><a href="#0"><i class="ti-instagram"></i></a></li>
								<li><a href="#0"><i class="ti-twitter"></i></a></li>
								<li><a href="#0"><i class="ti-pinterest"></i></a></li>
							</ul>
						</div>
					</div>
				</div>
			</div>
			<!-- /row -->
			<hr>
			<div class="row add_bottom_25">
				<div class="col-lg-6">
					<ul class="footer-selector clearfix">
						<li>
							<div class="styled-select lang-selector">
								<select>
									<option value="English" selected>English</option>
									<option value="French">French</option>
									<option value="Spanish">Spanish</option>
									<option value="Russian">Russian</option>
								</select>
							</div>
						</li>
						<li>
							<div class="styled-select currency-selector">
								<select>
									<option value="USD" selected>USD</option>
									<option value="EUR">EUR</option>
									<option value="GBP">GBP</option>
									<option value="RUB">RUB</option>
								</select>
							</div>
						</li>
						<li><img src="img/cards_all.svg" alt=""></li>
					</ul>
				</div>
				<div class="col-lg-6">
					<ul class="additional_links">
						<li><a href="#0">Terms and conditions</a></li>
						<li><a href="#0">Privacy</a></li>
						<li><span>© 2024 Allaia</span></li>
					</ul>
				</div>
			</div>
		</div>
	</footer>
	<!--/footer-->

	<div class="layer"></div>
	<!-- Opacity Mask Menu Mobile -->

	<!-- COMMON SCRIPTS -->
	<script src="js/common_scripts.min.js"></script>
	<script src="js/main.js"></script>

</body>
</html> --}}
