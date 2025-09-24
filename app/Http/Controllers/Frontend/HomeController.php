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
            ->with(['category', 'brand', 'reviews.user', 'productAttributes.attributeValue.attribute'])
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

    public function categoryPage(Request $request, $slug = null)
    {
        // Determine category based on route
        $categorySlug = $slug ?? $request->route()->getName();
        
        // Map route names to category slugs
        $routeToSlug = [
            'category.men' => 'men',
            'category.women' => 'women', 
            'category.body' => 'body',
            'category.girl' => 'girl'
        ];
        
        $categorySlug = $routeToSlug[$categorySlug] ?? $categorySlug;
        
        // Find the category
        $category = Category::active()
            ->where('slug', $categorySlug)
            ->with(['children', 'parent'])
            ->firstOrFail();

        // Get products for this category and its subcategories
        $categoryIds = collect([$category->id]);
        if ($category->children->isNotEmpty()) {
            $categoryIds = $categoryIds->merge($category->children->pluck('id'));
        }

        $query = Product::active()
            ->inStock()
            ->whereIn('category_id', $categoryIds)
            ->with(['category', 'brand', 'reviews']);

        // Apply filters
        if ($request->has('brand')) {
            $query->whereHas('brand', function($q) use ($request) {
                $q->where('slug', $request->brand);
            });
        }

        if ($request->has('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('description', 'like', "%{$search}%");
            });
        }

        // Sort products
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
        
        // Get related data
        $categories = Category::active()->rootCategories()->ordered()->get();
        $brands = Brand::active()->get();
        
        // Get subcategories for this category
        $subcategories = $category->children()->active()->ordered()->get();

        return view('category-page', compact(
            'category', 
            'products', 
            'categories', 
            'brands', 
            'subcategories'
        ));
    }
}
