@extends('layouts.admin')

@section('title', 'Product Master Directory - CMarket')
@section('page-title', 'Global Inventory Management')

@section('content')
<div class="space-y-10 animate-fade-in">
    <!-- Macro Summary & Action -->
    <div class="bg-white dark:bg-slate-900 rounded-[2.5rem] md:rounded-[3rem] p-6 md:p-10 lg:p-12 border border-slate-100 dark:border-slate-800 shadow-sm flex flex-col lg:flex-row justify-between items-center gap-8 md:gap-10 overflow-hidden relative group">
        <div class="relative z-10 w-full lg:w-auto text-center lg:text-left">
            <h2 class="text-2xl md:text-3xl font-black text-slate-800 dark:text-white tracking-tight leading-none mb-3 md:mb-4">Master Product Catalog</h2>
            <p class="text-slate-400 dark:text-slate-500 font-bold text-[9px] md:text-[10px] uppercase tracking-[0.2em] ml-1">Managing {{ $products->total() }} global inventory nodes</p>
        </div>
        <div class="flex items-center gap-4 relative z-10 w-full lg:w-auto">
            <a href="{{ route('admin.products.create') }}" class="flex-1 lg:flex-none px-6 py-4 md:px-10 md:py-5 bg-slate-900 dark:bg-sky-600 text-white rounded-xl md:rounded-2xl font-black text-[9px] md:text-[10px] uppercase tracking-widest shadow-2xl shadow-slate-900/10 hover:bg-sky-600 dark:hover:bg-sky-500 hover:scale-[1.05] transition-all flex items-center justify-center gap-3">
                <span class="text-base md:text-lg">➕</span> Register Global Unit
            </a>
        </div>
        <!-- Decor -->
        <div class="absolute -right-10 -bottom-10 opacity-[0.03] text-[150px] md:text-[200px] leading-none select-none italic font-black group-hover:scale-110 transition-transform duration-1000 dark:text-white">INDEX</div>
    </div>

    <!-- Intelligent Filtering Terminal -->
    <div class="bg-white dark:bg-slate-900 rounded-[2.5rem] md:rounded-[3rem] p-6 md:p-10 border border-slate-100 dark:border-slate-800 shadow-sm mb-10">
        <form method="GET" class="flex flex-col lg:flex-row gap-4 md:gap-6">
            <div class="flex-1 relative">
                <span class="absolute left-6 top-1/2 -translate-y-1/2 opacity-20 text-lg">🔍</span>
                <input type="text" name="search" placeholder="Search products..." 
                       value="{{ request('search') }}"
                       class="w-full h-14 md:h-16 bg-slate-50 dark:bg-slate-800 border-none rounded-2xl pl-16 pr-6 text-xs font-black text-slate-800 dark:text-white focus:ring-2 focus:ring-sky-500/20 transition-all placeholder:text-slate-300 dark:placeholder:text-slate-600">
            </div>
            
            <div class="grid grid-cols-2 lg:flex gap-4">
                <select name="status" class="w-full lg:w-48 h-14 md:h-16 bg-slate-50 dark:bg-slate-800 border-none rounded-2xl px-6 text-xs font-black text-slate-800 dark:text-white focus:ring-2 focus:ring-sky-500/20 transition-all">
                    <option value="">Status</option>
                    <option value="active" {{ request('status') == 'active' ? 'selected' : '' }}>Active</option>
                    <option value="inactive" {{ request('status') == 'inactive' ? 'selected' : '' }}>Inactive</option>
                    <option value="draft" {{ request('status') == 'draft' ? 'selected' : '' }}>Draft</option>
                </select>

                <select name="type" class="w-full lg:w-48 h-14 md:h-16 bg-slate-50 dark:bg-slate-800 border-none rounded-2xl px-6 text-xs font-black text-slate-800 dark:text-white focus:ring-2 focus:ring-sky-500/20 transition-all">
                    <option value="">Type</option>
                    <option value="product" {{ request('type') == 'product' ? 'selected' : '' }}>Product</option>
                    <option value="package" {{ request('type') == 'package' ? 'selected' : '' }}>Package</option>
                </select>
            </div>
            
            <button type="submit" class="h-14 md:h-16 px-10 bg-slate-900 dark:bg-sky-600 text-white rounded-2xl font-black text-[10px] uppercase tracking-widest hover:bg-sky-600 dark:hover:bg-sky-500 transition-all flex items-center justify-center gap-3 active:scale-95 shadow-lg shadow-slate-900/10 dark:shadow-sky-500/10">
                Execute
            </button>
        </form>
    </div>

    <!-- Data Infrastructure Table -->
    <div class="bg-white dark:bg-slate-900 rounded-[2.5rem] md:rounded-[3rem] border border-slate-100 dark:border-slate-800 shadow-sm overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse min-w-[1100px]">
                <thead>
                    <tr class="bg-slate-50/50 dark:bg-slate-800/50">
                        <th class="px-10 py-6 text-[10px] font-black uppercase tracking-[0.2em] text-slate-400 dark:text-slate-500">Inventory Node</th>
                        <th class="px-10 py-6 text-[10px] font-black uppercase tracking-[0.2em] text-slate-400 dark:text-slate-500">Category & Source</th>
                        <th class="px-10 py-6 text-[10px] font-black uppercase tracking-[0.2em] text-slate-400 dark:text-slate-500 text-center">Price Matrix</th>
                        <th class="px-10 py-6 text-[10px] font-black uppercase tracking-[0.2em] text-slate-400 dark:text-slate-500 text-center">Stock Vector</th>
                        <th class="px-10 py-6 text-[10px] font-black uppercase tracking-[0.2em] text-slate-400 dark:text-slate-500 text-center">Visibility</th>
                        <th class="px-10 py-6 text-[10px] font-black uppercase tracking-[0.2em] text-slate-400 dark:text-slate-500 text-right">Operations</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-50 dark:divide-slate-800">
                    @forelse($products as $product)
                        <tr class="group hover:bg-slate-50/80 transition-all duration-300">
                            <td class="px-10 py-8">
                                <div class="flex items-center gap-6">
                                    <div class="w-16 h-16 rounded-2xl bg-white border border-slate-100 overflow-hidden flex items-center justify-center shadow-lg group-hover:scale-110 transition-transform relative">
                                        @php $imgArr = is_array($product->images) ? $product->images : (json_decode($product->images, true) ?: []); $img = $imgArr[0] ?? null; @endphp
                                        @if($img)
                                            <img src="{{ asset('storage/' . $img) }}" alt="{{ $product->name }}" class="w-full h-full object-cover">
                                        @else
                                            <span class="text-2xl">🛍️</span>
                                        @endif
                                        @if($product->type === 'package')
                                            <div class="absolute top-0 right-0 bg-sky-500 w-3 h-3 rounded-full border-2 border-white"></div>
                                        @endif
                                    </div>
                                    <div>
                                        <div class="text-sm font-black text-slate-800 mb-1 truncate max-w-[200px]">{{ $product->name }}</div>
                                        <div class="text-[9px] text-slate-400 font-black uppercase tracking-widest">SKU: {{ $product->sku ?? 'N/A' }}</div>
                                    </div>
                                </div>
                            </td>
                            <td class="px-10 py-8">
                                <div class="text-[10px] font-black text-slate-800 uppercase tracking-widest mb-1">{{ $product->category->name ?? 'Uncategorized' }}</div>
                                <div class="text-[10px] font-bold text-sky-500 truncate max-w-[150px]">{{ $product->merchant->shop_name ?? 'System Direct' }}</div>
                            </td>
                            <td class="px-10 py-8 text-center text-sm font-black text-slate-800">
                                ৳{{ number_format($product->discount_price ?? $product->price, 2) }}
                            </td>
                            <td class="px-10 py-8 text-center">
                                <div class="inline-flex flex-col items-center">
                                    <span class="text-[10px] font-black {{ $product->stock < 10 ? 'text-rose-500' : 'text-slate-800' }}">
                                        {{ $product->stock }}
                                    </span>
                                    <div class="w-12 h-1 bg-slate-100 rounded-full mt-1.5 overflow-hidden">
                                        <div class="h-full {{ $product->stock < 10 ? 'bg-rose-500' : 'bg-emerald-500' }}" style="width: {{ min(100, ($product->stock / 50) * 100) }}%"></div>
                                    </div>
                                </div>
                            </td>
                            <td class="px-10 py-8 text-center">
                                @if($product->status === 'active')
                                    <span class="inline-flex items-center gap-1.5 py-1.5 px-3 rounded-lg text-[8px] font-black bg-emerald-50 text-emerald-600 border border-emerald-100">
                                        LIVE
                                    </span>
                                @elseif($product->status === 'draft')
                                    <span class="inline-flex items-center gap-1.5 py-1.5 px-3 rounded-lg text-[8px] font-black bg-amber-50 text-amber-600 border border-amber-100">
                                        DRAFT
                                    </span>
                                @else
                                    <span class="inline-flex items-center gap-1.5 py-1.5 px-3 rounded-lg text-[8px] font-black bg-slate-50 text-slate-400 border border-slate-100">
                                        OFFLINE
                                    </span>
                                @endif
                            </td>
                            <td class="px-10 py-8 text-right">
                                <div class="flex justify-end gap-3 opacity-0 group-hover:opacity-100 transition-opacity translate-x-4 group-hover:translate-x-0 duration-300">
                                    <a href="{{ route('admin.products.edit', $product) }}" class="w-10 h-10 rounded-xl bg-white dark:bg-slate-800 border border-slate-100 dark:border-slate-700 flex items-center justify-center text-lg hover:bg-sky-500 hover:text-white hover:border-sky-500 transition-all shadow-sm">
                                        ✏️
                                    </a>
                                    <form action="{{ route('admin.products.destroy', $product) }}" method="POST" class="inline" onsubmit="return confirm('Permanent node deletion confirmation?');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="w-10 h-10 rounded-xl bg-white dark:bg-slate-800 border border-slate-100 dark:border-slate-700 flex items-center justify-center text-lg hover:bg-rose-500 hover:text-white hover:border-rose-500 transition-all shadow-sm">
                                            🗑️
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="px-10 py-32 text-center text-slate-300 flex flex-col items-center">
                                <span class="text-8xl mb-6 opacity-10">🧊</span>
                                <p class="text-lg font-black uppercase tracking-[0.2em]">Inventory Exhausted</p>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if($products->hasPages())
            <div class="p-6 md:p-10 border-t border-slate-50 dark:border-slate-800 bg-slate-50/30 dark:bg-slate-800/30">
                {{ $products->links() }}
            </div>
        @endif
    </div>
</div>
@endsection
