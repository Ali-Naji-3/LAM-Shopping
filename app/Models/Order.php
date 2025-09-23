<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Order extends Model
{
    protected $fillable = [
        'user_id',
        'order_number',
        'subtotal',
        'tax_amount',
        'shipping_amount',
        'discount_amount',
        'total_amount',
        'customer_name',
        'customer_phone',
        'customer_email',
        'shipping_address',
        'billing_address',
        'locality',
        'status',
        'payment_status',
        'payment_method',
        'notes',
    ];

    protected $casts = [
        'subtotal' => 'decimal:2',
        'tax_amount' => 'decimal:2',
        'shipping_amount' => 'decimal:2',
        'discount_amount' => 'decimal:2',
        'total_amount' => 'decimal:2',
    ];

    // Relationships
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function orderItems(): HasMany
    {
        return $this->hasMany(OrderItem::class);
    }

    public function transactions(): HasMany
    {
        return $this->hasMany(Transaction::class);
    }

    // Scopes
    public function scopeByStatus($query, $status)
    {
        return $query->where('status', $status);
    }

    public function scopeByPaymentStatus($query, $paymentStatus)
    {
        return $query->where('payment_status', $paymentStatus);
    }

    public function scopePending($query)
    {
        return $query->where('status', 'pending');
    }

    public function scopeCompleted($query)
    {
        return $query->where('status', 'delivered');
    }

    public function scopePaid($query)
    {
        return $query->where('payment_status', 'paid');
    }

    // Helper Methods
    public function getStatusColorAttribute()
    {
        return match($this->status) {
            'pending' => '#f59e0b',
            'confirmed' => '#3182ce',
            'processing' => '#8b5cf6',
            'shipped' => '#06b6d4',
            'delivered' => '#10b981',
            'cancelled' => '#ef4444',
            'refunded' => '#6b7280',
            default => '#6b7280'
        };
    }

    public function getPaymentStatusColorAttribute()
    {
        return match($this->payment_status) {
            'paid' => '#10b981',
            'pending' => '#f59e0b',
            'failed' => '#ef4444',
            'refunded' => '#6b7280',
            default => '#6b7280'
        };
    }

    public function getFormattedTotalAttribute()
    {
        return '$' . number_format($this->total_amount, 2);
    }

    public function getItemsCountAttribute()
    {
        return $this->orderItems()->count();
    }

    public function getTotalQuantityAttribute()
    {
        return $this->orderItems()->sum('quantity');
    }

    public function generateOrderNumber()
    {
        do {
            $orderNumber = 'ORD-' . now()->format('Ymd') . '-' . strtoupper(substr(md5(uniqid()), 0, 6));
        } while (self::where('order_number', $orderNumber)->exists());

        return $orderNumber;
    }
}
