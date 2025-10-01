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
    use App\Models\Attribute;
use App\Models\AttributeValue;
use App\Models\ProductAttribute;
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
//  public function store(Request $request)
//     {
//         // Debug: تسجيل كل بيانات الطلب
//         \Log::info('Product creation request received', [
//             'method' => $request->method(),
//             'data' => $request->all()
//         ]);

//         try {
//             // Validate incoming request
//             $validated = $request->validate([
//                 'name' => 'required|string|max:255',
//                 'slug' => 'nullable|string|max:255',
//                 'description' => 'nullable|string',
//                 'price' => 'required|numeric|min:0',
//                 'sale_price' => 'nullable|numeric|min:0',
//                 'stock' => 'nullable|integer|min:0',
//                 'category_id' => 'required|exists:categories,id',
//                 'brand_id' => 'nullable|exists:brands,id',
//                 'status' => 'nullable|boolean',
//                 'image' => 'required|image|mimes:jpeg,png,jpg,gif,webp|max:5120',
//                 'gallery_images' => 'nullable|array',
//                 'gallery_images.*' => 'image|mimes:jpeg,png,jpg,gif,webp|max:5120',
//                 'enable_countdown' => 'nullable|boolean',
//                 'countdown_date' => 'nullable|date',
//                 'colors' => 'nullable|array',
//                 'colors.*.name' => 'required_with:colors|string|max:255',
//                 'colors.*.hex' => 'required_with:colors|string|max:7',
//                 'colors.*.stock' => 'nullable|integer|min:0',
//                 'sizes' => 'nullable|array',
//                 'sizes.*.name' => 'required_with:sizes|string|max:255',
//                 'sizes.*.stock' => 'nullable|integer|min:0',
//                 'sizes.*.guide' => 'nullable|string|max:500',
//                 'is_new_arrival' => 'nullable|boolean',
//                 'new_arrival_until' => 'nullable|date',
//                 'featured_new_arrival' => 'nullable|boolean',
//                 'new_arrival_priority' => 'nullable|integer|min:0|max:10'
//             ]);

//             // Generate slug if not provided
//             if (empty($validated['slug'])) {
//                 $validated['slug'] = Str::slug($validated['name']);
//             }

//             // Prepare product data
//             $productData = [
//                 'name' => $validated['name'],
//                 'slug' => $validated['slug'],
//                 'description' => $validated['description'],
//                 'regular_price' => $validated['price'],
//                 'sale_price' => $validated['sale_price'] ?? null,
//                 'quantity' => $validated['stock'] ?? 0,
//                 'category_id' => $validated['category_id'],
//                 'brand_id' => $validated['brand_id'] ?? null,
//                 'status' => ($validated['status'] ?? false) ? 'active' : 'inactive',
//                 'featured' => false,
//                 'sku' => 'SKU-' . time() . '-' . Str::random(6),
//                 'enable_countdown' => ($validated['enable_countdown'] ?? false),
//                 'countdown_date' => $validated['countdown_date'] ?? null,
//                 'is_new_arrival' => ($validated['is_new_arrival'] ?? false),
//                 'new_arrival_until' => $validated['new_arrival_until'] ?? null,
//                 'featured_new_arrival' => ($validated['featured_new_arrival'] ?? false),
//                 'new_arrival_priority' => $validated['new_arrival_priority'] ?? 0,
//             ];

//             // Handle main image
//             if ($request->hasFile('image')) {
//                 $image = $request->file('image');
//                 $filename = time() . '_' . Str::random(10) . '.' . $image->getClientOriginalExtension();
//                 $path = $image->storeAs('products', $filename, 'public');

//                 // Debug: تحقق من المسار
//                 // dd($path);

//                 $productData['image'] = $path;
//             }

//             // Handle gallery images
//             $galleryImagesPaths = [];
//             if ($request->hasFile('gallery_images')) {
//                 foreach ($request->file('gallery_images') as $index => $image) {
//                     $filename = time() . '_' . Str::random(10) . '_' . ($index + 1) . '.' . $image->getClientOriginalExtension();
//                     $path = $image->storeAs('products/gallery', $filename, 'public');
//                     $galleryImagesPaths[] = $path;
//                 }
//                 $productData['gallery_images'] = $galleryImagesPaths;
//             }

//             // Create product
//             $product = Product::create($productData);

//             return redirect()->route('admin.products.index')
//                 ->with('success', "Product '{$product->name}' created successfully!");

//         } catch (\Illuminate\Validation\ValidationException $e) {
//             \Log::error('Validation failed', [
//                 'errors' => $e->errors(),
//                 'request_data' => $request->all()
//             ]);

//             return redirect()->back()
//                 ->withErrors($e->errors())
//                 ->withInput();
//         } catch (\Exception $e) {
//             \Log::error('Product creation failed', [
//                 'error' => $e->getMessage(),
//                 'request_data' => $request->all()
//             ]);

//             return redirect()->back()
//                 ->withErrors(['error' => 'Failed to create product: ' . $e->getMessage()])
//                 ->withInput();
//         }
//     }
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
            'slug' => 'nullable|string|max:255',
            'description' => 'nullable|string',
            'price' => 'required|numeric|min:0',
            'sale_price' => 'nullable|numeric|min:0',
            'stock' => 'required|integer|min:1',
            'category_id' => 'required|exists:categories,id',
            'brand_id' => 'nullable|exists:brands,id',
            'status' => 'nullable|boolean',
            'image' => 'required|image|mimes:jpeg,png,jpg,gif,webp|max:5120',
            'gallery_images' => 'nullable|array',
            'gallery_images.*' => 'image|mimes:jpeg,png,jpg,gif,webp|max:5120',
            'enable_countdown' => 'nullable|boolean',
            'countdown_date' => 'nullable|date',
            'colors' => 'nullable|array',
            'colors.*.name' => 'required_with:colors|string|max:255',
            'colors.*.hex' => 'required_with:colors|string|max:7',
            'colors.*.stock' => 'nullable|integer|min:0',
            'sizes' => 'nullable|array',
            'sizes.*.name' => 'required_with:sizes|string|max:255',
            'sizes.*.stock' => 'nullable|integer|min:0',
            'sizes.*.guide' => 'nullable|string|max:500',
            'is_new_arrival' => 'nullable|boolean',
            'new_arrival_until' => 'nullable|date',
            'featured_new_arrival' => 'nullable|boolean',
            'new_arrival_priority' => 'nullable|integer|min:0|max:10'
        ]);

        // Generate slug if not provided
        if (empty($validated['slug'])) {
            $validated['slug'] = Str::slug($validated['name']);
        }

        // Check for similar slugs and warn user (but allow creation)
        $similarSlugs = Product::where('slug', 'like', '%' . $validated['slug'] . '%')
            ->orWhere('slug', 'like', '%' . Str::slug($validated['name']) . '%')
            ->pluck('slug')
            ->toArray();

        if (!empty($similarSlugs)) {
            \Log::info('Similar slugs found', [
                'new_slug' => $validated['slug'],
                'similar_slugs' => $similarSlugs
            ]);
        }

        // Map form fields to database fields
        $productData = [
            'name' => $validated['name'],
            'slug' => $validated['slug'],
            'description' => $validated['description'],
            'regular_price' => $validated['price'], // Map price to regular_price
            'sale_price' => $validated['sale_price'],
            'quantity' => $validated['stock'] ?? 0, // Map stock to quantity
            'category_id' => $validated['category_id'],
            'brand_id' => $validated['brand_id'],
            'status' => ($validated['status'] ?? false) ? 'active' : 'inactive',
            'featured' => false,
            'sku' => 'SKU-' . time() . '-' . Str::random(6), // Generate SKU
            'enable_countdown' => ($validated['enable_countdown'] ?? false) ? true : false,
            'countdown_date' => $validated['countdown_date'] ?? null,
            'is_new_arrival' => ($validated['is_new_arrival'] ?? false) ? true : false,
            'new_arrival_until' => $validated['new_arrival_until'] ?? null,
            'featured_new_arrival' => ($validated['featured_new_arrival'] ?? false) ? true : false,
            'new_arrival_priority' => $validated['new_arrival_priority'] ?? 0,
        ];

        // Handle main image upload
        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $filename = time() . '_' . Str::random(10) . '.' . $image->getClientOriginalExtension();
            $path = $image->storeAs('products', $filename, 'public');
            $productData['image'] = $path;
        }

        // Handle gallery images upload
        $galleryImagesPaths = [];
        if ($request->hasFile('gallery_images')) {
            foreach ($request->file('gallery_images') as $index => $image) {
                $filename = time() . '_' . Str::random(10) . '_' . ($index + 1) . '.' . $image->getClientOriginalExtension();
                $path = $image->storeAs('products/gallery', $filename, 'public');
                $galleryImagesPaths[] = $path;
            }
            $productData['gallery_images'] = $galleryImagesPaths;
        }

        $product = Product::create($productData);

            // Handle color attributes and track statistics
            $colorStats = ['new' => 0, 'reused' => 0];
            if ($request->has('colors') && is_array($request->colors)) {
                $colorStats = $this->handleColorAttributes($product, $request->colors);
            }

            // Handle size attributes and track statistics
            $sizeStats = ['new' => 0, 'reused' => 0];
            if ($request->has('sizes') && is_array($request->sizes)) {
                $sizeStats = $this->handleSizeAttributes($product, $request->sizes);
            }

            // Build success message with attribute sync info
            $message = "Product '{$product->name}' created successfully!";
            
            // Add attribute sync summary
            $syncMessages = [];
            if ($colorStats['new'] > 0) {
                $syncMessages[] = "<strong>{$colorStats['new']} new color(s)</strong> added to global library";
            }
            if ($colorStats['reused'] > 0) {
                $syncMessages[] = "{$colorStats['reused']} existing color(s) reused";
            }
            if ($sizeStats['new'] > 0) {
                $syncMessages[] = "<strong>{$sizeStats['new']} new size(s)</strong> added to global library";
            }
            if ($sizeStats['reused'] > 0) {
                $syncMessages[] = "{$sizeStats['reused']} existing size(s) reused";
            }
            
            if (!empty($syncMessages)) {
                $message .= "<br><small class='text-muted'>📊 Sync: " . implode(' • ', $syncMessages) . "</small>";
            }

            return redirect()->route('admin.products.index')
                ->with('success', $message);

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
            'slug' => 'nullable|string|max:255',
            'description' => 'nullable|string',
            'price' => 'required|numeric|min:0',
            'sale_price' => 'nullable|numeric|min:0',
            'stock' => 'nullable|integer|min:0',
            'category_id' => 'required|exists:categories,id',
            'brand_id' => 'nullable|exists:brands,id',
            'status' => 'nullable|boolean',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:5120',
            'gallery_images' => 'nullable|array',
            'gallery_images.*' => 'image|mimes:jpeg,png,jpg,gif,webp|max:5120',
            'enable_countdown' => 'nullable|boolean',
            'countdown_date' => 'nullable|date',
            'colors' => 'nullable|array',
            'colors.*.name' => 'required_with:colors|string|max:255',
            'colors.*.hex' => 'required_with:colors|string|max:7',
            'colors.*.stock' => 'nullable|integer|min:0',
            'delete_colors' => 'nullable|array',
            'delete_colors.*' => 'integer|exists:product_attributes,id',
            'sizes' => 'nullable|array',
            'sizes.*.name' => 'required_with:sizes|string|max:255',
            'sizes.*.stock' => 'nullable|integer|min:0',
            'sizes.*.guide' => 'nullable|string|max:500',
            'delete_sizes' => 'nullable|array',
            'delete_sizes.*' => 'integer|exists:product_attributes,id',
            'is_new_arrival' => 'nullable|boolean',
            'new_arrival_until' => 'nullable|date',
            'featured_new_arrival' => 'nullable|boolean',
            'new_arrival_priority' => 'nullable|integer|min:0|max:10'
        ]);

        // Generate slug if not provided
        if (empty($validated['slug'])) {
            $validated['slug'] = Str::slug($validated['name']);
        }

        // Check for similar slugs and warn user (but allow creation)
        $similarSlugs = Product::where('slug', 'like', '%' . $validated['slug'] . '%')
            ->where('id', '!=', $product->id)
            ->pluck('slug')
            ->toArray();

        if (!empty($similarSlugs)) {
            \Log::info('Similar slugs found during update', [
                'new_slug' => $validated['slug'],
                'similar_slugs' => $similarSlugs,
                'product_id' => $product->id
            ]);
        }

        // Map form fields to database fields
        $productData = [
            'name' => $validated['name'],
            'slug' => $validated['slug'],
            'description' => $validated['description'],
            'regular_price' => $validated['price'], // Map price to regular_price
            'sale_price' => $validated['sale_price'],
            'quantity' => $validated['stock'] ?? $product->quantity, // Map stock to quantity
            'category_id' => $validated['category_id'],
            'brand_id' => $validated['brand_id'],
            'status' => ($validated['status'] ?? false) ? 'active' : 'inactive',
            'enable_countdown' => ($validated['enable_countdown'] ?? false) ? true : false,
            'countdown_date' => $validated['countdown_date'] ?? null,
            'is_new_arrival' => ($validated['is_new_arrival'] ?? false) ? true : false,
            'new_arrival_until' => $validated['new_arrival_until'] ?? null,
            'featured_new_arrival' => ($validated['featured_new_arrival'] ?? false) ? true : false,
            'new_arrival_priority' => $validated['new_arrival_priority'] ?? 0,
        ];

        // Handle main image upload
        if ($request->hasFile('image')) {
            // Delete old image if exists
            if ($product->image) {
                Storage::disk('public')->delete($product->image);
            }

            $image = $request->file('image');
            $filename = time() . '_' . Str::random(10) . '.' . $image->getClientOriginalExtension();
            $path = $image->storeAs('products', $filename, 'public');
            $productData['image'] = $path;
        }

        // Handle gallery images upload
        if ($request->hasFile('gallery_images')) {
            // Delete old gallery images if they exist
            if ($product->gallery_images) {
                $oldGalleryImages = is_array($product->gallery_images) ? $product->gallery_images : json_decode($product->gallery_images, true);
                if (is_array($oldGalleryImages)) {
                    foreach ($oldGalleryImages as $oldImage) {
                        Storage::disk('public')->delete($oldImage);
                    }
                }
            }

            $galleryImagesPaths = [];
            foreach ($request->file('gallery_images') as $index => $image) {
                $filename = time() . '_' . Str::random(10) . '_' . ($index + 1) . '.' . $image->getClientOriginalExtension();
                $path = $image->storeAs('products/gallery', $filename, 'public');
                $galleryImagesPaths[] = $path;
            }
            $productData['gallery_images'] = $galleryImagesPaths;
        }

        $product->update($productData);

        // Auto-remove last new arrival if this product is marked as new arrival
        if (($validated['is_new_arrival'] ?? false) && !$product->wasRecentlyCreated) {
            $this->manageNewArrivalLimit($product);
        }

        // Handle color attributes and track statistics
        $colorStats = ['new' => 0, 'reused' => 0];
        if ($request->has('colors') && is_array($request->colors)) {
            $colorStats = $this->handleColorAttributes($product, $request->colors);
        }
        
        // Handle color deletions
        if ($request->has('delete_colors') && is_array($request->delete_colors)) {
            ProductAttribute::whereIn('id', $request->delete_colors)->delete();
        }

        // Handle size attributes and track statistics  
        $sizeStats = ['new' => 0, 'reused' => 0];
        if ($request->has('sizes') && is_array($request->sizes)) {
            $sizeStats = $this->handleSizeAttributes($product, $request->sizes);
        }
        
        // Handle size deletions
        if ($request->has('delete_sizes') && is_array($request->delete_sizes)) {
            ProductAttribute::whereIn('id', $request->delete_sizes)->delete();
        }

        // Build success message with attribute sync info
        $message = "Product '{$product->name}' updated successfully!";
        
        // Add attribute sync summary
        $syncMessages = [];
        if ($colorStats['new'] > 0) {
            $syncMessages[] = "<strong>{$colorStats['new']} new color(s)</strong> added to global library";
        }
        if ($colorStats['reused'] > 0) {
            $syncMessages[] = "{$colorStats['reused']} existing color(s) reused";
        }
        if ($sizeStats['new'] > 0) {
            $syncMessages[] = "<strong>{$sizeStats['new']} new size(s)</strong> added to global library";
        }
        if ($sizeStats['reused'] > 0) {
            $syncMessages[] = "{$sizeStats['reused']} existing size(s) reused";
        }
        
        if (!empty($syncMessages)) {
            $message .= "<br><small class='text-muted'>📊 Sync: " . implode(' • ', $syncMessages) . "</small>";
        }

        return redirect()->route('admin.products.index')
            ->with('success', $message);
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

    // GENDER-SPECIFIC PRODUCT METHODS

    /**
     * Display Men's products
     */
    public function men(Request $request)
    {
        return $this->displayGenderProducts('Men', 'men-theme', $request);
    }

    /**
     * Display Women's products
     */
    public function women(Request $request)
    {
        return $this->displayGenderProducts('Women', 'women-theme', $request);
    }

    /**
     * Display Boys' products
     */
    public function boys(Request $request)
    {
        return $this->displayGenderProducts('Boys', 'boys-theme', $request);
    }

    /**
     * Display Girls' products
     */
    public function girls(Request $request)
    {
        return $this->displayGenderProducts('Girls', 'girls-theme', $request);
    }

    /**
     * Generic method to display gender-specific products
     */
    private function displayGenderProducts($gender, $themeClass, Request $request)
    {
        // Get the parent gender category
        $parentCategory = Category::where('name', $gender)->first();

        if (!$parentCategory) {
            return redirect()->route('admin.products.index')
                ->with('error', "{$gender} category not found. Please create it first.");
        }

        // Build query for products in this gender category
        $query = Product::with(['category', 'brand'])
            ->whereHas('category', function($q) use ($parentCategory) {
                $q->where('id', $parentCategory->id)
                  ->orWhere('parent_id', $parentCategory->id);
            });

        // Apply filters
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('description', 'like', "%{$search}%")
                  ->orWhere('sku', 'like', "%{$search}%");
            });
        }

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        if ($request->filled('brand_id')) {
            $query->where('brand_id', $request->brand_id);
        }

        if ($request->filled('featured')) {
            $query->where('featured', $request->featured === 'yes');
        }

        $products = $query->orderBy('featured', 'desc')
            ->orderBy('created_at', 'desc')
            ->paginate(12);

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

        // Get categories and brands for filters
        $categories = Category::where('parent_id', $parentCategory->id)->active()->orderBy('name')->get();
        $brands = Brand::active()->orderBy('name')->get();

        // Calculate statistics for this gender
        $statistics = [
            'active_products' => $query->where('status', 'active')->count(),
            'featured_products' => $query->where('featured', true)->count(),
            'average_rating' => $query->withAvg('reviews', 'rating')->get()->avg('reviews_avg_rating') ?? 0,
        ];

        // Theme configuration
        $theme = $this->getGenderTheme($gender);

        return view('admin.products.gender', compact(
            'products',
            'categories',
            'brands',
            'gender',
            'theme',
            'statistics'
        ));
    }

    /**
     * Get gender-specific theme configuration for products
     */
    private function getGenderTheme($gender)
    {
        $themes = [
            'Men' => [
                'theme_name' => 'men-theme',
                'icon' => '👨',
                'title' => 'Men\'s Products',
                'description' => 'Manage men\'s sportswear and athletic gear products',
                'color' => '#3182ce',
            ],
            'Women' => [
                'theme_name' => 'women-theme',
                'icon' => '👩',
                'title' => 'Women\'s Products',
                'description' => 'Manage women\'s sportswear and athletic gear products',
                'color' => '#ec4899',
            ],
            'Boys' => [
                'theme_name' => 'boys-theme',
                'icon' => '👦',
                'title' => 'Boys\' Products',
                'description' => 'Manage boys\' sportswear and athletic gear products',
                'color' => '#10b981',
            ],
            'Girls' => [
                'theme_name' => 'girls-theme',
                'icon' => '👧',
                'title' => 'Girls\' Products',
                'description' => 'Manage girls\' sportswear and athletic gear products',
                'color' => '#8b5cf6',
            ],
        ];

        return $themes[$gender] ?? $themes['Men'];
    }

    /**
     * Handle color attributes for a product
     */
    private function handleColorAttributes(Product $product, array $colors)
    {
        $newlyCreatedColors = [];
        $reusedColors = [];
        
        // Get or create the Color attribute
        $colorAttribute = Attribute::firstOrCreate(
            ['slug' => 'color'],
            [
                'name' => 'Color',
                'slug' => 'color',
                'type' => 'select',
                'is_required' => false
            ]
        );

        foreach ($colors as $colorData) {
            if (isset($colorData['name']) && isset($colorData['hex'])) {
                // Create or get the attribute value
                $attributeValue = AttributeValue::firstOrCreate(
                    [
                        'attribute_id' => $colorAttribute->id,
                        'value' => $colorData['name']
                    ],
                    [
                        'display_value' => $colorData['name'],
                        'hex_code' => $colorData['hex'] ?? null
                    ]
                );

                // Track if this was a new color added to global library
                if ($attributeValue->wasRecentlyCreated) {
                    $newlyCreatedColors[] = $colorData['name'];
                    \Log::info("✨ NEW color added to global library", [
                        'color_name' => $colorData['name'],
                        'color_hex' => $colorData['hex']
                    ]);
                } else {
                    // Update hex code if provided and different
                    if (isset($colorData['hex']) && $attributeValue->hex_code !== $colorData['hex']) {
                        $attributeValue->update(['hex_code' => $colorData['hex']]);
                    }
                    $reusedColors[] = $colorData['name'];
                }

                // Create or get the product attribute relationship (prevents duplicates)
                $productAttribute = ProductAttribute::firstOrCreate([
                    'product_id' => $product->id,
                    'attribute_value_id' => $attributeValue->id
                ], [
                    'additional_price' => 0.00
                ]);

                if ($productAttribute->wasRecentlyCreated) {
                    \Log::info("Color attribute linked to product", [
                        'product_id' => $product->id,
                        'product_name' => $product->name,
                        'color_name' => $colorData['name']
                    ]);
                }
            }
        }
        
        // Store summary in session for display
        if (!empty($newlyCreatedColors)) {
            session()->flash('colors_created', $newlyCreatedColors);
        }
        if (!empty($reusedColors)) {
            session()->flash('colors_reused', $reusedColors);
        }
        
        return [
            'new' => count($newlyCreatedColors),
            'reused' => count($reusedColors)
        ];
    }

    /**
     * Handle color attributes update for a product
     */
    private function handleColorAttributesUpdate(Product $product, Request $request)
    {
        // Handle color deletions
        if ($request->has('delete_colors') && is_array($request->delete_colors)) {
            ProductAttribute::whereIn('id', $request->delete_colors)->delete();
            \Log::info("Deleted color attributes", ['deleted_ids' => $request->delete_colors]);
        }

        // Handle new color additions
        if ($request->has('colors') && is_array($request->colors)) {
            $this->handleColorAttributes($product, $request->colors);
        }
    }

    /**
     * Handle size attributes update for a product
     */
    private function handleSizeAttributesUpdate(Product $product, Request $request)
    {
        // Handle size deletions
        if ($request->has('delete_sizes') && is_array($request->delete_sizes)) {
            ProductAttribute::whereIn('id', $request->delete_sizes)->delete();
            \Log::info("Deleted size attributes", ['deleted_ids' => $request->delete_sizes]);
        }

        // Handle new size additions
        if ($request->has('sizes') && is_array($request->sizes)) {
            $this->handleSizeAttributes($product, $request->sizes);
        }
    }

    /**
     * Handle size attributes for a product
     */
    private function handleSizeAttributes(Product $product, array $sizes)
    {
        $newlyCreatedSizes = [];
        $reusedSizes = [];
        
        // Get or create the Size attribute
        $sizeAttribute = Attribute::firstOrCreate(
            ['slug' => 'size'],
            [
                'name' => 'Size',
                'slug' => 'size',
                'type' => 'select',
                'is_required' => false
            ]
        );

        foreach ($sizes as $sizeData) {
            if (isset($sizeData['name'])) {
                // Create or get the attribute value
                $attributeValue = AttributeValue::firstOrCreate(
                    [
                        'attribute_id' => $sizeAttribute->id,
                        'value' => $sizeData['name']
                    ],
                    [
                        'display_value' => $sizeData['name']
                    ]
                );

                // Track if this was a new size added to global library
                if ($attributeValue->wasRecentlyCreated) {
                    $newlyCreatedSizes[] = $sizeData['name'];
                    \Log::info("✨ NEW size added to global library", [
                        'size_name' => $sizeData['name']
                    ]);
                } else {
                    $reusedSizes[] = $sizeData['name'];
                }

                // Create or get the product attribute relationship (prevents duplicates)
                $productAttribute = ProductAttribute::firstOrCreate([
                    'product_id' => $product->id,
                    'attribute_value_id' => $attributeValue->id
                ], [
                    'additional_price' => 0.00
                ]);

                if ($productAttribute->wasRecentlyCreated) {
                    \Log::info("Size attribute linked to product", [
                        'product_id' => $product->id,
                        'product_name' => $product->name,
                        'size_name' => $sizeData['name'],
                        'size_guide' => $sizeData['guide'] ?? null
                    ]);
                }
            }
        }
        
        // Store summary in session for display
        if (!empty($newlyCreatedSizes)) {
            session()->flash('sizes_created', $newlyCreatedSizes);
        }
        if (!empty($reusedSizes)) {
            session()->flash('sizes_reused', $reusedSizes);
        }
        
        return [
            'new' => count($newlyCreatedSizes),
            'reused' => count($reusedSizes)
        ];
    }

    /**
     * Manage new arrival limit by removing the oldest new arrival if limit is exceeded
     */
    private function manageNewArrivalLimit($currentProduct)
    {
        $maxNewArrivals = 8; // Maximum number of new arrivals to show

        // Get all current new arrivals (excluding the current product)
        $currentNewArrivals = Product::active()
            ->inStock()
            ->newArrival()
            ->where('id', '!=', $currentProduct->id)
            ->orderBy('new_arrival_priority', 'desc')
            ->orderBy('featured_new_arrival', 'desc')
            ->orderBy('created_at', 'desc')
            ->get();

        // If we're at or over the limit, remove the oldest one
        if ($currentNewArrivals->count() >= $maxNewArrivals) {
            $oldestNewArrival = $currentNewArrivals->last();

            if ($oldestNewArrival) {
                // Remove the oldest new arrival
                $oldestNewArrival->update([
                    'is_new_arrival' => false,
                    'featured_new_arrival' => false,
                    'new_arrival_until' => null
                ]);

                \Log::info("Auto-removed oldest new arrival to make room for new one", [
                    'removed_product_id' => $oldestNewArrival->id,
                    'removed_product_name' => $oldestNewArrival->name,
                    'new_product_id' => $currentProduct->id,
                    'new_product_name' => $currentProduct->name
                ]);
            }
        }

        \Log::info("New arrival limit managed", [
            'current_count' => $currentNewArrivals->count(),
            'max_limit' => $maxNewArrivals,
            'new_product_id' => $currentProduct->id,
            'new_product_name' => $currentProduct->name
        ]);
    }
}
