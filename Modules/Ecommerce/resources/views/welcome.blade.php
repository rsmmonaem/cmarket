@extends('layouts.public')

@section('content')
<div class="space-y-6 md:space-y-12 pb-20">
    <!-- High Impact Hero Section -->
    <section class="relative">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-2 md:py-8">
            <div class="relative rounded-[1.5rem] md:rounded-[3rem] overflow-hidden aspect-[16/9] sm:aspect-[21/9] lg:h-[500px] shadow-3xl group">
                @forelse($mainBanners as $banner)
                    <div class="absolute inset-0">
                        <img src="{{ asset('storage/' . $banner->image) }}" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-[2000ms]">
                        <div class="absolute inset-0 bg-gradient-to-t md:bg-gradient-to-r from-dark/80 via-dark/20 to-transparent flex flex-col justify-end md:justify-center p-5 md:px-20 text-white">
                            <div class="animate-fade-in space-y-2 md:space-y-6">
                                <span class="bg-primary/20 backdrop-blur-md text-primary px-3 py-1 rounded-full text-[8px] md:text-[10px] font-black uppercase tracking-widest w-fit inline-block">Flash Collection</span>
                                <h1 class="text-xl md:text-6xl lg:text-7xl font-black leading-tight tracking-tighter drop-shadow-2xl max-w-2xl">{{ $banner->title }}</h1>
                                <div class="flex flex-wrap gap-4 pt-1 md:pt-4">
                                    <a href="{{ $banner->link ?? '#' }}" class="bg-primary text-white px-6 py-2.5 md:px-10 md:py-5 rounded-xl md:rounded-2xl font-black text-[10px] md:text-[12px] uppercase tracking-widest hover:scale-105 transition shadow-2xl active:scale-95">Shop Now →</a>
                                </div>
                            </div>
                        </div>
                    </div>
                @empty
                    <div class="absolute inset-0 flex flex-col justify-center items-center text-center p-8 md:px-20 text-white bg-dark">
                        <h1 class="text-4xl md:text-8xl font-black mb-6 leading-tight tracking-tighter">PREMIUM <br><span class="text-primary italic">DEALS</span></h1>
                        <a href="#" class="bg-primary text-white px-12 py-5 rounded-2xl font-black text-[12px] uppercase tracking-widest shadow-2xl hover:bg-primary-hover transition active:scale-95">Start Discovery</a>
                    </div>
                @endforelse
            </div>
        </div>
    </section>

    <!-- Quick Actions (Mobile App Style) -->
    {{-- <section class="lg:hidden px-4">
        <div class="flex items-center justify-between gap-4 overflow-x-auto no-scrollbar pb-2">
            @foreach($popularCategories->take(5) as $cat)
                <a href="{{ route('products.index', ['category' => $cat->slug]) }}" class="flex flex-col items-center gap-2 min-w-[70px]">
                    <div class="w-14 h-14 rounded-2xl bg-white shadow-sm flex items-center justify-center text-2xl border border-slate-100">
                        {{ $cat->image ? '🖼️' : '📂' }}
                    </div>
                    <span class="text-[10px] font-bold text-slate-600 text-center truncate w-full">{{ $cat->name }}</span>
                </a>
            @endforeach
        </div>
    </section> --}}

    <!-- Categories Slide Section -->
    <section class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 -mt-6 md:mt-0 relative z-20">
        <div class="bg-white/80 backdrop-blur-xl rounded-[2.5rem] p-5 md:p-8 shadow-2xl shadow-slate-200/50 border border-white">
            <div class="flex items-center justify-between mb-6 md:mb-8 px-2">
                <div>
                    <h2 class="text-xs md:text-sm font-black text-slate-800 uppercase tracking-widest flex items-center gap-2">
                        <span class="w-2 h-2 rounded-full bg-primary animate-pulse"></span>
                        Top Categories
                    </h2>
                </div>
                <a href="{{ route('categories.index') }}" class="text-[10px] font-black text-primary uppercase tracking-widest hover:translate-x-1 transition-transform inline-flex items-center gap-2 bg-primary/5 px-4 py-2 rounded-full">
                    Explore ➔
                </a>
            </div>
            
            <div class="flex overflow-x-auto gap-5 md:gap-10 pb-4 no-scrollbar scroll-smooth">
                @foreach($popularCategories as $cat)
                    <a href="{{ route('products.index', ['category' => $cat->slug]) }}" class="flex-shrink-0 group text-center w-20 md:w-28">
                        <div class="relative w-16 h-16 md:w-24 md:h-24 mx-auto mb-4">
                            <!-- Animated Ring -->
                            <div class="absolute inset-0 rounded-[2rem] border-2 border-primary/0 group-hover:border-primary/50 group-hover:scale-110 transition-all duration-500"></div>
                            
                            <div class="w-full h-full rounded-[1.8rem] bg-slate-50 flex items-center justify-center p-0.5 group-hover:bg-white group-hover:shadow-2xl group-hover:-translate-y-2 transition-all duration-500 border border-slate-100 overflow-hidden relative z-10">
                                @if($cat->image)
                                    <img src="{{ asset('storage/' . $cat->image) }}" class="w-full h-full object-cover rounded-[1.6rem]">
                                @else
                                    <div class="w-full h-full flex flex-col items-center justify-center bg-gradient-to-br from-slate-50 to-slate-100">
                                        <span class="text-2xl md:text-4xl group-hover:scale-110 transition-transform duration-500">🏷️</span>
                                    </div>
                                @endif
                            </div>
                        </div>
                        <span class="text-[9px] md:text-[11px] font-black text-slate-500 group-hover:text-primary transition-colors block leading-tight px-1 uppercase tracking-tighter">
                            {{ $cat->name }}
                        </span>
                    </a>
                @endforeach
            </div>
        </div>
    </section>

    <style>
        .no-scrollbar::-webkit-scrollbar { display: none; }
        .no-scrollbar { -ms-overflow-style: none; scrollbar-width: none; }
    </style>

    <!-- Flash Deals Section -->
    @if($flashDeals->count() > 0)
    <section class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="bg-white rounded-2xl md:rounded-[2.5rem] p-5 md:p-10 border border-slate-100 shadow-2xl relative overflow-hidden">
            <div class="flex flex-col md:flex-row justify-between items-start md:items-center gap-6 mb-8 relative z-10">
                <div class="flex items-center gap-4">
                    <div class="w-12 h-12 bg-primary text-white flex items-center justify-center text-2xl rounded-2xl shadow-xl shadow-primary/20 animate-pulse">⚡</div>
                    <div>
                        <h2 class="text-2xl md:text-4xl font-black text-dark tracking-tight">Flash Deals</h2>
                        <p class="text-[10px] font-black text-primary uppercase tracking-widest mt-1">Hurry! Offers ending soon</p>
                    </div>
                </div>
                
                <div class="flex items-center gap-4 bg-slate-50 px-6 py-3 rounded-2xl border border-slate-100 w-full md:w-auto overflow-hidden">
                    <div class="flex gap-4 font-black text-dark mx-auto">
                        <div class="flex flex-col items-center"><span id="cd-hours" class="text-xl tabular-nums">00</span><span class="text-[8px] uppercase text-slate-400">Hours</span></div>
                        <span class="text-slate-300 text-xl">:</span>
                        <div class="flex flex-col items-center"><span id="cd-minutes" class="text-xl tabular-nums">00</span><span class="text-[8px] uppercase text-slate-400">Mins</span></div>
                        <span class="text-slate-300 text-xl">:</span>
                        <div class="flex flex-col items-center"><span id="cd-seconds" class="text-xl tabular-nums text-primary">00</span><span class="text-[8px] uppercase text-slate-400">Secs</span></div>
                    </div>
                </div>
            </div>

            <div class="grid grid-cols-2 lg:grid-cols-4 gap-4 md:gap-8 relative z-10">
                @foreach($flashDeals as $product)
                    <div onclick="window.location.href='{{ route('products.show', $product) }}'" class="group bg-slate-50/50 rounded-2xl p-3 md:p-5 border border-transparent hover:border-primary/20 hover:bg-white hover:shadow-2xl transition-all cursor-pointer relative">
                        @if($product->discount_percentage > 0)
                            <div class="absolute top-3 left-3 z-10 bg-primary text-white text-[9px] font-black px-2 py-1 rounded-lg">
                                -{{ round($product->discount_percentage) }}%
                            </div>
                        @endif
                        
                        <div class="aspect-square rounded-xl bg-white overflow-hidden mb-4 flex items-center justify-center p-2">
                            @php $imgArr = is_array($product->images) ? $product->images : (json_decode($product->images, true) ?: []); $img = $imgArr[0] ?? null; @endphp
                            @if($img)
                                <img src="{{ asset('storage/' . $img) }}" class="w-full h-full object-cover group-hover:scale-110 transition-duration-500">
                            @else
                                <span class="text-4xl opacity-10">🛍️</span>
                            @endif
                        </div>
                        
                        <div class="space-y-1">
                            <h3 class="text-[13px] md:text-base font-bold text-dark line-clamp-1">{{ $product->name }}</h3>
                            <div class="flex items-center gap-2">
                                <span class="text-base md:text-xl font-black text-primary">৳{{ number_format($product->final_price) }}</span>
                                @if($product->discount_price)
                                    <span class="text-[10px] md:text-xs font-bold text-slate-400 line-through">৳{{ number_format($product->price) }}</span>
                                @endif
                            </div>
                            <!-- Cashback Badge -->
                            @if($product->cashback_amount > 0)
                            <div class="bg-emerald-50 text-emerald-600 text-[8px] font-black px-2 py-1 rounded-md w-fit mt-2 uppercase tracking-tighter">
                                Cashbask: ৳{{ number_format($product->cashback_amount) }}
                            </div>
                            @endif
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </section>
    @endif

    <!-- Featured Products Grid -->
    <section class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between items-end mb-6">
            <div>
                <h2 class="text-2xl md:text-3xl font-black text-dark tracking-tight">Featured Collection</h2>
                <div class="h-1 w-12 bg-primary mt-2 rounded-full"></div>
            </div>
            <a href="{{ route('products.index') }}" class="text-[10px] font-black text-slate-400 uppercase tracking-widest hover:text-primary transition">View All →</a>
        </div>
        
        <div class="grid grid-cols-2 lg:grid-cols-4 xl:grid-cols-5 gap-4 md:gap-6">
            @foreach($featuredProducts as $product)
                <div onclick="window.location.href='{{ route('products.show', $product) }}'" class="group bg-white rounded-2xl p-3 border border-slate-100 hover:shadow-xl transition-all relative flex flex-col h-full cursor-pointer">
                    <div class="aspect-square rounded-xl bg-slate-50 overflow-hidden mb-4 relative">
                        <!-- Add to Wishlist -->
                        <button onclick="event.stopPropagation();" class="absolute top-2 right-2 z-10 w-8 h-8 bg-white/80 backdrop-blur-md rounded-lg shadow-sm flex items-center justify-center text-slate-400 hover:text-rose-500 transition opacity-0 group-hover:opacity-100">🤍</button>
                        
                        @php $imgArr = is_array($product->images) ? $product->images : (json_decode($product->images, true) ?: []); $img = $imgArr[0] ?? null; @endphp
                        @if($img)
                            <img src="{{ asset('storage/' . $img) }}" class="w-full h-full object-cover group-hover:scale-110 transition duration-500">
                        @else
                            <span class="text-2xl opacity-10">🛍️</span>
                        @endif
                    </div>
                    
                    <div class="flex-1 space-y-2">
                        <p class="text-[9px] font-black text-slate-400 uppercase tracking-widest">{{ $product->category->name ?? 'Product' }}</p>
                        <h3 class="text-sm font-bold text-dark line-clamp-2 h-10 leading-snug">{{ $product->name }}</h3>
                        <div class="flex items-center justify-between mt-auto pt-2 border-t border-slate-50">
                            <span class="text-base font-black text-dark">৳{{ number_format($product->final_price) }}</span>
                            <button onclick="event.stopPropagation(); addToCart({{ $product->id }})" class="w-9 h-9 bg-dark text-white rounded-lg flex items-center justify-center hover:bg-primary transition shadow-lg shadow-dark/10">🛒</button>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </section>

    <!-- Mid Promotional Banner -->
    @if($midBanners->count() > 0)
    <section class="max-w-7xl mx-auto px-4 lg:px-8">
        @php $banner = $midBanners->first(); @endphp
        <div class="relative rounded-[2rem] overflow-hidden group aspect-[2/1] md:aspect-[21/7]">
            <img src="{{ asset('storage/' . $banner->image) }}" class="w-full h-full object-cover">
            <div class="absolute inset-0 bg-dark/40 flex flex-col justify-center items-center text-center px-6">
                <h3 class="text-2xl md:text-4xl font-black text-white mb-6 uppercase tracking-tight">{{ $banner->title }}</h3>
                <a href="{{ $banner->link ?? '#' }}" class="bg-white text-dark px-8 py-3.5 rounded-xl font-black text-[10px] uppercase tracking-widest hover:scale-105 transition shadow-2xl">Claim Offer</a>
            </div>
        </div>
    </section>
    @endif

    <!-- New Arrivals Section -->
    <section class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between items-end mb-6">
            <div>
                <h2 class="text-2xl md:text-3xl font-black text-dark tracking-tight">New Arrivals</h2>
                <div class="h-1 w-12 bg-primary mt-2 rounded-full"></div>
            </div>
        </div>
        
        <div class="grid grid-cols-2 lg:grid-cols-4 gap-4 md:gap-8">
            @foreach($newArrivals as $product)
                <div onclick="window.location.href='{{ route('products.show', $product) }}'" class="group bg-white rounded-2xl p-4 border border-slate-100 hover:shadow-2xl transition-all cursor-pointer">
                    <div class="aspect-square rounded-xl bg-slate-50 overflow-hidden mb-4 relative flex items-center justify-center">
                        <span class="absolute top-2 left-2 z-10 bg-emerald-500 text-white text-[8px] font-black px-2 py-1 rounded-md uppercase">New</span>
                        @php $imgArr = is_array($product->images) ? $product->images : (json_decode($product->images, true) ?: []); $img = $imgArr[0] ?? null; @endphp
                        @if($img)
                            <img src="{{ asset('storage/' . $img) }}" class="w-full h-full object-cover group-hover:scale-110 transition duration-500">
                        @else
                            <span class="text-3xl opacity-10">🛍️</span>
                        @endif
                    </div>
                    <h3 class="text-sm font-bold text-dark line-clamp-1 mb-2">{{ $product->name }}</h3>
                    <p class="text-lg font-black text-primary">৳{{ number_format($product->final_price) }}</p>
                </div>
            @endforeach
        </div>
    </section>
</div>

@if($popupBanner)
<!-- Initial Popup Matrix -->
<div id="matrix-popup" class="fixed inset-0 z-[100] flex items-center justify-center p-6 bg-slate-900/80 backdrop-blur-md opacity-0 invisible transition-all duration-700">
    <div class="bg-white rounded-3xl overflow-hidden max-w-lg w-full relative shadow-3xl scale-90 transition-all duration-700" id="popup-content">
        <button onclick="closePopup()" class="absolute top-4 right-4 w-10 h-10 bg-white/20 hover:bg-white/40 backdrop-blur-md rounded-xl flex items-center justify-center text-white z-20 transition">✕</button>
        <div class="relative">
            <img src="{{ asset('storage/' . $popupBanner->image) }}" class="w-full aspect-square object-cover">
            <div class="absolute inset-x-0 bottom-0 p-8 bg-gradient-to-t from-dark/95 to-transparent text-center">
                <h3 class="text-2xl font-black text-white mb-4">{{ $popupBanner->title }}</h3>
                <a href="{{ $popupBanner->link ?? '#' }}" class="inline-block bg-primary text-white px-10 py-4 rounded-xl font-black text-[12px] uppercase tracking-widest shadow-xl">Claim Now</a>
            </div>
        </div>
    </div>
</div>

<script>
    window.onload = function() {
        setTimeout(() => {
            const popup = document.getElementById('matrix-popup');
            const content = document.getElementById('popup-content');
            if(popup && content) {
                popup.classList.remove('opacity-0', 'invisible');
                content.classList.remove('scale-90');
            }
        }, 3000);
    };
    function closePopup() {
        document.getElementById('matrix-popup').classList.add('opacity-0', 'invisible');
    }
</script>
@endif

@push('scripts')
<script>
    function updateCountdown() {
        const dealEnd = new Date("{{ $flashDeals->first()?->flash_deal_end ?? now()->addDays(1) }}").getTime();
        const now = new Date().getTime();
        const distance = dealEnd - now;
        if (distance < 0) return;
        const hours = Math.floor((distance % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
        const minutes = Math.floor((distance % (1000 * 60 * 60)) / (1000 * 60));
        const seconds = Math.floor((distance % (1000 * 60)) / 1000);
        const h = document.getElementById('cd-hours');
        const m = document.getElementById('cd-minutes');
        const s = document.getElementById('cd-seconds');
        if(h) h.innerText = hours.toString().padStart(2, '0');
        if(m) m.innerText = minutes.toString().padStart(2, '0');
        if(s) s.innerText = seconds.toString().padStart(2, '0');
    }
    setInterval(updateCountdown, 1000);
    updateCountdown();
</script>
@endpush
@endsection
