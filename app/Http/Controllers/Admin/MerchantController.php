<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Merchant;
use Illuminate\Http\Request;

class MerchantController extends Controller
{
    public function index()
    {
        $merchants = Merchant::with('user')->latest()->paginate(20);
        return view('admin.merchants.index', compact('merchants'));
    }

    public function show(Merchant $merchant)
    {
        $merchant->load(['user', 'products', 'orders']);
        return view('admin.merchants.show', compact('merchant'));
    }

    public function approve(Merchant $merchant)
    {
        $merchant->update([
            'status' => 'approved',
            'approved_at' => now(),
        ]);

        // Update user status
        $merchant->user->update(['status' => 'vendor']);

        // Create shop wallet if not exists
        if (!$merchant->user->hasWallet('shop')) {
            \App\Models\Wallet::create([
                'user_id' => $merchant->user->id,
                'wallet_type' => 'shop',
                'is_locked' => false,
            ]);
        }

        return redirect()->route('admin.merchants.index')
            ->with('success', 'Merchant approved successfully.');
    }

    public function reject(Merchant $merchant)
    {
        $merchant->update(['status' => 'rejected']);

        return redirect()->route('admin.merchants.index')
            ->with('success', 'Merchant rejected.');
    }

    public function suspend(Merchant $merchant)
    {
        $merchant->update(['status' => 'suspended']);
        $merchant->user->update(['status' => 'suspended']);

        return redirect()->route('admin.merchants.index')
            ->with('success', 'Merchant suspended.');
    }
}
