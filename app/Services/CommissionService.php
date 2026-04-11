<?php

namespace App\Services;

use App\Models\Order;
use App\Models\User;
use App\Models\Commission;
use App\Models\Referral;
use App\Models\Designation;
use App\Models\Wallet;
use App\Models\AuditLog;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class CommissionService
{
    protected $walletService;
    protected $pointService;
    protected $rankService;

    public function __construct(PointService $pointService, RankService $rankService, WalletService $walletService)
    {
        $this->pointService = $pointService;
        $this->rankService = $rankService;
        $this->walletService = $walletService;
    }

    /**
     * Distribute profit based on the order type (Membership vs Product)
     */
    public function distribute(Order $order)
    {
        return DB::transaction(function () use ($order) {
            $buyer = $order->user;
            if (!$buyer) return;

            // Prevent double distribution
            if ($order->commissions()->exists()) {
                return;
            }

            // 1. Detect if this is a Membership Purchase Order
            $isMembershipOrder = false;
            foreach ($order->items as $item) {
                if ($item && $item->product && $item->product->type === 'package') {
                    $isMembershipOrder = true;
                    break;
                }
            }

            if ($isMembershipOrder) {
                return $this->distributeMembershipCommission($order);
            }

            // 2. Regular Product Commission Distribution
            $this->distributeProductProfit($order);

            // 3. Grant Buyer Cashback (if not already received)
            if ($order->cashback_amount > 0) {
                $this->grantBuyerCashback($order);
            }

            return true;
        });
    }

    /**
     * Distribute commission for Membership Card purchase (12 Levels)
     */
    protected function distributeMembershipCommission(Order $order)
    {
        $subscriber = $order->user;
        $price = $order->total_amount;
        $reference = 'MEMB-ORD-' . $order->order_number;

        // A. Admin Distribution (10%)
        $adminPercentage = \App\Models\SystemSetting::get('membership_admin_percentage', 10.00);
        $adminAmount = ($price * $adminPercentage) / 100;
        
        $adminUser = User::role('admin')->first();
        if ($adminUser) {
            $adminWallet = $adminUser->getWallet('main');
            if ($adminWallet) {
                $adminWallet->credit($adminAmount, $reference, 'commission', "Admin Profit from Membership: {$subscriber->name}");
            }
        }

        // B. Direct Referrer Distribution (20%)
        $directReferrer = $this->getParent($subscriber->id);
        $directPercentage = \App\Models\SystemSetting::get('membership_direct_percentage', 20.00);
        $directAmount = ($price * $directPercentage) / 100;

        if ($directReferrer) {
            $refWallet = $directReferrer->getWallet('commission') ?: 
                         $directReferrer->wallets()->firstOrCreate(['wallet_type' => 'commission'], ['user_id' => $directReferrer->id]);
            
            $refWallet->credit($directAmount, $reference, 'commission', "Direct Referral Commission from: {$subscriber->name}");
            
            $this->createCommissionRecord($directReferrer, $subscriber, $order, $directAmount, $directPercentage, 1);
        }

        // C. Multi-Level Distribution (Remaining amount across 12 Levels)
        $remainingAmount = $price - ($adminAmount + $directAmount);
        

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


        // Start from Subscriber's Grandparent
        $currentUpline = $directReferrer ? $this->getParent($directReferrer->id) : null;
        
        for ($level = 1; $level <= 12; $level++) {
            if (!isset($mlmDistribution[$level])) break;
            
            $percentage = $mlmDistribution[$level];
            $amount = $remainingAmount * $percentage;

            if ($currentUpline) {
                $uplineWallet = $currentUpline->getWallet('commission') ?: 
                               $currentUpline->wallets()->firstOrCreate(['wallet_type' => 'commission'], ['user_id' => $currentUpline->id]);
                
                $uplineWallet->credit($amount, $reference, 'commission', "Level {$level} MLM Commission from: {$subscriber->name}");

                $this->createCommissionRecord($currentUpline, $subscriber, $order, $amount, ($percentage * 100), $level + 1);

                $currentUpline = $this->getParent($currentUpline->id);
            } else {
                // If no upline, send unclaimed portion to Admin
                if ($adminUser && isset($adminWallet)) {
                    $adminWallet->credit($amount, $reference, 'unclaimed_commission', "Unclaimed MLM Level {$level} commission from: {$subscriber->name}");
                }
            }
        }

        return true;
    }

    /**
     * Original product distribution logic refactored
     */
    protected function distributeProductProfit(Order $order)
    {
        $buyer = $order->user;
        
        // Total % of profit to be distributed (Dynamic from DB)
        $profitMargin = \App\Models\SystemSetting::get('distributable_profit_percentage', 10.00);
        $totalProfit = ($order->total_amount * $profitMargin) / 100;

        // Get all designations ordered by sort_order
        $designations = Designation::orderBy('sort_order', 'asc')->get();

        $currentReferrer = $this->getParent($buyer->id);
        $level = 1;

        while ($currentReferrer && $level <= 12) {
            $rankInfo = $designations->where('sort_order', $level)->first();
            
            if ($rankInfo && $rankInfo->percentage > 0) {
                $commissionAmount = ($totalProfit * $rankInfo->percentage) / 100;

                if ($commissionAmount > 0) {
                    $this->applyCommission($currentReferrer, $buyer, $order, $commissionAmount, $rankInfo->percentage, $level);
                }
            }

            $currentReferrer = $this->getParent($currentReferrer->id);
            $level++;
        }

        // Add points to buyer
        $this->processOrderPoints($order, $buyer);

        // Pay the Merchant
        $this->processMerchantPayout($order);

        // Check for promotions
        $this->checkHierarchyPromotions($buyer);

        return true;
    }

    /**
     * Helper to create commission record
     */
    protected function createCommissionRecord($user, $sourceUser, $order, $amount, $percentage, $level)
    {
        return Commission::create([
            'user_id' => $user->id,
            'source_user' => $sourceUser->id,
            'order_id' => $order->id,
            'order_amount' => $order->total_amount,
            'commission_amount' => $amount,
            'commission_percentage' => $percentage,
            'level' => $level,
            'status' => 'approved',
            'approved_at' => now(),
        ]);
    }

    /**
     * Process points for an order
     */
    protected function processOrderPoints(Order $order, $buyer)
    {
        $orderPoints = 0;
        foreach ($order->items as $item) {
            $points = $item->points ?: ($item->product->points ?? 0);
            $orderPoints += ($points * $item->quantity);
        }

        if ($orderPoints > 0) {
            $this->pointService->addPoints($buyer, $orderPoints, "Order #{$order->order_number}");
        }
    }

    /**
     * Create commission record and update wallet
     */
    protected function applyCommission($referrer, $buyer, $order, $amount, $percentage, $level)
    {
        Commission::create([
            'user_id' => $referrer->id,
            'source_user' => $buyer->id,
            'order_id' => $order->id,
            'order_amount' => $order->total_amount,
            'commission_amount' => $amount,
            'commission_percentage' => $percentage,
            'level' => $level,
            'status' => 'approved',
            'approved_at' => now(),
        ]);

        // Add to main wallet
        $wallet = $referrer->getWallet('main') ?: $referrer->wallets()->first();
        if ($wallet) {
            $wallet->deposit($amount, "COMMISSION-{$order->id}-L{$level}", 'commission', "Level {$level} Profit Sharing");
        }

        AuditLog::create([
            'user_id' => $referrer->id,
            'action' => 'commission_received',
            'description' => "Received ৳{$amount} from {$buyer->name} (Level {$level})",
            'metadata' => json_encode(['level' => $level, 'order_id' => $order->id])
        ]);
    }

    /**
     * Get parent user
     */
    protected function getParent($userId)
    {
        $referral = Referral::where('referred_id', $userId)->first();
        return $referral ? $referral->referrer : null;
    }

    /**
     * Process affiliate commission for an order
     */
    public function processAffiliateCommission(Order $order, $affiliateData)
    {
        return DB::transaction(function () use ($order, $affiliateData) {
            $affiliateId = $affiliateData['affiliate_id'];
            $linkId = $affiliateData['link_id'];
            
            $affiliate = \App\Models\Affiliate::findOrFail($affiliateId);
            $link = \App\Models\AffiliateLink::findOrFail($linkId);

            // Calculate commission (Dynamic from DB)
            $percentage = \App\Models\SystemSetting::get('default_affiliate_commission_percentage', 5.00);
            $commissionAmount = ($order->total_amount * $percentage) / 100;

            // Create affiliate commission record
            \App\Models\AffiliateCommission::create([
                'affiliate_id' => $affiliate->id,
                'order_id' => $order->id,
                'order_amount' => $order->total_amount,
                'commission_amount' => $commissionAmount,
                'commission_percentage' => $percentage,
                'status' => 'approved'
            ]);

            // Update affiliate totals
            $affiliate->increment('total_earnings', $commissionAmount);
            $affiliate->increment('total_conversions');
            $link->increment('conversions');

            // Credit wallet (Bonus)
            $user = $affiliate->user;
            $wallet = $user->getWallet('main') ?: $user->wallets()->first();
            if ($wallet) {
                $wallet->deposit($commissionAmount, "AFF-{$order->id}", 'affiliate_bonus', "Affiliate Commission for Order #{$order->order_number}");
            }

            AuditLog::create([
                'user_id' => $user->id,
                'action' => 'affiliate_commission',
                'description' => "Earned ৳{$commissionAmount} affiliate commission from order #{$order->order_number}",
                'metadata' => json_encode(['order_id' => $order->id, 'link_id' => $linkId])
            ]);

            return true;
        });
    }

    /**
     * Process merchant payout for an order
     */
    public function processMerchantPayout(Order $order)
    {
        $merchant = $order->merchant;
        if (!$merchant) return;

        return DB::transaction(function () use ($order, $merchant) {
            // Get dynamic percentages
            $hierarchyMargin = \App\Models\SystemSetting::get('distributable_profit_percentage', 10.00);
            $platformFeeSetting = \App\Models\SystemSetting::get('merchant_commission_percentage', 2.00);

            $totalAmount = $order->total_amount;
            
            $hierarchyPool = ($totalAmount * $hierarchyMargin) / 100;
            $platformFee = ($totalAmount * $platformFeeSetting) / 100;
            
            // Merchant gets the rest
            $merchantShare = $totalAmount - $hierarchyPool - $platformFee;

            if ($merchantShare > 0) {
                $user = $merchant->user;
                $wallet = $user->getWallet('shop_balance') ?: 
                         $user->wallets()->firstOrCreate(['wallet_type' => 'shop_balance'], ['user_id' => $user->id]);

                $wallet->deposit($merchantShare, "SALE-{$order->id}", 'sale_income', "Income from Order #{$order->order_number}");

                AuditLog::create([
                    'user_id' => $user->id,
                    'action' => 'merchant_income',
                    'description' => "Earned ৳{$merchantShare} from Order #{$order->order_number} (Deducted ৳{$platformFee} Platform Fee)",
                    'metadata' => json_encode(['order_id' => $order->id, 'platform_fee' => $platformFee])
                ]);
            }

            return true;
        });
    }

    /**
     * Grant cashback to the buyer for an order
     */
    protected function grantBuyerCashback(Order $order)
    {
        $buyer = $order->user;
        if (!$buyer) return;

        $reference = $order->order_number;
        
        // Check if cashback already granted for this order
        $alreadyGranted = \App\Models\WalletLedger::where('reference', $reference)
            ->where('type', 'cashback')
            ->exists();

        if (!$alreadyGranted) {
            $this->walletService->creditCashback(
                $buyer, 
                $order->cashback_amount, 
                $reference, 
                "Cashback for Order #{$order->order_number}"
            );
        }
    }

    /**
     * Re-check targets for the hierarchy after an order completion
     */
    protected function checkHierarchyPromotions(User $buyer)
    {
        $current = $buyer;
        $depth = 0;
        
        while ($current && $depth < 15) { // Check up to 15 levels for performance
            $this->rankService->checkTargetPromotion($current);
            
            $referral = Referral::where('referred_id', $current->id)->first();
            $current = $referral ? $referral->referrer : null;
            $depth++;
        }
    }
}
