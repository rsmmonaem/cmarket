@extends('layouts.public')

@section('title', 'Checkout - CMarket')

@section('content')
<div class="max-w-5xl mx-auto px-4 py-10">

    {{-- Step Indicator --}}
    <div class="flex items-center gap-3 mb-10 max-w-xs">
        <div class="flex items-center gap-2">
            <div class="w-7 h-7 rounded-full bg-emerald-500 text-white text-xs font-bold flex items-center justify-center">1</div>
            <span class="text-xs font-semibold text-emerald-600">Cart</span>
        </div>
        <div class="flex-1 h-px bg-slate-200"></div>
        <div class="flex items-center gap-2">
            <div class="w-7 h-7 rounded-full bg-slate-900 text-white text-xs font-bold flex items-center justify-center">2</div>
            <span class="text-xs font-bold text-slate-900">Checkout</span>
        </div>
        <div class="flex-1 h-px bg-slate-100"></div>
        <div class="flex items-center gap-2">
            <div class="w-7 h-7 rounded-full bg-slate-100 text-slate-400 text-xs font-bold flex items-center justify-center">3</div>
            <span class="text-xs font-semibold text-slate-300">Confirm</span>
        </div>
    </div>

    <div class="flex flex-col lg:flex-row gap-8">

        {{-- Left: Shipping + Payment --}}
        <div class="flex-1">
            <form action="{{ route('checkout.process') }}" method="POST" id="checkoutForm">
                @csrf

                {{-- Shipping Info --}}
                <div class="bg-white rounded-2xl border border-slate-100 shadow-sm p-6 mb-5">
                    <h2 class="text-sm font-bold text-slate-800 mb-5 flex items-center gap-2">
                        <span>📍</span> Delivery Information
                    </h2>

                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 mb-4">
                        <div>
                            <label class="block text-xs font-semibold text-slate-500 mb-1.5">Full Name</label>
                            <input type="text" value="{{ auth()->user()->name }}" readonly
                                   class="w-full bg-slate-50 border border-slate-100 rounded-xl px-4 py-2.5 text-sm text-slate-400 cursor-not-allowed">
                        </div>
                        <div>
                            <label class="block text-xs font-semibold text-slate-500 mb-1.5">Phone Number <span class="text-rose-500">*</span></label>
                            <input type="text" name="phone"
                                   value="{{ auth()->user()->phone ?? old('phone') }}"
                                   required placeholder="01XXXXXXXXX"
                                   class="w-full bg-slate-50 border border-slate-200 rounded-xl px-4 py-2.5 text-sm font-medium text-slate-800 focus:ring-2 focus:ring-primary/20 focus:border-primary focus:outline-none placeholder:text-slate-300 transition-all">
                        </div>
                    </div>

                    <div class="mb-4">
                        <label class="block text-xs font-semibold text-slate-500 mb-1.5">Delivery Address <span class="text-rose-500">*</span></label>
                        <textarea name="shipping_address" rows="3" required
                                  placeholder="Full address including city, district..."
                                  class="w-full bg-slate-50 border border-slate-200 rounded-xl px-4 py-2.5 text-sm text-slate-800 focus:ring-2 focus:ring-primary/20 focus:border-primary focus:outline-none placeholder:text-slate-300 transition-all resize-none">{{ old('shipping_address') }}</textarea>
                    </div>

                    <div>
                        <label class="block text-xs font-semibold text-slate-500 mb-1.5">Order Notes <span class="text-slate-300">(optional)</span></label>
                        <input type="text" name="notes"
                               placeholder="e.g. Leave at reception..."
                               class="w-full bg-slate-50 border border-slate-200 rounded-xl px-4 py-2.5 text-sm text-slate-800 focus:ring-2 focus:ring-primary/20 focus:border-primary focus:outline-none placeholder:text-slate-300 transition-all">
                    </div>
                </div>

                {{-- Payment Method --}}
                <div class="bg-white rounded-2xl border border-slate-100 shadow-sm p-6 mb-6">
                    <h2 class="text-sm font-bold text-slate-800 mb-5 flex items-center gap-2">
                        <span>💳</span> Payment Method
                    </h2>

                    <div class="space-y-3">
                        {{-- Wallet --}}
                        <label class="flex items-center gap-4 p-4 rounded-xl border-2 border-slate-100 bg-slate-50 hover:border-primary/30 peer-checked:border-primary cursor-pointer transition-all group">
                            <input type="radio" name="payment_method" value="wallet" class="accent-primary" required>
                            <div class="w-10 h-10 rounded-xl bg-white border border-slate-100 flex items-center justify-center text-xl shadow-sm">🏦</div>
                            <div class="flex-1">
                                <p class="text-sm font-bold text-slate-800">Wallet Balance</p>
                                <p class="text-xs text-slate-400">Available: <span class="text-emerald-600 font-semibold">৳{{ number_format($mainWallet->balance ?? 0, 2) }}</span></p>
                            </div>
                        </label>

                        {{-- COD --}}
                        <label class="flex items-center gap-4 p-4 rounded-xl border-2 border-slate-100 bg-slate-50 hover:border-slate-300 cursor-pointer transition-all">
                            <input type="radio" name="payment_method" value="cod" class="accent-slate-900">
                            <div class="w-10 h-10 rounded-xl bg-white border border-slate-100 flex items-center justify-center text-xl shadow-sm">🚚</div>
                            <div class="flex-1">
                                <p class="text-sm font-bold text-slate-800">Cash on Delivery</p>
                                <p class="text-xs text-slate-400">Pay when your order arrives</p>
                            </div>
                        </label>

                        {{-- Card (disabled) --}}
                        <div class="flex items-center gap-4 p-4 rounded-xl border-2 border-dashed border-slate-100 opacity-40 cursor-not-allowed">
                            <div class="w-10 h-10 rounded-xl bg-slate-100 flex items-center justify-center text-xl">🛡️</div>
                            <div class="flex-1">
                                <p class="text-sm font-bold text-slate-500">Credit / Debit Card</p>
                                <p class="text-xs text-slate-400">Coming soon</p>
                            </div>
                            <span class="text-[10px] font-bold text-slate-400 bg-slate-100 px-2 py-1 rounded-lg uppercase">Soon</span>
                        </div>
                    </div>
                </div>

                <button type="submit"
                        class="w-full py-4 bg-slate-900 text-white rounded-xl font-bold text-sm hover:bg-primary transition-colors shadow-sm">
                    Place Order →
                </button>
                <p class="text-center text-xs text-slate-400 mt-3">Your order details are securely processed.</p>
            </form>
        </div>

        {{-- Right: Order Summary --}}
        <div class="lg:w-80 shrink-0">
            <div class="sticky top-24 space-y-4">

                {{-- Items --}}
                <div class="bg-white rounded-2xl border border-slate-100 shadow-sm overflow-hidden">
                    <div class="px-5 py-4 border-b border-slate-100 bg-slate-50/50">
                        <h3 class="text-xs font-bold text-slate-700 uppercase tracking-wider">Your Items ({{ count($cartItems) }})</h3>
                    </div>
                    <div class="p-5 space-y-4 max-h-60 overflow-y-auto">
                        @foreach($cartItems as $item)
                            <div class="flex justify-between items-start gap-3">
                                <div class="flex-1 min-w-0">
                                    <p class="text-xs font-semibold text-slate-800 truncate">{{ $item['product']->name }}</p>
                                    <p class="text-[11px] text-slate-400">× {{ $item['quantity'] }} @ ৳{{ number_format($item['product']->price, 0) }}</p>
                                </div>
                                <span class="text-xs font-bold text-slate-900 shrink-0">৳{{ number_format($item['subtotal'], 0) }}</span>
                            </div>
                        @endforeach
                    </div>

                    {{-- Coupon --}}
                    <div class="px-5 py-4 border-t border-slate-100">
                        @if(session('coupon'))
                            @php $coup = session('coupon'); @endphp
                            <div class="flex items-center justify-between bg-emerald-50 border border-emerald-100 rounded-xl px-3 py-2">
                                <div>
                                    <p class="text-xs font-bold text-emerald-700">🎟 {{ $coup['code'] }} applied</p>
                                    <p class="text-[11px] text-emerald-600">-৳{{ number_format($coup['discount'], 2) }} saved</p>
                                </div>
                                <form action="{{ route('checkout.remove-coupon') }}" method="POST">
                                    @csrf
                                    <button class="text-xs font-bold text-rose-400 hover:text-rose-600 transition">✕</button>
                                </form>
                            </div>
                        @else
                            <form action="{{ route('checkout.apply-coupon') }}" method="POST" class="flex gap-2">
                                @csrf
                                <input type="text" name="coupon_code" placeholder="Coupon code"
                                       class="flex-1 px-3 py-2 text-xs border border-slate-200 rounded-xl focus:ring-2 focus:ring-primary/20 focus:outline-none">
                                <button type="submit"
                                        class="px-4 py-2 bg-slate-900 text-white rounded-xl text-xs font-bold hover:bg-primary transition-colors">Apply</button>
                            </form>
                            @if(session('coupon_error'))
                                <p class="text-rose-500 text-[11px] mt-2">{{ session('coupon_error') }}</p>
                            @endif
                        @endif
                    </div>

                    {{-- Totals --}}
                    <div class="px-5 py-4 border-t border-slate-100 space-y-2.5">
                        <div class="flex justify-between text-xs">
                            <span class="text-slate-500">Subtotal</span>
                            <span class="font-semibold text-slate-800">৳{{ number_format($subtotal, 0) }}</span>
                        </div>
                        @if(session('coupon'))
                            <div class="flex justify-between text-xs">
                                <span class="text-emerald-600">Coupon Discount</span>
                                <span class="font-semibold text-emerald-600">-৳{{ number_format(session('coupon.discount'), 0) }}</span>
                            </div>
                            <input type="hidden" name="coupon_code" value="{{ session('coupon.code') }}" form="checkoutForm">
                        @endif
                        <div class="flex justify-between text-xs">
                            <span class="text-slate-500">Shipping</span>
                            <span class="font-semibold text-emerald-600">Free</span>
                        </div>
                        <div class="border-t border-slate-100 pt-3 flex justify-between items-center">
                            <span class="text-sm font-bold text-slate-800">Total</span>
                            <span class="text-lg font-bold text-slate-900">৳{{ number_format($subtotal - (session('coupon.discount') ?? 0), 0) }}</span>
                        </div>
                    </div>
                </div>

                {{-- Cashback note --}}
                <div class="bg-indigo-50 rounded-2xl p-4 flex items-start gap-3">
                    <span class="text-xl">🎁</span>
                    <div>
                        <p class="text-xs font-bold text-indigo-700">Earn Cashback & Points</p>
                        <p class="text-[11px] text-indigo-500 mt-0.5">Rewards will be credited after delivery.</p>
                    </div>
                </div>

                <div class="text-center">
                    <a href="{{ route('cart.index') }}" class="text-xs text-slate-400 hover:text-slate-700 font-medium transition-colors">
                        ← Back to Cart
                    </a>
                </div>
            </div>
        </div>

    </div>
</div>
@endsection
