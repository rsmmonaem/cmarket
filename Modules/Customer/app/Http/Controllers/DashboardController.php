<?php

namespace Modules\Customer\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\Wallet;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    protected $rankService;

    public function __construct(\App\Services\RankService $rankService)
    {
        $this->rankService = $rankService;
    }

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
            'team_size' => $this->rankService->getTeamSize($user),
        ];

        $nextRank = $this->rankService->getNextRank($user);

        $recent_orders = Order::where('user_id', $user->id)
            ->with(['merchant', 'items'])
            ->latest()
            ->limit(5)
            ->get();

        return view('customer::dashboard', compact('user', 'wallets', 'stats', 'recent_orders', 'nextRank'));
    }

    public function profile()
    {
        return view('customer::profile');
    }

    public function updateProfile(Request $request)
    {
        $user = auth()->user();
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $user->id,
            'phone' => 'required|string|unique:users,phone,' . $user->id,
            'address' => 'nullable|string|max:500',
            'avatar' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:2048',
        ]);

        $data = [
            'name' => $request->name,
            'email' => $request->email,
            'phone' => $request->phone,
            'address' => $request->address,
        ];

        if ($request->hasFile('avatar')) {
            $path = $request->file('avatar')->store('avatars', 'public');
            $data['avatar'] = $path;
        }

        $user->update($data);

        return redirect()->back()->with('success', 'Profile updated successfully! ✨');
    }

    public function settings()
    {
        return view('customer::settings');
    }

    public function updateSettings(Request $request)
    {
        $user = auth()->user();
        
        if ($request->has('password') && $request->password) {
            $request->validate([
                'password' => 'required|min:8|confirmed',
            ]);
            $user->update(['password' => bcrypt($request->password)]);
        }

        return redirect()->back()->with('success', 'Settings updated successfully!');
    }

    public function commissions()
    {
        $commissions = \App\Models\Commission::where('user_id', auth()->id())
            ->with(['sourceUser', 'order'])
            ->latest()
            ->paginate(15);
        return view('customer::commissions', compact('commissions'));
    }

    public function designation()
    {
        $user = auth()->user();
        // Assuming user has a relationship with designations
        return view('customer::designation', compact('user'));
    }
}
