@extends('layouts.public')

@section('content')
<!-- Hero Section -->
<div class="gradient-bg text-white py-20">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
        <h1 class="text-5xl font-bold mb-4">Welcome to CMarket</h1>
        <p class="text-xl mb-8">Shop Smart, Earn Cashback, Build Your Network</p>
        <div class="flex justify-center space-x-4">
            <a href="{{ route('products.index') }}" class="bg-white text-indigo-600 px-8 py-3 rounded-lg font-semibold hover:bg-gray-100">
                Shop Now
            </a>
            <a href="{{ route('merchant.register') }}" class="bg-indigo-800 text-white px-8 py-3 rounded-lg font-semibold hover:bg-indigo-900">
                Become a Merchant
            </a>
        </div>
    </div>
</div>

<!-- Features -->
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-16">
    <h2 class="text-3xl font-bold text-center mb-12">Why Choose CMarket?</h2>
    <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
        <div class="bg-white p-8 rounded-lg shadow-lg text-center">
            <div class="text-5xl mb-4">💰</div>
            <h3 class="text-xl font-semibold mb-2">Cashback Rewards</h3>
            <p class="text-gray-600">Earn cashback on every purchase and build your wallet balance</p>
        </div>
        <div class="bg-white p-8 rounded-lg shadow-lg text-center">
            <div class="text-5xl mb-4">🤝</div>
            <h3 class="text-xl font-semibold mb-2">Referral Program</h3>
            <p class="text-gray-600">Invite friends and earn multi-level commissions</p>
        </div>
        <div class="bg-white p-8 rounded-lg shadow-lg text-center">
            <div class="text-5xl mb-4">🏆</div>
            <h3 class="text-xl font-semibold mb-2">Achievement Levels</h3>
            <p class="text-gray-600">Unlock designations and earn more rewards</p>
        </div>
    </div>
</div>

<!-- Featured Products -->
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-16 bg-gray-50">
    <div class="flex justify-between items-center mb-8">
        <h2 class="text-3xl font-bold">Featured Products</h2>
        <a href="{{ route('products.index') }}" class="text-indigo-600 hover:text-indigo-800">View All →</a>
    </div>
    
    <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6">
        @forelse($featuredProducts as $product)
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
                        <h3 class="font-semibold text-lg mb-2 truncate">{{ $product->name }}</h3>
                        <p class="text-gray-600 text-sm mb-3 line-clamp-2">{{ $product->description }}</p>
                        
                        <div class="flex items-center justify-between">
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
                        
                        <button onclick="addToCart({{ $product->id }})" 
                                class="w-full mt-4 bg-indigo-600 text-white py-2 rounded-lg hover:bg-indigo-700 transition">
                            Add to Cart
                        </button>
                    </div>
                </a>
            </div>
        @empty
            <div class="col-span-4 text-center py-12 text-gray-500">
                No products available yet
            </div>
        @endforelse
    </div>
</div>

<!-- Categories -->
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-16">
    <h2 class="text-3xl font-bold text-center mb-12">Shop by Category</h2>
    <div class="grid grid-cols-2 md:grid-cols-4 lg:grid-cols-6 gap-4">
        @foreach($categories as $category)
            <a href="{{ route('products.index', ['category' => $category->id]) }}" 
               class="bg-white p-6 rounded-lg shadow hover:shadow-lg transition text-center">
                @if($category->image)
                    <img src="{{ asset('storage/' . $category->image) }}" alt="{{ $category->name }}" 
                         class="w-16 h-16 mx-auto mb-3 rounded-full object-cover">
                @else
                    <div class="text-4xl mb-3">📂</div>
                @endif
                <h3 class="font-semibold">{{ $category->name }}</h3>
                <p class="text-sm text-gray-500">{{ $category->products_count ?? 0 }} items</p>
            </a>
        @endforeach
    </div>
</div>

<!-- CTA Section -->
<div class="gradient-bg text-white py-16">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
        <h2 class="text-3xl font-bold mb-4">Start Your Business with CMarket</h2>
        <p class="text-xl mb-8">Join thousands of merchants and riders earning with us</p>
        <div class="flex justify-center space-x-4">
            <a href="{{ route('merchant.register') }}" class="bg-white text-indigo-600 px-8 py-3 rounded-lg font-semibold hover:bg-gray-100">
                Become a Merchant
            </a>
            <a href="{{ route('rider.register') }}" class="bg-indigo-800 text-white px-8 py-3 rounded-lg font-semibold hover:bg-indigo-900">
                Become a Rider
            </a>
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
    })
    .catch(error => {
        console.error('Error:', error);
        alert('An error occurred');
    });
}
</script>
@endsection
