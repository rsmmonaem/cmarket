@extends('layouts.public')

@section('title', 'Secure Settlement - CMarket')
@section('page-title', 'Final Confirmation')

@section('content')
<div class="space-y-12 animate-fade-in">
    <!-- Top Progress Indicator -->
    <div class="flex items-center justify-between px-10 max-w-2xl mx-auto mb-16 relative">
        <div class="flex flex-col items-center gap-4 relative z-10">
            <div class="w-12 h-12 rounded-full bg-emerald-500 text-white flex items-center justify-center text-sm font-black shadow-lg shadow-emerald-500/20">1</div>
            <p class="text-[10px] font-black text-emerald-500 uppercase tracking-widest">Inventory</p>
        </div>
        <div class="flex-1 h-0.5 bg-emerald-500 mx-4"></div>
        <div class="flex flex-col items-center gap-4 relative z-10">
            <div class="w-12 h-12 rounded-full bg-slate-900 text-white flex items-center justify-center text-sm font-black shadow-lg shadow-slate-900/20">2</div>
            <p class="text-[10px] font-black text-slate-900 uppercase tracking-widest">Settlement</p>
        </div>
        <div class="flex-1 h-0.5 bg-slate-100 mx-4"></div>
        <div class="flex flex-col items-center gap-4 relative z-10">
            <div class="w-12 h-12 rounded-full bg-slate-100 text-slate-400 flex items-center justify-center text-sm font-black">3</div>
            <p class="text-[10px] font-black text-slate-300 uppercase tracking-widest">Deployment</p>
        </div>
    </div>

    <div class="flex flex-col lg:flex-row gap-12">
        <!-- Main Checkout Intelligence -->
        <div class="lg:w-2/3 space-y-8">
            <form action="{{ route('checkout.process') }}" method="POST" id="checkoutForm">
                @csrf

                <!-- Deployment Logistics -->
                <div class="bg-white rounded-[3rem] p-10 lg:p-12 border border-slate-100 shadow-sm space-y-10">
                    <div class="flex items-center gap-4 mb-12 border-b border-slate-50 pb-8">
                        <span class="text-3xl">📍</span>
                        <h3 class="text-xl font-black text-slate-800 tracking-tight">Logistics Command</h3>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                        <div class="space-y-3">
                            <label class="block text-[10px] font-black text-slate-400 uppercase tracking-widest ml-1">Asset Receiver</label>
                            <input type="text" value="{{ auth()->user()->name }}" readonly class="w-full bg-slate-50 border-none rounded-2xl p-5 text-sm font-bold text-slate-400 cursor-not-allowed">
                        </div>
                        <div class="space-y-3">
                            <label class="block text-[10px] font-black text-slate-400 uppercase tracking-widest ml-1">Secure Contact Number</label>
                            <input type="text" name="phone" value="{{ auth()->user()->phone ?? old('phone') }}" required placeholder="01XXXXXXXXX" class="w-full bg-slate-50 border-none rounded-2xl p-5 text-sm font-black text-slate-800 focus:ring-2 focus:ring-primary/20 transition-all placeholder:text-slate-300">
                        </div>
                    </div>

                    <div class="space-y-3">
                        <label class="block text-[10px] font-black text-slate-400 uppercase tracking-widest ml-1">Physical Coordinates (Address)</label>
                        <textarea name="shipping_address" rows="4" required placeholder="Full deployment address including district and upazila..." class="w-full bg-slate-50 border-none rounded-[2rem] p-6 text-sm font-medium text-slate-800 focus:ring-2 focus:ring-primary/20 transition-all placeholder:text-slate-300">{{ old('shipping_address') }}</textarea>
                    </div>

                    <div class="space-y-3">
                        <label class="block text-[10px] font-black text-slate-400 uppercase tracking-widest ml-1">Special Directives (Optional)</label>
                        <input type="text" name="notes" placeholder="Example: Leave at front gate..." class="w-full bg-slate-50 border-none rounded-2xl p-5 text-sm font-medium text-slate-800 focus:ring-2 focus:ring-primary/20 transition-all placeholder:text-slate-300">
                    </div>
                </div>

                <!-- Financial Gateway -->
                <div class="bg-white rounded-[3rem] p-10 lg:p-12 border border-slate-100 shadow-sm space-y-10 mt-10">
                    <div class="flex items-center gap-4 mb-12 border-b border-slate-50 pb-8">
                        <span class="text-3xl">💳</span>
                        <h3 class="text-xl font-black text-slate-800 tracking-tight">Monetary Protocol</h3>
                    </div>

                    <div class="grid grid-cols-1 gap-6">
                        <!-- Internal Wallet -->
                        <label class="relative block cursor-pointer group">
                            <input type="radio" name="payment_method" value="wallet" class="peer hidden" required>
                            <div class="p-8 rounded-[2rem] border-2 border-slate-50 bg-slate-50 peer-checked:border-primary peer-checked:bg-primary/5 peer-checked:shadow-xl peer-checked:shadow-primary/10 transition-all duration-300 flex items-center justify-between">
                                <div class="flex items-center gap-6">
                                    <div class="w-14 h-14 rounded-2xl bg-white flex items-center justify-center text-2xl shadow-sm border border-slate-100 peer-checked:border-primary/20">🏦</div>
                                    <div>
                                        <h4 class="text-lg font-black text-slate-800 mb-1">Ecosystem Digital Wallet</h4>
                                        <p class="text-[10px] font-black text-slate-400 uppercase tracking-widest">Instant Settlement • Liquid: <span class="text-emerald-500">৳{{ number_format($mainWallet->balance ?? 0, 2) }}</span></p>
                                    </div>
                                </div>
                                <div class="w-6 h-6 rounded-full border-2 border-slate-200 peer-checked:border-primary peer-checked:bg-primary flex items-center justify-center transition-all">
                                    <div class="w-2.5 h-2.5 rounded-full bg-white opacity-0 peer-checked:opacity-100 transition-all"></div>
                                </div>
                            </div>
                        </label>

                        <!-- COD -->
                        <label class="relative block cursor-pointer group">
                            <input type="radio" name="payment_method" value="cod" class="peer hidden">
                            <div class="p-8 rounded-[2rem] border-2 border-slate-50 bg-slate-50 peer-checked:border-slate-900 peer-checked:bg-slate-900 peer-checked:shadow-xl peer-checked:shadow-slate-900/10 transition-all duration-300 flex items-center justify-between">
                                <div class="flex items-center gap-6">
                                    <div class="w-14 h-14 rounded-2xl bg-white flex items-center justify-center text-2xl shadow-sm border border-slate-100 peer-checked:border-slate-800">🚚</div>
                                    <div>
                                        <h4 class="text-lg font-black text-slate-800 peer-checked:text-white mb-1 transition-colors">Physical Fiat (COD)</h4>
                                        <p class="text-[10px] font-black text-slate-400 uppercase tracking-widest peer-checked:text-slate-400">Settlement upon territory arrival</p>
                                    </div>
                                </div>
                                <div class="w-6 h-6 rounded-full border-2 border-slate-200 peer-checked:border-white peer-checked:bg-white flex items-center justify-center transition-all">
                                    <div class="w-2.5 h-2.5 rounded-full bg-slate-900 opacity-0 peer-checked:opacity-100 transition-all"></div>
                                </div>
                            </div>
                        </label>

                        <!-- Disabled Gateway -->
                        <div class="p-8 rounded-[2rem] border-2 border-dashed border-slate-100 bg-slate-50/50 flex items-center justify-between opacity-50 grayscale">
                            <div class="flex items-center gap-6">
                                <div class="w-14 h-14 rounded-2xl bg-white/50 flex items-center justify-center text-2xl shadow-sm border border-slate-100">🛡️</div>
                                <div>
                                    <h4 class="text-lg font-black text-slate-400 mb-1">Credit / Debit Matrix</h4>
                                    <p class="text-[10px] font-black text-slate-300 uppercase tracking-widest">Protocol implementation pending</p>
                                </div>
                            </div>
                            <span class="px-4 py-2 bg-slate-100 text-slate-400 rounded-xl text-[8px] font-black uppercase tracking-[0.2em]">Restricted</span>
                        </div>
                    </div>
                </div>

                <div class="mt-12">
                    <button type="submit" class="w-full py-7 bg-slate-900 text-white rounded-[2rem] font-black text-sm uppercase tracking-[0.4em] shadow-2xl shadow-slate-900/40 hover:bg-primary-hover sticky top-40">
                        Initiate Final Deployment ➔
                    </button>
                    <p class="text-center text-[9px] font-bold text-slate-400 uppercase tracking-[0.3em] mt-6">Secure end-to-end encrypted transaction module</p>
                </div>
            </form>
        </div>

        <!-- Order Infrastructure Summary -->
        <div class="lg:w-1/3">
            <div class="sticky top-32 space-y-6">
                <!-- Main Breakdown -->
                <div class="bg-white rounded-[3rem] border border-slate-100 shadow-xl overflow-hidden">
                    <div class="p-10 border-b border-slate-50 bg-slate-50/50">
                        <h3 class="text-xs font-black text-slate-800 uppercase tracking-[0.2em]">Batch Inventory</h3>
                    </div>

                    <div class="p-10 max-h-[400px] overflow-y-auto space-y-6 scrollbar-hide">
                        @foreach($cartItems as $item)
                            <div class="flex justify-between items-start gap-6">
                                <div class="flex-1">
                                    <h4 class="text-xs font-black text-slate-800 mb-1 leading-tight">{{ $item['product']->name }}</h4>
                                    <p class="text-[9px] font-bold text-slate-400 uppercase tracking-widest">Qty: {{ $item['quantity'] }} × ৳{{ number_format($item['product']->price, 0) }}</p>
                                </div>
                                <span class="text-xs font-black text-slate-900">৳{{ number_format($item['subtotal'], 0) }}</span>
                            </div>
                        @endforeach
                    </div>

                    {{-- Coupon --}}
                    <div class="px-10 py-6 border-t border-slate-50 bg-white">
                        @if(session('coupon'))
                        @php $coup = session('coupon'); @endphp
                        <div class="flex items-center justify-between bg-emerald-50 border border-emerald-100 rounded-2xl px-4 py-3">
                            <div>
                                <span class="text-[10px] font-black text-emerald-600 uppercase tracking-widest">🎟 {{ $coup['code'] }} applied</span>
                                <p class="text-xs font-black text-emerald-700">-৳{{ number_format($coup['discount'], 2) }} saved</p>
                            </div>
                            <form action="{{ route('checkout.remove-coupon') }}" method="POST"><@csrf<button class="text-[9px] font-black text-rose-400 uppercase hover:text-rose-600 transition">✕ Remove</button></form>
                        </div>
                        @else
                        <form action="{{ route('checkout.apply-coupon') }}" method="POST" class="flex gap-2">
                            @csrf
                            <input type="text" name="coupon_code" placeholder="Coupon code" class="flex-1 px-4 py-3 rounded-2xl bg-slate-50 border-transparent focus:border-primary/30 text-xs font-bold transition-all">
                            <button type="submit" class="px-5 py-3 bg-slate-900 text-white rounded-2xl text-[10px] font-black uppercase tracking-widest hover:bg-primary transition-all">Apply</button>
                        </form>
                        @if(session('coupon_error'))<p class="text-rose-500 text-[10px] font-bold mt-2">{{ session('coupon_error') }}</p>@endif
                        @endif
                    </div>

                    <div class="p-10 bg-slate-900 text-white space-y-6">
                        <div class="flex justify-between items-center text-white/50">
                            <span class="text-[9px] font-black uppercase tracking-widest">Subtotal</span>
                            <span class="text-xs font-black">৳{{ number_format($subtotal, 0) }}</span>
                        </div>
                        @if(session('coupon'))
                        <div class="flex justify-between items-center">
                            <span class="text-[9px] font-black text-emerald-400 uppercase tracking-widest">Coupon Discount</span>
                            <span class="text-xs font-black text-emerald-400">-৳{{ number_format(session('coupon.discount'), 0) }}</span>
                        </div>
                        <input type="hidden" name="coupon_code" value="{{ session('coupon.code') }}" form="checkoutForm">
                        @endif
                        <div class="flex justify-between items-center">
                            <span class="text-[9px] font-black text-emerald-400 uppercase tracking-widest">Shipping</span>
                            <span class="text-xs font-black text-emerald-400 tracking-widest">FREE</span>
                        </div>
                        <div class="border-t border-white/10 pt-8 flex justify-between items-baseline">
                            <span class="text-sm font-black uppercase tracking-[0.3em]">Total</span>
                            <span class="text-3xl font-black tracking-tighter">৳{{ number_format($subtotal - (session('coupon.discount') ?? 0), 0) }}</span>
                        </div>
                    </div>
                </div>


                <!-- Reward Potential -->
                <div class="bg-gradient-to-br from-indigo-500 to-slate-900 rounded-[2.5rem] p-8 text-white relative overflow-hidden group">
                    <div class="relative z-10 flex items-center gap-5">
                        <div class="w-12 h-12 rounded-2xl bg-white/10 backdrop-blur-xl border border-white/20 flex items-center justify-center text-xl">🎁</div>
                        <div>
                            <h4 class="text-xs font-black uppercase tracking-widest mb-1 text-indigo-200">Growth Reward</h4>
                            <p class="text-sm font-bold opacity-70">Cashback & Points will be credited upon delivery completion.</p>
                        </div>
                    </div>
                    <!-- Decor -->
                    <div class="absolute -right-4 -bottom-4 opacity-10 text-6xl">📈</div>
                </div>

                <div class="text-center pt-4">
                    <a href="{{ route('cart.index') }}" class="text-[10px] font-black text-slate-400 uppercase tracking-widest hover:text-slate-900 transition-colors">
                        ← Modification of Batch
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
