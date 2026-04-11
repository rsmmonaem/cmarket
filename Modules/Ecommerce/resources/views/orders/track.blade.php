@extends('layouts.public')

@section('title', 'Track Your Order - CMarket')

@section('content')
<div class="min-h-[70vh] flex items-center justify-center py-20 px-6">
    <div class="max-w-xl w-full">
        <!-- Header -->
        <div class="text-center mb-12">
            <div class="w-20 h-20 bg-primary/10 rounded-3xl flex items-center justify-center text-3xl mx-auto mb-6 shadow-xl shadow-primary/5">🔍</div>
            <h1 class="text-4xl font-black text-dark tracking-tight mb-4">Track Your Order</h1>
            <p class="text-slate-500 font-medium">Enter your order details below to see the current status of your delivery.</p>
        </div>

        <!-- Tracking Form -->
        <div class="bg-white rounded-[2.5rem] p-8 md:p-12 shadow-2xl border border-slate-50 relative overflow-hidden">
            <!-- Decorative circle -->
            <div class="absolute -top-12 -right-12 w-24 h-24 bg-primary/5 rounded-full"></div>
            
            <form action="{{ route('orders.track') }}" method="GET" class="space-y-6 relative z-10">
                <div class="space-y-2">
                    <label class="text-[10px] font-black text-slate-400 uppercase tracking-widest ml-1">Order Number</label>
                    <input type="text" name="order_number" value="{{ old('order_number') }}" placeholder="e.g. ORD-65F..." 
                        class="w-full bg-slate-50 border-2 border-transparent focus:border-primary/20 focus:bg-white rounded-2xl px-6 py-4 text-sm font-bold transition-all outline-none" required>
                </div>

                <div class="space-y-2">
                    <label class="text-[10px] font-black text-slate-400 uppercase tracking-widest ml-1">Phone Number</label>
                    <input type="text" name="phone" value="{{ old('phone') }}" placeholder="Enter shipping phone number" 
                        class="w-full bg-slate-50 border-2 border-transparent focus:border-primary/20 focus:bg-white rounded-2xl px-6 py-4 text-sm font-bold transition-all outline-none" required>
                </div>

                @if(session('error'))
                    <div class="bg-rose-50 text-rose-500 p-4 rounded-xl text-xs font-bold flex items-center gap-3">
                        <span>⚠️</span>
                        {{ session('error') }}
                    </div>
                @endif

                <button type="submit" class="w-full bg-dark text-white py-5 rounded-2xl font-black text-[12px] uppercase tracking-[0.2em] shadow-2xl shadow-dark/10 hover:bg-primary transition-all active:scale-[0.98]">
                    Trace Package ➔
                </button>
            </form>
        </div>

        <!-- Help Link -->
        <p class="text-center mt-10 text-[10px] font-bold text-slate-400 uppercase tracking-[0.15em]">
            Need help? <a href="#" class="text-primary hover:underline">Contact Support</a>
        </p>
    </div>
</div>
@endsection
