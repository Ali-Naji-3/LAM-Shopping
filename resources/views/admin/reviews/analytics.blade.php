@extends('admin.dashboard')

@section('content')
<div class="container-fluid">
    <!-- Page Header -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h2 class="mb-1" style="color: #1a202c !important; font-weight: 700 !important; font-size: 24px !important;">
                📊 Reviews Analytics Dashboard
            </h2>
            <p class="mb-0" style="color: #4a5568 !important; font-size: 14px !important;">
                Comprehensive insights into customer reviews and ratings performance
            </p>
        </div>
        <div class="d-flex gap-2">
            <a href="{{ route('admin.reviews.index') }}" class="btn btn-outline-primary"
               style="color: #3182ce !important; border-color: #3182ce !important; background: #ffffff !important; padding: 12px 20px !important; border-radius: 10px !important; font-weight: 600 !important; font-size: 14px !important; border-width: 2px !important; transition: all 0.2s ease !important; text-decoration: none !important;"
               onmouseover="this.style.backgroundColor='#3182ce !important'; this.style.color='#ffffff !important';"
               onmouseout="this.style.backgroundColor='#ffffff !important'; this.style.color='#3182ce !important';">
                <i class="bi bi-arrow-left me-2"></i>Back to Reviews
            </a>
        </div>
    </div>

    <!-- Key Metrics Cards -->
    <div class="row mb-4">
        <div class="col-lg-3 col-md-6 mb-3">
            <div class="card" style="background: linear-gradient(135deg, #3182ce 0%, #2c5aa0 100%) !important; border: none !important; border-radius: 12px !important; color: #ffffff !important; box-shadow: 0 4px 12px rgba(49, 130, 206, 0.3) !important;">
                <div class="card-body" style="padding: 1.5rem !important;">
                    <div class="d-flex align-items-center">
                        <div style="background: rgba(255, 255, 255, 0.2) !important; border-radius: 50% !important; width: 50px !important; height: 50px !important; display: flex !important; align-items: center !important; justify-content: center !important; margin-right: 1rem !important;">
                            <i class="bi bi-star-fill" style="font-size: 20px !important;"></i>
                        </div>
                        <div>
                            <h3 class="mb-0" style="color: #ffffff !important; font-weight: 700 !important; font-size: 28px !important;">{{ $analytics['total_reviews'] }}</h3>
                            <p class="mb-0" style="color: rgba(255, 255, 255, 0.9) !important; font-size: 14px !important; font-weight: 500 !important;">Total Reviews</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-lg-3 col-md-6 mb-3">
            <div class="card" style="background: linear-gradient(135deg, #10b981 0%, #059669 100%) !important; border: none !important; border-radius: 12px !important; color: #ffffff !important; box-shadow: 0 4px 12px rgba(16, 185, 129, 0.3) !important;">
                <div class="card-body" style="padding: 1.5rem !important;">
                    <div class="d-flex align-items-center">
                        <div style="background: rgba(255, 255, 255, 0.2) !important; border-radius: 50% !important; width: 50px !important; height: 50px !important; display: flex !important; align-items: center !important; justify-content: center !important; margin-right: 1rem !important;">
                            <i class="bi bi-check-circle-fill" style="font-size: 20px !important;"></i>
                        </div>
                        <div>
                            <h3 class="mb-0" style="color: #ffffff !important; font-weight: 700 !important; font-size: 28px !important;">{{ $analytics['approved_reviews'] }}</h3>
                            <p class="mb-0" style="color: rgba(255, 255, 255, 0.9) !important; font-size: 14px !important; font-weight: 500 !important;">Approved Reviews</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-lg-3 col-md-6 mb-3">
            <div class="card" style="background: linear-gradient(135deg, #f59e0b 0%, #d97706 100%) !important; border: none !important; border-radius: 12px !important; color: #ffffff !important; box-shadow: 0 4px 12px rgba(245, 158, 11, 0.3) !important;">
                <div class="card-body" style="padding: 1.5rem !important;">
                    <div class="d-flex align-items-center">
                        <div style="background: rgba(255, 255, 255, 0.2) !important; border-radius: 50% !important; width: 50px !important; height: 50px !important; display: flex !important; align-items: center !important; justify-content: center !important; margin-right: 1rem !important;">
                            <i class="bi bi-clock-fill" style="font-size: 20px !important;"></i>
                        </div>
                        <div>
                            <h3 class="mb-0" style="color: #ffffff !important; font-weight: 700 !important; font-size: 28px !important;">{{ $analytics['pending_reviews'] }}</h3>
                            <p class="mb-0" style="color: rgba(255, 255, 255, 0.9) !important; font-size: 14px !important; font-weight: 500 !important;">Pending Reviews</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-lg-3 col-md-6 mb-3">
            <div class="card" style="background: linear-gradient(135deg, #8b5cf6 0%, #7c3aed 100%) !important; border: none !important; border-radius: 12px !important; color: #ffffff !important; box-shadow: 0 4px 12px rgba(139, 92, 246, 0.3) !important;">
                <div class="card-body" style="padding: 1.5rem !important;">
                    <div class="d-flex align-items-center">
                        <div style="background: rgba(255, 255, 255, 0.2) !important; border-radius: 50% !important; width: 50px !important; height: 50px !important; display: flex !important; align-items: center !important; justify-content: center !important; margin-right: 1rem !important;">
                            <i class="bi bi-graph-up" style="font-size: 20px !important;"></i>
                        </div>
                        <div>
                            <h3 class="mb-0" style="color: #ffffff !important; font-weight: 700 !important; font-size: 28px !important;">{{ number_format($analytics['average_rating'], 1) }}</h3>
                            <p class="mb-0" style="color: rgba(255, 255, 255, 0.9) !important; font-size: 14px !important; font-weight: 500 !important;">Average Rating</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <!-- Rating Distribution Chart -->
        <div class="col-lg-6 mb-4">
            <div class="card" style="background: #ffffff !important; border: 1px solid #e2e8f0 !important; border-radius: 12px !important; box-shadow: 0 1px 3px rgba(0, 0, 0, 0.1) !important;">
                <div class="card-header" style="background: linear-gradient(135deg, #f7fafc 0%, #edf2f7 100%) !important; border-bottom: 1px solid #e2e8f0 !important; border-radius: 12px 12px 0 0 !important; padding: 1.5rem 2rem !important;">
                    <h5 class="mb-0" style="color: #1a202c !important; font-weight: 600 !important; font-size: 18px !important;">
                        <i class="bi bi-bar-chart me-2" style="color: #3182ce !important;"></i>Rating Distribution
                    </h5>
                </div>
                <div class="card-body" style="padding: 2rem !important;">
                    @for($i = 5; $i >= 1; $i--)
                        @php
                            $count = $analytics['rating_distribution'][$i] ?? 0;
                            $percentage = $analytics['approved_reviews'] > 0 ? round(($count / $analytics['approved_reviews']) * 100, 1) : 0;
                        @endphp
                        <div class="d-flex align-items-center mb-3">
                            <div class="d-flex align-items-center" style="width: 40px !important;">
                                <span style="color: #1a202c !important; font-weight: 600 !important; font-size: 14px !important;">{{ $i }}</span>
                                <i class="bi bi-star-fill ms-1" style="color: #fbbf24 !important; font-size: 12px !important;"></i>
                            </div>
                            <div class="flex-grow-1 mx-3">
                                <div style="background: #f1f5f9 !important; border-radius: 8px !important; height: 8px !important; overflow: hidden !important;">
                                    <div style="background: linear-gradient(90deg, #3182ce 0%, #2c5aa0 100%) !important; height: 100% !important; width: {{ $percentage }}% !important; transition: width 0.3s ease !important;"></div>
                                </div>
                            </div>
                            <div class="text-end" style="width: 80px !important;">
                                <span style="color: #4a5568 !important; font-weight: 600 !important; font-size: 14px !important;">{{ $count }}</span>
                                <small style="color: #718096 !important; font-size: 12px !important; margin-left: 4px !important;">({{ $percentage }}%)</small>
                            </div>
                        </div>
                    @endfor
                </div>
            </div>
        </div>

        <!-- Approval Rate -->
        <div class="col-lg-6 mb-4">
            <div class="card" style="background: #ffffff !important; border: 1px solid #e2e8f0 !important; border-radius: 12px !important; box-shadow: 0 1px 3px rgba(0, 0, 0, 0.1) !important;">
                <div class="card-header" style="background: linear-gradient(135deg, #f7fafc 0%, #edf2f7 100%) !important; border-bottom: 1px solid #e2e8f0 !important; border-radius: 12px 12px 0 0 !important; padding: 1.5rem 2rem !important;">
                    <h5 class="mb-0" style="color: #1a202c !important; font-weight: 600 !important; font-size: 18px !important;">
                        <i class="bi bi-pie-chart me-2" style="color: #3182ce !important;"></i>Approval Rate
                    </h5>
                </div>
                <div class="card-body" style="padding: 2rem !important;">
                    <div class="text-center">
                        <div style="position: relative !important; display: inline-block !important; margin-bottom: 1rem !important;">
                            <div style="width: 120px !important; height: 120px !important; border-radius: 50% !important; background: conic-gradient(#10b981 0deg {{ $analytics['approval_rate'] * 3.6 }}deg, #e2e8f0 {{ $analytics['approval_rate'] * 3.6 }}deg 360deg) !important; display: flex !important; align-items: center !important; justify-content: center !important;">
                                <div style="width: 80px !important; height: 80px !important; background: #ffffff !important; border-radius: 50% !important; display: flex !important; align-items: center !important; justify-content: center !important;">
                                    <span style="color: #1a202c !important; font-weight: 700 !important; font-size: 20px !important;">{{ $analytics['approval_rate'] }}%</span>
                                </div>
                            </div>
                        </div>
                        <p style="color: #4a5568 !important; font-size: 14px !important; margin-bottom: 0 !important;">Reviews approved for public display</p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <!-- Recent Reviews -->
        <div class="col-lg-8 mb-4">
            <div class="card" style="background: #ffffff !important; border: 1px solid #e2e8f0 !important; border-radius: 12px !important; box-shadow: 0 1px 3px rgba(0, 0, 0, 0.1) !important;">
                <div class="card-header" style="background: linear-gradient(135deg, #f7fafc 0%, #edf2f7 100%) !important; border-bottom: 1px solid #e2e8f0 !important; border-radius: 12px 12px 0 0 !important; padding: 1.5rem 2rem !important;">
                    <h5 class="mb-0" style="color: #1a202c !important; font-weight: 600 !important; font-size: 18px !important;">
                        <i class="bi bi-clock-history me-2" style="color: #3182ce !important;"></i>Recent Reviews
                    </h5>
                </div>
                <div class="card-body" style="padding: 0 !important;">
                    @forelse($analytics['recent_reviews'] as $review)
                        <div class="border-bottom" style="padding: 1.5rem 2rem !important; transition: all 0.2s ease !important;" onmouseover="this.style.backgroundColor='#f8fafc !important';" onmouseout="this.style.backgroundColor='transparent !important';">
                            <div class="d-flex justify-content-between align-items-start mb-2">
                                <div class="d-flex align-items-center gap-2">
                                    <div class="rating-stars" style="color: {{ $review->rating_color }} !important; font-size: 16px !important;">
                                        {{ $review->star_rating }}
                                    </div>
                                    <span class="badge" style="background: {{ $review->status_color }} !important; color: #ffffff !important; font-size: 10px !important; padding: 4px 8px !important; border-radius: 12px !important;">
                                        {{ $review->status_badge }}
                                    </span>
                                </div>
                                <small style="color: #718096 !important; font-size: 12px !important;">{{ $review->created_at->diffForHumans() }}</small>
                            </div>

                            @if($review->title)
                                <h6 style="color: #1a202c !important; font-weight: 600 !important; font-size: 14px !important; margin-bottom: 8px !important;">
                                    "{{ $review->title }}"
                                </h6>
                            @endif

                            @if($review->comment)
                                <p style="color: #4a5568 !important; font-size: 13px !important; line-height: 1.5 !important; margin-bottom: 8px !important;">
                                    {{ Str::limit($review->comment, 100) }}
                                </p>
                            @endif

                            <div style="color: #718096 !important; font-size: 12px !important;">
                                <strong>Product:</strong> {{ $review->product->name }} •
                                <strong>Reviewer:</strong> {{ $review->user->name }}
                            </div>
                        </div>
                    @empty
                        <div style="padding: 3rem 2rem !important; text-align: center !important;">
                            <i class="bi bi-inbox" style="font-size: 48px !important; color: #cbd5e0 !important; margin-bottom: 1rem !important;"></i>
                            <p style="color: #718096 !important; font-size: 14px !important; margin-bottom: 0 !important;">No reviews found</p>
                        </div>
                    @endforelse
                </div>
            </div>
        </div>

        <!-- Top Rated Products -->
        <div class="col-lg-4 mb-4">
            <div class="card" style="background: #ffffff !important; border: 1px solid #e2e8f0 !important; border-radius: 12px !important; box-shadow: 0 1px 3px rgba(0, 0, 0, 0.1) !important;">
                <div class="card-header" style="background: linear-gradient(135deg, #f7fafc 0%, #edf2f7 100%) !important; border-bottom: 1px solid #e2e8f0 !important; border-radius: 12px 12px 0 0 !important; padding: 1.5rem 2rem !important;">
                    <h5 class="mb-0" style="color: #1a202c !important; font-weight: 600 !important; font-size: 18px !important;">
                        <i class="bi bi-trophy me-2" style="color: #3182ce !important;"></i>Top Rated Products
                    </h5>
                </div>
                <div class="card-body" style="padding: 0 !important;">
                    @forelse($analytics['top_rated_products'] as $index => $product)
                        <div class="border-bottom" style="padding: 1.5rem 2rem !important; transition: all 0.2s ease !important;" onmouseover="this.style.backgroundColor='#f8fafc !important';" onmouseout="this.style.backgroundColor='transparent !important';">
                            <div class="d-flex align-items-center">
                                <div style="background: linear-gradient(135deg, #3182ce 0%, #2c5aa0 100%) !important; color: #ffffff !important; width: 30px !important; height: 30px !important; border-radius: 50% !important; display: flex !important; align-items: center !important; justify-content: center !important; font-weight: 700 !important; font-size: 12px !important; margin-right: 1rem !important;">
                                    {{ $index + 1 }}
                                </div>
                                <div class="flex-grow-1">
                                    <h6 style="color: #1a202c !important; font-weight: 600 !important; font-size: 14px !important; margin-bottom: 4px !important;">
                                        {{ $product->name }}
                                    </h6>
                                    <div class="d-flex align-items-center gap-2">
                                        <div class="rating-stars" style="color: #fbbf24 !important; font-size: 12px !important;">
                                            @for($i = 1; $i <= 5; $i++)
                                                <i class="bi bi-star{{ $i <= round($product->reviews_avg_rating) ? '-fill' : '' }}"></i>
                                            @endfor
                                        </div>
                                        <span style="color: #4a5568 !important; font-size: 12px !important; font-weight: 600 !important;">
                                            {{ number_format($product->reviews_avg_rating, 1) }}
                                        </span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @empty
                        <div style="padding: 3rem 2rem !important; text-align: center !important;">
                            <i class="bi bi-box" style="font-size: 48px !important; color: #cbd5e0 !important; margin-bottom: 1rem !important;"></i>
                            <p style="color: #718096 !important; font-size: 14px !important; margin-bottom: 0 !important;">No products with reviews</p>
                        </div>
                    @endforelse
                </div>
            </div>
        </div>
    </div>

    <!-- Most Active Reviewers -->
    <div class="row">
        <div class="col-12">
            <div class="card" style="background: #ffffff !important; border: 1px solid #e2e8f0 !important; border-radius: 12px !important; box-shadow: 0 1px 3px rgba(0, 0, 0, 0.1) !important;">
                <div class="card-header" style="background: linear-gradient(135deg, #f7fafc 0%, #edf2f7 100%) !important; border-bottom: 1px solid #e2e8f0 !important; border-radius: 12px 12px 0 0 !important; padding: 1.5rem 2rem !important;">
                    <h5 class="mb-0" style="color: #1a202c !important; font-weight: 600 !important; font-size: 18px !important;">
                        <i class="bi bi-people me-2" style="color: #3182ce !important;"></i>Most Active Reviewers
                    </h5>
                </div>
                <div class="card-body" style="padding: 0 !important;">
                    @forelse($analytics['most_active_reviewers'] as $index => $user)
                        <div class="border-bottom" style="padding: 1.5rem 2rem !important; transition: all 0.2s ease !important;" onmouseover="this.style.backgroundColor='#f8fafc !important';" onmouseout="this.style.backgroundColor='transparent !important';">
                            <div class="d-flex align-items-center">
                                <div style="background: linear-gradient(135deg, #10b981 0%, #059669 100%) !important; color: #ffffff !important; width: 40px !important; height: 40px !important; border-radius: 50% !important; display: flex !important; align-items: center !important; justify-content: center !important; font-weight: 700 !important; font-size: 16px !important; margin-right: 1rem !important;">
                                    {{ $index + 1 }}
                                </div>
                                <div class="flex-grow-1">
                                    <h6 style="color: #1a202c !important; font-weight: 600 !important; font-size: 16px !important; margin-bottom: 4px !important;">
                                        {{ $user->name }}
                                    </h6>
                                    <p style="color: #4a5568 !important; font-size: 13px !important; margin-bottom: 0 !important;">
                                        {{ $user->email }}
                                    </p>
                                </div>
                                <div class="text-end">
                                    <div style="background: linear-gradient(135deg, #3182ce 0%, #2c5aa0 100%) !important; color: #ffffff !important; padding: 8px 16px !important; border-radius: 20px !important; font-weight: 700 !important; font-size: 14px !important;">
                                        {{ $user->reviews_count }} reviews
                                    </div>
                                </div>
                            </div>
                        </div>
                    @empty
                        <div style="padding: 3rem 2rem !important; text-align: center !important;">
                            <i class="bi bi-person" style="font-size: 48px !important; color: #cbd5e0 !important; margin-bottom: 1rem !important;"></i>
                            <p style="color: #718096 !important; font-size: 14px !important; margin-bottom: 0 !important;">No active reviewers found</p>
                        </div>
                    @endforelse
                </div>
            </div>
        </div>
    </div>
</div>

@push('styles')
<style>
    /* CLEAN REVIEWS ANALYTICS - Professional Styling */
    .card {
        transition: all 0.2s ease !important;
    }

    .card:hover {
        transform: translateY(-2px) !important;
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.15) !important;
    }

    .rating-stars {
        display: inline-flex !important;
        gap: 2px !important;
    }

    /* Responsive adjustments */
    @media (max-width: 768px) {
        .card-body {
            padding: 1rem !important;
        }

        .card-header {
            padding: 1rem 1.5rem !important;
        }
    }
</style>
@endpush
@endsection
