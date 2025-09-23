@extends('admin.dashboard')

@section('content')
<div class="container-fluid">
    <!-- Page Header -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h2 class="mb-1" style="color: #1a202c !important; font-weight: 700 !important; font-size: 24px !important;">
                👁️ Warehouse Details
            </h2>
            <p class="mb-0" style="color: #4a5568 !important; font-size: 14px !important;">
                {{ $warehouse->name }} • {{ $warehouse->code }} • {{ $warehouse->location }}
            </p>
        </div>
        <div class="d-flex gap-2">
            <a href="{{ route('admin.warehouses.edit', $warehouse) }}" class="btn btn-outline-primary"
               style="color: #3182ce !important; border-color: #3182ce !important; background: #ffffff !important; padding: 12px 20px !important; border-radius: 10px !important; font-weight: 600 !important; font-size: 14px !important; border-width: 2px !important; transition: all 0.2s ease !important; text-decoration: none !important;"
               onmouseover="this.style.backgroundColor='#3182ce !important'; this.style.color='#ffffff !important';"
               onmouseout="this.style.backgroundColor='#ffffff !important'; this.style.color='#3182ce !important';">
                <i class="bi bi-pencil me-2"></i>Edit Warehouse
            </a>
            <a href="{{ route('admin.warehouses.index') }}" class="btn btn-outline-secondary" 
               style="color: #4a5568 !important; border-color: #4a5568 !important; background: #ffffff !important; padding: 12px 20px !important; border-radius: 10px !important; font-weight: 600 !important; font-size: 14px !important; border-width: 2px !important; transition: all 0.2s ease !important; text-decoration: none !important;"
               onmouseover="this.style.backgroundColor='#4a5568 !important'; this.style.color='#ffffff !important';"
               onmouseout="this.style.backgroundColor='#ffffff !important'; this.style.color='#4a5568 !important';">
                <i class="bi bi-arrow-left me-2"></i>Back to Warehouses
            </a>
        </div>
    </div>

    <div class="row">
        <div class="col-lg-8">
            <!-- Warehouse Overview -->
            <div class="card mb-4" style="background: #ffffff !important; border: 1px solid #e2e8f0 !important; border-radius: 12px !important; box-shadow: 0 1px 3px rgba(0, 0, 0, 0.1) !important;">
                <div class="card-header" style="background: linear-gradient(135deg, #f7fafc 0%, #edf2f7 100%) !important; border-bottom: 1px solid #e2e8f0 !important; border-radius: 12px 12px 0 0 !important; padding: 1.5rem 2rem !important;">
                    <div class="d-flex justify-content-between align-items-center">
                        <h5 class="mb-0" style="color: #1a202c !important; font-weight: 600 !important; font-size: 18px !important;">
                            <i class="bi bi-building me-2" style="color: #3182ce !important;"></i>Warehouse Overview
                        </h5>
                        <span class="badge" style="background: {{ $warehouse->status_color }} !important; color: #ffffff !important; font-size: 12px !important; padding: 8px 16px !important; border-radius: 20px !important; text-transform: uppercase !important;">
                            {{ $warehouse->status }}
                        </span>
                    </div>
                </div>
                <div class="card-body" style="padding: 2rem !important;">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="warehouse-info">
                                <h6 style="color: #1a202c !important; font-weight: 600 !important; font-size: 16px !important; margin-bottom: 1rem !important;">Warehouse Information</h6>
                                <div class="table-responsive">
                                    <table class="table table-borderless">
                                        <tr>
                                            <td style="color: #4a5568 !important; font-weight: 600 !important; font-size: 14px !important; padding: 0.5rem 0 !important; width: 40%;">Warehouse Name:</td>
                                            <td style="color: #1a202c !important; font-weight: 500 !important; font-size: 14px !important; padding: 0.5rem 0 !important;">{{ $warehouse->name }}</td>
                                        </tr>
                                        <tr>
                                            <td style="color: #4a5568 !important; font-weight: 600 !important; font-size: 14px !important; padding: 0.5rem 0 !important;">Warehouse Code:</td>
                                            <td style="color: #1a202c !important; font-weight: 500 !important; font-size: 14px !important; padding: 0.5rem 0 !important;">
                                                <span class="badge" style="background: #3182ce !important; color: #ffffff !important; font-size: 12px !important; padding: 6px 12px !important; border-radius: 15px !important; font-family: monospace !important;">
                                                    {{ $warehouse->code }}
                                                </span>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td style="color: #4a5568 !important; font-weight: 600 !important; font-size: 14px !important; padding: 0.5rem 0 !important;">Location:</td>
                                            <td style="color: #1a202c !important; font-weight: 500 !important; font-size: 14px !important; padding: 0.5rem 0 !important;">
                                                <i class="bi bi-geo-alt me-2" style="color: #f59e0b !important;"></i>{{ $warehouse->location }}
                                            </td>
                                        </tr>
                                        <tr>
                                            <td style="color: #4a5568 !important; font-weight: 600 !important; font-size: 14px !important; padding: 0.5rem 0 !important;">Created:</td>
                                            <td style="color: #1a202c !important; font-weight: 500 !important; font-size: 14px !important; padding: 0.5rem 0 !important;">{{ $warehouse->created_at->format('M d, Y \a\t g:i A') }}</td>
                                        </tr>
                                    </table>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="management-info">
                                <h6 style="color: #1a202c !important; font-weight: 600 !important; font-size: 16px !important; margin-bottom: 1rem !important;">Management Information</h6>
                                <div style="padding: 1.5rem !important; background: linear-gradient(135deg, #f3e8ff 0%, #e9d5ff 100%) !important; border-radius: 10px !important; border-left: 4px solid #8b5cf6 !important;">
                                    <div class="management-details">
                                        <div class="d-flex justify-content-between mb-2">
                                            <span style="color: #4a5568 !important; font-size: 14px !important;">Manager:</span>
                                            <span style="color: #1a202c !important; font-weight: 600 !important; font-size: 14px !important;">
                                                @if($warehouse->manager)
                                                    <i class="bi bi-person me-1" style="color: #8b5cf6 !important;"></i>{{ $warehouse->manager }}
                                                @else
                                                    <span style="color: #9ca3af !important; font-style: italic;">No manager assigned</span>
                                                @endif
                                            </span>
                                        </div>
                                        <div class="d-flex justify-content-between mb-2">
                                            <span style="color: #4a5568 !important; font-size: 14px !important;">Contact:</span>
                                            <span style="color: #1a202c !important; font-weight: 600 !important; font-size: 14px !important;">
                                                @if($warehouse->contact_number)
                                                    <i class="bi bi-telephone me-1" style="color: #10b981 !important;"></i>{{ $warehouse->formatted_contact_number }}
                                                @else
                                                    <span style="color: #9ca3af !important; font-style: italic;">No contact number</span>
                                                @endif
                                            </span>
                                        </div>
                                        <div class="d-flex justify-content-between">
                                            <span style="color: #4a5568 !important; font-size: 14px !important;">Status:</span>
                                            <span class="badge" style="background: {{ $warehouse->status_color }} !important; color: #ffffff !important; font-size: 11px !important; padding: 4px 8px !important; border-radius: 12px !important; text-transform: uppercase !important;">
                                                {{ $warehouse->status }}
                                            </span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Warehouse Statistics -->
            <div class="card" style="background: #ffffff !important; border: 1px solid #e2e8f0 !important; border-radius: 12px !important; box-shadow: 0 1px 3px rgba(0, 0, 0, 0.1) !important;">
                <div class="card-header" style="background: linear-gradient(135deg, #f7fafc 0%, #edf2f7 100%) !important; border-bottom: 1px solid #e2e8f0 !important; border-radius: 12px 12px 0 0 !important; padding: 1.5rem 2rem !important;">
                    <h5 class="mb-0" style="color: #1a202c !important; font-weight: 600 !important; font-size: 18px !important;">
                        <i class="bi bi-graph-up me-2" style="color: #10b981 !important;"></i>Warehouse Statistics
                    </h5>
                </div>
                <div class="card-body" style="padding: 2rem !important;">
                    <div class="row text-center">
                        <div class="col-md-3 mb-3">
                            <div style="padding: 1.5rem !important; background: linear-gradient(135deg, #f0f9ff 0%, #e0f2fe 100%) !important; border-radius: 10px !important; border: 1px solid #e0f2fe !important;">
                                <div style="color: #3182ce !important; font-size: 2rem !important; margin-bottom: 0.5rem !important;">📦</div>
                                <div style="color: #1a202c !important; font-weight: 700 !important; font-size: 24px !important;">{{ number_format($connectionCounts['inventory_count']) }}</div>
                                <div style="color: #4a5568 !important; font-size: 14px !important;">Inventory Items</div>
                            </div>
                        </div>
                        <div class="col-md-3 mb-3">
                            <div style="padding: 1.5rem !important; background: linear-gradient(135deg, #f0fdf4 0%, #dcfce7 100%) !important; border-radius: 10px !important; border: 1px solid #dcfce7 !important;">
                                <div style="color: #10b981 !important; font-size: 2rem !important; margin-bottom: 0.5rem !important;">📊</div>
                                <div style="color: #1a202c !important; font-weight: 700 !important; font-size: 24px !important;">{{ number_format($connectionCounts['total_stock']) }}</div>
                                <div style="color: #4a5568 !important; font-size: 14px !important;">Total Stock</div>
                            </div>
                        </div>
                        <div class="col-md-3 mb-3">
                            <div style="padding: 1.5rem !important; background: linear-gradient(135deg, #fef3c7 0%, #fed7aa 100%) !important; border-radius: 10px !important; border: 1px solid #fed7aa !important;">
                                <div style="color: #f59e0b !important; font-size: 2rem !important; margin-bottom: 0.5rem !important;">💰</div>
                                <div style="color: #1a202c !important; font-weight: 700 !important; font-size: 24px !important;">${{ number_format($connectionCounts['total_value'], 2) }}</div>
                                <div style="color: #4a5568 !important; font-size: 14px !important;">Total Value</div>
                            </div>
                        </div>
                        <div class="col-md-3 mb-3">
                            <div style="padding: 1.5rem !important; background: linear-gradient(135deg, #fef2f2 0%, #fecaca 100%) !important; border-radius: 10px !important; border: 1px solid #fecaca !important;">
                                <div style="color: #ef4444 !important; font-size: 2rem !important; margin-bottom: 0.5rem !important;">📞</div>
                                <div style="color: #1a202c !important; font-weight: 700 !important; font-size: 24px !important;">{{ number_format($connectionCounts['contacts_count']) }}</div>
                                <div style="color: #4a5568 !important; font-size: 14px !important;">Contact Messages</div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-lg-4">
            <!-- Quick Actions -->
            <div class="card mb-4" style="background: #ffffff !important; border: 1px solid #e2e8f0 !important; border-radius: 12px !important; box-shadow: 0 1px 3px rgba(0, 0, 0, 0.1) !important;">
                <div class="card-header" style="background: linear-gradient(135deg, #f7fafc 0%, #edf2f7 100%) !important; border-bottom: 1px solid #e2e8f0 !important; border-radius: 12px 12px 0 0 !important; padding: 1rem 1.5rem !important;">
                    <h5 class="mb-0" style="color: #1a202c !important; font-weight: 600 !important; font-size: 16px !important;">
                        <i class="bi bi-lightning me-2" style="color: #3182ce !important;"></i>Quick Actions
                    </h5>
                </div>
                <div class="card-body" style="padding: 1.5rem !important;">
                    <div class="d-grid gap-2">
                        <a href="{{ route('admin.warehouses.inventory', $warehouse) }}" class="btn btn-outline-primary w-100"
                           style="color: #3182ce !important; border-color: #3182ce !important; background: #ffffff !important; padding: 12px 16px !important; border-radius: 8px !important; font-weight: 600 !important; transition: all 0.2s ease !important; text-decoration: none !important;"
                           onmouseover="this.style.backgroundColor='#3182ce !important'; this.style.color='#ffffff !important';"
                           onmouseout="this.style.backgroundColor='#ffffff !important'; this.style.color='#3182ce !important';">
                            <i class="bi bi-box me-2"></i>Inventory ({{ $connectionCounts['inventory_count'] }})
                        </a>
                        
                        <a href="{{ route('admin.warehouses.contacts', $warehouse) }}" class="btn btn-outline-info w-100"
                           style="color: #06b6d4 !important; border-color: #06b6d4 !important; background: #ffffff !important; padding: 12px 16px !important; border-radius: 8px !important; font-weight: 600 !important; transition: all 0.2s ease !important; text-decoration: none !important;"
                           onmouseover="this.style.backgroundColor='#06b6d4 !important'; this.style.color='#ffffff !important';"
                           onmouseout="this.style.backgroundColor='#ffffff !important'; this.style.color='#06b6d4 !important';">
                            <i class="bi bi-envelope me-2"></i>Contacts ({{ $connectionCounts['contacts_count'] }})
                            @if($connectionCounts['pending_contacts'] > 0)
                                <span class="badge bg-warning text-dark ms-1" style="font-size: 10px !important;">{{ $connectionCounts['pending_contacts'] }}</span>
                            @endif
                        </a>
                        
                        <a href="{{ route('admin.warehouses.analytics', $warehouse) }}" class="btn btn-outline-success w-100"
                           style="color: #10b981 !important; border-color: #10b981 !important; background: #ffffff !important; padding: 12px 16px !important; border-radius: 8px !important; font-weight: 600 !important; transition: all 0.2s ease !important; text-decoration: none !important;"
                           onmouseover="this.style.backgroundColor='#10b981 !important'; this.style.color='#ffffff !important';"
                           onmouseout="this.style.backgroundColor='#ffffff !important'; this.style.color='#10b981 !important';">
                            <i class="bi bi-graph-up me-2"></i>Analytics
                        </a>
                        
                        <form method="POST" action="{{ route('admin.warehouses.toggleStatus', $warehouse) }}">
                            @csrf
                            @method('PATCH')
                            <button type="submit" class="btn btn-outline-{{ $warehouse->is_active ? 'warning' : 'success' }} w-100"
                                    style="color: {{ $warehouse->is_active ? '#f59e0b' : '#10b981' }} !important; border-color: {{ $warehouse->is_active ? '#f59e0b' : '#10b981' }} !important; background: #ffffff !important; padding: 12px 16px !important; border-radius: 8px !important; font-weight: 600 !important; transition: all 0.2s ease !important;"
                                    onmouseover="this.style.backgroundColor='{{ $warehouse->is_active ? '#f59e0b' : '#10b981' }} !important'; this.style.color='#ffffff !important';"
                                    onmouseout="this.style.backgroundColor='#ffffff !important'; this.style.color='{{ $warehouse->is_active ? '#f59e0b' : '#10b981' }} !important';">
                                <i class="bi bi-{{ $warehouse->is_active ? 'pause' : 'play' }} me-2"></i>{{ $warehouse->is_active ? 'Deactivate' : 'Activate' }}
                            </button>
                        </form>
                        
                        <form method="POST" action="{{ route('admin.warehouses.destroy', $warehouse) }}" onsubmit="return confirm('Are you sure you want to delete this warehouse? This action cannot be undone.')">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-outline-danger w-100"
                                    style="color: #e53e3e !important; border-color: #e53e3e !important; background: #ffffff !important; padding: 12px 16px !important; border-radius: 8px !important; font-weight: 600 !important; transition: all 0.2s ease !important;"
                                    onmouseover="this.style.backgroundColor='#e53e3e !important'; this.style.color='#ffffff !important';"
                                    onmouseout="this.style.backgroundColor='#ffffff !important'; this.style.color='#e53e3e !important';">
                                <i class="bi bi-trash me-2"></i>Delete Warehouse
                            </button>
                        </form>
                    </div>
                </div>
            </div>

            <!-- Warehouse Performance -->
            <div class="card" style="background: #ffffff !important; border: 1px solid #e2e8f0 !important; border-radius: 12px !important; box-shadow: 0 1px 3px rgba(0, 0, 0, 0.1) !important;">
                <div class="card-header" style="background: linear-gradient(135deg, #f7fafc 0%, #edf2f7 100%) !important; border-bottom: 1px solid #e2e8f0 !important; border-radius: 12px 12px 0 0 !important; padding: 1rem 1.5rem !important;">
                    <h5 class="mb-0" style="color: #1a202c !important; font-weight: 600 !important; font-size: 16px !important;">
                        <i class="bi bi-speedometer2 me-2" style="color: #8b5cf6 !important;"></i>Performance Metrics
                    </h5>
                </div>
                <div class="card-body" style="padding: 1.5rem !important;">
                    <div class="performance-stats">
                        <div class="stat-item" style="padding: 12px !important; background: linear-gradient(135deg, #f0f9ff 0%, #e0f2fe 100%) !important; border-radius: 8px !important; margin-bottom: 12px !important;">
                            <div class="d-flex justify-content-between align-items-center">
                                <span style="color: #2d3748 !important; font-weight: 600 !important; font-size: 14px !important;">Warehouse ID</span>
                                <span style="color: #3182ce !important; font-weight: 700 !important; font-size: 14px !important;">#{{ $warehouse->id }}</span>
                            </div>
                        </div>
                        <div class="stat-item" style="padding: 12px !important; background: linear-gradient(135deg, #f0fdf4 0%, #dcfce7 100%) !important; border-radius: 8px !important; margin-bottom: 12px !important;">
                            <div class="d-flex justify-content-between align-items-center">
                                <span style="color: #2d3748 !important; font-weight: 600 !important; font-size: 14px !important;">Stock Items</span>
                                <span style="color: #10b981 !important; font-weight: 700 !important; font-size: 14px !important;">{{ number_format($connectionCounts['inventory_count']) }}</span>
                            </div>
                        </div>
                        <div class="stat-item" style="padding: 12px !important; background: linear-gradient(135deg, #fef3c7 0%, #fed7aa 100%) !important; border-radius: 8px !important; margin-bottom: 12px !important;">
                            <div class="d-flex justify-content-between align-items-center">
                                <span style="color: #2d3748 !important; font-weight: 600 !important; font-size: 14px !important;">Total Stock</span>
                                <span style="color: #f59e0b !important; font-weight: 700 !important; font-size: 14px !important;">{{ number_format($connectionCounts['total_stock']) }}</span>
                            </div>
                        </div>
                        <div class="stat-item" style="padding: 12px !important; background: linear-gradient(135deg, #f3e8ff 0%, #e9d5ff 100%) !important; border-radius: 8px !important;">
                            <div class="d-flex justify-content-between align-items-center">
                                <span style="color: #2d3748 !important; font-weight: 600 !important; font-size: 14px !important;">Last Updated</span>
                                <span style="color: #8b5cf6 !important; font-weight: 700 !important; font-size: 14px !important;">{{ $warehouse->updated_at->format('M d, Y') }}</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@push('styles')
<style>
    /* CLEAN WAREHOUSES SHOW PAGE - Professional Styling */
    .stat-item {
        transition: all 0.2s ease !important;
    }
    
    .stat-item:hover {
        transform: translateY(-1px) !important;
        box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1) !important;
    }
    
    .table td {
        border-bottom: 1px solid #f1f5f9 !important;
    }
    
    .table tr:last-child td {
        border-bottom: none !important;
    }
    
    .warehouse-info, .management-info {
        transition: all 0.2s ease !important;
    }
    
    .management-details > div {
        transition: all 0.2s ease !important;
    }
    
    .performance-stats > div:hover {
        transform: translateY(-1px) !important;
        box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1) !important;
    }
</style>
@endpush
@endsection
