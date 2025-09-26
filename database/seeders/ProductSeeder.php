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
        // Clear existing products
        \DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        Product::truncate();
        \DB::statement('SET FOREIGN_KEY_CHECKS=1;');

        // Get categories and brands
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
                'status' => 'active',
                'quantity' => 45,
                'category_id' => $categories->first()->id,
                'brand_id' => $brands->where('name', 'Nike')->first()?->id ?? $brands->first()->id,
                'weight' => 0.85,
                'dimensions' => ['length' => 32, 'width' => 20, 'height' => 12],
                'meta_title' => 'Nike Air Max 270 - Running Shoes',
                'meta_description' => 'Nike Air Max 270 shoes with responsive cushioning.',
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
                'status' => 'active',
                'quantity' => 35,
                'category_id' => $categories->first()->id,
                'brand_id' => $brands->where('name', 'Adidas')->first()?->id ?? $brands->first()->id,
                'weight' => 0.92,
                'dimensions' => ['length' => 33, 'width' => 21, 'height' => 13],
                'meta_title' => 'Adidas Ultraboost 22 - Premium Running',
                'meta_description' => 'Adidas Ultraboost 22 with Boost technology.',
            ],
            [
                'name' => 'Zara Slim Fit Jeans',
                'slug' => 'zara-slim-fit-jeans',
                'sku' => 'ZARA-SFJ-003',
                'short_description' => 'Modern slim fit denim jeans.',
                'description' => 'Zara slim fit jeans with contemporary styling.',
                'regular_price' => 49.99,
                'sale_price' => 39.99,
                'featured' => false,
                'status' => 'active',
                'quantity' => 90,
                'category_id' => $categories->skip(1)->first()?->id ?? $categories->first()->id,
                'brand_id' => $brands->where('name', 'Zara')->first()?->id ?? $brands->first()->id,
                'weight' => 0.75,
                'dimensions' => ['length' => 42, 'width' => 18, 'height' => 2],
                'meta_title' => 'Zara Slim Fit Jeans - Modern Style',
                'meta_description' => 'Zara slim fit denim jeans with contemporary styling.',
            ],
            [
                'name' => 'H&M Cotton T-Shirt',
                'slug' => 'hm-cotton-tshirt',
                'sku' => 'HM-COT-004',
                'short_description' => 'Essential cotton t-shirt in classic fit.',
                'description' => 'H&M cotton t-shirt with 100% cotton construction.',
                'regular_price' => 12.99,
                'sale_price' => 9.99,
                'featured' => false,
                'status' => 'active',
                'quantity' => 200,
                'category_id' => $categories->skip(1)->first()?->id ?? $categories->first()->id,
                'brand_id' => $brands->where('name', 'H&M')->first()?->id ?? $brands->first()->id,
                'weight' => 0.20,
                'dimensions' => ['length' => 27, 'width' => 19, 'height' => 1],
                'meta_title' => 'H&M Cotton T-Shirt - Essential Wardrobe',
                'meta_description' => 'Essential H&M cotton t-shirt in classic fit.',
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
                'status' => 'active',
                'quantity' => 15,
                'category_id' => $categories->skip(2)->first()?->id ?? $categories->first()->id,
                'brand_id' => $brands->where('name', 'Gucci')->first()?->id ?? $brands->first()->id,
                'weight' => 0.95,
                'dimensions' => ['length' => 35, 'width' => 15, 'height' => 25],
                'meta_title' => 'Gucci Leather Handbag - Luxury Fashion',
                'meta_description' => 'Premium Gucci leather handbag with signature craftsmanship.',
            ],
            [
                'name' => 'Puma RS-X Sneakers',
                'slug' => 'puma-rs-x-sneakers',
                'sku' => 'PUMA-RSX-006',
                'short_description' => 'Retro-futuristic sneakers with bold design.',
                'description' => 'Puma RS-X sneakers with retro aesthetics and comfort.',
                'regular_price' => 110.00,
                'sale_price' => 89.99,
                'featured' => true,
                'status' => 'active',
                'quantity' => 55,
                'category_id' => $categories->first()->id,
                'brand_id' => $brands->where('name', 'Puma')->first()?->id ?? $brands->first()->id,
                'weight' => 0.88,
                'dimensions' => ['length' => 31, 'width' => 19, 'height' => 12],
                'meta_title' => 'Puma RS-X Sneakers - Retro Style',
                'meta_description' => 'Puma RS-X sneakers with retro-futuristic design.',
            ],
        ];

        foreach ($products as $productData) {
            Product::create($productData);
        }

        $this->command->info('✅ Products seeded successfully!');
        $this->command->info('📊 Total products created: ' . count($products));
        $this->command->info('🟢 Active products: ' . collect($products)->where('status', 'active')->count());
        $this->command->info('⭐ Featured products: ' . collect($products)->where('featured', true)->count());
    }
}
