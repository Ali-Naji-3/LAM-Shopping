<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\Category;
use Illuminate\Http\Request;

class ListingController extends Controller
{
    /**
     * Display Men's Collection (listing-grid-3-full)
     */
    public function mensCollection(Request $request)
    {
        return $this->displayCollection('Men', 'listing-grid-3-full', $request);
    }

    /**
     * Display Women's Collection (listing-grid-1-full)
     */
    public function womensCollection(Request $request)
    {
        return $this->displayCollection('Women', 'listing-grid-1-full', $request);
    }

    /**
     * Display Boys' Collection (listing-grid-2-full)
     */
    public function boysCollection(Request $request)
    {
        return $this->displayCollection('Boys', 'listing-grid-2-full', $request);
    }

    /**
     * Display Girls' Collection (girls)
     */
    public function girlsCollection(Request $request)
    {
        return $this->displayCollection('Girls', 'girls', $request);
    }

    /**
     * Display Home Page (Collections)
     */
    public function homePage(Request $request)
    {
        // Get all active products for home page
        $products = Product::active()
            ->with(['category', 'brand'])
            ->orderBy('featured', 'desc')
            ->orderBy('created_at', 'desc')
            ->paginate(12);

        $category = Category::where('name', 'Collections')->first();
        
        return view('index', compact('products', 'category'));
    }

    /**
     * Generic method to display collection pages
     */
    private function displayCollection($categoryName, $viewName, Request $request)
    {
        // Get products for the specific category (simplified query)
        $products = Product::active()
            ->whereHas('category', function ($q) use ($categoryName) {
                $q->where('name', $categoryName);
            })
            ->with(['category', 'brand'])
            ->orderBy('featured', 'desc')
            ->orderBy('created_at', 'desc')
            ->paginate(12);

        // Get the root category
        $category = Category::where('name', $categoryName)->first();

        // Handle sorting
        if ($request->has('sort')) {
            $sort = $request->get('sort');
            switch ($sort) {
                case 'price':
                    $products = $products->appends($request->query())->sortBy('effective_price');
                    break;
                case 'price-desc':
                    $products = $products->appends($request->query())->sortByDesc('effective_price');
                    break;
                case 'date':
                    $products = $products->appends($request->query())->sortByDesc('created_at');
                    break;
                case 'rating':
                    $products = $products->appends($request->query())->sortByDesc('average_rating');
                    break;
                default: // popularity
                    $products = $products->appends($request->query())->sortByDesc('featured');
                    break;
            }
        }

        // Handle filtering by subcategory
        if ($request->has('subcategory')) {
            $subcategoryId = $request->get('subcategory');
            $products = $products->where('category_id', $subcategoryId);
        }

        return view($viewName, compact('products', 'category'));
    }

    /**
     * Display a specific category page
     */
    public function categoryPage($slug, Request $request)
    {
        $category = Category::where('slug', $slug)->firstOrFail();
        
        // Get products for this category and its subcategories
        $products = Product::active()
            ->byCategoryHierarchy($category->name)
            ->with(['category', 'brand'])
            ->orderBy('featured', 'desc')
            ->orderBy('created_at', 'desc')
            ->paginate(12);

        // Handle sorting
        if ($request->has('sort')) {
            $sort = $request->get('sort');
            switch ($sort) {
                case 'price':
                    $products = $products->appends($request->query())->sortBy('effective_price');
                    break;
                case 'price-desc':
                    $products = $products->appends($request->query())->sortByDesc('effective_price');
                    break;
                case 'date':
                    $products = $products->appends($request->query())->sortByDesc('created_at');
                    break;
                case 'rating':
                    $products = $products->appends($request->query())->sortByDesc('average_rating');
                    break;
                default: // popularity
                    $products = $products->appends($request->query())->sortByDesc('featured');
                    break;
            }
        }

        return view('category-page', compact('products', 'category'));
    }
}
