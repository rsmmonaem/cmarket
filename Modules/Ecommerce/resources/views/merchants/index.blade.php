@extends('layouts.public')

@section('title', 'Merchant Infrastructure - C-Market')

@section('content')
<!-- Header -->
<section class="bg-slate-900 py-12 md:py-16 text-center relative overflow-hidden">
    <div class="max-w-7xl mx-auto px-4 relative z-10">
        <h1 class="text-3xl md:text-5xl font-black text-white mb-4 tracking-tighter">Verified <span class="text-primary">Stores</span></h1>
        <p class="text-slate-400 text-[10px] md:text-xs font-bold uppercase tracking-[0.2em]">Shop directly from our trusted merchants</p>
    </div>
</section>

<section class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-10 md:py-16">
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-10">
        @forelse($merchants as $merchant)
            <div class="group bg-white rounded-2xl p-6 md:p-8 border border-slate-100 shadow-sm hover:shadow-xl hover:-translate-y-1 transition-all duration-300 relative flex flex-col">
                <div class="flex items-center gap-4 mb-6">
                    <div class="w-24 h-24 rounded-4xl bg-slate-50 flex items-center justify-center group-hover:scale-110 transition-transform shadow-inner overflow-hidden border border-slate-100 p-4">
                        @if($merchant->logo)
                            <img src="{{ asset('storage/' . $merchant->logo) }}" class="w-full h-full object-contain">
                        @else
                            <span class="text-3xl opacity-20">🏪</span>
                        @endif
                    </div>
                    <div>
                        <h3 class="text-xl font-black text-slate-900 group-hover:text-primary transition-colors leading-tight">{{ $merchant->shop_name ?? $merchant->business_name }}</h3>
                        <p class="text-[9px] font-black text-emerald-500 uppercase tracking-widest mt-1">✓ Verified Store</p>
                    </div>
                </div>

                <div class="space-y-6 mb-10">
                    <div class="flex items-center justify-between p-4 bg-slate-50 rounded-2xl">
                        <span class="text-[10px] font-black text-slate-400 uppercase tracking-widest">Active Assets</span>
                        <span class="text-sm font-black text-slate-900">{{ $merchant->products_count }} Products</span>
                    </div>
                    <div class="flex items-center justify-between p-4 bg-slate-50 rounded-2xl">
                        <span class="text-[10px] font-black text-slate-400 uppercase tracking-widest">Growth</span>
                        <div class="flex text-amber-400 text-[10px]">★★★★★</div>
                    </div>
                </div>

                <p class="text-slate-500 text-xs font-medium leading-relaxed mb-10 line-clamp-3">
                    {{ $merchant->business_description ?? 'This verified store provides high-quality products to the C-Market ecosystem.' }}
                </p>

                <div class="mt-auto pt-8 border-t border-slate-50 flex gap-4">
                    <a href="{{ route('products.index', ['merchant' => $merchant->id]) }}" class="flex-1 h-12 bg-slate-900 text-white rounded-2xl flex items-center justify-center text-[10px] font-black uppercase tracking-widest hover:bg-primary transition-all active:scale-95 shadow-xl shadow-slate-900/10">
                        Visit Shop ➔
                    </a>
                    <button class="w-12 h-12 bg-white border border-slate-100 rounded-2xl flex items-center justify-center hover:text-primary transition-colors shadow-soft">
                        💬
                    </button>
                </div>
            </div>
        @empty
            <div class="col-span-full py-40 text-center">
                <div class="text-7xl mb-8 opacity-20">🏢</div>
                <h2 class="text-xl font-black text-slate-800 mb-2">No Active Stores</h2>
                <p class="text-slate-400 font-bold uppercase tracking-widest text-[10px]">We are onboarding new merchants soon.</p>
            </div>
        @endforelse
    </div>
</section>
@endsection
