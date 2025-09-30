

@extends('frontend.layouts.layout')
@section('content')
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
                                <div style="background-image: url({{ asset('img/products/product_placeholder_square_medium.jpg') }});" class="item-box"></div>
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
                                <div style="background-image: url({{ asset('img/products/product_placeholder_square_medium.jpg') }});" class="item active"></div>
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
                    <x-dynamic-star-rating
                        :product="$product"
                        size="normal"
                        :show-count="true"
                        :show-average="true"
                        class="product-rating" />
	                    <p><small>SKU: {{ $product->sku }}</small><br>{{ $product->short_description ?: $product->description }}</p>

	                    <!-- Quick Review Button -->
	                    <div class="mt-3 mb-3">
	                        <a href="{{ route('frontend.leave-review', ['product' => $product->id]) }}" class="btn_1 outline">
	                            <i class="ti-star"></i> Write a Review for {{ $product->name }}
	                        </a>
	                    </div>
	                    <div class="prod_options">
	                        <div class="row">
	                            <label class="col-xl-5 col-lg-5  col-md-6 col-6 pt-0"><strong>Color</strong></label>
	                            <div class="col-xl-4 col-lg-5 col-md-6 col-6 colors">
	                                <ul class="color-dots-list">
	                                    @php
	                                        $colorAttribute = \App\Models\Attribute::where('slug', 'color')->first();
	                                        $productColors = $product->productAttributes()
	                                            ->whereHas('attributeValue.attribute', function($q) {
	                                                $q->where('slug', 'color');
	                                            })
	                                            ->with('attributeValue')
	                                            ->get();
	                                    @endphp

	                                    @if($productColors->count() > 0)
	                                        @foreach($productColors as $index => $productColor)
	                                            @php
	                                                $colorValue = $productColor->attributeValue->value;


	                                                // Color mapping
	                                                $colorMap = [
	                                                    'black' => '#000000',
	                                                    'white' => '#ffffff',
	                                                    'red' => '#ff0000',
	                                                    'blue' => '#0000ff',
	                                                    'green' => '#00ff00',
	                                                    'yellow' => '#ffff00',
	                                                    'pink' => '#ffc0cb',
	                                                    'gray' => '#808080',
	                                                    'brown' => '#a52a2a',
	                                                    'navy' => '#000080',
	                                                    'purple' => '#800080',
	                                                    'orange' => '#ffa500',
	                                                    'beige' => '#f5f5dc',
	                                                    'maroon' => '#800000',
	                                                    'teal' => '#008080',
	                                                    'lime' => '#00ff00',
	                                                    'cyan' => '#00ffff',
	                                                    'magenta' => '#ff00ff',
	                                                    'silver' => '#c0c0c0',
	                                                    'gold' => '#ffd700'
	                                                ];
	                                                $colorHex = $colorMap[strtolower($colorValue)] ?? '#cccccc';
	                                                $isFirst = $index === 0;
	                                            @endphp
	                                            <li>
	                                                <a href="#0"
	                                                   class="color-dot {{ $isFirst ? 'active' : '' }}"
	                                                   data-color="{{ $colorValue }}"
	                                                   data-hex="{{ $colorHex }}"
	                                                   data-product-id="{{ $product->id }}"
	                                                   style="background-color: {{ $colorHex }};"
	                                                   title="{{ ucfirst($colorValue) }}">
	                                                </a>
	                                            </li>
	                                        @endforeach
	                                    @else
	                                        <!-- Fallback colors if no database colors -->
	                                        <li><a href="#0" class="color color_1 active"></a></li>
	                                        <li><a href="#0" class="color color_2"></a></li>
	                                        <li><a href="#0" class="color color_3"></a></li>
	                                        <li><a href="#0" class="color color_4"></a></li>
	                                    @endif
	                                </ul>
	                            </div>
	                        </div>
                        <div class="row">
                            <label class="col-xl-5 col-lg-5 col-md-6 col-6"><strong>Size</strong> - Size Guide <a href="#0" data-bs-toggle="modal" data-bs-target="#size-modal"><i class="ti-help-alt"></i></a></label>
                            <div class="col-xl-4 col-lg-5 col-md-6 col-6">
                                <div class="size-selection-container">
                                    @php
                                        $sizeAttribute = \App\Models\Attribute::where('slug', 'size')->first();
                                        $productSizes = $product->productAttributes()
                                            ->whereHas('attributeValue.attribute', function($q) {
                                                $q->where('slug', 'size');
                                            })
                                            ->with('attributeValue')
                                            ->get();
                                    @endphp

                                    @if($productSizes->count() > 0)
                                        <div class="size-buttons-container">
                                            @foreach($productSizes as $index => $productSize)
                                                @php
                                                    $sizeValue = $productSize->attributeValue->value;
                                                    $isFirst = $index === 0;
                                                @endphp
                                                <button type="button"
                                                        class="size-button {{ $isFirst ? 'active' : '' }}"
                                                        data-size="{{ $sizeValue }}"
                                                        data-product-id="{{ $product->id }}"
                                                        title="{{ $sizeValue }}">
                                                    {{ $sizeValue }}
                                                </button>
                                            @endforeach
                                        </div>
                                    @else
                                        <!-- Fallback sizes if no database sizes -->
                                        <div class="size-buttons-container">
                                            <button type="button" class="size-button active" data-size="S">S</button>
                                            <button type="button" class="size-button" data-size="M">M</button>
                                            <button type="button" class="size-button" data-size="L">L</button>
                                            <button type="button" class="size-button" data-size="XL">XL</button>
                                        </div>
                                    @endif
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
<form action="{{ route('cart.add') }}" method="POST" class="add-to-cart-form">
    @csrf
    <input type="hidden" name="product_id" value="{{ $product->id }}">
    <input type="hidden" name="qty" value="1">
    <button type="submit" class="btn_1">Add to Cart</button>
</form>

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
                        <li>
                            <a href="{{ route('frontend.leave-review', ['product' => $product->id]) }}"><i class="ti-star"></i><span>Write Review</span></a>
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
	                                    @if($product->description)
	                                        <div style="line-height: 1.8; color: #4a5568;">
	                                            {!! nl2br(e($product->description)) !!}
	                                        </div>
	                                    @else
	                                        <p class="text-muted">No product description available.</p>
	                                    @endif
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
	                            <p class="text-end"><a href="{{ route('frontend.leave-review', ['product' => $product->id]) }}" class="btn_1">Leave a review</a></p>
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
@endsection


