<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class Category extends Model
{
    use SoftDeletes;
    
    protected $fillable = [
        'name', 'slug', 'description', 'image', 'parent_id', 'is_active', 'order', 'frontend_page_url', 'is_root_category'
    ];

    protected $casts = [
        'is_active' => 'boolean',
        'is_root_category' => 'boolean',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
        'deleted_at' => 'datetime',
    ];

    // Model Events for Data Synchronization
    protected static function booted()
    {
        // When category is being deleted
        static::deleting(function ($category) {
            \Log::info("🗑️ Deleting category: {$category->name}");
            
            // Check for active orders with products from this category
            $activeOrdersCount = \DB::table('order_items')
                ->join('products', 'order_items.product_id', '=', 'products.id')
                ->join('orders', 'order_items.order_id', '=', 'orders.id')
                ->where('products.category_id', $category->id)
                ->whereIn('orders.status', ['pending', 'confirmed', 'processing', 'shipped'])
                ->count();
                
            if ($activeOrdersCount > 0) {
                throw new \Exception("Cannot delete category '{$category->name}': {$activeOrdersCount} active orders contain products from this category.");
            }
            
            // Move products to parent category or set to null
            $productsToMove = $category->products()->count();
            if ($productsToMove > 0) {
                $newCategoryId = $category->parent_id; // Move to parent or null
                $category->products()->update(['category_id' => $newCategoryId]);
                \Log::info("📦 Moved {$productsToMove} products to category ID: " . ($newCategoryId ?? 'null'));
            }
            
            // Move subcategories to parent or make them root categories
            $subcategoriesToMove = $category->children()->count();
            if ($subcategoriesToMove > 0) {
                $category->children()->update(['parent_id' => $category->parent_id]);
                \Log::info("📂 Moved {$subcategoriesToMove} subcategories to parent");
            }
            
            // Archive related contacts
            $contactsToArchive = $category->contacts()->where('status', '!=', 'archived')->count();
            if ($contactsToArchive > 0) {
                $category->contacts()->where('status', '!=', 'archived')->update([
                    'status' => 'resolved',
                    'subject' => \DB::raw("CONCAT('[ARCHIVED - Category Deleted] ', subject)")
                ]);
                \Log::info("📞 Archived {$contactsToArchive} contacts");
            }
        });
        
        // When category is updated
        static::updated(function ($category) {
            if ($category->wasChanged('name') || $category->wasChanged('slug')) {
                \Log::info("📝 Category updated: {$category->name}");
                
                // Update related product search indexes or cache
                $category->products()->touch(); // Updates updated_at timestamp
            }
            
            if ($category->wasChanged('is_active') && !$category->is_active) {
                // If category becomes inactive, also deactivate products
                $deactivatedProducts = $category->products()->where('status', 'active')->count();
                $category->products()->where('status', 'active')->update(['status' => 'inactive']);
                \Log::info("📦 Deactivated {$deactivatedProducts} products due to category deactivation");
            }
        });
        
        // When category is restored from soft delete
        static::restored(function ($category) {
            \Log::info("♻️ Category restored: {$category->name}");
            
            // Optionally reactivate products that were deactivated
            $restoredProducts = $category->products()->where('status', 'inactive')->count();
            $category->products()->where('status', 'inactive')->update(['status' => 'active']);
            \Log::info("📦 Reactivated {$restoredProducts} products");
        });
    }

    // Relationships
    public function parent(): BelongsTo
    {
        return $this->belongsTo(Category::class, 'parent_id');
    }

    public function subcategories(): HasMany
    {
        return $this->hasMany(Category::class, 'parent_id');
    }

    public function children(): HasMany
    {
        return $this->hasMany(Category::class, 'parent_id');
    }

    public function products(): HasMany
    {
        return $this->hasMany(Product::class);
    }

    public function contacts(): HasMany
    {
        return $this->hasMany(Contact::class);
    }

    // Helper methods for analytics
    public function getTotalProductsAttribute()
    {
        return $this->products()->count() + $this->children()->withCount('products')->get()->sum('products_count');
    }

    public function getActiveProductsAttribute()
    {
        return $this->products()->where('status', 'active')->count();
    }

    public function getAverageRatingAttribute()
    {
        return $this->products()
            ->join('reviews', 'products.id', '=', 'reviews.product_id')
            ->where('reviews.is_approved', true)
            ->avg('reviews.rating') ?? 0;
    }

    // Scopes
    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    public function scopeParentCategories($query)
    {
        return $query->whereNull('parent_id');
    }

    public function scopeOrdered($query)
    {
        return $query->orderBy('order', 'asc')->orderBy('name', 'asc');
    }

    public function scopeWithProducts($query)
    {
        return $query->has('products');
    }

    public function scopeRootCategories($query)
    {
        return $query->where('is_root_category', true);
    }

    // Helper method to get root category for navigation
    public function getRootCategory()
    {
        if ($this->is_root_category) {
            return $this;
        }
        
        $parent = $this->parent;
        while ($parent && !$parent->is_root_category) {
            $parent = $parent->parent;
        }
        
        return $parent;
    }

    // Helper method to get frontend URL
    public function getFrontendUrl()
    {
        if ($this->frontend_page_url) {
            return $this->frontend_page_url;
        }
        
        $rootCategory = $this->getRootCategory();
        if ($rootCategory && $rootCategory->frontend_page_url) {
            return $rootCategory->frontend_page_url . '/' . $this->slug;
        }
        
        return '/category/' . $this->slug;
    }
}
