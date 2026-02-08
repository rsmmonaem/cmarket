<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\Wallet;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        $user = auth()->user();
        
        $wallets = [
            'main' => $user->getWallet('main'),
            'cashback' => $user->getWallet('cashback'),
            'commission' => $user->getWallet('commission'),
        ];

        $stats = [
            'total_orders' => Order::where('user_id', $user->id)->count(),
            'pending_orders' => Order::where('user_id', $user->id)->where('status', 'pending')->count(),
            'total_spent' => Order::where('user_id', $user->id)->where('status', 'delivered')->sum('total_amount'),
        ];

        $recent_orders = Order::where('user_id', $user->id)
            ->with(['merchant', 'items'])
            ->latest()
            ->limit(5)
            ->get();

        return view('customer.dashboard', compact('wallets', 'stats', 'recent_orders'));
    }
}
