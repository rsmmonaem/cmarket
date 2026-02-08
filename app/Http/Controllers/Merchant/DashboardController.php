<?php

namespace App\Http\Controllers\Merchant;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\Category;
use App\Models\Order;
use App\Models\OrderItem;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class DashboardController extends Controller
{
    public function index()
    {
        $merchant = auth()->user()->merchant;
        
        if (!$merchant) {
            return redirect()->route('merchant.register')
                ->with('error', 'Please complete merchant registration first.');
        }

        if ($merchant->status !== 'approved') {
            return view('merchant.pending', compact('merchant'));
        }

        // Statistics
        $totalProducts = Product::where('merchant_id', $merchant->id)->count();
        $activeProducts = Product::where('merchant_id', $merchant->id)
            ->where('status', 'active')
            ->count();
        
        $totalOrders = OrderItem::where('merchant_id', $merchant->id)->count();
        $pendingOrders = OrderItem::where('merchant_id', $merchant->id)
            ->whereHas('order', function($q) {
                $q->where('status', 'pending');
            })
            ->count();
        
        $totalSales = OrderItem::where('merchant_id', $merchant->id)
            ->whereHas('order', function($q) {
                $q->where('status', 'delivered');
            })
            ->sum('subtotal');

        // Recent orders
        $recentOrders = OrderItem::where('merchant_id', $merchant->id)
            ->with(['order.user', 'product'])
            ->latest()
            ->take(10)
            ->get();

        return view('merchant.dashboard', compact(
            'merchant',
            'totalProducts',
            'activeProducts',
            'totalOrders',
            'pendingOrders',
            'totalSales',
            'recentOrders'
        ));
    }
}
