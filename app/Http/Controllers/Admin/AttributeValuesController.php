<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Attribute;
use App\Models\AttributeValue;
use Illuminate\Http\Request;

class AttributeValuesController extends Controller
{
    /**
     * Display a listing of all attribute values.
     */
    public function index(Request $request)
    {
        $query = AttributeValue::with('attribute');

        // Search functionality
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('value', 'like', "%{$search}%")
                  ->orWhereHas('attribute', function($subQ) use ($search) {
                      $subQ->where('name', 'like', "%{$search}%");
                  });
            });
        }

        // Filter by attribute
        if ($request->filled('attribute_id')) {
            $query->where('attribute_id', $request->attribute_id);
        }

        $attributeValues = $query->orderBy('attribute_id')
                                ->orderBy('value')
                                ->paginate(20);

        $attributes = Attribute::orderBy('name')->get();

        return view('admin.attribute-values.index', compact('attributeValues', 'attributes'));
    }

    /**
     * Show the form for creating a new attribute value.
     */
    public function create()
    {
        $attributes = Attribute::orderBy('name')->get();
        return view('admin.attribute-values.create', compact('attributes'));
    }

    /**
     * Store a newly created attribute value in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'attribute_id' => 'required|exists:attributes,id',
            'value' => 'required|string|max:255',
            'values' => 'nullable|array', // For bulk creation
            'values.*' => 'string|max:255'
        ]);

        // Single value creation
        if ($request->filled('value')) {
            // Check for duplicate values within the same attribute
            $attribute = Attribute::findOrFail($validated['attribute_id']);
            if ($attribute->attributeValues()->where('value', $validated['value'])->exists()) {
                return redirect()->back()
                    ->withInput()
                    ->with('error', 'This value already exists for the selected attribute.');
            }

            AttributeValue::create([
                'attribute_id' => $validated['attribute_id'],
                'value' => $validated['value']
            ]);

            return redirect()->route('admin.attributeValues.index')
                ->with('success', 'Attribute value created successfully!');
        }

        // Bulk value creation
        if ($request->filled('values')) {
            $attribute = Attribute::findOrFail($validated['attribute_id']);
            $created = 0;
            $skipped = 0;

            foreach ($validated['values'] as $value) {
                $value = trim($value);
                if (empty($value)) continue;

                // Skip if value already exists
                if ($attribute->attributeValues()->where('value', $value)->exists()) {
                    $skipped++;
                    continue;
                }

                AttributeValue::create([
                    'attribute_id' => $validated['attribute_id'],
                    'value' => $value
                ]);
                $created++;
            }

            $message = "Created {$created} values";
            if ($skipped > 0) {
                $message .= ", skipped {$skipped} duplicates";
            }

            return redirect()->route('admin.attributeValues.index')
                ->with('success', $message . '!');
        }

        return redirect()->back()->with('error', 'Please provide at least one value.');
    }

    /**
     * Display the specified attribute value.
     */
    public function show(AttributeValue $attributeValue)
    {
        $attributeValue->load(['attribute', 'products']);
        
        // Calculate usage statistics
        $usageStats = [
            'products_count' => $attributeValue->products()->count(),
            'total_revenue' => $attributeValue->products()->sum('regular_price') ?? 0,
            'average_price' => $attributeValue->products()->avg('regular_price') ?? 0,
        ];

        return view('admin.attribute-values.show', compact('attributeValue', 'usageStats'));
    }

    /**
     * Show the form for editing the specified attribute value.
     */
    public function edit(AttributeValue $attributeValue)
    {
        $attributes = Attribute::orderBy('name')->get();
        return view('admin.attribute-values.edit', compact('attributeValue', 'attributes'));
    }

    /**
     * Update the specified attribute value in storage.
     */
    public function update(Request $request, AttributeValue $attributeValue)
    {
        $validated = $request->validate([
            'attribute_id' => 'required|exists:attributes,id',
            'value' => 'required|string|max:255'
        ]);

        // Check for duplicate values within the same attribute (excluding current)
        $attribute = Attribute::findOrFail($validated['attribute_id']);
        if ($attribute->attributeValues()
            ->where('value', $validated['value'])
            ->where('id', '!=', $attributeValue->id)
            ->exists()) {
            return redirect()->back()
                ->withInput()
                ->with('error', 'This value already exists for the selected attribute.');
        }

        $attributeValue->update($validated);

        return redirect()->route('admin.attributeValues.index')
            ->with('success', 'Attribute value updated successfully!');
    }

    /**
     * Remove the specified attribute value from storage.
     */
    public function destroy(AttributeValue $attributeValue)
    {
        // Check if value is used by products
        $productsUsingValue = $attributeValue->products()->count();

        if ($productsUsingValue > 0) {
            return redirect()->route('admin.attributeValues.index')
                ->with('error', "Cannot delete value used by {$productsUsingValue} products. Please remove from products first.");
        }

        $attributeValue->delete();

        return redirect()->route('admin.attributeValues.index')
            ->with('success', 'Attribute value deleted successfully!');
    }

    /**
     * Handle bulk actions for attribute values.
     */
    public function bulkActions(Request $request)
    {
        $request->validate([
            'action' => 'required|in:delete',
            'selected_values' => 'required|array|min:1',
            'selected_values.*' => 'exists:attribute_values,id'
        ]);

        $values = AttributeValue::whereIn('id', $request->selected_values);

        switch ($request->action) {
            case 'delete':
                // Check for products using these values
                $valuesWithProducts = 0;
                foreach ($values->get() as $value) {
                    if ($value->products()->count() > 0) {
                        $valuesWithProducts++;
                    }
                }

                if ($valuesWithProducts > 0) {
                    return redirect()->back()->with('error', 
                        "Cannot delete {$valuesWithProducts} values that are used by products.");
                }
                
                $values->delete();
                return redirect()->back()->with('success', 'Selected values deleted successfully!');
        }
    }

    /**
     * Show products using a specific attribute value.
     */
    public function products(AttributeValue $attributeValue)
    {
        $products = $attributeValue->products()
            ->with(['category', 'brand'])
            ->paginate(12);

        return view('admin.attribute-values.products', compact('attributeValue', 'products'));
    }

    /**
     * Bulk import attribute values from CSV or text.
     */
    public function bulkImport(Request $request)
    {
        $request->validate([
            'attribute_id' => 'required|exists:attributes,id',
            'import_method' => 'required|in:csv,text',
            'csv_file' => 'required_if:import_method,csv|file|mimes:csv,txt',
            'text_values' => 'required_if:import_method,text|string'
        ]);

        $attribute = Attribute::findOrFail($request->attribute_id);
        $values = [];
        $created = 0;
        $skipped = 0;

        if ($request->import_method === 'csv' && $request->hasFile('csv_file')) {
            $file = $request->file('csv_file');
            $content = file_get_contents($file->getRealPath());
            $lines = explode("\n", $content);
            
            foreach ($lines as $line) {
                $value = trim($line);
                if (!empty($value)) {
                    $values[] = $value;
                }
            }
        } elseif ($request->import_method === 'text') {
            $lines = explode("\n", $request->text_values);
            foreach ($lines as $line) {
                $value = trim($line);
                if (!empty($value)) {
                    $values[] = $value;
                }
            }
        }

        foreach ($values as $value) {
            // Skip if value already exists
            if ($attribute->attributeValues()->where('value', $value)->exists()) {
                $skipped++;
                continue;
            }

            AttributeValue::create([
                'attribute_id' => $attribute->id,
                'value' => $value
            ]);
            $created++;
        }

        $message = "Imported {$created} values";
        if ($skipped > 0) {
            $message .= ", skipped {$skipped} duplicates";
        }

        return redirect()->route('admin.attributeValues.index')
            ->with('success', $message . '!');
    }
}