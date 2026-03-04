<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Designation extends Model
{
    use HasFactory;

    protected $fillable = [
        'name', 'slug', 'description', 'criteria', 
        'commission_rate', 'percentage', 'required_points', 'required_voucher_points',
        'sales_target', 'referral_target', 'team_building_target',
        'sort_order', 'is_active'
    ];

    protected function casts(): array
    {
        return [
            'criteria' => 'array',
            'commission_rate' => 'decimal:2',
            'is_active' => 'boolean',
        ];
    }

    protected static function boot()
    {
        parent::boot();
        
        static::creating(function ($designation) {
            if (empty($designation->slug)) {
                $designation->slug = Str::slug($designation->name);
            }
        });
    }

    public function userDesignations()
    {
        return $this->hasMany(UserDesignation::class);
    }

    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    // Check if user meets criteria
    public function checkEligibility(User $user)
    {
        $criteria = $this->criteria;
        
        // Example criteria check
        if (isset($criteria['sales_count'])) {
            $salesCount = $user->orders()->where('status', 'delivered')->count();
            if ($salesCount < $criteria['sales_count']) {
                return false;
            }
        }

        if (isset($criteria['referral_count'])) {
            $referralCount = $user->referrals()->count();
            if ($referralCount < $criteria['referral_count']) {
                return false;
            }
        }

        if (isset($criteria['team_levels'])) {
            // Check team depth
            // Implementation depends on referral structure
        }

        return true;
    }
}
