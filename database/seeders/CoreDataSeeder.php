<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Category;
use App\Models\Brand;
use App\Models\Product;
use App\Models\Attribute;
use App\Models\AttributeValue;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class CoreDataSeeder extends Seeder
{
    public function run()
    {
        $this->command->info('🚀 Creating CORE data for your Collection Store...');
        
        $this->createCustomers();
        $this->createCategories();
        $this->createBrands();
        $this->createAttributes();
        $this->createAttributeValues();
        $this->createProducts();
        
        $this->command->info('✅ CORE data created successfully!');
    }
    
    private function createCustomers()
    {
        $this->command->info('👥 Creating customers...');
        
        $customers = [
            ['name' => 'Ahmed Hassan', 'email' => 'ahmed.hassan@example.com', 'mobile' => '+201234567890'],
            ['name' => 'Sarah Mohammed', 'email' => 'sarah.mohammed@example.com', 'mobile' => '+201234567891'],
            ['name' => 'Omar Ali', 'email' => 'omar.ali@example.com', 'mobile' => '+201234567892'],
            ['name' => 'Fatima Ibrahim', 'email' => 'fatima.ibrahim@example.com', 'mobile' => '+201234567893'],
        ];
        
        foreach ($customers as $customer) {
            User::create([
                'name' => $customer['name'],
                'email' => $customer['email'],
                'mobile' => $customer['mobile'],
                'email_verified_at' => now(),
                'password' => Hash::make('password123'),
                'u_type' => 'USR',
            ]);
        }
    }
    
    private function createCategories()
    {
        $this->command->info('📂 Creating categories from your frontend...');
        
        // Gender Categories (Parent)
        $men = Category::create([
            'name' => 'Men',
            'slug' => 'men',
            'description' => 'Men\'s sportswear and athletic gear',
            'is_active' => true,
            'order' => 1,
        ]);
        
        $women = Category::create([
            'name' => 'Women',
            'slug' => 'women',
            'description' => 'Women\'s sportswear and athletic gear',
            'is_active' => true,
            'order' => 2,
        ]);
        
        $boys = Category::create([
            'name' => 'Boys',
            'slug' => 'boys',
            'description' => 'Boys\' sportswear and athletic gear',
            'is_active' => true,
            'order' => 3,
        ]);
        
        $girls = Category::create([
            'name' => 'Girls',
            'slug' => 'girls',
            'description' => 'Girls\' sportswear and athletic gear',
            'is_active' => true,
            'order' => 4,
        ]);
        
        // Activity Categories (From your frontend)
        $categories = [
            // Men's subcategories
            ['name' => 'Men Running', 'slug' => 'men-running', 'parent_id' => $men->id, 'order' => 1],
            ['name' => 'Men Football', 'slug' => 'men-football', 'parent_id' => $men->id, 'order' => 2],
            ['name' => 'Men Training', 'slug' => 'men-training', 'parent_id' => $men->id, 'order' => 3],
            ['name' => 'Men Life Style', 'slug' => 'men-lifestyle', 'parent_id' => $men->id, 'order' => 4],
            
            // Women's subcategories
            ['name' => 'Women Running', 'slug' => 'women-running', 'parent_id' => $women->id, 'order' => 1],
            ['name' => 'Women Training', 'slug' => 'women-training', 'parent_id' => $women->id, 'order' => 2],
            ['name' => 'Women Life Style', 'slug' => 'women-lifestyle', 'parent_id' => $women->id, 'order' => 3],
            
            // Collections (Special category)
            ['name' => 'Collections', 'slug' => 'collections', 'parent_id' => null, 'order' => 5],
        ];
        
        foreach ($categories as $category) {
            Category::create([
                'name' => $category['name'],
                'slug' => $category['slug'],
                'description' => "Premium {$category['name']} products for athletes and fitness enthusiasts",
                'parent_id' => $category['parent_id'],
                'is_active' => true,
                'order' => $category['order'],
            ]);
        }
    }
    
    private function createBrands()
    {
        $this->command->info('🏷️ Creating real sports brands...');
        
        $brands = [
            ['name' => 'Nike', 'slug' => 'nike', 'description' => 'Just Do It - World\'s leading athletic brand'],
            ['name' => 'Adidas', 'slug' => 'adidas', 'description' => 'Impossible is Nothing - German multinational corporation'],
            ['name' => 'Under Armour', 'slug' => 'under-armour', 'description' => 'I Will - American sports equipment company'],
            ['name' => 'Puma', 'slug' => 'puma', 'description' => 'Forever Faster - German multinational corporation'],
            ['name' => 'New Balance', 'slug' => 'new-balance', 'description' => 'Endorsed by No One - American multinational corporation'],
            ['name' => 'Jordan', 'slug' => 'jordan', 'description' => 'Jumpman - Basketball brand by Nike'],
        ];
        
        foreach ($brands as $brand) {
            Brand::create([
                'name' => $brand['name'],
                'slug' => $brand['slug'],
                'description' => $brand['description'],
                'is_active' => true,
            ]);
        }
    }
    
    private function createAttributes()
    {
        $this->command->info('🔧 Creating product attributes...');
        
        $attributes = [
            ['name' => 'Color', 'slug' => 'color', 'type' => 'select', 'is_required' => true],
            ['name' => 'Size', 'slug' => 'size', 'type' => 'select', 'is_required' => true],
            ['name' => 'Material', 'slug' => 'material', 'type' => 'select', 'is_required' => false],
        ];
        
        foreach ($attributes as $attribute) {
            Attribute::create($attribute);
        }
    }
    
    private function createAttributeValues()
    {
        $this->command->info('📝 Creating attribute values...');
        
        $colorAttr = Attribute::where('slug', 'color')->first();
        $sizeAttr = Attribute::where('slug', 'size')->first();
        $materialAttr = Attribute::where('slug', 'material')->first();
        
        // Colors (matching your frontend color options)
        $colors = ['Black', 'White', 'Red', 'Blue', 'Navy', 'Gray'];
        foreach ($colors as $color) {
            AttributeValue::create([
                'attribute_id' => $colorAttr->id,
                'value' => $color,
            ]);
        }
        
        // Sizes (matching your frontend)
        $sizes = ['S', 'M', 'L', 'XL'];
        foreach ($sizes as $size) {
            AttributeValue::create([
                'attribute_id' => $sizeAttr->id,
                'value' => $size,
            ]);
        }
        
        // Materials
        $materials = ['Cotton', 'Polyester', 'Mesh', 'Synthetic'];
        foreach ($materials as $material) {
            AttributeValue::create([
                'attribute_id' => $materialAttr->id,
                'value' => $material,
            ]);
        }
    }
    
    private function createProducts()
    {
        $this->command->info('🛍️ Creating real products from your frontend...');
        
        // Get references
        $nike = Brand::where('slug', 'nike')->first();
        $adidas = Brand::where('slug', 'adidas')->first();
        $underArmour = Brand::where('slug', 'under-armour')->first();
        
        $menRunning = Category::where('slug', 'men-running')->first();
        $womenTraining = Category::where('slug', 'women-training')->first();
        $collections = Category::where('slug', 'collections')->first();
        
        $products = [
            // Featured product from your frontend
            [
                'name' => 'Armor Air X Fear',
                'slug' => 'armor-air-x-fear',
                'sku' => 'MTKRY-001',
                'short_description' => 'Premium athletic shoes with advanced air cushioning technology',
                'description' => 'The Armor Air X Fear combines cutting-edge design with superior comfort. Featuring advanced air cushioning, breathable mesh upper, and durable rubber outsole. Perfect for training and casual wear.',
                'regular_price' => 160.00,
                'sale_price' => 148.00,
                'featured' => true,
                'status' => 'active',
                'quantity' => 50,
                'category_id' => $menRunning->id,
                'brand_id' => $underArmour->id,
                'weight' => 0.6,
            ],
            
            // Nike Products
            [
                'name' => 'Nike Air Max 270',
                'slug' => 'nike-air-max-270',
                'sku' => 'NIKE-270-001',
                'short_description' => 'Nike\'s biggest heel Air unit yet delivers exceptional comfort',
                'description' => 'The Nike Air Max 270 features Nike\'s biggest heel Air unit yet and a sleek silhouette that\'s perfect for any occasion.',
                'regular_price' => 150.00,
                'sale_price' => 135.00,
                'featured' => true,
                'status' => 'active',
                'quantity' => 75,
                'category_id' => $collections->id,
                'brand_id' => $nike->id,
                'weight' => 0.8,
            ],
            
            [
                'name' => 'Nike Women\'s Training Set',
                'slug' => 'nike-womens-training-set',
                'sku' => 'NIKE-WTS-001',
                'short_description' => 'Complete training set with sports bra and leggings',
                'description' => 'Complete your workout wardrobe with this stylish and functional Nike training set.',
                'regular_price' => 85.00,
                'sale_price' => 76.50,
                'featured' => false,
                'status' => 'active',
                'quantity' => 80,
                'category_id' => $womenTraining->id,
                'brand_id' => $nike->id,
                'weight' => 0.4,
            ],
            
            // Adidas Products
            [
                'name' => 'Adidas Ultraboost 22',
                'slug' => 'adidas-ultraboost-22',
                'sku' => 'ADI-UB22-001',
                'short_description' => 'Energy-returning running shoes with Boost midsole',
                'description' => 'Experience incredible energy return with every step in the Adidas Ultraboost 22.',
                'regular_price' => 180.00,
                'sale_price' => 162.00,
                'featured' => true,
                'status' => 'active',
                'quantity' => 60,
                'category_id' => $menRunning->id,
                'brand_id' => $adidas->id,
                'weight' => 0.7,
            ],
        ];
        
        foreach ($products as $product) {
            Product::create($product);
        }
    }
}
