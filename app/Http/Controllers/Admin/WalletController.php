<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Wallet;
use App\Models\User;
use Illuminate\Http\Request;

class WalletController extends Controller
{
    public function index()
    {
        $wallets = Wallet::with('user')->latest()->paginate(20);
        return view('admin.wallets.index', compact('wallets'));
    }

    public function show(Wallet $wallet)
    {
        $wallet->load(['user', 'ledgers' => function($query) {
            $query->latest()->limit(50);
        }]);
        return view('admin.wallets.show', compact('wallet'));
    }

    public function credit(Request $request, Wallet $wallet)
    {
        $request->validate([
            'amount' => 'required|numeric|min:0.01',
            'description' => 'required|string|max:255',
        ]);

        $wallet->credit(
            $request->amount,
            'ADMIN-CREDIT-' . time(),
            'admin_credit',
            $request->description
        );

        return redirect()->route('admin.wallets.show', $wallet)
            ->with('success', 'Wallet credited successfully.');
    }

    public function debit(Request $request, Wallet $wallet)
    {
        $request->validate([
            'amount' => 'required|numeric|min:0.01',
            'description' => 'required|string|max:255',
        ]);

        try {
            $wallet->debit(
                $request->amount,
                'ADMIN-DEBIT-' . time(),
                'admin_debit',
                $request->description
            );

            return redirect()->route('admin.wallets.show', $wallet)
                ->with('success', 'Wallet debited successfully.');
        } catch (\Exception $e) {
            return back()->withErrors(['amount' => $e->getMessage()]);
        }
    }

    public function lock(Wallet $wallet)
    {
        $wallet->lock();
        return redirect()->route('admin.wallets.show', $wallet)
            ->with('success', 'Wallet locked successfully.');
    }

    public function unlock(Wallet $wallet)
    {
        $wallet->unlock();
        return redirect()->route('admin.wallets.show', $wallet)
            ->with('success', 'Wallet unlocked successfully.');
    }
}
