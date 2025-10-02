<?php

namespace App\Http\Controllers\Frontend;

use App\Models\Brand;
use App\Models\Product;
use App\Models\Setting;
use App\Models\Category;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class FunctionController extends Controller
{
    /**
     * Boys Collection
     */
    public function index()
{

    $setting = Setting::first();
    return view('frontend.index-2', compact('setting'));
}

    public function listingGrid2Full()
    {
        $products = Product::active()
            ->whereHas('category', function ($q) {
                $q->where('name', 'Boys')
                    ->orWhere('parent_id', function ($subQuery) {
                        $subQuery->select('id')
                            ->from('categories')
                            ->where('name', 'Boys');
                    });
            })
            ->with(['category', 'brand'])
            ->orderBy('featured', 'desc')
            ->orderBy('created_at', 'desc')
            ->paginate(12);

        $categories = Category::active()->rootCategories()->ordered()->get();
        $brands = Brand::active()->get();

        return view('frontend.listing-grid-2-full', compact('products', 'categories', 'brands'));
    }

    /**
     * Listing with sidebar (static view)
     */
    /**
     * Women Collection (with subcategories)
     */
    public function listingGrid1Full()
    {
        $womenCategory = Category::where('name', 'Women')->first();
        if (!$womenCategory)
            abort(404, 'Category not found');

        $categoryIds = [$womenCategory->id];
        $subcategories = Category::where('parent_id', $womenCategory->id)->pluck('id');
        $categoryIds = array_merge($categoryIds, $subcategories->toArray());

        $products = Product::active()
            ->whereIn('category_id', $categoryIds)
            ->with(['category', 'brand'])
            ->orderBy('featured', 'desc')
            ->orderBy('created_at', 'desc')
            ->paginate(12);

        $categories = Category::active()->rootCategories()->ordered()->get();
        $brands = Brand::active()->get();

        return view('frontend.listing-grid-1-full', compact('products', 'categories', 'brands'));
    }

    /**
     * Men Collection (with subcategories)
     */
    public function listingGrid3()
    {
        $menCategory = Category::where('name', 'Men')->first();
        if (!$menCategory)
            abort(404, 'Men category not found');

        $categoryIds = [$menCategory->id];
        $subcategories = Category::where('parent_id', $menCategory->id)->pluck('id');
        $categoryIds = array_merge($categoryIds, $subcategories->toArray());

        $products = Product::active()
            ->whereIn('category_id', $categoryIds)
            ->with(['category', 'brand'])
            ->orderBy('featured', 'desc')
            ->orderBy('created_at', 'desc')
            ->paginate(12);

        $categories = Category::active()->rootCategories()->ordered()->get();
        $brands = Brand::active()->get();

        return view('frontend.listing-grid-3', compact('products', 'categories', 'brands'));
    }

    /**
     * Girls Collection
     */
    public function girls()
    {
        $products = Product::active()
            ->whereHas('category', function ($q) {
                $q->where('name', 'Girls')
                    ->orWhere('parent_id', function ($subQuery) {
                        $subQuery->select('id')
                            ->from('categories')
                            ->where('name', 'Girls');
                    });
            })
            ->with(['category', 'brand'])
            ->orderBy('featured', 'desc')
            ->orderBy('created_at', 'desc')
            ->paginate(12);

        $categories = Category::active()->rootCategories()->ordered()->get();
        $brands = Brand::active()->get();

        return view('frontend.girls', compact('products', 'categories', 'brands'));
    }

    /**
     * Simple pages
     */
    public function productDetail2()
    {
        return view('frontend.product-detail-2');
    }
    public function cart()
    {
        return view('frontend.cart');
    }
    public function checkout()
    {
        return view('frontend.checkout');
    }
    public function confirm()
    {
        return view('frontend.confirm');
    }
    public function account()
    {
        return view('frontend.account');
    }
    public function trackOrder()
    {
        return view('frontend.track-order');
    }
    public function help()
    {
        return view('frontend.help');
    }
    public function myOrders()
    {
        return view('frontend.my-orders');
    }
    public function profilePage()
    {
        return view('frontend.profile-page');
    }
    public function myWishlist()
    {
        return view('frontend.my-wishlist');
    }
}

