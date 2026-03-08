<?php

namespace Modules\Admin\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Rider;
use Illuminate\Http\Request;

class RiderController extends Controller
{
    public function index()
    {
        $riders = Rider::with('user')->latest()->paginate(20);
        return view('admin::riders.index', compact('riders'));
    }

    public function show(Rider $rider)
    {
        $rider->load(['user', 'deliveries']);
        return view('admin::riders.show', compact('rider'));
    }

    public function approve(Rider $rider)
    {
        $rider->update([
            'status' => 'approved',
            'approved_at' => now(),
        ]);

        // Update user status
        $rider->user->update(['status' => 'rider']);

        // Create rider wallet if not exists
        if (!$rider->user->hasWallet('rider')) {
            \App\Models\Wallet::create([
                'user_id' => $rider->user->id,
                'wallet_type' => 'rider',
                'is_locked' => false,
            ]);
        }

        return redirect()->route('admin.riders.index')
            ->with('success', 'Rider approved successfully.');
    }

    public function reject(Rider $rider)
    {
        $rider->update(['status' => 'rejected']);

        return redirect()->route('admin.riders.index')
            ->with('success', 'Rider rejected.');
    }

    public function suspend(Rider $rider)
    {
        $rider->update(['status' => 'suspended']);
        $rider->user->update(['status' => 'suspended']);

        return redirect()->route('admin.riders.index')
            ->with('success', 'Rider suspended.');
    }
}
