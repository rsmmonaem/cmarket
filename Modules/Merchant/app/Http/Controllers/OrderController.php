<?php

namespace Modules\Merchant\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\OrderItem;
use App\Models\Order;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    public function index(Request $request)
    {
        $merchant = auth()->user()->merchant;
        
        $query = OrderItem::where('merchant_id', $merchant->id)
            ->with(['order.user', 'product']);

        // Filter by status
        if ($request->has('status') && $request->status !== 'all') {
            $query->whereHas('order', function($q) use ($request) {
                $q->where('status', $request->status);
            });
        }

        $orders = $query->latest()->paginate(20);

        return view('merchant.orders.index', compact('orders'));
    }

    public function show($orderId)
    {
        $merchant = auth()->user()->merchant;
        
        $order = Order::with(['user', 'items' => function($q) use ($merchant) {
            $q->where('merchant_id', $merchant->id);
        }, 'items.product'])->findOrFail($orderId);

        // Ensure merchant has items in this order
        if ($order->items->isEmpty()) {
            abort(403);
        }

        return view('merchant.orders.show', compact('order'));
    }
}
