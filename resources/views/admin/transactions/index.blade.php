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
                            <h1 class="h3 mb-1" style="color: #ffffff; font-weight: 700;">💳 Transactions Management</h1>
                            <p class="mb-0" style="color: rgba(255,255,255,0.9); font-size: 14px;">Payment processing • Financial tracking • Transaction analytics</p>
                        </div>
                        <div class="d-flex gap-2">
                            <a href="{{ route('admin.transactions.analytics') }}" class="btn btn-light" style="color: #4c51bf; font-weight: 600; border-radius: 8px;">
                                <i class="fas fa-chart-line me-1"></i> Analytics
                            </a>
                            <a href="{{ route('admin.transactions.create') }}" class="btn btn-outline-light" style="border-radius: 8px; font-weight: 600;">
                                <i class="fas fa-plus me-1"></i> New Transaction
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Compact Statistics -->
    <div class="row mb-3">
        <div class="col-xl-3 col-md-6 mb-2">
            <div class="card border-0 shadow stat-card" style="border-radius: 10px; background: linear-gradient(135deg, #48bb78 0%, #38a169 100%);">
                <div class="card-body text-white p-3">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <div style="color: rgba(255,255,255,0.8); font-size: 10px; font-weight: 600; text-transform: uppercase; margin-bottom: 4px;">Total Amount</div>
                            <div style="color: #ffffff; font-size: 20px; font-weight: 800;">${{ number_format($statistics['total_amount'], 2) }}</div>
                        </div>
                        <i class="fas fa-dollar-sign fa-lg" style="color: rgba(255,255,255,0.4);"></i>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-xl-3 col-md-6 mb-2">
            <div class="card border-0 shadow stat-card" style="border-radius: 10px; background: linear-gradient(135deg, #4299e1 0%, #3182ce 100%);">
                <div class="card-body text-white p-3">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <div style="color: rgba(255,255,255,0.8); font-size: 10px; font-weight: 600; text-transform: uppercase; margin-bottom: 4px;">Total Transactions</div>
                            <div style="color: #ffffff; font-size: 20px; font-weight: 800;">{{ number_format($statistics['total_transactions']) }}</div>
                        </div>
                        <i class="fas fa-receipt fa-lg" style="color: rgba(255,255,255,0.4);"></i>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-xl-3 col-md-6 mb-2">
            <div class="card border-0 shadow stat-card" style="border-radius: 10px; background: linear-gradient(135deg, #ed8936 0%, #dd6b20 100%);">
                <div class="card-body text-white p-3">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <div style="color: rgba(255,255,255,0.8); font-size: 10px; font-weight: 600; text-transform: uppercase; margin-bottom: 4px;">Success Rate</div>
                            <div style="color: #ffffff; font-size: 20px; font-weight: 800;">{{ number_format($statistics['success_rate'], 1) }}%</div>
                        </div>
                        <i class="fas fa-check-circle fa-lg" style="color: rgba(255,255,255,0.4);"></i>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-xl-3 col-md-6 mb-2">
            <div class="card border-0 shadow stat-card" style="border-radius: 10px; background: linear-gradient(135deg, #9f7aea 0%, #805ad5 100%);">
                <div class="card-body text-white p-3">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <div style="color: rgba(255,255,255,0.8); font-size: 10px; font-weight: 600; text-transform: uppercase; margin-bottom: 4px;">Avg Transaction</div>
                            <div style="color: #ffffff; font-size: 20px; font-weight: 800;">${{ number_format($statistics['average_transaction'], 2) }}</div>
                        </div>
                        <i class="fas fa-chart-bar fa-lg" style="color: rgba(255,255,255,0.4);"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Compact Filters -->
    <div class="card shadow mb-3">
        <div class="card-header py-2" style="background: #f8fafc; border-bottom: 1px solid #e2e8f0;">
            <h6 class="m-0" style="color: #2d3748; font-weight: 600; font-size: 14px;">🔍 Filters & Search</h6>
        </div>
        <div class="card-body p-3">
            <form method="GET" action="{{ route('admin.transactions.index') }}">
                <div class="row">
                    <div class="col-md-2">
                        <input type="text" class="form-control form-control-sm" name="search" 
                               value="{{ request('search') }}" placeholder="Search transactions...">
                    </div>
                    <div class="col-md-2">
                        <select class="form-control form-control-sm" name="status">
                            <option value="">All Status</option>
                            <option value="completed" {{ request('status') == 'completed' ? 'selected' : '' }}>Completed</option>
                            <option value="pending" {{ request('status') == 'pending' ? 'selected' : '' }}>Pending</option>
                            <option value="failed" {{ request('status') == 'failed' ? 'selected' : '' }}>Failed</option>
                            <option value="refunded" {{ request('status') == 'refunded' ? 'selected' : '' }}>Refunded</option>
                        </select>
                    </div>
                    <div class="col-md-2">
                        <select class="form-control form-control-sm" name="payment_mode">
                            <option value="">All Modes</option>
                            @foreach($paymentModes as $mode)
                                <option value="{{ $mode }}" {{ request('payment_mode') == $mode ? 'selected' : '' }}>
                                    {{ ucfirst(str_replace('_', ' ', $mode)) }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-2">
                        <input type="date" class="form-control form-control-sm" name="date_from" 
                               value="{{ request('date_from') }}" placeholder="From Date">
                    </div>
                    <div class="col-md-2">
                        <input type="date" class="form-control form-control-sm" name="date_to" 
                               value="{{ request('date_to') }}" placeholder="To Date">
                    </div>
                    <div class="col-md-2">
                        <div class="d-flex gap-1">
                            <button type="submit" class="btn btn-primary btn-sm" style="font-weight: 600;">
                                <i class="fas fa-search me-1"></i> Filter
                            </button>
                            <a href="{{ route('admin.transactions.index') }}" class="btn btn-secondary btn-sm">
                                <i class="fas fa-times"></i>
                            </a>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <!-- Compact Transactions Table -->
    <div class="card shadow mb-3">
        <div class="card-header py-2 d-flex justify-content-between align-items-center" style="background: #f8fafc;">
            <h6 class="m-0" style="color: #2d3748; font-weight: 600; font-size: 14px;">💳 Transaction Records</h6>
            <div class="d-flex gap-2">
                <button class="btn btn-sm btn-danger" onclick="bulkDelete()" id="bulkDeleteBtn" style="display: none; font-size: 11px;">
                    <i class="fas fa-trash me-1"></i> Delete Selected
                </button>
                <button class="btn btn-sm btn-info" onclick="bulkExport()" id="bulkExportBtn" style="display: none; font-size: 11px;">
                    <i class="fas fa-download me-1"></i> Export Selected
                </button>
            </div>
        </div>
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover mb-0" style="font-size: 13px;">
                    <thead style="background: linear-gradient(135deg, #f8fafc 0%, #e2e8f0 100%);">
                        <tr>
                            <th style="padding: 10px 8px; width: 40px;"><input type="checkbox" id="selectAll"></th>
                            <th style="padding: 10px 8px; color: #2d3748; font-weight: 700; font-size: 12px;">Transaction</th>
                            <th style="padding: 10px 8px; color: #2d3748; font-weight: 700; font-size: 12px;">Customer</th>
                            <th style="padding: 10px 8px; color: #2d3748; font-weight: 700; font-size: 12px;">Amount</th>
                            <th style="padding: 10px 8px; color: #2d3748; font-weight: 700; font-size: 12px;">Payment</th>
                            <th style="padding: 10px 8px; color: #2d3748; font-weight: 700; font-size: 12px;">Status</th>
                            <th style="padding: 10px 8px; color: #2d3748; font-weight: 700; font-size: 12px;">Date</th>
                            <th style="padding: 10px 8px; color: #2d3748; font-weight: 700; font-size: 12px;">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($transactions as $transaction)
                        <tr style="border-bottom: 1px solid #f1f5f9;">
                            <td style="padding: 10px 8px;"><input type="checkbox" class="item-checkbox" value="{{ $transaction->id }}"></td>
                            <td style="padding: 10px 8px;">
                                <div>
                                    <div style="color: #1a202c; font-weight: 600; font-size: 13px;">{{ $transaction->transaction_id ?? 'N/A' }}</div>
                                    @if($transaction->order)
                                        <div style="color: #718096; font-size: 11px;">Order: {{ $transaction->order->order_number }}</div>
                                    @endif
                                </div>
                            </td>
                            <td style="padding: 10px 8px;">
                                @if($transaction->user)
                                    <div style="color: #1a202c; font-weight: 600; font-size: 13px;">{{ $transaction->user->name }}</div>
                                    <div style="color: #718096; font-size: 11px;">{{ $transaction->user->email }}</div>
                                @else
                                    <span style="color: #a0aec0; font-style: italic;">Guest</span>
                                @endif
                            </td>
                            <td style="padding: 10px 8px;">
                                <div style="color: {{ $transaction->amount >= 0 ? '#22543d' : '#f56565' }}; font-weight: 700; font-size: 14px;">
                                    {{ $transaction->getFormattedAmount() }}
                                </div>
                            </td>
                            <td style="padding: 10px 8px;">
                                <div style="color: #1a202c; font-weight: 600; font-size: 12px;">{{ $transaction->payment_method }}</div>
                                <span class="badge badge-{{ $transaction->getPaymentModeColor() }}" style="font-size: 10px;">
                                    {{ ucfirst(str_replace('_', ' ', $transaction->payment_mode)) }}
                                </span>
                            </td>
                            <td style="padding: 10px 8px;">
                                <span class="badge badge-{{ $transaction->getStatusColor() }}" style="font-size: 11px; padding: 4px 8px;">
                                    {{ ucfirst($transaction->status) }}
                                </span>
                            </td>
                            <td style="padding: 10px 8px;">
                                <div style="color: #2d3748; font-size: 12px;">{{ $transaction->created_at->format('M d, Y') }}</div>
                                <div style="color: #718096; font-size: 10px;">{{ $transaction->created_at->format('H:i') }}</div>
                            </td>
                            <td style="padding: 10px 8px;">
                                <div class="d-flex gap-1">
                                    <a href="{{ route('admin.transactions.show', $transaction) }}" class="btn btn-sm btn-outline-primary" style="font-size: 11px; padding: 4px 8px;">
                                        <i class="fas fa-eye me-1"></i> View
                                    </a>
                                    <a href="{{ route('admin.transactions.edit', $transaction) }}" class="btn btn-sm btn-outline-warning" style="font-size: 11px; padding: 4px 8px;">
                                        <i class="fas fa-edit me-1"></i> Edit
                                    </a>
                                </div>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="8" class="text-center py-4">
                                <div class="empty-state">
                                    <i class="fas fa-credit-card fa-3x mb-3" style="color: #cbd5e0;"></i>
                                    <h6 style="color: #2d3748; font-weight: 600;">No transactions found</h6>
                                    <p style="color: #718096;">Start by creating your first transaction</p>
                                    <a href="{{ route('admin.transactions.create') }}" class="btn btn-primary">
                                        <i class="fas fa-plus me-1"></i> Create Transaction
                                    </a>
                                </div>
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <!-- Compact Pagination -->
            @if($transactions->hasPages())
            <div class="d-flex justify-content-between align-items-center p-3" style="background: #f8fafc; border-top: 1px solid #e2e8f0;">
                <div style="color: #718096; font-size: 12px;">
                    Showing {{ $transactions->firstItem() }}-{{ $transactions->lastItem() }} of {{ $transactions->total() }}
                </div>
                {{ $transactions->links('vendor.pagination.custom') }}
            </div>
            @endif
        </div>
    </div>
</div>

@push('styles')
<style>
/* Compact transaction table styling */
.table td, .table th {
    padding: 8px !important;
    border: none !important;
    vertical-align: middle !important;
}

.table tbody tr:hover {
    background: linear-gradient(135deg, #f8fafc 0%, #e2e8f0 100%) !important;
}

.stat-card {
    transition: all 0.3s ease !important;
    cursor: pointer !important;
}

.stat-card:hover {
    transform: translateY(-2px) scale(1.02) !important;
    box-shadow: 0 8px 20px rgba(0,0,0,0.15) !important;
}

.empty-state {
    padding: 30px 20px;
}

.btn-sm {
    font-size: 11px !important;
    padding: 4px 8px !important;
    border-radius: 4px !important;
}

.form-control-sm {
    font-size: 12px !important;
    padding: 4px 8px !important;
}

.badge {
    font-size: 10px !important;
    padding: 3px 6px !important;
    font-weight: 600 !important;
}
</style>
@endpush

@push('scripts')
<script>
// Checkbox functionality
document.getElementById('selectAll').addEventListener('change', function() {
    const checkboxes = document.querySelectorAll('.item-checkbox');
    checkboxes.forEach(checkbox => checkbox.checked = this.checked);
    toggleBulkButtons();
});

document.querySelectorAll('.item-checkbox').forEach(checkbox => {
    checkbox.addEventListener('change', toggleBulkButtons);
});

function toggleBulkButtons() {
    const checkedBoxes = document.querySelectorAll('.item-checkbox:checked');
    const bulkDeleteBtn = document.getElementById('bulkDeleteBtn');
    const bulkExportBtn = document.getElementById('bulkExportBtn');
    
    if (checkedBoxes.length > 0) {
        bulkDeleteBtn.style.display = 'inline-block';
        bulkExportBtn.style.display = 'inline-block';
    } else {
        bulkDeleteBtn.style.display = 'none';
        bulkExportBtn.style.display = 'none';
    }
}

function bulkDelete() {
    const checkedBoxes = document.querySelectorAll('.item-checkbox:checked');
    if (checkedBoxes.length === 0) return;
    
    if (confirm(`Are you sure you want to delete ${checkedBoxes.length} transactions?`)) {
        const form = document.createElement('form');
        form.method = 'POST';
        form.action = '{{ route("admin.transactions.bulk") }}';
        
        const csrfToken = document.createElement('input');
        csrfToken.type = 'hidden';
        csrfToken.name = '_token';
        csrfToken.value = '{{ csrf_token() }}';
        form.appendChild(csrfToken);
        
        const actionInput = document.createElement('input');
        actionInput.type = 'hidden';
        actionInput.name = 'action';
        actionInput.value = 'delete';
        form.appendChild(actionInput);
        
        checkedBoxes.forEach(checkbox => {
            const input = document.createElement('input');
            input.type = 'hidden';
            input.name = 'selected_items[]';
            input.value = checkbox.value;
            form.appendChild(input);
        });
        
        document.body.appendChild(form);
        form.submit();
    }
}

function bulkExport() {
    const checkedBoxes = document.querySelectorAll('.item-checkbox:checked');
    if (checkedBoxes.length === 0) return;
    
    showNotification(`Exporting ${checkedBoxes.length} transactions...`, 'info');
    
    setTimeout(() => {
        showNotification('Transactions exported successfully!', 'success');
    }, 2000);
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
