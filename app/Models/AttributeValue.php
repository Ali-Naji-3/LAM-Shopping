<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class AttributeValue extends Model
{
    protected $fillable = [
        'attribute_id',
        'value',
    ];

    // Relationships
    public function attribute(): BelongsTo
    {
        return $this->belongsTo(Attribute::class);
    }

    public function products(): BelongsToMany
    {
        return $this->belongsToMany(Product::class, 'product_attributes')
            ->withPivot('additional_price')
            ->withTimestamps();
    }

    // Scopes
    public function scopeForAttribute($query, $attributeId)
    {
        return $query->where('attribute_id', $attributeId);
    }

    public function scopeByValue($query, $value)
    {
        return $query->where('value', 'like', "%{$value}%");
    }

    // Helper Methods
    public function getProductsCountAttribute()
    {
        return $this->products()->count();
    }

    public function getFormattedValueAttribute()
    {
        return ucfirst(strtolower($this->value));
    }
}
