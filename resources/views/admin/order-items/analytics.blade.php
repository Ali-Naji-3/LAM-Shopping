@extends('admin.dashboard')

@section('content')
<div class="container-fluid">
    <!-- Page Header -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h2 class="mb-1" style="color: #1a202c !important; font-weight: 700 !important; font-size: 28px !important;">
                <i class="bi bi-graph-up-arrow" style="color: #667eea;"></i> Advanced Sales Analytics
            </h2>
            <p class="mb-0" style="color: #6b7280 !important; font-size: 15px !important;">
                Comprehensive insights into product sales, revenue trends, and performance metrics
            </p>
        </div>
        <div class="d-flex gap-2">
            <button onclick="exportReport('pdf')" class="btn btn-outline-danger">
                <i class="bi bi-file-pdf me-2"></i>Export PDF
            </button>
            <button onclick="exportReport('excel')" class="btn btn-outline-success">
                <i class="bi bi-file-earmark-excel me-2"></i>Export Excel
            </button>
            <a href="{{ route('admin.orderItems.index') }}" class="btn btn-outline-secondary">
                <i class="bi bi-arrow-left me-2"></i>Back
            </a>
        </div>
    </div>

    <!-- Date Range Filter -->
    <div class="card mb-4" style="border: none; border-radius: 16px; box-shadow: 0 2px 4px rgba(0,0,0,0.06);">
        <div class="card-body" style="padding: 1.5rem;">
            <form method="GET" class="row g-3 align-items-end">
                <div class="col-md-3">
                    <label class="form-label" style="font-weight: 600; color: #374151; font-size: 14px;">
                        <i class="bi bi-calendar-range me-1"></i>Date From
                    </label>
                    <input type="date" name="date_from" class="form-control" value="{{ request('date_from', now()->subDays(30)->format('Y-m-d')) }}">
                </div>
                <div class="col-md-3">
                    <label class="form-label" style="font-weight: 600; color: #374151; font-size: 14px;">
                        <i class="bi bi-calendar-check me-1"></i>Date To
                    </label>
                    <input type="date" name="date_to" class="form-control" value="{{ request('date_to', now()->format('Y-m-d')) }}">
                </div>
                <div class="col-md-3">
                    <label class="form-label" style="font-weight: 600; color: #374151; font-size: 14px;">
                        <i class="bi bi-filter me-1"></i>Category
                    </label>
                    <select name="category_id" class="form-control">
                        <option value="">All Categories</option>
                        @foreach(\App\Models\Category::all() as $cat)
                            <option value="{{ $cat->id }}">{{ $cat->name }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-3">
                    <button type="submit" class="btn btn-primary w-100">
                        <i class="bi bi-search me-2"></i>Apply Filters
                    </button>
                </div>
            </form>
        </div>
    </div>

    <!-- Key Metrics Row -->
    <div class="row mb-4">
        @php
            $dateFrom = request('date_from', now()->subDays(30)->format('Y-m-d'));
            $dateTo = request('date_to', now()->format('Y-m-d'));
            
            $analytics = \App\Models\OrderItem::whereBetween('created_at', [$dateFrom, $dateTo])
                ->selectRaw('COUNT(*) as total_sales')
                ->selectRaw('SUM(quantity) as total_units')
                ->selectRaw('SUM(total_price) as total_revenue')
                ->selectRaw('AVG(unit_price) as avg_price')
                ->selectRaw('COUNT(DISTINCT order_id) as unique_orders')
                ->selectRaw('COUNT(DISTINCT product_id) as unique_products')
                ->first();
        @endphp

        <div class="col-lg-4 col-md-6 mb-3">
            <div class="card h-100" style="border: none; border-radius: 16px; background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); box-shadow: 0 4px 8px rgba(102, 126, 234, 0.3);">
                <div class="card-body text-center" style="padding: 2rem;">
                    <div style="color: rgba(255,255,255,0.9); font-size: 14px; font-weight: 600; text-transform: uppercase; letter-spacing: 0.5px; margin-bottom: 1rem;">Total Revenue</div>
                    <div style="color: #ffffff; font-size: 42px; font-weight: 700; margin-bottom: 0.5rem;">${{ number_format($analytics->total_revenue, 2) }}</div>
                    <div style="color: rgba(255,255,255,0.8); font-size: 13px;">
                        <i class="bi bi-arrow-up"></i> From {{ $analytics->total_sales }} sales
                    </div>
                </div>
            </div>
        </div>

        <div class="col-lg-4 col-md-6 mb-3">
            <div class="card h-100" style="border: none; border-radius: 16px; background: linear-gradient(135deg, #10b981 0%, #059669 100%); box-shadow: 0 4px 8px rgba(16, 185, 129, 0.3);">
                <div class="card-body text-center" style="padding: 2rem;">
                    <div style="color: rgba(255,255,255,0.9); font-size: 14px; font-weight: 600; text-transform: uppercase; letter-spacing: 0.5px; margin-bottom: 1rem;">Units Sold</div>
                    <div style="color: #ffffff; font-size: 42px; font-weight: 700; margin-bottom: 0.5rem;">{{ number_format($analytics->total_units) }}</div>
                    <div style="color: rgba(255,255,255,0.8); font-size: 13px;">
                        <i class="bi bi-box-seam"></i> {{ $analytics->unique_products }} products
                    </div>
                </div>
            </div>
        </div>

        <div class="col-lg-4 col-md-6 mb-3">
            <div class="card h-100" style="border: none; border-radius: 16px; background: linear-gradient(135deg, #f59e0b 0%, #d97706 100%); box-shadow: 0 4px 8px rgba(245, 158, 11, 0.3);">
                <div class="card-body text-center" style="padding: 2rem;">
                    <div style="color: rgba(255,255,255,0.9); font-size: 14px; font-weight: 600; text-transform: uppercase; letter-spacing: 0.5px; margin-bottom: 1rem;">Average Value</div>
                    <div style="color: #ffffff; font-size: 42px; font-weight: 700; margin-bottom: 0.5rem;">${{ number_format($analytics->avg_price, 2) }}</div>
                    <div style="color: rgba(255,255,255,0.8); font-size: 13px;">
                        <i class="bi bi-receipt"></i> Across {{ $analytics->unique_orders }} orders
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Charts Row -->
    <div class="row mb-4">
        <!-- Revenue Trend Chart -->
        <div class="col-lg-8 mb-4">
            <div class="card" style="border: none; border-radius: 16px; box-shadow: 0 2px 8px rgba(0,0,0,0.08); height: 100%;">
                <div class="card-header" style="background: linear-gradient(135deg, #f8fafc 0%, #f1f5f9 100%); border: none; border-radius: 16px 16px 0 0; padding: 1.5rem 2rem;">
                    <div class="d-flex justify-content-between align-items-center">
                        <h5 class="mb-0" style="color: #1a202c; font-weight: 700; font-size: 18px;">
                            <i class="bi bi-graph-up me-2" style="color: #667eea;"></i>Revenue Trend
                        </h5>
                        <div class="btn-group btn-group-sm" role="group">
                            <button type="button" class="btn btn-outline-primary active" onclick="updateChart('daily')">Daily</button>
                            <button type="button" class="btn btn-outline-primary" onclick="updateChart('weekly')">Weekly</button>
                            <button type="button" class="btn btn-outline-primary" onclick="updateChart('monthly')">Monthly</button>
                        </div>
                    </div>
                </div>
                <div class="card-body" style="padding: 2rem;">
                    <canvas id="revenueChart" height="300"></canvas>
                </div>
            </div>
        </div>

        <!-- Top Products Chart -->
        <div class="col-lg-4 mb-4">
            <div class="card" style="border: none; border-radius: 16px; box-shadow: 0 2px 8px rgba(0,0,0,0.08); height: 100%;">
                <div class="card-header" style="background: linear-gradient(135deg, #f8fafc 0%, #f1f5f9 100%); border: none; border-radius: 16px 16px 0 0; padding: 1.5rem 2rem;">
                    <h5 class="mb-0" style="color: #1a202c; font-weight: 700; font-size: 18px;">
                        <i class="bi bi-pie-chart me-2" style="color: #10b981;"></i>Top 5 Products
                    </h5>
                </div>
                <div class="card-body" style="padding: 2rem;">
                    <canvas id="topProductsChart" height="300"></canvas>
                </div>
            </div>
        </div>
    </div>

    <!-- Detailed Insights -->
    <div class="row">
        <!-- Best Sellers -->
        <div class="col-lg-6 mb-4">
            <div class="card" style="border: none; border-radius: 16px; box-shadow: 0 2px 8px rgba(0,0,0,0.08);">
                <div class="card-header" style="background: linear-gradient(135deg, #10b981 0%, #059669 100%); border: none; border-radius: 16px 16px 0 0; padding: 1.5rem 2rem;">
                    <h5 class="mb-0" style="color: #ffffff; font-weight: 700; font-size: 18px;">
                        <i class="bi bi-trophy-fill me-2"></i>Best Selling Products
                    </h5>
                </div>
                <div class="card-body" style="padding: 0;">
                    @php
                        $bestSellers = \App\Models\OrderItem::whereBetween('created_at', [$dateFrom, $dateTo])
                            ->select('product_id')
                            ->selectRaw('SUM(quantity) as total_quantity')
                            ->selectRaw('SUM(total_price) as total_revenue')
                            ->with('product')
                            ->groupBy('product_id')
                            ->orderBy('total_quantity', 'desc')
                            ->limit(10)
                            ->get();
                    @endphp

                    <div class="table-responsive">
                        <table class="table table-hover mb-0">
                            <thead style="background: #f8fafc;">
                                <tr>
                                    <th style="padding: 1rem 1.5rem; border: none; color: #6b7280; font-size: 12px; font-weight: 700; text-transform: uppercase;">#</th>
                                    <th style="padding: 1rem 1.5rem; border: none; color: #6b7280; font-size: 12px; font-weight: 700; text-transform: uppercase;">Product</th>
                                    <th style="padding: 1rem 1.5rem; border: none; color: #6b7280; font-size: 12px; font-weight: 700; text-transform: uppercase; text-align: right;">Units</th>
                                    <th style="padding: 1rem 1.5rem; border: none; color: #6b7280; font-size: 12px; font-weight: 700; text-transform: uppercase; text-align: right;">Revenue</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($bestSellers as $index => $item)
                                    <tr style="transition: all 0.2s;" onmouseover="this.style.backgroundColor='#f8fafc'" onmouseout="this.style.backgroundColor='transparent'">
                                        <td style="padding: 1rem 1.5rem; border-bottom: 1px solid #f1f5f9;">
                                            <div style="width: 32px; height: 32px; border-radius: 50%; background: {{ $index == 0 ? '#fbbf24' : ($index == 1 ? '#94a3b8' : ($index == 2 ? '#fb923c' : '#e2e8f0')) }}; display: flex; align-items: center; justify-content: center; color: {{ $index < 3 ? '#ffffff' : '#1a202c' }}; font-weight: 700; font-size: 14px;">
                                                {{ $index + 1 }}
                                            </div>
                                        </td>
                                        <td style="padding: 1rem 1.5rem; border-bottom: 1px solid #f1f5f9;">
                                            <div style="color: #1a202c; font-weight: 600; font-size: 14px;">{{ $item->product->name }}</div>
                                            <div style="color: #9ca3af; font-size: 12px;">{{ $item->product->sku }}</div>
                                        </td>
                                        <td style="padding: 1rem 1.5rem; border-bottom: 1px solid #f1f5f9; text-align: right;">
                                            <span style="color: #10b981; font-weight: 700; font-size: 15px;">{{ $item->total_quantity }}</span>
                                        </td>
                                        <td style="padding: 1rem 1.5rem; border-bottom: 1px solid #f1f5f9; text-align: right;">
                                            <span style="color: #1a202c; font-weight: 700; font-size: 15px;">${{ number_format($item->total_revenue, 2) }}</span>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>

        <!-- Revenue by Category -->
        <div class="col-lg-6 mb-4">
            <div class="card" style="border: none; border-radius: 16px; box-shadow: 0 2px 8px rgba(0,0,0,0.08);">
                <div class="card-header" style="background: linear-gradient(135deg, #3b82f6 0%, #2563eb 100%); border: none; border-radius: 16px 16px 0 0; padding: 1.5rem 2rem;">
                    <h5 class="mb-0" style="color: #ffffff; font-weight: 700; font-size: 18px;">
                        <i class="bi bi-folder-fill me-2"></i>Revenue by Category
                    </h5>
                </div>
                <div class="card-body" style="padding: 2rem;">
                    <canvas id="categoryRevenueChart" height="300"></canvas>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Include Chart.js -->
<script src="https://cdn.jsdelivr.net/npm/chart.js@3.9.1/dist/chart.min.js"></script>

<script>
// Revenue Trend Chart
const revenueCtx = document.getElementById('revenueChart').getContext('2d');
const revenueChart = new Chart(revenueCtx, {
    type: 'line',
    data: {
        labels: ['Day 1', 'Day 2', 'Day 3', 'Day 4', 'Day 5', 'Day 6', 'Day 7'],
        datasets: [{
            label: 'Revenue',
            data: [1200, 1900, 3000, 5000, 4000, 3000, 4500],
            borderColor: 'rgb(102, 126, 234)',
            backgroundColor: 'rgba(102, 126, 234, 0.1)',
            tension: 0.4,
            fill: true,
            borderWidth: 3
        }]
    },
    options: {
        responsive: true,
        maintainAspectRatio: false,
        plugins: {
            legend: {
                display: false
            },
            tooltip: {
                backgroundColor: '#1f2937',
                padding: 12,
                titleFont: { size: 14, weight: '600' },
                bodyFont: { size: 13 },
                displayColors: false,
                callbacks: {
                    label: function(context) {
                        return '$' + context.parsed.y.toLocaleString();
                    }
                }
            }
        },
        scales: {
            y: {
                beginAtZero: true,
                ticks: {
                    callback: function(value) {
                        return '$' + value.toLocaleString();
                    }
                },
                grid: {
                    color: '#f1f5f9'
                }
            },
            x: {
                grid: {
                    display: false
                }
            }
        }
    }
});

// Top Products Pie Chart
@php
    $topProducts = \App\Models\OrderItem::select('product_id')
        ->selectRaw('SUM(total_price) as revenue')
        ->with('product')
        ->groupBy('product_id')
        ->orderBy('revenue', 'desc')
        ->limit(5)
        ->get();
@endphp

const topProductsCtx = document.getElementById('topProductsChart').getContext('2d');
const topProductsChart = new Chart(topProductsCtx, {
    type: 'doughnut',
    data: {
        labels: [@foreach($topProducts as $p)'{{ $p->product->name }}'{{ !$loop->last ? ',' : '' }}@endforeach],
        datasets: [{
            data: [@foreach($topProducts as $p){{ $p->revenue }}{{ !$loop->last ? ',' : '' }}@endforeach],
            backgroundColor: [
                'rgb(102, 126, 234)',
                'rgb(16, 185, 129)',
                'rgb(245, 158, 11)',
                'rgb(239, 68, 68)',
                'rgb(59, 130, 246)'
            ],
            borderWidth: 0
        }]
    },
    options: {
        responsive: true,
        maintainAspectRatio: false,
        plugins: {
            legend: {
                position: 'bottom',
                labels: {
                    padding: 15,
                    font: { size: 12 },
                    usePointStyle: true
                }
            },
            tooltip: {
                backgroundColor: '#1f2937',
                padding: 12,
                callbacks: {
                    label: function(context) {
                        return context.label + ': $' + context.parsed.toLocaleString();
                    }
                }
            }
        }
    }
});

// Category Revenue Chart
@php
    $categoryRevenue = \App\Models\OrderItem::join('products', 'order_items.product_id', '=', 'products.id')
        ->join('categories', 'products.category_id', '=', 'categories.id')
        ->select('categories.name as category_name')
        ->selectRaw('SUM(order_items.total_price) as total_revenue')
        ->groupBy('categories.id', 'categories.name')
        ->orderBy('total_revenue', 'desc')
        ->limit(6)
        ->get();
@endphp

const categoryCtx = document.getElementById('categoryRevenueChart').getContext('2d');
const categoryChart = new Chart(categoryCtx, {
    type: 'bar',
    data: {
        labels: [@foreach($categoryRevenue as $cat)'{{ $cat->category_name }}'{{ !$loop->last ? ',' : '' }}@endforeach],
        datasets: [{
            label: 'Revenue',
            data: [@foreach($categoryRevenue as $cat){{ $cat->total_revenue }}{{ !$loop->last ? ',' : '' }}@endforeach],
            backgroundColor: 'rgba(59, 130, 246, 0.8)',
            borderRadius: 8,
            barThickness: 40
        }]
    },
    options: {
        responsive: true,
        maintainAspectRatio: false,
        plugins: {
            legend: {
                display: false
            },
            tooltip: {
                backgroundColor: '#1f2937',
                padding: 12,
                callbacks: {
                    label: function(context) {
                        return '$' + context.parsed.y.toLocaleString();
                    }
                }
            }
        },
        scales: {
            y: {
                beginAtZero: true,
                ticks: {
                    callback: function(value) {
                        return '$' + value.toLocaleString();
                    }
                },
                grid: {
                    color: '#f1f5f9'
                }
            },
            x: {
                grid: {
                    display: false
                }
            }
        }
    }
});

function exportReport(format) {
    alert('Exporting report as ' + format.toUpperCase() + '...\nThis feature will be implemented soon!');
}

function updateChart(period) {
    console.log('Updating chart for period:', period);
    // This would typically make an AJAX call to fetch new data
}
</script>

@endsection