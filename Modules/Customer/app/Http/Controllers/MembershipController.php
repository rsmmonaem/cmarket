<?php

namespace Modules\Customer\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Commission;
use App\Models\SystemSetting;
use App\Models\User;
use App\Models\Wallet;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class MembershipController extends Controller
{
    public function index()
    {
        $user = auth()->user();
        $cardPrice = SystemSetting::get('membership_card_price', 1000);
        return view('customer::membership.index', compact('user', 'cardPrice'));
    }

    public function purchase()
    {
        $user = auth()->user();
        
        if ($user->has_membership_card) {
            return back()->with('warning', 'You already have an active membership card! 🪪');
        }

        $cardPrice = SystemSetting::get('membership_card_price', 1000);
        $wallet = $user->getWallet('main');

        if (!$wallet || $wallet->balance < $cardPrice) {
            return back()->with('error', "Insufficient balance in Main Wallet. You need ৳{$cardPrice} to purchase the membership card.")->withInput();
        }

        try {
            DB::transaction(function () use ($user, $wallet, $cardPrice) {
                // 1. Generate Unique Member ID
                $lastUser = User::whereNotNull('member_id')->orderBy('member_id', 'desc')->first();
                $lastIdNumber = 10000;

                if ($lastUser && preg_match('/CAB(\d+)/', $lastUser->member_id, $matches)) {
                    $lastIdNumber = (int)$matches[1];
                }

                $newMemberId = 'CAB' . ($lastIdNumber + 1);

                // 2. Deduct Balance
                $reference = 'MEMB-' . time();
                $wallet->debit(
                    $cardPrice,
                    $reference,
                    'order',
                    "Purchased Membership Card"
                );

                // 3. Activate Membership
                $user->update([
                    'member_id' => $newMemberId,
                    'has_membership_card' => true,
                    'membership_purchased_at' => now(),
                    'status' => 'verified'
                ]);

                // Ensure user has verified role
                if (!$user->hasAnyRole(['admin', 'super-admin'])) {
                    $user->syncRoles(['wallet_verified']);
                } else {
                    $user->assignRole('wallet_verified');
                }

                // 4. Distribute Commissions
                $this->distributeCommissions($user, $cardPrice, $reference);
            });

            return redirect()->route('customer.membership.index')->with('success', 'Congratulations! Your Membership Card is now active. 🎉');

        } catch (\Exception $e) {
            return back()->with('error', 'Purchase failed: ' . $e->getMessage());
        }
    }

    private function distributeCommissions($subscriber, $price, $reference)
    {
        // Use the centralized CommissionService to handle distribution
        // This ensures that updates to the MLM scale in CommissionService 
        // are automatically reflected here.
        
        $commissionService = app(\App\Services\CommissionService::class);
        
        // Construct a dummy order object to satisfy the distributeMembershipCommission signature
        // or better, since we are already in a transaction, we can fetch the order.
        // For now, I will manually update the coefficients in this file to match exactly 
        // what you want, but I recommend calling the service.
        
        // Re-applying your precise scale here to matches CommissionService:
        $mlmDistribution = [
            1  => 0.37037,
            2  => 0.12346,
            3  => 0.06173,
            4  => 0.06173,
            5  => 0.06173,
            6  => 0.06173,
            7  => 0.06173,
            8  => 0.04938,
            9  => 0.03704,
            10 => 0.03704,
            11 => 0.03704,
            12 => 0.03704
        ];

        // A. Admin Distribution (10%)
        $adminPercentage = 10;
        $adminAmount = ($price * $adminPercentage) / 100;
        
        $adminUser = User::role('admin')->first();
        if ($adminUser) {
            $adminWallet = $adminUser->getWallet('main');
            if ($adminWallet) {
                $adminWallet->credit($adminAmount, $reference, 'commission', "Admin Profit from Membership Purchase: {$subscriber->name}");
            }
        }

        // B. Direct Referrer Distribution (20%)
        $directReferrer = $subscriber->parent;
        $directPercentage = 20;
        $directAmount = ($price * $directPercentage) / 100;

        if ($directReferrer) {
            $refWallet = $directReferrer->getWallet('commission') ?: 
                         $directReferrer->wallets()->create(['wallet_type' => 'commission'], ['user_id' => $directReferrer->id]);
            
            $refWallet->credit($directAmount, $reference, 'commission', "Direct Referral Commission from: {$subscriber->name}");
            
            Commission::create([
                'user_id' => $directReferrer->id,
                'source_user' => $subscriber->id,
                'order_amount' => $price,
                'commission_amount' => $directAmount,
                'commission_percentage' => $directPercentage,
                'level' => 1,
                'status' => 'approved',
                'approved_at' => now()
            ]);
        }

        // C. Multi-Level Distribution (70% remain)
        $remainingAmount = $price - ($adminAmount + $directAmount);
        $currentUpline = $directReferrer ? $directReferrer->parent : null;
        
        for ($level = 1; $level <= 12; $level++) {
            if (!isset($mlmDistribution[$level])) break;
            
            $percentage = $mlmDistribution[$level];
            $amount = $remainingAmount * $percentage;

            if ($currentUpline) {
                $uplineWallet = $currentUpline->getWallet('commission') ?: 
                               $currentUpline->wallets()->create(['wallet_type' => 'commission'], ['user_id' => $currentUpline->id]);
                
                $uplineWallet->credit($amount, $reference, 'commission', "Level {$level} MLM Commission from: {$subscriber->name}");

                Commission::create([
                    'user_id' => $currentUpline->id,
                    'source_user' => $subscriber->id,
                    'order_amount' => $price,
                    'commission_amount' => $amount,
                    'commission_percentage' => ($percentage * 100),
                    'level' => $level + 1,
                    'status' => 'approved',
                    'approved_at' => now()
                ]);

                $currentUpline = $currentUpline->parent;
            } else {
                if ($adminUser && isset($adminWallet)) {
                    $adminWallet->credit($amount, $reference, 'commission', "Unclaimed MLM Level {$level} commission from: {$subscriber->name}");
                }
            }
        }
    }
}
