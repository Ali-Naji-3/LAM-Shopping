<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Review;
use App\Models\Product;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;

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

        // Get reCAPTCHA site key
        $recaptchaSiteKey = env('RECAPTCHA_SITE_KEY');

        return view('frontend.leave-review', compact('product', 'products', 'recaptchaSiteKey'));
    }

    public function register(Request $request)
    {
        $response = Http::asForm()->post('https://www.google.com/recaptcha/api/siteverify', [
            'secret'   => env('RECAPTCHA_SECRET_KEY'),
            'response' => $request->input('g-recaptcha-response'),
            'remoteip' => $request->ip(),
        ]);
    
        $result = $response->json();
    
        if (!($result['success'] ?? false)) {
            return back()->withErrors(['captcha' => 'Please confirm you are not a robot.']);
        }
    
        // ✅ Captcha verified, continue with registration logic
    }
    /**
     * Store a new review.
     */
    public function store(Request $request)
    {
        // Verify reCAPTCHA
        $response = Http::asForm()->post('https://www.google.com/recaptcha/api/siteverify', [
            'secret'   => env('RECAPTCHA_SECRET_KEY'),
            'response' => $request->input('g-recaptcha-response'),
            'remoteip' => $request->ip(),
        ]);

        $result = $response->json();

        if (!($result['success'] ?? false)) {
            return back()->withErrors(['captcha' => 'Please confirm you are not a robot.']);
        }

        // ✅ Captcha verified, continue with review logic
        
        try {
            // Log incoming request
            \Log::info('📝 Review submission received', [
                'product_id' => $request->product_id,
                'rating' => $request->rating,
                'has_title' => !empty($request->title),
                'has_comment' => !empty($request->comment),
                'user_id' => Auth::id(),
            ]);

            // Validate the request
            $validated = $request->validate([
                'product_id' => 'required|exists:products,id',
                'rating' => 'required|integer|min:1|max:5',
                'title' => 'nullable|string|max:255',
                'comment' => 'required|string|max:2000',
            ]);

            \Log::info('✅ Validation passed');

            // Check if user is authenticated
            if (!Auth::check()) {
                return redirect()->back()
                    ->withInput()
                    ->with('error', 'You must be logged in to submit a review.');
            }
            
            $user = Auth::user();
            \Log::info('👤 Using authenticated user', [
                'user_id' => $user->id,
                'user_name' => $user->name,
                'user_email' => $user->email
            ]);

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

            \Log::info('✅ Review created successfully!', [
                'review_id' => $review->id,
                'product_id' => $review->product_id,
                'user_id' => $review->user_id,
                'rating' => $review->rating,
                'is_approved' => $review->is_approved
            ]);

            return redirect()->route('frontend.leave-review')
                ->with('success', 'Thank you for your review! It will be reviewed and published soon. (Review ID: ' . $review->id . ')');

        } catch (\Illuminate\Validation\ValidationException $e) {
            \Log::error('❌ Validation failed', ['errors' => $e->errors()]);
            return redirect()->back()
                ->withErrors($e->errors())
                ->withInput()
                ->with('error', 'Please check the form and try again.');
        } catch (\Exception $e) {
            \Log::error('❌ Review creation failed', [
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);
            return redirect()->back()
                ->withInput()
                ->with('error', 'There was an error submitting your review. Please try again. Error: ' . $e->getMessage());
        }
    }
}
