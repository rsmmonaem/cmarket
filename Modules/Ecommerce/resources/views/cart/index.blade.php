@extends('layouts.public')

@section('title', 'My Cart - CMarket')

@section('content')
<div class="max-w-5xl mx-auto px-4 py-10">

    @if(empty($cartItems))
        {{-- Empty Cart --}}
        <div class="text-center py-24">
            <div class="text-7xl mb-6">🛒</div>
            <h2 class="text-2xl font-bold text-slate-800 mb-3">Your cart is empty</h2>
            <p class="text-slate-400 mb-8">Browse our products and add items to your cart.</p>
            <a href="{{ route('products.index') }}"
               class="inline-flex items-center gap-2 px-7 py-3 bg-slate-900 text-white rounded-xl font-semibold text-sm hover:bg-primary transition-colors">
                Continue Shopping →
            </a>
        </div>
    @else
        <div class="flex flex-col lg:flex-row gap-8">

            {{-- Cart Items --}}
            <div class="flex-1">
                <div class="flex items-center justify-between mb-5">
                    <h1 class="text-xl font-bold text-slate-800">Shopping Cart <span class="text-slate-400 font-normal">({{ count($cartItems) }} items)</span></h1>
                    <form action="{{ route('cart.clear') }}" method="POST" onsubmit="return confirm('Clear your cart?')">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="text-xs text-rose-500 hover:text-rose-600 font-semibold transition-colors">Clear all</button>
                    </form>
                </div>

                <div class="bg-white rounded-2xl border border-slate-100 shadow-sm overflow-hidden divide-y divide-slate-100">
                    @foreach($cartItems as $item)
                        <div class="flex items-center gap-5 p-5">
                            {{-- Image --}}
                            <div class="w-20 h-20 rounded-xl overflow-hidden bg-slate-100 shrink-0 border border-slate-100">
                                @if($item['product']->image)
                                    <img src="{{ asset('storage/' . $item['product']->image) }}"
                                         alt="{{ $item['product']->name }}"
                                         class="w-full h-full object-cover">
                                @else
                                    <div class="w-full h-full flex items-center justify-center text-2xl text-slate-300">📦</div>
                                @endif
                            </div>

                            {{-- Info --}}
                            <div class="flex-1 min-w-0">
                                <p class="text-[10px] font-semibold text-primary uppercase tracking-wider mb-1">{{ $item['product']->category->name ?? '' }}</p>
                                <h3 class="text-sm font-bold text-slate-800 truncate mb-1">
                                    <a href="{{ route('products.show', $item['product']) }}" class="hover:text-primary transition-colors">{{ $item['product']->name }}</a>
                                </h3>
                                <p class="text-xs text-slate-400">৳{{ number_format($item['product']->price, 2) }} / piece</p>
                            </div>

                            {{-- Qty --}}
                            <div class="shrink-0">
                                <form action="{{ route('cart.update', $item['product']->id) }}" method="POST" class="flex items-center gap-1">
                                    @csrf
                                    @method('PUT')
                                    <input type="number" name="quantity"
                                           value="{{ $item['quantity'] }}"
                                           min="1" max="{{ $item['product']->stock }}"
                                           class="w-14 text-center text-sm font-bold border border-slate-200 rounded-lg py-1.5 focus:ring-2 focus:ring-primary/20 focus:outline-none">
                                    <button type="submit"
                                            class="px-3 py-1.5 bg-slate-100 hover:bg-primary hover:text-white text-slate-600 rounded-lg text-xs font-semibold transition-colors">
                                        Update
                                    </button>
                                </form>
                            </div>

                            {{-- Subtotal --}}
                            <div class="shrink-0 text-right min-w-[90px]">
                                <p class="text-sm font-bold text-slate-900">৳{{ number_format($item['subtotal'], 2) }}</p>
                            </div>

                            {{-- Remove --}}
                            <form action="{{ route('cart.remove', $item['product']->id) }}" method="POST">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="w-8 h-8 rounded-full bg-rose-50 text-rose-400 hover:bg-rose-500 hover:text-white transition-colors flex items-center justify-center text-sm font-bold">
                                    ✕
                                </button>
                            </form>
                        </div>
                    @endforeach
                </div>

                <div class="mt-5">
                    <a href="{{ route('products.index') }}" class="text-sm text-slate-500 hover:text-primary font-medium transition-colors">
                        ← Continue Shopping
                    </a>
                </div>
            </div>

            {{-- Order Summary --}}
            <div class="lg:w-80 shrink-0">
                <div class="bg-white rounded-2xl border border-slate-100 shadow-sm p-6 sticky top-24">
                    <h2 class="text-sm font-bold text-slate-800 mb-5">Order Summary</h2>

                    <div class="space-y-3 mb-5">
                        <div class="flex justify-between text-sm">
                            <span class="text-slate-500">Subtotal ({{ count($cartItems) }} items)</span>
                            <span class="font-semibold text-slate-800">৳{{ number_format($total, 2) }}</span>
                        </div>
                        <div class="flex justify-between text-sm">
                            <span class="text-slate-500">Shipping</span>
                            <span class="font-semibold text-emerald-600">Free</span>
                        </div>
                    </div>

                    <div class="border-t border-slate-100 pt-4 mb-6">
                        <div class="flex justify-between items-center">
                            <span class="font-bold text-slate-800">Total</span>
                            <span class="text-xl font-bold text-slate-900">৳{{ number_format($total, 2) }}</span>
                        </div>
                    </div>

                    @if($total > 0)
                        <a href="{{ route('checkout.index') }}"
                           class="block w-full py-3.5 bg-slate-900 text-white text-center rounded-xl font-bold text-sm hover:bg-primary transition-colors">
                            Proceed to Checkout →
                        </a>
                    @endif
                </div>
            </div>

        </div>
    @endif

</div>
@endsection
