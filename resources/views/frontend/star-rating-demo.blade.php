@extends('frontend.layouts.app')

@section('content')
<div class="container margin_60_35">
    <div class="row justify-content-center">
        <div class="col-lg-8">
            <h1>Star Rating System Demo</h1>
            <p>This page demonstrates the activated star rating system with dynamic data.</p>
            
            <!-- Static Star Ratings -->
            <div class="card mb-4">
                <div class="card-header">
                    <h3>Static Star Ratings (Display Only)</h3>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <h5>5 Star Rating</h5>
                            <span class="rating" data-rating="5" data-review-count="25">
                                <i class="icon-star"></i>
                                <i class="icon-star"></i>
                                <i class="icon-star"></i>
                                <i class="icon-star"></i>
                                <i class="icon-star"></i>
                                <em>0 reviews</em>
                            </span>
                        </div>
                        
                        <div class="col-md-6 mb-3">
                            <h5>4 Star Rating</h5>
                            <span class="rating" data-rating="4" data-review-count="12">
                                <i class="icon-star"></i>
                                <i class="icon-star"></i>
                                <i class="icon-star"></i>
                                <i class="icon-star"></i>
                                <i class="icon-star"></i>
                                <em>0 reviews</em>
                            </span>
                        </div>
                        
                        <div class="col-md-6 mb-3">
                            <h5>3 Star Rating</h5>
                            <span class="rating" data-rating="3" data-review-count="8">
                                <i class="icon-star"></i>
                                <i class="icon-star"></i>
                                <i class="icon-star"></i>
                                <i class="icon-star"></i>
                                <i class="icon-star"></i>
                                <em>0 reviews</em>
                            </span>
                        </div>
                        
                        <div class="col-md-6 mb-3">
                            <h5>2.5 Star Rating</h5>
                            <span class="rating" data-rating="2.5" data-review-count="3">
                                <i class="icon-star"></i>
                                <i class="icon-star"></i>
                                <i class="icon-star"></i>
                                <i class="icon-star"></i>
                                <i class="icon-star"></i>
                                <em>0 reviews</em>
                            </span>
                        </div>
                    </div>
                </div>
            </div>
            
            <!-- Interactive Star Ratings -->
            <div class="card mb-4">
                <div class="card-header">
                    <h3>Interactive Star Ratings</h3>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <h5>Rate this product:</h5>
                            <span class="rating rating-interactive" data-rating="0" data-review-count="0">
                                <i class="icon-star"></i>
                                <i class="icon-star"></i>
                                <i class="icon-star"></i>
                                <i class="icon-star"></i>
                                <i class="icon-star"></i>
                                <em>0 reviews</em>
                            </span>
                        </div>
                        
                        <div class="col-md-6 mb-3">
                            <h5>Rate this service:</h5>
                            <span class="rating rating-interactive" data-rating="0" data-review-count="0">
                                <i class="icon-star"></i>
                                <i class="icon-star"></i>
                                <i class="icon-star"></i>
                                <i class="icon-star"></i>
                                <i class="icon-star"></i>
                                <em>0 reviews</em>
                            </span>
                        </div>
                    </div>
                </div>
            </div>
            
            <!-- Product Reviews with Dynamic Data -->
            <div class="card mb-4">
                <div class="card-header">
                    <h3>Product Reviews (Dynamic Data)</h3>
                </div>
                <div class="card-body">
                    @php
                        $reviews = App\Models\Review::where('is_approved', true)
                            ->with(['product', 'user'])
                            ->orderBy('created_at', 'desc')
                            ->limit(5)
                            ->get();
                    @endphp
                    
                    @if($reviews->count() > 0)
                        @foreach($reviews as $review)
                            <div class="review-item mb-3 p-3 border rounded">
                                <div class="d-flex justify-content-between align-items-start mb-2">
                                    <div>
                                        <h6 class="mb-1">{{ $review->product->name ?? 'Product' }}</h6>
                                        <span class="rating" data-rating="{{ $review->rating }}" data-review-count="1">
                                            <i class="icon-star"></i>
                                            <i class="icon-star"></i>
                                            <i class="icon-star"></i>
                                            <i class="icon-star"></i>
                                            <i class="icon-star"></i>
                                            <em>0 reviews</em>
                                        </span>
                                    </div>
                                    <small class="text-muted">{{ $review->created_at->format('M d, Y') }}</small>
                                </div>
                                
                                @if($review->title)
                                    <h6 class="mb-2">"{{ $review->title }}"</h6>
                                @endif
                                
                                @if($review->comment)
                                    <p class="mb-2">{{ $review->comment }}</p>
                                @endif
                                
                                @if($review->pros)
                                    <div class="mb-1">
                                        <strong>Pros:</strong> {{ $review->pros }}
                                    </div>
                                @endif
                                
                                @if($review->cons)
                                    <div class="mb-1">
                                        <strong>Cons:</strong> {{ $review->cons }}
                                    </div>
                                @endif
                                
                                <div class="review-meta">
                                    <small class="text-muted">
                                        By {{ $review->user->name ?? 'Anonymous' }}
                                        @if($review->purchase_verified)
                                            <span class="badge bg-success ms-2">✓ Verified Purchase</span>
                                        @endif
                                        @if($review->would_recommend)
                                            <span class="badge bg-primary ms-2">✓ Recommends</span>
                                        @endif
                                    </small>
                                </div>
                            </div>
                        @endforeach
                    @else
                        <p class="text-muted">No reviews available yet.</p>
                    @endif
                </div>
            </div>
            
            <!-- Rating Form -->
            <div class="card">
                <div class="card-header">
                    <h3>Submit a Review</h3>
                </div>
                <div class="card-body">
                    <form id="review-form">
                        <div class="mb-3">
                            <label class="form-label">Your Rating:</label>
                            <span class="rating rating-interactive" data-rating="0" data-review-count="0">
                                <i class="icon-star"></i>
                                <i class="icon-star"></i>
                                <i class="icon-star"></i>
                                <i class="icon-star"></i>
                                <i class="icon-star"></i>
                                <em>0 reviews</em>
                            </span>
                        </div>
                        
                        <div class="mb-3">
                            <label for="review-title" class="form-label">Review Title:</label>
                            <input type="text" class="form-control" id="review-title" placeholder="Enter a title for your review">
                        </div>
                        
                        <div class="mb-3">
                            <label for="review-comment" class="form-label">Your Review:</label>
                            <textarea class="form-control" id="review-comment" rows="4" placeholder="Write your review here..."></textarea>
                        </div>
                        
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="pros" class="form-label">Pros:</label>
                                <textarea class="form-control" id="pros" rows="2" placeholder="What did you like?"></textarea>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="cons" class="form-label">Cons:</label>
                                <textarea class="form-control" id="cons" rows="2" placeholder="What could be improved?"></textarea>
                            </div>
                        </div>
                        
                        <div class="mb-3">
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" id="would-recommend">
                                <label class="form-check-label" for="would-recommend">
                                    I would recommend this product
                                </label>
                            </div>
                        </div>
                        
                        <button type="submit" class="btn btn-primary">Submit Review</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script src="{{ asset('js/star-rating.js') }}"></script>
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Handle form submission
    document.getElementById('review-form').addEventListener('submit', function(e) {
        e.preventDefault();
        
        const rating = document.querySelector('.rating-interactive input[type="radio"]:checked');
        const title = document.getElementById('review-title').value;
        const comment = document.getElementById('review-comment').value;
        const pros = document.getElementById('pros').value;
        const cons = document.getElementById('cons').value;
        const wouldRecommend = document.getElementById('would-recommend').checked;
        
        if (!rating) {
            alert('Please select a rating');
            return;
        }
        
        // Here you would typically send the data to your server
        console.log('Review submitted:', {
            rating: rating.value,
            title: title,
            comment: comment,
            pros: pros,
            cons: cons,
            wouldRecommend: wouldRecommend
        });
        
        alert('Review submitted successfully! (This is a demo)');
    });
});
</script>
@endpush

@push('styles')
<style>
.review-item {
    background: #f8f9fa;
    border: 1px solid #dee2e6;
}

.badge {
    font-size: 0.75em;
}

.rating {
    margin-bottom: 0;
}

.icon-star {
    font-style: normal;
    color: #ddd;
    transition: all 0.2s ease;
}

.icon-star.voted {
    color: #ffc107;
}

.rating-interactive .rating-star {
    cursor: pointer;
    transition: all 0.2s ease;
}

.rating-interactive .rating-star:hover {
    color: #ffc107;
    transform: scale(1.1);
}
</style>
@endpush
@endsection
