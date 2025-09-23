<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Builder;

class Transaction extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'order_id',
        'transaction_id',
        'amount',
        'currency',
        'payment_method',
        'payment_mode',
        'status',
        'gateway_response',
    ];

    protected $casts = [
        'amount' => 'decimal:2',
        'gateway_response' => 'array',
    ];

    /**
     * Get the user that owns the transaction.
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get the order that owns the transaction.
     */
    public function order(): BelongsTo
    {
        return $this->belongsTo(Order::class);
    }

    /**
     * Scope a query to only include completed transactions.
     */
    public function scopeCompleted(Builder $query): void
    {
        $query->where('status', 'completed');
    }

    /**
     * Scope a query to only include pending transactions.
     */
    public function scopePending(Builder $query): void
    {
        $query->where('status', 'pending');
    }

    /**
     * Scope a query to only include failed transactions.
     */
    public function scopeFailed(Builder $query): void
    {
        $query->where('status', 'failed');
    }

    /**
     * Scope a query to only include refunded transactions.
     */
    public function scopeRefunded(Builder $query): void
    {
        $query->where('status', 'refunded');
    }

    /**
     * Scope a query by payment method.
     */
    public function scopeByPaymentMethod(Builder $query, $method): void
    {
        $query->where('payment_method', $method);
    }

    /**
     * Scope a query by payment mode.
     */
    public function scopeByPaymentMode(Builder $query, $mode): void
    {
        $query->where('payment_mode', $mode);
    }

    /**
     * Scope a query by date range.
     */
    public function scopeDateRange(Builder $query, $startDate, $endDate): void
    {
        $query->whereBetween('created_at', [$startDate, $endDate]);
    }

    /**
     * Scope a query by amount range.
     */
    public function scopeAmountRange(Builder $query, $minAmount, $maxAmount): void
    {
        $query->whereBetween('amount', [$minAmount, $maxAmount]);
    }

    /**
     * Check if the transaction is completed.
     */
    public function isCompleted(): bool
    {
        return $this->status === 'completed';
    }

    /**
     * Check if the transaction is pending.
     */
    public function isPending(): bool
    {
        return $this->status === 'pending';
    }

    /**
     * Check if the transaction failed.
     */
    public function isFailed(): bool
    {
        return $this->status === 'failed';
    }

    /**
     * Check if the transaction was refunded.
     */
    public function isRefunded(): bool
    {
        return $this->status === 'refunded';
    }

    /**
     * Get the status color for UI display.
     */
    public function getStatusColor(): string
    {
        return match($this->status) {
            'completed' => 'success',
            'pending' => 'warning',
            'failed' => 'danger',
            'refunded' => 'info',
            default => 'secondary'
        };
    }

    /**
     * Get the payment mode color for UI display.
     */
    public function getPaymentModeColor(): string
    {
        return match($this->payment_mode) {
            'online' => 'primary',
            'cash' => 'success',
            'wallet' => 'info',
            'bank_transfer' => 'secondary',
            default => 'dark'
        };
    }

    /**
     * Get formatted amount with currency.
     */
    public function getFormattedAmount(): string
    {
        return $this->currency . ' ' . number_format($this->amount, 2);
    }

    /**
     * Generate unique transaction ID.
     */
    public static function generateTransactionId(): string
    {
        do {
            $transactionId = 'TXN' . date('Ymd') . strtoupper(substr(uniqid(), -6));
        } while (self::where('transaction_id', $transactionId)->exists());

        return $transactionId;
    }

    /**
     * Get transaction statistics.
     */
    public static function getTransactionStatistics(): array
    {
        return [
            'total_transactions' => self::count(),
            'total_amount' => self::sum('amount'),
            'completed_transactions' => self::completed()->count(),
            'pending_transactions' => self::pending()->count(),
            'failed_transactions' => self::failed()->count(),
            'refunded_transactions' => self::refunded()->count(),
            'completed_amount' => self::completed()->sum('amount'),
            'pending_amount' => self::pending()->sum('amount'),
            'refunded_amount' => self::refunded()->sum('amount'),
            'average_transaction' => self::completed()->avg('amount') ?? 0,
            'success_rate' => self::count() > 0 ? round((self::completed()->count() / self::count()) * 100, 2) : 0,
        ];
    }

    /**
     * Get monthly transaction statistics.
     */
    public static function getMonthlyStatistics($year = null, $month = null): array
    {
        $year = $year ?? date('Y');
        $month = $month ?? date('m');
        
        $query = self::whereYear('created_at', $year)
                     ->whereMonth('created_at', $month);
        
        return [
            'total_transactions' => $query->count(),
            'total_amount' => $query->sum('amount'),
            'completed_transactions' => $query->completed()->count(),
            'completed_amount' => $query->completed()->sum('amount'),
            'average_transaction' => $query->completed()->avg('amount') ?? 0,
            'success_rate' => $query->count() > 0 ? round(($query->completed()->count() / $query->count()) * 100, 2) : 0,
        ];
    }

    /**
     * Get payment method breakdown.
     */
    public static function getPaymentMethodBreakdown(): array
    {
        return self::selectRaw('payment_method, COUNT(*) as count, SUM(amount) as total_amount')
                   ->groupBy('payment_method')
                   ->orderBy('total_amount', 'desc')
                   ->get()
                   ->toArray();
    }

    /**
     * Get daily transaction trends for the last 30 days.
     */
    public static function getDailyTrends($days = 30): array
    {
        $startDate = now()->subDays($days);
        
        return self::selectRaw('DATE(created_at) as date, COUNT(*) as count, SUM(amount) as amount')
                   ->where('created_at', '>=', $startDate)
                   ->groupBy('date')
                   ->orderBy('date', 'asc')
                   ->get()
                   ->toArray();
    }
}