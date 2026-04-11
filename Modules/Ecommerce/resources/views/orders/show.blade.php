@extends(isset($is_tracking) && $is_tracking ? 'layouts.public' : 'layouts.customer')

@section('title', 'Order Details - #' . $order->order_number)
@if(!isset($is_tracking) || !$is_tracking)
    @section('page-title', 'Order details')
@endif

@section('content')
<div class="max-w-6xl mx-auto {{ isset($is_tracking) && $is_tracking ? 'py-16 px-6' : '' }}">
    
    <!-- Welcome / Success Banner -->
    @if(session('success'))
        <div class="mb-10 bg-emerald-500 rounded-[2.5rem] p-10 text-white relative overflow-hidden shadow-2xl shadow-emerald-500/20">
            <div class="absolute top-0 right-0 p-8 opacity-20 transform translate-x-10 -translate-y-10">
                <span class="text-[120px]">🎉</span>
            </div>
            <div class="relative z-10 max-w-2xl">
                <h1 class="text-4xl font-black tracking-tight mb-4">Welcome to the Family!</h1>
                <p class="text-emerald-50 text-lg font-medium leading-relaxed">Thank you for choosing C-Market. Your order <span class="bg-white/20 px-2 py-0.5 rounded font-black">#{{ $order->order_number }}</span> has been confirmed and our merchants are already preparing your items.</p>
                <div class="mt-8 flex gap-4">
                    <span class="px-4 py-2 bg-white/20 rounded-xl text-xs font-black uppercase tracking-widest">Order Confirmed</span>
                    <span class="px-4 py-2 bg-emerald-400 rounded-xl text-xs font-black uppercase tracking-widest">Preparing Shipment</span>
                </div>
            </div>
        </div>
    @endif
    
    <!-- Header Section: Success Message if tracked -->
    @if(isset($is_tracking) && $is_tracking)
        <div class="mb-12 text-center">
            <div class="w-16 h-16 bg-emerald-500/10 text-emerald-500 rounded-full flex items-center justify-center text-2xl mx-auto mb-4 animate-bounce">✓</div>
            <h1 class="text-3xl font-black text-dark tracking-tight">Order Located!</h1>
            <p class="text-slate-500 font-medium">Here are the latest details for order #{{ $order->order_number }}</p>
        </div>
    @endif

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
        
        <!-- Main Details Column -->
        <div class="lg:col-span-2 space-y-8">
            
            <!-- Order Status & Timeline Card -->
            <div class="bg-white rounded-[2.5rem] p-8 border border-slate-50 shadow-sm overflow-hidden relative">
                <div class="flex flex-col md:flex-row justify-between items-start md:items-center gap-6 mb-10">
                    <div>
                        <h2 class="text-2xl font-black text-dark tracking-tight mb-1">Status: <span class="text-primary">{{ ucfirst($order->status) }}</span></h2>
                        <p class="text-[10px] font-bold text-slate-300 uppercase tracking-widest italic">Updated: {{ $order->updated_at->format('M d, Y • h:i A') }}</p>
                    </div>
                    
                    @if($order->status === 'delivered')
                        <a href="{{ route('invoices.view', $order) }}" target="_blank" class="px-6 py-3 bg-slate-50 text-slate-900 rounded-xl font-black text-[10px] uppercase tracking-widest hover:bg-slate-900 hover:text-white transition-all border border-slate-100">
                            📄 View Invoice
                        </a>
                    @endif
                </div>

                <!-- Minimal Progress Bar -->
                <div class="relative pt-8 pb-4">
                    <div class="absolute top-0 left-0 w-full h-1 bg-slate-100 rounded-full"></div>
                    @php
                        $progress = 20;
                        if($order->status == 'processing') $progress = 50;
                        if($order->status == 'shipped') $progress = 80;
                        if($order->status == 'delivered') $progress = 100;
                        if($order->status == 'cancelled') $progress = 0;
                    @endphp
                    <div class="absolute top-0 left-0 h-1 bg-primary rounded-full transition-all duration-1000 shadow-[0_0_15px_rgba(255,107,44,0.3)]" style="width: {{ $progress }}%"></div>
                    
                    <div class="grid grid-cols-4 gap-2">
                        <div class="text-center">
                            <span class="block text-[9px] font-black uppercase tracking-tighter {{ $progress >= 20 ? 'text-primary' : 'text-slate-300' }}">Pending</span>
                        </div>
                        <div class="text-center">
                            <span class="block text-[9px] font-black uppercase tracking-tighter {{ $progress >= 50 ? 'text-primary' : 'text-slate-300' }}">Processing</span>
                        </div>
                        <div class="text-center">
                            <span class="block text-[9px] font-black uppercase tracking-tighter {{ $progress >= 80 ? 'text-primary' : 'text-slate-300' }}">Shipped</span>
                        </div>
                        <div class="text-center">
                            <span class="block text-[9px] font-black uppercase tracking-tighter {{ $progress >= 100 ? 'text-primary' : 'text-slate-300' }}">Delivered</span>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Items Card -->
            <div class="bg-white rounded-[2.5rem] p-8 border border-slate-50 shadow-sm overflow-hidden">
                <h3 class="text-lg font-black text-dark uppercase tracking-widest mb-8 flex items-center gap-3">
                    <span class="w-8 h-8 bg-slate-900 text-white rounded-lg flex items-center justify-center text-xs">📦</span>
                    Order Items ({{ $order->items->count() }})
                </h3>
                
                <div class="divide-y divide-slate-50">
                    @foreach($order->items as $item)
                        <div class="py-6 flex flex-col md:flex-row gap-6 items-center">
                            <div class="w-24 h-24 rounded-2xl bg-slate-50 border border-slate-100 overflow-hidden flex-shrink-0 group">
                                @php
                                    $product = $item->product;
                                    $image = $product->thumbnail ?? (is_array($product->images) ? ($product->images[0] ?? null) : (json_decode($product->images, true)[0] ?? null));
                                @endphp
                                @if($image)
                                    <img src="{{ asset('storage/' . $image) }}" alt="{{ $item->product_name }}" class="w-full h-full object-cover transition-standard group-hover:scale-110">
                                @else
                                    <div class="w-full h-full flex items-center justify-center text-3xl opacity-20">🛍️</div>
                                @endif
                            </div>
                            
                            <div class="flex-1 text-center md:text-left">
                                <h4 class="font-black text-slate-800 text-base mb-1 hover:text-primary transition-colors cursor-pointer">{{ $item->product_name }}</h4>
                                <p class="text-[10px] font-bold text-slate-400 uppercase tracking-widest mb-3">Sold by: <span class="text-sky-500">{{ $item->product->merchant->business_name ?? 'C-Market' }}</span></p>
                                
                                @if($item->cashback_amount > 0)
                                    <span class="inline-flex items-center gap-1.5 px-3 py-1 bg-emerald-50 text-emerald-600 rounded-lg text-[9px] font-black uppercase tracking-wider">
                                        ✨ ৳{{ number_format($item->cashback_amount, 0) }} Cashback Earned
                                    </span>
                                @endif
                            </div>
                            
                            <div class="text-center md:text-right min-w-[120px]">
                                <p class="text-xl font-black text-dark">৳{{ number_format($item->subtotal, 0) }}</p>
                                <p class="text-[11px] font-bold text-slate-300">QTY: {{ $item->quantity }} × ৳{{ number_format($item->price, 0) }}</p>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>

            <!-- Shipping Info Card -->
            <div class="bg-slate-900 rounded-[2.5rem] p-10 text-white shadow-2xl relative overflow-hidden">
                <div class="absolute top-0 right-0 p-10 opacity-10 pointer-events-none">
                    <svg class="w-32 h-32" fill="currentColor" viewBox="0 0 24 24"><path d="M20 8l-8 5-8-5V6l8 5 8-5m0-2H4c-1.11 0-2 .89-2 2v12c0 1.11.89 2 2 2h16c1.11 0 2-.89 2-2V6c0-1.11-.89-2-2-2z"/></svg>
                </div>
                
                <h3 class="text-sm font-black uppercase tracking-[0.3em] mb-10 text-sky-400">Shipping Foundation</h3>
                
                <div class="grid grid-cols-1 md:grid-cols-2 gap-12 relative z-10">
                    <div>
                        <p class="text-[10px] font-black uppercase tracking-widest text-slate-500 mb-3">Recipient</p>
                        <p class="text-lg font-black mb-1">{{ $order->user->name ?? 'Valued Customer' }}</p>
                        <p class="text-sm font-medium text-slate-400">{{ $order->shipping_phone ?? $order->phone ?? 'N/A' }}</p>
                    </div>
                    
                    <div>
                        <p class="text-[10px] font-black uppercase tracking-widest text-slate-500 mb-3">Delivery Site</p>
                        <p class="text-sm font-bold leading-relaxed text-slate-200">{{ $order->shipping_address }}</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Sidebar Summary Column -->
        <div class="space-y-8">
            
            <!-- Summary Card -->
            <div class="bg-white rounded-[2.5rem] p-8 border-2 border-primary shadow-xl shadow-primary/5 relative overflow-hidden">
                <h3 class="text-lg font-black text-dark uppercase tracking-widest mb-8">Financial Overview</h3>
                
                <div class="space-y-4 mb-10">
                    <div class="flex justify-between items-center text-sm font-bold text-slate-500 uppercase tracking-tighter">
                        <span>Original Subtotal</span>
                        <span class="text-dark">৳{{ number_format($order->subtotal, 0) }}</span>
                    </div>
                    
                    @if($order->discount > 0)
                        <div class="flex justify-between items-center text-sm font-bold text-rose-500 uppercase tracking-tighter">
                            <span>Promo Discount</span>
                            <span>-৳{{ number_format($order->discount, 0) }}</span>
                        </div>
                    @endif
                    
                    <div class="flex justify-between items-center text-sm font-bold text-slate-500 uppercase tracking-tighter">
                        <span>Logistic Fee</span>
                        <span class="text-dark">৳0.00</span>
                    </div>
                    
                    <div class="pt-6 border-t-2 border-slate-50 flex justify-between items-center">
                        <span class="text-xs font-black text-dark uppercase tracking-widest">Total Amount</span>
                        <span class="text-3xl font-black text-primary">৳{{ number_format($order->total_amount, 0) }}</span>
                    </div>
                </div>

                <div class="bg-slate-50 rounded-2xl p-5 space-y-3">
                    <div class="flex justify-between items-center">
                        <span class="text-[10px] font-black text-slate-400 uppercase tracking-widest">Method</span>
                        <span class="text-[10px] font-black text-dark uppercase tracking-widest bg-white px-3 py-1 rounded-lg border border-slate-100">{{ strtoupper(str_replace('_', ' ', $order->payment_method)) }}</span>
                    </div>
                    <div class="flex justify-between items-center">
                        <span class="text-[10px] font-black text-slate-400 uppercase tracking-widest">Payment</span>
                        <span class="text-[10px] font-black uppercase tracking-widest {{ $order->payment_status === 'paid' ? 'text-emerald-500' : 'text-amber-500' }}">{{ $order->payment_status }}</span>
                    </div>
                </div>
            </div>

            <!-- Support / Tracking Box -->
            <div class="bg-sky-500 rounded-[2.5rem] p-8 text-white shadow-xl shadow-sky-500/20 text-center">
                <div class="w-12 h-12 bg-white/20 rounded-2xl flex items-center justify-center text-xl mx-auto mb-6">🛰️</div>
                <h4 class="text-xl font-black mb-2">Need to track elsewhere?</h4>
                <p class="text-sm font-bold text-sky-100 mb-8 px-4">Share the tracking link with your phone number to stay updated site-wide.</p>
                
                <button onclick="copyTrackingLink()" class="w-full bg-white text-sky-600 py-4 rounded-xl font-black text-[11px] uppercase tracking-widest hover:bg-sky-50 transition-all active:scale-95">
                    Copy Public Tracking Link
                </button>
            </div>

            @if(!isset($is_tracking) || !$is_tracking)
                <div class="text-center">
                    <a href="{{ route('orders.index') }}" class="text-xs font-black text-slate-400 uppercase tracking-widest hover:text-primary transition-all flex items-center justify-center gap-2">
                        ← Return to Order History
                    </a>
                </div>
            @endif
        </div>
    </div>
</div>

<script>
    function copyTrackingLink() {
        const orderNum = "{{ $order->order_number }}";
        const phone = "{{ $order->shipping_phone ?? $order->phone }}";
        const link = `{{ url('/tracking') }}?order_number=${orderNum}&phone=${phone}`;
        
        navigator.clipboard.writeText(link).then(() => {
            Swal.fire({
                toast: true,
                position: 'top-end',
                icon: 'success',
                title: 'Tracking Link Copied! 🔗',
                showConfirmButton: false,
                timer: 2000
            });
        });
    }
</script>
@endsection
