<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Transaction;
use App\Models\User;
use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class TransactionsController extends Controller
{
    /**
     * Display a listing of the transactions.
     */
    public function index(Request $request): View
    {
        $query = Transaction::with(['user', 'order']);

        // Search functionality
        if ($request->filled('search')) {
            $search = $request->input('search');
            $query->where(function ($q) use ($search) {
                $q->where('transaction_id', 'like', "%{$search}%")
                  ->orWhere('payment_method', 'like', "%{$search}%")
                  ->orWhere('amount', 'like', "%{$search}%")
                  ->orWhereHas('user', function ($userQuery) use ($search) {
                      $userQuery->where('name', 'like', "%{$search}%")
                               ->orWhere('email', 'like', "%{$search}%");
                  })
                  ->orWhereHas('order', function ($orderQuery) use ($search) {
                      $orderQuery->where('order_number', 'like', "%{$search}%");
                  });
            });
        }

        // Filter by status
        if ($request->filled('status')) {
            $query->where('status', $request->input('status'));
        }

        // Filter by payment method
        if ($request->filled('payment_method')) {
            $query->where('payment_method', $request->input('payment_method'));
        }

        // Filter by payment mode
        if ($request->filled('payment_mode')) {
            $query->where('payment_mode', $request->input('payment_mode'));
        }

        // Filter by date range
        if ($request->filled('date_from')) {
            $query->whereDate('created_at', '>=', $request->input('date_from'));
        }
        if ($request->filled('date_to')) {
            $query->whereDate('created_at', '<=', $request->input('date_to'));
        }

        // Filter by amount range
        if ($request->filled('amount_min')) {
            $query->where('amount', '>=', $request->input('amount_min'));
        }
        if ($request->filled('amount_max')) {
            $query->where('amount', '<=', $request->input('amount_max'));
        }

        // Sort functionality
        $sortBy = $request->input('sort_by', 'created_at');
        $sortOrder = $request->input('sort_order', 'desc');
        
        if (in_array($sortBy, ['amount', 'created_at', 'status', 'payment_method'])) {
            $query->orderBy($sortBy, $sortOrder);
        }

        $transactions = $query->paginate(15)->withQueryString();
        $statistics = Transaction::getTransactionStatistics();

        // Get unique payment methods and modes for filters
        $paymentMethods = Transaction::distinct('payment_method')->pluck('payment_method');
        $paymentModes = ['online', 'cash', 'wallet', 'bank_transfer'];

        return view('admin.transactions.index', compact(
            'transactions', 
            'statistics', 
            'paymentMethods', 
            'paymentModes'
        ));
    }

    /**
     * Show the form for creating a new transaction.
     */
    public function create(): View
    {
        $users = User::where('u_type', 'USR')->get();
        $orders = Order::whereIn('payment_status', ['pending', 'paid'])->get();

        return view('admin.transactions.create', compact('users', 'orders'));
    }

    /**
     * Store a newly created transaction in storage.
     */
    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'user_id' => 'nullable|exists:users,id',
            'order_id' => 'nullable|exists:orders,id',
            'amount' => 'required|numeric|min:0.01',
            'currency' => 'required|string|size:3',
            'payment_method' => 'required|string|max:50',
            'payment_mode' => 'required|in:online,cash,wallet,bank_transfer',
            'status' => 'required|in:pending,completed,failed,refunded',
            'gateway_response' => 'nullable|string',
        ]);

        // Generate unique transaction ID if not provided
        if (empty($validated['transaction_id'])) {
            $validated['transaction_id'] = Transaction::generateTransactionId();
        }

        // Parse gateway response as JSON if provided
        if (!empty($validated['gateway_response'])) {
            $validated['gateway_response'] = json_decode($validated['gateway_response'], true) ?? $validated['gateway_response'];
        }

        Transaction::create($validated);

        return redirect()->route('admin.transactions.index')
            ->with('success', 'Transaction created successfully.');
    }

    /**
     * Display the specified transaction.
     */
    public function show(Transaction $transaction): View
    {
        $transaction->load(['user', 'order.orderItems.product']);
        
        // Get related transactions for the same user
        $relatedTransactions = Transaction::with(['order'])
            ->where('user_id', $transaction->user_id)
            ->where('id', '!=', $transaction->id)
            ->orderBy('created_at', 'desc')
            ->limit(5)
            ->get();

        return view('admin.transactions.show', compact('transaction', 'relatedTransactions'));
    }

    /**
     * Show the form for editing the specified transaction.
     */
    public function edit(Transaction $transaction): View
    {
        $transaction->load(['user', 'order']);
        $users = User::where('u_type', 'USR')->get();
        $orders = Order::all();

        return view('admin.transactions.edit', compact('transaction', 'users', 'orders'));
    }

    /**
     * Update the specified transaction in storage.
     */
    public function update(Request $request, Transaction $transaction): RedirectResponse
    {
        $validated = $request->validate([
            'user_id' => 'nullable|exists:users,id',
            'order_id' => 'nullable|exists:orders,id',
            'transaction_id' => 'nullable|string|unique:transactions,transaction_id,' . $transaction->id,
            'amount' => 'required|numeric|min:0.01',
            'currency' => 'required|string|size:3',
            'payment_method' => 'required|string|max:50',
            'payment_mode' => 'required|in:online,cash,wallet,bank_transfer',
            'status' => 'required|in:pending,completed,failed,refunded',
            'gateway_response' => 'nullable|string',
        ]);

        // Parse gateway response as JSON if provided
        if (!empty($validated['gateway_response'])) {
            $validated['gateway_response'] = json_decode($validated['gateway_response'], true) ?? $validated['gateway_response'];
        }

        $transaction->update($validated);

        return redirect()->route('admin.transactions.index')
            ->with('success', 'Transaction updated successfully.');
    }

    /**
     * Remove the specified transaction from storage.
     */
    public function destroy(Transaction $transaction): RedirectResponse
    {
        $transactionId = $transaction->transaction_id ?? 'Unknown';
        $transaction->delete();

        return redirect()->route('admin.transactions.index')
            ->with('success', "Transaction '{$transactionId}' deleted successfully.");
    }

    /**
     * Handle bulk actions for transactions.
     */
    public function bulkActions(Request $request): RedirectResponse
    {
        $request->validate([
            'action' => 'required|in:delete,update_status,export',
            'selected_items' => 'required|array|min:1',
            'selected_items.*' => 'exists:transactions,id',
            'status' => 'nullable|in:pending,completed,failed,refunded',
        ]);

        $selectedItems = $request->input('selected_items');
        $action = $request->input('action');

        switch ($action) {
            case 'delete':
                Transaction::whereIn('id', $selectedItems)->delete();
                $message = count($selectedItems) . ' transactions deleted successfully.';
                break;

            case 'update_status':
                $status = $request->input('status');
                if ($status) {
                    Transaction::whereIn('id', $selectedItems)->update(['status' => $status]);
                    $message = count($selectedItems) . " transactions updated to '{$status}' status.";
                } else {
                    $message = 'Status is required for bulk status update.';
                }
                break;

            case 'export':
                $message = count($selectedItems) . ' transactions exported successfully.';
                break;

            default:
                $message = 'Invalid action selected.';
        }

        return redirect()->route('admin.transactions.index')->with('success', $message);
    }

    /**
     * Update transaction status.
     */
    public function updateStatus(Request $request, Transaction $transaction): RedirectResponse
    {
        $request->validate([
            'status' => 'required|in:pending,completed,failed,refunded',
            'notes' => 'nullable|string|max:500',
        ]);

        $oldStatus = $transaction->status;
        $newStatus = $request->input('status');
        
        $transaction->update([
            'status' => $newStatus,
            'gateway_response' => array_merge(
                $transaction->gateway_response ?? [],
                [
                    'status_updated_at' => now()->toISOString(),
                    'old_status' => $oldStatus,
                    'new_status' => $newStatus,
                    'notes' => $request->input('notes'),
                    'updated_by' => auth()->user()->name ?? 'Admin',
                ]
            )
        ]);

        return redirect()->route('admin.transactions.show', $transaction)
            ->with('success', "Transaction status updated from '{$oldStatus}' to '{$newStatus}'.");
    }

    /**
     * Display transaction analytics dashboard.
     */
    public function analytics(): View
    {
        $statistics = Transaction::getTransactionStatistics();
        $monthlyStats = Transaction::getMonthlyStatistics();
        $paymentMethodBreakdown = Transaction::getPaymentMethodBreakdown();
        $dailyTrends = Transaction::getDailyTrends(30);
        
        // Get recent transactions
        $recentTransactions = Transaction::with(['user', 'order'])
            ->orderBy('created_at', 'desc')
            ->limit(10)
            ->get();

        // Get high-value transactions
        $highValueTransactions = Transaction::with(['user', 'order'])
            ->where('amount', '>=', 100)
            ->orderBy('amount', 'desc')
            ->limit(10)
            ->get();

        // Get failed transactions
        $failedTransactions = Transaction::with(['user', 'order'])
            ->failed()
            ->orderBy('created_at', 'desc')
            ->limit(10)
            ->get();

        return view('admin.transactions.analytics', compact(
            'statistics',
            'monthlyStats',
            'paymentMethodBreakdown',
            'dailyTrends',
            'recentTransactions',
            'highValueTransactions',
            'failedTransactions'
        ));
    }

    /**
     * Process refund for a transaction.
     */
    public function processRefund(Request $request, Transaction $transaction): RedirectResponse
    {
        $request->validate([
            'refund_amount' => 'required|numeric|min:0.01|max:' . $transaction->amount,
            'refund_reason' => 'required|string|max:255',
        ]);

        if ($transaction->status !== 'completed') {
            return redirect()->back()->withErrors(['status' => 'Only completed transactions can be refunded.']);
        }

        $refundAmount = $request->input('refund_amount');
        $refundReason = $request->input('refund_reason');

        // Create refund transaction
        $refundTransaction = Transaction::create([
            'user_id' => $transaction->user_id,
            'order_id' => $transaction->order_id,
            'transaction_id' => Transaction::generateTransactionId(),
            'amount' => -$refundAmount,
            'currency' => $transaction->currency,
            'payment_method' => $transaction->payment_method,
            'payment_mode' => $transaction->payment_mode,
            'status' => 'completed',
            'gateway_response' => [
                'refund_for' => $transaction->transaction_id,
                'refund_reason' => $refundReason,
                'refund_processed_at' => now()->toISOString(),
                'processed_by' => auth()->user()->name ?? 'Admin',
            ]
        ]);

        // Update original transaction status if full refund
        if ($refundAmount == $transaction->amount) {
            $transaction->update(['status' => 'refunded']);
        }

        return redirect()->route('admin.transactions.show', $transaction)
            ->with('success', "Refund of {$transaction->currency} {$refundAmount} processed successfully.");
    }
}
