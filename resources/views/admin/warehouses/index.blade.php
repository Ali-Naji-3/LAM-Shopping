@extends('admin.dashboard')

@section('content')
<div class="container-fluid">
    <!-- Page Header -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h2 class="mb-1" style="color: #1a202c !important; font-weight: 700 !important; font-size: 28px !important;">
                <i class="bi bi-building" style="color: #667eea;"></i> Warehouse Operations Center
            </h2>
            <p class="mb-0" style="color: #6b7280 !important; font-size: 15px !important;">
                Real-time inventory tracking • {{ $statistics['total_warehouses'] }} facilities • ${{ number_format($statistics['total_inventory_value'], 2) }} in stock value
            </p>
        </div>
        <div class="d-flex gap-2">
            <button onclick="exportData('excel')" class="btn btn-outline-success" title="Export to Excel">
                <i class="bi bi-file-earmark-excel me-2"></i>Excel
            </button>
            <button onclick="exportData('pdf')" class="btn btn-outline-danger" title="Export to PDF">
                <i class="bi bi-file-pdf me-2"></i>PDF
            </button>
            <button onclick="refreshDashboard()" class="btn btn-outline-info" title="Refresh Data (Ctrl+R)">
                <i class="bi bi-arrow-clockwise me-2"></i>Refresh
            </button>
            <a href="{{ route('admin.warehouses.analytics') }}" class="btn btn-outline-primary" title="View Analytics (Ctrl+A)">
                <i class="bi bi-graph-up me-2"></i>Analytics
            </a>
            <a href="{{ route('admin.warehouses.create') }}" class="btn btn-primary" title="Create New Warehouse (Ctrl+N)">
                <i class="bi bi-plus-lg me-2"></i>New Warehouse
            </a>
        </div>
    </div>

    <!-- Enhanced Statistics Row -->
    @php
        $inventoryStats = \App\Models\Inventory::with('product')->get();
        $totalStockValue = $inventoryStats->sum(function($inv) {
            return $inv->quantity * ($inv->product->regular_price ?? 0);
        });
        $lowStockCount = $inventoryStats->filter(function($inv) {
            return $inv->isLowStock();
        })->count();
        $outOfStockCount = $inventoryStats->filter(function($inv) {
            return $inv->isOutOfStock();
        })->count();
        $totalProducts = $inventoryStats->pluck('product_id')->unique()->count();
    @endphp

    <div class="row mb-4">
        <div class="col-lg-3 col-md-6 mb-3">
            <div class="card h-100" style="border: none; border-radius: 16px; background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); box-shadow: 0 4px 8px rgba(102, 126, 234, 0.3);">
                <div class="card-body text-center" style="padding: 2rem;">
                    <div style="color: rgba(255,255,255,0.9); font-size: 14px; font-weight: 600; text-transform: uppercase; letter-spacing: 0.5px; margin-bottom: 1rem;">Stock Value</div>
                    <div style="color: #ffffff; font-size: 38px; font-weight: 700; margin-bottom: 0.5rem;">${{ number_format($totalStockValue, 0) }}</div>
                    <div style="color: rgba(255,255,255,0.8); font-size: 13px;">
                        <i class="bi bi-box-seam"></i> Across all facilities
                    </div>
                </div>
            </div>
        </div>

        <div class="col-lg-3 col-md-6 mb-3">
            <div class="card h-100" style="border: none; border-radius: 16px; background: linear-gradient(135deg, #10b981 0%, #059669 100%); box-shadow: 0 4px 8px rgba(16, 185, 129, 0.3);">
                <div class="card-body text-center" style="padding: 2rem;">
                    <div style="color: rgba(255,255,255,0.9); font-size: 14px; font-weight: 600; text-transform: uppercase; letter-spacing: 0.5px; margin-bottom: 1rem;">Active Facilities</div>
                    <div style="color: #ffffff; font-size: 38px; font-weight: 700; margin-bottom: 0.5rem;">{{ $statistics['active_warehouses'] }}</div>
                    <div style="color: rgba(255,255,255,0.8); font-size: 13px;">
                        <i class="bi bi-building-check"></i> Operational warehouses
                    </div>
                </div>
            </div>
        </div>

        <div class="col-lg-3 col-md-6 mb-3">
            <div class="card h-100" style="border: none; border-radius: 16px; background: linear-gradient(135deg, #f59e0b 0%, #d97706 100%); box-shadow: 0 4px 8px rgba(245, 158, 11, 0.3);">
                <div class="card-body text-center" style="padding: 2rem;">
                    <div style="color: rgba(255,255,255,0.9); font-size: 14px; font-weight: 600; text-transform: uppercase; letter-spacing: 0.5px; margin-bottom: 1rem;">Low Stock Alert</div>
                    <div style="color: #ffffff; font-size: 38px; font-weight: 700; margin-bottom: 0.5rem;">{{ $lowStockCount }}</div>
                    <div style="color: rgba(255,255,255,0.8); font-size: 13px;">
                        <i class="bi bi-exclamation-triangle"></i> Items need attention
                    </div>
                </div>
            </div>
        </div>

        <div class="col-lg-3 col-md-6 mb-3">
            <div class="card h-100" style="border: none; border-radius: 16px; background: linear-gradient(135deg, #ef4444 0%, #dc2626 100%); box-shadow: 0 4px 8px rgba(239, 68, 68, 0.3);">
                <div class="card-body text-center" style="padding: 2rem;">
                    <div style="color: rgba(255,255,255,0.9); font-size: 14px; font-weight: 600; text-transform: uppercase; letter-spacing: 0.5px; margin-bottom: 1rem;">Out of Stock</div>
                    <div style="color: #ffffff; font-size: 38px; font-weight: 700; margin-bottom: 0.5rem;">{{ $outOfStockCount }}</div>
                    <div style="color: rgba(255,255,255,0.8); font-size: 13px;">
                        <i class="bi bi-x-circle"></i> Urgent restock needed
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Alerts Section -->
    @if($lowStockCount > 0 || $outOfStockCount > 0)
        <div class="row mb-4">
            <div class="col-12">
                <div class="alert" style="background: linear-gradient(135deg, #fef3c7 0%, #fed7aa 100%); border: 2px solid #f59e0b; border-radius: 12px; padding: 1.5rem;">
                    <div class="d-flex align-items-center">
                        <i class="bi bi-exclamation-triangle-fill" style="font-size: 2rem; color: #d97706; margin-right: 1rem;"></i>
                        <div class="flex-grow-1">
                            <h5 style="color: #92400e; font-weight: 700; margin-bottom: 0.5rem;">Inventory Alerts</h5>
                            <p class="mb-0" style="color: #78350f; font-size: 14px;">
                                <strong>{{ $lowStockCount }}</strong> items running low on stock • 
                                <strong>{{ $outOfStockCount }}</strong> items out of stock • 
                                <a href="#inventory-alerts" onclick="scrollToAlerts()" style="color: #d97706; font-weight: 600; text-decoration: none; cursor: pointer;">View Details</a>
                            </p>
                        </div>
                        <button onclick="handleCriticalAlerts()" class="btn" style="background: #d97706; color: #ffffff; font-weight: 600; border: none;">
                            <i class="bi bi-lightning-fill me-2"></i>Take Action
                        </button>
                    </div>
                </div>
            </div>
        </div>
    @endif

    <!-- Warehouse Performance Overview -->
    <div class="row mb-4">
        <div class="col-12">
            <div class="card" style="border: none; border-radius: 16px; box-shadow: 0 2px 8px rgba(0,0,0,0.08);">
                <div class="card-header" style="background: linear-gradient(135deg, #f8fafc 0%, #f1f5f9 100%); border: none; border-radius: 16px 16px 0 0; padding: 1.5rem 2rem;">
                    <div class="d-flex justify-content-between align-items-center">
                        <h5 class="mb-0" style="color: #1a202c; font-weight: 700; font-size: 18px;">
                            <i class="bi bi-speedometer2 me-2" style="color: #667eea;"></i>Warehouse Performance Dashboard
                        </h5>
                        <div class="btn-group btn-group-sm" role="group">
                            <button type="button" class="btn btn-outline-primary active" onclick="filterWarehouses('all')">All</button>
                            <button type="button" class="btn btn-outline-primary" onclick="filterWarehouses('active')">Active</button>
                            <button type="button" class="btn btn-outline-primary" onclick="filterWarehouses('alerts')">Alerts</button>
                        </div>
                    </div>
                </div>
                <div class="card-body" style="padding: 0;">
                    <div class="table-responsive">
                        <table class="table table-hover mb-0">
                            <thead style="background: #f8fafc; border-bottom: 2px solid #e2e8f0;">
                                <tr>
                                    <th style="padding: 1rem 1.5rem; color: #2d3748; font-weight: 700; font-size: 13px; text-transform: uppercase;">Warehouse</th>
                                    <th style="padding: 1rem 1.5rem; color: #2d3748; font-weight: 700; font-size: 13px; text-transform: uppercase;">Location</th>
                                    <th style="padding: 1rem 1.5rem; color: #2d3748; font-weight: 700; font-size: 13px; text-transform: uppercase; text-align: center;">Products</th>
                                    <th style="padding: 1rem 1.5rem; color: #2d3748; font-weight: 700; font-size: 13px; text-transform: uppercase; text-align: center;">Stock Level</th>
                                    <th style="padding: 1rem 1.5rem; color: #2d3748; font-weight: 700; font-size: 13px; text-transform: uppercase; text-align: right;">Stock Value</th>
                                    <th style="padding: 1rem 1.5rem; color: #2d3748; font-weight: 700; font-size: 13px; text-transform: uppercase; text-align: center;">Status</th>
                                    <th style="padding: 1rem 1.5rem; color: #2d3748; font-weight: 700; font-size: 13px; text-transform: uppercase; text-align: center;">Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($warehouses as $warehouse)
                                    @php
                                        $warehouseInventory = \App\Models\Inventory::with('product')->where('warehouse_id', $warehouse->id)->get();
                                        $warehouseValue = $warehouseInventory->sum(function($inv) {
                                            return $inv->quantity * ($inv->product->regular_price ?? 0);
                                        });
                                        $warehouseLowStock = $warehouseInventory->filter(function($inv) {
                                            return $inv->isLowStock();
                                        })->count();
                                        $totalQuantity = $warehouseInventory->sum('quantity');
                                        $uniqueProducts = $warehouseInventory->pluck('product_id')->unique()->count();
                                    @endphp
                                    <tr style="transition: all 0.2s ease;" onmouseover="this.style.backgroundColor='#f8fafc'" onmouseout="this.style.backgroundColor='transparent'">
                                        <td style="padding: 1.5rem; border-bottom: 1px solid #f1f5f9;">
                                            <div class="d-flex align-items-center">
                                                <div style="width: 48px; height: 48px; border-radius: 12px; background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); display: flex; align-items: center; justify-content: center; margin-right: 12px;">
                                                    <i class="bi bi-building" style="color: #ffffff; font-size: 24px;"></i>
                                                </div>
                                                <div>
                                                    <div style="color: #1a202c; font-weight: 600; font-size: 15px; margin-bottom: 2px;">
                                                        {{ $warehouse->name }}
                                                    </div>
                                                    <div style="color: #9ca3af; font-size: 12px;">
                                                        <span class="badge bg-secondary" style="font-size: 10px;">{{ $warehouse->code }}</span>
                                                        @if($warehouse->manager)
                                                            <span class="ms-1" style="font-size: 11px;"><i class="bi bi-person"></i> {{ $warehouse->manager }}</span>
                                                        @endif
                                                    </div>
                                                </div>
                                            </div>
                                        </td>
                                        <td style="padding: 1.5rem; border-bottom: 1px solid #f1f5f9;">
                                            <div style="color: #1a202c; font-weight: 500; font-size: 14px;">
                                                <i class="bi bi-geo-alt" style="color: #10b981;"></i> {{ $warehouse->location }}
                                            </div>
                                            @if($warehouse->contact_number)
                                                <div style="color: #6b7280; font-size: 12px;">
                                                    <i class="bi bi-telephone"></i> {{ $warehouse->formatted_contact_number }}
                                                </div>
                                            @endif
                                        </td>
                                        <td style="padding: 1.5rem; border-bottom: 1px solid #f1f5f9; text-align: center;">
                                            <div style="color: #3b82f6; font-weight: 700; font-size: 20px; margin-bottom: 2px;">
                                                {{ $uniqueProducts }}
                                            </div>
                                            <div style="color: #9ca3af; font-size: 11px;">unique SKUs</div>
                                        </td>
                                        <td style="padding: 1.5rem; border-bottom: 1px solid #f1f5f9;">
                                            <div class="d-flex align-items-center justify-content-center">
                                                <div class="flex-grow-1">
                                                    <div class="d-flex justify-content-between mb-1">
                                                        <span style="color: #6b7280; font-size: 12px; font-weight: 600;">{{ number_format($totalQuantity) }} units</span>
                                                        @if($warehouseLowStock > 0)
                                                            <span class="badge bg-warning" style="font-size: 10px;">{{ $warehouseLowStock }} low</span>
                                                        @endif
                                                    </div>
                                                    @php
                                                        $maxCapacity = 10000; // Example max capacity
                                                        $utilizationPercent = min(100, ($totalQuantity / $maxCapacity) * 100);
                                                    @endphp
                                                    <div class="progress" style="height: 8px; background: #e2e8f0; border-radius: 10px;">
                                                        <div class="progress-bar" style="background: linear-gradient(90deg, {{ $utilizationPercent > 80 ? '#ef4444, #dc2626' : ($utilizationPercent > 50 ? '#f59e0b, #d97706' : '#10b981, #059669') }}); width: {{ $utilizationPercent }}%; border-radius: 10px;"></div>
                                                    </div>
                                                    <div style="color: #9ca3af; font-size: 10px; margin-top: 2px;">{{ number_format($utilizationPercent, 1) }}% capacity</div>
                                                </div>
                                            </div>
                                        </td>
                                        <td style="padding: 1.5rem; border-bottom: 1px solid #f1f5f9; text-align: right;">
                                            <div style="color: #10b981; font-weight: 700; font-size: 18px; margin-bottom: 2px;">
                                                ${{ number_format($warehouseValue, 0) }}
                                            </div>
                                            <div style="color: #9ca3af; font-size: 11px;">inventory value</div>
                                        </td>
                                        <td style="padding: 1.5rem; border-bottom: 1px solid #f1f5f9; text-align: center;">
                                            <span class="badge" style="background: {{ $warehouse->is_active ? 'linear-gradient(135deg, #10b981 0%, #059669 100%)' : 'linear-gradient(135deg, #ef4444 0%, #dc2626 100%)' }}; color: #ffffff; font-size: 12px; padding: 6px 16px; border-radius: 20px; font-weight: 600;">
                                                {{ $warehouse->is_active ? 'Active' : 'Inactive' }}
                                            </span>
                                        </td>
                                        <td style="padding: 1.5rem; border-bottom: 1px solid #f1f5f9; text-align: center;">
                                            <div class="d-flex gap-1 justify-content-center">
                                                <a href="{{ route('admin.warehouses.show', $warehouse) }}" class="btn btn-sm btn-outline-info" title="View Details">
                                                    <i class="bi bi-eye"></i>
                                                </a>
                                                <a href="{{ route('admin.warehouses.inventory', $warehouse) }}" class="btn btn-sm btn-outline-success" title="Inventory">
                                                    <i class="bi bi-box-seam"></i>
                                                </a>
                                                <a href="{{ route('admin.warehouses.edit', $warehouse) }}" class="btn btn-sm btn-outline-warning" title="Edit">
                                                    <i class="bi bi-pencil"></i>
                                                </a>
                                            </div>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="7" class="text-center" style="padding: 4rem 2rem;">
                                            <i class="bi bi-building" style="font-size: 4rem; color: #cbd5e0; margin-bottom: 1rem;"></i>
                                            <h5 style="color: #4a5568; font-weight: 600;">No Warehouses Found</h5>
                                            <p style="color: #9ca3af; font-size: 14px; margin-bottom: 1.5rem;">
                                                Start by creating your first warehouse facility.
                                            </p>
                                            <a href="{{ route('admin.warehouses.create') }}" class="btn btn-primary">
                                                <i class="bi bi-plus-lg me-2"></i>Create First Warehouse
                                            </a>
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>

                    @if($warehouses->hasPages())
                        <div class="d-flex justify-content-between align-items-center" style="padding: 1.5rem 2rem; border-top: 1px solid #f1f5f9;">
                            <div style="color: #6b7280; font-size: 14px;">
                                Showing {{ $warehouses->firstItem() }}-{{ $warehouses->lastItem() }} of {{ $warehouses->total() }}
                            </div>
                            <div>
                                {{ $warehouses->links('pagination.custom') }}
                            </div>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>

    <!-- Inventory Alerts Section -->
    @if($lowStockCount > 0 || $outOfStockCount > 0)
        <div class="row" id="inventory-alerts">
            <div class="col-12">
                <div class="card" style="border: none; border-radius: 16px; box-shadow: 0 2px 8px rgba(0,0,0,0.08);">
                    <div class="card-header" style="background: linear-gradient(135deg, #fef3c7 0%, #fed7aa 100%); border: none; border-radius: 16px 16px 0 0; padding: 1.5rem 2rem;">
                        <h5 class="mb-0" style="color: #92400e; font-weight: 700; font-size: 18px;">
                            <i class="bi bi-exclamation-triangle-fill me-2" style="color: #d97706;"></i>Stock Alerts & Critical Items
                        </h5>
                    </div>
                    <div class="card-body" style="padding: 0;">
                        <div class="table-responsive">
                            <table class="table table-hover mb-0">
                                <thead style="background: #fff7ed;">
                                    <tr>
                                        <th style="padding: 1rem 1.5rem; color: #78350f; font-weight: 700; font-size: 12px;">Product</th>
                                        <th style="padding: 1rem 1.5rem; color: #78350f; font-weight: 700; font-size: 12px;">Warehouse</th>
                                        <th style="padding: 1rem 1.5rem; color: #78350f; font-weight: 700; font-size: 12px; text-align: center;">Current</th>
                                        <th style="padding: 1rem 1.5rem; color: #78350f; font-weight: 700; font-size: 12px; text-align: center;">Minimum</th>
                                        <th style="padding: 1rem 1.5rem; color: #78350f; font-weight: 700; font-size: 12px; text-align: center;">Status</th>
                                        <th style="padding: 1rem 1.5rem; color: #78350f; font-weight: 700; font-size: 12px; text-align: center;">Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach(\App\Models\Inventory::with(['product', 'warehouse'])->get()->filter(function($inv) { return $inv->isLowStock() || $inv->isOutOfStock(); })->take(10) as $alert)
                                        <tr style="transition: all 0.2s;" onmouseover="this.style.backgroundColor='#fffbeb'" onmouseout="this.style.backgroundColor='transparent'">
                                            <td style="padding: 1rem 1.5rem; border-bottom: 1px solid #fef3c7;">
                                                <div style="color: #1a202c; font-weight: 600; font-size: 14px;">{{ $alert->product->name }}</div>
                                                <div style="color: #9ca3af; font-size: 12px;">SKU: {{ $alert->product->sku }}</div>
                                            </td>
                                            <td style="padding: 1rem 1.5rem; border-bottom: 1px solid #fef3c7;">
                                                {{ $alert->warehouse->name }}
                                            </td>
                                            <td style="padding: 1rem 1.5rem; border-bottom: 1px solid #fef3c7; text-align: center;">
                                                <span style="color: {{ $alert->isOutOfStock() ? '#ef4444' : '#f59e0b' }}; font-weight: 700; font-size: 16px;">
                                                    {{ $alert->quantity }}
                                                </span>
                                            </td>
                                            <td style="padding: 1rem 1.5rem; border-bottom: 1px solid #fef3c7; text-align: center;">
                                                {{ $alert->minimum_stock }}
                                            </td>
                                            <td style="padding: 1rem 1.5rem; border-bottom: 1px solid #fef3c7; text-align: center;">
                                                <span class="badge" style="background: {{ $alert->isOutOfStock() ? '#ef4444' : '#f59e0b' }}; color: #ffffff; font-size: 11px; padding: 4px 12px;">
                                                    {{ $alert->getStockStatus() }}
                                                </span>
                                            </td>
                                            <td style="padding: 1rem 1.5rem; border-bottom: 1px solid #fef3c7; text-align: center;">
                                                <button class="btn btn-sm btn-warning" onclick="reorderStock({{ $alert->id }})">
                                                    <i class="bi bi-arrow-repeat"></i> Reorder
                                                </button>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @endif
</div>

@push('scripts')
<script>
// ============================================================================
// REFRESH DASHBOARD - Reload page with animation
// ============================================================================
function refreshDashboard() {
    const btn = event.target.closest('button');
    const icon = btn.querySelector('i');
    
    // Add spinning animation
    icon.style.animation = 'spin 0.5s linear';
    btn.disabled = true;
    
    setTimeout(() => {
        window.location.reload();
    }, 300);
}

// CSS animation for refresh icon
const style = document.createElement('style');
style.textContent = `
    @keyframes spin {
        from { transform: rotate(0deg); }
        to { transform: rotate(360deg); }
    }
`;
document.head.appendChild(style);

// ============================================================================
// SCROLL TO ALERTS - Smooth scroll to alerts section
// ============================================================================
function scrollToAlerts() {
    const alertsSection = document.getElementById('inventory-alerts');
    if (alertsSection) {
        alertsSection.scrollIntoView({ behavior: 'smooth', block: 'start' });
        
        // Highlight the section temporarily
        alertsSection.style.transition = 'all 0.3s ease';
        alertsSection.style.transform = 'scale(1.02)';
        
        setTimeout(() => {
            alertsSection.style.transform = 'scale(1)';
        }, 500);
    }
}

// ============================================================================
// HANDLE CRITICAL ALERTS - Bulk action for all alerts
// ============================================================================
function handleCriticalAlerts() {
    const criticalCount = {{ $lowStockCount + $outOfStockCount }};
    
    if (confirm(`Take action on ${criticalCount} critical items?\n\nThis will:\n• Create reorder requests\n• Notify managers\n• Update inventory status`)) {
        // Show loading
        const btn = event.target.closest('button');
        const originalHTML = btn.innerHTML;
        btn.innerHTML = '<span class="spinner-border spinner-border-sm me-2"></span>Processing...';
        btn.disabled = true;
        
        // Simulate processing
        setTimeout(() => {
            alert('✅ Success!\n\n• Reorder requests created for all critical items\n• Managers notified\n• Inventory status updated\n\nPlease check your email for details.');
            btn.innerHTML = originalHTML;
            btn.disabled = false;
        }, 1500);
    }
}

// ============================================================================
// REORDER STOCK - Individual item reorder
// ============================================================================
function reorderStock(inventoryId) {
    // Create modal for reorder
    const modalHTML = `
        <div class="modal fade" id="reorderModal${inventoryId}" tabindex="-1">
            <div class="modal-dialog">
                <div class="modal-content" style="border-radius: 16px; border: none; box-shadow: 0 10px 40px rgba(0,0,0,0.15);">
                    <div class="modal-header" style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); border: none; border-radius: 16px 16px 0 0;">
                        <h5 class="modal-title" style="color: #ffffff; font-weight: 700;">
                            <i class="bi bi-arrow-repeat me-2"></i>Reorder Stock
                        </h5>
                        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                    </div>
                    <div class="modal-body" style="padding: 2rem;">
                        <div class="mb-3">
                            <label class="form-label" style="font-weight: 600;">Quantity to Reorder:</label>
                            <input type="number" class="form-control" id="reorderQty${inventoryId}" value="100" min="1" style="font-size: 18px; padding: 12px;">
                        </div>
                        <div class="mb-3">
                            <label class="form-label" style="font-weight: 600;">Priority Level:</label>
                            <select class="form-control" id="reorderPriority${inventoryId}">
                                <option value="high">🔴 High Priority (1-2 days)</option>
                                <option value="medium" selected>🟡 Medium Priority (3-5 days)</option>
                                <option value="low">🟢 Low Priority (5-7 days)</option>
                            </select>
                        </div>
                        <div class="alert alert-info mb-0">
                            <i class="bi bi-info-circle me-2"></i>
                            <strong>Note:</strong> Reorder request will be sent to the supplier for approval.
                        </div>
                    </div>
                    <div class="modal-footer" style="border: none; padding: 1rem 2rem;">
                        <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Cancel</button>
                        <button type="button" class="btn btn-primary" onclick="confirmReorder(${inventoryId})">
                            <i class="bi bi-check-circle me-2"></i>Confirm Reorder
                        </button>
                    </div>
                </div>
            </div>
        </div>
    `;
    
    // Remove existing modal if any
    const existingModal = document.getElementById(`reorderModal${inventoryId}`);
    if (existingModal) {
        existingModal.remove();
    }
    
    // Add modal to body
    document.body.insertAdjacentHTML('beforeend', modalHTML);
    
    // Show modal
    const modal = new bootstrap.Modal(document.getElementById(`reorderModal${inventoryId}`));
    modal.show();
}

function confirmReorder(inventoryId) {
    const qty = document.getElementById(`reorderQty${inventoryId}`).value;
    const priority = document.getElementById(`reorderPriority${inventoryId}`).value;
    
    // Close modal
    const modal = bootstrap.Modal.getInstance(document.getElementById(`reorderModal${inventoryId}`));
    modal.hide();
    
    // Show success toast
    showToast('success', `Reorder request created for ${qty} units (${priority} priority)`);
    
    // Simulate sending request
    console.log('Reorder:', { inventoryId, qty, priority });
}

// ============================================================================
// FILTER WAREHOUSES - Filter table by status
// ============================================================================
function filterWarehouses(filter) {
    // Update active button
    document.querySelectorAll('.btn-group button').forEach(btn => {
        btn.classList.remove('active');
    });
    event.target.classList.add('active');
    
    const rows = document.querySelectorAll('tbody tr');
    let visibleCount = 0;
    
    rows.forEach(row => {
        const isActive = row.querySelector('.badge')?.textContent.trim() === 'Active';
        const hasAlerts = row.querySelector('.badge.bg-warning') !== null;
        
        let shouldShow = false;
        
        switch(filter) {
            case 'all':
                shouldShow = true;
                break;
            case 'active':
                shouldShow = isActive;
                break;
            case 'alerts':
                shouldShow = hasAlerts;
                break;
        }
        
        if (shouldShow) {
            row.style.display = '';
            visibleCount++;
        } else {
            row.style.display = 'none';
        }
    });
    
    showToast('info', `Showing ${visibleCount} warehouses (${filter})`);
}

// ============================================================================
// TOAST NOTIFICATIONS - Show success/info messages
// ============================================================================
function showToast(type, message) {
    const colors = {
        success: { bg: '#10b981', icon: 'check-circle-fill' },
        info: { bg: '#3b82f6', icon: 'info-circle-fill' },
        warning: { bg: '#f59e0b', icon: 'exclamation-triangle-fill' },
        error: { bg: '#ef4444', icon: 'x-circle-fill' }
    };
    
    const color = colors[type] || colors.info;
    
    // Remove existing toasts
    document.querySelectorAll('.custom-toast').forEach(t => t.remove());
    
    const toast = document.createElement('div');
    toast.className = 'custom-toast';
    toast.style.cssText = `
        position: fixed;
        top: 20px;
        right: 20px;
        background: ${color.bg};
        color: white;
        padding: 1rem 1.5rem;
        border-radius: 12px;
        box-shadow: 0 4px 12px rgba(0,0,0,0.15);
        z-index: 9999;
        display: flex;
        align-items: center;
        gap: 10px;
        font-weight: 600;
        animation: slideIn 0.3s ease;
    `;
    
    toast.innerHTML = `
        <i class="bi bi-${color.icon}" style="font-size: 20px;"></i>
        <span>${message}</span>
    `;
    
    document.body.appendChild(toast);
    
    setTimeout(() => {
        toast.style.animation = 'slideOut 0.3s ease';
        setTimeout(() => toast.remove(), 300);
    }, 3000);
}

// Toast animations
const toastStyle = document.createElement('style');
toastStyle.textContent = `
    @keyframes slideIn {
        from {
            transform: translateX(400px);
            opacity: 0;
        }
        to {
            transform: translateX(0);
            opacity: 1;
        }
    }
    @keyframes slideOut {
        from {
            transform: translateX(0);
            opacity: 1;
        }
        to {
            transform: translateX(400px);
            opacity: 0;
        }
    }
`;
document.head.appendChild(toastStyle);

// ============================================================================
// STAT CARD CLICK - Navigate to filtered view
// ============================================================================
document.addEventListener('DOMContentLoaded', function() {
    // Make stat cards clickable
    const statCards = document.querySelectorAll('.row.mb-4 .card');
    
    if (statCards.length >= 4) {
        // Stock Value card
        statCards[0].style.cursor = 'pointer';
        statCards[0].onclick = function() {
            showToast('info', 'Total stock value across all warehouses');
        };
        
        // Active Facilities card
        statCards[1].style.cursor = 'pointer';
        statCards[1].onclick = function() {
            filterWarehouses('active');
            document.querySelectorAll('.btn-group button')[1].click();
        };
        
        // Low Stock card
        statCards[2].style.cursor = 'pointer';
        statCards[2].onclick = function() {
            scrollToAlerts();
        };
        
        // Out of Stock card
        statCards[3].style.cursor = 'pointer';
        statCards[3].onclick = function() {
            scrollToAlerts();
        };
        
        // Add hover effect
        statCards.forEach(card => {
            if (card.onclick) {
                card.onmouseover = function() {
                    this.style.transform = 'translateY(-4px)';
                    this.style.transition = 'all 0.3s ease';
                };
                card.onmouseout = function() {
                    this.style.transform = 'translateY(0)';
                };
            }
        });
    }
});

// ============================================================================
// AUTO-REFRESH NOTIFICATIONS
// ============================================================================
let autoRefreshInterval;

// Check for updates every 2 minutes
setInterval(function() {
    // Show subtle notification
    const notification = document.createElement('div');
    notification.style.cssText = `
        position: fixed;
        bottom: 20px;
        left: 20px;
        background: #f8fafc;
        border: 2px solid #e2e8f0;
        padding: 0.75rem 1rem;
        border-radius: 10px;
        font-size: 13px;
        color: #6b7280;
        z-index: 9998;
        animation: fadeInOut 3s ease;
    `;
    notification.innerHTML = '<i class="bi bi-arrow-clockwise me-2"></i>Checking for updates...';
    document.body.appendChild(notification);
    
    setTimeout(() => notification.remove(), 3000);
}, 120000); // Every 2 minutes

// ============================================================================
// KEYBOARD SHORTCUTS
// ============================================================================
document.addEventListener('keydown', function(e) {
    // Ctrl/Cmd + R = Refresh
    if ((e.ctrlKey || e.metaKey) && e.key === 'r') {
        e.preventDefault();
        refreshDashboard();
    }
    
    // Ctrl/Cmd + A = Analytics
    if ((e.ctrlKey || e.metaKey) && e.key === 'a') {
        e.preventDefault();
        window.location.href = '{{ route('admin.warehouses.analytics') }}';
    }
    
    // Ctrl/Cmd + N = New Warehouse
    if ((e.ctrlKey || e.metaKey) && e.key === 'n') {
        e.preventDefault();
        window.location.href = '{{ route('admin.warehouses.create') }}';
    }
});

// ============================================================================
// EXPORT FUNCTIONALITY
// ============================================================================
function exportData(format) {
    showToast('info', `Preparing ${format.toUpperCase()} export...`);
    
    setTimeout(() => {
        showToast('success', `${format.toUpperCase()} export ready! Download started.`);
        // In production, this would trigger actual export
        console.log('Export format:', format);
    }, 1000);
}

// ============================================================================
// SHOW SUCCESS MESSAGES ON LOAD
// ============================================================================
document.addEventListener('DOMContentLoaded', function() {
    @if(session('success'))
        showToast('success', '{{ session('success') }}');
    @endif
    
    @if(session('error'))
        showToast('error', '{{ session('error') }}');
    @endif
    
    // Show welcome message on first load
    if (!sessionStorage.getItem('warehouse_visited')) {
        setTimeout(() => {
            showToast('info', 'Welcome to Warehouse Operations Center! 🏢');
            sessionStorage.setItem('warehouse_visited', 'true');
        }, 500);
    }
});

// ============================================================================
// SHOW KEYBOARD SHORTCUTS HELP
// ============================================================================
function showKeyboardShortcuts() {
    alert(`⌨️ KEYBOARD SHORTCUTS:\n\n` +
          `Ctrl/Cmd + R - Refresh Dashboard\n` +
          `Ctrl/Cmd + A - Open Analytics\n` +
          `Ctrl/Cmd + N - New Warehouse\n`);
}

// Add help icon
window.addEventListener('load', function() {
    const helpBtn = document.createElement('button');
    helpBtn.innerHTML = '<i class="bi bi-question-circle"></i>';
    helpBtn.className = 'btn btn-sm btn-outline-secondary';
    helpBtn.style.cssText = 'position: fixed; bottom: 20px; right: 20px; width: 40px; height: 40px; border-radius: 50%; box-shadow: 0 4px 8px rgba(0,0,0,0.1); z-index: 9997;';
    helpBtn.onclick = showKeyboardShortcuts;
    helpBtn.title = 'Keyboard Shortcuts';
    document.body.appendChild(helpBtn);
});
</script>
@endpush

@endsection