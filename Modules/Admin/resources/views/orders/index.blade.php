@extends('layouts.admin')

@section('title', 'Order Management - CMarket')
@section('page-title', 'Order Management')

@section('content')
<div class="space-y-8 animate-fade-in">
    <!-- Header Summary -->
    <div class="bg-gradient-to-br from-slate-900 to-slate-800 rounded-[2.5rem] p-8 md:p-12 text-white shadow-2xl shadow-slate-900/20 relative overflow-hidden group">
        <div class="relative z-10 flex flex-col lg:flex-row justify-between items-center gap-8">
            <div class="text-center lg:text-left">
                <h2 class="text-3xl md:text-4xl font-black tracking-tight mb-2">Order Management</h2>
                <p class="text-slate-400 text-[10px] font-black uppercase tracking-[0.2em] ml-1">Live Transaction Stream • {{ number_format($orders->total()) }} Total Orders</p>
            </div>
            
            <div class="flex items-center gap-4">
                <div class="bg-white/5 backdrop-blur-xl border border-white/10 p-6 rounded-3xl text-center min-w-[150px]">
                    <p class="text-[9px] font-black uppercase tracking-tighter opacity-40 mb-1">Queue Size</p>
                    <p class="text-2xl font-black text-amber-400">{{ $orders->whereIn('status', ['pending', 'processing'])->count() }}</p>
                </div>
                <div class="bg-white/5 backdrop-blur-xl border border-white/10 p-6 rounded-3xl text-center min-w-[150px]">
                    <p class="text-[9px] font-black uppercase tracking-tighter opacity-40 mb-1">Delivered</p>
                    <p class="text-2xl font-black text-emerald-400">{{ $orders->where('status', 'delivered')->count() }}</p>
                </div>
            </div>
        </div>
        <div class="absolute -right-10 -bottom-10 opacity-5 text-[220px] leading-none select-none italic font-black group-hover:scale-110 transition-transform duration-1000">📦</div>
    </div>

    <!-- Smart Filters -->
    <div class="bg-white rounded-[2.5rem] p-6 border border-slate-100 shadow-sm">
        <form method="GET" class="flex flex-col lg:flex-row gap-4">
            <div class="flex-1 relative group">
                <span class="absolute left-6 top-1/2 -translate-y-1/2 opacity-20 text-lg group-focus-within:opacity-100 transition-opacity">🔍</span>
                <input type="text" name="search" placeholder="Search by Order ID, Name or Phone..." 
                       value="{{ request('search') }}"
                       class="w-full h-14 bg-slate-50 border-none rounded-2xl pl-16 pr-6 text-sm font-bold text-slate-800 focus:bg-white focus:ring-4 focus:ring-slate-900/5 transition-all placeholder:text-slate-300">
            </div>
            
            <div class="lg:w-64">
                <select name="status" class="w-full h-14 bg-slate-50 border-none rounded-2xl px-6 text-sm font-bold text-slate-800 focus:bg-white focus:ring-4 focus:ring-slate-900/5 transition-all appearance-none cursor-pointer">
                    <option value="">All Statuses</option>
                    @foreach(['pending', 'paid', 'processing', 'shipped', 'delivered', 'cancelled'] as $status)
                        <option value="{{ $status }}" {{ request('status') == $status ? 'selected' : '' }}>{{ ucfirst($status) }}</option>
                    @endforeach
                </select>
            </div>
            
            <button type="submit" class="h-14 px-10 bg-slate-900 text-white rounded-2xl font-black text-[10px] uppercase tracking-widest hover:bg-black transition-all active:scale-95 shadow-lg shadow-slate-900/10">
                Filter Results
            </button>
        </form>
    </div>

    <!-- Data Presentation -->
    <div class="bg-white rounded-[2.5rem] border border-slate-100 shadow-sm overflow-hidden min-h-[500px]">
        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse min-w-[1000px]">
                <thead>
                    <tr class="bg-slate-50/50">
                        <th class="px-10 py-6 text-[10px] font-black uppercase tracking-widest text-slate-400">Order Ident</th>
                        <th class="px-10 py-6 text-[10px] font-black uppercase tracking-widest text-slate-400">Customer Node</th>
                        <th class="px-10 py-6 text-[10px] font-black uppercase tracking-widest text-slate-400">Merchant Partner</th>
                        <th class="px-10 py-6 text-[10px] font-black uppercase tracking-widest text-slate-400 text-center">Value</th>
                        <th class="px-10 py-6 text-[10px] font-black uppercase tracking-widest text-slate-400 text-center">Status Phase</th>
                        <th class="px-10 py-6 text-[10px] font-black uppercase tracking-widest text-slate-400 text-right">Action</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-50">
                    @forelse($orders as $order)
                        <tr class="group hover:bg-slate-50/50 transition-colors">
                            <td class="px-10 py-8">
                                <div class="text-sm font-black text-slate-800 mb-1">#{{ $order->order_number }}</div>
                                <div class="text-[10px] text-slate-400 font-bold">{{ $order->created_at->format('M d, Y • H:i') }}</div>
                            </td>
                            <td class="px-10 py-8">
                                <div class="flex items-center gap-3">
                                    <div class="w-10 h-10 rounded-xl bg-slate-100 flex items-center justify-center text-lg shadow-sm group-hover:bg-white transition-colors">👤</div>
                                    <div>
                                        <p class="text-sm font-black text-slate-800">{{ $order->user->name }}</p>
                                        <p class="text-[10px] font-bold text-sky-500 tracking-tight">{{ $order->user->phone }}</p>
                                    </div>
                                </div>
                            </td>
                            <td class="px-10 py-8">
                                @if($order->merchant)
                                    <div class="text-sm font-black text-slate-800">{{ $order->merchant->business_name }}</div>
                                    <div class="text-[10px] text-slate-400 font-bold uppercase tracking-wider">Premium Seller</div>
                                @else
                                    <div class="text-sm font-black text-slate-400">Direct Admin</div>
                                    <div class="text-[10px] text-slate-300 font-bold uppercase tracking-wider">In-House Node</div>
                                @endif
                            </td>
                            <td class="px-10 py-8 text-center">
                                <div class="text-lg font-black text-slate-800 mb-0.5">৳{{ number_format($order->total_amount, 2) }}</div>
                                <div class="text-[9px] font-black text-slate-400 uppercase tracking-widest">{{ $order->payment_method }}</div>
                            </td>
                            <td class="px-10 py-8 text-center">
                                @php
                                    $statusMaps = [
                                        'pending' => ['bg' => 'bg-amber-100', 'text' => 'text-amber-600', 'label' => 'Pending'],
                                        'paid' => ['bg' => 'bg-sky-100', 'text' => 'text-sky-600', 'label' => 'Paid'],
                                        'processing' => ['bg' => 'bg-blue-100', 'text' => 'text-blue-600', 'label' => 'Processing'],
                                        'shipped' => ['bg' => 'bg-emerald-100', 'text' => 'text-emerald-600', 'label' => 'Shipped'],
                                        'delivered' => ['bg' => 'bg-emerald-600', 'text' => 'text-white', 'label' => 'Delivered'],
                                        'cancelled' => ['bg' => 'bg-rose-100', 'text' => 'text-rose-600', 'label' => 'Cancelled'],
                                    ];
                                    $map = $statusMaps[$order->status] ?? ['bg' => 'bg-slate-100', 'text' => 'text-slate-600', 'label' => $order->status];
                                @endphp
                                <span class="px-3 py-1.5 rounded-lg {{ $map['bg'] }} {{ $map['text'] }} text-[9px] font-black uppercase tracking-wider">
                                    {{ $map['label'] }}
                                </span>
                            </td>
                            <td class="px-10 py-8 text-right">
                                <a href="{{ route('admin.orders.show', $order) }}" class="inline-flex w-10 h-10 rounded-xl bg-slate-900 text-white items-center justify-center text-lg hover:bg-sky-500 hover:scale-110 transition-all shadow-lg shadow-slate-900/10">
                                    👁️
                                </a>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="px-10 py-32 text-center text-slate-300 flex flex-col items-center">
                                <div class="text-7xl mb-6 opacity-20">🧊</div>
                                <h3 class="text-xl font-black uppercase tracking-widest">No Orders Found</h3>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if($orders->count() > 0)
            <div class="p-8 border-t border-slate-50">
                {{ $orders->links() }}
            </div>
        @endif
    </div>
</div>
@endsection

