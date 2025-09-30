<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Review;
use App\Models\Product;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ReviewController extends Controller
{
    /**
     * Show the review form.
     */
    public function show($productId = null)
    {
        $product = null;
        
        if ($productId) {
            $product = Product::with(['category', 'brand'])->find($productId);
            if (!$product) {
                return redirect()->route('frontend.leave-review')->with('error', 'Product not found.');
            }
        }

        // Get some sample products if no specific product is selected
        $products = Product::with(['category', 'brand'])->limit(10)->get();

        return view('frontend.leave-review', compact('product', 'products'));
    }

    /**
     * Store a new review.
     */
    public function store(Request $request)
    {
        try {
            // Validate the request
            $validated = $request->validate([
                'product_id' => 'required|exists:products,id',
                'rating' => 'required|integer|min:1|max:5',
                'title' => 'nullable|string|max:255',
                'comment' => 'required|string|max:2000',
                'name' => 'required|string|max:255',
                'email' => 'required|email|max:255',
            ]);

            // Check if user is authenticated or create/get user
            $user = null;
            if (Auth::check()) {
                $user = Auth::user();
            } else {
                // For guest users, try to find existing user by email or create new one
                $user = User::where('email', $validated['email'])->first();
                
                if (!$user) {
                    // Create a guest user account
                    $user = User::create([
                        'name' => $validated['name'],
                        'email' => $validated['email'],
                        'password' => bcrypt('guest_password'), // Temporary password
                        'u_type' => 'USR', // Regular user
                        'email_verified_at' => null,
                    ]);
                }
            }

            // Create the review
            $review = Review::create([
                'user_id' => $user->id,
                'product_id' => $validated['product_id'],
                'rating' => $validated['rating'],
                'title' => $validated['title'],
                'comment' => $validated['comment'],
                'is_approved' => false, // Reviews need approval by default
                'would_recommend' => true,
            ]);

            return redirect()->route('frontend.leave-review')
                ->with('success', 'Thank you for your review! It will be reviewed and published soon.');

        } catch (\Illuminate\Validation\ValidationException $e) {
            throw $e;
        } catch (\Exception $e) {
            \Log::error('Review creation failed: ' . $e->getMessage());
            return redirect()->back()->with('error', 'There was an error submitting your review. Please try again.');
        }
    }
}
