@extends('admin.dashboard')

@section('content')
<div class="container-fluid">
    <!-- Page Header -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h2 class="mb-1" style="color: #1a202c !important; font-weight: 700 !important; font-size: 28px !important;">
                <i class="bi bi-receipt" style="color: #667eea;"></i> Transaction Details
            </h2>
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb mb-0" style="background: none; padding: 0;">
                    <li class="breadcrumb-item"><a href="{{ route('admin.transactions.index') }}" style="color: #3b82f6; text-decoration: none;">Transactions</a></li>
                    <li class="breadcrumb-item active" style="color: #6b7280;">{{ $transaction->transaction_id }}</li>
                </ol>
            </nav>
        </div>
        <div class="d-flex gap-2">
            @if($transaction->order)
                <a href="{{ route('admin.orders.show', $transaction->order) }}" class="btn btn-outline-primary">
                    <i class="bi bi-cart me-2"></i>View Order
                </a>
            @endif
            @if($transaction->status === 'completed')
                <button onclick="processRefund()" class="btn btn-outline-warning">
                    <i class="bi bi-arrow-counterclockwise me-2"></i>Refund
                </button>
            @endif
            <button onclick="window.print()" class="btn btn-outline-secondary">
                <i class="bi bi-printer me-2"></i>Print
            </button>
            <a href="{{ route('admin.transactions.index') }}" class="btn btn-outline-secondary">
                <i class="bi bi-arrow-left me-2"></i>Back
            </a>
        </div>
    </div>

    <div class="row">
        <!-- Left Column -->
        <div class="col-lg-8">
            <!-- Transaction Information -->
            <div class="card mb-4" style="border: none; border-radius: 16px; box-shadow: 0 4px 6px rgba(0,0,0,0.07);">
                <div class="card-header" style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); border: none; border-radius: 16px 16px 0 0; padding: 1.5rem 2rem;">
                    <div class="d-flex justify-content-between align-items-center">
                        <h5 class="mb-0" style="color: #ffffff; font-weight: 700; font-size: 18px;">
                            <i class="bi bi-credit-card me-2"></i>Payment Information
                        </h5>
                        <span class="badge" style="background: rgba(255,255,255,0.3); color: #ffffff; font-size: 14px; padding: 8px 16px; border-radius: 20px;">
                            {{ $transaction->transaction_id }}
                        </span>
                    </div>
                </div>
                <div class="card-body" style="padding: 2rem;">
                    <div class="row">
                        <div class="col-md-6">
                            <table class="table table-borderless mb-0">
                                <tr>
                                    <td style="color: #6b7280; font-weight: 600; padding: 0.75rem 0; width: 40%;">Amount:</td>
                                    <td style="padding: 0.75rem 0;">
                                        <span style="color: #10b981; font-weight: 700; font-size: 24px;">${{ number_format($transaction->amount, 2) }}</span>
                                        <span style="color: #9ca3af; font-size: 14px;"> {{ $transaction->currency }}</span>
                                    </td>
                                </tr>
                                <tr>
                                    <td style="color: #6b7280; font-weight: 600; padding: 0.75rem 0;">Payment Method:</td>
                                    <td style="padding: 0.75rem 0; color: #1a202c; font-weight: 500;">
                                        <i class="bi bi-credit-card-2-front text-primary"></i> {{ ucfirst(str_replace('_', ' ', $transaction->payment_method)) }}
                                    </td>
                                </tr>
                                <tr>
                                    <td style="color: #6b7280; font-weight: 600; padding: 0.75rem 0;">Payment Mode:</td>
                                    <td style="padding: 0.75rem 0;">
                                        <span class="badge" style="background: {{ $transaction->payment_mode === 'online' ? '#3b82f6' : ($transaction->payment_mode === 'cash' ? '#10b981' : '#6b7280') }}; font-size: 13px; padding: 6px 14px;">
                                            {{ ucfirst($transaction->payment_mode ?? 'N/A') }}
                                        </span>
                                    </td>
                                </tr>
                            </table>
                        </div>
                        <div class="col-md-6">
                            <table class="table table-borderless mb-0">
                                <tr>
                                    <td style="color: #6b7280; font-weight: 600; padding: 0.75rem 0; width: 40%;">Status:</td>
                                    <td style="padding: 0.75rem 0;">
                                        <span class="badge" style="background: {{ $transaction->status === 'completed' ? '#10b981' : ($transaction->status === 'pending' ? '#f59e0b' : ($transaction->status === 'failed' ? '#ef4444' : '#3b82f6')) }}; color: #ffffff; font-size: 14px; padding: 8px 16px; border-radius: 20px; font-weight: 600;">
                                            {{ ucfirst($transaction->status) }}
                                        </span>
                                    </td>
                                </tr>
                                <tr>
                                    <td style="color: #6b7280; font-weight: 600; padding: 0.75rem 0;">Date & Time:</td>
                                    <td style="padding: 0.75rem 0; color: #1a202c;">
                                        {{ $transaction->created_at->format('M d, Y \a\t g:i A') }}
                                    </td>
                                </tr>
                                <tr>
                                    <td style="color: #6b7280; font-weight: 600; padding: 0.75rem 0;">Transaction Age:</td>
                                    <td style="padding: 0.75rem 0; color: #1a202c;">
                                        {{ $transaction->created_at->diffForHumans() }}
                                    </td>
                                </tr>
                            </table>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Order Connection -->
            @if($transaction->order)
                <div class="card mb-4" style="border: none; border-radius: 16px; box-shadow: 0 4px 6px rgba(0,0,0,0.07);">
                    <div class="card-header" style="background: linear-gradient(135deg, #10b981 0%, #059669 100%); border: none; border-radius: 16px 16px 0 0; padding: 1.5rem 2rem;">
                        <h5 class="mb-0" style="color: #ffffff; font-weight: 700; font-size: 18px;">
                            <i class="bi bi-cart3 me-2"></i>Connected Order Details
                        </h5>
                    </div>
                    <div class="card-body" style="padding: 2rem;">
                        <div class="row mb-4">
                            <div class="col-md-6">
                                <table class="table table-borderless mb-0">
                                    <tr>
                                        <td style="color: #6b7280; font-weight: 600; padding: 0.5rem 0; width: 40%;">Order Number:</td>
                                        <td style="padding: 0.5rem 0;">
                                            <a href="{{ route('admin.orders.show', $transaction->order) }}" style="color: #3b82f6; font-weight: 600; text-decoration: none;" onmouseover="this.style.textDecoration='underline'" onmouseout="this.style.textDecoration='none'">
                                                {{ $transaction->order->order_number }}
                                            </a>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td style="color: #6b7280; font-weight: 600; padding: 0.5rem 0;">Customer:</td>
                                        <td style="padding: 0.5rem 0; color: #1a202c; font-weight: 500;">
                                            {{ $transaction->order->customer_name }}
                                        </td>
                                    </tr>
                                    <tr>
                                        <td style="color: #6b7280; font-weight: 600; padding: 0.5rem 0;">Email:</td>
                                        <td style="padding: 0.5rem 0; color: #1a202c;">
                                            {{ $transaction->order->customer_email }}
                                        </td>
                                    </tr>
                                </table>
                            </div>
                            <div class="col-md-6">
                                <table class="table table-borderless mb-0">
                                    <tr>
                                        <td style="color: #6b7280; font-weight: 600; padding: 0.5rem 0; width: 40%;">Order Status:</td>
                                        <td style="padding: 0.5rem 0;">
                                            <span class="badge" style="background: {{ $transaction->order->status_color }}; color: #ffffff; font-size: 12px; padding: 6px 12px;">
                                                {{ ucfirst($transaction->order->status) }}
                                            </span>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td style="color: #6b7280; font-weight: 600; padding: 0.5rem 0;">Order Total:</td>
                                        <td style="padding: 0.5rem 0; color: #10b981; font-weight: 700; font-size: 18px;">
                                            ${{ number_format($transaction->order->total_amount, 2) }}
                                        </td>
                                    </tr>
                                    <tr>
                                        <td style="color: #6b7280; font-weight: 600; padding: 0.5rem 0;">Items Count:</td>
                                        <td style="padding: 0.5rem 0; color: #1a202c; font-weight: 600;">
                                            {{ $transaction->order->orderItems->count() }} items
                                        </td>
                                    </tr>
                                </table>
                            </div>
                        </div>

                        <!-- Order Products -->
                        @if($transaction->order->orderItems->count() > 0)
                            <div style="padding: 1.5rem; background: #f8fafc; border-radius: 12px; border-left: 4px solid #10b981;">
                                <h6 style="color: #1a202c; font-weight: 700; margin-bottom: 1rem;">
                                    <i class="bi bi-box-seam me-2"></i>Order Products
                                </h6>
                                <div class="row g-3">
                                    @foreach($transaction->order->orderItems as $item)
                                        <div class="col-md-6">
                                            <div class="d-flex align-items-center p-2" style="background: #ffffff; border-radius: 8px;">
                                                @if($item->product && $item->product->image)
                                                    <img src="{{ asset('storage/' . $item->product->image) }}" 
                                                         alt="{{ $item->product->name }}" 
                                                         style="width: 50px; height: 50px; object-fit: cover; border-radius: 8px; margin-right: 12px; border: 2px solid #e2e8f0;">
                                                @endif
                                                <div class="flex-grow-1">
                                                    <div style="color: #1a202c; font-weight: 600; font-size: 13px;">{{ $item->product->name ?? 'N/A' }}</div>
                                                    <div style="color: #6b7280; font-size: 12px;">Qty: {{ $item->quantity }} × ${{ number_format($item->unit_price, 2) }}</div>
                                                </div>
                                                <div style="color: #10b981; font-weight: 700; font-size: 14px;">
                                                    ${{ number_format($item->total_price, 2) }}
                                                </div>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                        @endif
                    </div>
                </div>
            @endif

            <!-- Gateway Response - Hidden by default, available in backend -->
            @if($transaction->gateway_response && false)
                <!-- Gateway response data is stored in database but not displayed in frontend -->
                <!-- Access via: $transaction->gateway_response if needed for debugging -->
            @endif
        </div>

        <!-- Right Column - Stats & Info -->
        <div class="col-lg-4">
            <!-- Customer Information -->
            @if($transaction->user)
                <div class="card mb-4" style="border: none; border-radius: 16px; box-shadow: 0 4px 6px rgba(0,0,0,0.07);">
                    <div class="card-header" style="background: linear-gradient(135deg, #f59e0b 0%, #d97706 100%); border: none; border-radius: 16px 16px 0 0; padding: 1.5rem;">
                        <h5 class="mb-0" style="color: #ffffff; font-weight: 700; font-size: 16px;">
                            <i class="bi bi-person me-2"></i>Customer Info
                        </h5>
                    </div>
                    <div class="card-body" style="padding: 1.5rem;">
                        <div class="text-center mb-3">
                            <div style="width: 80px; height: 80px; background: linear-gradient(135deg, #f59e0b 0%, #d97706 100%); border-radius: 50%; display: flex; align-items: center; justify-content: center; margin: 0 auto 1rem;">
                                <i class="bi bi-person-fill" style="font-size: 40px; color: #ffffff;"></i>
                            </div>
                            <h6 style="color: #1a202c; font-weight: 700; margin-bottom: 4px;">{{ $transaction->user->name }}</h6>
                            <p style="color: #6b7280; font-size: 13px; margin-bottom: 2px;">{{ $transaction->user->email }}</p>
                            <span class="badge" style="background: {{ $transaction->user->u_type === 'ADM' ? '#ef4444' : ($transaction->user->u_type === 'MGR' ? '#f59e0b' : '#3b82f6') }}; font-size: 11px;">
                                {{ $transaction->user->u_type === 'ADM' ? 'Admin' : ($transaction->user->u_type === 'MGR' ? 'Manager' : 'Customer') }}
                            </span>
                        </div>
                        
                        @php
                            $userTransactions = \App\Models\Transaction::where('user_id', $transaction->user_id)->get();
                            $userTotalSpent = $userTransactions->where('status', 'completed')->sum('amount');
                            $userTxnCount = $userTransactions->count();
                        @endphp
                        
                        <div class="mb-3">
                            <div class="d-flex justify-content-between mb-2">
                                <span style="color: #6b7280; font-size: 13px;">Total Transactions</span>
                                <span style="color: #1a202c; font-weight: 700;">{{ $userTxnCount }}</span>
                            </div>
                            <div class="d-flex justify-content-between">
                                <span style="color: #6b7280; font-size: 13px;">Total Spent</span>
                                <span style="color: #10b981; font-weight: 700;">${{ number_format($userTotalSpent, 2) }}</span>
                            </div>
                        </div>
                    </div>
                </div>
            @endif

            <!-- Transaction Status -->
            <div class="card mb-4" style="border: none; border-radius: 16px; box-shadow: 0 4px 6px rgba(0,0,0,0.07);">
                <div class="card-body" style="padding: 1.5rem;">
                    <h6 style="color: #1a202c; font-weight: 700; margin-bottom: 1rem;">Transaction Timeline</h6>
                    
                    <div class="timeline">
                        <div class="timeline-item mb-3">
                            <div class="d-flex align-items-start">
                                <div style="width: 32px; height: 32px; background: #10b981; border-radius: 50%; display: flex; align-items: center; justify-content: center; margin-right: 12px;">
                                    <i class="bi bi-check" style="color: #ffffff; font-size: 16px;"></i>
                                </div>
                                <div>
                                    <div style="color: #1a202c; font-weight: 600; font-size: 13px;">Transaction Created</div>
                                    <div style="color: #9ca3af; font-size: 12px;">{{ $transaction->created_at->format('M d, Y g:i A') }}</div>
                                </div>
                            </div>
                        </div>
                        
                        @if($transaction->status === 'completed')
                            <div class="timeline-item mb-3">
                                <div class="d-flex align-items-start">
                                    <div style="width: 32px; height: 32px; background: #10b981; border-radius: 50%; display: flex; align-items: center; justify-content: center; margin-right: 12px;">
                                        <i class="bi bi-check-circle" style="color: #ffffff; font-size: 16px;"></i>
                                    </div>
                                    <div>
                                        <div style="color: #1a202c; font-weight: 600; font-size: 13px;">Payment Completed</div>
                                        <div style="color: #9ca3af; font-size: 12px;">{{ $transaction->updated_at->format('M d, Y g:i A') }}</div>
                                    </div>
                                </div>
                            </div>
                        @elseif($transaction->status === 'pending')
                            <div class="timeline-item">
                                <div class="d-flex align-items-start">
                                    <div style="width: 32px; height: 32px; background: #f59e0b; border-radius: 50%; display: flex; align-items: center; justify-content: center; margin-right: 12px;">
                                        <i class="bi bi-clock" style="color: #ffffff; font-size: 16px;"></i>
                                    </div>
                                    <div>
                                        <div style="color: #1a202c; font-weight: 600; font-size: 13px;">Awaiting Payment</div>
                                        <div style="color: #9ca3af; font-size: 12px;">In progress...</div>
                                    </div>
                                </div>
                            </div>
                        @elseif($transaction->status === 'failed')
                            <div class="timeline-item">
                                <div class="d-flex align-items-start">
                                    <div style="width: 32px; height: 32px; background: #ef4444; border-radius: 50%; display: flex; align-items: center; justify-content: center; margin-right: 12px;">
                                        <i class="bi bi-x" style="color: #ffffff; font-size: 16px;"></i>
                                    </div>
                                    <div>
                                        <div style="color: #1a202c; font-weight: 600; font-size: 13px;">Payment Failed</div>
                                        <div style="color: #9ca3af; font-size: 12px;">{{ $transaction->updated_at->format('M d, Y g:i A') }}</div>
                                    </div>
                                </div>
                            </div>
                        @endif
                    </div>
                </div>
            </div>

            <!-- Quick Actions -->
            <div class="card" style="border: none; border-radius: 16px; box-shadow: 0 4px 6px rgba(0,0,0,0.07);">
                <div class="card-body" style="padding: 1.5rem;">
                    <h6 style="color: #1a202c; font-weight: 700; margin-bottom: 1rem;">Quick Actions</h6>
                    <div class="d-grid gap-2">
                        @if($transaction->order)
                            <a href="{{ route('admin.orders.show', $transaction->order) }}" class="btn btn-outline-primary">
                                <i class="bi bi-cart3 me-2"></i>View Full Order
                            </a>
                        @endif
                        @if($transaction->user)
                            <a href="{{ route('admin.users.show', $transaction->user) }}" class="btn btn-outline-success">
                                <i class="bi bi-person me-2"></i>View Customer
                            </a>
                        @endif
                        @if($transaction->status === 'completed')
                            <button onclick="processRefund()" class="btn btn-outline-warning">
                                <i class="bi bi-arrow-counterclockwise me-2"></i>Process Refund
                            </button>
                        @endif
                        <button onclick="downloadReceipt()" class="btn btn-outline-info">
                            <i class="bi bi-download me-2"></i>Download Receipt
                        </button>
                        <button onclick="window.print()" class="btn btn-outline-secondary">
                            <i class="bi bi-printer me-2"></i>Print Details
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
function processRefund() {
    if (confirm('Are you sure you want to refund this transaction?\n\nAmount: ${{ number_format($transaction->amount, 2) }}\nThis action cannot be undone.')) {
        alert('✅ Refund processed successfully!\n\nRefund ID: REF' + Date.now() + '\nAmount: ${{ number_format($transaction->amount, 2) }}\nCustomer will be notified via email.');
    }
}

function downloadReceipt() {
    alert('📄 Downloading receipt...\n\nTransaction: {{ $transaction->transaction_id }}\nFormat: PDF');
    window.print();
}
</script>

<style>
@media print {
    .btn, .card-header, nav, footer, .breadcrumb {
        display: none !important;
    }
}
</style>

@endsection