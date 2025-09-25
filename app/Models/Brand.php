<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class Brand extends Model
{
    use SoftDeletes;
    
    protected $fillable = [
        'name', 'slug', 'description', 'image', 'is_active'
    ];

    protected $casts = [
        'is_active' => 'boolean',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
        'deleted_at' => 'datetime',
    ];

    // Model Events for Data Synchronization
    protected static function booted()
    {
        // When brand is being deleted
        static::deleting(function ($brand) {
            \Log::info("🗑️ Deleting brand: {$brand->name}");
            
            // Check for active orders with products from this brand
            $activeOrdersCount = \DB::table('order_items')
                ->join('products', 'order_items.product_id', '=', 'products.id')
                ->join('orders', 'order_items.order_id', '=', 'orders.id')
                ->where('products.brand_id', $brand->id)
                ->whereIn('orders.status', ['pending', 'confirmed', 'processing', 'shipped'])
                ->count();
                
            if ($activeOrdersCount > 0) {
                throw new \Exception("Cannot delete brand '{$brand->name}': {$activeOrdersCount} active orders contain products from this brand.");
            }
            
            // Set products' brand_id to null (unbranded products)
            $productsToUnbrand = $brand->products()->count();
            if ($productsToUnbrand > 0) {
                $brand->products()->update(['brand_id' => null]);
                \Log::info("📦 Unbranded {$productsToUnbrand} products");
            }
            
            // Archive related contacts
            $contactsToArchive = $brand->contacts()->where('status', '!=', 'archived')->count();
            if ($contactsToArchive > 0) {
                $brand->contacts()->where('status', '!=', 'archived')->update([
                    'status' => 'resolved',
                    'subject' => \DB::raw("CONCAT('[ARCHIVED - Brand Discontinued] ', subject)")
                ]);
                \Log::info("📞 Archived {$contactsToArchive} contacts");
            }
        });
        
        // When brand is updated
        static::updated(function ($brand) {
            if ($brand->wasChanged('name') || $brand->wasChanged('slug')) {
                \Log::info("📝 Brand updated: {$brand->name}");
                
                // Update related products' updated_at for search indexing
                $brand->products()->touch();
            }
            
            if ($brand->wasChanged('is_active') && !$brand->is_active) {
                // If brand becomes inactive, optionally deactivate products
                $deactivatedProducts = $brand->products()->where('status', 'active')->count();
                $brand->products()->where('status', 'active')->update(['status' => 'inactive']);
                \Log::info("📦 Deactivated {$deactivatedProducts} products due to brand deactivation");
            }
        });
        
        // When brand is restored
        static::restored(function ($brand) {
            \Log::info("♻️ Brand restored: {$brand->name}");
            
            // Optionally reactivate products
            $restoredProducts = $brand->products()->where('status', 'inactive')->count();
            $brand->products()->where('status', 'inactive')->update(['status' => 'active']);
            \Log::info("📦 Reactivated {$restoredProducts} products");
        });
    }

    // Relationships
    public function products(): HasMany
    {
        return $this->hasMany(Product::class);
    }

    public function contacts(): HasMany
    {
        return $this->hasMany(Contact::class);
    }

    // Indirect relationships through products
    public function reviews(): HasMany
    {
        return $this->hasManyThrough(Review::class, Product::class);
    }

    public function orders(): HasMany
    {
        return $this->hasManyThrough(OrderItem::class, Product::class, 'brand_id', 'product_id');
    }

    public function inventory(): HasMany
    {
        return $this->hasManyThrough(Inventory::class, Product::class);
    }

    // Helper methods for analytics
    public function getTotalProductsAttribute()
    {
        return $this->products()->count();
    }

    public function getActiveProductsAttribute()
    {
        return $this->products()->where('status', 'active')->count();
    }

    public function getAverageRatingAttribute()
    {
        return $this->reviews()
            ->where('is_approved', true)
            ->avg('rating') ?? 0;
    }

    public function getTotalRevenueAttribute()
    {
        return $this->orders()
            ->join('orders', 'order_items.order_id', '=', 'orders.id')
            ->where('orders.payment_status', 'paid')
            ->sum('order_items.total_price') ?? 0;
    }

    // Scopes
    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    public function scopeWithProducts($query)
    {
        return $query->has('products');
    }

    public function scopePopular($query)
    {
        return $query->withCount('products')
            ->orderBy('products_count', 'desc');
    }
}
