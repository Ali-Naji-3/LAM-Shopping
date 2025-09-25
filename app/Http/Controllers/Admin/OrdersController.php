<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\User;
use App\Models\Product;
use Illuminate\Http\Request;

class OrdersController extends Controller
{
    /**
     * Helper method to safely count records and handle missing tables
     */
    private function safeCount(callable $callback)
    {
        try {
            return $callback();
        } catch (\Illuminate\Database\QueryException $e) {
            if (str_contains($e->getMessage(), "doesn't exist")) {
                return 0;
            }
            throw $e;
        }
    }

    /**
     * Display a listing of orders.
     */
    public function index(Request $request)
    {
        $query = Order::with(['user', 'orderItems.product']);

        // Search functionality
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('order_number', 'like', "%{$search}%")
                  ->orWhere('customer_name', 'like', "%{$search}%")
                  ->orWhere('customer_email', 'like', "%{$search}%")
                  ->orWhere('customer_phone', 'like', "%{$search}%")
                  ->orWhereHas('user', function($subQ) use ($search) {
                      $subQ->where('name', 'like', "%{$search}%")
                           ->orWhere('email', 'like', "%{$search}%");
                  });
            });
        }

        // Filter by status
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        // Filter by payment status
        if ($request->filled('payment_status')) {
            $query->where('payment_status', $request->payment_status);
        }

        // Filter by date range
        if ($request->filled('date_from')) {
            $query->whereDate('created_at', '>=', $request->date_from);
        }
        if ($request->filled('date_to')) {
            $query->whereDate('created_at', '<=', $request->date_to);
        }

        // Filter by amount range
        if ($request->filled('amount_min')) {
            $query->where('total_amount', '>=', $request->amount_min);
        }
        if ($request->filled('amount_max')) {
            $query->where('total_amount', '<=', $request->amount_max);
        }

        $orders = $query->orderBy('created_at', 'desc')->paginate(20);

        // Calculate statistics
        $statistics = [
            'total_orders' => Order::count(),
            'pending_orders' => Order::where('status', 'pending')->count(),
            'completed_orders' => Order::where('status', 'delivered')->count(),
            'cancelled_orders' => Order::where('status', 'cancelled')->count(),
            'total_revenue' => Order::where('payment_status', 'paid')->sum('total_amount'),
            'pending_revenue' => Order::where('payment_status', 'pending')->sum('total_amount'),
            'average_order_value' => Order::avg('total_amount') ?? 0,
        ];

        return view('admin.orders.index', compact('orders', 'statistics'));
    }

    /**
     * Show the form for creating a new order.
     */
    public function create()
    {
        $users = User::orderBy('name')->get();
        $products = Product::with(['category', 'brand'])->orderBy('name')->get();
        
        return view('admin.orders.create', compact('users', 'products'));
    }

    /**
     * Store a newly created order.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'user_id' => 'nullable|exists:users,id',
            'customer_name' => 'required|string|max:255',
            'customer_phone' => 'required|string|max:20',
            'customer_email' => 'required|email|max:255',
            'shipping_address' => 'required|string',
            'billing_address' => 'nullable|string',
            'locality' => 'nullable|string|max:255',
            'subtotal' => 'required|numeric|min:0',
            'tax_amount' => 'nullable|numeric|min:0',
            'shipping_amount' => 'nullable|numeric|min:0',
            'discount_amount' => 'nullable|numeric|min:0',
            'total_amount' => 'required|numeric|min:0',
            'status' => 'required|in:pending,confirmed,processing,shipped,delivered,cancelled,refunded',
            'payment_status' => 'required|in:pending,paid,failed,refunded',
            'payment_method' => 'nullable|string|max:50',
            'notes' => 'nullable|string',
        ]);

        // Set defaults
        $validated['tax_amount'] = $validated['tax_amount'] ?? 0.00;
        $validated['shipping_amount'] = $validated['shipping_amount'] ?? 0.00;
        $validated['discount_amount'] = $validated['discount_amount'] ?? 0.00;

        // Generate unique order number
        $order = new Order($validated);
        $validated['order_number'] = $order->generateOrderNumber();

        $order = Order::create($validated);

        return redirect()->route('admin.orders.index')
            ->with('success', 'Order created successfully!');
    }

    /**
     * Display the specified order.
     */
    public function show(Order $order)
    {
        $order->load(['user', 'orderItems.product.category', 'orderItems.product.brand', 'transactions']);
        
        // Calculate order analytics
        $orderAnalytics = [
            'items_count' => $order->orderItems()->count(),
            'total_quantity' => $order->orderItems()->sum('quantity'),
            'average_item_price' => $order->orderItems()->count() > 0 ? 
                $order->orderItems()->sum('price') / $order->orderItems()->sum('quantity') : 0,
            'transactions_count' => $this->safeCount(function() use ($order) {
                return $order->transactions()->count();
            }),
            'payment_total' => $this->safeCount(function() use ($order) {
                return $order->transactions()->sum('amount');
            }),
        ];

        return view('admin.orders.show', compact('order', 'orderAnalytics'));
    }

    /**
     * Show the form for editing the specified order.
     */
    public function edit(Order $order)
    {
        $order->load(['user', 'orderItems']);
        $users = User::orderBy('name')->get();
        
        return view('admin.orders.edit', compact('order', 'users'));
    }

    /**
     * Update the specified order.
     */
    public function update(Request $request, Order $order)
    {
        $validated = $request->validate([
            'user_id' => 'nullable|exists:users,id',
            'customer_name' => 'required|string|max:255',
            'customer_phone' => 'required|string|max:20',
            'customer_email' => 'required|email|max:255',
            'shipping_address' => 'required|string',
            'billing_address' => 'nullable|string',
            'locality' => 'nullable|string|max:255',
            'subtotal' => 'required|numeric|min:0',
            'tax_amount' => 'nullable|numeric|min:0',
            'shipping_amount' => 'nullable|numeric|min:0',
            'discount_amount' => 'nullable|numeric|min:0',
            'total_amount' => 'required|numeric|min:0',
            'status' => 'required|in:pending,confirmed,processing,shipped,delivered,cancelled,refunded',
            'payment_status' => 'required|in:pending,paid,failed,refunded',
            'payment_method' => 'nullable|string|max:50',
            'notes' => 'nullable|string',
        ]);

        // Set defaults
        $validated['tax_amount'] = $validated['tax_amount'] ?? 0.00;
        $validated['shipping_amount'] = $validated['shipping_amount'] ?? 0.00;
        $validated['discount_amount'] = $validated['discount_amount'] ?? 0.00;

        $order->update($validated);

        return redirect()->route('admin.orders.index')
            ->with('success', 'Order updated successfully!');
    }

    /**
     * Remove the specified order.
     */
    public function destroy(Order $order)
    {
        $order->delete();

        return redirect()->route('admin.orders.index')
            ->with('success', 'Order deleted successfully!');
    }

    /**
     * Handle bulk actions for orders.
     */
    public function bulkActions(Request $request)
    {
        $request->validate([
            'action' => 'required|in:update_status,update_payment_status,delete',
            'selected_orders' => 'required|array|min:1',
            'selected_orders.*' => 'exists:orders,id',
            'bulk_status' => 'nullable|in:pending,confirmed,processing,shipped,delivered,cancelled,refunded',
            'bulk_payment_status' => 'nullable|in:pending,paid,failed,refunded'
        ]);

        $orders = Order::whereIn('id', $request->selected_orders);

        switch ($request->action) {
            case 'update_status':
                if ($request->filled('bulk_status')) {
                    $orders->update(['status' => $request->bulk_status]);
                    return redirect()->back()->with('success', 'Order statuses updated successfully!');
                } else {
                    return redirect()->back()->with('error', 'Please select a status for bulk update.');
                }
                
            case 'update_payment_status':
                if ($request->filled('bulk_payment_status')) {
                    $orders->update(['payment_status' => $request->bulk_payment_status]);
                    return redirect()->back()->with('success', 'Payment statuses updated successfully!');
                } else {
                    return redirect()->back()->with('error', 'Please select a payment status for bulk update.');
                }
                
            case 'delete':
                $orders->delete();
                return redirect()->back()->with('success', 'Selected orders deleted successfully!');
        }
    }

    /**
     * Update order status.
     */
    public function updateStatus(Request $request, Order $order)
    {
        $request->validate([
            'status' => 'required|in:pending,confirmed,processing,shipped,delivered,cancelled,refunded'
        ]);

        $order->update(['status' => $request->status]);
        
        return redirect()->back()->with('success', "Order status updated to {$request->status}!");
    }

    /**
     * Update payment status.
     */
    public function updatePaymentStatus(Request $request, Order $order)
    {
        $request->validate([
            'payment_status' => 'required|in:pending,paid,failed,refunded'
        ]);

        $order->update(['payment_status' => $request->payment_status]);
        
        return redirect()->back()->with('success', "Payment status updated to {$request->payment_status}!");
    }

    /**
     * Show analytics for orders.
     */
    public function analytics()
    {
        $analytics = [
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
            'failed_payments' => Order::where('payment_status', 'failed')->count(),
            'refunded_payments' => Order::where('payment_status', 'refunded')->count(),
            
            'total_revenue' => Order::where('payment_status', 'paid')->sum('total_amount'),
            'pending_revenue' => Order::where('payment_status', 'pending')->sum('total_amount'),
            'average_order_value' => Order::avg('total_amount') ?? 0,
            'completion_rate' => Order::count() > 0 ? 
                round((Order::where('status', 'delivered')->count() / Order::count()) * 100, 1) : 0,
            
            'recent_orders' => Order::with(['user', 'orderItems'])
                ->orderBy('created_at', 'desc')
                ->limit(10)
                ->get(),
            
            'top_customers' => $this->safeCount(function() {
                return User::withCount('orders')
                    ->withSum('orders', 'total_amount')
                    ->orderBy('orders_sum_total_amount', 'desc')
                    ->limit(10)
                    ->get();
            }),
            
            'monthly_revenue' => $this->getMonthlyRevenue(),
            'status_distribution' => $this->getStatusDistribution(),
        ];

        return view('admin.orders.analytics', compact('analytics'));
    }

    /**
     * Get monthly revenue data for the last 12 months.
     */
    private function getMonthlyRevenue()
    {
        $monthlyData = [];
        for ($i = 11; $i >= 0; $i--) {
            $date = now()->subMonths($i);
            $revenue = Order::where('payment_status', 'paid')
                ->whereYear('created_at', $date->year)
                ->whereMonth('created_at', $date->month)
                ->sum('total_amount');
            
            $monthlyData[] = [
                'month' => $date->format('M Y'),
                'revenue' => $revenue,
                'orders_count' => Order::whereYear('created_at', $date->year)
                    ->whereMonth('created_at', $date->month)
                    ->count()
            ];
        }
        
        return $monthlyData;
    }

    /**
     * Get status distribution data.
     */
    private function getStatusDistribution()
    {
        $statuses = ['pending', 'confirmed', 'processing', 'shipped', 'delivered', 'cancelled', 'refunded'];
        $distribution = [];
        
        foreach ($statuses as $status) {
            $count = Order::where('status', $status)->count();
            $distribution[] = [
                'status' => $status,
                'count' => $count,
                'percentage' => Order::count() > 0 ? round(($count / Order::count()) * 100, 1) : 0
            ];
        }
        
        return $distribution;
    }
}