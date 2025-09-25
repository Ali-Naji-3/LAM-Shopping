<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class Product extends Model
{
    use SoftDeletes;
    
    protected $fillable = [
        'name', 'slug', 'sku', 'short_description', 'description', 
        'regular_price', 'sale_price', 'featured', 'status', 'quantity', 
        'image', 'images', 'category_id', 'brand_id', 'weight', 'dimensions',
        'meta_title', 'meta_description'
    ];

    protected $casts = [
        'regular_price' => 'decimal:2',
        'sale_price' => 'decimal:2',
        'weight' => 'decimal:2',
        'featured' => 'boolean',
        'images' => 'array',
        'dimensions' => 'array',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
        'deleted_at' => 'datetime',
    ];

    // Auto-generate slug from name if not provided
    public function setNameAttribute($value)
    {
        $this->attributes['name'] = $value;
        
        // Generate slug if not already set
        if (empty($this->attributes['slug'])) {
            $this->attributes['slug'] = \Str::slug($value);
        }
    }

    // Model Events for Data Synchronization
    protected static function booted()
    {
        // When product is being deleted
        static::deleting(function ($product) {
            \Log::info("🗑️ Deleting product: {$product->name} (SKU: {$product->sku})");
            
            // Check for active orders
            $activeOrdersCount = $product->orderItems()
                ->join('orders', 'order_items.order_id', '=', 'orders.id')
                ->whereIn('orders.status', ['pending', 'confirmed', 'processing', 'shipped'])
                ->count();
                
            if ($activeOrdersCount > 0) {
                throw new \Exception("Cannot delete product '{$product->name}': {$activeOrdersCount} active orders contain this product. Please wait for orders to be delivered or cancel them first.");
            }
            
            // Archive completed order items (for historical data)
            $completedOrderItems = $product->orderItems()
                ->join('orders', 'order_items.order_id', '=', 'orders.id')
                ->whereIn('orders.status', ['delivered', 'cancelled'])
                ->count();
            \Log::info("📋 {$completedOrderItems} completed order items will be preserved for history");
            
            // Clear inventory records
            $inventoryRecords = $product->inventory()->count();
            if ($inventoryRecords > 0) {
                $product->inventory()->delete();
                \Log::info("📦 Cleared {$inventoryRecords} inventory records");
            }
            
            // Archive product reviews (soft delete)
            $reviewsCount = $product->reviews()->count();
            if ($reviewsCount > 0) {
                $product->reviews()->delete(); // Soft delete if Review model uses SoftDeletes
                \Log::info("⭐ Archived {$reviewsCount} product reviews");
            }
            
            // Remove attribute assignments
            $attributesCount = $product->productAttributes()->count();
            if ($attributesCount > 0) {
                $product->productAttributes()->delete();
                \Log::info("🔧 Removed {$attributesCount} attribute assignments");
            }
            
            // Update contacts related to this product
            $contactsCount = \DB::table('contacts')
                ->where('subject', 'LIKE', "%{$product->name}%")
                ->orWhere('message', 'LIKE', "%{$product->name}%")
                ->count();
            
            if ($contactsCount > 0) {
                \DB::table('contacts')
                    ->where('subject', 'LIKE', "%{$product->name}%")
                    ->orWhere('message', 'LIKE', "%{$product->name}%")
                    ->update([
                        'subject' => \DB::raw("CONCAT('[PRODUCT DISCONTINUED] ', subject)"),
                        'status' => 'resolved',
                        'updated_at' => now()
                    ]);
                \Log::info("📞 Updated {$contactsCount} related contacts");
            }
        });
        
        // When product is updated
        static::updated(function ($product) {
            if ($product->wasChanged('status')) {
                \Log::info("📝 Product status changed: {$product->name} -> {$product->status}");
                
                if ($product->status === 'inactive' || $product->status === 'draft') {
                    // Remove from active inventory if product becomes inactive
                    $product->inventory()->where('quantity', '>', 0)->update(['quantity' => 0]);
                }
            }
            
            if ($product->wasChanged('regular_price') || $product->wasChanged('sale_price')) {
                \Log::info("💰 Product pricing updated: {$product->name}");
                
                // Update any pending orders with new pricing (optional business logic)
                $pendingOrderItems = $product->orderItems()
                    ->join('orders', 'order_items.order_id', '=', 'orders.id')
                    ->where('orders.status', 'pending')
                    ->count();
                    
                if ($pendingOrderItems > 0) {
                    \Log::info("⚠️ {$pendingOrderItems} pending orders may need price adjustment");
                }
            }
            
            if ($product->wasChanged('category_id')) {
                \Log::info("📂 Product moved to new category: {$product->name}");
                
                // Update inventory records if needed
                $product->inventory()->touch();
            }
        });
        
        // When product is restored
        static::restored(function ($product) {
            \Log::info("♻️ Product restored: {$product->name}");
            
            // Restore related reviews if they were soft deleted
            $product->reviews()->withTrashed()->restore();
            
            // Optionally restore inventory to a default level
            $product->inventory()->update(['quantity' => 10]); // Default stock level
        });
        
        // When product is created
        static::created(function ($product) {
            \Log::info("✨ New product created: {$product->name} (SKU: {$product->sku})");
            
            // Auto-create inventory records in all warehouses
            $warehouses = \App\Models\Warehouse::where('is_active', true)->get();
            foreach ($warehouses as $warehouse) {
                \App\Models\Inventory::create([
                    'product_id' => $product->id,
                    'warehouse_id' => $warehouse->id,
                    'quantity' => 0,
                    'minimum_stock' => 5,
                    'reorder_level' => 10,
                ]);
            }
            \Log::info("📦 Created inventory records in {$warehouses->count()} warehouses");
        });
    }

    // Relationships
    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class);
    }

    public function brand(): BelongsTo
    {
        return $this->belongsTo(Brand::class);
    }

    public function reviews(): HasMany
    {
        return $this->hasMany(Review::class);
    }

    public function orderItems(): HasMany
    {
        return $this->hasMany(OrderItem::class);
    }

    public function inventory(): HasMany
    {
        return $this->hasMany(Inventory::class);
    }

    public function productAttributes(): HasMany
    {
        return $this->hasMany(ProductAttribute::class);
    }

    // Helper methods
    public function getEffectivePriceAttribute()
    {
        return $this->sale_price ?? $this->regular_price;
    }

    public function getDiscountPercentageAttribute()
    {
        if ($this->sale_price && $this->regular_price > $this->sale_price) {
            return round((($this->regular_price - $this->sale_price) / $this->regular_price) * 100);
        }
        return 0;
    }

    public function getTotalStockAttribute()
    {
        return $this->inventory()->sum('quantity');
    }

    public function getAverageRatingAttribute()
    {
        return $this->reviews()->where('is_approved', true)->avg('rating') ?? 0;
    }

    public function getTotalReviewsAttribute()
    {
        return $this->reviews()->where('is_approved', true)->count();
    }

    // Scopes
    public function scopeActive($query)
    {
        return $query->where('status', 'active');
    }

    public function scopeFeatured($query)
    {
        return $query->where('featured', true);
    }

    public function scopeInStock($query)
    {
        return $query->where('quantity', '>', 0);
    }

    public function scopeOnSale($query)
    {
        return $query->whereNotNull('sale_price');
    }
}
