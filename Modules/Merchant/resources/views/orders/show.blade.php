@extends('layouts.merchant')

@section('title', 'Order Inspection - Unit #' . $order->order_number)
@section('page-title', 'Dispatch Unit Analysis')

@section('content')
<div class="space-y-10 animate-fade-in pb-20">
    <!-- Header / Status Banner -->
    <div class="card-premium bg-[#0f172a] p-10 md:p-14 text-white border-none shadow-2xl relative overflow-hidden group">
        <div class="relative z-10 flex flex-col md:flex-row justify-between items-start md:items-center gap-10">
            <div class="space-y-4">
                <div class="flex items-center gap-3">
                    <span class="px-4 py-1.5 bg-primary/20 text-primary rounded-xl text-[10px] font-black uppercase tracking-[0.2em] border border-primary/30">
                        Dispatch Token #{{ $order->order_number }}
                    </span>
                    <span class="px-4 py-1.5 bg-white/10 text-slate-400 rounded-xl text-[10px] font-black uppercase tracking-[0.2em] border border-white/10 uppercase">
                        {{ str_replace('_', ' ', $order->status) }}
                    </span>
                </div>
                <h2 class="text-3xl md:text-5xl font-black tracking-tight leading-none uppercase">Projected Revenue: ৳{{ number_format($order->items->sum('subtotal'), 2) }}</h2>
                <p class="text-slate-400 font-bold text-xs uppercase tracking-widest">Initialization: {{ $order->created_at->format('M d, Y • H:i:s') }}</p>
            </div>

            <div class="flex gap-4">
                <button class="px-8 py-4 bg-white text-slate-900 rounded-2xl font-black text-[10px] uppercase tracking-[0.2em] hover:bg-primary hover:text-white transition-all shadow-xl shadow-white/5">
                    🖨️ Generate Manifest
                </button>
            </div>
        </div>
        <div class="absolute -right-10 -top-10 opacity-5 text-[280px] leading-none select-none italic font-black group-hover:scale-110 transition-transform duration-1000">UNIT</div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-10">
        <!-- Target Identity & Logistics -->
        <div class="lg:col-span-2 space-y-10">
            <!-- Asset Matrix -->
            <div class="card-premium p-8 md:p-10 bg-white border-slate-100 shadow-sm overflow-hidden">
                <h3 class="text-[10px] font-black text-slate-400 uppercase tracking-[0.2em] mb-8 flex items-center gap-2">
                    <span class="w-2 h-2 bg-primary rounded-full"></span> Dispatch Inventory Nodes
                </h3>
                
                <div class="space-y-8">
                    @foreach($order->items as $item)
                        <div class="flex items-center gap-8 group">
                            <div class="w-20 h-20 rounded-2xl bg-slate-50 border border-slate-100 overflow-hidden flex-shrink-0 group-hover:scale-105 transition-transform shadow-sm">
                                <img src="{{ asset('storage/' . $item->product->image) }}" class="w-full h-full object-cover">
                            </div>
                            <div class="flex-1">
                                <p class="text-[9px] font-black text-slate-400 uppercase tracking-widest mb-1">{{ $item->product->category->name ?? 'Asset' }}</p>
                                <h4 class="text-sm font-black text-slate-800 uppercase tracking-tight">{{ $item->product->name }}</h4>
                                <div class="flex items-center gap-4 mt-2">
                                    <span class="text-[10px] font-black text-primary uppercase">৳{{ number_format($item->price, 2) }}</span>
                                    <span class="text-[8px] font-black text-slate-300 uppercase">×</span>
                                    <span class="text-[10px] font-black text-slate-600 uppercase">{{ $item->quantity }} Units</span>
                                </div>
                            </div>
                            <div class="text-right">
                                <p class="text-sm font-black text-slate-900 tracking-tighter">৳{{ number_format($item->subtotal, 2) }}</p>
                            </div>
                        </div>
                    @endforeach
                </div>

                <div class="mt-12 pt-8 border-t border-slate-50 flex justify-between items-end">
                    <div class="space-y-1">
                        <p class="text-[9px] font-black text-slate-400 uppercase tracking-widest">Net Revenue Protocol</p>
                        <p class="text-[10px] font-bold text-slate-500 uppercase">Tax & Delivery Logic Applied Separately</p>
                    </div>
                    <p class="text-3xl font-black text-slate-900 tracking-tighter">৳{{ number_format($order->items->sum('subtotal'), 2) }}</p>
                </div>
            </div>

            <!-- Logistical Coordinates -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                <div class="card-premium p-8 bg-white border-slate-100">
                    <h3 class="text-[10px] font-black text-slate-400 uppercase tracking-[0.2em] mb-8">Target Coordinates</h3>
                    <div class="space-y-6">
                        <div>
                            <p class="text-[9px] font-black text-slate-400 uppercase tracking-widest mb-1">Receiver</p>
                            <p class="text-sm font-black text-slate-800 uppercase">{{ $order->user->name }}</p>
                        </div>
                        <div>
                            <p class="text-[9px] font-black text-slate-400 uppercase tracking-widest mb-1">Signal Protocol</p>
                            <p class="text-sm font-black text-primary tracking-tight">{{ $order->shipping_phone }}</p>
                        </div>
                        <div>
                            <p class="text-[9px] font-black text-slate-400 uppercase tracking-widest mb-1">Physical Node</p>
                            <p class="text-sm font-bold text-slate-600 leading-relaxed">{{ $order->shipping_address }}</p>
                        </div>
                    </div>
                </div>

                <div class="card-premium p-8 bg-slate-50 border-slate-100">
                    <h3 class="text-[10px] font-black text-slate-400 uppercase tracking-[0.2em] mb-8">Transaction Security</h3>
                    <div class="space-y-6">
                        <div class="flex justify-between items-center">
                            <p class="text-[9px] font-black text-slate-400 uppercase tracking-widest">Method</p>
                            <span class="text-[10px] font-black text-slate-800 uppercase tracking-widest">{{ $order->payment_method }}</span>
                        </div>
                        <div class="flex justify-between items-center">
                            <p class="text-[9px] font-black text-slate-400 uppercase tracking-widest">Verification</p>
                            <span class="px-3 py-1 bg-emerald-50 text-emerald-600 rounded-lg text-[9px] font-black uppercase">Secured</span>
                        </div>
                        <hr class="border-slate-200">
                        <div class="pt-2">
                            <p class="text-[9px] font-black text-slate-400 uppercase tracking-widest mb-3">Merchant Notes</p>
                            <p class="text-[10px] font-bold text-slate-500 italic">{{ $order->notes ?? 'No operational notes provided.' }}</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Operational Control Sidebar -->
        <div class="space-y-10">
            <div class="card-premium p-8 bg-white border-slate-100 shadow-xl">
                <h3 class="text-[10px] font-black text-slate-400 uppercase tracking-[0.2em] mb-8">Protocol Adjustment</h3>
                
                <form action="#" method="POST" class="space-y-6">
                    @csrf
                    <div class="space-y-2">
                        <label class="text-[9px] font-black text-slate-400 uppercase tracking-widest ml-1">Update Unit Status</label>
                        <select name="status" class="w-full px-5 py-4 bg-slate-50 border-none rounded-2xl text-[10px] font-black text-slate-800 uppercase tracking-widest focus:ring-4 focus:ring-primary/10 transition-all">
                            <option value="pending" {{ $order->status == 'pending' ? 'selected' : '' }}>Pending</option>
                            <option value="confirmed" {{ $order->status == 'confirmed' ? 'selected' : '' }}>Confirmed</option>
                            <option value="packaging" {{ $order->status == 'packaging' ? 'selected' : '' }}>Packaging</option>
                            <option value="out_for_delivery" {{ $order->status == 'out_for_delivery' ? 'selected' : '' }}>Out For Delivery</option>
                            <option value="delivered" {{ $order->status == 'delivered' ? 'selected' : '' }}>Delivered</option>
                            <option value="canceled" {{ $order->status == 'canceled' ? 'selected' : '' }}>Canceled</option>
                        </select>
                    </div>

                    <button type="submit" class="w-full btn-matrix btn-primary-matrix py-5 text-[10px] tracking-[0.2em]">
                        DEPLOY UPDATE
                    </button>
                </form>
            </div>

            <!-- Transit Node Tracking -->
            <div class="card-premium p-8 bg-slate-900 text-white border-none shadow-2xl relative overflow-hidden">
                <h3 class="text-[10px] font-black text-sky-400 uppercase tracking-[0.2em] mb-8">Logistics Node</h3>
                <div class="space-y-6">
                    <div class="flex items-center gap-4">
                        <div class="w-12 h-12 rounded-xl bg-white/5 border border-white/10 flex items-center justify-center text-xl">🏍️</div>
                        <div>
                            <p class="text-[10px] font-black uppercase tracking-widest">Awaiting Assignment</p>
                            <p class="text-[9px] font-bold text-slate-500 uppercase">Transit Agent Protocol</p>
                        </div>
                    </div>
                </div>
                <div class="absolute -right-4 -bottom-4 opacity-5 text-6xl italic font-black select-none">FLEET</div>
            </div>
        </div>
    </div>
</div>
@endsection
