<?php

namespace Modules\Ecommerce\Http\Controllers;

use App\Http\Controllers\Controller;

use App\Models\User;
use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class RegionalDashboardController extends Controller
{
    /**
     * Show the regional dashboard based on user role
     */
    public function index()
    {
        $user = Auth::user();
        $role = $user->getRoleNames()->first();
        
        // Scope data based on role
        $query = User::query();
        $orderQuery = Order::query();

        if ($role === 'upazila') {
            $query->where('upazila', $user->upazila);
            $orderQuery->whereHas('user', fn($q) => $q->where('upazila', $user->upazila));
        } elseif ($role === 'district') {
            $query->where('district', $user->district);
            $orderQuery->whereHas('user', fn($q) => $q->where('district', $user->district));
        } elseif ($role === 'division') {
            $query->where('division', $user->division);
            $orderQuery->whereHas('user', fn($q) => $q->where('division', $user->division));
        }

        $stats = [
            'total_users' => $query->count(),
            'total_orders' => $orderQuery->count(),
            'total_sales' => $orderQuery->where('status', 'delivered')->sum('total_amount'),
            'recent_users' => $query->latest()->take(5)->get(),
            'recent_orders' => $orderQuery->latest()->with('user')->take(5)->get(),
        ];

        return view('regional.dashboard', compact('stats', 'role'));
    }

    /**
     * View users in the region
     */
    public function users()
    {
        $user = Auth::user();
        $role = $user->getRoleNames()->first();
        
        $query = User::query();
        if ($role === 'upazila') $query->where('upazila', $user->upazila);
        elseif ($role === 'district') $query->where('district', $user->district);
        elseif ($role === 'division') $query->where('division', $user->division);

        $users = $query->latest()->paginate(20);
        return view('regional.users', compact('users', 'role'));
    }

    /**
     * View orders in the region
     */
    public function orders()
    {
        $user = Auth::user();
        $role = $user->getRoleNames()->first();
        
        $query = Order::query();
        if ($role === 'upazila') {
            $query->whereHas('user', fn($q) => $q->where('upazila', $user->upazila));
        } elseif ($role === 'district') {
            $query->whereHas('user', fn($q) => $q->where('district', $user->district));
        } elseif ($role === 'division') {
            $query->whereHas('user', fn($q) => $q->where('division', $user->division));
        }

        $orders = $query->latest()->with('user')->paginate(20);
        return view('regional.orders', compact('orders', 'role'));
    }
}
