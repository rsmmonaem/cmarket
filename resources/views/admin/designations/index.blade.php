@extends('layouts.admin')

@section('title', 'Hierarchy Manager - CMarket')
@section('page-title', 'Platform Achievement Protocol')

@section('content')
<div class="space-y-10 animate-fade-in">
    <!-- Macro Summary & Action -->
    <div class="bg-white dark:bg-slate-900 rounded-[2.5rem] md:rounded-[3rem] p-6 md:p-10 lg:p-12 border border-slate-100 dark:border-slate-800 shadow-sm flex flex-col lg:flex-row justify-between items-center gap-8 md:gap-10 overflow-hidden relative group">
        <div class="relative z-10 w-full lg:w-auto text-center lg:text-left">
            <h2 class="text-2xl md:text-3xl font-black text-slate-800 dark:text-white tracking-tight leading-none mb-3 md:mb-4">Rank Infrastructure</h2>
            <p class="text-slate-400 dark:text-slate-500 font-bold text-[9px] md:text-[10px] uppercase tracking-[0.2em] ml-1">Defining {{ $designations->count() }} active platform hierarchies</p>
        </div>
        <div class="flex items-center gap-4 relative z-10 w-full lg:w-auto">
            <a href="{{ route('admin.designations.create') }}" class="flex-1 lg:flex-none px-6 py-4 md:px-10 md:py-5 bg-slate-900 dark:bg-sky-600 text-white rounded-xl md:rounded-2xl font-black text-[9px] md:text-[10px] uppercase tracking-widest shadow-2xl shadow-slate-900/10 hover:bg-sky-600 dark:hover:bg-sky-500 hover:scale-[1.05] transition-all flex items-center justify-center gap-3">
                <span class="text-base md:text-lg">➕</span> Deploy New Rank
            </a>
        </div>
        <!-- Decor -->
        <div class="absolute -right-10 -bottom-10 opacity-[0.03] text-[150px] md:text-[200px] leading-none select-none italic font-black group-hover:scale-110 transition-transform duration-1000 dark:text-white">RANK</div>
    </div>

    <!-- Data Infrastructure Table -->
    <div class="bg-white dark:bg-slate-900 rounded-[2.5rem] md:rounded-[3rem] border border-slate-100 dark:border-slate-800 shadow-sm overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse min-w-[800px]">
                <thead>
                    <tr class="bg-slate-50/50 dark:bg-slate-800/50">
                        <th class="px-10 py-6 text-[10px] font-black uppercase tracking-[0.2em] text-slate-400 dark:text-slate-500">Rank Identity</th>
                        <th class="px-10 py-6 text-[10px] font-black uppercase tracking-[0.2em] text-slate-400 dark:text-slate-500">Sales Threshold</th>
                        <th class="px-10 py-6 text-[10px] font-black uppercase tracking-[0.2em] text-slate-400 dark:text-slate-500 text-center">Team Requirement</th>
                        <th class="px-10 py-6 text-[10px] font-black uppercase tracking-[0.2em] text-slate-400 dark:text-slate-500 text-center">Benefit Yield</th>
                        <th class="px-10 py-6 text-[10px] font-black uppercase tracking-[0.2em] text-slate-400 dark:text-slate-500 text-right">Operations</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-50 dark:divide-slate-800">
                    @forelse($designations as $designation)
                        <tr class="group hover:bg-slate-50/80 dark:hover:bg-slate-800/50 transition-all duration-300">
                            <td class="px-10 py-8">
                                <div class="flex items-center gap-6">
                                    <div class="w-12 h-12 rounded-2xl bg-slate-900 dark:bg-slate-800 border border-slate-100 dark:border-slate-700 flex items-center justify-center text-white font-black text-sm shadow-lg group-hover:scale-110 transition-transform">
                                        {{ substr($designation->name, 0, 1) }}
                                    </div>
                                    <div>
                                        <div class="text-sm font-black text-slate-800 dark:text-white mb-1">{{ $designation->name }}</div>
                                        <div class="text-[9px] text-slate-400 dark:text-slate-500 font-black uppercase tracking-widest">LEVEL: {{ $designation->level ?? 1 }} PROTOCOL</div>
                                    </div>
                                </div>
                            </td>
                            <td class="px-10 py-8">
                                <div class="text-sm font-black text-slate-800 dark:text-white">৳{{ number_format($designation->min_sales ?? 0, 0) }}</div>
                                <div class="text-[8px] text-slate-400 dark:text-slate-500 font-black uppercase mt-1 tracking-widest">MINIMUM REVENUE</div>
                            </td>
                            <td class="px-10 py-8 text-center text-xs font-black text-slate-700 dark:text-slate-300 uppercase tracking-widest">
                                {{ $designation->min_team_size ?? 0 }} Nodes
                            </td>
                            <td class="px-10 py-8 text-center">
                                <span class="px-3 py-1.5 rounded-lg bg-sky-50 dark:bg-sky-900/40 text-sky-600 dark:text-sky-400 font-black text-[10px] border border-sky-100 dark:border-sky-800">
                                    {{ $designation->commission_rate ?? 0 }}% YIELD
                                </span>
                            </td>
                            <td class="px-10 py-8 text-right">
                                <div class="flex justify-end opacity-0 group-hover:opacity-100 transition-all translate-x-4 group-hover:translate-x-0 duration-300">
                                    <a href="{{ route('admin.designations.edit', $designation) }}" class="p-2 rounded-xl bg-slate-900 dark:bg-slate-800 text-white hover:bg-sky-500 transition-all shadow-xl shadow-slate-900/10">
                                        ✏️
                                    </a>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="px-10 py-32 text-center text-slate-300 flex flex-col items-center">
                                <span class="text-8xl mb-6 opacity-10">🏆</span>
                                <p class="text-lg font-black uppercase tracking-[0.2em]">Zero Ranks Defined</p>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
