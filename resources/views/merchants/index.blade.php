@extends('layouts.public')

@section('title', 'Merchant Infrastructure - EcomMatrix')

@section('content')
<!-- Header Node -->
<section class="bg-slate-900 py-24 text-center relative overflow-hidden">
    <!-- Decor -->
    <div class="absolute inset-0 opacity-10 pointer-events-none -rotate-12 flex items-center justify-center">
        <span class="text-[300px] font-black italic text-slate-700">MERCHANTS</span>
    </div>
    
    <div class="max-w-7xl mx-auto px-4 relative z-10">
        <h1 class="text-4xl lg:text-6xl font-black text-white mb-6 tracking-tighter">Verified <span class="text-primary">Merchants</span></h1>
        <p class="text-slate-400 text-sm font-bold uppercase tracking-[0.3em]">Direct access to global manufacturing and distribution nodes</p>
    </div>
</section>

<section class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-24">
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-10">
        @forelse($merchants as $merchant)
            <div class="group bg-white rounded-[3rem] p-10 border border-slate-100 shadow-soft hover:shadow-2xl hover:shadow-slate-200/50 transition-all duration-700 relative flex flex-col">
                <div class="flex items-center gap-6 mb-10">
                    <div class="w-24 h-24 rounded-4xl bg-slate-50 flex items-center justify-center group-hover:scale-110 transition-transform shadow-inner overflow-hidden border border-slate-100 p-4">
                        @if($merchant->logo)
                            <img src="{{ asset('storage/' . $merchant->logo) }}" class="w-full h-full object-contain">
                        @else
                            <span class="text-4xl">🏢</span>
                        @endif
                    </div>
                    <div>
                        <h3 class="text-xl font-black text-slate-900 group-hover:text-primary transition-colors leading-tight">{{ $merchant->shop_name ?? $merchant->business_name }}</h3>
                        <p class="text-[9px] font-black text-primary uppercase tracking-widest mt-1">Status: Verified node</p>
                    </div>
                </div>

                <div class="space-y-6 mb-10">
                    <div class="flex items-center justify-between p-4 bg-slate-50 rounded-2xl">
                        <span class="text-[10px] font-black text-slate-400 uppercase tracking-widest">Active Assets</span>
                        <span class="text-sm font-black text-slate-900">{{ $merchant->products_count }} Products</span>
                    </div>
                    <div class="flex items-center justify-between p-4 bg-slate-50 rounded-2xl">
                        <span class="text-[10px] font-black text-slate-400 uppercase tracking-widest">Growth Performance</span>
                        <div class="flex text-amber-400 text-xs">★★★★★</div>
                    </div>
                </div>

                <p class="text-slate-500 text-xs font-medium leading-relaxed mb-10 line-clamp-3">
                    {{ $merchant->business_description ?? 'This verified merchant is a core node in our distribution infrastructure, providing high-quality assets to the global EcomMatrix ecosystem.' }}
                </p>

                <div class="mt-auto pt-8 border-t border-slate-50 flex gap-4">
                    <a href="{{ route('products.index', ['merchant' => $merchant->id]) }}" class="flex-1 h-12 bg-slate-900 text-white rounded-2xl flex items-center justify-center text-[10px] font-black uppercase tracking-widest hover:bg-primary transition-all active:scale-95 shadow-xl shadow-slate-900/10">
                        Scan Products ➔
                    </a>
                    <button class="w-12 h-12 bg-white border border-slate-100 rounded-2xl flex items-center justify-center hover:text-primary transition-colors shadow-soft">
                        💬
                    </button>
                </div>
            </div>
        @empty
            <div class="col-span-full py-40 text-center">
                <div class="text-7xl mb-8 opacity-20">🏢</div>
                <h2 class="text-2xl font-black text-slate-900 mb-4">No Active Merchants</h2>
                <p class="text-slate-400 font-bold uppercase tracking-widest text-xs">Syncing with global merchant network...</p>
            </div>
        @endforelse
    </div>
</section>
@endsection
