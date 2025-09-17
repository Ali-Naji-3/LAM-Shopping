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
    <link href="css/account.css" rel="stylesheet">

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
								<a href="my-wishlist.html" class="wishlist"><span>Wishlist</span></a>
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
	
	<main class="bg_gray">
		<div class="container margin_30">
		<div class="page_header">
			<div class="breadcrumbs">
				<ul>
					<li><a href="#">Home</a></li>
					<li><a href="#">Category</a></li>
					<li>Page active</li>
				</ul>
			</div>
			<h1>My Wishlist page</h1>
		</div>
		<!-- /page_header -->
		<table class="table table-striped product-list whislist mb-5">
			<thead>
				<tr>
					<th>
						Product
					</th>
					<th>
						Price
					</th>
					<th>
						Product id
					</th>
					<th>
                        Action
					</th>
                    <th>
                        Remove
					</th>
				</tr>
			</thead>
			<tbody>
				<tr>
					<td>
						<div class="thumb_product">
							<img src="img/products/product_placeholder_square_small.jpg" data-src="img/products/shoes/1.jpg"
								class="lazy" alt="Image">
						</div>
						<span class="item_product"><a href="#">Armor Air x Fear</a></span>
					</td>
					<td>
						<strong>$140.00</strong>
					</td>
					<td>
						<strong>#ew33r4</strong>
					</td>
					<td>
						<a href="#0" class="btn_1">Add to cart</a>
					</td>
                    <td class="options">
                        <a href="#"><i class="ti-trash"></i></a>
                    </td>
				</tr>
				<tr>
					<td>
						<div class="thumb_product">
							<img src="img/products/product_placeholder_square_small.jpg" data-src="img/products/shoes/1.jpg"
								class="lazy" alt="Image">
						</div>
						<span class="item_product"><a href="#">Armor Air x Fear</a></span>
					</td>
					<td>
						<strong>$140.00</strong>
					</td>
					<td>
						<strong>#ew33r4</strong>
					</td>
					<td>
						<a href="#0" class="btn_1">Add to cart</a>
					</td>
                    <td class="options">
                        <a href="#"><i class="ti-trash"></i></a>
                    </td>
				</tr>
				<tr>
					<td>
						<div class="thumb_product">
							<img src="img/products/product_placeholder_square_small.jpg" data-src="img/products/shoes/1.jpg"
								class="lazy" alt="Image">
						</div>
						<span class="item_product"><a href="#">Armor Air x Fear</a></span>
					</td>
					<td>
						<strong>$140.00</strong>
					</td>
					<td>
						<strong>#ew33r4</strong>
					</td>
					<td>
						<a href="#0" class="btn_1">Add to cart</a>
					</td>
                    <td class="options">
                        <a href="#"><i class="ti-trash"></i></a>
                    </td>
				</tr>
                <tr>
					<td>
						<div class="thumb_product">
							<img src="img/products/product_placeholder_square_small.jpg" data-src="img/products/shoes/1.jpg"
								class="lazy" alt="Image">
						</div>
						<span class="item_product"><a href="#">Armor Air x Fear</a></span>
					</td>
					<td>
						<strong>$140.00</strong>
					</td>
					<td>
						<strong>#ew33r4</strong>
					</td>
					<td>
						<a href="#0" class="btn_1">Add to cart</a>
					</td>
                    <td class="options">
                        <a href="#"><i class="ti-trash"></i></a>
                    </td>
				</tr>
			</tbody>
		</table>
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

		
</body>
</html>