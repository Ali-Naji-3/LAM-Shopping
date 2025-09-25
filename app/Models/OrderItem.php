<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class OrderItem extends Model
{
    protected $fillable = [
        'order_id',
        'product_id',
        'quantity',
        'unit_price',
        'total_price',
        'attributes',
    ];

    protected $casts = [
        'quantity' => 'integer',
        'unit_price' => 'decimal:2',
        'total_price' => 'decimal:2',
        'attributes' => 'array',
    ];

    // Relationships
    public function order(): BelongsTo
    {
        return $this->belongsTo(Order::class);
    }

    public function product(): BelongsTo
    {
        return $this->belongsTo(Product::class);
    }

    // Scopes
    public function scopeForOrder($query, $orderId)
    {
        return $query->where('order_id', $orderId);
    }

    public function scopeForProduct($query, $productId)
    {
        return $query->where('product_id', $productId);
    }

    public function scopeByQuantity($query, $operator, $quantity)
    {
        return $query->where('quantity', $operator, $quantity);
    }

    public function scopeByUnitPrice($query, $operator, $price)
    {
        return $query->where('unit_price', $operator, $price);
    }

    public function scopeByTotalPrice($query, $operator, $price)
    {
        return $query->where('total_price', $operator, $price);
    }

    // Helper Methods
    public function getFormattedUnitPriceAttribute()
    {
        return '$' . number_format($this->unit_price, 2);
    }

    public function getFormattedTotalPriceAttribute()
    {
        return '$' . number_format($this->total_price, 2);
    }

    public function getAttributesDisplayAttribute()
    {
        if (!$this->attributes || empty($this->attributes)) {
            return 'No attributes';
        }

        $display = [];
        foreach ($this->attributes as $key => $value) {
            if (is_array($value)) {
                $display[] = ucfirst($key) . ': ' . implode(', ', $value);
            } else {
                $display[] = ucfirst($key) . ': ' . $value;
            }
        }

        return implode(' | ', $display);
    }

    public function getItemSubtotalAttribute()
    {
        return $this->quantity * $this->unit_price;
    }

    public function getDiscountAmountAttribute()
    {
        $subtotal = $this->item_subtotal;
        return $subtotal - $this->total_price;
    }

    public function getHasDiscountAttribute()
    {
        return $this->discount_amount > 0;
    }

    public function getDiscountPercentageAttribute()
    {
        if (!$this->has_discount) {
            return 0;
        }

        $subtotal = $this->item_subtotal;
        return round(($this->discount_amount / $subtotal) * 100, 2);
    }

    // Static Methods
    public static function calculateTotalPrice($quantity, $unitPrice, $discount = 0)
    {
        $subtotal = $quantity * $unitPrice;
        return $subtotal - $discount;
    }

    public static function getOrderItemsStatistics($orderId = null)
    {
        $query = self::query();
        
        if ($orderId) {
            $query->where('order_id', $orderId);
        }

        return [
            'total_items' => $query->count(),
            'total_quantity' => $query->sum('quantity'),
            'total_value' => $query->sum('total_price'),
            'average_unit_price' => $query->avg('unit_price'),
            'average_quantity' => $query->avg('quantity'),
            'most_ordered_product' => $query->select('product_id')
                ->selectRaw('COUNT(*) as order_count')
                ->groupBy('product_id')
                ->orderBy('order_count', 'desc')
                ->with('product')
                ->first(),
        ];
    }
}