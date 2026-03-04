@extends('layouts.customer')

@section('title', 'Merchant Hub - CMarket')
@section('page-title', 'Business Intelligence')

@section('content')
<div class="space-y-10 animate-fade-in">
    <!-- Merchant Overview Header -->
    <div class="bg-slate-900 rounded-[2.5rem] p-10 text-white shadow-2xl shadow-slate-900/10 relative overflow-hidden group">
        <div class="relative z-10 flex flex-col lg:flex-row justify-between items-start lg:items-center gap-10">
            <div>
                <div class="flex items-center gap-3 mb-6">
                    <span class="px-4 py-2 bg-emerald-500 rounded-2xl text-[10px] font-black uppercase tracking-[0.2em] shadow-lg shadow-emerald-500/20">
                        Official Merchant
                    </span>
                    <span class="text-white/40 text-[10px] font-black uppercase tracking-widest">Store Operations Live</span>
                </div>
                <h2 class="text-4xl font-black mb-4 tracking-tight leading-none">
                    {{ Auth::user()->merchant->business_name ?? 'Your Business Store' }}
                </h2>
                <p class="text-slate-400 text-xs font-bold font-mono">Managed Operations • Verified Supplier Account</p>
            </div>
            
            <div class="flex flex-wrap gap-4">
                <a href="{{ route('merchant.products.create') }}" class="px-8 py-4 bg-white/5 border border-white/10 backdrop-blur-xl rounded-2xl font-black text-[10px] uppercase tracking-[0.2em] hover:bg-white/10 transition-all flex items-center gap-3">
                    <span class="text-lg">➕</span> Add Product
                </a>
                <a href="{{ route('merchant.orders.index') }}" class="px-8 py-4 bg-white text-slate-900 rounded-2xl font-black text-[10px] uppercase tracking-[0.2em] hover:bg-emerald-500 hover:text-white transition-all shadow-xl shadow-white/5 flex items-center gap-3">
                    <span class="text-lg">🛍️</span> View Orders
                </a>
            </div>
        </div>
        <!-- Background Asset -->
        <div class="absolute -right-10 -top-10 opacity-5 text-[300px] leading-none select-none font-black italic group-hover:scale-110 transition-transform duration-1000">🏪</div>
    </div>

    <!-- Metrics Grid -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
        <div class="bg-white rounded-[2rem] p-8 border border-slate-100 shadow-sm relative overflow-hidden group hover:-translate-y-2 transition-all">
            <p class="text-[10px] font-black text-slate-400 uppercase tracking-widest mb-6">Total Catalog</p>
            <h3 class="text-4xl font-black text-slate-800 mb-2">{{ number_format(Auth::user()->merchant?->products()->count() ?? 0) }}</h3>
            <p class="text-[10px] font-black text-sky-500 uppercase tracking-tighter">Listed SKU's</p>
            <div class="absolute -right-4 -top-4 opacity-5 text-7xl select-none group-hover:scale-110 transition-transform">📦</div>
        </div>

        <div class="bg-white rounded-[2rem] p-8 border border-slate-100 shadow-sm relative overflow-hidden group hover:-translate-y-2 transition-all">
            <p class="text-[10px] font-black text-slate-400 uppercase tracking-widest mb-6">Cumulative Sales</p>
            <h3 class="text-4xl font-black text-slate-800 mb-2">{{ number_format(Auth::user()->merchant?->orders()->count() ?? 0) }}</h3>
            <p class="text-[10px] font-black text-emerald-500 uppercase tracking-tighter">Gross Order Volume</p>
            <div class="absolute -right-4 -top-4 opacity-5 text-7xl select-none group-hover:scale-110 transition-transform">🛒</div>
        </div>

        <div class="bg-white rounded-[2rem] p-8 border border-slate-100 shadow-sm relative overflow-hidden group hover:-translate-y-2 transition-all">
            <p class="text-[10px] font-black text-slate-400 uppercase tracking-widest mb-6">Store Liquidity</p>
            <h3 class="text-4xl font-black text-slate-800 mb-2">৳{{ number_format(Auth::user()->getWallet('shop')?->balance ?? 0, 2) }}</h3>
            <p class="text-[10px] font-black text-indigo-500 uppercase tracking-tighter">Shop Wallet Balance</p>
            <div class="absolute -right-4 -top-4 opacity-5 text-7xl select-none group-hover:scale-110 transition-transform">💰</div>
        </div>

        <div class="bg-white rounded-[2rem] p-8 border border-slate-100 shadow-sm relative overflow-hidden group hover:-translate-y-2 transition-all">
            <p class="text-[10px] font-black text-slate-400 uppercase tracking-widest mb-6">Active Pipeline</p>
            <h3 class="text-4xl font-black text-rose-500 mb-2">{{ number_format(Auth::user()->merchant?->orders()->where('status', 'pending')->count() ?? 0) }}</h3>
            <p class="text-[10px] font-black text-rose-400 uppercase tracking-tighter">Pending Fulfillment</p>
            <div class="absolute -right-4 -top-4 opacity-5 text-7xl select-none group-hover:scale-110 transition-transform">🕒</div>
        </div>
    </div>

    <!-- Rapid Management Grid -->
    <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
        <!-- Quick Stats/Graph Placeholder -->
        <div class="bg-white rounded-[2.5rem] p-8 border border-slate-100 shadow-sm">
            <h3 class="text-sm font-black text-slate-800 uppercase tracking-widest mb-8">Performance Trajectory</h3>
            <div class="h-64 bg-slate-50 rounded-3xl flex items-center justify-center border-2 border-dashed border-slate-200">
                <p class="text-xs font-black text-slate-300 uppercase tracking-[0.2em]">Sales Visualization Coming Soon</p>
            </div>
        </div>

        <!-- Utility Navigation -->
        <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
            <a href="{{ route('merchant.products.index') }}" class="group bg-white p-8 rounded-[2rem] border border-slate-100 shadow-sm hover:shadow-xl hover:bg-slate-900 transition-all duration-500">
                <div class="w-14 h-14 rounded-2xl bg-slate-50 flex items-center justify-center text-2xl mb-6 group-hover:bg-white/10 group-hover:scale-110 transition-all">📦</div>
                <h4 class="text-lg font-black text-slate-800 group-hover:text-white transition-colors">Inventory</h4>
                <p class="text-[10px] font-bold text-slate-400 group-hover:text-slate-400 transition-colors uppercase tracking-widest mt-2">Manage Store SKU's</p>
            </a>

            <a href="{{ route('merchant.reports.sales') }}" class="group bg-white p-8 rounded-[2rem] border border-slate-100 shadow-sm hover:shadow-xl hover:bg-emerald-600 transition-all duration-500">
                <div class="w-14 h-14 rounded-2xl bg-slate-50 flex items-center justify-center text-2xl mb-6 group-hover:bg-white/10 group-hover:scale-110 transition-all">📈</div>
                <h4 class="text-lg font-black text-slate-800 group-hover:text-white transition-colors">Analytics</h4>
                <p class="text-[10px] font-bold text-slate-400 group-hover:text-emerald-100/70 transition-colors uppercase tracking-widest mt-2">Sales Intelligence</p>
            </a>

            <a href="{{ route('merchant.orders.index') }}" class="group bg-white p-8 rounded-[2rem] border border-slate-100 shadow-sm hover:shadow-xl hover:bg-sky-600 transition-all duration-500">
                <div class="w-14 h-14 rounded-2xl bg-slate-50 flex items-center justify-center text-2xl mb-6 group-hover:bg-white/10 group-hover:scale-110 transition-all">🛒</div>
                <h4 class="text-lg font-black text-slate-800 group-hover:text-white transition-colors">Orders</h4>
                <p class="text-[10px] font-bold text-slate-400 group-hover:text-sky-100/70 transition-colors uppercase tracking-widest mt-2">Order Fulfillment</p>
            </a>

            <a href="{{ route('customer.profile') }}" class="group bg-white p-8 rounded-[2rem] border border-slate-100 shadow-sm hover:shadow-xl hover:bg-indigo-600 transition-all duration-500">
                <div class="w-14 h-14 rounded-2xl bg-slate-50 flex items-center justify-center text-2xl mb-6 group-hover:bg-white/10 group-hover:scale-110 transition-all">⚙️</div>
                <h4 class="text-lg font-black text-slate-800 group-hover:text-white transition-colors">Settings</h4>
                <p class="text-[10px] font-bold text-slate-400 group-hover:text-indigo-100/70 transition-colors uppercase tracking-widest mt-2">Shop Configuration</p>
            </a>
        </div>
    </div>
</div>
@endsection
