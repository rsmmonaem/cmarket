@extends('layouts.public')

@section('title', 'All Products - C-Market')

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12 md:py-16">
    <div class="flex flex-col lg:flex-row gap-8 animate-fade-in">
    <!-- Filters Sidebar -->
    <aside class="w-full lg:w-72 flex-shrink-0 space-y-6">
        <div class="bg-white rounded-2xl p-6 border border-slate-100 shadow-sm sticky top-32">
            <div class="flex items-center gap-3 mb-6 pl-1">
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

                <button type="submit" class="w-full py-4 bg-slate-900 text-white rounded-xl font-black text-[10px] uppercase tracking-widest shadow-lg shadow-slate-900/10 hover:bg-primary hover:-translate-y-0.5 transition-all duration-300">
                    Apply Filters
                </button>
                <a href="{{ route('products.index') }}" class="block text-center text-[10px] font-black text-slate-400 uppercase tracking-widest hover:text-rose-500 transition-colors">Clear Filters</a>
            </form>
        </div>
    </aside>

    <!-- Products Grid -->
    <div class="flex-1 space-y-6">
        <!-- Results Summary -->
        <div class="flex items-center justify-between px-2">
            <p class="text-[10px] md:text-xs font-black text-slate-400 uppercase tracking-widest">
                Showing <span class="text-slate-800">{{ $products->total() }}</span> products
            </p>
        </div>

        <div class="grid grid-cols-2 md:grid-cols-3 xl:grid-cols-4 gap-4 md:gap-6">
            @forelse($products as $product)
                <div class="bg-white rounded-2xl border border-slate-100 shadow-sm overflow-hidden group hover:shadow-lg hover:-translate-y-1 transition-all duration-300 flex flex-col">
                    <div class="aspect-square relative overflow-hidden bg-slate-50">
                        @if($product->thumbnail)
                            <img src="{{ asset('storage/' . $product->thumbnail) }}" alt="{{ $product->name }}" class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-1000">
                        @elseif($product->image)
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
                                <div class="px-3 py-1 bg-emerald-500 text-white rounded-lg text-[9px] font-black uppercase tracking-wider shadow-sm">
                                    {{ $product->cashback_percentage }}% Cashback
                                </div>
                            @endif
                            @if($product->points > 0)
                                <div class="px-3 py-1 bg-primary text-white rounded-lg text-[9px] font-black uppercase tracking-wider shadow-sm">
                                    +{{ $product->points }} Points
                                </div>
                            @endif
                        </div>
                    </div>
                    
                    <div class="p-4 md:p-6 flex-1 flex flex-col">
                        <p class="text-[9px] font-black text-sky-500 uppercase tracking-widest mb-2">{{ $product->category->name }}</p>
                        <h3 class="text-sm font-bold text-slate-800 mb-4 leading-tight group-hover:text-primary transition-colors line-clamp-2 h-10">
                            <a href="{{ route('products.show', $product) }}">{{ $product->name }}</a>
                        </h3>
                        
                        <div class="mt-auto space-y-4">
                            <div class="flex items-baseline gap-2">
                                @if($product->discount_price)
                                    <span class="text-lg font-black text-slate-900 tracking-tighter">৳{{ number_format($product->discount_price, 0) }}</span>
                                    <span class="text-xs font-bold text-slate-400 line-through">৳{{ number_format($product->price, 0) }}</span>
                                @else
                                    <span class="text-lg font-black text-slate-900 tracking-tighter">৳{{ number_format($product->price, 0) }}</span>
                                @endif
                            </div>
                            
                            <div class="flex items-center justify-between border-t border-slate-50 pt-4">
                                <div class="flex items-center gap-1.5">
                                    <div class="w-1.5 h-1.5 rounded-full {{ $product->stock > 10 ? 'bg-emerald-500' : 'bg-rose-500' }}"></div>
                                    <span class="text-[9px] font-black text-slate-400 capitalize">{{ $product->stock > 0 ? 'In Stock' : 'Out of stock' }}</span>
                                </div>
                                <span class="text-[9px] font-black text-slate-300 uppercase tracking-tighter">{{ $product->merchant?->business_name ?? 'C-Market' }}</span>
                            </div>

                            <button onclick="addToCart({{ $product->id }})" class="w-full py-3 bg-slate-50 text-slate-900 rounded-xl border-2 border-transparent font-black text-[10px] uppercase tracking-widest hover:bg-slate-900 hover:text-white hover:shadow-lg transition-all duration-300 flex items-center justify-center gap-2">
                                🛒 Add to Cart
                            </button>
                        </div>
                    </div>
                </div>
            @empty
                <div class="col-span-full py-20 flex flex-col items-center text-center">
                    <div class="text-6xl mb-6 opacity-20">🛍️</div>
                    <h3 class="text-xl font-black text-slate-800 uppercase tracking-widest mb-2">No Products Found</h3>
                    <p class="text-xs font-bold text-slate-400">Try adjusting your search or filters.</p>
                </div>
            @endforelse
        </div>

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
