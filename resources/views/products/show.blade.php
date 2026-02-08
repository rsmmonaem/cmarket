@extends('layouts.public')

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
    <div class="bg-white rounded-lg shadow-lg overflow-hidden">
        <div class="grid grid-cols-1 md:grid-cols-2 gap-8 p-8">
            <!-- Product Image -->
            <div>
                @if($product->image)
                    <img src="{{ asset('storage/' . $product->image) }}" alt="{{ $product->name }}" 
                         class="w-full rounded-lg">
                @else
                    <div class="w-full h-96 bg-gray-200 flex items-center justify-center rounded-lg">
                        <span class="text-gray-400 text-6xl">📦</span>
                    </div>
                @endif
            </div>

            <!-- Product Details -->
            <div>
                <div class="mb-4">
                    <a href="{{ route('products.index', ['category' => $product->category_id]) }}" 
                       class="text-indigo-600 hover:text-indigo-800 text-sm">
                        {{ $product->category->name }}
                    </a>
                </div>
                
                <h1 class="text-3xl font-bold text-gray-900 mb-4">{{ $product->name }}</h1>
                
                <div class="flex items-center gap-4 mb-6">
                    @if($product->discount_price)
                        <span class="text-4xl font-bold text-indigo-600">৳{{ number_format($product->discount_price, 2) }}</span>
                        <span class="text-2xl text-gray-500 line-through">৳{{ number_format($product->price, 2) }}</span>
                        <span class="bg-red-100 text-red-800 px-3 py-1 rounded-full text-sm font-semibold">
                            {{ round((($product->price - $product->discount_price) / $product->price) * 100) }}% OFF
                        </span>
                    @else
                        <span class="text-4xl font-bold text-indigo-600">৳{{ number_format($product->price, 2) }}</span>
                    @endif
                </div>

                @if($product->cashback_percentage)
                    <div class="bg-green-50 border border-green-200 rounded-lg p-4 mb-6">
                        <div class="flex items-center">
                            <span class="text-green-600 font-semibold">🎁 {{ $product->cashback_percentage }}% Cashback</span>
                            <span class="ml-2 text-gray-600">
                                (৳{{ number_format(($product->discount_price ?? $product->price) * $product->cashback_percentage / 100, 2) }})
                            </span>
                        </div>
                    </div>
                @endif

                <div class="mb-6">
                    <h3 class="font-semibold text-gray-900 mb-2">Description</h3>
                    <p class="text-gray-600 leading-relaxed">{{ $product->description }}</p>
                </div>

                <div class="grid grid-cols-2 gap-4 mb-6">
                    <div>
                        <span class="text-gray-600">Stock:</span>
                        <span class="font-semibold {{ $product->stock > 0 ? 'text-green-600' : 'text-red-600' }}">
                            {{ $product->stock > 0 ? $product->stock . ' available' : 'Out of stock' }}
                        </span>
                    </div>
                    <div>
                        <span class="text-gray-600">SKU:</span>
                        <span class="font-semibold">{{ $product->sku ?? 'N/A' }}</span>
                    </div>
                    <div class="col-span-2">
                        <span class="text-gray-600">Sold by:</span>
                        <span class="font-semibold">{{ $product->merchant->business_name }}</span>
                    </div>
                </div>

                @if($product->stock > 0)
                    <button onclick="addToCart({{ $product->id }})" 
                            class="w-full bg-indigo-600 text-white py-4 rounded-lg hover:bg-indigo-700 transition text-lg font-semibold">
                        Add to Cart
                    </button>
                @else
                    <button disabled class="w-full bg-gray-300 text-gray-600 py-4 rounded-lg cursor-not-allowed text-lg font-semibold">
                        Out of Stock
                    </button>
                @endif
            </div>
        </div>
    </div>

    <!-- Related Products -->
    @if($relatedProducts->count() > 0)
        <div class="mt-12">
            <h2 class="text-2xl font-bold mb-6">Related Products</h2>
            <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-4 gap-6">
                @foreach($relatedProducts as $related)
                    <div class="bg-white rounded-lg shadow-lg overflow-hidden hover:shadow-xl transition">
                        <a href="{{ route('products.show', $related) }}">
                            @if($related->image)
                                <img src="{{ asset('storage/' . $related->image) }}" alt="{{ $related->name }}" 
                                     class="w-full h-48 object-cover">
                            @else
                                <div class="w-full h-48 bg-gray-200 flex items-center justify-center">
                                    <span class="text-gray-400 text-4xl">📦</span>
                                </div>
                            @endif
                            <div class="p-4">
                                <h3 class="font-semibold truncate">{{ $related->name }}</h3>
                                <span class="text-lg font-bold text-indigo-600">৳{{ number_format($related->price, 2) }}</span>
                            </div>
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
            alert('Product added to cart!');
            window.location.href = '{{ route("cart.index") }}';
        } else {
            alert(data.message || 'Failed to add product to cart');
        }
    });
}
</script>
@endsection
