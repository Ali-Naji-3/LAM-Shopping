@extends('admin.dashboard')

@section('content')
<div class="container-fluid">
    <!-- Page Header -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h2 class="mb-1" style="color: #1a202c !important; font-weight: 700 !important; font-size: 24px !important;">
                <i class="bi bi-box-seam" style="color: #667eea;"></i> Order Item Analysis
            </h2>
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb mb-0" style="background: none; padding: 0;">
                    <li class="breadcrumb-item"><a href="{{ route('admin.orders.show', $orderItem->order) }}" style="color: #3b82f6; text-decoration: none;">Order #{{ $orderItem->order->order_number }}</a></li>
                    <li class="breadcrumb-item active" style="color: #6b7280;">Item Details</li>
                </ol>
            </nav>
        </div>
        <div class="d-flex gap-2">
            <a href="{{ route('admin.orders.show', $orderItem->order) }}" class="btn btn-outline-primary">
                <i class="bi bi-receipt me-2"></i>View Order
            </a>
            <a href="{{ route('admin.products.show', $orderItem->product) }}" class="btn btn-outline-success">
                <i class="bi bi-box me-2"></i>View Product
            </a>
            <a href="{{ route('admin.orderItems.index') }}" class="btn btn-outline-secondary">
                <i class="bi bi-arrow-left me-2"></i>Back
            </a>
        </div>
    </div>

    <div class="row">
        <!-- Left Column -->
        <div class="col-lg-8">
            <!-- Product Information Card -->
            <div class="card mb-4" style="border: none; border-radius: 16px; box-shadow: 0 4px 6px rgba(0,0,0,0.07);">
                <div class="card-body" style="padding: 2rem;">
                    <div class="row align-items-center">
                        <!-- Product Image -->
                        <div class="col-md-3 text-center">
                            @if($orderItem->product && $orderItem->product->image)
                                <img src="{{ asset('storage/' . $orderItem->product->image) }}" 
                                     alt="{{ $orderItem->product->name }}" 
                                     style="width: 100%; max-width: 200px; height: auto; border-radius: 12px; border: 3px solid #e2e8f0; box-shadow: 0 2px 8px rgba(0,0,0,0.1);">
                            @else
                                <div style="width: 200px; height: 200px; background: linear-gradient(135deg, #e2e8f0 0%, #cbd5e0 100%); border-radius: 12px; display: flex; align-items: center; justify-content: center; margin: 0 auto;">
                                    <i class="bi bi-image" style="font-size: 4rem; color: #9ca3af;"></i>
                                </div>
                            @endif
                        </div>
                        
                        <!-- Product Details -->
                        <div class="col-md-9">
                            <h3 style="color: #1a202c; font-weight: 700; font-size: 24px; margin-bottom: 1rem;">
                                {{ $orderItem->product->name }}
                            </h3>
                            
                            <div class="d-flex flex-wrap gap-2 mb-3">
                                <span class="badge" style="background: #e0f2fe; color: #0369a1; font-size: 13px; padding: 8px 16px; border-radius: 20px; font-weight: 600;">
                                    SKU: {{ $orderItem->product->sku }}
                                </span>
                                        @if($orderItem->product->category)
                                    <span class="badge" style="background: #f3e8ff; color: #7c3aed; font-size: 13px; padding: 8px 16px; border-radius: 20px; font-weight: 600;">
                                        {{ $orderItem->product->category->name }}
                                    </span>
                                        @endif
                                        @if($orderItem->product->brand)
                                    <span class="badge" style="background: #fef3c7; color: #d97706; font-size: 13px; padding: 8px 16px; border-radius: 20px; font-weight: 600;">
                                        {{ $orderItem->product->brand->name }}
                                    </span>
                                @endif
                            </div>
                            
                            @if($orderItem->product->description)
                                <p style="color: #4a5568; font-size: 14px; line-height: 1.6; margin-bottom: 1.5rem;">
                                    {{ Str::limit($orderItem->product->description, 200) }}
                                </p>
                                        @endif
                            
                            <div class="row g-3">
                                <div class="col-6">
                                    <div style="padding: 1rem; background: linear-gradient(135deg, #f0fdf4 0%, #dcfce7 100%); border-radius: 10px; border-left: 4px solid #10b981;">
                                        <div style="color: #6b7280; font-size: 12px; font-weight: 600; text-transform: uppercase; margin-bottom: 4px;">In Stock</div>
                                        <div style="color: #1a202c; font-size: 20px; font-weight: 700;">{{ $orderItem->product->stock_quantity ?? 'N/A' }}</div>
                                    </div>
                                </div>
                                <div class="col-6">
                                    <div style="padding: 1rem; background: linear-gradient(135deg, #fef3c7 0%, #fed7aa 100%); border-radius: 10px; border-left: 4px solid #f59e0b;">
                                        <div style="color: #6b7280; font-size: 12px; font-weight: 600; text-transform: uppercase; margin-bottom: 4px;">Regular Price</div>
                                        <div style="color: #1a202c; font-size: 20px; font-weight: 700;">${{ number_format($orderItem->product->regular_price, 2) }}</div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Sales Information -->
            <div class="card mb-4" style="border: none; border-radius: 16px; box-shadow: 0 4px 6px rgba(0,0,0,0.07);">
                <div class="card-header" style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); border: none; border-radius: 16px 16px 0 0; padding: 1.5rem 2rem;">
                    <h5 class="mb-0" style="color: #ffffff; font-weight: 700; font-size: 18px;">
                        <i class="bi bi-cash-stack me-2"></i>Sales Information
                    </h5>
                </div>
                <div class="card-body" style="padding: 2rem;">
                    <div class="row g-4">
                        <div class="col-md-4">
                            <div class="text-center" style="padding: 1.5rem; background: #f8fafc; border-radius: 12px;">
                                <div style="color: #6b7280; font-size: 13px; font-weight: 600; text-transform: uppercase; margin-bottom: 8px;">Quantity Sold</div>
                                <div style="color: #10b981; font-size: 32px; font-weight: 700; margin-bottom: 4px;">{{ $orderItem->quantity }}</div>
                                <div style="color: #9ca3af; font-size: 12px;">units</div>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="text-center" style="padding: 1.5rem; background: #f8fafc; border-radius: 12px;">
                                <div style="color: #6b7280; font-size: 13px; font-weight: 600; text-transform: uppercase; margin-bottom: 8px;">Unit Price</div>
                                <div style="color: #3b82f6; font-size: 32px; font-weight: 700; margin-bottom: 4px;">${{ number_format($orderItem->unit_price, 2) }}</div>
                                @if($orderItem->product->regular_price > $orderItem->unit_price)
                                    <div style="color: #ef4444; font-size: 12px;">
                                        <i class="bi bi-tag-fill"></i> {{ round((($orderItem->product->regular_price - $orderItem->unit_price) / $orderItem->product->regular_price) * 100, 1) }}% discount
                                    </div>
                                @else
                                    <div style="color: #9ca3af; font-size: 12px;">regular price</div>
                                @endif
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="text-center" style="padding: 1.5rem; background: linear-gradient(135deg, #f0fdf4 0%, #dcfce7 100%); border-radius: 12px; border: 2px solid #10b981;">
                                <div style="color: #6b7280; font-size: 13px; font-weight: 600; text-transform: uppercase; margin-bottom: 8px;">Total Revenue</div>
                                <div style="color: #10b981; font-size: 32px; font-weight: 700; margin-bottom: 4px;">${{ number_format($orderItem->total_price, 2) }}</div>
                                <div style="color: #10b981; font-size: 12px; font-weight: 600;">
                                    ${{ number_format($orderItem->unit_price, 2) }} × {{ $orderItem->quantity }}
                    </div>
                </div>
            </div>
                    </div>

                    @if($orderItem->has_discount)
                        <div class="alert alert-success mt-4 mb-0" style="background: #f0fdf4; border: 1px solid #86efac; border-radius: 10px;">
                            <div class="d-flex align-items-center">
                                <i class="bi bi-tag-fill" style="font-size: 2rem; color: #10b981; margin-right: 1rem;"></i>
                                <div>
                                    <strong style="color: #166534;">Discount Applied!</strong>
                                    <p class="mb-0" style="color: #15803d; font-size: 14px;">
                                        Customer saved ${{ number_format($orderItem->discount_amount, 2) }} ({{ $orderItem->discount_percentage }}% off)
                                    </p>
                                                </div>
                                            </div>
                                        </div>
                    @endif
                                    </div>
                                </div>

            <!-- Order Context -->
            <div class="card" style="border: none; border-radius: 16px; box-shadow: 0 4px 6px rgba(0,0,0,0.07);">
                <div class="card-header" style="background: linear-gradient(135deg, #10b981 0%, #059669 100%); border: none; border-radius: 16px 16px 0 0; padding: 1.5rem 2rem;">
                    <h5 class="mb-0" style="color: #ffffff; font-weight: 700; font-size: 18px;">
                        <i class="bi bi-receipt me-2"></i>Order Context
                    </h5>
                        </div>
                <div class="card-body" style="padding: 2rem;">
                    <div class="table-responsive">
                        <table class="table table-borderless mb-0">
                            <tr>
                                <td style="color: #6b7280; font-weight: 600; padding: 0.75rem 0; width: 30%;">Order Number:</td>
                                <td style="padding: 0.75rem 0;">
                                    <a href="{{ route('admin.orders.show', $orderItem->order) }}" style="color: #3b82f6; font-weight: 600; text-decoration: none;" onmouseover="this.style.textDecoration='underline'" onmouseout="this.style.textDecoration='none'">
                                        {{ $orderItem->order->order_number }}
                                    </a>
                                </td>
                            </tr>
                            <tr>
                                <td style="color: #6b7280; font-weight: 600; padding: 0.75rem 0;">Customer:</td>
                                <td style="padding: 0.75rem 0; color: #1a202c; font-weight: 600;">{{ $orderItem->order->customer_name }}</td>
                            </tr>
                            <tr>
                                <td style="color: #6b7280; font-weight: 600; padding: 0.75rem 0;">Order Date:</td>
                                <td style="padding: 0.75rem 0; color: #1a202c;">{{ $orderItem->created_at->format('F d, Y \a\t g:i A') }}</td>
                            </tr>
                            <tr>
                                <td style="color: #6b7280; font-weight: 600; padding: 0.75rem 0;">Order Status:</td>
                                <td style="padding: 0.75rem 0;">
                                    <span class="badge" style="background: {{ $orderItem->order->status_color }}; color: #ffffff; font-size: 12px; padding: 6px 12px; border-radius: 20px; text-transform: uppercase;">
                                        {{ $orderItem->order->status }}
                                    </span>
                                </td>
                            </tr>
                            <tr>
                                <td style="color: #6b7280; font-weight: 600; padding: 0.75rem 0;">Payment Status:</td>
                                <td style="padding: 0.75rem 0;">
                                    <span class="badge" style="background: {{ $orderItem->order->payment_status_color }}; color: #ffffff; font-size: 12px; padding: 6px 12px; border-radius: 20px; text-transform: uppercase;">
                                        {{ $orderItem->order->payment_status }}
                                    </span>
                                </td>
                            </tr>
                            <tr>
                                <td style="color: #6b7280; font-weight: 600; padding: 0.75rem 0;">Order Total:</td>
                                <td style="padding: 0.75rem 0; color: #10b981; font-weight: 700; font-size: 18px;">
                                    ${{ number_format($orderItem->order->total_amount, 2) }}
                                </td>
                            </tr>
                        </table>
                    </div>
                </div>
            </div>
        </div>

        <!-- Right Column - Statistics & Insights -->
        <div class="col-lg-4">
            <!-- Quick Stats -->
            <div class="card mb-4" style="border: none; border-radius: 16px; box-shadow: 0 4px 6px rgba(0,0,0,0.07);">
                <div class="card-header" style="background: linear-gradient(135deg, #3b82f6 0%, #2563eb 100%); border: none; border-radius: 16px 16px 0 0; padding: 1.5rem;">
                    <h5 class="mb-0" style="color: #ffffff; font-weight: 700; font-size: 16px;">
                        <i class="bi bi-graph-up me-2"></i>Performance Metrics
                    </h5>
                </div>
                <div class="card-body" style="padding: 1.5rem;">
                    @php
                        $contribution = ($orderItem->order->total_amount > 0) 
                            ? ($orderItem->total_price / $orderItem->order->total_amount) * 100 
                            : 0;
                    @endphp
                    
                    <div class="mb-4">
                        <div class="d-flex justify-content-between mb-2">
                            <span style="color: #6b7280; font-size: 13px; font-weight: 600;">Order Contribution</span>
                            <span style="color: #1a202c; font-weight: 700; font-size: 14px;">{{ number_format($contribution, 1) }}%</span>
                        </div>
                        <div class="progress" style="height: 10px; background: #e2e8f0; border-radius: 10px;">
                            <div class="progress-bar" style="background: linear-gradient(90deg, #10b981 0%, #059669 100%); width: {{ min($contribution, 100) }}%; border-radius: 10px;"></div>
                        </div>
                        <small style="color: #9ca3af; font-size: 11px;">This item represents {{ number_format($contribution, 1) }}% of the order value</small>
                    </div>

                    <div class="mb-4">
                        <div class="d-flex justify-content-between mb-2">
                            <span style="color: #6b7280; font-size: 13px; font-weight: 600;">Profit Margin</span>
                            @php
                                $costPrice = $orderItem->product->regular_price * 0.6; // Assuming 40% markup
                                $profit = $orderItem->unit_price - $costPrice;
                                $profitMargin = ($orderItem->unit_price > 0) ? ($profit / $orderItem->unit_price) * 100 : 0;
                            @endphp
                            <span style="color: {{ $profitMargin > 30 ? '#10b981' : ($profitMargin > 15 ? '#f59e0b' : '#ef4444') }}; font-weight: 700; font-size: 14px;">
                                {{ number_format($profitMargin, 1) }}%
                            </span>
                        </div>
                        <div class="progress" style="height: 10px; background: #e2e8f0; border-radius: 10px;">
                            <div class="progress-bar" style="background: linear-gradient(90deg, {{ $profitMargin > 30 ? '#10b981, #059669' : ($profitMargin > 15 ? '#f59e0b, #d97706' : '#ef4444, #dc2626') }}); width: {{ min($profitMargin, 100) }}%; border-radius: 10px;"></div>
                        </div>
                        <small style="color: #9ca3af; font-size: 11px;">Estimated profit: ${{ number_format($profit * $orderItem->quantity, 2) }}</small>
                    </div>

                    <div class="alert alert-info mb-0" style="background: #f0f9ff; border: 1px solid #bae6fd; border-radius: 10px; padding: 1rem;">
                        <i class="bi bi-info-circle me-2" style="color: #0369a1;"></i>
                        <strong style="color: #0c4a6e;">Revenue Impact</strong>
                        <p class="mb-0" style="color: #0369a1; font-size: 12px; margin-top: 4px;">
                            This sale contributed ${{ number_format($orderItem->total_price, 2) }} to total revenue
                        </p>
                    </div>
                </div>
            </div>

            <!-- Product Performance -->
            @php
                $productStats = \App\Models\OrderItem::where('product_id', $orderItem->product_id)
                    ->selectRaw('COUNT(*) as times_sold')
                    ->selectRaw('SUM(quantity) as total_quantity')
                    ->selectRaw('SUM(total_price) as total_revenue')
                    ->first();
            @endphp

            <div class="card mb-4" style="border: none; border-radius: 16px; box-shadow: 0 4px 6px rgba(0,0,0,0.07);">
                <div class="card-header" style="background: linear-gradient(135deg, #f59e0b 0%, #d97706 100%); border: none; border-radius: 16px 16px 0 0; padding: 1.5rem;">
                    <h5 class="mb-0" style="color: #ffffff; font-weight: 700; font-size: 16px;">
                        <i class="bi bi-trophy me-2"></i>Product Performance
                    </h5>
                </div>
                <div class="card-body" style="padding: 1.5rem;">
                    <div class="mb-3">
                        <div class="d-flex justify-content-between align-items-center mb-2">
                            <span style="color: #6b7280; font-size: 13px;">Times Sold</span>
                            <span style="color: #1a202c; font-weight: 700; font-size: 18px;">{{ $productStats->times_sold }}</span>
                            </div>
                        <div class="progress" style="height: 6px; background: #e2e8f0; border-radius: 10px;">
                            <div class="progress-bar" style="background: #3b82f6; width: 100%; border-radius: 10px;"></div>
                        </div>
                    </div>

                    <div class="mb-3">
                        <div class="d-flex justify-content-between align-items-center mb-2">
                            <span style="color: #6b7280; font-size: 13px;">Total Units</span>
                            <span style="color: #1a202c; font-weight: 700; font-size: 18px;">{{ $productStats->total_quantity }}</span>
                            </div>
                        <div class="progress" style="height: 6px; background: #e2e8f0; border-radius: 10px;">
                            <div class="progress-bar" style="background: #10b981; width: 100%; border-radius: 10px;"></div>
                        </div>
                            </div>

                    <div class="mb-0">
                        <div class="d-flex justify-content-between align-items-center mb-2">
                            <span style="color: #6b7280; font-size: 13px;">Total Revenue</span>
                            <span style="color: #10b981; font-weight: 700; font-size: 18px;">${{ number_format($productStats->total_revenue, 2) }}</span>
                        </div>
                        <div class="progress" style="height: 6px; background: #e2e8f0; border-radius: 10px;">
                            <div class="progress-bar" style="background: linear-gradient(90deg, #10b981 0%, #059669 100%); width: 100%; border-radius: 10px;"></div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Actions -->
            <div class="card" style="border: none; border-radius: 16px; box-shadow: 0 4px 6px rgba(0,0,0,0.07);">
                <div class="card-body" style="padding: 1.5rem;">
                    <h6 style="color: #1a202c; font-weight: 700; font-size: 14px; margin-bottom: 1rem;">Quick Actions</h6>
                    <div class="d-grid gap-2">
                        <a href="{{ route('admin.orderItems.edit', $orderItem) }}" class="btn btn-primary">
                            <i class="bi bi-pencil me-2"></i>Edit Item Details
                        </a>
                        <a href="{{ route('admin.products.edit', $orderItem->product) }}" class="btn btn-outline-primary">
                            <i class="bi bi-box me-2"></i>Edit Product
                        </a>
                        <a href="{{ route('admin.orders.edit', $orderItem->order) }}" class="btn btn-outline-success">
                            <i class="bi bi-receipt me-2"></i>Edit Order
                        </a>
                        <button onclick="window.print()" class="btn btn-outline-secondary">
                            <i class="bi bi-printer me-2"></i>Print Details
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
@media print {
    .btn, .card-header, nav, footer, .breadcrumb {
        display: none !important;
    }
    .card {
        box-shadow: none !important;
        border: 1px solid #ddd !important;
    }
    }
</style>

@endsection