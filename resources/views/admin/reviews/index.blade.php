@extends('admin.dashboard')

@section('content')

<script>
// Global search functions for reviews
window.handleReviewSearchKeyup = function(input) {
    const searchTerm = input.value.trim();
    const minSearchLength = 2;
    
    // Force clean professional styling
    input.style.background = '#ffffff';
    input.style.color = '#1a202c';
    input.style.border = '2px solid #e2e8f0';
    
    if (searchTerm.length >= minSearchLength) {
        input.style.borderColor = '#3182ce';
        input.style.boxShadow = '0 0 0 4px rgba(49, 130, 206, 0.15)';
        input.style.transform = 'translateY(-1px)';
    } else {
        input.style.borderColor = '#e2e8f0';
        input.style.boxShadow = '0 1px 3px rgba(0, 0, 0, 0.1)';
        input.style.transform = 'translateY(0)';
    }
    
    clearTimeout(window.reviewSearchTimeout);
    if (searchTerm.length >= minSearchLength || searchTerm.length === 0) {
        window.reviewSearchTimeout = setTimeout(function() {
            if (searchTerm !== '{{ request('search') }}') {
                input.closest('form').submit();
            }
        }, 600);
    }
};

window.handleReviewSearchKeydown = function(event, input) {
    if (event.key === 'Enter') {
        event.preventDefault();
        input.closest('form').submit();
    }
    if (event.key === 'Escape') {
        input.value = '';
        input.style.borderColor = '#e2e8f0';
        input.style.boxShadow = '0 1px 3px rgba(0, 0, 0, 0.1)';
        input.blur();
    }
};

window.handleReviewSearchFocus = function(input) {
    input.style.borderColor = '#3182ce';
    input.style.boxShadow = '0 0 0 2px rgba(49, 130, 206, 0.2)';
};

window.handleReviewSearchBlur = function(input) {
    setTimeout(function() {
        if (input.value.trim().length === 0) {
            input.style.borderColor = '#e2e8f0';
            input.style.boxShadow = '0 1px 3px rgba(0, 0, 0, 0.1)';
        }
    }, 150);
};
</script>

<div class="container-fluid">
    <!-- Page Header -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h2 class="mb-1" style="color: #1a202c !important; font-weight: 700 !important; font-size: 24px !important;">
                ⭐ Reviews Management
            </h2>
            <p class="mb-0" style="color: #4a5568 !important; font-size: 14px !important;">
                Manage customer product reviews and ratings • {{ $reviews->total() }} total reviews
            </p>
        </div>
        <div class="d-flex gap-2">
            <a href="{{ route('admin.reviews.create') }}" class="btn btn-primary"
               style="background: linear-gradient(135deg, #3182ce 0%, #2c5aa0 100%) !important; border: none !important; color: #ffffff !important; padding: 12px 20px !important; border-radius: 10px !important; font-weight: 600 !important; transition: all 0.2s ease !important;"
               onmouseover="this.style.transform='translateY(-1px)'; this.style.boxShadow='0 4px 8px rgba(49, 130, 206, 0.3) !important';"
               onmouseout="this.style.transform='translateY(0)'; this.style.boxShadow='none';">
                <i class="bi bi-plus-circle me-2"></i>Add Review
            </a>
            <a href="{{ route('admin.reviews.analytics') }}" class="btn btn-outline-info" 
               style="color: #0891b2 !important; border-color: #0891b2 !important; background: #ffffff !important; padding: 12px 20px !important; border-radius: 10px !important; font-weight: 600 !important; font-size: 14px !important; border-width: 2px !important; transition: all 0.2s ease !important; text-decoration: none !important;"
               onmouseover="this.style.backgroundColor='#0891b2 !important'; this.style.color='#ffffff !important';"
               onmouseout="this.style.backgroundColor='#ffffff !important'; this.style.color='#0891b2 !important';">
                <i class="bi bi-bar-chart me-2"></i>Analytics
            </a>
        </div>
    </div>

    <!-- Statistics Cards -->
    <div class="row mb-4">
        <div class="col-lg-3 col-md-6 mb-3">
            <div class="card" style="background: linear-gradient(135deg, #3182ce 0%, #2c5aa0 100%) !important; border: none !important; border-radius: 12px !important; color: #ffffff !important;">
                <div class="card-body" style="padding: 1.5rem !important;">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h6 style="color: rgba(255, 255, 255, 0.8) !important; font-size: 12px !important; text-transform: uppercase !important; font-weight: 600 !important; margin-bottom: 8px !important;">Total Reviews</h6>
                            <h3 style="color: #ffffff !important; font-weight: 700 !important; margin: 0 !important;">{{ number_format($statistics['total_reviews']) }}</h3>
                        </div>
                        <i class="bi bi-chat-quote" style="font-size: 2.5rem !important; opacity: 0.3 !important;"></i>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-lg-3 col-md-6 mb-3">
            <div class="card" style="background: linear-gradient(135deg, #10b981 0%, #059669 100%) !important; border: none !important; border-radius: 12px !important; color: #ffffff !important;">
                <div class="card-body" style="padding: 1.5rem !important;">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h6 style="color: rgba(255, 255, 255, 0.8) !important; font-size: 12px !important; text-transform: uppercase !important; font-weight: 600 !important; margin-bottom: 8px !important;">Approved Reviews</h6>
                            <h3 style="color: #ffffff !important; font-weight: 700 !important; margin: 0 !important;">{{ number_format($statistics['approved_reviews']) }}</h3>
                        </div>
                        <i class="bi bi-check-circle" style="font-size: 2.5rem !important; opacity: 0.3 !important;"></i>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-lg-3 col-md-6 mb-3">
            <div class="card" style="background: linear-gradient(135deg, #f59e0b 0%, #d97706 100%) !important; border: none !important; border-radius: 12px !important; color: #ffffff !important;">
                <div class="card-body" style="padding: 1.5rem !important;">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h6 style="color: rgba(255, 255, 255, 0.8) !important; font-size: 12px !important; text-transform: uppercase !important; font-weight: 600 !important; margin-bottom: 8px !important;">Pending Reviews</h6>
                            <h3 style="color: #ffffff !important; font-weight: 700 !important; margin: 0 !important;">{{ number_format($statistics['pending_reviews']) }}</h3>
                        </div>
                        <i class="bi bi-clock" style="font-size: 2.5rem !important; opacity: 0.3 !important;"></i>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-lg-3 col-md-6 mb-3">
            <div class="card" style="background: linear-gradient(135deg, #8b5cf6 0%, #7c3aed 100%) !important; border: none !important; border-radius: 12px !important; color: #ffffff !important;">
                <div class="card-body" style="padding: 1.5rem !important;">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h6 style="color: rgba(255, 255, 255, 0.8) !important; font-size: 12px !important; text-transform: uppercase !important; font-weight: 600 !important; margin-bottom: 8px !important;">Average Rating</h6>
                            <h3 style="color: #ffffff !important; font-weight: 700 !important; margin: 0 !important;">{{ number_format($statistics['average_rating'], 1) }}/5</h3>
                        </div>
                        <i class="bi bi-star-fill" style="font-size: 2.5rem !important; opacity: 0.3 !important;"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Search and Filter Card -->
    <div class="card mb-4" style="background: #ffffff !important; border: 1px solid #e2e8f0 !important; border-radius: 12px !important; box-shadow: 0 1px 3px rgba(0, 0, 0, 0.1) !important;">
        <div class="card-body" style="padding: 1.5rem 2rem !important;">
            <form method="GET" action="{{ route('admin.reviews.index') }}">
                <div class="row align-items-end">
                    <div class="col-md-3">
                        <label class="form-label" style="color: #2d3748 !important; font-weight: 600 !important; font-size: 14px !important; margin-bottom: 10px !important;">Search Reviews</label>
                        <div class="search-input-container" style="position: relative;">
                            <input type="text" 
                                   name="search" 
                                   id="search-reviews"
                                   class="form-control" 
                                   placeholder="🔍 Search reviews, products, users..." 
                                   value="{{ request('search') }}"
                                   style="background: #ffffff !important; border: 2px solid #e2e8f0 !important; color: #1a202c !important; padding: 14px 18px 14px 45px !important; border-radius: 10px !important; font-size: 15px !important; font-weight: 500 !important; box-shadow: 0 1px 3px rgba(0, 0, 0, 0.1) !important; transition: all 0.2s ease !important;"
                                   onkeyup="handleReviewSearchKeyup(this)"
                                   onkeydown="handleReviewSearchKeydown(event, this)"
                                   onfocus="handleReviewSearchFocus(this)"
                                   onblur="handleReviewSearchBlur(this)"
                                   autocomplete="off">
                            <i class="bi bi-search search-icon" 
                               style="position: absolute; left: 15px; top: 50%; transform: translateY(-50%); color: #718096 !important; opacity: 0.8; pointer-events: none; z-index: 10; font-size: 16px;"></i>
                        </div>
                    </div>
                    <div class="col-md-2">
                        <label class="form-label" style="color: #2d3748 !important; font-weight: 600 !important; font-size: 14px !important; margin-bottom: 10px !important;">Status</label>
                        <select name="status" class="form-control" style="background: #ffffff !important; border: 2px solid #e2e8f0 !important; color: #1a202c !important; padding: 14px 18px !important; border-radius: 10px !important; font-size: 15px !important; font-weight: 500 !important;">
                            <option value="">All Status</option>
                            <option value="approved" {{ request('status') == 'approved' ? 'selected' : '' }}>Approved</option>
                            <option value="pending" {{ request('status') == 'pending' ? 'selected' : '' }}>Pending</option>
                        </select>
                    </div>
                    <div class="col-md-2">
                        <label class="form-label" style="color: #2d3748 !important; font-weight: 600 !important; font-size: 14px !important; margin-bottom: 10px !important;">Rating</label>
                        <select name="rating" class="form-control" style="background: #ffffff !important; border: 2px solid #e2e8f0 !important; color: #1a202c !important; padding: 14px 18px !important; border-radius: 10px !important; font-size: 15px !important; font-weight: 500 !important;">
                            <option value="">All Ratings</option>
                            @for($i = 5; $i >= 1; $i--)
                                <option value="{{ $i }}" {{ request('rating') == $i ? 'selected' : '' }}>
                                    {{ $i }} Star{{ $i > 1 ? 's' : '' }}
                                </option>
                            @endfor
                        </select>
                    </div>
                    <div class="col-md-3">
                        <label class="form-label" style="color: #2d3748 !important; font-weight: 600 !important; font-size: 14px !important; margin-bottom: 10px !important;">Product</label>
                        <select name="product_id" class="form-control" style="background: #ffffff !important; border: 2px solid #e2e8f0 !important; color: #1a202c !important; padding: 14px 18px !important; border-radius: 10px !important; font-size: 15px !important; font-weight: 500 !important;">
                            <option value="">All Products</option>
                            @foreach($products as $product)
                                <option value="{{ $product->id }}" {{ request('product_id') == $product->id ? 'selected' : '' }}>
                                    {{ $product->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-2">
                        <div class="d-flex align-items-center gap-2">
                            <button type="submit" class="btn btn-outline-primary flex-fill" 
                                    style="color: #3182ce !important; border-color: #3182ce !important; background: #ffffff !important; padding: 14px 20px !important; border-radius: 10px !important; font-weight: 600 !important; font-size: 14px !important; border-width: 2px !important; transition: all 0.2s ease !important;"
                                    onmouseover="this.style.backgroundColor='#3182ce !important'; this.style.color='#ffffff !important';"
                                    onmouseout="this.style.backgroundColor='#ffffff !important'; this.style.color='#3182ce !important';">
                                <i class="bi bi-search me-1"></i> Search
                            </button>
                            @if(request()->hasAny(['search', 'status', 'rating', 'product_id']))
                                <a href="{{ route('admin.reviews.index') }}" class="btn btn-outline-secondary"
                                   style="color: #4a5568 !important; border-color: #4a5568 !important; background: #ffffff !important; padding: 14px 16px !important; border-radius: 10px !important; font-weight: 600 !important; font-size: 14px !important; border-width: 2px !important; transition: all 0.2s ease !important; text-decoration: none !important;"
                                   onmouseover="this.style.backgroundColor='#4a5568 !important'; this.style.color='#ffffff !important';"
                                   onmouseout="this.style.backgroundColor='#ffffff !important'; this.style.color='#4a5568 !important';">
                                    <i class="bi bi-x-circle"></i>
                                </a>
                            @endif
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>

    @if($reviews->count() > 0)
        <!-- Bulk Actions Card -->
        <div class="card mb-4" style="background: #ffffff !important; border: 1px solid #e2e8f0 !important; border-radius: 12px !important; box-shadow: 0 1px 3px rgba(0, 0, 0, 0.1) !important;">
            <div class="card-body" style="padding: 1rem 2rem !important;">
                <form id="bulk-actions-form" method="POST" action="{{ route('admin.reviews.bulk') }}">
                    @csrf
                    <div class="row align-items-center">
                        <div class="col-md-2">
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" id="select-all">
                                <label class="form-check-label" for="select-all" style="color: #2d3748 !important; font-weight: 500 !important; font-size: 14px !important;">
                                    Select All
                                </label>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <select name="action" class="form-control" style="background: #ffffff !important; border: 2px solid #e2e8f0 !important; color: #1a202c !important; padding: 12px 16px !important; border-radius: 8px !important; font-size: 14px !important; font-weight: 500 !important;">
                                <option value="">Bulk Actions</option>
                                <option value="approve">Approve Selected</option>
                                <option value="reject">Reject Selected</option>
                                <option value="delete">Delete Selected</option>
                            </select>
                        </div>
                        <div class="col-md-6">
                            <button type="submit" class="btn btn-outline-warning" 
                                    style="color: #d69e2e !important; border-color: #d69e2e !important; background: #ffffff !important; padding: 12px 20px !important; border-radius: 8px !important; font-weight: 600 !important; font-size: 14px !important; border-width: 2px !important; transition: all 0.2s ease !important;"
                                    onclick="return confirm('Are you sure you want to perform this bulk action?')">
                                <i class="bi bi-lightning me-1"></i> Apply Action
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>

        <!-- Reviews Display -->
        <div class="row">
            @foreach($reviews as $review)
                <div class="col-lg-6 col-md-12 mb-4">
                    <div class="review-card" 
                         style="background: #ffffff !important; border: 1px solid #e2e8f0 !important; border-radius: 12px !important; padding: 1.5rem !important; transition: all 0.2s ease !important; height: 100% !important;"
                         onmouseover="this.style.transform='translateY(-2px)'; this.style.boxShadow='0 4px 12px rgba(0, 0, 0, 0.1) !important'; this.style.borderColor='#3182ce !important';"
                         onmouseout="this.style.transform='translateY(0)'; this.style.boxShadow='none'; this.style.borderColor='#e2e8f0 !important';">
                        
                        <div class="d-flex justify-content-between align-items-start mb-3">
                            <!-- Rating and Status -->
                            <div class="d-flex align-items-center gap-2">
                                <div class="rating-stars" style="color: {{ $review->rating_color }} !important; font-size: 16px !important;">
                                    {{ $review->star_rating }}
                                </div>
                                <span class="badge" style="background: {{ $review->status_color }} !important; color: #ffffff !important; font-size: 10px !important; padding: 4px 8px !important; border-radius: 12px !important;">
                                    {{ $review->status_badge }}
                                </span>
                            </div>
                            <!-- Checkbox for bulk actions -->
                            <div class="form-check">
                                <input class="form-check-input review-checkbox" type="checkbox" value="{{ $review->id }}" name="selected_reviews[]">
                            </div>
                        </div>
                        
                        <!-- Review Title -->
                        @if($review->title)
                            <h6 style="color: #1a202c !important; font-weight: 600 !important; font-size: 16px !important; margin-bottom: 8px !important;">
                                "{{ $review->title }}"
                            </h6>
                        @endif
                        
                        <!-- Review Comment -->
                        @if($review->comment)
                            <p style="color: #4a5568 !important; font-size: 14px !important; line-height: 1.6 !important; margin-bottom: 12px !important;">
                                {{ Str::limit($review->comment, 150) }}
                            </p>
                        @endif
                        
                        <!-- Product and User Info -->
                        <div class="mb-3" style="padding: 12px !important; background: linear-gradient(135deg, #f8fafc 0%, #f1f5f9 100%) !important; border-radius: 8px !important;">
                            <div class="row">
                                <div class="col-6">
                                    <small style="color: #718096 !important; font-size: 11px !important; text-transform: uppercase !important; font-weight: 600 !important;">Product</small>
                                    <div style="color: #1a202c !important; font-weight: 500 !important; font-size: 13px !important;">{{ $review->product->name ?? 'Unknown Product' }}</div>
                                </div>
                                <div class="col-6">
                                    <small style="color: #718096 !important; font-size: 11px !important; text-transform: uppercase !important; font-weight: 600 !important;">Reviewer</small>
                                    <div style="color: #1a202c !important; font-weight: 500 !important; font-size: 13px !important;">{{ $review->user->name ?? 'Unknown User' }}</div>
                                </div>
                            </div>
                        </div>
                        
                        <!-- Review Meta -->
                        <div class="mb-3" style="padding: 8px 12px !important; background: linear-gradient(135deg, #fef3c7 0%, #fed7aa 100%) !important; border-radius: 6px !important;">
                            <div class="d-flex justify-content-between align-items-center">
                                <small style="color: #92400e !important; font-weight: 600 !important; font-size: 11px !important;">
                                    ID: {{ $review->id }}
                                </small>
                                <small style="color: #92400e !important; font-weight: 600 !important; font-size: 11px !important;">
                                    {{ $review->created_at->format('M d, Y') }}
                                </small>
                            </div>
                        </div>
                        
                        <!-- Actions -->
                        <div class="d-flex gap-1">
                            @if(!$review->is_approved)
                                <form method="POST" action="{{ route('admin.reviews.toggleApproval', $review) }}" class="d-inline flex-fill">
                                    @csrf
                                    @method('PATCH')
                                    <button type="submit" class="btn btn-sm btn-outline-success w-100"
                                            style="color: #10b981 !important; border-color: #10b981 !important; background: #ffffff !important; padding: 8px 12px !important; border-radius: 6px !important; font-size: 12px !important; transition: all 0.2s ease !important;"
                                            onmouseover="this.style.backgroundColor='#10b981 !important'; this.style.color='#ffffff !important';"
                                            onmouseout="this.style.backgroundColor='#ffffff !important'; this.style.color='#10b981 !important';">
                                        <i class="bi bi-check-circle"></i> Approve
                                    </button>
                                </form>
                            @else
                                <form method="POST" action="{{ route('admin.reviews.toggleApproval', $review) }}" class="d-inline flex-fill">
                                    @csrf
                                    @method('PATCH')
                                    <button type="submit" class="btn btn-sm btn-outline-warning w-100"
                                            style="color: #d69e2e !important; border-color: #d69e2e !important; background: #ffffff !important; padding: 8px 12px !important; border-radius: 6px !important; font-size: 12px !important; transition: all 0.2s ease !important;"
                                            onmouseover="this.style.backgroundColor='#d69e2e !important'; this.style.color='#ffffff !important';"
                                            onmouseout="this.style.backgroundColor='#ffffff !important'; this.style.color='#d69e2e !important';">
                                        <i class="bi bi-x-circle"></i> Reject
                                    </button>
                                </form>
                            @endif
                            <a href="{{ route('admin.reviews.edit', $review) }}" class="btn btn-sm btn-outline-primary flex-fill"
                               style="color: #3182ce !important; border-color: #3182ce !important; background: #ffffff !important; padding: 8px 12px !important; border-radius: 6px !important; font-size: 12px !important; transition: all 0.2s ease !important; text-decoration: none !important;"
                               onmouseover="this.style.backgroundColor='#3182ce !important'; this.style.color='#ffffff !important';"
                               onmouseout="this.style.backgroundColor='#ffffff !important'; this.style.color='#3182ce !important';">
                                <i class="bi bi-pencil"></i>
                            </a>
                            <a href="{{ route('admin.reviews.show', $review) }}" class="btn btn-sm btn-outline-info flex-fill"
                               style="color: #0891b2 !important; border-color: #0891b2 !important; background: #ffffff !important; padding: 8px 12px !important; border-radius: 6px !important; font-size: 12px !important; transition: all 0.2s ease !important; text-decoration: none !important;"
                               onmouseover="this.style.backgroundColor='#0891b2 !important'; this.style.color='#ffffff !important';"
                               onmouseout="this.style.backgroundColor='#ffffff !important'; this.style.color='#0891b2 !important';">
                                <i class="bi bi-eye"></i>
                            </a>
                            <form method="POST" action="{{ route('admin.reviews.destroy', $review) }}" class="d-inline flex-fill" 
                                  onsubmit="return confirm('Are you sure you want to delete this review?')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-sm btn-outline-danger w-100"
                                        style="color: #e53e3e !important; border-color: #e53e3e !important; background: #ffffff !important; padding: 8px 12px !important; border-radius: 6px !important; font-size: 12px !important; transition: all 0.2s ease !important;"
                                        onmouseover="this.style.backgroundColor='#e53e3e !important'; this.style.color='#ffffff !important';"
                                        onmouseout="this.style.backgroundColor='#ffffff !important'; this.style.color='#e53e3e !important';">
                                    <i class="bi bi-trash"></i>
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>

        <!-- Professional Pagination -->
        <div class="pagination-container mt-4" style="background: white; padding: 12px 20px; border-radius: 8px; border: 1px solid #dee2e6; display: flex; justify-content: space-between; align-items: center;">
            <div class="pagination-info" style="color: #6c757d; font-weight: 400; font-size: 14px; white-space: nowrap;">
                Showing {{ $reviews->firstItem() ?? 0 }} to {{ $reviews->lastItem() ?? 0 }} of {{ $reviews->total() }} entries
            </div>
            <div class="pagination-links">
                {{ $reviews->appends(request()->query())->links('vendor.pagination.custom') }}
            </div>
        </div>

    @else
        <!-- Empty State -->
        <div class="card" style="background: #ffffff !important; border: 1px solid #e2e8f0 !important; border-radius: 12px !important; box-shadow: 0 1px 3px rgba(0, 0, 0, 0.1) !important;">
            <div class="card-body" style="padding: 3rem !important;">
                <div class="text-center">
                    <i class="bi bi-chat-quote" style="color: #718096 !important; font-size: 4rem !important; margin-bottom: 1.5rem !important;"></i>
                    <h4 style="color: #1a202c !important; font-weight: 600 !important; margin-bottom: 1rem !important;">No Reviews Found</h4>
                    <p style="color: #4a5568 !important; font-size: 16px !important; line-height: 1.6 !important; max-width: 500px !important; margin: 0 auto 2rem auto !important;">
                        @if(request()->hasAny(['search', 'status', 'rating', 'product_id']))
                            No reviews match your current search criteria. Try adjusting your filters.
                        @else
                            No customer reviews have been submitted yet. Reviews will appear here once customers start rating products.
                        @endif
                    </p>
                    <div class="d-flex gap-2 justify-content-center">
                        <a href="{{ route('admin.reviews.create') }}" class="btn btn-primary"
                           style="background: linear-gradient(135deg, #3182ce 0%, #2c5aa0 100%) !important; border: none !important; color: #ffffff !important; padding: 12px 24px !important; border-radius: 10px !important; font-weight: 600 !important;">
                            <i class="bi bi-plus-circle me-2"></i>Add First Review
                        </a>
                        @if(request()->hasAny(['search', 'status', 'rating', 'product_id']))
                            <a href="{{ route('admin.reviews.index') }}" class="btn btn-outline-secondary"
                               style="color: #4a5568 !important; border-color: #4a5568 !important; background: #ffffff !important; padding: 12px 24px !important; border-radius: 10px !important; font-weight: 600 !important; text-decoration: none !important;"
                               onmouseover="this.style.backgroundColor='#4a5568 !important'; this.style.color='#ffffff !important';"
                               onmouseout="this.style.backgroundColor='#ffffff !important'; this.style.color='#4a5568 !important';">
                                <i class="bi bi-arrow-left me-2"></i>Clear Filters
                            </a>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    @endif
</div>

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Bulk selection functionality
    const selectAllCheckbox = document.getElementById('select-all');
    const reviewCheckboxes = document.querySelectorAll('.review-checkbox');
    
    if (selectAllCheckbox) {
        selectAllCheckbox.addEventListener('change', function() {
            reviewCheckboxes.forEach(checkbox => {
                checkbox.checked = this.checked;
            });
            updateBulkActionsState();
        });
    }
    
    reviewCheckboxes.forEach(checkbox => {
        checkbox.addEventListener('change', function() {
            updateSelectAllState();
            updateBulkActionsState();
        });
    });
    
    function updateSelectAllState() {
        if (selectAllCheckbox) {
            const checkedCount = document.querySelectorAll('.review-checkbox:checked').length;
            selectAllCheckbox.checked = checkedCount === reviewCheckboxes.length;
            selectAllCheckbox.indeterminate = checkedCount > 0 && checkedCount < reviewCheckboxes.length;
        }
    }
    
    function updateBulkActionsState() {
        const selectedCount = document.querySelectorAll('.review-checkbox:checked').length;
        const bulkForm = document.getElementById('bulk-actions-form');
        
        if (bulkForm) {
            const actionSelect = bulkForm.querySelector('select[name="action"]');
            
            if (selectedCount > 0) {
                actionSelect.style.borderColor = '#3182ce';
                actionSelect.style.background = '#f0f9ff';
            } else {
                actionSelect.style.borderColor = '#e2e8f0';
                actionSelect.style.background = '#ffffff';
            }
        }
    }
});
</script>
@endpush

@push('styles')
<style>
    /* CLEAN REVIEWS INDEX - Professional Styling */
    .review-card {
        transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1) !important;
    }
    
    .rating-stars {
        transition: all 0.2s ease !important;
        text-shadow: 0 1px 2px rgba(0, 0, 0, 0.1) !important;
    }
    
    .review-card:hover .rating-stars {
        transform: scale(1.05) !important;
    }
    
    /* Clean Search Input Styling */
    #search-reviews::placeholder {
        color: #718096 !important;
        opacity: 1 !important;
        font-weight: 400 !important;
    }
    
    .form-control:hover {
        border-color: #cbd5e0 !important;
        box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1) !important;
    }
    
    .form-control:focus {
        background: #ffffff !important;
        border: 2px solid #3182ce !important;
        color: #1a202c !important;
        box-shadow: 0 0 0 4px rgba(49, 130, 206, 0.15), 0 2px 8px rgba(49, 130, 206, 0.1) !important;
        outline: none !important;
        transform: translateY(-1px) !important;
    }
    
    .form-check-input:checked {
        background-color: #3182ce !important;
        border-color: #3182ce !important;
        box-shadow: 0 0 0 2px rgba(49, 130, 206, 0.2) !important;
    }
    
    /* Responsive Design */
    @media (max-width: 768px) {
        .review-card {
            margin-bottom: 1rem !important;
        }
        
        .d-flex.gap-1 {
            flex-direction: column !important;
            gap: 0.5rem !important;
        }
        
        .d-flex.gap-1 .btn {
            width: 100% !important;
        }
    }
</style>
@endpush
@endsection
