<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Wallet extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'wallet_type',
        'is_locked',
    ];

    protected function casts(): array
    {
        return [
            'is_locked' => 'boolean',
        ];
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function ledgers()
    {
        return $this->hasMany(WalletLedger::class);
    }

    public function transfersFrom()
    {
        return $this->hasMany(WalletTransfer::class, 'from_wallet');
    }

    public function transfersTo()
    {
        return $this->hasMany(WalletTransfer::class, 'to_wallet');
    }

    public function withdrawals()
    {
        return $this->hasMany(Withdrawal::class);
    }

    // Calculate balance from ledger
    public function getBalanceAttribute()
    {
        $lastLedger = $this->ledgers()->latest()->first();
        return $lastLedger ? $lastLedger->balance_after : 0;
    }

    // Credit wallet
    public function credit($amount, $reference, $type, $description = null)
    {
        $currentBalance = $this->balance;
        $newBalance = $currentBalance + $amount;

        return $this->ledgers()->create([
            'reference' => $reference,
            'credit' => $amount,
            'debit' => 0,
            'balance_after' => $newBalance,
            'type' => $type,
            'description' => $description,
        ]);
    }

    // Debit wallet
    public function debit($amount, $reference, $type, $description = null)
    {
        $currentBalance = $this->balance;
        
        if ($currentBalance < $amount) {
            throw new \Exception('Insufficient balance');
        }

        $newBalance = $currentBalance - $amount;

        return $this->ledgers()->create([
            'reference' => $reference,
            'credit' => 0,
            'debit' => $amount,
            'balance_after' => $newBalance,
            'type' => $type,
            'description' => $description,
        ]);
    }

    public function lock()
    {
        $this->update(['is_locked' => true]);
    }

    public function unlock()
    {
        $this->update(['is_locked' => false]);
    }
}
