@extends('frontend.layouts.layout')
@section('content')
    <main>


        <div class="container margin_60_35">

            <div class="row justify-content-center">
                <div class="col-lg-8">
                    <div class="write_review">
                        @if ($product)
                            <h1>Write a review for {{ $product->name }}</h1>
                        @else
                            <h1>Write a review</h1>
                        @endif

                        @if (session('success'))
                            <div class="alert alert-success alert-dismissible fade show" role="alert">
                                {{ session('success') }}
                                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                            </div>
                        @endif

                        @if (session('error'))
                            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                                {{ session('error') }}
                                <button type="button" class="btn-close" data-bs-dismiss="alert"
                                    aria-label="Close"></button>
                            </div>
                        @endif

                        <form action="{{ route('frontend.review.store') }}" method="POST" id="reviewForm">
                            @csrf

                            @if ($product)
                                <input type="hidden" name="product_id" value="{{ $product->id }}">
                            @else
                                <div class="form-group">
                                    <label for="product_id">Select Product <span class="text-danger">*</span></label>
                                    <select name="product_id" id="product_id" class="form-control" required>
                                        <option value="">Choose a product...</option>
                                        @foreach ($products as $prod)
                                            <option value="{{ $prod->id }}">{{ $prod->name }} -
                                                {{ $prod->brand->name ?? 'No Brand' }}</option>
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
                                        <input type="radio" class="rating-input" id="5_star" name="rating"
                                            value="5" required>
                                        <label for="5_star" class="rating-star"></label>
                                        <input type="radio" class="rating-input" id="4_star" name="rating"
                                            value="4" required>
                                        <label for="4_star" class="rating-star"></label>
                                        <input type="radio" class="rating-input" id="3_star" name="rating"
                                            value="3" required>
                                        <label for="3_star" class="rating-star"></label>
                                        <input type="radio" class="rating-input" id="2_star" name="rating"
                                            value="2" required>
                                        <label for="2_star" class="rating-star"></label>
                                        <input type="radio" class="rating-input" id="1_star" name="rating"
                                            value="1" required>
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
                                    <input class="form-control" type="text" name="name" id="name"
                                        placeholder="Enter your full name" value="{{ old('name') }}" required>
                                    @error('name')
                                        <div class="text-danger small">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="form-group">
                                    <label for="email">Your Email <span class="text-danger">*</span></label>
                                    <input class="form-control" type="email" name="email" id="email"
                                        placeholder="Enter your email address" value="{{ old('email') }}" required>
                                    @error('email')
                                        <div class="text-danger small">{{ $message }}</div>
                                    @enderror
                                </div>
                            @endguest

                            <div class="form-group">
                                <label for="title">Title of your review</label>
                                <input class="form-control" type="text" name="title" id="title"
                                    placeholder="If you could say it in one sentence, what would you say?"
                                    value="{{ old('title') }}">
                                @error('title')
                                    <div class="text-danger small">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="form-group">
                                <label for="comment">Your review <span class="text-danger">*</span></label>
                                <textarea class="form-control" name="comment" id="comment" style="height: 180px;"
                                    placeholder="Write your review to help others learn about this product" required>{{ old('comment') }}</textarea>
                                @error('comment')
                                    <div class="text-danger small">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="form-group">
                                <div class="checkboxes float-left add_bottom_15 add_top_15">
                                    <label class="container_check">I agree to the <a href="#" target="_blank">Terms
                                            and Conditions</a> and <a href="#" target="_blank">Privacy Policy</a>
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
@endsection

