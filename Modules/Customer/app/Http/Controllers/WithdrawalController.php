<?php

namespace Modules\Customer\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Withdrawal;
use App\Services\WalletService;
use Illuminate\Http\Request;

class WithdrawalController extends Controller
{
    protected $walletService;

    public function __construct(WalletService $walletService)
    {
        $this->walletService = $walletService;
    }

    public function index()
    {
        $user = auth()->user();
        $withdrawals = Withdrawal::whereHas('wallet', function($q) use ($user) {
                $q->where('user_id', $user->id);
            })
            ->latest()
            ->paginate(15);

        $wallets = $user->wallets()->whereIn('wallet_type', ['main', 'commission'])->get();

        return view('customer::withdrawals.index', compact('withdrawals', 'wallets'));
    }

    public function request(Request $request)
    {
        $request->validate([
            'wallet_type' => 'required|in:main,commission',
            'amount' => 'required|numeric|min:500', // Minimum withdrawal 500
            'method' => 'required|string|in:bkash,nagad,rocket,bank',
            'account_details' => 'required|array',
            'account_details.number' => 'required_unless:method,bank|string',
            'account_details.bank_name' => 'required_if:method,bank|string',
            'account_details.account_name' => 'required_if:method,bank|string',
            'account_details.account_number' => 'required_if:method,bank|string',
            'account_details.branch' => 'required_if:method,bank|string',
        ]);

        try {
            $this->walletService->requestWithdrawal(
                auth()->user(),
                $request->wallet_type,
                $request->amount,
                $request->method,
                $request->account_details
            );

            return back()->with('success', 'Withdrawal request submitted successfully! It will be processed within 24-48 hours.');
        } catch (\Exception $e) {
            return back()->with('error', $e->getMessage());
        }
    }
}
