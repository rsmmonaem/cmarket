<?php

namespace Modules\Ecommerce\Http\Controllers;

use App\Http\Controllers\Controller;

use App\Models\User;
use App\Models\Wallet;
use App\Models\WalletLedger;
use App\Services\WalletService;
use Illuminate\Http\Request;

class WalletController extends Controller
{
    protected $walletService;

    public function __construct(WalletService $walletService)
    {
        $this->walletService = $walletService;
    }

    public function index()
    {
        $user = auth()->user();
        
        $wallets = Wallet::where('user_id', $user->id)
            ->with(['ledgers' => function($query) {
                $query->latest()->limit(50);
            }])
            ->get();

        return view('wallet.index', compact('wallets', 'user'));
    }

    /**
     * Preview recipient name by phone
     */
    public function previewRecipient(Request $request)
    {
        $request->validate(['phone' => 'required|string']);
        
        $user = User::where('phone', $request->phone)->first();
        
        if (!$user) {
            return response()->json(['error' => 'User not found.'], 404);
        }

        return response()->json(['name' => $user->name]);
    }

    /**
     * Handle fund transfer
     */
    public function transfer(Request $request)
    {
        $request->validate([
            'phone' => 'required|string',
            'amount' => 'required|numeric|min:1',
            'wallet_type' => 'required|in:main,cashback,commission,shop,share',
            'description' => 'nullable|string|max:255',
        ]);

        try {
            $reference = $this->walletService->transfer(
                auth()->user(),
                $request->phone,
                $request->amount,
                $request->wallet_type,
                $request->description
            );

            return back()->with('success', "Transfer successful! Reference: {$reference}");
        } catch (\Exception $e) {
            return back()->with('error', $e->getMessage());
        }
    }
}
