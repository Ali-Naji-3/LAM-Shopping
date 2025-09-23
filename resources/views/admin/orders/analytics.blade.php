@extends('admin.dashboard')

@section('content')
<div class="container-fluid">
    <!-- Page Header -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h2 class="mb-1" style="color: #1a202c !important; font-weight: 700 !important; font-size: 24px !important;">
                📊 Orders Analytics
            </h2>
            <p class="mb-0" style="color: #4a5568 !important; font-size: 14px !important;">
                Comprehensive analytics and insights for your order management
            </p>
        </div>
        <a href="{{ route('admin.orders.index') }}" class="btn btn-outline-secondary" 
           style="color: #4a5568 !important; border-color: #4a5568 !important; background: #ffffff !important; padding: 12px 20px !important; border-radius: 10px !important; font-weight: 600 !important; font-size: 14px !important; border-width: 2px !important; transition: all 0.2s ease !important; text-decoration: none !important;"
           onmouseover="this.style.backgroundColor='#4a5568 !important'; this.style.color='#ffffff !important';"
           onmouseout="this.style.backgroundColor='#ffffff !important'; this.style.color='#4a5568 !important';">
            <i class="bi bi-arrow-left me-2"></i>Back to Orders
        </a>
    </div>

    <!-- Overview Statistics -->
    <div class="row mb-4">
        <div class="col-lg-2 col-md-4 col-sm-6 mb-3">
            <div class="card" style="background: linear-gradient(135deg, #3182ce 0%, #2c5aa0 100%) !important; border: none !important; border-radius: 12px !important; color: #ffffff !important;">
                <div class="card-body text-center" style="padding: 1.5rem !important;">
                    <i class="bi bi-collection mb-2" style="font-size: 2rem !important; opacity: 0.8 !important;"></i>
                    <h6 style="color: rgba(255, 255, 255, 0.8) !important; font-size: 11px !important; text-transform: uppercase !important; font-weight: 600 !important; margin-bottom: 4px !important;">Total Orders</h6>
                    <h4 style="color: #ffffff !important; font-weight: 700 !important; margin: 0 !important;">{{ number_format($analytics['total_orders']) }}</h4>
                </div>
            </div>
        </div>
        <div class="col-lg-2 col-md-4 col-sm-6 mb-3">
            <div class="card" style="background: linear-gradient(135deg, #f59e0b 0%, #d97706 100%) !important; border: none !important; border-radius: 12px !important; color: #ffffff !important;">
                <div class="card-body text-center" style="padding: 1.5rem !important;">
                    <i class="bi bi-clock mb-2" style="font-size: 2rem !important; opacity: 0.8 !important;"></i>
                    <h6 style="color: rgba(255, 255, 255, 0.8) !important; font-size: 11px !important; text-transform: uppercase !important; font-weight: 600 !important; margin-bottom: 4px !important;">Pending</h6>
                    <h4 style="color: #ffffff !important; font-weight: 700 !important; margin: 0 !important;">{{ number_format($analytics['pending_orders']) }}</h4>
                </div>
            </div>
        </div>
        <div class="col-lg-2 col-md-4 col-sm-6 mb-3">
            <div class="card" style="background: linear-gradient(135deg, #10b981 0%, #059669 100%) !important; border: none !important; border-radius: 12px !important; color: #ffffff !important;">
                <div class="card-body text-center" style="padding: 1.5rem !important;">
                    <i class="bi bi-check-circle mb-2" style="font-size: 2rem !important; opacity: 0.8 !important;"></i>
                    <h6 style="color: rgba(255, 255, 255, 0.8) !important; font-size: 11px !important; text-transform: uppercase !important; font-weight: 600 !important; margin-bottom: 4px !important;">Delivered</h6>
                    <h4 style="color: #ffffff !important; font-weight: 700 !important; margin: 0 !important;">{{ number_format($analytics['delivered_orders']) }}</h4>
                </div>
            </div>
        </div>
        <div class="col-lg-2 col-md-4 col-sm-6 mb-3">
            <div class="card" style="background: linear-gradient(135deg, #10b981 0%, #047857 100%) !important; border: none !important; border-radius: 12px !important; color: #ffffff !important;">
                <div class="card-body text-center" style="padding: 1.5rem !important;">
                    <i class="bi bi-currency-dollar mb-2" style="font-size: 2rem !important; opacity: 0.8 !important;"></i>
                    <h6 style="color: rgba(255, 255, 255, 0.8) !important; font-size: 11px !important; text-transform: uppercase !important; font-weight: 600 !important; margin-bottom: 4px !important;">Total Revenue</h6>
                    <h4 style="color: #ffffff !important; font-weight: 700 !important; margin: 0 !important;">${{ number_format($analytics['total_revenue'], 0) }}</h4>
                </div>
            </div>
        </div>
        <div class="col-lg-2 col-md-4 col-sm-6 mb-3">
            <div class="card" style="background: linear-gradient(135deg, #f59e0b 0%, #d97706 100%) !important; border: none !important; border-radius: 12px !important; color: #ffffff !important;">
                <div class="card-body text-center" style="padding: 1.5rem !important;">
                    <i class="bi bi-hourglass mb-2" style="font-size: 2rem !important; opacity: 0.8 !important;"></i>
                    <h6 style="color: rgba(255, 255, 255, 0.8) !important; font-size: 11px !important; text-transform: uppercase !important; font-weight: 600 !important; margin-bottom: 4px !important;">Pending Revenue</h6>
                    <h4 style="color: #ffffff !important; font-weight: 700 !important; margin: 0 !important;">${{ number_format($analytics['pending_revenue'], 0) }}</h4>
                </div>
            </div>
        </div>
        <div class="col-lg-2 col-md-4 col-sm-6 mb-3">
            <div class="card" style="background: linear-gradient(135deg, #8b5cf6 0%, #7c3aed 100%) !important; border: none !important; border-radius: 12px !important; color: #ffffff !important;">
                <div class="card-body text-center" style="padding: 1.5rem !important;">
                    <i class="bi bi-graph-up mb-2" style="font-size: 2rem !important; opacity: 0.8 !important;"></i>
                    <h6 style="color: rgba(255, 255, 255, 0.8) !important; font-size: 11px !important; text-transform: uppercase !important; font-weight: 600 !important; margin-bottom: 4px !important;">Avg Order</h6>
                    <h4 style="color: #ffffff !important; font-weight: 700 !important; margin: 0 !important;">${{ number_format($analytics['average_order_value'], 0) }}</h4>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-lg-8">
            <!-- Order Status Distribution -->
            <div class="card mb-4" style="background: #ffffff !important; border: 1px solid #e2e8f0 !important; border-radius: 12px !important; box-shadow: 0 1px 3px rgba(0, 0, 0, 0.1) !important;">
                <div class="card-header" style="background: linear-gradient(135deg, #f7fafc 0%, #edf2f7 100%) !important; border-bottom: 1px solid #e2e8f0 !important; border-radius: 12px 12px 0 0 !important; padding: 1.5rem 2rem !important;">
                    <h5 class="mb-0" style="color: #1a202c !important; font-weight: 600 !important; font-size: 18px !important;">
                        <i class="bi bi-pie-chart me-2" style="color: #3182ce !important;"></i>Order Status Distribution
                    </h5>
                </div>
                <div class="card-body" style="padding: 2rem !important;">
                    <div class="table-responsive">
                        <table class="table table-borderless">
                            <thead>
                                <tr style="border-bottom: 2px solid #f1f5f9 !important;">
                                    <th style="color: #2d3748 !important; font-weight: 700 !important; font-size: 14px !important; padding: 1rem 0.5rem !important;">Status</th>
                                    <th style="color: #2d3748 !important; font-weight: 700 !important; font-size: 14px !important; padding: 1rem 0.5rem !important;">Count</th>
                                    <th style="color: #2d3748 !important; font-weight: 700 !important; font-size: 14px !important; padding: 1rem 0.5rem !important;">Percentage</th>
                                    <th style="color: #2d3748 !important; font-weight: 700 !important; font-size: 14px !important; padding: 1rem 0.5rem !important;">Description</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($analytics['status_distribution'] as $statusData)
                                    <tr style="border-bottom: 1px solid #f8fafc !important;">
                                        <td style="padding: 1rem 0.5rem !important;">
                                            @php
                                                $statusColors = [
                                                    'pending' => '#f59e0b',
                                                    'confirmed' => '#3182ce',
                                                    'processing' => '#8b5cf6',
                                                    'shipped' => '#06b6d4',
                                                    'delivered' => '#10b981',
                                                    'cancelled' => '#ef4444',
                                                    'refunded' => '#6b7280'
                                                ];
                                            @endphp
                                            <span class="badge" style="background: {{ $statusColors[$statusData['status']] ?? '#6b7280' }} !important; color: #ffffff !important; font-size: 11px !important; padding: 6px 12px !important; border-radius: 20px !important; text-transform: capitalize !important;">
                                                {{ $statusData['status'] }}
                                            </span>
                                        </td>
                                        <td style="color: #1a202c !important; font-weight: 600 !important; font-size: 14px !important; padding: 1rem 0.5rem !important;">{{ number_format($statusData['count']) }}</td>
                                        <td style="color: {{ $statusColors[$statusData['status']] ?? '#6b7280' }} !important; font-weight: 600 !important; font-size: 14px !important; padding: 1rem 0.5rem !important;">{{ $statusData['percentage'] }}%</td>
                                        <td style="color: #4a5568 !important; font-size: 13px !important; padding: 1rem 0.5rem !important;">
                                            @switch($statusData['status'])
                                                @case('pending')
                                                    Awaiting confirmation
                                                    @break
                                                @case('confirmed')
                                                    Order confirmed, ready for processing
                                                    @break
                                                @case('processing')
                                                    Currently being prepared
                                                    @break
                                                @case('shipped')
                                                    On the way to customer
                                                    @break
                                                @case('delivered')
                                                    Successfully completed
                                                    @break
                                                @case('cancelled')
                                                    Order cancelled
                                                    @break
                                                @case('refunded')
                                                    Money returned to customer
                                                    @break
                                                @default
                                                    Unknown status
                                            @endswitch
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

            <!-- Recent Orders -->
            <div class="card" style="background: #ffffff !important; border: 1px solid #e2e8f0 !important; border-radius: 12px !important; box-shadow: 0 1px 3px rgba(0, 0, 0, 0.1) !important;">
                <div class="card-header" style="background: linear-gradient(135deg, #f7fafc 0%, #edf2f7 100%) !important; border-bottom: 1px solid #e2e8f0 !important; border-radius: 12px 12px 0 0 !important; padding: 1.5rem 2rem !important;">
                    <h5 class="mb-0" style="color: #1a202c !important; font-weight: 600 !important; font-size: 18px !important;">
                        <i class="bi bi-clock-history me-2" style="color: #3182ce !important;"></i>Recent Orders
                    </h5>
                </div>
                <div class="card-body" style="padding: 2rem !important;">
                    @if($analytics['recent_orders']->count() > 0)
                        <div class="recent-orders">
                            @foreach($analytics['recent_orders'] as $order)
                                <div class="recent-order-item" style="padding: 1rem !important; background: linear-gradient(135deg, #f8fafc 0%, #f1f5f9 100%) !important; border-radius: 10px !important; margin-bottom: 1rem !important; border: 1px solid #e2e8f0 !important; transition: all 0.2s ease !important;"
                                     onmouseover="this.style.transform='translateY(-1px)'; this.style.boxShadow='0 2px 8px rgba(0, 0, 0, 0.1) !important';"
                                     onmouseout="this.style.transform='translateY(0)'; this.style.boxShadow='none';">
                                    <div class="d-flex justify-content-between align-items-center">
                                        <div class="flex-grow-1">
                                            <h6 style="color: #1a202c !important; font-weight: 600 !important; font-size: 16px !important; margin-bottom: 4px !important;">
                                                {{ $order->order_number }}
                                            </h6>
                                            <div class="d-flex align-items-center gap-2 mb-2">
                                                <span style="color: #10b981 !important; font-weight: 700 !important; font-size: 14px !important;">{{ $order->formatted_total }}</span>
                                                <span class="badge" style="background: {{ $order->status_color }} !important; color: #ffffff !important; font-size: 10px !important; padding: 3px 8px !important; border-radius: 12px !important;">
                                                    {{ $order->status }}
                                                </span>
                                                <span class="badge" style="background: {{ $order->payment_status_color }} !important; color: #ffffff !important; font-size: 10px !important; padding: 3px 8px !important; border-radius: 12px !important;">
                                                    {{ $order->payment_status }}
                                                </span>
                                            </div>
                                            <small style="color: #4a5568 !important; font-size: 12px !important;">
                                                {{ $order->customer_name }} • {{ $order->created_at->diffForHumans() }}
                                            </small>
                                        </div>
                                        <div class="d-flex align-items-center gap-2">
                                            <a href="{{ route('admin.orders.show', $order) }}" class="btn btn-sm btn-outline-primary"
                                               style="color: #3182ce !important; border-color: #3182ce !important; background: #ffffff !important; padding: 4px 8px !important; border-radius: 4px !important; font-size: 11px !important; text-decoration: none !important;"
                                               onmouseover="this.style.backgroundColor='#3182ce !important'; this.style.color='#ffffff !important';"
                                               onmouseout="this.style.backgroundColor='#ffffff !important'; this.style.color='#3182ce !important';">
                                                <i class="bi bi-eye"></i>
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    @else
                        <div class="text-center py-4">
                            <i class="bi bi-cart-x" style="color: #718096 !important; font-size: 3rem !important; margin-bottom: 1rem !important;"></i>
                            <h6 style="color: #4a5568 !important; font-weight: 500 !important;">No orders created yet</h6>
                        </div>
                    @endif
                </div>
            </div>
        </div>

        <div class="col-lg-4">
            <!-- Payment Status Overview -->
            <div class="card mb-4" style="background: #ffffff !important; border: 1px solid #e2e8f0 !important; border-radius: 12px !important; box-shadow: 0 1px 3px rgba(0, 0, 0, 0.1) !important;">
                <div class="card-header" style="background: linear-gradient(135deg, #f7fafc 0%, #edf2f7 100%) !important; border-bottom: 1px solid #e2e8f0 !important; border-radius: 12px 12px 0 0 !important; padding: 1rem 1.5rem !important;">
                    <h5 class="mb-0" style="color: #1a202c !important; font-weight: 600 !important; font-size: 16px !important;">
                        <i class="bi bi-credit-card me-2" style="color: #3182ce !important;"></i>Payment Status
                    </h5>
                </div>
                <div class="card-body" style="padding: 1.5rem !important;">
                    <div class="payment-stats">
                        <div class="payment-item" style="padding: 12px !important; background: linear-gradient(135deg, #ecfdf5 0%, #d1fae5 100%) !important; border-radius: 8px !important; margin-bottom: 12px !important; border-left: 4px solid #10b981 !important;">
                            <div class="d-flex justify-content-between align-items-center">
                                <span style="color: #2d3748 !important; font-weight: 600 !important; font-size: 14px !important;">Paid Orders</span>
                                <span style="color: #10b981 !important; font-weight: 700 !important; font-size: 16px !important;">{{ number_format($analytics['paid_orders']) }}</span>
                            </div>
                        </div>
                        <div class="payment-item" style="padding: 12px !important; background: linear-gradient(135deg, #fef3c7 0%, #fed7aa 100%) !important; border-radius: 8px !important; margin-bottom: 12px !important; border-left: 4px solid #f59e0b !important;">
                            <div class="d-flex justify-content-between align-items-center">
                                <span style="color: #2d3748 !important; font-weight: 600 !important; font-size: 14px !important;">Pending Payments</span>
                                <span style="color: #f59e0b !important; font-weight: 700 !important; font-size: 16px !important;">{{ number_format($analytics['pending_payments']) }}</span>
                            </div>
                        </div>
                        <div class="payment-item" style="padding: 12px !important; background: linear-gradient(135deg, #fef2f2 0%, #fecaca 100%) !important; border-radius: 8px !important; margin-bottom: 12px !important; border-left: 4px solid #ef4444 !important;">
                            <div class="d-flex justify-content-between align-items-center">
                                <span style="color: #2d3748 !important; font-weight: 600 !important; font-size: 14px !important;">Failed Payments</span>
                                <span style="color: #ef4444 !important; font-weight: 700 !important; font-size: 16px !important;">{{ number_format($analytics['failed_payments']) }}</span>
                            </div>
                        </div>
                        <div class="payment-item" style="padding: 12px !important; background: linear-gradient(135deg, #f9fafb 0%, #f3f4f6 100%) !important; border-radius: 8px !important; border-left: 4px solid #6b7280 !important;">
                            <div class="d-flex justify-content-between align-items-center">
                                <span style="color: #2d3748 !important; font-weight: 600 !important; font-size: 14px !important;">Refunded</span>
                                <span style="color: #6b7280 !important; font-weight: 700 !important; font-size: 16px !important;">{{ number_format($analytics['refunded_payments']) }}</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Performance Metrics -->
            <div class="card" style="background: #ffffff !important; border: 1px solid #e2e8f0 !important; border-radius: 12px !important; box-shadow: 0 1px 3px rgba(0, 0, 0, 0.1) !important;">
                <div class="card-header" style="background: linear-gradient(135deg, #f7fafc 0%, #edf2f7 100%) !important; border-bottom: 1px solid #e2e8f0 !important; border-radius: 12px 12px 0 0 !important; padding: 1rem 1.5rem !important;">
                    <h5 class="mb-0" style="color: #1a202c !important; font-weight: 600 !important; font-size: 16px !important;">
                        <i class="bi bi-speedometer2 me-2" style="color: #3182ce !important;"></i>Performance Metrics
                    </h5>
                </div>
                <div class="card-body" style="padding: 1.5rem !important;">
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <div class="performance-metric text-center" style="padding: 1.5rem !important; background: linear-gradient(135deg, #f0f9ff 0%, #e0f2fe 100%) !important; border-radius: 10px !important; border: 1px solid #e0f2fe !important;">
                                <h4 style="color: #3182ce !important; font-weight: 700 !important; font-size: 2rem !important; margin-bottom: 8px !important;">{{ $analytics['completion_rate'] }}%</h4>
                                <h6 style="color: #2d3748 !important; font-weight: 600 !important; font-size: 14px !important; margin-bottom: 4px !important;">Completion Rate</h6>
                                <small style="color: #4a5568 !important; font-size: 12px !important;">Orders delivered successfully</small>
                            </div>
                        </div>
                        <div class="col-md-6 mb-3">
                            <div class="performance-metric text-center" style="padding: 1.5rem !important; background: linear-gradient(135deg, #f0fdf4 0%, #dcfce7 100%) !important; border-radius: 10px !important; border: 1px solid #dcfce7 !important;">
                                <h4 style="color: #10b981 !important; font-weight: 700 !important; font-size: 2rem !important; margin-bottom: 8px !important;">{{ round(($analytics['paid_orders'] / max($analytics['total_orders'], 1)) * 100, 1) }}%</h4>
                                <h6 style="color: #2d3748 !important; font-weight: 600 !important; font-size: 14px !important; margin-bottom: 4px !important;">Payment Success</h6>
                                <small style="color: #4a5568 !important; font-size: 12px !important;">Orders with successful payment</small>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-lg-4">
            <!-- Top Customers -->
            @if($analytics['top_customers'] && $analytics['top_customers']->count() > 0)
                <div class="card mb-4" style="background: #ffffff !important; border: 1px solid #e2e8f0 !important; border-radius: 12px !important; box-shadow: 0 1px 3px rgba(0, 0, 0, 0.1) !important;">
                    <div class="card-header" style="background: linear-gradient(135deg, #f7fafc 0%, #edf2f7 100%) !important; border-bottom: 1px solid #e2e8f0 !important; border-radius: 12px 12px 0 0 !important; padding: 1rem 1.5rem !important;">
                        <h5 class="mb-0" style="color: #1a202c !important; font-weight: 600 !important; font-size: 16px !important;">
                            <i class="bi bi-trophy me-2" style="color: #f59e0b !important;"></i>Top Customers
                        </h5>
                    </div>
                    <div class="card-body" style="padding: 1.5rem !important;">
                        @foreach($analytics['top_customers']->take(5) as $customer)
                            <div class="customer-item" style="padding: 12px !important; background: linear-gradient(135deg, #f8fafc 0%, #f1f5f9 100%) !important; border-radius: 8px !important; margin-bottom: 12px !important; border: 1px solid #e2e8f0 !important; transition: all 0.2s ease !important;"
                                 onmouseover="this.style.transform='translateY(-1px)'; this.style.boxShadow='0 2px 8px rgba(0, 0, 0, 0.1) !important';"
                                 onmouseout="this.style.transform='translateY(0)'; this.style.boxShadow='none';">
                                <div class="d-flex justify-content-between align-items-start">
                                    <div class="flex-grow-1">
                                        <h6 style="color: #1a202c !important; font-weight: 600 !important; font-size: 14px !important; margin-bottom: 4px !important;">
                                            {{ $customer->name }}
                                        </h6>
                                        <small style="color: #4a5568 !important; font-size: 12px !important;">
                                            {{ $customer->orders_count }} orders • ${{ number_format($customer->orders_sum_total_amount ?? 0, 2) }}
                                        </small>
                                    </div>
                                    <div class="customer-rank" style="background: #f59e0b !important; color: #ffffff !important; width: 24px !important; height: 24px !important; border-radius: 50% !important; display: flex !important; align-items: center !important; justify-content: center !important; font-size: 11px !important; font-weight: 700 !important;">
                                        {{ $loop->iteration }}
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            @endif

            <!-- Quick Actions -->
            <div class="card" style="background: #ffffff !important; border: 1px solid #e2e8f0 !important; border-radius: 12px !important; box-shadow: 0 1px 3px rgba(0, 0, 0, 0.1) !important;">
                <div class="card-header" style="background: linear-gradient(135deg, #f7fafc 0%, #edf2f7 100%) !important; border-bottom: 1px solid #e2e8f0 !important; border-radius: 12px 12px 0 0 !important; padding: 1rem 1.5rem !important;">
                    <h5 class="mb-0" style="color: #1a202c !important; font-weight: 600 !important; font-size: 16px !important;">
                        <i class="bi bi-lightning me-2" style="color: #3182ce !important;"></i>Quick Actions
                    </h5>
                </div>
                <div class="card-body" style="padding: 1.5rem !important;">
                    <div class="d-grid gap-2">
                        <a href="{{ route('admin.orders.create') }}" class="btn btn-primary w-100"
                           style="background: linear-gradient(135deg, #3182ce 0%, #2c5aa0 100%) !important; border: none !important; color: #ffffff !important; padding: 12px 16px !important; border-radius: 8px !important; font-weight: 600 !important; transition: all 0.2s ease !important; text-decoration: none !important;"
                           onmouseover="this.style.transform='translateY(-1px)'; this.style.boxShadow='0 4px 8px rgba(49, 130, 206, 0.3) !important';"
                           onmouseout="this.style.transform='translateY(0)'; this.style.boxShadow='none';">
                            <i class="bi bi-plus-circle me-2"></i>Create New Order
                        </a>
                        
                        <a href="{{ route('admin.orders.index') }}" class="btn btn-outline-info w-100"
                           style="color: #0891b2 !important; border-color: #0891b2 !important; background: #ffffff !important; padding: 12px 16px !important; border-radius: 8px !important; font-weight: 600 !important; text-decoration: none !important;"
                           onmouseover="this.style.backgroundColor='#0891b2 !important'; this.style.color='#ffffff !important';"
                           onmouseout="this.style.backgroundColor='#ffffff !important'; this.style.color='#0891b2 !important';">
                            <i class="bi bi-collection me-2"></i>Manage All Orders
                        </a>
                        
                        @if($analytics['pending_orders'] > 0)
                            <div class="alert alert-warning" style="background: linear-gradient(135deg, #fef3c7 0%, #fed7aa 100%) !important; border: 1px solid #f59e0b !important; border-radius: 8px !important; padding: 12px !important; margin-bottom: 0 !important;">
                                <i class="bi bi-exclamation-triangle me-2" style="color: #f59e0b !important;"></i>
                                <small style="color: #92400e !important; font-weight: 600 !important;">{{ $analytics['pending_orders'] }} order{{ $analytics['pending_orders'] > 1 ? 's' : '' }} need attention</small>
                            </div>
                        @else
                            <div class="alert alert-success" style="background: linear-gradient(135deg, #ecfdf5 0%, #d1fae5 100%) !important; border: 1px solid #10b981 !important; border-radius: 8px !important; padding: 12px !important; margin-bottom: 0 !important;">
                                <i class="bi bi-check-circle me-2" style="color: #10b981 !important;"></i>
                                <small style="color: #065f46 !important; font-weight: 600 !important;">All orders are being processed</small>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Monthly Revenue Chart (Placeholder) -->
    <div class="row">
        <div class="col-12">
            <div class="card" style="background: #ffffff !important; border: 1px solid #e2e8f0 !important; border-radius: 12px !important; box-shadow: 0 1px 3px rgba(0, 0, 0, 0.1) !important;">
                <div class="card-header" style="background: linear-gradient(135deg, #f7fafc 0%, #edf2f7 100%) !important; border-bottom: 1px solid #e2e8f0 !important; border-radius: 12px 12px 0 0 !important; padding: 1.5rem 2rem !important;">
                    <h5 class="mb-0" style="color: #1a202c !important; font-weight: 600 !important; font-size: 18px !important;">
                        <i class="bi bi-graph-up me-2" style="color: #3182ce !important;"></i>Monthly Revenue Trend
                    </h5>
                </div>
                <div class="card-body" style="padding: 2rem !important;">
                    <div class="monthly-revenue-display">
                        <div class="row">
                            @foreach($analytics['monthly_revenue'] as $monthData)
                                <div class="col-lg-2 col-md-3 col-sm-4 col-6 mb-3">
                                    <div class="month-revenue text-center" style="padding: 1rem !important; background: linear-gradient(135deg, #f8fafc 0%, #f1f5f9 100%) !important; border-radius: 8px !important; border: 1px solid #e2e8f0 !important; transition: all 0.2s ease !important;"
                                         onmouseover="this.style.transform='translateY(-2px)'; this.style.boxShadow='0 4px 12px rgba(0, 0, 0, 0.1) !important';"
                                         onmouseout="this.style.transform='translateY(0)'; this.style.boxShadow='none';">
                                        <h6 style="color: #10b981 !important; font-weight: 700 !important; font-size: 16px !important; margin-bottom: 4px !important;">
                                            ${{ number_format($monthData['revenue'], 0) }}
                                        </h6>
                                        <small style="color: #1a202c !important; font-weight: 600 !important; font-size: 12px !important; display: block; margin-bottom: 2px !important;">{{ $monthData['month'] }}</small>
                                        <small style="color: #4a5568 !important; font-size: 11px !important;">{{ $monthData['orders_count'] }} orders</small>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@push('styles')
<style>
    /* CLEAN ORDERS ANALYTICS - Professional Styling */
    .performance-metric {
        transition: all 0.2s ease !important;
    }
    
    .performance-metric:hover {
        transform: translateY(-2px) !important;
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1) !important;
    }
    
    .recent-order-item {
        transition: all 0.2s ease !important;
    }
    
    .payment-item {
        transition: all 0.2s ease !important;
    }
    
    .payment-item:hover {
        transform: translateY(-1px) !important;
        box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1) !important;
    }
    
    .customer-item {
        transition: all 0.2s ease !important;
    }
    
    .month-revenue {
        transition: all 0.2s ease !important;
    }
    
    .table td {
        border-bottom: 1px solid #f8fafc !important;
    }
    
    .table tr:last-child td {
        border-bottom: none !important;
    }
    
    .alert {
        transition: all 0.2s ease !important;
    }
    
    .alert:hover {
        transform: translateY(-1px) !important;
        box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1) !important;
    }
    
    .customer-rank {
        transition: all 0.2s ease !important;
    }
    
    .customer-item:hover .customer-rank {
        transform: scale(1.1) !important;
    }
</style>
@endpush
@endsection
