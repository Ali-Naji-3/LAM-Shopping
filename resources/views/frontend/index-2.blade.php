<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="Ansonika">
    <title>Allaia | Bootstrap eCommerce Template - ThemeForest99999</title>
 <!--sasdasdassdasdasda>
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
    <link href="css/home_1.css" rel="stylesheet">
    
    <!-- PROFESSIONAL PRODUCT IMAGES CSS -->
    <link href="css/product-images.css" rel="stylesheet">

    <!-- YOUR CUSTOM CSS -->
    <link href="css/custom.css" rel="stylesheet">
    
    <!-- Enhanced Video Header CSS -->
    <style>
        .header-video {
            position: relative;
            min-height: 500px;
            overflow: hidden;
        }
        
        .header-video--media {
            position: absolute;
            top: 50%;
            left: 50%;
            min-width: 100%;
            min-height: 100%;
            width: auto;
            height: auto;
            transform: translate(-50%, -50%);
            z-index: 1;
        }
        
        .header-video--fallback {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            z-index: 1;
        }
        
        .opacity-mask {
            position: relative;
            z-index: 2;
        }
        
        /* Ensure video works on mobile */
        @media (max-width: 767px) {
            .header-video {
                min-height: 420px;
            }
        }
    </style>

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
						<!-- Mobile menu button -->
						<div class="main-menu">
							<div id="header_menu">
								<a href="{{ url('/') }}"><img src="img/logo_black.svg" alt="" width="100" height="35"></a>
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
						<a class="phone_top" href="tel://9438843343"><strong><span>Need Help?</span>+94 423-23-221</strong></a>
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
											<li><span><a href="{{ url('listing-grid-7-sidebar-right') }}">Collections</a></span></li>
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
									<a href="{{ url('cart') }}" class="cart_bt"><strong>2</strong></a>
									<div class="dropdown-menu">
										<ul>
											<li>
												<a href="{{ url('product-detail-2') }}">
													<figure><img src="img/products/product_placeholder_square_small.jpg" data-src="img/products/shoes/thumb/1.jpg" alt="" width="50" height="50" class="lazy"></figure>
													<strong><span>1x Armor Air x Fear</span>$90.00</strong>
												</a>
												<a href="#0" class="action"><i class="ti-trash"></i></a>
											</li>
											<li>
												<a href="{{ url('product-detail-2') }}">
													<figure><img src="img/products/product_placeholder_square_small.jpg" data-src="img/products/shoes/thumb/2.jpg" alt="" width="50" height="50" class="lazy"></figure>
													<strong><span>1x Armor Okwahn II</span>$110.00</strong>
												</a>
												<a href="0" class="action"><i class="ti-trash"></i></a>
											</li>
										</ul>
										<div class="total_drop">
											<div class="clearfix"><strong>Total</strong><span>$200.00</span></div>
											<a href="{{ url('cart') }}" class="btn_1 outline">View Cart</a><a href="{{ url('checkout') }}" class="btn_1">Checkout</a>
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
												<a href="{{ url('track-order') }}"><i class="ti-truck"></i>Track your Order</a>
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
	<!-- /header -->

	<main>
		<div class="header-video">
			<div id="hero_video">
				<div class="opacity-mask d-flex align-items-center" data-opacity-mask="rgba(0, 0, 0, 0.5)">
					<div class="container">
						<div class="row justify-content-center justify-content-md-start">
							<div class="col-lg-6">
								<div class="slide-text white">
									<h3>Armor Air<br>Max 720 Sage Low</h3>
									<p>Limited items available at this price</p>
									<a class="btn_1" href="#0" role="button">Shop Now</a>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
			<video autoplay muted loop playsinline class="header-video--media" onerror="this.style.display='none'; this.nextElementSibling.style.display='block';">
    <source src="{{ asset('video/hero.mp4') }}" type="video/mp4">
    Your browser does not support the video tag.
</video>
<!-- Fallback background image if video fails to load -->
<div class="header-video--fallback" style="display:none; position:absolute; top:0; left:0; width:100%; height:100%; background-image:url('{{ asset('img/hero/main.png') }}'); background-size:cover; background-position:center;"></div>

		</div>
		<!-- /header-video -->

		<div class="feat">
			<div class="container">
				<ul>
					<li>
						<div class="box">
							<i class="ti-gift"></i>
							<div class="justify-content-center">
								<h3>Free Shipping</h3>
								<p>For all oders over $99</p>
							</div>
						</div>
					</li>
					<li>
						<div class="box">
							<i class="ti-wallet"></i>
							<div class="justify-content-center">
								<h3>Secure Payment</h3>
								<p>100% secure payment</p>
							</div>
						</div>
					</li>
					<li>
						<div class="box">
							<i class="ti-headphone-alt"></i>
							<div class="justify-content-center">
								<h3>24/7 Support</h3>
								<p>Online top support</p>
							</div>
						</div>
					</li>
				</ul>
			</div>
		</div>
		<!--/feat-->

		<div class="container margin_60_35">
			<div class="row small-gutters categories_grid">
				<div class="col-sm-12 col-md-6">
					<a href="{{ url('listing-grid-7-sidebar-right') }}">
						<img src="{{ asset('img/hero/main.png') }}" data-src="{{ asset('img/hero/main.png') }}" alt="" class="img-fluid lazy">
						<div class="wrapper">
							<h2>Collections</h2>
							<p>115 Products</p>
						</div>
					</a>
				</div>
				<div class="col-sm-12 col-md-6">
					<div class="row small-gutters mt-md-0 mt-sm-2">
						<div class="col-sm-6">
							<a href="{{ url('listing-grid-1-full') }}">
								<img src="{{ asset('img/hero/woman.jpg') }}" data-src="{{ asset('img/hero/woman.jpg') }}" alt="" class="img-fluid lazy">
								<div class="wrapper">
									<h2>Woman</h2>
									<p>150 Products</p>
								</div>
							</a>
						</div>
						<div class="col-sm-6">
							<a href="{{ url('listing-grid-3') }}">
								<img src="{{ asset('img/hero/man.jpg') }}" data-src="{{ asset('img/hero/man.jpg') }}" alt="" class="img-fluid lazy">
								<div class="wrapper">
									<h2>Men</h2>
									<p>90 Products</p>
								</div>
							</a>
						</div>
						<div class="col-sm-12 mt-sm-2">
							<a href="{{ url('listing-grid-2-full') }}">
								<img src="{{ asset('img/hero/kid.avif') }}" data-src="{{ asset('img/hero/kid.avif') }}" alt="" class="img-fluid lazy">
								<div class="wrapper">
									<h2>Kids</h2>
									<p>120 Products</p>
								</div>
							</a>
						</div>
					</div>
				</div>
			</div>
			<!--/categories_grid-->
		</div>
		<!-- /container -->

		<hr class="mb-0">

		<div class="container margin_60_35">
			<div class="main_title mb-4">
				<h2>New Arrival</h2>
				<span>Products</span>
				<p>Cum doctus civibus efficiantur in imperdiet deterruisset.</p>
			</div>
			<div class="isotope_filter">
				<ul>
					<li><a href="#0" id="all" data-filter="*" class="active">All</a></li>
					<li><a href="#0" id="popular" data-filter=".popular">Popular</a></li>
					<li><a href="#0" id="sale" data-filter=".sale">Sale</a></li>
				</ul>
			</div>
			<div class="isotope-wrapper">
				<div class="row small-gutters">
					@forelse($newArrivalProducts as $product)
					<div class="col-6 col-md-4 col-xl-3 isotope-item {{ $product->sale_price ? 'sale' : ($product->featured ? 'popular' : '') }}">
						<div class="grid_item">
							<figure>
								@if($product->new_arrival_badge == 'featured-new')
									<span class="ribbon hot">Featured New</span>
								@elseif($product->new_arrival_badge == 'new')
									<span class="ribbon new">New</span>
								@elseif($product->sale_price && $product->sale_price < $product->regular_price)
									@php
										$discount = round((($product->regular_price - $product->sale_price) / $product->regular_price) * 100);
									@endphp
									<span class="ribbon off">-{{ $discount }}%</span>
								@elseif($product->featured)
									<span class="ribbon hot">Hot</span>
								@endif
								<a href="{{ route('product.detail', $product->slug) }}">
									@if($product->image)
										<img class="img-fluid lazy" src="{{ asset('storage/' . $product->image) }}" alt="{{ $product->name }}">
									@else
										<img class="img-fluid lazy" src="{{ asset('img/products/product_placeholder_square_medium.jpg') }}" alt="{{ $product->name }}">
									@endif
								</a>
								@if($product->enable_countdown && $product->countdown_date)
									<div data-countdown="{{ $product->countdown_date->format('Y/m/d') }}" class="countdown"></div>
								@endif
							</figure>
							<div class="rating">
								@for($i = 1; $i <= 5; $i++)
									<i class="icon-star {{ $i <= $product->average_rating ? 'voted' : '' }}"></i>
								@endfor
							</div>
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
							</ul>
						</div>
						<!-- /grid_item -->
					</div>
					<!-- /col -->
					@empty
					<div class="col-12">
						<div class="text-center py-5">
							<h4>No new arrival products available</h4>
							<p>Check back soon for new products!</p>
						</div>
					</div>
					@endforelse
				</div>
				<!-- /row -->
			</div>
			<!-- /isotope-wrapper -->
		</div>
		<!-- /container -->

		<div class="featured lazy" data-bg="url(img/featured_home.jpg)">
			<div class="opacity-mask d-flex align-items-center" data-opacity-mask="rgba(0, 0, 0, 0.5)">
				<div class="container margin_60">
					<div class="row justify-content-center justify-content-md-start">
						<div class="col-lg-6 wow" data-wow-offset="150">
							<h3>Armor<br>Air Color 720</h3>
							<p>Lightweight cushioning and durable support with a Phylon midsole</p>
							<div class="feat_text_block">
								<div class="price_box">
									<span class="new_price">$90.00</span>
									<span class="old_price">$170.00</span>
								</div>
								<a class="btn_1" href="listing-grid-1-full.html" role="button">Shop Now</a>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
		<!-- /featured -->

		<div class="bg_gray">
			<div class="container margin_30">
				<div id="brands" class="owl-carousel owl-theme">
					<div class="item">
						<a href="#0"><img src="img/brands/placeholder_brands.png" data-src="img/brands/logo_1.png" alt="" class="owl-lazy"></a>
					</div><!-- /item -->
					<div class="item">
						<a href="#0"><img src="img/brands/placeholder_brands.png" data-src="img/brands/logo_2.png" alt="" class="owl-lazy"></a>
					</div><!-- /item -->
					<div class="item">
						<a href="#0"><img src="img/brands/placeholder_brands.png" data-src="img/brands/logo_3.png" alt="" class="owl-lazy"></a>
					</div><!-- /item -->
					<div class="item">
						<a href="#0"><img src="img/brands/placeholder_brands.png" data-src="img/brands/logo_4.png" alt="" class="owl-lazy"></a>
					</div><!-- /item -->
					<div class="item">
						<a href="#0"><img src="img/brands/placeholder_brands.png" data-src="img/brands/logo_5.png" alt="" class="owl-lazy"></a>
					</div><!-- /item -->
					<div class="item">
						<a href="#0"><img src="img/brands/placeholder_brands.png" data-src="img/brands/logo_6.png" alt="" class="owl-lazy"></a>
					</div><!-- /item -->
				</div><!-- /carousel -->
			</div><!-- /container -->
		</div>


	</main>
	<!-- /main -->

	<footer class="revealed">
		<div class="container">
			<div class="row">
				<div class="col-lg-3 col-md-6">
					<h3 data-bs-target="#collapse_1">Quick Links</h3>
					<div class="collapse dont-collapse-sm links" id="collapse_1">
						<ul>
							<li><a href="{{ url('about-us.html') }}">About us</a></li>
							<li><a href="{{ url('help') }}">Faq</a></li>
							<li><a href="{{ url('help') }}">Help</a></li>
							<li><a href="{{ url('login') }}">My account</a></li>
							<li><a href="{{ url('blog.html') }}">Blog</a></li>
							<li><a href="{{ url('contacts.html') }}">Contacts</a></li>
						</ul>
					</div>
				</div>
				<div class="col-lg-3 col-md-6">
					<h3 data-bs-target="#collapse_2">Categories</h3>
					<div class="collapse dont-collapse-sm links" id="collapse_2">
						<ul>
							<li><a href="{{ url('listing-grid-1-full.html') }}">Clothes</a></li>
							<li><a href="{{ url('listing-grid-2-full.html') }}">Electronics</a></li>
							<li><a href="{{ url('listing-grid-1-full.html') }}">Furniture</a></li>
							<li><a href="{{ url('listing-grid-3.html') }}">Glasses</a></li>
							<li><a href="{{ url('listing-grid-1-full.html') }}">Shoes</a></li>
							<li><a href="{{ url('listing-grid-1-full.html') }}">Watches</a></li>
						</ul>
					</div>
				</div>
				<div class="col-lg-3 col-md-6">
						<h3 data-bs-target="#collapse_3">Contacts</h3>
					<div class="collapse dont-collapse-sm contacts" id="collapse_3">
						<ul>
							<li><i class="ti-home"></i>97845 Baker st. 567<br>Los Angeles - US</li>
							<li><i class="ti-headphone-alt"></i>+94 423-23-221</li>
							<li><i class="ti-email"></i><a href="#0">info@allaia.com</a></li>
						</ul>
					</div>
				</div>
				<div class="col-lg-3 col-md-6">
						<h3 data-bs-target="#collapse_4">Keep in touch</h3>
					<div class="collapse dont-collapse-sm" id="collapse_4">
						<div id="newsletter">
						    <div class="form-group">
						        <input type="email" name="email_newsletter" id="email_newsletter" class="form-control" placeholder="Your email">
						        <button type="submit" id="submit-newsletter"><i class="ti-angle-double-right"></i></button>
						    </div>
						</div>
						<div class="follow_us">
							<h5>Follow Us</h5>
							<ul>
								<li><a href="#0"><i class="bi bi-facebook"></i></a></li>
								<li><a href="#0"><i class="bi bi-twitter-x"></i></a></li>
								<li><a href="#0"><i class="bi bi-instagram"></i></a></li>
								<li><a href="#0"><i class="bi bi-tiktok"></i></a></li>
								<li><a href="#0"><i class="bi bi-whatsapp"></i></a></li>
							</ul>
						</div>
					</div>
				</div>
			</div>
			<!-- /row-->
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
									<option value="US Dollars" selected>US Dollars</option>
									<option value="Euro">Euro</option>
								</select>
							</div>
						</li>
						<li><img src="data:image/gif;base64,R0lGODlhAQABAIAAAP///wAAACH5BAEAAAAALAAAAAABAAEAAAICRAEAOw==" data-src="img/cards_all.svg" alt="" width="198" height="30" class="lazy"></li>
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
	</div>
	<!-- page -->

	<div id="toTop"></div><!-- Back to top button -->

	<!-- COMMON SCRIPTS -->
    <script src="js/common_scripts.min.js"></script>
    <script src="js/main.js"></script>

	<!-- SPECIFIC SCRIPTS -->
	<script src="js/modernizr.js"></script>
	<script src="js/video_header.min.js"></script>
	<!-- Fallback video script in case video_header.min.js fails -->
	<script>
		// Simple video fallback
		$(document).ready(function() {
			var $video = $('.header-video--media');
			if ($video.length > 0) {
				// Ensure video plays
				$video[0].play().catch(function(error) {
					console.log('Video autoplay failed:', error);
					// Show fallback background
					$('.header-video--fallback').show();
					$video.hide();
				});
			}
		});
	</script>
	<script>
		// Video Header - Enhanced with error handling
		$(document).ready(function() {
			try {
				// Check if HeaderVideo is available and elements exist
				if (typeof HeaderVideo !== 'undefined') {
					var $container = $('.header-video');
					var $header = $('.header-video--media');
					var $videoTrigger = $("#video-trigger");
					
					// Only initialize if elements exist
					if ($container.length > 0 && $header.length > 0) {
						HeaderVideo.init({
							container: $container,
							header: $header,
							videoTrigger: $videoTrigger.length > 0 ? $videoTrigger : null,
							autoPlayVideo: true
						});
					} else {
						console.log('Video header elements not found, skipping initialization');
					}
				} else {
					console.log('HeaderVideo library not loaded');
				}
			} catch (error) {
				console.log('Video header initialization error:', error);
			}
		});
	</script>
	<script src="js/isotope.min.js"></script>
	<script>
		// Enhanced Isotope filter for New Arrival Products
		$(window).on('load',function(){
			try {
				var $container = $('.isotope-wrapper');
				if ($container.length > 0 && typeof $.fn.isotope !== 'undefined') {
					$container.isotope({ 
						itemSelector: '.isotope-item', 
						layoutMode: 'masonry',
						transitionDuration: '0.3s'
					});
				} else {
					console.log('Isotope container not found or library not loaded');
				}
			} catch (error) {
				console.log('Isotope initialization error:', error);
			}
		});
		
		$('.isotope_filter').on( 'click', 'a', function(e){
			e.preventDefault();
			
			try {
				// Remove active class from all filter buttons
				$('.isotope_filter a').removeClass('active');
				
				// Add active class to clicked button
				$(this).addClass('active');
				
				// Get filter selector
				var selector = $(this).attr('data-filter');
				
				// Apply filter with animation if isotope is available
				var $container = $('.isotope-wrapper');
				if ($container.length > 0 && typeof $.fn.isotope !== 'undefined') {
					$container.isotope({ 
						filter: selector,
						transitionDuration: '0.3s'
					});
				}
				
				// Update URL hash for better UX
				if (selector === '*') {
					history.replaceState(null, null, window.location.pathname);
				} else {
					history.replaceState(null, null, window.location.pathname + '#' + selector.replace('.', ''));
				}
			} catch (error) {
				console.log('Filter click error:', error);
			}
		});
		
		// Handle initial filter from URL hash
		$(document).ready(function() {
			try {
				var hash = window.location.hash;
				if (hash) {
					var filterClass = '.' + hash.replace('#', '');
					var $filterButton = $('.isotope_filter a[data-filter="' + filterClass + '"]');
					if ($filterButton.length > 0) {
						$filterButton.click();
					}
				}
			} catch (error) {
				console.log('URL hash handling error:', error);
			}
		});
	</script>

</body>
</html>
