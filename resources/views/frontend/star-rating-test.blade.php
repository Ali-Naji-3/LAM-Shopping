<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Activated Star Rating System</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <style>
        body { padding: 20px; background: #f8f9fa; }
        .card { margin-bottom: 20px; }
        .rating { display: flex; align-items: center; gap: 2px; margin-bottom: 0; }
        .icon-star { font-style: normal; color: #ddd; transition: all 0.2s ease; }
        .icon-star.voted { color: #ffc107; }
        .rating em { margin-left: 8px; color: #666; font-size: 0.9em; font-style: normal; }
        .rating-interactive .icon-star { cursor: pointer; }
        .rating-interactive .icon-star:hover { color: #ffc107; transform: scale(1.1); }
        .rating-interactive .icon-star:hover ~ .icon-star { color: #ddd; }
    </style>
</head>
<body>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-10">
                <h1 class="text-center mb-4">🌟 Activated Star Rating System</h1>
                <p class="text-center text-muted mb-5">Dynamic star ratings with real data from the database</p>
                
                <!-- Static Star Ratings -->
                <div class="card">
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
                <div class="card">
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
                
                <!-- Dynamic Data from Database -->
                <div class="card">
                    <div class="card-header">
                        <h3>Dynamic Data from Database</h3>
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
                                <div class="review-item mb-3 p-3 border rounded bg-light">
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
                
                <!-- Usage Instructions -->
                <div class="card">
                    <div class="card-header">
                        <h3>How to Use</h3>
                    </div>
                    <div class="card-body">
                        <h5>HTML Structure:</h5>
                        <pre><code>&lt;span class="rating" data-rating="4" data-review-count="10"&gt;
    &lt;i class="icon-star"&gt;&lt;/i&gt;
    &lt;i class="icon-star"&gt;&lt;/i&gt;
    &lt;i class="icon-star"&gt;&lt;/i&gt;
    &lt;i class="icon-star"&gt;&lt;/i&gt;
    &lt;i class="icon-star"&gt;&lt;/i&gt;
    &lt;em&gt;0 reviews&lt;/em&gt;
&lt;/span&gt;</code></pre>
                        
                        <h5>For Interactive Ratings:</h5>
                        <pre><code>&lt;span class="rating rating-interactive" data-rating="0" data-review-count="0"&gt;
    &lt;i class="icon-star"&gt;&lt;/i&gt;
    &lt;i class="icon-star"&gt;&lt;/i&gt;
    &lt;i class="icon-star"&gt;&lt;/i&gt;
    &lt;i class="icon-star"&gt;&lt;/i&gt;
    &lt;i class="icon-star"&gt;&lt;/i&gt;
    &lt;em&gt;0 reviews&lt;/em&gt;
&lt;/span&gt;</code></pre>
                        
                        <div class="alert alert-info mt-3">
                            <strong>Note:</strong> The star rating system is now activated and will automatically:
                            <ul class="mb-0 mt-2">
                                <li>Display the correct number of filled stars based on the rating</li>
                                <li>Show the review count dynamically</li>
                                <li>Handle interactive ratings with hover effects</li>
                                <li>Work with real data from the database</li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="{{ asset('js/star-rating.js') }}"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            console.log('🌟 Star Rating System Activated!');
            console.log('Static ratings will be automatically updated with data-rating attribute');
            console.log('Interactive ratings are ready for user interaction');
        });
    </script>
</body>
</html>
