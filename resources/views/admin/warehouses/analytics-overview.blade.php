@extends('admin.dashboard')

@section('content')
<div class="container-fluid">
    <!-- Page Header -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h2 class="mb-1" style="color: #1a202c !important; font-weight: 700 !important; font-size: 28px !important;">
                <i class="bi bi-graph-up-arrow" style="color: #667eea;"></i> Warehouse Analytics Overview
            </h2>
            <p class="mb-0" style="color: #6b7280 !important; font-size: 15px !important;">
                Comprehensive insights across all warehouse facilities and inventory
            </p>
        </div>
        <div class="d-flex gap-2">
            <button onclick="exportReport('excel')" class="btn btn-outline-success">
                <i class="bi bi-file-earmark-excel me-2"></i>Export Excel
            </button>
            <button onclick="window.print()" class="btn btn-outline-secondary">
                <i class="bi bi-printer me-2"></i>Print Report
            </button>
            <a href="{{ route('admin.warehouses.index') }}" class="btn btn-outline-primary">
                <i class="bi bi-arrow-left me-2"></i>Back to Warehouses
            </a>
        </div>
    </div>

    @php
        $inventoryStats = \App\Models\Inventory::with('product')->get();
        $totalStockValue = $inventoryStats->sum(function($inv) {
            return $inv->quantity * ($inv->product->regular_price ?? 0);
        });
        $totalUnits = $inventoryStats->sum('quantity');
        $lowStockCount = $inventoryStats->filter(function($inv) { return $inv->isLowStock(); })->count();
        $outOfStockCount = $inventoryStats->filter(function($inv) { return $inv->isOutOfStock(); })->count();
        $totalWarehouses = \App\Models\Warehouse::count();
        $activeWarehouses = \App\Models\Warehouse::where('is_active', true)->count();
    @endphp

    <!-- Key Metrics -->
    <div class="row mb-4">
        <div class="col-lg-3 col-md-6 mb-3">
            <div class="card h-100" style="border: none; border-radius: 16px; background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); box-shadow: 0 4px 8px rgba(102, 126, 234, 0.3);">
                <div class="card-body text-center" style="padding: 2rem;">
                    <div style="color: rgba(255,255,255,0.9); font-size: 14px; font-weight: 600; text-transform: uppercase; letter-spacing: 0.5px; margin-bottom: 1rem;">Total Stock Value</div>
                    <div style="color: #ffffff; font-size: 42px; font-weight: 700; margin-bottom: 0.5rem;">${{ number_format($totalStockValue, 0) }}</div>
                    <div style="color: rgba(255,255,255,0.8); font-size: 13px;">
                        <i class="bi bi-box-seam"></i> Across {{ $totalWarehouses }} facilities
                    </div>
                </div>
            </div>
        </div>

        <div class="col-lg-3 col-md-6 mb-3">
            <div class="card h-100" style="border: none; border-radius: 16px; background: linear-gradient(135deg, #10b981 0%, #059669 100%); box-shadow: 0 4px 8px rgba(16, 185, 129, 0.3);">
                <div class="card-body text-center" style="padding: 2rem;">
                    <div style="color: rgba(255,255,255,0.9); font-size: 14px; font-weight: 600; text-transform: uppercase; letter-spacing: 0.5px; margin-bottom: 1rem;">Total Units</div>
                    <div style="color: #ffffff; font-size: 42px; font-weight: 700; margin-bottom: 0.5rem;">{{ number_format($totalUnits) }}</div>
                    <div style="color: rgba(255,255,255,0.8); font-size: 13px;">
                        <i class="bi bi-building"></i> {{ $activeWarehouses }} active warehouses
                    </div>
                </div>
            </div>
        </div>

        <div class="col-lg-3 col-md-6 mb-3">
            <div class="card h-100" style="border: none; border-radius: 16px; background: linear-gradient(135deg, #f59e0b 0%, #d97706 100%); box-shadow: 0 4px 8px rgba(245, 158, 11, 0.3);">
                <div class="card-body text-center" style="padding: 2rem;">
                    <div style="color: rgba(255,255,255,0.9); font-size: 14px; font-weight: 600; text-transform: uppercase; letter-spacing: 0.5px; margin-bottom: 1rem;">Low Stock Alerts</div>
                    <div style="color: #ffffff; font-size: 42px; font-weight: 700; margin-bottom: 0.5rem;">{{ $lowStockCount }}</div>
                    <div style="color: rgba(255,255,255,0.8); font-size: 13px;">
                        <i class="bi bi-exclamation-triangle"></i> Require attention
                    </div>
                </div>
            </div>
        </div>

        <div class="col-lg-3 col-md-6 mb-3">
            <div class="card h-100" style="border: none; border-radius: 16px; background: linear-gradient(135deg, #ef4444 0%, #dc2626 100%); box-shadow: 0 4px 8px rgba(239, 68, 68, 0.3);">
                <div class="card-body text-center" style="padding: 2rem;">
                    <div style="color: rgba(255,255,255,0.9); font-size: 14px; font-weight: 600; text-transform: uppercase; letter-spacing: 0.5px; margin-bottom: 1rem;">Out of Stock</div>
                    <div style="color: #ffffff; font-size: 42px; font-weight: 700; margin-bottom: 0.5rem;">{{ $outOfStockCount }}</div>
                    <div style="color: rgba(255,255,255,0.8); font-size: 13px;">
                        <i class="bi bi-x-circle"></i> Urgent restock
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Charts Row -->
    <div class="row mb-4">
        <!-- Warehouse Stock Distribution -->
        <div class="col-lg-8 mb-4">
            <div class="card" style="border: none; border-radius: 16px; box-shadow: 0 2px 8px rgba(0,0,0,0.08);">
                <div class="card-header" style="background: linear-gradient(135deg, #f8fafc 0%, #f1f5f9 100%); border: none; border-radius: 16px 16px 0 0; padding: 1.5rem 2rem;">
                    <h5 class="mb-0" style="color: #1a202c; font-weight: 700; font-size: 18px;">
                        <i class="bi bi-bar-chart me-2" style="color: #667eea;"></i>Stock Distribution by Warehouse
                    </h5>
                </div>
                <div class="card-body" style="padding: 2rem;">
                    <canvas id="warehouseStockChart" height="300"></canvas>
                </div>
            </div>
        </div>

        <!-- Warehouse Value Distribution -->
        <div class="col-lg-4 mb-4">
            <div class="card" style="border: none; border-radius: 16px; box-shadow: 0 2px 8px rgba(0,0,0,0.08);">
                <div class="card-header" style="background: linear-gradient(135deg, #f8fafc 0%, #f1f5f9 100%); border: none; border-radius: 16px 16px 0 0; padding: 1.5rem 2rem;">
                    <h5 class="mb-0" style="color: #1a202c; font-weight: 700; font-size: 18px;">
                        <i class="bi bi-pie-chart me-2" style="color: #10b981;"></i>Value Distribution
                    </h5>
                </div>
                <div class="card-body" style="padding: 2rem;">
                    <canvas id="warehouseValueChart" height="300"></canvas>
                </div>
            </div>
        </div>
    </div>

    <!-- Warehouse Comparison Table -->
    <div class="row">
        <div class="col-12">
            <div class="card" style="border: none; border-radius: 16px; box-shadow: 0 2px 8px rgba(0,0,0,0.08);">
                <div class="card-header" style="background: linear-gradient(135deg, #10b981 0%, #059669 100%); border: none; border-radius: 16px 16px 0 0; padding: 1.5rem 2rem;">
                    <h5 class="mb-0" style="color: #ffffff; font-weight: 700; font-size: 18px;">
                        <i class="bi bi-building me-2"></i>Warehouse Performance Comparison
                    </h5>
                </div>
                <div class="card-body" style="padding: 0;">
                    <div class="table-responsive">
                        <table class="table table-hover mb-0">
                            <thead style="background: #f8fafc; border-bottom: 2px solid #e2e8f0;">
                                <tr>
                                    <th style="padding: 1rem 1.5rem; color: #2d3748; font-weight: 700; font-size: 13px; text-transform: uppercase;">Rank</th>
                                    <th style="padding: 1rem 1.5rem; color: #2d3748; font-weight: 700; font-size: 13px; text-transform: uppercase;">Warehouse</th>
                                    <th style="padding: 1rem 1.5rem; color: #2d3748; font-weight: 700; font-size: 13px; text-transform: uppercase; text-align: center;">Products</th>
                                    <th style="padding: 1rem 1.5rem; color: #2d3748; font-weight: 700; font-size: 13px; text-transform: uppercase; text-align: center;">Units</th>
                                    <th style="padding: 1rem 1.5rem; color: #2d3748; font-weight: 700; font-size: 13px; text-transform: uppercase; text-align: right;">Value</th>
                                    <th style="padding: 1rem 1.5rem; color: #2d3748; font-weight: 700; font-size: 13px; text-transform: uppercase; text-align: center;">Health</th>
                                    <th style="padding: 1rem 1.5rem; color: #2d3748; font-weight: 700; font-size: 13px; text-transform: uppercase; text-align: center;">Status</th>
                                </tr>
                            </thead>
                            <tbody>
                                @php
                                    $warehouses = \App\Models\Warehouse::all()->map(function($wh) {
                                        $inv = \App\Models\Inventory::with('product')->where('warehouse_id', $wh->id)->get();
                                        $value = $inv->sum(function($i) { return $i->quantity * ($i->product->regular_price ?? 0); });
                                        $low = $inv->filter(function($i) { return $i->isLowStock(); })->count();
                                        $out = $inv->filter(function($i) { return $i->isOutOfStock(); })->count();
                                        $health = 100 - (($low + $out * 2) / max($inv->count(), 1) * 100);
                                        
                                        return (object)[
                                            'warehouse' => $wh,
                                            'products' => $inv->pluck('product_id')->unique()->count(),
                                            'units' => $inv->sum('quantity'),
                                            'value' => $value,
                                            'health' => $health,
                                            'low' => $low,
                                            'out' => $out,
                                        ];
                                    })->sortByDesc('value');
                                @endphp

                                @foreach($warehouses as $index => $data)
                                    <tr style="transition: all 0.2s;" onmouseover="this.style.backgroundColor='#f8fafc'" onmouseout="this.style.backgroundColor='transparent'">
                                        <td style="padding: 1rem 1.5rem; border-bottom: 1px solid #f1f5f9;">
                                            <div style="width: 32px; height: 32px; border-radius: 50%; background: {{ $index == 0 ? '#fbbf24' : ($index == 1 ? '#94a3b8' : ($index == 2 ? '#fb923c' : '#e2e8f0')) }}; display: flex; align-items: center; justify-content: center; color: {{ $index < 3 ? '#ffffff' : '#1a202c' }}; font-weight: 700; font-size: 14px;">
                                                {{ $index + 1 }}
                                            </div>
                                        </td>
                                        <td style="padding: 1rem 1.5rem; border-bottom: 1px solid #f1f5f9;">
                                            <div style="color: #1a202c; font-weight: 600; font-size: 14px; margin-bottom: 2px;">
                                                <a href="{{ route('admin.warehouses.show', $data->warehouse) }}" style="color: #3b82f6; text-decoration: none;" onmouseover="this.style.textDecoration='underline'" onmouseout="this.style.textDecoration='none'">
                                                    {{ $data->warehouse->name }}
                                                </a>
                                            </div>
                                            <div style="color: #9ca3af; font-size: 12px;">
                                                <i class="bi bi-geo-alt"></i> {{ $data->warehouse->location }}
                                            </div>
                                        </td>
                                        <td style="padding: 1rem 1.5rem; border-bottom: 1px solid #f1f5f9; text-align: center;">
                                            <span style="color: #3b82f6; font-weight: 700; font-size: 16px;">{{ $data->products }}</span>
                                        </td>
                                        <td style="padding: 1rem 1.5rem; border-bottom: 1px solid #f1f5f9; text-align: center;">
                                            <span style="color: #10b981; font-weight: 700; font-size: 16px;">{{ number_format($data->units) }}</span>
                                        </td>
                                        <td style="padding: 1rem 1.5rem; border-bottom: 1px solid #f1f5f9; text-align: right;">
                                            <span style="color: #1a202c; font-weight: 700; font-size: 16px;">${{ number_format($data->value, 0) }}</span>
                                        </td>
                                        <td style="padding: 1rem 1.5rem; border-bottom: 1px solid #f1f5f9; text-align: center;">
                                            <div class="d-flex flex-column align-items-center">
                                                <span style="color: {{ $data->health > 80 ? '#10b981' : ($data->health > 60 ? '#f59e0b' : '#ef4444') }}; font-weight: 700; font-size: 16px; margin-bottom: 4px;">
                                                    {{ number_format($data->health, 0) }}%
                                                </span>
                                                <div class="progress" style="width: 80px; height: 6px; background: #e2e8f0; border-radius: 10px;">
                                                    <div class="progress-bar" style="background: {{ $data->health > 80 ? '#10b981' : ($data->health > 60 ? '#f59e0b' : '#ef4444') }}; width: {{ $data->health }}%; border-radius: 10px;"></div>
                                                </div>
                                            </div>
                                        </td>
                                        <td style="padding: 1rem 1.5rem; border-bottom: 1px solid #f1f5f9; text-align: center;">
                                            <span class="badge" style="background: {{ $data->warehouse->is_active ? '#10b981' : '#ef4444' }}; color: #ffffff; font-size: 11px; padding: 6px 12px;">
                                                {{ $data->warehouse->is_active ? 'Active' : 'Inactive' }}
                                            </span>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                            <tfoot style="background: #f8fafc; border-top: 2px solid #e2e8f0;">
                                <tr>
                                    <td colspan="2" style="padding: 1rem 1.5rem; font-weight: 700; color: #1a202c;">Totals:</td>
                                    <td style="padding: 1rem 1.5rem; text-align: center; font-weight: 700; color: #3b82f6;">{{ $warehouses->sum('products') }}</td>
                                    <td style="padding: 1rem 1.5rem; text-align: center; font-weight: 700; color: #10b981;">{{ number_format($warehouses->sum('units')) }}</td>
                                    <td style="padding: 1rem 1.5rem; text-align: right; font-weight: 700; color: #1a202c;">${{ number_format($warehouses->sum('value'), 0) }}</td>
                                    <td colspan="2"></td>
                                </tr>
                            </tfoot>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Include Chart.js -->
<script src="https://cdn.jsdelivr.net/npm/chart.js@3.9.1/dist/chart.min.js"></script>

<script>
@php
    $chartData = \App\Models\Warehouse::all()->map(function($wh) {
        $inv = \App\Models\Inventory::with('product')->where('warehouse_id', $wh->id)->get();
        return (object)[
            'name' => $wh->name,
            'units' => $inv->sum('quantity'),
            'value' => $inv->sum(function($i) { return $i->quantity * ($i->product->regular_price ?? 0); })
        ];
    });
@endphp

// Stock Distribution Chart
const stockCtx = document.getElementById('warehouseStockChart').getContext('2d');
const stockChart = new Chart(stockCtx, {
    type: 'bar',
    data: {
        labels: [@foreach($chartData as $d)'{{ $d->name }}'{{ !$loop->last ? ',' : '' }}@endforeach],
        datasets: [{
            label: 'Units in Stock',
            data: [@foreach($chartData as $d){{ $d->units }}{{ !$loop->last ? ',' : '' }}@endforeach],
            backgroundColor: 'rgba(102, 126, 234, 0.8)',
            borderRadius: 8,
            barThickness: 50
        }]
    },
    options: {
        responsive: true,
        maintainAspectRatio: false,
        plugins: {
            legend: { display: false },
            tooltip: {
                backgroundColor: '#1f2937',
                padding: 12,
                callbacks: {
                    label: function(context) {
                        return context.parsed.y.toLocaleString() + ' units';
                    }
                }
            }
        },
        scales: {
            y: {
                beginAtZero: true,
                grid: { color: '#f1f5f9' }
            },
            x: { grid: { display: false } }
        }
    }
});

// Value Distribution Pie Chart
const valueCtx = document.getElementById('warehouseValueChart').getContext('2d');
const valueChart = new Chart(valueCtx, {
    type: 'doughnut',
    data: {
        labels: [@foreach($chartData as $d)'{{ $d->name }}'{{ !$loop->last ? ',' : '' }}@endforeach],
        datasets: [{
            data: [@foreach($chartData as $d){{ $d->value }}{{ !$loop->last ? ',' : '' }}@endforeach],
            backgroundColor: [
                'rgb(102, 126, 234)',
                'rgb(16, 185, 129)',
                'rgb(245, 158, 11)',
                'rgb(239, 68, 68)',
                'rgb(59, 130, 246)',
                'rgb(139, 92, 246)'
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
                labels: { padding: 15, font: { size: 12 }, usePointStyle: true }
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

function exportReport(format) {
    alert('Exporting warehouse analytics as ' + format.toUpperCase() + '...');
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

