@extends('admin.dashboard')

@section('content')
<div class="container-fluid">
    <!-- Page Header -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h2 class="mb-1" style="color: #1a202c !important; font-weight: 700 !important; font-size: 24px !important;">
                📦 Warehouse Inventory
            </h2>
            <p class="mb-0" style="color: #4a5568 !important; font-size: 14px !important;">
                {{ $warehouse->name }} • {{ $warehouse->code }} • Inventory Management
            </p>
        </div>
        <div class="d-flex gap-2">
            <a href="{{ route('admin.warehouses.show', $warehouse) }}" class="btn btn-outline-info"
               style="color: #06b6d4 !important; border-color: #06b6d4 !important; background: #ffffff !important; padding: 12px 20px !important; border-radius: 10px !important; font-weight: 600 !important; font-size: 14px !important; border-width: 2px !important; transition: all 0.2s ease !important; text-decoration: none !important;"
               onmouseover="this.style.backgroundColor='#06b6d4 !important'; this.style.color='#ffffff !important';"
               onmouseout="this.style.backgroundColor='#ffffff !important'; this.style.color='#06b6d4 !important';">
                <i class="bi bi-building me-2"></i>Warehouse Details
            </a>
            <a href="{{ route('admin.warehouses.index') }}" class="btn btn-outline-secondary" 
               style="color: #4a5568 !important; border-color: #4a5568 !important; background: #ffffff !important; padding: 12px 20px !important; border-radius: 10px !important; font-weight: 600 !important; font-size: 14px !important; border-width: 2px !important; transition: all 0.2s ease !important; text-decoration: none !important;"
               onmouseover="this.style.backgroundColor='#4a5568 !important'; this.style.color='#ffffff !important';"
               onmouseout="this.style.backgroundColor='#ffffff !important'; this.style.color='#4a5568 !important';">
                <i class="bi bi-arrow-left me-2"></i>Back to Warehouses
            </a>
        </div>
    </div>

    <!-- Warehouse Info Card -->
    <div class="card mb-4" style="background: linear-gradient(135deg, #f0f9ff 0%, #e0f2fe 100%) !important; border: 1px solid #e0f2fe !important; border-radius: 12px !important; box-shadow: 0 1px 3px rgba(0, 0, 0, 0.1) !important;">
        <div class="card-body" style="padding: 1.5rem !important;">
            <div class="d-flex justify-content-between align-items-center">
                <div>
                    <h5 style="color: #1a202c !important; font-weight: 600 !important; font-size: 18px !important; margin-bottom: 4px !important;">
                        <i class="bi bi-building me-2" style="color: #3182ce !important;"></i>{{ $warehouse->name }}
                    </h5>
                    <div style="color: #4a5568 !important; font-size: 14px !important;">
                        <span class="badge" style="background: #3182ce !important; color: #ffffff !important; font-size: 11px !important; padding: 4px 8px !important; border-radius: 12px !important; font-family: monospace !important; margin-right: 8px !important;">
                            {{ $warehouse->code }}
                        </span>
                        <i class="bi bi-geo-alt me-1" style="color: #f59e0b !important;"></i>{{ $warehouse->location }}
                        @if($warehouse->manager)
                            • <i class="bi bi-person me-1" style="color: #8b5cf6 !important;"></i>{{ $warehouse->manager }}
                        @endif
                    </div>
                </div>
                <span class="badge" style="background: {{ $warehouse->status_color }} !important; color: #ffffff !important; font-size: 12px !important; padding: 8px 16px !important; border-radius: 20px !important; text-transform: uppercase !important;">
                    {{ $warehouse->status }}
                </span>
            </div>
        </div>
    </div>

    <!-- Inventory Content -->
    @if($inventory && $inventory->count() > 0)
        <!-- Inventory Statistics -->
        <div class="row mb-4">
            <div class="col-lg-3 col-md-6 mb-3">
                <div class="card" style="background: linear-gradient(135deg, #f0fdf4 0%, #dcfce7 100%) !important; border: 1px solid #dcfce7 !important; border-radius: 12px !important; box-shadow: 0 1px 3px rgba(0, 0, 0, 0.1) !important;">
                    <div class="card-body text-center" style="padding: 1.5rem !important;">
                        <div class="stat-icon" style="color: #10b981 !important; font-size: 2rem !important; margin-bottom: 0.5rem !important;">📦</div>
                        <div class="stat-number h3 mb-1" style="color: #1a202c !important; font-weight: 700 !important;">{{ $inventory->total() }}</div>
                        <div class="stat-label" style="color: #4a5568 !important; font-size: 14px !important;">Total Items</div>
                    </div>
                </div>
            </div>
            <div class="col-lg-3 col-md-6 mb-3">
                <div class="card" style="background: linear-gradient(135deg, #fef3c7 0%, #fed7aa 100%) !important; border: 1px solid #fed7aa !important; border-radius: 12px !important; box-shadow: 0 1px 3px rgba(0, 0, 0, 0.1) !important;">
                    <div class="card-body text-center" style="padding: 1.5rem !important;">
                        <div class="stat-icon" style="color: #f59e0b !important; font-size: 2rem !important; margin-bottom: 0.5rem !important;">📊</div>
                        <div class="stat-number h3 mb-1" style="color: #1a202c !important; font-weight: 700 !important;">{{ number_format($inventory->sum('stock_quantity')) }}</div>
                        <div class="stat-label" style="color: #4a5568 !important; font-size: 14px !important;">Total Stock</div>
                    </div>
                </div>
            </div>
            <div class="col-lg-3 col-md-6 mb-3">
                <div class="card" style="background: linear-gradient(135deg, #f3e8ff 0%, #e9d5ff 100%) !important; border: 1px solid #e9d5ff !important; border-radius: 12px !important; box-shadow: 0 1px 3px rgba(0, 0, 0, 0.1) !important;">
                    <div class="card-body text-center" style="padding: 1.5rem !important;">
                        <div class="stat-icon" style="color: #8b5cf6 !important; font-size: 2rem !important; margin-bottom: 0.5rem !important;">💰</div>
                        <div class="stat-number h3 mb-1" style="color: #1a202c !important; font-weight: 700 !important;">${{ number_format($inventory->sum('value'), 2) }}</div>
                        <div class="stat-label" style="color: #4a5568 !important; font-size: 14px !important;">Total Value</div>
                    </div>
                </div>
            </div>
            <div class="col-lg-3 col-md-6 mb-3">
                <div class="card" style="background: linear-gradient(135deg, #fef2f2 0%, #fecaca 100%) !important; border: 1px solid #fecaca !important; border-radius: 12px !important; box-shadow: 0 1px 3px rgba(0, 0, 0, 0.1) !important;">
                    <div class="card-body text-center" style="padding: 1.5rem !important;">
                        <div class="stat-icon" style="color: #ef4444 !important; font-size: 2rem !important; margin-bottom: 0.5rem !important;">⚠️</div>
                        <div class="stat-number h3 mb-1" style="color: #1a202c !important; font-weight: 700 !important;">{{ $inventory->where('stock_quantity', '<', 10)->count() }}</div>
                        <div class="stat-label" style="color: #4a5568 !important; font-size: 14px !important;">Low Stock</div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Inventory Items -->
        <div class="card" style="background: #ffffff !important; border: 1px solid #e2e8f0 !important; border-radius: 12px !important; box-shadow: 0 1px 3px rgba(0, 0, 0, 0.1) !important;">
            <div class="card-header" style="background: linear-gradient(135deg, #f7fafc 0%, #edf2f7 100%) !important; border-bottom: 1px solid #e2e8f0 !important; border-radius: 12px 12px 0 0 !important; padding: 1.5rem 2rem !important;">
                <h5 class="mb-0" style="color: #1a202c !important; font-weight: 600 !important; font-size: 18px !important;">
                    <i class="bi bi-box me-2" style="color: #10b981 !important;"></i>Inventory Items ({{ $inventory->total() }})
                </h5>
            </div>
            <div class="card-body" style="padding: 2rem !important;">
                <div class="row">
                    @foreach($inventory as $item)
                        <div class="col-lg-4 col-md-6 mb-4">
                            <div class="inventory-card" style="padding: 1.5rem !important; background: linear-gradient(135deg, #f8fafc 0%, #f1f5f9 100%) !important; border-radius: 10px !important; border: 1px solid #f1f5f9 !important; transition: all 0.3s ease !important;"
                                 onmouseover="this.style.transform='translateY(-4px)'; this.style.boxShadow='0 8px 25px rgba(0, 0, 0, 0.15) !important'; this.style.borderColor='#e2e8f0 !important';"
                                 onmouseout="this.style.transform='translateY(0)'; this.style.boxShadow='none'; this.style.borderColor='#f1f5f9 !important';">
                                
                                <div class="d-flex justify-content-between align-items-start mb-3">
                                    <div class="flex-grow-1">
                                        <h6 style="color: #1a202c !important; font-weight: 600 !important; font-size: 16px !important; margin-bottom: 4px !important; line-height: 1.3 !important;">
                                            {{ $item->product->name ?? 'Product Not Found' }}
                                        </h6>
                                        <div style="color: #4a5568 !important; font-size: 13px !important; line-height: 1.4 !important;">
                                            <div><strong>SKU:</strong> {{ $item->product->sku ?? 'N/A' }}</div>
                                            @if($item->product && $item->product->category)
                                                <div><strong>Category:</strong> {{ $item->product->category->name }}</div>
                                            @endif
                                            @if($item->product && $item->product->brand)
                                                <div><strong>Brand:</strong> {{ $item->product->brand->name }}</div>
                                            @endif
                                        </div>
                                    </div>
                                    <span class="badge" style="
                                        background: {{ $item->stock_quantity > 10 ? '#10b981' : ($item->stock_quantity > 0 ? '#f59e0b' : '#ef4444') }} !important; 
                                        color: #ffffff !important; 
                                        font-size: 11px !important; 
                                        padding: 6px 10px !important; 
                                        border-radius: 15px !important;
                                        text-transform: uppercase !important;
                                    ">
                                        {{ $item->stock_quantity > 10 ? 'In Stock' : ($item->stock_quantity > 0 ? 'Low Stock' : 'Out of Stock') }}
                                    </span>
                                </div>

                                <div class="inventory-details">
                                    <div class="d-flex justify-content-between align-items-center mb-2">
                                        <span style="color: #4a5568 !important; font-size: 14px !important; font-weight: 600 !important;">Stock Quantity:</span>
                                        <span style="color: #1a202c !important; font-weight: 700 !important; font-size: 16px !important;">{{ number_format($item->stock_quantity) }}</span>
                                    </div>
                                    <div class="d-flex justify-content-between align-items-center mb-2">
                                        <span style="color: #4a5568 !important; font-size: 14px !important; font-weight: 600 !important;">Unit Value:</span>
                                        <span style="color: #10b981 !important; font-weight: 600 !important; font-size: 14px !important;">${{ number_format($item->unit_value ?? 0, 2) }}</span>
                                    </div>
                                    <hr style="margin: 12px 0 !important; border-color: #e2e8f0 !important;">
                                    <div class="d-flex justify-content-between align-items-center">
                                        <span style="color: #2d3748 !important; font-size: 14px !important; font-weight: 700 !important;">Total Value:</span>
                                        <span style="color: #8b5cf6 !important; font-weight: 700 !important; font-size: 16px !important;">${{ number_format($item->value ?? 0, 2) }}</span>
                                    </div>
                                </div>

                                <div class="inventory-actions mt-3">
                                    <div class="d-flex gap-2">
                                        <a href="#" class="btn btn-sm btn-outline-primary flex-fill"
                                           style="color: #3182ce !important; border-color: #3182ce !important; padding: 8px 12px !important; border-radius: 6px !important; font-size: 12px !important; text-decoration: none !important;">
                                            <i class="bi bi-eye me-1"></i>View
                                        </a>
                                        <a href="#" class="btn btn-sm btn-outline-success flex-fill"
                                           style="color: #10b981 !important; border-color: #10b981 !important; padding: 8px 12px !important; border-radius: 6px !important; font-size: 12px !important; text-decoration: none !important;">
                                            <i class="bi bi-plus me-1"></i>Restock
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>

                <!-- Pagination -->
                @if($inventory->hasPages())
                    <div class="d-flex justify-content-between align-items-center mt-4" style="padding-top: 1.5rem !important; border-top: 1px solid #f1f5f9 !important;">
                        <div style="color: #4a5568 !important; font-size: 14px !important;">
                            Showing {{ $inventory->firstItem() }}-{{ $inventory->lastItem() }} of {{ $inventory->total() }}
                        </div>
                        <div>
                            {{ $inventory->links('vendor.pagination.custom') }}
                        </div>
                    </div>
                @endif
            </div>
        </div>
    @else
        <!-- No Inventory State -->
        <div class="card" style="background: #ffffff !important; border: 1px solid #e2e8f0 !important; border-radius: 12px !important; box-shadow: 0 1px 3px rgba(0, 0, 0, 0.1) !important;">
            <div class="card-body text-center" style="padding: 4rem !important;">
                <div style="color: #9ca3af !important; font-size: 4rem !important; margin-bottom: 2rem !important;">📦</div>
                <h4 style="color: #1a202c !important; font-weight: 600 !important; font-size: 24px !important; margin-bottom: 1rem !important;">
                    No Inventory Items
                </h4>
                <p style="color: #4a5568 !important; font-size: 16px !important; margin-bottom: 2rem !important; max-width: 500px !important; margin-left: auto !important; margin-right: auto !important; line-height: 1.6 !important;">
                    This warehouse doesn't have any inventory items yet. Once the inventory system is implemented, you'll be able to:
                </p>
                
                <div class="row justify-content-center mb-4">
                    <div class="col-md-8">
                        <div class="features-grid" style="text-align: left !important;">
                            <div class="feature-item" style="padding: 1rem !important; background: linear-gradient(135deg, #f0f9ff 0%, #e0f2fe 100%) !important; border-radius: 8px !important; margin-bottom: 1rem !important; border-left: 4px solid #3182ce !important;">
                                <div style="color: #1a202c !important; font-weight: 600 !important; font-size: 14px !important; margin-bottom: 4px !important;">
                                    <i class="bi bi-plus-circle me-2" style="color: #3182ce !important;"></i>Add & Track Inventory
                                </div>
                                <div style="color: #4a5568 !important; font-size: 13px !important;">Add products to this warehouse and track stock levels</div>
                            </div>
                            <div class="feature-item" style="padding: 1rem !important; background: linear-gradient(135deg, #f0fdf4 0%, #dcfce7 100%) !important; border-radius: 8px !important; margin-bottom: 1rem !important; border-left: 4px solid #10b981 !important;">
                                <div style="color: #1a202c !important; font-weight: 600 !important; font-size: 14px !important; margin-bottom: 4px !important;">
                                    <i class="bi bi-graph-up me-2" style="color: #10b981 !important;"></i>Monitor Stock Levels
                                </div>
                                <div style="color: #4a5568 !important; font-size: 13px !important;">Track quantities, set reorder points, and manage stock alerts</div>
                            </div>
                            <div class="feature-item" style="padding: 1rem !important; background: linear-gradient(135deg, #fef3c7 0%, #fed7aa 100%) !important; border-radius: 8px !important; margin-bottom: 1rem !important; border-left: 4px solid #f59e0b !important;">
                                <div style="color: #1a202c !important; font-weight: 600 !important; font-size: 14px !important; margin-bottom: 4px !important;">
                                    <i class="bi bi-arrow-left-right me-2" style="color: #f59e0b !important;"></i>Transfer Between Warehouses
                                </div>
                                <div style="color: #4a5568 !important; font-size: 13px !important;">Move inventory between different warehouse locations</div>
                            </div>
                            <div class="feature-item" style="padding: 1rem !important; background: linear-gradient(135deg, #f3e8ff 0%, #e9d5ff 100%) !important; border-radius: 8px !important; border-left: 4px solid #8b5cf6 !important;">
                                <div style="color: #1a202c !important; font-weight: 600 !important; font-size: 14px !important; margin-bottom: 4px !important;">
                                    <i class="bi bi-bar-chart me-2" style="color: #8b5cf6 !important;"></i>Analytics & Reporting
                                </div>
                                <div style="color: #4a5568 !important; font-size: 13px !important;">View inventory performance, turnover rates, and value analysis</div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="coming-soon" style="padding: 2rem !important; background: linear-gradient(135deg, #f8fafc 0%, #f1f5f9 100%) !important; border-radius: 12px !important; border: 2px dashed #e2e8f0 !important; margin-top: 2rem !important;">
                    <h6 style="color: #1a202c !important; font-weight: 600 !important; font-size: 16px !important; margin-bottom: 1rem !important;">
                        <i class="bi bi-clock me-2" style="color: #8b5cf6 !important;"></i>Coming Soon: Inventory Management System
                    </h6>
                    <p style="color: #4a5568 !important; font-size: 14px !important; margin-bottom: 1.5rem !important;">
                        The inventory management system will be implemented next, enabling complete warehouse inventory tracking and management.
                    </p>
                    <div class="d-flex gap-2 justify-content-center">
                        <a href="{{ route('admin.warehouses.show', $warehouse) }}" class="btn btn-outline-primary"
                           style="color: #3182ce !important; border-color: #3182ce !important; padding: 10px 20px !important; border-radius: 8px !important; font-weight: 600 !important; text-decoration: none !important;">
                            <i class="bi bi-building me-2"></i>Back to Warehouse
                        </a>
                        <a href="{{ route('admin.warehouses.contacts', $warehouse) }}" class="btn btn-outline-info"
                           style="color: #06b6d4 !important; border-color: #06b6d4 !important; padding: 10px 20px !important; border-radius: 8px !important; font-weight: 600 !important; text-decoration: none !important;">
                            <i class="bi bi-envelope me-2"></i>Manage Contacts
                        </a>
                    </div>
                </div>
            </div>
        </div>
    @endif
</div>

@push('styles')
<style>
    /* CLEAN WAREHOUSE INVENTORY PAGE - Professional Styling */
    .inventory-card {
        transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1) !important;
    }
    
    .inventory-card:hover {
        transform: translateY(-4px) !important;
        box-shadow: 0 8px 25px rgba(0, 0, 0, 0.15) !important;
    }
    
    .feature-item {
        transition: all 0.2s ease !important;
    }
    
    .feature-item:hover {
        transform: translateX(4px) !important;
        box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1) !important;
    }
    
    .coming-soon {
        animation: pulse 3s ease-in-out infinite;
    }
    
    @keyframes pulse {
        0%, 100% { opacity: 1; }
        50% { opacity: 0.95; }
    }
    
    .stat-icon {
        transition: all 0.3s ease !important;
    }
    
    .card:hover .stat-icon {
        transform: scale(1.1) !important;
    }
</style>
@endpush
@endsection
