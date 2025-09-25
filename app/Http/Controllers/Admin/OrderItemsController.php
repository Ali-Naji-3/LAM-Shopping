<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\OrderItem;
use App\Models\Order;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class OrderItemsController extends Controller
{
    /**
     * Display a listing of the order items.
     */
    public function index(Request $request)
    {
        $query = OrderItem::query()->with(['order', 'product']);

        // Search functionality
        if ($request->filled('search')) {
            $search = $request->search;
            $query->whereHas('order', function($q) use ($search) {
                $q->where('order_number', 'like', "%{$search}%")
                  ->orWhere('customer_name', 'like', "%{$search}%");
            })->orWhereHas('product', function($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('sku', 'like', "%{$search}%");
            });
        }

        // Filter by order
        if ($request->filled('order_id')) {
            $query->where('order_id', $request->order_id);
        }

        // Filter by product
        if ($request->filled('product_id')) {
            $query->where('product_id', $request->product_id);
        }

        // Sort
        $sortBy = $request->get('sort_by', 'created_at');
        $sortOrder = $request->get('sort_order', 'desc');
        $query->orderBy($sortBy, $sortOrder);

        $orderItems = $query->paginate(10);

        // Statistics
        $statistics = $this->getStatistics($request);

        // Get orders and products for filters
        $orders = Order::orderBy('order_number')->get(['id', 'order_number', 'customer_name']);
        $products = Product::orderBy('name')->get(['id', 'name', 'sku']);

        return view('admin.order-items.index', compact('orderItems', 'statistics', 'orders', 'products'));
    }

    /**
     * Show the form for creating a new order item.
     */
    public function create(Request $request)
    {
        $orders = Order::orderBy('order_number')->get(['id', 'order_number', 'customer_name']);
        $products = Product::with(['category', 'brand'])->orderBy('name')->get();
        
        // Pre-select order if provided
        $selectedOrder = null;
        if ($request->filled('order_id')) {
            $selectedOrder = Order::find($request->order_id);
        }

        return view('admin.order-items.create', compact('orders', 'products', 'selectedOrder'));
    }

    /**
     * Store a newly created order item in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'order_id' => 'required|exists:orders,id',
            'product_id' => 'required|exists:products,id',
            'quantity' => 'required|integer|min:1',
            'unit_price' => 'required|numeric|min:0',
            'total_price' => 'required|numeric|min:0',
            'attributes' => 'nullable|array',
        ]);

        DB::beginTransaction();
        try {
            // Create order item
            $orderItem = OrderItem::create([
                'order_id' => $request->order_id,
                'product_id' => $request->product_id,
                'quantity' => $request->quantity,
                'unit_price' => $request->unit_price,
                'total_price' => $request->total_price,
                'attributes' => $request->attributes,
            ]);

            // Update order total
            $this->updateOrderTotal($request->order_id);

            DB::commit();

            return redirect()->route('admin.orderItems.index')
                ->with('success', 'Order item created successfully!');
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->withInput()
                ->with('error', 'Failed to create order item: ' . $e->getMessage());
        }
    }

    /**
     * Display the specified order item.
     */
    public function show(OrderItem $orderItem)
    {
        $orderItem->load(['order', 'product.category', 'product.brand']);
        
        // Get related order items
        $relatedItems = OrderItem::where('order_id', $orderItem->order_id)
            ->where('id', '!=', $orderItem->id)
            ->with(['product'])
            ->get();

        // Get item analytics
        $itemAnalytics = [
            'subtotal' => $orderItem->item_subtotal,
            'discount_amount' => $orderItem->discount_amount,
            'discount_percentage' => $orderItem->discount_percentage,
            'has_discount' => $orderItem->has_discount,
            'attributes_count' => $orderItem->attributes ? count($orderItem->attributes) : 0,
        ];

        return view('admin.order-items.show', compact('orderItem', 'relatedItems', 'itemAnalytics'));
    }

    /**
     * Show the form for editing the specified order item.
     */
    public function edit(OrderItem $orderItem)
    {
        $orderItem->load(['order', 'product']);
        $orders = Order::orderBy('order_number')->get(['id', 'order_number', 'customer_name']);
        $products = Product::with(['category', 'brand'])->orderBy('name')->get();

        return view('admin.order-items.edit', compact('orderItem', 'orders', 'products'));
    }

    /**
     * Update the specified order item in storage.
     */
    public function update(Request $request, OrderItem $orderItem)
    {
        $request->validate([
            'order_id' => 'required|exists:orders,id',
            'product_id' => 'required|exists:products,id',
            'quantity' => 'required|integer|min:1',
            'unit_price' => 'required|numeric|min:0',
            'total_price' => 'required|numeric|min:0',
            'attributes' => 'nullable|array',
        ]);

        DB::beginTransaction();
        try {
            $oldOrderId = $orderItem->order_id;

            // Update order item
            $orderItem->update([
                'order_id' => $request->order_id,
                'product_id' => $request->product_id,
                'quantity' => $request->quantity,
                'unit_price' => $request->unit_price,
                'total_price' => $request->total_price,
                'attributes' => $request->attributes,
            ]);

            // Update order totals
            $this->updateOrderTotal($oldOrderId);
            if ($oldOrderId != $request->order_id) {
                $this->updateOrderTotal($request->order_id);
            }

            DB::commit();

            return redirect()->route('admin.orderItems.show', $orderItem)
                ->with('success', 'Order item updated successfully!');
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->withInput()
                ->with('error', 'Failed to update order item: ' . $e->getMessage());
        }
    }

    /**
     * Remove the specified order item from storage.
     */
    public function destroy(OrderItem $orderItem)
    {
        DB::beginTransaction();
        try {
            $orderId = $orderItem->order_id;
            $orderItem->delete();

            // Update order total
            $this->updateOrderTotal($orderId);

            DB::commit();

            return redirect()->route('admin.orderItems.index')
                ->with('success', 'Order item deleted successfully!');
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Failed to delete order item: ' . $e->getMessage());
        }
    }

    /**
     * Get statistics for the index page.
     */
    private function getStatistics(Request $request)
    {
        $query = OrderItem::query();

        // Apply same filters as index
        if ($request->filled('search')) {
            $search = $request->search;
            $query->whereHas('order', function($q) use ($search) {
                $q->where('order_number', 'like', "%{$search}%")
                  ->orWhere('customer_name', 'like', "%{$search}%");
            })->orWhereHas('product', function($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('sku', 'like', "%{$search}%");
            });
        }

        if ($request->filled('order_id')) {
            $query->where('order_id', $request->order_id);
        }

        if ($request->filled('product_id')) {
            $query->where('product_id', $request->product_id);
        }

        return [
            'total_items' => $query->count(),
            'total_quantity' => $query->sum('quantity'),
            'total_value' => $query->sum('total_price'),
            'average_unit_price' => $query->avg('unit_price'),
            'average_quantity' => $query->avg('quantity'),
            'unique_orders' => $query->distinct('order_id')->count(),
            'unique_products' => $query->distinct('product_id')->count(),
        ];
    }

    /**
     * Show analytics dashboard for order items.
     */
    public function analytics(Request $request)
    {
        // Overall statistics
        $overallStats = OrderItem::getOrderItemsStatistics();

        // Monthly trends
        $monthlyTrends = OrderItem::selectRaw('
            DATE_FORMAT(created_at, "%Y-%m") as month,
            COUNT(*) as items_count,
            SUM(quantity) as total_quantity,
            SUM(total_price) as total_value,
            AVG(unit_price) as avg_unit_price
        ')
        ->groupBy('month')
        ->orderBy('month', 'desc')
        ->limit(12)
        ->get();

        // Top products by quantity sold
        $topProductsByQuantity = OrderItem::select('product_id')
            ->selectRaw('SUM(quantity) as total_quantity, SUM(total_price) as total_value, COUNT(*) as order_count')
            ->with('product')
            ->groupBy('product_id')
            ->orderBy('total_quantity', 'desc')
            ->limit(10)
            ->get();

        // Top products by revenue
        $topProductsByRevenue = OrderItem::select('product_id')
            ->selectRaw('SUM(total_price) as total_revenue, SUM(quantity) as total_quantity, COUNT(*) as order_count')
            ->with('product')
            ->groupBy('product_id')
            ->orderBy('total_revenue', 'desc')
            ->limit(10)
            ->get();

        // Orders with most items
        $ordersWithMostItems = OrderItem::select('order_id')
            ->selectRaw('COUNT(*) as items_count, SUM(quantity) as total_quantity, SUM(total_price) as total_value')
            ->with('order')
            ->groupBy('order_id')
            ->orderBy('items_count', 'desc')
            ->limit(10)
            ->get();

        // Average order composition
        $averageOrderComposition = [
            'avg_items_per_order' => OrderItem::selectRaw('AVG(items_count) as avg_items')
                ->fromSub(
                    OrderItem::selectRaw('order_id, COUNT(*) as items_count')->groupBy('order_id'),
                    'order_items_counts'
                )->value('avg_items'),
            'avg_quantity_per_order' => OrderItem::selectRaw('AVG(total_quantity) as avg_quantity')
                ->fromSub(
                    OrderItem::selectRaw('order_id, SUM(quantity) as total_quantity')->groupBy('order_id'),
                    'order_quantities'
                )->value('avg_quantity'),
        ];

        return view('admin.order-items.analytics', compact(
            'overallStats',
            'monthlyTrends',
            'topProductsByQuantity',
            'topProductsByRevenue',
            'ordersWithMostItems',
            'averageOrderComposition'
        ));
    }

    /**
     * Handle bulk actions for order items.
     */
    public function bulkActions(Request $request)
    {
        $request->validate([
            'action' => 'required|in:delete,update_quantity,recalculate_totals',
            'selected_items' => 'required|array|min:1',
            'selected_items.*' => 'exists:order_items,id',
        ]);

        DB::beginTransaction();
        try {
            $selectedItems = OrderItem::whereIn('id', $request->selected_items)->get();
            $affectedOrders = $selectedItems->pluck('order_id')->unique();

            switch ($request->action) {
                case 'delete':
                    OrderItem::whereIn('id', $request->selected_items)->delete();
                    $message = count($request->selected_items) . ' order items deleted successfully!';
                    break;

                case 'update_quantity':
                    $request->validate(['quantity' => 'required|integer|min:1']);
                    foreach ($selectedItems as $item) {
                        $item->update([
                            'quantity' => $request->quantity,
                            'total_price' => OrderItem::calculateTotalPrice($request->quantity, $item->unit_price),
                        ]);
                    }
                    $message = 'Quantity updated for ' . count($request->selected_items) . ' order items!';
                    break;

                case 'recalculate_totals':
                    foreach ($selectedItems as $item) {
                        $item->update([
                            'total_price' => OrderItem::calculateTotalPrice($item->quantity, $item->unit_price),
                        ]);
                    }
                    $message = 'Totals recalculated for ' . count($request->selected_items) . ' order items!';
                    break;
            }

            // Update affected order totals
            foreach ($affectedOrders as $orderId) {
                $this->updateOrderTotal($orderId);
            }

            DB::commit();

            return redirect()->route('admin.orderItems.index')->with('success', $message);
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Bulk action failed: ' . $e->getMessage());
        }
    }

    /**
     * Get order items for a specific order (AJAX endpoint).
     */
    public function getOrderItems(Request $request, Order $order)
    {
        $orderItems = $order->orderItems()->with('product')->get();
        
        return response()->json([
            'order_items' => $orderItems,
            'order_total' => $order->total_amount,
            'items_count' => $orderItems->count(),
            'total_quantity' => $orderItems->sum('quantity'),
        ]);
    }

    /**
     * Calculate item total based on quantity and unit price (AJAX endpoint).
     */
    public function calculateItemTotal(Request $request)
    {
        $request->validate([
            'quantity' => 'required|integer|min:1',
            'unit_price' => 'required|numeric|min:0',
            'discount' => 'nullable|numeric|min:0',
        ]);

        $quantity = $request->quantity;
        $unitPrice = $request->unit_price;
        $discount = $request->discount ?? 0;

        $subtotal = $quantity * $unitPrice;
        $total = $subtotal - $discount;

        return response()->json([
            'subtotal' => number_format($subtotal, 2),
            'discount' => number_format($discount, 2),
            'total' => number_format($total, 2),
            'formatted_subtotal' => '$' . number_format($subtotal, 2),
            'formatted_discount' => '$' . number_format($discount, 2),
            'formatted_total' => '$' . number_format($total, 2),
        ]);
    }

    /**
     * Update order total after order item changes.
     */
    private function updateOrderTotal($orderId)
    {
        $order = Order::find($orderId);
        if ($order) {
            $itemsTotal = $order->orderItems()->sum('total_price');
            $order->update([
                'subtotal' => $itemsTotal,
                'total_amount' => $itemsTotal + $order->tax_amount + $order->shipping_amount - $order->discount_amount,
            ]);
        }
    }
}
