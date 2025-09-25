<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Review;
use App\Models\Product;
use App\Models\User;
use Illuminate\Http\Request;

class ReviewsController extends Controller
{
    /**
     * Helper method to safely count records and handle missing tables
     */
    private function safeCount(callable $callback)
    {
        try {
            return $callback();
        } catch (\Illuminate\Database\QueryException $e) {
            if (str_contains($e->getMessage(), "doesn't exist")) {
                return 0;
            }
            throw $e;
        }
    }

    /**
     * Display a listing of all reviews.
     */
    public function index(Request $request)
    {
        $query = Review::with(['product', 'user']);

        // Search functionality
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('title', 'like', "%{$search}%")
                  ->orWhere('comment', 'like', "%{$search}%")
                  ->orWhereHas('product', function($subQ) use ($search) {
                      $subQ->where('name', 'like', "%{$search}%");
                  })
                  ->orWhereHas('user', function($subQ) use ($search) {
                      $subQ->where('name', 'like', "%{$search}%")
                           ->orWhere('email', 'like', "%{$search}%");
                  });
            });
        }

        // Filter by approval status
        if ($request->filled('status')) {
            $status = $request->status;
            if ($status === 'approved') {
                $query->where('is_approved', true);
            } elseif ($status === 'pending') {
                $query->where('is_approved', false);
            }
        }

        // Filter by rating
        if ($request->filled('rating')) {
            $query->where('rating', $request->rating);
        }

        // Filter by product
        if ($request->filled('product_id')) {
            $query->where('product_id', $request->product_id);
        }

        $reviews = $query->orderBy('created_at', 'desc')->paginate(20);

        // Get filter options
        $products = Product::orderBy('name')->get();

        // Calculate statistics
        $statistics = [
            'total_reviews' => Review::count(),
            'approved_reviews' => Review::where('is_approved', true)->count(),
            'pending_reviews' => Review::where('is_approved', false)->count(),
            'average_rating' => Review::where('is_approved', true)->avg('rating') ?? 0,
            'five_star_reviews' => Review::where('is_approved', true)->where('rating', 5)->count(),
            'one_star_reviews' => Review::where('is_approved', true)->where('rating', 1)->count(),
        ];

        return view('admin.reviews.index', compact('reviews', 'products', 'statistics'));
    }

    /**
     * Show the form for creating a new review.
     */
    public function create()
    {
        $products = Product::orderBy('name')->get();
        $users = User::orderBy('name')->get();
        
        return view('admin.reviews.create', compact('products', 'users'));
    }

    /**
     * Store a newly created review.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'user_id' => 'required|exists:users,id',
            'product_id' => 'required|exists:products,id',
            'rating' => 'required|integer|min:1|max:5',
            'title' => 'nullable|string|max:255',
            'comment' => 'nullable|string|max:2000',
            'is_approved' => 'boolean',
        ]);

        // Set default approval status
        $validated['is_approved'] = $validated['is_approved'] ?? false;

        Review::create($validated);

        return redirect()->route('admin.reviews.index')
            ->with('success', 'Review created successfully!');
    }

    /**
     * Display the specified review.
     */
    public function show(Review $review)
    {
        $review->load(['product.category', 'product.brand', 'user']);
        
        // Get related reviews for the same product
        $relatedReviews = Review::where('product_id', $review->product_id)
            ->where('id', '!=', $review->id)
            ->where('is_approved', true)
            ->with(['user'])
            ->orderBy('rating', 'desc')
            ->limit(5)
            ->get();

        // Get other reviews by the same user
        $userReviews = Review::where('user_id', $review->user_id)
            ->where('id', '!=', $review->id)
            ->with(['product'])
            ->orderBy('created_at', 'desc')
            ->limit(5)
            ->get();

        return view('admin.reviews.show', compact('review', 'relatedReviews', 'userReviews'));
    }

    /**
     * Show the form for editing the specified review.
     */
    public function edit(Review $review)
    {
        $review->load(['product', 'user']);
        $products = Product::orderBy('name')->get();
        $users = User::orderBy('name')->get();
        
        return view('admin.reviews.edit', compact('review', 'products', 'users'));
    }

    /**
     * Update the specified review.
     */
    public function update(Request $request, Review $review)
    {
        $validated = $request->validate([
            'user_id' => 'required|exists:users,id',
            'product_id' => 'required|exists:products,id',
            'rating' => 'required|integer|min:1|max:5',
            'title' => 'nullable|string|max:255',
            'comment' => 'nullable|string|max:2000',
            'is_approved' => 'boolean',
        ]);

        $review->update($validated);

        return redirect()->route('admin.reviews.index')
            ->with('success', 'Review updated successfully!');
    }

    /**
     * Remove the specified review.
     */
    public function destroy(Review $review)
    {
        $review->delete();

        return redirect()->route('admin.reviews.index')
            ->with('success', 'Review deleted successfully!');
    }

    /**
     * Handle bulk actions for reviews.
     */
    public function bulkActions(Request $request)
    {
        $request->validate([
            'action' => 'required|in:approve,reject,delete',
            'selected_reviews' => 'required|array|min:1',
            'selected_reviews.*' => 'exists:reviews,id'
        ]);

        $reviews = Review::whereIn('id', $request->selected_reviews);

        switch ($request->action) {
            case 'approve':
                $reviews->update(['is_approved' => true]);
                return redirect()->back()->with('success', 'Selected reviews approved successfully!');
                
            case 'reject':
                $reviews->update(['is_approved' => false]);
                return redirect()->back()->with('success', 'Selected reviews rejected successfully!');
                
            case 'delete':
                $reviews->delete();
                return redirect()->back()->with('success', 'Selected reviews deleted successfully!');
        }
    }

    /**
     * Toggle review approval status.
     */
    public function toggleApproval(Review $review)
    {
        $review->update(['is_approved' => !$review->is_approved]);
        
        $status = $review->is_approved ? 'approved' : 'rejected';
        return redirect()->back()->with('success', "Review {$status} successfully!");
    }

    /**
     * Show reviews for a specific product.
     */
    public function productReviews(Product $product)
    {
        $reviews = Review::where('product_id', $product->id)
            ->with(['user'])
            ->orderBy('created_at', 'desc')
            ->paginate(15);

        $reviewStats = [
            'total_reviews' => $reviews->total(),
            'approved_reviews' => Review::where('product_id', $product->id)->where('is_approved', true)->count(),
            'average_rating' => Review::where('product_id', $product->id)->where('is_approved', true)->avg('rating') ?? 0,
            'rating_distribution' => []
        ];

        // Calculate rating distribution
        for ($i = 1; $i <= 5; $i++) {
            $reviewStats['rating_distribution'][$i] = Review::where('product_id', $product->id)
                ->where('is_approved', true)
                ->where('rating', $i)
                ->count();
        }

        return view('admin.reviews.product-reviews', compact('product', 'reviews', 'reviewStats'));
    }

    /**
     * Show reviews by a specific user.
     */
    public function userReviews(User $user)
    {
        $reviews = Review::where('user_id', $user->id)
            ->with(['product'])
            ->orderBy('created_at', 'desc')
            ->paginate(15);

        $userStats = [
            'total_reviews' => $reviews->total(),
            'approved_reviews' => Review::where('user_id', $user->id)->where('is_approved', true)->count(),
            'average_rating_given' => Review::where('user_id', $user->id)->avg('rating') ?? 0,
            'most_recent_review' => Review::where('user_id', $user->id)->latest()->first(),
        ];

        return view('admin.reviews.user-reviews', compact('user', 'reviews', 'userStats'));
    }

    /**
     * Show analytics dashboard for reviews.
     */
    public function analytics()
    {
        $analytics = [
            'total_reviews' => Review::count(),
            'approved_reviews' => Review::where('is_approved', true)->count(),
            'pending_reviews' => Review::where('is_approved', false)->count(),
            'approval_rate' => Review::count() > 0 ? round((Review::where('is_approved', true)->count() / Review::count()) * 100, 1) : 0,
            'average_rating' => Review::where('is_approved', true)->avg('rating') ?? 0,
            'rating_distribution' => [],
            'recent_reviews' => Review::with(['product', 'user'])->orderBy('created_at', 'desc')->limit(10)->get(),
            'top_rated_products' => $this->safeCount(function() {
                return Product::withAvg('reviews', 'rating')
                    ->whereHas('reviews', function($q) {
                        $q->where('is_approved', true);
                    })
                    ->orderBy('reviews_avg_rating', 'desc')
                    ->limit(10)
                    ->get();
            }),
            'most_active_reviewers' => $this->safeCount(function() {
                return User::withCount(['reviews' => function($q) {
                    $q->where('is_approved', true);
                }])
                ->orderBy('reviews_count', 'desc')
                ->limit(10)
                ->get();
            }),
        ];

        // Calculate rating distribution
        for ($i = 1; $i <= 5; $i++) {
            $analytics['rating_distribution'][$i] = Review::where('is_approved', true)
                ->where('rating', $i)
                ->count();
        }

        return view('admin.reviews.analytics', compact('analytics'));
    }
}