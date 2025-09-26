<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="Ansonika">
    <title>Allaia | About Us</title>

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
							<a href="index.html"><img src="{{ asset('img/logo.svg') }}" alt="" width="100" height="35"></a>
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
								<li class="submenu">
									<a href="javascript:void(0);" class="show-submenu">Home</a>
									<ul>
										<li><a href="{{ url('index.html') }}">Slider</a></li>
										<li><a href="{{ url('/') }}">Video Background</a></li>
										<li><a href="{{ url('index-3.html') }}">Vertical Slider</a></li>
										<li><a href="{{ url('index-4.html') }}">GDPR Cookie Bar</a></li>
									</ul>
								</li>
								<li class="megamenu submenu">
									<a href="javascript:void(0);" class="show-submenu-mega">Pages</a>
									<div class="menu-wrapper">
										<div class="row small-gutters">
											<div class="col-lg-3">
												<h3>Listing grid</h3>
												<ul>
													<li><a href="{{ url('listing-grid-1-full.html') }}">Grid Full Width</a></li>
													<li><a href="{{ url('listing-grid-2-full.html') }}">Grid Full Width 2</a></li>
													<li><a href="{{ url('listing-grid-3.html') }}">Grid Boxed</a></li>
													<li><a href="{{ url('listing-grid-4-sidebar-left.html') }}">Grid Sidebar Left</a></li>
													<li><a href="{{ url('listing-grid-5-sidebar-right.html') }}">Grid Sidebar Right</a></li>
													<li><a href="{{ url('listing-grid-6-sidebar-left.html') }}">Grid Sidebar Left 2</a></li>
													<li><a href="{{ url('listing-grid-7-sidebar-right.html') }}">Grid Sidebar Right 2</a></li>
												</ul>
											</div>
											<div class="col-lg-3">
												<h3>Listing row &amp; Product</h3>
												<ul>
													<li><a href="{{ url('listing-row-1-sidebar-left.html') }}">Row Sidebar Left</a></li>
													<li><a href="{{ url('listing-row-2-sidebar-right.html') }}">Row Sidebar Right</a></li>
													<li><a href="{{ url('listing-row-3-sidebar-left.html') }}">Row Sidebar Left 2</a></li>
													<li><a href="{{ url('listing-row-4-sidebar-extended.html') }}">Row Sidebar Extended</a></li>
													<li><a href="{{ url('product-detail-1.html') }}">Product Large Image</a></li>
													<li><a href="{{ url('product-detail-2.html') }}">Product Carousel</a></li>
													<li><a href="{{ url('product-detail-3.html') }}">Product Sticky Info</a></li>
												</ul>
											</div>
											<div class="col-lg-3">
												<h3>Other pages</h3>
												<ul>
													<li><a href="{{ url('cart.html') }}">Cart Page</a></li>
													<li><a href="{{ url('checkout.html') }}">Check Out Page</a></li>
													<li><a href="{{ url('confirm.html') }}">Confirm Purchase Page</a></li>
													<li><a href="{{ url('account.html') }}">Create Account Page</a></li>
													<li><a href="{{ url('track-order.html') }}">Track Order</a></li>
													<li><a href="{{ url('help.html') }}">Help Page</a></li>
													<li><a href="{{ url('help-2.html') }}">Help Page 2</a></li>
													<li><a href="{{ url('leave-review.html') }}">Leave a Review</a></li>
												</ul>
											</div>
											<div class="col-lg-3 d-xl-block d-lg-block d-md-none d-sm-none d-none">
												<div class="banner_menu">
													<a href="#0">
														<img src="data:image/gif;base64,R0lGODlhAQABAIAAAP///wAAACH5BAEAAAAALAAAAAABAAEAAAICRAEAOw==" data-src="{{ asset('img/banner_menu.jpg') }}" width="400" height="550" alt="" class="img-fluid lazy">
													</a>
												</div>
											</div>
										</div>
										<!-- /row -->
									</div>
									<!-- /menu-wrapper -->
								</li>
								<li class="submenu">
									<a href="javascript:void(0);" class="show-submenu">Extra Pages</a>
									<ul>
										<li><a href="{{ url('header-2.html') }}">Header Style 2</a></li>
										<li><a href="{{ url('header-3.html') }}">Header Style 3</a></li>
										<li><a href="{{ url('header-4.html') }}">Header Style 4</a></li>
										<li><a href="{{ url('header-5.html') }}">Header Style 5</a></li>
										<li><a href="{{ url('404.html') }}">404 Page</a></li>
										<li><a href="{{ url('sign-in-modal.html') }}">Sign In Modal</a></li>
										<li><a href="{{ url('contacts.html') }}">Contact Us</a></li>
										<li><a href="{{ url('about-us.html') }}">About Us</a></li>
										<li><a href="{{ url('modal-advertise.html') }}">Modal Advertise</a></li>
										<li><a href="{{ url('modal-newsletter.html') }}">Modal Newsletter</a></li>
										<li><a href="{{ url('gallery.html') }}">Gallery Page</a></li>
									</ul>
								</li>
								<li>
									<a href="{{ url('blog.html') }}">Blog</a>
								</li>
								<li>
									<a href="#0">Buy Template</a>
								</li>
							</ul>
						</div>
						<!--/main-menu -->
					</nav>
				</div>
				<!-- /row -->
			</div>
		</div>
		<!-- /main_header -->
	</header>
	<!-- /header -->
		
	<main class="bg_gray">
		<div class="container margin_30">
			<div class="page_header">
				<h1>About Us</h1>
			</div>
			<!-- /page_header -->
			<div class="row justify-content-center">
				<div class="col-lg-8">
					<div class="box_general">
						<h3>Our Story</h3>
						<p>Welcome to Allaia, your number one source for all things shoes, clothes, and accessories. We're dedicated to giving you the very best of fashion, with a focus on dependability, customer service and uniqueness.</p>
						<p>Founded in 2024 by Jane Doe, Allaia has come a long way from its beginnings in a home office. When Jane first started out, her passion for providing eco-friendly and stylish fashion drove her to do intense research, and gave her the impetus to turn hard work and inspiration into to a booming online store. We now serve customers all over the world, and are thrilled to be a part of the quirky, eco-friendly, fair trade wing of the fashion industry.</p>
						<p>We hope you enjoy our products as much as we enjoy offering them to you. If you have any questions or comments, please don't hesitate to contact us.</p>
						<p>Sincerely,<br>Jane Doe, Founder</p>
					</div>
				</div>
			</div>
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
						<ul>1
							<li><a href="{{ url('about-us.html') }}">About us</a></li>
							<li><a href="{{ url('help.html') }}">Faq</a></li>
							<li><a href="{{ url('help.html') }}">Help</a></li>
							<li><a href="{{ url('account.html') }}">My account</a></li>
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
						<li><img src="{{ asset('img/cards_all.svg') }}" alt="" width="198" height="30" class="lazy"></li>
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
