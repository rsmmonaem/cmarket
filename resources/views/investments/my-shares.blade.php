@extends('layouts.customer')

@section('title', 'My Share Portfolio')
@section('page-title', 'My Investment Portfolio')

@section('content')
<div class="space-y-8">
    <!-- Portfolio Summary -->
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
        <div class="bg-slate-900 rounded-3xl p-6 text-white shadow-xl relative overflow-hidden">
            <div class="relative z-10">
                <p class="text-[10px] font-black uppercase tracking-widest text-slate-400 mb-2">Total Invested</p>
                <h3 class="text-3xl font-black">৳{{ number_format($purchases->sum('total_amount'), 2) }}</h3>
            </div>
            <div class="absolute -right-4 -bottom-4 opacity-10 text-6xl">🏢</div>
        </div>

        <div class="bg-white rounded-3xl p-6 border border-slate-100 shadow-sm relative overflow-hidden">
            <p class="text-[10px] font-black uppercase tracking-widest text-muted-light mb-2">Total Shares Held</p>
            <h3 class="text-3xl font-black text-slate-800">{{ number_format($purchases->sum('shares')) }}</h3>
            <div class="absolute -right-4 -bottom-4 opacity-10 text-6xl">💎</div>
        </div>

        <div class="bg-white rounded-3xl p-6 border border-slate-100 shadow-sm relative overflow-hidden">
            <p class="text-[10px] font-black uppercase tracking-widest text-muted-light mb-2">Unique Projects</p>
            <h3 class="text-3xl font-black text-slate-800">{{ $purchases->groupBy('chain_shop_id')->count() }}</h3>
            <div class="absolute -right-4 -bottom-4 opacity-10 text-6xl">🏗️</div>
        </div>
    </div>

    <!-- Purchases Table -->
    <div class="bg-white rounded-[2rem] border border-slate-100 shadow-sm overflow-hidden">
        <div class="p-8 border-b border-slate-50 flex items-center justify-between">
            <div>
                <h3 class="text-lg font-black text-slate-800 uppercase tracking-tight">Recent Purchases</h3>
                <p class="text-[10px] font-bold text-muted-light uppercase tracking-widest mt-1">History of your share acquisitions</p>
            </div>
            <a href="{{ route('investments.index') }}" class="bg-sky-500 hover:bg-sky-400 text-white text-[10px] font-black px-6 py-3 rounded-xl transition-all shadow-lg shadow-sky-500/20">
                INVEST MORE 💰
            </a>
        </div>

        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse">
                <thead>
                    <tr class="bg-slate-50/50">
                        <th class="p-6 text-[10px] font-black text-slate-500 uppercase tracking-widest">Project</th>
                        <th class="p-6 text-[10px] font-black text-slate-500 uppercase tracking-widest text-center">Shares</th>
                        <th class="p-6 text-[10px] font-black text-slate-500 uppercase tracking-widest">Price/Share</th>
                        <th class="p-6 text-[10px] font-black text-slate-500 uppercase tracking-widest">Total Value</th>
                        <th class="p-6 text-[10px] font-black text-slate-500 uppercase tracking-widest text-right">Date</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-50">
                    @forelse($purchases as $p)
                        <tr class="hover:bg-slate-50/50 transition-colors group">
                            <td class="p-6">
                                <div class="flex items-center gap-4">
                                    <div class="w-10 h-10 rounded-xl bg-slate-100 flex items-center justify-center text-xl group-hover:scale-110 transition-transform">🏢</div>
                                    <div>
                                        <p class="text-sm font-black text-slate-800">{{ $p->chainShop->name }}</p>
                                        <p class="text-[10px] font-bold text-muted-light">Ref: {{ $p->transaction_reference }}</p>
                                    </div>
                                </div>
                            </td>
                            <td class="p-6 text-center">
                                <span class="bg-sky-50 text-sky-600 px-3 py-1 rounded-lg text-xs font-black">{{ $p->shares }}</span>
                            </td>
                            <td class="p-6 font-bold text-sm text-slate-700">
                                ৳{{ number_format($p->price_per_share, 2) }}
                            </td>
                            <td class="p-6">
                                <p class="text-sm font-black text-slate-800">৳{{ number_format($p->total_amount, 2) }}</p>
                            </td>
                            <td class="p-6 text-right">
                                <p class="text-[11px] font-black text-slate-800">{{ $p->created_at->format('M d, Y') }}</p>
                                <p class="text-[9px] font-bold text-muted-light">{{ $p->created_at->format('h:i A') }}</p>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="p-20 text-center">
                                <div class="text-6xl mb-6 grayscale opacity-20">💰</div>
                                <h4 class="text-xl font-black text-slate-300 uppercase tracking-widest">No Investments Yet</h4>
                                <p class="text-xs font-bold text-muted-light mt-2 mb-8">Start building your portfolio by investing in prime shops.</p>
                                <a href="{{ route('investments.index') }}" class="inline-flex bg-slate-900 text-white font-black px-10 py-4 rounded-2xl shadow-xl shadow-slate-900/10 hover:scale-105 transition-all">
                                    EXPLORE OPPORTUNITIES
                                </a>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
