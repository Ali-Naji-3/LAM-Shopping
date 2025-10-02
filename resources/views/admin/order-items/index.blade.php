@extends('admin.dashboard')

@section('content')
<div class="container-fluid">
    <!-- Page Header -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h2 class="mb-1" style="color: #1a202c !important; font-weight: 700 !important; font-size: 24px !important;">
                📊 Product Sales Analytics
            </h2>
            <p class="mb-0" style="color: #4a5568 !important; font-size: 14px !important;">
                Track product performance, revenue, and inventory impact • {{ number_format($statistics['total_items']) }} items sold
            </p>
        </div>
        <div class="d-flex gap-2">
            <button onclick="exportData('excel')" class="btn btn-outline-success">
                <i class="bi bi-file-earmark-excel me-2"></i>Export Excel
            </button>
            <button onclick="exportData('csv')" class="btn btn-outline-info">
                <i class="bi bi-file-earmark-spreadsheet me-2"></i>Export CSV
            </button>
            <a href="{{ route('admin.orderItems.analytics') }}" class="btn btn-outline-primary">
                <i class="bi bi-graph-up me-2"></i>Advanced Analytics
            </a>
        </div>
    </div>

    <!-- Enhanced Statistics Cards -->
    <div class="row mb-4">
        <div class="col-lg-3 col-md-6 mb-3">
            <div class="card" style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%) !important; border: none !important; border-radius: 12px !important; box-shadow: 0 4px 8px rgba(102, 126, 234, 0.3) !important;">
                <div class="card-body text-center" style="padding: 1.5rem !important;">
                    <div class="stat-icon" style="color: #ffffff !important; font-size: 2.5rem !important; margin-bottom: 0.5rem !important;">💰</div>
                    <div class="stat-number h3 mb-1" style="color: #ffffff !important; font-weight: 700 !important;">${{ number_format($statistics['total_value'], 2) }}</div>
                    <div class="stat-label" style="color: rgba(255,255,255,0.9) !important; font-size: 14px !important; font-weight: 500 !important;">Total Revenue</div>
                </div>
            </div>
        </div>
        <div class="col-lg-3 col-md-6 mb-3">
            <div class="card" style="background: linear-gradient(135deg, #10b981 0%, #059669 100%) !important; border: none !important; border-radius: 12px !important; box-shadow: 0 4px 8px rgba(16, 185, 129, 0.3) !important;">
                <div class="card-body text-center" style="padding: 1.5rem !important;">
                    <div class="stat-icon" style="color: #ffffff !important; font-size: 2.5rem !important; margin-bottom: 0.5rem !important;">📦</div>
                    <div class="stat-number h3 mb-1" style="color: #ffffff !important; font-weight: 700 !important;">{{ number_format($statistics['total_quantity']) }}</div>
                    <div class="stat-label" style="color: rgba(255,255,255,0.9) !important; font-size: 14px !important; font-weight: 500 !important;">Units Sold</div>
                </div>
            </div>
        </div>
        <div class="col-lg-3 col-md-6 mb-3">
            <div class="card" style="background: linear-gradient(135deg, #f59e0b 0%, #d97706 100%) !important; border: none !important; border-radius: 12px !important; box-shadow: 0 4px 8px rgba(245, 158, 11, 0.3) !important;">
                <div class="card-body text-center" style="padding: 1.5rem !important;">
                    <div class="stat-icon" style="color: #ffffff !important; font-size: 2.5rem !important; margin-bottom: 0.5rem !important;">📊</div>
                    <div class="stat-number h3 mb-1" style="color: #ffffff !important; font-weight: 700 !important;">${{ number_format($statistics['average_unit_price'] ?? 0, 2) }}</div>
                    <div class="stat-label" style="color: rgba(255,255,255,0.9) !important; font-size: 14px !important; font-weight: 500 !important;">Avg. Price</div>
                </div>
            </div>
        </div>
        <div class="col-lg-3 col-md-6 mb-3">
            <div class="card" style="background: linear-gradient(135deg, #3b82f6 0%, #2563eb 100%) !important; border: none !important; border-radius: 12px !important; box-shadow: 0 4px 8px rgba(59, 130, 246, 0.3) !important;">
                <div class="card-body text-center" style="padding: 1.5rem !important;">
                    <div class="stat-icon" style="color: #ffffff !important; font-size: 2.5rem !important; margin-bottom: 0.5rem !important;">🛒</div>
                    <div class="stat-number h3 mb-1" style="color: #ffffff !important; font-weight: 700 !important;">{{ number_format($statistics['unique_orders']) }}</div>
                    <div class="stat-label" style="color: rgba(255,255,255,0.9) !important; font-size: 14px !important; font-weight: 500 !important;">Orders Fulfilled</div>
                </div>
            </div>
        </div>
    </div>

    <!-- Top Performing Products -->
    @php
        $topProducts = \App\Models\OrderItem::select('product_id')
            ->selectRaw('SUM(quantity) as total_quantity')
            ->selectRaw('SUM(total_price) as total_revenue')
            ->selectRaw('COUNT(DISTINCT order_id) as order_count')
            ->with('product')
            ->groupBy('product_id')
            ->orderBy('total_revenue', 'desc')
            ->limit(5)
            ->get();
    @endphp

    <div class="row mb-4">
        <!-- Top 5 Products by Revenue -->
        <div class="col-lg-6 mb-4">
            <div class="card" style="background: #ffffff !important; border: 1px solid #e2e8f0 !important; border-radius: 12px !important; box-shadow: 0 1px 3px rgba(0, 0, 0, 0.1) !important;">
                <div class="card-header" style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%) !important; border: none !important; border-radius: 12px 12px 0 0 !important; padding: 1.5rem !important;">
                    <h5 class="mb-0" style="color: #ffffff !important; font-weight: 600 !important; font-size: 16px !important;">
                        <i class="bi bi-trophy me-2"></i>Top 5 Products by Revenue
                    </h5>
                </div>
                <div class="card-body" style="padding: 1.5rem !important;">
                    @forelse($topProducts as $index => $item)
                        <div class="d-flex align-items-center mb-3 p-3" style="background: #f8f9fa; border-radius: 8px;">
                            <div class="rank-badge me-3" style="width: 40px; height: 40px; background: {{ $index == 0 ? '#fbbf24' : ($index == 1 ? '#94a3b8' : ($index == 2 ? '#fb923c' : '#e2e8f0')) }}; border-radius: 50%; display: flex; align-items: center; justify-content: center; font-weight: 700; color: {{ $index < 3 ? '#ffffff' : '#1a202c' }};">
                                {{ $index + 1 }}
                            </div>
                            <div class="flex-grow-1">
                                <div style="color: #1a202c; font-weight: 600; font-size: 14px;">
                                    {{ $item->product->name }}
                                </div>
                                <div style="color: #6b7280; font-size: 12px;">
                                    {{ $item->total_quantity }} units • {{ $item->order_count }} orders
                                </div>
                            </div>
                            <div class="text-end">
                                <div style="color: #10b981; font-weight: 700; font-size: 16px;">
                                    ${{ number_format($item->total_revenue, 2) }}
                                </div>
                            </div>
                        </div>
                    @empty
                        <p class="text-center text-muted">No data available</p>
                    @endforelse
                </div>
            </div>
        </div>

        <!-- Quick Stats & Insights -->
        <div class="col-lg-6 mb-4">
            <div class="card" style="background: #ffffff !important; border: 1px solid #e2e8f0 !important; border-radius: 12px !important; box-shadow: 0 1px 3px rgba(0, 0, 0, 0.1) !important; height: 100%;">
                <div class="card-header" style="background: linear-gradient(135deg, #10b981 0%, #059669 100%) !important; border: none !important; border-radius: 12px 12px 0 0 !important; padding: 1.5rem !important;">
                    <h5 class="mb-0" style="color: #ffffff !important; font-weight: 600 !important; font-size: 16px !important;">
                        <i class="bi bi-lightbulb me-2"></i>Quick Insights
                    </h5>
                </div>
                <div class="card-body" style="padding: 1.5rem !important;">
                    <div class="mb-4">
                        <div class="d-flex justify-content-between align-items-center mb-2">
                            <span style="color: #4a5568; font-size: 14px;">Average Order Value</span>
                            <span style="color: #1a202c; font-weight: 700; font-size: 16px;">
                                ${{ number_format(($statistics['total_value'] ?? 0) / max($statistics['unique_orders'], 1), 2) }}
                            </span>
                        </div>
                        <div class="progress" style="height: 8px; background: #e2e8f0;">
                            <div class="progress-bar" style="background: linear-gradient(90deg, #10b981 0%, #059669 100%); width: 75%;"></div>
                        </div>
                    </div>

                    <div class="mb-4">
                        <div class="d-flex justify-content-between align-items-center mb-2">
                            <span style="color: #4a5568; font-size: 14px;">Average Items Per Order</span>
                            <span style="color: #1a202c; font-weight: 700; font-size: 16px;">
                                {{ number_format(($statistics['total_items'] ?? 0) / max($statistics['unique_orders'], 1), 2) }}
                            </span>
                        </div>
                        <div class="progress" style="height: 8px; background: #e2e8f0;">
                            <div class="progress-bar" style="background: linear-gradient(90deg, #3b82f6 0%, #2563eb 100%); width: 60%;"></div>
                        </div>
                    </div>

                    <div class="mb-4">
                        <div class="d-flex justify-content-between align-items-center mb-2">
                            <span style="color: #4a5568; font-size: 14px;">Unique Products Sold</span>
                            <span style="color: #1a202c; font-weight: 700; font-size: 16px;">
                                {{ \App\Models\OrderItem::distinct('product_id')->count('product_id') }}
                            </span>
                        </div>
                        <div class="progress" style="height: 8px; background: #e2e8f0;">
                            <div class="progress-bar" style="background: linear-gradient(90deg, #f59e0b 0%, #d97706 100%); width: 85%;"></div>
                        </div>
                    </div>

                    <div class="alert alert-info mb-0" style="background: #f0f9ff; border: 1px solid #bae6fd; border-radius: 8px;">
                        <i class="bi bi-info-circle me-2"></i>
                        <strong>Tip:</strong> Use filters to analyze specific time periods or product categories for deeper insights.
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Advanced Filters -->
    <div class="card mb-4" style="background: #ffffff !important; border: 1px solid #e2e8f0 !important; border-radius: 12px !important; box-shadow: 0 1px 3px rgba(0, 0, 0, 0.1) !important;">
        <div class="card-header" style="background: linear-gradient(135deg, #f7fafc 0%, #edf2f7 100%) !important; border-bottom: 1px solid #e2e8f0 !important; border-radius: 12px 12px 0 0 !important; padding: 1rem 1.5rem !important;">
            <div class="d-flex justify-content-between align-items-center">
                <h6 class="mb-0" style="color: #1a202c !important; font-weight: 600 !important;">
                    <i class="bi bi-funnel me-2"></i>Filter & Search
                </h6>
                <button type="button" class="btn btn-sm btn-link" onclick="toggleFilters()">
                    <i class="bi bi-chevron-down" id="filterToggleIcon"></i>
                </button>
            </div>
        </div>
        <div class="card-body" id="filterSection" style="padding: 1.5rem !important; display: block;">
            <form method="GET" action="{{ route('admin.orderItems.index') }}">
                <div class="row g-3">
                    <div class="col-md-3">
                        <label class="form-label" style="color: #2d3748; font-weight: 600; font-size: 14px;">
                            <i class="bi bi-search me-1"></i>Search
                        </label>
                        <input type="text" name="search" class="form-control" placeholder="Product, SKU, Order #..." value="{{ request('search') }}">
                    </div>
                    <div class="col-md-3">
                        <label class="form-label" style="color: #2d3748; font-weight: 600; font-size: 14px;">
                            <i class="bi bi-box me-1"></i>Product
                        </label>
                        <select name="product_id" class="form-control">
                            <option value="">All Products</option>
                            @foreach($products as $product)
                                <option value="{{ $product->id }}" {{ request('product_id') == $product->id ? 'selected' : '' }}>
                                    {{ $product->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-3">
                        <label class="form-label" style="color: #2d3748; font-weight: 600; font-size: 14px;">
                            <i class="bi bi-receipt me-1"></i>Order
                        </label>
                        <select name="order_id" class="form-control">
                            <option value="">All Orders</option>
                            @foreach($orders as $order)
                                <option value="{{ $order->id }}" {{ request('order_id') == $order->id ? 'selected' : '' }}>
                                    {{ $order->order_number }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-3">
                        <label class="form-label" style="color: transparent;">Actions</label>
                        <div class="d-flex gap-2">
                            <button type="submit" class="btn btn-primary w-100">
                                <i class="bi bi-search me-1"></i>Filter
                            </button>
                            <a href="{{ route('admin.orderItems.index') }}" class="btn btn-outline-secondary">
                                <i class="bi bi-arrow-clockwise"></i>
                            </a>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <!-- Product Sales Table -->
    <div class="card" style="background: #ffffff !important; border: 1px solid #e2e8f0 !important; border-radius: 12px !important; box-shadow: 0 1px 3px rgba(0, 0, 0, 0.1) !important;">
        <div class="card-header" style="background: linear-gradient(135deg, #f7fafc 0%, #edf2f7 100%) !important; border-bottom: 1px solid #e2e8f0 !important; border-radius: 12px 12px 0 0 !important; padding: 1.5rem 2rem !important;">
            <div class="d-flex justify-content-between align-items-center">
                <h5 class="mb-0" style="color: #1a202c !important; font-weight: 600 !important; font-size: 18px !important;">
                    <i class="bi bi-list-ul me-2"></i>Product Sales Details ({{ $orderItems->total() }})
                </h5>
                <div class="d-flex gap-2">
                    <select class="form-select form-select-sm" style="width: auto;" onchange="location.href=this.value">
                        <option value="?per_page=10" {{ request('per_page') == 10 ? 'selected' : '' }}>10 per page</option>
                        <option value="?per_page=25" {{ request('per_page') == 25 ? 'selected' : '' }}>25 per page</option>
                        <option value="?per_page=50" {{ request('per_page') == 50 ? 'selected' : '' }}>50 per page</option>
                        <option value="?per_page=100" {{ request('per_page') == 100 ? 'selected' : '' }}>100 per page</option>
                    </select>
                </div>
            </div>
        </div>
        <div class="card-body" style="padding: 0 !important;">
            @if($orderItems->count() > 0)
                <div class="table-responsive">
                    <table class="table table-hover mb-0">
                        <thead style="background: #f8fafc !important; border-bottom: 2px solid #e2e8f0 !important;">
                            <tr>
                                <th style="padding: 1rem 1.5rem; color: #2d3748; font-weight: 700; font-size: 13px; text-transform: uppercase;">
                                    Product
                                </th>
                                <th style="padding: 1rem 1.5rem; color: #2d3748; font-weight: 700; font-size: 13px; text-transform: uppercase;">
                                    Order Info
                                </th>
                                <th style="padding: 1rem 1.5rem; color: #2d3748; font-weight: 700; font-size: 13px; text-transform: uppercase; text-align: center;">
                                    Quantity
                                </th>
                                <th style="padding: 1rem 1.5rem; color: #2d3748; font-weight: 700; font-size: 13px; text-transform: uppercase; text-align: right;">
                                    Unit Price
                                </th>
                                <th style="padding: 1rem 1.5rem; color: #2d3748; font-weight: 700; font-size: 13px; text-transform: uppercase; text-align: right;">
                                    Revenue
                                </th>
                                <th style="padding: 1rem 1.5rem; color: #2d3748; font-weight: 700; font-size: 13px; text-transform: uppercase; text-align: center;">
                                    Actions
                                </th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($orderItems as $item)
                                <tr style="transition: all 0.2s ease;" onmouseover="this.style.backgroundColor='#f8fafc'" onmouseout="this.style.backgroundColor='transparent'">
                                    <td style="padding: 1rem 1.5rem; border-bottom: 1px solid #f1f5f9;">
                                        <div class="d-flex align-items-center">
                                            @if($item->product && $item->product->image)
                                                <img src="{{ asset('storage/' . $item->product->image) }}" alt="{{ $item->product->name }}" style="width: 50px; height: 50px; object-fit: cover; border-radius: 8px; margin-right: 12px; border: 2px solid #e2e8f0;">
                                            @else
                                                <div style="width: 50px; height: 50px; background: #e2e8f0; border-radius: 8px; margin-right: 12px; display: flex; align-items: center; justify-content: center;">
                                                    <i class="bi bi-image" style="color: #9ca3af; font-size: 24px;"></i>
                                                </div>
                                            @endif
                                            <div>
                                                <div style="color: #1a202c; font-weight: 600; font-size: 14px; margin-bottom: 2px;">
                                                    {{ $item->product->name }}
                                                </div>
                                                <div style="color: #6b7280; font-size: 12px;">
                                                    <span class="badge bg-secondary" style="font-size: 10px;">{{ $item->product->sku }}</span>
                                                    @if($item->product->category)
                                                        <span class="badge bg-info ms-1" style="font-size: 10px;">{{ $item->product->category->name }}</span>
                                                    @endif
                                                    @if($item->product->brand)
                                                        <span class="badge bg-primary ms-1" style="font-size: 10px;">{{ $item->product->brand->name }}</span>
                                                    @endif
                                                </div>
                                            </div>
                                        </div>
                                    </td>
                                    <td style="padding: 1rem 1.5rem; border-bottom: 1px solid #f1f5f9;">
                                        <div>
                                            <a href="{{ route('admin.orders.show', $item->order) }}" style="color: #3b82f6; font-weight: 600; font-size: 13px; text-decoration: none;" onmouseover="this.style.textDecoration='underline'" onmouseout="this.style.textDecoration='none'">
                                                <i class="bi bi-receipt me-1"></i>{{ $item->order->order_number }}
                                            </a>
                                        </div>
                                        <div style="color: #6b7280; font-size: 12px; margin-top: 2px;">
                                            {{ $item->order->customer_name }}
                                        </div>
                                        <div style="color: #9ca3af; font-size: 11px;">
                                            {{ $item->created_at->diffForHumans() }}
                                        </div>
                                    </td>
                                    <td style="padding: 1rem 1.5rem; border-bottom: 1px solid #f1f5f9; text-align: center;">
                                        <span class="badge" style="background: linear-gradient(135deg, #10b981 0%, #059669 100%); color: #ffffff; font-size: 13px; padding: 8px 16px; border-radius: 20px; font-weight: 600;">
                                            {{ $item->quantity }} units
                                        </span>
                                    </td>
                                    <td style="padding: 1rem 1.5rem; border-bottom: 1px solid #f1f5f9; text-align: right;">
                                        <span style="color: #1a202c; font-weight: 600; font-size: 15px;">
                                            ${{ number_format($item->unit_price, 2) }}
                                        </span>
                                    </td>
                                    <td style="padding: 1rem 1.5rem; border-bottom: 1px solid #f1f5f9; text-align: right;">
                                        <div style="color: #10b981; font-weight: 700; font-size: 16px;">
                                            ${{ number_format($item->total_price, 2) }}
                                        </div>
                                        @if($item->has_discount)
                                            <div style="color: #ef4444; font-size: 11px;">
                                                <i class="bi bi-tag-fill me-1"></i>{{ $item->discount_percentage }}% off
                                            </div>
                                        @endif
                                    </td>
                                    <td style="padding: 1rem 1.5rem; border-bottom: 1px solid #f1f5f9; text-align: center;">
                                        <div class="d-flex gap-1 justify-content-center">
                                            <a href="{{ route('admin.orderItems.show', $item) }}" class="btn btn-sm btn-outline-info" title="View Details">
                                                <i class="bi bi-eye"></i>
                                            </a>
                                            <a href="{{ route('admin.orders.show', $item->order) }}" class="btn btn-sm btn-outline-primary" title="View Order">
                                                <i class="bi bi-receipt"></i>
                                            </a>
                                            <a href="{{ route('admin.products.show', $item->product) }}" class="btn btn-sm btn-outline-success" title="View Product">
                                                <i class="bi bi-box"></i>
                                            </a>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                        <tfoot style="background: #f8fafc; border-top: 2px solid #e2e8f0;">
                            <tr>
                                <td colspan="2" style="padding: 1rem 1.5rem; font-weight: 700; color: #1a202c;">
                                    Page Totals:
                                </td>
                                <td style="padding: 1rem 1.5rem; text-align: center; font-weight: 700; color: #10b981;">
                                    {{ $orderItems->sum('quantity') }} units
                                </td>
                                <td style="padding: 1rem 1.5rem; text-align: right; font-weight: 600; color: #1a202c;">
                                    Avg: ${{ number_format($orderItems->avg('unit_price'), 2) }}
                                </td>
                                <td style="padding: 1rem 1.5rem; text-align: right; font-weight: 700; color: #10b981; font-size: 16px;">
                                    ${{ number_format($orderItems->sum('total_price'), 2) }}
                                </td>
                                <td></td>
                            </tr>
                        </tfoot>
                    </table>
                </div>

                <!-- Pagination -->
                <div class="d-flex justify-content-between align-items-center" style="padding: 1.5rem 2rem; border-top: 1px solid #f1f5f9;">
                    <div style="color: #6b7280; font-size: 14px;">
                        Showing {{ $orderItems->firstItem() }}-{{ $orderItems->lastItem() }} of {{ $orderItems->total() }}
                    </div>
                    <div>
                        {{ $orderItems->appends(request()->query())->links('pagination.custom') }}
                    </div>
                </div>
            @else
                <div class="text-center" style="padding: 4rem 2rem;">
                    <i class="bi bi-inbox" style="color: #cbd5e0; font-size: 4rem; margin-bottom: 1rem;"></i>
                    <h5 style="color: #4a5568; font-weight: 600;">No sales data found</h5>
                    <p style="color: #9ca3af; font-size: 14px; margin-bottom: 1.5rem;">
                        Adjust your filters or check back later for product sales analytics.
                    </p>
                </div>
            @endif
        </div>
    </div>
</div>

@push('scripts')
<script>
function toggleFilters() {
    const filterSection = document.getElementById('filterSection');
    const icon = document.getElementById('filterToggleIcon');
    
    if (filterSection.style.display === 'none') {
        filterSection.style.display = 'block';
        icon.classList.remove('bi-chevron-down');
        icon.classList.add('bi-chevron-up');
    } else {
        filterSection.style.display = 'none';
        icon.classList.remove('bi-chevron-up');
        icon.classList.add('bi-chevron-down');
    }
}

function exportData(format) {
    const params = new URLSearchParams(window.location.search);
    params.set('export', format);
    window.location.href = '{{ route("admin.orderItems.index") }}?' + params.toString();
}

// Initialize tooltips
document.addEventListener('DOMContentLoaded', function() {
    var tooltipTriggerList = [].slice.call(document.querySelectorAll('[title]'));
    tooltipTriggerList.forEach(function (tooltipTriggerEl) {
        tooltipTriggerEl.setAttribute('data-bs-toggle', 'tooltip');
    });
});
</script>
@endpush
@endsection