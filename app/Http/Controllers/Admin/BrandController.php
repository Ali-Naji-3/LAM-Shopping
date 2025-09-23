<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Brand;
use App\Models\Category;
use App\Models\Product;
use App\Models\Contact;
use App\Models\Review;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;

class BrandController extends Controller
{
    /**
     * Display a listing of brands.
     */
    public function index(Request $request)
    {
        $query = Brand::query();

        // Search functionality
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('description', 'like', "%{$search}%")
                  ->orWhere('slug', 'like', "%{$search}%");
            });
        }

        // Status filter
        if ($request->filled('status')) {
            if ($request->status === 'active') {
                $query->where('is_active', true);
            } elseif ($request->status === 'inactive') {
                $query->where('is_active', false);
            }
        }

        // Category filter (brands that have products in specific category)
        if ($request->filled('category_id')) {
            $query->whereHas('products', function($q) use ($request) {
                $q->where('category_id', $request->category_id);
            });
        }

        $brands = $query->withCount(['products', 'contacts'])
                       ->orderBy('name')
                       ->paginate(12);

        $categories = Category::active()->orderBy('name')->get();

        return view('admin.brands.index', compact('brands', 'categories'));
    }

    /**
     * Show the form for creating a new brand.
     */
    public function create()
    {
        $categories = Category::active()->orderBy('name')->get();
        
        return view('admin.brands.create', compact('categories'));
    }

    /**
     * Store a newly created brand.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255|unique:brands,name',
            'slug' => 'nullable|string|max:255|unique:brands,slug',
            'description' => 'nullable|string|max:1000',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'is_active' => 'boolean',
        ]);

        // Generate slug if not provided
        if (empty($validated['slug'])) {
            $validated['slug'] = Str::slug($validated['name']);
            
            // Ensure slug uniqueness
            $originalSlug = $validated['slug'];
            $counter = 1;
            while (Brand::where('slug', $validated['slug'])->exists()) {
                $validated['slug'] = $originalSlug . '-' . $counter;
                $counter++;
            }
        }

        // Handle image upload
        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $filename = time() . '_' . Str::random(10) . '.' . $image->getClientOriginalExtension();
            $path = $image->storeAs('brands', $filename, 'public');
            $validated['image'] = $path;
        }

        $brand = Brand::create($validated);

        return redirect()->route('admin.brands.index')
            ->with('success', 'Brand created successfully!');
    }

    /**
     * Display the specified brand.
     */
    public function show(Brand $brand)
    {
        $brand->load(['products.category', 'contacts.responses']);
        
        // Calculate connection counts for dashboard
        $connectionCounts = [
            'products_count' => $brand->products()->count(),
            'contacts_count' => $brand->contacts()->count(),
            'categories_count' => Category::whereHas('products', function($query) use ($brand) {
                $query->where('brand_id', $brand->id);
            })->count(),
            'reviews_count' => Review::whereHas('product', function($query) use ($brand) {
                $query->where('brand_id', $brand->id);
            })->count(),
            'pending_contacts' => $brand->contacts()->where('status', 'pending')->count(),
        ];
        
        return view('admin.brands.show', compact('brand', 'connectionCounts'));
    }

    /**
     * Show the form for editing the brand.
     */
    public function edit(Brand $brand)
    {
        $categories = Category::active()->orderBy('name')->get();
        
        return view('admin.brands.edit', compact('brand', 'categories'));
    }

    /**
     * Update the specified brand.
     */
    public function update(Request $request, Brand $brand)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255|unique:brands,name,' . $brand->id,
            'slug' => 'nullable|string|max:255|unique:brands,slug,' . $brand->id,
            'description' => 'nullable|string|max:1000',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'is_active' => 'boolean',
            'remove_image' => 'boolean'
        ]);

        // Generate slug if not provided
        if (empty($validated['slug'])) {
            $validated['slug'] = Str::slug($validated['name']);
            
            // Ensure slug uniqueness (excluding current brand)
            $originalSlug = $validated['slug'];
            $counter = 1;
            while (Brand::where('slug', $validated['slug'])->where('id', '!=', $brand->id)->exists()) {
                $validated['slug'] = $originalSlug . '-' . $counter;
                $counter++;
            }
        }

        // Handle image removal
        if ($request->boolean('remove_image') && $brand->image) {
            Storage::disk('public')->delete($brand->image);
            $validated['image'] = null;
        }

        // Handle new image upload
        if ($request->hasFile('image')) {
            // Delete old image if exists
            if ($brand->image) {
                Storage::disk('public')->delete($brand->image);
            }
            
            $image = $request->file('image');
            $filename = time() . '_' . Str::random(10) . '.' . $image->getClientOriginalExtension();
            $path = $image->storeAs('brands', $filename, 'public');
            $validated['image'] = $path;
        }

        $brand->update($validated);

        return redirect()->route('admin.brands.index')
            ->with('success', 'Brand updated successfully!');
    }

    /**
     * Remove the specified brand.
     */
    public function destroy(Brand $brand)
    {
        // Check if brand has products
        if ($brand->products()->count() > 0) {
            return redirect()->route('admin.brands.index')
                ->with('error', 'Cannot delete brand with associated products. Please reassign or delete products first.');
        }

        // Delete brand image if exists
        if ($brand->image) {
            Storage::disk('public')->delete($brand->image);
        }

        $brand->delete();

        return redirect()->route('admin.brands.index')
            ->with('success', 'Brand deleted successfully!');
    }

    /**
     * Toggle brand status.
     */
    public function toggleStatus(Brand $brand)
    {
        $brand->update(['is_active' => !$brand->is_active]);
        
        $status = $brand->is_active ? 'activated' : 'deactivated';
        return redirect()->back()->with('success', "Brand {$status} successfully!");
    }

    /**
     * Handle bulk actions.
     */
    public function bulkActions(Request $request)
    {
        $request->validate([
            'action' => 'required|in:activate,deactivate,delete',
            'selected_brands' => 'required|array|min:1',
            'selected_brands.*' => 'exists:brands,id'
        ]);

        $brands = Brand::whereIn('id', $request->selected_brands);

        switch ($request->action) {
            case 'activate':
                $brands->update(['is_active' => true]);
                return redirect()->back()->with('success', 'Selected brands activated successfully!');
                
            case 'deactivate':
                $brands->update(['is_active' => false]);
                return redirect()->back()->with('success', 'Selected brands deactivated successfully!');
                
            case 'delete':
                // Check for products before deletion
                $brandsWithProducts = $brands->has('products')->count();
                if ($brandsWithProducts > 0) {
                    return redirect()->back()->with('error', 
                        "Cannot delete {$brandsWithProducts} brands that have associated products.");
                }
                
                $brands->get()->each(function($brand) {
                    if ($brand->image) {
                        Storage::disk('public')->delete($brand->image);
                    }
                });
                
                $brands->delete();
                return redirect()->back()->with('success', 'Selected brands deleted successfully!');
        }
    }

    /**
     * Show contacts for a specific brand.
     */
    public function contacts(Brand $brand)
    {
        $contacts = $brand->contacts()
            ->with(['user', 'responses'])
            ->latest()
            ->paginate(10);

        return view('admin.brands.contacts', compact('brand', 'contacts'));
    }

    /**
     * Store a new contact message for a brand.
     */
    public function storeContact(Request $request, Brand $brand)
    {
        $validated = $request->validate([
            'subject' => 'required|string|max:255',
            'message' => 'required|string',
            'contact_type' => 'required|in:inquiry,complaint,suggestion,other',
            'priority' => 'required|in:low,medium,high,urgent',
        ]);

        $contact = Contact::create([
            'brand_id' => $brand->id,
            'user_id' => auth()->id(),
            'subject' => $validated['subject'],
            'message' => $validated['message'],
            'contact_type' => $validated['contact_type'],
            'priority' => $validated['priority'],
            'status' => 'pending',
        ]);

        return redirect()->route('admin.brands.contacts', $brand)
            ->with('success', 'Contact message sent successfully!');
    }

    /**
     * Show brand analytics dashboard.
     */
    public function analytics(Brand $brand)
    {
        $analytics = [
            'total_products' => $brand->products()->count(),
            'total_contacts' => $brand->contacts()->count(),
            'pending_contacts' => $brand->contacts()->where('status', 'pending')->count(),
            'total_reviews' => Review::whereHas('product', function($query) use ($brand) {
                $query->where('brand_id', $brand->id);
            })->count(),
            'average_rating' => Review::whereHas('product', function($query) use ($brand) {
                $query->where('brand_id', $brand->id);
            })->avg('rating') ?? 0,
            'categories_count' => Category::whereHas('products', function($query) use ($brand) {
                $query->where('brand_id', $brand->id);
            })->count(),
            'active_products' => $brand->products()->where('status', 'active')->count(),
            'featured_products' => $brand->products()->where('featured', true)->count(),
        ];

        return view('admin.brands.analytics', compact('brand', 'analytics'));
    }

    /**
     * Show products for a specific brand.
     */
    public function products(Brand $brand)
    {
        $products = $brand->products()
            ->with(['category', 'reviews'])
            ->withCount(['reviews', 'orderItems'])
            ->paginate(12);

        return view('admin.brands.products', compact('brand', 'products'));
    }

    /**
     * Show categories associated with a brand.
     */
    public function categories(Brand $brand)
    {
        $categories = Category::whereHas('products', function($query) use ($brand) {
            $query->where('brand_id', $brand->id);
        })->withCount(['products' => function($query) use ($brand) {
            $query->where('brand_id', $brand->id);
        }])->get();

        return view('admin.brands.categories', compact('brand', 'categories'));
    }
}
