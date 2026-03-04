@extends('layouts.customer')

@section('title', $product->name . ' - CMarket')
@section('page-title', 'Product Identification')

@section('content')
<div class="space-y-12 animate-fade-in">
    <!-- Macro Product Card -->
    <div class="bg-white rounded-[3rem] border border-slate-100 shadow-xl overflow-hidden">
        <div class="flex flex-col lg:flex-row">
            <!-- Asset Visualization -->
            <div class="lg:w-1/2 p-8 lg:p-16 bg-slate-50 flex items-center justify-center relative overflow-hidden group">
                <div class="relative z-10 w-full aspect-square rounded-[2rem] overflow-hidden shadow-2xl transition-transform duration-700 group-hover:scale-105">
                    @if($product->image)
                        <img src="{{ asset('storage/' . $product->image) }}" alt="{{ $product->name }}" class="w-full h-full object-cover">
                    @else
                        <div class="w-full h-full flex flex-col items-center justify-center bg-white">
                            <span class="text-8xl opacity-10">📦</span>
                            <span class="text-[10px] font-black text-slate-300 uppercase mt-4 tracking-[0.3em]">Asset Visual Missing</span>
                        </div>
                    @endif
                </div>
                <!-- Backdrop Decor -->
                <div class="absolute inset-0 opacity-[0.03] flex items-center justify-center text-[400px] leading-none select-none font-black italic">ASSET</div>
            </div>

            <!-- Intelligence Hub -->
            <div class="lg:w-1/2 p-8 lg:p-16 flex flex-col">
                <div class="mb-10 flex flex-wrap gap-3">
                    <span class="px-4 py-2 bg-sky-100 text-sky-600 rounded-2xl text-[10px] font-black uppercase tracking-widest">{{ $product->category->name }}</span>
                    @if($product->points > 0)
                        <span class="px-4 py-2 bg-indigo-100 text-indigo-600 rounded-2xl text-[10px] font-black uppercase tracking-widest">{{ $product->points }} LP / Point</span>
                    @endif
                </div>

                <h1 class="text-4xl lg:text-5xl font-black text-slate-800 mb-8 leading-[1.1] tracking-tight">{{ $product->name }}</h1>
                
                <div class="flex items-baseline gap-6 mb-12">
                    @if($product->discount_price)
                        <span class="text-5xl font-black text-slate-900 tracking-tighter">৳{{ number_format($product->discount_price, 0) }}</span>
                        <div class="flex flex-col">
                            <span class="text-lg font-bold text-slate-300 line-through">৳{{ number_format($product->price, 0) }}</span>
                            <span class="text-[10px] font-black text-rose-500 uppercase">Save {{ round((($product->price - $product->discount_price) / $product->price) * 100) }}% Off</span>
                        </div>
                    @else
                        <span class="text-5xl font-black text-slate-900 tracking-tighter">৳{{ number_format($product->price, 0) }}</span>
                    @endif
                </div>

                @if($product->cashback_percentage)
                    <div class="bg-gradient-to-br from-emerald-500 to-teal-600 rounded-[2rem] p-8 text-white mb-12 shadow-xl shadow-emerald-500/20 relative overflow-hidden group/cb">
                        <div class="relative z-10 flex items-center justify-between">
                            <div>
                                <p class="text-[10px] font-black uppercase tracking-[0.2em] opacity-60 mb-1">Ecosystem Reward</p>
                                <h4 class="text-xl font-black">৳{{ number_format(($product->discount_price ?? $product->price) * $product->cashback_percentage / 100, 2) }} Cashback</h4>
                                <p class="text-xs font-bold text-emerald-100/70 mt-1">Automatically credited to your digital wallet.</p>
                            </div>
                            <div class="text-4xl group-hover/cb:rotate-12 transition-transform">🎁</div>
                        </div>
                    </div>
                @endif

                <div class="mb-12">
                    <h4 class="text-[10px] font-black text-slate-400 uppercase tracking-[0.2em] mb-4">Functional Description</h4>
                    <p class="text-slate-600 leading-relaxed text-sm font-medium">{{ $product->description }}</p>
                </div>

                <div class="grid grid-cols-2 gap-6 mb-12">
                    <div class="p-6 bg-slate-50 rounded-3xl border border-transparent hover:border-slate-100 transition-all">
                        <p class="text-[9px] font-black text-slate-400 uppercase tracking-widest mb-1">Territory Stock</p>
                        <p class="text-sm font-black text-slate-800">{{ $product->stock > 0 ? $product->stock . ' Units Ready' : 'Out of Stock' }}</p>
                    </div>
                    <div class="p-6 bg-slate-50 rounded-3xl border border-transparent hover:border-slate-100 transition-all">
                        <p class="text-[9px] font-black text-slate-400 uppercase tracking-widest mb-1">Merchant Origin</p>
                        <p class="text-sm font-black text-slate-800">{{ $product->merchant->business_name }}</p>
                    </div>
                </div>

                <div class="mt-auto">
                    @if($product->stock > 0)
                        <button onclick="addToCart({{ $product->id }})" class="w-full py-6 bg-slate-900 text-white rounded-[1.5rem] font-black text-xs uppercase tracking-[0.3em] shadow-2xl shadow-slate-900/20 hover:bg-sky-600 hover:scale-[1.02] transition-all duration-300 flex items-center justify-center gap-4">
                            <span>🛒</span> Initiate Acquisition
                        </button>
                    @else
                        <button disabled class="w-full py-6 bg-slate-100 text-slate-400 rounded-[1.5rem] font-black text-xs uppercase tracking-[0.3em] cursor-not-allowed flex items-center justify-center gap-4">
                            Inventory Depleted 📦
                        </button>
                    @endif
                </div>
            </div>
        </div>
    </div>

    <!-- Recommendations Engine -->
    @if($relatedProducts->count() > 0)
        <div class="pt-10">
            <div class="flex items-center justify-between mb-10 px-4">
                <h2 class="text-sm font-black text-slate-800 uppercase tracking-[0.2em]">Affiliated Recommendations</h2>
                <a href="{{ route('products.index') }}" class="text-[10px] font-black text-sky-500 uppercase tracking-widest hover:text-slate-900 transition-colors">Explore Gallery</a>
            </div>
            
            <div class="grid grid-cols-2 lg:grid-cols-4 gap-8">
                @foreach($relatedProducts as $related)
                    <div class="bg-white p-4 rounded-[2.5rem] border border-slate-50 hover:shadow-xl hover:-translate-y-2 transition-all group">
                        <a href="{{ route('products.show', $related) }}">
                            <div class="aspect-square rounded-2xl overflow-hidden bg-slate-50 mb-6">
                                @if($related->image)
                                    <img src="{{ asset('storage/' . $related->image) }}" alt="{{ $related->name }}" class="w-full h-full object-cover">
                                @else
                                    <div class="w-full h-full flex items-center justify-center opacity-10 text-4xl">📦</div>
                                @endif
                            </div>
                            <h3 class="text-xs font-black text-slate-800 mb-2 truncate group-hover:text-sky-500 transition-colors">{{ $related->name }}</h3>
                            <p class="text-sm font-black text-slate-900">৳{{ number_format($related->price, 0) }}</p>
                        </a>
                    </div>
                @endforeach
            </div>
        </div>
    @endif
</div>

<script>
function addToCart(productId) {
    @guest
        window.location.href = '{{ route("login") }}';
        return;
    @endguest
    
    fetch(`/cart/add/${productId}`, {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': '{{ csrf_token() }}'
        }
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            Toast.fire({
                icon: 'success',
                title: 'Deployment successful! Asset added to cart. 🛍️'
            });
            setTimeout(() => window.location.href = '{{ route("cart.index") }}', 1500);
        } else {
            Toast.fire({
                icon: 'error',
                title: data.message || 'Error occurred during fulfillment.'
            });
        }
    })
    .catch(error => {
        console.error('Error:', error);
        Toast.fire({
            icon: 'error',
            title: 'Protocol communication failure.'
        });
    });
}
</script>
@endsection
