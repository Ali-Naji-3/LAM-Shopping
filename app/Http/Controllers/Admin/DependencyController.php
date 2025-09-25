<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Category;
use App\Models\Brand;
use App\Models\Product;
use App\Models\User;
use App\Models\Warehouse;

class DependencyController extends Controller
{
    /**
     * Analyze dependencies before deletion
     */
    public function analyze(Request $request)
    {
        $entityType = $request->get('type');
        $entityId = $request->get('id');
        
        switch ($entityType) {
            case 'category':
                return $this->analyzeCategoryDependencies($entityId);
            case 'brand':
                return $this->analyzeBrandDependencies($entityId);
            case 'product':
                return $this->analyzeProductDependencies($entityId);
            case 'user':
                return $this->analyzeUserDependencies($entityId);
            case 'warehouse':
                return $this->analyzeWarehouseDependencies($entityId);
            default:
                return response()->json(['error' => 'Invalid entity type'], 400);
        }
    }
    
    private function analyzeCategoryDependencies($categoryId)
    {
        $category = Category::findOrFail($categoryId);
        
        $dependencies = [
            'entity' => [
                'type' => 'category',
                'name' => $category->name,
                'id' => $category->id
            ],
            'safe_to_delete' => true,
            'warnings' => [],
            'blockers' => [],
            'actions' => [],
            'affected_entities' => []
        ];
        
        // Check products
        $productsCount = $category->products()->count();
        if ($productsCount > 0) {
            $parentName = $category->parent ? $category->parent->name : 'No Category';
            $dependencies['actions'][] = [
                'type' => 'move',
                'description' => "Move {$productsCount} products to '{$parentName}'",
                'count' => $productsCount,
                'entity' => 'products'
            ];
            $dependencies['affected_entities']['products'] = $productsCount;
        }
        
        // Check subcategories
        $subcategoriesCount = $category->subcategories()->count();
        if ($subcategoriesCount > 0) {
            $parentName = $category->parent ? $category->parent->name : 'Root Level';
            $dependencies['actions'][] = [
                'type' => 'move',
                'description' => "Move {$subcategoriesCount} subcategories to '{$parentName}'",
                'count' => $subcategoriesCount,
                'entity' => 'subcategories'
            ];
            $dependencies['affected_entities']['subcategories'] = $subcategoriesCount;
        }
        
        // Check active orders
        $activeOrdersCount = \DB::table('order_items')
            ->join('products', 'order_items.product_id', '=', 'products.id')
            ->join('orders', 'order_items.order_id', '=', 'orders.id')
            ->where('products.category_id', $category->id)
            ->whereIn('orders.status', ['pending', 'confirmed', 'processing', 'shipped'])
            ->count();
            
        if ($activeOrdersCount > 0) {
            $dependencies['safe_to_delete'] = false;
            $dependencies['blockers'][] = [
                'type' => 'active_orders',
                'description' => "{$activeOrdersCount} active orders contain products from this category",
                'count' => $activeOrdersCount,
                'severity' => 'high'
            ];
        }
        
        // Check contacts
        $contactsCount = $category->contacts()->where('status', '!=', 'resolved')->count();
        if ($contactsCount > 0) {
            $dependencies['actions'][] = [
                'type' => 'archive',
                'description' => "Archive {$contactsCount} open contacts",
                'count' => $contactsCount,
                'entity' => 'contacts'
            ];
            $dependencies['affected_entities']['contacts'] = $contactsCount;
        }
        
        return response()->json($dependencies);
    }
    
    private function analyzeProductDependencies($productId)
    {
        $product = Product::findOrFail($productId);
        
        $dependencies = [
            'entity' => [
                'type' => 'product',
                'name' => $product->name,
                'sku' => $product->sku,
                'id' => $product->id
            ],
            'safe_to_delete' => true,
            'warnings' => [],
            'blockers' => [],
            'actions' => [],
            'affected_entities' => []
        ];
        
        // Check active orders
        $activeOrdersCount = $product->orderItems()
            ->join('orders', 'order_items.order_id', '=', 'orders.id')
            ->whereIn('orders.status', ['pending', 'confirmed', 'processing', 'shipped'])
            ->count();
            
        if ($activeOrdersCount > 0) {
            $dependencies['safe_to_delete'] = false;
            $dependencies['blockers'][] = [
                'type' => 'active_orders',
                'description' => "{$activeOrdersCount} active orders contain this product",
                'count' => $activeOrdersCount,
                'severity' => 'high'
            ];
        }
        
        // Check inventory
        $inventoryCount = $product->inventory()->count();
        $totalStock = $product->inventory()->sum('quantity');
        if ($inventoryCount > 0) {
            $dependencies['actions'][] = [
                'type' => 'clear',
                'description' => "Clear {$inventoryCount} inventory records ({$totalStock} total stock)",
                'count' => $inventoryCount,
                'entity' => 'inventory',
                'details' => "Total stock value: {$totalStock} units"
            ];
            $dependencies['affected_entities']['inventory'] = $inventoryCount;
        }
        
        // Check reviews
        $reviewsCount = $product->reviews()->count();
        if ($reviewsCount > 0) {
            $dependencies['actions'][] = [
                'type' => 'archive',
                'description' => "Archive {$reviewsCount} product reviews",
                'count' => $reviewsCount,
                'entity' => 'reviews'
            ];
            $dependencies['affected_entities']['reviews'] = $reviewsCount;
        }
        
        // Check attributes
        $attributesCount = $product->productAttributes()->count();
        if ($attributesCount > 0) {
            $dependencies['actions'][] = [
                'type' => 'remove',
                'description' => "Remove {$attributesCount} attribute assignments",
                'count' => $attributesCount,
                'entity' => 'attributes'
            ];
            $dependencies['affected_entities']['attributes'] = $attributesCount;
        }
        
        return response()->json($dependencies);
    }
    
    private function analyzeUserDependencies($userId)
    {
        $user = User::findOrFail($userId);
        
        $dependencies = [
            'entity' => [
                'type' => 'user',
                'name' => $user->name,
                'email' => $user->email,
                'id' => $user->id
            ],
            'safe_to_delete' => true,
            'warnings' => [],
            'blockers' => [],
            'actions' => [],
            'affected_entities' => []
        ];
        
        // Check active orders
        $activeOrdersCount = $user->orders()
            ->whereIn('status', ['pending', 'confirmed', 'processing', 'shipped'])
            ->count();
            
        if ($activeOrdersCount > 0) {
            $dependencies['safe_to_delete'] = false;
            $dependencies['blockers'][] = [
                'type' => 'active_orders',
                'description' => "{$activeOrdersCount} active orders",
                'count' => $activeOrdersCount,
                'severity' => 'high'
            ];
        }
        
        // Check completed orders
        $completedOrdersCount = $user->orders()
            ->whereIn('status', ['delivered', 'cancelled'])
            ->count();
            
        if ($completedOrdersCount > 0) {
            $dependencies['actions'][] = [
                'type' => 'transfer',
                'description' => "Transfer {$completedOrdersCount} completed orders to Guest User",
                'count' => $completedOrdersCount,
                'entity' => 'orders'
            ];
            $dependencies['affected_entities']['orders'] = $completedOrdersCount;
        }
        
        // Check reviews
        $reviewsCount = $user->reviews()->count();
        if ($reviewsCount > 0) {
            $dependencies['actions'][] = [
                'type' => 'anonymize',
                'description' => "Anonymize {$reviewsCount} reviews",
                'count' => $reviewsCount,
                'entity' => 'reviews'
            ];
            $dependencies['affected_entities']['reviews'] = $reviewsCount;
        }
        
        // Check transactions
        $transactionsCount = $user->transactions()->count();
        if ($transactionsCount > 0) {
            $dependencies['actions'][] = [
                'type' => 'transfer',
                'description' => "Transfer {$transactionsCount} transactions to Guest User",
                'count' => $transactionsCount,
                'entity' => 'transactions'
            ];
            $dependencies['affected_entities']['transactions'] = $transactionsCount;
        }
        
        return response()->json($dependencies);
    }
    
    private function analyzeBrandDependencies($brandId)
    {
        $brand = Brand::findOrFail($brandId);
        
        $dependencies = [
            'entity' => [
                'type' => 'brand',
                'name' => $brand->name,
                'id' => $brand->id
            ],
            'safe_to_delete' => true,
            'warnings' => [],
            'blockers' => [],
            'actions' => [],
            'affected_entities' => []
        ];
        
        // Check products
        $productsCount = $brand->products()->count();
        if ($productsCount > 0) {
            $dependencies['actions'][] = [
                'type' => 'unbrand',
                'description' => "Remove brand from {$productsCount} products (make unbranded)",
                'count' => $productsCount,
                'entity' => 'products'
            ];
            $dependencies['affected_entities']['products'] = $productsCount;
        }
        
        // Check active orders
        $activeOrdersCount = \DB::table('order_items')
            ->join('products', 'order_items.product_id', '=', 'products.id')
            ->join('orders', 'order_items.order_id', '=', 'orders.id')
            ->where('products.brand_id', $brand->id)
            ->whereIn('orders.status', ['pending', 'confirmed', 'processing', 'shipped'])
            ->count();
            
        if ($activeOrdersCount > 0) {
            $dependencies['warnings'][] = [
                'type' => 'active_orders',
                'description' => "{$activeOrdersCount} active orders contain products from this brand",
                'count' => $activeOrdersCount,
                'severity' => 'medium'
            ];
        }
        
        return response()->json($dependencies);
    }
    
    private function analyzeWarehouseDependencies($warehouseId)
    {
        $warehouse = Warehouse::findOrFail($warehouseId);
        
        $dependencies = [
            'entity' => [
                'type' => 'warehouse',
                'name' => $warehouse->name,
                'code' => $warehouse->code,
                'id' => $warehouse->id
            ],
            'safe_to_delete' => true,
            'warnings' => [],
            'blockers' => [],
            'actions' => [],
            'affected_entities' => []
        ];
        
        // Check inventory
        try {
            $inventoryCount = $warehouse->inventory()->count();
            $totalStock = $warehouse->inventory()->sum('quantity');
            
            if ($inventoryCount > 0) {
                $dependencies['actions'][] = [
                    'type' => 'clear',
                    'description' => "Clear {$inventoryCount} inventory records ({$totalStock} total stock)",
                    'count' => $inventoryCount,
                    'entity' => 'inventory',
                    'details' => "Total stock: {$totalStock} units"
                ];
                $dependencies['affected_entities']['inventory'] = $inventoryCount;
            }
        } catch (\Exception $e) {
            // Inventory table might not exist yet
            $dependencies['warnings'][] = [
                'type' => 'missing_table',
                'description' => 'Inventory table not found - no inventory to clear',
                'severity' => 'low'
            ];
        }
        
        return response()->json($dependencies);
    }
}
