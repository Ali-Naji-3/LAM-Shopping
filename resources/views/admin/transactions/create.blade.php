@extends('admin.dashboard')

@section('content')
<div class="container-fluid">
    <!-- Compact Header -->
    <div class="row mb-3">
        <div class="col-12">
            <div class="d-flex justify-content-between align-items-center">
                <div>
                    <h1 class="h3 mb-0" style="color: #1a202c; font-weight: 700;">💳 Create New Transaction</h1>
                    <p style="color: #4a5568; font-size: 14px; margin-bottom: 0;">Process payment and record transaction details</p>
                </div>
                <a href="{{ route('admin.transactions.index') }}" class="btn btn-secondary" style="font-weight: 600;">
                    <i class="fas fa-arrow-left me-1"></i> Back to Transactions
                </a>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-lg-8">
            <!-- Main Form -->
            <div class="card shadow border-0" style="border-radius: 12px;">
                <div class="card-header" style="background: #f8fafc; border-bottom: 2px solid #e2e8f0; padding: 15px;">
                    <h6 class="m-0" style="color: #2d3748; font-weight: 700; font-size: 15px;">Transaction Information</h6>
                </div>
                <div class="card-body p-3">
                    <form action="{{ route('admin.transactions.store') }}" method="POST">
                        @csrf
                        
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group mb-3">
                                    <label class="form-label" style="color: #2d3748; font-weight: 600; font-size: 13px;">
                                        <i class="fas fa-user text-primary me-1"></i> Customer (Optional)
                                    </label>
                                    <select class="form-control @error('user_id') is-invalid @enderror" name="user_id">
                                        <option value="">Select Customer</option>
                                        @foreach($users as $user)
                                            <option value="{{ $user->id }}" {{ old('user_id') == $user->id ? 'selected' : '' }}>
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
                                        <i class="fas fa-shopping-cart text-info me-1"></i> Related Order (Optional)
                                    </label>
                                    <select class="form-control @error('order_id') is-invalid @enderror" name="order_id">
                                        <option value="">Select Order</option>
                                        @foreach($orders as $order)
                                            <option value="{{ $order->id }}" {{ old('order_id') == $order->id ? 'selected' : '' }}>
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
                            <div class="col-md-4">
                                <div class="form-group mb-3">
                                    <label class="form-label" style="color: #2d3748; font-weight: 600; font-size: 13px;">
                                        <i class="fas fa-dollar-sign text-success me-1"></i> Amount *
                                    </label>
                                    <input type="number" step="0.01" min="0.01" 
                                           class="form-control @error('amount') is-invalid @enderror" 
                                           name="amount" value="{{ old('amount') }}" 
                                           placeholder="0.00" required>
                                    @error('amount')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            
                            <div class="col-md-4">
                                <div class="form-group mb-3">
                                    <label class="form-label" style="color: #2d3748; font-weight: 600; font-size: 13px;">
                                        <i class="fas fa-coins text-warning me-1"></i> Currency *
                                    </label>
                                    <select class="form-control @error('currency') is-invalid @enderror" name="currency" required>
                                        <option value="USD" {{ old('currency', 'USD') == 'USD' ? 'selected' : '' }}>USD - US Dollar</option>
                                        <option value="EUR" {{ old('currency') == 'EUR' ? 'selected' : '' }}>EUR - Euro</option>
                                        <option value="GBP" {{ old('currency') == 'GBP' ? 'selected' : '' }}>GBP - British Pound</option>
                                        <option value="CAD" {{ old('currency') == 'CAD' ? 'selected' : '' }}>CAD - Canadian Dollar</option>
                                    </select>
                                    @error('currency')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            
                            <div class="col-md-4">
                                <div class="form-group mb-3">
                                    <label class="form-label" style="color: #2d3748; font-weight: 600; font-size: 13px;">
                                        <i class="fas fa-credit-card text-info me-1"></i> Payment Method *
                                    </label>
                                    <input type="text" 
                                           class="form-control @error('payment_method') is-invalid @enderror" 
                                           name="payment_method" value="{{ old('payment_method') }}" 
                                           placeholder="e.g., Credit Card, PayPal" required>
                                    @error('payment_method')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group mb-3">
                                    <label class="form-label" style="color: #2d3748; font-weight: 600; font-size: 13px;">
                                        <i class="fas fa-mobile-alt text-primary me-1"></i> Payment Mode *
                                    </label>
                                    <select class="form-control @error('payment_mode') is-invalid @enderror" name="payment_mode" required>
                                        <option value="online" {{ old('payment_mode', 'online') == 'online' ? 'selected' : '' }}>Online</option>
                                        <option value="cash" {{ old('payment_mode') == 'cash' ? 'selected' : '' }}>Cash</option>
                                        <option value="wallet" {{ old('payment_mode') == 'wallet' ? 'selected' : '' }}>Wallet</option>
                                        <option value="bank_transfer" {{ old('payment_mode') == 'bank_transfer' ? 'selected' : '' }}>Bank Transfer</option>
                                    </select>
                                    @error('payment_mode')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            
                            <div class="col-md-6">
                                <div class="form-group mb-3">
                                    <label class="form-label" style="color: #2d3748; font-weight: 600; font-size: 13px;">
                                        <i class="fas fa-flag text-warning me-1"></i> Status *
                                    </label>
                                    <select class="form-control @error('status') is-invalid @enderror" name="status" required>
                                        <option value="pending" {{ old('status', 'pending') == 'pending' ? 'selected' : '' }}>Pending</option>
                                        <option value="completed" {{ old('status') == 'completed' ? 'selected' : '' }}>Completed</option>
                                        <option value="failed" {{ old('status') == 'failed' ? 'selected' : '' }}>Failed</option>
                                        <option value="refunded" {{ old('status') == 'refunded' ? 'selected' : '' }}>Refunded</option>
                                    </select>
                                    @error('status')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <div class="form-group mb-3">
                            <label class="form-label" style="color: #2d3748; font-weight: 600; font-size: 13px;">
                                <i class="fas fa-server text-secondary me-1"></i> Gateway Response (Optional)
                            </label>
                            <textarea class="form-control @error('gateway_response') is-invalid @enderror" 
                                      name="gateway_response" rows="3" 
                                      placeholder='{"authorization_code": "ABC123", "reference": "REF456"}'>{{ old('gateway_response') }}</textarea>
                            <small class="form-text text-muted">JSON format for gateway response data</small>
                            @error('gateway_response')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="form-group">
                            <button type="submit" class="btn btn-primary" style="font-weight: 600; border-radius: 8px; padding: 10px 20px;">
                                <i class="fas fa-save me-1"></i> Create Transaction
                            </button>
                            <a href="{{ route('admin.transactions.index') }}" class="btn btn-secondary" style="font-weight: 600; border-radius: 8px; padding: 10px 20px;">
                                <i class="fas fa-times me-1"></i> Cancel
                            </a>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <div class="col-lg-4">
            <!-- Transaction Guidelines -->
            <div class="card shadow border-0" style="border-radius: 12px;">
                <div class="card-header" style="background: linear-gradient(135deg, #4299e1 0%, #3182ce 100%); color: white; padding: 15px;">
                    <h6 class="m-0" style="font-weight: 700; font-size: 14px;">📋 Transaction Guidelines</h6>
                </div>
                <div class="card-body p-3">
                    <div class="mb-3">
                        <h6 style="color: #2d3748; font-weight: 600; font-size: 13px;">💰 Payment Processing</h6>
                        <ul style="color: #718096; font-size: 12px; line-height: 1.5;">
                            <li>Verify payment details before processing</li>
                            <li>Use appropriate payment mode for method</li>
                            <li>Record gateway responses for audit trail</li>
                            <li>Set status based on payment outcome</li>
                        </ul>
                    </div>

                    <div class="mb-3">
                        <h6 style="color: #2d3748; font-weight: 600; font-size: 13px;">🔒 Security Best Practices</h6>
                        <ul style="color: #718096; font-size: 12px; line-height: 1.5;">
                            <li>Never store sensitive card details</li>
                            <li>Use secure payment gateways</li>
                            <li>Implement proper validation</li>
                            <li>Maintain transaction logs</li>
                        </ul>
                    </div>

                    <div class="mb-3">
                        <h6 style="color: #2d3748; font-weight: 600; font-size: 13px;">📊 Status Management</h6>
                        <ul style="color: #718096; font-size: 12px; line-height: 1.5;">
                            <li><span class="badge badge-warning">Pending</span> - Processing payment</li>
                            <li><span class="badge badge-success">Completed</span> - Payment successful</li>
                            <li><span class="badge badge-danger">Failed</span> - Payment declined</li>
                            <li><span class="badge badge-info">Refunded</span> - Money returned</li>
                        </ul>
                    </div>
                </div>
            </div>

            <!-- Quick Stats -->
            <div class="card shadow border-0 mt-3" style="border-radius: 12px;">
                <div class="card-header" style="background: linear-gradient(135deg, #48bb78 0%, #38a169 100%); color: white; padding: 15px;">
                    <h6 class="m-0" style="font-weight: 700; font-size: 14px;">📈 Today's Summary</h6>
                </div>
                <div class="card-body p-3">
                    @php
                        $todayStats = \App\Models\Transaction::whereDate('created_at', today())->get();
                        $todayAmount = $todayStats->sum('amount');
                        $todayCount = $todayStats->count();
                        $todaySuccess = $todayStats->where('status', 'completed')->count();
                    @endphp
                    <div class="d-flex justify-content-between mb-2">
                        <span style="color: #718096; font-size: 12px;">Total Amount:</span>
                        <span style="color: #22543d; font-weight: 700;">${{ number_format($todayAmount, 2) }}</span>
                    </div>
                    <div class="d-flex justify-content-between mb-2">
                        <span style="color: #718096; font-size: 12px;">Transactions:</span>
                        <span style="color: #2d3748; font-weight: 600;">{{ $todayCount }}</span>
                    </div>
                    <div class="d-flex justify-content-between">
                        <span style="color: #718096; font-size: 12px;">Success Rate:</span>
                        <span style="color: #22543d; font-weight: 700;">
                            {{ $todayCount > 0 ? round(($todaySuccess / $todayCount) * 100, 1) : 0 }}%
                        </span>
                    </div>
                </div>
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
// Auto-fill amount when order is selected
document.querySelector('select[name="order_id"]').addEventListener('change', function() {
    const selectedOption = this.options[this.selectedIndex];
    if (this.value && selectedOption.text.includes('$')) {
        const amount = selectedOption.text.split('$')[1];
        document.querySelector('input[name="amount"]').value = amount;
    }
});

// Payment mode suggestions
document.querySelector('select[name="payment_mode"]').addEventListener('change', function() {
    const paymentMethodInput = document.querySelector('input[name="payment_method"]');
    const suggestions = {
        'online': 'Credit Card',
        'cash': 'Cash',
        'wallet': 'Digital Wallet',
        'bank_transfer': 'Bank Transfer'
    };
    
    if (suggestions[this.value] && !paymentMethodInput.value) {
        paymentMethodInput.value = suggestions[this.value];
    }
});
</script>
@endpush
@endsection
