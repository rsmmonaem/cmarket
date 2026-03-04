@extends('layouts.customer')

@section('title', 'Reconfigure Inventory - CMarket')
@section('page-title', 'Inventory Configuration Node')

@section('content')
<div class="max-w-5xl mx-auto animate-fade-in pb-20">
    <form action="{{ route('merchant.products.update', $product) }}" method="POST" enctype="multipart/form-data" class="space-y-10">
        @csrf
        @method('PUT')
        
        <!-- Header Section -->
        <div class="bg-slate-900 rounded-[3rem] p-10 lg:p-14 text-white shadow-2xl shadow-slate-900/10 relative overflow-hidden group">
            <div class="relative z-10">
                <div class="flex items-center gap-3 mb-4">
                    <span class="px-3 py-1 bg-sky-500 rounded-lg text-[8px] font-black uppercase tracking-widest">Live Node</span>
                    <span class="text-white/40 text-[8px] font-black uppercase tracking-widest">ID: #{{ $product->id }}</span>
                </div>
                <h2 class="text-4xl font-black mb-6 tracking-tight">Reconfigure Unit</h2>
                <p class="text-slate-400 font-medium leading-relaxed max-w-2xl">Modify the operational parameters of your inventory unit. System synchronizes changes across all active marketplace channels in real-time.</p>
            </div>
            <div class="absolute -right-10 -bottom-10 opacity-5 text-[250px] leading-none select-none italic font-black group-hover:scale-110 transition-transform duration-1000">MOD</div>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-10">
            <!-- Left: Core Info -->
            <div class="lg:col-span-2 space-y-10">
                <div class="bg-white rounded-[2.5rem] p-10 border border-slate-100 shadow-sm space-y-8">
                    <div class="flex items-center gap-4 mb-4">
                        <span class="w-10 h-10 rounded-xl bg-sky-50 flex items-center justify-center text-lg">📝</span>
                        <h3 class="text-sm font-black text-slate-800 uppercase tracking-widest">Primary Identity</h3>
                    </div>

                    <div class="space-y-6">
                        <div class="space-y-2">
                            <label class="text-[10px] font-black text-slate-400 uppercase tracking-widest ml-1">Product Designation</label>
                            <input type="text" name="name" required value="{{ old('name', $product->name) }}" 
                                   class="w-full h-16 bg-slate-50 border-none rounded-2xl px-6 text-sm font-black text-slate-800 focus:ring-2 focus:ring-sky-500/20 transition-all">
                        </div>

                        <div class="grid grid-cols-2 gap-6">
                            <div class="space-y-2">
                                <label class="text-[10px] font-black text-slate-400 uppercase tracking-widest ml-1">Category Classification</label>
                                <select name="category_id" required class="w-full h-16 bg-slate-50 border-none rounded-2xl px-6 text-sm font-black text-slate-800 focus:ring-2 focus:ring-sky-500/20 transition-all">
                                    @foreach($categories as $category)
                                        <option value="{{ $category->id }}" {{ $product->category_id == $category->id ? 'selected' : '' }}>{{ $category->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="space-y-2">
                                <label class="text-[10px] font-black text-slate-400 uppercase tracking-widest ml-1">Inventory SKU</label>
                                <input type="text" name="sku" value="{{ old('sku', $product->sku) }}" 
                                       class="w-full h-16 bg-slate-50 border-none rounded-2xl px-6 text-sm font-black text-slate-800 focus:ring-2 focus:ring-sky-500/20 transition-all">
                            </div>
                        </div>

                        <div class="space-y-2">
                            <label class="text-[10px] font-black text-slate-400 uppercase tracking-widest ml-1">Technical Specifications & Description</label>
                            <textarea name="description" rows="6" class="w-full bg-slate-50 border-none rounded-[2rem] p-8 text-sm font-medium text-slate-600 focus:ring-2 focus:ring-sky-500/20 transition-all">{{ old('description', $product->description) }}</textarea>
                        </div>
                    </div>
                </div>

                <div class="bg-white rounded-[2.5rem] p-10 border border-slate-100 shadow-sm space-y-8">
                    <div class="flex items-center gap-4 mb-4">
                        <span class="w-10 h-10 rounded-xl bg-emerald-50 flex items-center justify-center text-lg">💰</span>
                        <h3 class="text-sm font-black text-slate-800 uppercase tracking-widest">Financial Matrix</h3>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                        <div class="space-y-2">
                            <label class="text-[10px] font-black text-slate-400 uppercase tracking-widest ml-1">Standard Price (৳)</label>
                            <input type="number" name="price" step="0.01" required value="{{ old('price', $product->price) }}" 
                                   class="w-full h-16 bg-slate-50 border-none rounded-2xl px-6 text-sm font-black text-slate-800 focus:ring-2 focus:ring-sky-500/20 transition-all">
                        </div>
                        <div class="space-y-2">
                            <label class="text-[10px] font-black text-slate-400 uppercase tracking-widest ml-1">Promotional Price (৳)</label>
                            <input type="number" name="discount_price" step="0.01" value="{{ old('discount_price', $product->discount_price) }}" 
                                   class="w-full h-16 bg-slate-50 border-none rounded-2xl px-6 text-sm font-black text-slate-800 focus:ring-2 focus:ring-sky-500/20 transition-all">
                        </div>
                        <div class="space-y-2">
                            <label class="text-[10px] font-black text-slate-400 uppercase tracking-widest ml-1">Cashback Vector (%)</label>
                            <input type="number" name="cashback_percentage" step="0.1" value="{{ old('cashback_percentage', $product->cashback_percentage) }}" 
                                   class="w-full h-16 bg-slate-50 border-none rounded-2xl px-6 text-sm font-black text-emerald-600 focus:ring-2 focus:ring-emerald-500/20 transition-all">
                        </div>
                        <div class="space-y-2">
                            <label class="text-[10px] font-black text-slate-400 uppercase tracking-widest ml-1">Stock Reservoir Level</label>
                            <input type="number" name="stock" required value="{{ old('stock', $product->stock) }}" 
                                   class="w-full h-16 bg-slate-50 border-none rounded-2xl px-6 text-sm font-black text-slate-800 focus:ring-2 focus:ring-sky-500/20 transition-all">
                        </div>
                        <div class="space-y-2 md:col-span-2">
                            <label class="text-[10px] font-black text-slate-400 uppercase tracking-widest ml-1">Visibility Protocol</label>
                            <select name="status" class="w-full h-16 bg-slate-50 border-none rounded-2xl px-6 text-sm font-black text-slate-800 focus:ring-2 focus:ring-sky-500/20 transition-all">
                                <option value="active" {{ $product->status == 'active' ? 'selected' : '' }}>Public / Active</option>
                                <option value="inactive" {{ $product->status == 'inactive' ? 'selected' : '' }}>Private / Offline</option>
                            </select>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Right: Assets -->
            <div class="space-y-10">
                <div class="bg-white rounded-[2.5rem] p-10 border border-slate-100 shadow-sm text-center">
                    <div class="flex items-center gap-4 mb-8 text-left">
                        <span class="w-10 h-10 rounded-xl bg-purple-50 flex items-center justify-center text-lg">🖼️</span>
                        <h3 class="text-sm font-black text-slate-800 uppercase tracking-widest">Master Visual</h3>
                    </div>
                    
                    <div class="relative group cursor-pointer">
                        <input type="file" name="image" id="product_image" class="hidden" onchange="previewImage(this)">
                        <div onclick="document.getElementById('product_image').click()" 
                             id="image_preview_container"
                             class="w-full aspect-square bg-slate-50 rounded-[2rem] border-2 border-slate-200 flex flex-col items-center justify-center shadow-inner group-hover:border-sky-500 transition-all overflow-hidden relative">
                            @if($product->image)
                                <img src="{{ asset('storage/' . $product->image) }}" class="w-full h-full object-cover">
                                <div class="absolute inset-0 bg-black/40 opacity-0 group-hover:opacity-100 transition-opacity flex items-center justify-center">
                                    <span class="text-white font-black text-[10px] uppercase tracking-widest">Update Visual</span>
                                </div>
                            @else
                                <span class="text-4xl">📸</span>
                                <p class="text-[10px] font-black text-slate-300 uppercase tracking-widest">Upload Master Visual</p>
                            @endif
                        </div>
                    </div>
                </div>

                <div class="bg-slate-900 rounded-[2.5rem] p-10 text-center">
                    <div class="w-16 h-16 bg-white/5 border border-white/10 rounded-2xl flex items-center justify-center text-2xl mx-auto mb-6">💾</div>
                    <h4 class="text-xs font-black text-white uppercase tracking-widest mb-2">Sync Changes</h4>
                    <p class="text-[10px] text-slate-500 font-bold leading-relaxed mb-8">Re-validating inventory vectors will update all live marketplace listings immediately.</p>
                    
                    <button type="submit" class="w-full py-5 bg-sky-500 text-white rounded-2xl font-black text-[10px] uppercase tracking-[0.3em] shadow-2xl shadow-sky-500/40 hover:bg-sky-400 transition-all hover:scale-[1.02] active:scale-95">
                        Commit Configuration
                    </button>
                    <a href="{{ route('merchant.products.index') }}" class="block mt-4 text-[10px] font-black text-slate-500 uppercase tracking-widest hover:text-white transition-colors">Abort Terminal</a>
                </div>
            </div>
        </div>
    </form>
</div>

<script>
function previewImage(input) {
    if (input.files && input.files[0]) {
        var reader = new FileReader();
        reader.onload = function(e) {
            const container = document.getElementById('image_preview_container');
            container.innerHTML = `<img src="${e.target.result}" class="w-full h-full object-cover">`;
        }
        reader.readAsDataURL(input.files[0]);
    }
}
</script>
@endsection
