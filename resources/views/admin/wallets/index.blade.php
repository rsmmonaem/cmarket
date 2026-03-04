@extends('layouts.admin')

@section('title', 'Wallet Management')
@section('page-title', 'Wallet Management')

@section('content')
<x-admin.card>
    <div class="flex flex-col lg:flex-row justify-between items-start lg:items-center gap-6 mb-8">
        <div>
            <h2 class="text-xl font-black text-light">Financial Directory</h2>
            <p class="text-xs text-muted-light font-bold uppercase tracking-widest">Audit and manage user digital wallets</p>
        </div>
        <form method="GET" class="flex flex-wrap gap-3 w-full lg:w-auto">
            <input type="text" name="search" placeholder="User name or phone..." value="{{ request('search') }}"
                   class="px-4 py-2.5 bg-slate-50 dark:bg-slate-800 border border-slate-200 dark:border-slate-700 rounded-xl text-xs font-bold focus:outline-none focus:ring-2 focus:ring-sky-500 transition">
            <select name="wallet_type" class="px-4 py-2.5 bg-slate-50 dark:bg-slate-800 border border-slate-200 dark:border-slate-700 rounded-xl text-xs font-bold focus:outline-none focus:ring-2 focus:ring-sky-500 transition">
                <option value="">All Types</option>
                <option value="main">Main</option>
                <option value="cashback">Cashback</option>
                <option value="commission">Commission</option>
                <option value="shop">Shop</option>
            </select>
            <x-admin.button type="submit" variant="secondary">🔍</x-admin.button>
        </form>
    </div>

    <div class="overflow-x-auto -mx-6">
        <table class="w-full text-left border-collapse">
            <thead>
                <tr class="border-b border-light">
                    <th class="px-6 py-4 text-[10px] font-black uppercase tracking-widest text-muted-light">Account Holder</th>
                    <th class="px-6 py-4 text-[10px] font-black uppercase tracking-widest text-muted-light">Wallet Type</th>
                    <th class="px-6 py-4 text-[10px] font-black uppercase tracking-widest text-muted-light">Current Balance</th>
                    <th class="px-6 py-4 text-[10px] font-black uppercase tracking-widest text-muted-light">Security Status</th>
                    <th class="px-6 py-4 text-[10px] font-black uppercase tracking-widest text-muted-light">Last Activity</th>
                    <th class="px-6 py-4 text-[10px] font-black uppercase tracking-widest text-muted-light text-right">Action</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-light">
                @forelse($wallets as $wallet)
                    <tr class="group hover:bg-slate-50 dark:hover:bg-slate-800/50 transition-colors">
                        <td class="px-6 py-4">
                            <div class="text-sm font-black text-light">{{ $wallet->user->name }}</div>
                            <div class="text-[10px] text-muted-light font-bold uppercase tracking-tighter">{{ $wallet->user->phone }}</div>
                        </td>
                        <td class="px-6 py-4">
                            <span class="px-2 py-0.5 rounded-lg bg-slate-100 dark:bg-slate-800 text-[10px] font-black text-light border border-light uppercase">
                                {{ $wallet->wallet_type }}
                            </span>
                        </td>
                        <td class="px-6 py-4">
                            <div class="text-lg font-black text-light">৳{{ number_format($wallet->balance, 2) }}</div>
                        </td>
                        <td class="px-6 py-4">
                            @if($wallet->is_locked)
                                <span class="inline-flex items-center gap-1.5 py-1.5 px-3 rounded-full text-[10px] font-black bg-red-100 text-red-700 dark:bg-red-900/40 dark:text-red-400">
                                    <span class="w-1.5 h-1.5 rounded-full bg-red-500"></span> LOCKED
                                </span>
                            @else
                                <span class="inline-flex items-center gap-1.5 py-1.5 px-3 rounded-full text-[10px] font-black bg-emerald-100 text-emerald-700 dark:bg-emerald-900/40 dark:text-emerald-400">
                                    <span class="w-1.5 h-1.5 rounded-full bg-emerald-500"></span> ACTIVE
                                </span>
                            @endif
                        </td>
                        <td class="px-6 py-4 text-xs font-bold text-muted-light">
                            {{ $wallet->updated_at->diffForHumans() }}
                        </td>
                        <td class="px-6 py-4 text-right">
                            <a href="{{ route('admin.wallets.show', $wallet) }}" class="p-2 rounded-xl bg-slate-100 dark:bg-slate-800 text-light hover:bg-slate-900 hover:text-white transition shadow-sm inline-block">
                                ⚖️
                            </a>
                        </td>
                    </tr>
                @empty
                    <tr><td colspan="6" class="px-6 py-12 text-center text-muted-light italic">No wallets found in directory.</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
    
    @if($wallets->hasPages())
        <div class="mt-8">{{ $wallets->links() }}</div>
    @endif
</x-admin.card>
@endsection
