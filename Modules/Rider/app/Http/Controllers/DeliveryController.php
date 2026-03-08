<?php

namespace Modules\Rider\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Delivery;
use App\Models\Wallet;
use App\Models\WalletLedger;
use Illuminate\Http\Request;

class DeliveryController extends Controller
{
    public function index(Request $request)
    {
        $rider = auth()->user()->rider;
        
        $query = Delivery::where('rider_id', $rider->id)
            ->with('order.user');

        // Filter by status
        if ($request->has('status') && $request->status !== 'all') {
            $query->where('status', $request->status);
        }

        $deliveries = $query->latest()->paginate(20);

        return view('rider.deliveries.index', compact('deliveries'));
    }

    public function show(Delivery $delivery)
    {
        // Ensure rider can only view their own deliveries
        if ($delivery->rider_id !== auth()->user()->rider->id) {
            abort(403);
        }

        $delivery->load('order.user', 'order.items.product');

        return view('rider.deliveries.show', compact('delivery'));
    }

    public function updateStatus(Request $request, Delivery $delivery)
    {
        // Ensure rider can only update their own deliveries
        if ($delivery->rider_id !== auth()->user()->rider->id) {
            abort(403);
        }

        $request->validate([
            'status' => 'required|in:picked_up,in_transit,delivered,failed',
        ]);

        $delivery->update([
            'status' => $request->status,
            'delivered_at' => $request->status === 'delivered' ? now() : null,
        ]);

        // If delivered, credit delivery fee to rider wallet
        if ($request->status === 'delivered') {
            $riderWallet = Wallet::where('user_id', auth()->id())
                ->where('wallet_type', 'rider')
                ->first();

            if ($riderWallet) {
                WalletLedger::create([
                    'wallet_id' => $riderWallet->id,
                    'type' => 'credit',
                    'amount' => $delivery->delivery_fee,
                    'description' => "Delivery fee for order #{$delivery->order->order_number}",
                    'reference_type' => 'delivery',
                    'reference_id' => $delivery->id,
                ]);
            }

            // Update order status
            $delivery->order->update(['status' => 'delivered']);
        }

        return redirect()->back()->with('success', 'Delivery status updated successfully!');
    }
}
