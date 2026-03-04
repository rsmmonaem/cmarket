<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Kyc;
use App\Models\User;
use Illuminate\Http\Request;

class KycController extends Controller
{
    public function index()
    {
        $kycs = Kyc::with('user')->latest()->paginate(20);
        return view('admin.kyc.index', compact('kycs'));
    }

    public function show(Kyc $kyc)
    {
        $kyc->load('user');
        return view('admin.kyc.show', compact('kyc'));
    }

    public function approve(Kyc $kyc)
    {
        $kyc->approve();
        
        $user = $kyc->user;

        // Update user status
        $user->update(['status' => 'wallet_verified']);

        // Update role to 'wallet_verified'
        $user->syncRoles(['wallet_verified']);

        // Create additional wallets
        $walletTypes = ['cashback', 'commission', 'shop', 'share'];
        foreach ($walletTypes as $type) {
            if (!$user->hasWallet($type)) {
                \App\Models\Wallet::create([
                    'user_id' => $user->id,
                    'wallet_type' => $type,
                    'is_locked' => false,
                ]);
            }
        }

        return redirect()->route('admin.kyc.index')
            ->with('success', 'KYC approved and user upgraded to Wallet Verified status.');
    }

    public function reject(Request $request, Kyc $kyc)
    {
        $request->validate([
            'rejection_reason' => 'required|string|max:500',
        ]);

        $kyc->reject($request->rejection_reason);

        return redirect()->route('admin.kyc.index')
            ->with('success', 'KYC rejected.');
    }
}
