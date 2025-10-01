@extends('admin.dashboard')

@section('content')
<div class="container-fluid">
    <!-- Page Header -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h2 class="mb-1" style="color: #1a202c !important; font-weight: 700 !important; font-size: 28px !important;">
                <i class="bi bi-building" style="color: #667eea;"></i> {{ $warehouse->name }}
            </h2>
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb mb-0" style="background: none; padding: 0;">
                    <li class="breadcrumb-item"><a href="{{ route('admin.warehouses.index') }}" style="color: #3b82f6; text-decoration: none;">Warehouses</a></li>
                    <li class="breadcrumb-item active" style="color: #6b7280;">{{ $warehouse->code }}</li>
                </ol>
            </nav>
        </div>
        <div class="d-flex gap-2">
            <a href="{{ route('admin.warehouses.inventory', $warehouse) }}" class="btn btn-outline-success">
                <i class="bi bi-box-seam me-2"></i>Manage Inventory
            </a>
            <a href="{{ route('admin.warehouses.edit', $warehouse) }}" class="btn btn-outline-primary">
                <i class="bi bi-pencil me-2"></i>Edit
            </a>
            <a href="{{ route('admin.warehouses.index') }}" class="btn btn-outline-secondary">
                <i class="bi bi-arrow-left me-2"></i>Back
            </a>
        </div>
    </div>

    @php
        $warehouseInventory = \App\Models\Inventory::with(['product.category', 'product.brand'])->where('warehouse_id', $warehouse->id)->get();
        $totalValue = $warehouseInventory->sum(function($inv) {
            return $inv->quantity * ($inv->product->regular_price ?? 0);
        });
        $lowStockItems = $warehouseInventory->filter(function($inv) { return $inv->isLowStock(); })->count();
        $outOfStockItems = $warehouseInventory->filter(function($inv) { return $inv->isOutOfStock(); })->count();
        $totalQuantity = $warehouseInventory->sum('quantity');
    @endphp

    <div class="row">
        <!-- Left Column -->
        <div class="col-lg-8">
            <!-- Warehouse Information Card -->
            <div class="card mb-4" style="border: none; border-radius: 16px; box-shadow: 0 4px 6px rgba(0,0,0,0.07);">
                <div class="card-header" style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); border: none; border-radius: 16px 16px 0 0; padding: 1.5rem 2rem;">
                    <h5 class="mb-0" style="color: #ffffff; font-weight: 700; font-size: 18px;">
                        <i class="bi bi-info-circle me-2"></i>Warehouse Information
                    </h5>
                </div>
                <div class="card-body" style="padding: 2rem;">
                    <div class="row">
                        <div class="col-md-6">
                            <table class="table table-borderless mb-0">
                                <tr>
                                    <td style="color: #6b7280; font-weight: 600; padding: 0.75rem 0; width: 35%;">Warehouse Code:</td>
                                    <td style="padding: 0.75rem 0;">
                                        <span class="badge" style="background: #667eea; color: #ffffff; font-size: 14px; padding: 8px 16px; border-radius: 20px; font-weight: 600;">
                                            {{ $warehouse->code }}
                                        </span>
                                    </td>
                                </tr>
                                <tr>
                                    <td style="color: #6b7280; font-weight: 600; padding: 0.75rem 0;">Location:</td>
                                    <td style="padding: 0.75rem 0; color: #1a202c; font-weight: 500;">
                                        <i class="bi bi-geo-alt text-success"></i> {{ $warehouse->location }}
                                    </td>
                                </tr>
                                <tr>
                                    <td style="color: #6b7280; font-weight: 600; padding: 0.75rem 0;">Manager:</td>
                                    <td style="padding: 0.75rem 0; color: #1a202c; font-weight: 500;">
                                        <i class="bi bi-person-badge"></i> {{ $warehouse->manager ?? 'Not assigned' }}
                                    </td>
                                </tr>
                            </table>
                        </div>
                        <div class="col-md-6">
                            <table class="table table-borderless mb-0">
                                <tr>
                                    <td style="color: #6b7280; font-weight: 600; padding: 0.75rem 0; width: 35%;">Contact:</td>
                                    <td style="padding: 0.75rem 0; color: #1a202c; font-weight: 500;">
                                        <i class="bi bi-telephone"></i> {{ $warehouse->formatted_contact_number }}
                                    </td>
                                </tr>
                                <tr>
                                    <td style="color: #6b7280; font-weight: 600; padding: 0.75rem 0;">Status:</td>
                                    <td style="padding: 0.75rem 0;">
                                        <span class="badge" style="background: {{ $warehouse->is_active ? '#10b981' : '#ef4444' }}; color: #ffffff; font-size: 13px; padding: 6px 16px; border-radius: 20px;">
                                            {{ $warehouse->is_active ? 'Active' : 'Inactive' }}
                                        </span>
                                    </td>
                                </tr>
                                <tr>
                                    <td style="color: #6b7280; font-weight: 600; padding: 0.75rem 0;">Created:</td>
                                    <td style="padding: 0.75rem 0; color: #1a202c;">
                                        {{ $warehouse->created_at->format('M d, Y') }}
                                    </td>
                                </tr>
                            </table>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Inventory Overview -->
            <div class="card mb-4" style="border: none; border-radius: 16px; box-shadow: 0 4px 6px rgba(0,0,0,0.07);">
                <div class="card-header" style="background: linear-gradient(135deg, #10b981 0%, #059669 100%); border: none; border-radius: 16px 16px 0 0; padding: 1.5rem 2rem;">
                    <h5 class="mb-0" style="color: #ffffff; font-weight: 700; font-size: 18px;">
                        <i class="bi bi-box-seam me-2"></i>Inventory Overview
                    </h5>
                </div>
                <div class="card-body" style="padding: 2rem;">
                    <div class="row g-4">
                        <div class="col-md-3">
                            <div class="text-center" style="padding: 1.5rem; background: #f8fafc; border-radius: 12px;">
                                <div style="color: #6b7280; font-size: 13px; font-weight: 600; text-transform: uppercase; margin-bottom: 8px;">Total Products</div>
                                <div style="color: #3b82f6; font-size: 32px; font-weight: 700; margin-bottom: 4px;">{{ $warehouseInventory->pluck('product_id')->unique()->count() }}</div>
                                <div style="color: #9ca3af; font-size: 12px;">unique SKUs</div>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="text-center" style="padding: 1.5rem; background: #f8fafc; border-radius: 12px;">
                                <div style="color: #6b7280; font-size: 13px; font-weight: 600; text-transform: uppercase; margin-bottom: 8px;">Total Units</div>
                                <div style="color: #10b981; font-size: 32px; font-weight: 700; margin-bottom: 4px;">{{ number_format($totalQuantity) }}</div>
                                <div style="color: #9ca3af; font-size: 12px;">in stock</div>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="text-center" style="padding: 1.5rem; background: #fef3c7; border-radius: 12px; border: 2px solid #f59e0b;">
                                <div style="color: #78350f; font-size: 13px; font-weight: 600; text-transform: uppercase; margin-bottom: 8px;">Low Stock</div>
                                <div style="color: #f59e0b; font-size: 32px; font-weight: 700; margin-bottom: 4px;">{{ $lowStockItems }}</div>
                                <div style="color: #92400e; font-size: 12px;">items</div>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="text-center" style="padding: 1.5rem; background: linear-gradient(135deg, #f0fdf4 0%, #dcfce7 100%); border-radius: 12px;">
                                <div style="color: #166534; font-size: 13px; font-weight: 600; text-transform: uppercase; margin-bottom: 8px;">Stock Value</div>
                                <div style="color: #10b981; font-size: 28px; font-weight: 700; margin-bottom: 4px;">${{ number_format($totalValue, 0) }}</div>
                                <div style="color: #15803d; font-size: 12px;">total value</div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Top Products in Warehouse -->
            @php
                $topProducts = $warehouseInventory->sortByDesc(function($inv) {
                    return $inv->quantity * ($inv->product->regular_price ?? 0);
                })->take(10);
            @endphp

            <div class="card" style="border: none; border-radius: 16px; box-shadow: 0 4px 6px rgba(0,0,0,0.07);">
                <div class="card-header" style="background: linear-gradient(135deg, #3b82f6 0%, #2563eb 100%); border: none; border-radius: 16px 16px 0 0; padding: 1.5rem 2rem;">
                    <h5 class="mb-0" style="color: #ffffff; font-weight: 700; font-size: 18px;">
                        <i class="bi bi-trophy me-2"></i>Top 10 Products by Value
                    </h5>
                </div>
                <div class="card-body" style="padding: 0;">
                    <div class="table-responsive">
                        <table class="table table-hover mb-0">
                            <thead style="background: #f8fafc;">
                                <tr>
                                    <th style="padding: 1rem 1.5rem; color: #6b7280; font-weight: 700; font-size: 12px; text-transform: uppercase;">#</th>
                                    <th style="padding: 1rem 1.5rem; color: #6b7280; font-weight: 700; font-size: 12px; text-transform: uppercase;">Product</th>
                                    <th style="padding: 1rem 1.5rem; color: #6b7280; font-weight: 700; font-size: 12px; text-transform: uppercase; text-align: center;">Quantity</th>
                                    <th style="padding: 1rem 1.5rem; color: #6b7280; font-weight: 700; font-size: 12px; text-transform: uppercase; text-align: right;">Value</th>
                                    <th style="padding: 1rem 1.5rem; color: #6b7280; font-weight: 700; font-size: 12px; text-transform: uppercase; text-align: center;">Status</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($topProducts as $index => $inv)
                                    <tr style="transition: all 0.2s;" onmouseover="this.style.backgroundColor='#f8fafc'" onmouseout="this.style.backgroundColor='transparent'">
                                        <td style="padding: 1rem 1.5rem; border-bottom: 1px solid #f1f5f9;">
                                            <div style="width: 32px; height: 32px; border-radius: 50%; background: {{ $index == 0 ? '#fbbf24' : ($index == 1 ? '#94a3b8' : ($index == 2 ? '#fb923c' : '#e2e8f0')) }}; display: flex; align-items: center; justify-content: center; color: {{ $index < 3 ? '#ffffff' : '#1a202c' }}; font-weight: 700; font-size: 14px;">
                                                {{ $index + 1 }}
                                            </div>
                                        </td>
                                        <td style="padding: 1rem 1.5rem; border-bottom: 1px solid #f1f5f9;">
                                            <div class="d-flex align-items-center">
                                                @if($inv->product->image)
                                                    <img src="{{ asset('storage/' . $inv->product->image) }}" alt="{{ $inv->product->name }}" style="width: 40px; height: 40px; object-fit: cover; border-radius: 8px; margin-right: 10px;">
                                                @endif
                                                <div>
                                                    <div style="color: #1a202c; font-weight: 600; font-size: 14px;">{{ $inv->product->name }}</div>
                                                    <div style="color: #9ca3af; font-size: 12px;">{{ $inv->product->sku }}</div>
                                                </div>
                                            </div>
                                        </td>
                                        <td style="padding: 1rem 1.5rem; border-bottom: 1px solid #f1f5f9; text-align: center;">
                                            <span style="color: #10b981; font-weight: 700; font-size: 16px;">{{ $inv->quantity }}</span>
                                        </td>
                                        <td style="padding: 1rem 1.5rem; border-bottom: 1px solid #f1f5f9; text-align: right;">
                                            <span style="color: #1a202c; font-weight: 700; font-size: 15px;">${{ number_format($inv->quantity * ($inv->product->regular_price ?? 0), 0) }}</span>
                                        </td>
                                        <td style="padding: 1rem 1.5rem; border-bottom: 1px solid #f1f5f9; text-align: center;">
                                            <span class="badge" style="background: {{ $inv->isOutOfStock() ? '#ef4444' : ($inv->isLowStock() ? '#f59e0b' : '#10b981') }}; color: #ffffff; font-size: 11px; padding: 4px 12px;">
                                                {{ $inv->getStockStatus() }}
                                            </span>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>

        <!-- Right Column - Stats & Actions -->
        <div class="col-lg-4">
            <!-- Performance Metrics -->
            <div class="card mb-4" style="border: none; border-radius: 16px; box-shadow: 0 4px 6px rgba(0,0,0,0.07);">
                <div class="card-header" style="background: linear-gradient(135deg, #f59e0b 0%, #d97706 100%); border: none; border-radius: 16px 16px 0 0; padding: 1.5rem;">
                    <h5 class="mb-0" style="color: #ffffff; font-weight: 700; font-size: 16px;">
                        <i class="bi bi-speedometer2 me-2"></i>Performance Metrics
                    </h5>
                </div>
                <div class="card-body" style="padding: 1.5rem;">
                    @php
                        $maxCapacity = 10000;
                        $utilization = min(100, ($totalQuantity / $maxCapacity) * 100);
                    @endphp
                    
                    <div class="mb-4">
                        <div class="d-flex justify-content-between mb-2">
                            <span style="color: #6b7280; font-size: 13px; font-weight: 600;">Capacity Utilization</span>
                            <span style="color: #1a202c; font-weight: 700; font-size: 14px;">{{ number_format($utilization, 1) }}%</span>
                        </div>
                        <div class="progress" style="height: 10px; background: #e2e8f0; border-radius: 10px;">
                            <div class="progress-bar" style="background: linear-gradient(90deg, {{ $utilization > 80 ? '#ef4444, #dc2626' : ($utilization > 50 ? '#f59e0b, #d97706' : '#10b981, #059669') }}); width: {{ $utilization }}%; border-radius: 10px;"></div>
                        </div>
                        <small style="color: #9ca3af; font-size: 11px;">{{ number_format($totalQuantity) }} / {{ number_format($maxCapacity) }} units</small>
                    </div>

                    <div class="mb-4">
                        <div class="d-flex justify-content-between mb-2">
                            <span style="color: #6b7280; font-size: 13px; font-weight: 600;">Stock Health</span>
                            @php
                                $healthScore = 100 - (($lowStockItems + $outOfStockItems * 2) / max($warehouseInventory->count(), 1) * 100);
                            @endphp
                            <span style="color: {{ $healthScore > 80 ? '#10b981' : ($healthScore > 60 ? '#f59e0b' : '#ef4444') }}; font-weight: 700; font-size: 14px;">
                                {{ number_format($healthScore, 0) }}%
                            </span>
                        </div>
                        <div class="progress" style="height: 10px; background: #e2e8f0; border-radius: 10px;">
                            <div class="progress-bar" style="background: linear-gradient(90deg, {{ $healthScore > 80 ? '#10b981, #059669' : ($healthScore > 60 ? '#f59e0b, #d97706' : '#ef4444, #dc2626') }}); width: {{ $healthScore }}%; border-radius: 10px;"></div>
                        </div>
                        <small style="color: #9ca3af; font-size: 11px;">{{ $lowStockItems }} low stock • {{ $outOfStockItems }} out of stock</small>
                    </div>

                    <div class="alert alert-info mb-0" style="background: #f0f9ff; border: 1px solid #bae6fd; border-radius: 10px; padding: 1rem;">
                        <i class="bi bi-info-circle me-2" style="color: #0369a1;"></i>
                        <strong style="color: #0c4a6e; font-size: 13px;">Current Performance</strong>
                        <p class="mb-0" style="color: #0369a1; font-size: 12px; margin-top: 4px;">
                            This warehouse is operating at {{ number_format($utilization, 1) }}% capacity with {{ number_format($healthScore, 0) }}% stock health.
                        </p>
                    </div>
                </div>
            </div>

            <!-- Quick Actions -->
            <div class="card" style="border: none; border-radius: 16px; box-shadow: 0 4px 6px rgba(0,0,0,0.07);">
                <div class="card-body" style="padding: 1.5rem;">
                    <h6 style="color: #1a202c; font-weight: 700; font-size: 14px; margin-bottom: 1rem;">Quick Actions</h6>
                    <div class="d-grid gap-2">
                        <a href="{{ route('admin.warehouses.inventory', $warehouse) }}" class="btn btn-success">
                            <i class="bi bi-box-seam me-2"></i>Manage Inventory
                        </a>
                        <a href="{{ route('admin.warehouses.edit', $warehouse) }}" class="btn btn-outline-primary">
                            <i class="bi bi-pencil me-2"></i>Edit Warehouse
                        </a>
                        <button onclick="generateReport()" class="btn btn-outline-info">
                            <i class="bi bi-file-earmark-pdf me-2"></i>Generate Report
                        </button>
                        <button onclick="window.print()" class="btn btn-outline-secondary">
                            <i class="bi bi-printer me-2"></i>Print Details
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
function generateReport() {
    alert('Generating warehouse report...\nThis feature will be implemented soon!');
}
</script>

<style>
@media print {
    .btn, .card-header, nav, footer {
        display: none !important;
    }
}
</style>

@endsection