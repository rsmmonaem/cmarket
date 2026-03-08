@extends('layouts.customer')
@section('title', 'Affiliate Analytics')
@section('page-title', 'Link Analytics')

@section('content')
<div class="space-y-8">
    {{-- Nav --}}
    <div class="flex flex-wrap gap-2">
        @foreach([['affiliate.dashboard','🏠 Dashboard'],['affiliate.links','🔗 Links'],['affiliate.commissions','💰 Commissions'],['affiliate.analytics','📊 Analytics'],['affiliate.withdraw','🏦 Withdraw']] as [$r,$l])
        <a href="{{ route($r) }}" class="px-4 py-2 rounded-2xl text-[10px] font-black uppercase tracking-widest {{ request()->routeIs($r) ? 'bg-indigo-600 text-white' : 'bg-slate-100 text-slate-500 hover:bg-slate-200 dark:bg-slate-800 dark:text-slate-300' }} transition-all">{{ $l }}</a>
        @endforeach
    </div>

    @if($links->isEmpty())
    <div class="bg-white dark:bg-slate-900 rounded-3xl p-20 text-center border border-slate-100 dark:border-slate-800">
        <div class="text-6xl mb-6">📊</div>
        <h3 class="text-2xl font-black text-slate-800 dark:text-white mb-2">No data yet</h3>
        <p class="text-sm text-slate-400 font-bold mb-6">Generate affiliate links and start sharing to see analytics here.</p>
        <a href="{{ route('affiliate.links') }}" class="px-8 py-4 bg-indigo-600 text-white rounded-2xl text-xs font-black uppercase tracking-widest hover:bg-indigo-700 transition-all">Go to Links</a>
    </div>
    @else

    {{-- Total stats bar --}}
    <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
        @php
            $totalClicks      = $links->sum('clicks_count');
            $totalConversions = $links->sum('conversions');
            $avgCvr = $totalClicks > 0 ? round(($totalConversions / $totalClicks) * 100, 1) : 0;
        @endphp
        <div class="bg-white dark:bg-slate-900 rounded-3xl border border-slate-100 dark:border-slate-800 p-6 shadow-sm text-center">
            <div class="text-3xl font-black text-indigo-600">{{ number_format($totalClicks) }}</div>
            <div class="text-[9px] font-black text-slate-400 uppercase tracking-widest mt-1">Total Clicks</div>
        </div>
        <div class="bg-white dark:bg-slate-900 rounded-3xl border border-slate-100 dark:border-slate-800 p-6 shadow-sm text-center">
            <div class="text-3xl font-black text-emerald-600">{{ number_format($totalConversions) }}</div>
            <div class="text-[9px] font-black text-slate-400 uppercase tracking-widest mt-1">Conversions</div>
        </div>
        <div class="bg-white dark:bg-slate-900 rounded-3xl border border-slate-100 dark:border-slate-800 p-6 shadow-sm text-center">
            <div class="text-3xl font-black text-amber-500">{{ $avgCvr }}%</div>
            <div class="text-[9px] font-black text-slate-400 uppercase tracking-widest mt-1">Avg. CVR</div>
        </div>
        <div class="bg-white dark:bg-slate-900 rounded-3xl border border-slate-100 dark:border-slate-800 p-6 shadow-sm text-center">
            <div class="text-3xl font-black text-slate-800 dark:text-white">{{ $links->count() }}</div>
            <div class="text-[9px] font-black text-slate-400 uppercase tracking-widest mt-1">Active Links</div>
        </div>
    </div>

    {{-- Per-link breakdown --}}
    <div class="bg-white dark:bg-slate-900 rounded-3xl border border-slate-100 dark:border-slate-800 overflow-hidden shadow-sm">
        <div class="px-8 py-5 border-b border-slate-50 dark:border-slate-800">
            <h4 class="text-[10px] font-black uppercase tracking-[0.2em] text-slate-400">Performance by Link</h4>
        </div>
        <div class="divide-y divide-slate-50 dark:divide-slate-800">
            @foreach($links as $link)
            @php
                $cvr = $link->clicks_count > 0 ? round(($link->conversions / $link->clicks_count) * 100, 1) : 0;
                $barWidth = $totalClicks > 0 ? round(($link->clicks_count / $totalClicks) * 100) : 0;
            @endphp
            <div class="px-8 py-6">
                <div class="flex items-center justify-between mb-3">
                    <div class="flex-1 min-w-0 mr-4">
                        <p class="text-sm font-black text-slate-800 dark:text-white truncate uppercase">{{ $link->product->name }}</p>
                        <p class="text-[10px] font-mono text-indigo-500">{{ url('/ref/' . $link->code) }}</p>
                    </div>
                    <div class="flex items-center gap-6 flex-shrink-0">
                        <div class="text-center">
                            <p class="text-xl font-black text-slate-800 dark:text-white">{{ number_format($link->clicks_count) }}</p>
                            <p class="text-[9px] text-slate-400 font-bold uppercase">Clicks</p>
                        </div>
                        <div class="text-center">
                            <p class="text-xl font-black text-emerald-600">{{ $link->conversions }}</p>
                            <p class="text-[9px] text-slate-400 font-bold uppercase">Conv.</p>
                        </div>
                        <div class="text-center">
                            <p class="text-xl font-black text-amber-500">{{ $cvr }}%</p>
                            <p class="text-[9px] text-slate-400 font-bold uppercase">CVR</p>
                        </div>
                    </div>
                </div>
                {{-- Click bar --}}
                <div class="h-2 bg-slate-100 dark:bg-slate-800 rounded-full overflow-hidden">
                    <div class="h-full bg-gradient-to-r from-indigo-500 to-violet-500 rounded-full transition-all duration-700" style="width: {{ $barWidth }}%"></div>
                </div>
            </div>
            @endforeach
        </div>
    </div>
    @endif
</div>
@endsection
