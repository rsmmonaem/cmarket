<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SharePurchase extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id', 'chain_shop_id', 'shares', 
        'price_per_share', 'total_amount', 'transaction_reference'
    ];

    protected function casts(): array
    {
        return [
            'price_per_share' => 'decimal:2',
            'total_amount' => 'decimal:2',
        ];
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function chainShop()
    {
        return $this->belongsTo(ChainShop::class);
    }
}
