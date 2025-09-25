<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Contact;
use App\Http\Requests\StoreCategoryRequest;
use App\Http\Requests\UpdateCategoryRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;

class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = Category::with(['parent', 'children'])
            ->withCount(['products', 'contacts']);

        // Search functionality
        if ($request->filled('search')) {
            $search = $request->get('search');
            $query->where(function($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('description', 'like', "%{$search}%")
                  ->orWhere('slug', 'like', "%{$search}%");
            });
        }

        // Filter by status
        if ($request->filled('status')) {
            $query->where('is_active', $request->get('status') === 'active');
        }

        // Filter by parent category
        if ($request->filled('parent_id')) {
            if ($request->get('parent_id') === 'root') {
                $query->whereNull('parent_id');
            } else {
                $query->where('parent_id', $request->get('parent_id'));
            }
        }

        $categories = $query->ordered()->paginate(20);
        $parentCategories = Category::whereNull('parent_id')->active()->ordered()->get();

        return view('admin.categories.index', compact('categories', 'parentCategories'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $parentCategories = Category::whereNull('parent_id')->active()->ordered()->get();
        return view('admin.categories.create', compact('parentCategories'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreCategoryRequest $request)
    {
        $validated = $request->validated();

        // Generate slug if not provided
        if (empty($validated['slug'])) {
            $validated['slug'] = Str::slug($validated['name']);
            
            // Ensure slug uniqueness
            $originalSlug = $validated['slug'];
            $counter = 1;
            while (Category::where('slug', $validated['slug'])->exists()) {
                $validated['slug'] = $originalSlug . '-' . $counter;
                $counter++;
            }
        }

        // Handle image upload
        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $filename = time() . '_' . Str::random(10) . '.' . $image->getClientOriginalExtension();
            $path = $image->storeAs('categories', $filename, 'public');
            $validated['image'] = $path;
        }

        // Set default order if not provided
        if (!isset($validated['order'])) {
            $maxOrder = Category::where('parent_id', $validated['parent_id'] ?? null)->max('order');
            $validated['order'] = ($maxOrder ?? 0) + 1;
        }

        $category = Category::create($validated);

        return redirect()->route('admin.categories.index')
            ->with('success', 'Category created successfully!');
    }

    /**
     * Display the specified resource.
     */
    public function show(Category $category)
    {
        $category->load(['parent', 'children.children', 'products', 'contacts.responses']);
        
        // Calculate connection counts for dashboard
        $connectionCounts = [
            'products_count' => $category->products()->count(),
            'contacts_count' => $category->contacts()->count(),
            'brands_count' => Brand::whereHas('products', function($query) use ($category) {
                $query->where('category_id', $category->id);
            })->count(),
            'reviews_count' => Review::whereHas('product', function($query) use ($category) {
                $query->where('category_id', $category->id);
            })->count(),
            'children_count' => $category->children()->count(),
        ];
        
        return view('admin.categories.show', compact('category', 'connectionCounts'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Category $category)
    {
        $parentCategories = Category::whereNull('parent_id')
            ->where('id', '!=', $category->id)
            ->active()
            ->ordered()
            ->get();

        return view('admin.categories.edit', compact('category', 'parentCategories'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateCategoryRequest $request, Category $category)
    {
        $validated = $request->validated();

        // Generate slug if not provided
        if (empty($validated['slug'])) {
            $validated['slug'] = Str::slug($validated['name']);
            
            // Ensure slug uniqueness
            $originalSlug = $validated['slug'];
            $counter = 1;
            while (Category::where('slug', $validated['slug'])->where('id', '!=', $category->id)->exists()) {
                $validated['slug'] = $originalSlug . '-' . $counter;
                $counter++;
            }
        }

        // Handle image removal
        if ($request->boolean('remove_image')) {
            if ($category->image) {
                Storage::disk('public')->delete($category->image);
            }
            $validated['image'] = null;
        }
        // Handle image upload
        elseif ($request->hasFile('image')) {
            // Delete old image
            if ($category->image) {
                Storage::disk('public')->delete($category->image);
            }
            
            $image = $request->file('image');
            $filename = time() . '_' . Str::random(10) . '.' . $image->getClientOriginalExtension();
            $path = $image->storeAs('categories', $filename, 'public');
            $validated['image'] = $path;
        }

        $category->update($validated);

        return redirect()->route('admin.categories.index')
            ->with('success', 'Category updated successfully!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Category $category)
    {
        // Check if category has products
        if ($category->products()->count() > 0) {
            return redirect()->back()
                ->with('error', 'Cannot delete category with associated products. Please reassign or delete products first.');
        }

        // Handle child categories - set their parent_id to null or to this category's parent
        if ($category->children()->count() > 0) {
            $category->children()->update(['parent_id' => $category->parent_id]);
        }

        // Delete image if exists
        if ($category->image) {
            Storage::disk('public')->delete($category->image);
        }

        $category->delete();

        return redirect()->route('admin.categories.index')
            ->with('success', 'Category deleted successfully!');
    }

    /**
     * Toggle category status
     */
    public function toggleStatus(Category $category)
    {
        $category->update(['is_active' => !$category->is_active]);
        
        $status = $category->is_active ? 'activated' : 'deactivated';
        
        return response()->json([
            'success' => true,
            'message' => "Category {$status} successfully!",
            'is_active' => $category->is_active
        ]);
    }

    /**
     * Handle bulk actions
     */
    public function bulkActions(Request $request)
    {
        $request->validate([
            'action' => 'required|in:activate,deactivate,delete',
            'categories' => 'required|array',
            'categories.*' => 'exists:categories,id'
        ]);

        $categories = Category::whereIn('id', $request->categories);

        switch ($request->action) {
            case 'activate':
                $categories->update(['is_active' => true]);
                $message = 'Categories activated successfully!';
                break;
                
            case 'deactivate':
                $categories->update(['is_active' => false]);
                $message = 'Categories deactivated successfully!';
                break;
                
            case 'delete':
                // Check for products
                $categoriesWithProducts = $categories->withCount('products')
                    ->get()
                    ->filter(function($category) {
                        return $category->products_count > 0;
                    });

                if ($categoriesWithProducts->count() > 0) {
                    return redirect()->back()
                        ->with('error', 'Some categories have associated products and cannot be deleted.');
                }

                // Handle child categories and delete images
                foreach ($categories->get() as $category) {
                    if ($category->children()->count() > 0) {
                        $category->children()->update(['parent_id' => $category->parent_id]);
                    }
                    if ($category->image) {
                        Storage::disk('public')->delete($category->image);
                    }
                }
                
                $categories->delete();
                $message = 'Categories deleted successfully!';
                break;
        }

        return redirect()->back()->with('success', $message);
    }

    /**
     * Reorder categories
     */
    public function reorder(Request $request)
    {
        $request->validate([
            'categories' => 'required|array',
            'categories.*.id' => 'required|exists:categories,id',
            'categories.*.order' => 'required|integer|min:0'
        ]);

        foreach ($request->categories as $categoryData) {
            Category::where('id', $categoryData['id'])
                ->update(['order' => $categoryData['order']]);
        }

        return response()->json([
            'success' => true,
            'message' => 'Categories reordered successfully!'
        ]);
    }

    /**
     * Get category contacts
     */
    public function contacts(Category $category)
    {
        $contacts = $category->contacts()->with('responses')->latest()->paginate(10);
        
        return view('admin.categories.contacts', compact('category', 'contacts'));
    }

    /**
     * Store category contact
     */
    public function storeContact(Request $request, Category $category)
    {
        $validated = $request->validate([
            'subject' => 'required|string|max:255',
            'message' => 'required|string|max:2000',
            'contact_type' => 'required|in:inquiry,complaint,suggestion,other',
            'priority' => 'required|in:low,medium,high,urgent'
        ]);

        $validated['category_id'] = $category->id;
        $validated['user_id'] = auth()->id();
        $validated['status'] = 'pending';

        Contact::create($validated);

        return redirect()->back()
            ->with('success', 'Contact message created successfully!');
    }

    /**
     * Check if a category is descendant of another
     */
    private function isDescendant(Category $category, $potentialParentId)
    {
        $descendants = $this->getAllDescendants($category);
        return in_array($potentialParentId, $descendants->pluck('id')->toArray());
    }

    /**
     * Get all descendants of a category
     */
    private function getAllDescendants(Category $category)
    {
        $descendants = collect();
        
        foreach ($category->children as $child) {
            $descendants->push($child);
            $descendants = $descendants->merge($this->getAllDescendants($child));
        }
        
        return $descendants;
    }

    // ENHANCED CATEGORY CONNECTIONS - Complete CRUD Integration

    /**
     * Show products for a specific category
     */
    public function products(Category $category)
    {
        $products = $category->products()
            ->with(['brand', 'reviews'])
            ->withCount(['reviews', 'orderItems'])
            ->paginate(12);

        return view('admin.categories.products', compact('category', 'products'));
    }

    /**
     * Show brands associated with a category
     */
    public function brands(Category $category)
    {
        $brands = Brand::whereHas('products', function($query) use ($category) {
            $query->where('category_id', $category->id);
        })->withCount(['products'])->get();

        return view('admin.categories.brands', compact('category', 'brands'));
    }

    /**
     * Show reviews for products in a category
     */
    public function reviews(Category $category)
    {
        $reviews = Review::whereHas('product', function($query) use ($category) {
            $query->where('category_id', $category->id);
        })->with(['product', 'user'])->latest()->paginate(10);

        return view('admin.categories.reviews', compact('category', 'reviews'));
    }

    /**
     * Show analytics dashboard for a category
     */
    public function analytics(Category $category)
    {
        $analytics = [
            'total_products' => $category->products()->count(),
            'total_contacts' => $category->contacts()->count(),
            'pending_contacts' => $category->contacts()->where('status', 'pending')->count(),
            'total_reviews' => Review::whereHas('product', function($query) use ($category) {
                $query->where('category_id', $category->id);
            })->count(),
            'average_rating' => Review::whereHas('product', function($query) use ($category) {
                $query->where('category_id', $category->id);
            })->avg('rating') ?? 0,
            'brands_count' => Brand::whereHas('products', function($query) use ($category) {
                $query->where('category_id', $category->id);
            })->count(),
            'active_products' => $category->products()->where('status', 'active')->count(),
            'featured_products' => $category->products()->where('featured', true)->count(),
        ];

        return view('admin.categories.analytics', compact('category', 'analytics'));
    }
}
