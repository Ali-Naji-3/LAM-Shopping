<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Slider extends Model
{
    protected $fillable = [
        'title', 'subtitle', 'image', 'link', 'button_text', 
        'is_active', 'order', 'start_date', 'end_date'
    ];
    
    protected $casts = [
        'is_active' => 'boolean',
        'start_date' => 'date',
        'end_date' => 'date'
    ];
    
    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }
    
    public function scopeOrdered($query)
    {
        return $query->orderBy('order');
    }

    public function scopeCurrentlyActive($query)
    {
        return $query->where('is_active', true)
                    ->where(function($q) {
                        $q->whereNull('start_date')
                          ->orWhere('start_date', '<=', now()->toDateString());
                    })
                    ->where(function($q) {
                        $q->whereNull('end_date')
                          ->orWhere('end_date', '>=', now()->toDateString());
                    });
    }

    public function scopeScheduled($query)
    {
        return $query->where('start_date', '>', now()->toDateString());
    }

    public function scopeExpired($query)
    {
        return $query->where('end_date', '<', now()->toDateString());
    }

    // Helper Methods
    public function getStatusAttribute()
    {
        if (!$this->is_active) {
            return 'Inactive';
        }

        $now = now()->toDateString();
        
        if ($this->start_date && $this->start_date > $now) {
            return 'Scheduled';
        }
        
        if ($this->end_date && $this->end_date < $now) {
            return 'Expired';
        }
        
        return 'Active';
    }

    public function getStatusColorAttribute()
    {
        return match($this->status) {
            'Active' => '#10b981',
            'Scheduled' => '#3182ce',
            'Expired' => '#6b7280',
            'Inactive' => '#ef4444',
            default => '#6b7280'
        };
    }

    public function getDurationAttribute()
    {
        if (!$this->start_date || !$this->end_date) {
            return 'Permanent';
        }
        
        $start = \Carbon\Carbon::parse($this->start_date);
        $end = \Carbon\Carbon::parse($this->end_date);
        
        return $start->diffInDays($end) + 1 . ' days';
    }

    public function getImageUrlAttribute()
    {
        if ($this->image) {
            return asset('storage/' . $this->image);
        }
        return asset('images/placeholder-slider.jpg');
    }
}
