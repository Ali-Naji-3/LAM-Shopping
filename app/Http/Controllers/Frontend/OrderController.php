<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class OrderController extends Controller
{
    /**
     * Display the checkout page
     */
    public function checkout()
    {
        $cart = session()->get('cart', []);
        
        if (empty($cart)) {
            return redirect()->route('cart.index')->with('error', 'Your cart is empty!');
        }

        $subtotal = collect($cart)->sum(function($item) {
            return $item['price'] * $item['qty'];
        });

        $shipping = 10.00; // Default shipping cost
        $tax = $subtotal * 0.1; // 10% tax
        $total = $subtotal + $shipping + $tax;

        $user = Auth::user();

        return view('frontend.checkout', compact('cart', 'subtotal', 'shipping', 'tax', 'total', 'user'));
    }

    /**
     * Process the order
     */
    public function placeOrder(Request $request)
    {
        // Validate the request
        $validated = $request->validate([
            'customer_name' => 'required|string|max:255',
            'customer_email' => 'required|email|max:255',
            'customer_phone' => 'required|string|max:20',
            'shipping_address' => 'required|string',
            'shipping_city' => 'required|string|max:255',
            'shipping_postal_code' => 'required|string|max:20',
            'shipping_country' => 'required|string|max:255',
            'billing_address' => 'nullable|string',
            'billing_city' => 'nullable|string|max:255',
            'billing_postal_code' => 'nullable|string|max:20',
            'billing_country' => 'nullable|string|max:255',
            'payment_method' => 'required|string|max:50',
            'shipping_method' => 'required|string|max:50',
            'notes' => 'nullable|string',
        ]);

        // Get cart from session
        $cart = session()->get('cart', []);

        if (empty($cart)) {
            return redirect()->route('cart.index')->with('error', 'Your cart is empty!');
        }

        // Calculate totals
        $subtotal = collect($cart)->sum(function($item) {
            return $item['price'] * $item['qty'];
        });

        $shipping_amount = $request->shipping_method === 'express' ? 20.00 : 10.00;
        $tax_amount = $subtotal * 0.1; // 10% tax
        $total_amount = $subtotal + $shipping_amount + $tax_amount;

        try {
            DB::beginTransaction();

            // Create the order
            $order = Order::create([
                'user_id' => Auth::id(),
                'order_number' => 'ORD-' . now()->format('YmdHis') . '-' . rand(1000, 9999),
                'customer_name' => $validated['customer_name'],
                'customer_email' => $validated['customer_email'],
                'customer_phone' => $validated['customer_phone'],
                'shipping_address' => $validated['shipping_address'] . "\n" . 
                                     $validated['shipping_city'] . ', ' . 
                                     $validated['shipping_postal_code'] . "\n" . 
                                     $validated['shipping_country'],
                'billing_address' => !empty($validated['billing_address']) 
                    ? $validated['billing_address'] . "\n" . 
                      $validated['billing_city'] . ', ' . 
                      $validated['billing_postal_code'] . "\n" . 
                      $validated['billing_country']
                    : null,
                'locality' => $validated['shipping_city'],
                'subtotal' => $subtotal,
                'tax_amount' => $tax_amount,
                'shipping_amount' => $shipping_amount,
                'discount_amount' => 0,
                'total_amount' => $total_amount,
                'status' => 'pending',
                'payment_status' => 'pending',
                'payment_method' => ucfirst($validated['payment_method']),
                'notes' => $validated['notes'] ?? null,
            ]);

            // Create order items
            foreach ($cart as $productId => $item) {
                $product = Product::find($productId);
                
                if ($product) {
                    OrderItem::create([
                        'order_id' => $order->id,
                        'product_id' => $product->id,
                        'quantity' => $item['qty'],
                        'unit_price' => $item['price'],
                        'total_price' => $item['price'] * $item['qty'],
                    ]);

                    // Update product stock
                    if ($product->stock_quantity !== null) {
                        $product->decrement('stock_quantity', $item['qty']);
                    }
                }
            }

            DB::commit();

            // Clear the cart
            session()->forget('cart');

            // Log for debugging
            \Log::info('Order placed successfully', [
                'order_id' => $order->id,
                'order_number' => $order->order_number,
                'total' => $order->total_amount,
                'items_count' => $order->orderItems->count(),
            ]);

            return redirect()->route('frontend.order.confirmation', $order->id)
                ->with('success', 'Your order has been placed successfully!');

        } catch (\Exception $e) {
            DB::rollBack();
            
            \Log::error('Order placement failed', [
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString(),
            ]);

            return redirect()->back()
                ->withInput()
                ->with('error', 'Failed to place order. Please try again.');
        }
    }

    /**
     * Show order confirmation page
     */
    public function confirmation($orderId)
    {
        $order = Order::with('orderItems.product')->findOrFail($orderId);

        // Check if user has access to this order
        if (Auth::check() && $order->user_id !== Auth::id()) {
            abort(403, 'Unauthorized access to this order.');
        }

        return view('frontend.order-confirmation', compact('order'));
    }
}
