<?php

namespace Modules\Customer\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Wallet;
use App\Models\WalletTransfer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use App\Models\SystemSetting;

class TransferController extends Controller
{
    public function index()
    {
        $users = User::where('id', '!=', auth()->id())
            ->select('id', 'name')
            ->get();
            
        $min_balance = SystemSetting::get('min_transfer_balance', 500);
        return view('customer::transfer.index', compact('users', 'min_balance'));
    }

    public function transfer(Request $request)
    {
        $request->validate([
            'recipient_id' => 'required|exists:users,id',
            'amount' => 'required|numeric|min:1',
        ]);

        $sender = auth()->user();
        $recipient = User::findOrFail($request->recipient_id);
        $amount = $request->amount;

        // Business Logic: Dynamic mandatory balance
        $min_balance = SystemSetting::get('min_transfer_balance', 500);
        $senderMainWallet = $sender->getWallet('main');
        $availableBalance = $senderMainWallet->balance;

        if (($availableBalance - $amount) < $min_balance) {
            $transferable = max(0, $availableBalance - $min_balance);
            return back()->with('error', "Insufficient balance. You must maintain at least ৳{$min_balance} in your wallet. Maximum you can transfer is ৳{$transferable}.")->withInput();
        }

        try {
            DB::transaction(function () use ($sender, $recipient, $amount, $senderMainWallet) {
                $recipientMainWallet = $recipient->getWallet('main');
                
                if (!$recipientMainWallet) {
                    $recipientMainWallet = Wallet::create([
                        'user_id' => $recipient->id,
                        'wallet_type' => 'main',
                        'is_locked' => false
                    ]);
                }

                $reference = 'TRF-' . strtoupper(Str::random(10));

                // 1. Record Transfer
                WalletTransfer::create([
                    'from_user' => $sender->id,
                    'to_user' => $recipient->id,
                    'from_wallet' => $senderMainWallet->id,
                    'to_wallet' => $recipientMainWallet->id,
                    'amount' => $amount,
                    'reference' => $reference,
                    'status' => 'completed',
                    'note' => "Fund transfer to {$recipient->name}"
                ]);

                // 2. Debit Sender
                $senderMainWallet->debit(
                    $amount,
                    $reference,
                    'transfer',
                    "Sent funds to {$recipient->name} (#{$recipient->id})"
                );

                // 3. Credit Recipient
                $recipientMainWallet->credit(
                    $amount,
                    $reference,
                    'transfer',
                    "Received funds from {$sender->name} (#{$sender->id})"
                );
            });

            return redirect()->route('customer.dashboard')->with('success', "৳{$amount} transferred successfully to {$recipient->name}! ✅");

        } catch (\Exception $e) {
            return back()->with('error', "Transfer failed: " . $e->getMessage())->withInput();
        }
    }
}
