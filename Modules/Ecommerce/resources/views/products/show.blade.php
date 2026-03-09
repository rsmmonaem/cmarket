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

    <div class="bg-white rounded-xl border border-slate-100 shadow-sm overflow-hidden mb-12">
        <div class="flex flex-col lg:flex-row">
            <!-- Product Images -->
            <div class="lg:w-1/2 p-4 md:p-8 border-r border-slate-50">
                @php 
                    $images = is_array($product->images) ? $product->images : (json_decode($product->images, true) ?: []);
                    $mainImage = $product->thumbnail ?: ($images[0] ?? null);
                @endphp
                
                <div class="aspect-square rounded-lg overflow-hidden bg-white border border-slate-50 mb-4">
                    @if($mainImage)
                        <img id="main-display-node" src="{{ asset('storage/' . $mainImage) }}" alt="{{ $product->name }}" class="w-full h-full object-cover">
                    @else
                        <div class="w-full h-full flex items-center justify-center opacity-10 text-9xl">📦</div>
                    @endif
                </div>

                <!-- Thumbnail Array -->
                @if(count($images) > 1)
                    <div class="flex gap-2 overflow-x-auto no-scrollbar pb-1">
                        @foreach($images as $img)
                            <button onclick="syncDisplayNode('{{ asset('storage/' . $img) }}')" class="w-14 h-14 rounded-md overflow-hidden border border-slate-100 hover:border-primary transition-all flex-shrink-0">
                                <img src="{{ asset('storage/' . $img) }}" class="w-full h-full object-cover">
                            </button>
                        @endforeach
                    </div>
                @endif
            </div>

            <!-- Product Details -->
            <div class="lg:w-1/2 p-4 md:p-8 flex flex-col">
                <div class="flex flex-wrap gap-2 mb-4">
                    <span class="px-2 py-0.5 bg-slate-50 text-slate-500 rounded text-[9px] font-bold uppercase tracking-wider">SKU: {{ $product->sku ?? 'N/A' }}</span>
                    @if($product->is_featured)
                        <span class="px-2 py-0.5 bg-sky-50 text-sky-600 rounded text-[9px] font-bold uppercase tracking-wider">Featured</span>
                    @endif
                </div>

                <h1 class="text-xl md:text-3xl font-bold text-slate-900 mb-2 leading-tight tracking-tight">{{ $product->name }}</h1>
                
                <div class="flex items-center gap-3 mb-8">
                    <div class="flex text-amber-400 text-sm">★★★★☆</div>
                    <span class="text-[9px] font-bold text-slate-400 border-l border-slate-100 pl-3 uppercase tracking-widest">{{ $product->reviews_count ?? 0 }} Reviews</span>
                </div>

                <div class="flex items-baseline gap-4 mb-8">
                    <span class="text-3xl font-bold text-slate-900 tracking-tighter">৳{{ number_format($product->final_price) }}</span>
                    @if($product->discount_price)
                        <span class="text-lg font-medium text-slate-300 line-through">৳{{ number_format($product->price) }}</span>
                        <span class="text-[9px] font-bold text-emerald-500 uppercase tracking-widest">Save {{ round($product->discount_percentage) }}%</span>
                    @endif
                </div>

                <div class="space-y-8 pt-8 border-t border-slate-50">
                    <div class="grid grid-cols-2 gap-4">
                        <div>
                            <p class="text-[9px] font-bold text-slate-400 uppercase tracking-widest mb-1">Availability</p>
                            <p class="text-xs font-semibold text-slate-700">{{ $product->stock > 0 ? $product->stock . ' In Stock' : 'Out of Stock' }}</p>
                        </div>
                        <div>
                            <p class="text-[9px] font-bold text-slate-400 uppercase tracking-widest mb-1">Sold By</p>
                            <a href="#" class="text-xs font-semibold text-sky-600 hover:underline">{{ $product->merchant?->business_name ?? 'C-Market' }}</a>
                        </div>
                    </div>

                    <div class="flex gap-3">
                        <button
                            onclick="addToCart({{ $product->id }})"
                            class="flex-1 py-3 bg-slate-900 text-white rounded-lg font-bold text-[10px] uppercase tracking-widest hover:bg-slate-800 transition-all flex items-center justify-center gap-2">
                            Add to Cart 🛒
                        </button>
                        <button class="w-12 h-12 bg-white border border-slate-200 rounded-lg flex items-center justify-center text-lg hover:text-rose-500 transition-colors">🤍</button>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Details Section -->
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
        <div class="lg:col-span-2 space-y-6">
            <div class="bg-white rounded-xl p-6 md:p-8 border border-slate-100">
                <h3 class="text-lg font-bold mb-6 text-slate-900">Product Details</h3>
                <div class="prose prose-slate max-w-none text-slate-600 leading-relaxed text-sm">
                    {!! nl2br(e($product->description)) !!}
                </div>
            </div>
        </div>
        
        <div class="space-y-6">
            <div class="bg-slate-50 rounded-xl p-6 border border-slate-100">
                <h4 class="text-[10px] font-black text-slate-800 uppercase tracking-widest mb-4">Delivery Info</h4>
                <ul class="space-y-3 text-[11px] text-slate-500 font-medium">
                    <li class="flex items-start gap-2"><span>🚚</span> Fast Delivery: 2-3 Business Days</li>
                    <li class="flex items-start gap-2"><span>🔄</span> 7-Day Asset Rollback Policy</li>
                    <li class="flex items-start gap-2"><span>🛡️</span> 100% Genuine Guaranteed</li>
                </ul>
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
