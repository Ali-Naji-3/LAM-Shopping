@extends('admin.dashboard')

@section('content')
<div class="container-fluid">
    <!-- Compact Header -->
    <div class="row mb-3">
        <div class="col-12">
            <div class="d-flex justify-content-between align-items-center">
                <div>
                    <h1 class="h3 mb-0" style="color: #1a202c; font-weight: 700;">💳 Transaction Details</h1>
                    <p style="color: #4a5568; font-size: 14px; margin-bottom: 0;">{{ $transaction->transaction_id ?? 'Transaction #' . $transaction->id }}</p>
                </div>
                <div class="d-flex gap-2">
                    <a href="{{ route('admin.transactions.edit', $transaction) }}" class="btn btn-warning" style="font-weight: 600;">
                        <i class="fas fa-edit me-1"></i> Edit
                    </a>
                    <a href="{{ route('admin.transactions.index') }}" class="btn btn-secondary" style="font-weight: 600;">
                        <i class="fas fa-arrow-left me-1"></i> Back
                    </a>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-lg-8">
            <!-- Transaction Information -->
            <div class="card shadow border-0 mb-3" style="border-radius: 12px;">
                <div class="card-header" style="background: #f8fafc; border-bottom: 2px solid #e2e8f0; padding: 15px;">
                    <h6 class="m-0" style="color: #2d3748; font-weight: 700; font-size: 15px;">📋 Transaction Information</h6>
                </div>
                <div class="card-body p-3">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label style="color: #718096; font-size: 12px; font-weight: 600; text-transform: uppercase;">Transaction ID</label>
                                <div style="color: #1a202c; font-weight: 700; font-size: 16px;">{{ $transaction->transaction_id ?? 'N/A' }}</div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label style="color: #718096; font-size: 12px; font-weight: 600; text-transform: uppercase;">Amount</label>
                                <div style="color: {{ $transaction->amount >= 0 ? '#22543d' : '#f56565' }}; font-weight: 800; font-size: 24px;">
                                    {{ $transaction->getFormattedAmount() }}
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-4">
                            <div class="mb-3">
                                <label style="color: #718096; font-size: 12px; font-weight: 600; text-transform: uppercase;">Payment Method</label>
                                <div style="color: #1a202c; font-weight: 600; font-size: 14px;">{{ $transaction->payment_method }}</div>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="mb-3">
                                <label style="color: #718096; font-size: 12px; font-weight: 600; text-transform: uppercase;">Payment Mode</label>
                                <div>
                                    <span class="badge badge-{{ $transaction->getPaymentModeColor() }}" style="font-size: 12px; padding: 6px 12px;">
                                        {{ ucfirst(str_replace('_', ' ', $transaction->payment_mode)) }}
                                    </span>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="mb-3">
                                <label style="color: #718096; font-size: 12px; font-weight: 600; text-transform: uppercase;">Status</label>
                                <div>
                                    <span class="badge badge-{{ $transaction->getStatusColor() }}" style="font-size: 12px; padding: 6px 12px;">
                                        {{ ucfirst($transaction->status) }}
                                    </span>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label style="color: #718096; font-size: 12px; font-weight: 600; text-transform: uppercase;">Created Date</label>
                                <div style="color: #1a202c; font-weight: 600; font-size: 14px;">
                                    {{ $transaction->created_at->format('M d, Y \a\t H:i') }}
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label style="color: #718096; font-size: 12px; font-weight: 600; text-transform: uppercase;">Last Updated</label>
                                <div style="color: #1a202c; font-weight: 600; font-size: 14px;">
                                    {{ $transaction->updated_at->format('M d, Y \a\t H:i') }}
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Customer & Order Information -->
            <div class="card shadow border-0 mb-3" style="border-radius: 12px;">
                <div class="card-header" style="background: #f8fafc; border-bottom: 2px solid #e2e8f0; padding: 15px;">
                    <h6 class="m-0" style="color: #2d3748; font-weight: 700; font-size: 15px;">👤 Customer & Order Details</h6>
                </div>
                <div class="card-body p-3">
                    <div class="row">
                        <div class="col-md-6">
                            @if($transaction->user)
                                <div class="mb-3">
                                    <label style="color: #718096; font-size: 12px; font-weight: 600; text-transform: uppercase;">Customer</label>
                                    <div style="color: #1a202c; font-weight: 600; font-size: 14px;">{{ $transaction->user->name }}</div>
                                    <div style="color: #718096; font-size: 12px;">{{ $transaction->user->email }}</div>
                                </div>
                            @else
                                <div class="mb-3">
                                    <label style="color: #718096; font-size: 12px; font-weight: 600; text-transform: uppercase;">Customer</label>
                                    <div style="color: #a0aec0; font-style: italic;">Guest Transaction</div>
                                </div>
                            @endif
                        </div>
                        <div class="col-md-6">
                            @if($transaction->order)
                                <div class="mb-3">
                                    <label style="color: #718096; font-size: 12px; font-weight: 600; text-transform: uppercase;">Related Order</label>
                                    <div>
                                        <a href="{{ route('admin.orders.show', $transaction->order) }}" style="color: #4299e1; font-weight: 600; text-decoration: none;">
                                            {{ $transaction->order->order_number }}
                                        </a>
                                    </div>
                                    <div style="color: #718096; font-size: 12px;">Total: ${{ number_format($transaction->order->total_amount, 2) }}</div>
                                </div>
                            @else
                                <div class="mb-3">
                                    <label style="color: #718096; font-size: 12px; font-weight: 600; text-transform: uppercase;">Related Order</label>
                                    <div style="color: #a0aec0; font-style: italic;">Standalone Transaction</div>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>

            <!-- Gateway Response -->
            @if($transaction->gateway_response)
            <div class="card shadow border-0" style="border-radius: 12px;">
                <div class="card-header" style="background: #f8fafc; border-bottom: 2px solid #e2e8f0; padding: 15px;">
                    <h6 class="m-0" style="color: #2d3748; font-weight: 700; font-size: 15px;">🔧 Gateway Response</h6>
                </div>
                <div class="card-body p-3">
                    <pre style="background: #f1f5f9; border-radius: 6px; padding: 12px; font-size: 12px; color: #2d3748; max-height: 200px; overflow-y: auto;">{{ json_encode($transaction->gateway_response, JSON_PRETTY_PRINT) }}</pre>
                </div>
            </div>
            @endif
        </div>

        <div class="col-lg-4">
            <!-- Quick Actions -->
            <div class="card shadow border-0 mb-3" style="border-radius: 12px;">
                <div class="card-header" style="background: linear-gradient(135deg, #ed8936 0%, #dd6b20 100%); color: white; padding: 15px;">
                    <h6 class="m-0" style="font-weight: 700; font-size: 14px;">⚡ Quick Actions</h6>
                </div>
                <div class="card-body p-3">
                    @if($transaction->status === 'completed' && $transaction->amount > 0)
                        <button class="btn btn-danger btn-block mb-2" onclick="processRefund()" style="font-weight: 600; border-radius: 6px;">
                            <i class="fas fa-undo me-1"></i> Process Refund
                        </button>
                    @endif
                    
                    @if($transaction->status === 'pending')
                        <button class="btn btn-success btn-block mb-2" onclick="markCompleted()" style="font-weight: 600; border-radius: 6px;">
                            <i class="fas fa-check me-1"></i> Mark as Completed
                        </button>
                        <button class="btn btn-danger btn-block mb-2" onclick="markFailed()" style="font-weight: 600; border-radius: 6px;">
                            <i class="fas fa-times me-1"></i> Mark as Failed
                        </button>
                    @endif
                    
                    <button class="btn btn-info btn-block mb-2" onclick="downloadReceipt()" style="font-weight: 600; border-radius: 6px;">
                        <i class="fas fa-download me-1"></i> Download Receipt
                    </button>
                    
                    <button class="btn btn-secondary btn-block" onclick="viewAuditLog()" style="font-weight: 600; border-radius: 6px;">
                        <i class="fas fa-history me-1"></i> View Audit Log
                    </button>
                </div>
            </div>

            <!-- Transaction Summary -->
            <div class="card shadow border-0" style="border-radius: 12px;">
                <div class="card-header" style="background: linear-gradient(135deg, #9f7aea 0%, #805ad5 100%); color: white; padding: 15px;">
                    <h6 class="m-0" style="font-weight: 700; font-size: 14px;">📊 Transaction Summary</h6>
                </div>
                <div class="card-body p-3">
                    <div class="d-flex justify-content-between mb-2">
                        <span style="color: #718096; font-size: 12px;">Processing Time:</span>
                        <span style="color: #2d3748; font-weight: 600; font-size: 12px;">
                            {{ $transaction->created_at->diffForHumans() }}
                        </span>
                    </div>
                    
                    @if($transaction->user)
                    <div class="d-flex justify-content-between mb-2">
                        <span style="color: #718096; font-size: 12px;">Customer Since:</span>
                        <span style="color: #2d3748; font-weight: 600; font-size: 12px;">
                            {{ $transaction->user->created_at->format('M Y') }}
                        </span>
                    </div>
                    @endif

                    @if($relatedTransactions->count() > 0)
                    <div class="d-flex justify-content-between mb-2">
                        <span style="color: #718096; font-size: 12px;">Related Transactions:</span>
                        <span style="color: #4299e1; font-weight: 600; font-size: 12px;">
                            {{ $relatedTransactions->count() }} more
                        </span>
                    </div>
                    @endif

                    <hr style="margin: 12px 0;">
                    
                    <div class="d-flex justify-content-between">
                        <span style="color: #718096; font-size: 12px;">Transaction Type:</span>
                        <span class="badge badge-{{ $transaction->amount >= 0 ? 'success' : 'info' }}" style="font-size: 11px;">
                            {{ $transaction->amount >= 0 ? 'Payment' : 'Refund' }}
                        </span>
                    </div>
                </div>
            </div>

            <!-- Related Transactions -->
            @if($relatedTransactions->count() > 0)
            <div class="card shadow border-0 mt-3" style="border-radius: 12px;">
                <div class="card-header" style="background: #f8fafc; border-bottom: 2px solid #e2e8f0; padding: 15px;">
                    <h6 class="m-0" style="color: #2d3748; font-weight: 700; font-size: 15px;">🔗 Related Transactions</h6>
                </div>
                <div class="card-body p-3">
                    @foreach($relatedTransactions as $related)
                    <div class="d-flex justify-content-between align-items-center mb-2 p-2" style="background: #f8fafc; border-radius: 6px;">
                        <div>
                            <div style="color: #1a202c; font-weight: 600; font-size: 13px;">{{ $related->transaction_id }}</div>
                            <div style="color: #718096; font-size: 11px;">{{ $related->created_at->format('M d, Y') }}</div>
                        </div>
                        <div class="text-right">
                            <div style="color: {{ $related->amount >= 0 ? '#22543d' : '#f56565' }}; font-weight: 700;">
                                {{ $related->getFormattedAmount() }}
                            </div>
                            <span class="badge badge-{{ $related->getStatusColor() }}" style="font-size: 10px;">
                                {{ ucfirst($related->status) }}
                            </span>
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>
            @endif
        </div>
    </div>
</div>

<!-- Status Update Modal -->
<div class="modal fade" id="statusUpdateModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Update Transaction Status</h5>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>
            <form method="POST" action="{{ route('admin.transactions.updateStatus', $transaction) }}">
                @csrf
                @method('PATCH')
                <div class="modal-body">
                    <input type="hidden" name="status" id="newStatus">
                    <div class="form-group">
                        <label for="notes">Notes (Optional)</label>
                        <textarea class="form-control" name="notes" rows="3" placeholder="Reason for status change..."></textarea>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-primary" id="statusSubmitBtn">Update Status</button>
                </div>
            </form>
        </div>
    </div>
</div>

@push('scripts')
<script>
function markCompleted() {
    document.getElementById('newStatus').value = 'completed';
    document.getElementById('statusSubmitBtn').textContent = 'Mark as Completed';
    document.getElementById('statusSubmitBtn').className = 'btn btn-success';
    $('#statusUpdateModal').modal('show');
}

function markFailed() {
    document.getElementById('newStatus').value = 'failed';
    document.getElementById('statusSubmitBtn').textContent = 'Mark as Failed';
    document.getElementById('statusSubmitBtn').className = 'btn btn-danger';
    $('#statusUpdateModal').modal('show');
}

function processRefund() {
    showNotification('Refund processing feature coming soon!', 'info');
}

function downloadReceipt() {
    showNotification('Receipt generated successfully!', 'success');
}

function viewAuditLog() {
    showNotification('Audit log feature coming soon!', 'info');
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
