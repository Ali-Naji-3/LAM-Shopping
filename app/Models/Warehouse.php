<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Warehouse extends Model
{
    protected $fillable = [
        'name',
        'code',
        'location',
        'manager',
        'contact_number',
        'is_active',
    ];

    protected $casts = [
        'is_active' => 'boolean',
    ];

    // Relationships
    public function inventory(): HasMany
    {
        return $this->hasMany(Inventory::class);
    }

    public function contacts(): HasMany
    {
        return $this->hasMany(Contact::class);
    }

    // Scopes
    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    public function scopeInactive($query)
    {
        return $query->where('is_active', false);
    }

    public function scopeByLocation($query, $location)
    {
        return $query->where('location', 'like', "%{$location}%");
    }

    public function scopeByManager($query, $manager)
    {
        return $query->where('manager', 'like', "%{$manager}%");
    }

    public function scopeByCode($query, $code)
    {
        return $query->where('code', 'like', "%{$code}%");
    }

    // Helper Methods
    public function getStatusAttribute()
    {
        return $this->is_active ? 'Active' : 'Inactive';
    }

    public function getStatusColorAttribute()
    {
        return $this->is_active ? '#10b981' : '#ef4444';
    }

    public function getStatusBadgeAttribute()
    {
        return $this->is_active ? 'success' : 'danger';
    }

    public function getTotalInventoryAttribute()
    {
        try {
            return $this->inventory()->count();
        } catch (\Illuminate\Database\QueryException $e) {
            // If inventories table doesn't exist, return 0
            if (str_contains($e->getMessage(), "doesn't exist")) {
                return 0;
            }
            throw $e;
        } catch (\Exception $e) {
            return 0;
        }
    }

    public function getTotalStockAttribute()
    {
        try {
            return $this->inventory()->sum('stock_quantity');
        } catch (\Illuminate\Database\QueryException $e) {
            // If inventories table doesn't exist, return 0
            if (str_contains($e->getMessage(), "doesn't exist")) {
                return 0;
            }
            throw $e;
        } catch (\Exception $e) {
            return 0;
        }
    }

    public function getTotalValueAttribute()
    {
        try {
            return $this->inventory()->sum('value');
        } catch (\Illuminate\Database\QueryException $e) {
            // If inventories table doesn't exist, return 0
            if (str_contains($e->getMessage(), "doesn't exist")) {
                return 0;
            }
            throw $e;
        } catch (\Exception $e) {
            return 0;
        }
    }

    public function getPendingContactsAttribute()
    {
        try {
            return $this->contacts()->where('status', 'pending')->count();
        } catch (\Exception $e) {
            return 0;
        }
    }

    public function getFormattedContactNumberAttribute()
    {
        if (!$this->contact_number) {
            return 'No contact number';
        }
        
        // Format phone number (assuming US format)
        $cleaned = preg_replace('/[^0-9]/', '', $this->contact_number);
        if (strlen($cleaned) === 10) {
            return sprintf('(%s) %s-%s', 
                substr($cleaned, 0, 3),
                substr($cleaned, 3, 3),
                substr($cleaned, 6)
            );
        }
        
        return $this->contact_number;
    }

    public function getCapacityUtilizationAttribute()
    {
        // This would require a capacity field in the database
        // For now, return a calculated percentage based on inventory
        $totalItems = $this->total_inventory;
        $maxCapacity = 1000; // Default max capacity
        
        if ($maxCapacity > 0) {
            return min(100, ($totalItems / $maxCapacity) * 100);
        }
        
        return 0;
    }

    // Static Methods
    public static function getActiveWarehouses()
    {
        return self::where('is_active', true)->orderBy('name')->get();
    }

    public static function getWarehouseStatistics()
    {
        $totalInventoryItems = 0;
        $totalStockQuantity = 0;
        
        try {
            $totalInventoryItems = self::join('inventories', 'warehouses.id', '=', 'inventories.warehouse_id')->count();
            $totalStockQuantity = self::join('inventories', 'warehouses.id', '=', 'inventories.warehouse_id')
                ->sum('inventories.stock_quantity');
        } catch (\Illuminate\Database\QueryException $e) {
            // If inventories table doesn't exist, use 0
            if (str_contains($e->getMessage(), "doesn't exist")) {
                $totalInventoryItems = 0;
                $totalStockQuantity = 0;
            } else {
                throw $e;
            }
        }
        
        return [
            'total_warehouses' => self::count(),
            'active_warehouses' => self::where('is_active', true)->count(),
            'inactive_warehouses' => self::where('is_active', false)->count(),
            'total_inventory_items' => $totalInventoryItems,
            'total_stock_quantity' => $totalStockQuantity,
            'average_capacity_utilization' => 0, // Will be calculated when inventory exists
        ];
    }

    public static function generateWarehouseCode($name, $location)
    {
        // Generate warehouse code based on name and location
        $nameCode = strtoupper(substr(preg_replace('/[^A-Za-z]/', '', $name), 0, 3));
        $locationCode = strtoupper(substr(preg_replace('/[^A-Za-z]/', '', $location), 0, 2));
        $number = str_pad(self::count() + 1, 3, '0', STR_PAD_LEFT);
        
        $baseCode = $nameCode . $locationCode . $number;
        
        // Ensure uniqueness
        $counter = 1;
        $code = $baseCode;
        while (self::where('code', $code)->exists()) {
            $code = $baseCode . str_pad($counter, 2, '0', STR_PAD_LEFT);
            $counter++;
        }
        
        return $code;
    }
}