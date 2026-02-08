<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProfitDistribution extends Model
{
    use HasFactory;

    protected $fillable = [
        'chain_shop_id', 'total_profit', 'profit_per_share', 
        'period', 'distribution_date', 'status'
    ];

    protected function casts(): array
    {
        return [
            'total_profit' => 'decimal:2',
            'profit_per_share' => 'decimal:2',
            'distribution_date' => 'date',
        ];
    }

    public function chainShop()
    {
        return $this->belongsTo(ChainShop::class);
    }
}
