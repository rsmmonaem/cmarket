<?php

namespace Modules\Ecommerce\Http\Controllers;

use App\Http\Controllers\Controller;

use App\Models\ChainShop;
use App\Models\SharePurchase;
use App\Models\Wallet;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class InvestmentController extends Controller
{
    /**
     * Show investment marketplace
     */
    public function index()
    {
        $shops = ChainShop::active()->get();
        return view('ecommerce::investments.index', compact('shops'));
    }

    /**
     * Show specific shop details and purchase form
     */
    public function show(ChainShop $shop)
    {
        return view('ecommerce::investments.show', compact('shop'));
    }

    /**
     * Complete share purchase using wallet balance
     */
    public function purchase(Request $request, ChainShop $shop)
    {
        $request->validate([
            'shares' => 'required|integer|min:1',
        ]);

        $user = auth()->user();
        $shares = $request->shares;

        if ($shop->available_shares < $shares) {
            return redirect()->back()->with('error', 'Not enough shares available.');
        }

        $totalCost = $shares * $shop->share_price;
        $mainWallet = $user->getWallet('main');

        if (!$mainWallet || $mainWallet->balance < $totalCost) {
            return redirect()->back()->with('error', 'Insufficient main wallet balance.');
        }

        return DB::transaction(function () use ($user, $shop, $shares, $totalCost, $mainWallet) {
            $ref = 'SHR-' . strtoupper(uniqid());

            // Deduct from wallet
            $mainWallet->debit($totalCost, $ref, 'share_purchase', "Purchased {$shares} shares in {$shop->name}");

            // Create share purchase record
            SharePurchase::create([
                'user_id' => $user->id,
                'chain_shop_id' => $shop->id,
                'shares' => $shares,
                'price_per_share' => $shop->share_price,
                'total_amount' => $totalCost,
                'transaction_reference' => $ref
            ]);

            // Update available shares
            $shop->decrement('available_shares', $shares);

            return redirect()->route('investments.my-shares')
                ->with('success', "Success! You have purchased {$shares} shares in {$shop->name}.");
        });
    }

    /**
     * View user's share portfolio
     */
    public function myShares()
    {
        $purchases = SharePurchase::where('user_id', auth()->id())
            ->with('chainShop')
            ->latest()
            ->get();
            
        return view('ecommerce::investments.my-shares', compact('purchases'));
    }
}
