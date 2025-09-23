<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Warehouse;
use App\Models\Inventory;
use App\Models\Contact;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class WarehousesController extends Controller
{
    /**
     * Display a listing of the warehouses.
     */
    public function index(Request $request)
    {
        $query = Warehouse::query();

        // Search functionality
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('code', 'like', "%{$search}%")
                  ->orWhere('location', 'like', "%{$search}%")
                  ->orWhere('manager', 'like', "%{$search}%");
            });
        }

        // Filter by status
        if ($request->filled('status')) {
            $query->where('is_active', $request->status === 'active');
        }

        // Filter by location
        if ($request->filled('location')) {
            $query->where('location', 'like', "%{$request->location}%");
        }

        // Sort
        $sortBy = $request->get('sort_by', 'name');
        $sortOrder = $request->get('sort_order', 'asc');
        $query->orderBy($sortBy, $sortOrder);

        $warehouses = $query->paginate(10);

        // Statistics
        $statistics = $this->getStatistics($request);

        // Get unique locations for filter
        $locations = Warehouse::distinct('location')->orderBy('location')->pluck('location');

        return view('admin.warehouses.index', compact('warehouses', 'statistics', 'locations'));
    }

    /**
     * Show the form for creating a new warehouse.
     */
    public function create()
    {
        return view('admin.warehouses.create');
    }

    /**
     * Store a newly created warehouse in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'code' => 'required|string|max:50|unique:warehouses,code',
            'location' => 'required|string|max:255',
            'manager' => 'nullable|string|max:255',
            'contact_number' => 'nullable|string|max:20',
            'is_active' => 'boolean',
        ]);

        try {
            $warehouse = Warehouse::create([
                'name' => $request->name,
                'code' => $request->code,
                'location' => $request->location,
                'manager' => $request->manager,
                'contact_number' => $request->contact_number,
                'is_active' => $request->has('is_active'),
            ]);

            return redirect()->route('admin.warehouses.index')
                ->with('success', 'Warehouse created successfully!');
        } catch (\Exception $e) {
            return back()->withInput()
                ->with('error', 'Failed to create warehouse: ' . $e->getMessage());
        }
    }

    /**
     * Display the specified warehouse.
     */
    public function show(Warehouse $warehouse)
    {
        // Safe loading - only load contacts, skip inventory if table doesn't exist
        try {
            $warehouse->load(['inventory.product', 'contacts.responses']);
        } catch (\Illuminate\Database\QueryException $e) {
            if (str_contains($e->getMessage(), "doesn't exist")) {
                // Load only contacts if inventory table doesn't exist
                $warehouse->load(['contacts.responses']);
            } else {
                throw $e;
            }
        }
        
        // Calculate connection counts
        $connectionCounts = [
            'inventory_count' => $this->safeCount(function() use ($warehouse) {
                return $warehouse->inventory()->count();
            }),
            'contacts_count' => $warehouse->contacts()->count(),
            'total_stock' => $this->safeCount(function() use ($warehouse) {
                return $warehouse->inventory()->sum('stock_quantity');
            }),
            'total_value' => $this->safeCount(function() use ($warehouse) {
                return $warehouse->inventory()->sum('value');
            }),
            'pending_contacts' => $warehouse->contacts()->where('status', 'pending')->count(),
        ];

        return view('admin.warehouses.show', compact('warehouse', 'connectionCounts'));
    }

    /**
     * Show the form for editing the specified warehouse.
     */
    public function edit(Warehouse $warehouse)
    {
        // Get warehouse analytics for sidebar
        $warehouseAnalytics = [
            'inventory_count' => $this->safeCount(function() use ($warehouse) {
                return $warehouse->inventory()->count();
            }),
            'contacts_count' => $warehouse->contacts()->count(),
            'total_stock' => $this->safeCount(function() use ($warehouse) {
                return $warehouse->inventory()->sum('stock_quantity');
            }),
            'pending_contacts' => $warehouse->contacts()->where('status', 'pending')->count(),
        ];

        return view('admin.warehouses.edit', compact('warehouse', 'warehouseAnalytics'));
    }

    /**
     * Update the specified warehouse in storage.
     */
    public function update(Request $request, Warehouse $warehouse)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'code' => 'required|string|max:50|unique:warehouses,code,' . $warehouse->id,
            'location' => 'required|string|max:255',
            'manager' => 'nullable|string|max:255',
            'contact_number' => 'nullable|string|max:20',
            'is_active' => 'boolean',
        ]);

        try {
            $warehouse->update([
                'name' => $request->name,
                'code' => $request->code,
                'location' => $request->location,
                'manager' => $request->manager,
                'contact_number' => $request->contact_number,
                'is_active' => $request->has('is_active'),
            ]);

            return redirect()->route('admin.warehouses.show', $warehouse)
                ->with('success', 'Warehouse updated successfully!');
        } catch (\Exception $e) {
            return back()->withInput()
                ->with('error', 'Failed to update warehouse: ' . $e->getMessage());
        }
    }

    /**
     * Remove the specified warehouse from storage.
     */
    public function destroy(Warehouse $warehouse)
    {
        try {
            // Check if warehouse has inventory
            $inventoryCount = $this->safeCount(function() use ($warehouse) {
                return $warehouse->inventory()->count();
            });

            if ($inventoryCount > 0) {
                return back()->with('error', 'Cannot delete warehouse with existing inventory. Please transfer or remove inventory first.');
            }

            $warehouse->delete();

            return redirect()->route('admin.warehouses.index')
                ->with('success', 'Warehouse deleted successfully!');
        } catch (\Exception $e) {
            return back()->with('error', 'Failed to delete warehouse: ' . $e->getMessage());
        }
    }

    /**
     * Handle bulk actions for warehouses.
     */
    public function bulkActions(Request $request)
    {
        $request->validate([
            'action' => 'required|in:activate,deactivate,delete',
            'selected_warehouses' => 'required|array|min:1',
            'selected_warehouses.*' => 'exists:warehouses,id',
        ]);

        try {
            switch ($request->action) {
                case 'activate':
                    Warehouse::whereIn('id', $request->selected_warehouses)
                        ->update(['is_active' => true]);
                    $message = count($request->selected_warehouses) . ' warehouses activated successfully!';
                    break;

                case 'deactivate':
                    Warehouse::whereIn('id', $request->selected_warehouses)
                        ->update(['is_active' => false]);
                    $message = count($request->selected_warehouses) . ' warehouses deactivated successfully!';
                    break;

                case 'delete':
                    // Check for inventory in selected warehouses
                    $warehousesWithInventory = $this->safeCount(function() use ($request) {
                        return Warehouse::whereIn('id', $request->selected_warehouses)
                            ->whereHas('inventory')
                            ->count();
                    });

                    if ($warehousesWithInventory > 0) {
                        return back()->with('error', 'Cannot delete warehouses with existing inventory.');
                    }

                    Warehouse::whereIn('id', $request->selected_warehouses)->delete();
                    $message = count($request->selected_warehouses) . ' warehouses deleted successfully!';
                    break;
            }

            return redirect()->route('admin.warehouses.index')->with('success', $message);
        } catch (\Exception $e) {
            return back()->with('error', 'Bulk action failed: ' . $e->getMessage());
        }
    }

    /**
     * Toggle warehouse status.
     */
    public function toggleStatus(Warehouse $warehouse)
    {
        try {
            $warehouse->update(['is_active' => !$warehouse->is_active]);
            
            $status = $warehouse->is_active ? 'activated' : 'deactivated';
            return back()->with('success', "Warehouse {$status} successfully!");
        } catch (\Exception $e) {
            return back()->with('error', 'Failed to update warehouse status: ' . $e->getMessage());
        }
    }

    /**
     * Show warehouse inventory.
     */
    public function inventory(Warehouse $warehouse)
    {
        $inventory = $this->safeQuery(function() use ($warehouse) {
            return $warehouse->inventory()->with(['product.category', 'product.brand'])->paginate(12);
        }, collect());

        return view('admin.warehouses.inventory', compact('warehouse', 'inventory'));
    }

    /**
     * Show warehouse contacts.
     */
    public function contacts(Warehouse $warehouse)
    {
        $contacts = $warehouse->contacts()->with('responses')->latest()->paginate(10);
        
        return view('admin.warehouses.contacts', compact('warehouse', 'contacts'));
    }

    /**
     * Show warehouse analytics.
     */
    public function analytics(Warehouse $warehouse)
    {
        // Warehouse-specific analytics
        $warehouseStats = [
            'total_inventory' => $this->safeCount(function() use ($warehouse) {
                return $warehouse->inventory()->count();
            }),
            'total_stock' => $this->safeCount(function() use ($warehouse) {
                return $warehouse->inventory()->sum('stock_quantity');
            }),
            'total_value' => $this->safeCount(function() use ($warehouse) {
                return $warehouse->inventory()->sum('value');
            }),
            'low_stock_items' => $this->safeCount(function() use ($warehouse) {
                return $warehouse->inventory()->where('stock_quantity', '<', 10)->count();
            }),
            'out_of_stock_items' => $this->safeCount(function() use ($warehouse) {
                return $warehouse->inventory()->where('stock_quantity', 0)->count();
            }),
            'contacts_count' => $warehouse->contacts()->count(),
            'pending_contacts' => $warehouse->contacts()->where('status', 'pending')->count(),
        ];

        return view('admin.warehouses.analytics', compact('warehouse', 'warehouseStats'));
    }

    /**
     * Get statistics for the index page.
     */
    private function getStatistics(Request $request)
    {
        $query = Warehouse::query();

        // Apply same filters as index
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('code', 'like', "%{$search}%")
                  ->orWhere('location', 'like', "%{$search}%")
                  ->orWhere('manager', 'like', "%{$search}%");
            });
        }

        if ($request->filled('status')) {
            $query->where('is_active', $request->status === 'active');
        }

        if ($request->filled('location')) {
            $query->where('location', 'like', "%{$request->location}%");
        }

        return [
            'total_warehouses' => $query->count(),
            'active_warehouses' => $query->where('is_active', true)->count(),
            'inactive_warehouses' => $query->where('is_active', false)->count(),
            'unique_locations' => $query->distinct('location')->count(),
            'total_inventory' => $this->safeCount(function() use ($query) {
                return $query->withCount('inventory')->get()->sum('inventory_count');
            }),
            'managed_warehouses' => $query->whereNotNull('manager')->count(),
        ];
    }

    /**
     * Safe count helper to handle missing tables.
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
     * Safe query helper to handle missing tables.
     */
    private function safeQuery(callable $callback, $default = null)
    {
        try {
            return $callback();
        } catch (\Illuminate\Database\QueryException $e) {
            if (str_contains($e->getMessage(), "doesn't exist")) {
                return $default ?? collect();
            }
            throw $e;
        }
    }
}
