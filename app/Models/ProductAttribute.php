<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ProductAttribute extends Model
{
    protected $fillable = [
        'product_id',
        'attribute_value_id',
        'additional_price',
    ];

    protected $casts = [
        'additional_price' => 'decimal:2',
    ];

    // Relationships
    public function product(): BelongsTo
    {
        return $this->belongsTo(Product::class);
    }

    public function attributeValue(): BelongsTo
    {
        return $this->belongsTo(AttributeValue::class);
    }

    // Scopes
    public function scopeForProduct($query, $productId)
    {
        return $query->where('product_id', $productId);
    }

    public function scopeForAttribute($query, $attributeId)
    {
        return $query->whereHas('attributeValue', function($q) use ($attributeId) {
            $q->where('attribute_id', $attributeId);
        });
    }

    public function scopeWithAdditionalPrice($query)
    {
        return $query->where('additional_price', '>', 0);
    }

    // Helper Methods
    public function getFormattedAdditionalPriceAttribute()
    {
        return $this->additional_price > 0 ? '+$' . number_format($this->additional_price, 2) : 'Free';
    }

    public function getAttributeNameAttribute()
    {
        return $this->attributeValue->attribute->name ?? 'Unknown';
    }

    public function getValueNameAttribute()
    {
        return $this->attributeValue->value ?? 'Unknown';
    }
}
