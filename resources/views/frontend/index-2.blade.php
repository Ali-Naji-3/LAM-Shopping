@extends('frontend.layouts.layout')
@section('content')
	<main>

@php

    $setting = \App\Models\Setting::first();

@endphp

<div class="header-video">
    <div id="hero_video">
        <div class="opacity-mask d-flex align-items-center" data-opacity-mask="rgba(0, 0, 0, 0.5)">
            <div class="container">
                <div class="row justify-content-center justify-content-md-start">
                    <div class="col-lg-6">
                        <div class="slide-text white">
                            <h1 class="text-white">{{  $setting->hero_title??'' }}</h1>
                            <p>{{  $setting->hero_sub_title??'' }}</p>
                            <a href="#" class="btn btn-primary">
                                {{ $setting->hero_button_text??'' }}
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>


       		<video autoplay muted loop playsinline class="header-video--media" onerror="this.style.display='none'; this.nextElementSibling.style.display='block';">
    <source src="{{ asset('storage/'. $setting->hero_background) }}" type="video/mp4">
    Your browser does not support the video tag.
</video>
        {{-- صورة fallback --}}
        {{-- <div class="header-video--fallback"
             style="display:none; position:absolute; top:0; left:0; width:100%; height:100%;
                    background-image:url('{{ asset('img/hero/main.png') }}');
                    background-size:cover; background-position:center;">
        </div> --}}

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
					<a href="{{ route('listing.girls') }}">
						<img src="{{ asset('img/hero/grils.jpeg') }}" data-src="{{ asset('img/hero/grils.jpeg') }}" alt="" class="img-fluid lazy">
						<div class="wrapper">
							<h2>Grils</h2>
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
 {{-- @php
    $setting = \App\Models\Setting::first();
    $sliders = json_decode($setting->sliders ?? '[]', true);
@endphp

<div class="container margin_60_35">
    <div class="row small-gutters categories_grid">
        @foreach($sliders as $key => $slider)
            <div class="col-sm-6 col-md-3 mb-3">
                <a href="{{ $slider['link'] ?? '#' }}">
                    <img src="{{ asset('storage/categories/' . ($slider['image'] ?? 'placeholder.jpg')) }}"
                         alt="{{ $slider['name'] ?? $key }}"
                         class="img-fluid lazy">
                    <div class="wrapper">
                        <h2>{{ $slider['name'] ?? $key }}</h2>
                        <p>{{ $slider['products'] ?? 0 }} Products</p>
                    </div>
                </a>
            </div>
        @endforeach
    </div>
</div> --}}




{{-- <div class="container margin_60_35">
    <div class="row small-gutters categories_grid">
        @foreach($categories as $key => $cat)
            @if($key == 0)
                <div class="col-sm-12 col-md-6">
                    <a href="{{ $cat['link'] }}">
                        <img src="{{ asset('img/hero/'.$cat['image']) }}" alt="{{ $cat['title'] }}" class="img-fluid lazy">
                        <div class="wrapper">
                            <h2>{{ $cat['title'] }}</h2>
                            <p>{{ $cat['products'] }} Products</p>
                        </div>
                    </a>
                </div>
            @else
                @if($key == 1)
                    <div class="col-sm-12 col-md-6">
                        <div class="row small-gutters mt-md-0 mt-sm-2">
                @endif

                        <div class="col-sm-{{ $key == 3 ? 12 : 6 }} mt-sm-{{ $key == 3 ? '2' : '0' }}">
                            <a href="{{ $cat['link'] }}">
                                <img src="{{ asset('img/hero/'.$cat['image']) }}" alt="{{ $cat['title'] }}" class="img-fluid lazy">
                                <div class="wrapper">
                                    <h2>{{ $cat['title'] }}</h2>
                                    <p>{{ $cat['products'] }} Products</p>
                                </div>
                            </a>
                        </div>

                @if($key == 3)
                        </div>
                    </div>
                @endif
            @endif
        @endforeach
    </div>
</div> --}}

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
										<img class="img-fluid lazy" src="{{ asset('storage/' . $product->image) }}" alt="{{ $product->name }}" width="400" height="400" style="object-fit: cover;">
									@else
										<img class="img-fluid lazy" src="{{ asset('img/product.png') }}" alt="{{ $product->name }}" width="400" height="400" style="object-fit: cover;">
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

		<div class="featured lazy" data-bg="url(img/hero/feature.jpeg)">
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
								<a class="btn_1" href="#" role="button">Shop Now</a>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
		<!-- /featured -->

		<div class="bg_gray">
			<div class="container-fluid">
				<div class="brands-marquee-wrapper" style="overflow: hidden; padding: 30px 0; position: relative;">
					<!-- Marquee Effect -->
					<div class="brands-marquee" style="display: flex; gap: 60px; animation: marquee 30s linear infinite; will-change: transform;">
						@forelse($brandSliders as $brandSlider)
						<div class="brand-item" style="flex-shrink: 0; display: flex; align-items: center; justify-content: center; min-width: 180px;">
							<a href="{{ $brandSlider->link ?: '#0' }}"
							   @if($brandSlider->link) target="_blank" @endif
							   style="display: block; transition: transform 0.3s ease; text-decoration: none;"
							   onmouseover="this.style.transform='scale(1.1)'"
							   onmouseout="this.style.transform='scale(1)'">
								<img src="{{ asset('storage/' . $brandSlider->image) }}"
								     alt="{{ $brandSlider->title ?: 'Brand' }}"
								     style="max-height: 100px; max-width: 180px; object-fit: contain; opacity: 1; transition: transform 0.3s ease;">
							</a>
						</div>
						@empty
						<!-- Fallback to default brand images if no sliders -->
						<div class="brand-item" style="flex-shrink: 0; min-width: 180px;">
							<a href="#0"><img src="{{asset('img/hero/clothes.png')}}" alt="" style="max-height: 100px; max-width: 180px; object-fit: contain; opacity: 1;"></a>
						</div>
						<div class="brand-item" style="flex-shrink: 0; min-width: 180px;">
							<a href="#0"><img src="{{asset('img/brands/puma.png')}}" alt="" style="max-height: 100px; max-width: 180px; object-fit: contain; opacity: 1;"></a>
						</div>
						<div class="brand-item" style="flex-shrink: 0; min-width: 180px;">
							<a href="#0"><img src="{{asset('img/brands/supreme.png')}}" alt="" style="max-height: 100px; max-width: 180px; object-fit: contain; opacity: 1;"></a>
						</div>
						<div class="brand-item" style="flex-shrink: 0; min-width: 180px;">
							<a href="#0"><img src="{{asset('img/brands/prada.jpg')}}" alt="" style="max-height: 100px; max-width: 180px; object-fit: contain; opacity: 1;"></a>
						</div>
						<div class="brand-item" style="flex-shrink: 0; min-width: 180px;">
							<a href="#0"><img src="{{asset('img/brands/adidas.jpg')}}" alt="" style="max-height: 100px; max-width: 180px; object-fit: contain; opacity: 1;"></a>
						</div>
						<div class="brand-item" style="flex-shrink: 0; min-width: 180px;">
							<a href="#0"><img src="{{asset('img/brands/dior.jpeg')}}" alt="" style="max-height: 100px; max-width: 180px; object-fit: contain; opacity: 1;"></a>
						</div>
						@endforelse

						<!-- Duplicate items for seamless loop -->
						@if($brandSliders->count() > 0)
							@foreach($brandSliders as $brandSlider)
							<div class="brand-item" style="flex-shrink: 0; display: flex; align-items: center; justify-content: center; min-width: 180px;">
								<a href="{{ $brandSlider->link ?: '#0' }}"
								   @if($brandSlider->link) target="_blank" @endif
								   style="display: block; transition: transform 0.3s ease;"
								   onmouseover="this.style.transform='scale(1.1)'"
								   onmouseout="this.style.transform='scale(1)'">
									<img src="{{ asset('storage/' . $brandSlider->image) }}"
									     alt="{{ $brandSlider->title ?: 'Brand' }}"
									     style="max-height: 100px; max-width: 180px; object-fit: contain; opacity: 1; transition: transform 0.3s ease;">
								</a>
							</div>
							@endforeach
						@endif
					</div>
				</div>
			</div>
		</div>

		<style>
		@keyframes marquee {
			0% {
				transform: translateX(0);
			}
			100% {
				transform: translateX(-50%);
			}
		}

		.brands-marquee-wrapper:hover .brands-marquee {
			animation-play-state: paused;
		}

		.brands-marquee {
			display: inline-flex !important;
		}

		/* Responsive adjustments */
		@media (max-width: 768px) {
			.brand-item {
				min-width: 120px !important;
			}

			.brand-item img {
				max-height: 60px !important;
			}
		}
		</style>


	</main>
@endsection



