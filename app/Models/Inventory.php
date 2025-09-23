<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Builder;

class Inventory extends Model
{
    use HasFactory;

    protected $fillable = [
        'product_id',
        'warehouse_id',
        'quantity',
        'minimum_stock',
        'reorder_level',
    ];

    protected $casts = [
        'quantity' => 'integer',
        'minimum_stock' => 'integer',
        'reorder_level' => 'integer',
    ];

    /**
     * Get the product that owns the inventory.
     */
    public function product(): BelongsTo
    {
        return $this->belongsTo(Product::class);
    }

    /**
     * Get the warehouse that owns the inventory.
     */
    public function warehouse(): BelongsTo
    {
        return $this->belongsTo(Warehouse::class);
    }

    /**
     * Scope a query to only include low stock items.
     */
    public function scopeLowStock(Builder $query): void
    {
        $query->whereColumn('quantity', '<=', 'minimum_stock');
    }

    /**
     * Scope a query to only include items that need reordering.
     */
    public function scopeNeedReorder(Builder $query): void
    {
        $query->whereColumn('quantity', '<=', 'reorder_level');
    }

    /**
     * Scope a query to only include out of stock items.
     */
    public function scopeOutOfStock(Builder $query): void
    {
        $query->where('quantity', '<=', 0);
    }

    /**
     * Scope a query to only include in stock items.
     */
    public function scopeInStock(Builder $query): void
    {
        $query->where('quantity', '>', 0);
    }

    /**
     * Scope a query by warehouse.
     */
    public function scopeByWarehouse(Builder $query, $warehouseId): void
    {
        $query->where('warehouse_id', $warehouseId);
    }

    /**
     * Scope a query by product.
     */
    public function scopeByProduct(Builder $query, $productId): void
    {
        $query->where('product_id', $productId);
    }

    /**
     * Check if the item is low on stock.
     */
    public function isLowStock(): bool
    {
        return $this->quantity <= $this->minimum_stock;
    }

    /**
     * Check if the item needs reordering.
     */
    public function requiresReorder(): bool
    {
        return $this->quantity <= $this->reorder_level;
    }

    /**
     * Check if the item needs reordering (alias for backward compatibility).
     */
    public function needsReorder(): bool
    {
        return $this->requiresReorder();
    }

    /**
     * Check if the item is out of stock.
     */
    public function isOutOfStock(): bool
    {
        return $this->quantity <= 0;
    }

    /**
     * Check if the item is in stock.
     */
    public function isInStock(): bool
    {
        return $this->quantity > 0;
    }

    /**
     * Get the stock status.
     */
    public function getStockStatus(): string
    {
        if ($this->isOutOfStock()) {
            return 'Out of Stock';
        } elseif ($this->isLowStock()) {
            return 'Low Stock';
        } elseif ($this->requiresReorder()) {
            return 'Needs Reorder';
        } else {
            return 'In Stock';
        }
    }

    /**
     * Get the stock status color.
     */
    public function getStockStatusColor(): string
    {
        if ($this->isOutOfStock()) {
            return 'danger';
        } elseif ($this->isLowStock()) {
            return 'warning';
        } elseif ($this->needsReorder()) {
            return 'info';
        } else {
            return 'success';
        }
    }

    /**
     * Calculate stock value based on product price.
     */
    public function getStockValue(): float
    {
        if ($this->product && $this->product->regular_price) {
            return $this->quantity * $this->product->regular_price;
        }
        return 0.0;
    }

    /**
     * Get inventory statistics.
     */
    public static function getInventoryStatistics(): array
    {
        return [
            'total_items' => self::count(),
            'total_quantity' => self::sum('quantity'),
            'low_stock_items' => self::lowStock()->count(),
            'out_of_stock_items' => self::outOfStock()->count(),
            'needs_reorder_items' => self::needReorder()->count(),
            'in_stock_items' => self::inStock()->count(),
            'total_warehouses' => self::distinct('warehouse_id')->count(),
            'total_products' => self::distinct('product_id')->count(),
        ];
    }

    /**
     * Get inventory by warehouse statistics.
     */
    public static function getWarehouseStatistics($warehouseId): array
    {
        $query = self::byWarehouse($warehouseId);
        
        return [
            'total_items' => $query->count(),
            'total_quantity' => $query->sum('quantity'),
            'low_stock_items' => $query->lowStock()->count(),
            'out_of_stock_items' => $query->outOfStock()->count(),
            'needs_reorder_items' => $query->needReorder()->count(),
            'in_stock_items' => $query->inStock()->count(),
            'total_products' => $query->distinct('product_id')->count(),
        ];
    }

    /**
     * Get inventory by product statistics.
     */
    public static function getProductStatistics($productId): array
    {
        $query = self::byProduct($productId);
        
        return [
            'total_warehouses' => $query->count(),
            'total_quantity' => $query->sum('quantity'),
            'average_quantity' => $query->avg('quantity'),
            'max_quantity' => $query->max('quantity'),
            'min_quantity' => $query->min('quantity'),
            'warehouses_in_stock' => $query->inStock()->count(),
            'warehouses_out_of_stock' => $query->outOfStock()->count(),
        ];
    }
}