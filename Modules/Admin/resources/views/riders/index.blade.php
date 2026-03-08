@extends('layouts.admin')

@section('title', 'Riders - CMarket')
@section('page-title', 'Riders')

@section('content')
<div class="space-y-10 animate-fade-in">
    <!-- Summary -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
        <div class="bg-white dark:bg-slate-900 rounded-[2rem] p-8 border border-slate-100 dark:border-slate-800 shadow-sm relative overflow-hidden group">
            <div class="relative z-10">
                <p class="text-[9px] font-black uppercase tracking-widest text-slate-400 dark:text-slate-500 mb-6 font-black tracking-[0.2em]">Pending Approval</p>
                <h3 class="text-4xl font-black text-slate-800 dark:text-white leading-none">{{ $riders->where('status', 'pending')->count() }}</h3>
            </div>
            <div class="absolute -right-2 -bottom-2 opacity-[0.03] text-6xl font-black italic text-slate-400 dark:text-white">WAIT</div>
        </div>
        <div class="bg-slate-900 dark:bg-sky-600 rounded-[2rem] p-8 text-white shadow-2xl shadow-slate-900/10 relative overflow-hidden group border-none">
            <div class="relative z-10">
                <p class="text-[9px] font-black uppercase tracking-widest text-sky-400 dark:text-white/60 mb-6 font-black tracking-[0.2em]">Active Logistics</p>
                <h3 class="text-4xl font-black text-white leading-none">{{ $riders->where('status', 'approved')->count() }}</h3>
            </div>
            <div class="absolute -right-2 -bottom-2 opacity-[0.05] text-6xl font-black italic text-white">NODES</div>
        </div>
        <div class="bg-white dark:bg-slate-900 rounded-[2rem] p-8 border border-slate-100 dark:border-slate-800 shadow-sm relative overflow-hidden group">
            <div class="relative z-10">
                <p class="text-[9px] font-black uppercase tracking-widest text-slate-400 dark:text-slate-500 mb-6 font-black tracking-[0.2em]">Total Records</p>
                <h3 class="text-4xl font-black text-slate-800 dark:text-white leading-none">{{ $riders->total() }}</h3>
            </div>
            <div class="absolute -right-2 -bottom-2 opacity-[0.03] text-6xl font-black italic text-slate-400 dark:text-white">GLOBAL</div>
        </div>
        <div class="bg-white dark:bg-slate-900 rounded-[2rem] p-8 border border-slate-100 dark:border-slate-800 shadow-sm relative overflow-hidden group">
            <div class="relative z-10">
                <p class="text-[9px] font-black uppercase tracking-widest text-slate-400 dark:text-slate-500 mb-6 font-black tracking-[0.2em]">Audit Status</p>
                <h3 class="text-4xl font-black text-emerald-500 leading-none">HEALTHY</h3>
            </div>
            <div class="absolute -right-2 -bottom-2 opacity-[0.03] text-6xl font-black italic text-slate-400 dark:text-white">SYSTEM</div>
        </div>
    </div>

    <!-- Data Table -->
    <div class="bg-white dark:bg-slate-900 rounded-[2.5rem] md:rounded-[3rem] border border-slate-100 dark:border-slate-800 shadow-sm overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse min-w-[900px]">
                <thead>
                    <tr class="bg-slate-50/50 dark:bg-slate-800/50">
                        <th class="px-10 py-6 text-[10px] font-black uppercase tracking-[0.2em] text-slate-400 dark:text-slate-500">Logistics Node</th>
                        <th class="px-10 py-6 text-[10px] font-black uppercase tracking-[0.2em] text-slate-400 dark:text-slate-500">Vector Asset</th>
                        <th class="px-10 py-6 text-[10px] font-black uppercase tracking-[0.2em] text-slate-400 dark:text-slate-500">Comm Channel</th>
                        <th class="px-10 py-6 text-[10px] font-black uppercase tracking-[0.2em] text-slate-400 dark:text-slate-500 text-center">Level</th>
                        <th class="px-10 py-6 text-[10px] font-black uppercase tracking-[0.2em] text-slate-400 dark:text-slate-500 text-right">Operations</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-50 dark:divide-slate-800">
                    @forelse($riders as $rider)
                        <tr class="group hover:bg-slate-50/80 dark:hover:bg-slate-800/50 transition-all duration-300">
                            <td class="px-10 py-8">
                                <div class="flex items-center gap-6">
                                    <div class="w-12 h-12 rounded-2xl bg-slate-100 dark:bg-slate-800 border border-slate-100 dark:border-slate-700 flex items-center justify-center text-xl shadow-lg group-hover:scale-110 transition-transform overflow-hidden font-black">
                                        {{ substr($rider->user->name, 0, 1) }}
                                    </div>
                                    <div>
                                        <div class="text-sm font-black text-slate-800 dark:text-white mb-1">{{ $rider->user->name }}</div>
                                        <div class="text-[9px] text-slate-400 dark:text-slate-500 font-black uppercase tracking-widest">ZONE: {{ $rider->zone ?? 'CENTRAL' }}</div>
                                    </div>
                                </div>
                            </td>
                            <td class="px-10 py-8">
                                <div class="text-[10px] font-black text-slate-800 dark:text-white uppercase tracking-widest mb-1">{{ $rider->vehicle_type }}</div>
                                <div class="text-[9px] text-sky-500 font-bold tracking-widest">{{ $rider->vehicle_number ?? 'UNREGISTERED' }}</div>
                            </td>
                            <td class="px-10 py-8">
                                <div class="text-[10px] font-black text-slate-600 dark:text-slate-400 uppercase tracking-widest">
                                    {{ $rider->phone }}
                                </div>
                            </td>
                            <td class="px-10 py-8 text-center">
                                @if($rider->status === 'approved')
                                    <span class="inline-flex items-center gap-1.5 py-1.5 px-3 rounded-lg text-[8px] font-black bg-emerald-50 dark:bg-emerald-900/20 text-emerald-600 dark:text-emerald-400 border border-emerald-100 dark:border-emerald-800 uppercase">
                                        ACTIVE LOGISTICS
                                    </span>
                                @elseif($rider->status === 'pending')
                                    <span class="inline-flex items-center gap-1.5 py-1.5 px-3 rounded-lg text-[8px] font-black bg-amber-50 dark:bg-amber-900/20 text-amber-600 dark:text-amber-400 border border-amber-100 dark:border-amber-800 uppercase">
                                        AWAITING AUDIT
                                    </span>
                                @else
                                    <span class="inline-flex items-center gap-1.5 py-1.5 px-3 rounded-lg text-[8px] font-black bg-rose-50 dark:bg-rose-900/20 text-rose-600 dark:text-rose-400 border border-rose-100 dark:border-rose-800 uppercase">
                                        PROTOCOL SUSPENDED
                                    </span>
                                @endif
                            </td>
                            <td class="px-10 py-8 text-right">
                                <div class="flex justify-end opacity-0 group-hover:opacity-100 transition-all translate-x-4 group-hover:translate-x-0 duration-300">
                                    <a href="{{ route('admin.riders.show', $rider) }}" class="px-6 py-3 bg-slate-900 dark:bg-slate-800 text-white rounded-xl text-[9px] font-black uppercase tracking-[0.2em] shadow-xl shadow-slate-900/10 hover:bg-sky-500 transition-all">
                                        Review Profile ⚡
                                    </a>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="px-10 py-32 text-center text-slate-300 flex flex-col items-center">
                                <span class="text-8xl mb-6 opacity-10">🚴</span>
                                <p class="text-lg font-black uppercase tracking-[0.2em]">No Logistic Nodes Detected</p>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if($riders->hasPages())
            <div class="p-6 md:p-10 border-t border-slate-50 dark:border-slate-800 bg-slate-50/30 dark:bg-slate-800/30">
                {{ $riders->links() }}
            </div>
        @endif
    </div>
</div>
@endsection
