<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Product;
use App\Models\Attribute;
use App\Models\AttributeValue;
use App\Models\ProductAttribute;
use Illuminate\Support\Facades\DB;

class ProductAttributeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Clear existing product attributes
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        ProductAttribute::truncate();
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');

        // Get products and attributes
        $products = Product::all();
        $attributes = Attribute::with('attributeValues')->get();

        if ($products->isEmpty() || $attributes->isEmpty()) {
            $this->command->warn('⚠️  No products or attributes found. Please seed products and attributes first.');
            return;
        }

        $assignmentCount = 0;

        foreach ($products as $product) {
            // For each product, assign 2-4 random attributes
            $numAttributesToAssign = rand(2, 4);
            $selectedAttributes = $attributes->random($numAttributesToAssign);

            foreach ($selectedAttributes as $attribute) {
                // Skip if attribute has no values
                if ($attribute->attributeValues->isEmpty()) {
                    continue;
                }

                // Select 1-3 random values from this attribute
                $numValuesToAssign = $attribute->type === 'checkbox' ? rand(1, 3) : 1;
                $numValuesToAssign = min($numValuesToAssign, $attribute->attributeValues->count());
                
                $selectedValues = $attribute->attributeValues->random($numValuesToAssign);

                foreach ($selectedValues as $attributeValue) {
                    // Check if assignment already exists (prevent duplicates)
                    $exists = ProductAttribute::where('product_id', $product->id)
                        ->where('attribute_value_id', $attributeValue->id)
                        ->exists();

                    if ($exists) {
                        continue;
                    }

                    // Generate realistic additional pricing
                    $additionalPrice = $this->generateAdditionalPrice($attribute->name, $attributeValue->value);

                    ProductAttribute::create([
                        'product_id' => $product->id,
                        'attribute_value_id' => $attributeValue->id,
                        'additional_price' => $additionalPrice
                    ]);

                    $assignmentCount++;
                }
            }
        }

        $this->command->info('✅ Product attribute assignments seeded successfully!');
        $this->command->info('📊 Products processed: ' . $products->count());
        $this->command->info('🔧 Attributes available: ' . $attributes->count());
        $this->command->info('🔗 Total assignments created: ' . $assignmentCount);
        
        // Show some statistics
        $this->showStatistics();
    }

    /**
     * Generate realistic additional pricing based on attribute and value
     */
    private function generateAdditionalPrice(string $attributeName, string $value): float
    {
        $attributeName = strtolower($attributeName);
        $value = strtolower($value);

        // Most attributes are free by default
        $baseChance = rand(1, 100);
        
        // Different attributes have different pricing strategies
        switch ($attributeName) {
            case 'size':
                // Larger sizes might cost more
                if (in_array($value, ['xl', 'xxl', 'xxxl'])) {
                    return $baseChance <= 40 ? round(rand(200, 800) / 100, 2) : 0.00;
                }
                return $baseChance <= 20 ? round(rand(100, 300) / 100, 2) : 0.00;
                
            case 'material':
                // Premium materials cost more
                $premiumMaterials = ['silk', 'cashmere', 'leather', 'wool'];
                if (in_array($value, $premiumMaterials)) {
                    return $baseChance <= 70 ? round(rand(500, 2000) / 100, 2) : 0.00;
                }
                return $baseChance <= 30 ? round(rand(200, 800) / 100, 2) : 0.00;
                
            case 'color':
                // Special colors might have additional cost
                $specialColors = ['gold', 'silver', 'metallic', 'custom'];
                if (in_array($value, $specialColors)) {
                    return $baseChance <= 50 ? round(rand(300, 1000) / 100, 2) : 0.00;
                }
                return $baseChance <= 15 ? round(rand(100, 500) / 100, 2) : 0.00;
                
            case 'style':
                // Premium styles cost more
                $premiumStyles = ['formal', 'business', 'wedding', 'party'];
                if (in_array($value, $premiumStyles)) {
                    return $baseChance <= 60 ? round(rand(400, 1500) / 100, 2) : 0.00;
                }
                return $baseChance <= 25 ? round(rand(200, 700) / 100, 2) : 0.00;
                
            case 'brand':
                // Premium brands cost more
                $premiumBrands = ['nike', 'adidas', 'under armour', 'jordan'];
                if (in_array($value, $premiumBrands)) {
                    return $baseChance <= 80 ? round(rand(1000, 5000) / 100, 2) : 0.00;
                }
                return $baseChance <= 40 ? round(rand(500, 2000) / 100, 2) : 0.00;
                
            default:
                // Generic attributes - mostly free with occasional small charges
                return $baseChance <= 20 ? round(rand(100, 500) / 100, 2) : 0.00;
        }
    }

    /**
     * Show assignment statistics
     */
    private function showStatistics(): void
    {
        $stats = [
            'total_assignments' => ProductAttribute::count(),
            'free_assignments' => ProductAttribute::where('additional_price', 0)->count(),
            'paid_assignments' => ProductAttribute::where('additional_price', '>', 0)->count(),
            'total_additional_revenue' => ProductAttribute::sum('additional_price'),
            'average_additional_price' => ProductAttribute::where('additional_price', '>', 0)->avg('additional_price'),
            'products_with_attributes' => Product::whereHas('productAttributes')->count(),
        ];

        $this->command->info('');
        $this->command->info('📈 ASSIGNMENT STATISTICS:');
        $this->command->info('• Total Assignments: ' . number_format($stats['total_assignments']));
        $this->command->info('• Free Assignments: ' . number_format($stats['free_assignments']) . ' (' . round(($stats['free_assignments'] / $stats['total_assignments']) * 100, 1) . '%)');
        $this->command->info('• Paid Assignments: ' . number_format($stats['paid_assignments']) . ' (' . round(($stats['paid_assignments'] / $stats['total_assignments']) * 100, 1) . '%)');
        $this->command->info('• Total Additional Revenue: $' . number_format($stats['total_additional_revenue'], 2));
        $this->command->info('• Average Additional Price: $' . number_format($stats['average_additional_price'] ?? 0, 2));
        $this->command->info('• Products with Attributes: ' . number_format($stats['products_with_attributes']));
    }
}