<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable, SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'email',
        'mobile',
        'password',
        'u_type',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
            'created_at' => 'datetime',
            'updated_at' => 'datetime',
            'deleted_at' => 'datetime',
        ];
    }

    // Model Events for Data Synchronization
    protected static function booted()
    {
        // When user is being deleted
        static::deleting(function ($user) {
            \Log::info("🗑️ Deleting user: {$user->name} ({$user->email})");
            
            // Check for active orders
            $activeOrdersCount = $user->orders()
                ->whereIn('status', ['pending', 'confirmed', 'processing', 'shipped'])
                ->count();
                
            if ($activeOrdersCount > 0) {
                throw new \Exception("Cannot delete user '{$user->name}': {$activeOrdersCount} active orders. Please complete or cancel orders first.");
            }
            
            // Transfer completed orders to a "Guest User" account
            $completedOrders = $user->orders()
                ->whereIn('status', ['delivered', 'cancelled'])
                ->count();
                
            if ($completedOrders > 0) {
                // Create or get guest user
                $guestUser = User::firstOrCreate(
                    ['email' => 'guest@collection.com'],
                    [
                        'name' => 'Guest User',
                        'mobile' => '+201000000000',
                        'u_type' => 'USR',
                        'password' => bcrypt('guest123'),
                        'email_verified_at' => now(),
                    ]
                );
                
                $user->orders()->whereIn('status', ['delivered', 'cancelled'])
                    ->update(['user_id' => $guestUser->id]);
                \Log::info("📦 Transferred {$completedOrders} completed orders to guest user");
            }
            
            // Archive user reviews (keep for product history)
            $reviewsCount = $user->reviews()->count();
            if ($reviewsCount > 0) {
                $user->reviews()->update([
                    'user_id' => null, // Anonymous reviews
                    'title' => \DB::raw("CONCAT('[Anonymous] ', title)")
                ]);
                \Log::info("⭐ Anonymized {$reviewsCount} reviews");
            }
            
            // Transfer transactions to guest user for financial records
            $transactionsCount = $user->transactions()->count();
            if ($transactionsCount > 0) {
                $guestUser = $guestUser ?? User::where('email', 'guest@collection.com')->first();
                $user->transactions()->update(['user_id' => $guestUser->id]);
                \Log::info("💳 Transferred {$transactionsCount} transactions to guest user");
            }
            
            // Archive contacts
            $contactsCount = $user->contacts()->count();
            if ($contactsCount > 0) {
                $user->contacts()->update([
                    'user_id' => null,
                    'subject' => \DB::raw("CONCAT('[User Deleted] ', subject)"),
                    'status' => 'resolved'
                ]);
                \Log::info("📞 Archived {$contactsCount} contacts");
            }
        });
        
        // When user is updated
        static::updated(function ($user) {
            if ($user->wasChanged('email')) {
                \Log::info("📧 User email changed: {$user->name}");
                
                // Update all related orders with new email
                $user->orders()->update(['customer_email' => $user->email]);
            }
            
            if ($user->wasChanged('name')) {
                \Log::info("👤 User name changed: {$user->email}");
                
                // Update all related orders with new name
                $user->orders()->update(['customer_name' => $user->name]);
            }
            
            if ($user->wasChanged('mobile')) {
                \Log::info("📱 User mobile changed: {$user->name}");
                
                // Update all related orders with new mobile
                $user->orders()->update(['customer_phone' => $user->mobile]);
            }
        });
        
        // When user is restored
        static::restored(function ($user) {
            \Log::info("♻️ User restored: {$user->name}");
            
            // Restore reviews if they were anonymized
            $user->reviews()->where('title', 'LIKE', '[Anonymous]%')
                ->update([
                    'title' => \DB::raw("REPLACE(title, '[Anonymous] ', '')")
                ]);
        });
    }

    // Relationships
    public function reviews(): HasMany
    {
        return $this->hasMany(Review::class);
    }

    public function orders(): HasMany
    {
        return $this->hasMany(Order::class);
    }

    public function transactions(): HasMany
    {
        return $this->hasMany(Transaction::class);
    }

    public function contacts(): HasMany
    {
        return $this->hasMany(Contact::class);
    }

    // Helper methods for user roles
    public function isAdmin()
    {
        return $this->u_type === 'ADM';
    }

    public function isManager()
    {
        return $this->u_type === 'MGR';
    }

    public function isUser()
    {
        return $this->u_type === 'USR';
    }

    // Helper methods for analytics
    public function getTotalOrdersAttribute()
    {
        return $this->orders()->count();
    }

    public function getTotalSpentAttribute()
    {
        return $this->orders()
            ->where('payment_status', 'paid')
            ->sum('total_amount') ?? 0;
    }

    public function getAverageOrderValueAttribute()
    {
        $totalOrders = $this->orders()->where('payment_status', 'paid')->count();
        return $totalOrders > 0 ? $this->total_spent / $totalOrders : 0;
    }

    // Scopes
    public function scopeCustomers($query)
    {
        return $query->where('u_type', 'USR');
    }

    public function scopeAdmins($query)
    {
        return $query->whereIn('u_type', ['ADM', 'MGR']);
    }

    public function scopeActive($query)
    {
        return $query->whereNull('deleted_at');
    }
}
