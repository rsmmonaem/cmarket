@extends('layouts.merchant')

@section('title', 'Sales Intelligence - EcomMatrix')
@section('page-title', 'Revenue Analytics Vector')

@section('content')
<div class="space-y-10 animate-fade-in pb-10">
    <!-- Analysis Controls -->
    <div class="bg-white rounded-[3rem] p-10 lg:p-12 border border-slate-100 shadow-sm flex flex-col lg:flex-row justify-between items-center gap-10 overflow-hidden relative group">
        <div class="relative z-10 w-full lg:w-auto text-center lg:text-left">
            <h2 class="text-3xl font-black text-slate-800 tracking-tight leading-none mb-4 uppercase">Analytical Terminal</h2>
            <p class="text-slate-400 font-bold text-[10px] uppercase tracking-[0.2em] ml-1">Marketplace Performance Metrics • Real-time Data Feed</p>
        </div>
        
        <div class="flex flex-wrap items-center gap-4 relative z-10 w-full lg:w-auto justify-center lg:justify-start">
            <input type="date" class="px-6 py-4 bg-slate-50 border-none rounded-2xl text-[10px] font-black uppercase tracking-widest text-slate-800 focus:ring-4 focus:ring-primary/10">
            <span class="text-slate-300 font-black">TO</span>
            <input type="date" class="px-6 py-4 bg-slate-50 border-none rounded-2xl text-[10px] font-black uppercase tracking-widest text-slate-800 focus:ring-4 focus:ring-primary/10">
            <button class="px-10 py-5 bg-slate-900 text-white rounded-2xl font-black text-[10px] uppercase tracking-widest shadow-2xl shadow-slate-900/10 hover:bg-primary transition-all">
                Execute Filter
            </button>
        </div>
    </div>

    <!-- Analytics Matrix -->
    <div class="grid grid-cols-1 lg:grid-cols-4 gap-8">
        <div class="card-premium p-8 bg-white border-slate-100">
            <p class="text-[10px] font-black text-slate-400 uppercase tracking-widest mb-6">Gross Transaction Vol.</p>
            <h3 class="text-3xl font-black text-slate-800 mb-2 tracking-tighter">৳0.00</h3>
            <div class="flex items-center gap-2 text-[10px] font-black text-emerald-500 uppercase">
                <span>↑ 0%</span>
                <span class="text-slate-400 font-medium">vs Prev. Period</span>
            </div>
        </div>

        <div class="card-premium p-8 bg-white border-slate-100">
            <p class="text-[10px] font-black text-slate-400 uppercase tracking-widest mb-6">Net Settlement</p>
            <h3 class="text-3xl font-black text-slate-800 mb-2 tracking-tighter">৳0.00</h3>
            <p class="text-[10px] font-black text-sky-500 uppercase tracking-tighter">Liquidated Logic</p>
        </div>

        <div class="card-premium p-8 bg-white border-slate-100">
            <p class="text-[10px] font-black text-slate-400 uppercase tracking-widest mb-6">System Commission</p>
            <h3 class="text-3xl font-black text-rose-500 mb-2 tracking-tighter">-৳0.00</h3>
            <p class="text-[10px] font-black text-slate-400 uppercase tracking-tighter">Platform Protocol Fee</p>
        </div>

        <div class="card-premium p-8 bg-white border-slate-100">
            <p class="text-[10px] font-black text-slate-400 uppercase tracking-widest mb-6">Average Order Value</p>
            <h3 class="text-3xl font-black text-slate-800 mb-2 tracking-tighter">৳0.00</h3>
            <p class="text-[10px] font-black text-indigo-500 uppercase tracking-tighter">Cart Efficiency Index</p>
        </div>
    </div>

    <!-- Performance Visualization -->
    <div class="card-premium p-10 bg-white border-slate-100 h-[500px] flex flex-col">
        <div class="flex items-center justify-between mb-10">
            <h3 class="text-sm font-black text-slate-800 uppercase tracking-widest">Revenue Propagation Matrix</h3>
            <button class="px-6 py-3 bg-slate-50 text-slate-400 hover:text-primary rounded-xl text-[9px] font-black uppercase tracking-widest transition-all">
                Export Data Protocol (.CSV)
            </button>
        </div>
        <div class="flex-1 min-h-0 relative flex flex-col items-center justify-center opacity-30">
            <span class="text-8xl mb-6">📈</span>
            <p class="text-[10px] font-black uppercase tracking-[0.3em] text-slate-400">Waiting for data injection...</p>
        </div>
    </div>
</div>
@endsection
