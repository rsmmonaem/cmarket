<?php

namespace App\Services;

use App\Models\User;
use App\Models\Designation;
use App\Models\UserDesignation;
use App\Models\AuditLog;
use Illuminate\Support\Facades\DB;

class PointService
{
    /**
     * Add points to a user and check for eligibility upgrades
     */
    public function addPoints(User $user, $points, $source = 'purchase')
    {
        return DB::transaction(function () use ($user, $points, $source) {
            $user->points += $points;
            $user->total_points += $points;
            $user->save();

            AuditLog::create([
                'user_id' => $user->id,
                'action' => 'points_added',
                'description' => "Earned {$points} points from {$source}",
                'metadata' => json_encode(['points' => $points, 'source' => $source])
            ]);

            return $this->checkAutomaticUpgrade($user);
        });
    }

    /**
     * Upgrade user position using Voucher Points
     */
    public function upgradeWithVoucher(User $user, $requiredPoints)
    {
        if ($user->voucher_points < $requiredPoints) {
            throw new \Exception("Insufficient voucher points.");
        }

        return DB::transaction(function () use ($user, $requiredPoints) {
            $user->voucher_points -= $requiredPoints;
            $user->save();

            // Find the designation that matches these required points
            $designation = Designation::where('required_voucher_points', '<=', $requiredPoints)
                ->orderBy('sort_order', 'desc')
                ->first();

            if ($designation) {
                $this->assignDesignation($user, $designation, 'voucher_upgrade');
            }

            AuditLog::create([
                'user_id' => $user->id,
                'action' => 'voucher_upgrade',
                'description' => "Upgraded using {$requiredPoints} voucher points",
                'metadata' => json_encode(['points_used' => $requiredPoints])
            ]);

            return true;
        });
    }

    /**
     * Check if user is eligible for an automatic upgrade based on points
     */
    public function checkAutomaticUpgrade(User $user)
    {
        // Get the current designation sort order
        $currentOrder = $user->currentDesignation ? $user->currentDesignation->designation->sort_order : 0;

        // Find highest possible designation the user qualifies for by points
        $newDesignation = Designation::where('required_points', '>', 0)
            ->where('required_points', '<=', $user->total_points)
            ->where('sort_order', '>', $currentOrder)
            ->orderBy('sort_order', 'desc')
            ->first();

        if ($newDesignation) {
            return $this->assignDesignation($user, $newDesignation, 'point_based_upgrade');
        }

        return null;
    }

    /**
     * Assign a new designation to a user
     */
    public function assignDesignation(User $user, Designation $designation, $reason = 'system')
    {
        return DB::transaction(function () use ($user, $designation, $reason) {
            // Deactivate current
            UserDesignation::where('user_id', $user->id)->update(['is_current' => false]);

            // Create new
            $new = UserDesignation::create([
                'user_id' => $user->id,
                'designation_id' => $designation->id,
                'achieved_at' => now(),
                'is_current' => true,
                'achievement_data' => json_encode([
                    'total_points' => $user->total_points,
                    'reason' => $reason
                ])
            ]);

            AuditLog::create([
                'user_id' => $user->id,
                'action' => 'rank_promoted',
                'description' => "Promoted to {$designation->name} via {$reason}",
                'metadata' => json_encode(['rank' => $designation->name, 'reason' => $reason])
            ]);

            return $new;
        });
    }
}
