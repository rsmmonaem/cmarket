<?php

namespace App\Http\Controllers;

use App\Models\Wallet;
use App\Models\WalletLedger;
use Illuminate\Http\Request;

class WalletController extends Controller
{
    public function index()
    {
        $user = auth()->user();
        
        $wallets = Wallet::where('user_id', $user->id)
            ->with(['ledgers' => function($query) {
                $query->latest()->take(10);
            }])
            ->get();

        return view('wallet.index', compact('wallets'));
    }
}
