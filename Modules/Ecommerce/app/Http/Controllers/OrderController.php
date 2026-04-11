<?php

namespace Modules\Ecommerce\Http\Controllers;

use App\Http\Controllers\Controller;

use App\Models\Order;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    public function index()
    {
        $orders = Order::where('user_id', auth()->id())
            ->with(['items.product'])
            ->latest()
            ->paginate(10);

        return view('ecommerce::orders.index', compact('orders'));
    }

    public function show(Order $order)
    {
        // Ensure user can only view their own orders
        if ($order->user_id !== auth()->id()) {
            abort(403);
        }

        $order->load(['items.product.merchant']);

        return view('ecommerce::orders.show', compact('order'));
    }

    public function trackForm()
    {
        return view('ecommerce::orders.track');
    }

    public function track(Request $request)
    {
        $request->validate([
            'order_number' => 'required|string',
            'phone' => 'required|string'
        ]);

        $order = Order::where('order_number', $request->order_number)
            ->where('shipping_phone', $request->phone)
            ->with(['items.product.merchant'])
            ->first();

        if (!$order) {
            return back()->with('error', 'No order found with these details.')->withInput();
        }

        return view('ecommerce::orders.show', compact('order'))->with('is_tracking', true);
    }
}
