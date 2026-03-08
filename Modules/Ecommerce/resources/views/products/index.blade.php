@extends('layouts.customer')

@section('title', 'Marketplace - CMarket')
@section('page-title', 'Marketplace')

@section('content')
<div class="flex flex-col lg:flex-row gap-10 animate-fade-in">
    <!-- Intelligent Filtering Sidebar -->
    <aside class="w-full lg:w-[320px] flex-shrink-0 space-y-8">
        <div class="bg-white rounded-[2.5rem] p-8 border border-slate-100 shadow-sm sticky top-32">
            <div class="flex items-center gap-3 mb-10 pl-1">
                <span class="text-xl">🔍</span>
                <h3 class="text-sm font-black text-slate-800 uppercase tracking-widest">Filters</h3>
            </div>
            
            <form action="{{ route('products.index') }}" method="GET" class="space-y-8">
                <!-- Search -->
                <div>
                    <label class="block text-[10px] font-black text-slate-400 uppercase tracking-widest mb-3 pl-1">Search Keywords</label>
                    <input type="text" name="search" value="{{ request('search') }}" placeholder="Product name..." class="w-full bg-slate-50 border-none rounded-2xl p-4 text-xs font-bold text-slate-800 focus:ring-2 focus:ring-sky-500/20 transition-all placeholder:text-slate-300">
                </div>

                <!-- Category -->
                <div>
                    <label class="block text-[10px] font-black text-slate-400 uppercase tracking-widest mb-3 pl-1">Category</label>
                    <select name="category" class="w-full bg-slate-50 border-none rounded-2xl p-4 text-xs font-bold text-slate-800 focus:ring-2 focus:ring-sky-500/20 transition-all">
                        <option value="">All Categories</option>
                        @foreach($categories as $category)
                            <option value="{{ $category->id }}" {{ request('category') == $category->id ? 'selected' : '' }}>
                                {{ $category->name }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <!-- Price Range -->
                <div>
                    <label class="block text-[10px] font-black text-slate-400 uppercase tracking-widest mb-3 pl-1">Price Range</label>
                    <div class="flex gap-4">
                        <input type="number" name="min_price" placeholder="Min" value="{{ request('min_price') }}" class="w-1/2 bg-slate-50 border-none rounded-2xl p-4 text-xs font-black text-slate-800 focus:ring-2 focus:ring-sky-500/20 transition-all placeholder:text-slate-300">
                        <input type="number" name="max_price" placeholder="Max" value="{{ request('max_price') }}" class="w-1/2 bg-slate-50 border-none rounded-2xl p-4 text-xs font-black text-slate-800 focus:ring-2 focus:ring-sky-500/20 transition-all placeholder:text-slate-300">
                    </div>
                </div>

                <!-- Sorting -->
                <div>
                    <label class="block text-[10px] font-black text-slate-400 uppercase tracking-widest mb-3 pl-1">Sort By</label>
                    <select name="sort" class="w-full bg-slate-50 border-none rounded-2xl p-4 text-xs font-bold text-slate-800 focus:ring-2 focus:ring-sky-500/20 transition-all">
                        <option value="latest" {{ request('sort') == 'latest' ? 'selected' : '' }}>Newest First</option>
                        <option value="price_low" {{ request('sort') == 'price_low' ? 'selected' : '' }}>Price: Low to High</option>
                        <option value="price_high" {{ request('sort') == 'price_high' ? 'selected' : '' }}>Price: High to Low</option>
                        <option value="name" {{ request('sort') == 'name' ? 'selected' : '' }}>Name A–Z</option>
                    </select>
                </div>

                <button type="submit" class="w-full py-5 bg-slate-900 text-white rounded-2xl font-black text-[10px] uppercase tracking-[0.2em] shadow-xl shadow-slate-900/10 hover:bg-sky-600 hover:scale-[1.02] transition-all duration-300">
                    Update Results ✨
                </button>
                <a href="{{ route('products.index') }}" class="block text-center text-[9px] font-black text-slate-400 uppercase tracking-widest hover:text-rose-500 transition-colors">Clear Filters</a>
            </form>
        </div>
    </aside>

    <!-- Global Product Infrastructure -->
    <div class="flex-1 space-y-8">
        <!-- Results Summary -->
        <div class="flex items-center justify-between px-4">
            <p class="text-[10px] font-black text-slate-400 uppercase tracking-widest">
                Showing <span class="text-slate-800">{{ $products->total() }}</span> products
            </p>
        </div>

        <!-- Catalog Grid -->
        <div class="grid grid-cols-1 sm:grid-cols-2 xl:grid-cols-3 gap-8">
            @forelse($products as $product)
                <div class="bg-white rounded-[2.5rem] border border-slate-100 shadow-sm overflow-hidden group hover:shadow-2xl hover:-translate-y-2 transition-all duration-500 flex flex-col">
                    <!-- Visual Asset Container -->
                    <div class="aspect-square relative overflow-hidden bg-slate-50">
                        @if($product->image)
                            <img src="{{ asset('storage/' . $product->image) }}" alt="{{ $product->name }}" class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-1000">
                        @else
                            <div class="w-full h-full flex flex-col items-center justify-center bg-slate-50 group-hover:bg-sky-50 transition-colors">
                                <span class="text-5xl mb-2 opacity-20">📦</span>
                                <span class="text-[9px] font-black text-slate-300 uppercase tracking-widest">No Image</span>
                            </div>
                        @endif
                        
                        <!-- Badges -->
                        <div class="absolute top-6 right-6 flex flex-col gap-2">
                            @if($product->cashback_percentage)
                                <div class="px-3 py-1 bg-emerald-500 text-white rounded-full text-[9px] font-black uppercase tracking-wider shadow-lg shadow-emerald-500/20">
                                    {{ $product->cashback_percentage }}% Cashback
                                </div>
                            @endif
                            @if($product->points > 0)
                                <div class="px-3 py-1 bg-sky-500 text-white rounded-full text-[9px] font-black uppercase tracking-wider shadow-lg shadow-sky-500/20">
                                    +{{ $product->points }} Points
                                </div>
                            @endif
                        </div>
                    </div>
                    
                    <!-- Descriptive Block -->
                    <div class="p-8 flex-1 flex flex-col">
                        <p class="text-[9px] font-black text-sky-500 uppercase tracking-widest mb-2">{{ $product->category->name }}</p>
                        <h3 class="text-lg font-black text-slate-800 mb-6 leading-tight group-hover:text-sky-600 transition-colors line-clamp-2 min-h-[3rem]">
                            <a href="{{ route('products.show', $product) }}">{{ $product->name }}</a>
                        </h3>
                        
                        <div class="mt-auto space-y-6">
                            <!-- Monetary Evaluation -->
                            <div class="flex items-baseline gap-3">
                                @if($product->discount_price)
                                    <span class="text-3xl font-black text-slate-900 tracking-tighter">৳{{ number_format($product->discount_price, 0) }}</span>
                                    <span class="text-sm font-bold text-slate-300 line-through">৳{{ number_format($product->price, 0) }}</span>
                                @else
                                    <span class="text-3xl font-black text-slate-900 tracking-tighter">৳{{ number_format($product->price, 0) }}</span>
                                @endif
                            </div>
                            
                            <!-- Contextual Metadata -->
                            <div class="flex items-center justify-between border-t border-slate-50 pt-6">
                                <div class="flex items-center gap-2">
                                    <div class="w-2 h-2 rounded-full {{ $product->stock > 10 ? 'bg-emerald-500' : 'bg-rose-500' }}"></div>
                                    <span class="text-[10px] font-black text-slate-400 capitalize">{{ $product->stock > 0 ? $product->stock . ' units available' : 'Out of stock' }}</span>
                                </div>
                                <span class="text-[9px] font-black text-slate-300 uppercase tracking-tighter">By {{ $product->merchant->business_name }}</span>
                            </div>

                            <!-- Engagement Module -->
                            <button onclick="addToCart({{ $product->id }})" class="w-full py-4 bg-slate-50 text-slate-900 rounded-2xl border-2 border-transparent font-black text-[10px] uppercase tracking-widest hover:bg-slate-900 hover:text-white hover:shadow-xl hover:shadow-slate-900/10 transition-all duration-300 flex items-center justify-center gap-3">
                                <span>🛒</span> Add to Cart
                            </button>
                        </div>
                    </div>
                </div>
            @empty
                <div class="col-span-full py-32 flex flex-col items-center text-center">
                    <div class="text-8xl mb-8 opacity-10">🧊</div>
                    <h3 class="text-2xl font-black text-slate-800 uppercase tracking-widest mb-2">No Products Found</h3>
                    <p class="text-sm font-bold text-slate-400">Try adjusting your search or filters.</p>
                </div>
            @endforelse
        </div>

        <!-- Infrastructure Pagination -->
        @if($products->hasPages())
            <div class="pt-10">
                {{ $products->links() }}
            </div>
        @endif
    </div>
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
                title: 'Item added to cart! 🛍️'
            });
            setTimeout(() => location.reload(), 1500);
        } else {
            Toast.fire({
                icon: 'error',
                title: data.message || 'Fulfillment error.'
            });
        }
    })
    .catch(error => {
        console.error('Error:', error);
        Toast.fire({
                icon: 'error',
                title: 'Something went wrong. Please try again.'
            });
        });
}
</script>
@endsection
