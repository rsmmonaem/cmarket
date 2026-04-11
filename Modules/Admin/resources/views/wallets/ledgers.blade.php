@extends('layouts.admin')

@section('title', 'Financial Ledger - CMarket')
@section('page-title', 'Global Wallet Ledgers')

@section('content')
<div class="space-y-10 animate-fade-in">
    <!-- Header Summary -->
    <div class="bg-white dark:bg-slate-900 rounded-[2.5rem] md:rounded-[3rem] p-6 md:p-10 lg:p-12 border border-slate-100 dark:border-slate-800 shadow-sm flex flex-col lg:flex-row justify-between items-center gap-8 md:gap-10 overflow-hidden relative group">
        <div class="relative z-10 w-full lg:w-auto text-center lg:text-left">
            <h2 class="text-2xl md:text-3xl font-black text-slate-800 dark:text-white tracking-tight leading-none mb-3 md:mb-4">Global Audit Trail</h2>
            <p class="text-slate-400 dark:text-slate-500 font-bold text-[9px] md:text-[10px] uppercase tracking-[0.2em] ml-1">Universal Financial History of All Nodes</p>
        </div>
        
        <div class="w-full lg:w-auto relative z-10">
            <form method="GET" class="flex flex-col sm:flex-row gap-4">
                <div class="flex-1 relative">
                    <input type="text" name="search" placeholder="Ref, desc, or user..." value="{{ request('search') }}"
                           class="w-full h-14 md:h-16 bg-slate-50 dark:bg-slate-800 border-none rounded-2xl px-6 text-xs font-black text-slate-800 dark:text-white focus:ring-2 focus:ring-sky-500/20 transition-all placeholder:text-slate-300 dark:placeholder:text-slate-600">
                </div>
                <select name="type" class="h-14 md:h-16 bg-slate-50 dark:bg-slate-800 border-none rounded-2xl px-6 text-xs font-black text-slate-800 dark:text-white focus:ring-2 focus:ring-sky-500/20 transition-all">
                    <option value="">All Transactions</option>
                    <option value="commission" {{ request('type') == 'commission' ? 'selected' : '' }}>Commission</option>
                    <option value="order" {{ request('type') == 'order' ? 'selected' : '' }}>Orders</option>
                    <option value="withdrawal" {{ request('type') == 'withdrawal' ? 'selected' : '' }}>Withdrawals</option>
                    <option value="topup" {{ request('type') == 'topup' ? 'selected' : '' }}>Top-ups</option>
                    <option value="sale_income" {{ request('type') == 'sale_income' ? 'selected' : '' }}>Sales</option>
                </select>
                <button type="submit" class="h-14 md:h-16 px-8 bg-slate-900 dark:bg-sky-600 text-white rounded-2xl font-black text-[10px] uppercase tracking-widest hover:bg-sky-600 transition-all active:scale-95 shadow-lg shadow-slate-900/10">
                    Filter
                </button>
            </form>
        </div>
        <!-- Decor -->
        <div class="absolute -right-10 -bottom-10 opacity-[0.03] text-[150px] md:text-[200px] leading-none select-none italic font-black group-hover:scale-110 transition-transform duration-1000 dark:text-white">AUDIT</div>
    </div>

    <!-- Data Table -->
    <div class="bg-white dark:bg-slate-900 rounded-[2.5rem] md:rounded-[3rem] border border-slate-100 dark:border-slate-800 shadow-sm overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse min-w-[1000px]">
                <thead>
                    <tr class="bg-slate-50/50 dark:bg-slate-800/50">
                        <th class="px-8 py-6 text-[10px] font-black uppercase tracking-[0.2em] text-slate-400 dark:text-slate-500">Transaction Date</th>
                        <th class="px-8 py-6 text-[10px] font-black uppercase tracking-[0.2em] text-slate-400 dark:text-slate-500">Node / Holder</th>
                        <th class="px-8 py-6 text-[10px] font-black uppercase tracking-[0.2em] text-slate-400 dark:text-slate-500">Source / Reference</th>
                        <th class="px-8 py-6 text-[10px] font-black uppercase tracking-[0.2em] text-slate-400 dark:text-slate-500">Method</th>
                        <th class="px-8 py-6 text-[10px] font-black uppercase tracking-[0.2em] text-slate-400 dark:text-slate-500 text-center">Inflow</th>
                        <th class="px-8 py-6 text-[10px] font-black uppercase tracking-[0.2em] text-slate-400 dark:text-slate-500 text-center">Outflow</th>
                        <th class="px-8 py-6 text-[10px] font-black uppercase tracking-[0.2em] text-slate-400 dark:text-slate-500 text-right">Node Balance</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-50 dark:divide-slate-800">
                    @forelse($ledgers as $ledger)
                        <tr class="group hover:bg-slate-50/50 transition-all duration-300">
                            <td class="px-8 py-6">
                                <div class="text-[10px] font-black text-slate-800 dark:text-white uppercase leading-none">{{ $ledger->created_at->format('d M, Y') }}</div>
                                <div class="text-[9px] text-slate-400 dark:text-slate-500 font-bold mt-1">{{ $ledger->created_at->format('h:i A') }}</div>
                            </td>
                            <td class="px-8 py-6 text-sm font-black text-slate-800 dark:text-white">
                                <div class="flex items-center gap-3">
                                    <div class="w-8 h-8 rounded-lg bg-slate-100 dark:bg-slate-800 border border-slate-50 dark:border-slate-700 flex items-center justify-center text-[10px] font-black text-slate-400">
                                        {{ substr($ledger->wallet->user->name, 0, 1) }}
                                    </div>
                                    <div>
                                        <p class="text-xs leading-none mb-1">{{ $ledger->wallet->user->name }}</p>
                                        <p class="text-[8px] text-slate-400 dark:text-slate-500 uppercase tracking-widest font-bold">{{ $ledger->wallet->wallet_type }}</p>
                                    </div>
                                </div>
                            </td>
                            <td class="px-8 py-6 font-bold text-slate-500 dark:text-slate-400">
                                <span class="block text-[10px] text-slate-800 dark:text-white font-black truncate max-w-[150px] uppercase">{{ $ledger->reference }}</span>
                                <span class="block text-[9px] text-slate-400 truncate max-w-[200px] mt-0.5">{{ $ledger->description }}</span>
                            </td>
                            <td class="px-8 py-6">
                                <span class="px-3 py-1 rounded-lg bg-slate-50 dark:bg-slate-800 border border-slate-100 dark:border-slate-700 text-[8px] font-black text-slate-500 dark:text-slate-400 uppercase tracking-widest">
                                    {{ $ledger->type }}
                                </span>
                            </td>
                            <td class="px-8 py-6 text-center">
                                @if($ledger->credit > 0)
                                    <span class="text-sm font-black text-emerald-600 dark:text-emerald-400 leading-none">+৳{{ number_format($ledger->credit, 2) }}</span>
                                @else
                                    <span class="text-[9px] font-black text-slate-200 dark:text-slate-700">---</span>
                                @endif
                            </td>
                            <td class="px-8 py-6 text-center">
                                @if($ledger->debit > 0)
                                    <span class="text-sm font-black text-rose-600 dark:text-rose-400 leading-none">-৳{{ number_format($ledger->debit, 2) }}</span>
                                @else
                                    <span class="text-[9px] font-black text-slate-200 dark:text-slate-700">---</span>
                                @endif
                            </td>
                            <td class="px-8 py-6 text-right font-black text-slate-900 dark:text-white text-sm">
                                ৳{{ number_format($ledger->balance_after, 2) }}
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="px-10 py-32 text-center text-slate-300 flex flex-col items-center">
                                <span class="text-8xl mb-6 opacity-10">📑</span>
                                <p class="text-lg font-black uppercase tracking-[0.2em]">No Records Found</p>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if($ledgers->hasPages())
            <div class="p-6 md:p-10 border-t border-slate-50 dark:border-slate-800 bg-slate-50/30 dark:bg-slate-800/30">
                {{ $ledgers->links() }}
            </div>
        @endif
    </div>
</div>
@endsection
