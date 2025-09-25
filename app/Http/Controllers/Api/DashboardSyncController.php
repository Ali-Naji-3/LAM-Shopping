<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Product;
use App\Models\Brand;
use App\Models\Slider;
use App\Models\Review;
use Illuminate\Http\Request;

class DashboardSyncController extends Controller
{
    /**
     * Get homepage data from dashboard
     */
    public function getHomepageData()
    {
        $data = [
            'sliders' => Slider::where('is_active', true)
                ->where(function($query) {
                    $query->whereNull('start_date')
                          ->orWhere('start_date', '<=', now()->toDateString());
                })
                ->where(function($query) {
                    $query->whereNull('end_date')
                          ->orWhere('end_date', '>=', now()->toDateString());
                })
                ->orderBy('order')
                ->get(),
                
            'featured_products' => Product::where('featured', true)
                ->where('status', 'active')
                ->with(['category', 'brand'])
                ->take(8)
                ->get(),
                
            'categories_grid' => [
                'collections' => [
                    'name' => 'Collections',
                    'products_count' => Product::where('featured', true)->where('status', 'active')->count(),
                    'url' => url('collections'),
                    'image' => 'img/img_cat_home_1.jpg'
                ],
                'women' => [
                    'name' => 'Women',
                    'products_count' => Product::whereHas('category', function($q) {
                        $q->where('name', 'LIKE', 'Women%')->orWhereHas('parent', function($subq) {
                            $subq->where('name', 'Women');
                        });
                    })->where('status', 'active')->count(),
                    'url' => url('listing-grid-1-full'),
                    'image' => 'img/img_cat_home_2.jpg'
                ],
                'boys' => [
                    'name' => 'Boys',
                    'products_count' => Product::whereHas('category', function($q) {
                        $q->where('name', 'LIKE', 'Boys%')->orWhereHas('parent', function($subq) {
                            $subq->where('name', 'Boys');
                        });
                    })->where('status', 'active')->count(),
                    'url' => url('listing-grid-2-full'),
                    'image' => 'img/img_cat_home_3.jpg'
                ],
                'training' => [
                    'name' => 'Training',
                    'products_count' => Product::whereHas('category', function($q) {
                        $q->where('name', 'LIKE', '%Training%');
                    })->where('status', 'active')->count(),
                    'url' => url('listing-grid-7-sidebar-right'),
                    'image' => 'img/img_cat_home_4.jpg'
                ]
            ],
            
            'brands' => Brand::where('is_active', true)
                ->withCount(['products' => function($q) {
                    $q->where('status', 'active');
                }])
                ->orderBy('products_count', 'desc')
                ->take(6)
                ->get(),
                
            'statistics' => [
                'total_products' => Product::where('status', 'active')->count(),
                'total_categories' => Category::where('is_active', true)->count(),
                'total_brands' => Brand::where('is_active', true)->count(),
                'featured_products' => Product::where('featured', true)->where('status', 'active')->count(),
            ]
        ];

        return response()->json($data);
    }

    /**
     * Get products by gender for frontend
     */
    public function getProductsByGender($gender, Request $request)
    {
        $query = Product::with(['category', 'brand', 'reviews' => function($q) {
            $q->where('is_approved', true);
        }])
        ->where('status', 'active')
        ->whereHas('category', function($q) use ($gender) {
            $q->where('name', 'LIKE', "{$gender}%")
              ->orWhereHas('parent', function($subq) use ($gender) {
                  $subq->where('name', $gender);
              });
        });

        // Apply filters
        if ($request->filled('category')) {
            $query->whereHas('category', function($q) use ($request) {
                $q->where('slug', $request->get('category'));
            });
        }

        if ($request->filled('brand')) {
            $query->whereHas('brand', function($q) use ($request) {
                $q->where('slug', $request->get('brand'));
            });
        }

        if ($request->filled('min_price')) {
            $query->where('regular_price', '>=', $request->get('min_price'));
        }

        if ($request->filled('max_price')) {
            $query->where('regular_price', '<=', $request->get('max_price'));
        }

        if ($request->filled('sort')) {
            switch ($request->get('sort')) {
                case 'price_low':
                    $query->orderBy('regular_price', 'asc');
                    break;
                case 'price_high':
                    $query->orderBy('regular_price', 'desc');
                    break;
                case 'newest':
                    $query->orderBy('created_at', 'desc');
                    break;
                case 'featured':
                    $query->orderBy('featured', 'desc');
                    break;
                default:
                    $query->orderBy('name', 'asc');
            }
        } else {
            $query->orderBy('featured', 'desc')->orderBy('name', 'asc');
        }

        $products = $query->paginate($request->get('per_page', 12));

        return response()->json($products);
    }

    /**
     * Get product details for frontend
     */
    public function getProductDetails($slug)
    {
        $product = Product::where('slug', $slug)
            ->where('status', 'active')
            ->with([
                'category.parent',
                'brand',
                'reviews' => function($q) {
                    $q->where('is_approved', true)->with('user')->orderBy('created_at', 'desc');
                },
                'productAttributes.attributeValue.attribute'
            ])
            ->first();

        if (!$product) {
            return response()->json(['error' => 'Product not found'], 404);
        }

        // Get related products
        $relatedProducts = Product::where('status', 'active')
            ->where('id', '!=', $product->id)
            ->where(function($q) use ($product) {
                $q->where('category_id', $product->category_id)
                  ->orWhere('brand_id', $product->brand_id);
            })
            ->with(['category', 'brand'])
            ->take(4)
            ->get();

        // Get product attributes grouped by attribute type
        $attributes = $product->productAttributes()
            ->with('attributeValue.attribute')
            ->get()
            ->groupBy('attributeValue.attribute.name');

        // Get inventory status
        $totalStock = $product->inventory()->sum('quantity');
        $stockStatus = $totalStock > 0 ? 'in_stock' : 'out_of_stock';

        return response()->json([
            'product' => $product,
            'related_products' => $relatedProducts,
            'attributes' => $attributes,
            'stock_status' => $stockStatus,
            'total_stock' => $totalStock,
            'breadcrumbs' => [
                ['name' => 'Home', 'url' => url('/')],
                ['name' => $product->category->parent->name ?? 'Category', 'url' => url('/' . strtolower($product->category->parent->name ?? 'category'))],
                ['name' => $product->category->name, 'url' => url('/' . $product->category->slug)],
                ['name' => $product->name, 'url' => null]
            ]
        ]);
    }

    /**
     * Get categories by gender for frontend navigation
     */
    public function getCategoriesByGender($gender)
    {
        $genderCategory = Category::where('name', $gender)->first();
        
        if (!$genderCategory) {
            return response()->json(['error' => 'Gender category not found'], 404);
        }

        $categories = $genderCategory->children()
            ->where('is_active', true)
            ->withCount(['products' => function($q) {
                $q->where('status', 'active');
            }])
            ->orderBy('order')
            ->get();

        return response()->json([
            'gender_category' => $genderCategory,
            'subcategories' => $categories,
            'total_products' => $categories->sum('products_count')
        ]);
    }

    /**
     * Search products across all categories
     */
    public function searchProducts(Request $request)
    {
        $query = Product::with(['category', 'brand'])
            ->where('status', 'active');

        if ($request->filled('q')) {
            $search = $request->get('q');
            $query->where(function($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('description', 'like', "%{$search}%")
                  ->orWhere('sku', 'like', "%{$search}%")
                  ->orWhereHas('brand', function($subq) use ($search) {
                      $subq->where('name', 'like', "%{$search}%");
                  })
                  ->orWhereHas('category', function($subq) use ($search) {
                      $subq->where('name', 'like', "%{$search}%");
                  });
            });
        }

        $products = $query->orderBy('featured', 'desc')
            ->orderBy('name', 'asc')
            ->paginate($request->get('per_page', 20));

        return response()->json($products);
    }

    /**
     * Get active sliders for frontend
     */
    public function getActiveSliders()
    {
        $sliders = Slider::where('is_active', true)
            ->where(function($query) {
                $query->whereNull('start_date')
                      ->orWhere('start_date', '<=', now()->toDateString());
            })
            ->where(function($query) {
                $query->whereNull('end_date')
                      ->orWhere('end_date', '>=', now()->toDateString());
            })
            ->orderBy('order')
            ->get();

        return response()->json($sliders);
    }
}
