<?php

namespace App\Http\Controllers\Frontend;
use App\Http\Controllers\Controller;

use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Category;
use App\Models\Brand;

class FunctionController extends Controller
{
    public function listingGrid2Full()
    {
        $products = Product::active()
            ->whereHas('category', fn($q) => $q->where('name', 'boy'))
            ->with(['category', 'brand'])
            ->orderBy('featured', 'desc')
            ->orderBy('created_at', 'desc')
            ->paginate(12);

        $categories = Category::active()->rootCategories()->ordered()->get();
        $brands = Brand::active()->get();

        return view('frontend.listing-grid-2-full', compact('products', 'categories', 'brands'));
    }

    public function listingGrid7SidebarRight()
    {
        return view('frontend.listing-grid-7-sidebar-right');
    }

    public function listingGrid1Full()
    {
        $womenCategory = Category::where('name', 'Women')->first();

        if (!$womenCategory) abort(404, 'Category not found');

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

    public function listingGrid3()
    {
        $menCategory = Category::where('name', 'Men')->first();

        if (!$menCategory) abort(404, 'Men category not found');

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

    public function girls()
    {
        $products = Product::active()
            ->whereHas('category', fn($q) => $q->where('name', 'Girl'))
            ->with(['category', 'brand'])
            ->orderBy('featured', 'desc')
            ->orderBy('created_at', 'desc')
            ->paginate(12);

        $categories = Category::active()->rootCategories()->ordered()->get();
        $brands = Brand::active()->get();

        return view('frontend.girls', compact('products', 'categories', 'brands'));
    }

    // Simple views
    public function productDetail2() { return view('frontend.product-detail-2'); }
    public function cart() { return view('frontend.cart'); }
    public function checkout() { return view('frontend.checkout'); }
    public function confirm() { return view('frontend.confirm'); }
    public function account() { return view('frontend.account'); }
    public function trackOrder() { return view('frontend.track-order'); }
    public function help() { return view('frontend.help'); }
    public function leaveReview() { return view('frontend.leave-review'); }
    public function myOrders() { return view('frontend.my-orders'); }
    public function profilePage() { return view('frontend.profile-page'); }
    public function myWishlist() { return view('frontend.my-wishlist'); }
}
