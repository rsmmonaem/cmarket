@extends('layouts.customer')

@section('title', 'Region Orders - ' . ucfirst($role))
@section('page-title', 'Territory Order Monitoring')

@section('content')
<div class="bg-white rounded-3xl border border-slate-100 shadow-sm overflow-hidden">
    <div class="p-6 border-b border-slate-50 flex items-center justify-between bg-slate-50/50">
        <h3 class="font-black text-slate-800 uppercase tracking-widest text-xs">Orders List</h3>
        <div class="text-[10px] font-bold text-muted-light uppercase tracking-widest">
            Total Sales: ৳{{ number_format($orders->where('status', 'delivered')->sum('total_amount'), 2) }}
        </div>
    </div>
    
    <div class="overflow-x-auto">
        <table class="w-full text-left border-collapse">
            <thead>
                <tr class="bg-slate-50/50">
                    <th class="p-4 text-[10px] font-black text-slate-500 uppercase tracking-widest">Order</th>
                    <th class="p-4 text-[10px] font-black text-slate-500 uppercase tracking-widest">Customer</th>
                    <th class="p-4 text-[10px] font-black text-slate-500 uppercase tracking-widest">Amount</th>
                    <th class="p-4 text-[10px] font-black text-slate-500 uppercase tracking-widest">Status</th>
                    <th class="p-4 text-[10px] font-black text-slate-500 uppercase tracking-widest text-right">Date</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-slate-50">
                @forelse($orders as $order)
                    <tr class="hover:bg-slate-50/50 transition-colors">
                        <td class="p-4">
                            <p class="text-sm font-black text-slate-800">#{{ $order->order_number }}</p>
                            <p class="text-[9px] font-bold text-sky-600 uppercase">{{ $order->payment_method }}</p>
                        </td>
                        <td class="p-4">
                            <p class="text-xs font-black text-slate-800">{{ $order->user->name }}</p>
                            <p class="text-[10px] font-bold text-muted-light">{{ $order->user->upazila }}</p>
                        </td>
                        <td class="p-4">
                            <p class="text-sm font-black text-slate-800">৳{{ number_format($order->total_amount, 2) }}</p>
                        </td>
                        <td class="p-4">
                            <span class="text-[9px] font-black px-2 py-0.5 rounded-full {{ $order->status == 'delivered' ? 'bg-emerald-100 text-emerald-700' : ($order->status == 'cancelled' ? 'bg-red-100 text-red-700' : 'bg-slate-100 text-slate-600') }} uppercase">
                                {{ $order->status }}
                            </span>
                        </td>
                        <td class="p-4 text-right">
                            <p class="text-[10px] font-black text-slate-800">{{ $order->created_at->format('M d, h:i A') }}</p>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="5" class="p-12 text-center">
                            <div class="text-4xl mb-4">🛒</div>
                            <p class="text-sm font-black text-slate-400 uppercase tracking-widest">No orders recorded in this region</p>
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
    
    @if($orders->hasPages())
        <div class="p-6 border-t border-slate-50">
            {{ $orders->links() }}
        </div>
    @endif
</div>
@endsection
