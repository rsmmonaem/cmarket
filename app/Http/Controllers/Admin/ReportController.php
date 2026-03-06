<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\User;
use App\Models\Merchant;
use App\Models\Product;
use App\Models\Wallet;
use Illuminate\Http\Request;

class ReportController extends Controller
{
    public function sales()
    {
        $orders = Order::where('status', 'paid')->latest()->paginate(20);
        return view('admin.reports.sales', compact('orders'));
    }

    public function merchants()
    {
        $merchants = Merchant::withCount('products')->orderBy('products_count', 'desc')->paginate(20);
        return view('admin.reports.merchants', compact('merchants'));
    }

    public function financials()
    {
        $wallets = Wallet::with('user')->orderBy('balance', 'desc')->paginate(20);
        return view('admin.reports.financials', compact('wallets'));
    }
}
