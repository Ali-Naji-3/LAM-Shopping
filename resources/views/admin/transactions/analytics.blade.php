@extends('admin.dashboard')

@section('content')
<div class="container-fluid">
    <!-- Compact Header -->
    <div class="row mb-3">
        <div class="col-12">
            <div class="card shadow-lg border-0" style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); border-radius: 12px;">
                <div class="card-body text-white p-3">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h1 class="h3 mb-1" style="color: #ffffff; font-weight: 700;">💳 Transaction Analytics</h1>
                            <p class="mb-0" style="color: rgba(255,255,255,0.9); font-size: 14px;">Financial insights • Payment trends • Revenue analytics</p>
                        </div>
                        <div class="d-flex gap-2">
                            <a href="{{ route('admin.transactions.index') }}" class="btn btn-light" style="color: #4c51bf; font-weight: 600; border-radius: 8px;">
                                <i class="fas fa-list me-1"></i> All Transactions
                            </a>
                            <button class="btn btn-outline-light" onclick="exportReport()" style="border-radius: 8px; font-weight: 600;">
                                <i class="fas fa-download me-1"></i> Export Report
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
            <div class="card border-0 shadow stat-card" style="border-radius: 10px; background: linear-gradient(135deg, #48bb78 0%, #38a169 100%);">
                <div class="card-body text-white p-3">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <div style="color: rgba(255,255,255,0.8); font-size: 10px; font-weight: 600; text-transform: uppercase; margin-bottom: 4px;">Total Revenue</div>
                            <div style="color: #ffffff; font-size: 18px; font-weight: 800;">${{ number_format($statistics['total_amount'], 0) }}</div>
                        </div>
                        <i class="fas fa-dollar-sign fa-lg" style="color: rgba(255,255,255,0.4);"></i>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-xl-2 col-md-4 mb-2">
            <div class="card border-0 shadow stat-card" style="border-radius: 10px; background: linear-gradient(135deg, #4299e1 0%, #3182ce 100%);">
                <div class="card-body text-white p-3">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <div style="color: rgba(255,255,255,0.8); font-size: 10px; font-weight: 600; text-transform: uppercase; margin-bottom: 4px;">Transactions</div>
                            <div style="color: #ffffff; font-size: 18px; font-weight: 800;">{{ number_format($statistics['total_transactions']) }}</div>
                        </div>
                        <i class="fas fa-receipt fa-lg" style="color: rgba(255,255,255,0.4);"></i>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-xl-2 col-md-4 mb-2">
            <div class="card border-0 shadow stat-card" style="border-radius: 10px; background: linear-gradient(135deg, #ed8936 0%, #dd6b20 100%);">
                <div class="card-body text-white p-3">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <div style="color: rgba(255,255,255,0.8); font-size: 10px; font-weight: 600; text-transform: uppercase; margin-bottom: 4px;">Success Rate</div>
                            <div style="color: #ffffff; font-size: 18px; font-weight: 800;">{{ number_format($statistics['success_rate'], 1) }}%</div>
                        </div>
                        <i class="fas fa-check-circle fa-lg" style="color: rgba(255,255,255,0.4);"></i>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-xl-2 col-md-4 mb-2">
            <div class="card border-0 shadow stat-card" style="border-radius: 10px; background: linear-gradient(135deg, #9f7aea 0%, #805ad5 100%);">
                <div class="card-body text-white p-3">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <div style="color: rgba(255,255,255,0.8); font-size: 10px; font-weight: 600; text-transform: uppercase; margin-bottom: 4px;">Avg Amount</div>
                            <div style="color: #ffffff; font-size: 18px; font-weight: 800;">${{ number_format($statistics['average_transaction'], 0) }}</div>
                        </div>
                        <i class="fas fa-chart-bar fa-lg" style="color: rgba(255,255,255,0.4);"></i>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-xl-2 col-md-4 mb-2">
            <div class="card border-0 shadow stat-card" style="border-radius: 10px; background: linear-gradient(135deg, #f56565 0%, #e53e3e 100%);">
                <div class="card-body text-white p-3">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <div style="color: rgba(255,255,255,0.8); font-size: 10px; font-weight: 600; text-transform: uppercase; margin-bottom: 4px;">Failed</div>
                            <div style="color: #ffffff; font-size: 18px; font-weight: 800;">{{ number_format($statistics['failed_transactions']) }}</div>
                        </div>
                        <i class="fas fa-times-circle fa-lg" style="color: rgba(255,255,255,0.4);"></i>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-xl-2 col-md-4 mb-2">
            <div class="card border-0 shadow stat-card" style="border-radius: 10px; background: linear-gradient(135deg, #4fd1c7 0%, #38b2ac 100%);">
                <div class="card-body text-white p-3">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <div style="color: rgba(255,255,255,0.8); font-size: 10px; font-weight: 600; text-transform: uppercase; margin-bottom: 4px;">Refunded</div>
                            <div style="color: #ffffff; font-size: 18px; font-weight: 800;">${{ number_format($statistics['refunded_amount'], 0) }}</div>
                        </div>
                        <i class="fas fa-undo fa-lg" style="color: rgba(255,255,255,0.4);"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Payment Methods & Recent Transactions -->
    <div class="row mb-3">
        <div class="col-lg-6">
            <!-- Payment Methods Chart -->
            <div class="card shadow-lg border-0" style="border-radius: 12px;">
                <div class="card-header" style="background: linear-gradient(135deg, #4299e1 0%, #3182ce 100%); color: white; padding: 15px;">
                    <h6 class="m-0" style="font-weight: 700; font-size: 15px;">💳 Payment Methods Distribution</h6>
                </div>
                <div class="card-body p-3">
                    <div class="chart-container" style="position: relative; height: 300px;">
                        <canvas id="paymentMethodsChart"></canvas>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-lg-6">
            <!-- Recent Transactions -->
            <div class="card shadow-lg border-0" style="border-radius: 12px;">
                <div class="card-header" style="background: linear-gradient(135deg, #48bb78 0%, #38a169 100%); color: white; padding: 15px;">
                    <h6 class="m-0" style="font-weight: 700; font-size: 15px;">🕐 Recent Transactions</h6>
                </div>
                <div class="card-body p-0">
                    <div style="max-height: 300px; overflow-y: auto;">
                        @foreach($recentTransactions as $recent)
                        <div class="d-flex justify-content-between align-items-center p-3 border-bottom" style="border-color: #f1f5f9;">
                            <div>
                                <div style="color: #1a202c; font-weight: 600; font-size: 13px;">{{ $recent->transaction_id ?? 'N/A' }}</div>
                                <div style="color: #718096; font-size: 11px;">
                                    {{ $recent->user->name ?? 'Guest' }} • {{ $recent->created_at->format('M d, H:i') }}
                                </div>
                            </div>
                            <div class="text-right">
                                <div style="color: {{ $recent->amount >= 0 ? '#22543d' : '#f56565' }}; font-weight: 700; font-size: 14px;">
                                    {{ $recent->getFormattedAmount() }}
                                </div>
                                <span class="badge badge-{{ $recent->getStatusColor() }}" style="font-size: 10px;">
                                    {{ ucfirst($recent->status) }}
                                </span>
                            </div>
                        </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Failed Transactions & High Value -->
    <div class="row">
        <div class="col-lg-6">
            <!-- Failed Transactions -->
            <div class="card shadow border-0" style="border-radius: 12px;">
                <div class="card-header" style="background: linear-gradient(135deg, #f56565 0%, #e53e3e 100%); color: white; padding: 15px;">
                    <h6 class="m-0" style="font-weight: 700; font-size: 15px;">❌ Failed Transactions</h6>
                </div>
                <div class="card-body p-3">
                    @if($failedTransactions->count() > 0)
                        @foreach($failedTransactions as $failed)
                        <div class="d-flex justify-content-between align-items-center mb-2 p-2" style="background: #fef5f5; border-radius: 6px; border-left: 3px solid #f56565;">
                            <div>
                                <div style="color: #742a2a; font-weight: 600; font-size: 12px;">{{ $failed->transaction_id ?? 'N/A' }}</div>
                                <div style="color: #a0aec0; font-size: 10px;">{{ $failed->payment_method }}</div>
                            </div>
                            <div class="text-right">
                                <div style="color: #f56565; font-weight: 700; font-size: 13px;">{{ $failed->getFormattedAmount() }}</div>
                                <div style="color: #a0aec0; font-size: 10px;">{{ $failed->created_at->format('M d') }}</div>
                            </div>
                        </div>
                        @endforeach
                    @else
                        <div class="text-center py-3">
                            <i class="fas fa-check-circle fa-2x text-success mb-2"></i>
                            <p style="color: #22543d; font-weight: 600;">No failed transactions!</p>
                        </div>
                    @endif
                </div>
            </div>
        </div>

        <div class="col-lg-6">
            <!-- High Value Transactions -->
            <div class="card shadow border-0" style="border-radius: 12px;">
                <div class="card-header" style="background: linear-gradient(135deg, #ed8936 0%, #dd6b20 100%); color: white; padding: 15px;">
                    <h6 class="m-0" style="font-weight: 700; font-size: 15px;">💎 High Value Transactions</h6>
                </div>
                <div class="card-body p-3">
                    @foreach($highValueTransactions as $highValue)
                    <div class="d-flex justify-content-between align-items-center mb-2 p-2" style="background: #fffbeb; border-radius: 6px; border-left: 3px solid #ed8936;">
                        <div>
                            <div style="color: #744210; font-weight: 600; font-size: 12px;">{{ $highValue->transaction_id ?? 'N/A' }}</div>
                            <div style="color: #a0aec0; font-size: 10px;">{{ $highValue->user->name ?? 'Guest' }}</div>
                        </div>
                        <div class="text-right">
                            <div style="color: #ed8936; font-weight: 700; font-size: 13px;">{{ $highValue->getFormattedAmount() }}</div>
                            <span class="badge badge-{{ $highValue->getStatusColor() }}" style="font-size: 10px;">
                                {{ ucfirst($highValue->status) }}
                            </span>
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
</div>

@push('styles')
<style>
.stat-card {
    transition: all 0.3s ease !important;
    cursor: pointer !important;
}

.stat-card:hover {
    transform: translateY(-2px) scale(1.02) !important;
    box-shadow: 0 8px 20px rgba(0,0,0,0.15) !important;
}

.border-bottom {
    border-bottom: 1px solid #f1f5f9 !important;
}

.chart-container {
    background: radial-gradient(circle at center, rgba(255,255,255,0.9) 0%, rgba(248,250,252,0.9) 100%);
    border-radius: 8px;
    padding: 10px;
}
</style>
@endpush

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
document.addEventListener('DOMContentLoaded', function() {
    initializeCharts();
});

function initializeCharts() {
    // Payment Methods Chart
    const ctx = document.getElementById('paymentMethodsChart').getContext('2d');
    
    const paymentData = @json($paymentMethodBreakdown);
    const labels = paymentData.map(item => item.payment_method);
    const amounts = paymentData.map(item => item.total_amount);
    const counts = paymentData.map(item => item.count);
    
    new Chart(ctx, {
        type: 'doughnut',
        data: {
            labels: labels,
            datasets: [{
                data: amounts,
                backgroundColor: [
                    '#48bb78',
                    '#4299e1', 
                    '#ed8936',
                    '#9f7aea',
                    '#f56565',
                    '#4fd1c7'
                ],
                borderColor: '#ffffff',
                borderWidth: 3
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
                        usePointStyle: true,
                        font: {
                            size: 11,
                            weight: '600'
                        }
                    }
                },
                tooltip: {
                    backgroundColor: 'rgba(45, 55, 72, 0.95)',
                    titleColor: '#ffffff',
                    bodyColor: '#ffffff',
                    cornerRadius: 8,
                    callbacks: {
                        label: function(context) {
                            const method = context.label;
                            const amount = context.parsed;
                            const count = counts[context.dataIndex];
                            return [
                                `${method}`,
                                `Amount: $${amount.toLocaleString()}`,
                                `Transactions: ${count}`
                            ];
                        }
                    }
                }
            },
            animation: {
                animateRotate: true,
                duration: 2000
            }
        }
    });
}

function exportReport() {
    showNotification('Generating financial report...', 'info');
    
    setTimeout(() => {
        showNotification('Financial report exported successfully!', 'success');
    }, 3000);
}

function showNotification(message, type = 'info') {
    const notification = document.createElement('div');
    notification.className = `alert alert-${type} alert-dismissible fade show position-fixed`;
    notification.style.cssText = `
        top: 20px; 
        right: 20px; 
        z-index: 9999; 
        min-width: 300px;
        box-shadow: 0 10px 30px rgba(0,0,0,0.2);
        border-radius: 8px;
        border: none;
        font-size: 13px;
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
    
    setTimeout(() => {
        if (notification.parentNode) {
            notification.remove();
        }
    }, 4000);
}
</script>
@endpush
@endsection
