@extends('layouts.customer')

@section('title', 'My Order History - CMarket')
@section('page-title', 'My Orders')

@section('content')
<div class="space-y-8 animate-fade-in">
    @if($orders->count() > 0)
        <div class="grid grid-cols-1 gap-6">
            @foreach($orders as $order)
                <div class="bg-white rounded-[2rem] border border-slate-100 shadow-sm overflow-hidden hover:shadow-xl transition-all duration-300 group">
                    <div class="p-6 md:p-8 flex flex-col md:flex-row justify-between items-start md:items-center gap-6 bg-slate-50/50">
                        <div class="flex items-center gap-5">
                            <div class="w-14 h-14 rounded-2xl bg-white border border-slate-200 flex items-center justify-center text-2xl shadow-sm">📦</div>
                            <div>
                                <h3 class="text-lg font-black text-slate-800 leading-tight">Order #{{ $order->order_number }}</h3>
                                <p class="text-[10px] font-bold text-slate-400 uppercase tracking-widest mt-1">Placed on {{ $order->created_at->format('M d, Y') }}</p>
                            </div>
                        </div>
                        
                        <div class="flex items-center gap-4 w-full md:w-auto justify-between md:justify-end">
                            <div class="text-left md:text-right">
                                <p class="text-2xl font-black text-slate-800">৳{{ number_format($order->total_amount, 2) }}</p>
                                <p class="text-[9px] font-black uppercase tracking-tighter text-sky-500">{{ $order->payment_method }} • {{ $order->items->count() }} Items</p>
                            </div>
                            <span class="px-4 py-1.5 rounded-full text-[10px] font-black uppercase tracking-wider
                                {{ $order->status === 'delivered' ? 'bg-emerald-100 text-emerald-600' : '' }}
                                {{ $order->status === 'pending' ? 'bg-amber-100 text-amber-600' : '' }}
                                {{ $order->status === 'processing' ? 'bg-sky-100 text-sky-600' : '' }}
                                {{ $order->status === 'cancelled' ? 'bg-rose-100 text-rose-600' : '' }}">
                                {{ $order->status }}
                            </span>
                        </div>
                    </div>

                    <div class="p-6 md:p-8">
                        <div class="flex flex-wrap gap-8 items-center justify-between">
                            <div class="flex -space-x-4 overflow-hidden">
                                @foreach($order->items->take(4) as $item)
                                    <div class="inline-block h-12 w-12 rounded-xl ring-4 ring-white bg-slate-100 overflow-hidden border border-slate-200">
                                        @php
                                            $product = $item->product;
                                            $image = $product->thumbnail ?? (is_array($product->images) ? ($product->images[0] ?? null) : (json_decode($product->images, true)[0] ?? null));
                                        @endphp
                                        @if($image)
                                            <img src="{{ asset('storage/' . $image) }}" alt="" class="h-full w-full object-cover">
                                        @else
                                            <div class="h-full w-full flex items-center justify-center text-xs opacity-30 text-slate-400">📦</div>
                                        @endif
                                    </div>
                                @endforeach
                                @if($order->items->count() > 4)
                                    <div class="inline-block h-12 w-12 rounded-xl ring-4 ring-white bg-slate-900 border border-slate-800 flex items-center justify-center text-[10px] font-black text-white">
                                        +{{ $order->items->count() - 4 }}
                                    </div>
                                @endif
                            </div>

                            <div class="flex gap-4">
                                <a href="{{ route('invoices.view', $order) }}" target="_blank" class="px-6 py-3 rounded-xl bg-slate-50 text-slate-400 hover:bg-slate-100 transition-all font-black text-[10px] uppercase tracking-widest">
                                    Invoice
                                </a>
                                <a href="{{ route('orders.show', $order) }}" class="px-6 py-3 rounded-xl bg-slate-900 text-white hover:bg-sky-600 transition-all font-black text-[10px] uppercase tracking-widest shadow-lg shadow-slate-900/10">
                                    View Details
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>

        <div class="mt-10">
            {{ $orders->links() }}
        </div>
    @else
        <div class="bg-white rounded-[3rem] p-20 text-center border border-slate-100 shadow-sm flex flex-col items-center">
            <div class="w-32 h-32 rounded-[2.5rem] bg-slate-50 flex items-center justify-center text-6xl mb-8 group-hover:scale-110 transition-transform duration-500">🛒</div>
            <h2 class="text-3xl font-black text-slate-800 mb-2">No Orders Found</h2>
            <p class="text-sm font-medium text-slate-400 max-w-sm mb-10">Your purchase history is currently empty. Start exploring the marketplace to find amazing deals!</p>
            <a href="{{ route('products.index') }}" class="px-10 py-5 bg-slate-900 text-white rounded-2xl font-black text-xs uppercase tracking-widest shadow-2xl shadow-slate-900/20 hover:scale-105 transition-all">
                Shop Marketplace 📦
            </a>
        </div>
    @endif
</div>
@endsection
