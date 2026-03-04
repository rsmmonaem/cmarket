@extends('layouts.admin')

@section('title', 'Commission Engine - CMarket')
@section('page-title', 'Protocol Beneficiaries')

@section('content')
<div class="space-y-10 animate-fade-in">
    <!-- Macro Summary -->
    <div class="grid grid-cols-2 md:grid-cols-4 gap-4 md:gap-6">
        <div class="bg-white dark:bg-slate-900 rounded-[1.5rem] md:rounded-[2rem] p-5 md:p-8 border border-slate-100 dark:border-slate-800 shadow-sm relative overflow-hidden group">
            <div class="relative z-10">
                <p class="text-[7px] md:text-[9px] font-black uppercase tracking-widest text-slate-400 dark:text-slate-500 mb-4 md:mb-6 font-black tracking-[0.2em]">Pending Payouts</p>
                <h3 class="text-2xl md:text-4xl font-black text-slate-800 dark:text-white leading-none">{{ $commissions->where('status', 'pending')->count() }}</h3>
            </div>
            <div class="absolute -right-2 -bottom-2 opacity-[0.03] text-5xl md:text-6xl font-black italic text-slate-400 dark:text-white">WAIT</div>
        </div>
        <div class="bg-slate-900 dark:bg-sky-600 rounded-[1.5rem] md:rounded-[2rem] p-5 md:p-8 text-white shadow-2xl shadow-slate-900/10 relative overflow-hidden group border-none">
            <div class="relative z-10">
                <p class="text-[7px] md:text-[9px] font-black uppercase tracking-widest text-sky-400 dark:text-white/60 mb-4 md:mb-6 font-black tracking-[0.2em]">Disbursed</p>
                <h3 class="text-2xl md:text-4xl font-black text-white leading-none">৳{{ number_format($commissions->where('status', 'approved')->sum('amount') / 1000, 1) }}k</h3>
            </div>
            <div class="absolute -right-2 -bottom-2 opacity-[0.05] text-5xl md:text-6xl font-black italic text-white">PAID</div>
        </div>
        <div class="bg-white dark:bg-slate-900 rounded-[1.5rem] md:rounded-[2rem] p-5 md:p-8 border border-slate-100 dark:border-slate-800 shadow-sm relative overflow-hidden group">
            <div class="relative z-10">
                <p class="text-[7px] md:text-[9px] font-black uppercase tracking-widest text-slate-400 dark:text-slate-500 mb-4 md:mb-6 font-black tracking-[0.2em]">Efficiency Rate</p>
                <h3 class="text-2xl md:text-4xl font-black text-slate-800 dark:text-white leading-none">12%</h3>
            </div>
            <div class="absolute -right-2 -bottom-2 opacity-[0.03] text-5xl md:text-6xl font-black italic text-slate-400 dark:text-white">RATE</div>
        </div>
        <div class="bg-white dark:bg-slate-900 rounded-[1.5rem] md:rounded-[2rem] p-5 md:p-8 border border-slate-100 dark:border-slate-800 shadow-sm relative overflow-hidden group">
            <div class="relative z-10">
                <p class="text-[7px] md:text-[9px] font-black uppercase tracking-widest text-slate-400 dark:text-slate-500 mb-4 md:mb-6 font-black tracking-[0.2em]">Total Logs</p>
                <h3 class="text-2xl md:text-4xl font-black text-slate-800 dark:text-white leading-none">{{ $commissions->total() }}</h3>
            </div>
            <div class="absolute -right-2 -bottom-2 opacity-[0.03] text-5xl md:text-6xl font-black italic text-slate-400 dark:text-white">HIST</div>
        </div>
    </div>

    <!-- Data Infrastructure Table -->
    <div class="bg-white dark:bg-slate-900 rounded-[2.5rem] md:rounded-[3rem] border border-slate-100 dark:border-slate-800 shadow-sm overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse min-w-[1000px]">
                <thead>
                    <tr class="bg-slate-50/50 dark:bg-slate-800/50">
                        <th class="px-10 py-6 text-[10px] font-black uppercase tracking-[0.2em] text-slate-400 dark:text-slate-500">Beneficiary Node</th>
                        <th class="px-10 py-6 text-[10px] font-black uppercase tracking-[0.2em] text-slate-400 dark:text-slate-500">Financial Quantum</th>
                        <th class="px-10 py-6 text-[10px] font-black uppercase tracking-[0.2em] text-slate-400 dark:text-slate-500">Trigger Event</th>
                        <th class="px-10 py-6 text-[10px] font-black uppercase tracking-[0.2em] text-slate-400 dark:text-slate-500 text-center">Protocol Status</th>
                        <th class="px-10 py-6 text-[10px] font-black uppercase tracking-[0.2em] text-slate-400 dark:text-slate-500 text-right">Operations</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-50 dark:divide-slate-800">
                    @forelse($commissions as $commission)
                        <tr class="group hover:bg-slate-50/80 dark:hover:bg-slate-800/50 transition-all duration-300">
                            <td class="px-10 py-8">
                                <div class="flex items-center gap-6">
                                    <div class="w-12 h-12 rounded-2xl bg-slate-100 dark:bg-slate-800 border border-slate-100 dark:border-slate-700 flex items-center justify-center text-sm shadow-lg group-hover:scale-110 transition-transform overflow-hidden font-black">
                                        {{ substr($commission->user->name, 0, 1) }}
                                    </div>
                                    <div>
                                        <div class="text-sm font-black text-slate-800 dark:text-white mb-1">{{ $commission->user->name }}</div>
                                        <div class="text-[9px] text-slate-400 dark:text-slate-500 font-black uppercase tracking-widest">{{ $commission->commission_type }}</div>
                                    </div>
                                </div>
                            </td>
                            <td class="px-10 py-8">
                                <div class="text-sm font-black text-slate-800 dark:text-white leading-none">৳{{ number_format($commission->amount, 2) }}</div>
                                <div class="text-[8px] text-slate-400 dark:text-slate-500 font-black uppercase mt-1 tracking-widest">{{ $commission->created_at->format('d M, Y') }}</div>
                            </td>
                            <td class="px-10 py-8">
                                <div class="text-[10px] font-black text-slate-800 dark:text-white uppercase tracking-widest mb-1">Order #{{ $commission->order->order_number ?? 'SYSTEM' }}</div>
                                <div class="text-[9px] text-sky-500 font-bold tracking-widest">Protocol Sync</div>
                            </td>
                            <td class="px-10 py-8 text-center">
                                @if($commission->status === 'approved')
                                    <span class="inline-flex items-center gap-1.5 py-1.5 px-3 rounded-lg text-[8px] font-black bg-emerald-50 dark:bg-emerald-900/20 text-emerald-600 dark:text-emerald-400 border border-emerald-100 dark:border-emerald-800 uppercase">
                                        SUCCESSFUL DISBURSEMENT
                                    </span>
                                @elseif($commission->status === 'pending')
                                    <span class="inline-flex items-center gap-1.5 py-1.5 px-3 rounded-lg text-[8px] font-black bg-amber-50 dark:bg-amber-900/20 text-amber-600 dark:text-amber-400 border border-amber-100 dark:border-amber-800 uppercase">
                                        AWAITING AUDIT
                                    </span>
                                @else
                                    <span class="inline-flex items-center gap-1.5 py-1.5 px-3 rounded-lg text-[8px] font-black bg-rose-50 dark:bg-rose-900/20 text-rose-600 dark:text-rose-400 border border-rose-100 dark:border-rose-800 uppercase">
                                        REJECTED PROTOCOL
                                    </span>
                                @endif
                            </td>
                            <td class="px-10 py-8 text-right">
                                <div class="flex justify-end opacity-0 group-hover:opacity-100 transition-all translate-x-4 group-hover:translate-x-0 duration-300">
                                    <a href="{{ route('admin.commissions.show', $commission) }}" class="w-10 h-10 rounded-xl bg-slate-900 dark:bg-slate-800 text-white flex items-center justify-center text-lg hover:bg-sky-500 transition-all shadow-xl shadow-slate-900/10">
                                        ⚖️
                                    </a>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="px-10 py-32 text-center text-slate-300 flex flex-col items-center">
                                <span class="text-8xl mb-6 opacity-10">💵</span>
                                <p class="text-lg font-black uppercase tracking-[0.2em]">Zero Yield Detected</p>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if($commissions->hasPages())
            <div class="p-6 md:p-10 border-t border-slate-50 dark:border-slate-800 bg-slate-50/30 dark:bg-slate-800/30">
                {{ $commissions->links() }}
            </div>
        @endif
    </div>
</div>
@endsection
