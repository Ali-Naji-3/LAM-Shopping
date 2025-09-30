<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Review extends Model
{
    protected $fillable = [
        'user_id',
        'product_id',
        'rating',
        'title',
        'comment',
        'is_approved',
        'attributes',
        'pros',
        'cons',
        'would_recommend',
        'purchase_verified',
    ];

    protected $casts = [
        'is_approved' => 'boolean',
        'rating' => 'integer',
        'attributes' => 'array',
        'would_recommend' => 'boolean',
    ];

    // Relationships
    public function product(): BelongsTo
    {
        return $this->belongsTo(Product::class);
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function contacts(): HasMany
    {
        return $this->hasMany(Contact::class);
    }

    // Scopes
    public function scopeApproved($query)
    {
        return $query->where('is_approved', true);
    }

    public function scopeByRating($query, $rating)
    {
        return $query->where('rating', $rating);
    }

    public function scopePending($query)
    {
        return $query->where('is_approved', false);
    }

    // Helper Methods
    public function getStarRatingAttribute()
    {
        return str_repeat('★', $this->rating) . str_repeat('☆', 5 - $this->rating);
    }

    public function getRatingColorAttribute()
    {
        return match($this->rating) {
            5 => '#10b981', // Green
            4 => '#84cc16', // Light Green
            3 => '#f59e0b', // Yellow
            2 => '#f97316', // Orange
            1 => '#ef4444', // Red
            default => '#6b7280' // Gray
        };
    }

    public function getStatusBadgeAttribute()
    {
        return $this->is_approved ? 'Approved' : 'Pending';
    }

    public function getStatusColorAttribute()
    {
        return $this->is_approved ? '#10b981' : '#f59e0b';
    }

    // New attribute helper methods
    public function getRecommendationTextAttribute()
    {
        return $this->would_recommend ? 'Yes, I recommend this product' : 'No, I do not recommend this product';
    }

    public function getRecommendationColorAttribute()
    {
        return $this->would_recommend ? '#10b981' : '#ef4444';
    }

    public function getPurchaseVerificationTextAttribute()
    {
        return $this->purchase_verified ? 'Verified Purchase' : 'Unverified Purchase';
    }

    public function getPurchaseVerificationColorAttribute()
    {
        return $this->purchase_verified ? '#10b981' : '#f59e0b';
    }

    public function getAttributesFormattedAttribute()
    {
        if (!$this->attributes) {
            return [];
        }
        
        $formatted = [];
        foreach ($this->attributes as $key => $value) {
            $formatted[] = [
                'name' => ucwords(str_replace('_', ' ', $key)),
                'value' => $value
            ];
        }
        
        return $formatted;
    }
}
