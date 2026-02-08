<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Commission;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class ReferralController extends Controller
{
    public function generateCode()
    {
        $user = auth()->user();
        
        if ($user->referral_code) {
            return redirect()->back()->with('error', 'You already have a referral code');
        }

        // Generate unique referral code
        do {
            $code = strtoupper(Str::random(8));
        } while (User::where('referral_code', $code)->exists());

        $user->update(['referral_code' => $code]);

        return redirect()->back()->with('success', 'Referral code generated successfully!');
    }

    public function myReferrals()
    {
        $user = auth()->user();
        
        // Get direct referrals
        $directReferrals = User::where('referred_by', $user->id)->get();
        
        // Get all referrals in tree
        $allReferrals = $this->getAllReferrals($user->id);
        
        // Get commission earnings
        $totalCommissions = Commission::where('user_id', $user->id)
            ->where('status', 'approved')
            ->sum('amount');
        
        $pendingCommissions = Commission::where('user_id', $user->id)
            ->where('status', 'pending')
            ->sum('amount');

        return view('referral.index', compact('directReferrals', 'allReferrals', 'totalCommissions', 'pendingCommissions'));
    }

    private function getAllReferrals($userId, $level = 1, $maxLevel = 5)
    {
        if ($level > $maxLevel) {
            return collect();
        }

        $referrals = User::where('referred_by', $userId)
            ->with('designation')
            ->get()
            ->map(function($user) use ($level) {
                $user->level = $level;
                return $user;
            });

        foreach ($referrals as $referral) {
            $children = $this->getAllReferrals($referral->id, $level + 1, $maxLevel);
            $referrals = $referrals->merge($children);
        }

        return $referrals;
    }
}
