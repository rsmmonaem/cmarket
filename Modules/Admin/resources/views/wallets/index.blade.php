@extends('layouts.admin')

@section('title', 'Financial Controller - CMarket')
@section('page-title', 'Global Wallet Infrastructure')

@section('content')
<div class="space-y-10 animate-fade-in">
    <!-- Macro Summary -->
    <div class="bg-white dark:bg-slate-900 rounded-[2.5rem] md:rounded-[3rem] p-6 md:p-10 lg:p-12 border border-slate-100 dark:border-slate-800 shadow-sm flex flex-col lg:flex-row justify-between items-center gap-8 md:gap-10 overflow-hidden relative group">
        <div class="relative z-10 w-full lg:w-auto text-center lg:text-left">
            <h2 class="text-2xl md:text-3xl font-black text-slate-800 dark:text-white tracking-tight leading-none mb-3 md:mb-4">Internal Ledger</h2>
            <p class="text-slate-400 dark:text-slate-500 font-bold text-[9px] md:text-[10px] uppercase tracking-[0.2em] ml-1">Managing {{ $wallets->total() }} Financial Nodes</p>
        </div>
        
        <div class="w-full lg:w-auto relative z-10">
            <form method="GET" class="flex flex-col sm:flex-row gap-4">
                <div class="flex-1 relative">
                    <input type="text" name="search" placeholder="Search identity..." value="{{ request('search') }}"
                           class="w-full h-14 md:h-16 bg-slate-50 dark:bg-slate-800 border-none rounded-2xl px-6 text-xs font-black text-slate-800 dark:text-white focus:ring-2 focus:ring-sky-500/20 transition-all placeholder:text-slate-300 dark:placeholder:text-slate-600">
                </div>
                <select name="wallet_type" class="h-14 md:h-16 bg-slate-50 dark:bg-slate-800 border-none rounded-2xl px-6 text-xs font-black text-slate-800 dark:text-white focus:ring-2 focus:ring-sky-500/20 transition-all">
                    <option value="">All Types</option>
                    <option value="main" {{ request('wallet_type') == 'main' ? 'selected' : '' }}>Main</option>
                    <option value="cashback" {{ request('wallet_type') == 'cashback' ? 'selected' : '' }}>Cashback</option>
                    <option value="commission" {{ request('wallet_type') == 'commission' ? 'selected' : '' }}>Commission</option>
                    <option value="shop" {{ request('wallet_type') == 'shop' ? 'selected' : '' }}>Shop</option>
                </select>
                <button type="submit" class="h-14 md:h-16 px-8 bg-slate-900 dark:bg-sky-600 text-white rounded-2xl font-black text-[10px] uppercase tracking-widest hover:bg-sky-600 transition-all active:scale-95 shadow-lg shadow-slate-900/10">
                    Audit
                </button>
            </form>
        </div>
        <!-- Decor -->
        <div class="absolute -right-10 -bottom-10 opacity-[0.03] text-[150px] md:text-[200px] leading-none select-none italic font-black group-hover:scale-110 transition-transform duration-1000 dark:text-white">LEDGER</div>
    </div>

    <!-- Data Infrastructure Table -->
    <div class="bg-white dark:bg-slate-900 rounded-[2.5rem] md:rounded-[3rem] border border-slate-100 dark:border-slate-800 shadow-sm overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse min-w-[900px]">
                <thead>
                    <tr class="bg-slate-50/50 dark:bg-slate-800/50">
                        <th class="px-10 py-6 text-[10px] font-black uppercase tracking-[0.2em] text-slate-400 dark:text-slate-500">Reservoir Node</th>
                        <th class="px-10 py-6 text-[10px] font-black uppercase tracking-[0.2em] text-slate-400 dark:text-slate-500">Class</th>
                        <th class="px-10 py-6 text-[10px] font-black uppercase tracking-[0.2em] text-slate-400 dark:text-slate-500 text-center">Liquidity Level</th>
                        <th class="px-10 py-6 text-[10px] font-black uppercase tracking-[0.2em] text-slate-400 dark:text-slate-500 text-center">Protocol Status</th>
                        <th class="px-10 py-6 text-[10px] font-black uppercase tracking-[0.2em] text-slate-400 dark:text-slate-500 text-right">Operations</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-50 dark:divide-slate-800">
                    @forelse($wallets as $wallet)
                        <tr class="group hover:bg-slate-50/80 transition-all duration-300">
                            <td class="px-10 py-8">
                                <div class="flex items-center gap-6">
                                    <div class="w-12 h-12 rounded-2xl bg-slate-900 dark:bg-slate-800 border border-slate-100 dark:border-slate-700 flex items-center justify-center text-white font-black text-sm shadow-lg group-hover:scale-110 transition-transform">
                                        {{ substr($wallet->user->name, 0, 1) }}
                                    </div>
                                    <div>
                                        <div class="text-sm font-black text-slate-800 dark:text-white mb-1">{{ $wallet->user->name }}</div>
                                        <div class="text-[9px] text-slate-400 dark:text-slate-500 font-black uppercase tracking-widest">{{ $wallet->user->phone }}</div>
                                    </div>
                                </div>
                            </td>
                            <td class="px-10 py-8">
                                <span class="px-3 py-1 rounded-lg bg-slate-50 dark:bg-slate-800 border border-slate-100 dark:border-slate-700 text-[8px] font-black text-slate-500 dark:text-slate-400 uppercase tracking-widest">
                                    {{ $wallet->wallet_type }}
                                </span>
                            </td>
                            <td class="px-10 py-8 text-center">
                                <div class="text-lg font-black text-slate-900 dark:text-white leading-none">৳{{ number_format($wallet->balance, 2) }}</div>
                                <div class="text-[8px] font-bold text-slate-400 dark:text-slate-500 uppercase mt-1 tracking-tighter">Updated {{ $wallet->updated_at->diffForHumans() }}</div>
                            </td>
                            <td class="px-10 py-8 text-center">
                                @if($wallet->is_locked)
                                    <span class="inline-flex items-center gap-2 py-2 px-4 rounded-xl text-[9px] font-black bg-rose-50 text-rose-600 border border-rose-100">
                                        LOCKED
                                    </span>
                                @else
                                    <span class="inline-flex items-center gap-2 py-2 px-4 rounded-xl text-[9px] font-black bg-emerald-50 text-emerald-600 border border-emerald-100">
                                        ACTIVE
                                    </span>
                                @endif
                            </td>
                            <td class="px-10 py-8 text-right">
                                <div class="flex justify-end opacity-0 group-hover:opacity-100 transition-opacity translate-x-4 group-hover:translate-x-0 duration-300">
                                    <a href="{{ route('admin.wallets.show', $wallet) }}" class="w-12 h-12 rounded-2xl bg-slate-900 text-white flex items-center justify-center text-xl hover:bg-sky-500 transition-all shadow-xl shadow-slate-900/20">
                                        ⚖️
                                    </a>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="px-10 py-32 text-center text-slate-300 flex flex-col items-center">
                                <span class="text-8xl mb-6 opacity-10">💰</span>
                                <p class="text-lg font-black uppercase tracking-[0.2em]">Liquidity Void</p>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if($wallets->hasPages())
            <div class="p-6 md:p-10 border-t border-slate-50 dark:border-slate-800 bg-slate-50/30 dark:bg-slate-800/30">
                {{ $wallets->links() }}
            </div>
        @endif
    </div>
</div>
@endsection
