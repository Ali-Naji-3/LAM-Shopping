<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\Category;
use App\Models\Brand;
use App\Models\Contact;
use App\Models\Review;
use App\Models\OrderItem;
use App\Models\Inventory;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;

class ProductController extends Controller
{
    /**
     * Helper method to safely count records and handle missing tables
     */
    private function safeCount(callable $callback)
    {
        try {
            return $callback();
        } catch (\Illuminate\Database\QueryException $e) {
            // If table doesn't exist, return 0
            if (str_contains($e->getMessage(), "doesn't exist")) {
                return 0;
            }
            throw $e;
        }
    }
    /**
     * Display a listing of products.
     */
    public function index(Request $request)
    {
        $query = Product::with(['category', 'brand']);

        // Search functionality
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('description', 'like', "%{$search}%")
                  ->orWhere('short_description', 'like', "%{$search}%")
                  ->orWhere('sku', 'like', "%{$search}%");
            });
        }

        // Status filter
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        // Category filter
        if ($request->filled('category_id')) {
            $query->where('category_id', $request->category_id);
        }

        // Brand filter
        if ($request->filled('brand_id')) {
            $query->where('brand_id', $request->brand_id);
        }

        // Featured filter
        if ($request->filled('featured')) {
            $query->where('featured', $request->featured === 'yes');
        }

        // Price range filter
        if ($request->filled('min_price')) {
            $query->where('regular_price', '>=', $request->min_price);
        }
        if ($request->filled('max_price')) {
            $query->where('regular_price', '<=', $request->max_price);
        }

        // Use safe counting for relationships that might not exist yet
        $products = $query->orderBy('created_at', 'desc')->paginate(12);
        
        // Add counts safely
        $products->getCollection()->transform(function ($product) {
            $product->reviews_count = $this->safeCount(function() use ($product) {
                return $product->reviews()->count();
            });
            $product->order_items_count = $this->safeCount(function() use ($product) {
                return $product->orderItems()->count();
            });
            return $product;
        });

        $categories = Category::active()->orderBy('name')->get();
        $brands = Brand::active()->orderBy('name')->get();

        return view('admin.products.index', compact('products', 'categories', 'brands'));
    }

    /**
     * Show the form for creating a new product.
     */
    public function create()
    {
        $categories = Category::active()->orderBy('name')->get();
        $brands = Brand::active()->orderBy('name')->get();
        
        return view('admin.products.create', compact('categories', 'brands'));
    }

    /**
     * Store a newly created product.
     */
    public function store(Request $request)
    {
        // Debug: Log the request data
        \Log::info('Product creation request received', [
            'method' => $request->method(),
            'data' => $request->all()
        ]);
        
        try {
            $validated = $request->validate([
            'name' => 'required|string|max:255',
            'slug' => 'nullable|string|max:255|unique:products,slug',
            'sku' => 'required|string|max:255|unique:products,sku',
            'short_description' => 'nullable|string|max:500',
            'description' => 'nullable|string',
            'regular_price' => 'required|numeric|min:0',
            'sale_price' => 'nullable|numeric|min:0',
            'quantity' => 'required|integer|min:0',
            'category_id' => 'required|exists:categories,id',
            'brand_id' => 'required|exists:brands,id',
            'status' => 'required|in:active,inactive,draft',
            'featured' => 'boolean',
            'weight' => 'nullable|numeric|min:0',
            'dimensions' => 'nullable|array',
            'dimensions.length' => 'nullable|numeric|min:0',
            'dimensions.width' => 'nullable|numeric|min:0',
            'dimensions.height' => 'nullable|numeric|min:0',
            'meta_title' => 'nullable|string|max:255',
            'meta_description' => 'nullable|string|max:500',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'images' => 'nullable|array',
            'images.*' => 'image|mimes:jpeg,png,jpg,gif|max:2048'
        ]);

        // Generate slug if not provided
        if (empty($validated['slug'])) {
            $validated['slug'] = Str::slug($validated['name']);
        }
        
        // Ensure slug uniqueness
        $originalSlug = $validated['slug'];
        $counter = 1;
        while (Product::where('slug', $validated['slug'])->exists()) {
            $validated['slug'] = $originalSlug . '-' . $counter;
            $counter++;
        }

        // Handle dimensions
        if (isset($validated['dimensions'])) {
            $validated['dimensions'] = array_filter($validated['dimensions']);
        }

        // Handle main image upload
        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $filename = time() . '_' . Str::random(10) . '.' . $image->getClientOriginalExtension();
            $path = $image->storeAs('products', $filename, 'public');
            $validated['image'] = $path;
        }

        // Handle multiple images upload
        $imagesPaths = [];
        if ($request->hasFile('images')) {
            foreach ($request->file('images') as $image) {
                $filename = time() . '_' . Str::random(10) . '.' . $image->getClientOriginalExtension();
                $path = $image->storeAs('products/gallery', $filename, 'public');
                $imagesPaths[] = $path;
            }
            $validated['images'] = $imagesPaths;
        }

            $product = Product::create($validated);

            return redirect()->route('admin.products.index')
                ->with('success', "Product '{$product->name}' created successfully!");
                
        } catch (\Illuminate\Validation\ValidationException $e) {
            \Log::error('Validation failed', [
                'errors' => $e->errors(),
                'request_data' => $request->all()
            ]);
            
            return redirect()->back()
                ->withErrors($e->errors())
                ->withInput();
        } catch (\Exception $e) {
            \Log::error('Product creation failed', [
                'error' => $e->getMessage(),
                'request_data' => $request->all()
            ]);
            
            return redirect()->back()
                ->withErrors(['error' => 'Failed to create product: ' . $e->getMessage()])
                ->withInput();
        }
    }

    /**
     * Display the specified product.
     */
    public function show(Product $product)
    {
        $product->load(['category', 'brand', 'reviews.user', 'orderItems.order']);
        
        // Calculate connection counts for dashboard (with safety checks)
        $connectionCounts = [
            'reviews_count' => $this->safeCount(function() use ($product) {
                return $product->reviews()->count();
            }),
            'orders_count' => $this->safeCount(function() use ($product) {
                return OrderItem::where('product_id', $product->id)->distinct('order_id')->count();
            }),
            'inventory_count' => $this->safeCount(function() use ($product) {
                return $product->inventory()->count();
            }),
            'approved_reviews' => $this->safeCount(function() use ($product) {
                return $product->reviews()->where('is_approved', true)->count();
            }),
            'pending_reviews' => $this->safeCount(function() use ($product) {
                return $product->reviews()->where('is_approved', false)->count();
            }),
        ];
        
        return view('admin.products.show', compact('product', 'connectionCounts'));
    }

    /**
     * Show the form for editing the product.
     */
    public function edit(Product $product)
    {
        $categories = Category::active()->orderBy('name')->get();
        $brands = Brand::active()->orderBy('name')->get();
        
        return view('admin.products.edit', compact('product', 'categories', 'brands'));
    }

    /**
     * Update the specified product.
     */
    public function update(Request $request, Product $product)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'slug' => 'nullable|string|max:255|unique:products,slug,' . $product->id,
            'sku' => 'required|string|max:255|unique:products,sku,' . $product->id,
            'short_description' => 'nullable|string|max:500',
            'description' => 'nullable|string',
            'regular_price' => 'required|numeric|min:0',
            'sale_price' => 'nullable|numeric|min:0',
            'quantity' => 'required|integer|min:0',
            'category_id' => 'required|exists:categories,id',
            'brand_id' => 'required|exists:brands,id',
            'status' => 'required|in:active,inactive,draft',
            'featured' => 'boolean',
            'weight' => 'nullable|numeric|min:0',
            'dimensions' => 'nullable|array',
            'dimensions.length' => 'nullable|numeric|min:0',
            'dimensions.width' => 'nullable|numeric|min:0',
            'dimensions.height' => 'nullable|numeric|min:0',
            'meta_title' => 'nullable|string|max:255',
            'meta_description' => 'nullable|string|max:500',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'images' => 'nullable|array',
            'images.*' => 'image|mimes:jpeg,png,jpg,gif|max:2048',
            'remove_image' => 'boolean',
            'remove_images' => 'nullable|array'
        ]);

        // Generate slug if not provided
        if (empty($validated['slug'])) {
            $validated['slug'] = Str::slug($validated['name']);
            
            // Ensure slug uniqueness (excluding current product)
            $originalSlug = $validated['slug'];
            $counter = 1;
            while (Product::where('slug', $validated['slug'])->where('id', '!=', $product->id)->exists()) {
                $validated['slug'] = $originalSlug . '-' . $counter;
                $counter++;
            }
        }

        // Handle dimensions
        if (isset($validated['dimensions'])) {
            $validated['dimensions'] = array_filter($validated['dimensions']);
        }

        // Handle main image removal
        if ($request->boolean('remove_image') && $product->image) {
            Storage::disk('public')->delete($product->image);
            $validated['image'] = null;
        }

        // Handle new main image upload
        if ($request->hasFile('image')) {
            // Delete old image if exists
            if ($product->image) {
                Storage::disk('public')->delete($product->image);
            }
            
            $image = $request->file('image');
            $filename = time() . '_' . Str::random(10) . '.' . $image->getClientOriginalExtension();
            $path = $image->storeAs('products', $filename, 'public');
            $validated['image'] = $path;
        }

        // Handle gallery images removal
        if ($request->filled('remove_images') && $product->images) {
            $currentImages = $product->images;
            foreach ($request->remove_images as $removeIndex) {
                if (isset($currentImages[$removeIndex])) {
                    Storage::disk('public')->delete($currentImages[$removeIndex]);
                    unset($currentImages[$removeIndex]);
                }
            }
            $validated['images'] = array_values($currentImages);
        }

        // Handle new gallery images upload
        if ($request->hasFile('images')) {
            $currentImages = $product->images ?? [];
            foreach ($request->file('images') as $image) {
                $filename = time() . '_' . Str::random(10) . '.' . $image->getClientOriginalExtension();
                $path = $image->storeAs('products/gallery', $filename, 'public');
                $currentImages[] = $path;
            }
            $validated['images'] = $currentImages;
        }

        $product->update($validated);

        return redirect()->route('admin.products.index')
            ->with('success', 'Product updated successfully!');
    }

    /**
     * Remove the specified product.
     */
    public function destroy(Product $product)
    {
        // Check if product has orders
        if ($product->orderItems()->count() > 0) {
            return redirect()->route('admin.products.index')
                ->with('error', 'Cannot delete product with existing orders. Please archive it instead.');
        }

        // Delete product images
        if ($product->image) {
            Storage::disk('public')->delete($product->image);
        }
        if ($product->images) {
            foreach ($product->images as $imagePath) {
                Storage::disk('public')->delete($imagePath);
            }
        }

        $product->delete();

        return redirect()->route('admin.products.index')
            ->with('success', 'Product deleted successfully!');
    }

    /**
     * Toggle product status.
     */
    public function toggleStatus(Product $product)
    {
        $newStatus = $product->status === 'active' ? 'inactive' : 'active';
        $product->update(['status' => $newStatus]);
        
        return redirect()->back()->with('success', "Product {$newStatus} successfully!");
    }

    /**
     * Toggle featured status.
     */
    public function toggleFeatured(Product $product)
    {
        $product->update(['featured' => !$product->featured]);
        
        $status = $product->featured ? 'featured' : 'unfeatured';
        return redirect()->back()->with('success', "Product {$status} successfully!");
    }

    /**
     * Handle bulk actions.
     */
    public function bulkActions(Request $request)
    {
        $request->validate([
            'action' => 'required|in:activate,deactivate,feature,unfeature,delete,draft',
            'selected_products' => 'required|array|min:1',
            'selected_products.*' => 'exists:products,id'
        ]);

        $products = Product::whereIn('id', $request->selected_products);

        switch ($request->action) {
            case 'activate':
                $products->update(['status' => 'active']);
                return redirect()->back()->with('success', 'Selected products activated successfully!');
                
            case 'deactivate':
                $products->update(['status' => 'inactive']);
                return redirect()->back()->with('success', 'Selected products deactivated successfully!');
                
            case 'draft':
                $products->update(['status' => 'draft']);
                return redirect()->back()->with('success', 'Selected products moved to draft successfully!');
                
            case 'feature':
                $products->update(['featured' => true]);
                return redirect()->back()->with('success', 'Selected products featured successfully!');
                
            case 'unfeature':
                $products->update(['featured' => false]);
                return redirect()->back()->with('success', 'Selected products unfeatured successfully!');
                
            case 'delete':
                // Check for orders before deletion
                $productsWithOrders = $products->has('orderItems')->count();
                if ($productsWithOrders > 0) {
                    return redirect()->back()->with('error', 
                        "Cannot delete {$productsWithOrders} products that have existing orders.");
                }
                
                $products->get()->each(function($product) {
                    if ($product->image) {
                        Storage::disk('public')->delete($product->image);
                    }
                    if ($product->images) {
                        foreach ($product->images as $imagePath) {
                            Storage::disk('public')->delete($imagePath);
                        }
                    }
                });
                
                $products->delete();
                return redirect()->back()->with('success', 'Selected products deleted successfully!');
        }
    }

    /**
     * Show reviews for a specific product.
     */
    public function reviews(Product $product)
    {
        try {
            $reviews = $product->reviews()
                ->with(['user'])
                ->latest()
                ->paginate(10);
        } catch (\Illuminate\Database\QueryException $e) {
            // If table doesn't exist, create empty paginator
            if (str_contains($e->getMessage(), "doesn't exist")) {
                $reviews = new \Illuminate\Pagination\LengthAwarePaginator(
                    collect([]), 0, 10, 1, ['path' => request()->url()]
                );
            } else {
                throw $e;
            }
        }

        return view('admin.products.reviews', compact('product', 'reviews'));
    }

    /**
     * Show orders for a specific product.
     */
    public function orders(Product $product)
    {
        try {
            $orders = OrderItem::where('product_id', $product->id)
                ->with(['order.user'])
                ->latest()
                ->paginate(10);
        } catch (\Illuminate\Database\QueryException $e) {
            // If table doesn't exist, create empty paginator
            if (str_contains($e->getMessage(), "doesn't exist")) {
                $orders = new \Illuminate\Pagination\LengthAwarePaginator(
                    collect([]), 0, 10, 1, ['path' => request()->url()]
                );
            } else {
                throw $e;
            }
        }

        return view('admin.products.orders', compact('product', 'orders'));
    }

    /**
     * Show inventory for a specific product.
     */
    public function inventory(Product $product)
    {
        $inventory = $this->safeCount(function() use ($product) {
            return $product->inventory()->with(['warehouse'])->get();
        });
        
        // If inventory returns 0 (table doesn't exist), create empty collection
        if ($inventory === 0) {
            $inventory = collect([]);
        }

        return view('admin.products.inventory', compact('product', 'inventory'));
    }

    /**
     * Show product analytics.
     */
    public function analytics(Product $product)
    {
        $analytics = [
            'total_reviews' => $this->safeCount(function() use ($product) {
                return $product->reviews()->count();
            }),
            'approved_reviews' => $this->safeCount(function() use ($product) {
                return $product->reviews()->where('is_approved', true)->count();
            }),
            'pending_reviews' => $this->safeCount(function() use ($product) {
                return $product->reviews()->where('is_approved', false)->count();
            }),
            'average_rating' => $this->safeCount(function() use ($product) {
                return $product->reviews()->where('is_approved', true)->avg('rating') ?? 0;
            }),
            'total_orders' => $this->safeCount(function() use ($product) {
                return OrderItem::where('product_id', $product->id)->distinct('order_id')->count();
            }),
            'total_quantity_sold' => $this->safeCount(function() use ($product) {
                return OrderItem::where('product_id', $product->id)->sum('quantity') ?? 0;
            }),
            'total_revenue' => $this->safeCount(function() use ($product) {
                return OrderItem::where('product_id', $product->id)->sum(\DB::raw('quantity * price')) ?? 0;
            }),
            'current_stock' => $product->quantity,
            'inventory_locations' => $this->safeCount(function() use ($product) {
                return $product->inventory()->count();
            }),
            'views_count' => 0, // Can be implemented with analytics tracking
        ];

        return view('admin.products.analytics', compact('product', 'analytics'));
    }
}
