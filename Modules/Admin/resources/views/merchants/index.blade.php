@extends('layouts.admin')

@section('title', 'Merchant Directory - CMarket')
@section('page-title', 'Global Merchant Network')

@section('content')
<div class="space-y-10 animate-fade-in">
    <!-- Macro Summary -->
    <div class="bg-white dark:bg-slate-900 rounded-[2.5rem] md:rounded-[3rem] p-6 md:p-10 lg:p-12 border border-slate-100 dark:border-slate-800 shadow-sm flex flex-col lg:flex-row justify-between items-center gap-8 md:gap-10 overflow-hidden relative group">
        <div class="relative z-10 w-full lg:w-auto text-center lg:text-left">
            <h2 class="text-2xl md:text-3xl font-black text-slate-800 dark:text-white tracking-tight leading-none mb-3 md:mb-4">Merchant Network</h2>
            <p class="text-slate-400 dark:text-slate-500 font-bold text-[9px] md:text-[10px] uppercase tracking-[0.2em] ml-1">Protocol Partners • {{ $merchants->total() }} Identified Entities</p>
        </div>
        <div class="grid grid-cols-2 lg:flex items-center gap-3 md:gap-4 relative z-10 w-full lg:w-auto">
            <div class="px-6 py-4 md:px-8 md:py-6 rounded-2xl md:rounded-3xl bg-slate-950 text-white text-center flex-1 lg:w-32 shadow-xl shadow-slate-900/20">
                <div class="text-[7px] md:text-[8px] font-black text-sky-400 uppercase mb-1">Live Nodes</div>
                <div class="text-base md:text-xl font-black">{{ $merchants->where('status', 'active')->count() }}</div>
            </div>
            <div class="px-6 py-4 md:px-8 md:py-6 rounded-2xl md:rounded-3xl bg-amber-500 text-white text-center flex-1 lg:w-32 shadow-xl shadow-amber-500/20">
                <div class="text-[7px] md:text-[8px] font-black text-amber-900 uppercase mb-1">Waitlist</div>
                <div class="text-base md:text-xl font-black">{{ $merchants->where('status', 'pending')->count() }}</div>
            </div>
        </div>
        <!-- Decor -->
        <div class="absolute -right-10 -bottom-10 opacity-[0.03] text-[150px] md:text-[200px] leading-none select-none italic font-black group-hover:scale-110 transition-transform duration-1000 dark:text-white">NODES</div>
    </div>

    <!-- Data Infrastructure Table -->
    <div class="bg-white dark:bg-slate-900 rounded-[2.5rem] md:rounded-[3rem] border border-slate-100 dark:border-slate-800 shadow-sm overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse min-w-[1000px]">
                <thead>
                    <tr class="bg-slate-50/50 dark:bg-slate-800/50">
                        <th class="px-10 py-6 text-[10px] font-black uppercase tracking-[0.2em] text-slate-400 dark:text-slate-500">Merchant Entity</th>
                        <th class="px-10 py-6 text-[10px] font-black uppercase tracking-[0.2em] text-slate-400 dark:text-slate-500">Auth Controller</th>
                        <th class="px-10 py-6 text-[10px] font-black uppercase tracking-[0.2em] text-slate-400 dark:text-slate-500 text-center">Catalog Vector</th>
                        <th class="px-10 py-6 text-[10px] font-black uppercase tracking-[0.2em] text-slate-400 dark:text-slate-500 text-center">Operational Status</th>
                        <th class="px-10 py-6 text-[10px] font-black uppercase tracking-[0.2em] text-slate-400 dark:text-slate-500 text-right">Operations</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-50 dark:divide-slate-800">
                    @forelse($merchants as $merchant)
                        <tr class="group hover:bg-slate-50/80 transition-all duration-300">
                            <td class="px-10 py-8">
                                <div class="flex items-center gap-6">
                                    <div class="w-14 h-14 rounded-2xl bg-slate-50 dark:bg-slate-800 border border-slate-100 dark:border-slate-700 overflow-hidden flex items-center justify-center shadow-lg group-hover:scale-110 transition-transform text-2xl">
                                        🏪
                                    </div>
                                    <div>
                                        <div class="text-sm font-black text-slate-800 dark:text-white mb-1">{{ $merchant->business_name }}</div>
                                        <div class="text-[9px] text-slate-400 dark:text-slate-500 font-black uppercase tracking-widest">{{ $merchant->business_type }}</div>
                                    </div>
                                </div>
                            </td>
                            <td class="px-10 py-8">
                                <div class="text-[10px] font-black text-slate-800 dark:text-white uppercase tracking-widest mb-1">{{ $merchant->user->name }}</div>
                                <div class="text-[10px] font-bold text-sky-500">{{ $merchant->phone }}</div>
                            </td>
                            <td class="px-10 py-8 text-center">
                                <span class="inline-flex px-4 py-1.5 rounded-xl bg-slate-50 dark:bg-slate-800 border border-slate-100 dark:border-slate-700 text-[9px] font-black text-slate-800 dark:text-white tracking-tighter">
                                    {{ $merchant->products_count ?? 0 }} DEP. UNITS
                                </span>
                            </td>
                            <td class="px-10 py-8 text-center">
                                @if($merchant->status === 'approved')
                                    <span class="inline-flex items-center gap-2 py-2 px-4 rounded-xl text-[9px] font-black bg-emerald-50 text-emerald-600 border border-emerald-100">
                                        LIVE
                                    </span>
                                @elseif($merchant->status === 'pending')
                                    <span class="inline-flex items-center gap-2 py-2 px-4 rounded-xl text-[9px] font-black bg-amber-50 text-amber-600 border border-amber-100">
                                        PENDING
                                    </span>
                                @else
                                    <span class="inline-flex items-center gap-2 py-2 px-4 rounded-xl text-[9px] font-black bg-rose-50 text-rose-600 border border-rose-100">
                                        OFFLINE
                                    </span>
                                @endif
                            </td>
                            <td class="px-10 py-8 text-right">
                                <div class="flex justify-end opacity-0 group-hover:opacity-100 transition-opacity translate-x-4 group-hover:translate-x-0 duration-300">
                                    <a href="{{ route('admin.merchants.show', $merchant) }}" class="px-6 py-3 rounded-xl bg-slate-900 text-white text-[9px] font-black uppercase tracking-widest hover:bg-sky-500 transition-all shadow-xl shadow-slate-900/10">
                                        Inspect Node ⚡
                                    </a>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="px-10 py-32 text-center text-slate-300 flex flex-col items-center">
                                <span class="text-8xl mb-6 opacity-10">🧊</span>
                                <p class="text-lg font-black uppercase tracking-[0.2em]">Network Vacuum Detected</p>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if($merchants->hasPages())
            <div class="p-6 md:p-10 border-t border-slate-50 dark:border-slate-800 bg-slate-50/30 dark:bg-slate-800/30">
                {{ $merchants->links() }}
            </div>
        @endif
    </div>
</div>
@endsection
