<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Order;
use App\Models\User;
use Illuminate\Support\Facades\DB;

class OrderSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Clear existing orders
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        Order::truncate();
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');

        // Get users
        $users = User::all();

        if ($users->isEmpty()) {
            $this->command->warn('⚠️  No users found. Please seed users first.');
            return;
        }

        $orderCount = 0;

        // Sample customer data
        $customers = [
            ['name' => 'John Smith', 'phone' => '+1-555-0101', 'email' => 'john.smith@example.com', 'locality' => 'New York, NY'],
            ['name' => 'Sarah Johnson', 'phone' => '+1-555-0102', 'email' => 'sarah.johnson@example.com', 'locality' => 'Los Angeles, CA'],
            ['name' => 'Michael Brown', 'phone' => '+1-555-0103', 'email' => 'michael.brown@example.com', 'locality' => 'Chicago, IL'],
            ['name' => 'Emily Davis', 'phone' => '+1-555-0104', 'email' => 'emily.davis@example.com', 'locality' => 'Houston, TX'],
            ['name' => 'David Wilson', 'phone' => '+1-555-0105', 'email' => 'david.wilson@example.com', 'locality' => 'Phoenix, AZ'],
            ['name' => 'Lisa Anderson', 'phone' => '+1-555-0106', 'email' => 'lisa.anderson@example.com', 'locality' => 'Philadelphia, PA'],
            ['name' => 'James Taylor', 'phone' => '+1-555-0107', 'email' => 'james.taylor@example.com', 'locality' => 'San Antonio, TX'],
            ['name' => 'Jessica Martinez', 'phone' => '+1-555-0108', 'email' => 'jessica.martinez@example.com', 'locality' => 'San Diego, CA'],
            ['name' => 'Robert Garcia', 'phone' => '+1-555-0109', 'email' => 'robert.garcia@example.com', 'locality' => 'Dallas, TX'],
            ['name' => 'Ashley Rodriguez', 'phone' => '+1-555-0110', 'email' => 'ashley.rodriguez@example.com', 'locality' => 'San Jose, CA'],
        ];

        // Payment methods
        $paymentMethods = ['Credit Card', 'PayPal', 'Bank Transfer', 'Cash on Delivery', 'Apple Pay', 'Google Pay'];

        // Generate 15 sample orders
        for ($i = 0; $i < 15; $i++) {
            $customer = $customers[array_rand($customers)];
            $user = rand(1, 10) <= 7 ? $users->random() : null; // 70% chance of registered user
            
            // Generate realistic order amounts
            $subtotal = rand(2500, 50000) / 100; // $25.00 to $500.00
            $taxRate = 0.08; // 8% tax
            $taxAmount = round($subtotal * $taxRate, 2);
            $shippingAmount = $subtotal > 50 ? 0 : rand(500, 1500) / 100; // Free shipping over $50
            $discountAmount = rand(1, 10) <= 3 ? rand(500, 2000) / 100 : 0; // 30% chance of discount
            $totalAmount = $subtotal + $taxAmount + $shippingAmount - $discountAmount;

            // Generate realistic status distribution
            $statusWeights = [
                'pending' => 15,
                'confirmed' => 20,
                'processing' => 25,
                'shipped' => 20,
                'delivered' => 15,
                'cancelled' => 3,
                'refunded' => 2
            ];
            
            $randomNum = rand(1, 100);
            $status = 'pending';
            $cumulative = 0;
            foreach ($statusWeights as $s => $weight) {
                $cumulative += $weight;
                if ($randomNum <= $cumulative) {
                    $status = $s;
                    break;
                }
            }

            // Payment status based on order status
            $paymentStatus = match($status) {
                'delivered', 'shipped', 'processing' => 'paid',
                'cancelled' => rand(1, 2) === 1 ? 'failed' : 'pending',
                'refunded' => 'refunded',
                default => rand(1, 3) === 1 ? 'paid' : 'pending'
            };

            $order = new Order();
            $orderNumber = $order->generateOrderNumber();

            Order::create([
                'user_id' => $user?->id,
                'order_number' => $orderNumber,
                'subtotal' => $subtotal,
                'tax_amount' => $taxAmount,
                'shipping_amount' => $shippingAmount,
                'discount_amount' => $discountAmount,
                'total_amount' => $totalAmount,
                'customer_name' => $customer['name'],
                'customer_phone' => $customer['phone'],
                'customer_email' => $customer['email'],
                'shipping_address' => $this->generateAddress(),
                'billing_address' => rand(1, 3) === 1 ? $this->generateAddress() : null,
                'locality' => $customer['locality'],
                'status' => $status,
                'payment_status' => $paymentStatus,
                'payment_method' => $paymentMethods[array_rand($paymentMethods)],
                'notes' => rand(1, 4) === 1 ? $this->generateNotes() : null,
                'created_at' => now()->subDays(rand(1, 60)), // Random date within last 60 days
            ]);

            $orderCount++;
        }

        $this->command->info('✅ Orders seeded successfully!');
        $this->command->info('📊 Users available: ' . $users->count());
        $this->command->info('📦 Total orders created: ' . $orderCount);
        
        // Show statistics
        $this->showStatistics();
    }

    /**
     * Generate a random address
     */
    private function generateAddress(): string
    {
        $streets = [
            '123 Main Street', '456 Oak Avenue', '789 Pine Road', '321 Elm Street', '654 Maple Drive',
            '987 Cedar Lane', '147 Birch Boulevard', '258 Willow Way', '369 Spruce Street', '741 Aspen Avenue'
        ];
        
        $cities = [
            'Springfield, IL 62701', 'Riverside, CA 92501', 'Franklin, TN 37064', 'Georgetown, TX 78626',
            'Clinton, MS 39056', 'Madison, WI 53703', 'Marion, IN 46952', 'Salem, OR 97301'
        ];

        return $streets[array_rand($streets)] . ', ' . $cities[array_rand($cities)];
    }

    /**
     * Generate random order notes
     */
    private function generateNotes(): string
    {
        $notes = [
            'Customer requested expedited shipping.',
            'Gift wrapping requested for birthday present.',
            'Leave package at front door if no answer.',
            'Customer has allergies - handle with care.',
            'Fragile items - please handle carefully.',
            'Customer prefers morning delivery.',
            'Special discount applied for loyalty customer.',
            'Rush order - customer needs by weekend.',
            'Customer requested color change after order.',
            'Delivery to business address during office hours only.'
        ];

        return $notes[array_rand($notes)];
    }

    /**
     * Show order statistics
     */
    private function showStatistics(): void
    {
        $stats = [
            'total_orders' => Order::count(),
            'pending_orders' => Order::where('status', 'pending')->count(),
            'confirmed_orders' => Order::where('status', 'confirmed')->count(),
            'processing_orders' => Order::where('status', 'processing')->count(),
            'shipped_orders' => Order::where('status', 'shipped')->count(),
            'delivered_orders' => Order::where('status', 'delivered')->count(),
            'cancelled_orders' => Order::where('status', 'cancelled')->count(),
            'refunded_orders' => Order::where('status', 'refunded')->count(),
            'paid_orders' => Order::where('payment_status', 'paid')->count(),
            'pending_payments' => Order::where('payment_status', 'pending')->count(),
            'total_revenue' => Order::where('payment_status', 'paid')->sum('total_amount'),
            'average_order_value' => Order::avg('total_amount'),
        ];

        $this->command->info('');
        $this->command->info('📈 ORDER STATISTICS:');
        $this->command->info('• Total Orders: ' . number_format($stats['total_orders']));
        $this->command->info('• Pending: ' . $stats['pending_orders'] . ' (' . round(($stats['pending_orders'] / $stats['total_orders']) * 100, 1) . '%)');
        $this->command->info('• Confirmed: ' . $stats['confirmed_orders'] . ' (' . round(($stats['confirmed_orders'] / $stats['total_orders']) * 100, 1) . '%)');
        $this->command->info('• Processing: ' . $stats['processing_orders'] . ' (' . round(($stats['processing_orders'] / $stats['total_orders']) * 100, 1) . '%)');
        $this->command->info('• Shipped: ' . $stats['shipped_orders'] . ' (' . round(($stats['shipped_orders'] / $stats['total_orders']) * 100, 1) . '%)');
        $this->command->info('• Delivered: ' . $stats['delivered_orders'] . ' (' . round(($stats['delivered_orders'] / $stats['total_orders']) * 100, 1) . '%)');
        $this->command->info('• Cancelled: ' . $stats['cancelled_orders'] . ' (' . round(($stats['cancelled_orders'] / $stats['total_orders']) * 100, 1) . '%)');
        $this->command->info('• Refunded: ' . $stats['refunded_orders'] . ' (' . round(($stats['refunded_orders'] / $stats['total_orders']) * 100, 1) . '%)');
        $this->command->info('');
        $this->command->info('💰 PAYMENT STATISTICS:');
        $this->command->info('• Paid Orders: ' . $stats['paid_orders'] . ' (' . round(($stats['paid_orders'] / $stats['total_orders']) * 100, 1) . '%)');
        $this->command->info('• Pending Payments: ' . $stats['pending_payments'] . ' (' . round(($stats['pending_payments'] / $stats['total_orders']) * 100, 1) . '%)');
        $this->command->info('• Total Revenue: $' . number_format($stats['total_revenue'], 2));
        $this->command->info('• Average Order Value: $' . number_format($stats['average_order_value'], 2));
    }
}