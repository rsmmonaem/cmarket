<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Topup extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'amount',
        'method',
        'transaction_id',
        'sender_number',
        'status',
        'admin_note',
        'approved_at',
        'approved_by',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function approver()
    {
        return $this->belongsTo(User::class, 'approved_by');
    }
}
