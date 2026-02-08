<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Spatie\Permission\Traits\HasRoles;
use Illuminate\Database\Eloquent\SoftDeletes;

class User extends Authenticatable
{
    use HasFactory, Notifiable, HasRoles, SoftDeletes;

    protected $fillable = [
        'name',
        'phone',
        'email',
        'password',
        'status',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    // Relationships
    public function devices()
    {
        return $this->hasMany(UserDevice::class);
    }

    public function kyc()
    {
        return $this->hasOne(Kyc::class);
    }

    public function wallets()
    {
        return $this->hasMany(Wallet::class);
    }

    public function merchant()
    {
        return $this->hasOne(Merchant::class);
    }

    public function rider()
    {
        return $this->hasOne(Rider::class);
    }

    public function affiliate()
    {
        return $this->hasOne(Affiliate::class);
    }

    public function orders()
    {
        return $this->hasMany(Order::class);
    }

    public function referrals()
    {
        return $this->hasMany(Referral::class, 'referrer_id');
    }

    public function referredBy()
    {
        return $this->hasMany(Referral::class, 'referred_id');
    }

    public function commissions()
    {
        return $this->hasMany(Commission::class);
    }

    public function designations()
    {
        return $this->hasMany(UserDesignation::class);
    }

    public function currentDesignation()
    {
        return $this->hasOne(UserDesignation::class)->where('is_current', true)->latest();
    }

    public function notifications()
    {
        return $this->hasMany(Notification::class);
    }

    public function sharePurchases()
    {
        return $this->hasMany(SharePurchase::class);
    }

    // Scopes
    public function scopeByStatus($query, $status)
    {
        return $query->where('status', $status);
    }

    public function scopeVerified($query)
    {
        return $query->where('status', 'wallet_verified');
    }

    public function scopeVendors($query)
    {
        return $query->where('status', 'vendor');
    }

    public function scopeRiders($query)
    {
        return $query->where('status', 'rider');
    }

    // Accessors
    public function getIsWalletVerifiedAttribute()
    {
        return in_array($this->status, ['wallet_verified', 'vendor', 'rider']);
    }

    public function getIsVendorAttribute()
    {
        return $this->status === 'vendor';
    }

    public function getIsRiderAttribute()
    {
        return $this->status === 'rider';
    }

    // Helper Methods
    public function getWallet($type = 'main')
    {
        return $this->wallets()->where('wallet_type', $type)->first();
    }

    public function hasWallet($type)
    {
        return $this->wallets()->where('wallet_type', $type)->exists();
    }
}
