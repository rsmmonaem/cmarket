@extends('layouts.public')

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
    <!-- Header -->
    <div class="mb-8">
        <h1 class="text-3xl font-bold text-gray-900">All Products</h1>
        <p class="text-gray-600 mt-2">Discover amazing products with cashback rewards</p>
    </div>

    <div class="flex flex-col md:flex-row gap-8">
        <!-- Filters Sidebar -->
        <div class="w-full md:w-64 flex-shrink-0">
            <div class="bg-white rounded-lg shadow p-6">
                <h3 class="font-semibold text-lg mb-4">Filters</h3>
                
                <form action="{{ route('products.index') }}" method="GET">
                    <!-- Categories -->
                    <div class="mb-6">
                        <h4 class="font-medium mb-2">Category</h4>
                        <select name="category" class="w-full px-3 py-2 border border-gray-300 rounded-lg">
                            <option value="">All Categories</option>
                            @foreach($categories as $category)
                                <option value="{{ $category->id }}" {{ request('category') == $category->id ? 'selected' : '' }}>
                                    {{ $category->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <!-- Price Range -->
                    <div class="mb-6">
                        <h4 class="font-medium mb-2">Price Range</h4>
                        <div class="flex gap-2">
                            <input type="number" name="min_price" placeholder="Min" value="{{ request('min_price') }}"
                                   class="w-1/2 px-3 py-2 border border-gray-300 rounded-lg">
                            <input type="number" name="max_price" placeholder="Max" value="{{ request('max_price') }}"
                                   class="w-1/2 px-3 py-2 border border-gray-300 rounded-lg">
                        </div>
                    </div>

                    <!-- Sort -->
                    <div class="mb-6">
                        <h4 class="font-medium mb-2">Sort By</h4>
                        <select name="sort" class="w-full px-3 py-2 border border-gray-300 rounded-lg">
                            <option value="latest" {{ request('sort') == 'latest' ? 'selected' : '' }}>Latest</option>
                            <option value="price_low" {{ request('sort') == 'price_low' ? 'selected' : '' }}>Price: Low to High</option>
                            <option value="price_high" {{ request('sort') == 'price_high' ? 'selected' : '' }}>Price: High to Low</option>
                            <option value="name" {{ request('sort') == 'name' ? 'selected' : '' }}>Name</option>
                        </select>
                    </div>

                    <button type="submit" class="w-full bg-indigo-600 text-white py-2 rounded-lg hover:bg-indigo-700">
                        Apply Filters
                    </button>
                </form>
            </div>
        </div>

        <!-- Products Grid -->
        <div class="flex-1">
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
                @forelse($products as $product)
                    <div class="bg-white rounded-lg shadow-lg overflow-hidden hover:shadow-xl transition">
                        <a href="{{ route('products.show', $product) }}">
                            @if($product->image)
                                <img src="{{ asset('storage/' . $product->image) }}" alt="{{ $product->name }}" 
                                     class="w-full h-48 object-cover">
                            @else
                                <div class="w-full h-48 bg-gray-200 flex items-center justify-center">
                                    <span class="text-gray-400 text-4xl">📦</span>
                                </div>
                            @endif
                            
                            <div class="p-4">
                                <span class="text-xs text-gray-500">{{ $product->category->name }}</span>
                                <h3 class="font-semibold text-lg mb-2 truncate">{{ $product->name }}</h3>
                                <p class="text-gray-600 text-sm mb-3 line-clamp-2">{{ $product->description }}</p>
                                
                                <div class="flex items-center justify-between mb-3">
                                    <div>
                                        @if($product->discount_price)
                                            <span class="text-xl font-bold text-indigo-600">৳{{ number_format($product->discount_price, 2) }}</span>
                                            <span class="text-sm text-gray-500 line-through ml-2">৳{{ number_format($product->price, 2) }}</span>
                                        @else
                                            <span class="text-xl font-bold text-indigo-600">৳{{ number_format($product->price, 2) }}</span>
                                        @endif
                                    </div>
                                    @if($product->cashback_percentage)
                                        <span class="bg-green-100 text-green-800 text-xs px-2 py-1 rounded">
                                            {{ $product->cashback_percentage }}% Cashback
                                        </span>
                                    @endif
                                </div>
                                
                                <div class="flex items-center justify-between text-sm text-gray-500 mb-3">
                                    <span>Stock: {{ $product->stock }}</span>
                                    <span>{{ $product->merchant->business_name }}</span>
                                </div>
                                
                                <button onclick="addToCart({{ $product->id }})" 
                                        class="w-full bg-indigo-600 text-white py-2 rounded-lg hover:bg-indigo-700 transition">
                                    Add to Cart
                                </button>
                            </div>
                        </a>
                    </div>
                @empty
                    <div class="col-span-3 text-center py-12 text-gray-500">
                        No products found
                    </div>
                @endforelse
            </div>

            <!-- Pagination -->
            <div class="mt-8">
                {{ $products->links() }}
            </div>
        </div>
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
            alert('Product added to cart!');
            location.reload();
        } else {
            alert(data.message || 'Failed to add product to cart');
        }
    });
}
</script>
@endsection
