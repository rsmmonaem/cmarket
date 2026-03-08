@extends('layouts.public')

@section('content')
<div class="space-y-20 pb-20">
    <!-- Hero Section -->
    <section class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 pt-8">
        <div class="grid grid-cols-1 lg:grid-cols-4 gap-8">
            <!-- Sidebar Categories (Desktop) -->
            <div class="hidden lg:block bg-white rounded-xl border border-slate-100 shadow-sm p-5 h-full">
                <p class="text-[10px] font-black text-slate-400 uppercase tracking-[0.2em] mb-6 px-2">Popular Categories</p>
                <div class="space-y-1">
                    @foreach($popularCategories as $cat)
                        <a href="{{ route('categories.index') }}" class="flex items-center justify-between px-3 py-3.5 rounded-xl hover:bg-slate-50 transition-standard group">
                            <span class="text-[13px] font-bold text-slate-700 group-hover:text-primary transition-standard">{{ $cat->name }}</span>
                            <span class="text-[10px] font-black text-slate-300 group-hover:text-primary opacity-0 group-hover:opacity-100 transition-standard group-hover:translate-x-1">➔</span>
                        </a>
                    @endforeach
                </div>
            </div>

            <!-- Hero Banner Slider -->
            <div class="lg:col-span-3">
                <div class="relative rounded-2xl overflow-hidden aspect-[21/9] lg:aspect-auto lg:h-[500px] gradient-primary group shadow-2xl">
                    @forelse($mainBanners as $banner)
                        <div class="absolute inset-0 transition-opacity duration-1000">
                            <img src="{{ asset('storage/' . $banner->image) }}" class="w-full h-full object-cover group-hover:scale-105 transition-standard duration-[2s]">
                            <div class="absolute inset-0 bg-gradient-to-r from-dark/80 via-dark/40 to-transparent flex flex-col justify-center px-8 md:px-20 text-white">
                                <h1 class="text-3xl md:text-5xl lg:text-[56px] font-black mb-6 leading-[1.1] tracking-tighter animate-float drop-shadow-2xl max-w-2xl">{{ $banner->title }}</h1>
                                <div class="flex flex-wrap gap-4">
                                    <a href="{{ $banner->link ?? '#' }}" class="inline-flex items-center gap-4 bg-primary text-white px-10 py-5 rounded-xl font-black text-[13px] uppercase tracking-widest hover:scale-105 transition-standard shadow-xl shadow-primary/30 active:scale-95">
                                        Shop Now ➔
                                    </a>
                                    <a href="{{ route('products.index') }}" class="inline-flex items-center gap-4 bg-white/10 backdrop-blur-md border border-white/20 text-white px-10 py-5 rounded-xl font-black text-[13px] uppercase tracking-widest hover:bg-white/20 transition-standard active:scale-95">
                                        Explore Products
                                    </a>
                                </div>
                            </div>
                        </div>
                    @empty
                        <div class="absolute inset-0 flex flex-col justify-center px-12 md:px-20 text-white bg-dark">
                            <h1 class="text-4xl md:text-7xl font-black mb-6 leading-tight tracking-tighter">Premium Deals <br><span class="text-primary italic">Live Now</span></h1>
                            <div class="flex gap-4">
                                <a href="#" class="inline-flex items-center gap-4 bg-primary text-white px-10 py-5 rounded-xl font-black text-[13px] uppercase tracking-widest hover:scale-105 transition-standard shadow-2xl w-fit">
                                    Start Discovery ➔
                                </a>
                            </div>
                        </div>
                    @endforelse
                </div>
            </div>
        </div>
    </section>

    <!-- Flash Deals Section -->
    @if($flashDeals->count() > 0)
    <section class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="bg-white rounded-[2rem] p-8 md:p-12 border border-slate-100 shadow-2xl relative overflow-hidden">
            <div class="flex flex-col md:flex-row justify-between items-center gap-8 mb-12 relative z-10">
                <div class="flex items-center gap-6">
                    <div class="w-16 h-16 bg-primary text-white flex items-center justify-center text-3xl rounded-2xl shadow-xl shadow-primary/20 animate-pulse">
                        ⚡
                    </div>
                    <div>
                        <h2 class="text-2xl md:text-4xl font-black text-dark tracking-tight">Flash Deals</h2>
                        <p class="text-[10px] font-black text-primary uppercase tracking-[0.2em] mt-1">Limited time offers</p>
                    </div>
                </div>
                
                <div class="flex items-center gap-6 bg-slate-50 px-8 py-5 rounded-2xl border border-slate-100">
                    <p class="text-[11px] font-black text-slate-500 uppercase tracking-widest hidden md:block">Ending In</p>
                    <div class="flex gap-4 font-black text-dark">
                        <div class="flex flex-col items-center">
                            <span id="cd-hours" class="text-2xl tabular-nums">00</span>
                            <span class="text-[8px] uppercase tracking-tighter text-slate-400">Hours</span>
                        </div>
                        <span class="text-slate-300 text-2xl">:</span>
                        <div class="flex flex-col items-center">
                            <span id="cd-minutes" class="text-2xl tabular-nums">00</span>
                            <span class="text-[8px] uppercase tracking-tighter text-slate-400">Mins</span>
                        </div>
                        <span class="text-slate-300 text-2xl">:</span>
                        <div class="flex flex-col items-center">
                            <span id="cd-seconds" class="text-2xl tabular-nums text-primary">00</span>
                            <span class="text-[8px] uppercase tracking-tighter text-slate-400">Secs</span>
                        </div>
                    </div>
                </div>
            </div>

            <div class="grid grid-cols-2 lg:grid-cols-4 gap-8 relative z-10">
                @foreach($flashDeals as $product)
                    <div class="group bg-slate-50 rounded-2xl p-5 card-shadow transition-standard hover:bg-white hover:shadow-2xl relative">
                        <!-- Discount Badge -->
                        @if($product->discount_percentage > 0)
                            <div class="absolute top-4 left-4 z-10 bg-primary text-white text-[10px] font-black px-3 py-1.5 rounded-lg shadow-lg">
                                -{{ round($product->discount_percentage) }}%
                            </div>
                        @endif
                        
                        <div class="aspect-square rounded-xl bg-white overflow-hidden mb-6 flex items-center justify-center border border-slate-100 transition-standard group-hover:p-2">
                            @php $imgArr = is_array($product->images) ? $product->images : (json_decode($product->images, true) ?: []); $img = $imgArr[0] ?? null; @endphp
                            @if($img)
                                <img src="{{ asset('storage/' . $img) }}" class="w-full h-full object-cover transition-standard group-hover:scale-110">
                            @else
                                <span class="text-4xl opacity-10">🛍️</span>
                            @endif
                        </div>
                        
                        <div class="space-y-3">
                            <p class="text-[10px] font-black text-primary uppercase tracking-widest">{{ $product->category->name ?? 'Product' }}</p>
                            <h3 class="text-[15px] font-black text-dark line-clamp-1 h-6">{{ $product->name }}</h3>
                            <div class="flex items-baseline gap-3">
                                <span class="text-xl font-black text-dark">৳{{ number_format($product->final_price) }}</span>
                                @if($product->discount_price)
                                    <span class="text-[11px] font-bold text-slate-400 line-through">৳{{ number_format($product->price) }}</span>
                                @endif
                            </div>
                        </div>

                        <!-- Quick Actions -->
                        <div class="mt-8 flex gap-3 opacity-0 group-hover:opacity-100 transition-standard translate-y-4 group-hover:translate-y-0">
                            <form action="{{ route('cart.add', $product) }}" method="POST" class="flex-1">
                                @csrf
                                <button type="submit" class="w-full bg-dark text-white py-4 rounded-xl font-black text-[10px] uppercase tracking-widest hover:bg-primary transition-standard active:scale-95 shadow-lg">
                                    Add to Cart
                                </button>
                            </form>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </section>
    @endif

    <!-- Popular Categories -->
    <section class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="mb-12 flex justify-between items-end">
            <div>
                <h2 class="text-3xl font-black text-dark tracking-tight">Browse Categories</h2>
                <p class="text-[10px] font-black text-slate-400 uppercase tracking-[0.2em] mt-2">Explore our collections</p>
            </div>
            <a href="{{ route('categories.index') }}" class="text-[11px] font-black text-primary uppercase tracking-widest hover:brightness-110 group transition-standard">
                View All <span class="inline-block group-hover:translate-x-2 transition-standard">➔</span>
            </a>
        </div>
        
        <div class="grid grid-cols-2 md:grid-cols-5 gap-8">
            @foreach($popularCategories as $cat)
                <a href="{{ route('categories.index') }}" class="group bg-white p-10 rounded-2xl border border-slate-100 card-shadow hover:shadow-2xl hover:-translate-y-2 transition-standard text-center flex flex-col items-center relative overflow-hidden">
                    <div class="absolute top-0 right-0 w-32 h-32 bg-primary/5 rounded-full -mr-16 -mt-16 transition-standard group-hover:bg-primary/10"></div>
                    <div class="w-20 h-20 rounded-2xl bg-slate-50 flex items-center justify-center text-4xl mb-6 group-hover:scale-110 transition-standard overflow-hidden font-black relative z-10 shadow-sm group-hover:shadow-xl">
                        @if($cat->image)
                            <img src="{{ asset('storage/' . $cat->image) }}" class="w-full h-full object-cover">
                        @else
                            📂
                        @endif
                    </div>
                    <span class="text-xs font-black text-dark uppercase tracking-widest group-hover:text-primary transition-standard relative z-10">{{ $cat->name }}</span>
                    <div class="mt-4 px-3 py-1 bg-slate-50 rounded-lg group-hover:bg-primary/5 transition-standard">
                        <span class="text-[9px] font-bold text-slate-400 group-hover:text-primary/70">{{ $cat->products_count }} Products</span>
                    </div>
                </a>
            @endforeach
        </div>
    </section>

    <!-- Mid Promotional Banners -->
    @if($midBanners->count() > 0)
    <section class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
            @foreach($midBanners->take(2) as $banner)
                <div class="relative rounded-[3rem] overflow-hidden group aspect-[16/7]">
                    <img src="{{ asset('storage/' . $banner->image) }}" class="w-full h-full object-cover transition-transform duration-700 group-hover:scale-105">
                    <div class="absolute inset-0 bg-black/40 flex flex-col justify-center px-10 text-white">
                        <h3 class="text-2xl font-black mb-4 tracking-tight">{{ $banner->title }}</h3>
                        <a href="{{ $banner->link ?? '#' }}" class="text-[10px] font-black uppercase tracking-widest border-b-2 border-primary pb-1 w-fit">Initiate Discovery Node ➔</a>
                    </div>
                </div>
            @endforeach
        </div>
    </section>
    @endif

    <!-- Featured Products Section -->
    <section class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="mb-12 flex justify-between items-end">
            <div>
                <h2 class="text-3xl font-black text-dark tracking-tight">Featured Products</h2>
                <p class="text-[10px] font-black text-slate-400 uppercase tracking-[0.2em] mt-2">Handpicked for you</p>
            </div>
            <a href="{{ route('products.index') }}" class="text-[11px] font-black text-primary uppercase tracking-widest transition-standard hover:brightness-110">View Inventory ➔</a>
        </div>
        
        <div class="grid grid-cols-2 lg:grid-cols-4 xl:grid-cols-5 gap-8">
            @foreach($featuredProducts as $product)
                <div class="group bg-white rounded-2xl p-4 border border-slate-50 card-shadow hover:shadow-2xl transition-standard relative flex flex-col h-full overflow-hidden">
                    <div class="aspect-square rounded-xl bg-slate-50 overflow-hidden mb-6 flex items-center justify-center relative shadow-inner">
                        <button class="absolute top-3 right-3 z-10 w-9 h-9 bg-white/90 backdrop-blur-md rounded-lg shadow-lg flex items-center justify-center text-slate-400 hover:text-rose-500 transition-standard opacity-0 group-hover:opacity-100 translate-x-4 group-hover:translate-x-0">
                            🤍
                        </button>
                        
                        @php $imgArr = is_array($product->images) ? $product->images : (json_decode($product->images, true) ?: []); $img = $imgArr[0] ?? null; @endphp
                        @if($img)
                            <img src="{{ asset('storage/' . $img) }}" class="w-full h-full object-cover transition-standard group-hover:scale-110">
                        @else
                            <span class="text-3xl opacity-10">🛍️</span>
                        @endif
                        
                        <!-- Quick View Overlay -->
                        <div class="absolute inset-0 bg-dark/40 opacity-0 group-hover:opacity-100 transition-standard flex items-center justify-center p-6">
                            <a href="{{ route('products.show', $product) }}" class="bg-white text-dark w-full py-3 rounded-lg font-black text-[10px] uppercase tracking-widest shadow-xl scale-90 group-hover:scale-100 transition-standard text-center">
                                Quick View
                            </a>
                        </div>
                    </div>
                    
                    <div class="space-y-3 flex-1 px-1">
                        <div class="flex justify-between items-start">
                             <p class="text-[9px] font-black text-primary uppercase tracking-widest">{{ $product->category->name ?? 'Product' }}</p>
                             <div class="flex text-[10px] text-amber-500">
                                 <span class="font-bold mr-1">4.5</span>
                                 <span class="opacity-50">★</span>
                             </div>
                        </div>
                        <h3 class="text-sm font-bold text-dark line-clamp-2 h-10 leading-relaxed transition-standard group-hover:text-primary">{{ $product->name }}</h3>
                        <div class="pt-4 flex items-center justify-between">
                            <div class="flex flex-col">
                                <span class="text-lg font-black text-dark tracking-tight">৳{{ number_format($product->final_price) }}</span>
                                @if($product->discount_price)
                                    <span class="text-[10px] font-bold text-slate-300 line-through">৳{{ number_format($product->price) }}</span>
                                @endif
                            </div>
                            <form action="{{ route('cart.add', $product) }}" method="POST">
                                @csrf
                                <button type="submit" class="w-10 h-10 bg-dark text-white rounded-lg flex items-center justify-center hover:bg-primary transition-standard shadow-lg shadow-dark/10 active:scale-90">
                                    🛒
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </section>

    <!-- Top Merchants Section -->
    <section class="bg-dark py-32 relative overflow-hidden">
        <div class="absolute top-0 inset-x-0 h-px bg-gradient-to-r from-transparent via-primary/30 to-transparent"></div>
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10">
            <div class="mb-16 text-center lg:text-left flex flex-col lg:flex-row justify-between items-end gap-8">
                <div>
                    <h2 class="text-3xl md:text-5xl font-black text-white tracking-tight">Verified Merchants</h2>
                    <p class="text-[11px] font-black text-primary uppercase tracking-[0.3em] mt-3">Shop from the most trusted stores</p>
                </div>
                <a href="{{ route('merchants.index') }}" class="text-white/60 hover:text-white text-[11px] font-black uppercase tracking-widest border-b border-white/20 pb-2 transition-standard">Discover All Stores</a>
            </div>
            
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-8">
                @foreach($topMerchants as $merchant)
                    <div class="bg-white/5 backdrop-blur-xl p-8 rounded-2xl border border-white/10 group hover:bg-white/10 transition-standard hover:border-white/20">
                        <div class="flex justify-between items-start mb-6">
                            <div class="w-20 h-20 rounded-xl bg-white p-3 flex items-center justify-center transition-standard group-hover:scale-110 shadow-2xl relative">
                                <div class="absolute -top-2 -right-2 w-6 h-6 bg-accent text-white flex items-center justify-center rounded-full text-[10px] shadow-lg">✓</div>
                                @if($merchant->logo)
                                    <img src="{{ asset('storage/' . $merchant->logo) }}" class="w-full h-full object-contain">
                                @else
                                    <span class="text-3xl">🏢</span>
                                @endif
                            </div>
                            <div class="text-right">
                                <div class="flex items-center gap-1 text-amber-400 font-black text-xs">
                                    <span class="text-white mr-1">4.9</span> ★
                                </div>
                                <p class="text-[9px] font-bold text-slate-500 uppercase mt-1">{{ $merchant->products_count }} Products</p>
                            </div>
                        </div>
                        <h3 class="text-lg font-black text-white mb-6 group-hover:text-primary transition-standard">{{ $merchant->shop_name ?? $merchant->business_name }}</h3>
                        <a href="{{ route('products.index', ['merchant' => $merchant->id]) }}" class="flex h-12 w-full bg-white text-dark items-center justify-center rounded-xl text-[10px] font-black uppercase tracking-widest hover:bg-primary hover:text-white transition-standard shadow-xl active:scale-95">
                            Visit Store
                        </a>
                    </div>
                @endforeach
            </div>
        </div>
    </section>

    <!-- Why Choose Us -->
    <section class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-12">
            <div class="flex flex-col items-center text-center group">
                <div class="w-20 h-20 bg-primary/10 rounded-full flex items-center justify-center mb-8 transition-standard group-hover:bg-primary group-hover:rotate-[360deg] duration-700 shadow-inner">
                    <span class="text-3xl group-hover:scale-125 transition-standard">🚀</span>
                </div>
                <h4 class="text-[13px] font-black text-dark uppercase tracking-widest mb-4">Fastest Logistics</h4>
                <p class="text-slate-500 text-xs font-medium leading-relaxed max-w-[200px]">Strategic optimization for ultra-fast delivery across the network.</p>
            </div>
            <div class="flex flex-col items-center text-center group">
                <div class="w-20 h-20 bg-accent/10 rounded-full flex items-center justify-center mb-8 transition-standard group-hover:bg-accent group-hover:rotate-[360deg] duration-700 shadow-inner">
                    <span class="text-3xl group-hover:scale-125 transition-standard">🛡️</span>
                </div>
                <h4 class="text-[13px] font-black text-dark uppercase tracking-widest mb-4">Secure Gateway</h4>
                <p class="text-slate-500 text-xs font-medium leading-relaxed max-w-[200px]">Multiple redundant layers of end-to-end security protocols.</p>
            </div>
            <div class="flex flex-col items-center text-center group">
                <div class="w-20 h-20 bg-emerald-500/10 rounded-full flex items-center justify-center mb-8 transition-standard group-hover:bg-emerald-500 group-hover:rotate-[360deg] duration-700 shadow-inner">
                    <span class="text-3xl group-hover:scale-125 transition-standard">🔄</span>
                </div>
                <h4 class="text-[13px] font-black text-dark uppercase tracking-widest mb-4">Express Returns</h4>
                <p class="text-slate-500 text-xs font-medium leading-relaxed max-w-[200px]">Hassle-free 7-day asset rollback and exchange policy.</p>
            </div>
            <div class="flex flex-col items-center text-center group">
                <div class="w-20 h-20 bg-amber-500/10 rounded-full flex items-center justify-center mb-8 transition-standard group-hover:bg-amber-500 group-hover:rotate-[360deg] duration-700 shadow-inner">
                    <span class="text-3xl group-hover:scale-125 transition-standard">💎</span>
                </div>
                <h4 class="text-[13px] font-black text-dark uppercase tracking-widest mb-4">Curated Assets</h4>
                <p class="text-slate-500 text-xs font-medium leading-relaxed max-w-[200px]">100% genuine verified products from official sources only.</p>
            </div>
        </div>
    </section>
</div>

@if($popupBanner)
<!-- Initial Popup Matrix -->
<div id="matrix-popup" class="fixed inset-0 z-[100] flex items-center justify-center p-6 bg-slate-900/80 backdrop-blur-md opacity-0 invisible transition-all duration-700">
    <div class="bg-white rounded-2xl overflow-hidden max-w-lg w-full relative shadow-3xl scale-90 transition-standard duration-700" id="popup-content">
        <button onclick="closePopup()" class="absolute top-6 right-6 w-10 h-10 bg-dark/10 hover:bg-dark/20 rounded-xl flex items-center justify-center text-xl font-bold transition-standard text-white z-20">✕</button>
        <div class="relative group">
            <img src="{{ asset('storage/' . $popupBanner->image) }}" class="w-full aspect-square object-cover transition-standard group-hover:scale-110">
            <div class="absolute inset-0 bg-gradient-to-t from-dark/90 via-transparent to-transparent"></div>
            <div class="absolute bottom-10 inset-x-0 px-10 text-center">
                <h3 class="text-3xl font-black mb-6 tracking-tight text-white">{{ $popupBanner->title }}</h3>
                <a href="{{ $popupBanner->link ?? '#' }}" class="inline-flex bg-primary text-white px-10 py-5 rounded-xl font-black text-[13px] uppercase tracking-widest shadow-2xl shadow-primary/40 hover:scale-105 active:scale-95 transition-standard">Claim Offer Now ➔</a>
            </div>
        </div>
    </div>
</div>

<script>
    window.onload = function() {
        setTimeout(() => {
            const popup = document.getElementById('matrix-popup');
            const content = document.getElementById('popup-content');
            popup.classList.remove('opacity-0', 'invisible');
            content.classList.remove('scale-90');
        }, 3000);
    };

    function closePopup() {
        const popup = document.getElementById('matrix-popup');
        popup.classList.add('opacity-0', 'invisible');
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

        document.getElementById('cd-hours').innerText = hours.toString().padStart(2, '0');
        document.getElementById('cd-minutes').innerText = minutes.toString().padStart(2, '0');
        document.getElementById('cd-seconds').innerText = seconds.toString().padStart(2, '0');
    }

    setInterval(updateCountdown, 1000);
    updateCountdown();
</script>
@endpush
@endsection
