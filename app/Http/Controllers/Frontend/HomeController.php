<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\Category;
use App\Models\Brand;
use App\Models\Slider;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index()
    {
        // Get homepage data
        $featuredProducts = Product::active()
            ->featured()
            ->inStock()
            ->with(['category', 'brand', 'reviews'])
            ->limit(8)
            ->get();

        $latestProducts = Product::active()
            ->inStock()
            ->with(['category', 'brand', 'reviews'])
            ->latest()
            ->limit(8)
            ->get();

        $categories = Category::active()
            ->rootCategories()
            ->ordered()
            ->limit(6)
            ->get();

        $brands = Brand::active()
            ->limit(6)
            ->get();

        $sliders = Slider::active()
            ->where(function($query) {
                $query->whereNull('start_date')
                      ->orWhere('start_date', '<=', now());
            })
            ->where(function($query) {
                $query->whereNull('end_date')
                      ->orWhere('end_date', '>=', now());
            })
            ->ordered()
            ->get();

        return view('index-2', compact(
            'featuredProducts',
            'latestProducts', 
            'categories',
            'brands',
            'sliders'
        ));
    }

    public function products(Request $request)
    {
        $query = Product::active()->inStock()->with(['category', 'brand', 'reviews']);

        // Filter by category
        if ($request->has('category')) {
            $query->whereHas('category', function($q) use ($request) {
                $q->where('slug', $request->category);
            });
        }

        // Filter by brand
        if ($request->has('brand')) {
            $query->whereHas('brand', function($q) use ($request) {
                $q->where('slug', $request->brand);
            });
        }

        // Search
        if ($request->has('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('description', 'like', "%{$search}%")
                  ->orWhere('short_description', 'like', "%{$search}%");
            });
        }

        // Sort
        $sort = $request->get('sort', 'latest');
        switch ($sort) {
            case 'price_low':
                $query->orderByRaw('COALESCE(sale_price, regular_price) ASC');
                break;
            case 'price_high':
                $query->orderByRaw('COALESCE(sale_price, regular_price) DESC');
                break;
            case 'name':
                $query->orderBy('name');
                break;
            default:
                $query->latest();
        }

        $products = $query->paginate(12);
        $categories = Category::active()->rootCategories()->ordered()->get();
        $brands = Brand::active()->get();

        return view('listing-grid-2-full', compact('products', 'categories', 'brands'));
    }

    public function productDetail($slug)
    {
        $product = Product::active()
            ->where('slug', $slug)
            ->with(['category', 'brand', 'reviews.user', 'attributeValues.attribute'])
            ->firstOrFail();

        $relatedProducts = Product::active()
            ->inStock()
            ->where('category_id', $product->category_id)
            ->where('id', '!=', $product->id)
            ->with(['category', 'brand', 'reviews'])
            ->limit(4)
            ->get();

        return view('product-detail-2', compact('product', 'relatedProducts'));
    }
}
