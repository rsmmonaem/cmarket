<?php

namespace App\Http\Controllers\Rider;

use App\Http\Controllers\Controller;
use App\Models\Delivery;
use App\Models\Order;
use App\Models\Wallet;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        $rider = auth()->user()->rider;
        
        if (!$rider) {
            return redirect()->route('rider.register')
                ->with('error', 'Please complete rider registration first.');
        }

        if ($rider->status !== 'approved') {
            return view('rider.pending', compact('rider'));
        }

        // Statistics
        $totalDeliveries = Delivery::where('rider_id', $rider->id)->count();
        $completedDeliveries = Delivery::where('rider_id', $rider->id)
            ->where('status', 'delivered')
            ->count();
        $pendingDeliveries = Delivery::where('rider_id', $rider->id)
            ->whereIn('status', ['assigned', 'picked_up'])
            ->count();
        
        $totalEarnings = Delivery::where('rider_id', $rider->id)
            ->where('status', 'delivered')
            ->sum('delivery_fee');

        $riderWallet = Wallet::where('user_id', auth()->id())
            ->where('wallet_type', 'rider')
            ->first();

        // Recent deliveries
        $recentDeliveries = Delivery::where('rider_id', $rider->id)
            ->with('order.user')
            ->latest()
            ->take(10)
            ->get();

        return view('rider.dashboard', compact(
            'rider',
            'totalDeliveries',
            'completedDeliveries',
            'pendingDeliveries',
            'totalEarnings',
            'riderWallet',
            'recentDeliveries'
        ));
    }
}
