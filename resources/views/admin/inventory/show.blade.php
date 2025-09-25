@extends('admin.dashboard')

@section('content')
<div class="container-fluid">
    <!-- Header Section -->
    <div class="row mb-4">
        <div class="col-12">
            <div class="d-flex justify-content-between align-items-center">
                <div>
                    <h1 class="h3 mb-0 text-gray-800">📦 Inventory Details</h1>
                    <p class="text-muted">{{ $inventory->product->name ?? 'Unknown Product' }} - {{ $inventory->warehouse->name ?? 'Unknown Warehouse' }}</p>
                </div>
                <div class="d-flex gap-2">
                    <a href="{{ route('admin.inventory.edit', $inventory) }}" class="btn btn-warning">
                        <i class="fas fa-edit"></i> Edit
                    </a>
                    <a href="{{ route('admin.inventory.index') }}" class="btn btn-secondary">
                        <i class="fas fa-arrow-left"></i> Back to List
                    </a>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-lg-8">
            <!-- Basic Information -->
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">📋 Basic Information</h6>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label class="font-weight-bold text-gray-800">Product</label>
                                <div class="d-flex align-items-center mt-2">
                                    @if($inventory->product && $inventory->product->image)
                                        <img src="{{ Storage::url($inventory->product->image) }}" 
                                             alt="{{ $inventory->product->name }}" 
                                             class="rounded me-3" 
                                             style="width: 60px; height: 60px; object-fit: cover;">
                                    @else
                                        <div class="bg-secondary rounded me-3 d-flex align-items-center justify-content-center" style="width: 60px; height: 60px;">
                                            <i class="fas fa-box text-white fa-lg"></i>
                                        </div>
                                    @endif
                                    <div>
                                        <h5 class="mb-1">{{ $inventory->product->name ?? 'Unknown Product' }}</h5>
                                        <p class="text-muted mb-1">SKU: {{ $inventory->product->sku ?? 'N/A' }}</p>
                                        @if($inventory->product && $inventory->product->category)
                                            <small class="badge badge-info">{{ $inventory->product->category->name }}</small>
                                        @endif
                                        @if($inventory->product && $inventory->product->brand)
                                            <small class="badge badge-secondary">{{ $inventory->product->brand->name }}</small>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label class="font-weight-bold text-gray-800">Warehouse</label>
                                <div class="mt-2">
                                    <h5 class="mb-1">{{ $inventory->warehouse->name ?? 'Unknown Warehouse' }}</h5>
                                    <p class="text-muted mb-1">Code: {{ $inventory->warehouse->code ?? 'N/A' }}</p>
                                    <p class="text-muted mb-1">Location: {{ $inventory->warehouse->location ?? 'N/A' }}</p>
                                    @if($inventory->warehouse && $inventory->warehouse->manager)
                                        <small class="text-info">Manager: {{ $inventory->warehouse->manager }}</small>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Stock Information -->
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-success">📊 Stock Information</h6>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-3">
                            <div class="text-center p-3 border rounded">
                                <div class="text-xs font-weight-bold text-gray-600 text-uppercase mb-1">Current Quantity</div>
                                <div class="h3 mb-0 font-weight-bold text-{{ $inventory->quantity > 0 ? 'success' : 'danger' }}">
                                    {{ number_format($inventory->quantity) }}
                                </div>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="text-center p-3 border rounded">
                                <div class="text-xs font-weight-bold text-gray-600 text-uppercase mb-1">Minimum Stock</div>
                                <div class="h3 mb-0 font-weight-bold text-warning">
                                    {{ number_format($inventory->minimum_stock) }}
                                </div>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="text-center p-3 border rounded">
                                <div class="text-xs font-weight-bold text-gray-600 text-uppercase mb-1">Reorder Level</div>
                                <div class="h3 mb-0 font-weight-bold text-info">
                                    {{ number_format($inventory->reorder_level) }}
                                </div>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="text-center p-3 border rounded">
                                <div class="text-xs font-weight-bold text-gray-600 text-uppercase mb-1">Status</div>
                                <div class="h6 mb-0">
                                    <span class="badge badge-{{ $inventory->getStockStatusColor() }} badge-pill">
                                        {{ $inventory->getStockStatus() }}
                                    </span>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Stock Value -->
                    @if($inventory->product && $inventory->product->regular_price)
                    <div class="row mt-4">
                        <div class="col-12">
                            <div class="alert alert-info">
                                <div class="d-flex justify-content-between align-items-center">
                                    <div>
                                        <strong>💰 Stock Value:</strong>
                                        <span class="h5 mb-0 ml-2">${{ number_format($inventory->getStockValue(), 2) }}</span>
                                    </div>
                                    <small class="text-muted">
                                        {{ number_format($inventory->quantity) }} × ${{ number_format($inventory->product->regular_price, 2) }}
                                    </small>
                                </div>
                            </div>
                        </div>
                    </div>
                    @endif

                    <!-- Enhanced Quick Actions -->
                    <div class="row mt-4">
                        <div class="col-12">
                            <div class="card border-0" style="background: linear-gradient(135deg, #f8fafc 0%, #e2e8f0 100%); border-radius: 12px; padding: 20px;">
                                <h6 class="mb-4" style="color: #2d3748; font-weight: 700; font-size: 16px;">
                                    ⚡ Quick Stock Actions
                                </h6>
                                <div class="row">
                                    <div class="col-lg-4 mb-3">
                                        <button class="btn btn-success btn-lg w-100 action-button" onclick="adjustStock('add')" style="border-radius: 10px; padding: 15px; transition: all 0.3s ease;">
                                            <div class="d-flex align-items-center justify-content-center">
                                                <div class="action-icon me-3">
                                                    <i class="fas fa-plus-circle fa-2x"></i>
                                                </div>
                                                <div class="text-left">
                                                    <div style="font-weight: 700; font-size: 16px;">Add Stock</div>
                                                    <div style="font-size: 12px; opacity: 0.8;">Increase inventory quantity</div>
                                                </div>
                                            </div>
                                        </button>
                                    </div>
                                    
                                    <div class="col-lg-4 mb-3">
                                        <button class="btn btn-warning btn-lg w-100 action-button" onclick="adjustStock('subtract')" style="border-radius: 10px; padding: 15px; transition: all 0.3s ease;">
                                            <div class="d-flex align-items-center justify-content-center">
                                                <div class="action-icon me-3">
                                                    <i class="fas fa-minus-circle fa-2x"></i>
                                                </div>
                                                <div class="text-left">
                                                    <div style="font-weight: 700; font-size: 16px;">Remove Stock</div>
                                                    <div style="font-size: 12px; opacity: 0.8;">Decrease inventory quantity</div>
                                                </div>
                                            </div>
                                        </button>
                                    </div>
                                    
                                    <div class="col-lg-4 mb-3">
                                        <button class="btn btn-info btn-lg w-100 action-button" onclick="adjustStock('set')" style="border-radius: 10px; padding: 15px; transition: all 0.3s ease;">
                                            <div class="d-flex align-items-center justify-content-center">
                                                <div class="action-icon me-3">
                                                    <i class="fas fa-edit fa-2x"></i>
                                                </div>
                                                <div class="text-left">
                                                    <div style="font-weight: 700; font-size: 16px;">Set Quantity</div>
                                                    <div style="font-size: 12px; opacity: 0.8;">Override current quantity</div>
                                                </div>
                                            </div>
                                        </button>
                                    </div>
                                </div>
                                
                                <!-- Additional Actions Row -->
                                <div class="row mt-3">
                                    <div class="col-lg-6 mb-2">
                                        <button class="btn btn-outline-primary btn-md w-100" onclick="viewStockHistory()" style="border-radius: 8px; font-weight: 600;">
                                            <i class="fas fa-history me-2"></i> View Stock History
                                        </button>
                                    </div>
                                    <div class="col-lg-6 mb-2">
                                        <button class="btn btn-outline-secondary btn-md w-100" onclick="generateStockReport()" style="border-radius: 8px; font-weight: 600;">
                                            <i class="fas fa-file-alt me-2"></i> Generate Report
                                        </button>
                                    </div>
                                </div>
                                
                                <!-- Emergency Actions -->
                                @if($inventory->isOutOfStock() || $inventory->isLowStock())
                                <div class="row mt-3">
                                    <div class="col-12">
                                        <div class="alert alert-{{ $inventory->isOutOfStock() ? 'danger' : 'warning' }} mb-0" style="border-radius: 8px;">
                                            <div class="d-flex justify-content-between align-items-center">
                                                <div>
                                                    <strong>
                                                        @if($inventory->isOutOfStock())
                                                            🚨 Emergency Restock Required
                                                        @else
                                                            ⚠️ Low Stock Alert
                                                        @endif
                                                    </strong>
                                                </div>
                                                <button class="btn btn-{{ $inventory->isOutOfStock() ? 'danger' : 'warning' }} btn-sm" onclick="emergencyRestock()" style="font-weight: 600;">
                                                    <i class="fas fa-shopping-cart me-1"></i> Order Now
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Related Inventory (Same Product, Other Warehouses) -->
            @if($relatedInventories->count() > 0)
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-info">🏪 Same Product in Other Warehouses</h6>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-bordered table-sm">
                            <thead class="thead-light">
                                <tr>
                                    <th>Warehouse</th>
                                    <th>Quantity</th>
                                    <th>Status</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($relatedInventories as $related)
                                <tr>
                                    <td>
                                        <strong>{{ $related->warehouse->name }}</strong><br>
                                        <small class="text-muted">{{ $related->warehouse->code }}</small>
                                    </td>
                                    <td>
                                        <span class="badge badge-{{ $related->quantity > 0 ? 'success' : 'danger' }} badge-pill">
                                            {{ number_format($related->quantity) }}
                                        </span>
                                    </td>
                                    <td>
                                        <span class="badge badge-{{ $related->getStockStatusColor() }}">
                                            {{ $related->getStockStatus() }}
                                        </span>
                                    </td>
                                    <td>
                                        <a href="{{ route('admin.inventory.show', $related) }}" class="btn btn-sm btn-outline-primary">
                                            <i class="fas fa-eye"></i>
                                        </a>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            @endif

            <!-- Activity History -->
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-secondary">📅 Activity History</h6>
                </div>
                <div class="card-body">
                    <div class="timeline">
                        <div class="timeline-item">
                            <div class="timeline-marker bg-success"></div>
                            <div class="timeline-content">
                                <h6 class="mb-1">Record Created</h6>
                                <p class="text-muted mb-0">{{ $inventory->created_at->format('M d, Y \a\t H:i') }}</p>
                            </div>
                        </div>
                        @if($inventory->created_at != $inventory->updated_at)
                        <div class="timeline-item">
                            <div class="timeline-marker bg-info"></div>
                            <div class="timeline-content">
                                <h6 class="mb-1">Last Updated</h6>
                                <p class="text-muted mb-0">{{ $inventory->updated_at->format('M d, Y \a\t H:i') }}</p>
                            </div>
                        </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>

        <div class="col-lg-4">
            <!-- Statistics -->
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-success">📊 Statistics</h6>
                </div>
                <div class="card-body">
                    <div class="mb-3">
                        <div class="d-flex justify-content-between align-items-center">
                            <span class="text-gray-600">Product Total Quantity:</span>
                            <span class="font-weight-bold">{{ number_format($statistics['product_total_quantity']) }}</span>
                        </div>
                    </div>
                    <div class="mb-3">
                        <div class="d-flex justify-content-between align-items-center">
                            <span class="text-gray-600">Warehouse Total Items:</span>
                            <span class="font-weight-bold">{{ number_format($statistics['warehouse_total_items']) }}</span>
                        </div>
                    </div>
                    <div class="mb-3">
                        <div class="d-flex justify-content-between align-items-center">
                            <span class="text-gray-600">Product in Warehouses:</span>
                            <span class="font-weight-bold">{{ number_format($statistics['product_warehouses']) }}</span>
                        </div>
                    </div>
                    @if($statistics['stock_value'] > 0)
                    <div class="mb-3">
                        <div class="d-flex justify-content-between align-items-center">
                            <span class="text-gray-600">Stock Value:</span>
                            <span class="font-weight-bold text-success">${{ number_format($statistics['stock_value'], 2) }}</span>
                        </div>
                    </div>
                    @endif
                </div>
            </div>

            <!-- Stock Alerts -->
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-warning">⚠️ Stock Alerts</h6>
                </div>
                <div class="card-body">
                    @if($inventory->isOutOfStock())
                        <div class="alert alert-danger">
                            <i class="fas fa-exclamation-circle"></i>
                            <strong>Out of Stock!</strong><br>
                            This item is completely out of stock and needs immediate restocking.
                        </div>
                    @elseif($inventory->isLowStock())
                        <div class="alert alert-warning">
                            <i class="fas fa-exclamation-triangle"></i>
                            <strong>Low Stock Alert!</strong><br>
                            Current quantity ({{ $inventory->quantity }}) is below minimum stock level ({{ $inventory->minimum_stock }}).
                        </div>
                    @elseif($inventory->needsReorder())
                        <div class="alert alert-info">
                            <i class="fas fa-info-circle"></i>
                            <strong>Reorder Recommended!</strong><br>
                            Current quantity ({{ $inventory->quantity }}) is at or below reorder level ({{ $inventory->reorder_level }}).
                        </div>
                    @else
                        <div class="alert alert-success">
                            <i class="fas fa-check-circle"></i>
                            <strong>Stock Levels Good!</strong><br>
                            Current stock levels are adequate.
                        </div>
                    @endif
                </div>
            </div>

            <!-- Enhanced Quick Links -->
            <div class="card shadow-lg border-0" style="border-radius: 12px; overflow: hidden;">
                <div class="card-header" style="background: linear-gradient(135deg, #4299e1 0%, #3182ce 100%); color: white; padding: 16px;">
                    <h6 class="m-0" style="font-weight: 700; font-size: 15px;">🔗 Quick Navigation</h6>
                </div>
                <div class="card-body p-3">
                    @if($inventory->product)
                    <a href="{{ route('admin.products.show', $inventory->product) }}" class="btn btn-outline-primary btn-block mb-3 enhanced-link-btn">
                        <div class="d-flex align-items-center">
                            <div class="link-icon me-3">
                                <i class="fas fa-box fa-lg"></i>
                            </div>
                            <div class="text-left">
                                <div style="font-weight: 600; font-size: 14px;">Product Details</div>
                                <div style="font-size: 11px; opacity: 0.7;">{{ Str::limit($inventory->product->name, 20) }}</div>
                            </div>
                        </div>
                    </a>
                    @endif
                    
                    @if($inventory->warehouse)
                    <a href="{{ route('admin.warehouses.show', $inventory->warehouse) }}" class="btn btn-outline-info btn-block mb-3 enhanced-link-btn">
                        <div class="d-flex align-items-center">
                            <div class="link-icon me-3">
                                <i class="fas fa-warehouse fa-lg"></i>
                            </div>
                            <div class="text-left">
                                <div style="font-weight: 600; font-size: 14px;">Warehouse Details</div>
                                <div style="font-size: 11px; opacity: 0.7;">{{ Str::limit($inventory->warehouse->name, 20) }}</div>
                            </div>
                        </div>
                    </a>
                    @endif
                    
                    <a href="{{ route('admin.inventory.analytics') }}" class="btn btn-outline-success btn-block mb-3 enhanced-link-btn">
                        <div class="d-flex align-items-center">
                            <div class="link-icon me-3">
                                <i class="fas fa-chart-bar fa-lg"></i>
                            </div>
                            <div class="text-left">
                                <div style="font-weight: 600; font-size: 14px;">Analytics Dashboard</div>
                                <div style="font-size: 11px; opacity: 0.7;">Performance insights</div>
                            </div>
                        </div>
                    </a>
                    
                    <a href="{{ route('admin.inventory.index') }}" class="btn btn-outline-dark btn-block enhanced-link-btn">
                        <div class="d-flex align-items-center">
                            <div class="link-icon me-3">
                                <i class="fas fa-list fa-lg"></i>
                            </div>
                            <div class="text-left">
                                <div style="font-weight: 600; font-size: 14px;">All Inventory</div>
                                <div style="font-size: 11px; opacity: 0.7;">Manage all records</div>
                            </div>
                        </div>
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Stock Adjustment Modal -->
<div class="modal fade" id="stockAdjustmentModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Stock Adjustment</h5>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>
            <form method="POST" action="{{ route('admin.inventory.adjustQuantity', $inventory) }}">
                @csrf
                <div class="modal-body">
                    <input type="hidden" name="adjustment_type" id="adjustmentType">
                    
                    <div class="form-group">
                        <label for="quantity">Quantity</label>
                        <input type="number" class="form-control" name="quantity" id="adjustmentQuantity" min="0" required>
                        <small class="form-text text-muted" id="adjustmentHelp"></small>
                    </div>
                    
                    <div class="form-group">
                        <label for="reason">Reason (Optional)</label>
                        <input type="text" class="form-control" name="reason" placeholder="e.g., Stock received, Damage, Sale, etc.">
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-primary" id="adjustmentSubmit">Apply Adjustment</button>
                </div>
            </form>
        </div>
    </div>
</div>

@push('styles')
<style>
.timeline {
    position: relative;
    padding-left: 30px;
}

.timeline-item {
    position: relative;
    margin-bottom: 20px;
}

.timeline-marker {
    position: absolute;
    left: -35px;
    top: 5px;
    width: 12px;
    height: 12px;
    border-radius: 50%;
}

.timeline-item:not(:last-child)::before {
    content: '';
    position: absolute;
    left: -29px;
    top: 17px;
    width: 2px;
    height: calc(100% + 15px);
    background-color: #e3e6f0;
}
</style>
@endpush

@push('styles')
<style>
/* Enhanced Action Button Styling */
.action-button {
    transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1) !important;
    border: 2px solid transparent !important;
    position: relative !important;
    overflow: hidden !important;
}

.action-button:hover {
    transform: translateY(-3px) scale(1.02) !important;
    box-shadow: 0 10px 25px rgba(0,0,0,0.15) !important;
}

.action-button:active {
    transform: translateY(-1px) scale(0.98) !important;
}

.action-button .action-icon {
    transition: transform 0.3s ease !important;
}

.action-button:hover .action-icon {
    transform: scale(1.1) rotate(5deg) !important;
}

/* Enhanced Link Button Styling */
.enhanced-link-btn {
    transition: all 0.3s ease !important;
    border-radius: 8px !important;
    padding: 12px 16px !important;
    text-decoration: none !important;
    border-width: 2px !important;
}

.enhanced-link-btn:hover {
    transform: translateY(-2px) !important;
    box-shadow: 0 6px 20px rgba(0,0,0,0.1) !important;
    text-decoration: none !important;
}

.enhanced-link-btn .link-icon {
    transition: transform 0.3s ease !important;
    width: 40px !important;
    display: flex !important;
    align-items: center !important;
    justify-content: center !important;
}

.enhanced-link-btn:hover .link-icon {
    transform: scale(1.15) !important;
}

/* Button Color Enhancements */
.btn-success {
    background: linear-gradient(135deg, #48bb78 0%, #38a169 100%) !important;
    border: none !important;
    color: #ffffff !important;
}

.btn-success:hover {
    background: linear-gradient(135deg, #38a169 0%, #2f855a 100%) !important;
    color: #ffffff !important;
}

.btn-warning {
    background: linear-gradient(135deg, #ed8936 0%, #dd6b20 100%) !important;
    border: none !important;
    color: #ffffff !important;
}

.btn-warning:hover {
    background: linear-gradient(135deg, #dd6b20 0%, #c05621 100%) !important;
    color: #ffffff !important;
}

.btn-info {
    background: linear-gradient(135deg, #4299e1 0%, #3182ce 100%) !important;
    border: none !important;
    color: #ffffff !important;
}

.btn-info:hover {
    background: linear-gradient(135deg, #3182ce 0%, #2c5282 100%) !important;
    color: #ffffff !important;
}

/* Loading States */
.action-button.loading {
    pointer-events: none !important;
    opacity: 0.7 !important;
}

.action-button.loading .action-icon {
    animation: spin 1s linear infinite !important;
}

@keyframes spin {
    from { transform: rotate(0deg); }
    to { transform: rotate(360deg); }
}

/* Pulse Effect for Emergency Actions */
.alert .btn {
    animation: pulse-glow 2s infinite !important;
}

@keyframes pulse-glow {
    0% { box-shadow: 0 0 5px rgba(0,0,0,0.1); }
    50% { box-shadow: 0 0 20px rgba(0,0,0,0.2), 0 0 30px rgba(255,255,255,0.1); }
    100% { box-shadow: 0 0 5px rgba(0,0,0,0.1); }
}

/* Responsive Improvements */
@media (max-width: 768px) {
    .action-button {
        margin-bottom: 10px !important;
    }
    
    .action-button .d-flex {
        flex-direction: column !important;
        text-align: center !important;
    }
    
    .action-button .action-icon {
        margin-right: 0 !important;
        margin-bottom: 8px !important;
    }
}
</style>
@endpush

@push('scripts')
<script>
// Enhanced stock adjustment function
function adjustStock(type) {
    const modal = $('#stockAdjustmentModal');
    const typeInput = document.getElementById('adjustmentType');
    const quantityInput = document.getElementById('adjustmentQuantity');
    const helpText = document.getElementById('adjustmentHelp');
    const submitBtn = document.getElementById('adjustmentSubmit');
    
    // Add loading state to button
    const clickedBtn = event.target.closest('.action-button');
    if (clickedBtn) {
        clickedBtn.classList.add('loading');
        setTimeout(() => clickedBtn.classList.remove('loading'), 1000);
    }
    
    typeInput.value = type;
    
    switch(type) {
        case 'add':
            modal.find('.modal-title').html('<i class="fas fa-plus-circle text-success me-2"></i>Add Stock');
            helpText.innerHTML = '<i class="fas fa-info-circle text-info me-1"></i>Enter the quantity to add to current stock.';
            submitBtn.innerHTML = '<i class="fas fa-plus me-1"></i>Add Stock';
            submitBtn.className = 'btn btn-success';
            quantityInput.min = '1';
            quantityInput.placeholder = 'e.g., 50';
            break;
        case 'subtract':
            modal.find('.modal-title').html('<i class="fas fa-minus-circle text-warning me-2"></i>Remove Stock');
            helpText.innerHTML = '<i class="fas fa-exclamation-triangle text-warning me-1"></i>Enter the quantity to subtract from current stock.';
            submitBtn.innerHTML = '<i class="fas fa-minus me-1"></i>Remove Stock';
            submitBtn.className = 'btn btn-warning';
            quantityInput.min = '1';
            quantityInput.placeholder = 'e.g., 25';
            break;
        case 'set':
            modal.find('.modal-title').html('<i class="fas fa-edit text-info me-2"></i>Set Stock Quantity');
            helpText.innerHTML = '<i class="fas fa-cog text-info me-1"></i>Enter the new stock quantity (current: {{ $inventory->quantity }}).';
            submitBtn.innerHTML = '<i class="fas fa-save me-1"></i>Set Quantity';
            submitBtn.className = 'btn btn-info';
            quantityInput.min = '0';
            quantityInput.placeholder = 'e.g., 100';
            break;
    }
    
    quantityInput.value = '';
    quantityInput.focus();
    modal.modal('show');
}

// Additional interactive functions
function viewStockHistory() {
    showNotification('Stock history feature coming soon!', 'info');
}

function generateStockReport() {
    showNotification('Generating stock report...', 'info');
    
    setTimeout(() => {
        showNotification('Stock report generated successfully!', 'success');
    }, 2000);
}

function emergencyRestock() {
    const isOutOfStock = {{ $inventory->isOutOfStock() ? 'true' : 'false' }};
    const message = isOutOfStock ? 
        'Emergency restock order initiated!' : 
        'Low stock reorder scheduled!';
    
    showNotification(message, 'success');
}

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
    
    // Auto remove after 4 seconds
    setTimeout(() => {
        if (notification.parentNode) {
            notification.remove();
        }
    }, 4000);
}

// Add hover effects on page load
document.addEventListener('DOMContentLoaded', function() {
    // Add ripple effect to action buttons
    const actionButtons = document.querySelectorAll('.action-button');
    actionButtons.forEach(button => {
        button.addEventListener('click', function(e) {
            const ripple = document.createElement('span');
            const rect = this.getBoundingClientRect();
            const size = Math.max(rect.width, rect.height);
            const x = e.clientX - rect.left - size / 2;
            const y = e.clientY - rect.top - size / 2;
            
            ripple.style.cssText = `
                position: absolute;
                width: ${size}px;
                height: ${size}px;
                left: ${x}px;
                top: ${y}px;
                background: rgba(255,255,255,0.3);
                border-radius: 50%;
                transform: scale(0);
                animation: ripple 0.6s ease-out;
                pointer-events: none;
            `;
            
            this.appendChild(ripple);
            
            setTimeout(() => {
                if (ripple.parentNode) {
                    ripple.remove();
                }
            }, 600);
        });
    });
});

// Add ripple animation
const style = document.createElement('style');
style.textContent = `
    @keyframes ripple {
        to {
            transform: scale(2);
            opacity: 0;
        }
    }
`;
document.head.appendChild(style);
</script>
@endpush
@endsection
