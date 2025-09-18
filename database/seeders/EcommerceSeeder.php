<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class EcommerceSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Create Categories
        $categories = [
            ['name' => 'Men\'s Fashion', 'slug' => 'mens-fashion'],
            ['name' => 'Women\'s Fashion', 'slug' => 'womens-fashion'],
            ['name' => 'Electronics', 'slug' => 'electronics'],
            ['name' => 'Home & Garden', 'slug' => 'home-garden'],
            ['name' => 'Sports & Outdoors', 'slug' => 'sports-outdoors'],
            ['name' => 'Beauty & Health', 'slug' => 'beauty-health'],
        ];

        foreach ($categories as $category) {
            \App\Models\Category::create([
                'name' => $category['name'],
                'slug' => $category['slug'],
                'is_active' => true,
                'order' => 1,
            ]);
        }

        // Create Brands
        $brands = [
            ['name' => 'Nike', 'slug' => 'nike'],
            ['name' => 'Adidas', 'slug' => 'adidas'],
            ['name' => 'Apple', 'slug' => 'apple'],
            ['name' => 'Samsung', 'slug' => 'samsung'],
            ['name' => 'Zara', 'slug' => 'zara'],
            ['name' => 'H&M', 'slug' => 'hm'],
        ];

        foreach ($brands as $brand) {
            \App\Models\Brand::create([
                'name' => $brand['name'],
                'slug' => $brand['slug'],
                'is_active' => true,
            ]);
        }

        // Create Sample Products
        $products = [
            [
                'name' => 'Nike Air Max 270',
                'slug' => 'nike-air-max-270',
                'sku' => 'NIKE-AM270-001',
                'short_description' => 'Comfortable running shoes with great cushioning',
                'description' => 'The Nike Air Max 270 delivers visible cushioning under every step.',
                'regular_price' => 150.00,
                'sale_price' => 120.00,
                'featured' => true,
                'status' => 'active',
                'quantity' => 50,
                'category_id' => 1,
                'brand_id' => 1,
            ],
            [
                'name' => 'iPhone 15 Pro',
                'slug' => 'iphone-15-pro',
                'sku' => 'APPLE-IP15P-001',
                'short_description' => 'Latest iPhone with titanium design',
                'description' => 'iPhone 15 Pro with A17 Pro chip and titanium design.',
                'regular_price' => 999.00,
                'featured' => true,
                'status' => 'active',
                'quantity' => 25,
                'category_id' => 3,
                'brand_id' => 3,
            ],
            [
                'name' => 'Zara Slim Fit Jeans',
                'slug' => 'zara-slim-fit-jeans',
                'sku' => 'ZARA-SFJ-001',
                'short_description' => 'Classic slim fit denim jeans',
                'description' => 'Five-pocket jeans with a slim fit. Faded effect.',
                'regular_price' => 59.90,
                'sale_price' => 39.90,
                'featured' => false,
                'status' => 'active',
                'quantity' => 100,
                'category_id' => 1,
                'brand_id' => 5,
            ],
        ];

        foreach ($products as $product) {
            \App\Models\Product::create($product);
        }

        // Create Sliders
        $sliders = [
            [
                'title' => 'Summer Sale',
                'subtitle' => 'Up to 50% off on selected items',
                'image' => 'slider/summer-sale.jpg',
                'link' => '/products',
                'button_text' => 'Shop Now',
                'is_active' => true,
                'order' => 1,
            ],
            [
                'title' => 'New Arrivals',
                'subtitle' => 'Discover the latest fashion trends',
                'image' => 'slider/new-arrivals.jpg',
                'link' => '/products',
                'button_text' => 'Explore',
                'is_active' => true,
                'order' => 2,
            ],
        ];

        foreach ($sliders as $slider) {
            \App\Models\Slider::create($slider);
        }

        $this->command->info('E-commerce sample data created successfully!');
    }
}
