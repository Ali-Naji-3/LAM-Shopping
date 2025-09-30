@extends('admin.dashboard')

@section('content')
<div class="container-fluid">
    <!-- Page Header -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h2 class="mb-1" style="color: #1a202c !important; font-weight: 700 !important; font-size: 24px !important;">
                👤 User Reviews: {{ $user->name }}
            </h2>
            <p class="mb-0" style="color: #4a5568 !important; font-size: 14px !important;">
                All reviews by this user • {{ $reviews->total() }} total reviews
            </p>
        </div>
        <div class="d-flex gap-2">
            <a href="{{ route('admin.users.show', $user) }}" class="btn btn-outline-primary"
               style="color: #3182ce !important; border-color: #3182ce !important; background: #ffffff !important; padding: 12px 20px !important; border-radius: 10px !important; font-weight: 600 !important; font-size: 14px !important; border-width: 2px !important; transition: all 0.2s ease !important; text-decoration: none !important;"
               onmouseover="this.style.backgroundColor='#3182ce !important'; this.style.color='#ffffff !important';"
               onmouseout="this.style.backgroundColor='#ffffff !important'; this.style.color='#3182ce !important';">
                <i class="bi bi-person me-2"></i>View User
            </a>
            <a href="{{ route('admin.reviews.index') }}" class="btn btn-outline-secondary"
               style="color: #4a5568 !important; border-color: #4a5568 !important; background: #ffffff !important; padding: 12px 20px !important; border-radius: 10px !important; font-weight: 600 !important; font-size: 14px !important; border-width: 2px !important; transition: all 0.2s ease !important; text-decoration: none !important;"
               onmouseover="this.style.backgroundColor='#4a5568 !important'; this.style.color='#ffffff !important';"
               onmouseout="this.style.backgroundColor='#ffffff !important'; this.style.color='#4a5568 !important';">
                <i class="bi bi-arrow-left me-2"></i>Back to Reviews
            </a>
        </div>
    </div>

    <!-- User Info Card -->
    <div class="row mb-4">
        <div class="col-12">
            <div class="card" style="background: #ffffff !important; border: 1px solid #e2e8f0 !important; border-radius: 12px !important; box-shadow: 0 1px 3px rgba(0, 0, 0, 0.1) !important;">
                <div class="card-body" style="padding: 2rem !important;">
                    <div class="row align-items-center">
                        <div class="col-md-8">
                            <h4 style="color: #1a202c !important; font-weight: 700 !important; font-size: 20px !important; margin-bottom: 8px !important;">
                                {{ $user->name }}
                            </h4>
                            <p style="color: #4a5568 !important; font-size: 14px !important; margin-bottom: 12px !important;">
                                {{ $user->email }}
                            </p>
                            <div class="d-flex align-items-center gap-3">
                                <div style="color: #4a5568 !important; font-size: 14px !important;">
                                    User Type: <span class="badge" style="background: #3182ce !important; color: #ffffff !important; font-size: 11px !important; padding: 4px 8px !important; border-radius: 12px !important;">{{ $user->u_type }}</span>
                                </div>
                                <div style="color: #4a5568 !important; font-size: 14px !important;">
                                    Member since: {{ $user->created_at->format('M d, Y') }}
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4 text-md-end">
                            <div class="d-flex flex-column align-items-md-end">
                                <div class="mb-2">
                                    <div style="color: #1a202c !important; font-weight: 700 !important; font-size: 18px !important;">
                                        {{ $userStats['total_reviews'] }} reviews
                                    </div>
                                </div>
                                <div style="color: #4a5568 !important; font-size: 14px !important;">
                                    {{ $userStats['approved_reviews'] }} approved
                                </div>
                                <div style="color: #4a5568 !important; font-size: 14px !important;">
                                    Avg rating given: {{ number_format($userStats['average_rating_given'], 1) }}/5
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Reviews List -->
    <div class="row">
        @forelse($reviews as $review)
            <div class="col-lg-6 col-md-12 mb-4">
                <div class="card" style="background: #ffffff !important; border: 1px solid #e2e8f0 !important; border-radius: 12px !important; box-shadow: 0 1px 3px rgba(0, 0, 0, 0.1) !important; transition: all 0.2s ease !important; height: 100% !important;"
                     onmouseover="this.style.transform='translateY(-2px)'; this.style.boxShadow='0 4px 12px rgba(0, 0, 0, 0.1) !important'; this.style.borderColor='#3182ce !important';"
                     onmouseout="this.style.transform='translateY(0)'; this.style.boxShadow='0 1px 3px rgba(0, 0, 0, 0.1) !important'; this.style.borderColor='#e2e8f0 !important';">

                    <div class="card-body" style="padding: 1.5rem !important;">
                        <div class="d-flex justify-content-between align-items-start mb-3">
                            <div class="d-flex align-items-center gap-2">
                                <div class="rating-stars" style="color: {{ $review->rating_color }} !important; font-size: 16px !important;">
                                    {{ $review->star_rating }}
                                </div>
                                <span class="badge" style="background: {{ $review->status_color }} !important; color: #ffffff !important; font-size: 10px !important; padding: 4px 8px !important; border-radius: 12px !important;">
                                    {{ $review->status_badge }}
                                </span>
                            </div>
                            <small style="color: #718096 !important; font-size: 12px !important;">{{ $review->created_at->format('M d, Y') }}</small>
                        </div>

                        @if($review->title)
                            <h6 style="color: #1a202c !important; font-weight: 600 !important; font-size: 16px !important; margin-bottom: 8px !important;">
                                "{{ $review->title }}"
                            </h6>
                        @endif

                        @if($review->comment)
                            <p style="color: #4a5568 !important; font-size: 14px !important; line-height: 1.6 !important; margin-bottom: 12px !important;">
                                {{ $review->comment }}
                            </p>
                        @endif

                        <div style="padding: 10px !important; background: linear-gradient(135deg, #f8fafc 0%, #f1f5f9 100%) !important; border-radius: 8px !important;">
                            <div style="color: #718096 !important; font-size: 12px !important;">
                                <strong>Product:</strong> {{ $review->product->name }}<br>
                                <strong>Review ID:</strong> #{{ $review->id }}
                            </div>
                        </div>

                        <div class="d-flex justify-content-between align-items-center mt-3">
                            <div class="d-flex gap-2">
                                <a href="{{ route('admin.reviews.show', $review) }}" class="btn btn-sm btn-outline-primary"
                                   style="color: #3182ce !important; border-color: #3182ce !important; background: #ffffff !important; padding: 6px 12px !important; border-radius: 6px !important; font-weight: 500 !important; font-size: 12px !important; border-width: 1px !important; transition: all 0.2s ease !important; text-decoration: none !important;"
                                   onmouseover="this.style.backgroundColor='#3182ce !important'; this.style.color='#ffffff !important';"
                                   onmouseout="this.style.backgroundColor='#ffffff !important'; this.style.color='#3182ce !important';">
                                    <i class="bi bi-eye me-1"></i>View
                                </a>
                                <a href="{{ route('admin.reviews.edit', $review) }}" class="btn btn-sm btn-outline-secondary"
                                   style="color: #4a5568 !important; border-color: #4a5568 !important; background: #ffffff !important; padding: 6px 12px !important; border-radius: 6px !important; font-weight: 500 !important; font-size: 12px !important; border-width: 1px !important; transition: all 0.2s ease !important; text-decoration: none !important;"
                                   onmouseover="this.style.backgroundColor='#4a5568 !important'; this.style.color='#ffffff !important';"
                                   onmouseout="this.style.backgroundColor='#ffffff !important'; this.style.color='#4a5568 !important';">
                                    <i class="bi bi-pencil me-1"></i>Edit
                                </a>
                            </div>

                            <form method="POST" action="{{ route('admin.reviews.toggleApproval', $review) }}" class="d-inline">
                                @csrf
                                <button type="submit" class="btn btn-sm {{ $review->is_approved ? 'btn-outline-warning' : 'btn-outline-success' }}"
                                        style="padding: 6px 12px !important; border-radius: 6px !important; font-weight: 500 !important; font-size: 12px !important; border-width: 1px !important; transition: all 0.2s ease !important;"
                                        onmouseover="this.style.transform='translateY(-1px)';"
                                        onmouseout="this.style.transform='translateY(0)';">
                                    <i class="bi bi-{{ $review->is_approved ? 'x-circle' : 'check-circle' }} me-1"></i>
                                    {{ $review->is_approved ? 'Reject' : 'Approve' }}
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        @empty
            <div class="col-12">
                <div class="card" style="background: #ffffff !important; border: 1px solid #e2e8f0 !important; border-radius: 12px !important; box-shadow: 0 1px 3px rgba(0, 0, 0, 0.1) !important;">
                    <div class="card-body" style="padding: 3rem !important; text-align: center !important;">
                        <i class="bi bi-inbox" style="font-size: 48px !important; color: #cbd5e0 !important; margin-bottom: 1rem !important;"></i>
                        <h5 style="color: #1a202c !important; font-weight: 600 !important; font-size: 18px !important; margin-bottom: 8px !important;">No Reviews Found</h5>
                        <p style="color: #718096 !important; font-size: 14px !important; margin-bottom: 0 !important;">This user hasn't written any reviews yet.</p>
                    </div>
                </div>
            </div>
        @endforelse
    </div>

    <!-- Pagination -->
    @if($reviews->hasPages())
        <div class="d-flex justify-content-center mt-4">
            {{ $reviews->links() }}
        </div>
    @endif
</div>

@push('styles')
<style>
    /* CLEAN USER REVIEWS - Professional Styling */
    .card {
        transition: all 0.2s ease !important;
    }

    .rating-stars {
        display: inline-flex !important;
        gap: 2px !important;
    }

    .btn-sm {
        transition: all 0.2s ease !important;
    }

    .btn-sm:hover {
        transform: translateY(-1px) !important;
    }

    /* Responsive adjustments */
    @media (max-width: 768px) {
        .card-body {
            padding: 1rem !important;
        }

        .d-flex.gap-2 {
            flex-direction: column !important;
            gap: 8px !important;
        }
    }
</style>
@endpush
@endsection
