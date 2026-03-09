@extends('layouts.customer')

@section('title', 'Merchant Inventory - CMarket')
@section('page-title', 'Product & Inventory Hub')

@section('content')
<div class="space-y-10 animate-fade-in">
    <!-- Macro Summary -->
    <div class="bg-white rounded-[3rem] p-10 lg:p-12 border border-slate-100 shadow-sm flex flex-col lg:flex-row justify-between items-center gap-10 overflow-hidden relative group">
        <div class="relative z-10">
            <h2 class="text-3xl font-black text-slate-800 tracking-tight leading-none mb-4">Merchant Inventory</h2>
            <p class="text-slate-400 font-bold text-[10px] uppercase tracking-[0.2em] ml-1">Live Management Terminal • {{ $products->total() }} Identified Products</p>
        </div>
        <div class="flex items-center gap-4 relative z-10 w-full lg:w-auto">
            <a href="{{ route('merchant.products.create') }}" class="flex-1 lg:flex-none px-10 py-5 bg-slate-900 text-white rounded-2xl font-black text-[10px] uppercase tracking-widest shadow-2xl shadow-slate-900/10 hover:bg-emerald-600 hover:scale-[1.05] transition-all flex items-center justify-center gap-3">
                <span class="text-lg">📦</span> Deployment Unit
            </a>
        </div>
        <!-- Decor -->
        <div class="absolute -right-10 -bottom-10 opacity-[0.03] text-[200px] leading-none select-none italic font-black group-hover:scale-110 transition-transform duration-1000">STOCK</div>
    </div>

    <!-- Inventory Grid -->
    <div class="bg-white rounded-[3rem] border border-slate-100 shadow-sm overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse">
                <thead>
                    <tr class="bg-slate-50/50">
                        <th class="px-10 py-6 text-[10px] font-black uppercase tracking-[0.2em] text-slate-400">Inventory Node</th>
                        <th class="px-10 py-6 text-[10px] font-black uppercase tracking-[0.2em] text-slate-400 text-center">Pricing Matrix</th>
                        <th class="px-10 py-6 text-[10px] font-black uppercase tracking-[0.2em] text-slate-400 text-center">Stock Vector</th>
                        <th class="px-10 py-6 text-[10px] font-black uppercase tracking-[0.2em] text-slate-400 text-center">Status</th>
                        <th class="px-10 py-6 text-[10px] font-black uppercase tracking-[0.2em] text-slate-400 text-right">Operations</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-50">
                    @forelse($products as $product)
                        <tr class="group hover:bg-slate-50/80 transition-all duration-300">
                            <td class="px-10 py-8">
                                <div class="flex items-center gap-6">
                                    <div class="w-16 h-16 rounded-2xl bg-white border border-slate-100 overflow-hidden flex items-center justify-center shadow-lg group-hover:scale-110 transition-transform">
                                        @if($product->image)
                                            <img src="{{ asset('storage/' . $product->image) }}" alt="{{ $product->name }}" class="w-full h-full object-cover">
                                        @else
                                            <span class="text-2xl">📦</span>
                                        @endif
                                    </div>
                                    <div>
                                        <div class="text-sm font-black text-slate-800 mb-1">{{ $product->name }}</div>
                                        <div class="flex items-center gap-2">
                                            <span class="text-[9px] font-black text-slate-400 uppercase tracking-widest">{{ $product->category->name }}</span>
                                            <span class="w-1 h-1 rounded-full bg-slate-200"></span>
                                            <span class="text-[9px] font-bold text-sky-500 uppercase tracking-tighter">SKU: {{ $product->sku ?? 'N/A' }}</span>
                                        </div>
                                    </div>
                                </div>
                            </td>
                            <td class="px-10 py-8 text-center">
                                <div class="inline-block text-left">
                                    <div class="text-sm font-black text-slate-800">৳{{ number_format($product->discount_price ?? $product->price, 2) }}</div>
                                    @if($product->discount_price)
                                        <div class="text-[10px] text-slate-400 line-through font-bold">৳{{ number_format($product->price, 2) }}</div>
                                    @endif
                                </div>
                            </td>
                            <td class="px-10 py-8 text-center">
                                <div class="inline-flex flex-col items-center">
                                    <span class="text-sm font-black {{ $product->stock < 10 ? 'text-rose-500' : 'text-slate-800' }}">
                                        {{ $product->stock }}
                                    </span>
                                    <div class="w-16 h-1 bg-slate-100 rounded-full mt-2 overflow-hidden">
                                        <div class="h-full {{ $product->stock < 10 ? 'bg-rose-500' : 'bg-emerald-500' }}" style="width: {{ min(100, ($product->stock / 50) * 100) }}%"></div>
                                    </div>
                                </div>
                            </td>
                            <td class="px-10 py-8 text-center">
                                @if($product->status === 'active')
                                    <span class="inline-flex items-center gap-2 py-2 px-4 rounded-xl text-[9px] font-black bg-emerald-50 text-emerald-600 border border-emerald-100">
                                        <span class="w-1.5 h-1.5 rounded-full bg-emerald-500 animate-pulse"></span> LIVE
                                    </span>
                                @elseif($product->status === 'pending')
                                    <span class="inline-flex items-center gap-2 py-2 px-4 rounded-xl text-[9px] font-black bg-sky-50 text-sky-600 border border-sky-100">
                                        🕒 PENDING
                                    </span>
                                @elseif($product->status === 'update_pending')
                                    <span class="inline-flex items-center gap-2 py-2 px-4 rounded-xl text-[9px] font-black bg-indigo-50 text-indigo-600 border border-indigo-100">
                                        🔄 UPDATING
                                    </span>
                                @elseif($product->status === 'denied')
                                    <div class="flex flex-col items-center gap-1">
                                        <span class="inline-flex items-center gap-2 py-2 px-4 rounded-xl text-[9px] font-black bg-rose-50 text-rose-600 border border-rose-100">
                                            ❌ DENIED
                                        </span>
                                        @if($product->admin_feedback)
                                            <p class="text-[8px] font-bold text-rose-400 max-w-[150px] leading-tight">{{ $product->admin_feedback }}</p>
                                        @endif
                                    </div>
                                @else
                                    <span class="inline-flex items-center gap-2 py-2 px-4 rounded-xl text-[9px] font-black bg-slate-50 text-slate-400 border border-slate-100">
                                        OFFLINE
                                    </span>
                                @endif
                            </td>
                            <td class="px-10 py-8 text-right">
                                <div class="flex justify-end gap-3 opacity-0 group-hover:opacity-100 transition-opacity translate-x-4 group-hover:translate-x-0 duration-300">
                                    <a href="{{ route('merchant.products.edit', $product) }}" class="w-10 h-10 rounded-xl bg-white border border-slate-100 flex items-center justify-center text-lg hover:bg-sky-500 hover:text-white hover:border-sky-500 transition-all shadow-sm">
                                        ✏️
                                    </a>
                                    <form action="{{ route('merchant.products.destroy', $product) }}" method="POST" class="inline" onsubmit="return confirm('Permanent inventory removal confirmation?');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="w-10 h-10 rounded-xl bg-white border border-slate-100 flex items-center justify-center text-lg hover:bg-rose-500 hover:text-white hover:border-rose-500 transition-all shadow-sm">
                                            🗑️
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="px-10 py-32 text-center text-slate-300 flex flex-col items-center">
                                <span class="text-8xl mb-6 opacity-10">📦</span>
                                <p class="text-lg font-black uppercase tracking-[0.2em]">Inventory Vacuum Discovered</p>
                                <p class="text-[10px] font-bold text-slate-400 mt-2">Deploy your first product to begin marketplace operations.</p>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if($products->hasPages())
            <div class="p-10 border-t border-slate-50 bg-slate-50/30">
                {{ $products->links() }}
            </div>
        @endif
    </div>
</div>
@endsection
