<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Product extends Model
{
    use HasFactory;

    protected $fillable = [
        'merchant_id', 'category_id', 'type', 'name', 'slug', 'description',
        'price', 'discount_price', 'stock', 'images', 'thumbnail', 'attributes', 'variations', 'sku',
        'cashback_percentage', 'status',
        'meta_title', 'meta_description',
        'is_featured', 'is_flash_deal',
        'flash_deal_start', 'flash_deal_end'
    ];

    protected function casts(): array
    {
        return [
            'price' => 'decimal:2',
            'discount_price' => 'decimal:2',
            'cashback_percentage' => 'decimal:2',
            'images' => 'array',
            'attributes' => 'array',
            'variations' => 'array',
            'is_featured' => 'boolean',
            'is_flash_deal' => 'boolean',
            'flash_deal_start' => 'datetime',
            'flash_deal_end' => 'datetime',
        ];
    }

    protected static function boot()
    {
        parent::boot();
        
        static::creating(function ($product) {
            if (empty($product->slug)) {
                $product->slug = Str::slug($product->name);
            }
        });
    }

    public function merchant()
    {
        return $this->belongsTo(Merchant::class)->withDefault([
            'business_name' => 'Admin'
        ]);
    }

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function orderItems()
    {
        return $this->hasMany(OrderItem::class);
    }

    public function reviews()
    {
        return $this->hasMany(Review::class);
    }

    public function scopeActive($query)
    {
        return $query->where('status', 'active');
    }

    public function scopeInStock($query)
    {
        return $query->where('stock', '>', 0);
    }

    public function getFinalPriceAttribute()
    {
        return $this->discount_price ?? $this->price;
    }

    public function getDiscountPercentageAttribute()
    {
        if ($this->discount_price) {
            return round((($this->price - $this->discount_price) / $this->price) * 100, 2);
        }
        return 0;
    }
}
