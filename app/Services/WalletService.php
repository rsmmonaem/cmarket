<?php

namespace App\Services;

use App\Models\User;
use App\Models\Wallet;
use App\Models\WalletLedger;
use Illuminate\Support\Facades\DB;

class WalletService
{
    /**
     * Transfer funds between users
     */
    public function transfer(User $fromUser, string $toPhone, float $amount, string $walletType = 'main', string $description = null)
    {
        return DB::transaction(function () use ($fromUser, $toPhone, $amount, $walletType, $description) {
            $toUser = User::where('phone', $toPhone)->first();
            
            if (!$toUser) {
                throw new \Exception("Recipient user not found.");
            }

            if ($fromUser->id === $toUser->id) {
                throw new \Exception("Cannot transfer to yourself.");
            }

            $fromWallet = $fromUser->getWallet($walletType);
            $toWallet = $toUser->getWallet($walletType);

            if (!$fromWallet || $fromWallet->is_locked) {
                throw new \Exception("Sender wallet is unavailable or locked.");
            }
            
            if (!$toWallet || $toWallet->is_locked) {
                throw new \Exception("Recipient wallet is unavailable or locked.");
            }

            if ($fromWallet->balance < $amount) {
                throw new \Exception("Insufficient balance in your {$walletType} wallet.");
            }

            $reference = 'TRF-' . strtoupper(uniqid());

            // Debit sender
            $fromWallet->debit($amount, $reference, 'transfer_out', "Transfer to {$toUser->name} ({$toPhone}). " . $description);

            // Credit recipient
            $toWallet->credit($amount, $reference, 'transfer_in', "Received from {$fromUser->name} ({$fromUser->phone}). " . $description);

            return $reference;
        });
    }

    /**
     * Credit commission to user
     */
    public function creditCommission(User $user, float $amount, string $reference, string $description = null)
    {
        $wallet = $user->getWallet('commission');
        if (!$wallet) {
             $wallet = Wallet::create(['user_id' => $user->id, 'wallet_type' => 'commission']);
        }
        return $wallet->credit($amount, $reference, 'commission', $description);
    }

    /**
     * Credit cashback to user
     */
    public function creditCashback(User $user, float $amount, string $reference, string $description = null)
    {
        $wallet = $user->getWallet('cashback');
        if (!$wallet) {
             $wallet = Wallet::create(['user_id' => $user->id, 'wallet_type' => 'cashback']);
        }
        return $wallet->credit($amount, $reference, 'cashback', $description);
    }
}
