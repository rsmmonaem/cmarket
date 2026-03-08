@extends('layouts.admin')

@section('title', 'KYC Audit Terminal - CMarket')
@section('page-title', 'KYC Verification Pipeline')

@section('content')
<div class="space-y-10 animate-fade-in">
    <!-- Macro Summary -->
    <div class="bg-slate-900 dark:bg-slate-900 rounded-[2.5rem] md:rounded-[3rem] p-6 md:p-10 lg:p-12 text-white shadow-2xl shadow-slate-900/10 flex flex-col lg:flex-row justify-between items-center gap-8 md:gap-10 overflow-hidden relative group">
        <div class="relative z-10 w-full lg:w-auto text-center lg:text-left">
            <h2 class="text-2xl md:text-3xl font-black tracking-tight leading-none mb-3 md:mb-4 text-white">Verification Gateway</h2>
            <p class="text-slate-400 font-bold text-[9px] md:text-[10px] uppercase tracking-[0.2em] ml-1">Live Audit Queue • {{ $kycs->total() }} Identified Nodes</p>
        </div>
        <div class="grid grid-cols-2 lg:flex items-center gap-3 md:gap-4 relative z-10 w-full lg:w-auto">
            <div class="p-4 md:p-6 rounded-2xl bg-white/5 border border-white/10 backdrop-blur-xl text-center flex-1 lg:w-32">
                <div class="text-[7px] md:text-[8px] font-black text-amber-500 uppercase mb-1">Queue</div>
                <div class="text-base md:text-xl font-black text-white">{{ $kycs->where('status', 'pending')->count() }}</div>
            </div>
            <div class="p-4 md:p-6 rounded-2xl bg-white/5 border border-white/10 backdrop-blur-xl text-center flex-1 lg:w-32">
                <div class="text-[7px] md:text-[8px] font-black text-emerald-500 uppercase mb-1">Passed</div>
                <div class="text-base md:text-xl font-black text-white">{{ $kycs->where('status', 'approved')->count() }}</div>
            </div>
        </div>
        <!-- Decor -->
        <div class="absolute -right-10 -bottom-10 opacity-[0.03] text-[150px] md:text-[200px] leading-none select-none italic font-black group-hover:scale-110 transition-transform duration-1000 dark:text-white">AUDIT</div>
    </div>

    <!-- Data Infrastructure Table -->
    <div class="bg-white dark:bg-slate-900 rounded-[2.5rem] md:rounded-[3rem] border border-slate-100 dark:border-slate-800 shadow-sm overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse min-w-[800px]">
                <thead>
                    <tr class="bg-slate-50/50 dark:bg-slate-800/50">
                        <th class="px-10 py-6 text-[10px] font-black uppercase tracking-[0.2em] text-slate-400 dark:text-slate-500">Target Node</th>
                        <th class="px-10 py-6 text-[10px] font-black uppercase tracking-[0.2em] text-slate-400 dark:text-slate-500">Document Vector</th>
                        <th class="px-10 py-6 text-[10px] font-black uppercase tracking-[0.2em] text-slate-400 dark:text-slate-500">Temporal Stamp</th>
                        <th class="px-10 py-6 text-[10px] font-black uppercase tracking-[0.2em] text-slate-400 dark:text-slate-500 text-center">Status</th>
                        <th class="px-10 py-6 text-[10px] font-black uppercase tracking-[0.2em] text-slate-400 dark:text-slate-500 text-right">Operations</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-50 dark:divide-slate-800">
                    @forelse($kycs as $kyc)
                        <tr class="group hover:bg-slate-50/80 transition-all duration-300">
                            <td class="px-10 py-8">
                                <div class="flex items-center gap-6">
                                    <div class="w-12 h-12 rounded-2xl bg-slate-900 border border-slate-100 flex items-center justify-center text-white font-black text-sm shadow-lg group-hover:scale-110 transition-transform">
                                        {{ substr($kyc->user->name, 0, 1) }}
                                    </div>
                                    <div>
                                        <div class="text-sm font-black text-slate-800 dark:text-white mb-1">{{ $kyc->user->name }}</div>
                                        <div class="text-[9px] text-slate-400 dark:text-slate-500 font-black uppercase tracking-widest">{{ $kyc->user->phone }}</div>
                                    </div>
                                </div>
                            </td>
                            <td class="px-10 py-8">
                                <div class="text-[10px] font-black text-slate-800 dark:text-white uppercase tracking-widest mb-1">{{ $kyc->id_type }}</div>
                                <div class="text-[10px] font-bold text-sky-500">{{ $kyc->id_number }}</div>
                            </td>
                            <td class="px-10 py-8">
                                <div class="text-[10px] font-black text-slate-800 dark:text-white mb-1">{{ $kyc->created_at->format('d M Y') }}</div>
                                <div class="text-[9px] text-slate-400 dark:text-slate-500 font-bold uppercase tracking-tight">{{ $kyc->created_at->diffForHumans() }}</div>
                            </td>
                            <td class="px-10 py-8 text-center">
                                @if($kyc->status === 'pending')
                                    <span class="inline-flex items-center gap-1.5 py-1.5 px-3 rounded-lg text-[8px] font-black bg-amber-50 text-amber-600 border border-amber-100">
                                        QUEUE
                                    </span>
                                @elseif($kyc->status === 'approved')
                                    <span class="inline-flex items-center gap-1.5 py-1.5 px-3 rounded-lg text-[8px] font-black bg-emerald-50 text-emerald-600 border border-emerald-100">
                                        PASSED
                                    </span>
                                @else
                                    <span class="inline-flex items-center gap-1.5 py-1.5 px-3 rounded-lg text-[8px] font-black bg-rose-50 text-rose-600 border border-rose-100">
                                        REJECTED
                                    </span>
                                @endif
                            </td>
                            <td class="px-10 py-8 text-right">
                                <div class="flex justify-end opacity-0 group-hover:opacity-100 transition-opacity translate-x-4 group-hover:translate-x-0 duration-300">
                                    <a href="{{ route('admin.kyc.show', $kyc) }}" class="px-6 py-3 rounded-xl bg-slate-900 text-white text-[9px] font-black uppercase tracking-widest hover:bg-sky-500 transition-all shadow-xl shadow-slate-900/10">
                                        Review Detail ⚡
                                    </a>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="px-10 py-32 text-center text-slate-300 flex flex-col items-center">
                                <span class="text-8xl mb-6 opacity-10">🛡️</span>
                                <p class="text-lg font-black uppercase tracking-[0.2em]">Queue Vacuum Detected</p>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if($kycs->hasPages())
            <div class="p-6 md:p-10 border-t border-slate-50 dark:border-slate-800 bg-slate-50/30 dark:bg-slate-800/30">
                {{ $kycs->links() }}
            </div>
        @endif
    </div>
</div>
@endsection
