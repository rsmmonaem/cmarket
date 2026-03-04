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
    protected $pointService;
    protected $rankService;

    public function __construct(PointService $pointService, RankService $rankService)
    {
        $this->pointService = $pointService;
        $this->rankService = $rankService;
    }

    /**
     * Distribute profit based on the 9-generation hierarchy
     */
    public function distribute(Order $order)
    {
        return DB::transaction(function () use ($order) {
            $buyer = $order->user;
            if (!$buyer) return;

            // Total % of profit to be distributed (Dynamic from DB)
            $profitMargin = \App\Models\SystemSetting::get('distributable_profit_percentage', 10.00);
            $totalProfit = ($order->total_amount * $profitMargin) / 100;

            // Get all designations ordered by sort_order
            $designations = Designation::orderBy('sort_order', 'asc')->get();

            $currentReferrer = $this->getParent($buyer->id);
            $level = 1;

            while ($currentReferrer && $level <= 9) {
                // Get the percentage for this level (mapped to rank order)
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

            // Also add points to the buyer
            $orderPoints = 0;
            foreach ($order->items as $item) {
                // Calculate points from product if not already snapshot-ed
                $points = $item->points ?: ($item->product->points ?? 0);
                $orderPoints += ($points * $item->quantity);
            }

            if ($orderPoints > 0) {
                $this->pointService->addPoints($buyer, $orderPoints, "Order #{$order->order_number}");
            }

            // Pay the Merchant
            $this->processMerchantPayout($order);

            // Check for potential target-based promotions for the whole hierarchy
            $this->checkHierarchyPromotions($buyer);

            return true;
        });
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
