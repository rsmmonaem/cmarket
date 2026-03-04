@extends('layouts.customer')

@section('title', 'Deploy Inventory - CMarket')
@section('page-title', 'Inventory Deployment Terminal')

@section('content')
<div class="max-w-5xl mx-auto animate-fade-in pb-20">
    <form action="{{ route('merchant.products.store') }}" method="POST" enctype="multipart/form-data" class="space-y-10">
        @csrf
        
        <!-- Header Section -->
        <div class="bg-slate-900 rounded-[3rem] p-10 lg:p-14 text-white shadow-2xl shadow-slate-900/10 relative overflow-hidden group">
            <div class="relative z-10">
                <h2 class="text-4xl font-black mb-6 tracking-tight">New Inventory Unit</h2>
                <p class="text-slate-400 font-medium leading-relaxed max-w-2xl">Configure your product parameters for marketplace deployment. Detailed information increases conversion rates and partner trust.</p>
            </div>
            <div class="absolute -right-10 -bottom-10 opacity-5 text-[250px] leading-none select-none italic font-black group-hover:scale-110 transition-transform duration-1000">UNIT</div>
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
                            <input type="text" name="name" required placeholder="Ex: Premium Wireless Audio Matrix" 
                                   class="w-full h-16 bg-slate-50 border-none rounded-2xl px-6 text-sm font-black text-slate-800 placeholder:text-slate-300 focus:ring-2 focus:ring-sky-500/20 transition-all">
                        </div>

                        <div class="grid grid-cols-2 gap-6">
                            <div class="space-y-2">
                                <label class="text-[10px] font-black text-slate-400 uppercase tracking-widest ml-1">Category Classification</label>
                                <select name="category_id" required class="w-full h-16 bg-slate-50 border-none rounded-2xl px-6 text-sm font-black text-slate-800 focus:ring-2 focus:ring-sky-500/20 transition-all">
                                    <option value="">Select Category</option>
                                    @foreach($categories as $category)
                                        <option value="{{ $category->id }}">{{ $category->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="space-y-2">
                                <label class="text-[10px] font-black text-slate-400 uppercase tracking-widest ml-1">Inventory SKU</label>
                                <input type="text" name="sku" placeholder="SKU-XXXXX" 
                                       class="w-full h-16 bg-slate-50 border-none rounded-2xl px-6 text-sm font-black text-slate-800 placeholder:text-slate-300 focus:ring-2 focus:ring-sky-500/20 transition-all">
                            </div>
                        </div>

                        <div class="space-y-2">
                            <label class="text-[10px] font-black text-slate-400 uppercase tracking-widest ml-1">Technical Specifications & Description</label>
                            <textarea name="description" rows="6" placeholder="Describe the unit in detail..." 
                                      class="w-full bg-slate-50 border-none rounded-[2rem] p-8 text-sm font-medium text-slate-600 placeholder:text-slate-300 focus:ring-2 focus:ring-sky-500/20 transition-all"></textarea>
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
                            <input type="number" name="price" step="0.01" required placeholder="0.00" 
                                   class="w-full h-16 bg-slate-50 border-none rounded-2xl px-6 text-sm font-black text-slate-800 focus:ring-2 focus:ring-sky-500/20 transition-all">
                        </div>
                        <div class="space-y-2">
                            <label class="text-[10px] font-black text-slate-400 uppercase tracking-widest ml-1">Promotional Price (৳)</label>
                            <input type="number" name="discount_price" step="0.01" placeholder="Optional" 
                                   class="w-full h-16 bg-slate-50 border-none rounded-2xl px-6 text-sm font-black text-slate-800 focus:ring-2 focus:ring-sky-500/20 transition-all">
                        </div>
                        <div class="space-y-2">
                            <label class="text-[10px] font-black text-slate-400 uppercase tracking-widest ml-1">Cashback Vector (%)</label>
                            <input type="number" name="cashback_percentage" step="0.1" placeholder="0.0" 
                                   class="w-full h-16 bg-slate-50 border-none rounded-2xl px-6 text-sm font-black text-emerald-600 focus:ring-2 focus:ring-emerald-500/20 transition-all">
                        </div>
                        <div class="space-y-2">
                            <label class="text-[10px] font-black text-slate-400 uppercase tracking-widest ml-1">Initial Stock Quantity</label>
                            <input type="number" name="stock" required placeholder="0" 
                                   class="w-full h-16 bg-slate-50 border-none rounded-2xl px-6 text-sm font-black text-slate-800 focus:ring-2 focus:ring-sky-500/20 transition-all">
                        </div>
                    </div>
                </div>
            </div>

            <!-- Right: Assets -->
            <div class="space-y-10">
                <div class="bg-white rounded-[2.5rem] p-10 border border-slate-100 shadow-sm text-center">
                    <div class="flex items-center gap-4 mb-8 text-left">
                        <span class="w-10 h-10 rounded-xl bg-purple-50 flex items-center justify-center text-lg">🖼️</span>
                        <h3 class="text-sm font-black text-slate-800 uppercase tracking-widest">Visual Asset</h3>
                    </div>
                    
                    <div class="relative group cursor-pointer">
                        <input type="file" name="image" id="product_image" class="hidden" onchange="previewImage(this)">
                        <div onclick="document.getElementById('product_image').click()" 
                             id="image_preview_container"
                             class="w-full aspect-square bg-slate-50 rounded-[2rem] border-2 border-dashed border-slate-200 flex flex-col items-center justify-center gap-4 group-hover:border-sky-500 transition-all overflow-hidden">
                            <span class="text-4xl">📸</span>
                            <p class="text-[10px] font-black text-slate-300 uppercase tracking-widest">Upload Master Visual</p>
                        </div>
                    </div>
                    <p class="text-[9px] text-slate-400 mt-4 font-bold uppercase tracking-tighter">Recommended: 1080x1080px (MAX 2MB)</p>
                </div>

                <div class="bg-slate-50 rounded-[2.5rem] p-10 border border-slate-100 text-center">
                    <div class="w-16 h-16 bg-white rounded-2xl flex items-center justify-center text-2xl mx-auto mb-6 shadow-sm">🚀</div>
                    <h4 class="text-xs font-black text-slate-800 uppercase tracking-widest mb-2">Final Review</h4>
                    <p class="text-[10px] text-slate-400 font-bold leading-relaxed mb-8">Ensure all data sectors are validated. Once deployed, the unit will be immediately visible to the marketplace node.</p>
                    
                    <button type="submit" class="w-full py-5 bg-slate-900 text-white rounded-2xl font-black text-[10px] uppercase tracking-[0.3em] shadow-2xl shadow-slate-900/40 hover:bg-emerald-600 transition-all hover:scale-[1.02] active:scale-95">
                        Initialize Deployment
                    </button>
                    <a href="{{ route('merchant.products.index') }}" class="block mt-4 text-[10px] font-black text-slate-400 uppercase tracking-widest hover:text-rose-500 transition-colors">Cancel Terminal</a>
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
            container.classList.remove('border-dashed');
        }
        reader.readAsDataURL(input.files[0]);
    }
}
</script>
@endsection
