<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Withdrawal extends Model
{
    use HasFactory;

    protected $fillable = [
        'wallet_id', 'amount', 'method', 'account_details', 
        'status', 'admin_note', 'approved_at', 'completed_at'
    ];

    protected function casts(): array
    {
        return [
            'amount' => 'decimal:2',
            'account_details' => 'array',
            'approved_at' => 'datetime',
            'completed_at' => 'datetime',
        ];
    }

    public function wallet()
    {
        return $this->belongsTo(Wallet::class);
    }

    public function scopePending($query)
    {
        return $query->where('status', 'pending');
    }
}
