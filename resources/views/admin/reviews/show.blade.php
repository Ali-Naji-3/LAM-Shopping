@extends('admin.dashboard')

@section('content')
<div class="container-fluid">
    <!-- Page Header -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h2 class="mb-1" style="color: #1a202c !important; font-weight: 700 !important; font-size: 24px !important;">
                👁️ Review Details
            </h2>
            <p class="mb-0" style="color: #4a5568 !important; font-size: 14px !important;">
                Review #{{ $review->id }} • {{ $review->created_at->format('F d, Y') }}
            </p>
        </div>
        <div class="d-flex gap-2">
            <a href="{{ route('admin.reviews.edit', $review) }}" class="btn btn-outline-primary"
               style="color: #3182ce !important; border-color: #3182ce !important; background: #ffffff !important; padding: 12px 20px !important; border-radius: 10px !important; font-weight: 600 !important; font-size: 14px !important; border-width: 2px !important; transition: all 0.2s ease !important; text-decoration: none !important;"
               onmouseover="this.style.backgroundColor='#3182ce !important'; this.style.color='#ffffff !important';"
               onmouseout="this.style.backgroundColor='#ffffff !important'; this.style.color='#3182ce !important';">
                <i class="bi bi-pencil me-2"></i>Edit Review
            </a>
            <a href="{{ route('admin.reviews.index') }}" class="btn btn-outline-secondary"
               style="color: #4a5568 !important; border-color: #4a5568 !important; background: #ffffff !important; padding: 12px 20px !important; border-radius: 10px !important; font-weight: 600 !important; font-size: 14px !important; border-width: 2px !important; transition: all 0.2s ease !important; text-decoration: none !important;"
               onmouseover="this.style.backgroundColor='#4a5568 !important'; this.style.color='#ffffff !important';"
               onmouseout="this.style.backgroundColor='#ffffff !important'; this.style.color='#4a5568 !important';">
                <i class="bi bi-arrow-left me-2"></i>Back to Reviews
            </a>
        </div>
    </div>

    <div class="row">
        <div class="col-lg-8">
            <!-- Review Content -->
            <div class="card mb-4" style="background: #ffffff !important; border: 1px solid #e2e8f0 !important; border-radius: 12px !important; box-shadow: 0 1px 3px rgba(0, 0, 0, 0.1) !important;">
                <div class="card-header" style="background: linear-gradient(135deg, #f7fafc 0%, #edf2f7 100%) !important; border-bottom: 1px solid #e2e8f0 !important; border-radius: 12px 12px 0 0 !important; padding: 1.5rem 2rem !important;">
                    <div class="d-flex justify-content-between align-items-center">
                        <h5 class="mb-0" style="color: #1a202c !important; font-weight: 600 !important; font-size: 18px !important;">
                            <i class="bi bi-chat-quote me-2" style="color: #3182ce !important;"></i>Review Content
                        </h5>
                        <div class="d-flex align-items-center gap-2">
                            <div class="rating-stars" style="color: {{ $review->rating_color }} !important; font-size: 20px !important;">
                                {{ $review->star_rating }}
                            </div>
                            <span class="badge" style="background: {{ $review->status_color }} !important; color: #ffffff !important; font-size: 12px !important; padding: 6px 12px !important; border-radius: 20px !important;">
                                {{ $review->status_badge }}
                            </span>
                        </div>
                    </div>
                </div>
                <div class="card-body" style="padding: 2rem !important;">
                    @if($review->title)
                        <div class="mb-3">
                            <h4 style="color: #1a202c !important; font-weight: 600 !important; font-size: 20px !important; line-height: 1.4 !important;">
                                "{{ $review->title }}"
                            </h4>
                        </div>
                    @endif

                    @if($review->comment)
                        <div class="review-comment" style="color: #2d3748 !important; font-size: 16px !important; line-height: 1.8 !important; padding: 1.5rem !important; background: linear-gradient(135deg, #f8fafc 0%, #f1f5f9 100%) !important; border-radius: 10px !important; border-left: 4px solid #3182ce !important;">
                            {{ $review->comment }}
                        </div>
                    @else
                        <div style="color: #718096 !important; font-style: italic !important; padding: 1.5rem !important; text-align: center !important; background: linear-gradient(135deg, #f8fafc 0%, #f1f5f9 100%) !important; border-radius: 10px !important;">
                            No comment provided with this review.
                        </div>
                    @endif
                </div>
            </div>

            <!-- Product Information -->
            <div class="card mb-4" style="background: #ffffff !important; border: 1px solid #e2e8f0 !important; border-radius: 12px !important; box-shadow: 0 1px 3px rgba(0, 0, 0, 0.1) !important;">
                <div class="card-header" style="background: linear-gradient(135deg, #f7fafc 0%, #edf2f7 100%) !important; border-bottom: 1px solid #e2e8f0 !important; border-radius: 12px 12px 0 0 !important; padding: 1.5rem 2rem !important;">
                    <h5 class="mb-0" style="color: #1a202c !important; font-weight: 600 !important; font-size: 18px !important;">
                        <i class="bi bi-box me-2" style="color: #3182ce !important;"></i>Product Information
                    </h5>
                </div>
                <div class="card-body" style="padding: 2rem !important;">
                    <div class="row align-items-center">
                        <div class="col-md-8">
                            <h6 style="color: #1a202c !important; font-weight: 600 !important; font-size: 18px !important; margin-bottom: 8px !important;">
                                {{ $review->product->name }}
                            </h6>
                            <div class="product-meta" style="color: #4a5568 !important; font-size: 14px !important; line-height: 1.6 !important;">
                                <div><strong>SKU:</strong> {{ $review->product->sku }}</div>
                                @if($review->product->category)
                                    <div><strong>Category:</strong> {{ $review->product->category->name }}</div>
                                @endif
                                @if($review->product->brand)
                                    <div><strong>Brand:</strong> {{ $review->product->brand->name }}</div>
                                @endif
                                <div><strong>Price:</strong> ${{ number_format($review->product->regular_price, 2) }}</div>
                            </div>
                        </div>
                        <div class="col-md-4 text-end">
                            <a href="{{ route('admin.products.show', $review->product) }}" class="btn btn-outline-info"
                               style="color: #0891b2 !important; border-color: #0891b2 !important; background: #ffffff !important; padding: 10px 16px !important; border-radius: 8px !important; font-weight: 600 !important; font-size: 13px !important; text-decoration: none !important;"
                               onmouseover="this.style.backgroundColor='#0891b2 !important'; this.style.color='#ffffff !important';"
                               onmouseout="this.style.backgroundColor='#ffffff !important'; this.style.color='#0891b2 !important';">
                                <i class="bi bi-eye me-1"></i>View Product
                            </a>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Reviewer Information -->
            <div class="card" style="background: #ffffff !important; border: 1px solid #e2e8f0 !important; border-radius: 12px !important; box-shadow: 0 1px 3px rgba(0, 0, 0, 0.1) !important;">
                <div class="card-header" style="background: linear-gradient(135deg, #f7fafc 0%, #edf2f7 100%) !important; border-bottom: 1px solid #e2e8f0 !important; border-radius: 12px 12px 0 0 !important; padding: 1.5rem 2rem !important;">
                    <h5 class="mb-0" style="color: #1a202c !important; font-weight: 600 !important; font-size: 18px !important;">
                        <i class="bi bi-person me-2" style="color: #3182ce !important;"></i>Reviewer Information
                    </h5>
                </div>
                <div class="card-body" style="padding: 2rem !important;">
                    <div class="row align-items-center">
                        <div class="col-md-8">
                            <h6 style="color: #1a202c !important; font-weight: 600 !important; font-size: 18px !important; margin-bottom: 8px !important;">
                                {{ $review->user->name }}
                            </h6>
                            <div class="user-meta" style="color: #4a5568 !important; font-size: 14px !important; line-height: 1.6 !important;">
                                <div><strong>Email:</strong> {{ $review->user->email }}</div>
                                <div><strong>Member Since:</strong> {{ $review->user->created_at->format('F Y') }}</div>
                                <div><strong>Total Reviews:</strong> {{ $review->user->reviews()->count() }}</div>
                            </div>
                        </div>
                        <div class="col-md-4 text-end">
                            <a href="{{ route('admin.reviews.user', $review->user) }}" class="btn btn-outline-success"
                               style="color: #10b981 !important; border-color: #10b981 !important; background: #ffffff !important; padding: 10px 16px !important; border-radius: 8px !important; font-weight: 600 !important; font-size: 13px !important; text-decoration: none !important;"
                               onmouseover="this.style.backgroundColor='#10b981 !important'; this.style.color='#ffffff !important';"
                               onmouseout="this.style.backgroundColor='#ffffff !important'; this.style.color='#10b981 !important';">
                                <i class="bi bi-person-lines-fill me-1"></i>User Reviews
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-lg-4">
            <!-- Quick Actions -->
            <div class="card mb-4" style="background: #ffffff !important; border: 1px solid #e2e8f0 !important; border-radius: 12px !important; box-shadow: 0 1px 3px rgba(0, 0, 0, 0.1) !important;">
                <div class="card-header" style="background: linear-gradient(135deg, #f7fafc 0%, #edf2f7 100%) !important; border-bottom: 1px solid #e2e8f0 !important; border-radius: 12px 12px 0 0 !important; padding: 1rem 1.5rem !important;">
                    <h5 class="mb-0" style="color: #1a202c !important; font-weight: 600 !important; font-size: 16px !important;">
                        <i class="bi bi-lightning me-2" style="color: #3182ce !important;"></i>Quick Actions
                    </h5>
                </div>
                <div class="card-body" style="padding: 1.5rem !important;">
                    <div class="d-grid gap-2">
                        @if(!$review->is_approved)
                            <form method="POST" action="{{ route('admin.reviews.toggleApproval', $review) }}">
                                @csrf
                                @method('PATCH')
                                <button type="submit" class="btn btn-success w-100"
                                        style="background: linear-gradient(135deg, #10b981 0%, #059669 100%) !important; border: none !important; color: #ffffff !important; padding: 12px 16px !important; border-radius: 8px !important; font-weight: 600 !important; transition: all 0.2s ease !important;"
                                        onmouseover="this.style.transform='translateY(-1px)'; this.style.boxShadow='0 4px 8px rgba(16, 185, 129, 0.3) !important';"
                                        onmouseout="this.style.transform='translateY(0)'; this.style.boxShadow='none';">
                                    <i class="bi bi-check-circle me-2"></i>Approve Review
                                </button>
                            </form>
                        @else
                            <form method="POST" action="{{ route('admin.reviews.toggleApproval', $review) }}">
                                @csrf
                                @method('PATCH')
                                <button type="submit" class="btn btn-warning w-100"
                                        style="background: linear-gradient(135deg, #f59e0b 0%, #d97706 100%) !important; border: none !important; color: #ffffff !important; padding: 12px 16px !important; border-radius: 8px !important; font-weight: 600 !important; transition: all 0.2s ease !important;"
                                        onmouseover="this.style.transform='translateY(-1px)'; this.style.boxShadow='0 4px 8px rgba(245, 158, 11, 0.3) !important';"
                                        onmouseout="this.style.transform='translateY(0)'; this.style.boxShadow='none';">
                                    <i class="bi bi-x-circle me-2"></i>Reject Review
                                </button>
                            </form>
                        @endif

                        <a href="{{ route('admin.reviews.edit', $review) }}" class="btn btn-outline-primary w-100"
                           style="color: #3182ce !important; border-color: #3182ce !important; background: #ffffff !important; padding: 12px 16px !important; border-radius: 8px !important; font-weight: 600 !important; text-decoration: none !important;"
                           onmouseover="this.style.backgroundColor='#3182ce !important'; this.style.color='#ffffff !important';"
                           onmouseout="this.style.backgroundColor='#ffffff !important'; this.style.color='#3182ce !important';">
                            <i class="bi bi-pencil me-2"></i>Edit Review
                        </a>

                        <form method="POST" action="{{ route('admin.reviews.destroy', $review) }}" onsubmit="return confirm('Are you sure you want to delete this review?')">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-outline-danger w-100"
                                    style="color: #e53e3e !important; border-color: #e53e3e !important; background: #ffffff !important; padding: 12px 16px !important; border-radius: 8px !important; font-weight: 600 !important; transition: all 0.2s ease !important;"
                                    onmouseover="this.style.backgroundColor='#e53e3e !important'; this.style.color='#ffffff !important';"
                                    onmouseout="this.style.backgroundColor='#ffffff !important'; this.style.color='#e53e3e !important';">
                                <i class="bi bi-trash me-2"></i>Delete Review
                            </button>
                        </form>
                    </div>
                </div>
            </div>

            <!-- Review Statistics -->
            <div class="card mb-4" style="background: #ffffff !important; border: 1px solid #e2e8f0 !important; border-radius: 12px !important; box-shadow: 0 1px 3px rgba(0, 0, 0, 0.1) !important;">
                <div class="card-header" style="background: linear-gradient(135deg, #f7fafc 0%, #edf2f7 100%) !important; border-bottom: 1px solid #e2e8f0 !important; border-radius: 12px 12px 0 0 !important; padding: 1rem 1.5rem !important;">
                    <h5 class="mb-0" style="color: #1a202c !important; font-weight: 600 !important; font-size: 16px !important;">
                        <i class="bi bi-graph-up me-2" style="color: #3182ce !important;"></i>Review Details
                    </h5>
                </div>
                <div class="card-body" style="padding: 1.5rem !important;">
                    <div class="review-stats">
                        <div class="stat-item" style="padding: 12px !important; background: linear-gradient(135deg, #f0f9ff 0%, #e0f2fe 100%) !important; border-radius: 8px !important; margin-bottom: 12px !important;">
                            <div class="d-flex justify-content-between align-items-center">
                                <span style="color: #2d3748 !important; font-weight: 600 !important; font-size: 14px !important;">Review ID</span>
                                <span style="color: #3182ce !important; font-weight: 700 !important; font-size: 14px !important;">#{{ $review->id }}</span>
                            </div>
                        </div>
                        <div class="stat-item" style="padding: 12px !important; background: linear-gradient(135deg, #f0fdf4 0%, #dcfce7 100%) !important; border-radius: 8px !important; margin-bottom: 12px !important;">
                            <div class="d-flex justify-content-between align-items-center">
                                <span style="color: #2d3748 !important; font-weight: 600 !important; font-size: 14px !important;">Rating</span>
                                <span style="color: {{ $review->rating_color }} !important; font-weight: 700 !important; font-size: 14px !important;">{{ $review->rating }}/5</span>
                            </div>
                        </div>
                        <div class="stat-item" style="padding: 12px !important; background: linear-gradient(135deg, #fef3c7 0%, #fed7aa 100%) !important; border-radius: 8px !important; margin-bottom: 12px !important;">
                            <div class="d-flex justify-content-between align-items-center">
                                <span style="color: #2d3748 !important; font-weight: 600 !important; font-size: 14px !important;">Status</span>
                                <span style="color: {{ $review->status_color }} !important; font-weight: 700 !important; font-size: 14px !important;">{{ $review->status_badge }}</span>
                            </div>
                        </div>
                        <div class="stat-item" style="padding: 12px !important; background: linear-gradient(135deg, #f3e8ff 0%, #e9d5ff 100%) !important; border-radius: 8px !important;">
                            <div class="d-flex justify-content-between align-items-center">
                                <span style="color: #2d3748 !important; font-weight: 600 !important; font-size: 14px !important;">Created</span>
                                <span style="color: #8b5cf6 !important; font-weight: 700 !important; font-size: 14px !important;">{{ $review->created_at->format('M d, Y') }}</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            @if($relatedReviews->count() > 0)
                <!-- Related Reviews -->
                <div class="card" style="background: #ffffff !important; border: 1px solid #e2e8f0 !important; border-radius: 12px !important; box-shadow: 0 1px 3px rgba(0, 0, 0, 0.1) !important;">
                    <div class="card-header" style="background: linear-gradient(135deg, #f7fafc 0%, #edf2f7 100%) !important; border-bottom: 1px solid #e2e8f0 !important; border-radius: 12px 12px 0 0 !important; padding: 1rem 1.5rem !important;">
                        <h5 class="mb-0" style="color: #1a202c !important; font-weight: 600 !important; font-size: 16px !important;">
                            <i class="bi bi-collection me-2" style="color: #3182ce !important;"></i>Other Reviews for This Product
                        </h5>
                    </div>
                    <div class="card-body" style="padding: 1.5rem !important;">
                        @foreach($relatedReviews as $relatedReview)
                            <div class="related-review" style="padding: 12px !important; background: linear-gradient(135deg, #f8fafc 0%, #f1f5f9 100%) !important; border-radius: 8px !important; margin-bottom: 12px !important;">
                                <div class="d-flex justify-content-between align-items-start mb-2">
                                    <div class="rating-stars" style="color: {{ $relatedReview->rating_color }} !important; font-size: 14px !important;">
                                        {{ $relatedReview->star_rating }}
                                    </div>
                                    <small style="color: #718096 !important; font-size: 11px !important;">{{ $relatedReview->created_at->format('M d, Y') }}</small>
                                </div>
                                @if($relatedReview->title)
                                    <h6 style="color: #1a202c !important; font-weight: 600 !important; font-size: 13px !important; margin-bottom: 4px !important;">{{ Str::limit($relatedReview->title, 40) }}</h6>
                                @endif
                                <small style="color: #4a5568 !important; font-size: 12px !important;">by {{ $relatedReview->user->name }}</small>
                            </div>
                        @endforeach
                        <a href="{{ route('admin.reviews.product', $review->product) }}" class="btn btn-outline-info btn-sm w-100 mt-2"
                           style="color: #0891b2 !important; border-color: #0891b2 !important; background: #ffffff !important; padding: 8px 12px !important; border-radius: 6px !important; font-size: 12px !important; text-decoration: none !important;"
                           onmouseover="this.style.backgroundColor='#0891b2 !important'; this.style.color='#ffffff !important';"
                           onmouseout="this.style.backgroundColor='#ffffff !important'; this.style.color='#0891b2 !important';">
                            View All Product Reviews
                        </a>
                    </div>
                </div>
            @endif
        </div>
    </div>
</div>

@push('styles')
<style>
    /* CLEAN REVIEWS SHOW PAGE - Professional Styling */
    .review-comment {
        transition: all 0.2s ease !important;
    }

    .review-comment:hover {
        transform: translateY(-1px) !important;
        box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1) !important;
    }

    .stat-item {
        transition: all 0.2s ease !important;
    }

    .stat-item:hover {
        transform: translateY(-1px) !important;
        box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1) !important;
    }

    .related-review {
        transition: all 0.2s ease !important;
    }

    .related-review:hover {
        transform: translateY(-1px) !important;
        box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1) !important;
    }

    .rating-stars {
        text-shadow: 0 1px 2px rgba(0, 0, 0, 0.1) !important;
    }
</style>
@endpush
@endsection
