<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class WalletTransfer extends Model
{
    use HasFactory;

    protected $fillable = ['from_wallet', 'to_wallet', 'amount', 'status', 'note'];

    protected function casts(): array
    {
        return [
            'amount' => 'decimal:2',
        ];
    }

    public function fromWallet()
    {
        return $this->belongsTo(Wallet::class, 'from_wallet');
    }

    public function toWallet()
    {
        return $this->belongsTo(Wallet::class, 'to_wallet');
    }
}
