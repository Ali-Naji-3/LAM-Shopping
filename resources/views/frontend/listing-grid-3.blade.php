
@extends('frontend.layouts.layout')
@section('content')
<main>

		<div class="container margin_30">
		    <div class="top_banner version_2">
		        <div class="opacity-mask d-flex align-items-center" data-opacity-mask="rgba(0, 0, 0, 0)">
		            <div class="container">
		                <div class="d-flex justify-content-center">
		                </div>
		            </div>
		        </div>
		        <img src="img/hero/mans.jpg" class="img-fluid" alt="">
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
		                            <option value="price-desc">Sort by price: high to
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
		            <div class="collapse" id="filters">
		                <div class="row small-gutters filters_listing_1">
		                    <div class="col-lg-3 col-md-6 col-sm-6">
		                        <div class="dropdown">
		                            <a href="#" data-bs-toggle="dropdown" class="drop">Categories</a>
		                            <div class="dropdown-menu">
		                                <div class="filter_type">
		                                    <ul>
		                                        <li>
		                                            <label class="container_check">Men <small>12</small>
		                                                <input type="checkbox">
		                                                <span class="checkmark"></span>
		                                            </label>
		                                        </li>
		                                        <li>
		                                            <label class="container_check">Women <small>24</small>
		                                                <input type="checkbox">
		                                                <span class="checkmark"></span>
		                                            </label>
		                                        </li>
		                                        <li>
		                                            <label class="container_check">Running <small>23</small>
		                                                <input type="checkbox">
		                                                <span class="checkmark"></span>
		                                            </label>
		                                        </li>
		                                        <li>
		                                            <label class="container_check">Training <small>11</small>
		                                                <input type="checkbox">
		                                                <span class="checkmark"></span>
		                                            </label>
		                                        </li>
		                                    </ul>
		                                    <a href="#0" class="apply_filter">Apply</a>
		                                </div>
		                            </div>
		                        </div>
		                        <!-- /dropdown -->
		                    </div>
		                    <div class="col-lg-3 col-md-6 col-sm-6">
		                        <div class="dropdown">
		                            <a href="#" data-bs-toggle="dropdown" class="drop">Color</a>
		                            <div class="dropdown-menu">
		                                <div class="filter_type">
		                                    <ul>
		                                        <li>
		                                            <label class="container_check">Blue <small>06</small>
		                                                <input type="checkbox">
		                                                <span class="checkmark"></span>
		                                            </label>
		                                        </li>
		                                        <li>
		                                            <label class="container_check">Red <small>12</small>
		                                                <input type="checkbox">
		                                                <span class="checkmark"></span>
		                                            </label>
		                                        </li>
		                                        <li>
		                                            <label class="container_check">Orange <small>17</small>
		                                                <input type="checkbox">
		                                                <span class="checkmark"></span>
		                                            </label>
		                                        </li>
		                                        <li>
		                                            <label class="container_check">Black <small>43</small>
		                                                <input type="checkbox">
		                                                <span class="checkmark"></span>
		                                            </label>
		                                        </li>
		                                    </ul>
		                                    <a href="#0" class="apply_filter">Apply</a>
		                                </div>
		                            </div>
		                        </div>
		                        <!-- /dropdown -->
		                    </div>
		                    <div class="col-lg-3 col-md-6 col-sm-6">
		                        <div class="dropdown">
		                            <a href="#" data-bs-toggle="dropdown" class="drop">Brand</a>
		                            <div class="dropdown-menu">
		                                <div class="filter_type">
		                                    <ul>
		                                        <li>
		                                            <label class="container_check">Adidas <small>11</small>
		                                                <input type="checkbox">
		                                                <span class="checkmark"></span>
		                                            </label>
		                                        </li>
		                                        <li>
		                                            <label class="container_check">Nike <small>08</small>
		                                                <input type="checkbox">
		                                                <span class="checkmark"></span>
		                                            </label>
		                                        </li>
		                                        <li>
		                                            <label class="container_check">Vans <small>05</small>
		                                                <input type="checkbox">
		                                                <span class="checkmark"></span>
		                                            </label>
		                                        </li>
		                                        <li>
		                                            <label class="container_check">Puma <small>18</small>
		                                                <input type="checkbox">
		                                                <span class="checkmark"></span>
		                                            </label>
		                                        </li>
		                                    </ul>
		                                    <a href="#0" class="apply_filter">Apply</a>
		                                </div>
		                            </div>
		                        </div>
		                        <!-- /dropdown -->
		                    </div>
		                    <div class="col-lg-3 col-md-6 col-sm-6">
		                        <div class="dropdown">
		                            <a href="#" data-bs-toggle="dropdown" class="drop">Price</a>
		                            <div class="dropdown-menu">
		                                <div class="filter_type">
		                                    <ul>
		                                        <li>
		                                            <label class="container_check">$0 — $50<small>11</small>
		                                                <input type="checkbox">
		                                                <span class="checkmark"></span>
		                                            </label>
		                                        </li>
		                                        <li>
		                                            <label class="container_check">$50 — $100<small>08</small>
		                                                <input type="checkbox">
		                                                <span class="checkmark"></span>
		                                            </label>
		                                        </li>
		                                        <li>
		                                            <label class="container_check">$100 — $150<small>05</small>
		                                                <input type="checkbox">
		                                                <span class="checkmark"></span>
		                                            </label>
		                                        </li>
		                                        <li>
		                                            <label class="container_check">$150 — $200<small>18</small>
		                                                <input type="checkbox">
		                                                <span class="checkmark"></span>
		                                            </label>
		                                        </li>
		                                    </ul>
		                                    <a href="#0" class="apply_filter">Apply</a>
		                                </div>
		                            </div>
		                        </div>
		                        <!-- /dropdown -->
		                    </div>
		                </div>
		            </div>
		        </div>
		    </div>
		    <!-- /toolbox -->
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
									<img class="img-fluid lazy" src="{{ asset('storage/' . $product->image) }}" alt="{{ $product->name }}" width="400" height="400" style="object-fit: cover;">
								@else
									<img class="img-fluid lazy" src="{{ asset('img/product.png') }}" alt="{{ $product->name }}" width="400" height="400" style="object-fit: cover;">
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
						<h3>No Men's products found</h3>
						<p>We're working on adding more Men's products. Check back soon!</p>
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
@endsection

