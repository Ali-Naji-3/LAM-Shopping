@extends('admin.dashboard')

@section('content')
<div class="container-fluid">
    <!-- Page Header -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h2 class="mb-1" style="color: #1a202c !important; font-weight: 700 !important; font-size: 24px !important;">
                📊 Order Items Analytics
            </h2>
            <p class="mb-0" style="color: #4a5568 !important; font-size: 14px !important;">
                Comprehensive analytics and insights for order items performance
            </p>
        </div>
        <div class="d-flex gap-2">
            <a href="{{ route('admin.orderItems.index') }}" class="btn btn-outline-secondary" 
               style="color: #4a5568 !important; border-color: #4a5568 !important; background: #ffffff !important; padding: 12px 20px !important; border-radius: 10px !important; font-weight: 600 !important; font-size: 14px !important; border-width: 2px !important; transition: all 0.2s ease !important; text-decoration: none !important;"
               onmouseover="this.style.backgroundColor='#4a5568 !important'; this.style.color='#ffffff !important';"
               onmouseout="this.style.backgroundColor='#ffffff !important'; this.style.color='#4a5568 !important';">
                <i class="bi bi-arrow-left me-2"></i>Back to Order Items
            </a>
        </div>
    </div>

    <!-- Overall Statistics -->
    <div class="row mb-4">
        <div class="col-lg-3 col-md-6 mb-3">
            <div class="card" style="background: linear-gradient(135deg, #f0f9ff 0%, #e0f2fe 100%) !important; border: 1px solid #e0f2fe !important; border-radius: 12px !important; box-shadow: 0 4px 6px rgba(0, 0, 0, 0.05) !important; transition: all 0.3s ease !important;"
                 onmouseover="this.style.transform='translateY(-2px)'; this.style.boxShadow='0 8px 25px rgba(0, 0, 0, 0.1) !important';"
                 onmouseout="this.style.transform='translateY(0)'; this.style.boxShadow='0 4px 6px rgba(0, 0, 0, 0.05) !important';">
                <div class="card-body text-center" style="padding: 2rem !important;">
                    <div class="stat-icon" style="color: #3182ce !important; font-size: 3rem !important; margin-bottom: 1rem !important;">📋</div>
                    <div class="stat-number h2 mb-2" style="color: #1a202c !important; font-weight: 800 !important;">{{ number_format($overallStats['total_items'] ?? 0) }}</div>
                    <div class="stat-label" style="color: #4a5568 !important; font-size: 16px !important; font-weight: 600 !important;">Total Items</div>
                </div>
            </div>
        </div>
        <div class="col-lg-3 col-md-6 mb-3">
            <div class="card" style="background: linear-gradient(135deg, #f0fdf4 0%, #dcfce7 100%) !important; border: 1px solid #dcfce7 !important; border-radius: 12px !important; box-shadow: 0 4px 6px rgba(0, 0, 0, 0.05) !important; transition: all 0.3s ease !important;"
                 onmouseover="this.style.transform='translateY(-2px)'; this.style.boxShadow='0 8px 25px rgba(0, 0, 0, 0.1) !important';"
                 onmouseout="this.style.transform='translateY(0)'; this.style.boxShadow='0 4px 6px rgba(0, 0, 0, 0.05) !important';">
                <div class="card-body text-center" style="padding: 2rem !important;">
                    <div class="stat-icon" style="color: #10b981 !important; font-size: 3rem !important; margin-bottom: 1rem !important;">📊</div>
                    <div class="stat-number h2 mb-2" style="color: #1a202c !important; font-weight: 800 !important;">{{ number_format($overallStats['total_quantity'] ?? 0) }}</div>
                    <div class="stat-label" style="color: #4a5568 !important; font-size: 16px !important; font-weight: 600 !important;">Total Quantity</div>
                </div>
            </div>
        </div>
        <div class="col-lg-3 col-md-6 mb-3">
            <div class="card" style="background: linear-gradient(135deg, #fef3c7 0%, #fed7aa 100%) !important; border: 1px solid #fed7aa !important; border-radius: 12px !important; box-shadow: 0 4px 6px rgba(0, 0, 0, 0.05) !important; transition: all 0.3s ease !important;"
                 onmouseover="this.style.transform='translateY(-2px)'; this.style.boxShadow='0 8px 25px rgba(0, 0, 0, 0.1) !important';"
                 onmouseout="this.style.transform='translateY(0)'; this.style.boxShadow='0 4px 6px rgba(0, 0, 0, 0.05) !important';">
                <div class="card-body text-center" style="padding: 2rem !important;">
                    <div class="stat-icon" style="color: #f59e0b !important; font-size: 3rem !important; margin-bottom: 1rem !important;">💰</div>
                    <div class="stat-number h2 mb-2" style="color: #1a202c !important; font-weight: 800 !important;">${{ number_format($overallStats['total_value'] ?? 0, 2) }}</div>
                    <div class="stat-label" style="color: #4a5568 !important; font-size: 16px !important; font-weight: 600 !important;">Total Value</div>
                </div>
            </div>
        </div>
        <div class="col-lg-3 col-md-6 mb-3">
            <div class="card" style="background: linear-gradient(135deg, #f3e8ff 0%, #e9d5ff 100%) !important; border: 1px solid #e9d5ff !important; border-radius: 12px !important; box-shadow: 0 4px 6px rgba(0, 0, 0, 0.05) !important; transition: all 0.3s ease !important;"
                 onmouseover="this.style.transform='translateY(-2px)'; this.style.boxShadow='0 8px 25px rgba(0, 0, 0, 0.1) !important';"
                 onmouseout="this.style.transform='translateY(0)'; this.style.boxShadow='0 4px 6px rgba(0, 0, 0, 0.05) !important';">
                <div class="card-body text-center" style="padding: 2rem !important;">
                    <div class="stat-icon" style="color: #8b5cf6 !important; font-size: 3rem !important; margin-bottom: 1rem !important;">💵</div>
                    <div class="stat-number h2 mb-2" style="color: #1a202c !important; font-weight: 800 !important;">${{ number_format($overallStats['average_unit_price'] ?? 0, 2) }}</div>
                    <div class="stat-label" style="color: #4a5568 !important; font-size: 16px !important; font-weight: 600 !important;">Avg Unit Price</div>
                </div>
            </div>
        </div>
    </div>

    <!-- Charts and Analytics -->
    <div class="row">
        <div class="col-lg-8">
            <!-- Monthly Trends Chart -->
            <div class="card mb-4" style="background: #ffffff !important; border: 1px solid #e2e8f0 !important; border-radius: 12px !important; box-shadow: 0 1px 3px rgba(0, 0, 0, 0.1) !important;">
                <div class="card-header" style="background: linear-gradient(135deg, #f7fafc 0%, #edf2f7 100%) !important; border-bottom: 1px solid #e2e8f0 !important; border-radius: 12px 12px 0 0 !important; padding: 1.5rem 2rem !important;">
                    <h5 class="mb-0" style="color: #1a202c !important; font-weight: 600 !important; font-size: 18px !important;">
                        <i class="bi bi-graph-up me-2" style="color: #3182ce !important;"></i>Monthly Trends (Last 12 Months)
                    </h5>
                </div>
                <div class="card-body" style="padding: 2rem !important;">
                    <div id="monthlyTrendsChart" style="height: 350px;"></div>
                </div>
            </div>

            <!-- Top Products by Revenue -->
            <div class="card mb-4" style="background: #ffffff !important; border: 1px solid #e2e8f0 !important; border-radius: 12px !important; box-shadow: 0 1px 3px rgba(0, 0, 0, 0.1) !important;">
                <div class="card-header" style="background: linear-gradient(135deg, #f7fafc 0%, #edf2f7 100%) !important; border-bottom: 1px solid #e2e8f0 !important; border-radius: 12px 12px 0 0 !important; padding: 1.5rem 2rem !important;">
                    <h5 class="mb-0" style="color: #1a202c !important; font-weight: 600 !important; font-size: 18px !important;">
                        <i class="bi bi-trophy me-2" style="color: #f59e0b !important;"></i>Top Products by Revenue
                    </h5>
                </div>
                <div class="card-body" style="padding: 2rem !important;">
                    @if($topProductsByRevenue->count() > 0)
                        <div class="table-responsive">
                            <table class="table table-hover">
                                <thead style="background: #f8fafc !important;">
                                    <tr>
                                        <th style="color: #2d3748 !important; font-weight: 600 !important; font-size: 14px !important; border: none !important; padding: 1rem !important;">Rank</th>
                                        <th style="color: #2d3748 !important; font-weight: 600 !important; font-size: 14px !important; border: none !important; padding: 1rem !important;">Product</th>
                                        <th style="color: #2d3748 !important; font-weight: 600 !important; font-size: 14px !important; border: none !important; padding: 1rem !important;">Revenue</th>
                                        <th style="color: #2d3748 !important; font-weight: 600 !important; font-size: 14px !important; border: none !important; padding: 1rem !important;">Quantity</th>
                                        <th style="color: #2d3748 !important; font-weight: 600 !important; font-size: 14px !important; border: none !important; padding: 1rem !important;">Orders</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($topProductsByRevenue as $index => $item)
                                        <tr style="transition: all 0.2s ease !important;" 
                                            onmouseover="this.style.backgroundColor='#f8fafc !important';" 
                                            onmouseout="this.style.backgroundColor='transparent';">
                                            <td style="padding: 1rem !important; border-bottom: 1px solid #f1f5f9 !important;">
                                                <span class="badge" style="
                                                    background: {{ $index < 3 ? ['#f59e0b', '#10b981', '#3182ce'][$index] : '#6b7280' }} !important; 
                                                    color: #ffffff !important; 
                                                    font-size: 12px !important; 
                                                    padding: 6px 12px !important; 
                                                    border-radius: 20px !important;
                                                ">
                                                    #{{ $index + 1 }}
                                                </span>
                                            </td>
                                            <td style="padding: 1rem !important; border-bottom: 1px solid #f1f5f9 !important;">
                                                <div style="color: #1a202c !important; font-weight: 600 !important; font-size: 14px !important;">
                                                    {{ $item->product->name ?? 'Product Not Found' }}
                                                </div>
                                                <div style="color: #4a5568 !important; font-size: 12px !important;">
                                                    SKU: {{ $item->product->sku ?? 'N/A' }}
                                                </div>
                                            </td>
                                            <td style="padding: 1rem !important; border-bottom: 1px solid #f1f5f9 !important;">
                                                <span style="color: #10b981 !important; font-weight: 700 !important; font-size: 16px !important;">
                                                    ${{ number_format($item->total_revenue, 2) }}
                                                </span>
                                            </td>
                                            <td style="padding: 1rem !important; border-bottom: 1px solid #f1f5f9 !important;">
                                                <span style="color: #1a202c !important; font-weight: 600 !important; font-size: 14px !important;">
                                                    {{ number_format($item->total_quantity) }}
                                                </span>
                                            </td>
                                            <td style="padding: 1rem !important; border-bottom: 1px solid #f1f5f9 !important;">
                                                <span style="color: #3182ce !important; font-weight: 600 !important; font-size: 14px !important;">
                                                    {{ number_format($item->order_count) }}
                                                </span>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @else
                        <div class="text-center py-4">
                            <i class="bi bi-inbox" style="color: #9ca3af !important; font-size: 3rem !important; margin-bottom: 1rem !important;"></i>
                            <h6 style="color: #4a5568 !important; font-weight: 500 !important;">No product data available</h6>
                        </div>
                    @endif
                </div>
            </div>
        </div>

        <div class="col-lg-4">
            <!-- Average Order Composition -->
            <div class="card mb-4" style="background: #ffffff !important; border: 1px solid #e2e8f0 !important; border-radius: 12px !important; box-shadow: 0 1px 3px rgba(0, 0, 0, 0.1) !important;">
                <div class="card-header" style="background: linear-gradient(135deg, #f7fafc 0%, #edf2f7 100%) !important; border-bottom: 1px solid #e2e8f0 !important; border-radius: 12px 12px 0 0 !important; padding: 1.5rem 2rem !important;">
                    <h5 class="mb-0" style="color: #1a202c !important; font-weight: 600 !important; font-size: 18px !important;">
                        <i class="bi bi-pie-chart me-2" style="color: #8b5cf6 !important;"></i>Order Composition
                    </h5>
                </div>
                <div class="card-body" style="padding: 2rem !important;">
                    <div class="composition-stats">
                        <div class="stat-item" style="padding: 1.5rem !important; background: linear-gradient(135deg, #f0f9ff 0%, #e0f2fe 100%) !important; border-radius: 10px !important; margin-bottom: 1rem !important; border-left: 4px solid #3182ce !important;">
                            <div class="d-flex justify-content-between align-items-center">
                                <div>
                                    <div style="color: #2d3748 !important; font-weight: 600 !important; font-size: 14px !important;">Avg Items per Order</div>
                                    <div style="color: #4a5568 !important; font-size: 12px !important;">Average number of items</div>
                                </div>
                                <div style="color: #3182ce !important; font-weight: 700 !important; font-size: 24px !important;">
                                    {{ number_format($averageOrderComposition['avg_items_per_order'] ?? 0, 1) }}
                                </div>
                            </div>
                        </div>
                        <div class="stat-item" style="padding: 1.5rem !important; background: linear-gradient(135deg, #f0fdf4 0%, #dcfce7 100%) !important; border-radius: 10px !important; border-left: 4px solid #10b981 !important;">
                            <div class="d-flex justify-content-between align-items-center">
                                <div>
                                    <div style="color: #2d3748 !important; font-weight: 600 !important; font-size: 14px !important;">Avg Quantity per Order</div>
                                    <div style="color: #4a5568 !important; font-size: 12px !important;">Average total quantity</div>
                                </div>
                                <div style="color: #10b981 !important; font-weight: 700 !important; font-size: 24px !important;">
                                    {{ number_format($averageOrderComposition['avg_quantity_per_order'] ?? 0, 1) }}
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Top Products by Quantity -->
            <div class="card" style="background: #ffffff !important; border: 1px solid #e2e8f0 !important; border-radius: 12px !important; box-shadow: 0 1px 3px rgba(0, 0, 0, 0.1) !important;">
                <div class="card-header" style="background: linear-gradient(135deg, #f7fafc 0%, #edf2f7 100%) !important; border-bottom: 1px solid #e2e8f0 !important; border-radius: 12px 12px 0 0 !important; padding: 1.5rem 2rem !important;">
                    <h5 class="mb-0" style="color: #1a202c !important; font-weight: 600 !important; font-size: 18px !important;">
                        <i class="bi bi-box-seam me-2" style="color: #10b981 !important;"></i>Top by Quantity
                    </h5>
                </div>
                <div class="card-body" style="padding: 2rem !important;">
                    @if($topProductsByQuantity->count() > 0)
                        @foreach($topProductsByQuantity->take(5) as $index => $item)
                            <div class="product-item" style="padding: 1rem !important; background: linear-gradient(135deg, #f8fafc 0%, #f1f5f9 100%) !important; border-radius: 8px !important; margin-bottom: 1rem !important; border: 1px solid #f1f5f9 !important; transition: all 0.2s ease !important;"
                                 onmouseover="this.style.transform='translateY(-1px)'; this.style.boxShadow='0 2px 8px rgba(0, 0, 0, 0.1) !important';"
                                 onmouseout="this.style.transform='translateY(0)'; this.style.boxShadow='none';">
                                <div class="d-flex justify-content-between align-items-center">
                                    <div class="flex-grow-1">
                                        <div style="color: #1a202c !important; font-weight: 600 !important; font-size: 14px !important; margin-bottom: 4px !important;">
                                            {{ $item->product->name ?? 'Product Not Found' }}
                                        </div>
                                        <div style="color: #4a5568 !important; font-size: 12px !important;">
                                            {{ number_format($item->order_count) }} orders • ${{ number_format($item->total_value, 2) }}
                                        </div>
                                    </div>
                                    <div class="text-end">
                                        <div style="color: #10b981 !important; font-weight: 700 !important; font-size: 16px !important;">
                                            {{ number_format($item->total_quantity) }}
                                        </div>
                                        <div style="color: #6b7280 !important; font-size: 11px !important;">units</div>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    @else
                        <div class="text-center py-3">
                            <i class="bi bi-inbox" style="color: #9ca3af !important; font-size: 2rem !important; margin-bottom: 0.5rem !important;"></i>
                            <p style="color: #4a5568 !important; font-size: 14px !important; margin: 0 !important;">No quantity data available</p>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>

    <!-- Orders with Most Items -->
    <div class="row mt-4">
        <div class="col-12">
            <div class="card" style="background: #ffffff !important; border: 1px solid #e2e8f0 !important; border-radius: 12px !important; box-shadow: 0 1px 3px rgba(0, 0, 0, 0.1) !important;">
                <div class="card-header" style="background: linear-gradient(135deg, #f7fafc 0%, #edf2f7 100%) !important; border-bottom: 1px solid #e2e8f0 !important; border-radius: 12px 12px 0 0 !important; padding: 1.5rem 2rem !important;">
                    <h5 class="mb-0" style="color: #1a202c !important; font-weight: 600 !important; font-size: 18px !important;">
                        <i class="bi bi-cart-check me-2" style="color: #06b6d4 !important;"></i>Orders with Most Items
                    </h5>
                </div>
                <div class="card-body" style="padding: 2rem !important;">
                    @if($ordersWithMostItems->count() > 0)
                        <div class="row">
                            @foreach($ordersWithMostItems->take(6) as $orderItem)
                                <div class="col-lg-4 col-md-6 mb-3">
                                    <div class="order-card" style="padding: 1.5rem !important; background: linear-gradient(135deg, #f0f9ff 0%, #e0f2fe 100%) !important; border-radius: 10px !important; border: 1px solid #e0f2fe !important; transition: all 0.2s ease !important;"
                                         onmouseover="this.style.transform='translateY(-2px)'; this.style.boxShadow='0 4px 12px rgba(0, 0, 0, 0.1) !important';"
                                         onmouseout="this.style.transform='translateY(0)'; this.style.boxShadow='none';">
                                        <div class="d-flex justify-content-between align-items-start mb-2">
                                            <div>
                                                <h6 style="color: #1a202c !important; font-weight: 600 !important; font-size: 16px !important; margin-bottom: 4px !important;">
                                                    <a href="{{ route('admin.orders.show', $orderItem->order) }}" 
                                                       style="color: #3182ce !important; text-decoration: none !important;"
                                                       onmouseover="this.style.textDecoration='underline !important';"
                                                       onmouseout="this.style.textDecoration='none !important';">
                                                        {{ $orderItem->order->order_number ?? 'Order Not Found' }}
                                                    </a>
                                                </h6>
                                                <div style="color: #4a5568 !important; font-size: 13px !important;">
                                                    {{ $orderItem->order->customer_name ?? 'Unknown Customer' }}
                                                </div>
                                            </div>
                                            <span class="badge" style="background: #06b6d4 !important; color: #ffffff !important; font-size: 11px !important; padding: 4px 8px !important; border-radius: 12px !important;">
                                                {{ $orderItem->items_count }} items
                                            </span>
                                        </div>
                                        <div class="order-stats">
                                            <div class="d-flex justify-content-between mb-1">
                                                <span style="color: #4a5568 !important; font-size: 13px !important;">Total Quantity:</span>
                                                <span style="color: #1a202c !important; font-weight: 600 !important; font-size: 13px !important;">{{ number_format($orderItem->total_quantity) }}</span>
                                            </div>
                                            <div class="d-flex justify-content-between">
                                                <span style="color: #4a5568 !important; font-size: 13px !important;">Total Value:</span>
                                                <span style="color: #10b981 !important; font-weight: 700 !important; font-size: 14px !important;">${{ number_format($orderItem->total_value, 2) }}</span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    @else
                        <div class="text-center py-4">
                            <i class="bi bi-inbox" style="color: #9ca3af !important; font-size: 3rem !important; margin-bottom: 1rem !important;"></i>
                            <h6 style="color: #4a5568 !important; font-weight: 500 !important;">No order data available</h6>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/apexcharts"></script>
<script>
    // Monthly Trends Chart
    document.addEventListener('DOMContentLoaded', function() {
        const monthlyData = @json($monthlyTrends);
        
        const chartOptions = {
            series: [{
                name: 'Items Count',
                type: 'column',
                data: monthlyData.map(item => item.items_count)
            }, {
                name: 'Total Value',
                type: 'line',
                data: monthlyData.map(item => parseFloat(item.total_value))
            }],
            chart: {
                height: 350,
                type: 'line',
                toolbar: {
                    show: true
                }
            },
            colors: ['#3182ce', '#10b981'],
            dataLabels: {
                enabled: false
            },
            stroke: {
                width: [0, 4]
            },
            xaxis: {
                categories: monthlyData.map(item => {
                    const date = new Date(item.month + '-01');
                    return date.toLocaleDateString('en-US', { month: 'short', year: 'numeric' });
                }).reverse()
            },
            yaxis: [{
                title: {
                    text: 'Items Count',
                },
            }, {
                opposite: true,
                title: {
                    text: 'Total Value ($)'
                }
            }],
            tooltip: {
                shared: true,
                intersect: false,
                y: [{
                    formatter: function (y) {
                        if (typeof y !== "undefined") {
                            return y + " items";
                        }
                        return y;
                    }
                }, {
                    formatter: function (y) {
                        if (typeof y !== "undefined") {
                            return "$" + y.toFixed(2);
                        }
                        return y;
                    }
                }]
            }
        };

        const chart = new ApexCharts(document.querySelector("#monthlyTrendsChart"), chartOptions);
        chart.render();
    });
</script>
@endpush
@endsection
