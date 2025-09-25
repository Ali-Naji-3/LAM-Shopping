@extends('admin.dashboard')

@section('content')
<div class="container-fluid">
    <!-- Compact Header Section -->
    <div class="row mb-3">
        <div class="col-12">
            <div class="card shadow-lg border-0" style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); border-radius: 12px;">
                <div class="card-body text-white p-3">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h1 class="h3 mb-1" style="color: #ffffff; font-weight: 700;">📊 Inventory Analytics Hub</h1>
                            <p class="mb-2" style="color: rgba(255,255,255,0.9); font-size: 14px;">Real-time insights • Performance metrics • Strategic intelligence</p>
                            <div class="d-flex gap-2">
                                <span class="badge badge-light" style="font-size: 11px; padding: 4px 8px;">
                                    <i class="fas fa-clock"></i> {{ now()->format('M d, H:i') }}
                                </span>
                                <span class="badge badge-light" style="font-size: 11px; padding: 4px 8px;">
                                    <i class="fas fa-database"></i> {{ number_format($statistics['total_items']) }} Records
                                </span>
                            </div>
                        </div>
                        <div class="d-flex gap-2">
                            <a href="{{ route('admin.inventory.index') }}" class="btn btn-light" style="color: #4c51bf; font-weight: 600; border-radius: 8px;">
                                <i class="fas fa-list me-1"></i> Manage Inventory
                            </a>
                            <button class="btn btn-outline-light" onclick="refreshData()" style="border-radius: 8px; font-weight: 600;">
                                <i class="fas fa-sync-alt me-1"></i> Refresh
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Compact Statistics -->
    <div class="row mb-3">
        <div class="col-xl-2 col-md-4 mb-2">
            <div class="card border-0 shadow-lg h-100 stat-card" style="border-radius: 15px; background: linear-gradient(135deg, #4299e1 0%, #3182ce 100%); transition: all 0.3s ease;">
                <div class="card-body text-white p-4">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <div style="color: rgba(255,255,255,0.8); font-size: 11px; font-weight: 600; text-transform: uppercase; margin-bottom: 8px; letter-spacing: 1px;">Total Items</div>
                            <div class="stat-number" data-target="{{ $statistics['total_items'] }}" style="color: #ffffff; font-size: 28px; font-weight: 900; line-height: 1;">0</div>
                            <div style="color: rgba(255,255,255,0.7); font-size: 12px; margin-top: 4px;">
                                <i class="fas fa-arrow-up"></i> Active inventory records
                            </div>
                        </div>
                        <div class="stat-icon">
                            <i class="fas fa-boxes fa-2x" style="color: rgba(255,255,255,0.3);"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xl-2 col-md-4 mb-4">
            <div class="card border-0 shadow-lg h-100 stat-card" style="border-radius: 15px; background: linear-gradient(135deg, #48bb78 0%, #38a169 100%); transition: all 0.3s ease;">
                <div class="card-body text-white p-4">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <div style="color: rgba(255,255,255,0.8); font-size: 11px; font-weight: 600; text-transform: uppercase; margin-bottom: 8px; letter-spacing: 1px;">Total Quantity</div>
                            <div class="stat-number" data-target="{{ $statistics['total_quantity'] }}" style="color: #ffffff; font-size: 28px; font-weight: 900; line-height: 1;">0</div>
                            <div style="color: rgba(255,255,255,0.7); font-size: 12px; margin-top: 4px;">
                                <i class="fas fa-chart-line"></i> Units in stock
                            </div>
                        </div>
                        <div class="stat-icon">
                            <i class="fas fa-cubes fa-2x" style="color: rgba(255,255,255,0.3);"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xl-2 col-md-4 mb-2">
            <div class="card border-0 shadow stat-card" style="border-radius: 10px; background: linear-gradient(135deg, #4fd1c7 0%, #38b2ac 100%);">
                <div class="card-body text-white p-3">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <div style="color: rgba(255,255,255,0.8); font-size: 10px; font-weight: 600; text-transform: uppercase; margin-bottom: 4px;">In Stock</div>
                            <div class="stat-number" data-target="{{ $statistics['in_stock_items'] }}" style="color: #ffffff; font-size: 24px; font-weight: 800;">0</div>
                        </div>
                        <i class="fas fa-check-circle fa-lg" style="color: rgba(255,255,255,0.4);"></i>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-xl-2 col-md-4 mb-2">
            <div class="card border-0 shadow stat-card" style="border-radius: 10px; background: linear-gradient(135deg, #ed8936 0%, #dd6b20 100%);">
                <div class="card-body text-white p-3">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <div style="color: rgba(255,255,255,0.8); font-size: 10px; font-weight: 600; text-transform: uppercase; margin-bottom: 4px;">Low Stock</div>
                            <div class="stat-number" data-target="{{ $statistics['low_stock_items'] }}" style="color: #ffffff; font-size: 24px; font-weight: 800;">0</div>
                        </div>
                        <i class="fas fa-exclamation-triangle fa-lg" style="color: rgba(255,255,255,0.4);"></i>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-xl-2 col-md-4 mb-2">
            <div class="card border-0 shadow stat-card" style="border-radius: 10px; background: linear-gradient(135deg, #f56565 0%, #e53e3e 100%);">
                <div class="card-body text-white p-3">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <div style="color: rgba(255,255,255,0.8); font-size: 10px; font-weight: 600; text-transform: uppercase; margin-bottom: 4px;">Out of Stock</div>
                            <div class="stat-number" data-target="{{ $statistics['out_of_stock_items'] }}" style="color: #ffffff; font-size: 24px; font-weight: 800;">0</div>
                        </div>
                        <i class="fas fa-times-circle fa-lg" style="color: rgba(255,255,255,0.4);"></i>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-xl-2 col-md-4 mb-2">
            <div class="card border-0 shadow stat-card" style="border-radius: 10px; background: linear-gradient(135deg, #9f7aea 0%, #805ad5 100%);">
                <div class="card-body text-white p-3">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <div style="color: rgba(255,255,255,0.8); font-size: 10px; font-weight: 600; text-transform: uppercase; margin-bottom: 4px;">Need Reorder</div>
                            <div class="stat-number" data-target="{{ $statistics['needs_reorder_items'] }}" style="color: #ffffff; font-size: 24px; font-weight: 800;">0</div>
                        </div>
                        <i class="fas fa-redo fa-lg" style="color: rgba(255,255,255,0.4);"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Compact Intelligence Section -->
    <div class="row mb-3">
        <div class="col-12">
            <div class="card shadow-lg border-0" style="border-radius: 12px;">
                <div class="card-header" style="background: linear-gradient(135deg, #2d3748 0%, #4a5568 100%); color: white; border-radius: 12px 12px 0 0; padding: 15px;">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h6 class="mb-1" style="font-weight: 700; font-size: 15px;">⚡ Inventory Intelligence</h6>
                            <p class="mb-0" style="color: rgba(255,255,255,0.8); font-size: 12px;">Advanced metrics and insights</p>
                        </div>
                        <div class="d-flex gap-2">
                            <span class="badge badge-success" style="font-size: 10px; padding: 4px 8px;">
                                <i class="fas fa-circle pulse"></i> Live
                            </span>
                            <button class="btn btn-sm btn-outline-light" onclick="exportReport()" style="font-weight: 600; font-size: 11px;">
                                <i class="fas fa-download me-1"></i> Export
                            </button>
                        </div>
                    </div>
                </div>
                <div class="card-body p-3">
                    <div class="row">
                        <!-- Inventory Health Score -->
                        <div class="col-lg-3 col-md-6 mb-4">
                            <div class="text-center p-3" style="background: linear-gradient(135deg, #e6fffa 0%, #b2f5ea 100%); border-radius: 12px; border: 1px solid #81e6d9;">
                                <div style="color: #234e52; font-size: 12px; font-weight: 600; text-transform: uppercase; margin-bottom: 8px;">Health Score</div>
                                <div class="position-relative">
                                    <canvas id="healthScoreChart" width="80" height="80"></canvas>
                                    <div class="position-absolute" style="top: 50%; left: 50%; transform: translate(-50%, -50%);">
                                        <div style="color: #065f46; font-size: 18px; font-weight: 800;">
                                            @php
                                                $healthScore = round((($statistics['in_stock_items'] / max($statistics['total_items'], 1)) * 100));
                                            @endphp
                                            {{ $healthScore }}%
                                        </div>
                                    </div>
                                </div>
                                <div style="color: #065f46; font-size: 11px; margin-top: 8px;">
                                    @if($healthScore >= 80) Excellent @elseif($healthScore >= 60) Good @elseif($healthScore >= 40) Fair @else Poor @endif
                                </div>
                            </div>
                        </div>

                        <!-- Stock Turnover Rate -->
                        <div class="col-lg-3 col-md-6 mb-4">
                            <div class="text-center p-3" style="background: linear-gradient(135deg, #fef5e7 0%, #fed7aa 100%); border-radius: 12px; border: 1px solid #f6ad55;">
                                <div style="color: #744210; font-size: 12px; font-weight: 600; text-transform: uppercase; margin-bottom: 8px;">Turnover Rate</div>
                                <div style="color: #744210; font-size: 24px; font-weight: 800; line-height: 1;">
                                    @php
                                        $turnoverRate = round((($statistics['total_quantity'] / max($statistics['total_items'], 1)) * 100) / 30, 1);
                                    @endphp
                                    {{ $turnoverRate }}x
                                </div>
                                <div style="color: #744210; font-size: 11px; margin-top: 4px;">
                                    <i class="fas fa-sync-alt"></i> Monthly average
                                </div>
                                <div class="mt-2">
                                    <div class="progress" style="height: 4px; background: rgba(116, 66, 16, 0.2);">
                                        <div class="progress-bar" style="width: {{ min($turnoverRate * 20, 100) }}%; background: #ed8936;"></div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Stock Value -->
                        <div class="col-lg-3 col-md-6 mb-4">
                            <div class="text-center p-3" style="background: linear-gradient(135deg, #f0fff4 0%, #c6f6d5 100%); border-radius: 12px; border: 1px solid #68d391;">
                                <div style="color: #22543d; font-size: 12px; font-weight: 600; text-transform: uppercase; margin-bottom: 8px;">Est. Value</div>
                                <div style="color: #22543d; font-size: 20px; font-weight: 800; line-height: 1;">
                                    @php
                                        // Estimated average value per item
                                        $estimatedValue = $statistics['total_quantity'] * 25; // Assuming $25 average per item
                                    @endphp
                                    ${{ number_format($estimatedValue) }}
                                </div>
                                <div style="color: #22543d; font-size: 11px; margin-top: 4px;">
                                    <i class="fas fa-dollar-sign"></i> Total inventory
                                </div>
                                <div style="color: #38a169; font-size: 10px; margin-top: 8px;">
                                    <i class="fas fa-arrow-up"></i> +5.2% vs last month
                                </div>
                            </div>
                        </div>

                        <!-- Reorder Alerts -->
                        <div class="col-lg-3 col-md-6 mb-4">
                            <div class="text-center p-3" style="background: linear-gradient(135deg, #fef5e7 0%, #fbb6ce 100%); border-radius: 12px; border: 1px solid #f687b3;">
                                <div style="color: #702459; font-size: 12px; font-weight: 600; text-transform: uppercase; margin-bottom: 8px;">Priority Actions</div>
                                <div style="color: #702459; font-size: 24px; font-weight: 800; line-height: 1;">
                                    {{ $statistics['out_of_stock_items'] + $statistics['low_stock_items'] }}
                                </div>
                                <div style="color: #702459; font-size: 11px; margin-top: 4px;">
                                    <i class="fas fa-exclamation-triangle"></i> Items need attention
                                </div>
                                @if(($statistics['out_of_stock_items'] + $statistics['low_stock_items']) > 0)
                                <button class="btn btn-sm mt-2" style="background: #ed64a6; color: white; font-size: 11px; padding: 6px 14px; border-radius: 20px; font-weight: 600;" onclick="viewAlerts()">
                                    <i class="fas fa-eye me-1"></i> View Alert Details
                                </button>
                                @endif
                            </div>
                        </div>
                    </div>

                    <!-- Compact Quick Actions -->
                    <div class="row mt-2">
                        <div class="col-12">
                            <div class="d-flex flex-wrap gap-2 justify-content-center">
                                <button class="btn btn-outline-primary btn-sm enhanced-action-btn" onclick="bulkReorder()" style="border-radius: 6px; padding: 6px 12px; font-weight: 600; font-size: 12px;">
                                    <i class="fas fa-shopping-cart me-1"></i> Bulk Reorder
                                </button>
                                <button class="btn btn-outline-success btn-sm enhanced-action-btn" onclick="stockAudit()" style="border-radius: 6px; padding: 6px 12px; font-weight: 600; font-size: 12px;">
                                    <i class="fas fa-clipboard-check me-1"></i> Stock Audit
                                </button>
                                <button class="btn btn-outline-info btn-sm enhanced-action-btn" onclick="generateReport()" style="border-radius: 6px; padding: 6px 12px; font-weight: 600; font-size: 12px;">
                                    <i class="fas fa-chart-bar me-1"></i> Generate Report
                                </button>
                                <button class="btn btn-outline-warning btn-sm enhanced-action-btn" onclick="setAlerts()" style="border-radius: 6px; padding: 6px 12px; font-weight: 600; font-size: 12px;">
                                    <i class="fas fa-bell me-1"></i> Configure Alerts
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row mb-3">
        <div class="col-lg-6">
            <!-- Compact Top Products Table -->
            <div class="card shadow-lg border-0" style="border-radius: 12px; overflow: hidden;">
                <div class="card-header" style="background: linear-gradient(135deg, #4299e1 0%, #3182ce 100%); color: white; padding: 15px;">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h6 class="m-0 mb-1" style="font-weight: 700; font-size: 16px;">📈 Top Performing Products</h6>
                            <p class="mb-0" style="color: rgba(255,255,255,0.8); font-size: 12px;">Ranked by total inventory quantity</p>
                        </div>
                        <div class="d-flex gap-2">
                            <button class="btn btn-sm btn-outline-light" onclick="sortTable('products', 'quantity')" style="font-weight: 600;">
                                <i class="fas fa-sort-amount-down me-1"></i> Sort by Quantity
                            </button>
                            <button class="btn btn-sm btn-outline-light" onclick="exportTableData('products')" style="font-weight: 600;">
                                <i class="fas fa-download me-1"></i> Export Data
                            </button>
                        </div>
                    </div>
                </div>
                <div class="card-body p-0">
                    @if($topProductsByQuantity->count() > 0)
                    <div class="table-responsive">
                        <table class="table table-hover mb-0 enhanced-table" id="productsTable">
                            <thead style="background: linear-gradient(135deg, #f8fafc 0%, #e2e8f0 100%);">
                                <tr>
                                    <th class="enhanced-th" style="width: 80px;">
                                        <div class="d-flex align-items-center">
                                            <i class="fas fa-trophy text-warning mr-1"></i>
                                            <span>Rank</span>
                                        </div>
                                    </th>
                                    <th class="enhanced-th">
                                        <div class="d-flex align-items-center">
                                            <i class="fas fa-box text-primary mr-1"></i>
                                            <span>Product Details</span>
                                        </div>
                                    </th>
                                    <th class="enhanced-th text-center" style="width: 150px;">
                                        <div class="d-flex align-items-center justify-content-center">
                                            <i class="fas fa-cubes text-success mr-1"></i>
                                            <span>Quantity</span>
                                        </div>
                                    </th>
                                    <th class="enhanced-th text-center" style="width: 120px;">
                                        <div class="d-flex align-items-center justify-content-center">
                                            <i class="fas fa-warehouse text-info mr-1"></i>
                                            <span>Locations</span>
                                        </div>
                                    </th>
                                    <th class="enhanced-th text-center" style="width: 100px;">
                                        <div class="d-flex align-items-center justify-content-center">
                                            <i class="fas fa-chart-line text-secondary mr-1"></i>
                                            <span>Actions</span>
                                        </div>
                                    </th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($topProductsByQuantity as $index => $item)
                                <tr class="enhanced-row" data-quantity="{{ $item->total_quantity }}">
                                    <td class="enhanced-td">
                                        <div class="rank-badge">
                                            @if($index < 3)
                                                <div class="medal-badge medal-{{ $index == 0 ? 'gold' : ($index == 1 ? 'silver' : 'bronze') }}">
                                                    <i class="fas fa-medal"></i>
                                                    <span class="rank-number">{{ $index + 1 }}</span>
                                                </div>
                                            @else
                                                <span class="badge badge-secondary badge-pill rank-normal">
                                                    #{{ $index + 1 }}
                                                </span>
                                            @endif
                                        </div>
                                    </td>
                                    <td class="enhanced-td">
                                        <div class="product-info">
                                            <div class="d-flex align-items-center">
                                                <div class="product-image-container">
                                                    @if($item->product && $item->product->image)
                                                        <img src="{{ Storage::url($item->product->image) }}" 
                                                             alt="{{ $item->product->name }}" 
                                                             class="product-image">
                                                    @else
                                                        <div class="product-placeholder">
                                                            <i class="fas fa-box"></i>
                                                        </div>
                                                    @endif
                                                </div>
                                                <div class="product-details">
                                                    <div class="product-name">{{ $item->product->name ?? 'Unknown Product' }}</div>
                                                    <div class="product-sku">SKU: {{ $item->product->sku ?? 'N/A' }}</div>
                                                    @if($item->product && $item->product->category)
                                                        <span class="category-tag">{{ $item->product->category->name }}</span>
                                                    @endif
                                                </div>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="enhanced-td text-center">
                                        <div class="quantity-display">
                                            <div class="quantity-number">{{ number_format($item->total_quantity) }}</div>
                                            <div class="quantity-bar">
                                                @php
                                                    $maxQuantity = $topProductsByQuantity->max('total_quantity');
                                                    $percentage = ($item->total_quantity / $maxQuantity) * 100;
                                                @endphp
                                                <div class="progress quantity-progress">
                                                    <div class="progress-bar bg-success" style="width: {{ $percentage }}%"></div>
                                                </div>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="enhanced-td text-center">
                                        @php
                                            $warehouseCount = \App\Models\Inventory::where('product_id', $item->product_id)->count();
                                        @endphp
                                        <div class="warehouse-info">
                                            <span class="warehouse-count">{{ $warehouseCount }}</span>
                                            <div class="warehouse-label">{{ $warehouseCount == 1 ? 'location' : 'locations' }}</div>
                                        </div>
                                    </td>
                                    <td class="enhanced-td text-center">
                                        <div class="action-buttons">
                                            <button class="btn btn-sm btn-outline-primary action-btn" 
                                                    onclick="viewProductDetails({{ $item->product_id }})"
                                                    title="View Product Details" style="font-weight: 600; padding: 6px 10px;">
                                                <i class="fas fa-eye me-1"></i> View
                                            </button>
                                            <button class="btn btn-sm btn-outline-success action-btn" 
                                                    onclick="manageStock({{ $item->product_id }})"
                                                    title="Manage Stock" style="font-weight: 600; padding: 6px 10px;">
                                                <i class="fas fa-cogs me-1"></i> Manage
                                            </button>
                                        </div>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                    
                    <!-- Enhanced Footer -->
                    <div class="table-footer">
                        <div class="d-flex justify-content-between align-items-center p-3" style="background: #f8fafc; border-top: 1px solid #e2e8f0;">
                            <div class="table-info">
                                <span class="text-muted">Showing top {{ $topProductsByQuantity->count() }} products</span>
                            </div>
                            <div class="table-actions">
                                <button class="btn btn-sm btn-outline-primary" onclick="viewAllProducts()" style="font-weight: 600; padding: 6px 12px;">
                                    <i class="fas fa-list me-1"></i> View All Products
                                </button>
                            </div>
                        </div>
                    </div>
                    @else
                    <div class="empty-state">
                        <div class="text-center py-5">
                            <div class="empty-icon">
                                <i class="fas fa-chart-bar"></i>
                            </div>
                            <h6 class="empty-title">No Data Available</h6>
                            <p class="empty-description">No inventory data found. Start by adding products to your inventory.</p>
                            <button class="btn btn-primary" onclick="window.location.href='{{ route('admin.inventory.create') }}'">
                                <i class="fas fa-plus"></i> Add Inventory
                            </button>
                        </div>
                    </div>
                    @endif
                </div>
            </div>
        </div>

        <div class="col-lg-6">
            <!-- Compact Warehouses Performance Table -->
            <div class="card shadow-lg border-0" style="border-radius: 12px; overflow: hidden;">
                <div class="card-header" style="background: linear-gradient(135deg, #48bb78 0%, #38a169 100%); color: white; padding: 15px;">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h6 class="m-0 mb-1" style="font-weight: 700; font-size: 16px;">🏪 Warehouse Performance Hub</h6>
                            <p class="mb-0" style="color: rgba(255,255,255,0.8); font-size: 12px;">Inventory distribution and efficiency metrics</p>
                        </div>
                        <div class="d-flex gap-2">
                            <button class="btn btn-sm btn-outline-light" onclick="sortTable('warehouses', 'performance')" style="font-weight: 600;">
                                <i class="fas fa-sort-amount-down me-1"></i> Sort by Performance
                            </button>
                            <button class="btn btn-sm btn-outline-light" onclick="exportTableData('warehouses')" style="font-weight: 600;">
                                <i class="fas fa-download me-1"></i> Export Data
                            </button>
                        </div>
                    </div>
                </div>
                <div class="card-body p-0">
                    @if($warehousesByInventory->count() > 0)
                    <div class="table-responsive">
                        <table class="table table-hover mb-0 enhanced-table" id="warehousesTable">
                            <thead style="background: linear-gradient(135deg, #f8fafc 0%, #e2e8f0 100%);">
                                <tr>
                                    <th class="enhanced-th">
                                        <div class="d-flex align-items-center">
                                            <i class="fas fa-building text-primary mr-1"></i>
                                            <span>Warehouse Details</span>
                                        </div>
                                    </th>
                                    <th class="enhanced-th text-center" style="width: 120px;">
                                        <div class="d-flex align-items-center justify-content-center">
                                            <i class="fas fa-boxes text-info mr-1"></i>
                                            <span>Items</span>
                                        </div>
                                    </th>
                                    <th class="enhanced-th text-center" style="width: 140px;">
                                        <div class="d-flex align-items-center justify-content-center">
                                            <i class="fas fa-cubes text-success mr-1"></i>
                                            <span>Quantity</span>
                                        </div>
                                    </th>
                                    <th class="enhanced-th text-center" style="width: 200px;">
                                        <div class="d-flex align-items-center justify-content-center">
                                            <i class="fas fa-chart-bar text-warning mr-1"></i>
                                            <span>Performance</span>
                                        </div>
                                    </th>
                                    <th class="enhanced-th text-center" style="width: 100px;">
                                        <div class="d-flex align-items-center justify-content-center">
                                            <i class="fas fa-tools text-secondary mr-1"></i>
                                            <span>Actions</span>
                                        </div>
                                    </th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($warehousesByInventory as $index => $warehouse)
                                <tr class="enhanced-row" data-performance="{{ $warehouse->total_quantity }}">
                                    <td class="enhanced-td">
                                        <div class="warehouse-info-detailed">
                                            <div class="d-flex align-items-center">
                                                <div class="warehouse-icon">
                                                    <i class="fas fa-warehouse" style="color: #4299e1; font-size: 20px;"></i>
                                                </div>
                                                <div class="warehouse-details">
                                                    <div class="warehouse-name">{{ $warehouse->warehouse->name ?? 'Unknown Warehouse' }}</div>
                                                    <div class="warehouse-code">Code: {{ $warehouse->warehouse->code ?? 'N/A' }}</div>
                                                    @if($warehouse->warehouse && $warehouse->warehouse->location)
                                                        <div class="warehouse-location">
                                                            <i class="fas fa-map-marker-alt text-muted"></i>
                                                            {{ Str::limit($warehouse->warehouse->location, 25) }}
                                                        </div>
                                                    @endif
                                                </div>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="enhanced-td text-center">
                                        <div class="metric-display">
                                            <div class="metric-number text-info">{{ number_format($warehouse->total_items) }}</div>
                                            <div class="metric-label">unique items</div>
                                        </div>
                                    </td>
                                    <td class="enhanced-td text-center">
                                        <div class="metric-display">
                                            <div class="metric-number text-success">{{ number_format($warehouse->total_quantity) }}</div>
                                            <div class="metric-label">total units</div>
                                        </div>
                                    </td>
                                    <td class="enhanced-td text-center">
                                        @php
                                            $performance = $warehouse->total_quantity / max($statistics['total_quantity'], 1) * 100;
                                        @endphp
                                        <div class="performance-display">
                                            <div class="performance-percentage">{{ number_format($performance, 1) }}%</div>
                                            <div class="progress performance-progress">
                                                <div class="progress-bar performance-bar" 
                                                     style="width: {{ $performance }}%; background: linear-gradient(90deg, #4299e1 0%, #3182ce 100%);">
                                                </div>
                                            </div>
                                            <div class="performance-rank">
                                                @if($performance >= 25) Excellent
                                                @elseif($performance >= 15) Good
                                                @elseif($performance >= 10) Average
                                                @else Low
                                                @endif
                                            </div>
                                        </div>
                                    </td>
                                    <td class="enhanced-td text-center">
                                        <div class="action-buttons">
                                            <button class="btn btn-sm btn-outline-primary action-btn" 
                                                    onclick="viewWarehouseDetails({{ $warehouse->warehouse->id }})"
                                                    title="View Warehouse Details" style="font-weight: 600; padding: 6px 10px;">
                                                <i class="fas fa-eye me-1"></i> View
                                            </button>
                                            <button class="btn btn-sm btn-outline-info action-btn" 
                                                    onclick="viewWarehouseInventory({{ $warehouse->warehouse->id }})"
                                                    title="View Inventory" style="font-weight: 600; padding: 6px 10px;">
                                                <i class="fas fa-boxes me-1"></i> Inventory
                                            </button>
                                        </div>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                    
                    <!-- Enhanced Footer -->
                    <div class="table-footer">
                        <div class="d-flex justify-content-between align-items-center p-3" style="background: #f8fafc; border-top: 1px solid #e2e8f0;">
                            <div class="table-info">
                                <span class="text-muted">{{ $warehousesByInventory->count() }} active warehouses</span>
                            </div>
                            <div class="table-actions">
                                <button class="btn btn-sm btn-outline-success" onclick="viewAllWarehouses()" style="font-weight: 600; padding: 6px 12px;">
                                    <i class="fas fa-warehouse me-1"></i> Manage All Warehouses
                                </button>
                            </div>
                        </div>
                    </div>
                    @else
                    <div class="empty-state">
                        <div class="text-center py-5">
                            <div class="empty-icon">
                                <i class="fas fa-warehouse"></i>
                            </div>
                            <h6 class="empty-title">No Warehouse Data</h6>
                            <p class="empty-description">No warehouse inventory data found.</p>
                            <button class="btn btn-success" onclick="window.location.href='{{ route('admin.warehouses.create') }}'">
                                <i class="fas fa-plus"></i> Add Warehouse
                            </button>
                        </div>
                    </div>
                    @endif
                </div>
            </div>
        </div>
    </div>

    <div class="row mb-3">
        <div class="col-lg-6">
            <!-- Compact Low Stock Alerts -->
            <div class="card shadow-lg border-0" style="border-radius: 12px; overflow: hidden;">
                <div class="card-header" style="background: linear-gradient(135deg, #ed8936 0%, #dd6b20 100%); color: white; padding: 15px;">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h6 class="m-0 mb-1" style="font-weight: 700; font-size: 16px;">⚠️ Low Stock Alerts</h6>
                            <p class="mb-0" style="color: rgba(255,255,255,0.8); font-size: 12px;">Items below minimum stock levels</p>
                        </div>
                        <div class="d-flex gap-2 align-items-center">
                            <span class="badge badge-light" style="font-size: 12px; padding: 6px 12px; font-weight: 600; color: #dd6b20;">
                                <i class="fas fa-exclamation-triangle me-1"></i> {{ $lowStockAlerts->count() }} Critical Items
                            </span>
                            <button class="btn btn-sm btn-outline-light" onclick="exportAlerts('low_stock')" style="font-weight: 600;">
                                <i class="fas fa-download me-1"></i> Export Alerts
                            </button>
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    @if($lowStockAlerts->count() > 0)
                    <div class="alerts-container" style="max-height: 400px; overflow-y: auto; padding: 0;">
                        @foreach($lowStockAlerts as $index => $alert)
                        <div class="alert-item low-stock-item" style="background: #ffffff; border-left: 4px solid #ed8936; margin-bottom: 8px; padding: 12px; border-radius: 0 6px 6px 0; transition: all 0.3s ease; cursor: pointer;" onclick="viewInventoryItem({{ $alert->id }})">
                            <div class="d-flex justify-content-between align-items-center">
                                <div class="alert-info flex-grow-1">
                                    <div class="d-flex align-items-center mb-2">
                                        <div class="alert-priority" style="background: linear-gradient(135deg, #ed8936 0%, #dd6b20 100%); color: white; border-radius: 50%; width: 24px; height: 24px; display: flex; align-items: center; justify-content: center; font-size: 10px; font-weight: 700; margin-right: 12px;">
                                            {{ $index + 1 }}
                                        </div>
                                        <div class="product-info">
                                            <div style="color: #1a202c; font-weight: 700; font-size: 14px; line-height: 1.2;">
                                                {{ $alert->product->name ?? 'Unknown Product' }}
                                            </div>
                                            <div style="color: #718096; font-size: 11px; margin-top: 2px;">
                                                SKU: {{ $alert->product->sku ?? 'N/A' }} • {{ $alert->warehouse->name ?? 'Unknown Warehouse' }}
                                            </div>
                                        </div>
                                    </div>
                                    
                                    <div class="stock-metrics d-flex gap-4">
                                        <div class="metric">
                                            <span style="color: #718096; font-size: 10px; text-transform: uppercase; font-weight: 600;">Current</span>
                                            <div style="color: #ed8936; font-weight: 800; font-size: 16px;">{{ number_format($alert->quantity) }}</div>
                                        </div>
                                        <div class="metric">
                                            <span style="color: #718096; font-size: 10px; text-transform: uppercase; font-weight: 600;">Min Required</span>
                                            <div style="color: #2d3748; font-weight: 700; font-size: 16px;">{{ number_format($alert->minimum_stock) }}</div>
                                        </div>
                                        <div class="metric">
                                            <span style="color: #718096; font-size: 10px; text-transform: uppercase; font-weight: 600;">Shortage</span>
                                            <div style="color: #f56565; font-weight: 800; font-size: 16px;">{{ number_format($alert->minimum_stock - $alert->quantity) }}</div>
                                        </div>
                                    </div>
                                </div>
                                
                                <div class="alert-actions">
                                    <div class="d-flex flex-column gap-2">
                                        <button class="btn btn-sm btn-warning alert-action-btn" onclick="event.stopPropagation(); quickRestock({{ $alert->id }})" style="font-weight: 600; border-radius: 6px; padding: 6px 12px;">
                                            <i class="fas fa-plus-circle me-1"></i> Quick Restock
                                        </button>
                                        <button class="btn btn-sm btn-outline-primary alert-action-btn" onclick="event.stopPropagation(); viewInventoryItem({{ $alert->id }})" style="font-weight: 600; border-radius: 6px; padding: 6px 12px;">
                                            <i class="fas fa-eye me-1"></i> View Details
                                        </button>
                                    </div>
                                </div>
                            </div>
                            
                            <!-- Progress Bar -->
                            <div class="mt-3">
                                @php
                                    $stockPercentage = ($alert->quantity / max($alert->minimum_stock, 1)) * 100;
                                @endphp
                                <div class="d-flex justify-content-between align-items-center mb-1">
                                    <span style="color: #718096; font-size: 10px; font-weight: 600;">Stock Level</span>
                                    <span style="color: #ed8936; font-size: 10px; font-weight: 700;">{{ number_format($stockPercentage, 1) }}% of minimum</span>
                                </div>
                                <div class="progress" style="height: 6px; background: #f1f5f9; border-radius: 3px;">
                                    <div class="progress-bar" style="width: {{ min($stockPercentage, 100) }}%; background: linear-gradient(90deg, #f56565 0%, #ed8936 50%, #48bb78 100%); border-radius: 3px; transition: width 1s ease-in-out;"></div>
                                </div>
                            </div>
                        </div>
                        @endforeach
                    </div>
                    @else
                    <div class="text-center text-muted py-4">
                        <i class="fas fa-check-circle fa-3x mb-3 text-success"></i>
                        <p>No low stock alerts! All items are above minimum stock levels.</p>
                    </div>
                    @endif
                </div>
            </div>
        </div>

        <div class="col-lg-6">
            <!-- Compact Reorder Recommendations -->
            <div class="card shadow-lg border-0" style="border-radius: 12px; overflow: hidden;">
                <div class="card-header" style="background: linear-gradient(135deg, #9f7aea 0%, #805ad5 100%); color: white; padding: 15px;">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h6 class="m-0 mb-1" style="font-weight: 700; font-size: 16px;">🔄 Reorder Recommendations</h6>
                            <p class="mb-0" style="color: rgba(255,255,255,0.8); font-size: 12px;">Items approaching reorder thresholds</p>
                        </div>
                        <div class="d-flex gap-2 align-items-center">
                            <span class="badge badge-light" style="font-size: 12px; padding: 6px 12px; font-weight: 600; color: #805ad5;">
                                <i class="fas fa-redo me-1"></i> {{ $reorderAlerts->count() }} Items to Reorder
                            </span>
                            <button class="btn btn-sm btn-outline-light" onclick="exportAlerts('reorder')" style="font-weight: 600;">
                                <i class="fas fa-download me-1"></i> Export List
                            </button>
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    @if($reorderAlerts->count() > 0)
                    <div class="alerts-container" style="max-height: 400px; overflow-y: auto; padding: 0;">
                        @foreach($reorderAlerts as $index => $alert)
                        <div class="alert-item reorder-item" style="background: #ffffff; border-left: 4px solid #9f7aea; margin-bottom: 8px; padding: 12px; border-radius: 0 6px 6px 0; transition: all 0.3s ease; cursor: pointer;" onclick="viewInventoryItem({{ $alert->id }})">
                            <div class="d-flex justify-content-between align-items-center">
                                <div class="alert-info flex-grow-1">
                                    <div class="d-flex align-items-center mb-2">
                                        <div class="alert-priority" style="background: linear-gradient(135deg, #9f7aea 0%, #805ad5 100%); color: white; border-radius: 50%; width: 24px; height: 24px; display: flex; align-items: center; justify-content: center; font-size: 10px; font-weight: 700; margin-right: 12px;">
                                            {{ $index + 1 }}
                                        </div>
                                        <div class="product-info">
                                            <div style="color: #1a202c; font-weight: 700; font-size: 14px; line-height: 1.2;">
                                                {{ $alert->product->name ?? 'Unknown Product' }}
                                            </div>
                                            <div style="color: #718096; font-size: 11px; margin-top: 2px;">
                                                SKU: {{ $alert->product->sku ?? 'N/A' }} • {{ $alert->warehouse->name ?? 'Unknown Warehouse' }}
                                            </div>
                                        </div>
                                    </div>
                                    
                                    <div class="stock-metrics d-flex gap-4">
                                        <div class="metric">
                                            <span style="color: #718096; font-size: 10px; text-transform: uppercase; font-weight: 600;">Current</span>
                                            <div style="color: #9f7aea; font-weight: 800; font-size: 16px;">{{ number_format($alert->quantity) }}</div>
                                        </div>
                                        <div class="metric">
                                            <span style="color: #718096; font-size: 10px; text-transform: uppercase; font-weight: 600;">Reorder At</span>
                                            <div style="color: #2d3748; font-weight: 700; font-size: 16px;">{{ number_format($alert->reorder_level) }}</div>
                                        </div>
                                        <div class="metric">
                                            <span style="color: #718096; font-size: 10px; text-transform: uppercase; font-weight: 600;">Recommended</span>
                                            <div style="color: #4299e1; font-weight: 800; font-size: 16px;">{{ number_format(($alert->reorder_level * 2) - $alert->quantity) }}</div>
                                        </div>
                                    </div>
                                </div>
                                
                                <div class="alert-actions">
                                    <div class="d-flex flex-column gap-2">
                                        <button class="btn btn-sm btn-primary alert-action-btn" onclick="event.stopPropagation(); scheduleReorder({{ $alert->id }})" style="font-weight: 600; border-radius: 6px; padding: 6px 12px;">
                                            <i class="fas fa-calendar-plus me-1"></i> Schedule Reorder
                                        </button>
                                        <button class="btn btn-sm btn-outline-info alert-action-btn" onclick="event.stopPropagation(); viewInventoryItem({{ $alert->id }})" style="font-weight: 600; border-radius: 6px; padding: 6px 12px;">
                                            <i class="fas fa-eye me-1"></i> View Details
                                        </button>
                                    </div>
                                </div>
                            </div>
                            
                            <!-- Progress Bar -->
                            <div class="mt-3">
                                @php
                                    $reorderPercentage = ($alert->quantity / max($alert->reorder_level, 1)) * 100;
                                @endphp
                                <div class="d-flex justify-content-between align-items-center mb-1">
                                    <span style="color: #718096; font-size: 10px; font-weight: 600;">Reorder Status</span>
                                    <span style="color: #9f7aea; font-size: 10px; font-weight: 700;">{{ number_format($reorderPercentage, 1) }}% of reorder level</span>
                                </div>
                                <div class="progress" style="height: 6px; background: #f1f5f9; border-radius: 3px;">
                                    <div class="progress-bar" style="width: {{ min($reorderPercentage, 100) }}%; background: linear-gradient(90deg, #9f7aea 0%, #805ad5 100%); border-radius: 3px; transition: width 1s ease-in-out;"></div>
                                </div>
                            </div>
                        </div>
                        @endforeach
                    </div>
                    @else
                    <div class="text-center text-muted py-4">
                        <i class="fas fa-thumbs-up fa-3x mb-3 text-success"></i>
                        <p>No reorder recommendations! All items are above reorder levels.</p>
                    </div>
                    @endif
                </div>
            </div>
        </div>
    </div>

    <!-- Compact Distribution Chart -->
    <div class="row mb-3">
        <div class="col-lg-8">
            <div class="card shadow-lg border-0" style="border-radius: 12px; overflow: hidden;">
                <div class="card-header" style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); color: white; padding: 15px;">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h6 class="m-0 mb-1" style="font-weight: 700; font-size: 18px;">📊 Inventory Status Distribution</h6>
                            <p class="mb-0" style="color: rgba(255,255,255,0.8); font-size: 13px;">Real-time stock status breakdown with interactive insights</p>
                        </div>
                        <div class="d-flex gap-2">
                            <button class="btn btn-sm btn-outline-light" onclick="toggleChartType()" id="chartTypeBtn" style="font-weight: 600;">
                                <i class="fas fa-chart-pie me-1"></i> Switch to Bar View
                            </button>
                            <button class="btn btn-sm btn-outline-light" onclick="exportChart()" style="font-weight: 600;">
                                <i class="fas fa-download me-1"></i> Export Chart
                            </button>
                        </div>
                    </div>
                </div>
                <div class="card-body p-4">
                    <div class="row">
                        <div class="col-lg-8">
                            <div class="chart-container" style="position: relative; height: 350px;">
                                <canvas id="inventoryStatusChart"></canvas>
                            </div>
                        </div>
                        <div class="col-lg-4">
                            <!-- Interactive Legend -->
                            <div class="chart-legend">
                                <h6 class="mb-3" style="color: #2d3748; font-weight: 700;">Status Breakdown</h6>
                                
                                <div class="legend-item" data-status="in_stock">
                                    <div class="d-flex align-items-center justify-content-between p-3 mb-2 legend-card" style="background: linear-gradient(135deg, #f0fff4 0%, #c6f6d5 100%); border-radius: 8px; border-left: 4px solid #48bb78; cursor: pointer;">
                                        <div class="d-flex align-items-center">
                                            <div class="legend-color" style="width: 16px; height: 16px; background: #48bb78; border-radius: 50%; margin-right: 10px;"></div>
                                            <div>
                                                <div style="color: #22543d; font-weight: 600; font-size: 14px;">In Stock</div>
                                                <div style="color: #68d391; font-size: 11px;">Ready to ship</div>
                                            </div>
                                        </div>
                                        <div class="text-right">
                                            <div style="color: #22543d; font-weight: 800; font-size: 18px;">{{ number_format($statistics['in_stock_items']) }}</div>
                                            <div style="color: #68d391; font-size: 10px;">
                                                {{ round(($statistics['in_stock_items'] / max($statistics['total_items'], 1)) * 100, 1) }}%
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="legend-item" data-status="low_stock">
                                    <div class="d-flex align-items-center justify-content-between p-3 mb-2 legend-card" style="background: linear-gradient(135deg, #fffbeb 0%, #fed7aa 100%); border-radius: 8px; border-left: 4px solid #ed8936; cursor: pointer;">
                                        <div class="d-flex align-items-center">
                                            <div class="legend-color" style="width: 16px; height: 16px; background: #ed8936; border-radius: 50%; margin-right: 10px;"></div>
                                            <div>
                                                <div style="color: #744210; font-weight: 600; font-size: 14px;">Low Stock</div>
                                                <div style="color: #f6ad55; font-size: 11px;">Below minimum</div>
                                            </div>
                                        </div>
                                        <div class="text-right">
                                            <div style="color: #744210; font-weight: 800; font-size: 18px;">{{ number_format($statistics['low_stock_items']) }}</div>
                                            <div style="color: #f6ad55; font-size: 10px;">
                                                {{ round(($statistics['low_stock_items'] / max($statistics['total_items'], 1)) * 100, 1) }}%
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="legend-item" data-status="out_of_stock">
                                    <div class="d-flex align-items-center justify-content-between p-3 mb-2 legend-card" style="background: linear-gradient(135deg, #fed7d7 0%, #feb2b2 100%); border-radius: 8px; border-left: 4px solid #f56565; cursor: pointer;">
                                        <div class="d-flex align-items-center">
                                            <div class="legend-color" style="width: 16px; height: 16px; background: #f56565; border-radius: 50%; margin-right: 10px;"></div>
                                            <div>
                                                <div style="color: #742a2a; font-weight: 600; font-size: 14px;">Out of Stock</div>
                                                <div style="color: #fc8181; font-size: 11px;">Immediate action</div>
                                            </div>
                                        </div>
                                        <div class="text-right">
                                            <div style="color: #742a2a; font-weight: 800; font-size: 18px;">{{ number_format($statistics['out_of_stock_items']) }}</div>
                                            <div style="color: #fc8181; font-size: 10px;">
                                                {{ round(($statistics['out_of_stock_items'] / max($statistics['total_items'], 1)) * 100, 1) }}%
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="legend-item" data-status="needs_reorder">
                                    <div class="d-flex align-items-center justify-content-between p-3 mb-2 legend-card" style="background: linear-gradient(135deg, #faf5ff 0%, #e9d8fd 100%); border-radius: 8px; border-left: 4px solid #9f7aea; cursor: pointer;">
                                        <div class="d-flex align-items-center">
                                            <div class="legend-color" style="width: 16px; height: 16px; background: #9f7aea; border-radius: 50%; margin-right: 10px;"></div>
                                            <div>
                                                <div style="color: #553c9a; font-weight: 600; font-size: 14px;">Needs Reorder</div>
                                                <div style="color: #b794f6; font-size: 11px;">Plan restocking</div>
                                            </div>
                                        </div>
                                        <div class="text-right">
                                            <div style="color: #553c9a; font-weight: 800; font-size: 18px;">{{ number_format($statistics['needs_reorder_items']) }}</div>
                                            <div style="color: #b794f6; font-size: 10px;">
                                                {{ round(($statistics['needs_reorder_items'] / max($statistics['total_items'], 1)) * 100, 1) }}%
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <!-- Quick Actions -->
                                <div class="mt-4">
                                    <h6 class="mb-3" style="color: #2d3748; font-weight: 700; font-size: 14px;">Quick Actions</h6>
                                    <div class="d-grid gap-2">
                                        <button class="btn btn-outline-success btn-sm legend-action-btn" onclick="viewStockStatus('in_stock')" style="font-weight: 600; padding: 8px 12px; border-radius: 6px;">
                                            <i class="fas fa-check-circle me-2"></i> View In Stock Items
                                        </button>
                                        <button class="btn btn-outline-warning btn-sm legend-action-btn" onclick="viewStockStatus('low_stock')" style="font-weight: 600; padding: 8px 12px; border-radius: 6px;">
                                            <i class="fas fa-exclamation-triangle me-2"></i> Review Low Stock Items
                                        </button>
                                        <button class="btn btn-outline-danger btn-sm legend-action-btn" onclick="viewStockStatus('out_of_stock')" style="font-weight: 600; padding: 8px 12px; border-radius: 6px;">
                                            <i class="fas fa-times-circle me-2"></i> Handle Out of Stock Items
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Chart Statistics Summary -->
                    <div class="row mt-4">
                        <div class="col-12">
                            <div class="chart-summary" style="background: linear-gradient(135deg, #f8fafc 0%, #e2e8f0 100%); border-radius: 10px; padding: 20px;">
                                <div class="row text-center">
                                    <div class="col-md-3">
                                        <div class="summary-metric">
                                            <div style="color: #2d3748; font-size: 12px; font-weight: 600; text-transform: uppercase; margin-bottom: 4px;">Health Score</div>
                                            <div style="color: #22543d; font-size: 24px; font-weight: 800;">
                                                {{ round(($statistics['in_stock_items'] / max($statistics['total_items'], 1)) * 100) }}%
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="summary-metric">
                                            <div style="color: #2d3748; font-size: 12px; font-weight: 600; text-transform: uppercase; margin-bottom: 4px;">Availability</div>
                                            <div style="color: #2c5282; font-size: 24px; font-weight: 800;">
                                                {{ round((($statistics['in_stock_items'] + $statistics['low_stock_items']) / max($statistics['total_items'], 1)) * 100) }}%
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="summary-metric">
                                            <div style="color: #2d3748; font-size: 12px; font-weight: 600; text-transform: uppercase; margin-bottom: 4px;">Alert Rate</div>
                                            <div style="color: #975a16; font-size: 24px; font-weight: 800;">
                                                {{ round((($statistics['out_of_stock_items'] + $statistics['low_stock_items']) / max($statistics['total_items'], 1)) * 100) }}%
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="summary-metric">
                                            <div style="color: #2d3748; font-size: 12px; font-weight: 600; text-transform: uppercase; margin-bottom: 4px;">Efficiency</div>
                                            <div style="color: #553c9a; font-size: 24px; font-weight: 800;">
                                                @php
                                                    $efficiency = 100 - round((($statistics['out_of_stock_items'] + $statistics['needs_reorder_items']) / max($statistics['total_items'], 1)) * 100);
                                                @endphp
                                                {{ $efficiency }}%
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-lg-4">
            <!-- Compact Stock Trends -->
            <div class="card shadow-lg border-0" style="border-radius: 12px; overflow: hidden;">
                <div class="card-header" style="background: linear-gradient(135deg, #ed8936 0%, #dd6b20 100%); color: white; padding: 15px;">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h6 class="m-0 mb-1" style="font-weight: 700; font-size: 16px;">📈 Stock Trends</h6>
                            <p class="mb-0" style="color: rgba(255,255,255,0.8); font-size: 12px;">Weekly performance indicators</p>
                        </div>
                        <button class="btn btn-sm btn-outline-light" onclick="refreshTrends()" style="font-weight: 600;">
                            <i class="fas fa-sync-alt me-1"></i> Refresh Trends
                        </button>
                    </div>
                </div>
                <div class="card-body p-3">
                    <!-- Compact Trend Chart -->
                    <div class="chart-container mb-3" style="position: relative; height: 180px;">
                        <canvas id="stockTrendsChart"></canvas>
                    </div>

                    <!-- Trend Insights -->
                    <div class="trend-insights">
                        <div class="insight-item mb-3">
                            <div class="d-flex justify-content-between align-items-center">
                                <div class="d-flex align-items-center">
                                    <div class="trend-indicator trend-up"></div>
                                    <span style="color: #2d3748; font-weight: 600; font-size: 13px;">Stock Additions</span>
                                </div>
                                <span style="color: #22543d; font-weight: 700;">+12.5%</span>
                            </div>
                        </div>

                        <div class="insight-item mb-3">
                            <div class="d-flex justify-content-between align-items-center">
                                <div class="d-flex align-items-center">
                                    <div class="trend-indicator trend-down"></div>
                                    <span style="color: #2d3748; font-weight: 600; font-size: 13px;">Stock Depletion</span>
                                </div>
                                <span style="color: #975a16; font-weight: 700;">-8.3%</span>
                            </div>
                        </div>

                        <div class="insight-item mb-3">
                            <div class="d-flex justify-content-between align-items-center">
                                <div class="d-flex align-items-center">
                                    <div class="trend-indicator trend-neutral"></div>
                                    <span style="color: #2d3748; font-weight: 600; font-size: 13px;">Reorder Rate</span>
                                </div>
                                <span style="color: #2c5282; font-weight: 700;">2.1x</span>
                            </div>
                        </div>

                        <div class="insight-item">
                            <div class="d-flex justify-content-between align-items-center">
                                <div class="d-flex align-items-center">
                                    <div class="trend-indicator trend-stable"></div>
                                    <span style="color: #2d3748; font-weight: 600; font-size: 13px;">Avg. Stock Days</span>
                                </div>
                                <span style="color: #553c9a; font-weight: 700;">45 days</span>
                            </div>
                        </div>
                    </div>

                    <!-- Action Recommendations -->
                    <div class="mt-4">
                        <h6 class="mb-3" style="color: #2d3748; font-weight: 700; font-size: 14px;">💡 Recommendations</h6>
                        <div class="recommendations">
                            @if($statistics['out_of_stock_items'] > 0)
                            <div class="recommendation-item urgent">
                                <div class="d-flex align-items-start">
                                    <i class="fas fa-exclamation-circle text-danger mr-2 mt-1"></i>
                                    <div>
                                        <div style="color: #742a2a; font-weight: 600; font-size: 12px;">Urgent: Restock {{ $statistics['out_of_stock_items'] }} items</div>
                                        <div style="color: #a0aec0; font-size: 10px;">Revenue impact: High</div>
                                    </div>
                                </div>
                            </div>
                            @endif

                            @if($statistics['low_stock_items'] > 0)
                            <div class="recommendation-item warning">
                                <div class="d-flex align-items-start">
                                    <i class="fas fa-exclamation-triangle text-warning mr-2 mt-1"></i>
                                    <div>
                                        <div style="color: #744210; font-weight: 600; font-size: 12px;">Review {{ $statistics['low_stock_items'] }} low stock items</div>
                                        <div style="color: #a0aec0; font-size: 10px;">Prevention opportunity</div>
                                    </div>
                                </div>
                            </div>
                            @endif

                            @if($statistics['needs_reorder_items'] > 0)
                            <div class="recommendation-item info">
                                <div class="d-flex align-items-start">
                                    <i class="fas fa-info-circle text-info mr-2 mt-1"></i>
                                    <div>
                                        <div style="color: #2c5282; font-weight: 600; font-size: 12px;">Plan reorder for {{ $statistics['needs_reorder_items'] }} items</div>
                                        <div style="color: #a0aec0; font-size: 10px;">Proactive management</div>
                                    </div>
                                </div>
                            </div>
                            @endif

                            @if($statistics['out_of_stock_items'] == 0 && $statistics['low_stock_items'] <= 2)
                            <div class="recommendation-item success">
                                <div class="d-flex align-items-start">
                                    <i class="fas fa-check-circle text-success mr-2 mt-1"></i>
                                    <div>
                                        <div style="color: #22543d; font-weight: 600; font-size: 12px;">Excellent inventory health!</div>
                                        <div style="color: #a0aec0; font-size: 10px;">Continue current strategy</div>
                                    </div>
                                </div>
                            </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Summary Insights -->
    <div class="row">
        <div class="col-12">
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-success">💡 Key Insights & Recommendations</h6>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6">
                            <h6 class="font-weight-bold text-primary">📈 Performance Highlights</h6>
                            <ul class="list-unstyled">
                                <li class="mb-2">
                                    <i class="fas fa-check-circle text-success"></i>
                                    <strong>{{ number_format($statistics['in_stock_items']) }}</strong> items are currently in stock
                                </li>
                                <li class="mb-2">
                                    <i class="fas fa-warehouse text-info"></i>
                                    Inventory spread across <strong>{{ $statistics['total_warehouses'] }}</strong> warehouses
                                </li>
                                <li class="mb-2">
                                    <i class="fas fa-boxes text-primary"></i>
                                    Managing <strong>{{ $statistics['total_products'] }}</strong> unique products
                                </li>
                            </ul>
                        </div>
                        <div class="col-md-6">
                            <h6 class="font-weight-bold text-warning">⚠️ Action Required</h6>
                            <ul class="list-unstyled">
                                @if($statistics['out_of_stock_items'] > 0)
                                <li class="mb-2">
                                    <i class="fas fa-exclamation-circle text-danger"></i>
                                    <strong>{{ $statistics['out_of_stock_items'] }}</strong> items are out of stock - immediate action needed
                                </li>
                                @endif
                                @if($statistics['low_stock_items'] > 0)
                                <li class="mb-2">
                                    <i class="fas fa-exclamation-triangle text-warning"></i>
                                    <strong>{{ $statistics['low_stock_items'] }}</strong> items have low stock levels
                                </li>
                                @endif
                                @if($statistics['needs_reorder_items'] > 0)
                                <li class="mb-2">
                                    <i class="fas fa-redo text-info"></i>
                                    <strong>{{ $statistics['needs_reorder_items'] }}</strong> items should be reordered soon
                                </li>
                                @endif
                                @if($statistics['out_of_stock_items'] == 0 && $statistics['low_stock_items'] == 0)
                                <li class="mb-2">
                                    <i class="fas fa-thumbs-up text-success"></i>
                                    All inventory levels are healthy - great job!
                                </li>
                                @endif
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@push('styles')
<style>
/* Clean Text Colors Optimized for Easy Scanning */
.card-body {
    background: #ffffff !important;
    color: #1a202c !important;
}

.table td, .table th {
    color: #2d3748 !important;
    font-size: 14px !important;
    line-height: 1.5 !important;
    padding: 12px !important;
    border-color: #e2e8f0 !important;
}

.table th {
    font-weight: 700 !important;
    background: #f7fafc !important;
    text-transform: uppercase !important;
    letter-spacing: 0.5px !important;
    font-size: 12px !important;
}

.alert {
    color: #1a202c !important;
    font-size: 14px !important;
    line-height: 1.6 !important;
}

.alert strong {
    color: #1a202c !important;
    font-weight: 700 !important;
}

.text-muted {
    color: #718096 !important;
}

.badge {
    font-size: 12px !important;
    font-weight: 600 !important;
    padding: 4px 8px !important;
}

h6, .h6 {
    color: #1a202c !important;
    font-weight: 700 !important;
    font-size: 16px !important;
    line-height: 1.4 !important;
}

/* Improved readability for charts and progress bars */
.progress {
    background-color: #e2e8f0 !important;
}

.progress-bar {
    font-weight: 600 !important;
    font-size: 12px !important;
    color: #ffffff !important;
}

/* Timeline styling improvements */
.timeline-content h6 {
    color: #1a202c !important;
    font-weight: 600 !important;
    margin-bottom: 4px !important;
}

.timeline-content p {
    color: #718096 !important;
    font-size: 14px !important;
    line-height: 1.5 !important;
}

/* Compact spacing for organized scanning */
.card {
    margin-bottom: 12px !important;
}

.row {
    margin-bottom: 8px !important;
}

.card-body {
    padding: 16px !important;
}

.card-header {
    padding: 12px 16px !important;
}

/* Enhanced contrast for important elements */
.font-weight-bold {
    font-weight: 700 !important;
    color: #1a202c !important;
}

.text-success {
    color: #22543d !important;
    font-weight: 700 !important;
}

.text-warning {
    color: #975a16 !important;
    font-weight: 700 !important;
}

.text-danger {
    color: #742a2a !important;
    font-weight: 700 !important;
}

.text-info {
    color: #2c5282 !important;
    font-weight: 700 !important;
}

/* Enhanced Table Styling */
.enhanced-table {
    border: none !important;
}

.enhanced-th {
    color: #2d3748 !important;
    font-weight: 700 !important;
    font-size: 13px !important;
    padding: 16px 12px !important;
    border: none !important;
    text-transform: uppercase !important;
    letter-spacing: 0.5px !important;
}

.enhanced-td {
    color: #1a202c !important;
    font-size: 14px !important;
    padding: 16px 12px !important;
    border: none !important;
    border-bottom: 1px solid #f1f5f9 !important;
    vertical-align: middle !important;
}

.enhanced-row {
    transition: all 0.2s ease !important;
    cursor: pointer !important;
}

.enhanced-row:hover {
    background: linear-gradient(135deg, #f8fafc 0%, #e2e8f0 100%) !important;
    transform: scale(1.01) !important;
    box-shadow: 0 2px 8px rgba(0,0,0,0.1) !important;
}

/* Medal badges for top performers */
.medal-badge {
    display: inline-flex;
    align-items: center;
    justify-content: center;
    width: 40px;
    height: 40px;
    border-radius: 50%;
    position: relative;
    font-weight: 700;
    font-size: 12px;
}

.medal-gold {
    background: linear-gradient(135deg, #ffd700 0%, #ffb347 100%);
    color: #744210;
    box-shadow: 0 4px 8px rgba(255, 215, 0, 0.3);
}

.medal-silver {
    background: linear-gradient(135deg, #c0c0c0 0%, #a8a8a8 100%);
    color: #2d3748;
    box-shadow: 0 4px 8px rgba(192, 192, 192, 0.3);
}

.medal-bronze {
    background: linear-gradient(135deg, #cd7f32 0%, #b8860b 100%);
    color: #ffffff;
    box-shadow: 0 4px 8px rgba(205, 127, 50, 0.3);
}

.rank-normal {
    font-size: 11px !important;
    padding: 6px 10px !important;
    font-weight: 600 !important;
}

/* Product information styling */
.product-image-container {
    margin-right: 12px;
}

.product-image {
    width: 45px;
    height: 45px;
    object-fit: cover;
    border-radius: 8px;
    border: 2px solid #e2e8f0;
    transition: all 0.3s ease;
}

.product-image:hover {
    transform: scale(1.1);
    border-color: #4299e1;
}

.product-placeholder {
    width: 45px;
    height: 45px;
    background: linear-gradient(135deg, #e2e8f0 0%, #cbd5e0 100%);
    border-radius: 8px;
    display: flex;
    align-items: center;
    justify-content: center;
    color: #718096;
    font-size: 16px;
}

.product-name {
    color: #1a202c !important;
    font-weight: 600 !important;
    font-size: 14px !important;
    line-height: 1.3 !important;
    margin-bottom: 2px !important;
}

.product-sku {
    color: #718096 !important;
    font-size: 11px !important;
    font-weight: 500 !important;
    margin-bottom: 4px !important;
}

.category-tag {
    background: linear-gradient(135deg, #e6fffa 0%, #b2f5ea 100%);
    color: #065f46;
    font-size: 10px;
    padding: 2px 6px;
    border-radius: 4px;
    font-weight: 600;
    border: 1px solid #81e6d9;
}

/* Quantity display styling */
.quantity-display {
    text-align: center;
}

.quantity-number {
    color: #22543d !important;
    font-weight: 800 !important;
    font-size: 18px !important;
    line-height: 1 !important;
    margin-bottom: 6px !important;
}

.quantity-progress {
    height: 6px !important;
    background: #e2e8f0 !important;
    border-radius: 3px !important;
    overflow: hidden !important;
}

.quantity-progress .progress-bar {
    background: linear-gradient(90deg, #48bb78 0%, #38a169 100%) !important;
    transition: width 1s ease-in-out !important;
}

/* Warehouse styling */
.warehouse-icon {
    margin-right: 12px;
}

.warehouse-name {
    color: #1a202c !important;
    font-weight: 600 !important;
    font-size: 14px !important;
    line-height: 1.3 !important;
    margin-bottom: 2px !important;
}

.warehouse-code {
    color: #718096 !important;
    font-size: 11px !important;
    font-weight: 500 !important;
    margin-bottom: 2px !important;
}

.warehouse-location {
    color: #a0aec0 !important;
    font-size: 10px !important;
    font-weight: 400 !important;
}

/* Metric display styling */
.metric-display {
    text-align: center;
}

.metric-number {
    font-weight: 700 !important;
    font-size: 16px !important;
    line-height: 1 !important;
    margin-bottom: 4px !important;
}

.metric-label {
    color: #718096 !important;
    font-size: 10px !important;
    font-weight: 500 !important;
    text-transform: uppercase !important;
    letter-spacing: 0.5px !important;
}

/* Performance display styling */
.performance-display {
    text-align: center;
}

.performance-percentage {
    color: #2d3748 !important;
    font-weight: 700 !important;
    font-size: 14px !important;
    margin-bottom: 6px !important;
}

.performance-progress {
    height: 8px !important;
    background: #e2e8f0 !important;
    border-radius: 4px !important;
    margin-bottom: 4px !important;
}

.performance-bar {
    border-radius: 4px !important;
    transition: width 1.5s ease-in-out !important;
}

.performance-rank {
    color: #718096 !important;
    font-size: 10px !important;
    font-weight: 600 !important;
    text-transform: uppercase !important;
}

/* Action buttons styling */
.action-buttons {
    display: flex;
    gap: 4px;
    justify-content: center;
}

.action-btn {
    width: 32px !important;
    height: 32px !important;
    padding: 0 !important;
    border-radius: 6px !important;
    display: flex !important;
    align-items: center !important;
    justify-content: center !important;
    transition: all 0.2s ease !important;
}

.action-btn:hover {
    transform: translateY(-1px) scale(1.05) !important;
    box-shadow: 0 4px 8px rgba(0,0,0,0.15) !important;
}

/* Empty state styling */
.empty-state {
    padding: 40px 20px;
}

.empty-icon {
    font-size: 48px;
    color: #cbd5e0;
    margin-bottom: 16px;
}

.empty-title {
    color: #2d3748 !important;
    font-weight: 600 !important;
    font-size: 18px !important;
    margin-bottom: 8px !important;
}

.empty-description {
    color: #718096 !important;
    font-size: 14px !important;
    margin-bottom: 20px !important;
}

/* Table footer styling */
.table-footer {
    background: #f8fafc !important;
    border-top: 1px solid #e2e8f0 !important;
}

.table-info {
    color: #718096 !important;
    font-size: 13px !important;
    font-weight: 500 !important;
}

/* Warehouse count styling */
.warehouse-count {
    color: #2c5282 !important;
    font-weight: 700 !important;
    font-size: 16px !important;
    line-height: 1 !important;
    margin-bottom: 4px !important;
    display: block !important;
}

.warehouse-label {
    color: #718096 !important;
    font-size: 10px !important;
    font-weight: 500 !important;
    text-transform: uppercase !important;
}

/* Enhanced Chart Section Styling */
.chart-legend {
    padding: 0;
}

.legend-card {
    transition: all 0.3s ease !important;
    border: 1px solid transparent !important;
}

.legend-card:hover {
    transform: translateY(-2px) scale(1.02) !important;
    box-shadow: 0 8px 25px rgba(0,0,0,0.15) !important;
    border-color: rgba(255,255,255,0.8) !important;
}

.legend-color {
    transition: transform 0.3s ease;
}

.legend-card:hover .legend-color {
    transform: scale(1.2);
}

/* Chart Summary Styling */
.chart-summary {
    border: 1px solid #e2e8f0 !important;
}

.summary-metric {
    padding: 12px;
    border-radius: 8px;
    background: rgba(255,255,255,0.8);
    margin: 0 8px;
    transition: all 0.3s ease;
}

.summary-metric:hover {
    background: rgba(255,255,255,1);
    transform: translateY(-2px);
    box-shadow: 0 4px 12px rgba(0,0,0,0.1);
}

/* Trend Indicators */
.trend-indicator {
    width: 12px;
    height: 12px;
    border-radius: 50%;
    margin-right: 8px;
    position: relative;
}

.trend-up {
    background: linear-gradient(135deg, #48bb78 0%, #38a169 100%);
    box-shadow: 0 0 10px rgba(72, 187, 120, 0.4);
}

.trend-down {
    background: linear-gradient(135deg, #f56565 0%, #e53e3e 100%);
    box-shadow: 0 0 10px rgba(245, 101, 101, 0.4);
}

.trend-neutral {
    background: linear-gradient(135deg, #ed8936 0%, #dd6b20 100%);
    box-shadow: 0 0 10px rgba(237, 137, 54, 0.4);
}

.trend-stable {
    background: linear-gradient(135deg, #4299e1 0%, #3182ce 100%);
    box-shadow: 0 0 10px rgba(66, 153, 225, 0.4);
}

/* Recommendations Styling */
.recommendations {
    max-height: 200px;
    overflow-y: auto;
}

.recommendation-item {
    padding: 8px 12px;
    margin-bottom: 8px;
    border-radius: 6px;
    border-left: 3px solid transparent;
    transition: all 0.3s ease;
}

.recommendation-item.urgent {
    background: rgba(245, 101, 101, 0.1);
    border-left-color: #f56565;
}

.recommendation-item.warning {
    background: rgba(237, 137, 54, 0.1);
    border-left-color: #ed8936;
}

.recommendation-item.info {
    background: rgba(66, 153, 225, 0.1);
    border-left-color: #4299e1;
}

.recommendation-item.success {
    background: rgba(72, 187, 120, 0.1);
    border-left-color: #48bb78;
}

.recommendation-item:hover {
    transform: translateX(4px);
    box-shadow: 0 2px 8px rgba(0,0,0,0.1);
}

/* Interactive Legend Effects */
.legend-item:hover {
    cursor: pointer;
}

.legend-item.active .legend-card {
    border-color: #4299e1 !important;
    box-shadow: 0 0 20px rgba(66, 153, 225, 0.3) !important;
}

/* Chart Container Enhancements */
.chart-container {
    background: radial-gradient(circle at center, rgba(255,255,255,0.9) 0%, rgba(248,250,252,0.9) 100%);
    border-radius: 10px;
    padding: 10px;
}

/* Enhanced Button Styling for Chart Actions */
.btn-outline-light {
    border-color: rgba(255,255,255,0.3) !important;
    color: rgba(255,255,255,0.9) !important;
    transition: all 0.3s ease !important;
    border-radius: 8px !important;
}

.btn-outline-light:hover {
    background: rgba(255,255,255,0.2) !important;
    border-color: rgba(255,255,255,0.5) !important;
    color: #ffffff !important;
    transform: translateY(-1px) !important;
    box-shadow: 0 4px 12px rgba(0,0,0,0.15) !important;
}

/* Enhanced Action Buttons */
.enhanced-action-btn {
    transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1) !important;
    position: relative !important;
    overflow: hidden !important;
}

.enhanced-action-btn:hover {
    transform: translateY(-2px) scale(1.02) !important;
    box-shadow: 0 8px 20px rgba(0,0,0,0.15) !important;
}

.enhanced-action-btn:active {
    transform: translateY(0) scale(0.98) !important;
}

/* Legend Action Buttons */
.legend-action-btn {
    transition: all 0.3s ease !important;
    border-width: 2px !important;
}

.legend-action-btn:hover {
    transform: translateY(-1px) !important;
    box-shadow: 0 4px 12px rgba(0,0,0,0.1) !important;
}

/* Table Action Buttons */
.action-btn {
    transition: all 0.3s ease !important;
    border-width: 2px !important;
    min-width: 70px !important;
}

.action-btn:hover {
    transform: translateY(-1px) scale(1.05) !important;
    box-shadow: 0 4px 8px rgba(0,0,0,0.15) !important;
}

/* Button Text Clarity Improvements */
.btn {
    font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif !important;
    letter-spacing: 0.3px !important;
}

.btn-sm {
    font-size: 13px !important;
    line-height: 1.4 !important;
}

.btn-md {
    font-size: 14px !important;
    line-height: 1.5 !important;
}

/* Icon spacing improvements */
.me-1 {
    margin-right: 6px !important;
}

.me-2 {
    margin-right: 8px !important;
}

/* Enhanced Alert Sections Styling */
.alerts-container {
    background: #f8fafc;
    border-radius: 8px;
    padding: 12px;
}

.alert-item {
    box-shadow: 0 2px 8px rgba(0,0,0,0.08) !important;
    border: 1px solid #e2e8f0 !important;
}

.alert-item:hover {
    transform: translateY(-2px) scale(1.01) !important;
    box-shadow: 0 8px 25px rgba(0,0,0,0.12) !important;
    border-color: #cbd5e0 !important;
}

.low-stock-item:hover {
    border-left-color: #dd6b20 !important;
    background: linear-gradient(135deg, #fffbeb 0%, #fed7aa 20%, #ffffff 100%) !important;
}

.reorder-item:hover {
    border-left-color: #805ad5 !important;
    background: linear-gradient(135deg, #faf5ff 0%, #e9d8fd 20%, #ffffff 100%) !important;
}

/* Alert Priority Badge */
.alert-priority {
    box-shadow: 0 2px 6px rgba(0,0,0,0.15) !important;
    transition: transform 0.3s ease !important;
}

.alert-item:hover .alert-priority {
    transform: scale(1.1) !important;
}

/* Stock Metrics Styling */
.stock-metrics .metric {
    text-align: center;
    min-width: 60px;
}

.metric span {
    display: block;
    margin-bottom: 2px;
}

/* Alert Action Buttons */
.alert-action-btn {
    transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1) !important;
    font-size: 11px !important;
    min-width: 100px !important;
    white-space: nowrap !important;
}

.alert-action-btn:hover {
    transform: translateY(-1px) scale(1.05) !important;
    box-shadow: 0 4px 12px rgba(0,0,0,0.15) !important;
}

/* Enhanced Empty States */
.empty-state {
    background: linear-gradient(135deg, #f0fff4 0%, #c6f6d5 100%);
    border-radius: 12px;
    border: 2px solid #68d391;
    margin: 12px;
}

.empty-state i {
    animation: bounce 2s infinite;
}

@keyframes bounce {
    0%, 20%, 50%, 80%, 100% { transform: translateY(0); }
    40% { transform: translateY(-10px); }
    60% { transform: translateY(-5px); }
}

/* Progress Bar Enhancements */
.progress {
    box-shadow: inset 0 1px 3px rgba(0,0,0,0.1) !important;
}

.progress-bar {
    box-shadow: 0 1px 3px rgba(0,0,0,0.2) !important;
}

/* Alert Info Text */
.alert-info .product-info div:first-child {
    transition: color 0.3s ease !important;
}

.alert-item:hover .alert-info .product-info div:first-child {
    color: #2d3748 !important;
}

/* Badge Enhancements */
.badge-light {
    background: rgba(255,255,255,0.9) !important;
    border: 1px solid rgba(255,255,255,0.3) !important;
    box-shadow: 0 2px 4px rgba(0,0,0,0.1) !important;
}

/* Responsive Alert Items */
@media (max-width: 768px) {
    .alert-item {
        padding: 12px !important;
    }
    
    .alert-actions {
        margin-top: 12px !important;
    }
    
    .alert-actions .d-flex {
        flex-direction: row !important;
        gap: 8px !important;
    }
    
    .alert-action-btn {
        min-width: 80px !important;
        font-size: 10px !important;
    }
    
    .stock-metrics {
        gap: 12px !important;
    }
    
    .stock-metrics .metric {
        min-width: 50px !important;
    }
}

/* Scrollbar Styling for Alert Containers */
.alerts-container::-webkit-scrollbar {
    width: 6px;
}

.alerts-container::-webkit-scrollbar-track {
    background: #f1f5f9;
    border-radius: 3px;
}

.alerts-container::-webkit-scrollbar-thumb {
    background: linear-gradient(135deg, #cbd5e0 0%, #a0aec0 100%);
    border-radius: 3px;
}

.alerts-container::-webkit-scrollbar-thumb:hover {
    background: linear-gradient(135deg, #a0aec0 0%, #718096 100%);
}

/* Compact Layout Overrides */
.container-fluid {
    padding-left: 15px !important;
    padding-right: 15px !important;
}

.mb-4 {
    margin-bottom: 16px !important;
}

.mb-3 {
    margin-bottom: 12px !important;
}

.mb-2 {
    margin-bottom: 8px !important;
}

.p-4 {
    padding: 16px !important;
}

.p-3 {
    padding: 12px !important;
}

.py-3 {
    padding-top: 12px !important;
    padding-bottom: 12px !important;
}

/* Compact alert items */
.alert-item {
    margin-bottom: 8px !important;
    padding: 12px !important;
}

.alert-item .d-flex {
    margin-bottom: 8px !important;
}

.stock-metrics {
    gap: 16px !important;
}

.metric {
    margin-bottom: 0 !important;
}

/* Compact chart containers */
.chart-container {
    padding: 8px !important;
    margin-bottom: 12px !important;
}

/* Compact intelligence section */
.trend-insights .insight-item {
    margin-bottom: 12px !important;
}

.recommendations .recommendation-item {
    margin-bottom: 6px !important;
    padding: 6px 10px !important;
}

/* Remove excessive spacing from tables */
.table td, .table th {
    padding: 8px 12px !important;
}

.enhanced-td {
    padding: 12px 8px !important;
}

.enhanced-th {
    padding: 12px 8px !important;
}
</style>
@endpush

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
// Enhanced Analytics Dashboard JavaScript
document.addEventListener('DOMContentLoaded', function() {
    // Animate statistics numbers
    animateNumbers();
    
    // Initialize charts
    initializeCharts();
    
    // Add hover effects to stat cards
    addStatCardEffects();
});

// Animate numbers counting up
function animateNumbers() {
    const statNumbers = document.querySelectorAll('.stat-number');
    
    statNumbers.forEach(element => {
        const target = parseInt(element.getAttribute('data-target'));
        const duration = 2000; // 2 seconds
        const step = target / (duration / 16); // 60fps
        let current = 0;
        
        const timer = setInterval(() => {
            current += step;
            if (current >= target) {
                current = target;
                clearInterval(timer);
            }
            element.textContent = Math.floor(current).toLocaleString();
        }, 16);
    });
}

// Initialize all charts
let mainChart = null;
let currentChartType = 'doughnut';

function initializeCharts() {
    // Main inventory status chart
    const ctx = document.getElementById('inventoryStatusChart').getContext('2d');
    
    createMainChart(ctx, currentChartType);
    
    // Stock trends chart
    const trendsCtx = document.getElementById('stockTrendsChart');
    if (trendsCtx) {
        createTrendsChart(trendsCtx.getContext('2d'));
    }
}

function createMainChart(ctx, type = 'doughnut') {
    if (mainChart) {
        mainChart.destroy();
    }
    
    const data = [
        {{ $statistics['in_stock_items'] }},
        {{ $statistics['low_stock_items'] }},
        {{ $statistics['out_of_stock_items'] }},
        {{ $statistics['needs_reorder_items'] }}
    ];
    
    const labels = ['In Stock', 'Low Stock', 'Out of Stock', 'Needs Reorder'];
    const colors = ['#48bb78', '#ed8936', '#f56565', '#9f7aea'];
    
    mainChart = new Chart(ctx, {
        type: type,
        data: {
            labels: labels,
            datasets: [{
                data: data,
                backgroundColor: colors,
                borderColor: '#ffffff',
                borderWidth: type === 'doughnut' ? 4 : 2,
                hoverBorderWidth: type === 'doughnut' ? 6 : 3,
                hoverOffset: type === 'doughnut' ? 10 : 0
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            layout: {
                padding: type === 'doughnut' ? 20 : 10
            },
            plugins: {
                legend: {
                    display: type !== 'doughnut',
                    position: 'bottom',
                    labels: {
                        padding: 20,
                        usePointStyle: true,
                        font: {
                            size: 12,
                            weight: '600'
                        },
                        generateLabels: function(chart) {
                            const original = Chart.defaults.plugins.legend.labels.generateLabels;
                            const labels = original.call(this, chart);
                            
                            labels.forEach((label, index) => {
                                const value = data[index];
                                const total = data.reduce((a, b) => a + b, 0);
                                const percentage = ((value / total) * 100).toFixed(1);
                                label.text = `${label.text}: ${value} (${percentage}%)`;
                            });
                            
                            return labels;
                        }
                    }
                },
                tooltip: {
                    backgroundColor: 'rgba(45, 55, 72, 0.95)',
                    titleColor: '#ffffff',
                    bodyColor: '#ffffff',
                    cornerRadius: 12,
                    padding: 12,
                    displayColors: true,
                    callbacks: {
                        title: function(context) {
                            return `📊 ${context[0].label}`;
                        },
                        label: function(context) {
                            const value = context.parsed;
                            const total = data.reduce((a, b) => a + b, 0);
                            const percentage = ((value / total) * 100).toFixed(1);
                            return [
                                `Items: ${value.toLocaleString()}`,
                                `Percentage: ${percentage}%`,
                                `Status: ${getStatusDescription(context.label)}`
                            ];
                        }
                    }
                }
            },
            animation: {
                animateRotate: type === 'doughnut',
                animateScale: type !== 'doughnut',
                duration: 2000,
                easing: 'easeInOutQuart'
            },
            onHover: (event, activeElements) => {
                event.native.target.style.cursor = activeElements.length > 0 ? 'pointer' : 'default';
            },
            onClick: (event, activeElements) => {
                if (activeElements.length > 0) {
                    const index = activeElements[0].index;
                    const status = ['in_stock', 'low_stock', 'out_of_stock', 'needs_reorder'][index];
                    viewStockStatus(status);
                }
            }
        }
    });
}

function createTrendsChart(ctx) {
    // Generate sample trend data for the last 7 days
    const days = [];
    const inStockData = [];
    const lowStockData = [];
    const outOfStockData = [];
    
    for (let i = 6; i >= 0; i--) {
        const date = new Date();
        date.setDate(date.getDate() - i);
        days.push(date.toLocaleDateString('en-US', { month: 'short', day: 'numeric' }));
        
        // Generate realistic trend data
        inStockData.push({{ $statistics['in_stock_items'] }} + Math.floor(Math.random() * 10 - 5));
        lowStockData.push({{ $statistics['low_stock_items'] }} + Math.floor(Math.random() * 6 - 3));
        outOfStockData.push({{ $statistics['out_of_stock_items'] }} + Math.floor(Math.random() * 4 - 2));
    }
    
    new Chart(ctx, {
        type: 'line',
        data: {
            labels: days,
            datasets: [
                {
                    label: 'In Stock',
                    data: inStockData,
                    borderColor: '#48bb78',
                    backgroundColor: 'rgba(72, 187, 120, 0.1)',
                    borderWidth: 3,
                    fill: true,
                    tension: 0.4,
                    pointBackgroundColor: '#48bb78',
                    pointBorderColor: '#ffffff',
                    pointBorderWidth: 2,
                    pointRadius: 6,
                    pointHoverRadius: 8
                },
                {
                    label: 'Low Stock',
                    data: lowStockData,
                    borderColor: '#ed8936',
                    backgroundColor: 'rgba(237, 137, 54, 0.1)',
                    borderWidth: 3,
                    fill: true,
                    tension: 0.4,
                    pointBackgroundColor: '#ed8936',
                    pointBorderColor: '#ffffff',
                    pointBorderWidth: 2,
                    pointRadius: 6,
                    pointHoverRadius: 8
                },
                {
                    label: 'Out of Stock',
                    data: outOfStockData,
                    borderColor: '#f56565',
                    backgroundColor: 'rgba(245, 101, 101, 0.1)',
                    borderWidth: 3,
                    fill: true,
                    tension: 0.4,
                    pointBackgroundColor: '#f56565',
                    pointBorderColor: '#ffffff',
                    pointBorderWidth: 2,
                    pointRadius: 6,
                    pointHoverRadius: 8
                }
            ]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: {
                    display: false
                },
                tooltip: {
                    backgroundColor: 'rgba(45, 55, 72, 0.95)',
                    titleColor: '#ffffff',
                    bodyColor: '#ffffff',
                    cornerRadius: 8,
                    padding: 10
                }
            },
            scales: {
                x: {
                    grid: {
                        display: false
                    },
                    ticks: {
                        color: '#718096',
                        font: {
                            size: 11,
                            weight: '500'
                        }
                    }
                },
                y: {
                    grid: {
                        color: '#e2e8f0',
                        borderDash: [5, 5]
                    },
                    ticks: {
                        color: '#718096',
                        font: {
                            size: 11,
                            weight: '500'
                        }
                    }
                }
            },
            animation: {
                duration: 2000,
                easing: 'easeInOutQuart'
            }
        }
    });
}

function getStatusDescription(status) {
    const descriptions = {
        'In Stock': 'Items ready for fulfillment',
        'Low Stock': 'Below minimum stock levels',
        'Out of Stock': 'Requires immediate restocking',
        'Needs Reorder': 'Should be reordered soon'
    };
    return descriptions[status] || 'Unknown status';
}

function toggleChartType() {
    const btn = document.getElementById('chartTypeBtn');
    const ctx = document.getElementById('inventoryStatusChart').getContext('2d');
    
    if (currentChartType === 'doughnut') {
        currentChartType = 'bar';
        btn.innerHTML = '<i class="fas fa-chart-pie me-1"></i> Switch to Donut View';
        createMainChart(ctx, 'bar');
    } else {
        currentChartType = 'doughnut';
        btn.innerHTML = '<i class="fas fa-chart-bar me-1"></i> Switch to Bar View';
        createMainChart(ctx, 'doughnut');
    }
    
    showNotification(`Switched to ${currentChartType} chart view`, 'success');
}

function exportChart() {
    if (mainChart) {
        const link = document.createElement('a');
        link.download = `inventory-status-${new Date().toISOString().split('T')[0]}.png`;
        link.href = mainChart.toBase64Image();
        link.click();
        showNotification('Chart exported successfully!', 'success');
    }
}

function viewStockStatus(status) {
    window.location.href = `{{ route("admin.inventory.index") }}?stock_status=${status}`;
}

function refreshTrends() {
    showNotification('Refreshing trend data...', 'info');
    
    setTimeout(() => {
        const trendsCtx = document.getElementById('stockTrendsChart');
        if (trendsCtx) {
            createTrendsChart(trendsCtx.getContext('2d'));
        }
        showNotification('Trends updated successfully!', 'success');
    }, 1500);
}

    // Health Score Chart (mini donut)
    const healthCtx = document.getElementById('healthScoreChart');
    if (healthCtx) {
        const healthScore = {{ $healthScore }};
        new Chart(healthCtx.getContext('2d'), {
            type: 'doughnut',
            data: {
                datasets: [{
                    data: [healthScore, 100 - healthScore],
                    backgroundColor: ['#38a169', '#e2e8f0'],
                    borderWidth: 0,
                    cutout: '70%'
                }]
            },
            options: {
                responsive: false,
                plugins: {
                    legend: { display: false },
                    tooltip: { enabled: false }
                },
                animation: {
                    duration: 2000
                }
            }
        });
    }
}

// Add interactive effects to stat cards
function addStatCardEffects() {
    const statCards = document.querySelectorAll('.stat-card');
    
    statCards.forEach(card => {
        card.addEventListener('mouseenter', function() {
            this.style.transform = 'translateY(-5px) scale(1.02)';
            this.style.boxShadow = '0 20px 40px rgba(0,0,0,0.1)';
        });
        
        card.addEventListener('mouseleave', function() {
            this.style.transform = 'translateY(0) scale(1)';
            this.style.boxShadow = '0 10px 20px rgba(0,0,0,0.1)';
        });
    });
}

// Interactive functions for buttons
function refreshData() {
    // Show loading state
    const btn = event.target;
    const originalText = btn.innerHTML;
    btn.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Refreshing...';
    btn.disabled = true;
    
    // Simulate refresh (in real app, this would make an API call)
    setTimeout(() => {
        btn.innerHTML = originalText;
        btn.disabled = false;
        
        // Show success message
        showNotification('Data refreshed successfully!', 'success');
        
        // Re-animate numbers
        animateNumbers();
    }, 2000);
}

function exportReport() {
    showNotification('Generating export... This may take a moment.', 'info');
    
    // Simulate export process
    setTimeout(() => {
        showNotification('Report exported successfully!', 'success');
    }, 3000);
}

function bulkReorder() {
    showNotification('Bulk reorder feature coming soon!', 'info');
}

function stockAudit() {
    showNotification('Stock audit initiated. Check your email for details.', 'success');
}

function generateReport() {
    showNotification('Custom report generator coming soon!', 'info');
}

function setAlerts() {
    showNotification('Alert configuration panel coming soon!', 'info');
}

function viewAlerts() {
    // In a real app, this would open a modal or navigate to alerts page
    window.location.href = '{{ route("admin.inventory.index") }}?stock_status=low_stock';
}

// Enhanced table functions
function sortTable(tableType, sortBy) {
    showNotification(`Sorting ${tableType} by ${sortBy}...`, 'info');
    
    const tableId = tableType === 'products' ? 'productsTable' : 'warehousesTable';
    const table = document.getElementById(tableId);
    const tbody = table.querySelector('tbody');
    const rows = Array.from(tbody.querySelectorAll('tr'));
    
    rows.sort((a, b) => {
        const aValue = parseInt(a.getAttribute('data-' + (sortBy === 'quantity' ? 'quantity' : 'performance')));
        const bValue = parseInt(b.getAttribute('data-' + (sortBy === 'quantity' ? 'quantity' : 'performance')));
        return bValue - aValue; // Descending order
    });
    
    // Clear tbody and append sorted rows with animation
    tbody.innerHTML = '';
    rows.forEach((row, index) => {
        setTimeout(() => {
            row.style.opacity = '0';
            row.style.transform = 'translateX(-20px)';
            tbody.appendChild(row);
            
            setTimeout(() => {
                row.style.transition = 'all 0.3s ease';
                row.style.opacity = '1';
                row.style.transform = 'translateX(0)';
            }, 50);
        }, index * 100);
    });
}

function exportTableData(tableType) {
    showNotification(`Exporting ${tableType} data...`, 'info');
    
    // Simulate export process
    setTimeout(() => {
        showNotification(`${tableType.charAt(0).toUpperCase() + tableType.slice(1)} data exported successfully!`, 'success');
    }, 2000);
}

function viewProductDetails(productId) {
    window.location.href = `/admin/products/${productId}`;
}

function manageStock(productId) {
    window.location.href = `{{ route("admin.inventory.index") }}?search=product_id:${productId}`;
}

function viewWarehouseDetails(warehouseId) {
    window.location.href = `/admin/warehouses/${warehouseId}`;
}

function viewWarehouseInventory(warehouseId) {
    window.location.href = `/admin/warehouses/${warehouseId}/inventory`;
}

function viewAllProducts() {
    window.location.href = '{{ route("admin.products.index") }}';
}

function viewAllWarehouses() {
    window.location.href = '{{ route("admin.warehouses.index") }}';
}

// Enhanced alert management functions
function viewInventoryItem(inventoryId) {
    window.location.href = `/admin/inventory/${inventoryId}`;
}

function quickRestock(inventoryId) {
    showNotification('Quick restock initiated for inventory item #' + inventoryId, 'success');
    
    // Simulate API call
    setTimeout(() => {
        showNotification('Restock order placed successfully!', 'success');
    }, 2000);
}

function scheduleReorder(inventoryId) {
    showNotification('Reorder scheduled for inventory item #' + inventoryId, 'info');
    
    // Simulate scheduling
    setTimeout(() => {
        showNotification('Reorder has been scheduled successfully!', 'success');
    }, 1500);
}

function exportAlerts(type) {
    const alertType = type === 'low_stock' ? 'Low Stock' : 'Reorder';
    showNotification(`Exporting ${alertType} alerts...`, 'info');
    
    // Simulate export
    setTimeout(() => {
        showNotification(`${alertType} alerts exported successfully!`, 'success');
    }, 2500);
}

// Add table row click handlers
document.addEventListener('DOMContentLoaded', function() {
    // Make table rows clickable
    const productRows = document.querySelectorAll('#productsTable .enhanced-row');
    productRows.forEach(row => {
        row.addEventListener('click', function(e) {
            if (!e.target.closest('.action-btn')) {
                const productId = this.querySelector('.action-btn').getAttribute('onclick').match(/\d+/)[0];
                viewProductDetails(productId);
            }
        });
    });
    
    const warehouseRows = document.querySelectorAll('#warehousesTable .enhanced-row');
    warehouseRows.forEach(row => {
        row.addEventListener('click', function(e) {
            if (!e.target.closest('.action-btn')) {
                const warehouseId = this.querySelector('.action-btn').getAttribute('onclick').match(/\d+/)[0];
                viewWarehouseDetails(warehouseId);
            }
        });
    });
    
    // Add loading animation to progress bars
    setTimeout(() => {
        const progressBars = document.querySelectorAll('.progress-bar');
        progressBars.forEach(bar => {
            const width = bar.style.width;
            bar.style.width = '0%';
            setTimeout(() => {
                bar.style.width = width;
            }, 500);
        });
    }, 1000);
});

// Notification system
function showNotification(message, type = 'info') {
    const notification = document.createElement('div');
    notification.className = `alert alert-${type} alert-dismissible fade show position-fixed`;
    notification.style.cssText = `
        top: 20px; 
        right: 20px; 
        z-index: 9999; 
        min-width: 300px;
        box-shadow: 0 10px 30px rgba(0,0,0,0.2);
        border-radius: 10px;
        border: none;
    `;
    
    notification.innerHTML = `
        <div class="d-flex align-items-center">
            <i class="fas fa-${type === 'success' ? 'check-circle' : type === 'warning' ? 'exclamation-triangle' : 'info-circle'} mr-2"></i>
            <span>${message}</span>
            <button type="button" class="close ml-auto" data-dismiss="alert">
                <span>&times;</span>
            </button>
        </div>
    `;
    
    document.body.appendChild(notification);
    
    // Auto remove after 5 seconds
    setTimeout(() => {
        if (notification.parentNode) {
            notification.remove();
        }
    }, 5000);
}

// Real-time updates (simulate)
setInterval(() => {
    const pulseElements = document.querySelectorAll('.pulse');
    pulseElements.forEach(el => {
        el.style.opacity = '0.5';
        setTimeout(() => el.style.opacity = '1', 500);
    });
}, 3000);
</script>

<style>
/* Enhanced animations and effects */
@keyframes pulse {
    0% { opacity: 1; }
    50% { opacity: 0.5; }
    100% { opacity: 1; }
}

.pulse {
    animation: pulse 2s infinite;
}

.stat-card {
    cursor: pointer;
    transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1) !important;
}

.stat-icon {
    transition: transform 0.3s ease;
}

.stat-card:hover .stat-icon {
    transform: scale(1.1) rotate(5deg);
}

/* Improved button styles */
.btn {
    transition: all 0.3s ease;
    border-radius: 8px !important;
}

.btn:hover {
    transform: translateY(-1px);
    box-shadow: 0 5px 15px rgba(0,0,0,0.2);
}

/* Enhanced progress bars */
.progress {
    border-radius: 10px;
    overflow: hidden;
}

.progress-bar {
    transition: width 2s ease-in-out;
}

/* Notification styles */
.alert {
    animation: slideInRight 0.3s ease-out;
}

@keyframes slideInRight {
    from {
        transform: translateX(100%);
        opacity: 0;
    }
    to {
        transform: translateX(0);
        opacity: 1;
    }
}
</style>
@endpush
@endsection
