<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Delivery extends Model
{
    use HasFactory;

    protected $fillable = [
        'order_id', 'rider_id', 'status', 'pickup_address',
        'delivery_address', 'assigned_at', 'picked_at', 
        'delivered_at', 'delivery_note', 'delivery_fee'
    ];

    protected function casts(): array
    {
        return [
            'delivery_fee' => 'decimal:2',
            'assigned_at' => 'datetime',
            'picked_at' => 'datetime',
            'delivered_at' => 'datetime',
        ];
    }

    public function order()
    {
        return $this->belongsTo(Order::class);
    }

    public function rider()
    {
        return $this->belongsTo(Rider::class);
    }
}
