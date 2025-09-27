<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="Ansonika">
    <title>Allaia | Bootstrap eCommerce Template - ThemeForest</title>

    <!-- Favicons-->
    <link rel="shortcut icon" href="{{ asset('img/favicon.ico') }}" type="image/x-icon">
    <link rel="apple-touch-icon" type="image/x-icon" href="{{ asset('img/apple-touch-icon-57x57-precomposed.png') }}">
    <link rel="apple-touch-icon" type="image/x-icon" sizes="72x72" href="{{ asset('img/apple-touch-icon-72x72-precomposed.png') }}">
    <link rel="apple-touch-icon" type="image/x-icon" sizes="114x114" href="{{ asset('img/apple-touch-icon-114x114-precomposed.png') }}">
    <link rel="apple-touch-icon" type="image/x-icon" sizes="144x144" href="{{ asset('img/apple-touch-icon-144x144-precomposed.png') }}">
	
    <!-- GOOGLE WEB FONT -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
	<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
	<link href="https://fonts.googleapis.com/css2?family=Roboto:wght@300;400;500;700&display=swap" rel="stylesheet">

    <!-- BASE CSS -->
    <link href="{{ asset('css/bootstrap.min.css') }}" rel="stylesheet">
    <link href="{{ asset('css/style.css') }}" rel="stylesheet">

	<!-- SPECIFIC CSS -->
    <link href="{{ asset('css/leave_review.css') }}" rel="stylesheet">

    <!-- YOUR CUSTOM CSS -->
    <link href="{{ asset('css/custom.css') }}" rel="stylesheet">

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
							<a href="{{ url('/') }}"><img src="{{ asset('img/logo.svg') }}" alt="" width="100" height="35"></a>
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
								<a href="{{ url('/') }}"><img src="{{ asset('img/logo_black.svg') }}" alt="" width="100" height="35"></a>
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
								<li>
									<a href="{{ url('leave-review') }}">Leave Review</a>
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

		<div class="main_nav inner Sticky">
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
													<figure><img src="{{ asset('img/products/product_placeholder_square_small.jpg') }}" data-src="{{ asset('img/products/shoes/thumb/1.jpg') }}" alt="" width="50" height="50" class="lazy"></figure>
													<strong><span>1x Armor Air x Fear</span>$90.00</strong>
												</a>
												<a href="#0" class="action"><i class="ti-trash"></i></a>
											</li>
											<li>
												<a href="{{ url('product-detail-2') }}">
													<figure><img src="{{ asset('img/products/product_placeholder_square_small.jpg') }}" data-src="{{ asset('img/products/shoes/thumb/2.jpg') }}" alt="" width="50" height="50" class="lazy"></figure>
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
											<li>
												<a href="{{ url('leave-review') }}"><i class="ti-star"></i>Leave a Review</a>
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
	
		
	<div class="container margin_60_35">
	
			<div class="row justify-content-center">
				<div class="col-lg-8">
					<div class="write_review">
						@if($product)
							<h1>Write a review for {{ $product->name }}</h1>
						@else
							<h1>Write a review</h1>
						@endif

						@if(session('success'))
							<div class="alert alert-success alert-dismissible fade show" role="alert">
								{{ session('success') }}
								<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
							</div>
						@endif

						@if(session('error'))
							<div class="alert alert-danger alert-dismissible fade show" role="alert">
								{{ session('error') }}
								<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
							</div>
						@endif

						<form action="{{ route('frontend.review.store') }}" method="POST" id="reviewForm">
							@csrf
							
							@if($product)
								<input type="hidden" name="product_id" value="{{ $product->id }}">
							@else
								<div class="form-group">
									<label for="product_id">Select Product <span class="text-danger">*</span></label>
									<select name="product_id" id="product_id" class="form-control" required>
										<option value="">Choose a product...</option>
										@foreach($products as $prod)
											<option value="{{ $prod->id }}">{{ $prod->name }} - {{ $prod->brand->name ?? 'No Brand' }}</option>
										@endforeach
									</select>
									@error('product_id')
										<div class="text-danger small">{{ $message }}</div>
									@enderror
								</div>
							@endif

							<div class="rating_submit">
								<div class="form-group">
									<label class="d-block">Overall rating <span class="text-danger">*</span></label>
									<span class="rating mb-0">
										<input type="radio" class="rating-input" id="5_star" name="rating" value="5" required>
										<label for="5_star" class="rating-star"></label>
										<input type="radio" class="rating-input" id="4_star" name="rating" value="4" required>
										<label for="4_star" class="rating-star"></label>
										<input type="radio" class="rating-input" id="3_star" name="rating" value="3" required>
										<label for="3_star" class="rating-star"></label>
										<input type="radio" class="rating-input" id="2_star" name="rating" value="2" required>
										<label for="2_star" class="rating-star"></label>
										<input type="radio" class="rating-input" id="1_star" name="rating" value="1" required>
										<label for="1_star" class="rating-star"></label>
									</span>
									@error('rating')
										<div class="text-danger small">{{ $message }}</div>
									@enderror
								</div>
							</div>
							<!-- /rating_submit -->

							@guest
								<div class="form-group">
									<label for="name">Your Name <span class="text-danger">*</span></label>
									<input class="form-control" type="text" name="name" id="name" placeholder="Enter your full name" value="{{ old('name') }}" required>
									@error('name')
										<div class="text-danger small">{{ $message }}</div>
									@enderror
								</div>

								<div class="form-group">
									<label for="email">Your Email <span class="text-danger">*</span></label>
									<input class="form-control" type="email" name="email" id="email" placeholder="Enter your email address" value="{{ old('email') }}" required>
									@error('email')
										<div class="text-danger small">{{ $message }}</div>
									@enderror
								</div>
							@endguest

							<div class="form-group">
								<label for="title">Title of your review</label>
								<input class="form-control" type="text" name="title" id="title" placeholder="If you could say it in one sentence, what would you say?" value="{{ old('title') }}">
								@error('title')
									<div class="text-danger small">{{ $message }}</div>
								@enderror
							</div>

							<div class="form-group">
								<label for="comment">Your review <span class="text-danger">*</span></label>
								<textarea class="form-control" name="comment" id="comment" style="height: 180px;" placeholder="Write your review to help others learn about this product" required>{{ old('comment') }}</textarea>
								@error('comment')
									<div class="text-danger small">{{ $message }}</div>
								@enderror
							</div>

							<div class="form-group">
								<div class="checkboxes float-left add_bottom_15 add_top_15">
									<label class="container_check">I agree to the <a href="#" target="_blank">Terms and Conditions</a> and <a href="#" target="_blank">Privacy Policy</a>
										<input type="checkbox" required>
										<span class="checkmark"></span>
									</label>
								</div>
							</div>

							<button type="submit" class="btn_1">Submit review</button>
						</form>
					</div>
				</div>
		</div>
		<!-- /row -->
		</div>
		<!-- /container -->
	</main>
	<!--/main-->
	
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
							<li><a href="{{ url('login') }}">My account</a></li>
							<li><a href="blog.html">Blog</a></li>
							<li><a href="contacts.html">Contacts</a></li>
						</ul>
					</div>
				</div>
				<div class="col-lg-3 col-md-6">
					<h3 data-bs-target="#collapse_2">Categories</h3>
					<div class="collapse dont-collapse-sm links" id="collapse_2">
						<ul>
							<li><a href="listing-grid-1-full.html">Clothes</a></li>
							<li><a href="listing-grid-2-full.html">Electronics</a></li>
							<li><a href="listing-grid-1-full.html">Furniture</a></li>
							<li><a href="listing-grid-3.html">Glasses</a></li>
							<li><a href="listing-grid-1-full.html">Shoes</a></li>
							<li><a href="listing-grid-1-full.html">Watches</a></li>
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
						<li><img src="data:image/gif;base64,R0lGODlhAQABAIAAAP///wAAACH5BAEAAAAALAAAAAABAAEAAAICRAEAOw==" data-src="{{ asset('img/cards_all.svg') }}" alt="" width="198" height="30" class="lazy"></li>
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
    <script src="{{ asset('js/common_scripts.min.js') }}"></script>
    <script src="{{ asset('js/main.js') }}"></script>

		
</body>
</html>