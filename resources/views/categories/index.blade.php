@extends('layouts.public')

@section('title', 'Browse Categories - CMarket')

@section('content')
<div class="bg-indigo-900 py-16 text-white text-center">
    <div class="max-w-7xl mx-auto px-4">
        <h1 class="text-4xl lg:text-5xl font-extrabold mb-4">All Categories</h1>
        <p class="text-indigo-200 text-lg">Explore our diverse range of products across all departments</p>
    </div>
</div>

<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-16">
    <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-8">
        @forelse($categories as $category)
            <div class="group relative bg-white rounded-3xl p-8 shadow-xl shadow-gray-200/50 hover:shadow-indigo-900/10 transition-all duration-500 border border-gray-100 hover:border-indigo-100 flex flex-col items-center text-center">
                <div class="w-24 h-24 mb-6 rounded-full overflow-hidden bg-gray-50 flex items-center justify-center group-hover:scale-110 transition duration-500 shadow-inner">
                    @if($category->image)
                        <img src="{{ asset('storage/' . $category->image) }}" alt="{{ $category->name }}" class="w-full h-full object-cover">
                    @else
                        <span class="text-4xl text-indigo-300">📦</span>
                    @endif
                </div>
                
                <h3 class="text-xl font-bold text-gray-900 mb-2 group-hover:text-indigo-600 transition">{{ $category->name }}</h3>
                <p class="text-gray-500 text-sm mb-6 line-clamp-2">{{ $category->description ?? 'Explore premium products in ' . $category->name }}</p>
                
                <div class="mt-auto">
                    <span class="inline-block bg-indigo-50 text-indigo-700 text-xs font-bold px-4 py-1.5 rounded-full mb-6">
                        {{ $category->products_count ?? 0 }} PRODUCTS
                    </span>
                    
                    <a href="{{ route('products.index', ['category' => $category->id]) }}" class="block w-full text-indigo-600 font-bold border-2 border-indigo-600 px-6 py-2.5 rounded-2xl hover:bg-indigo-600 hover:text-white transition-all transform group-hover:scale-105 shadow-lg shadow-indigo-600/5">
                        Browse Now
                    </a>
                </div>
                
                @if($category->children->count() > 0)
                    <div class="mt-8 pt-6 border-t border-gray-100 w-full text-left">
                        <span class="text-[10px] font-black text-gray-400 uppercase tracking-widest mb-3 block">Sub-Categories</span>
                        <div class="flex flex-wrap gap-2">
                            @foreach($category->children as $child)
                                <a href="{{ route('products.index', ['category' => $child->id]) }}" class="text-xs bg-gray-100 hover:bg-indigo-100 text-gray-600 hover:text-indigo-700 px-3 py-1 rounded-lg transition">
                                    {{ $child->name }}
                                </a>
                            @endforeach
                        </div>
                    </div>
                @endif
            </div>
        @empty
            <div class="col-span-full py-24 text-center">
                <div class="text-6xl mb-6">🏜️</div>
                <h2 class="text-2xl font-bold text-gray-900 mb-2">No Categories Found</h2>
                <p class="text-gray-500">We're adding new categories soon. Check back later!</p>
            </div>
        @endforelse
    </div>
</div>
@endsection
