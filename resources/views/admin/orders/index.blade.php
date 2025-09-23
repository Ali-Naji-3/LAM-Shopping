@extends('admin.dashboard')

@section('content')

<script>
// Global search functions for orders
window.handleOrderSearchKeyup = function(input) {
    const searchTerm = input.value.trim();
    const minSearchLength = 2;
    
    // Force clean professional styling
    input.style.background = '#ffffff';
    input.style.color = '#1a202c';
    input.style.border = '2px solid #e2e8f0';
    
    if (searchTerm.length >= minSearchLength) {
        input.style.borderColor = '#3182ce';
        input.style.boxShadow = '0 0 0 4px rgba(49, 130, 206, 0.15)';
        input.style.transform = 'translateY(-1px)';
    } else {
        input.style.borderColor = '#e2e8f0';
        input.style.boxShadow = '0 1px 3px rgba(0, 0, 0, 0.1)';
        input.style.transform = 'translateY(0)';
    }
    
    clearTimeout(window.orderSearchTimeout);
    if (searchTerm.length >= minSearchLength || searchTerm.length === 0) {
        window.orderSearchTimeout = setTimeout(function() {
            if (searchTerm !== '{{ request('search') }}') {
                input.closest('form').submit();
            }
        }, 600);
    }
};

window.handleOrderSearchKeydown = function(event, input) {
    if (event.key === 'Enter') {
        event.preventDefault();
        input.closest('form').submit();
    }
    if (event.key === 'Escape') {
        input.value = '';
        input.style.borderColor = '#e2e8f0';
        input.style.boxShadow = '0 1px 3px rgba(0, 0, 0, 0.1)';
        input.blur();
    }
};

window.handleOrderSearchFocus = function(input) {
    input.style.borderColor = '#3182ce';
    input.style.boxShadow = '0 0 0 2px rgba(49, 130, 206, 0.2)';
};

window.handleOrderSearchBlur = function(input) {
    setTimeout(function() {
        if (input.value.trim().length === 0) {
            input.style.borderColor = '#e2e8f0';
            input.style.boxShadow = '0 1px 3px rgba(0, 0, 0, 0.1)';
        }
    }, 150);
};
</script>

<div class="container-fluid">
    <!-- Page Header -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h2 class="mb-1" style="color: #1a202c !important; font-weight: 700 !important; font-size: 24px !important;">
                📦 Orders Management
            </h2>
            <p class="mb-0" style="color: #4a5568 !important; font-size: 14px !important;">
                Manage customer orders and track fulfillment • {{ $orders->total() }} total orders
            </p>
        </div>
        <div class="d-flex gap-2">
            <a href="{{ route('admin.orders.create') }}" class="btn btn-primary"
               style="background: linear-gradient(135deg, #3182ce 0%, #2c5aa0 100%) !important; border: none !important; color: #ffffff !important; padding: 12px 20px !important; border-radius: 10px !important; font-weight: 600 !important; transition: all 0.2s ease !important;"
               onmouseover="this.style.transform='translateY(-1px)'; this.style.boxShadow='0 4px 8px rgba(49, 130, 206, 0.3) !important';"
               onmouseout="this.style.transform='translateY(0)'; this.style.boxShadow='none';">
                <i class="bi bi-plus-circle me-2"></i>Create Order
            </a>
            <a href="{{ route('admin.orders.analytics') }}" class="btn btn-outline-info" 
               style="color: #0891b2 !important; border-color: #0891b2 !important; background: #ffffff !important; padding: 12px 20px !important; border-radius: 10px !important; font-weight: 600 !important; font-size: 14px !important; border-width: 2px !important; transition: all 0.2s ease !important; text-decoration: none !important;"
               onmouseover="this.style.backgroundColor='#0891b2 !important'; this.style.color='#ffffff !important';"
               onmouseout="this.style.backgroundColor='#ffffff !important'; this.style.color='#0891b2 !important';">
                <i class="bi bi-bar-chart me-2"></i>Analytics
            </a>
        </div>
    </div>

    <!-- Statistics Cards -->
    <div class="row mb-4">
        <div class="col-lg-2 col-md-4 col-sm-6 mb-3">
            <div class="card" style="background: linear-gradient(135deg, #3182ce 0%, #2c5aa0 100%) !important; border: none !important; border-radius: 12px !important; color: #ffffff !important;">
                <div class="card-body text-center" style="padding: 1.5rem !important;">
                    <i class="bi bi-collection mb-2" style="font-size: 2rem !important; opacity: 0.8 !important;"></i>
                    <h6 style="color: rgba(255, 255, 255, 0.8) !important; font-size: 11px !important; text-transform: uppercase !important; font-weight: 600 !important; margin-bottom: 4px !important;">Total Orders</h6>
                    <h4 style="color: #ffffff !important; font-weight: 700 !important; margin: 0 !important;">{{ number_format($statistics['total_orders']) }}</h4>
                </div>
            </div>
        </div>
        <div class="col-lg-2 col-md-4 col-sm-6 mb-3">
            <div class="card" style="background: linear-gradient(135deg, #f59e0b 0%, #d97706 100%) !important; border: none !important; border-radius: 12px !important; color: #ffffff !important;">
                <div class="card-body text-center" style="padding: 1.5rem !important;">
                    <i class="bi bi-clock mb-2" style="font-size: 2rem !important; opacity: 0.8 !important;"></i>
                    <h6 style="color: rgba(255, 255, 255, 0.8) !important; font-size: 11px !important; text-transform: uppercase !important; font-weight: 600 !important; margin-bottom: 4px !important;">Pending</h6>
                    <h4 style="color: #ffffff !important; font-weight: 700 !important; margin: 0 !important;">{{ number_format($statistics['pending_orders']) }}</h4>
                </div>
            </div>
        </div>
        <div class="col-lg-2 col-md-4 col-sm-6 mb-3">
            <div class="card" style="background: linear-gradient(135deg, #10b981 0%, #059669 100%) !important; border: none !important; border-radius: 12px !important; color: #ffffff !important;">
                <div class="card-body text-center" style="padding: 1.5rem !important;">
                    <i class="bi bi-check-circle mb-2" style="font-size: 2rem !important; opacity: 0.8 !important;"></i>
                    <h6 style="color: rgba(255, 255, 255, 0.8) !important; font-size: 11px !important; text-transform: uppercase !important; font-weight: 600 !important; margin-bottom: 4px !important;">Completed</h6>
                    <h4 style="color: #ffffff !important; font-weight: 700 !important; margin: 0 !important;">{{ number_format($statistics['completed_orders']) }}</h4>
                </div>
            </div>
        </div>
        <div class="col-lg-2 col-md-4 col-sm-6 mb-3">
            <div class="card" style="background: linear-gradient(135deg, #ef4444 0%, #dc2626 100%) !important; border: none !important; border-radius: 12px !important; color: #ffffff !important;">
                <div class="card-body text-center" style="padding: 1.5rem !important;">
                    <i class="bi bi-x-circle mb-2" style="font-size: 2rem !important; opacity: 0.8 !important;"></i>
                    <h6 style="color: rgba(255, 255, 255, 0.8) !important; font-size: 11px !important; text-transform: uppercase !important; font-weight: 600 !important; margin-bottom: 4px !important;">Cancelled</h6>
                    <h4 style="color: #ffffff !important; font-weight: 700 !important; margin: 0 !important;">{{ number_format($statistics['cancelled_orders']) }}</h4>
                </div>
            </div>
        </div>
        <div class="col-lg-2 col-md-4 col-sm-6 mb-3">
            <div class="card" style="background: linear-gradient(135deg, #10b981 0%, #047857 100%) !important; border: none !important; border-radius: 12px !important; color: #ffffff !important;">
                <div class="card-body text-center" style="padding: 1.5rem !important;">
                    <i class="bi bi-currency-dollar mb-2" style="font-size: 2rem !important; opacity: 0.8 !important;"></i>
                    <h6 style="color: rgba(255, 255, 255, 0.8) !important; font-size: 11px !important; text-transform: uppercase !important; font-weight: 600 !important; margin-bottom: 4px !important;">Total Revenue</h6>
                    <h4 style="color: #ffffff !important; font-weight: 700 !important; margin: 0 !important;">${{ number_format($statistics['total_revenue'], 0) }}</h4>
                </div>
            </div>
        </div>
        <div class="col-lg-2 col-md-4 col-sm-6 mb-3">
            <div class="card" style="background: linear-gradient(135deg, #8b5cf6 0%, #7c3aed 100%) !important; border: none !important; border-radius: 12px !important; color: #ffffff !important;">
                <div class="card-body text-center" style="padding: 1.5rem !important;">
                    <i class="bi bi-graph-up mb-2" style="font-size: 2rem !important; opacity: 0.8 !important;"></i>
                    <h6 style="color: rgba(255, 255, 255, 0.8) !important; font-size: 11px !important; text-transform: uppercase !important; font-weight: 600 !important; margin-bottom: 4px !important;">Avg Order</h6>
                    <h4 style="color: #ffffff !important; font-weight: 700 !important; margin: 0 !important;">${{ number_format($statistics['average_order_value'], 0) }}</h4>
                </div>
            </div>
        </div>
    </div>

    <!-- Search and Filter Card -->
    <div class="card mb-4" style="background: #ffffff !important; border: 1px solid #e2e8f0 !important; border-radius: 12px !important; box-shadow: 0 1px 3px rgba(0, 0, 0, 0.1) !important;">
        <div class="card-body" style="padding: 1.5rem 2rem !important;">
            <form method="GET" action="{{ route('admin.orders.index') }}">
                <div class="row align-items-end">
                    <div class="col-md-3">
                        <label class="form-label" style="color: #2d3748 !important; font-weight: 600 !important; font-size: 14px !important; margin-bottom: 10px !important;">Search Orders</label>
                        <div class="search-input-container" style="position: relative;">
                            <input type="text" 
                                   name="search" 
                                   id="search-orders"
                                   class="form-control" 
                                   placeholder="🔍 Search orders, customers..." 
                                   value="{{ request('search') }}"
                                   style="background: #ffffff !important; border: 2px solid #e2e8f0 !important; color: #1a202c !important; padding: 14px 18px 14px 45px !important; border-radius: 10px !important; font-size: 15px !important; font-weight: 500 !important; box-shadow: 0 1px 3px rgba(0, 0, 0, 0.1) !important; transition: all 0.2s ease !important;"
                                   onkeyup="handleOrderSearchKeyup(this)"
                                   onkeydown="handleOrderSearchKeydown(event, this)"
                                   onfocus="handleOrderSearchFocus(this)"
                                   onblur="handleOrderSearchBlur(this)"
                                   autocomplete="off">
                            <i class="bi bi-search search-icon" 
                               style="position: absolute; left: 15px; top: 50%; transform: translateY(-50%); color: #718096 !important; opacity: 0.8; pointer-events: none; z-index: 10; font-size: 16px;"></i>
                        </div>
                    </div>
                    <div class="col-md-2">
                        <label class="form-label" style="color: #2d3748 !important; font-weight: 600 !important; font-size: 14px !important; margin-bottom: 10px !important;">Order Status</label>
                        <select name="status" class="form-control" style="background: #ffffff !important; border: 2px solid #e2e8f0 !important; color: #1a202c !important; padding: 14px 18px !important; border-radius: 10px !important; font-size: 15px !important; font-weight: 500 !important;">
                            <option value="">All Status</option>
                            <option value="pending" {{ request('status') == 'pending' ? 'selected' : '' }}>Pending</option>
                            <option value="confirmed" {{ request('status') == 'confirmed' ? 'selected' : '' }}>Confirmed</option>
                            <option value="processing" {{ request('status') == 'processing' ? 'selected' : '' }}>Processing</option>
                            <option value="shipped" {{ request('status') == 'shipped' ? 'selected' : '' }}>Shipped</option>
                            <option value="delivered" {{ request('status') == 'delivered' ? 'selected' : '' }}>Delivered</option>
                            <option value="cancelled" {{ request('status') == 'cancelled' ? 'selected' : '' }}>Cancelled</option>
                            <option value="refunded" {{ request('status') == 'refunded' ? 'selected' : '' }}>Refunded</option>
                        </select>
                    </div>
                    <div class="col-md-2">
                        <label class="form-label" style="color: #2d3748 !important; font-weight: 600 !important; font-size: 14px !important; margin-bottom: 10px !important;">Payment</label>
                        <select name="payment_status" class="form-control" style="background: #ffffff !important; border: 2px solid #e2e8f0 !important; color: #1a202c !important; padding: 14px 18px !important; border-radius: 10px !important; font-size: 15px !important; font-weight: 500 !important;">
                            <option value="">All Payments</option>
                            <option value="pending" {{ request('payment_status') == 'pending' ? 'selected' : '' }}>Pending</option>
                            <option value="paid" {{ request('payment_status') == 'paid' ? 'selected' : '' }}>Paid</option>
                            <option value="failed" {{ request('payment_status') == 'failed' ? 'selected' : '' }}>Failed</option>
                            <option value="refunded" {{ request('payment_status') == 'refunded' ? 'selected' : '' }}>Refunded</option>
                        </select>
                    </div>
                    <div class="col-md-2">
                        <label class="form-label" style="color: #2d3748 !important; font-weight: 600 !important; font-size: 14px !important; margin-bottom: 10px !important;">Date From</label>
                        <input type="date" name="date_from" class="form-control" value="{{ request('date_from') }}" style="background: #ffffff !important; border: 2px solid #e2e8f0 !important; color: #1a202c !important; padding: 14px 18px !important; border-radius: 10px !important; font-size: 15px !important; font-weight: 500 !important;">
                    </div>
                    <div class="col-md-2">
                        <label class="form-label" style="color: #2d3748 !important; font-weight: 600 !important; font-size: 14px !important; margin-bottom: 10px !important;">Date To</label>
                        <input type="date" name="date_to" class="form-control" value="{{ request('date_to') }}" style="background: #ffffff !important; border: 2px solid #e2e8f0 !important; color: #1a202c !important; padding: 14px 18px !important; border-radius: 10px !important; font-size: 15px !important; font-weight: 500 !important;">
                    </div>
                    <div class="col-md-1">
                        <button type="submit" class="btn btn-outline-primary w-100" 
                                style="color: #3182ce !important; border-color: #3182ce !important; background: #ffffff !important; padding: 14px 8px !important; border-radius: 10px !important; font-weight: 600 !important; font-size: 14px !important; border-width: 2px !important; transition: all 0.2s ease !important;"
                                onmouseover="this.style.backgroundColor='#3182ce !important'; this.style.color='#ffffff !important';"
                                onmouseout="this.style.backgroundColor='#ffffff !important'; this.style.color='#3182ce !important';">
                            <i class="bi bi-search"></i>
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>

    @if($orders->count() > 0)
        <!-- Bulk Actions Card -->
        <div class="card mb-4" style="background: #ffffff !important; border: 1px solid #e2e8f0 !important; border-radius: 12px !important; box-shadow: 0 1px 3px rgba(0, 0, 0, 0.1) !important;">
            <div class="card-body" style="padding: 1rem 2rem !important;">
                <form id="bulk-actions-form" method="POST" action="{{ route('admin.orders.bulk') }}">
                    @csrf
                    <div class="row align-items-end">
                        <div class="col-md-2">
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" id="select-all">
                                <label class="form-check-label" for="select-all" style="color: #2d3748 !important; font-weight: 500 !important; font-size: 14px !important;">
                                    Select All
                                </label>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <select name="action" class="form-control" style="background: #ffffff !important; border: 2px solid #e2e8f0 !important; color: #1a202c !important; padding: 12px 16px !important; border-radius: 8px !important; font-size: 14px !important; font-weight: 500 !important;">
                                <option value="">Bulk Actions</option>
                                <option value="update_status">Update Order Status</option>
                                <option value="update_payment_status">Update Payment Status</option>
                                <option value="delete">Delete Selected</option>
                            </select>
                        </div>
                        <div class="col-md-2">
                            <select name="bulk_status" class="form-control" style="background: #ffffff !important; border: 2px solid #e2e8f0 !important; color: #1a202c !important; padding: 12px 16px !important; border-radius: 8px !important; font-size: 14px !important; font-weight: 500 !important;">
                                <option value="">Order Status</option>
                                <option value="pending">Pending</option>
                                <option value="confirmed">Confirmed</option>
                                <option value="processing">Processing</option>
                                <option value="shipped">Shipped</option>
                                <option value="delivered">Delivered</option>
                                <option value="cancelled">Cancelled</option>
                            </select>
                        </div>
                        <div class="col-md-2">
                            <select name="bulk_payment_status" class="form-control" style="background: #ffffff !important; border: 2px solid #e2e8f0 !important; color: #1a202c !important; padding: 12px 16px !important; border-radius: 8px !important; font-size: 14px !important; font-weight: 500 !important;">
                                <option value="">Payment Status</option>
                                <option value="pending">Pending</option>
                                <option value="paid">Paid</option>
                                <option value="failed">Failed</option>
                                <option value="refunded">Refunded</option>
                            </select>
                        </div>
                        <div class="col-md-3">
                            <button type="submit" class="btn btn-outline-warning w-100" 
                                    style="color: #d69e2e !important; border-color: #d69e2e !important; background: #ffffff !important; padding: 12px 20px !important; border-radius: 8px !important; font-weight: 600 !important; font-size: 14px !important; border-width: 2px !important; transition: all 0.2s ease !important;"
                                    onclick="return confirm('Are you sure you want to perform this bulk action?')">
                                <i class="bi bi-lightning me-1"></i> Apply Action
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>

        <!-- Orders Display -->
        <div class="row">
            @foreach($orders as $order)
                <div class="col-lg-6 col-md-12 mb-4">
                    <div class="order-card" 
                         style="background: #ffffff !important; border: 1px solid #e2e8f0 !important; border-radius: 12px !important; padding: 1.5rem !important; transition: all 0.2s ease !important; height: 100% !important;"
                         onmouseover="this.style.transform='translateY(-2px)'; this.style.boxShadow='0 4px 12px rgba(0, 0, 0, 0.1) !important'; this.style.borderColor='#3182ce !important';"
                         onmouseout="this.style.transform='translateY(0)'; this.style.boxShadow='none'; this.style.borderColor='#e2e8f0 !important';">
                        
                        <div class="d-flex justify-content-between align-items-start mb-3">
                            <!-- Order Number and Total -->
                            <div class="flex-grow-1">
                                <h6 style="color: #1a202c !important; font-weight: 600 !important; font-size: 16px !important; margin-bottom: 4px !important;">
                                    {{ $order->order_number }}
                                </h6>
                                <div style="color: #10b981 !important; font-weight: 700 !important; font-size: 18px !important; margin-bottom: 4px !important;">
                                    {{ $order->formatted_total }}
                                </div>
                                <small style="color: #4a5568 !important; font-size: 12px !important;">
                                    {{ $order->items_count }} items • {{ $order->total_quantity }} qty
                                </small>
                            </div>
                            <!-- Checkbox for bulk actions -->
                            <div class="form-check">
                                <input class="form-check-input order-checkbox" type="checkbox" value="{{ $order->id }}" name="selected_orders[]">
                            </div>
                        </div>
                        
                        <!-- Status Badges -->
                        <div class="mb-3 d-flex gap-2">
                            <span class="badge" style="background: {{ $order->status_color }} !important; color: #ffffff !important; font-size: 11px !important; padding: 6px 12px !important; border-radius: 20px !important; text-transform: uppercase !important;">
                                {{ $order->status }}
                            </span>
                            <span class="badge" style="background: {{ $order->payment_status_color }} !important; color: #ffffff !important; font-size: 11px !important; padding: 6px 12px !important; border-radius: 20px !important; text-transform: uppercase !important;">
                                {{ $order->payment_status }}
                            </span>
                        </div>
                        
                        <!-- Customer Info -->
                        <div class="mb-3" style="padding: 12px !important; background: linear-gradient(135deg, #f8fafc 0%, #f1f5f9 100%) !important; border-radius: 8px !important;">
                            <div class="row">
                                <div class="col-6">
                                    <small style="color: #718096 !important; font-size: 11px !important; text-transform: uppercase !important; font-weight: 600 !important;">Customer</small>
                                    <div style="color: #1a202c !important; font-weight: 500 !important; font-size: 13px !important;">{{ $order->customer_name }}</div>
                                </div>
                                <div class="col-6">
                                    <small style="color: #718096 !important; font-size: 11px !important; text-transform: uppercase !important; font-weight: 600 !important;">Phone</small>
                                    <div style="color: #1a202c !important; font-weight: 500 !important; font-size: 13px !important;">{{ $order->customer_phone }}</div>
                                </div>
                            </div>
                            @if($order->locality)
                                <div class="row mt-2">
                                    <div class="col-12">
                                        <small style="color: #718096 !important; font-size: 11px !important; text-transform: uppercase !important; font-weight: 600 !important;">Location</small>
                                        <div style="color: #1a202c !important; font-weight: 500 !important; font-size: 13px !important;">{{ $order->locality }}</div>
                                    </div>
                                </div>
                            @endif
                        </div>
                        
                        <!-- Order Meta -->
                        <div class="mb-3" style="padding: 8px 12px !important; background: linear-gradient(135deg, #fef3c7 0%, #fed7aa 100%) !important; border-radius: 6px !important;">
                            <div class="d-flex justify-content-between align-items-center">
                                <small style="color: #92400e !important; font-weight: 600 !important; font-size: 11px !important;">
                                    ID: {{ $order->id }} • {{ $order->payment_method ?? 'No payment method' }}
                                </small>
                                <small style="color: #92400e !important; font-weight: 600 !important; font-size: 11px !important;">
                                    {{ $order->created_at->format('M d, Y') }}
                                </small>
                            </div>
                        </div>
                        
                        <!-- Actions -->
                        <div class="d-flex gap-1">
                            <a href="{{ route('admin.orders.show', $order) }}" class="btn btn-sm btn-outline-info flex-fill"
                               style="color: #0891b2 !important; border-color: #0891b2 !important; background: #ffffff !important; padding: 8px 12px !important; border-radius: 6px !important; font-size: 12px !important; transition: all 0.2s ease !important; text-decoration: none !important;"
                               onmouseover="this.style.backgroundColor='#0891b2 !important'; this.style.color='#ffffff !important';"
                               onmouseout="this.style.backgroundColor='#ffffff !important'; this.style.color='#0891b2 !important';">
                                <i class="bi bi-eye"></i>
                            </a>
                            <a href="{{ route('admin.orders.edit', $order) }}" class="btn btn-sm btn-outline-primary flex-fill"
                               style="color: #3182ce !important; border-color: #3182ce !important; background: #ffffff !important; padding: 8px 12px !important; border-radius: 6px !important; font-size: 12px !important; transition: all 0.2s ease !important; text-decoration: none !important;"
                               onmouseover="this.style.backgroundColor='#3182ce !important'; this.style.color='#ffffff !important';"
                               onmouseout="this.style.backgroundColor='#ffffff !important'; this.style.color='#3182ce !important';">
                                <i class="bi bi-pencil"></i>
                            </a>
                            @if($order->status === 'pending')
                                <form method="POST" action="{{ route('admin.orders.updateStatus', $order) }}" class="d-inline flex-fill">
                                    @csrf
                                    @method('PATCH')
                                    <input type="hidden" name="status" value="confirmed">
                                    <button type="submit" class="btn btn-sm btn-outline-success w-100"
                                            style="color: #10b981 !important; border-color: #10b981 !important; background: #ffffff !important; padding: 8px 12px !important; border-radius: 6px !important; font-size: 12px !important; transition: all 0.2s ease !important;"
                                            onmouseover="this.style.backgroundColor='#10b981 !important'; this.style.color='#ffffff !important';"
                                            onmouseout="this.style.backgroundColor='#ffffff !important'; this.style.color='#10b981 !important';">
                                        <i class="bi bi-check"></i>
                                    </button>
                                </form>
                            @endif
                            <form method="POST" action="{{ route('admin.orders.destroy', $order) }}" class="d-inline flex-fill" 
                                  onsubmit="return confirm('Are you sure you want to delete this order?')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-sm btn-outline-danger w-100"
                                        style="color: #e53e3e !important; border-color: #e53e3e !important; background: #ffffff !important; padding: 8px 12px !important; border-radius: 6px !important; font-size: 12px !important; transition: all 0.2s ease !important;"
                                        onmouseover="this.style.backgroundColor='#e53e3e !important'; this.style.color='#ffffff !important';"
                                        onmouseout="this.style.backgroundColor='#ffffff !important'; this.style.color='#e53e3e !important';">
                                    <i class="bi bi-trash"></i>
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>

        <!-- Professional Pagination -->
        <div class="pagination-container mt-4" style="background: white; padding: 12px 20px; border-radius: 8px; border: 1px solid #dee2e6; display: flex; justify-content: space-between; align-items: center;">
            <div class="pagination-info" style="color: #6c757d; font-weight: 400; font-size: 14px; white-space: nowrap;">
                Showing {{ $orders->firstItem() ?? 0 }} to {{ $orders->lastItem() ?? 0 }} of {{ $orders->total() }} entries
            </div>
            <div class="pagination-links">
                {{ $orders->appends(request()->query())->links('vendor.pagination.custom') }}
            </div>
        </div>

    @else
        <!-- Empty State -->
        <div class="card" style="background: #ffffff !important; border: 1px solid #e2e8f0 !important; border-radius: 12px !important; box-shadow: 0 1px 3px rgba(0, 0, 0, 0.1) !important;">
            <div class="card-body" style="padding: 3rem !important;">
                <div class="text-center">
                    <i class="bi bi-cart-x" style="color: #718096 !important; font-size: 4rem !important; margin-bottom: 1.5rem !important;"></i>
                    <h4 style="color: #1a202c !important; font-weight: 600 !important; margin-bottom: 1rem !important;">No Orders Found</h4>
                    <p style="color: #4a5568 !important; font-size: 16px !important; line-height: 1.6 !important; max-width: 500px !important; margin: 0 auto 2rem auto !important;">
                        @if(request()->hasAny(['search', 'status', 'payment_status', 'date_from', 'date_to']))
                            No orders match your current search criteria. Try adjusting your filters.
                        @else
                            No customer orders have been placed yet. Orders will appear here once customers start making purchases.
                        @endif
                    </p>
                    <div class="d-flex gap-2 justify-content-center">
                        <a href="{{ route('admin.orders.create') }}" class="btn btn-primary"
                           style="background: linear-gradient(135deg, #3182ce 0%, #2c5aa0 100%) !important; border: none !important; color: #ffffff !important; padding: 12px 24px !important; border-radius: 10px !important; font-weight: 600 !important;">
                            <i class="bi bi-plus-circle me-2"></i>Create First Order
                        </a>
                        @if(request()->hasAny(['search', 'status', 'payment_status', 'date_from', 'date_to']))
                            <a href="{{ route('admin.orders.index') }}" class="btn btn-outline-secondary"
                               style="color: #4a5568 !important; border-color: #4a5568 !important; background: #ffffff !important; padding: 12px 24px !important; border-radius: 10px !important; font-weight: 600 !important; text-decoration: none !important;"
                               onmouseover="this.style.backgroundColor='#4a5568 !important'; this.style.color='#ffffff !important';"
                               onmouseout="this.style.backgroundColor='#ffffff !important'; this.style.color='#4a5568 !important';">
                                <i class="bi bi-arrow-left me-2"></i>Clear Filters
                            </a>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    @endif
</div>

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Bulk selection functionality
    const selectAllCheckbox = document.getElementById('select-all');
    const orderCheckboxes = document.querySelectorAll('.order-checkbox');
    
    if (selectAllCheckbox) {
        selectAllCheckbox.addEventListener('change', function() {
            orderCheckboxes.forEach(checkbox => {
                checkbox.checked = this.checked;
            });
            updateBulkActionsState();
        });
    }
    
    orderCheckboxes.forEach(checkbox => {
        checkbox.addEventListener('change', function() {
            updateSelectAllState();
            updateBulkActionsState();
        });
    });
    
    function updateSelectAllState() {
        if (selectAllCheckbox) {
            const checkedCount = document.querySelectorAll('.order-checkbox:checked').length;
            selectAllCheckbox.checked = checkedCount === orderCheckboxes.length;
            selectAllCheckbox.indeterminate = checkedCount > 0 && checkedCount < orderCheckboxes.length;
        }
    }
    
    function updateBulkActionsState() {
        const selectedCount = document.querySelectorAll('.order-checkbox:checked').length;
        const bulkForm = document.getElementById('bulk-actions-form');
        
        if (bulkForm) {
            const actionSelect = bulkForm.querySelector('select[name="action"]');
            const statusSelect = bulkForm.querySelector('select[name="bulk_status"]');
            const paymentSelect = bulkForm.querySelector('select[name="bulk_payment_status"]');
            
            if (selectedCount > 0) {
                actionSelect.style.borderColor = '#3182ce';
                actionSelect.style.background = '#f0f9ff';
                if (statusSelect) {
                    statusSelect.style.borderColor = '#3182ce';
                    statusSelect.style.background = '#f0f9ff';
                }
                if (paymentSelect) {
                    paymentSelect.style.borderColor = '#3182ce';
                    paymentSelect.style.background = '#f0f9ff';
                }
            } else {
                actionSelect.style.borderColor = '#e2e8f0';
                actionSelect.style.background = '#ffffff';
                if (statusSelect) {
                    statusSelect.style.borderColor = '#e2e8f0';
                    statusSelect.style.background = '#ffffff';
                }
                if (paymentSelect) {
                    paymentSelect.style.borderColor = '#e2e8f0';
                    paymentSelect.style.background = '#ffffff';
                }
            }
        }
    }
});
</script>
@endpush

@push('styles')
<style>
    /* CLEAN ORDERS INDEX - Professional Styling */
    .order-card {
        transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1) !important;
    }
    
    /* Clean Search Input Styling */
    #search-orders::placeholder {
        color: #718096 !important;
        opacity: 1 !important;
        font-weight: 400 !important;
    }
    
    .form-control:hover {
        border-color: #cbd5e0 !important;
        box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1) !important;
    }
    
    .form-control:focus {
        background: #ffffff !important;
        border: 2px solid #3182ce !important;
        color: #1a202c !important;
        box-shadow: 0 0 0 4px rgba(49, 130, 206, 0.15), 0 2px 8px rgba(49, 130, 206, 0.1) !important;
        outline: none !important;
        transform: translateY(-1px) !important;
    }
    
    .form-check-input:checked {
        background-color: #3182ce !important;
        border-color: #3182ce !important;
        box-shadow: 0 0 0 2px rgba(49, 130, 206, 0.2) !important;
    }
    
    /* Responsive Design */
    @media (max-width: 768px) {
        .order-card {
            margin-bottom: 1rem !important;
        }
        
        .d-flex.gap-1 {
            flex-direction: column !important;
            gap: 0.5rem !important;
        }
        
        .d-flex.gap-1 .btn {
            width: 100% !important;
        }
    }
</style>
@endpush
@endsection
