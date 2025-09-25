<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Inventory;
use App\Models\Product;
use App\Models\Warehouse;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class InventoryController extends Controller
{
    /**
     * Display a listing of the inventory.
     */
    public function index(Request $request): View
    {
        $query = Inventory::with(['product', 'warehouse']);

        // Search functionality
        if ($request->filled('search')) {
            $search = $request->input('search');
            $query->whereHas('product', function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('sku', 'like', "%{$search}%");
            })->orWhereHas('warehouse', function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('code', 'like', "%{$search}%");
            });
        }

        // Filter by warehouse
        if ($request->filled('warehouse_id')) {
            $query->where('warehouse_id', $request->input('warehouse_id'));
        }

        // Filter by stock status
        if ($request->filled('stock_status')) {
            switch ($request->input('stock_status')) {
                case 'out_of_stock':
                    $query->outOfStock();
                    break;
                case 'low_stock':
                    $query->lowStock();
                    break;
                case 'needs_reorder':
                    $query->needReorder();
                    break;
                case 'in_stock':
                    $query->inStock();
                    break;
            }
        }

        // Sort functionality
        $sortBy = $request->input('sort_by', 'created_at');
        $sortOrder = $request->input('sort_order', 'desc');
        
        if (in_array($sortBy, ['quantity', 'minimum_stock', 'reorder_level', 'created_at'])) {
            $query->orderBy($sortBy, $sortOrder);
        }

        $inventories = $query->paginate(15)->withQueryString();
        $warehouses = Warehouse::where('is_active', true)->get();
        $statistics = Inventory::getInventoryStatistics();

        return view('admin.inventory.index', compact('inventories', 'warehouses', 'statistics'));
    }

    /**
     * Show the form for creating a new inventory record.
     */
    public function create(): View
    {
        $products = Product::where('status', 'active')->get();
        $warehouses = Warehouse::where('is_active', true)->get();

        return view('admin.inventory.create', compact('products', 'warehouses'));
    }

    /**
     * Store a newly created inventory record in storage.
     */
    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'product_id' => 'required|exists:products,id',
            'warehouse_id' => 'required|exists:warehouses,id',
            'quantity' => 'required|integer|min:0',
            'minimum_stock' => 'required|integer|min:0',
            'reorder_level' => 'required|integer|min:0',
        ]);

        // Check if inventory record already exists for this product-warehouse combination
        $existingInventory = Inventory::where('product_id', $validated['product_id'])
            ->where('warehouse_id', $validated['warehouse_id'])
            ->first();

        if ($existingInventory) {
            return redirect()->back()
                ->withInput()
                ->withErrors(['product_id' => 'Inventory record already exists for this product in the selected warehouse.']);
        }

        Inventory::create($validated);

        return redirect()->route('admin.inventory.index')
            ->with('success', 'Inventory record created successfully.');
    }

    /**
     * Display the specified inventory record.
     */
    public function show(Inventory $inventory): View
    {
        $inventory->load(['product.category', 'product.brand', 'warehouse']);
        
        // Get related inventory records for the same product in other warehouses
        $relatedInventories = Inventory::with('warehouse')
            ->where('product_id', $inventory->product_id)
            ->where('id', '!=', $inventory->id)
            ->get();

        // Get statistics for this specific inventory
        $statistics = [
            'product_total_quantity' => Inventory::byProduct($inventory->product_id)->sum('quantity'),
            'warehouse_total_items' => Inventory::byWarehouse($inventory->warehouse_id)->count(),
            'product_warehouses' => Inventory::byProduct($inventory->product_id)->count(),
            'stock_value' => $inventory->getStockValue(),
        ];

        return view('admin.inventory.show', compact('inventory', 'relatedInventories', 'statistics'));
    }

    /**
     * Show the form for editing the specified inventory record.
     */
    public function edit(Inventory $inventory): View
    {
        $inventory->load(['product', 'warehouse']);
        $products = Product::where('status', 'active')->get();
        $warehouses = Warehouse::where('is_active', true)->get();

        return view('admin.inventory.edit', compact('inventory', 'products', 'warehouses'));
    }

    /**
     * Update the specified inventory record in storage.
     */
    public function update(Request $request, Inventory $inventory): RedirectResponse
    {
        $validated = $request->validate([
            'product_id' => 'required|exists:products,id',
            'warehouse_id' => 'required|exists:warehouses,id',
            'quantity' => 'required|integer|min:0',
            'minimum_stock' => 'required|integer|min:0',
            'reorder_level' => 'required|integer|min:0',
        ]);

        // Check if inventory record already exists for this product-warehouse combination (excluding current record)
        $existingInventory = Inventory::where('product_id', $validated['product_id'])
            ->where('warehouse_id', $validated['warehouse_id'])
            ->where('id', '!=', $inventory->id)
            ->first();

        if ($existingInventory) {
            return redirect()->back()
                ->withInput()
                ->withErrors(['product_id' => 'Inventory record already exists for this product in the selected warehouse.']);
        }

        $inventory->update($validated);

        return redirect()->route('admin.inventory.index')
            ->with('success', 'Inventory record updated successfully.');
    }

    /**
     * Remove the specified inventory record from storage.
     */
    public function destroy(Inventory $inventory): RedirectResponse
    {
        $productName = $inventory->product->name ?? 'Unknown Product';
        $warehouseName = $inventory->warehouse->name ?? 'Unknown Warehouse';
        
        $inventory->delete();

        return redirect()->route('admin.inventory.index')
            ->with('success', "Inventory record for '{$productName}' at '{$warehouseName}' deleted successfully.");
    }

    /**
     * Handle bulk actions for inventory records.
     */
    public function bulkActions(Request $request): RedirectResponse
    {
        $request->validate([
            'action' => 'required|in:delete,adjust_quantity,set_reorder_level',
            'selected_items' => 'required|array|min:1',
            'selected_items.*' => 'exists:inventories,id',
            'adjustment_value' => 'nullable|integer',
        ]);

        $selectedItems = $request->input('selected_items');
        $action = $request->input('action');

        switch ($action) {
            case 'delete':
                Inventory::whereIn('id', $selectedItems)->delete();
                $message = count($selectedItems) . ' inventory records deleted successfully.';
                break;

            case 'adjust_quantity':
                $adjustment = $request->input('adjustment_value', 0);
                Inventory::whereIn('id', $selectedItems)
                    ->update(['quantity' => \DB::raw("GREATEST(0, quantity + {$adjustment})")]);
                $message = count($selectedItems) . " inventory quantities adjusted by {$adjustment}.";
                break;

            case 'set_reorder_level':
                $reorderLevel = $request->input('adjustment_value', 5);
                Inventory::whereIn('id', $selectedItems)
                    ->update(['reorder_level' => $reorderLevel]);
                $message = count($selectedItems) . " inventory reorder levels set to {$reorderLevel}.";
                break;

            default:
                $message = 'Invalid action selected.';
        }

        return redirect()->route('admin.inventory.index')->with('success', $message);
    }

    /**
     * Display inventory analytics dashboard.
     */
    public function analytics(): View
    {
        $statistics = Inventory::getInventoryStatistics();
        
        // Get top products by quantity
        $topProductsByQuantity = Inventory::with('product')
            ->select('product_id', \DB::raw('SUM(quantity) as total_quantity'))
            ->groupBy('product_id')
            ->orderBy('total_quantity', 'desc')
            ->limit(10)
            ->get();

        // Get warehouses with most inventory
        $warehousesByInventory = Inventory::with('warehouse')
            ->select('warehouse_id', \DB::raw('COUNT(*) as total_items'), \DB::raw('SUM(quantity) as total_quantity'))
            ->groupBy('warehouse_id')
            ->orderBy('total_quantity', 'desc')
            ->get();

        // Get low stock alerts
        $lowStockAlerts = Inventory::with(['product', 'warehouse'])
            ->lowStock()
            ->orderBy('quantity', 'asc')
            ->limit(20)
            ->get();

        // Get reorder alerts
        $reorderAlerts = Inventory::with(['product', 'warehouse'])
            ->needReorder()
            ->orderBy('quantity', 'asc')
            ->limit(20)
            ->get();

        return view('admin.inventory.analytics', compact(
            'statistics',
            'topProductsByQuantity',
            'warehousesByInventory',
            'lowStockAlerts',
            'reorderAlerts'
        ));
    }

    /**
     * Adjust inventory quantity (stock in/out).
     */
    public function adjustQuantity(Request $request, Inventory $inventory): RedirectResponse
    {
        $request->validate([
            'adjustment_type' => 'required|in:add,subtract,set',
            'quantity' => 'required|integer|min:0',
            'reason' => 'nullable|string|max:255',
        ]);

        $adjustmentType = $request->input('adjustment_type');
        $quantity = $request->input('quantity');
        $reason = $request->input('reason', 'Manual adjustment');

        $oldQuantity = $inventory->quantity;

        switch ($adjustmentType) {
            case 'add':
                $inventory->quantity += $quantity;
                break;
            case 'subtract':
                $inventory->quantity = max(0, $inventory->quantity - $quantity);
                break;
            case 'set':
                $inventory->quantity = $quantity;
                break;
        }

        $inventory->save();

        $message = "Inventory adjusted from {$oldQuantity} to {$inventory->quantity}. Reason: {$reason}";

        return redirect()->route('admin.inventory.show', $inventory)
            ->with('success', $message);
    }

    /**
     * Get inventory data for AJAX requests.
     */
    public function getInventoryData(Request $request)
    {
        $warehouseId = $request->input('warehouse_id');
        $productId = $request->input('product_id');

        if ($warehouseId && $productId) {
            $inventory = Inventory::where('warehouse_id', $warehouseId)
                ->where('product_id', $productId)
                ->first();

            return response()->json($inventory);
        }

        return response()->json(['error' => 'Missing parameters'], 400);
    }
}
