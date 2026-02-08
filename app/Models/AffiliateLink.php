<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class AffiliateLink extends Model
{
    use HasFactory;

    protected $fillable = [
        'affiliate_id', 'product_id', 'code', 'url', 'clicks', 'conversions'
    ];

    protected static function boot()
    {
        parent::boot();
        
        static::creating(function ($link) {
            if (empty($link->code)) {
                $link->code = Str::random(10);
            }
        });
    }

    public function affiliate()
    {
        return $this->belongsTo(Affiliate::class);
    }

    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    public function clicks()
    {
        return $this->hasMany(AffiliateClick::class, 'link_id');
    }
}
