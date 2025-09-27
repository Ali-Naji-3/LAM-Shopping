
{{-- Problem 238 if  --}}
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
    <link href="{{ asset('css/product_page.css') }}" rel="stylesheet">

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
	    <div class="container margin_30">
	        <div class="countdown_inner">-20% This offer ends in <div data-countdown="2019/05/15" class="countdown"></div>
	        </div>
	        <div class="row">
	            <div class="col-md-6">
	                <div class="all">
	                    <div class="slider">
	                        <div class="owl-carousel owl-theme main">
	                            @if($product->image)
	                                <div style="background-image: url({{ asset('storage/' . $product->image) }});" class="item-box"></div>
	                            @else
	                                <div style="background-image: url(img/products/product_placeholder_square_medium.jpg);" class="item-box"></div>
	                            @endif
                            @if($product->gallery_images && is_array($product->gallery_images))
                                @foreach($product->gallery_images as $image)
                                    <div style="background-image: url({{ asset('storage/' . $image) }});" class="item-box"></div>
                                @endforeach
                            @endif
	                        </div>
	                        <div class="left nonl"><i class="ti-angle-left"></i></div>
	                        <div class="right"><i class="ti-angle-right"></i></div>
	                    </div>
	                    <div class="slider-two">
	                        <div class="owl-carousel owl-theme thumbs">
	                            @if($product->image)
	                                <div style="background-image: url({{ asset('storage/' . $product->image) }});" class="item active"></div>
	                            @else
	                                <div style="background-image: url(img/products/product_placeholder_square_medium.jpg);" class="item active"></div>
	                            @endif
                            @if($product->gallery_images && is_array($product->gallery_images))
                                @foreach($product->gallery_images as $image)
                                    <div style="background-image: url({{ asset('storage/' . $image) }});" class="item"></div>
                                @endforeach
                            @endif
	                        </div>
	                        <div class="left-t nonl-t"></div>
	                        <div class="right-t"></div>
	                    </div>
	                </div>
	            </div>
	            <div class="col-md-6">
                <div class="breadcrumbs">
                    <ul>
                        <li><a href="{{ url('/') }}">Home</a></li>
                        @if($product->category)
                            @php
                                $categoryName = $product->category->name;
                                $categoryUrl = '#';

                                // Map category names to their respective listing pages
                                switch(strtolower($categoryName)) {
                                    case 'men':
                                        $categoryUrl = url('/listing-grid-3');
                                        break;
                                    case 'women':
                                        $categoryUrl = url('/listing-grid-1-full');
                                        break;
                                    case 'boys':
                                    case 'boy':
                                        $categoryUrl = url('/listing-grid-2-full');
                                        break;
                                    case 'girls':
                                    case 'girl':
                                        $categoryUrl = url('/girls');
                                        break;
                                    default:
                                        // For subcategories, try to find parent category
                                        if($product->category->parent) {
                                            $parentName = strtolower($product->category->parent->name);
                                            switch($parentName) {
                                                case 'men':
                                                    $categoryUrl = url('/listing-grid-3');
                                                    $categoryName = 'Men';
                                                    break;
                                                case 'women':
                                                    $categoryUrl = url('/listing-grid-1-full');
                                                    $categoryName = 'Women';
                                                    break;
                                                case 'boys':
                                                case 'boy':
                                                    $categoryUrl = url('/listing-grid-2-full');
                                                    $categoryName = 'Boys';
                                                    break;
                                                case 'girls':
                                                case 'girl':
                                                    $categoryUrl = url('/girls');
                                                    $categoryName = 'Girls';
                                                    break;
                                            }
                                        }
                                        break;
                                }
                            @endphp
                            <li><a href="{{ $categoryUrl }}">{{ $categoryName }}</a></li>
                        @else
                            <li><a href="#">Category</a></li>
                        @endif
                        <li>{{ $product->name }}</li>
                    </ul>
                </div>
	                <!-- /page_header -->
	                <div class="prod_info">
	                    <h1>{{ $product->name }}</h1>
	                    <span class="rating">
	                        @for($i = 1; $i <= 5; $i++)
	                            @if($i <= floor($product->average_rating))
	                                <i class="icon-star voted"></i>
	                            @else
	                                <i class="icon-star"></i>
	                            @endif
	                        @endfor
	                        <em>{{ $product->total_reviews }} reviews</em>
	                    </span>
	                    <p><small>SKU: {{ $product->sku }}</small><br>{{ $product->short_description ?: $product->description }}</p>
	                    <div class="prod_options">
	                        <div class="row">
	                            <label class="col-xl-5 col-lg-5  col-md-6 col-6 pt-0"><strong>Color</strong></label>
	                            <div class="col-xl-4 col-lg-5 col-md-6 col-6 colors">
	                                <ul>
	                                    <li><a href="#0" class="color color_1 active"></a></li>
	                                    <li><a href="#0" class="color color_2"></a></li>
	                                    <li><a href="#0" class="color color_3"></a></li>
	                                    <li><a href="#0" class="color color_4"></a></li>
	                                </ul>
	                            </div>
	                        </div>
	                        <div class="row">
	                            <label class="col-xl-5 col-lg-5 col-md-6 col-6"><strong>Size</strong> - Size Guide <a href="#0" data-bs-toggle="modal" data-bs-target="#size-modal"><i class="ti-help-alt"></i></a></label>
	                            <div class="col-xl-4 col-lg-5 col-md-6 col-6">
	                                <div class="custom-select-form">
	                                    <select class="wide">
	                                        <option value="" selected>Small (S)</option>
	                                        <option value="">M</option>
	                                        <option value=" ">L</option>
	                                        <option value=" ">XL</option>
	                                    </select>
	                                </div>
	                            </div>
	                        </div>
	                        <div class="row">
	                            <label class="col-xl-5 col-lg-5  col-md-6 col-6"><strong>Quantity</strong></label>
	                            <div class="col-xl-4 col-lg-5 col-md-6 col-6">
	                                <div class="numbers-row">
	                                    <input type="text" value="1" id="quantity_1" class="qty2" name="quantity_1">
	                                </div>
	                            </div>
	                        </div>
	                    </div>
	                    <div class="row">
	                        <div class="col-lg-5 col-md-6">
	                            <div class="price_main">
	                                @if($product->sale_price && $product->sale_price < $product->regular_price)
	                                    @php
	                                        $discount = round((($product->regular_price - $product->sale_price) / $product->regular_price) * 100);
	                                    @endphp
	                                    <span class="new_price">${{ number_format($product->sale_price, 2) }}</span>
	                                    <span class="percentage">-{{ $discount }}%</span>
	                                    <span class="old_price">${{ number_format($product->regular_price, 2) }}</span>
	                                @else
	                                    <span class="new_price">${{ number_format($product->regular_price, 2) }}</span>
	                                @endif
	                            </div>
	                        </div>
	                        <div class="col-lg-4 col-md-6">
	                            <div class="btn_add_to_cart"><a href="#0" class="btn_1">Add to Cart</a></div>
	                        </div>
	                    </div>
	                </div>
	                <!-- /prod_info -->
	                <div class="product_actions">
	                    <ul>
	                        <li>
	                            <a href="#"><i class="ti-heart"></i><span>Add to Wishlist</span></a>
	                        </li>
	                        <li>
	                            <a href="#"><i class="ti-control-shuffle"></i><span>Add to Compare</span></a>
	                        </li>
	                    </ul>
	                </div>
	                <!-- /product_actions -->
	            </div>
	        </div>
	        <!-- /row -->
	    </div>
	    <!-- /container -->

	    <div class="tabs_product">
	        <div class="container">
	            <ul class="nav nav-tabs" role="tablist">
	                <li class="nav-item">
	                    <a id="tab-A" href="#pane-A" class="nav-link active" data-bs-toggle="tab" role="tab">Description</a>
	                </li>
	                <li class="nav-item">
	                    <a id="tab-B" href="#pane-B" class="nav-link" data-bs-toggle="tab" role="tab">Reviews</a>
	                </li>
	            </ul>
	        </div>
	    </div>
	    <!-- /tabs_product -->
	    <div class="tab_content_wrapper">
	        <div class="container">
	            <div class="tab-content" role="tablist">
	                <div id="pane-A" class="card tab-pane fade active show" role="tabpanel" aria-labelledby="tab-A">
	                    <div class="card-header" role="tab" id="heading-A">
	                        <h5 class="mb-0">
	                            <a class="collapsed" data-bs-toggle="collapse" href="#collapse-A" aria-expanded="false" aria-controls="collapse-A">
	                                Description
	                            </a>
	                        </h5>
	                    </div>
	                    <div id="collapse-A" class="collapse" role="tabpanel" aria-labelledby="heading-A">
	                        <div class="card-body">
	                            <div class="row justify-content-between">
	                                <div class="col-lg-6">
	                                    <h3>Details</h3>
	                                    <p>Lorem ipsum dolor sit amet, in eleifend <strong>inimicus elaboraret</strong> his, harum efficiendi mel ne. Sale percipit vituperata ex mel, sea ne essent aeterno sanctus, nam ea laoreet civibus electram. Ea vis eius explicari. Quot iuvaret ad has.</p>
	                                    <p>Vis ei ipsum conclusionemque. Te enim suscipit recusabo mea, ne vis mazim aliquando, everti insolens at sit. Cu vel modo unum quaestio, in vide dicta has. Ut his laudem explicari adversarium, nisl <strong>laboramus hendrerit</strong> te his, alia lobortis vis ea.</p>
	                                    <p>Perfecto eleifend sea no, cu audire voluptatibus eam. An alii praesent sit, nobis numquam principes ea eos, cu autem constituto suscipiantur eam. Ex graeci elaboraret pro. Mei te omnis tantas, nobis viderer vivendo ex has.</p>
	                                </div>
                                <div class="col-lg-5">
                                    <h3>Specifications</h3>
                                    <div class="table-responsive">
                                        <table class="table table-sm table-striped">
                                            <tbody>
                                                @if($product->productAttributes && $product->productAttributes->count() > 0)
                                                    @foreach($product->productAttributes as $productAttribute)
                                                        <tr>
                                                            <td><strong>{{ $productAttribute->attributeValue->attribute->name }}</strong></td>
                                                            <td>{{ $productAttribute->attributeValue->value }}</td>
                                                        </tr>
                                                    @endforeach
                                                @else
                                                    <tr>
                                                        <td colspan="2" class="text-center text-muted">No specifications available</td>
                                                    </tr>
                                                @endif
                                            </tbody>
                                        </table>
                                    </div>
                                    <!-- /table-responsive -->
	                                </div>
	                            </div>
	                        </div>
	                    </div>
	                </div>
	                <!-- /TAB A -->
	                <div id="pane-B" class="card tab-pane fade" role="tabpanel" aria-labelledby="tab-B">
	                    <div class="card-header" role="tab" id="heading-B">
	                        <h5 class="mb-0">
	                            <a class="collapsed" data-bs-toggle="collapse" href="#collapse-B" aria-expanded="false" aria-controls="collapse-B">
	                                Reviews
	                            </a>
	                        </h5>
	                    </div>
	                    <div id="collapse-B" class="collapse" role="tabpanel" aria-labelledby="heading-B">
	                        <div class="card-body">
	                            <div class="row justify-content-between">
	                                <div class="col-lg-6">
	                                    <div class="review_content">
	                                        <div class="clearfix add_bottom_10">
	                                            <span class="rating"><i class="icon-star"></i><i class="icon-star"></i><i class="icon-star"></i><i class="icon-star"></i><i class="icon-star"></i><em>5.0/5.0</em></span>
	                                            <em>Published 54 minutes ago</em>
	                                        </div>
	                                        <h4>"Commpletely satisfied"</h4>
	                                        <p>Eos tollit ancillae ea, lorem consulatu qui ne, eu eros eirmod scaevola sea. Et nec tantas accusamus salutatus, sit commodo veritus te, erat legere fabulas has ut. Rebum laudem cum ea, ius essent fuisset ut. Viderer petentium cu his.</p>
	                                    </div>
	                                </div>
	                                <div class="col-lg-6">
	                                    <div class="review_content">
	                                        <div class="clearfix add_bottom_10">
	                                            <span class="rating"><i class="icon-star"></i><i class="icon-star"></i><i class="icon-star"></i><i class="icon-star empty"></i><i class="icon-star empty"></i><em>4.0/5.0</em></span>
	                                            <em>Published 1 day ago</em>
	                                        </div>
	                                        <h4>"Always the best"</h4>
	                                        <p>Et nec tantas accusamus salutatus, sit commodo veritus te, erat legere fabulas has ut. Rebum laudem cum ea, ius essent fuisset ut. Viderer petentium cu his.</p>
	                                    </div>
	                                </div>
	                            </div>
	                            <!-- /row -->
	                            <div class="row justify-content-between">
	                                <div class="col-lg-6">
	                                    <div class="review_content">
	                                        <div class="clearfix add_bottom_10">
	                                            <span class="rating"><i class="icon-star"></i><i class="icon-star"></i><i class="icon-star"></i><i class="icon-star"></i><i class="icon-star empty"></i><em>4.5/5.0</em></span>
	                                            <em>Published 3 days ago</em>
	                                        </div>
	                                        <h4>"Outstanding"</h4>
	                                        <p>Eos tollit ancillae ea, lorem consulatu qui ne, eu eros eirmod scaevola sea. Et nec tantas accusamus salutatus, sit commodo veritus te, erat legere fabulas has ut. Rebum laudem cum ea, ius essent fuisset ut. Viderer petentium cu his.</p>
	                                    </div>
	                                </div>
	                                <div class="col-lg-6">
	                                    <div class="review_content">
	                                        <div class="clearfix add_bottom_10">
	                                            <span class="rating"><i class="icon-star"></i><i class="icon-star"></i><i class="icon-star"></i><i class="icon-star"></i><i class="icon-star"></i><em>5.0/5.0</em></span>
	                                            <em>Published 4 days ago</em>
	                                        </div>
	                                        <h4>"Excellent"</h4>
	                                        <p>Sit commodo veritus te, erat legere fabulas has ut. Rebum laudem cum ea, ius essent fuisset ut. Viderer petentium cu his.</p>
	                                    </div>
	                                </div>
	                            </div>
	                            <!-- /row -->
	                            <p class="text-end"><a href="{{ url('leave-review') }}" class="btn_1">Leave a review</a></p>
	                        </div>
	                        <!-- /card-body -->
	                    </div>
	                </div>
	                <!-- /tab B -->
	            </div>
	            <!-- /tab-content -->
	        </div>
	        <!-- /container -->
	    </div>
	    <!-- /tab_content_wrapper -->

	    <div class="container margin_60_35">
	        <div class="main_title">
	            <h2>Related</h2>
	            <span>Products</span>
	            <p>Cum doctus civibus efficiantur in imperdiet deterruisset.</p>
	        </div>
	        <div class="owl-carousel owl-theme products_carousel">
	            @forelse($relatedProducts as $relatedProduct)
	            <div class="item">
	                <div class="grid_item">
	                    @if($relatedProduct->sale_price && $relatedProduct->sale_price < $relatedProduct->regular_price)
	                        @php
	                            $discount = round((($relatedProduct->regular_price - $relatedProduct->sale_price) / $relatedProduct->regular_price) * 100);
	                        @endphp
	                        <span class="ribbon off">-{{ $discount }}%</span>
	                    @elseif($relatedProduct->featured)
	                        <span class="ribbon hot">Hot</span>
	                    @elseif($relatedProduct->created_at->diffInDays() < 7)
	                        <span class="ribbon new">New</span>
	                    @endif
	                    <figure>
	                        <a href="{{ route('product.detail', $relatedProduct->slug) }}">
	                            @if($relatedProduct->image)
	                                <img class="owl-lazy" src="{{ asset('img/products/product_placeholder_square_medium.jpg') }}" data-src="{{ asset('storage/' . $relatedProduct->image) }}" alt="{{ $relatedProduct->name }}">
	                            @else
	                                <img class="owl-lazy" src="{{ asset('img/products/product_placeholder_square_medium.jpg') }}" data-src="{{ asset('img/products/product_placeholder_square_medium.jpg') }}" alt="{{ $relatedProduct->name }}">
	                            @endif
	                        </a>
	                    </figure>
	                    <div class="rating">
	                        @for($i = 1; $i <= 5; $i++)
	                            @if($i <= floor($relatedProduct->average_rating))
	                                <i class="icon-star voted"></i>
	                            @else
	                                <i class="icon-star"></i>
	                            @endif
	                        @endfor
	                    </div>
	                    <a href="{{ route('product.detail', $relatedProduct->slug) }}">
	                        <h3>{{ $relatedProduct->name }}</h3>
	                    </a>
	                    <div class="price_box">
	                        @if($relatedProduct->sale_price && $relatedProduct->sale_price < $relatedProduct->regular_price)
	                            <span class="new_price">${{ number_format($relatedProduct->sale_price, 2) }}</span>
	                            <span class="old_price">${{ number_format($relatedProduct->regular_price, 2) }}</span>
	                        @else
	                            <span class="new_price">${{ number_format($relatedProduct->regular_price, 2) }}</span>
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
	            <!-- /item -->
	            @empty
	            <div class="col-12">
	                <div class="text-center py-5">
	                    <h3>No related products found</h3>
	                    <p>Check back soon for more products in this category!</p>
	                </div>
	            </div>
	            @endforelse
	        </div>
	        <!-- /products_carousel -->
	    </div>
	    <!-- /container -->

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

	</main>
	<!-- /main -->

	<footer class="revealed">
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

	<div class="top_panel">
	    <div class="container header_panel">
	        <a href="#0" class="btn_close_top_panel"><i class="ti-close"></i></a>
	        <label>1 product added to cart</label>
	    </div>
	    <!-- /header_panel -->
	    <div class="item">
	        <div class="container">
	            <div class="row">
	                <div class="col-md-7">
	                    <div class="item_panel">
	                        <figure>
	                            <img src="{{ asset('img/products/product_placeholder_square_small.jpg') }}" data-src="{{ asset('img/products/shoes/1.jpg') }}" class="lazy" alt="">
	                        </figure>
	                        <h4>1x Armor Air X Fear</h4>
	                        <div class="price_panel"><span class="new_price">$148.00</span><span class="percentage">-20%</span> <span class="old_price">$160.00</span></div>
	                    </div>
	                </div>
	                <div class="col-md-5 btn_panel">
	                    <a href="{{ url('cart') }}" class="btn_1 outline">View cart</a> <a href="{{ url('checkout') }}" class="btn_1">Checkout</a>
	                </div>
	            </div>
	        </div>
	    </div>
	    <!-- /item -->
	    <div class="container related">
	        <h4>Who bought this product also bought</h4>
	        <div class="row">
	            <div class="col-md-4">
	                <div class="item_panel">
	                    <a href="#0">
	                        <figure>
	                            <img src="{{ asset('img/products/product_placeholder_square_small.jpg') }}" data-src="{{ asset('img/products/shoes/2.jpg') }}" alt="" class="lazy">
	                        </figure>
	                    </a>
	                    <a href="#0">
	                        <h5>Armor Okwahn II</h5>
	                    </a>
	                    <div class="price_panel"><span class="new_price">$90.00</span></div>
	                </div>
	            </div>
	            <div class="col-md-4">
	                <div class="item_panel">
	                    <a href="#0">
	                        <figure>
	                            <img src="{{ asset('img/products/product_placeholder_square_small.jpg') }}" data-src="{{ asset('img/products/shoes/3.jpg') }}" alt="" class="lazy">
	                        </figure>
	                    </a>
	                    <a href="#0">
	                        <h5>Armor Air Wildwood ACG</h5>
	                    </a>
	                    <div class="price_panel"><span class="new_price">$75.00</span><span class="percentage">-20%</span> <span class="old_price">$155.00</span></div>
	                </div>
	            </div>
	            <div class="col-md-4">
	                <div class="item_panel">
	                    <a href="#0">
	                        <figure>
	                            <img src="{{ asset('img/products/product_placeholder_square_small.jpg') }}" data-src="{{ asset('img/products/shoes/4.jpg') }}" alt="" class="lazy">
	                        </figure>
	                    </a>
	                    <a href="#0">
	                        <h5>Armor ACG React Terra</h5>
	                    </a>
	                    <div class="price_panel"><span class="new_price">$110.00</span></div>
	                </div>
	            </div>
	        </div>
	    </div>
	    <!-- /related -->
	</div>
	<!-- /add_cart_panel -->

	<!-- Size modal -->
	<div class="modal fade" tabindex="-1" role="dialog" aria-labelledby="size-modal" id="size-modal" aria-hidden="true">
		<div class="modal-dialog modal-dialog-centered modal-lg">
			<div class="modal-content">
				<div class="modal-header">
					<h5 class="modal-title">Size guide</h5>
					<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
				</div>
				<div class="modal-body">
					<p>Lorem ipsum dolor sit amet, et velit propriae invenire mea, ad nam alia intellegat. Aperiam mediocrem rationibus nec te. Tation persecuti accommodare pro te. Vis et augue legere, vel labitur habemus ocurreret ex.</p>
					<div class="table-responsive">
                                <table class="table table-striped table-sm sizes">
                                    <tbody><tr>
                                        <th scope="row">US Sizes</th>
                                        <td>6</td>
                                        <td>6,5</td>
                                        <td>7</td>
                                        <td>7,5</td>
                                        <td>8</td>
                                        <td>8,5</td>
                                        <td>9</td>
                                        <td>9,5</td>
                                        <td>10</td>
                                        <td>10,5</td>
                                    </tr>
                                    <tr>
                                        <th scope="row">Euro Sizes</th>
                                        <td>39</td>
                                        <td>39</td>
                                        <td>40</td>
                                        <td>40-41</td>
                                        <td>41</td>
                                        <td>41-42</td>
                                        <td>42</td>
                                        <td>42-43</td>
                                        <td>43</td>
                                        <td>43-44</td>
                                    </tr>
                                    <tr>
                                        <th scope="row">UK Sizes</th>
                                        <td>5,5</td>
                                        <td>6</td>
                                        <td>6,5</td>
                                        <td>7</td>
                                        <td>7,5</td>
                                        <td>8</td>
                                        <td>8,5</td>
                                        <td>9</td>
                                        <td>9,5</td>
                                        <td>10</td>
                                    </tr>
                                    <tr>
                                        <th scope="row">Inches</th>
                                        <td>9.25"</td>
                                        <td>9.5"</td>
                                        <td>9.625"</td>
                                        <td>9.75"</td>
                                        <td>9.9375"</td>
                                        <td>10.125"</td>
                                        <td>10.25"</td>
                                        <td>10.5"</td>
                                        <td>10.625"</td>
                                        <td>10.75"</td>
                                    </tr>
                                    <tr>
                                        <th scope="row">CM</th>
                                        <td>23,5</td>
                                        <td>24,1</td>
                                        <td>24,4</td>
                                        <td>24,8</td>
                                        <td>25,4</td>
                                        <td>25,7</td>
                                        <td>26</td>
                                        <td>26,7</td>
                                        <td>27</td>
                                        <td>27,3</td>
                                    </tr>
                                </tbody></table>
                            </div>
					<!-- /table -->
				</div>
			</div>
		</div>
	</div>


 	<!-- COMMON SCRIPTS -->
    <script src="{{ asset('js/common_scripts.min.js') }}"></script>
    <script src="{{ asset('js/main.js') }}"></script>

    <!-- SPECIFIC SCRIPTS -->
    <script src="{{ asset('js/carousel_with_thumbs.js') }}"></script>

</body>

</html>
