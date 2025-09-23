<?php

namespace Database\Seeders;

use App\Models\Inventory;
use App\Models\Product;
use App\Models\Warehouse;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class InventorySeeder extends Seeder
{
    /**
     * Run the database seeder.
     */
    public function run(): void
    {
        // Disable foreign key checks
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        
        // Clear existing inventory
        Inventory::truncate();
        
        // Re-enable foreign key checks
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');

        // Get all products and warehouses
        $products = Product::all();
        $warehouses = Warehouse::where('is_active', true)->get();

        if ($products->isEmpty() || $warehouses->isEmpty()) {
            $this->command->warn('No products or warehouses found. Please seed products and warehouses first.');
            return;
        }

        $inventoryData = [];
        $createdCombinations = [];

        // Create inventory records for random product-warehouse combinations
        foreach ($products as $product) {
            // Each product will be in 2-5 random warehouses
            $warehouseCount = rand(2, min(5, $warehouses->count()));
            $selectedWarehouses = $warehouses->random($warehouseCount);

            foreach ($selectedWarehouses as $warehouse) {
                $combination = $product->id . '-' . $warehouse->id;
                
                // Skip if combination already exists
                if (in_array($combination, $createdCombinations)) {
                    continue;
                }
                
                $createdCombinations[] = $combination;

                // Generate realistic stock levels
                $quantity = $this->generateQuantity($product->name);
                $minimumStock = max(1, intval($quantity * 0.1)); // 10% of quantity
                $reorderLevel = max($minimumStock + 1, intval($quantity * 0.2)); // 20% of quantity

                $inventoryData[] = [
                    'product_id' => $product->id,
                    'warehouse_id' => $warehouse->id,
                    'quantity' => $quantity,
                    'minimum_stock' => $minimumStock,
                    'reorder_level' => $reorderLevel,
                    'created_at' => now()->subDays(rand(1, 30)),
                    'updated_at' => now()->subDays(rand(0, 7)),
                ];
            }
        }

        // Insert inventory data in chunks for better performance
        $chunks = array_chunk($inventoryData, 100);
        foreach ($chunks as $chunk) {
            Inventory::insert($chunk);
        }

        $this->command->info('Created ' . count($inventoryData) . ' inventory records successfully!');

        // Create some specific scenarios for testing
        $this->createTestScenarios($products, $warehouses);
    }

    /**
     * Generate realistic quantity based on product type
     */
    private function generateQuantity(string $productName): int
    {
        $productName = strtolower($productName);
        
        // High-demand items
        if (str_contains($productName, 'shirt') || str_contains($productName, 'jeans') || str_contains($productName, 'dress')) {
            return rand(50, 200);
        }
        
        // Medium-demand items
        if (str_contains($productName, 'jacket') || str_contains($productName, 'shoes') || str_contains($productName, 'bag')) {
            return rand(20, 80);
        }
        
        // Low-demand items
        if (str_contains($productName, 'accessory') || str_contains($productName, 'watch') || str_contains($productName, 'jewelry')) {
            return rand(5, 30);
        }
        
        // Seasonal items
        if (str_contains($productName, 'coat') || str_contains($productName, 'boots') || str_contains($productName, 'scarf')) {
            return rand(10, 50);
        }
        
        // Default range
        return rand(10, 100);
    }

    /**
     * Create specific test scenarios
     */
    private function createTestScenarios($products, $warehouses): void
    {
        if ($products->count() < 5 || $warehouses->count() < 3) {
            return;
        }

        // Scenario 1: Out of stock items
        $outOfStockProducts = $products->take(3);
        foreach ($outOfStockProducts as $product) {
            $warehouse = $warehouses->random();
            
            // Check if combination already exists
            $existing = Inventory::where('product_id', $product->id)
                ->where('warehouse_id', $warehouse->id)
                ->first();
                
            if (!$existing) {
                Inventory::create([
                    'product_id' => $product->id,
                    'warehouse_id' => $warehouse->id,
                    'quantity' => 0,
                    'minimum_stock' => rand(5, 15),
                    'reorder_level' => rand(10, 25),
                ]);
            }
        }

        // Scenario 2: Low stock items
        $lowStockProducts = $products->skip(3)->take(5);
        foreach ($lowStockProducts as $product) {
            $warehouse = $warehouses->random();
            
            // Check if combination already exists
            $existing = Inventory::where('product_id', $product->id)
                ->where('warehouse_id', $warehouse->id)
                ->first();
                
            if (!$existing) {
                $minimumStock = rand(20, 30);
                $quantity = rand(1, $minimumStock - 1); // Below minimum stock
                
                Inventory::create([
                    'product_id' => $product->id,
                    'warehouse_id' => $warehouse->id,
                    'quantity' => $quantity,
                    'minimum_stock' => $minimumStock,
                    'reorder_level' => $minimumStock + rand(5, 15),
                ]);
            }
        }

        // Scenario 3: Items needing reorder
        $reorderProducts = $products->skip(8)->take(4);
        foreach ($reorderProducts as $product) {
            $warehouse = $warehouses->random();
            
            // Check if combination already exists
            $existing = Inventory::where('product_id', $product->id)
                ->where('warehouse_id', $warehouse->id)
                ->first();
                
            if (!$existing) {
                $reorderLevel = rand(25, 40);
                $quantity = rand(1, $reorderLevel - 1); // Below reorder level
                
                Inventory::create([
                    'product_id' => $product->id,
                    'warehouse_id' => $warehouse->id,
                    'quantity' => $quantity,
                    'minimum_stock' => rand(5, 15),
                    'reorder_level' => $reorderLevel,
                ]);
            }
        }

        // Scenario 4: High stock items
        $highStockProducts = $products->skip(12)->take(3);
        foreach ($highStockProducts as $product) {
            $warehouse = $warehouses->random();
            
            // Check if combination already exists
            $existing = Inventory::where('product_id', $product->id)
                ->where('warehouse_id', $warehouse->id)
                ->first();
                
            if (!$existing) {
                Inventory::create([
                    'product_id' => $product->id,
                    'warehouse_id' => $warehouse->id,
                    'quantity' => rand(500, 1000),
                    'minimum_stock' => rand(50, 100),
                    'reorder_level' => rand(100, 200),
                ]);
            }
        }

        $this->command->info('Created test scenarios: out of stock, low stock, reorder needed, and high stock items.');
    }
}
