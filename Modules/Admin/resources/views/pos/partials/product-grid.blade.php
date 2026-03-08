<div class="grid grid-cols-2 sm:grid-cols-3 xl:grid-cols-4 gap-3">
    @forelse($products as $product)
        <div class="pos-product-card bg-white rounded-xl border border-slate-200 overflow-hidden shadow-sm hover:border-primary/30"
             @click="addToCart({
                id: {{ $product->id }},
                name: '{{ addslashes($product->name) }}',
                sku: '{{ $product->sku }}',
                price: {{ $product->final_price }},
                image: '{{ $product->images ? asset('storage/' . $product->images[0]) : 'https://placehold.co/200x200?text=No+Image' }}',
                category: '{{ addslashes($product->category->name ?? '') }}',
                stock: {{ $product->stock }}
             })">
            {{-- Product Image --}}
            <div class="relative aspect-square bg-slate-50 overflow-hidden">
                @if($product->images && count($product->images) > 0)
                    <img src="{{ asset('storage/' . $product->images[0]) }}"
                         alt="{{ $product->name }}"
                         class="w-full h-full object-cover transition-transform duration-300 hover:scale-105"
                         onerror="this.src='https://placehold.co/200x200?text=No+Image'">
                @else
                    <div class="w-full h-full flex items-center justify-center">
                        <span class="text-4xl text-slate-300">📦</span>
                    </div>
                @endif

                {{-- Stock Badge --}}
                @if($product->stock <= 5)
                    <span class="absolute top-1.5 left-1.5 px-1.5 py-0.5 bg-rose-500 text-white text-[9px] font-black rounded-md uppercase">Low Stock</span>
                @endif

                {{-- Discount Badge --}}
                @if($product->discount_price)
                    <span class="absolute top-1.5 right-1.5 px-1.5 py-0.5 bg-orange-500 text-white text-[9px] font-black rounded-md uppercase">Sale</span>
                @endif
            </div>

            {{-- Product Info --}}
            <div class="p-2.5">
                <p class="text-[10px] font-bold text-primary/80 uppercase tracking-wide truncate">{{ $product->category->name ?? 'General' }}</p>
                <h3 class="text-xs font-bold text-slate-800 leading-tight line-clamp-2 min-h-[2rem] mt-0.5">{{ $product->name }}</h3>
                <div class="flex items-end justify-between mt-2">
                    <div>
                        @if($product->discount_price)
                            <p class="text-[10px] text-slate-400 line-through leading-none">৳{{ number_format($product->price) }}</p>
                        @endif
                        <p class="text-sm font-black text-slate-900 leading-tight">৳{{ number_format($product->final_price) }}</p>
                    </div>
                    <div class="text-[9px] font-bold text-slate-400">
                        <span class="@if($product->stock <= 0) text-rose-500 @elseif($product->stock <= 5) text-orange-500 @else text-emerald-500 @endif">
                            {{ $product->stock <= 0 ? 'Out' : $product->stock . ' left' }}
                        </span>
                    </div>
                </div>
            </div>
        </div>
    @empty
        <div class="col-span-4 py-16 text-center">
            <div class="text-4xl mb-3">🔍</div>
            <p class="text-sm font-bold text-slate-400">No products found</p>
            <p class="text-xs text-slate-300 mt-1">Try a different search or category</p>
        </div>
    @endforelse
</div>

@if($products->hasPages())
<div class="mt-4 flex justify-center">
    {{ $products->links('vendor.pagination.simple-tailwind') }}
</div>
@endif
