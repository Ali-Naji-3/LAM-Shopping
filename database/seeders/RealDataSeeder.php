<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Category;
use App\Models\Brand;
use App\Models\Product;
use App\Models\Attribute;
use App\Models\AttributeValue;
use App\Models\ProductAttribute;
use App\Models\User;
use App\Models\Review;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Warehouse;
use App\Models\Inventory;
use App\Models\Transaction;
use App\Models\Slider;
use App\Models\Contact;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class RealDataSeeder extends Seeder
{
    public function run()
    {
        $this->command->info('🚀 Creating REAL data for your Collection Store...');

        // Clear existing data safely
        $this->clearExistingData();

        // Create data in dependency order
        $this->createUsers();
        $this->createCategories();
        $this->createBrands();
        $this->createAttributes();
        $this->createAttributeValues();
        $this->createWarehouses();
        $this->createProducts();
        $this->createProductAttributes();
        $this->createInventory();
        $this->createReviews();
        $this->createOrders();
        $this->createOrderItems();
        $this->createTransactions();
        $this->createSliders();
        $this->createContacts();

        $this->command->info('✅ REAL data created successfully! Ready for frontend connection.');
    }

    private function clearExistingData()
    {
        $this->command->info('🧹 Clearing existing data...');

        \DB::statement('SET FOREIGN_KEY_CHECKS=0;');

        // Clear in reverse dependency order
        Contact::truncate();
        Slider::truncate();
        Transaction::truncate();
        OrderItem::truncate();
        Order::truncate();
        Review::truncate();
        Inventory::truncate();
        ProductAttribute::truncate();
        Product::truncate();
        AttributeValue::truncate();
        Attribute::truncate();
        Brand::truncate();
        Category::truncate();
        Warehouse::truncate();
        // Don't truncate users - keep admin accounts

        \DB::statement('SET FOREIGN_KEY_CHECKS=1;');
    }

    private function createUsers()
    {
        $this->command->info('👥 Creating real users...');

        // Create realistic customers
        $customers = [
            ['name' => 'Ahmed Hassan', 'email' => 'ahmed.hassan@example.com', 'mobile' => '+201234567890'],
            ['name' => 'Sarah Mohammed', 'email' => 'sarah.mohammed@example.com', 'mobile' => '+201234567891'],
            ['name' => 'Omar Ali', 'email' => 'omar.ali@example.com', 'mobile' => '+201234567892'],
            ['name' => 'Fatima Ibrahim', 'email' => 'fatima.ibrahim@example.com', 'mobile' => '+201234567893'],
            ['name' => 'Khaled Mahmoud', 'email' => 'khaled.mahmoud@example.com', 'mobile' => '+201234567894'],
            ['name' => 'Nour Abdel Rahman', 'email' => 'nour.abdel@example.com', 'mobile' => '+201234567895'],
            ['name' => 'Youssef Tarek', 'email' => 'youssef.tarek@example.com', 'mobile' => '+201234567896'],
            ['name' => 'Mona Farouk', 'email' => 'mona.farouk@example.com', 'mobile' => '+201234567897'],
        ];

        foreach ($customers as $customer) {
            User::updateOrCreate(
                ['email' => $customer['email']],
                [
                    'name' => $customer['name'],
                    'mobile' => $customer['mobile'],
                    'email_verified_at' => now(),
                    'password' => Hash::make('password123'),
                    'u_type' => 'USR',
                ]
            );
        }
    }

    private function createCategories()
    {
        $this->command->info('📂 Creating categories...');

        // Parent categories (Gender-based)
        $parentCategories = [
            ['name' => 'Men', 'slug' => 'men', 'description' => 'Men\'s clothing and accessories', 'is_active' => true, 'order' => 1],
            ['name' => 'Women', 'slug' => 'women', 'description' => 'Women\'s clothing and accessories', 'is_active' => true, 'order' => 2],
            ['name' => 'Boys', 'slug' => 'boys', 'description' => 'Boys\' clothing and accessories', 'is_active' => true, 'order' => 3],
            ['name' => 'Girls', 'slug' => 'girls', 'description' => 'Girls\' clothing and accessories', 'is_active' => true, 'order' => 4],
        ];

        $parentIds = [];
        foreach ($parentCategories as $category) {
            $cat = Category::updateOrCreate(
                ['slug' => $category['slug']],
                $category
            );
            $parentIds[$category['slug']] = $cat->id;
        }

        // Subcategories for Men
        $menSubcategories = [
            ['name' => 'Men Shirts', 'slug' => 'men-shirts', 'parent_id' => $parentIds['men'], 'description' => 'Men\'s shirts and tops'],
            ['name' => 'Men Pants', 'slug' => 'men-pants', 'parent_id' => $parentIds['men'], 'description' => 'Men\'s pants and trousers'],
            ['name' => 'Men Shoes', 'slug' => 'men-shoes', 'parent_id' => $parentIds['men'], 'description' => 'Men\'s footwear'],
            ['name' => 'Men Accessories', 'slug' => 'men-accessories', 'parent_id' => $parentIds['men'], 'description' => 'Men\'s accessories'],
        ];

        // Subcategories for Women
        $womenSubcategories = [
            ['name' => 'Women Dresses', 'slug' => 'women-dresses', 'parent_id' => $parentIds['women'], 'description' => 'Women\'s dresses'],
            ['name' => 'Women Tops', 'slug' => 'women-tops', 'parent_id' => $parentIds['women'], 'description' => 'Women\'s tops and blouses'],
            ['name' => 'Women Shoes', 'slug' => 'women-shoes', 'parent_id' => $parentIds['women'], 'description' => 'Women\'s footwear'],
            ['name' => 'Women Bags', 'slug' => 'women-bags', 'parent_id' => $parentIds['women'], 'description' => 'Women\'s handbags and purses'],
        ];

        // Subcategories for Boys
        $boysSubcategories = [
            ['name' => 'Boys T-Shirts', 'slug' => 'boys-tshirts', 'parent_id' => $parentIds['boys'], 'description' => 'Boys\' t-shirts'],
            ['name' => 'Boys Shorts', 'slug' => 'boys-shorts', 'parent_id' => $parentIds['boys'], 'description' => 'Boys\' shorts'],
            ['name' => 'Boys Shoes', 'slug' => 'boys-shoes', 'parent_id' => $parentIds['boys'], 'description' => 'Boys\' footwear'],
        ];

        // Subcategories for Girls
        $girlsSubcategories = [
            ['name' => 'Girls Dresses', 'slug' => 'girls-dresses', 'parent_id' => $parentIds['girls'], 'description' => 'Girls\' dresses'],
            ['name' => 'Girls Tops', 'slug' => 'girls-tops', 'parent_id' => $parentIds['girls'], 'description' => 'Girls\' tops'],
            ['name' => 'Girls Shoes', 'slug' => 'girls-shoes', 'parent_id' => $parentIds['girls'], 'description' => 'Girls\' footwear'],
        ];

        $allSubcategories = array_merge($menSubcategories, $womenSubcategories, $boysSubcategories, $girlsSubcategories);
        
        foreach ($allSubcategories as $subcategory) {
            Category::updateOrCreate(
                ['slug' => $subcategory['slug']],
                array_merge($subcategory, ['is_active' => true, 'order' => 1])
            );
        }
    }

    private function createBrands()
    {
        $this->command->info('🏷️ Creating brands...');

        // Check if brands table has the expected columns
        if (!\Schema::hasColumn('brands', 'name')) {
            $this->command->info('⚠️ Brands table does not have expected columns, skipping brands creation...');
            return;
        }

        $brands = [
            ['name' => 'Nike', 'slug' => 'nike', 'description' => 'Just Do It', 'is_active' => true],
            ['name' => 'Adidas', 'slug' => 'adidas', 'description' => 'Impossible is Nothing', 'is_active' => true],
            ['name' => 'Zara', 'slug' => 'zara', 'description' => 'Fast Fashion', 'is_active' => true],
            ['name' => 'H&M', 'slug' => 'hm', 'description' => 'Fashion and Quality at the Best Price', 'is_active' => true],
            ['name' => 'Uniqlo', 'slug' => 'uniqlo', 'description' => 'LifeWear', 'is_active' => true],
            ['name' => 'Puma', 'slug' => 'puma', 'description' => 'Forever Faster', 'is_active' => true],
            ['name' => 'Gucci', 'slug' => 'gucci', 'description' => 'Luxury Fashion', 'is_active' => true],
            ['name' => 'Chanel', 'slug' => 'chanel', 'description' => 'Luxury Fashion House', 'is_active' => true],
        ];

        foreach ($brands as $brand) {
            Brand::create($brand);
        }
    }

    private function createAttributes()
    {
        $this->command->info('🔧 Creating attributes...');

        $attributes = [
            ['name' => 'Size', 'slug' => 'size', 'type' => 'select', 'is_required' => true],
            ['name' => 'Color', 'slug' => 'color', 'type' => 'select', 'is_required' => true],
            ['name' => 'Material', 'slug' => 'material', 'type' => 'select', 'is_required' => false],
            ['name' => 'Season', 'slug' => 'season', 'type' => 'select', 'is_required' => false],
        ];

        foreach ($attributes as $attribute) {
            Attribute::create($attribute);
        }
    }

    private function createAttributeValues()
    {
        $this->command->info('📝 Creating attribute values...');

        $sizeAttribute = Attribute::where('name', 'Size')->first();
        $colorAttribute = Attribute::where('name', 'Color')->first();
        $materialAttribute = Attribute::where('name', 'Material')->first();
        $seasonAttribute = Attribute::where('name', 'Season')->first();

        // Size values
        $sizes = ['XS', 'S', 'M', 'L', 'XL', 'XXL', '28', '30', '32', '34', '36', '38', '40', '42', '44'];
        foreach ($sizes as $size) {
            AttributeValue::create(['attribute_id' => $sizeAttribute->id, 'value' => $size]);
        }

        // Color values
        $colors = ['Black', 'White', 'Red', 'Blue', 'Green', 'Yellow', 'Pink', 'Purple', 'Orange', 'Brown', 'Gray', 'Navy'];
        foreach ($colors as $color) {
            AttributeValue::create(['attribute_id' => $colorAttribute->id, 'value' => $color]);
        }

        // Material values
        $materials = ['Cotton', 'Polyester', 'Wool', 'Silk', 'Leather', 'Denim', 'Linen', 'Cashmere'];
        foreach ($materials as $material) {
            AttributeValue::create(['attribute_id' => $materialAttribute->id, 'value' => $material]);
        }

        // Season values
        $seasons = ['Spring', 'Summer', 'Fall', 'Winter', 'All Season'];
        foreach ($seasons as $season) {
            AttributeValue::create(['attribute_id' => $seasonAttribute->id, 'value' => $season]);
        }
    }

    private function createWarehouses()
    {
        $this->command->info('🏪 Creating warehouses...');

        $warehouses = [
            ['name' => 'Main Warehouse', 'code' => 'WH001', 'location' => 'Cairo, Egypt', 'is_active' => true],
            ['name' => 'Alexandria Branch', 'code' => 'WH002', 'location' => 'Alexandria, Egypt', 'is_active' => true],
            ['name' => 'Giza Distribution', 'code' => 'WH003', 'location' => 'Giza, Egypt', 'is_active' => true],
        ];

        foreach ($warehouses as $warehouse) {
            Warehouse::create($warehouse);
        }
    }

    private function createProducts()
    {
        $this->command->info('👕 Creating products...');

        $categories = Category::whereNotNull('parent_id')->get();
        $brands = Brand::all();

        $products = [
            // Men's products
            ['name' => 'Classic White Shirt', 'slug' => 'classic-white-shirt', 'sku' => 'MWS001', 'description' => 'Premium cotton white shirt for men', 'regular_price' => 299.99, 'sale_price' => 249.99, 'quantity' => 50, 'featured' => true, 'status' => 'active'],
            ['name' => 'Blue Denim Jeans', 'slug' => 'blue-denim-jeans', 'sku' => 'MBD001', 'description' => 'Classic blue denim jeans for men', 'regular_price' => 399.99, 'sale_price' => null, 'quantity' => 30, 'featured' => false, 'status' => 'active'],
            ['name' => 'Leather Dress Shoes', 'slug' => 'leather-dress-shoes', 'sku' => 'MLS001', 'description' => 'Premium leather dress shoes', 'regular_price' => 599.99, 'sale_price' => 499.99, 'quantity' => 25, 'featured' => true, 'status' => 'active'],
            
            // Women's products
            ['name' => 'Elegant Black Dress', 'slug' => 'elegant-black-dress', 'sku' => 'WBD001', 'description' => 'Elegant black dress for special occasions', 'regular_price' => 799.99, 'sale_price' => null, 'quantity' => 20, 'featured' => true, 'status' => 'active'],
            ['name' => 'Designer Handbag', 'slug' => 'designer-handbag', 'sku' => 'WHB001', 'description' => 'Luxury designer handbag', 'regular_price' => 1299.99, 'sale_price' => 999.99, 'quantity' => 15, 'featured' => true, 'status' => 'active'],
            ['name' => 'High Heel Shoes', 'slug' => 'high-heel-shoes', 'sku' => 'WHS001', 'description' => 'Elegant high heel shoes', 'regular_price' => 499.99, 'sale_price' => null, 'quantity' => 35, 'featured' => false, 'status' => 'active'],
            
            // Boys' products
            ['name' => 'Kids T-Shirt', 'slug' => 'kids-tshirt', 'sku' => 'BKT001', 'description' => 'Comfortable cotton t-shirt for boys', 'regular_price' => 99.99, 'sale_price' => 79.99, 'quantity' => 40, 'featured' => false, 'status' => 'active'],
            ['name' => 'Boys Sneakers', 'slug' => 'boys-sneakers', 'sku' => 'BKS001', 'description' => 'Comfortable sneakers for boys', 'regular_price' => 199.99, 'sale_price' => null, 'quantity' => 30, 'featured' => true, 'status' => 'active'],
            
            // Girls' products
            ['name' => 'Princess Dress', 'slug' => 'princess-dress', 'sku' => 'GPD001', 'description' => 'Beautiful princess dress for girls', 'regular_price' => 149.99, 'sale_price' => 119.99, 'quantity' => 25, 'featured' => true, 'status' => 'active'],
            ['name' => 'Girls Ballet Shoes', 'slug' => 'girls-ballet-shoes', 'sku' => 'GBS001', 'description' => 'Comfortable ballet shoes for girls', 'regular_price' => 89.99, 'sale_price' => null, 'quantity' => 20, 'featured' => false, 'status' => 'active'],
        ];

        foreach ($products as $index => $productData) {
            $category = $categories->random();
            $brand = $brands->random();
            
            $product = Product::create(array_merge($productData, [
                'category_id' => $category->id,
                'brand_id' => $brand->id,
                'image' => 'products/product_' . ($index + 1) . '.jpg',
            ]));
        }
    }

    private function createProductAttributes()
    {
        $this->command->info('🔗 Creating product attributes...');

        $products = Product::all();
        $sizeAttribute = Attribute::where('name', 'Size')->first();
        $colorAttribute = Attribute::where('name', 'Color')->first();

        foreach ($products as $product) {
            // Add random sizes
            $sizes = AttributeValue::where('attribute_id', $sizeAttribute->id)->inRandomOrder()->limit(3)->get();
            foreach ($sizes as $size) {
                ProductAttribute::create([
                    'product_id' => $product->id,
                    'attribute_value_id' => $size->id,
                ]);
            }

            // Add random colors
            $colors = AttributeValue::where('attribute_id', $colorAttribute->id)->inRandomOrder()->limit(2)->get();
            foreach ($colors as $color) {
                ProductAttribute::create([
                    'product_id' => $product->id,
                    'attribute_value_id' => $color->id,
                ]);
            }
        }
    }

    private function createInventory()
    {
        $this->command->info('📦 Creating inventory...');

        $products = Product::all();
        $warehouses = Warehouse::all();

        foreach ($products as $product) {
            foreach ($warehouses as $warehouse) {
                Inventory::updateOrCreate(
                    [
                        'product_id' => $product->id,
                        'warehouse_id' => $warehouse->id,
                    ],
                    [
                        'quantity' => rand(10, 100),
                        'minimum_stock' => 5,
                        'reorder_level' => 10,
                    ]
                );
            }
        }
    }

    private function createReviews()
    {
        $this->command->info('⭐ Creating reviews...');

        $products = Product::all();
        $users = User::all();

        $reviewTexts = [
            'Great product, highly recommended!',
            'Excellent quality and fast shipping.',
            'Love this item, will buy again.',
            'Good value for money.',
            'Perfect fit and comfortable.',
            'Beautiful design and great quality.',
            'Fast delivery and good packaging.',
            'Exactly as described, very satisfied.',
        ];

        foreach ($products as $product) {
            $reviewCount = rand(3, 8);
            for ($i = 0; $i < $reviewCount; $i++) {
                Review::create([
                    'product_id' => $product->id,
                    'user_id' => $users->random()->id,
                    'rating' => rand(3, 5),
                    'comment' => $reviewTexts[array_rand($reviewTexts)],
                    'is_approved' => true,
                ]);
            }
        }
    }

    private function createOrders()
    {
        $this->command->info('🛒 Creating orders...');

        $users = User::all();
        $products = Product::all();

        $orderStatuses = ['pending', 'confirmed', 'processing', 'shipped', 'delivered', 'cancelled'];

        for ($i = 0; $i < 20; $i++) {
            $user = $users->random();
            $order = Order::create([
                'user_id' => $user->id,
                'order_number' => 'ORD' . str_pad($i + 1, 6, '0', STR_PAD_LEFT),
                'status' => $orderStatuses[array_rand($orderStatuses)],
                'subtotal' => 0, // Will be calculated
                'total_amount' => 0, // Will be calculated
                'customer_name' => $user->name,
                'customer_phone' => $user->mobile ?? '+201234567890',
                'customer_email' => $user->email,
                'shipping_address' => '123 Main St, Cairo, Egypt',
                'billing_address' => '123 Main St, Cairo, Egypt',
                'notes' => 'Please handle with care',
            ]);

            // Add random products to order
            $productCount = rand(1, 4);
            $selectedProducts = $products->random($productCount);
            $totalAmount = 0;

            foreach ($selectedProducts as $product) {
                $quantity = rand(1, 3);
                $price = $product->sale_price ?? $product->regular_price;
                $subtotal = $price * $quantity;
                $totalAmount += $subtotal;

                OrderItem::create([
                    'order_id' => $order->id,
                    'product_id' => $product->id,
                    'quantity' => $quantity,
                    'unit_price' => $price,
                    'total_price' => $subtotal,
                ]);
            }

            $order->update(['subtotal' => $totalAmount, 'total_amount' => $totalAmount]);
        }
    }

    private function createOrderItems()
    {
        // Order items are created in createOrders method
        $this->command->info('📋 Order items created with orders');
    }

    private function createTransactions()
    {
        $this->command->info('💳 Creating transactions...');

        $orders = Order::all();
        $paymentMethods = ['credit_card', 'debit_card', 'paypal', 'bank_transfer', 'cash_on_delivery'];

        foreach ($orders as $order) {
            Transaction::create([
                'order_id' => $order->id,
                'amount' => $order->total_amount,
                'payment_method' => $paymentMethods[array_rand($paymentMethods)],
                'status' => $order->status === 'cancelled' ? 'failed' : 'completed',
                'transaction_id' => 'TXN' . str_pad(rand(1, 999999), 6, '0', STR_PAD_LEFT),
            ]);
        }
    }

    private function createSliders()
    {
        $this->command->info('🖼️ Creating sliders...');

        $sliders = [
            [
                'title' => 'New Collection 2024',
                'subtitle' => 'Discover the latest fashion trends',
                'image' => 'sliders/slider1.jpg',
                'link' => '/products',
                'is_active' => true,
                'order' => 1,
                'start_date' => now()->subDays(30),
                'end_date' => now()->addDays(30),
            ],
            [
                'title' => 'Summer Sale',
                'subtitle' => 'Up to 50% off on selected items',
                'image' => 'sliders/slider2.jpg',
                'link' => '/sale',
                'is_active' => true,
                'order' => 2,
                'start_date' => now()->subDays(15),
                'end_date' => now()->addDays(15),
            ],
            [
                'title' => 'Premium Brands',
                'subtitle' => 'Shop from top fashion brands',
                'image' => 'sliders/slider3.jpg',
                'link' => '/brands',
                'is_active' => true,
                'order' => 3,
                'start_date' => now()->subDays(7),
                'end_date' => now()->addDays(60),
            ],
        ];

        foreach ($sliders as $slider) {
            Slider::create($slider);
        }
    }

    private function createContacts()
    {
        if (!\Schema::hasTable('contacts')) {
            $this->command->info('⚠️ Contacts table does not exist, skipping contacts creation...');
            return;
        }

        $this->command->info('📞 Creating contacts...');

        $contactSubjects = [
            'Product Inquiry',
            'Order Status',
            'Return Request',
            'Size Guide',
            'Shipping Information',
            'Payment Issue',
            'Product Review',
            'General Question',
        ];

        $contactMessages = [
            'I would like to know more about this product.',
            'When will my order be delivered?',
            'I need to return an item.',
            'What sizes are available?',
            'How much does shipping cost?',
            'I have a problem with my payment.',
            'I love this product!',
            'Can you help me with my account?',
        ];

        $users = User::all();
        $products = Product::all();

        for ($i = 0; $i < 15; $i++) {
            $user = $users->random();
            
            Contact::create([
                'user_id' => $user->id,
                'subject' => $contactSubjects[array_rand($contactSubjects)],
                'message' => $contactMessages[array_rand($contactMessages)],
                'status' => ['pending', 'resolved'][array_rand(['pending', 'resolved'])],
                'priority' => ['low', 'medium', 'high', 'urgent'][array_rand(['low', 'medium', 'high', 'urgent'])],
                'contact_type' => ['inquiry', 'complaint', 'suggestion', 'other'][array_rand(['inquiry', 'complaint', 'suggestion', 'other'])],
            ]);
        }
    }
}
