@extends('layouts.public')

@section('title', 'Search results for "' . $query . '" - CMarket')

@section('content')
<div class="bg-gray-100 py-12">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <h1 class="text-3xl font-bold text-gray-900 mb-2">Search results</h1>
        <p class="text-gray-600">Showing results for "{{ $query }}"</p>
    </div>
</div>

<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
    @if($products->count() > 0)
        <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-8">
            @foreach($products as $product)
                <div class="bg-white rounded-2xl shadow-sm overflow-hidden group hover:shadow-xl transition-all duration-300">
                    <a href="{{ route('products.show', $product) }}" class="block">
                        <div class="aspect-square bg-gray-100 overflow-hidden relative">
                             @php $imgArr = is_array($product->images) ? $product->images : (json_decode($product->images, true) ?: []); $img = $imgArr[0] ?? null; @endphp
                            @if($img)
                                <img src="{{ asset('storage/' . $img) }}" alt="{{ $product->name }}" class="w-full h-full object-cover group-hover:scale-110 transition duration-500">
                            @else
                                <div class="w-full h-full flex items-center justify-center text-5xl">🛍️</div>
                            @endif
                            @if($product->type === 'package')
                                <div class="absolute top-4 right-4 bg-indigo-600 text-white text-[10px] font-black px-3 py-1 rounded-full shadow-lg">PACKAGE</div>
                            @endif
                        </div>
                        
                        <div class="p-6">
                            <h3 class="font-bold text-gray-900 group-hover:text-indigo-600 transition truncate mb-2">{{ $product->name }}</h3>
                            <div class="flex items-center justify-between">
                                <span class="text-xl font-black text-gray-900">৳{{ number_format($product->discount_price ?? $product->price, 2) }}</span>
                                <span class="text-xs text-gray-400">{{ $product->category->name ?? 'General' }}</span>
                            </div>
                        </div>
                    </a>
                </div>
            @endforeach
        </div>
        
        <div class="mt-12">
            {{ $products->appends(['q' => $query])->links() }}
        </div>
    @else
        <div class="text-center py-24">
            <div class="text-6xl mb-6">🔍</div>
            <h2 class="text-2xl font-bold text-gray-900 mb-2">No products found</h2>
            <p class="text-gray-500 mb-8">Try adjusting your search or category filters</p>
            <a href="{{ route('products.index') }}" class="inline-block bg-indigo-600 text-white px-8 py-3 rounded-xl font-bold hover:bg-indigo-700 transition">
                Browse All products
            </a>
        </div>
    @endif
</div>
@endsection
