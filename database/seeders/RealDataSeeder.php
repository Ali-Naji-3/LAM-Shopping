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
