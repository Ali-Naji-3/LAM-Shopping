<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Attribute extends Model
{
    protected $fillable = [
        'name',
        'slug', 
        'type',
        'is_required'
    ];

    protected $casts = [
        'is_required' => 'boolean',
    ];

    // Relationships
    public function attributeValues(): HasMany
    {
        return $this->hasMany(AttributeValue::class);
    }

    public function contacts(): HasMany
    {
        return $this->hasMany(Contact::class);
    }

    // Scopes
    public function scopeRequired($query)
    {
        return $query->where('is_required', true);
    }

    public function scopeOptional($query)
    {
        return $query->where('is_required', false);
    }

    public function scopeByType($query, $type)
    {
        return $query->where('type', $type);
    }

    // Helper methods for analytics
    public function getTotalValuesAttribute()
    {
        return $this->attributeValues()->count();
    }

    public function getTotalProductsAttribute()
    {
        try {
            return Product::whereHas('attributeValues', function($query) {
                $query->where('attribute_id', $this->id);
            })->count();
        } catch (\Illuminate\Database\QueryException $e) {
            return 0;
        }
    }

    public function getPendingContactsAttribute()
    {
        try {
            return $this->contacts()->where('status', 'pending')->count();
        } catch (\Illuminate\Database\QueryException $e) {
            return 0;
        }
    }
}
