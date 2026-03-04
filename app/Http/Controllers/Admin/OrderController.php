<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Services\PackageActivationService;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    protected $packageService;
    protected $commissionService;

    public function __construct(PackageActivationService $packageService, \App\Services\CommissionService $commissionService)
    {
        $this->packageService = $packageService;
        $this->commissionService = $commissionService;
    }
    public function index()
    {
        $orders = Order::with(['user', 'merchant', 'items'])->latest()->paginate(20);
        return view('admin.orders.index', compact('orders'));
    }

    public function show(Order $order)
    {
        $order->load(['user', 'merchant', 'items.product', 'delivery']);
        return view('admin.orders.show', compact('order'));
    }

    public function updateStatus(Request $request, Order $order)
    {
        $request->validate([
            'status' => 'required|in:pending,paid,processing,shipped,delivered,cancelled',
            'admin_note' => 'nullable|string|max:500',
        ]);

        $oldStatus = $order->status;
        $order->update([
            'status' => $request->status,
            'admin_note' => $request->admin_note,
        ]);

        if ($request->status === 'delivered') {
            $order->update(['delivered_at' => now()]);
            $this->commissionService->distribute($order);
        }

        // If order updated to 'paid' manually, trigger package activation logic
        if ($oldStatus !== 'paid' && $request->status === 'paid') {
            $order->update(['paid_at' => now()]);
            $this->packageService->activate($order);
        }

        return redirect()->route('admin.orders.show', $order)
            ->with('success', 'Order status and notes updated successfully.');
    }

    public function cancel(Order $order)
    {
        $order->update(['status' => 'cancelled']);
        
        return redirect()->route('admin.orders.index')
            ->with('success', 'Order cancelled successfully.');
    }
}
