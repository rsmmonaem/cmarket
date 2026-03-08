@extends('layouts.admin')

@section('title', 'Sales Report - CMarket')
@section('page-title', 'Sales Report')

@section('content')
<div class="space-y-10 animate-fade-in">
    <div class="card-premium p-8 md:p-12 bg-[#0f172a] text-white border-none shadow-2xl relative overflow-hidden group">
        <div class="relative z-10 flex flex-col md:flex-row justify-between items-center gap-8">
            <div>
                <h2 class="text-3xl md:text-5xl font-black tracking-tighter uppercase mb-2">Sales Analytics</h2>
                <p class="text-slate-400 font-bold text-[10px] uppercase tracking-[0.2em]">Platform Revenue Flux • Aggregated Data</p>
            </div>
            <div class="flex gap-4">
                <div class="px-8 py-5 rounded-3xl bg-white/5 border border-white/10 backdrop-blur-md text-center">
                    <div class="text-[9px] font-black text-sky-400 uppercase mb-1">Gross Yield</div>
                    <div class="text-2xl font-black">৳{{ number_format(\App\Models\Order::where('status', 'paid')->sum('total_amount'), 2) }}</div>
                </div>
            </div>
        </div>
        <div class="absolute -right-10 -bottom-10 opacity-5 text-[200px] leading-none select-none italic font-black group-hover:scale-110 transition-transform duration-1000">DATA</div>
    </div>

    <div class="bg-white dark:bg-slate-900 rounded-[3rem] border border-slate-100 dark:border-slate-800 shadow-sm overflow-hidden">
        <table class="w-full text-left border-collapse">
            <thead>
                <tr class="bg-slate-50/50 dark:bg-slate-800/50">
                    <th class="px-10 py-6 text-[10px] font-black uppercase tracking-[0.2em] text-slate-400">Order ID</th>
                    <th class="px-10 py-6 text-[10px] font-black uppercase tracking-[0.2em] text-slate-400">Timestamp</th>
                    <th class="px-10 py-6 text-[10px] font-black uppercase tracking-[0.2em] text-slate-400">Customer Node</th>
                    <th class="px-10 py-6 text-[10px] font-black uppercase tracking-[0.2em] text-slate-400 text-right">Magnitude</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-slate-50 dark:divide-slate-800">
                @foreach($orders as $order)
                    <tr class="group hover:bg-slate-50/50 transition-colors">
                        <td class="px-10 py-6 text-xs font-black text-slate-800 dark:text-white uppercase tracking-tighter">#{{ $order->id }}</td>
                        <td class="px-10 py-6 text-[10px] font-bold text-slate-400 uppercase tracking-widest">{{ $order->created_at->format('d M Y • H:i') }}</td>
                        <td class="px-10 py-6">
                            <div class="text-[10px] font-black text-slate-800 dark:text-white uppercase">{{ $order->user->name }}</div>
                            <div class="text-[9px] font-bold text-sky-500">{{ $order->user->phone }}</div>
                        </td>
                        <td class="px-10 py-6 text-right text-sm font-black text-emerald-500">৳{{ number_format($order->total_amount, 2) }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
        <div class="p-10 border-t border-slate-50 dark:border-slate-800">
            {{ $orders->links() }}
        </div>
    </div>
</div>
@endsection
