@extends('layouts.admin')

@section('title', 'Product Management')
@section('page-title', 'Product Management')

@section('content')
<x-admin.card>
    <div class="flex flex-col lg:flex-row justify-between items-start lg:items-center gap-6 mb-8">
        <div>
            <h2 class="text-xl font-black text-light">Master Product Catalog</h2>
            <p class="text-xs text-muted-light font-bold uppercase tracking-widest">Manage inventory and business packages</p>
        </div>
        <div class="flex flex-wrap gap-3">
            <a href="{{ route('admin.products.create') }}">
                <x-admin.button>
                    <span class="text-lg">➕</span> Add New Product
                </x-admin.button>
            </a>
        </div>
    </div>

    <!-- Filters -->
    <div class="p-6 rounded-3xl bg-slate-50 dark:bg-slate-800/50 border border-slate-100 dark:border-slate-800 mb-8">
        <form method="GET" class="grid grid-cols-1 md:grid-cols-4 gap-4">
            <input type="text" name="search" placeholder="Search products..." 
                   value="{{ request('search') }}"
                   class="px-4 py-3 bg-white dark:bg-slate-900 border border-slate-200 dark:border-slate-700 rounded-2xl text-sm focus:outline-none focus:ring-2 focus:ring-sky-500 transition">
            
            <select name="status" class="px-4 py-3 bg-white dark:bg-slate-900 border border-slate-200 dark:border-slate-700 rounded-2xl text-sm focus:outline-none focus:ring-2 focus:ring-sky-500 transition">
                <option value="">All Status</option>
                <option value="active" {{ request('status') == 'active' ? 'selected' : '' }}>Active</option>
                <option value="inactive" {{ request('status') == 'inactive' ? 'selected' : '' }}>Inactive</option>
                <option value="draft" {{ request('status') == 'draft' ? 'selected' : '' }}>Draft</option>
            </select>

            <select name="type" class="px-4 py-3 bg-white dark:bg-slate-900 border border-slate-200 dark:border-slate-700 rounded-2xl text-sm focus:outline-none focus:ring-2 focus:ring-sky-500 transition">
                <option value="">All Types</option>
                <option value="product" {{ request('type') == 'product' ? 'selected' : '' }}>Normal Product</option>
                <option value="package" {{ request('type') == 'package' ? 'selected' : '' }}>Business Package</option>
            </select>
            
            <x-admin.button type="submit" variant="secondary" class="w-full">
                🔍 Apply Filters
            </x-admin.button>
        </form>
    </div>

    <div class="overflow-x-auto -mx-6">
        <table class="w-full text-left border-collapse">
            <thead>
                <tr class="border-b border-light">
                    <th class="px-6 py-4 text-[10px] font-black uppercase tracking-widest text-muted-light">Product Detail</th>
                    <th class="px-6 py-4 text-[10px] font-black uppercase tracking-widest text-muted-light">Category</th>
                    <th class="px-6 py-4 text-[10px] font-black uppercase tracking-widest text-muted-light">Pricing</th>
                    <th class="px-6 py-4 text-[10px] font-black uppercase tracking-widest text-muted-light">Stock</th>
                    <th class="px-6 py-4 text-[10px] font-black uppercase tracking-widest text-muted-light">Status</th>
                    <th class="px-6 py-4 text-[10px] font-black uppercase tracking-widest text-muted-light text-right">Actions</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-light">
                @forelse($products as $product)
                    <tr class="group hover:bg-slate-50 dark:hover:bg-slate-800/50 transition-colors">
                        <td class="px-6 py-4">
                            <div class="flex items-center gap-4">
                                <div class="w-14 h-14 rounded-2xl bg-slate-100 dark:bg-slate-800 overflow-hidden flex items-center justify-center border border-light relative">
                                    @php $imgArr = is_array($product->images) ? $product->images : (json_decode($product->images, true) ?: []); $img = $imgArr[0] ?? null; @endphp
                                    @if($img)
                                        <img src="{{ asset('storage/' . $img) }}" alt="{{ $product->name }}" class="w-full h-full object-cover">
                                    @else
                                        <span class="text-2xl">🛍️</span>
                                    @endif
                                    @if($product->type === 'package')
                                        <div class="absolute top-0 right-0 bg-sky-500 w-3 h-3 rounded-full border-2 border-white dark:border-slate-900"></div>
                                    @endif
                                </div>
                                <div>
                                    <div class="text-sm font-black text-light line-clamp-1">{{ $product->name }}</div>
                                    <div class="text-[10px] text-muted-light font-bold flex items-center gap-2">
                                        <span class="px-1.5 py-0.5 rounded bg-slate-100 dark:bg-slate-800 uppercase tracking-tighter">{{ $product->type }}</span>
                                        SKU: {{ $product->sku ?? 'N/A' }}
                                    </div>
                                </div>
                            </div>
                        </td>
                        <td class="px-6 py-4 text-sm font-bold text-muted-light">
                            {{ $product->category->name ?? 'Uncategorized' }}
                        </td>
                        <td class="px-6 py-4">
                            <div class="text-sm font-black text-light">৳{{ number_format($product->discount_price ?? $product->price, 2) }}</div>
                            @if($product->discount_price)
                                <div class="text-[10px] text-muted-light line-through font-bold">৳{{ number_format($product->price, 2) }}</div>
                            @endif
                        </td>
                        <td class="px-6 py-4">
                            <div class="flex items-center gap-2">
                                <div class="w-24 h-1.5 bg-slate-100 dark:bg-slate-800 rounded-full overflow-hidden">
                                    <div class="h-full {{ $product->stock > 10 ? 'bg-emerald-500' : 'bg-red-500' }}" style="width: {{ min(100, ($product->stock / 100) * 100) }}%"></div>
                                </div>
                                <span class="text-[10px] font-black text-light">{{ $product->stock }}</span>
                            </div>
                        </td>
                        <td class="px-6 py-4">
                            @if($product->status === 'active')
                                <span class="inline-flex items-center gap-1.5 py-1.5 px-3 rounded-full text-[10px] font-black bg-emerald-100 text-emerald-700 dark:bg-emerald-900/40 dark:text-emerald-400">
                                    <span class="w-1.5 h-1.5 rounded-full bg-emerald-500"></span> ACTIVE
                                </span>
                            @elseif($product->status === 'draft')
                                <span class="inline-flex items-center gap-1.5 py-1.5 px-3 rounded-full text-[10px] font-black bg-amber-100 text-amber-700 dark:bg-amber-900/40 dark:text-amber-400">
                                    <span class="w-1.5 h-1.5 rounded-full bg-amber-500"></span> DRAFT
                                </span>
                            @else
                                <span class="inline-flex items-center gap-1.5 py-1.5 px-3 rounded-full text-[10px] font-black bg-slate-100 text-slate-500 dark:bg-slate-800 dark:text-slate-400">
                                    <span class="w-1.5 h-1.5 rounded-full bg-slate-400"></span> INACTIVE
                                </span>
                            @endif
                        </td>
                        <td class="px-6 py-4 text-right">
                            <div class="flex justify-end gap-2">
                                <a href="{{ route('admin.products.edit', $product) }}" class="p-2 rounded-xl bg-slate-100 dark:bg-slate-800 text-light hover:bg-sky-500 hover:text-white transition shadow-sm">
                                    ✏️
                                </a>
                                <form action="{{ route('admin.products.destroy', $product) }}" method="POST" class="inline" onsubmit="return confirm('Delete this product?');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="p-2 rounded-xl bg-slate-100 dark:bg-slate-800 text-light hover:bg-red-500 hover:text-white transition shadow-sm">
                                        🗑️
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="6" class="px-6 py-12 text-center text-muted-light italic">No products found for the current selection.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    @if($products->hasPages())
        <div class="mt-8">
            {{ $products->links() }}
        </div>
    @endif
</x-admin.card>
@endsection
