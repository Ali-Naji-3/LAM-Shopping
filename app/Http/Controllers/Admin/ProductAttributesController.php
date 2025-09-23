<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\Attribute;
use App\Models\AttributeValue;
use App\Models\ProductAttribute;
use Illuminate\Http\Request;

class ProductAttributesController extends Controller
{
    /**
     * Helper method to safely count records and handle missing tables
     */
    private function safeCount(callable $callback)
    {
        try {
            return $callback();
        } catch (\Illuminate\Database\QueryException $e) {
            if (str_contains($e->getMessage(), "doesn't exist")) {
                return 0;
            }
            throw $e;
        }
    }

    /**
     * Display a listing of all product attributes.
     */
    public function index(Request $request)
    {
        $query = ProductAttribute::with(['product', 'attributeValue.attribute']);

        // Search functionality
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->whereHas('product', function($subQ) use ($search) {
                    $subQ->where('name', 'like', "%{$search}%")
                         ->orWhere('sku', 'like', "%{$search}%");
                })->orWhereHas('attributeValue', function($subQ) use ($search) {
                    $subQ->where('value', 'like', "%{$search}%")
                         ->orWhereHas('attribute', function($attrQ) use ($search) {
                             $attrQ->where('name', 'like', "%{$search}%");
                         });
                });
            });
        }

        // Filter by product
        if ($request->filled('product_id')) {
            $query->where('product_id', $request->product_id);
        }

        // Filter by attribute
        if ($request->filled('attribute_id')) {
            $query->whereHas('attributeValue', function($q) use ($request) {
                $q->where('attribute_id', $request->attribute_id);
            });
        }

        // Filter by price range
        if ($request->filled('price_filter')) {
            switch ($request->price_filter) {
                case 'free':
                    $query->where('additional_price', 0);
                    break;
                case 'paid':
                    $query->where('additional_price', '>', 0);
                    break;
                case 'expensive':
                    $query->where('additional_price', '>', 10);
                    break;
            }
        }

        $productAttributes = $query->orderBy('product_id')
                                   ->orderBy('additional_price', 'desc')
                                   ->paginate(20);

        // Get filter options
        $products = Product::orderBy('name')->get();
        $attributes = Attribute::orderBy('name')->get();

        // Calculate statistics
        $statistics = [
            'total_assignments' => ProductAttribute::count(),
            'products_with_attributes' => $this->safeCount(function() {
                return Product::whereHas('productAttributes')->count();
            }),
            'total_additional_revenue' => $this->safeCount(function() {
                return ProductAttribute::sum('additional_price');
            }),
            'average_additional_price' => $this->safeCount(function() {
                return ProductAttribute::where('additional_price', '>', 0)->avg('additional_price');
            }),
        ];

        return view('admin.product-attributes.index', compact(
            'productAttributes', 
            'products', 
            'attributes', 
            'statistics'
        ));
    }

    /**
     * Show the form for creating a new product attribute assignment.
     */
    public function create()
    {
        $products = Product::with('category', 'brand')->orderBy('name')->get();
        $attributes = Attribute::with('attributeValues')->orderBy('name')->get();
        
        return view('admin.product-attributes.create', compact('products', 'attributes'));
    }

    /**
     * Store a newly created product attribute assignment.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'product_id' => 'required|exists:products,id',
            'attribute_value_id' => 'required|exists:attribute_values,id',
            'additional_price' => 'nullable|numeric|min:0|max:9999.99',
        ]);

        // Set default additional price
        $validated['additional_price'] = $validated['additional_price'] ?? 0.00;

        // Check for duplicate assignment
        if (ProductAttribute::where('product_id', $validated['product_id'])
                           ->where('attribute_value_id', $validated['attribute_value_id'])
                           ->exists()) {
            return redirect()->back()
                ->withInput()
                ->with('error', 'This attribute value is already assigned to the selected product.');
        }

        ProductAttribute::create($validated);

        return redirect()->route('admin.productAttributes.index')
            ->with('success', 'Product attribute assignment created successfully!');
    }

    /**
     * Display the specified product attribute assignment.
     */
    public function show(ProductAttribute $productAttribute)
    {
        $productAttribute->load(['product.category', 'product.brand', 'attributeValue.attribute']);
        
        // Get related assignments for the same product
        $relatedAssignments = ProductAttribute::where('product_id', $productAttribute->product_id)
            ->where('id', '!=', $productAttribute->id)
            ->with(['attributeValue.attribute'])
            ->get();

        // Get other products with the same attribute value
        $similarProducts = ProductAttribute::where('attribute_value_id', $productAttribute->attribute_value_id)
            ->where('product_id', '!=', $productAttribute->product_id)
            ->with(['product'])
            ->get();

        return view('admin.product-attributes.show', compact(
            'productAttribute', 
            'relatedAssignments', 
            'similarProducts'
        ));
    }

    /**
     * Show the form for editing the specified product attribute assignment.
     */
    public function edit(ProductAttribute $productAttribute)
    {
        $productAttribute->load(['product', 'attributeValue.attribute']);
        $products = Product::with('category', 'brand')->orderBy('name')->get();
        $attributes = Attribute::with('attributeValues')->orderBy('name')->get();
        
        return view('admin.product-attributes.edit', compact('productAttribute', 'products', 'attributes'));
    }

    /**
     * Update the specified product attribute assignment.
     */
    public function update(Request $request, ProductAttribute $productAttribute)
    {
        $validated = $request->validate([
            'product_id' => 'required|exists:products,id',
            'attribute_value_id' => 'required|exists:attribute_values,id',
            'additional_price' => 'nullable|numeric|min:0|max:9999.99',
        ]);

        // Set default additional price
        $validated['additional_price'] = $validated['additional_price'] ?? 0.00;

        // Check for duplicate assignment (excluding current)
        if (ProductAttribute::where('product_id', $validated['product_id'])
                           ->where('attribute_value_id', $validated['attribute_value_id'])
                           ->where('id', '!=', $productAttribute->id)
                           ->exists()) {
            return redirect()->back()
                ->withInput()
                ->with('error', 'This attribute value is already assigned to the selected product.');
        }

        $productAttribute->update($validated);

        return redirect()->route('admin.productAttributes.index')
            ->with('success', 'Product attribute assignment updated successfully!');
    }

    /**
     * Remove the specified product attribute assignment.
     */
    public function destroy(ProductAttribute $productAttribute)
    {
        $productAttribute->delete();

        return redirect()->route('admin.productAttributes.index')
            ->with('success', 'Product attribute assignment deleted successfully!');
    }

    /**
     * Handle bulk actions for product attribute assignments.
     */
    public function bulkActions(Request $request)
    {
        $request->validate([
            'action' => 'required|in:delete,update_price',
            'selected_assignments' => 'required|array|min:1',
            'selected_assignments.*' => 'exists:product_attributes,id',
            'bulk_additional_price' => 'nullable|numeric|min:0|max:9999.99'
        ]);

        $assignments = ProductAttribute::whereIn('id', $request->selected_assignments);

        switch ($request->action) {
            case 'delete':
                $assignments->delete();
                return redirect()->back()->with('success', 'Selected assignments deleted successfully!');
                
            case 'update_price':
                if ($request->filled('bulk_additional_price')) {
                    $assignments->update(['additional_price' => $request->bulk_additional_price]);
                    return redirect()->back()->with('success', 'Additional prices updated successfully!');
                } else {
                    return redirect()->back()->with('error', 'Please provide an additional price for bulk update.');
                }
        }
    }

    /**
     * Bulk assign attributes to a product.
     */
    public function bulkAssign(Request $request)
    {
        $request->validate([
            'product_id' => 'required|exists:products,id',
            'attribute_values' => 'required|array|min:1',
            'attribute_values.*' => 'exists:attribute_values,id',
            'default_additional_price' => 'nullable|numeric|min:0|max:9999.99'
        ]);

        $product = Product::findOrFail($request->product_id);
        $defaultPrice = $request->default_additional_price ?? 0.00;
        $created = 0;
        $skipped = 0;

        foreach ($request->attribute_values as $attributeValueId) {
            // Skip if assignment already exists
            if (ProductAttribute::where('product_id', $product->id)
                               ->where('attribute_value_id', $attributeValueId)
                               ->exists()) {
                $skipped++;
                continue;
            }

            ProductAttribute::create([
                'product_id' => $product->id,
                'attribute_value_id' => $attributeValueId,
                'additional_price' => $defaultPrice
            ]);
            $created++;
        }

        $message = "Assigned {$created} attributes to {$product->name}";
        if ($skipped > 0) {
            $message .= ", skipped {$skipped} existing assignments";
        }

        return redirect()->route('admin.productAttributes.index')
            ->with('success', $message . '!');
    }

    /**
     * Show analytics for product attributes.
     */
    public function analytics()
    {
        $analytics = [
            'total_assignments' => ProductAttribute::count(),
            'products_with_attributes' => $this->safeCount(function() {
                return Product::whereHas('productAttributes')->count();
            }),
            'products_without_attributes' => $this->safeCount(function() {
                return Product::whereDoesntHave('productAttributes')->count();
            }),
            'total_additional_revenue' => $this->safeCount(function() {
                return ProductAttribute::sum('additional_price');
            }),
            'average_additional_price' => $this->safeCount(function() {
                return ProductAttribute::where('additional_price', '>', 0)->avg('additional_price');
            }),
            'free_assignments' => ProductAttribute::where('additional_price', 0)->count(),
            'paid_assignments' => ProductAttribute::where('additional_price', '>', 0)->count(),
            'most_used_attributes' => $this->safeCount(function() {
                return Attribute::withCount('attributeValues.productAttributes')
                    ->orderBy('attribute_values_count', 'desc')
                    ->limit(5)
                    ->get();
            }),
            'highest_priced_assignments' => ProductAttribute::with(['product', 'attributeValue.attribute'])
                ->where('additional_price', '>', 0)
                ->orderBy('additional_price', 'desc')
                ->limit(10)
                ->get(),
        ];

        return view('admin.product-attributes.analytics', compact('analytics'));
    }
}