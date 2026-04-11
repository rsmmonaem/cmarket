<?php

namespace Modules\Admin\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Topup;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class TopupController extends Controller
{
    public function index()
    {
        $topups = Topup::with('user')->latest()->paginate(20);
        return view('admin::topup.index', compact('topups'));
    }

    public function create()
    {
        $users = \App\Models\User::whereDoesntHave('roles', function($q) {
            $q->whereIn('name', ['admin', 'super-admin']);
        })->select('id', 'name', 'email', 'phone')->get();
        
        return view('admin::topup.create', compact('users'));
    }

    public function directStore(Request $request)
    {
        $request->validate([
            'user_id' => 'required|exists:users,id',
            'amount' => 'required|numeric|min:1',
            'method' => 'required|string',
            'admin_note' => 'nullable|string|max:255',
        ]);

        DB::transaction(function () use ($request) {
            $user = \App\Models\User::findOrFail($request->user_id);
            $transaction_id = 'ADM-' . strtoupper(\Illuminate\Support\Str::random(10));

            $topup = Topup::create([
                'user_id' => $user->id,
                'amount' => $request->amount,
                'method' => $request->method,
                'transaction_id' => $transaction_id,
                'sender_number' => 'ADMIN',
                'status' => 'approved',
                'admin_note' => $request->admin_note ?? 'Direct top-up by admin',
                'approved_at' => now(),
                'approved_by' => auth()->id(),
            ]);

            // Credit the user's main wallet
            $wallet = $user->getWallet('main');
            if (!$wallet) {
                $wallet = \App\Models\Wallet::create([
                    'user_id' => $user->id,
                    'wallet_type' => 'main'
                ]);
            }
            
            $wallet->credit(
                $topup->amount, 
                $transaction_id, 
                'topup', 
                "Direct top-up by admin: " . ($request->admin_note ?? 'N/A')
            );
        });

        return redirect()->route('admin.topups.index')->with('success', 'Direct top-up successful! ✅');
    }

    public function approve(Request $request, Topup $topup)
    {
        if ($topup->status !== 'pending') {
            return back()->with('error', 'This request has already been processed.');
        }

        DB::transaction(function () use ($topup) {
            $topup->update([
                'status' => 'approved',
                'approved_at' => now(),
                'approved_by' => auth()->id(),
            ]);

            // Credit the user's main wallet
            $wallet = $topup->user->getWallet('main');
            if (!$wallet) {
                $wallet = \App\Models\Wallet::create([
                    'user_id' => $topup->user_id,
                    'wallet_type' => 'main'
                ]);
            }
            
            $wallet->credit(
                $topup->amount, 
                'TOPUP-' . $topup->transaction_id, 
                'topup', 
                "Manual top-up via {$topup->method}"
            );
        });

        return back()->with('success', 'Top-up request approved and wallet credited! ✅');
    }

    public function reject(Request $request, Topup $topup)
    {
        $request->validate(['admin_note' => 'required|string|max:255']);

        if ($topup->status !== 'pending') {
            return back()->with('error', 'This request has already been processed.');
        }

        $topup->update([
            'status' => 'rejected',
            'admin_note' => $request->admin_note,
        ]);

        return back()->with('success', 'Top-up request rejected.');
    }
}
