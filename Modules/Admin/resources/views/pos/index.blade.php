@extends('layouts.admin')

@section('title', 'POS Terminal - C-Market')
@section('page-title', 'POS Terminal')

@section('content')
<style>
    .pos-wrapper { margin: -1.5rem -2.5rem 0; }
    .slim-scroll::-webkit-scrollbar { width: 4px; }
    .slim-scroll::-webkit-scrollbar-thumb { background: #e2e8f0; border-radius: 10px; }
    .pos-product-card { cursor: pointer; transition: all .18s ease; }
    .pos-product-card:hover { transform: translateY(-2px); box-shadow: 0 8px 20px rgba(0,0,0,.10); }
    .pos-product-card:active { transform: scale(.97); }
    input[type=number]::-webkit-inner-spin-button { opacity: 1; }
</style>

<div class="pos-wrapper" x-data="posSystem()">

    {{-- Top Quick-Action Bar --}}
    <div class="flex items-center justify-between px-5 py-2.5 bg-white border-b border-slate-200 shadow-sm">
        <div class="flex items-center gap-4">
            <span class="text-sm font-bold text-slate-700">Quick Action</span>
            <div class="flex items-center gap-2">
                <a href="#" class="flex items-center gap-1.5 px-3 py-1.5 bg-emerald-50 text-emerald-600 rounded-lg text-[11px] font-bold hover:bg-emerald-100 transition-colors">🛒 Product List</a>
                <a href="{{ route('admin.orders.index') }}" class="flex items-center gap-1.5 px-3 py-1.5 bg-purple-50 text-purple-600 rounded-lg text-[11px] font-bold hover:bg-purple-100 transition-colors">📋 Today Sales</a>
                <a href="{{ route('admin.dashboard') }}" class="flex items-center gap-1.5 px-3 py-1.5 bg-red-50 text-red-500 rounded-lg text-[11px] font-bold hover:bg-red-100 transition-colors">🏠 Dashboard</a>
            </div>
        </div>
        <div class="text-xs font-semibold text-slate-400">{{ now()->format('d/m/Y H:i') }}</div>
    </div>

    {{-- Main Split --}}
    <div class="flex" style="height: calc(100vh - 145px);">

        {{-- ═══ LEFT: Order & Cart ═══ --}}
        <div class="flex flex-col bg-white border-r border-slate-200" style="width:56%;">

            {{-- Order Header --}}
            <div class="flex items-center gap-3 px-5 py-3 border-b border-slate-100 bg-slate-50">
                <div class="flex-1">
                    <label class="text-[10px] font-bold text-slate-400 uppercase tracking-widest">Order ID</label>
                    <input type="text" readonly :value="'S-' + String(orderId).padStart(5,'0')"
                           class="block w-full mt-0.5 px-3 py-2 bg-white border border-slate-200 rounded-lg text-sm font-bold text-slate-700">
                </div>
                <div class="flex-1">
                    <label class="text-[10px] font-bold text-slate-400 uppercase tracking-widest">Date</label>
                    <input type="date" :value="today"
                           class="block w-full mt-0.5 px-3 py-2 bg-white border border-slate-200 rounded-lg text-sm font-bold text-slate-700 focus:ring-2 focus:ring-primary/20 focus:outline-none">
                </div>
            </div>

            {{-- Customer Selector --}}
            <div class="flex items-center gap-2 px-5 py-3 border-b border-slate-100">
                <select x-model="customerId" class="flex-1 px-4 py-2.5 bg-white border border-slate-200 rounded-xl text-sm font-semibold text-slate-600 focus:outline-none focus:ring-2 focus:ring-primary/20">
                    <option value="">Select Customer (Walk-in)</option>
                    @foreach($customers as $customer)
                        <option value="{{ $customer->id }}">{{ $customer->name }} ({{ $customer->phone ?? 'No Phone' }})</option>
                    @endforeach
                </select>
                <button class="w-10 h-10 flex items-center justify-center bg-primary text-white rounded-xl text-xl font-bold shadow hover:bg-blue-700 transition-colors">+</button>
            </div>

            {{-- Cart Table --}}
            <div class="flex-1 overflow-y-auto slim-scroll">
                <table class="w-full text-left">
                    <thead class="sticky top-0 bg-white border-b border-slate-100 z-10">
                        <tr>
                            <th class="px-3 py-3 text-[10px] font-black uppercase tracking-wider text-slate-500 w-14">Image</th>
                            <th class="px-3 py-3 text-[10px] font-black uppercase tracking-wider text-slate-500">Items</th>
                            <th class="px-3 py-3 text-[10px] font-black uppercase tracking-wider text-slate-500">Code</th>
                            <th class="px-3 py-3 text-[10px] font-black uppercase tracking-wider text-slate-500">Unit</th>
                            <th class="px-3 py-3 text-[10px] font-black uppercase tracking-wider text-slate-500 text-right">Sale Price</th>
                            <th class="px-3 py-3 text-[10px] font-black uppercase tracking-wider text-slate-500 text-center w-28">Qty</th>
                            <th class="px-3 py-3 text-[10px] font-black uppercase tracking-wider text-slate-500 text-right">Sub Total</th>
                            <th class="px-3 py-3 text-[10px] font-black uppercase tracking-wider text-slate-500 text-center w-10">Del</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-50">
                        <template x-if="cart.length === 0">
                            <tr>
                                <td colspan="8" class="py-16 text-center">
                                    <div class="flex flex-col items-center gap-3 text-slate-300">
                                        <span class="text-5xl">🛒</span>
                                        <p class="text-sm font-bold">Cart is empty — click a product →</p>
                                    </div>
                                </td>
                            </tr>
                        </template>
                        <template x-for="(item, index) in cart" :key="item.id">
                            <tr class="hover:bg-slate-50/80 transition-colors group">
                                <td class="px-3 py-2">
                                    <div class="w-10 h-10 rounded-lg overflow-hidden bg-slate-100">
                                        <img :src="item.image" class="w-full h-full object-cover" onerror="this.src='https://placehold.co/80x80?text=N'">
                                    </div>
                                </td>
                                <td class="px-3 py-2">
                                    <div class="text-xs font-bold text-slate-800 max-w-[120px] truncate" x-text="item.name"></div>
                                    <div class="text-[10px] text-slate-400" x-text="item.category"></div>
                                </td>
                                <td class="px-3 py-2 text-xs font-mono text-slate-400" x-text="item.sku || 'N/A'"></td>
                                <td class="px-3 py-2 text-xs text-slate-400">pcs</td>
                                <td class="px-3 py-2 text-xs font-bold text-slate-800 text-right" x-text="'৳' + item.price.toLocaleString()"></td>
                                <td class="px-3 py-2">
                                    <div class="flex items-center justify-center gap-1">
                                        <button @click="updateQty(index, -1)" class="w-6 h-6 flex items-center justify-center rounded bg-slate-100 hover:bg-rose-100 hover:text-rose-600 text-slate-500 font-bold transition-colors">−</button>
                                        <input type="number" :value="item.qty" @change="setQty(index, $event.target.value)" min="1"
                                               class="w-10 text-center text-xs font-bold border border-slate-200 rounded py-0.5 focus:outline-none focus:ring-1 focus:ring-primary">
                                        <button @click="updateQty(index, 1)" class="w-6 h-6 flex items-center justify-center rounded bg-slate-100 hover:bg-emerald-100 hover:text-emerald-600 text-slate-500 font-bold transition-colors">+</button>
                                    </div>
                                </td>
                                <td class="px-3 py-2 text-xs font-bold text-primary text-right" x-text="'৳' + (item.price * item.qty).toLocaleString()"></td>
                                <td class="px-3 py-2 text-center">
                                    <button @click="removeFromCart(index)" class="w-7 h-7 flex items-center justify-center rounded-lg bg-rose-50 hover:bg-rose-500 hover:text-white text-rose-400 transition-colors mx-auto">✕</button>
                                </td>
                            </tr>
                        </template>
                    </tbody>
                </table>
            </div>

            {{-- Payment Footer --}}
            <div class="border-t border-slate-200 bg-slate-50">
                <div class="grid grid-cols-2 divide-x divide-slate-200">

                    {{-- Left: Receive / Change / Due / Payment / Note --}}
                    <div class="p-4 space-y-2.5">
                        <div class="flex items-center gap-2">
                            <label class="text-[11px] font-bold text-slate-500 w-28 shrink-0">Receive Amount</label>
                            <input type="number" x-model="receivedAmount"
                                   class="flex-1 px-3 py-2 border border-slate-200 bg-white rounded-lg text-sm font-bold text-slate-700 focus:outline-none focus:ring-2 focus:ring-primary/20" placeholder="0">
                        </div>
                        <div class="flex items-center gap-2">
                            <label class="text-[11px] font-bold text-slate-500 w-28 shrink-0">Change Amount</label>
                            <input type="number" :value="changeAmt" readonly
                                   class="flex-1 px-3 py-2 border border-slate-100 bg-white rounded-lg text-sm font-bold text-emerald-600">
                        </div>
                        <div class="flex items-center gap-2">
                            <label class="text-[11px] font-bold text-slate-500 w-28 shrink-0">Due Amount</label>
                            <input type="number" :value="dueAmt" readonly
                                   class="flex-1 px-3 py-2 border border-slate-100 bg-white rounded-lg text-sm font-bold text-rose-500">
                        </div>
                        <div class="flex items-center gap-2">
                            <label class="text-[11px] font-bold text-slate-500 w-28 shrink-0">Payment Type</label>
                            <select x-model="paymentType" class="flex-1 px-3 py-2 border border-slate-200 bg-white rounded-lg text-sm font-semibold text-slate-600 focus:outline-none">
                                <option value="cash">Cash</option>
                                <option value="card">Card</option>
                                <option value="mobile_banking">Mobile Banking</option>
                            </select>
                        </div>
                        <div class="flex items-center gap-2">
                            <label class="text-[11px] font-bold text-slate-500 w-28 shrink-0">Note</label>
                            <input type="text" x-model="note" placeholder="Type note..."
                                   class="flex-1 px-3 py-2 border border-slate-200 bg-white rounded-lg text-sm font-semibold text-slate-600 focus:outline-none">
                        </div>
                    </div>

                    {{-- Right: Totals + Checkout --}}
                    <div class="p-4 flex flex-col justify-between">
                        <div class="space-y-2">
                            <div class="flex items-center justify-between text-sm">
                                <span class="font-semibold text-slate-600">Sub Total</span>
                                <span class="font-black text-slate-800" x-text="'৳' + subtotal().toLocaleString()"></span>
                            </div>
                            <div class="flex items-center justify-between text-sm">
                                <span class="font-semibold text-slate-600">Vat</span>
                                <div class="flex items-center gap-1.5">
                                    <select x-model="vatType" class="text-xs border border-slate-200 rounded px-2 py-1 focus:outline-none bg-white">
                                        <option value="none">Select</option>
                                        <option value="percent">%</option>
                                        <option value="flat">Flat</option>
                                    </select>
                                    <input type="number" x-model="vatAmt" class="w-16 text-xs border border-slate-200 bg-white rounded px-2 py-1 text-right focus:outline-none" placeholder="0.00">
                                </div>
                            </div>
                            <div class="flex items-center justify-between text-sm">
                                <span class="font-semibold text-slate-600">Discount</span>
                                <div class="flex items-center gap-1.5">
                                    <select x-model="discountType" class="text-xs border border-slate-200 rounded px-2 py-1 focus:outline-none bg-white">
                                        <option value="flat">Flat (৳)</option>
                                        <option value="percent">%</option>
                                    </select>
                                    <input type="number" x-model="discountAmt" class="w-16 text-xs border border-slate-200 bg-white rounded px-2 py-1 text-right focus:outline-none" placeholder="0">
                                </div>
                            </div>
                            <div class="flex items-center justify-between text-sm">
                                <span class="font-semibold text-slate-600">Shipping</span>
                                <input type="number" x-model="shipping" class="w-20 text-xs border border-slate-200 bg-white rounded px-2 py-1 text-right focus:outline-none" placeholder="0">
                            </div>
                            <div class="h-px bg-slate-200 my-1"></div>
                            <div class="flex items-center justify-between">
                                <span class="font-black text-slate-800 text-sm">Total</span>
                                <span class="font-black text-lg text-primary" x-text="'৳' + grandTotal().toLocaleString()"></span>
                            </div>
                        </div>
                        <button @click="checkout()" :disabled="cart.length === 0"
                                class="mt-3 w-full py-3.5 bg-primary hover:bg-blue-700 disabled:opacity-40 disabled:cursor-not-allowed text-white font-black text-sm uppercase tracking-widest rounded-xl shadow-lg shadow-primary/20 transition-all active:scale-[.98]">
                            ✔ Process Order
                        </button>
                    </div>
                </div>
            </div>
        </div>

        {{-- ═══ RIGHT: Products ═══ --}}
        <div class="flex-1 flex flex-col bg-slate-50">

            {{-- Search & Filter --}}
            <div class="px-4 py-3 bg-white border-b border-slate-200 flex items-center gap-3">
                <div class="flex-1 relative">
                    <span class="absolute left-3 top-1/2 -translate-y-1/2 text-slate-400 text-sm">🔍</span>
                    <input type="text" x-model="search" @input.debounce.300ms="fetchProducts()"
                           placeholder="Search product..."
                           class="w-full pl-9 pr-4 py-2.5 border border-slate-200 rounded-xl text-sm font-semibold text-slate-700 focus:outline-none focus:ring-2 focus:ring-primary/20 bg-white">
                </div>
                <button @click="filterPanel = !filterPanel"
                        class="px-5 py-2.5 bg-orange-500 hover:bg-orange-600 text-white text-xs font-black uppercase tracking-wider rounded-xl transition-colors">
                    Category
                </button>
                <button class="px-5 py-2.5 bg-blue-600 hover:bg-blue-700 text-white text-xs font-black uppercase tracking-wider rounded-xl transition-colors">
                    Brand
                </button>
            </div>

            {{-- Category Pills --}}
            <div x-show="filterPanel" x-cloak class="px-4 py-2 bg-white border-b border-slate-100 flex flex-wrap gap-2">
                <button @click="category = null; fetchProducts()"
                        :class="category === null ? 'bg-primary text-white' : 'bg-slate-100 text-slate-600 hover:bg-slate-200'"
                        class="px-3 py-1.5 rounded-lg text-[10px] font-black uppercase transition-colors">All</button>
                @foreach($categories as $cat)
                    <button @click="category = {{ $cat->id }}; fetchProducts()"
                            :class="category === {{ $cat->id }} ? 'bg-primary text-white' : 'bg-slate-100 text-slate-600 hover:bg-slate-200'"
                            class="px-3 py-1.5 rounded-lg text-[10px] font-black uppercase transition-colors">
                        {{ $cat->name }}
                    </button>
                @endforeach
            </div>

            {{-- Product Grid --}}
            <div class="flex-1 overflow-y-auto slim-scroll p-4" id="productGridContainer">
                @include('admin::pos.partials.product-grid', ['products' => $products])
            </div>
        </div>

    </div>{{-- end main split --}}
</div>{{-- end pos-wrapper --}}

<script>
function posSystem() {
    return {
        search: '',
        category: null,
        filterPanel: false,
        customerId: '',
        paymentType: 'cash',
        note: '',
        vatType: 'none',
        vatAmt: 0,
        discountType: 'flat',
        discountAmt: 0,
        shipping: 0,
        receivedAmount: 0,
        cart: [],
        orderId: Math.floor(Math.random() * 90000) + 10000,
        today: new Date().toISOString().split('T')[0],

        fetchProducts() {
            const c = document.getElementById('productGridContainer');
            c.style.opacity = '0.5';
            let url = new URL(window.location.href);
            url.searchParams.set('search', this.search);
            if (this.category) url.searchParams.set('category', this.category);
            else url.searchParams.delete('category');
            fetch(url, { headers: { 'X-Requested-With': 'XMLHttpRequest' } })
                .then(r => r.text())
                .then(html => { c.innerHTML = html; c.style.opacity = '1'; });
        },

        addToCart(product) {
            const i = this.cart.findIndex(x => x.id === product.id);
            if (i !== -1) {
                if (this.cart[i].qty < product.stock) { this.cart[i].qty++; }
                else { Swal.fire({ toast:true, position:'top-end', icon:'warning', title:'Out of stock!', showConfirmButton:false, timer:2000 }); }
            } else {
                this.cart.push({ ...product, qty: 1 });
            }
        },

        removeFromCart(i) { this.cart.splice(i, 1); },

        updateQty(i, d) {
            const n = this.cart[i].qty + d;
            if (n <= 0) { this.removeFromCart(i); return; }
            if (d > 0 && n > this.cart[i].stock) {
                Swal.fire({ toast:true, position:'top-end', icon:'warning', title:'Stock limit', showConfirmButton:false, timer:1500 });
                return;
            }
            this.cart[i].qty = n;
        },

        setQty(i, val) {
            const q = parseInt(val);
            if (!q || q <= 0) { this.removeFromCart(i); return; }
            this.cart[i].qty = Math.min(q, this.cart[i].stock);
        },

        subtotal() { return this.cart.reduce((s, x) => s + (x.price * x.qty), 0); },

        vatCalc() {
            if (this.vatType === 'percent') return (this.subtotal() * parseFloat(this.vatAmt||0)) / 100;
            if (this.vatType === 'flat') return parseFloat(this.vatAmt||0);
            return 0;
        },

        discountCalc() {
            if (this.discountType === 'percent') return (this.subtotal() * parseFloat(this.discountAmt||0)) / 100;
            return parseFloat(this.discountAmt||0);
        },

        grandTotal() {
            return Math.max(0, this.subtotal() + this.vatCalc() - this.discountCalc() + parseFloat(this.shipping||0));
        },

        get changeAmt() {
            const d = parseFloat(this.receivedAmount||0) - this.grandTotal();
            return d > 0 ? d.toFixed(2) : 0;
        },

        get dueAmt() {
            const d = this.grandTotal() - parseFloat(this.receivedAmount||0);
            return d > 0 ? d.toFixed(2) : 0;
        },

        checkout() {
            if (!this.cart.length) return;
            const total = this.grandTotal().toLocaleString();
            const payment = this.paymentType.replace('_',' ').toUpperCase();
            const items = this.cart.length;
            Swal.fire({
                title: 'Process Order?',
                icon: 'question',
                html: '<div style="text-align:left;font-size:13px">' +
                      '<div style="display:flex;justify-content:space-between;margin:4px 0"><span>Items:</span><strong>' + items + '</strong></div>' +
                      '<div style="display:flex;justify-content:space-between;margin:4px 0"><span>Total:</span><strong>BDT ' + total + '</strong></div>' +
                      '<div style="display:flex;justify-content:space-between;margin:4px 0"><span>Payment:</span><strong>' + payment + '</strong></div>' +
                      '</div>',
                showCancelButton: true,
                confirmButtonText: 'Confirm',
                cancelButtonText: 'Cancel',
                confirmButtonColor: '#2563eb',
                customClass: { popup: 'rounded-2xl', confirmButton: 'rounded-xl', cancelButton: 'rounded-xl' }
            }).then(r => {
                if (r.isConfirmed) {
                    Swal.fire({ icon:'success', title:'Order Placed!', text:'Transaction completed.', confirmButtonColor:'#2563eb', customClass:{ popup:'rounded-2xl' } });
                    this.cart = [];
                    this.receivedAmount = 0;
                    this.orderId = Math.floor(Math.random() * 90000) + 10000;
                }
            });
        }
    }
}
</script>

@endsection
