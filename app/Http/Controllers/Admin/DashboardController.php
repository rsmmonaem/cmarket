<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Order;
use App\Models\Kyc;
use App\Models\Merchant;
use App\Models\Withdrawal;

class DashboardController extends Controller
{
    public function index()
    {
        $stats = [
            'total_users' => User::count(),
            'pending_kyc' => Kyc::where('status', 'pending')->count(),
            'total_orders' => Order::count(),
            'active_merchants' => Merchant::where('status', 'approved')->count(),
            'pending_withdrawals' => Withdrawal::where('status', 'pending')->count(),
            'total_revenue' => Order::where('status', 'delivered')->sum('total_amount'),
        ];

        $recent_orders = Order::with(['user', 'merchant'])
            ->latest()
            ->limit(10)
            ->get();

        $pending_kyc = Kyc::with('user')
            ->where('status', 'pending')
            ->latest()
            ->limit(5)
            ->get();

        $pending_merchants = Merchant::with('user')
            ->where('status', 'pending')
            ->latest()
            ->limit(5)
            ->get();

        $pending_withdrawals = Withdrawal::with('wallet.user')
            ->where('status', 'pending')
            ->latest()
            ->limit(5)
            ->get();

        return view('admin.dashboard', compact(
            'stats',
            'recent_orders',
            'pending_kyc',
            'pending_merchants',
            'pending_withdrawals'
        ));
    }
}
