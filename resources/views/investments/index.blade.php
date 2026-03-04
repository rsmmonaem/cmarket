@extends('layouts.customer')

@section('title', 'Investment Marketplace')
@section('page-title', 'Chain Shop & Share Market')

@section('content')
<div class="space-y-10">
    <!-- Hero Banner -->
    <div class="bg-slate-900 rounded-[2.5rem] p-10 text-white relative overflow-hidden shadow-2xl">
        <div class="relative z-10 max-w-2xl">
            <span class="inline-block px-4 py-1.5 rounded-full bg-sky-500/20 text-sky-400 text-[10px] font-black uppercase tracking-widest mb-4 border border-sky-500/30">Future Wealth</span>
            <h2 class="text-4xl md:text-5xl font-black mb-4 leading-[1.1] tracking-tight">Become a Shareholder in <span class="text-sky-500">Prime Locations</span></h2>
            <p class="text-slate-400 font-bold mb-8 leading-relaxed">Invest in CMarket's verified chain shops and earn a lifetime share of profits. Secure, transparent, and high-yield investment opportunities.</p>
            <div class="flex items-center gap-6">
                <div class="flex -space-x-3">
                    <div class="w-10 h-10 rounded-full border-2 border-slate-900 bg-slate-800"></div>
                    <div class="w-10 h-10 rounded-full border-2 border-slate-900 bg-slate-700"></div>
                    <div class="w-10 h-10 rounded-full border-2 border-slate-900 bg-slate-600"></div>
                </div>
                <p class="text-xs font-black text-slate-400">JOIN 2.5K+ INVESTORS</p>
            </div>
        </div>
        <div class="absolute right-0 top-0 bottom-0 w-1/3 bg-gradient-to-l from-sky-600/20 to-transparent hidden lg:block"></div>
        <div class="absolute -right-20 -bottom-20 opacity-10 text-[300px] leading-none select-none">🏦</div>
    </div>

    <!-- Marketplace Grid -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
        @foreach($shops as $shop)
        <div class="group bg-white rounded-[2rem] border border-slate-100 shadow-sm hover:shadow-2xl hover:-translate-y-2 transition-all overflow-hidden">
            <div class="h-48 bg-slate-100 relative overflow-hidden">
                <div class="absolute inset-0 bg-gradient-to-b from-transparent to-black/20"></div>
                <div class="absolute top-4 left-4 bg-white/90 backdrop-blur px-3 py-1.5 rounded-xl text-[10px] font-black text-slate-800 shadow-sm uppercase tracking-widest flex items-center gap-2">
                    <span class="w-2 h-2 rounded-full bg-emerald-500 animate-pulse"></span>
                    Now Funding
                </div>
                <!-- Placeholder for Image -->
                <div class="flex items-center justify-center h-full text-4xl opacity-20 group-hover:scale-110 transition-transform duration-700">🏢</div>
            </div>
            
            <div class="p-8">
                <div class="flex items-center justify-between mb-4">
                    <h3 class="text-lg font-black text-slate-800 leading-snug">{{ $shop->name }}</h3>
                </div>
                
                <p class="text-xs text-muted-light line-clamp-2 mb-6 font-medium leading-relaxed">
                    {{ $shop->description }}
                </p>

                <div class="space-y-4 mb-8">
                    <div class="flex justify-between items-center text-[10px] font-black uppercase tracking-widest">
                        <span class="text-muted-light">Share Price</span>
                        <span class="text-slate-800">৳{{ number_format($shop->share_price, 2) }}</span>
                    </div>
                    
                    <div class="w-full bg-slate-100 h-2 rounded-full overflow-hidden">
                        @php $percent = (($shop->total_shares - $shop->available_shares) / $shop->total_shares) * 100; @endphp
                        <div class="bg-sky-500 h-full rounded-full" style="width: {{ $percent }}%"></div>
                    </div>
                    
                    <div class="flex justify-between items-center text-[10px] font-black">
                        <span class="text-muted-light uppercase tracking-widest">Available</span>
                        <span class="text-sky-600">{{ number_format($shop->available_shares) }} / {{ number_format($shop->total_shares) }} Shares</span>
                    </div>
                </div>

                <a href="{{ route('investments.show', $shop) }}" class="w-full bg-slate-900 group-hover:bg-sky-600 text-white font-black py-4 rounded-2xl flex items-center justify-center gap-3 transition-colors shadow-lg">
                    Buy Shares <span>💰</span>
                </a>
            </div>
        </div>
        @endforeach
    </div>
</div>
@endsection
