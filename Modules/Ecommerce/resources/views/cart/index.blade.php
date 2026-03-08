@extends('layouts.public')

@section('title', 'My Cart - CMarket')
@section('page-title', 'Shopping Pipeline')

@section('content')
<div class="space-y-10 animate-fade-in">
    @if(empty($cartItems))
        <div class="bg-white rounded-[3rem] p-20 text-center border border-slate-100 shadow-sm">
            <div class="text-[120px] mb-8 select-none">🛒</div>
            <h2 class="text-4xl font-black text-slate-800 mb-4 tracking-tight">Your terminal is empty</h2>
            <p class="text-slate-400 font-medium mb-10 max-w-md mx-auto leading-relaxed">Expand your territory by adding high-performance products to your acquisition pipeline.</p>
            <a href="{{ route('products.index') }}" class="inline-flex items-center gap-4 px-10 py-5 bg-slate-900 text-white rounded-2xl font-black text-xs uppercase tracking-[0.2em] shadow-2xl shadow-slate-900/20 hover:bg-primary hover:bg-primary-hover shadow-primary/20 hover:scale-105 transition-all">
                Browse Marketplace <span class="text-lg">✨</span>
            </a>
        </div>
    @else
        <div class="flex flex-col lg:flex-row gap-10">
            <!-- Asset Selection -->
            <div class="lg:w-2/3 space-y-6">
                <div class="bg-white rounded-[2.5rem] border border-slate-100 shadow-sm overflow-hidden">
                    <div class="px-10 py-8 border-b border-slate-50 flex items-center justify-between bg-slate-50/50">
                        <div>
                            <h3 class="text-sm font-black text-slate-800 uppercase tracking-widest">Active Batch ({{ count($cartItems) }})</h3>
                            <p class="text-[9px] font-bold text-slate-400 uppercase tracking-tighter mt-1">Review your selections before deployment</p>
                        </div>
                        <form action="{{ route('cart.clear') }}" method="POST" onsubmit="return confirm('Reset the entire batch?')">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="text-[10px] font-black text-rose-500 uppercase tracking-widest hover:text-rose-600 transition-colors">Clear Batch 🗑️</button>
                        </form>
                    </div>
                    
                    <div class="divide-y divide-slate-50">
                        @foreach($cartItems as $item)
                            <div class="p-10 flex flex-col sm:flex-row gap-10 items-center group">
                                <!-- Asset Thumbnail -->
                                <div class="w-24 h-24 rounded-[1.5rem] overflow-hidden bg-slate-100 border border-slate-200 flex-shrink-0 relative group-hover:scale-110 transition-transform duration-500">
                                    @if($item['product']->image)
                                        <img src="{{ asset('storage/' . $item['product']->image) }}" alt="{{ $item['product']->name }}" class="w-full h-full object-cover">
                                    @else
                                        <div class="w-full h-full flex items-center justify-center opacity-10 text-4xl font-black italic">!</div>
                                    @endif
                                </div>

                                <!-- Metadata -->
                                <div class="flex-1 text-center sm:text-left">
                                    <p class="text-[10px] font-black text-primary uppercase tracking-widest mb-1">{{ $item['product']->category->name }}</p>
                                    <h3 class="text-lg font-black text-slate-800 leading-tight mb-2 group-hover:text-primary hover:text-primary-hover transition-colors">
                                        <a href="{{ route('products.show', $item['product']) }}">{{ $item['product']->name }}</a>
                                    </h3>
                                    <p class="text-sm font-black text-slate-400">৳{{ number_format($item['product']->price, 2) }} <span class="text-[9px] opacity-40">/ unit</span></p>
                                </div>

                                <!-- Flow Control -->
                                <div class="flex flex-col sm:flex-row items-center gap-8">
                                    <div class="px-4 py-2 bg-slate-50 rounded-2xl border border-slate-100 flex items-center gap-4">
                                        <form action="{{ route('cart.update', $item['product']->id) }}" method="POST" class="flex items-center gap-2">
                                            @csrf
                                            @method('PUT')
                                            <input type="number" name="quantity" value="{{ $item['quantity'] }}" min="1" max="{{ $item['product']->stock }}" class="w-12 bg-transparent border-none text-center font-black text-slate-800 focus:ring-0">
                                            <button type="submit" class="p-2 bg-white rounded-xl shadow-sm text-primary hover:bg-sky-500 hover:text-white transition-all text-[10px] font-black uppercase">Sync</button>
                                        </form>
                                    </div>

                                    <div class="text-right min-w-[120px]">
                                        <p class="text-[9px] font-black text-slate-300 uppercase tracking-tighter mb-1">Subtotal</p>
                                        <p class="text-xl font-black text-slate-900 tracking-tighter">৳{{ number_format($item['subtotal'], 2) }}</p>
                                    </div>

                                    <form action="{{ route('cart.remove', $item['product']->id) }}" method="POST">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="w-10 h-10 rounded-full bg-rose-50 text-rose-500 hover:bg-rose-500 hover:text-white hover:rotate-90 transition-all duration-500 flex items-center justify-center font-black">
                                            ✕
                                        </button>
                                    </form>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>

            <!-- Financial Finalization -->
            <div class="lg:w-1/3 space-y-6">
                <div class="bg-slate-900 rounded-[2.5rem] p-10 text-white shadow-2xl shadow-slate-900/20 relative overflow-hidden group">
                    <h2 class="text-xl font-black mb-10 border-b border-white/10 pb-6 tracking-tight relative z-10">Order Finalization</h2>
                    
                    <div class="space-y-6 relative z-10">
                        <div class="flex justify-between items-center">
                            <span class="text-[10px] font-black text-white/40 uppercase tracking-widest">Asset Valuation</span>
                            <span class="text-lg font-black tracking-tight">৳{{ number_format($total, 2) }}</span>
                        </div>
                        <div class="flex justify-between items-center">
                            <span class="text-[10px] font-black text-white/40 uppercase tracking-widest">Logistics Hub Fee</span>
                            <span class="text-lg font-black tracking-tight text-emerald-400">৳0.00</span>
                        </div>
                        
                        <div class="pt-10 mt-10 border-t border-white/10 flex justify-between items-baseline">
                            <span class="text-sm font-black uppercase tracking-widest text-white/60">Final Settlement</span>
                            <span class="text-4xl font-black tracking-tighter">৳{{ number_format($total, 2) }}</span>
                        </div>

                        @if($total > 0)
                            <a href="{{ route('checkout.index') }}" class="block w-full py-6 bg-white text-slate-900 text-center rounded-2xl font-black text-[10px] uppercase tracking-[0.3em] shadow-xl hover:bg-sky-500 hover:text-white hover:scale-[1.02] transition-all duration-300 mt-10">
                                Confirm Deployment ➔
                            </a>
                        @endif
                    </div>
                    
                    <!-- Background Asset -->
                    <div class="absolute -right-10 -bottom-10 opacity-5 text-[200px] select-none italic font-black">TOTAL</div>
                </div>

                <div class="text-center pt-4">
                    <a href="{{ route('products.index') }}" class="text-[10px] font-black text-slate-400 uppercase tracking-widest hover:text-primary transition-colors">
                        ← Continue Acquisition
                    </a>
                </div>
            </div>
        </div>
    @endif
</div>
@endsection
