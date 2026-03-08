<?php

namespace Modules\Admin\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Withdrawal;
use Illuminate\Http\Request;

class WithdrawalController extends Controller
{
    public function index()
    {
        $withdrawals = Withdrawal::with(['wallet.user'])->latest()->paginate(20);
        
        $stats = [
            'pending' => Withdrawal::where('status', 'pending')->count(),
            'approved' => Withdrawal::where('status', 'approved')->count(),
            'rejected' => Withdrawal::where('status', 'rejected')->count(),
            'total_disbursed' => Withdrawal::whereIn('status', ['approved', 'completed'])->sum('amount'),
        ];

        return view('admin::withdrawals.index', compact('withdrawals', 'stats'));
    }

    public function show(Withdrawal $withdrawal)
    {
        $withdrawal->load('wallet.user');
        return view('admin::withdrawals.show', compact('withdrawal'));
    }

    public function approve(Request $request, Withdrawal $withdrawal)
    {
        $request->validate([
            'admin_note' => 'nullable|string|max:500',
        ]);

        $withdrawal->update([
            'status' => 'approved',
            'admin_note' => $request->admin_note,
            'approved_at' => now(),
        ]);

        // Debit from wallet
        try {
            $withdrawal->wallet->debit(
                $withdrawal->amount,
                'WITHDRAWAL-' . $withdrawal->id,
                'withdrawal',
                'Withdrawal approved'
            );

            $withdrawal->update([
                'status'       => 'completed',
                'completed_at' => now(),
            ]);

            // Notify user by email
            try {
                \Illuminate\Support\Facades\Mail::queue(
                    new \App\Mail\WithdrawalApproved($withdrawal)
                );
            } catch (\Exception $e) { /* Mail queuing failed silently */ }

            return redirect()->route('admin.withdrawals.index')
                ->with('success', 'Withdrawal approved and processed successfully.');
        } catch (\Exception $e) {
            return back()->withErrors(['error' => $e->getMessage()]);
        }
    }

    public function reject(Request $request, Withdrawal $withdrawal)
    {
        $request->validate([
            'admin_note' => 'required|string|max:500',
        ]);

        $withdrawal->update([
            'status' => 'rejected',
            'admin_note' => $request->admin_note,
        ]);

        return redirect()->route('admin.withdrawals.index')
            ->with('success', 'Withdrawal rejected.');
    }
}
