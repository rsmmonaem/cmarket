@extends('layouts.admin')
@section('title', 'Finance Report')
@section('page-title', 'Finance Report')

@section('content')
<div class="space-y-6">
    <div class="bg-white dark:bg-slate-900 rounded-3xl border border-slate-100 dark:border-slate-800 overflow-hidden shadow-sm">
        <div class="px-8 py-5 border-b border-slate-50 dark:border-slate-800 flex items-center justify-between">
            <h4 class="text-[10px] font-black uppercase tracking-[0.2em] text-slate-400">Wallet Balances</h4>
            <span class="text-[10px] font-black text-primary uppercase">{{ $wallets->total() }} wallets</span>
        </div>
        <table class="w-full text-left">
            <thead><tr class="bg-slate-50 dark:bg-slate-800/50">
                <th class="px-8 py-4 text-[10px] font-black uppercase tracking-widest text-slate-400">User</th>
                <th class="px-8 py-4 text-[10px] font-black uppercase tracking-widest text-slate-400">Type</th>
                <th class="px-8 py-4 text-[10px] font-black uppercase tracking-widest text-slate-400 text-right">Balance</th>
                <th class="px-8 py-4 text-[10px] font-black uppercase tracking-widest text-slate-400">Status</th>
                <th class="px-8 py-4 text-right text-[10px] font-black uppercase tracking-widest text-slate-400">Action</th>
            </tr></thead>
            <tbody class="divide-y divide-slate-50 dark:divide-slate-800">
                @forelse($wallets as $wallet)
                <tr class="hover:bg-slate-50/50 dark:hover:bg-slate-800/30 transition-colors">
                    <td class="px-8 py-4">
                        <div class="text-sm font-black text-slate-800 dark:text-white uppercase">{{ $wallet->user->name }}</div>
                        <div class="text-[10px] text-slate-400">{{ $wallet->user->email }}</div>
                    </td>
                    <td class="px-8 py-4">
                        <span class="px-3 py-1 bg-primary/10 text-primary rounded-full text-[10px] font-black uppercase">{{ $wallet->wallet_type ?? 'Main' }}</span>
                    </td>
                    <td class="px-8 py-4 text-right text-sm font-black text-emerald-600">৳{{ number_format($wallet->balance, 2) }}</td>
                    <td class="px-8 py-4">
                        <span class="px-3 py-1 rounded-full text-[10px] font-black {{ $wallet->is_locked ? 'bg-rose-50 text-rose-600' : 'bg-emerald-50 text-emerald-600' }}">{{ $wallet->is_locked ? 'Locked' : 'Active' }}</span>
                    </td>
                    <td class="px-8 py-4 text-right">
                        <a href="{{ route('admin.wallets.show', $wallet) }}" class="px-4 py-2 text-[10px] font-black uppercase bg-slate-100 hover:bg-primary hover:text-white rounded-xl transition-all">Manage</a>
                    </td>
                </tr>
                @empty
                <tr><td colspan="5" class="px-8 py-16 text-center text-sm text-slate-400 font-bold">No financial data available.</td></tr>
                @endforelse
            </tbody>
        </table>
        <div class="p-8 border-t border-slate-50 dark:border-slate-800">{{ $wallets->links() }}</div>
    </div>
</div>
@endsection
