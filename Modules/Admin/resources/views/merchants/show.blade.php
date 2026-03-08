@extends('layouts.admin')

@section('title', 'Merchant Profile - ' . $merchant->business_name)
@section('page-title', 'Merchant Profile: ' . $merchant->business_name)

@section('content')
<div class="space-y-10 animate-fade-in">
    <!-- Header / Status Ribbon -->
    <div class="card-premium bg-[#0f172a] p-8 md:p-12 text-white border-none shadow-2xl relative overflow-hidden group">
        <div class="relative z-10 flex flex-col md:flex-row justify-between items-start md:items-center gap-8">
            <div class="space-y-4">
                <div class="flex items-center gap-3">
                    <span class="px-4 py-1.5 bg-primary/20 text-primary rounded-xl text-[10px] font-black uppercase tracking-[0.2em] border border-primary/30">
                        Merchant #{{ $merchant->id }}
                    </span>
                    @if($merchant->status === 'approved')
                        <span class="px-4 py-1.5 bg-emerald-500/20 text-emerald-400 rounded-xl text-[10px] font-black uppercase tracking-[0.2em] border border-emerald-500/30">
                            Verified & Live
                        </span>
                    @elseif($merchant->status === 'pending')
                        <span class="px-4 py-1.5 bg-amber-500/20 text-amber-400 rounded-xl text-[10px] font-black uppercase tracking-[0.2em] border border-amber-500/30">
                            Pending Approval
                        </span>
                    @else
                        <span class="px-4 py-1.5 bg-rose-500/20 text-rose-400 rounded-xl text-[10px] font-black uppercase tracking-[0.2em] border border-rose-500/30">
                            Station Offline
                        </span>
                    @endif
                </div>
                <h2 class="text-3xl md:text-5xl font-black tracking-tight leading-none uppercase">{{ $merchant->business_name }}</h2>
                <p class="text-slate-400 font-bold text-xs uppercase tracking-widest">{{ $merchant->business_type }} • Established {{ $merchant->created_at->format('M Y') }}</p>
            </div>

            <div class="flex flex-wrap gap-3">
                @if($merchant->status === 'pending')
                    <form action="{{ route('admin.merchants.approve', $merchant) }}" method="POST">
                        @csrf
                        <button type="submit" class="px-8 py-4 bg-emerald-500 text-white rounded-2xl font-black text-[10px] uppercase tracking-[0.2em] hover:bg-emerald-400 transition-all shadow-xl shadow-emerald-500/20">
                            ✓ Authorize Record
                        </button>
                    </form>
                    <form action="{{ route('admin.merchants.reject', $merchant) }}" method="POST">
                        @csrf
                        <button type="submit" class="px-8 py-4 bg-white/5 border border-white/10 text-rose-400 rounded-2xl font-black text-[10px] uppercase tracking-[0.2em] hover:bg-rose-500 hover:text-white transition-all">
                            ✗ Deny Application
                        </button>
                    </form>
                @elseif($merchant->status === 'approved')
                    <form action="{{ route('admin.merchants.suspend', $merchant) }}" method="POST">
                        @csrf
                        <button type="submit" class="px-8 py-4 bg-white/5 border border-white/10 text-amber-400 rounded-2xl font-black text-[10px] uppercase tracking-[0.2em] hover:bg-amber-500 hover:text-white transition-all">
                            🚫 Suspend Operation
                        </button>
                    </form>
                @endif
            </div>
        </div>
        <div class="absolute -right-10 -bottom-10 opacity-5 text-[240px] leading-none select-none italic font-black group-hover:scale-110 transition-transform duration-1000">EST</div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-10">
        <!-- Profile Info -->
        <div class="lg:col-span-2 space-y-10">
            <!-- Information Clusters -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                <!-- Business Cluster -->
                <div class="card-premium p-8 md:p-10 bg-white dark:bg-slate-900 border-slate-100 dark:border-slate-800 shadow-sm relative overflow-hidden group">
                    <h3 class="text-[10px] font-black text-slate-400 uppercase tracking-[0.2em] mb-8 flex items-center gap-2">
                        <span class="w-2 h-2 bg-primary rounded-full"></span> Business Intelligence
                    </h3>
                    <div class="space-y-6">
                        <div>
                            <p class="text-[9px] font-black text-slate-400 uppercase tracking-widest mb-1">Record Name</p>
                            <p class="text-sm font-black text-slate-800 dark:text-white uppercase">{{ $merchant->business_name }}</p>
                        </div>
                        <div>
                            <p class="text-[9px] font-black text-slate-400 uppercase tracking-widest mb-1">Trade Sector</p>
                            <p class="text-sm font-black text-slate-800 dark:text-white uppercase">{{ $merchant->business_type }}</p>
                        </div>
                        <div>
                            <p class="text-[9px] font-black text-slate-400 uppercase tracking-widest mb-1">Physical Coordinates</p>
                            <p class="text-sm font-bold text-slate-600 dark:text-slate-300 leading-relaxed">{{ $merchant->address }}</p>
                        </div>
                    </div>
                </div>

                <!-- Account Cluster -->
                <div class="card-premium p-8 md:p-10 bg-white dark:bg-slate-900 border-slate-100 dark:border-slate-800 shadow-sm">
                    <h3 class="text-[10px] font-black text-slate-400 uppercase tracking-[0.2em] mb-8 flex items-center gap-2">
                        <span class="w-2 h-2 bg-accent rounded-full"></span> Approval
                    </h3>
                    <div class="space-y-6">
                        <div>
                            <p class="text-[9px] font-black text-slate-400 uppercase tracking-widest mb-1">Root User</p>
                            <p class="text-sm font-black text-slate-800 dark:text-white uppercase">{{ $merchant->user->name }}</p>
                        </div>
                        <div>
                            <p class="text-[9px] font-black text-slate-400 uppercase tracking-widest mb-1">Contact</p>
                            <p class="text-sm font-black text-primary tracking-tight">{{ $merchant->phone }}</p>
                            <p class="text-[10px] font-bold text-slate-400 mt-1">{{ $merchant->email ?? $merchant->user->email }}</p>
                        </div>
                        <div>
                            <p class="text-[9px] font-black text-slate-400 uppercase tracking-widest mb-1">Identity Status</p>
                            <span class="inline-flex px-3 py-1 bg-slate-100 dark:bg-slate-800 rounded-lg text-[9px] font-black text-slate-600 dark:text-slate-400 uppercase">
                                {{ ucfirst($merchant->user->status) }} ROLE
                            </span>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Active Activity -->
            <div class="card-premium p-8 md:p-10 bg-white dark:bg-slate-900 border-slate-100 dark:border-slate-800 shadow-sm">
                <h3 class="text-[10px] font-black text-slate-400 uppercase tracking-[0.2em] mb-8 flex items-center gap-2">
                    <span class="w-2 h-2 bg-emerald-500 rounded-full"></span> Performance Overview
                </h3>
                <div class="grid grid-cols-2 lg:grid-cols-4 gap-6">
                    <div class="p-6 bg-slate-50 dark:bg-slate-800/50 rounded-2xl border border-slate-100 dark:border-slate-800">
                        <p class="text-[9px] font-black text-slate-400 uppercase tracking-widest mb-2">Stored Assets</p>
                        <p class="text-2xl font-black text-slate-800 dark:text-white leading-none tracking-tighter">{{ $merchant->products()->count() }}</p>
                    </div>
                    <div class="p-6 bg-slate-50 dark:bg-slate-800/50 rounded-2xl border border-slate-100 dark:border-slate-800">
                        <p class="text-[9px] font-black text-slate-400 uppercase tracking-widest mb-2">Order Vol.</p>
                        <p class="text-2xl font-black text-slate-800 dark:text-white leading-none tracking-tighter">{{ $merchant->orders()->count() }}</p>
                    </div>
                    <div class="p-6 bg-slate-50 dark:bg-slate-800/50 rounded-2xl border border-slate-100 dark:border-slate-800">
                        <p class="text-[9px] font-black text-slate-400 uppercase tracking-widest mb-2">Revenue Node</p>
                        <p class="text-2xl font-black text-slate-800 dark:text-white leading-none tracking-tighter">৳0</p>
                    </div>
                    <div class="p-6 bg-slate-50 dark:bg-slate-800/50 rounded-2xl border border-slate-100 dark:border-slate-800">
                        <p class="text-[9px] font-black text-slate-400 uppercase tracking-widest mb-2">Rating index</p>
                        <p class="text-sm font-black text-amber-500 leading-none tracking-widest">NO DATA</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- System Intelligence Sidebar -->
        <div class="space-y-10">
            <div class="card-premium p-8 bg-slate-950 text-white border-none shadow-2xl relative overflow-hidden group">
                <div class="relative z-10">
                    <h3 class="text-[10px] font-black text-sky-400 uppercase tracking-[0.2em] mb-8">Node Financials</h3>
                    <div class="space-y-6">
                        <div class="p-6 rounded-2xl bg-white/5 border border-white/10 backdrop-blur-sm">
                            <p class="text-[9px] font-black text-slate-400 uppercase tracking-widest mb-2">Primary Wallet</p>
                            <div class="flex items-end gap-2">
                                <span class="text-3xl font-black tracking-tighter">৳{{ number_format($merchant->user->getWallet('shop')?->balance ?? 0, 2) }}</span>
                                <span class="text-[9px] font-black text-sky-400 uppercase mb-1">PROT-SHOP</span>
                            </div>
                        </div>
                        <div class="space-y-3">
                            <button class="w-full py-4 bg-white/5 hover:bg-white/10 border border-white/10 rounded-2xl font-black text-[9px] uppercase tracking-widest transition-all">
                                Adjust Liquidity
                            </button>
                            <button class="w-full py-4 bg-white/5 hover:bg-white/10 border border-white/10 rounded-2xl font-black text-[9px] uppercase tracking-widest transition-all">
                                Transaction Logs
                            </button>
                        </div>
                    </div>
                </div>
                <div class="absolute -right-4 -bottom-4 opacity-10 text-6xl italic font-black select-none pointer-events-none">BANK</div>
            </div>

            <!-- Documents Cache -->
            <div class="card-premium p-8 bg-white dark:bg-slate-900 border-slate-100 dark:border-slate-800 shadow-sm">
                <h3 class="text-[10px] font-black text-slate-400 uppercase tracking-[0.2em] mb-8">Asset Documents</h3>
                <div class="space-y-4 text-center py-10 opacity-30">
                    <span class="text-5xl mb-4 block">📄</span>
                    <p class="text-[10px] font-black uppercase tracking-widest">No verified docs uploaded</p>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
