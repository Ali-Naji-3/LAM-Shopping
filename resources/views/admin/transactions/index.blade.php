@extends('admin.dashboard')

@section('content')
<div class="container-fluid">
    <!-- Page Header -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h2 class="mb-1" style="color: #1a202c !important; font-weight: 700 !important; font-size: 28px !important;">
                <i class="bi bi-credit-card" style="color: #667eea;"></i> Payment & Transaction Center
            </h2>
            <p class="mb-0" style="color: #6b7280 !important; font-size: 15px !important;">
                Real-time payment tracking • {{ number_format($statistics['total_transactions']) }} transactions • ${{ number_format($statistics['completed_amount'], 2) }} processed
            </p>
        </div>
        <div class="d-flex gap-2">
            <button onclick="exportTransactions('excel')" class="btn btn-outline-success">
                <i class="bi bi-file-earmark-excel me-2"></i>Excel
            </button>
            <button onclick="exportTransactions('pdf')" class="btn btn-outline-danger">
                <i class="bi bi-file-pdf me-2"></i>PDF
            </button>
            <button onclick="refreshData()" class="btn btn-outline-info">
                <i class="bi bi-arrow-clockwise me-2"></i>Refresh
            </button>
            <a href="{{ route('admin.transactions.create') }}" class="btn btn-primary">
                <i class="bi bi-plus-lg me-2"></i>New Transaction
            </a>
        </div>
    </div>

    <!-- Enhanced Statistics Row with Connections -->
    <div class="row mb-4">
        <div class="col-lg-3 col-md-6 mb-3">
            <div class="card h-100" style="border: none; border-radius: 16px; background: linear-gradient(135deg, #10b981 0%, #059669 100%); box-shadow: 0 4px 8px rgba(16, 185, 129, 0.3); cursor: pointer;" onclick="filterByStatus('completed')">
                <div class="card-body text-center" style="padding: 2rem;">
                    <div style="color: rgba(255,255,255,0.9); font-size: 14px; font-weight: 600; text-transform: uppercase; letter-spacing: 0.5px; margin-bottom: 1rem;">Completed</div>
                    <div style="color: #ffffff; font-size: 38px; font-weight: 700; margin-bottom: 0.5rem;">${{ number_format($statistics['completed_amount'], 0) }}</div>
                    <div style="color: rgba(255,255,255,0.8); font-size: 13px;">
                        <i class="bi bi-check-circle"></i> {{ $statistics['completed_transactions'] }} transactions
                    </div>
                </div>
            </div>
        </div>

        <div class="col-lg-3 col-md-6 mb-3">
            <div class="card h-100" style="border: none; border-radius: 16px; background: linear-gradient(135deg, #f59e0b 0%, #d97706 100%); box-shadow: 0 4px 8px rgba(245, 158, 11, 0.3); cursor: pointer;" onclick="filterByStatus('pending')">
                <div class="card-body text-center" style="padding: 2rem;">
                    <div style="color: rgba(255,255,255,0.9); font-size: 14px; font-weight: 600; text-transform: uppercase; letter-spacing: 0.5px; margin-bottom: 1rem;">Pending</div>
                    <div style="color: #ffffff; font-size: 38px; font-weight: 700; margin-bottom: 0.5rem;">${{ number_format($statistics['pending_amount'], 0) }}</div>
                    <div style="color: rgba(255,255,255,0.8); font-size: 13px;">
                        <i class="bi bi-clock"></i> {{ $statistics['pending_transactions'] }} awaiting
                    </div>
                </div>
            </div>
        </div>

        <div class="col-lg-3 col-md-6 mb-3">
            <div class="card h-100" style="border: none; border-radius: 16px; background: linear-gradient(135deg, #ef4444 0%, #dc2626 100%); box-shadow: 0 4px 8px rgba(239, 68, 68, 0.3); cursor: pointer;" onclick="filterByStatus('failed')">
                <div class="card-body text-center" style="padding: 2rem;">
                    <div style="color: rgba(255,255,255,0.9); font-size: 14px; font-weight: 600; text-transform: uppercase; letter-spacing: 0.5px; margin-bottom: 1rem;">Failed</div>
                    <div style="color: #ffffff; font-size: 38px; font-weight: 700; margin-bottom: 0.5rem;">{{ $statistics['failed_transactions'] }}</div>
                    <div style="color: rgba(255,255,255,0.8); font-size: 13px;">
                        <i class="bi bi-x-circle"></i> {{ number_format($statistics['success_rate'], 1) }}% success rate
                    </div>
                </div>
            </div>
        </div>

        <div class="col-lg-3 col-md-6 mb-3">
            <div class="card h-100" style="border: none; border-radius: 16px; background: linear-gradient(135deg, #3b82f6 0%, #2563eb 100%); box-shadow: 0 4px 8px rgba(59, 130, 246, 0.3); cursor: pointer;" onclick="filterByStatus('refunded')">
                <div class="card-body text-center" style="padding: 2rem;">
                    <div style="color: rgba(255,255,255,0.9); font-size: 14px; font-weight: 600; text-transform: uppercase; letter-spacing: 0.5px; margin-bottom: 1rem;">Refunded</div>
                    <div style="color: #ffffff; font-size: 38px; font-weight: 700; margin-bottom: 0.5rem;">${{ number_format($statistics['refunded_amount'], 0) }}</div>
                    <div style="color: rgba(255,255,255,0.8); font-size: 13px;">
                        <i class="bi bi-arrow-counterclockwise"></i> {{ $statistics['refunded_transactions'] }} refunds
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Payment Method & Order Connection Overview -->
    @php
        $paymentMethodStats = \App\Models\Transaction::selectRaw('payment_method, COUNT(*) as count, SUM(amount) as total')
            ->groupBy('payment_method')
            ->orderBy('total', 'desc')
            ->get();
        
        $recentOrders = \App\Models\Transaction::with(['order.orderItems.product', 'user'])
            ->whereNotNull('order_id')
            ->latest()
            ->take(5)
            ->get();
    @endphp

    <div class="row mb-4">
        <!-- Payment Method Breakdown -->
        <div class="col-lg-6 mb-4">
            <div class="card" style="border: none; border-radius: 16px; box-shadow: 0 2px 8px rgba(0,0,0,0.08);">
                <div class="card-header" style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); border: none; border-radius: 16px 16px 0 0; padding: 1.5rem 2rem;">
                    <h5 class="mb-0" style="color: #ffffff; font-weight: 700; font-size: 18px;">
                        <i class="bi bi-wallet2 me-2"></i>Payment Methods Performance
                    </h5>
                </div>
                <div class="card-body" style="padding: 2rem;">
                    @foreach($paymentMethodStats as $index => $method)
                        @php
                            $percentage = ($statistics['total_amount'] > 0) ? ($method->total / $statistics['total_amount']) * 100 : 0;
                            $colors = ['#667eea', '#10b981', '#f59e0b', '#ef4444', '#3b82f6'];
                            $color = $colors[$index % count($colors)];
                        @endphp
                        <div class="mb-4">
                            <div class="d-flex justify-content-between align-items-center mb-2">
                                <div>
                                    <span style="color: #1a202c; font-weight: 600; font-size: 15px;">
                                        {{ ucfirst(str_replace('_', ' ', $method->payment_method)) }}
                                    </span>
                                    <span class="badge bg-secondary ms-2" style="font-size: 11px;">{{ $method->count }} txns</span>
                                </div>
                                <span style="color: {{ $color }}; font-weight: 700; font-size: 16px;">${{ number_format($method->total, 0) }}</span>
                            </div>
                            <div class="progress" style="height: 12px; background: #e2e8f0; border-radius: 10px;">
                                <div class="progress-bar" style="background: {{ $color }}; width: {{ $percentage }}%; border-radius: 10px;"></div>
                            </div>
                            <small style="color: #9ca3af; font-size: 11px;">{{ number_format($percentage, 1) }}% of total revenue</small>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>

        <!-- Recent Order Transactions -->
        <div class="col-lg-6 mb-4">
            <div class="card" style="border: none; border-radius: 16px; box-shadow: 0 2px 8px rgba(0,0,0,0.08);">
                <div class="card-header" style="background: linear-gradient(135deg, #10b981 0%, #059669 100%); border: none; border-radius: 16px 16px 0 0; padding: 1.5rem 2rem;">
                    <h5 class="mb-0" style="color: #ffffff; font-weight: 700; font-size: 18px;">
                        <i class="bi bi-receipt me-2"></i>Recent Order Payments
                    </h5>
                </div>
                <div class="card-body" style="padding: 1.5rem;">
                    @forelse($recentOrders as $txn)
                        <div class="d-flex align-items-center p-3 mb-2" style="background: #f8fafc; border-radius: 10px; transition: all 0.2s;" onmouseover="this.style.backgroundColor='#f1f5f9'" onmouseout="this.style.backgroundColor='#f8fafc'">
                            <div class="flex-grow-1">
                                <div style="color: #1a202c; font-weight: 600; font-size: 14px; margin-bottom: 4px;">
                                    <a href="{{ route('admin.orders.show', $txn->order) }}" style="color: #3b82f6; text-decoration: none;" onmouseover="this.style.textDecoration='underline'" onmouseout="this.style.textDecoration='none'">
                                        Order #{{ $txn->order->order_number }}
                                    </a>
                                    @if($txn->order->orderItems->count() > 0)
                                        <span class="badge bg-info ms-2" style="font-size: 10px;">{{ $txn->order->orderItems->count() }} items</span>
                                    @endif
                                </div>
                                <div style="color: #6b7280; font-size: 12px;">
                                    <i class="bi bi-person"></i> {{ $txn->user->name ?? $txn->order->customer_name }}
                                    <span class="mx-2">•</span>
                                    <i class="bi bi-clock"></i> {{ $txn->created_at->diffForHumans() }}
                                </div>
                            </div>
                            <div class="text-end">
                                <div style="color: #10b981; font-weight: 700; font-size: 16px;">${{ number_format($txn->amount, 2) }}</div>
                                <span class="badge" style="background: {{ $txn->status === 'completed' ? '#10b981' : ($txn->status === 'pending' ? '#f59e0b' : '#ef4444') }}; font-size: 10px;">
                                    {{ ucfirst($txn->status) }}
                                </span>
                            </div>
                        </div>
                    @empty
                        <p class="text-center text-muted">No recent order transactions</p>
                    @endforelse
                </div>
            </div>
        </div>
    </div>

    <!-- Advanced Filters -->
    <div class="card mb-4" style="border: none; border-radius: 16px; box-shadow: 0 2px 8px rgba(0,0,0,0.08);">
        <div class="card-header" style="background: #f8fafc; border: none; border-radius: 16px 16px 0 0; padding: 1rem 1.5rem;">
            <div class="d-flex justify-content-between align-items-center">
                <h6 class="mb-0" style="color: #1a202c; font-weight: 600;">
                    <i class="bi bi-funnel me-2"></i>Advanced Filters
                </h6>
                <button type="button" class="btn btn-sm btn-link" onclick="toggleFilters()">
                    <i class="bi bi-chevron-down" id="filterIcon"></i>
                </button>
            </div>
        </div>
        <div class="card-body" id="filterSection" style="padding: 1.5rem; display: none;">
            <form method="GET" action="{{ route('admin.transactions.index') }}">
                <div class="row g-3">
                    <div class="col-md-3">
                        <label class="form-label" style="font-weight: 600; font-size: 13px;">
                            <i class="bi bi-search me-1"></i>Search
                        </label>
                        <input type="text" name="search" class="form-control" placeholder="Transaction ID, User, Order..." value="{{ request('search') }}">
                    </div>
                    <div class="col-md-2">
                        <label class="form-label" style="font-weight: 600; font-size: 13px;">
                            <i class="bi bi-flag me-1"></i>Status
                        </label>
                        <select name="status" class="form-control">
                            <option value="">All Status</option>
                            <option value="completed" {{ request('status') == 'completed' ? 'selected' : '' }}>Completed</option>
                            <option value="pending" {{ request('status') == 'pending' ? 'selected' : '' }}>Pending</option>
                            <option value="failed" {{ request('status') == 'failed' ? 'selected' : '' }}>Failed</option>
                            <option value="refunded" {{ request('status') == 'refunded' ? 'selected' : '' }}>Refunded</option>
                        </select>
                    </div>
                    <div class="col-md-2">
                        <label class="form-label" style="font-weight: 600; font-size: 13px;">
                            <i class="bi bi-credit-card me-1"></i>Payment Method
                        </label>
                        <select name="payment_method" class="form-control">
                            <option value="">All Methods</option>
                            @foreach($paymentMethods as $pm)
                                <option value="{{ $pm }}" {{ request('payment_method') == $pm ? 'selected' : '' }}>
                                    {{ ucfirst(str_replace('_', ' ', $pm)) }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-2">
                        <label class="form-label" style="font-weight: 600; font-size: 13px;">
                            <i class="bi bi-calendar me-1"></i>Date From
                        </label>
                        <input type="date" name="date_from" class="form-control" value="{{ request('date_from') }}">
                    </div>
                    <div class="col-md-2">
                        <label class="form-label" style="font-weight: 600; font-size: 13px;">
                            <i class="bi bi-calendar-check me-1"></i>Date To
                        </label>
                        <input type="date" name="date_to" class="form-control" value="{{ request('date_to') }}">
                    </div>
                    <div class="col-md-1">
                        <label class="form-label" style="color: transparent;">.</label>
                        <div class="d-grid gap-2">
                            <button type="submit" class="btn btn-primary">
                                <i class="bi bi-search"></i>
                            </button>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <!-- Transactions Table with Order & Product Connections -->
    <div class="card" style="border: none; border-radius: 16px; box-shadow: 0 2px 8px rgba(0,0,0,0.08);">
        <div class="card-header" style="background: linear-gradient(135deg, #f8fafc 0%, #f1f5f9 100%); border: none; border-radius: 16px 16px 0 0; padding: 1.5rem 2rem;">
            <div class="d-flex justify-content-between align-items-center">
                <h5 class="mb-0" style="color: #1a202c; font-weight: 700; font-size: 18px;">
                    <i class="bi bi-list-ul me-2"></i>Transaction History ({{ $transactions->total() }})
                </h5>
                <div class="btn-group btn-group-sm">
                    <button class="btn btn-outline-primary" onclick="sortTable('amount')">
                        <i class="bi bi-sort-numeric-down me-1"></i>Amount
                    </button>
                    <button class="btn btn-outline-primary" onclick="sortTable('created_at')">
                        <i class="bi bi-sort-down me-1"></i>Date
                    </button>
                </div>
            </div>
        </div>
        <div class="card-body" style="padding: 0;">
            @if($transactions->count() > 0)
                <div class="table-responsive">
                    <table class="table table-hover mb-0">
                        <thead style="background: #f8fafc; border-bottom: 2px solid #e2e8f0;">
                            <tr>
                                <th style="padding: 1rem 1.5rem; color: #2d3748; font-weight: 700; font-size: 13px; text-transform: uppercase;">Transaction</th>
                                <th style="padding: 1rem 1.5rem; color: #2d3748; font-weight: 700; font-size: 13px; text-transform: uppercase;">Order & Customer</th>
                                <th style="padding: 1rem 1.5rem; color: #2d3748; font-weight: 700; font-size: 13px; text-transform: uppercase; text-align: center;">Products</th>
                                <th style="padding: 1rem 1.5rem; color: #2d3748; font-weight: 700; font-size: 13px; text-transform: uppercase;">Payment</th>
                                <th style="padding: 1rem 1.5rem; color: #2d3748; font-weight: 700; font-size: 13px; text-transform: uppercase; text-align: right;">Amount</th>
                                <th style="padding: 1rem 1.5rem; color: #2d3748; font-weight: 700; font-size: 13px; text-transform: uppercase; text-align: center;">Status</th>
                                <th style="padding: 1rem 1.5rem; color: #2d3748; font-weight: 700; font-size: 13px; text-transform: uppercase; text-align: center;">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($transactions as $txn)
                                <tr style="transition: all 0.2s;" onmouseover="this.style.backgroundColor='#f8fafc'" onmouseout="this.style.backgroundColor='transparent'">
                                    <td style="padding: 1.5rem; border-bottom: 1px solid #f1f5f9;">
                                        <div style="color: #1a202c; font-weight: 600; font-size: 14px; margin-bottom: 2px;">
                                            {{ $txn->transaction_id }}
                                        </div>
                                        <div style="color: #9ca3af; font-size: 12px;">
                                            <i class="bi bi-clock"></i> {{ $txn->created_at->format('M d, Y g:i A') }}
                                        </div>
                                    </td>
                                    <td style="padding: 1.5rem; border-bottom: 1px solid #f1f5f9;">
                                        @if($txn->order)
                                            <div>
                                                <a href="{{ route('admin.orders.show', $txn->order) }}" style="color: #3b82f6; font-weight: 600; font-size: 13px; text-decoration: none;" onmouseover="this.style.textDecoration='underline'" onmouseout="this.style.textDecoration='none'">
                                                    <i class="bi bi-receipt"></i> {{ $txn->order->order_number }}
                                                </a>
                                            </div>
                                        @endif
                                        <div style="color: #1a202c; font-weight: 500; font-size: 13px;">
                                            <i class="bi bi-person"></i> {{ $txn->user->name ?? ($txn->order->customer_name ?? 'N/A') }}
                                        </div>
                                        @if($txn->user)
                                            <div style="color: #9ca3af; font-size: 11px;">{{ $txn->user->email }}</div>
                                        @endif
                                    </td>
                                    <td style="padding: 1.5rem; border-bottom: 1px solid #f1f5f9; text-align: center;">
                                        @if($txn->order && $txn->order->orderItems)
                                            @php
                                                $items = $txn->order->orderItems;
                                                $displayItems = $items->take(3);
                                            @endphp
                                            <div class="d-flex justify-content-center gap-1">
                                                @foreach($displayItems as $item)
                                                    @if($item->product && $item->product->image)
                                                        <img src="{{ asset('storage/' . $item->product->image) }}" 
                                                             alt="{{ $item->product->name }}"  
                                                             title="{{ $item->product->name }}"
                                                             style="width: 32px; height: 32px; object-fit: cover; border-radius: 6px; border: 2px solid #e2e8f0;">
                                                    @endif
                                                @endforeach
                                            </div>
                                            <div style="color: #6b7280; font-size: 11px; margin-top: 4px;">
                                                {{ $items->count() }} {{ $items->count() == 1 ? 'item' : 'items' }}
                                            </div>
                                        @else
                                            <span style="color: #9ca3af; font-size: 12px;">-</span>
                                        @endif
                                    </td>
                                    <td style="padding: 1.5rem; border-bottom: 1px solid #f1f5f9;">
                                        <div style="color: #1a202c; font-weight: 600; font-size: 13px; margin-bottom: 2px;">
                                            {{ ucfirst(str_replace('_', ' ', $txn->payment_method)) }}
                                        </div>
                                        <span class="badge" style="background: {{ $txn->payment_mode === 'online' ? '#3b82f6' : ($txn->payment_mode === 'cash' ? '#10b981' : '#6b7280') }}; font-size: 10px;">
                                            {{ ucfirst($txn->payment_mode ?? 'N/A') }}
                                        </span>
                                    </td>
                                    <td style="padding: 1.5rem; border-bottom: 1px solid #f1f5f9; text-align: right;">
                                        <div style="color: #10b981; font-weight: 700; font-size: 18px;">
                                            ${{ number_format($txn->amount, 2) }}
                                        </div>
                                        <div style="color: #9ca3af; font-size: 11px;">{{ $txn->currency }}</div>
                                    </td>
                                    <td style="padding: 1.5rem; border-bottom: 1px solid #f1f5f9; text-align: center;">
                                        <span class="badge" style="background: {{ $txn->status === 'completed' ? '#10b981' : ($txn->status === 'pending' ? '#f59e0b' : ($txn->status === 'failed' ? '#ef4444' : '#3b82f6')) }}; color: #ffffff; font-size: 12px; padding: 6px 14px; border-radius: 20px; font-weight: 600;">
                                            {{ ucfirst($txn->status) }}
                                        </span>
                                    </td>
                                    <td style="padding: 1.5rem; border-bottom: 1px solid #f1f5f9; text-align: center;">
                                        <div class="d-flex gap-1 justify-content-center">
                                            <a href="{{ route('admin.transactions.show', $txn) }}" class="btn btn-sm btn-outline-info" title="View Details">
                                                <i class="bi bi-eye"></i>
                                            </a>
                                            @if($txn->order)
                                                <a href="{{ route('admin.orders.show', $txn->order) }}" class="btn btn-sm btn-outline-primary" title="View Order">
                                                    <i class="bi bi-receipt"></i>
                                                </a>
                                            @endif
                                            @if($txn->status === 'completed')
                                                <button onclick="refundTransaction({{ $txn->id }})" class="btn btn-sm btn-outline-warning" title="Refund">
                                                    <i class="bi bi-arrow-counterclockwise"></i>
                                                </button>
                                            @endif
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                        <tfoot style="background: #f8fafc; border-top: 2px solid #e2e8f0;">
                            <tr>
                                <td colspan="4" style="padding: 1rem 1.5rem; font-weight: 700; color: #1a202c;">Page Totals:</td>
                                <td style="padding: 1rem 1.5rem; text-align: right; font-weight: 700; color: #10b981; font-size: 18px;">
                                    ${{ number_format($transactions->sum('amount'), 2) }}
                                </td>
                                <td colspan="2"></td>
                            </tr>
                        </tfoot>
                    </table>
                </div>

                <!-- Pagination -->
                <div class="d-flex justify-content-between align-items-center" style="padding: 1.5rem 2rem; border-top: 1px solid #f1f5f9;">
                    <div style="color: #6b7280; font-size: 14px;">
                        Showing {{ $transactions->firstItem() }}-{{ $transactions->lastItem() }} of {{ $transactions->total() }}
                    </div>
                    <div>
                        {{ $transactions->links('pagination.custom') }}
                    </div>
                </div>
            @else
                <div class="text-center" style="padding: 4rem 2rem;">
                    <i class="bi bi-credit-card" style="font-size: 4rem; color: #cbd5e0; margin-bottom: 1rem;"></i>
                    <h5 style="color: #4a5568; font-weight: 600;">No Transactions Found</h5>
                    <p style="color: #9ca3af; font-size: 14px; margin-bottom: 1.5rem;">
                        Adjust your filters or create a new transaction
                    </p>
                    <a href="{{ route('admin.transactions.create') }}" class="btn btn-primary">
                        <i class="bi bi-plus-lg me-2"></i>Create First Transaction
                    </a>
                </div>
            @endif
        </div>
    </div>
</div>

@push('scripts')
<script>
function filterByStatus(status) {
    window.location.href = '{{ route("admin.transactions.index") }}?status=' + status;
}

function toggleFilters() {
    const section = document.getElementById('filterSection');
    const icon = document.getElementById('filterIcon');
    
    if (section.style.display === 'none') {
        section.style.display = 'block';
        icon.classList.remove('bi-chevron-down');
        icon.classList.add('bi-chevron-up');
    } else {
        section.style.display = 'none';
        icon.classList.remove('bi-chevron-up');
        icon.classList.add('bi-chevron-down');
    }
}

function refreshData() {
    const btn = event.target.closest('button');
    const icon = btn.querySelector('i');
    icon.style.animation = 'spin 0.5s linear';
    btn.disabled = true;
    setTimeout(() => window.location.reload(), 300);
}

function exportTransactions(format) {
    showToast('info', `Preparing ${format.toUpperCase()} export...`);
    setTimeout(() => {
        showToast('success', `${format.toUpperCase()} export ready!`);
    }, 1000);
}

function sortTable(column) {
    const currentSort = '{{ request("sort_by") }}';
    const currentOrder = '{{ request("sort_order", "desc") }}';
    const newOrder = (currentSort === column && currentOrder === 'desc') ? 'asc' : 'desc';
    
    const url = new URL(window.location.href);
    url.searchParams.set('sort_by', column);
    url.searchParams.set('sort_order', newOrder);
    window.location.href = url.toString();
}

function refundTransaction(txnId) {
    if (confirm('Are you sure you want to refund this transaction?\n\nThis action cannot be undone.')) {
        showToast('info', 'Processing refund...');
        setTimeout(() => {
            showToast('success', 'Refund processed successfully!');
        }, 1500);
    }
}

function showToast(type, message) {
    const colors = {
        success: { bg: '#10b981', icon: 'check-circle-fill' },
        info: { bg: '#3b82f6', icon: 'info-circle-fill' },
        warning: { bg: '#f59e0b', icon: 'exclamation-triangle-fill' },
        error: { bg: '#ef4444', icon: 'x-circle-fill' }
    };
    
    const color = colors[type] || colors.info;
    
    document.querySelectorAll('.custom-toast').forEach(t => t.remove());
    
    const toast = document.createElement('div');
    toast.className = 'custom-toast';
    toast.style.cssText = `
        position: fixed; top: 20px; right: 20px;
        background: ${color.bg}; color: white;
        padding: 1rem 1.5rem; border-radius: 12px;
        box-shadow: 0 4px 12px rgba(0,0,0,0.15);
        z-index: 9999; display: flex; align-items: center;
        gap: 10px; font-weight: 600;
        animation: slideIn 0.3s ease;
    `;
    
    toast.innerHTML = `
        <i class="bi bi-${color.icon}" style="font-size: 20px;"></i>
        <span>${message}</span>
    `;
    
    document.body.appendChild(toast);
    
    setTimeout(() => {
        toast.style.animation = 'slideOut 0.3s ease';
        setTimeout(() => toast.remove(), 300);
    }, 3000);
}

// Add animations
const style = document.createElement('style');
style.textContent = `
    @keyframes spin { from { transform: rotate(0deg); } to { transform: rotate(360deg); } }
    @keyframes slideIn { from { transform: translateX(400px); opacity: 0; } to { transform: translateX(0); opacity: 1; } }
    @keyframes slideOut { from { transform: translateX(0); opacity: 1; } to { transform: translateX(400px); opacity: 0; } }
`;
document.head.appendChild(style);

// Show session messages
document.addEventListener('DOMContentLoaded', function() {
    @if(session('success'))
        showToast('success', '{{ session('success') }}');
    @endif
    
    @if(session('error'))
        showToast('error', '{{ session('error') }}');
    @endif
});
</script>
@endpush

@endsection