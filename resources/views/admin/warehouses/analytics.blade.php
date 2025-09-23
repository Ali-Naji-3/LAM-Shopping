@extends('admin.dashboard')

@section('content')
<div class="container-fluid">
    <!-- Page Header -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h2 class="mb-1" style="color: #1a202c !important; font-weight: 700 !important; font-size: 24px !important;">
                📊 Warehouse Analytics
            </h2>
            <p class="mb-0" style="color: #4a5568 !important; font-size: 14px !important;">
                {{ $warehouse->name }} • {{ $warehouse->code }} • Performance Insights
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

    <!-- Warehouse Overview Card -->
    <div class="card mb-4" style="background: linear-gradient(135deg, #f0f9ff 0%, #e0f2fe 100%) !important; border: 1px solid #e0f2fe !important; border-radius: 12px !important; box-shadow: 0 1px 3px rgba(0, 0, 0, 0.1) !important;">
        <div class="card-body" style="padding: 2rem !important;">
            <div class="row align-items-center">
                <div class="col-md-8">
                    <h4 style="color: #1a202c !important; font-weight: 700 !important; font-size: 24px !important; margin-bottom: 8px !important;">
                        <i class="bi bi-building me-3" style="color: #3182ce !important;"></i>{{ $warehouse->name }}
                    </h4>
                    <div style="color: #4a5568 !important; font-size: 16px !important; line-height: 1.6 !important;">
                        <div class="d-flex align-items-center gap-4 flex-wrap">
                            <span class="badge" style="background: #3182ce !important; color: #ffffff !important; font-size: 13px !important; padding: 8px 16px !important; border-radius: 20px !important; font-family: monospace !important;">
                                {{ $warehouse->code }}
                            </span>
                            <span><i class="bi bi-geo-alt me-2" style="color: #f59e0b !important;"></i>{{ $warehouse->location }}</span>
                            @if($warehouse->manager)
                                <span><i class="bi bi-person me-2" style="color: #8b5cf6 !important;"></i>{{ $warehouse->manager }}</span>
                            @endif
                        </div>
                    </div>
                </div>
                <div class="col-md-4 text-end">
                    <span class="badge" style="background: {{ $warehouse->status_color }} !important; color: #ffffff !important; font-size: 14px !important; padding: 12px 24px !important; border-radius: 25px !important; text-transform: uppercase !important; font-weight: 700 !important;">
                        {{ $warehouse->status }}
                    </span>
                </div>
            </div>
        </div>
    </div>

    <!-- Analytics Statistics -->
    <div class="row mb-4">
        <div class="col-lg-3 col-md-6 mb-3">
            <div class="card" style="background: linear-gradient(135deg, #f0fdf4 0%, #dcfce7 100%) !important; border: 1px solid #dcfce7 !important; border-radius: 12px !important; box-shadow: 0 4px 6px rgba(0, 0, 0, 0.05) !important; transition: all 0.3s ease !important;"
                 onmouseover="this.style.transform='translateY(-2px)'; this.style.boxShadow='0 8px 25px rgba(0, 0, 0, 0.1) !important';"
                 onmouseout="this.style.transform='translateY(0)'; this.style.boxShadow='0 4px 6px rgba(0, 0, 0, 0.05) !important';">
                <div class="card-body text-center" style="padding: 2rem !important;">
                    <div class="stat-icon" style="color: #10b981 !important; font-size: 3rem !important; margin-bottom: 1rem !important;">📦</div>
                    <div class="stat-number h2 mb-2" style="color: #1a202c !important; font-weight: 800 !important;">{{ number_format($warehouseStats['total_inventory']) }}</div>
                    <div class="stat-label" style="color: #4a5568 !important; font-size: 16px !important; font-weight: 600 !important;">Inventory Items</div>
                </div>
            </div>
        </div>
        <div class="col-lg-3 col-md-6 mb-3">
            <div class="card" style="background: linear-gradient(135deg, #fef3c7 0%, #fed7aa 100%) !important; border: 1px solid #fed7aa !important; border-radius: 12px !important; box-shadow: 0 4px 6px rgba(0, 0, 0, 0.05) !important; transition: all 0.3s ease !important;"
                 onmouseover="this.style.transform='translateY(-2px)'; this.style.boxShadow='0 8px 25px rgba(0, 0, 0, 0.1) !important';"
                 onmouseout="this.style.transform='translateY(0)'; this.style.boxShadow='0 4px 6px rgba(0, 0, 0, 0.05) !important';">
                <div class="card-body text-center" style="padding: 2rem !important;">
                    <div class="stat-icon" style="color: #f59e0b !important; font-size: 3rem !important; margin-bottom: 1rem !important;">📊</div>
                    <div class="stat-number h2 mb-2" style="color: #1a202c !important; font-weight: 800 !important;">{{ number_format($warehouseStats['total_stock']) }}</div>
                    <div class="stat-label" style="color: #4a5568 !important; font-size: 16px !important; font-weight: 600 !important;">Total Stock</div>
                </div>
            </div>
        </div>
        <div class="col-lg-3 col-md-6 mb-3">
            <div class="card" style="background: linear-gradient(135deg, #f3e8ff 0%, #e9d5ff 100%) !important; border: 1px solid #e9d5ff !important; border-radius: 12px !important; box-shadow: 0 4px 6px rgba(0, 0, 0, 0.05) !important; transition: all 0.3s ease !important;"
                 onmouseover="this.style.transform='translateY(-2px)'; this.style.boxShadow='0 8px 25px rgba(0, 0, 0, 0.1) !important';"
                 onmouseout="this.style.transform='translateY(0)'; this.style.boxShadow='0 4px 6px rgba(0, 0, 0, 0.05) !important';">
                <div class="card-body text-center" style="padding: 2rem !important;">
                    <div class="stat-icon" style="color: #8b5cf6 !important; font-size: 3rem !important; margin-bottom: 1rem !important;">💰</div>
                    <div class="stat-number h2 mb-2" style="color: #1a202c !important; font-weight: 800 !important;">${{ number_format($warehouseStats['total_value'], 2) }}</div>
                    <div class="stat-label" style="color: #4a5568 !important; font-size: 16px !important; font-weight: 600 !important;">Total Value</div>
                </div>
            </div>
        </div>
        <div class="col-lg-3 col-md-6 mb-3">
            <div class="card" style="background: linear-gradient(135deg, #fef2f2 0%, #fecaca 100%) !important; border: 1px solid #fecaca !important; border-radius: 12px !important; box-shadow: 0 4px 6px rgba(0, 0, 0, 0.05) !important; transition: all 0.3s ease !important;"
                 onmouseover="this.style.transform='translateY(-2px)'; this.style.boxShadow='0 8px 25px rgba(0, 0, 0, 0.1) !important';"
                 onmouseout="this.style.transform='translateY(0)'; this.style.boxShadow='0 4px 6px rgba(0, 0, 0, 0.05) !important';">
                <div class="card-body text-center" style="padding: 2rem !important;">
                    <div class="stat-icon" style="color: #ef4444 !important; font-size: 3rem !important; margin-bottom: 1rem !important;">⚠️</div>
                    <div class="stat-number h2 mb-2" style="color: #1a202c !important; font-weight: 800 !important;">{{ number_format($warehouseStats['low_stock_items']) }}</div>
                    <div class="stat-label" style="color: #4a5568 !important; font-size: 16px !important; font-weight: 600 !important;">Low Stock Items</div>
                </div>
            </div>
        </div>
    </div>

    <!-- Analytics Content -->
    <div class="row">
        <div class="col-lg-8">
            <!-- Performance Overview -->
            <div class="card mb-4" style="background: #ffffff !important; border: 1px solid #e2e8f0 !important; border-radius: 12px !important; box-shadow: 0 1px 3px rgba(0, 0, 0, 0.1) !important;">
                <div class="card-header" style="background: linear-gradient(135deg, #f7fafc 0%, #edf2f7 100%) !important; border-bottom: 1px solid #e2e8f0 !important; border-radius: 12px 12px 0 0 !important; padding: 1.5rem 2rem !important;">
                    <h5 class="mb-0" style="color: #1a202c !important; font-weight: 600 !important; font-size: 18px !important;">
                        <i class="bi bi-speedometer2 me-2" style="color: #3182ce !important;"></i>Performance Overview
                    </h5>
                </div>
                <div class="card-body" style="padding: 2rem !important;">
                    <div class="row">
                        <div class="col-md-6">
                            <div style="padding: 1.5rem !important; background: linear-gradient(135deg, #f0fdf4 0%, #dcfce7 100%) !important; border-radius: 10px !important; border-left: 4px solid #10b981 !important; margin-bottom: 1rem !important;">
                                <h6 style="color: #1a202c !important; font-weight: 600 !important; font-size: 16px !important; margin-bottom: 1rem !important;">Inventory Performance</h6>
                                <div class="performance-metrics">
                                    <div class="d-flex justify-content-between mb-2">
                                        <span style="color: #4a5568 !important; font-size: 14px !important;">Total Items:</span>
                                        <span style="color: #1a202c !important; font-weight: 600 !important; font-size: 14px !important;">{{ number_format($warehouseStats['total_inventory']) }}</span>
                                    </div>
                                    <div class="d-flex justify-content-between mb-2">
                                        <span style="color: #4a5568 !important; font-size: 14px !important;">Stock Quantity:</span>
                                        <span style="color: #1a202c !important; font-weight: 600 !important; font-size: 14px !important;">{{ number_format($warehouseStats['total_stock']) }}</span>
                                    </div>
                                    <div class="d-flex justify-content-between mb-2">
                                        <span style="color: #4a5568 !important; font-size: 14px !important;">Low Stock Items:</span>
                                        <span style="color: #ef4444 !important; font-weight: 600 !important; font-size: 14px !important;">{{ number_format($warehouseStats['low_stock_items']) }}</span>
                                    </div>
                                    <div class="d-flex justify-content-between">
                                        <span style="color: #4a5568 !important; font-size: 14px !important;">Out of Stock:</span>
                                        <span style="color: #ef4444 !important; font-weight: 700 !important; font-size: 14px !important;">{{ number_format($warehouseStats['out_of_stock_items']) }}</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div style="padding: 1.5rem !important; background: linear-gradient(135deg, #f3e8ff 0%, #e9d5ff 100%) !important; border-radius: 10px !important; border-left: 4px solid #8b5cf6 !important; margin-bottom: 1rem !important;">
                                <h6 style="color: #1a202c !important; font-weight: 600 !important; font-size: 16px !important; margin-bottom: 1rem !important;">Financial Overview</h6>
                                <div class="financial-metrics">
                                    <div class="d-flex justify-content-between mb-2">
                                        <span style="color: #4a5568 !important; font-size: 14px !important;">Total Inventory Value:</span>
                                        <span style="color: #10b981 !important; font-weight: 700 !important; font-size: 16px !important;">${{ number_format($warehouseStats['total_value'], 2) }}</span>
                                    </div>
                                    <div class="d-flex justify-content-between mb-2">
                                        <span style="color: #4a5568 !important; font-size: 14px !important;">Avg Item Value:</span>
                                        <span style="color: #1a202c !important; font-weight: 600 !important; font-size: 14px !important;">
                                            ${{ $warehouseStats['total_inventory'] > 0 ? number_format($warehouseStats['total_value'] / $warehouseStats['total_inventory'], 2) : '0.00' }}
                                        </span>
                                    </div>
                                    <div class="d-flex justify-content-between">
                                        <span style="color: #4a5568 !important; font-size: 14px !important;">Contact Messages:</span>
                                        <span style="color: #3182ce !important; font-weight: 600 !important; font-size: 14px !important;">{{ number_format($warehouseStats['contacts_count']) }}</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Coming Soon: Advanced Analytics -->
            <div class="card" style="background: #ffffff !important; border: 1px solid #e2e8f0 !important; border-radius: 12px !important; box-shadow: 0 1px 3px rgba(0, 0, 0, 0.1) !important;">
                <div class="card-header" style="background: linear-gradient(135deg, #f7fafc 0%, #edf2f7 100%) !important; border-bottom: 1px solid #e2e8f0 !important; border-radius: 12px 12px 0 0 !important; padding: 1.5rem 2rem !important;">
                    <h5 class="mb-0" style="color: #1a202c !important; font-weight: 600 !important; font-size: 18px !important;">
                        <i class="bi bi-graph-up me-2" style="color: #10b981 !important;"></i>Advanced Analytics
                        <span class="badge bg-info ms-2" style="font-size: 11px !important; padding: 4px 8px !important;">Coming Soon</span>
                    </h5>
                </div>
                <div class="card-body" style="padding: 3rem !important;">
                    <div class="text-center">
                        <div style="color: #8b5cf6 !important; font-size: 4rem !important; margin-bottom: 2rem !important;">📈</div>
                        <h4 style="color: #1a202c !important; font-weight: 600 !important; font-size: 24px !important; margin-bottom: 1rem !important;">
                            Advanced Analytics Dashboard
                        </h4>
                        <p style="color: #4a5568 !important; font-size: 16px !important; margin-bottom: 2rem !important; max-width: 600px !important; margin-left: auto !important; margin-right: auto !important; line-height: 1.6 !important;">
                            Once the inventory system is fully implemented, this section will provide comprehensive analytics including:
                        </p>
                        
                        <div class="row justify-content-center">
                            <div class="col-md-10">
                                <div class="features-grid">
                                    <div class="row">
                                        <div class="col-md-6 mb-3">
                                            <div style="padding: 1.5rem !important; background: linear-gradient(135deg, #f0f9ff 0%, #e0f2fe 100%) !important; border-radius: 10px !important; border-left: 4px solid #3182ce !important; text-align: left !important;">
                                                <h6 style="color: #1a202c !important; font-weight: 600 !important; font-size: 16px !important; margin-bottom: 8px !important;">
                                                    <i class="bi bi-bar-chart me-2" style="color: #3182ce !important;"></i>Inventory Trends
                                                </h6>
                                                <p style="color: #4a5568 !important; font-size: 14px !important; margin: 0 !important;">Stock level changes, turnover rates, and seasonal patterns</p>
                                            </div>
                                        </div>
                                        <div class="col-md-6 mb-3">
                                            <div style="padding: 1.5rem !important; background: linear-gradient(135deg, #f0fdf4 0%, #dcfce7 100%) !important; border-radius: 10px !important; border-left: 4px solid #10b981 !important; text-align: left !important;">
                                                <h6 style="color: #1a202c !important; font-weight: 600 !important; font-size: 16px !important; margin-bottom: 8px !important;">
                                                    <i class="bi bi-clock-history me-2" style="color: #10b981 !important;"></i>Performance Metrics
                                                </h6>
                                                <p style="color: #4a5568 !important; font-size: 14px !important; margin: 0 !important;">Processing times, efficiency ratings, and operational KPIs</p>
                                            </div>
                                        </div>
                                        <div class="col-md-6 mb-3">
                                            <div style="padding: 1.5rem !important; background: linear-gradient(135deg, #fef3c7 0%, #fed7aa 100%) !important; border-radius: 10px !important; border-left: 4px solid #f59e0b !important; text-align: left !important;">
                                                <h6 style="color: #1a202c !important; font-weight: 600 !important; font-size: 16px !important; margin-bottom: 8px !important;">
                                                    <i class="bi bi-truck me-2" style="color: #f59e0b !important;"></i>Shipping Analytics
                                                </h6>
                                                <p style="color: #4a5568 !important; font-size: 14px !important; margin: 0 !important;">Outbound shipments, delivery times, and logistics performance</p>
                                            </div>
                                        </div>
                                        <div class="col-md-6 mb-3">
                                            <div style="padding: 1.5rem !important; background: linear-gradient(135deg, #fef2f2 0%, #fecaca 100%) !important; border-radius: 10px !important; border-left: 4px solid #ef4444 !important; text-align: left !important;">
                                                <h6 style="color: #1a202c !important; font-weight: 600 !important; font-size: 16px !important; margin-bottom: 8px !important;">
                                                    <i class="bi bi-exclamation-triangle me-2" style="color: #ef4444 !important;"></i>Alert Management
                                                </h6>
                                                <p style="color: #4a5568 !important; font-size: 14px !important; margin: 0 !important;">Low stock alerts, reorder notifications, and critical issue tracking</p>
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
            <!-- Contact Performance -->
            <div class="card mb-4" style="background: #ffffff !important; border: 1px solid #e2e8f0 !important; border-radius: 12px !important; box-shadow: 0 1px 3px rgba(0, 0, 0, 0.1) !important;">
                <div class="card-header" style="background: linear-gradient(135deg, #f7fafc 0%, #edf2f7 100%) !important; border-bottom: 1px solid #e2e8f0 !important; border-radius: 12px 12px 0 0 !important; padding: 1.5rem 2rem !important;">
                    <h5 class="mb-0" style="color: #1a202c !important; font-weight: 600 !important; font-size: 18px !important;">
                        <i class="bi bi-chat-dots me-2" style="color: #06b6d4 !important;"></i>Contact Performance
                    </h5>
                </div>
                <div class="card-body" style="padding: 2rem !important;">
                    <div class="contact-stats">
                        <div class="stat-item" style="padding: 1rem !important; background: linear-gradient(135deg, #f0f9ff 0%, #e0f2fe 100%) !important; border-radius: 8px !important; margin-bottom: 1rem !important;">
                            <div class="d-flex justify-content-between align-items-center">
                                <span style="color: #2d3748 !important; font-weight: 600 !important; font-size: 14px !important;">Total Messages</span>
                                <span style="color: #3182ce !important; font-weight: 700 !important; font-size: 16px !important;">{{ number_format($warehouseStats['contacts_count']) }}</span>
                            </div>
                        </div>
                        <div class="stat-item" style="padding: 1rem !important; background: linear-gradient(135deg, #fef3c7 0%, #fed7aa 100%) !important; border-radius: 8px !important; margin-bottom: 1rem !important;">
                            <div class="d-flex justify-content-between align-items-center">
                                <span style="color: #2d3748 !important; font-weight: 600 !important; font-size: 14px !important;">Pending Messages</span>
                                <span style="color: #f59e0b !important; font-weight: 700 !important; font-size: 16px !important;">{{ number_format($warehouseStats['pending_contacts']) }}</span>
                            </div>
                        </div>
                        <div class="stat-item" style="padding: 1rem !important; background: linear-gradient(135deg, #f0fdf4 0%, #dcfce7 100%) !important; border-radius: 8px !important;">
                            <div class="d-flex justify-content-between align-items-center">
                                <span style="color: #2d3748 !important; font-weight: 600 !important; font-size: 14px !important;">Resolution Rate</span>
                                <span style="color: #10b981 !important; font-weight: 700 !important; font-size: 16px !important;">
                                    {{ $warehouseStats['contacts_count'] > 0 ? number_format((($warehouseStats['contacts_count'] - $warehouseStats['pending_contacts']) / $warehouseStats['contacts_count']) * 100, 1) : 0 }}%
                                </span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Quick Actions -->
            <div class="card" style="background: #ffffff !important; border: 1px solid #e2e8f0 !important; border-radius: 12px !important; box-shadow: 0 1px 3px rgba(0, 0, 0, 0.1) !important;">
                <div class="card-header" style="background: linear-gradient(135deg, #f7fafc 0%, #edf2f7 100%) !important; border-bottom: 1px solid #e2e8f0 !important; border-radius: 12px 12px 0 0 !important; padding: 1rem 1.5rem !important;">
                    <h5 class="mb-0" style="color: #1a202c !important; font-weight: 600 !important; font-size: 16px !important;">
                        <i class="bi bi-lightning me-2" style="color: #f59e0b !important;"></i>Quick Actions
                    </h5>
                </div>
                <div class="card-body" style="padding: 1.5rem !important;">
                    <div class="d-grid gap-2">
                        <a href="{{ route('admin.warehouses.inventory', $warehouse) }}" class="btn btn-outline-primary w-100"
                           style="color: #3182ce !important; border-color: #3182ce !important; background: #ffffff !important; padding: 12px 16px !important; border-radius: 8px !important; font-weight: 600 !important; transition: all 0.2s ease !important; text-decoration: none !important;"
                           onmouseover="this.style.backgroundColor='#3182ce !important'; this.style.color='#ffffff !important';"
                           onmouseout="this.style.backgroundColor='#ffffff !important'; this.style.color='#3182ce !important';">
                            <i class="bi bi-box me-2"></i>View Inventory
                        </a>
                        
                        <a href="{{ route('admin.warehouses.contacts', $warehouse) }}" class="btn btn-outline-info w-100"
                           style="color: #06b6d4 !important; border-color: #06b6d4 !important; background: #ffffff !important; padding: 12px 16px !important; border-radius: 8px !important; font-weight: 600 !important; transition: all 0.2s ease !important; text-decoration: none !important;"
                           onmouseover="this.style.backgroundColor='#06b6d4 !important'; this.style.color='#ffffff !important';"
                           onmouseout="this.style.backgroundColor='#ffffff !important'; this.style.color='#06b6d4 !important';">
                            <i class="bi bi-envelope me-2"></i>Manage Contacts
                        </a>
                        
                        <a href="{{ route('admin.warehouses.edit', $warehouse) }}" class="btn btn-outline-success w-100"
                           style="color: #10b981 !important; border-color: #10b981 !important; background: #ffffff !important; padding: 12px 16px !important; border-radius: 8px !important; font-weight: 600 !important; transition: all 0.2s ease !important; text-decoration: none !important;"
                           onmouseover="this.style.backgroundColor='#10b981 !important'; this.style.color='#ffffff !important';"
                           onmouseout="this.style.backgroundColor='#ffffff !important'; this.style.color='#10b981 !important';">
                            <i class="bi bi-pencil me-2"></i>Edit Warehouse
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@push('styles')
<style>
    /* CLEAN WAREHOUSE ANALYTICS - Professional Styling */
    .stat-item {
        transition: all 0.2s ease !important;
    }
    
    .stat-item:hover {
        transform: translateY(-1px) !important;
        box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1) !important;
    }
    
    .performance-metrics > div:hover,
    .financial-metrics > div:hover {
        background: rgba(255, 255, 255, 0.5) !important;
        border-radius: 6px !important;
        padding: 4px 8px !important;
        margin: -4px -8px !important;
    }
    
    .features-grid > div:hover {
        transform: translateY(-2px) !important;
    }
    
    .card:hover .stat-icon {
        transform: scale(1.1) !important;
    }
    
    .stat-icon {
        transition: all 0.3s ease !important;
    }
</style>
@endpush
@endsection
