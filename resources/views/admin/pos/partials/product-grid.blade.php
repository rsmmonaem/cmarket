<div class="grid grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-4 md:gap-6">
    @foreach($products as $product)
        <div class="card-premium p-4 hover:border-primary transition-all group flex flex-col h-full bg-white dark:bg-slate-900 border border-slate-100 dark:border-slate-800"
             @click="addToCart({
                id: {{ $product->id }},
                name: '{{ $product->name }}',
                price: {{ $product->final_price }},
                image: '{{ $product->images ? asset('storage/' . $product->images[0]) : 'https://placehold.co/400x400?text=No+Image' }}',
                stock: {{ $product->stock }}
             })">
            <div class="relative rounded-2xl overflow-hidden aspect-square mb-4 bg-slate-50 dark:bg-slate-800">
                @if($product->images && count($product->images) > 0)
                    <img src="{{ asset('storage/' . $product->images[0]) }}" alt="{{ $product->name }}" class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-500">
                @else
                    <div class="w-full h-full flex items-center justify-center text-slate-300">
                        <span class="text-4xl">📦</span>
                    </div>
                @endif
                <div class="absolute top-2 right-2 flex flex-col gap-1">
                    <span class="px-3 py-1 bg-white/95 dark:bg-slate-900/95 backdrop-blur-md text-[9px] font-black text-slate-800 dark:text-white rounded-lg shadow-sm uppercase tracking-tighter">
                        SKU: {{ $product->sku ?? 'N/A' }}
                    </span>
                    @if($product->discount_price)
                        <span class="px-3 py-1 bg-rose-500 text-white text-[9px] font-black rounded-lg shadow-sm uppercase tracking-tighter">
                            SAVE {{ $product->discount_percentage }}%
                        </span>
                    @endif
                </div>
            </div>

            <div class="flex-1 space-y-2">
                <div class="text-[10px] font-black text-primary uppercase tracking-widest truncate">{{ $product->category->name }}</div>
                <h3 class="text-xs font-bold text-slate-800 dark:text-white leading-tight line-clamp-2 h-8">{{ $product->name }}</h3>
                <div class="flex items-end justify-between pt-2 border-t border-slate-50 dark:border-slate-800">
                    <div>
                        <div class="text-[10px] font-black text-slate-400 line-through leading-none">৳{{ number_format($product->price) }}</div>
                        <div class="text-sm font-black text-slate-900 dark:text-white tracking-tighter">৳{{ number_format($product->final_price) }}</div>
                    </div>
                    <div class="text-[9px] font-black text-emerald-500 uppercase tracking-widest bg-emerald-50 dark:bg-emerald-900/20 px-2 py-0.5 rounded-md">
                        {{ $product->stock }} IN STOCK
                    </div>
                </div>
            </div>
        </div>
    @endforeach
</div>

<div class="mt-8">
    {{ $products->links('vendor.pagination.tailwind') }}
</div>
