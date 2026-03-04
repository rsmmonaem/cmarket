<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Spatie\Permission\Traits\HasRoles;
use Illuminate\Database\Eloquent\SoftDeletes;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable, HasRoles, SoftDeletes;

    protected $fillable = [
        'name',
        'phone',
        'email',
        'password',
        'status',
        'otp',
        'otp_expires_at',
        'login_attempts',
        'locked_until',
        'ip_address',
        'device_info',
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
            'otp_expires_at' => 'datetime',
            'locked_until' => 'datetime',
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

    // Security Helpers
    public function generateOtp()
    {
        $this->otp = rand(100000, 999999);
        $this->otp_expires_at = now()->addMinutes(5);
        $this->save();
        return $this->otp;
    }

    public function verifyOtp($otp)
    {
        if ($this->otp === $otp && $this->otp_expires_at->isFuture()) {
            $this->otp = null;
            $this->otp_expires_at = null;
            $this->login_attempts = 0;
            $this->save();
            return true;
        }
        return false;
    }

    public function incrementLoginAttempts()
    {
        $this->login_attempts++;
        if ($this->login_attempts >= 5) {
            $this->locked_until = now()->addMinutes(30);
        }
        $this->save();
    }

    public function isLocked()
    {
        return $this->locked_until && $this->locked_until->isFuture();
    }

    public function suspend()
    {
        $this->update(['status' => 'suspended']);
    }

    public function activate($status = 'free')
    {
        $this->update(['status' => $status]);
    }
}
