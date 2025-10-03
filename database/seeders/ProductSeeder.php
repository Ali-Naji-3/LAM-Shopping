<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Product;
use App\Models\Category;
use App\Models\Brand;

class ProductSeeder extends Seeder
{
    public function run(): void
    {
        \DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        Product::truncate();
        \DB::statement('SET FOREIGN_KEY_CHECKS=1;');

        $categories = Category::all();
        $brands = Brand::all();

        if ($categories->isEmpty() || $brands->isEmpty()) {
            $this->command->error('❌ Please seed Categories and Brands first!');
            return;
        }

        $products = [
            [
                'name' => 'Nike Air Max 270',
                'slug' => 'nike-air-max-270',
                'sku' => 'NIKE-AM270-001',
                'short_description' => 'Comfortable running shoes with Air Max technology.',
                'description' => 'Nike Air Max 270 with responsive cushioning and breathable design.',
                'regular_price' => 150.00,
                'sale_price' => 129.99,
                'featured' => true,
                'is_new_arrival' => true,
                'new_arrival_until' => now()->addDays(30),
                'featured_new_arrival' => true,
                'new_arrival_priority' => 1,
                'enable_countdown' => true,
                'countdown_date' => now()->addDays(10),
                'status' => 'active',
                'quantity' => 45,
                'category_id' => $categories->first()->id,
                'brand_id' => $brands->where('name', 'Nike')->first()->id,
            ],
            [
                'name' => 'Adidas Ultraboost 22',
                'slug' => 'adidas-ultraboost-22',
                'sku' => 'ADS-UB22-002',
                'short_description' => 'Premium running shoes with Boost technology.',
                'description' => 'Adidas Ultraboost 22 with energy-returning Boost midsole.',
                'regular_price' => 180.00,
                'sale_price' => 159.99,
                'featured' => true,
                'is_new_arrival' => true,
                'new_arrival_until' => now()->addDays(20),
                'featured_new_arrival' => false,
                'new_arrival_priority' => 2,
                'enable_countdown' => false,
                'countdown_date' => null,
                'status' => 'active',
                'quantity' => 35,
                'category_id' => $categories->first()->id,
                'brand_id' => $brands->where('name', 'Adidas')->first()->id,
            ],
            [
                'name' => 'Gucci Leather Handbag',
                'slug' => 'gucci-leather-handbag',
                'sku' => 'GUC-LTH-005',
                'short_description' => 'Luxury leather handbag with signature craftsmanship.',
                'description' => 'Gucci leather handbag with premium Italian leather.',
                'regular_price' => 1250.00,
                'sale_price' => null,
                'featured' => true,
                'is_new_arrival' => false,
                'featured_new_arrival' => false,
                'new_arrival_priority' => 1,
                'enable_countdown' => false,
                'countdown_date' => null,
                'status' => 'active',
                'quantity' => 15,
                'category_id' => $categories->skip(1)->first()->id,
                'brand_id' => $brands->where('name', 'Gucci')->first()->id,
            ],
        ];

        // حفظ البيانات بدون أي أحداث تعطل الحفظ
        Product::withoutEvents(function () use ($products) {
            foreach ($products as $productData) {
                Product::create($productData);
            }
        });

        $this->command->info('✅ Products seeded successfully!');
        $this->command->info('📊 Total products created: ' . count($products));
    }
}
