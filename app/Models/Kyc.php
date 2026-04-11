<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Kyc extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'document_type',
        'document_number',
        'document_file',
        'document_front',
        'document_back',
        'status',
        'rejection_reason',
        'approved_at',
    ];

    protected function casts(): array
    {
        return [
            'approved_at' => 'datetime',
        ];
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function scopePending($query)
    {
        return $query->where('status', 'pending');
    }

    public function scopeApproved($query)
    {
        return $query->where('status', 'approved');
    }

    public function approve()
    {
        $this->update([
            'status' => 'approved',
            'approved_at' => now(),
        ]);
    }

    public function reject($reason)
    {
        $this->update([
            'status' => 'rejected',
            'rejection_reason' => $reason,
        ]);
    }
}
