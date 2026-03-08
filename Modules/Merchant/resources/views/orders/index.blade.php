@extends('layouts.merchant')

@section('title', 'Order Management - Dispatch Hub')
@section('page-title', 'Global Order Dispatch Registry')

@section('content')
<div class="space-y-10 animate-fade-in">
    <!-- Section Header -->
    <div class="bg-white rounded-[3rem] p-10 lg:p-12 border border-slate-100 shadow-sm flex flex-col lg:flex-row justify-between items-center gap-10 overflow-hidden relative group">
        <div class="relative z-10 w-full lg:w-auto text-center lg:text-left">
            <h2 class="text-3xl font-black text-slate-800 tracking-tight leading-none mb-4 uppercase">Dispatch Control</h2>
            <p class="text-slate-400 font-bold text-[10px] uppercase tracking-[0.2em] ml-1">Operational Fleet Registry • Monitoring {{ $orders->total() }} Units</p>
        </div>
        
        <div class="flex items-center gap-4 relative z-10 w-full lg:w-auto overflow-x-auto pb-2 no-scrollbar">
            @php $currentStatus = request('status', 'all'); @endphp
            @foreach(['all' => 'All Assets', 'pending' => 'Awaiting', 'confirmed' => 'Verified', 'packaging' => 'Assembly', 'out_for_delivery' => 'Transit', 'delivered' => 'Complete'] as $val => $label)
                <a href="{{ route('merchant.orders.index', ['status' => $val]) }}" 
                   class="px-6 py-3 rounded-xl text-[9px] font-black uppercase tracking-widest whitespace-nowrap transition-all duration-300 {{ $currentStatus == $val ? 'bg-primary text-white shadow-lg shadow-primary/20 scale-105' : 'bg-slate-50 text-slate-400 hover:bg-slate-100 hover:text-slate-600' }}">
                    {{ $label }}
                </a>
            @endforeach
        </div>
        
        <div class="absolute -right-10 -bottom-10 opacity-[0.03] text-[200px] leading-none select-none italic font-black group-hover:scale-110 transition-transform duration-1000">DISPATCH</div>
    </div>

    <!-- Data Infrastructure: Order Matrix -->
    <div class="bg-white rounded-[3rem] border border-slate-100 shadow-sm overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse min-w-[1000px]">
                <thead>
                    <tr class="bg-slate-50/50">
                        <th class="px-10 py-6 text-[10px] font-black uppercase tracking-[0.2em] text-slate-400">Order Token</th>
                        <th class="px-10 py-6 text-[10px] font-black uppercase tracking-[0.2em] text-slate-400">Target Identity</th>
                        <th class="px-10 py-6 text-[10px] font-black uppercase tracking-[0.2em] text-slate-400 text-center">Unit Volume</th>
                        <th class="px-10 py-6 text-[10px] font-black uppercase tracking-[0.2em] text-slate-400 text-center">Financial Load</th>
                        <th class="px-10 py-6 text-[10px] font-black uppercase tracking-[0.2em] text-slate-400 text-center">Protocol Status</th>
                        <th class="px-10 py-6 text-[10px] font-black uppercase tracking-[0.2em] text-slate-400 text-right">Operations</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-50">
                    @forelse($orders as $item)
                        @php $order = $item->order; @endphp
                        <tr class="group hover:bg-slate-50/80 transition-all duration-300">
                            <td class="px-10 py-8">
                                <div class="text-sm font-black text-slate-800 mb-1">#{{ $order->order_number }}</div>
                                <div class="text-[9px] font-bold text-slate-400 uppercase tracking-widest">{{ $order->created_at->format('M d, Y • H:i') }}</div>
                            </td>
                            <td class="px-10 py-8">
                                <div class="text-[10px] font-black text-slate-800 uppercase tracking-widest mb-1">{{ $order->user->name }}</div>
                                <div class="text-[10px] font-bold text-sky-500">{{ $order->shipping_phone }}</div>
                            </td>
                            <td class="px-10 py-8 text-center">
                                <span class="inline-flex px-4 py-1.5 rounded-xl bg-slate-100 text-[10px] font-black text-slate-600 uppercase">
                                    {{ $order->items_count ?? 1 }} ASSETS
                                </span>
                            </td>
                            <td class="px-10 py-8 text-center">
                                <span class="text-sm font-black text-slate-800 tracking-tighter">৳{{ number_format($item->subtotal, 2) }}</span>
                            </td>
                            <td class="px-10 py-8 text-center">
                                @php
                                    $statusColors = [
                                        'pending' => 'amber',
                                        'confirmed' => 'sky',
                                        'packaging' => 'indigo',
                                        'out_for_delivery' => 'blue',
                                        'delivered' => 'emerald',
                                        'canceled' => 'rose',
                                    ];
                                    $c = $statusColors[$order->status] ?? 'slate';
                                @endphp
                                <span class="inline-flex items-center gap-2 py-2 px-4 rounded-xl text-[9px] font-black bg-{{ $c }}-50 text-{{ $c }}-600 border border-{{ $c }}-100 uppercase tracking-widest">
                                    <span class="w-1.5 h-1.5 rounded-full bg-{{ $c }}-500 {{ $order->status == 'pending' ? 'animate-pulse' : '' }}"></span>
                                    {{ str_replace('_', ' ', $order->status) }}
                                </span>
                            </td>
                            <td class="px-10 py-8 text-right">
                                <div class="flex justify-end gap-3 opacity-0 group-hover:opacity-100 transition-opacity translate-x-4 group-hover:translate-x-0 duration-300">
                                    <a href="{{ route('merchant.orders.show', $order) }}" class="px-6 py-3 rounded-xl bg-slate-900 text-white text-[9px] font-black uppercase tracking-widest hover:bg-primary transition-all shadow-xl shadow-slate-900/10">
                                        Inspect Unit ⚡
                                    </a>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="px-10 py-32 text-center text-slate-300 flex flex-col items-center">
                                <span class="text-8xl mb-6 opacity-10">🛍️</span>
                                <p class="text-xl font-black uppercase tracking-[0.2em]">Deployment Void Detected</p>
                                <p class="text-[10px] font-bold text-slate-400 mt-2 uppercase">No active orders found in the registry for this criteria.</p>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if($orders->count() > 0 && method_exists($orders, 'links'))
            <div class="px-10 py-8 border-t border-slate-50 bg-slate-50/30">
                {{ $orders->links() }}
            </div>
        @endif
    </div>
</div>
@endsection
