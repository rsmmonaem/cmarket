@extends('layouts.customer')

@section('title', 'Regional Analytics - ' . ucfirst($role))
@section('page-title', 'Territory Command Center')

@section('content')
<div class="space-y-10 animate-fade-in">
    <!-- Regional Overview Header -->
    <div class="bg-slate-900 rounded-[2.5rem] p-10 text-white shadow-2xl shadow-slate-900/10 relative overflow-hidden group">
        <div class="relative z-10 flex flex-col lg:flex-row justify-between items-start lg:items-center gap-10">
            <div>
                <div class="flex items-center gap-3 mb-6">
                    <span class="px-4 py-2 bg-sky-500 rounded-2xl text-[10px] font-black uppercase tracking-[0.2em] shadow-lg shadow-sky-500/20">
                        {{ $role }} Administrator
                    </span>
                    <span class="text-white/40 text-[10px] font-black uppercase tracking-widest">Active Territory Hub</span>
                </div>
                <h2 class="text-4xl font-black mb-4 tracking-tight leading-none">
                    @if($role == 'upazila') {{ Auth::user()->upazila }} @elseif($role == 'district') {{ Auth::user()->district }} @else {{ Auth::user()->division }} @endif
                </h2>
                <p class="text-slate-400 text-xs font-bold font-mono">Territory Command for {{ ucfirst($role) }} Level Management</p>
            </div>
            
            <div class="flex flex-wrap gap-4">
                <a href="{{ route('regional.users') }}" class="px-8 py-4 bg-white/5 border border-white/10 backdrop-blur-xl rounded-2xl font-black text-[10px] uppercase tracking-[0.2em] hover:bg-white/10 transition-all flex items-center gap-3">
                    <span class="text-lg">👥</span> Partner Network
                </a>
                <a href="{{ route('regional.orders') }}" class="px-8 py-4 bg-white text-slate-900 rounded-2xl font-black text-[10px] uppercase tracking-[0.2em] hover:bg-sky-500 hover:text-white transition-all shadow-xl shadow-white/5 flex items-center gap-3">
                    <span class="text-lg">🛍️</span> Regional Sales
                </a>
            </div>
        </div>
        <!-- Background Asset -->
        <div class="absolute -right-10 -top-10 opacity-5 text-[300px] leading-none select-none font-black italic group-hover:scale-110 transition-transform duration-1000">🌍</div>
    </div>

    <!-- Metrics Grid -->
    <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
        <div class="bg-white rounded-[2rem] p-8 border border-slate-100 shadow-sm relative overflow-hidden group hover:-translate-y-2 transition-all">
            <p class="text-[10px] font-black text-slate-400 uppercase tracking-widest mb-6">Regional Population</p>
            <h3 class="text-4xl font-black text-slate-800 mb-2">{{ number_format($stats['total_users']) }}</h3>
            <p class="text-[10px] font-black text-sky-500 uppercase tracking-tighter">Verified Partners in Area</p>
            <div class="absolute -right-4 -top-4 opacity-5 text-7xl select-none group-hover:scale-110 transition-transform">👥</div>
        </div>

        <div class="bg-white rounded-[2rem] p-8 border border-slate-100 shadow-sm relative overflow-hidden group hover:-translate-y-2 transition-all">
            <p class="text-[10px] font-black text-slate-400 uppercase tracking-widest mb-6">Territory Order Volume</p>
            <h3 class="text-4xl font-black text-slate-800 mb-2">{{ number_format($stats['total_orders']) }}</h3>
            <p class="text-[10px] font-black text-emerald-500 uppercase tracking-tighter">Processed Regional Sales</p>
            <div class="absolute -right-4 -top-4 opacity-5 text-7xl select-none group-hover:scale-110 transition-transform">🛍️</div>
        </div>

        <div class="bg-white rounded-[2rem] p-8 border border-slate-100 shadow-sm relative overflow-hidden group hover:-translate-y-2 transition-all">
            <p class="text-[10px] font-black text-slate-400 uppercase tracking-widest mb-6">Total Gross Value</p>
            <h3 class="text-4xl font-black text-slate-800 mb-2">৳{{ number_format($stats['total_sales'], 2) }}</h3>
            <p class="text-[10px] font-black text-amber-500 uppercase tracking-tighter">Regional Revenue Stream</p>
            <div class="absolute -right-4 -top-4 opacity-5 text-7xl select-none group-hover:scale-110 transition-transform">💰</div>
        </div>
    </div>

    <!-- Data Detail Section -->
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-10">
        <!-- New Recruits -->
        <div class="bg-white rounded-[2.5rem] border border-slate-100 shadow-sm overflow-hidden">
            <div class="p-8 border-b border-slate-50 flex items-center justify-between">
                <div>
                    <h3 class="text-sm font-black text-slate-800 uppercase tracking-widest">New Partnerships</h3>
                    <p class="text-[9px] font-bold text-slate-400 uppercase mt-1">Recently joined in territory</p>
                </div>
                <a href="{{ route('regional.users') }}" class="text-[10px] font-black text-sky-600 hover:gap-3 flex items-center gap-2 transition-all">FULL LOG →</a>
            </div>
            <div class="divide-y divide-slate-50">
                @forelse($stats['recent_users'] as $u)
                    <div class="p-6 hover:bg-slate-50 transition-colors flex items-center justify-between group">
                        <div class="flex items-center gap-4">
                            <div class="w-12 h-12 rounded-2xl bg-slate-100 flex items-center justify-center text-xs font-black text-slate-800 group-hover:bg-slate-900 group-hover:text-white transition-all">
                                {{ substr($u->name, 0, 1) }}
                            </div>
                            <div>
                                <p class="text-sm font-black text-slate-800">{{ $u->name }}</p>
                                <p class="text-[10px] font-bold text-slate-400 uppercase tracking-tighter">{{ $u->upazila }} • {{ $u->district }}</p>
                            </div>
                        </div>
                        <span class="px-3 py-1 rounded-lg bg-slate-100 text-[9px] font-black text-slate-500 uppercase">{{ $u->status }}</span>
                    </div>
                @empty
                    <div class="p-20 text-center opacity-30 text-xs font-black uppercase tracking-widest">No active users discovered</div>
                @endforelse
            </div>
        </div>

        <!-- Latest Sales -->
        <div class="bg-white rounded-[2.5rem] border border-slate-100 shadow-sm overflow-hidden">
            <div class="p-8 border-b border-slate-50 flex items-center justify-between">
                <div>
                    <h3 class="text-sm font-black text-slate-800 uppercase tracking-widest">Recent Grossing</h3>
                    <p class="text-[9px] font-bold text-slate-400 uppercase mt-1">Processed territory sales</p>
                </div>
                <a href="{{ route('regional.orders') }}" class="text-[10px] font-black text-emerald-600 hover:gap-3 flex items-center gap-2 transition-all">TOTAL SALES →</a>
            </div>
            <div class="divide-y divide-slate-50">
                @forelse($stats['recent_orders'] as $o)
                    <div class="p-6 hover:bg-slate-50 transition-colors flex items-center justify-between group">
                        <div class="flex items-center gap-4">
                            <div class="w-12 h-12 rounded-2xl bg-white border border-slate-100 flex items-center justify-center text-lg shadow-sm group-hover:shadow-lg group-hover:scale-105 transition-all">🛒</div>
                            <div>
                                <p class="text-sm font-black text-slate-800">#{{ $o->order_number }}</p>
                                <p class="text-[10px] font-bold text-slate-400 uppercase tracking-tighter">By {{ $o->user->name }}</p>
                            </div>
                        </div>
                        <div class="text-right">
                            <p class="text-sm font-black text-emerald-600">৳{{ number_format($o->total_amount, 2) }}</p>
                            <p class="text-[9px] font-black uppercase tracking-tighter text-slate-400">{{ $o->status }}</p>
                        </div>
                    </div>
                @empty
                    <div class="p-20 text-center opacity-30 text-xs font-black uppercase tracking-widest">No transaction volume found</div>
                @endforelse
            </div>
        </div>
    </div>
</div>
@endsection
