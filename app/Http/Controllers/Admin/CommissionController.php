<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Commission;
use Illuminate\Http\Request;

class CommissionController extends Controller
{
    public function index()
    {
        $commissions = Commission::with(['user', 'sourceUser', 'order'])->latest()->paginate(20);
        return view('admin.commissions.index', compact('commissions'));
    }

    public function show(Commission $commission)
    {
        $commission->load(['user', 'sourceUser', 'order']);
        return view('admin.commissions.show', compact('commission'));
    }

    public function approve(Commission $commission)
    {
        $commission->update([
            'status' => 'approved',
            'approved_at' => now(),
        ]);

        // Credit commission wallet
        $wallet = $commission->user->getWallet('commission');
        if ($wallet) {
            $wallet->credit(
                $commission->commission_amount,
                'COMMISSION-' . $commission->id,
                'commission',
                "Level {$commission->level} commission from order #{$commission->order_id}"
            );
        }

        return redirect()->route('admin.commissions.index')
            ->with('success', 'Commission approved and credited.');
    }

    public function reject(Commission $commission)
    {
        $commission->update(['status' => 'rejected']);

        return redirect()->route('admin.commissions.index')
            ->with('success', 'Commission rejected.');
    }

    public function bulkApprove(Request $request)
    {
        $request->validate([
            'commission_ids' => 'required|array',
            'commission_ids.*' => 'exists:commissions,id',
        ]);

        foreach ($request->commission_ids as $id) {
            $commission = Commission::find($id);
            if ($commission && $commission->status === 'pending') {
                $this->approve($commission);
            }
        }

        return redirect()->route('admin.commissions.index')
            ->with('success', 'Selected commissions approved.');
    }
}
