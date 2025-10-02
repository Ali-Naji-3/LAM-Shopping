@extends('frontend.layouts.layout')
@section('content')
<main>
    <div class="container margin_30">
        <div class="row">
            <div class="col-md-6">
                <div class="all">
                    <div class="slider">
                        <div class="owl-carousel owl-theme main">
                            @if($product->image)
                                <div style="background-image: url({{ asset('storage/' . $product->image) }}); height: 400px; background-size: cover; background-position: center;"></div>
                            @else
                                <div style="background: #f0f0f0; height: 400px; display: flex; align-items: center; justify-content: center;">
                                    <span>No Image Available</span>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-6">
                <div class="breadcrumbs">
                    <ul>
                        <li><a href="/">Home</a></li>
                        @if($product->category)
                            @php
                                $categoryName = $product->category->name;
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
                                        $categoryUrl = url('/listing-grid-3');
                                }
                            @endphp
                            <li><a href="{{ $categoryUrl }}">{{ $categoryName }}</a></li>
                        @else
                            <li><a href="#">Category</a></li>
                        @endif
                        <li>{{ $product->name }}</li>
                    </ul>
                </div>
                <div class="prod_info">
                    <h1>{{ $product->name }}</h1>
                    <div class="star-rating">
                        <span class="stars">★★★★★</span>
                        <span class="rating-text">(5.0)</span>
                    </div>
                    <p><small>SKU: {{ $product->sku ?? 'N/A' }}</small><br>{{ $product->short_description ?? $product->description ?? 'No description available' }}</p>
                    
                    <div class="prod_options">
                        <div class="row">
                            <label class="col-xl-5 col-lg-5 col-md-6 col-6"><strong>Price:</strong></label>
                            <div class="col-xl-4 col-lg-5 col-md-6 col-6">
                                <span class="price">
                                    @if($product->sale_price && $product->sale_price < $product->regular_price)
                                        <span class="old_price">${{ number_format($product->regular_price, 2) }}</span>
                                        <span class="new_price">${{ number_format($product->sale_price, 2) }}</span>
                                    @else
                                        <span class="new_price">${{ number_format($product->regular_price ?? 0, 2) }}</span>
                                    @endif
                                </span>
                            </div>
                        </div>
                    </div>
                    
                    <div class="row">
                        <div class="col-lg-5 col-md-6">
                            <div class="btn_add_to_cart">
                                <a href="#0" class="btn_1">Add to Cart</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
        <!-- Product Description -->
        <div class="row mt-5">
            <div class="col-12">
                <div class="tabs">
                    <ul class="nav nav-tabs" role="tablist">
                        <li class="nav-item">
                            <a class="nav-link active" id="tab_1" data-toggle="tab" href="#tab_1_content" role="tab">Description</a>
                        </li>
                    </ul>
                    <div class="tab-content">
                        <div class="tab-pane fade show active" id="tab_1_content" role="tabpanel">
                            <p>{{ $product->description ?? 'No description available' }}</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</main>
@endsection
