@extends('layouts.public')

@section('title', $product->meta_title ?? $product->name . ' - C-Market')
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

    <div class="bg-white rounded-2xl border border-slate-100 shadow-sm overflow-hidden relative">
        <div class="flex flex-col lg:flex-row">
            <!-- Product Images -->
            <div class="lg:w-1/2 p-6 md:p-10 relative group border-r border-slate-100">
                @php 
                    $images = is_array($product->images) ? $product->images : (json_decode($product->images, true) ?: []);
                    $mainImage = $images[0] ?? null;
                @endphp
                
                <div class="aspect-square rounded-xl overflow-hidden bg-white border border-slate-100 mb-6 group-hover:scale-[1.02] transition-transform duration-500">
                    @if($mainImage)
                        <img id="main-display-node" src="{{ asset('storage/' . $mainImage) }}" alt="{{ $product->name }}" class="w-full h-full object-cover">
                    @else
                        <div class="w-full h-full flex items-center justify-center opacity-10 text-9xl">📦</div>
                    @endif
                </div>

                <!-- Thumbnail Array -->
                @if(count($images) > 1)
                    <div class="flex gap-4 overflow-x-auto no-scrollbar pb-2">
                        @foreach($images as $img)
                            <button onclick="syncDisplayNode('{{ asset('storage/' . $img) }}')" class="w-16 h-16 rounded-lg overflow-hidden border-2 border-transparent hover:border-primary transition-all flex-shrink-0 bg-white shadow-sm">
                                <img src="{{ asset('storage/' . $img) }}" class="w-full h-full object-cover">
                            </button>
                        @endforeach
                    </div>
                @endif
            </div>

            <!-- Product Details -->
            <div class="lg:w-1/2 p-6 md:p-10 flex flex-col">
                <div class="flex flex-wrap gap-2 mb-6">
                    <span class="px-3 py-1 bg-slate-100 text-slate-600 rounded-lg text-[10px] font-black uppercase tracking-widest">SKU: {{ $product->sku ?? 'N/A' }}</span>
                    @if($product->is_featured)
                        <span class="px-3 py-1 bg-primary/10 text-primary border border-primary/20 rounded-lg text-[10px] font-black uppercase tracking-widest">Featured</span>
                    @endif
                    @if($product->is_flash_deal)
                        <span class="px-3 py-1 bg-rose-100 text-rose-600 rounded-lg text-[10px] font-black uppercase tracking-widest animate-pulse">⚡ Flash Deal</span>
                    @endif
                </div>

                <h1 class="text-2xl md:text-4xl font-black text-slate-900 mb-4 leading-tight tracking-tight">{{ $product->name }}</h1>
                
                <div class="flex items-center gap-4 mb-10">
                    <div class="flex text-amber-400 text-lg">★★★★☆</div>
                    <span class="text-[10px] font-bold text-slate-500 border-l border-slate-200 pl-4 uppercase tracking-widest">{{ $product->reviews_count ?? 0 }} Reviews</span>
                </div>

                <div class="flex items-baseline gap-8 mb-12">
                    <span class="text-4xl font-black text-slate-900 tracking-tighter">৳{{ number_format($product->final_price) }}</span>
                    @if($product->discount_price)
                        <div class="flex flex-col">
                            <span class="text-xl font-bold text-slate-300 line-through">৳{{ number_format($product->price) }}</span>
                            <span class="text-[10px] font-black text-emerald-500 uppercase tracking-widest mt-1">Save {{ round($product->discount_percentage) }}%</span>
                        </div>
                    @endif
                </div>

                @if($product->cashback_percentage > 0)
                    <div class="bg-primary/5 rounded-[2.5rem] p-8 border border-primary/10 mb-12 relative overflow-hidden group/cb">
                        <div class="relative z-10 flex items-center justify-between">
                            <div>
                                <h4 class="text-lg font-black text-slate-800">৳{{ number_format($product->final_price * $product->cashback_percentage / 100, 2) }} Cashback</h4>
                                <p class="text-[10px] font-bold text-slate-500 uppercase tracking-widest mt-1">Earned upon successful delivery</p>
                            </div>
                            <div class="text-4xl">🎁</div>
                        </div>
                        <div class="absolute -right-4 -bottom-4 text-primary opacity-[0.03] scale-[3]">REWARD</div>
                    </div>
                @endif

                <div class="space-y-12">
                    <div class="grid grid-cols-2 gap-8">
                        <div>
                            <p class="text-[10px] font-black text-slate-400 uppercase tracking-widest mb-2">Availability</p>
                            <p class="text-sm font-bold text-slate-800">{{ $product->stock > 0 ? $product->stock . ' In Stock' : 'Out of Stock' }}</p>
                        </div>
                        <div>
                            <p class="text-[10px] font-black text-slate-400 uppercase tracking-widest mb-2">Sold By</p>
                            <a href="#" class="text-sm font-bold text-primary hover:underline transition-colors">{{ $product->merchant->business_name }}</a>
                        </div>
                    </div>

                    <div class="flex flex-col sm:flex-row gap-4">
                        <form action="{{ route('cart.add', $product) }}" method="POST" class="flex-1">
                            @csrf
                            <button type="submit" class="w-full py-4 bg-slate-900 text-white rounded-xl font-black text-xs uppercase tracking-widest shadow-lg shadow-slate-900/10 hover:bg-primary hover:-translate-y-0.5 active:scale-95 transition-all duration-300 flex items-center justify-center gap-2">
                                Add to Cart 🛒
                            </button>
                        </form>
                        <button class="w-14 h-14 bg-white border border-slate-200 rounded-xl shadow-sm flex items-center justify-center text-xl hover:text-rose-500 hover:border-rose-200 transition-colors">🤍</button>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Product Description -->
    <div class="mt-12">
        <div class="flex border-b border-slate-100 mb-8 pb-1 gap-8 text-xs font-bold uppercase tracking-widest text-slate-400">
            <button class="border-b-2 border-primary pb-3 text-slate-900">Description</button>
            <button class="hover:text-primary transition-colors pb-3">Reviews ({{ $product->reviews_count ?? 0 }})</button>
        </div>
        
        <div class="bg-white rounded-2xl p-8 border border-slate-100 shadow-sm">
            <h3 class="text-xl font-black mb-6 text-slate-900">Product Details</h3>
            <div class="prose prose-slate max-w-none text-slate-600 leading-relaxed text-sm">
                {!! nl2br(e($product->description)) !!}
            </div>
        </div>
    </div>

    <!-- Related Products -->
    @if(isset($relatedProducts) && $relatedProducts->count() > 0)
        <div class="mt-20">
            <div class="flex items-center justify-between mb-8">
                <div>
                    <h2 class="text-2xl font-black text-slate-900 tracking-tight">Similar Products</h2>
                    <p class="text-[10px] font-black text-slate-400 uppercase tracking-widest mt-1">You may also like</p>
                </div>
                <a href="{{ route('products.index') }}" class="text-[10px] font-black text-primary uppercase tracking-widest hover:underline">View All ➔</a>
            </div>
            
            <div class="grid grid-cols-2 lg:grid-cols-4 gap-6">
                @foreach($relatedProducts as $related)
                    <div class="bg-white p-4 rounded-2xl border border-slate-100 shadow-sm hover:shadow-lg hover:-translate-y-1 transition-all group">
                        <a href="{{ route('products.show', $related) }}">
                            <div class="aspect-square rounded-xl overflow-hidden bg-slate-50 mb-4 flex items-center justify-center relative">
                                @php $rImgArr = is_array($related->images) ? $related->images : (json_decode($related->images, true) ?: []); $rImg = $rImgArr[0] ?? null; @endphp
                                @if($rImg)
                                    <img src="{{ asset('storage/' . $rImg) }}" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500">
                                @else
                                    <span class="text-3xl opacity-10">🛍️</span>
                                @endif
                            </div>
                            <div class="space-y-2">
                                <p class="text-[9px] font-black text-primary uppercase tracking-widest">{{ $related->category->name ?? 'Product' }}</p>
                                <h3 class="text-sm font-bold text-slate-800 line-clamp-1 h-5 group-hover:text-primary transition-colors">{{ $related->name }}</h3>
                                <div class="flex items-baseline gap-2 pt-1">
                                    <span class="text-lg font-black text-slate-900 mt-1">৳{{ number_format($related->final_price) }}</span>
                                    @if($related->discount_price)
                                        <span class="text-[10px] font-bold text-slate-400 line-through">৳{{ number_format($related->price) }}</span>
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
