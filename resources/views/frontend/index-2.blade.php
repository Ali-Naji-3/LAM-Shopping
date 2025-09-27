@extends('frontend.layouts.layout')

@section('content')
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
			<video autoplay muted loop playsinline class="header-video--media">
    <source src="{{ asset('video/hero.mp4') }}" type="video/mp4">
    Your browser does not support the video tag.
</video>

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
					<li><a href="#0" id="all" data-filter="*">All</a></li>
					<li><a href="#0" id="popular" data-filter=".popular">Popular</a></li>
					<li><a href="#0" id="sale" data-filter=".sale">Sale</a></li>
				</ul>
			</div>
			<div class="isotope-wrapper">
				<div class="row small-gutters">
					<div class="col-6 col-md-4 col-xl-3 isotope-item sale">
						<div class="grid_item">
							<figure>
								<span class="ribbon off">-30%</span>
								<a href="product-detail-1.html">
									<img class="img-fluid lazy" src="img/products/product_placeholder_square_medium.jpg" data-src="img/products/shoes/1.jpg" alt="">
									<img class="img-fluid lazy" src="img/products/product_placeholder_square_medium.jpg" data-src="img/products/shoes/1_b.jpg" alt="">
								</a>
								<div data-countdown="2019/05/15" class="countdown"></div>
							</figure>
							<div class="rating"><i class="icon-star voted"></i><i class="icon-star voted"></i><i class="icon-star voted"></i><i class="icon-star voted"></i><i class="icon-star"></i></div>
							<a href="product-detail-1.html">
								<h3>Armor Air x Fear</h3>
							</a>
							<div class="price_box">
								<span class="new_price">$48.00</span>
								<span class="old_price">$60.00</span>
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
					<div class="col-6 col-md-4 col-xl-3 isotope-item sale">
						<div class="grid_item">
							<span class="ribbon off">-30%</span>
							<figure>
								<a href="product-detail-1.html">
									<img class="img-fluid lazy" src="img/products/product_placeholder_square_medium.jpg" data-src="img/products/shoes/2.jpg" alt="">
									<img class="img-fluid lazy" src="img/products/product_placeholder_square_medium.jpg" data-src="img/products/shoes/2_b.jpg" alt="">
								</a>
								<div data-countdown="2019/05/10" class="countdown"></div>
							</figure>
							<div class="rating"><i class="icon-star voted"></i><i class="icon-star voted"></i><i class="icon-star voted"></i><i class="icon-star voted"></i><i class="icon-star"></i></div>
							<a href="product-detail-1.html">
								<h3>Armor Okwahn II</h3>
							</a>
							<div class="price_box">
								<span class="new_price">$90.00</span>
								<span class="old_price">$170.00</span>
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
					<div class="col-6 col-md-4 col-xl-3 isotope-item sale">
						<div class="grid_item">
							<span class="ribbon off">-50%</span>
							<figure>
								<a href="product-detail-1.html">
									<img class="img-fluid lazy" src="img/products/product_placeholder_square_medium.jpg" data-src="img/products/shoes/3.jpg" alt="">
									<img class="img-fluid lazy" src="img/products/product_placeholder_square_medium.jpg" data-src="img/products/shoes/3_b.jpg" alt="">
								</a>
								<div data-countdown="2019/05/21" class="countdown"></div>
							</figure>
							<div class="rating"><i class="icon-star voted"></i><i class="icon-star voted"></i><i class="icon-star voted"></i><i class="icon-star voted"></i><i class="icon-star"></i></div>
							<a href="product-detail-1.html">
								<h3>Armor Air Wildwood ACG</h3>
							</a>
							<div class="price_box">
								<span class="new_price">$75.00</span>
								<span class="old_price">$155.00</span>
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
					<div class="col-6 col-md-4 col-xl-3 isotope-item popular">
						<div class="grid_item">
							<span class="ribbon new">New</span>
							<figure>
								<a href="product-detail-1.html">
									<img class="img-fluid lazy" src="img/products/product_placeholder_square_medium.jpg" data-src="img/products/shoes/4.jpg" alt="">
									<img class="img-fluid lazy" src="img/products/product_placeholder_square_medium.jpg" data-src="img/products/shoes/4_b.jpg" alt="">
								</a>
							</figure>
							<div class="rating"><i class="icon-star voted"></i><i class="icon-star voted"></i><i class="icon-star voted"></i><i class="icon-star voted"></i><i class="icon-star"></i></div>
							<a href="product-detail-1.html">
								<h3>Armor ACG React Terra</h3>
							</a>
							<div class="price_box">
								<span class="new_price">$110.00</span>
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
					<div class="col-6 col-md-4 col-xl-3 isotope-item popular">
						<div class="grid_item">
							<span class="ribbon new">New</span>
							<figure>
								<a href="product-detail-1.html">
									<img class="img-fluid lazy" src="img/products/product_placeholder_square_medium.jpg" data-src="img/products/shoes/5.jpg" alt="">
									<img class="img-fluid lazy" src="img/products/product_placeholder_square_medium.jpg" data-src="img/products/shoes/5_b.jpg" alt="">
								</a>
							</figure>
							<div class="rating"><i class="icon-star voted"></i><i class="icon-star voted"></i><i class="icon-star voted"></i><i class="icon-star voted"></i><i class="icon-star"></i></div>
							<a href="product-detail-1.html">
								<h3>Armor Air Zoom Alpha</h3>
							</a>
							<div class="price_box">
								<span class="new_price">$140.00</span>
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
					<div class="col-6 col-md-4 col-xl-3 isotope-item popular">
						<div class="grid_item">
							<span class="ribbon new">New</span>
							<figure>
								<a href="product-detail-1.html">
									<img class="img-fluid lazy" src="img/products/product_placeholder_square_medium.jpg" data-src="img/products/shoes/6.jpg" alt="">
									<img class="img-fluid lazy" src="img/products/product_placeholder_square_medium.jpg" data-src="img/products/shoes/6_b.jpg" alt="">
								</a>
							</figure>
							<div class="rating"><i class="icon-star voted"></i><i class="icon-star voted"></i><i class="icon-star voted"></i><i class="icon-star voted"></i><i class="icon-star"></i></div>
							<a href="product-detail-1.html">
								<h3>Armor Air Alpha</h3>
							</a>
							<div class="price_box">
								<span class="new_price">$130.00</span>
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
					<div class="col-6 col-md-4 col-xl-3 isotope-item popular">
						<div class="grid_item">
							<span class="ribbon hot">Hot</span>
							<figure>
								<a href="product-detail-1.html">
									<img class="img-fluid lazy" src="img/products/product_placeholder_square_medium.jpg" data-src="img/products/shoes/7.jpg" alt="">
									<img class="img-fluid lazy" src="img/products/product_placeholder_square_medium.jpg" data-src="img/products/shoes/7_b.jpg" alt="">
								</a>
							</figure>
							<div class="rating"><i class="icon-star voted"></i><i class="icon-star voted"></i><i class="icon-star voted"></i><i class="icon-star voted"></i><i class="icon-star"></i></div>
							<a href="product-detail-1.html">
								<h3>Armor Air Max 98</h3>
							</a>
							<div class="price_box">
								<span class="new_price">$115.00</span>
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
					<div class="col-6 col-md-4 col-xl-3 isotope-item popular">
						<div class="grid_item">
							<span class="ribbon hot">Hot</span>
							<figure>
								<a href="product-detail-1.html">
									<img class="img-fluid lazy" src="img/products/product_placeholder_square_medium.jpg" data-src="img/products/shoes/8.jpg" alt="">
									<img class="img-fluid lazy" src="img/products/product_placeholder_square_medium.jpg" data-src="img/products/shoes/8_b.jpg" alt="">
								</a>
							</figure>
							<div class="rating"><i class="icon-star voted"></i><i class="icon-star voted"></i><i class="icon-star voted"></i><i class="icon-star voted"></i><i class="icon-star"></i></div>
							<a href="product-detail-1.html">
								<h3>Armor Air Max 720</h3>
							</a>
							<div class="price_box">
								<span class="new_price">$120.00</span>
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
@endsection



