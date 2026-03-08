@extends('layouts.admin')
@section('title', 'Refund Requests')
@section('page-title', 'Refund Requests')

@section('content')
<div class="space-y-6">
    <div class="flex items-center justify-between">
        <h2 class="text-2xl font-black text-slate-800 dark:text-white uppercase tracking-tighter">Refunds</h2>
        <div class="flex items-center gap-2">
            @foreach(['pending' => 'Pending', 'approved' => 'Approved', 'refunded' => 'Refunded', 'rejected' => 'Rejected'] as $s => $label)
            <a href="{{ route('admin.refunds.index', ['status' => $s]) }}" class="px-4 py-2 rounded-2xl text-[10px] font-black uppercase tracking-widest {{ request('status', 'pending') === $s ? 'bg-primary text-white' : 'bg-slate-100 text-slate-500 hover:bg-slate-200' }} transition-all">{{ $label }}</a>
            @endforeach
        </div>
    </div>
    <div class="bg-white dark:bg-slate-900 rounded-3xl border border-slate-100 dark:border-slate-800 overflow-hidden shadow-sm">
        <table class="w-full text-left">
            <thead><tr class="bg-slate-50 dark:bg-slate-800/50">
                <th class="px-8 py-5 text-[10px] font-black uppercase tracking-widest text-slate-400">Order</th>
                <th class="px-8 py-5 text-[10px] font-black uppercase tracking-widest text-slate-400">Customer</th>
                <th class="px-8 py-5 text-[10px] font-black uppercase tracking-widest text-slate-400">Amount</th>
                <th class="px-8 py-5 text-[10px] font-black uppercase tracking-widest text-slate-400">Date</th>
                <th class="px-8 py-5 text-right text-[10px] font-black uppercase tracking-widest text-slate-400">Action</th>
            </tr></thead>
            <tbody class="divide-y divide-slate-50 dark:divide-slate-800">
                @forelse($orders as $order)
                <tr class="hover:bg-slate-50/50 dark:hover:bg-slate-800/30 transition-colors">
                    <td class="px-8 py-4 text-sm font-black text-primary">#{{ $order->id }}</td>
                    <td class="px-8 py-4">
                        <div class="text-sm font-black text-slate-800 dark:text-white uppercase">{{ $order->user->name }}</div>
                        <div class="text-[10px] text-slate-400">{{ $order->user->phone }}</div>
                    </td>
                    <td class="px-8 py-4 text-sm font-black text-amber-600">৳{{ number_format($order->total_amount, 2) }}</td>
                    <td class="px-8 py-4 text-[10px] font-bold text-slate-400 uppercase">{{ $order->created_at->format('d M Y') }}</td>
                    <td class="px-8 py-4 text-right">
                        <a href="{{ route('admin.orders.show', $order) }}" class="px-4 py-2 text-[10px] font-black uppercase bg-slate-100 hover:bg-primary hover:text-white rounded-xl transition-all">View Order</a>
                    </td>
                </tr>
                @empty
                <tr><td colspan="5" class="px-8 py-16 text-center text-sm text-slate-400 font-bold">No refund requests found.</td></tr>
                @endforelse
            </tbody>
        </table>
        <div class="p-8 border-t border-slate-50 dark:border-slate-800">{{ $orders->links() }}</div>
    </div>
</div>
@endsection
