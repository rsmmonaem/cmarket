<?php

namespace App\Observers;

use App\Models\Order;
use App\Models\Commission;
use App\Models\User;
use App\Models\Wallet;
use App\Models\WalletLedger;
use Illuminate\Support\Facades\DB;

class OrderObserver
{
    public function updated(Order $order)
    {
        // When order is delivered, calculate and distribute commissions
        if ($order->isDirty('status') && $order->status === 'delivered') {
            $this->calculateCommissions($order);
        }
    }

    private function calculateCommissions(Order $order)
    {
        DB::beginTransaction();
        try {
            $buyer = $order->user;
            $orderAmount = $order->total_amount;

            // Commission percentages by level
            $commissionRates = [
                1 => 5,  // 5% for direct referrer
                2 => 3,  // 3% for level 2
                3 => 2,  // 2% for level 3
                4 => 1,  // 1% for level 4
                5 => 1,  // 1% for level 5
            ];

            $currentUser = $buyer;
            $level = 1;

            // Traverse up the referral chain
            while ($currentUser->referred_by && $level <= 5) {
                $referrer = User::find($currentUser->referred_by);
                
                if (!$referrer) {
                    break;
                }

                $commissionRate = $commissionRates[$level] ?? 0;
                $commissionAmount = ($orderAmount * $commissionRate) / 100;

                // Create commission record
                $commission = Commission::create([
                    'user_id' => $referrer->id,
                    'order_id' => $order->id,
                    'from_user_id' => $buyer->id,
                    'level' => $level,
                    'amount' => $commissionAmount,
                    'percentage' => $commissionRate,
                    'status' => 'pending',
                    'type' => 'referral',
                ]);

                // Auto-approve and credit to commission wallet
                $this->approveCommission($commission);

                $currentUser = $referrer;
                $level++;
            }

            // Check for designation upgrades
            $this->checkDesignationUpgrade($buyer);

            DB::commit();
        } catch (\Exception $e) {
            DB::rollBack();
            \Log::error('Commission calculation failed: ' . $e->getMessage());
        }
    }

    private function approveCommission(Commission $commission)
    {
        $commission->update([
            'status' => 'approved',
            'approved_at' => now(),
        ]);

        // Credit to commission wallet
        $commissionWallet = Wallet::where('user_id', $commission->user_id)
            ->where('wallet_type', 'commission')
            ->first();

        if ($commissionWallet) {
            WalletLedger::create([
                'wallet_id' => $commissionWallet->id,
                'type' => 'credit',
                'amount' => $commission->amount,
                'description' => "Level {$commission->level} commission from order #{$commission->order->order_number}",
                'reference_type' => 'commission',
                'reference_id' => $commission->id,
            ]);
        }

        // Send email notification
        try {
            \Mail::to($commission->user->email)->send(new \App\Mail\CommissionEarned($commission));
        } catch (\Exception $e) {
            \Log::error('Failed to send commission email: ' . $e->getMessage());
        }
    }

    private function checkDesignationUpgrade(User $user)
    {
        // Get user's total sales and referrals
        $totalSales = Order::where('user_id', $user->id)
            ->where('status', 'delivered')
            ->sum('total_amount');

        $directReferrals = User::where('referred_by', $user->id)->count();
        $teamSize = $this->getTeamSize($user->id);

        // Get all designations ordered by criteria
        $designations = \App\Models\Designation::where('is_active', true)
            ->orderBy('min_sales', 'desc')
            ->get();

        foreach ($designations as $designation) {
            $meetsRequirements = true;

            // Check sales requirement
            if ($designation->min_sales && $totalSales < $designation->min_sales) {
                $meetsRequirements = false;
            }

            // Check referral requirement
            if ($designation->min_referrals && $directReferrals < $designation->min_referrals) {
                $meetsRequirements = false;
            }

            // Check team size requirement
            if ($designation->min_team_size && $teamSize < $designation->min_team_size) {
                $meetsRequirements = false;
            }

            if ($meetsRequirements) {
                // Upgrade user's designation
                if (!$user->designation_id || $user->designation_id < $designation->id) {
                    $user->update([
                        'designation_id' => $designation->id,
                        'designation_achieved_at' => now(),
                    ]);
                }
                break;
            }
        }
    }

    private function getTeamSize($userId, $maxLevel = 5)
    {
        $count = 0;
        $level = 1;

        $currentLevelUsers = [$userId];

        while ($level <= $maxLevel && !empty($currentLevelUsers)) {
            $nextLevelUsers = User::whereIn('referred_by', $currentLevelUsers)
                ->pluck('id')
                ->toArray();

            $count += count($nextLevelUsers);
            $currentLevelUsers = $nextLevelUsers;
            $level++;
        }

        return $count;
    }
}
