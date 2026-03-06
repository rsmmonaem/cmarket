@extends('layouts.admin')

@section('title', 'POS - EcomMatrix')
@section('page-title', 'Point of Sale Terminal')

@section('content')
<div class="h-[calc(100vh-100px)] flex flex-col lg:flex-row gap-6 animate-fade-in" x-data="posSystem()">
    <!-- Left Workspace: Product Matrix -->
    <div class="flex-1 flex flex-col h-full space-y-6">
        <!-- Search & Filter Node -->
        <div class="card-premium p-6 space-y-6 bg-white dark:bg-slate-900 border-slate-100 dark:border-slate-800">
            <div class="flex flex-col md:flex-row gap-4">
                <div class="flex-1 relative group">
                    <span class="absolute left-4 top-1/2 -translate-y-1/2 text-slate-400 group-focus-within:text-primary transition-colors">🔍</span>
                    <input type="text" x-model="search" @input.debounce.300ms="fetchProducts()" placeholder="Scan barcode or search assets..." 
                           class="w-full pl-12 pr-6 py-4 bg-slate-50 dark:bg-slate-800 border-none rounded-2xl focus:ring-4 focus:ring-primary/10 font-bold text-slate-700 dark:text-white placeholder:text-slate-400">
                </div>
            </div>

            <!-- Category Ribbon -->
            <div class="relative">
                <div class="flex items-center gap-3 overflow-x-auto pb-2 scrollbar-none scroll-smooth" id="categorySlider">
                    <button @click="category = null; fetchProducts()" 
                            :class="category === null ? 'bg-primary text-white shadow-lg shadow-primary/20 scale-105' : 'bg-slate-50 dark:bg-slate-800 text-slate-500 hover:bg-slate-100 dark:hover:bg-slate-700'"
                            class="px-6 py-3 rounded-xl text-[10px] font-black uppercase tracking-widest whitespace-nowrap transition-all duration-300">
                        All Assets
                    </button>
                    @foreach($categories as $cat)
                        <button @click="category = {{ $cat->id }}; fetchProducts()" 
                                :class="category === {{ $cat->id }} ? 'bg-primary text-white shadow-lg shadow-primary/20 scale-105' : 'bg-slate-50 dark:bg-slate-800 text-slate-500 hover:bg-slate-100 dark:hover:bg-slate-700'"
                                class="px-6 py-3 rounded-xl text-[10px] font-black uppercase tracking-widest whitespace-nowrap transition-all duration-300">
                            {{ $cat->name }}
                        </button>
                    @endforeach
                </div>
            </div>
        </div>

        <!-- Product Grid Node -->
        <div class="flex-1 overflow-y-auto pr-2 custom-scrollbar" id="productGridContainer">
            @include('admin.pos.partials.product-grid', ['products' => $products])
        </div>
    </div>

    <!-- Right Workspace: Cart Logic & Execution -->
    <div class="w-full lg:w-[420px] h-full flex flex-col space-y-6">
        <!-- Customer Node -->
        <div class="card-premium p-6 bg-[#0f172a] text-white border-none shadow-2xl relative overflow-hidden group">
            <div class="relative z-10 space-y-4">
                <div class="flex items-center justify-between">
                    <label class="text-[10px] font-black uppercase tracking-widest text-slate-400">Target Customer</label>
                    <button class="w-6 h-6 bg-primary/20 text-primary rounded-lg flex items-center justify-center hover:bg-primary hover:text-white transition-all">
                        <span class="text-lg">+</span>
                    </button>
                </div>
                <select x-model="customerId" class="w-full px-5 py-4 bg-slate-800/50 border border-slate-700 rounded-2xl text-[11px] font-black text-white uppercase tracking-widest focus:ring-4 focus:ring-primary/20 transition-all shadow-sm">
                    <option value="">Walk-in Customer</option>
                    @foreach($customers as $customer)
                        <option value="{{ $customer->id }}">{{ $customer->name }} ({{ $customer->phone ?? 'No Phone' }})</option>
                    @endforeach
                </select>
            </div>
            <div class="absolute -right-4 -bottom-4 opacity-10 text-6xl italic font-black select-none">NODE</div>
        </div>

        <!-- Cart Summary Node -->
        <div class="card-premium flex-1 flex flex-col p-6 bg-white dark:bg-slate-900 border-slate-100 dark:border-slate-800 overflow-hidden shadow-2xl">
            <div class="flex items-center justify-between mb-6">
                <h3 class="text-sm font-black text-slate-800 dark:text-white uppercase tracking-widest">Protocol Cart</h3>
                <span class="px-2 py-1 bg-slate-50 dark:bg-slate-800 rounded font-black text-[10px] text-primary" x-text="cart.length + ' Items'"></span>
            </div>

            <!-- Scrollable Cart List -->
            <div class="flex-1 overflow-y-auto space-y-4 pr-2 custom-scrollbar">
                <template x-if="cart.length === 0">
                    <div class="h-full flex flex-col items-center justify-center text-slate-300 space-y-4 opacity-50">
                        <span class="text-6xl">🛒</span>
                        <p class="text-[10px] font-black uppercase tracking-widest">Cart is empty</p>
                    </div>
                </template>

                <template x-for="(item, index) in cart" :key="item.id">
                    <div class="flex items-center gap-4 p-3 bg-slate-50 dark:bg-slate-800 rounded-2xl group relative border border-transparent hover:border-primary/10 transition-all">
                        <div class="w-12 h-12 rounded-xl bg-white dark:bg-slate-700 overflow-hidden shadow-sm">
                            <img :src="item.image" class="w-full h-full object-cover">
                        </div>
                        <div class="flex-1 min-w-0">
                            <div class="text-[11px] font-bold text-slate-800 dark:text-white truncate" x-text="item.name"></div>
                            <div class="text-[10px] font-black text-primary" x-text="'৳' + item.price.toLocaleString()"></div>
                        </div>
                        <div class="flex items-center gap-2 bg-white dark:bg-slate-900 px-3 py-1.5 rounded-xl shadow-sm">
                            <button @click="updateQty(index, -1)" class="text-slate-400 hover:text-rose-500 transition-colors font-black">−</button>
                            <span class="text-[11px] font-black text-slate-700 dark:text-white min-w-[20px] text-center" x-text="item.qty"></span>
                            <button @click="updateQty(index, 1)" class="text-slate-400 hover:text-emerald-500 transition-colors font-black">+</button>
                        </div>
                        <button @click="removeFromCart(index)" class="absolute -top-1 -right-1 w-5 h-5 bg-rose-500 text-white rounded-lg flex items-center justify-center text-[10px] opacity-0 group-hover:opacity-100 transition-all shadow-lg translate-y-1 group-hover:translate-y-0">
                            ×
                        </button>
                    </div>
                </template>
            </div>

            <!-- Financial Matrix -->
            <div class="mt-6 pt-6 border-t border-slate-100 dark:border-slate-800 space-y-3">
                <div class="flex justify-between text-[11px] font-bold text-slate-500 uppercase tracking-widest">
                    <span>Subtotal</span>
                    <span class="text-slate-800 dark:text-white" x-text="'৳' + subtotal().toLocaleString()"></span>
                </div>
                <div class="flex justify-between text-[11px] font-bold text-slate-500 uppercase tracking-widest">
                    <span>Tax (0%)</span>
                    <span class="text-slate-800 dark:text-white">৳0</span>
                </div>
                <div class="flex justify-between items-end pt-3 text-lg font-black text-slate-900 dark:text-white tracking-tighter">
                    <span class="text-[10px] uppercase tracking-[0.2em] mb-1.5">Grand Total</span>
                    <span class="text-2xl" x-text="'৳' + subtotal().toLocaleString()"></span>
                </div>
            </div>

            <!-- Execution Button -->
            <button @click="checkout()" 
                    :disabled="cart.length === 0"
                    class="mt-8 w-full btn-matrix btn-primary-matrix py-5 text-[11px] tracking-[0.2em] disabled:opacity-50 disabled:grayscale">
                EXECUTE TRANSACTION
            </button>
        </div>
    </div>
</div>

@push('scripts')
<script>
    function posSystem() {
        return {
            search: '',
            category: null,
            customerId: '',
            cart: [],
            
            fetchProducts() {
                const container = document.getElementById('productGridContainer');
                container.style.opacity = '0.5';
                
                let url = new URL(window.location.href);
                url.searchParams.set('search', this.search);
                if (this.category) url.searchParams.set('category', this.category);
                else url.searchParams.delete('category');

                fetch(url, {
                    headers: { 'X-Requested-With': 'XMLHttpRequest' }
                })
                .then(res => res.text())
                .then(html => {
                    container.innerHTML = html;
                    container.style.opacity = '1';
                });
            },

            addToCart(product) {
                const existing = this.cart.findIndex(item => item.id === product.id);
                if (existing !== -1) {
                    if (this.cart[existing].qty < product.stock) {
                        this.cart[existing].qty++;
                    } else {
                        alert('Asset inventory depleted (Out of stock)');
                    }
                } else {
                    this.cart.push({ ...product, qty: 1 });
                }
            },

            removeFromCart(index) {
                this.cart.splice(index, 1);
            },

            updateQty(index, delta) {
                const newQty = this.cart[index].qty + delta;
                if (newQty > 0) {
                    if (delta > 0 && this.cart[index].qty >= this.cart[index].stock) {
                        alert('Inventory limit reached');
                        return;
                    }
                    this.cart[index].qty = newQty;
                } else {
                    this.removeFromCart(index);
                }
            },

            subtotal() {
                return this.cart.reduce((sum, item) => sum + (item.price * item.qty), 0);
            },

            checkout() {
                if (this.cart.length === 0) return;
                
                Swal.fire({
                    title: 'FINALIZE TRANSACTION?',
                    text: 'Deploying protocol for ' + this.cart.length + ' assets.',
                    icon: 'question',
                    showCancelButton: true,
                    confirmButtonText: 'CONFIRM EXECUTION',
                    cancelButtonText: 'ABORT',
                    confirmButtonColor: '#2563eb',
                    background: '#ffffff',
                    customClass: {
                        popup: 'rounded-[2rem] border-none shadow-2xl',
                        confirmButton: 'rounded-xl font-black uppercase tracking-widest text-[10px] px-8 py-3',
                        cancelButton: 'rounded-xl font-black uppercase tracking-widest text-[10px] px-8 py-3'
                    }
                }).then((result) => {
                    if (result.isConfirmed) {
                        // Here we would typically send via AJAX to a store route
                        Swal.fire({
                            title: 'TRANSACTION PROTOCOL COMPLETE',
                            text: 'Order matrix initialized successfully.',
                            icon: 'success',
                            confirmButtonColor: '#2563eb'
                        });
                        this.cart = [];
                    }
                });
            }
        }
    }
</script>
@endpush

<style>
    .custom-scrollbar::-webkit-scrollbar {
        width: 4px;
    }
    .custom-scrollbar::-webkit-scrollbar-track {
        background: transparent;
    }
    .custom-scrollbar::-webkit-scrollbar-thumb {
        background: rgba(37, 99, 235, 0.1);
        border-radius: 20px;
    }
    .custom-scrollbar:hover::-webkit-scrollbar-thumb {
        background: rgba(37, 99, 235, 0.3);
    }
    .scrollbar-none::-webkit-scrollbar {
        display: none;
    }
</style>
@endsection
