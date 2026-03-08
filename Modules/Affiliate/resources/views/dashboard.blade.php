@extends('layouts.customer')
@section('title', 'Affiliate Dashboard')
@section('page-title', 'Affiliate Hub')

@section('content')
<div class="space-y-8">
    {{-- Header --}}
    <div class="relative bg-gradient-to-br from-indigo-600 to-violet-700 rounded-3xl p-8 text-white overflow-hidden">
        <div class="relative z-10 flex flex-col md:flex-row items-center justify-between gap-6">
            <div>
                <p class="text-indigo-200 text-[10px] font-black uppercase tracking-[0.2em] mb-1">Your Affiliate Code</p>
                <h2 class="text-3xl font-black tracking-tight">{{ $affiliate->affiliate_code }}</h2>
                <p class="text-indigo-100 text-sm mt-1">Conversion Rate: <strong>{{ $conversionRate }}%</strong></p>
            </div>
            <div class="flex gap-3">
                <a href="{{ route('affiliate.links') }}" class="px-6 py-3 bg-white text-indigo-700 rounded-2xl text-xs font-black uppercase tracking-widest hover:scale-105 transition">🔗 My Links</a>
                <a href="{{ route('affiliate.analytics') }}" class="px-6 py-3 bg-indigo-500/40 border border-indigo-300/30 text-white rounded-2xl text-xs font-black uppercase tracking-widest hover:bg-indigo-500/60 transition">📊 Analytics</a>
            </div>
        </div>
        <div class="absolute -right-10 -bottom-10 text-[160px] opacity-5 select-none font-black">AFF</div>
    </div>

    {{-- Stats Cards --}}
    <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
        <div class="bg-white dark:bg-slate-900 rounded-3xl border border-slate-100 dark:border-slate-800 p-6 shadow-sm">
            <div class="text-2xl font-black text-emerald-600">৳{{ number_format($totalEarnings, 2) }}</div>
            <div class="text-[10px] font-black text-slate-400 uppercase tracking-widest mt-1">Total Earned</div>
        </div>
        <div class="bg-white dark:bg-slate-900 rounded-3xl border border-slate-100 dark:border-slate-800 p-6 shadow-sm">
            <div class="text-2xl font-black text-amber-500">৳{{ number_format($pendingEarnings, 2) }}</div>
            <div class="text-[10px] font-black text-slate-400 uppercase tracking-widest mt-1">Pending</div>
        </div>
        <div class="bg-white dark:bg-slate-900 rounded-3xl border border-slate-100 dark:border-slate-800 p-6 shadow-sm">
            <div class="text-2xl font-black text-primary">{{ number_format($totalClicks) }}</div>
            <div class="text-[10px] font-black text-slate-400 uppercase tracking-widest mt-1">Total Clicks</div>
        </div>
        <div class="bg-white dark:bg-slate-900 rounded-3xl border border-slate-100 dark:border-slate-800 p-6 shadow-sm">
            <div class="text-2xl font-black text-slate-800 dark:text-white">{{ number_format($totalConversions) }}</div>
            <div class="text-[10px] font-black text-slate-400 uppercase tracking-widest mt-1">Conversions</div>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
        {{-- Recent Commissions --}}
        <div class="bg-white dark:bg-slate-900 rounded-3xl border border-slate-100 dark:border-slate-800 overflow-hidden shadow-sm">
            <div class="px-8 py-5 border-b border-slate-50 dark:border-slate-800 flex items-center justify-between">
                <h4 class="text-[10px] font-black uppercase tracking-[0.2em] text-slate-400">Recent Commissions</h4>
                <a href="{{ route('affiliate.commissions') }}" class="text-[10px] font-black text-primary uppercase">View All →</a>
            </div>
            <div class="divide-y divide-slate-50 dark:divide-slate-800">
                @forelse($recentCommissions as $c)
                <div class="px-8 py-4 flex items-center justify-between">
                    <div>
                        <p class="text-sm font-black text-slate-800 dark:text-white">Order #{{ $c->order_id }}</p>
                        <p class="text-[10px] text-slate-400 font-bold">₳{{ number_format($c->order_amount, 2) }} order · {{ $c->created_at->diffForHumans() }}</p>
                    </div>
                    <div class="text-right">
                        <p class="text-sm font-black text-emerald-600">+৳{{ number_format($c->commission_amount, 2) }}</p>
                        @php $cColor = match($c->status) { 'approved' => 'emerald', 'pending' => 'amber', default => 'slate' }; @endphp
                        <span class="text-[9px] font-black uppercase bg-{{ $cColor }}-50 text-{{ $cColor }}-600 px-2 py-0.5 rounded-full">{{ $c->status }}</span>
                    </div>
                </div>
                @empty
                <div class="px-8 py-12 text-center text-sm text-slate-400 font-bold">No commissions yet. Share your links!</div>
                @endforelse
            </div>
        </div>

        {{-- Top Performing Links --}}
        <div class="bg-white dark:bg-slate-900 rounded-3xl border border-slate-100 dark:border-slate-800 overflow-hidden shadow-sm">
            <div class="px-8 py-5 border-b border-slate-50 dark:border-slate-800 flex items-center justify-between">
                <h4 class="text-[10px] font-black uppercase tracking-[0.2em] text-slate-400">Top Links</h4>
                <a href="{{ route('affiliate.links') }}" class="text-[10px] font-black text-primary uppercase">Manage →</a>
            </div>
            <div class="divide-y divide-slate-50 dark:divide-slate-800">
                @forelse($topLinks as $link)
                <div class="px-8 py-4 flex items-center justify-between gap-4">
                    <div class="flex-1 min-w-0">
                        <p class="text-sm font-black text-slate-800 dark:text-white truncate">{{ $link->product->name }}</p>
                        <p class="text-[10px] font-mono text-primary truncate">{{ url('/ref/' . $link->code) }}</p>
                    </div>
                    <div class="text-right flex-shrink-0">
                        <p class="text-sm font-black text-slate-800 dark:text-white">{{ number_format($link->clicks) }}</p>
                        <p class="text-[9px] text-slate-400 font-bold uppercase">Clicks</p>
                    </div>
                </div>
                @empty
                <div class="px-8 py-12 text-center text-sm text-slate-400 font-bold">No links yet. <a href="{{ route('affiliate.links') }}" class="text-primary underline">Generate one.</a></div>
                @endforelse
            </div>
        </div>
    </div>
</div>
@endsection
