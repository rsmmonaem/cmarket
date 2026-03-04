@extends('layouts.admin')

@section('title', 'Order Management')
@section('page-title', 'Order Management')

@section('content')
<div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-5 gap-4 mb-10">
    <x-admin.card class="border-l-4 border-l-amber-500">
        <p class="text-[10px] font-black uppercase tracking-widest text-muted-light">Pending</p>
        <h3 class="text-2xl font-black text-light">{{ $orders->where('status', 'pending')->count() }}</h3>
    </x-admin.card>
    <x-admin.card class="border-l-4 border-l-sky-500">
        <p class="text-[10px] font-black uppercase tracking-widest text-muted-light">Processing</p>
        <h3 class="text-2xl font-black text-light">{{ $orders->where('status', 'processing')->count() }}</h3>
    </x-admin.card>
    <x-admin.card class="border-l-4 border-l-blue-500">
        <p class="text-[10px] font-black uppercase tracking-widest text-muted-light">Shipped</p>
        <h3 class="text-2xl font-black text-light">{{ $orders->where('status', 'shipped')->count() }}</h3>
    </x-admin.card>
    <x-admin.card class="border-l-4 border-l-emerald-500">
        <p class="text-[10px] font-black uppercase tracking-widest text-muted-light">Delivered</p>
        <h3 class="text-2xl font-black text-light">{{ $orders->where('status', 'delivered')->count() }}</h3>
    </x-admin.card>
    <x-admin.card class="border-l-4 border-l-slate-900 dark:border-l-slate-700">
        <p class="text-[10px] font-black uppercase tracking-widest text-muted-light">Revenue</p>
        <h3 class="text-2xl font-black text-light">৳{{ number_format($orders->where('status', 'delivered')->sum('total_amount'), 0) }}</h3>
    </x-admin.card>
</div>

<x-admin.card>
    <div class="flex flex-col lg:flex-row justify-between items-start lg:items-center gap-6 mb-8">
        <div>
            <h2 class="text-xl font-black text-light">Order Ledger</h2>
            <p class="text-xs text-muted-light font-bold uppercase tracking-widest">Track lifecycle of customer purchases</p>
        </div>
        <form method="GET" class="flex flex-wrap gap-3 w-full lg:w-auto">
            <input type="text" name="search" placeholder="Order #" value="{{ request('search') }}"
                   class="px-4 py-2.5 bg-slate-50 dark:bg-slate-800 border border-slate-200 dark:border-slate-700 rounded-xl text-xs font-bold focus:outline-none focus:ring-2 focus:ring-sky-500 transition">
            <select name="status" class="px-4 py-2.5 bg-slate-50 dark:bg-slate-800 border border-slate-200 dark:border-slate-700 rounded-xl text-xs font-bold focus:outline-none focus:ring-2 focus:ring-sky-500 transition">
                <option value="">All Status</option>
                <option value="pending">Pending</option>
                <option value="paid">Paid</option>
                <option value="processing">Processing</option>
                <option value="shipped">Shipped</option>
                <option value="delivered">Delivered</option>
            </option>
            <x-admin.button type="submit" variant="secondary">🔍</x-admin.button>
        </form>
    </div>

    <div class="overflow-x-auto -mx-6">
        <table class="w-full text-left border-collapse">
            <thead>
                <tr class="border-b border-light">
                    <th class="px-6 py-4 text-[10px] font-black uppercase tracking-widest text-muted-light">Order Info</th>
                    <th class="px-6 py-4 text-[10px] font-black uppercase tracking-widest text-muted-light">Customer</th>
                    <th class="px-6 py-4 text-[10px] font-black uppercase tracking-widest text-muted-light">Merchant</th>
                    <th class="px-6 py-4 text-[10px] font-black uppercase tracking-widest text-muted-light">Amount</th>
                    <th class="px-6 py-4 text-[10px] font-black uppercase tracking-widest text-muted-light">Status</th>
                    <th class="px-6 py-4 text-[10px] font-black uppercase tracking-widest text-muted-light text-right">Action</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-light">
                @forelse($orders as $order)
                    <tr class="group hover:bg-slate-50 dark:hover:bg-slate-800/50 transition-colors">
                        <td class="px-6 py-4">
                            <div class="text-sm font-black text-light">#{{ $order->order_number }}</div>
                            <div class="text-[10px] text-muted-light font-bold">{{ $order->created_at->format('M d, Y h:i A') }}</div>
                        </td>
                        <td class="px-6 py-4">
                            <div class="text-sm font-bold text-light">{{ $order->user->name }}</div>
                            <div class="text-[10px] text-muted-light font-bold uppercase tracking-tighter">{{ $order->user->phone }}</div>
                        </td>
                        <td class="px-6 py-4">
                            <div class="text-sm font-bold text-light line-clamp-1">{{ $order->merchant->business_name ?? 'N/A' }}</div>
                        </td>
                        <td class="px-6 py-4">
                            <div class="text-sm font-black text-light">৳{{ number_format($order->total_amount, 2) }}</div>
                            <div class="text-[10px] text-muted-light font-bold uppercase tracking-tighter">{{ $order->payment_method }}</div>
                        </td>
                        <td class="px-6 py-4">
                            @php
                                $statusStyles = [
                                    'pending' => 'bg-amber-100 text-amber-700 dark:bg-amber-900/40 dark:text-amber-400',
                                    'paid' => 'bg-sky-100 text-sky-700 dark:bg-sky-900/40 dark:text-sky-400',
                                    'processing' => 'bg-blue-100 text-blue-700 dark:bg-blue-900/40 dark:text-blue-400',
                                    'shipped' => 'bg-indigo-100 text-indigo-700 dark:bg-indigo-900/40 dark:text-indigo-400',
                                    'delivered' => 'bg-emerald-100 text-emerald-700 dark:bg-emerald-900/40 dark:text-emerald-400',
                                    'cancelled' => 'bg-red-100 text-red-700 dark:bg-red-900/40 dark:text-red-400',
                                ];
                                $style = $statusStyles[$order->status] ?? 'bg-slate-100 text-slate-700 dark:bg-slate-800 dark:text-slate-400';
                            @endphp
                            <span class="inline-flex py-1.5 px-3 rounded-full text-[10px] font-black {{ $style }}">
                                {{ strtoupper($order->status) }}
                            </span>
                        </td>
                        <td class="px-6 py-4 text-right">
                            <a href="{{ route('admin.orders.show', $order) }}" class="p-2 rounded-xl bg-slate-100 dark:bg-slate-800 text-light hover:bg-slate-900 hover:text-white transition shadow-sm inline-block">
                                👁️
                            </a>
                        </td>
                    </tr>
                @empty
                    <tr><td colspan="6" class="px-6 py-12 text-center text-muted-light italic">No orders found.</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
    
    @if($orders->hasPages())
        <div class="mt-8">{{ $orders->links() }}</div>
    @endif
</x-admin.card>
@endsection
