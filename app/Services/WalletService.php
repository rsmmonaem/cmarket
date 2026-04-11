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
    public function transfer(User $fromUser, string $toPhone = null, float $amount, string $walletType = 'main', string $description = null, int $toUserId = null)
    {
        return DB::transaction(function () use ($fromUser, $toPhone, $amount, $walletType, $description, $toUserId) {
            if ($toUserId) {
                $toUser = User::find($toUserId);
            } else {
                $toUser = User::where('phone', $toPhone)->first();
            }
            
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

    /**
     * Request withdrawal
     */
    public function requestWithdrawal(User $user, string $walletType, float $amount, string $method, array $accountDetails)
    {
        return DB::transaction(function () use ($user, $walletType, $amount, $method, $accountDetails) {
            $wallet = $user->getWallet($walletType);

            if (!$wallet || $wallet->is_locked) {
                throw new \Exception("Wallet is unavailable or locked.");
            }

            if ($wallet->balance < $amount) {
                throw new \Exception("Insufficient balance in your {$walletType} wallet.");
            }

            // Create withdrawal reference
            $reference = 'WDR-' . strtoupper(uniqid());

            // Debit user first (locking the funds)
            $wallet->debit($amount, $reference, 'withdrawal_request', "Withdrawal request via {$method} to " . json_encode($accountDetails));

            // Create record
            return \App\Models\Withdrawal::create([
                'wallet_id' => $wallet->id,
                'amount' => $amount,
                'method' => $method,
                'account_details' => $accountDetails,
                'status' => 'pending',
            ]);
        });
    }
}
