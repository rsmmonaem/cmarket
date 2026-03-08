<?php

namespace Modules\Admin\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Order;
use Illuminate\Http\Request;

class RefundController extends Controller
{
    public function index(Request $request)
    {
        $status = $request->get('status', 'pending');
        
        // Filter: returned orders act as refund requests
        $orders = Order::where('status', 'returned')
            ->with(['user', 'items'])
            ->latest()
            ->paginate(20);
            
        return view('admin::refunds.index', compact('orders', 'status'));
    }
}
