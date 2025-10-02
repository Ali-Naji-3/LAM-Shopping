<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Attribute;
use App\Models\AttributeValue;
use App\Models\Product;
use App\Models\Contact;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class AttributeController extends Controller
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
     * API: Get attribute values for autocomplete (used in product pages)
     */
    public function getAttributeValues($attributeSlug)
    {
        try {
            $attribute = Attribute::where('slug', $attributeSlug)->first();
            
            if (!$attribute) {
                return response()->json(['error' => 'Attribute not found'], 404);
            }

            $values = AttributeValue::where('attribute_id', $attribute->id)
                ->with(['productAttributes' => function($q) {
                    $q->select('id', 'attribute_value_id', 'product_id');
                }])
                ->get()
                ->map(function($value) {
                    return [
                        'id' => $value->id,
                        'value' => $value->value,
                        'display_value' => $value->display_value,
                        'hex_code' => $value->hex_code,
                        'usage_count' => $value->productAttributes->count(),
                        'products' => $value->productAttributes->pluck('product_id')
                    ];
                });

            return response()->json([
                'attribute' => $attribute->name,
                'slug' => $attribute->slug,
                'values' => $values
            ]);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Failed to fetch values'], 500);
        }
    }

    /**
     * API: Get popular/frequently used attribute values
     */
    public function getPopularValues($attributeSlug, $limit = 10)
    {
        try {
            $attribute = Attribute::where('slug', $attributeSlug)->first();
            
            if (!$attribute) {
                return response()->json(['error' => 'Attribute not found'], 404);
            }

            $values = AttributeValue::where('attribute_id', $attribute->id)
                ->withCount('productAttributes')
                ->orderBy('product_attributes_count', 'desc')
                ->limit($limit)
                ->get()
                ->map(function($value) {
                    return [
                        'value' => $value->value,
                        'display_value' => $value->display_value,
                        'hex_code' => $value->hex_code,
                        'usage_count' => $value->product_attributes_count
                    ];
                });

            return response()->json([
                'attribute' => $attribute->name,
                'popular_values' => $values
            ]);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Failed to fetch popular values'], 500);
        }
    }

    /**
     * Display a listing of attributes.
     */
    public function index(Request $request)
    {
        $query = Attribute::query();

        // Search functionality
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('slug', 'like', "%{$search}%");
            });
        }

        // Type filter
        if ($request->filled('type')) {
            $query->where('type', $request->type);
        }

        // Required filter
        if ($request->filled('required')) {
            if ($request->required === 'yes') {
                $query->where('is_required', true);
            } elseif ($request->required === 'no') {
                $query->where('is_required', false);
            }
        }

        $attributes = $query->withCount(['attributeValues'])
                           ->orderBy('name')
                           ->paginate(12);

        return view('admin.attributes.index', compact('attributes'));
    }

    /**
     * Show the form for creating a new attribute.
     */
    public function create()
    {
        return view('admin.attributes.create');
    }

    /**
     * Store a newly created attribute.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255|unique:attributes,name',
            'slug' => 'nullable|string|max:255|unique:attributes,slug',
            'type' => 'required|in:text,select,checkbox,radio',
            'is_required' => 'boolean',
        ]);

        // Generate slug if not provided
        if (empty($validated['slug'])) {
            $validated['slug'] = Str::slug($validated['name']);
            
            // Ensure slug uniqueness
            $originalSlug = $validated['slug'];
            $counter = 1;
            while (Attribute::where('slug', $validated['slug'])->exists()) {
                $validated['slug'] = $originalSlug . '-' . $counter;
                $counter++;
            }
        }

        $attribute = Attribute::create($validated);

        return redirect()->route('admin.attributes.index')
            ->with('success', 'Attribute created successfully!');
    }

    /**
     * Display the specified attribute.
     */
    public function show(Attribute $attribute)
    {
        $attribute->load(['attributeValues']);
        
        // Calculate connection counts for dashboard
        $connectionCounts = [
            'values_count' => $attribute->attributeValues()->count(),
            'products_count' => $this->safeCount(function() use ($attribute) {
                return Product::whereHas('attributeValues', function($query) use ($attribute) {
                    $query->where('attribute_id', $attribute->id);
                })->count();
            }),
            'contacts_count' => $this->safeCount(function() use ($attribute) {
                return $attribute->contacts()->count();
            }),
        ];
        
        return view('admin.attributes.show', compact('attribute', 'connectionCounts'));
    }

    /**
     * Show the form for editing the attribute.
     */
    public function edit(Attribute $attribute)
    {
        return view('admin.attributes.edit', compact('attribute'));
    }

    /**
     * Update the specified attribute.
     */
    public function update(Request $request, Attribute $attribute)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255|unique:attributes,name,' . $attribute->id,
            'slug' => 'nullable|string|max:255|unique:attributes,slug,' . $attribute->id,
            'type' => 'required|in:text,select,checkbox,radio',
            'is_required' => 'boolean',
        ]);

        // Generate slug if not provided
        if (empty($validated['slug'])) {
            $validated['slug'] = Str::slug($validated['name']);
            
            // Ensure slug uniqueness (excluding current attribute)
            $originalSlug = $validated['slug'];
            $counter = 1;
            while (Attribute::where('slug', $validated['slug'])->where('id', '!=', $attribute->id)->exists()) {
                $validated['slug'] = $originalSlug . '-' . $counter;
                $counter++;
            }
        }

        $attribute->update($validated);

        return redirect()->route('admin.attributes.index')
            ->with('success', 'Attribute updated successfully!');
    }

    /**
     * Remove the specified attribute.
     */
    public function destroy(Attribute $attribute)
    {
        // Check if attribute has values
        if ($attribute->attributeValues()->count() > 0) {
            return redirect()->route('admin.attributes.index')
                ->with('error', 'Cannot delete attribute with existing values. Please delete values first.');
        }

        // Check if attribute is used by products
        $productsUsingAttribute = $this->safeCount(function() use ($attribute) {
            return Product::whereHas('attributeValues', function($query) use ($attribute) {
                $query->where('attribute_id', $attribute->id);
            })->count();
        });

        if ($productsUsingAttribute > 0) {
            return redirect()->route('admin.attributes.index')
                ->with('error', 'Cannot delete attribute used by products. Please remove from products first.');
        }

        $attribute->delete();

        return redirect()->route('admin.attributes.index')
            ->with('success', 'Attribute deleted successfully!');
    }

    /**
     * Handle bulk actions.
     */
    public function bulkActions(Request $request)
    {
        $request->validate([
            'action' => 'required|in:require,unrequire,delete',
            'selected_attributes' => 'required|array|min:1',
            'selected_attributes.*' => 'exists:attributes,id'
        ]);

        $attributes = Attribute::whereIn('id', $request->selected_attributes);

        switch ($request->action) {
            case 'require':
                $attributes->update(['is_required' => true]);
                return redirect()->back()->with('success', 'Selected attributes marked as required successfully!');
                
            case 'unrequire':
                $attributes->update(['is_required' => false]);
                return redirect()->back()->with('success', 'Selected attributes marked as optional successfully!');
                
            case 'delete':
                // Check for values before deletion
                $attributesWithValues = $attributes->has('attributeValues')->count();
                if ($attributesWithValues > 0) {
                    return redirect()->back()->with('error', 
                        "Cannot delete {$attributesWithValues} attributes that have values.");
                }
                
                $attributes->delete();
                return redirect()->back()->with('success', 'Selected attributes deleted successfully!');
        }
    }

    /**
     * Show attribute values for a specific attribute.
     */
    public function values(Attribute $attribute)
    {
        $values = $attribute->attributeValues()
            ->orderBy('value')
            ->paginate(15);

        return view('admin.attributes.values', compact('attribute', 'values'));
    }

    /**
     * Show products using a specific attribute.
     */
    public function products(Attribute $attribute)
    {
        $products = $this->safeCount(function() use ($attribute) {
            return Product::whereHas('attributeValues', function($query) use ($attribute) {
                $query->where('attribute_id', $attribute->id);
            })->with(['category', 'brand'])->paginate(12);
        });

        // If products returns 0 (table doesn't exist), create empty paginator
        if ($products === 0) {
            $products = new \Illuminate\Pagination\LengthAwarePaginator(
                collect([]), 0, 12, 1, ['path' => request()->url()]
            );
        }

        return view('admin.attributes.products', compact('attribute', 'products'));
    }

    /**
     * Show contacts for a specific attribute.
     */
    public function contacts(Attribute $attribute)
    {
        $contacts = $this->safeCount(function() use ($attribute) {
            return $attribute->contacts()->with(['user', 'responses'])->latest()->paginate(10);
        });

        // If contacts returns 0 (table doesn't exist), create empty paginator
        if ($contacts === 0) {
            $contacts = new \Illuminate\Pagination\LengthAwarePaginator(
                collect([]), 0, 10, 1, ['path' => request()->url()]
            );
        }

        return view('admin.attributes.contacts', compact('attribute', 'contacts'));
    }

    /**
     * Store a new contact message for an attribute.
     */
    public function storeContact(Request $request, Attribute $attribute)
    {
        $validated = $request->validate([
            'subject' => 'required|string|max:255',
            'message' => 'required|string',
            'contact_type' => 'required|in:inquiry,complaint,suggestion,other',
            'priority' => 'required|in:low,medium,high,urgent',
        ]);

        try {
            $contact = Contact::create([
                'attribute_id' => $attribute->id,
                'user_id' => auth()->id(),
                'subject' => $validated['subject'],
                'message' => $validated['message'],
                'contact_type' => $validated['contact_type'],
                'priority' => $validated['priority'],
                'status' => 'pending',
            ]);

            return redirect()->route('admin.attributes.contacts', $attribute)
                ->with('success', 'Contact message sent successfully!');
        } catch (\Illuminate\Database\QueryException $e) {
            if (str_contains($e->getMessage(), "doesn't exist")) {
                return redirect()->route('admin.attributes.contacts', $attribute)
                    ->with('error', 'Contact system not yet available. Please complete system setup first.');
            }
            throw $e;
        }
    }

    /**
     * Show attribute analytics.
     */
    public function analytics(Attribute $attribute)
    {
        $analytics = [
            'total_values' => $attribute->attributeValues()->count(),
            'total_products' => $this->safeCount(function() use ($attribute) {
                return Product::whereHas('attributeValues', function($query) use ($attribute) {
                    $query->where('attribute_id', $attribute->id);
                })->count();
            }),
            'total_contacts' => $this->safeCount(function() use ($attribute) {
                return $attribute->contacts()->count();
            }),
            'pending_contacts' => $this->safeCount(function() use ($attribute) {
                return $attribute->contacts()->where('status', 'pending')->count();
            }),
            'usage_rate' => 0, // Can be calculated based on products using this attribute
            'type_label' => ucfirst($attribute->type),
            'required_label' => $attribute->is_required ? 'Required' : 'Optional',
        ];

        return view('admin.attributes.analytics', compact('attribute', 'analytics'));
    }
}
