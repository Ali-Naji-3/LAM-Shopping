@extends('admin.dashboard')

@section('content')
<div class="container-fluid">
    <!-- Page Header -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h2 class="mb-1" style="color: #1a202c !important; font-weight: 700 !important; font-size: 28px !important;">
                <i class="bi bi-graph-up-arrow" style="color: #667eea;"></i> Payment Analytics Dashboard
            </h2>
            <p class="mb-0" style="color: #6b7280 !important; font-size: 15px !important;">
                Comprehensive insights into revenue, payment trends, and transaction performance
            </p>
        </div>
        <div class="d-flex gap-2">
            <button onclick="exportReport('excel')" class="btn btn-outline-success">
                <i class="bi bi-file-earmark-excel me-2"></i>Export Excel
            </button>
            <a href="{{ route('admin.transactions.index') }}" class="btn btn-outline-secondary">
                <i class="bi bi-arrow-left me-2"></i>Back
            </a>
        </div>
    </div>

    @php
        $stats = \App\Models\Transaction::getTransactionStatistics();
        $paymentBreakdown = \App\Models\Transaction::getPaymentMethodBreakdown();
        $dailyTrends = \App\Models\Transaction::getDailyTrends(30);
    @endphp

    <!-- Key Metrics -->
    <div class="row mb-4">
        <div class="col-lg-4 col-md-6 mb-3">
            <div class="card h-100" style="border: none; border-radius: 16px; background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); box-shadow: 0 4px 8px rgba(102, 126, 234, 0.3);">
                <div class="card-body text-center" style="padding: 2rem;">
                    <div style="color: rgba(255,255,255,0.9); font-size: 14px; font-weight: 600; text-transform: uppercase; letter-spacing: 0.5px; margin-bottom: 1rem;">Total Revenue</div>
                    <div style="color: #ffffff; font-size: 42px; font-weight: 700; margin-bottom: 0.5rem;">${{ number_format($stats['completed_amount'], 2) }}</div>
                    <div style="color: rgba(255,255,255,0.8); font-size: 13px;">
                        <i class="bi bi-check-circle"></i> From {{ $stats['completed_transactions'] }} completed
                    </div>
                </div>
            </div>
        </div>

        <div class="col-lg-4 col-md-6 mb-3">
            <div class="card h-100" style="border: none; border-radius: 16px; background: linear-gradient(135deg, #10b981 0%, #059669 100%); box-shadow: 0 4px 8px rgba(16, 185, 129, 0.3);">
                <div class="card-body text-center" style="padding: 2rem;">
                    <div style="color: rgba(255,255,255,0.9); font-size: 14px; font-weight: 600; text-transform: uppercase; letter-spacing: 0.5px; margin-bottom: 1rem;">Success Rate</div>
                    <div style="color: #ffffff; font-size: 42px; font-weight: 700; margin-bottom: 0.5rem;">{{ number_format($stats['success_rate'], 1) }}%</div>
                    <div style="color: rgba(255,255,255,0.8); font-size: 13px;">
                        <i class="bi bi-trophy"></i> {{ $stats['total_transactions'] }} total transactions
                    </div>
                </div>
            </div>
        </div>

        <div class="col-lg-4 col-md-6 mb-3">
            <div class="card h-100" style="border: none; border-radius: 16px; background: linear-gradient(135deg, #f59e0b 0%, #d97706 100%); box-shadow: 0 4px 8px rgba(245, 158, 11, 0.3);">
                <div class="card-body text-center" style="padding: 2rem;">
                    <div style="color: rgba(255,255,255,0.9); font-size: 14px; font-weight: 600; text-transform: uppercase; letter-spacing: 0.5px; margin-bottom: 1rem;">Avg Transaction</div>
                    <div style="color: #ffffff; font-size: 42px; font-weight: 700; margin-bottom: 0.5rem;">${{ number_format($stats['average_transaction'], 0) }}</div>
                    <div style="color: rgba(255,255,255,0.8); font-size: 13px;">
                        <i class="bi bi-calculator"></i> Per completed payment
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Charts Row -->
    <div class="row mb-4">
        <!-- Revenue Trend -->
        <div class="col-lg-8 mb-4">
            <div class="card" style="border: none; border-radius: 16px; box-shadow: 0 2px 8px rgba(0,0,0,0.08);">
                <div class="card-header" style="background: linear-gradient(135deg, #f8fafc 0%, #f1f5f9 100%); border: none; border-radius: 16px 16px 0 0; padding: 1.5rem 2rem;">
                    <h5 class="mb-0" style="color: #1a202c; font-weight: 700; font-size: 18px;">
                        <i class="bi bi-graph-up me-2" style="color: #667eea;"></i>Revenue Trend (Last 30 Days)
                    </h5>
                </div>
                <div class="card-body" style="padding: 2rem;">
                    <canvas id="revenueTrendChart" height="300"></canvas>
                </div>
            </div>
        </div>

        <!-- Payment Method Distribution -->
        <div class="col-lg-4 mb-4">
            <div class="card" style="border: none; border-radius: 16px; box-shadow: 0 2px 8px rgba(0,0,0,0.08);">
                <div class="card-header" style="background: linear-gradient(135deg, #f8fafc 0%, #f1f5f9 100%); border: none; border-radius: 16px 16px 0 0; padding: 1.5rem 2rem;">
                    <h5 class="mb-0" style="color: #1a202c; font-weight: 700; font-size: 18px;">
                        <i class="bi bi-pie-chart me-2" style="color: #10b981;"></i>Payment Methods
                    </h5>
                </div>
                <div class="card-body" style="padding: 2rem;">
                    <canvas id="paymentMethodChart" height="300"></canvas>
                </div>
            </div>
        </div>
    </div>

    <!-- Order Connection Analysis -->
    <div class="row">
        <div class="col-lg-12">
            <div class="card" style="border: none; border-radius: 16px; box-shadow: 0 2px 8px rgba(0,0,0,0.08);">
                <div class="card-header" style="background: linear-gradient(135deg, #10b981 0%, #059669 100%); border: none; border-radius: 16px 16px 0 0; padding: 1.5rem 2rem;">
                    <h5 class="mb-0" style="color: #ffffff; font-weight: 700; font-size: 18px;">
                        <i class="bi bi-link-45deg me-2"></i>Order & Product Performance
                    </h5>
                </div>
                <div class="card-body" style="padding: 2rem;">
                    @php
                        $transactionsWithOrders = \App\Models\Transaction::with('order.orderItems.product')
                            ->whereNotNull('order_id')
                            ->where('status', 'completed')
                            ->get();
                        
                        $totalRevenue = $transactionsWithOrders->sum('amount');
                        $totalOrders = $transactionsWithOrders->count();
                        $totalProducts = $transactionsWithOrders->flatMap(function($txn) {
                            return $txn->order->orderItems->pluck('product_id');
                        })->unique()->count();
                        $avgOrderValue = $totalOrders > 0 ? $totalRevenue / $totalOrders : 0;
                    @endphp

                    <div class="row">
                        <div class="col-md-3 text-center mb-3">
                            <div style="padding: 1.5rem; background: #f8fafc; border-radius: 12px;">
                                <div style="color: #6b7280; font-size: 12px; font-weight: 600; text-transform: uppercase; margin-bottom: 8px;">Connected Orders</div>
                                <div style="color: #3b82f6; font-size: 32px; font-weight: 700;">{{ $totalOrders }}</div>
                            </div>
                        </div>
                        <div class="col-md-3 text-center mb-3">
                            <div style="padding: 1.5rem; background: #f8fafc; border-radius: 12px;">
                                <div style="color: #6b7280; font-size: 12px; font-weight: 600; text-transform: uppercase; margin-bottom: 8px;">Products Sold</div>
                                <div style="color: #10b981; font-size: 32px; font-weight: 700;">{{ $totalProducts }}</div>
                            </div>
                        </div>
                        <div class="col-md-3 text-center mb-3">
                            <div style="padding: 1.5rem; background: #f8fafc; border-radius: 12px;">
                                <div style="color: #6b7280; font-size: 12px; font-weight: 600; text-transform: uppercase; margin-bottom: 8px;">Avg Order Value</div>
                                <div style="color: #f59e0b; font-size: 32px; font-weight: 700;">${{ number_format($avgOrderValue, 0) }}</div>
                            </div>
                        </div>
                        <div class="col-md-3 text-center mb-3">
                            <div style="padding: 1.5rem; background: #f8fafc; border-radius: 12px;">
                                <div style="color: #6b7280; font-size: 12px; font-weight: 600; text-transform: uppercase; margin-bottom: 8px;">Total Revenue</div>
                                <div style="color: #10b981; font-size: 28px; font-weight: 700;">${{ number_format($totalRevenue, 0) }}</div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Include Chart.js -->
<script src="https://cdn.jsdelivr.net/npm/chart.js@3.9.1/dist/chart.min.js"></script>

<script>
// Revenue Trend Chart
const labels = [@foreach($dailyTrends as $trend)'{{ \Carbon\Carbon::parse($trend['date'])->format('M d') }}'{{ !$loop->last ? ',' : '' }}@endforeach];
const data = [@foreach($dailyTrends as $trend){{ $trend['amount'] ?? 0 }}{{ !$loop->last ? ',' : '' }}@endforeach];

const revenueTrendCtx = document.getElementById('revenueTrendChart').getContext('2d');
new Chart(revenueTrendCtx, {
    type: 'line',
    data: {
        labels: labels.length > 0 ? labels : ['No Data'],
        datasets: [{
            label: 'Revenue',
            data: data.length > 0 ? data : [0],
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
            legend: { display: false },
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
                grid: { color: '#f1f5f9' }
            },
            x: { grid: { display: false } }
        }
    }
});

// Payment Method Pie Chart
const paymentMethodCtx = document.getElementById('paymentMethodChart').getContext('2d');
new Chart(paymentMethodCtx, {
    type: 'doughnut',
    data: {
        labels: [@foreach($paymentBreakdown as $pm)'{{ ucfirst(str_replace('_', ' ', $pm['payment_method'])) }}'{{ !$loop->last ? ',' : '' }}@endforeach],
        datasets: [{
            data: [@foreach($paymentBreakdown as $pm){{ $pm['total_amount'] }}{{ !$loop->last ? ',' : '' }}@endforeach],
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
    alert('Exporting analytics as ' + format.toUpperCase() + '...');
}
</script>

@endsection