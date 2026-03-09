@extends('layouts.admin')

@section('page-title', 'Create Product')

@section('content')
<div class="px-6 py-8 w-full max-w-5xl mx-auto" x-data="productForm()">
    
    <div class="mb-8">
        <h1 class="text-2xl font-bold text-slate-800">Add New Product</h1>
        <p class="text-slate-500 mt-1">Configure product details, categories, variations, and media.</p>
    </div>

    @if($errors->any())
        <div class="bg-rose-50 border border-rose-200 text-rose-700 px-4 py-3 rounded-xl mb-6 flex flex-col gap-1">
            <span class="font-bold text-sm">Please fix the following errors:</span>
            <ul class="list-disc pl-5 text-xs">
                @foreach($errors->all() as $err)
                    <li>{{ $err }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('admin.products.store') }}" method="POST" enctype="multipart/form-data" class="space-y-8 pb-32">
        @csrf

        {{-- Basic Info --}}
        <div class="bg-white rounded-2xl border border-slate-100 shadow-sm p-6 space-y-5">
            <h2 class="text-sm font-black text-slate-800 uppercase tracking-widest border-b border-slate-100 pb-3 mb-5">Basic Information</h2>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                <div>
                    <label class="block text-xs font-bold text-slate-700 mb-1.5">Product Type <span class="text-rose-500">*</span></label>
                    <select name="type" required class="w-full px-4 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-sm focus:ring-2 focus:ring-primary/20 focus:border-primary outline-none transition-all">
                        <option value="product">Physical Product</option>
                        <option value="package">Digital / Package</option>
                    </select>
                </div>
                <div>
                    <label class="block text-xs font-bold text-slate-700 mb-1.5">Merchant</label>
                    <select name="merchant_id" class="w-full px-4 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-sm focus:ring-2 focus:ring-primary/20 focus:border-primary outline-none transition-all">
                        <option value="">In-house (System Product)</option>
                        @foreach($merchants as $merchant)
                            <option value="{{ $merchant->id }}" {{ old('merchant_id') == $merchant->id ? 'selected' : '' }}>{{ $merchant->business_name }}</option>
                        @endforeach
                    </select>
                </div>
            </div>

            <div>
                <label class="block text-xs font-bold text-slate-700 mb-1.5">Product Name <span class="text-rose-500">*</span></label>
                <input type="text" name="name" value="{{ old('name') }}" required placeholder="e.g., Premium Cotton T-Shirt"
                       class="w-full px-4 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-sm focus:ring-2 focus:ring-primary/20 focus:border-primary outline-none transition-all">
            </div>

            <div>
                <label class="block text-xs font-bold text-slate-700 mb-1.5">Description <span class="text-rose-500">*</span></label>
                <textarea name="description" rows="4" required placeholder="Detailed description..."
                          class="w-full px-4 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-sm focus:ring-2 focus:ring-primary/20 focus:border-primary outline-none transition-all">{{ old('description') }}</textarea>
            </div>
        </div>

        {{-- Categories --}}
        <div class="bg-white rounded-2xl border border-slate-100 shadow-sm p-6">
            <h2 class="text-sm font-black text-slate-800 uppercase tracking-widest border-b border-slate-100 pb-3 mb-5">Category Hierarchy</h2>
            
            <input type="hidden" name="category_id" :value="selectedFinalCategory" required>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-5">
                {{-- L1 --}}
                <div>
                    <label class="block text-xs font-bold text-slate-700 mb-1.5">Root Category <span class="text-rose-500">*</span></label>
                    <select x-model="l1" @change="updateL2()" required class="w-full px-4 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-sm">
                        <option value="">Select Root Category</option>
                        <template x-for="cat in categories" :key="cat.id">
                            <option :value="cat.id" x-text="cat.name"></option>
                        </template>
                    </select>
                </div>
                {{-- L2 --}}
                <div>
                    <label class="block text-xs font-bold text-slate-700 mb-1.5">Subcategory</label>
                    <select x-model="l2" @change="updateL3()" :disabled="!l2Options.length" class="w-full px-4 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-sm disabled:opacity-50">
                        <option value="">Select Subcategory</option>
                        <template x-for="cat in l2Options" :key="cat.id">
                            <option :value="cat.id" x-text="cat.name"></option>
                        </template>
                    </select>
                </div>
                {{-- L3 --}}
                <div>
                    <label class="block text-xs font-bold text-slate-700 mb-1.5">Sub-Subcategory</label>
                    <select x-model="l3" @change="updateParams()" :disabled="!l3Options.length" class="w-full px-4 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-sm disabled:opacity-50">
                        <option value="">Select Sub-Subcategory</option>
                        <template x-for="cat in l3Options" :key="cat.id">
                            <option :value="cat.id" x-text="cat.name"></option>
                        </template>
                    </select>
                </div>
            </div>
            <p class="text-[11px] text-slate-400 mt-3 font-medium">The product will be attached to: <span class="text-primary font-bold" x-text="selectedChainText"></span></p>
        </div>

        {{-- Base Pricing & Inventory --}}
        <div class="bg-white rounded-2xl border border-slate-100 shadow-sm p-6">
            <h2 class="text-sm font-black text-slate-800 uppercase tracking-widest border-b border-slate-100 pb-3 mb-5">Pricing & Base Inventory</h2>
            
            <div class="grid grid-cols-1 md:grid-cols-4 gap-5">
                <div>
                    <label class="block text-xs font-bold text-slate-700 mb-1.5">Regular Price (৳) <span class="text-rose-500">*</span></label>
                    <input type="number" step="0.01" name="price" value="{{ old('price') }}" required placeholder="0.00"
                           class="w-full px-4 py-2 bg-slate-50 border border-slate-200 rounded-xl text-sm">
                </div>
                <div>
                    <label class="block text-xs font-bold text-slate-700 mb-1.5">Discount Price (৳)</label>
                    <input type="number" step="0.01" name="discount_price" value="{{ old('discount_price') }}" placeholder="0.00"
                           class="w-full px-4 py-2 bg-slate-50 border border-slate-200 rounded-xl text-sm">
                </div>
                <div>
                    <label class="block text-xs font-bold text-slate-700 mb-1.5">Base Stock <span class="text-slate-400 font-normal">(if no variations)</span></label>
                    <input type="number" name="stock" value="{{ old('stock', 0) }}" required placeholder="0"
                           class="w-full px-4 py-2 bg-slate-50 border border-slate-200 rounded-xl text-sm">
                </div>
                <div>
                    <label class="block text-xs font-bold text-slate-700 mb-1.5">SKU</label>
                    <input type="text" name="sku" value="{{ old('sku') }}" placeholder="e.g., TS-RED-XL"
                           class="w-full px-4 py-2 bg-slate-50 border border-slate-200 rounded-xl text-sm">
                </div>
            </div>
        </div>

        {{-- Variations --}}
        <div class="bg-white rounded-2xl border border-slate-100 shadow-sm p-6">
            <div class="flex items-center justify-between border-b border-slate-100 pb-3 mb-5">
                <h2 class="text-sm font-black text-slate-800 uppercase tracking-widest">Variations System</h2>
                <label class="flex items-center gap-2 cursor-pointer">
                    <input type="checkbox" x-model="hasVariations" class="rounded text-primary focus:ring-primary/20 accent-primary w-4 h-4">
                    <span class="text-xs font-bold text-slate-700">Enable Variations</span>
                </label>
            </div>

            <div x-show="hasVariations" class="space-y-6" x-collapse>
                
                {{-- Dynamic Attributes (e.g. Color, Size) --}}
                <div class="bg-slate-50 p-4 rounded-xl border border-slate-100 space-y-4">
                    <div class="flex items-center justify-between">
                        <span class="text-xs font-bold text-slate-700">1. Define Attributes</span>
                        <button type="button" @click="addAttribute()" class="text-[10px] font-bold bg-white border border-slate-200 px-3 py-1.5 rounded-lg hover:border-primary text-slate-600 hover:text-primary transition-colors">+ Add Attribute (e.g., Size)</button>
                    </div>

                    <div class="space-y-3">
                        <template x-for="(attr, aIndex) in attributes" :key="aIndex">
                            <div class="flex gap-3 items-start">
                                <div class="w-1/3">
                                    <input type="text" x-model="attr.name" @input="generateVariations()" placeholder="e.g. Color" class="w-full px-3 py-2 bg-white border border-slate-200 rounded-lg text-xs font-bold">
                                </div>
                                <div class="flex-1">
                                    <input type="text" x-model="attr.values" @input="generateVariations()" placeholder="Comma separated (e.g. Red, Blue, Green)" class="w-full px-3 py-2 bg-white border border-slate-200 rounded-lg text-xs">
                                </div>
                                <button type="button" @click="removeAttribute(aIndex)" class="w-8 h-8 flex items-center justify-center text-rose-400 hover:text-white hover:bg-rose-500 rounded-lg shrink-0 transition-colors">✕</button>
                            </div>
                        </template>
                    </div>
                </div>

                {{-- Generated Variations Matrix --}}
                <div x-show="variations.length > 0">
                    <span class="text-xs font-bold text-slate-700 block mb-3">2. Variation Matrix</span>
                    
                    <input type="hidden" name="attributes" :value="JSON.stringify(attributes)">
                    <input type="hidden" name="variations" :value="JSON.stringify(variations)">

                    <div class="border border-slate-200 rounded-xl overflow-hidden bg-white text-xs text-left">
                        <table class="w-full">
                            <thead class="bg-slate-50 border-b border-slate-200">
                                <tr>
                                    <th class="py-3 px-4 text-slate-500 font-bold uppercase tracking-wider w-[40%]">Variant</th>
                                    <th class="py-3 px-4 text-slate-500 font-bold uppercase tracking-wider w-[20%]">Price (৳)</th>
                                    <th class="py-3 px-4 text-slate-500 font-bold uppercase tracking-wider w-[20%]">Stock</th>
                                    <th class="py-3 px-4 text-slate-500 font-bold uppercase tracking-wider w-[20%]">SKU</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-slate-100">
                                <template x-for="(v, vIndex) in variations" :key="v.name">
                                    <tr class="hover:bg-slate-50/50">
                                        <td class="py-2 px-4 font-semibold text-slate-700" x-text="v.name"></td>
                                        <td class="py-2 px-4">
                                            <input type="number" step="0.01" x-model="v.price" class="w-full bg-white border border-slate-200 rounded-md px-2 py-1 outline-none focus:border-primary">
                                        </td>
                                        <td class="py-2 px-4">
                                            <input type="number" x-model="v.stock" class="w-full bg-white border border-slate-200 rounded-md px-2 py-1 outline-none focus:border-primary">
                                        </td>
                                        <td class="py-2 px-4">
                                            <input type="text" x-model="v.sku" class="w-full bg-white border border-slate-200 rounded-md px-2 py-1 outline-none focus:border-primary">
                                        </td>
                                    </tr>
                                </template>
                            </tbody>
                        </table>
                    </div>
                </div>

            </div>
        </div>

        {{-- Promotion & Perks --}}
        <div class="bg-white rounded-2xl border border-slate-100 shadow-sm p-6 grid grid-cols-1 md:grid-cols-2 gap-8">
            <div>
                <h2 class="text-sm font-black text-slate-800 uppercase tracking-widest border-b border-slate-100 pb-3 mb-5">Visibility & Deals</h2>
                
                <div class="space-y-4">
                    <label class="flex items-center p-4 bg-slate-50 border border-slate-100 rounded-xl cursor-pointer hover:border-primary/30 transition-colors">
                        <input type="checkbox" name="is_featured" value="1" class="rounded focus:ring-primary/20 accent-primary w-4 h-4">
                        <div class="ml-3">
                            <span class="block text-sm font-bold text-slate-700">Featured Product</span>
                            <span class="block text-[10px] text-slate-400">Display prominently on home sections.</span>
                        </div>
                    </label>

                    <div x-data="{ flash: false }" class="bg-rose-50/30 border border-rose-100 rounded-xl p-4 transition-all">
                        <label class="flex items-center cursor-pointer mb-3">
                            <input type="checkbox" name="is_flash_deal" value="1" x-model="flash" class="rounded focus:ring-rose-500/20 accent-rose-500 w-4 h-4">
                            <span class="ml-3 text-sm font-bold text-rose-700">Add to Flash Deal</span>
                        </label>
                        <div x-show="flash" x-collapse class="grid grid-cols-2 gap-3 pt-2">
                            <div>
                                <label class="block text-[10px] font-bold text-slate-500 mb-1">Starts At</label>
                                <input type="datetime-local" name="flash_deal_start" class="w-full px-3 py-1.5 bg-white border border-rose-200 rounded-lg text-xs outline-none focus:border-rose-400">
                            </div>
                            <div>
                                <label class="block text-[10px] font-bold text-slate-500 mb-1">Ends At</label>
                                <input type="datetime-local" name="flash_deal_end" class="w-full px-3 py-1.5 bg-white border border-rose-200 rounded-lg text-xs outline-none focus:border-rose-400">
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div>
                <h2 class="text-sm font-black text-slate-800 uppercase tracking-widest border-b border-slate-100 pb-3 mb-5">Perks & Cashback</h2>
                <div>
                    <label class="block text-xs font-bold text-slate-700 mb-1.5">Cashback Percentage (%)</label>
                    <input type="number" step="0.01" name="cashback_percentage" value="{{ old('cashback_percentage', 0) }}" placeholder="e.g. 5"
                           class="w-full px-4 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-sm focus:ring-primary/20 focus:border-primary transition-all">
                    <p class="text-[10px] text-slate-400 mt-1.5">Amount credited to buyer's cashback wallet upon delivery.</p>
                </div>
            </div>
        </div>

        {{-- Media --}}
        <div class="bg-white rounded-2xl border border-slate-100 shadow-sm p-6">
            <h2 class="text-sm font-black text-slate-800 uppercase tracking-widest border-b border-slate-100 pb-3 mb-5">Digital Media / Assets</h2>
            
            <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                <div>
                    <label class="block text-xs font-bold text-slate-700 mb-1.5">Main Thumbnail <span class="text-rose-500">*</span></label>
                    <div class="w-full h-32 bg-slate-50 border-2 border-dashed border-slate-200 rounded-xl flex items-center justify-center relative hover:bg-slate-100 transition-colors">
                        <span class="text-xs font-semibold text-slate-400">Upload 1 Cover Image</span>
                        <input type="file" name="thumbnail" accept="image/*" required class="absolute inset-0 opacity-0 cursor-pointer">
                    </div>
                </div>
                <div>
                    <label class="block text-xs font-bold text-slate-700 mb-1.5">Gallery / Multiple Images</label>
                    <div class="w-full h-32 bg-slate-50 border-2 border-dashed border-slate-200 rounded-xl flex items-center justify-center relative hover:bg-slate-100 transition-colors">
                        <span class="text-xs font-semibold text-slate-400">Upload multiple images</span>
                        <input type="file" name="product_images[]" multiple accept="image/*" class="absolute inset-0 opacity-0 cursor-pointer">
                    </div>
                    <p class="text-[9px] text-slate-400 mt-1.5">* You can select multiple images at once.</p>
                </div>
            </div>
        </div>

        <div class="bg-white rounded-2xl border border-slate-100 shadow-sm p-6 flex items-center justify-between">
            <select name="status" class="px-4 py-3 bg-slate-50 border border-slate-200 rounded-xl text-sm font-bold text-slate-700 outline-none">
                <option value="active">Publish immediately (Active)</option>
                <option value="draft">Save as Draft</option>
                <option value="inactive">Hidden (Inactive)</option>
            </select>
            
            <button type="submit" class="px-8 py-4 bg-slate-900 text-white rounded-xl font-black text-[11px] uppercase tracking-widest hover:bg-primary transition-colors hover:shadow-xl hover:shadow-primary/20">
                Create Product ➔
            </button>
        </div>

    </form>
</div>

<script>
document.addEventListener('alpine:init', () => {
    Alpine.data('productForm', () => ({
        // Categories
        categories: @json($categories),
        l1: '',
        l2: '',
        l3: '',
        
        get l2Options() {
            if (!this.l1) return [];
            let cat = this.categories.find(c => c.id == this.l1);
            return cat && cat.children ? cat.children : [];
        },
        
        get l3Options() {
            if (!this.l2) return [];
            let options = this.l2Options;
            let cat = options.find(c => c.id == this.l2);
            return cat && cat.children ? cat.children : [];
        },

        get selectedFinalCategory() {
            if (this.l3) return this.l3;
            if (this.l2) return this.l2;
            if (this.l1) return this.l1;
            return '';
        },

        get selectedChainText() {
            if (!this.l1) return 'None';
            let root = this.categories.find(c => c.id == this.l1).name;
            let sub = this.l2 ? this.l2Options.find(c => c.id == this.l2)?.name : null;
            let subsub = this.l3 ? this.l3Options.find(c => c.id == this.l3)?.name : null;
            let arr = [root];
            if(sub) arr.push(sub);
            if(subsub) arr.push(subsub);
            return arr.join(' → ');
        },

        updateL2() { this.l2 = ''; this.l3 = ''; },
        updateL3() { this.l3 = ''; },
        updateParams() {},

        // Variations
        hasVariations: false,
        attributes: [
            // {name: 'Color', values: 'Red, Blue'}
        ],
        variations: [],

        addAttribute() {
            this.attributes.push({name: '', values: ''});
        },
        removeAttribute(index) {
            this.attributes.splice(index, 1);
            this.generateVariations();
        },
        
        generateVariations() {
            // Calculate cartesian product of all attributes' values
            let validAttrs = this.attributes.filter(a => a.name.trim() && a.values.trim());
            if(validAttrs.length === 0) {
                this.variations = [];
                return;
            }

            let arrays = validAttrs.map(a => a.values.split(',').map(v => v.trim()).filter(v => v));
            
            // Cartesian Product
            let combos = arrays.reduce((a, b) => a.reduce((r, v) => r.concat(b.map(w => [].concat(v, w))), []));
            if(!arrays.length || combos.length === 0) {
                this.variations = [];
                return;
            }

            // If only 1 attribute array, combos needs to be mapped to arrays first to normalize
            if (arrays.length === 1) combos = combos.map(c => [c]);

            let newVars = combos.map(combo => ({
                name: combo.join(' - '),
                price: document.querySelector('input[name="price"]').value || 0,
                stock: 0,
                sku: ''
            }));

            // Try to match existing pricing/stock so user doesnt lose data if they just add another comma
            this.variations = newVars.map(nv => {
                let existing = this.variations.find(ev => ev.name === nv.name);
                return existing ? existing : nv;
            });
        }
    }));
});
</script>
@endsection
