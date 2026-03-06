@extends('layouts.public')

@section('title', $product->meta_title ?? $product->name . ' - EcomMatrix')
@section('meta_description', $product->meta_description ?? Str::limit(strip_tags($product->description), 160))

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
    <!-- Breadcrumbs Node -->
    <nav class="flex mb-12 text-[10px] font-black uppercase tracking-widest text-slate-400 gap-4">
        <a href="{{ route('home') }}" class="hover:text-primary transition-colors">Matrix Home</a>
        <span>/</span>
        <a href="{{ route('categories.index') }}" class="hover:text-primary transition-colors">{{ $product->category->name }}</a>
        <span>/</span>
        <span class="text-slate-900">{{ $product->name }}</span>
    </nav>

    <div class="bg-white rounded-[3.5rem] border border-slate-100 shadow-2xl overflow-hidden relative">
        <div class="flex flex-col lg:flex-row">
            <!-- Asset Visualization Matrix -->
            <div class="lg:w-1/2 p-4 md:p-12 lg:p-20 bg-slate-50 relative group">
                @php 
                    $images = is_array($product->images) ? $product->images : (json_decode($product->images, true) ?: []);
                    $mainImage = $images[0] ?? null;
                @endphp
                
                <div class="aspect-square rounded-[3rem] overflow-hidden bg-white shadow-2xl shadow-slate-200 border border-slate-100 mb-10 group-hover:scale-[1.02] transition-transform duration-700">
                    @if($mainImage)
                        <img id="main-display-node" src="{{ asset('storage/' . $mainImage) }}" alt="{{ $product->name }}" class="w-full h-full object-cover">
                    @else
                        <div class="w-full h-full flex items-center justify-center opacity-10 text-9xl">📦</div>
                    @endif
                </div>

                <!-- Thumbnail Array -->
                @if(count($images) > 1)
                    <div class="flex gap-4 overflow-x-auto no-scrollbar pb-4">
                        @foreach($images as $img)
                            <button onclick="syncDisplayNode('{{ asset('storage/' . $img) }}')" class="w-20 h-20 rounded-2xl overflow-hidden border-2 border-transparent hover:border-primary transition-all flex-shrink-0 bg-white">
                                <img src="{{ asset('storage/' . $img) }}" class="w-full h-full object-cover">
                            </button>
                        @endforeach
                    </div>
                @endif
                
                <div class="absolute inset-0 opacity-[0.02] pointer-events-none flex items-center justify-center text-[300px] font-black italic">NODE</div>
            </div>

            <!-- Intelligence Hub node -->
            <div class="lg:w-1/2 p-8 lg:p-20 flex flex-col">
                <div class="flex flex-wrap gap-3 mb-10">
                    <span class="px-5 py-2.5 bg-slate-900 text-white rounded-2xl text-[10px] font-black uppercase tracking-[0.2em] shadow-lg shadow-slate-900/10">ID: {{ $product->sku ?? '000-NODE' }}</span>
                    @if($product->is_featured)
                        <span class="px-5 py-2.5 bg-primary/10 text-primary border border-primary/20 rounded-2xl text-[10px] font-black uppercase tracking-[0.2em]">Featured Asset</span>
                    @endif
                    @if($product->is_flash_deal)
                        <span class="px-5 py-2.5 bg-rose-500 text-white rounded-2xl text-[10px] font-black uppercase tracking-[0.2em] animate-pulse">⚡ Flash Deal Active</span>
                    @endif
                </div>

                <h1 class="text-4xl lg:text-6xl font-black text-slate-900 mb-8 leading-[1.05] tracking-tight">{{ $product->name }}</h1>
                
                <div class="flex items-center gap-4 mb-10">
                    <div class="flex text-amber-400 text-lg">★★★★☆</div>
                    <span class="text-[10px] font-black text-slate-400 border-l border-slate-200 pl-4 uppercase tracking-widest">{{ $product->reviews_count ?? 0 }} User Feedbacks</span>
                </div>

                <div class="flex items-baseline gap-8 mb-12">
                    <span class="text-6xl font-black text-slate-900 tracking-tighter">৳{{ number_format($product->final_price) }}</span>
                    @if($product->discount_price)
                        <div class="flex flex-col">
                            <span class="text-xl font-bold text-slate-300 line-through">৳{{ number_format($product->price) }}</span>
                            <span class="text-[10px] font-black text-primary uppercase tracking-widest mt-1">Efficiency Gain: {{ round($product->discount_percentage) }}%</span>
                        </div>
                    @endif
                </div>

                @if($product->cashback_percentage > 0)
                    <div class="bg-primary/5 rounded-[2.5rem] p-8 border border-primary/10 mb-12 relative overflow-hidden group/cb">
                        <div class="relative z-10 flex items-center justify-between">
                            <div>
                                <h4 class="text-lg font-black text-slate-800">৳{{ number_format($product->final_price * $product->cashback_percentage / 100, 2) }} Wallet Sync</h4>
                                <p class="text-[10px] font-bold text-slate-500 uppercase tracking-widest mt-1">Automated ecosystem rewards protocol</p>
                            </div>
                            <div class="text-4xl">🎁</div>
                        </div>
                        <div class="absolute -right-4 -bottom-4 text-primary opacity-[0.03] scale-[3]">REWARD</div>
                    </div>
                @endif

                <div class="space-y-12">
                    <div class="grid grid-cols-2 gap-8">
                        <div>
                            <p class="text-[10px] font-black text-slate-400 uppercase tracking-[0.2em] mb-3">Unit Inventory</p>
                            <p class="text-sm font-black text-slate-800">{{ $product->stock > 0 ? $product->stock . ' Units available' : 'Asset Exhausted' }}</p>
                        </div>
                        <div>
                            <p class="text-[10px] font-black text-slate-400 uppercase tracking-[0.2em] mb-3">Origin Node</p>
                            <a href="#" class="text-sm font-black text-primary hover:text-primary-hover transition-colors">{{ $product->merchant->business_name }} ➔</a>
                        </div>
                    </div>

                    <div class="flex flex-col sm:flex-row gap-4">
                        <form action="{{ route('cart.add', $product) }}" method="POST" class="flex-1">
                            @csrf
                            <button type="submit" class="w-full py-6 bg-slate-900 text-white rounded-3xl font-black text-[11px] uppercase tracking-[0.3em] shadow-2xl shadow-slate-900/20 hover:bg-primary hover:scale-[1.02] active:scale-95 transition-all duration-300 flex items-center justify-center gap-4">
                                Acquire Asset Node node
                            </button>
                        </form>
                        <button class="w-20 h-20 bg-white border border-slate-100 rounded-3xl shadow-soft flex items-center justify-center text-2xl hover:text-primary transition-colors">🤍</button>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Multi-tab detail nodes -->
    <div class="mt-20">
        <div class="flex border-b border-slate-100 mb-12 pb-1 gap-12 text-[10px] font-black uppercase tracking-[0.2em]">
            <button class="border-b-4 border-primary pb-5 text-slate-900">Functional Description</button>
            <button class="text-slate-400 hover:text-primary transition-colors pb-5">Specification Protocol</button>
            <button class="text-slate-400 hover:text-primary transition-colors pb-5">Feedback Node ({{ $product->reviews_count ?? 0 }})</button>
        </div>
        
        <div class="max-w-4xl bg-white rounded-[3rem] p-12 lg:p-16 border border-slate-50 shadow-soft">
            <h3 class="text-xl font-black mb-8 text-slate-900 uppercase tracking-tight">Node Technical Overview</h3>
            <div class="prose prose-slate max-w-none text-slate-600 font-medium leading-loose text-sm italic">
                {!! nl2br(e($product->description)) !!}
            </div>
        </div>
    </div>

    <!-- Recommendation Network -->
    @if(isset($relatedProducts) && $relatedProducts->count() > 0)
        <div class="mt-32">
            <div class="flex items-center justify-between mb-12">
                <div>
                    <h2 class="text-3xl font-black text-slate-900 tracking-tight">Affiliated Clusters</h2>
                    <p class="text-[10px] font-black text-slate-400 uppercase tracking-[0.2em] mt-2">Highly correlated marketplace assets</p>
                </div>
                <a href="{{ route('products.index') }}" class="text-[10px] font-black text-primary uppercase tracking-widest">Full Network Scan ➔</a>
            </div>
            
            <div class="grid grid-cols-2 lg:grid-cols-4 gap-8">
                @foreach($relatedProducts as $related)
                    <div class="bg-white p-5 rounded-[2.5rem] border border-slate-100 shadow-soft hover:shadow-2xl hover:-translate-y-2 transition-all group">
                        <a href="{{ route('products.show', $related) }}">
                            <div class="aspect-square rounded-[2rem] overflow-hidden bg-slate-50 mb-8 flex items-center justify-center group-hover:scale-95 transition-transform overflow-hidden relative border border-slate-100">
                                @php $rImgArr = is_array($related->images) ? $related->images : (json_decode($related->images, true) ?: []); $rImg = $rImgArr[0] ?? null; @endphp
                                @if($rImg)
                                    <img src="{{ asset('storage/' . $rImg) }}" class="w-full h-full object-cover">
                                @else
                                    <span class="text-4xl opacity-10">🛍️</span>
                                @endif
                            </div>
                            <div class="space-y-3">
                                <p class="text-[8px] font-black text-slate-400 uppercase tracking-widest">{{ $related->category->name ?? 'Node' }}</p>
                                <h3 class="text-xs font-black text-slate-700 line-clamp-1 h-4 group-hover:text-primary transition-colors uppercase">{{ $related->name }}</h3>
                                <div class="flex items-baseline gap-2 pt-2">
                                    <span class="text-sm font-black text-slate-900 uppercase">৳{{ number_format($related->final_price) }}</span>
                                    @if($related->discount_price)
                                        <span class="text-[8px] font-bold text-slate-300 line-through">৳{{ number_format($related->price) }}</span>
                                    @endif
                                </div>
                            </div>
                        </a>
                    </div>
                @endforeach
            </div>
        </div>
    @endif
</div>

<script>
    function syncDisplayNode(uri) {
        document.getElementById('main-display-node').src = uri;
    }
</script>
@endsection
