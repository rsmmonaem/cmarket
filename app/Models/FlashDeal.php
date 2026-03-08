<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class FlashDeal extends Model
{
    protected $fillable = [
        'title','discount_percentage','start_date','end_date','type','is_active'
    ];

    protected $casts = [
        'is_active' => 'boolean',
        'start_date' => 'datetime',
        'end_date' => 'datetime',
    ];

    public function isActive(): bool
    {
        return $this->is_active && now()->between($this->start_date, $this->end_date);
    }
}
