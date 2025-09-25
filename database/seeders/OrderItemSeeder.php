<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\OrderItem;
use App\Models\Order;
use App\Models\Product;

class OrderItemSeeder extends Seeder
{
    /**
     * Run the database seeder.
     */
    public function run(): void
    {
        // Clear existing order items (handle foreign key constraints)
        \DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        OrderItem::truncate();
        \DB::statement('SET FOREIGN_KEY_CHECKS=1;');

        // Get existing orders and products
        $orders = Order::all();
        $products = Product::all();

        if ($orders->isEmpty() || $products->isEmpty()) {
            $this->command->warn('No orders or products found. Please seed orders and products first.');
            return;
        }

        $orderItems = [];

        foreach ($orders as $order) {
            // Each order will have 1-5 random items
            $itemCount = rand(1, 5);
            $usedProducts = [];
            $orderTotal = 0;

            for ($i = 0; $i < $itemCount; $i++) {
                // Get a random product that hasn't been used in this order
                $availableProducts = $products->whereNotIn('id', $usedProducts);
                if ($availableProducts->isEmpty()) {
                    break; // No more unique products available
                }

                $product = $availableProducts->random();
                $usedProducts[] = $product->id;

                $quantity = rand(1, 3);
                $unitPrice = $product->regular_price ?? rand(10, 500);
                
                // Sometimes apply a discount
                $hasDiscount = rand(1, 4) === 1; // 25% chance
                $discountAmount = $hasDiscount ? rand(5, 20) : 0;
                $totalPrice = ($quantity * $unitPrice) - $discountAmount;
                
                $orderTotal += $totalPrice;

                // Generate sample attributes based on product type
                $attributes = $this->generateSampleAttributes($product);

                $orderItems[] = [
                    'order_id' => $order->id,
                    'product_id' => $product->id,
                    'quantity' => $quantity,
                    'unit_price' => $unitPrice,
                    'total_price' => $totalPrice,
                    'attributes' => $attributes ? json_encode($attributes) : null,
                    'created_at' => now()->subDays(rand(0, 30)),
                    'updated_at' => now()->subDays(rand(0, 5)),
                ];
            }

            // Update order totals
            $order->update([
                'subtotal' => $orderTotal,
                'total_amount' => $orderTotal + $order->tax_amount + $order->shipping_amount - $order->discount_amount,
            ]);
        }

        // Insert all order items
        OrderItem::insert($orderItems);

        $this->command->info('Order items seeded successfully!');
        $this->command->info('Created ' . count($orderItems) . ' order items across ' . $orders->count() . ' orders.');
    }

    /**
     * Generate sample attributes for a product
     */
    private function generateSampleAttributes($product): ?array
    {
        // Sometimes no attributes
        if (rand(1, 3) === 1) {
            return null;
        }

        $attributes = [];

        // Color attribute (common for clothing/accessories)
        $colors = ['Red', 'Blue', 'Green', 'Black', 'White', 'Navy', 'Gray', 'Pink', 'Purple', 'Brown'];
        if (rand(1, 2) === 1) {
            $attributes['color'] = $colors[array_rand($colors)];
        }

        // Size attribute (for clothing)
        $sizes = ['XS', 'S', 'M', 'L', 'XL', 'XXL'];
        if (rand(1, 3) === 1) {
            $attributes['size'] = $sizes[array_rand($sizes)];
        }

        // Material attribute
        $materials = ['Cotton', 'Polyester', 'Wool', 'Silk', 'Denim', 'Leather', 'Canvas', 'Linen'];
        if (rand(1, 4) === 1) {
            $attributes['material'] = $materials[array_rand($materials)];
        }

        // Style attribute
        $styles = ['Casual', 'Formal', 'Sport', 'Vintage', 'Modern', 'Classic'];
        if (rand(1, 5) === 1) {
            $attributes['style'] = $styles[array_rand($styles)];
        }

        // Custom engraving/personalization
        if (rand(1, 10) === 1) {
            $personalizations = ['Custom Name', 'Monogram', 'Special Message', 'Gift Wrapping'];
            $attributes['personalization'] = $personalizations[array_rand($personalizations)];
        }

        // Warranty/Protection
        if (rand(1, 8) === 1) {
            $warranties = ['1 Year Extended', '2 Year Protection', 'Premium Care', 'Standard Warranty'];
            $attributes['warranty'] = $warranties[array_rand($warranties)];
        }

        // Return empty array if no attributes were added
        return empty($attributes) ? null : $attributes;
    }
}