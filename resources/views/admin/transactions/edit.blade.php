@extends('admin.dashboard')

@section('content')
<div class="container-fluid">
    <!-- Compact Header -->
    <div class="row mb-3">
        <div class="col-12">
            <div class="d-flex justify-content-between align-items-center">
                <div>
                    <h1 class="h3 mb-0" style="color: #1a202c; font-weight: 700;">💳 Edit Transaction</h1>
                    <p style="color: #4a5568; font-size: 14px; margin-bottom: 0;">{{ $transaction->transaction_id ?? 'Transaction #' . $transaction->id }}</p>
                </div>
                <div class="d-flex gap-2">
                    <a href="{{ route('admin.transactions.show', $transaction) }}" class="btn btn-info" style="font-weight: 600;">
                        <i class="fas fa-eye me-1"></i> View Details
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
            <!-- Main Form -->
            <div class="card shadow border-0" style="border-radius: 12px;">
                <div class="card-header" style="background: #f8fafc; border-bottom: 2px solid #e2e8f0; padding: 15px;">
                    <h6 class="m-0" style="color: #2d3748; font-weight: 700; font-size: 15px;">Edit Transaction Information</h6>
                </div>
                <div class="card-body p-3">
                    <form action="{{ route('admin.transactions.update', $transaction) }}" method="POST">
                        @csrf
                        @method('PUT')
                        
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group mb-3">
                                    <label class="form-label" style="color: #2d3748; font-weight: 600; font-size: 13px;">
                                        <i class="fas fa-user text-primary me-1"></i> Customer
                                    </label>
                                    <select class="form-control @error('user_id') is-invalid @enderror" name="user_id">
                                        <option value="">Select Customer</option>
                                        @foreach($users as $user)
                                            <option value="{{ $user->id }}" {{ old('user_id', $transaction->user_id) == $user->id ? 'selected' : '' }}>
                                                {{ $user->name }} ({{ $user->email }})
                                            </option>
                                        @endforeach
                                    </select>
                                    @error('user_id')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            
                            <div class="col-md-6">
                                <div class="form-group mb-3">
                                    <label class="form-label" style="color: #2d3748; font-weight: 600; font-size: 13px;">
                                        <i class="fas fa-shopping-cart text-info me-1"></i> Related Order
                                    </label>
                                    <select class="form-control @error('order_id') is-invalid @enderror" name="order_id">
                                        <option value="">Select Order</option>
                                        @foreach($orders as $order)
                                            <option value="{{ $order->id }}" {{ old('order_id', $transaction->order_id) == $order->id ? 'selected' : '' }}>
                                                {{ $order->order_number }} - ${{ number_format($order->total_amount, 2) }}
                                            </option>
                                        @endforeach
                                    </select>
                                    @error('order_id')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group mb-3">
                                    <label class="form-label" style="color: #2d3748; font-weight: 600; font-size: 13px;">
                                        <i class="fas fa-hashtag text-secondary me-1"></i> Transaction ID
                                    </label>
                                    <input type="text" 
                                           class="form-control @error('transaction_id') is-invalid @enderror" 
                                           name="transaction_id" value="{{ old('transaction_id', $transaction->transaction_id) }}" 
                                           placeholder="Auto-generated if empty">
                                    @error('transaction_id')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            
                            <div class="col-md-3">
                                <div class="form-group mb-3">
                                    <label class="form-label" style="color: #2d3748; font-weight: 600; font-size: 13px;">
                                        <i class="fas fa-dollar-sign text-success me-1"></i> Amount *
                                    </label>
                                    <input type="number" step="0.01" 
                                           class="form-control @error('amount') is-invalid @enderror" 
                                           name="amount" value="{{ old('amount', $transaction->amount) }}" required>
                                    @error('amount')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            
                            <div class="col-md-3">
                                <div class="form-group mb-3">
                                    <label class="form-label" style="color: #2d3748; font-weight: 600; font-size: 13px;">
                                        <i class="fas fa-coins text-warning me-1"></i> Currency *
                                    </label>
                                    <select class="form-control @error('currency') is-invalid @enderror" name="currency" required>
                                        <option value="USD" {{ old('currency', $transaction->currency) == 'USD' ? 'selected' : '' }}>USD</option>
                                        <option value="EUR" {{ old('currency', $transaction->currency) == 'EUR' ? 'selected' : '' }}>EUR</option>
                                        <option value="GBP" {{ old('currency', $transaction->currency) == 'GBP' ? 'selected' : '' }}>GBP</option>
                                        <option value="CAD" {{ old('currency', $transaction->currency) == 'CAD' ? 'selected' : '' }}>CAD</option>
                                    </select>
                                    @error('currency')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-4">
                                <div class="form-group mb-3">
                                    <label class="form-label" style="color: #2d3748; font-weight: 600; font-size: 13px;">
                                        <i class="fas fa-credit-card text-info me-1"></i> Payment Method *
                                    </label>
                                    <input type="text" 
                                           class="form-control @error('payment_method') is-invalid @enderror" 
                                           name="payment_method" value="{{ old('payment_method', $transaction->payment_method) }}" required>
                                    @error('payment_method')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            
                            <div class="col-md-4">
                                <div class="form-group mb-3">
                                    <label class="form-label" style="color: #2d3748; font-weight: 600; font-size: 13px;">
                                        <i class="fas fa-mobile-alt text-primary me-1"></i> Payment Mode *
                                    </label>
                                    <select class="form-control @error('payment_mode') is-invalid @enderror" name="payment_mode" required>
                                        <option value="online" {{ old('payment_mode', $transaction->payment_mode) == 'online' ? 'selected' : '' }}>Online</option>
                                        <option value="cash" {{ old('payment_mode', $transaction->payment_mode) == 'cash' ? 'selected' : '' }}>Cash</option>
                                        <option value="wallet" {{ old('payment_mode', $transaction->payment_mode) == 'wallet' ? 'selected' : '' }}>Wallet</option>
                                        <option value="bank_transfer" {{ old('payment_mode', $transaction->payment_mode) == 'bank_transfer' ? 'selected' : '' }}>Bank Transfer</option>
                                    </select>
                                    @error('payment_mode')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            
                            <div class="col-md-4">
                                <div class="form-group mb-3">
                                    <label class="form-label" style="color: #2d3748; font-weight: 600; font-size: 13px;">
                                        <i class="fas fa-flag text-warning me-1"></i> Status *
                                    </label>
                                    <select class="form-control @error('status') is-invalid @enderror" name="status" required>
                                        <option value="pending" {{ old('status', $transaction->status) == 'pending' ? 'selected' : '' }}>Pending</option>
                                        <option value="completed" {{ old('status', $transaction->status) == 'completed' ? 'selected' : '' }}>Completed</option>
                                        <option value="failed" {{ old('status', $transaction->status) == 'failed' ? 'selected' : '' }}>Failed</option>
                                        <option value="refunded" {{ old('status', $transaction->status) == 'refunded' ? 'selected' : '' }}>Refunded</option>
                                    </select>
                                    @error('status')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <div class="form-group mb-3">
                            <label class="form-label" style="color: #2d3748; font-weight: 600; font-size: 13px;">
                                <i class="fas fa-server text-secondary me-1"></i> Gateway Response
                            </label>
                            <textarea class="form-control @error('gateway_response') is-invalid @enderror" 
                                      name="gateway_response" rows="4" 
                                      placeholder='{"authorization_code": "ABC123", "reference": "REF456"}'>{{ old('gateway_response', is_array($transaction->gateway_response) ? json_encode($transaction->gateway_response, JSON_PRETTY_PRINT) : $transaction->gateway_response) }}</textarea>
                            <small class="form-text text-muted">JSON format for gateway response data</small>
                            @error('gateway_response')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="form-group">
                            <button type="submit" class="btn btn-primary" style="font-weight: 600; border-radius: 8px; padding: 10px 20px;">
                                <i class="fas fa-save me-1"></i> Update Transaction
                            </button>
                            <a href="{{ route('admin.transactions.show', $transaction) }}" class="btn btn-secondary" style="font-weight: 600; border-radius: 8px; padding: 10px 20px;">
                                <i class="fas fa-times me-1"></i> Cancel
                            </a>
                            <button type="button" class="btn btn-danger float-right" onclick="confirmDelete()" style="font-weight: 600; border-radius: 8px; padding: 10px 20px;">
                                <i class="fas fa-trash me-1"></i> Delete Transaction
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <div class="col-lg-4">
            <!-- Current Status -->
            <div class="card shadow border-0 mb-3" style="border-radius: 12px;">
                <div class="card-header" style="background: linear-gradient(135deg, #{{ $transaction->getStatusColor() == 'success' ? '48bb78' : ($transaction->getStatusColor() == 'warning' ? 'ed8936' : ($transaction->getStatusColor() == 'danger' ? 'f56565' : '4299e1')) }} 0%, #{{ $transaction->getStatusColor() == 'success' ? '38a169' : ($transaction->getStatusColor() == 'warning' ? 'dd6b20' : ($transaction->getStatusColor() == 'danger' ? 'e53e3e' : '3182ce')) }} 100%); color: white; padding: 15px;">
                    <h6 class="m-0" style="font-weight: 700; font-size: 14px;">📊 Current Status</h6>
                </div>
                <div class="card-body p-3">
                    <div class="text-center mb-3">
                        <div style="color: #{{ $transaction->amount >= 0 ? '22543d' : 'f56565' }}; font-size: 24px; font-weight: 800;">
                            {{ $transaction->getFormattedAmount() }}
                        </div>
                        <span class="badge badge-{{ $transaction->getStatusColor() }} mt-2" style="font-size: 12px; padding: 6px 12px;">
                            {{ ucfirst($transaction->status) }}
                        </span>
                    </div>

                    <hr style="margin: 12px 0;">

                    <div class="mb-2">
                        <div class="d-flex justify-content-between">
                            <span style="color: #718096; font-size: 12px;">Payment Method:</span>
                            <span style="color: #2d3748; font-weight: 600; font-size: 12px;">{{ $transaction->payment_method }}</span>
                        </div>
                    </div>
                    
                    <div class="mb-2">
                        <div class="d-flex justify-content-between">
                            <span style="color: #718096; font-size: 12px;">Payment Mode:</span>
                            <span class="badge badge-{{ $transaction->getPaymentModeColor() }}" style="font-size: 10px;">
                                {{ ucfirst(str_replace('_', ' ', $transaction->payment_mode)) }}
                            </span>
                        </div>
                    </div>
                    
                    <div class="mb-2">
                        <div class="d-flex justify-content-between">
                            <span style="color: #718096; font-size: 12px;">Created:</span>
                            <span style="color: #2d3748; font-weight: 600; font-size: 12px;">{{ $transaction->created_at->format('M d, Y') }}</span>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Warning Card -->
            <div class="card shadow border-0" style="border-radius: 12px;">
                <div class="card-header" style="background: linear-gradient(135deg, #f56565 0%, #e53e3e 100%); color: white; padding: 15px;">
                    <h6 class="m-0" style="font-weight: 700; font-size: 14px;">⚠️ Important Notes</h6>
                </div>
                <div class="card-body p-3">
                    <div style="color: #742a2a; font-size: 12px; line-height: 1.5;">
                        <p class="mb-2"><strong>Editing Transactions:</strong></p>
                        <ul class="mb-0" style="padding-left: 16px;">
                            <li>Changes are logged for audit purposes</li>
                            <li>Status changes may trigger notifications</li>
                            <li>Gateway responses should be valid JSON</li>
                            <li>Amount changes affect financial reports</li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Delete Confirmation Modal -->
<div class="modal fade" id="deleteModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Confirm Deletion</h5>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>
            <div class="modal-body">
                <p>Are you sure you want to delete this transaction?</p>
                <div class="alert alert-warning">
                    <strong>Warning:</strong> This action cannot be undone. Transaction 
                    <strong>{{ $transaction->transaction_id ?? '#' . $transaction->id }}</strong> 
                    will be permanently removed from the system.
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                <form action="{{ route('admin.transactions.destroy', $transaction) }}" method="POST" class="d-inline">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-danger">
                        <i class="fas fa-trash me-1"></i> Delete Transaction
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>

@push('styles')
<style>
.form-control {
    border-radius: 6px !important;
    border: 2px solid #e2e8f0 !important;
    font-size: 13px !important;
    transition: all 0.3s ease !important;
}

.form-control:focus {
    border-color: #4299e1 !important;
    box-shadow: 0 0 0 3px rgba(66, 153, 225, 0.1) !important;
}

.form-label {
    margin-bottom: 6px !important;
}

.btn {
    transition: all 0.3s ease !important;
}

.btn:hover {
    transform: translateY(-1px) !important;
    box-shadow: 0 4px 12px rgba(0,0,0,0.15) !important;
}
</style>
@endpush

@push('scripts')
<script>
function confirmDelete() {
    $('#deleteModal').modal('show');
}

// Auto-fill amount when order is selected
document.querySelector('select[name="order_id"]').addEventListener('change', function() {
    const selectedOption = this.options[this.selectedIndex];
    if (this.value && selectedOption.text.includes('$')) {
        const amount = selectedOption.text.split('$')[1];
        document.querySelector('input[name="amount"]').value = amount;
    }
});
</script>
@endpush
@endsection
