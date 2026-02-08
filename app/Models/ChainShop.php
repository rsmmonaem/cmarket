<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class ChainShop extends Model
{
    use HasFactory;

    protected $fillable = [
        'name', 'slug', 'description', 'location', 
        'total_shares', 'share_price', 'available_shares', 'status'
    ];

    protected function casts(): array
    {
        return [
            'share_price' => 'decimal:2',
        ];
    }

    protected static function boot()
    {
        parent::boot();
        
        static::creating(function ($shop) {
            if (empty($shop->slug)) {
                $shop->slug = Str::slug($shop->name);
            }
        });
    }

    public function sharePurchases()
    {
        return $this->hasMany(SharePurchase::class);
    }

    public function profitDistributions()
    {
        return $this->hasMany(ProfitDistribution::class);
    }

    public function scopeActive($query)
    {
        return $query->where('status', 'active');
    }
}
