<?php

namespace App\Services;

use App\Models\User;
use App\Models\Designation;
use App\Models\Referral;
use App\Models\AuditLog;
use Illuminate\Support\Facades\DB;

class RankService
{
    protected $pointService;

    public function __construct(PointService $pointService)
    {
        $this->pointService = $pointService;
    }

    /**
     * Check if a user is eligible for a target-based promotion
     */
    public function checkTargetPromotion(User $user)
    {
        // Get the current designation
        $currentOrder = $user->currentDesignation ? $user->currentDesignation->designation->sort_order : 0;

        // Try to find the next rank that has targets
        $nextRank = Designation::where('sort_order', '>', $currentOrder)
            ->where(function($q) {
                $q->where('sales_target', '>', 0)
                  ->orWhere('referral_target', '>', 0)
                  ->orWhere('team_building_target', '>', 0);
            })
            ->orderBy('sort_order', 'asc')
            ->first();

        if (!$nextRank) {
            return null;
        }

        // Check if targets are met
        if ($this->isEligibleForRank($user, $nextRank)) {
            return $this->pointService->assignDesignation($user, $nextRank, 'target_achievement');
        }

        return null;
    }

    /**
     * Check if user meets the targets for a specific designation
     */
    public function isEligibleForRank(User $user, Designation $designation)
    {
        // 1. Sales Target (Total sales amount from delivered orders)
        $totalSales = $user->orders()->where('status', 'delivered')->sum('total_amount');
        if ($totalSales < $designation->sales_target) {
            return false;
        }

        // 2. Referral Target (Direct referrals)
        $directReferrals = $user->referrals()->count();
        if ($directReferrals < $designation->referral_target) {
            return false;
        }

        // 3. Team Building Target (Total team size)
        $teamSize = $this->getTeamSize($user);
        if ($teamSize < $designation->team_building_target) {
            return false;
        }

        return true;
    }

    /**
     * Calculate total team size recursively (MLM tree)
     */
    public function getTeamSize(User $user)
    {
        // This is a simplified version, in a large scale app a closure table or materialized path is better
        $total = 0;
        $directs = Referral::where('referrer_id', $user->id)->pluck('referred_id')->toArray();
        
        if (empty($directs)) return 0;

        $total += count($directs);

        // Fetch sub-referrals (all levels)
        $subReferralsCount = Referral::whereIn('referrer_id', $directs)->count();
        // For MLM, we usually want the full tree.
        // Let's use a more robust way to get total downline for a flat structure
        
        // This query gets all nodes that have this user in their parent path (if level is tracked)
        // Since we only have referrer_id, we'd need multiple queries or a recursive CTE.
        
        // For now, let's use a recursive helper:
        return $this->recursiveTeamCount($user->id);
    }

    protected function recursiveTeamCount($userId, &$visited = [])
    {
        if (in_array($userId, $visited)) return 0;
        $visited[] = $userId;

        $referrals = Referral::where('referrer_id', $userId)->pluck('referred_id');
        $count = $referrals->count();

        foreach ($referrals as $referredId) {
            $count += $this->recursiveTeamCount($referredId, $visited);
        }

        return $count;
    }

    /**
     * Get structured generation list for a user (9 levels)
     */
    public function getGenerations(User $user, $maxLevel = 9)
    {
        $generations = [];
        for ($i = 1; $i <= $maxLevel; $i++) {
            $generations[$i] = [
                'count' => 0,
                'users' => collect()
            ];
        }

        $this->fillGenerations($user->id, 1, $maxLevel, $generations);

        return $generations;
    }

    protected function fillGenerations($userId, $currentLevel, $maxLevel, &$generations)
    {
        if ($currentLevel > $maxLevel) return;

        $referralData = Referral::where('referrer_id', $userId)
            ->with(['referred' => function($q) {
                $q->select('id', 'name', 'phone', 'created_at', 'status')
                  ->with('currentDesignation.designation');
            }])
            ->get();

        foreach ($referralData as $item) {
            $referredUser = $item->referred;
            if ($referredUser) {
                $generations[$currentLevel]['count']++;
                $generations[$currentLevel]['users']->push($referredUser);
                
                // Recursive call for next level
                $this->fillGenerations($referredUser->id, $currentLevel + 1, $maxLevel, $generations);
            }
        }
    }

    public function getNextRank(User $user)
    {
        $currentOrder = $user->currentDesignation ? $user->currentDesignation->designation->sort_order : -1;

        return Designation::where('sort_order', '>', $currentOrder)
            ->orderBy('sort_order', 'asc')
            ->first();
    }
}
