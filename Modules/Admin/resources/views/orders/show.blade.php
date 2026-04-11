@extends('layouts.admin')

@section('title', 'Order Detail - CMarket')
@section('page-title', 'Order Detail')

@section('content')
<div class="space-y-8 animate-fade-in pb-20">
    <!-- Header Summary -->
    <div class="bg-gradient-to-br from-slate-900 to-slate-800 rounded-[2.5rem] p-8 md:p-12 text-white shadow-2xl shadow-slate-900/20 relative overflow-hidden group">
        <div class="relative z-10 flex flex-col md:flex-row justify-between items-center gap-8">
            <div>
                <p class="text-sky-400 text-[10px] font-black uppercase tracking-[0.3em] mb-4">Official Receipt • Status Log</p>
                <h2 class="text-4xl font-black tracking-tight mb-2">Order #{{ $order->order_number }}</h2>
                <div class="flex items-center gap-4 mt-4">
                    <span class="px-4 py-2 rounded-xl bg-white/10 backdrop-blur-md border border-white/20 text-[10px] font-black uppercase tracking-widest text-white">
                        {{ $order->created_at->format('M d, Y • h:i A') }}
                    </span>
                    @php
                        $statusMaps = [
                            'pending' => 'bg-amber-400 text-slate-900',
                            'paid' => 'bg-sky-400 text-slate-900',
                            'processing' => 'bg-blue-400 text-white',
                            'shipped' => 'bg-emerald-400 text-slate-900',
                            'delivered' => 'bg-emerald-600 text-white',
                            'cancelled' => 'bg-rose-500 text-white',
                        ];
                    @endphp
                    <span class="px-4 py-2 rounded-xl {{ $statusMaps[$order->status] ?? 'bg-white/20' }} text-[10px] font-black uppercase tracking-widest shadow-lg">
                        {{ $order->status }}
                    </span>
                </div>
            </div>
            <div class="flex gap-4">
                <a href="{{ route('admin.orders.index') }}" class="bg-white/10 hover:bg-white/20 backdrop-blur-xl px-8 py-5 rounded-2xl font-black text-[10px] uppercase tracking-widest border border-white/10 transition-all active:scale-95">Back to Archive</a>
                <a href="{{ route('invoices.view', $order) }}" target="_blank" class="bg-sky-500 hover:bg-sky-400 px-8 py-5 rounded-2xl font-black text-[10px] uppercase tracking-widest text-slate-900 transition-all active:scale-95 shadow-xl shadow-sky-500/20">Print Invoice 🖨️</a>
            </div>
        </div>
        <div class="absolute -right-10 -bottom-10 opacity-5 text-[220px] leading-none select-none italic font-black group-hover:scale-110 transition-transform duration-1000">📁</div>
    </div>

    <!-- Order Timeline Progress -->
    <div class="bg-white rounded-[2.5rem] p-8 md:p-12 border border-slate-100 shadow-sm relative overflow-hidden group">
        <div class="flex flex-col md:flex-row justify-between items-center gap-8 relative z-10">
            @php
                $steps = [
                    'pending' => ['label' => 'Received', 'icon' => '📥'],
                    'paid' => ['label' => 'Payment', 'icon' => '💳'],
                    'processing' => ['label' => 'Processing', 'icon' => '⚙️'],
                    'shipped' => ['label' => 'Shipped', 'icon' => '🚚'],
                    'delivered' => ['label' => 'Delivered', 'icon' => '🏠']
                ];
                $activeIdx = array_search($order->status, array_keys($steps));
                if($order->status == 'cancelled') $activeIdx = -1;
            @endphp

            @foreach($steps as $key => $step)
                <div class="flex-1 flex flex-col items-center relative {{ $loop->last ? '' : 'w-full' }}">
                    <div class="w-14 h-14 rounded-2xl flex items-center justify-center text-xl shadow-inner transition-all duration-500 z-10 
                        {{ $loop->index <= $activeIdx ? 'bg-slate-900 text-white ring-4 ring-slate-100' : 'bg-slate-50 text-slate-300' }}">
                        {{ $step['icon'] }}
                    </div>
                    <p class="mt-4 text-[10px] font-black uppercase tracking-widest {{ $loop->index <= $activeIdx ? 'text-slate-800' : 'text-slate-300' }}">
                        {{ $step['label'] }}
                    </p>
                    
                    @if(!$loop->last)
                        <div class="hidden md:block absolute top-7 left-1/2 w-full h-[2px] bg-slate-100 -z-0">
                            <div class="h-full bg-slate-900 transition-all duration-1000" style="width: {{ $loop->index < $activeIdx ? '100' : ($loop->index == $activeIdx ? '0' : '0') }}%"></div>
                        </div>
                    @endif
                </div>
            @endforeach
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
        <!-- Main Asset Column -->
        <div class="lg:col-span-2 space-y-8">
            <!-- Product Manifest -->
            <div class="bg-white rounded-[2.5rem] p-8 border border-slate-100 shadow-sm overflow-hidden">
                <h3 class="text-sm font-black text-slate-800 uppercase tracking-widest mb-8 flex items-center gap-3">
                    Asset Manifest <span class="bg-slate-100 text-[10px] p-1.5 rounded-lg">{{ $order->items->count() }} Items</span>
                </h3>

                <div class="space-y-6">
                    @foreach($order->items as $item)
                        <div class="flex flex-col md:flex-row items-center gap-6 p-6 rounded-3xl bg-slate-50/50 hover:bg-slate-50 transition-colors group">
                            <div class="w-24 h-24 rounded-2xl bg-white border border-slate-100 overflow-hidden shadow-sm group-hover:scale-105 transition-transform">
                                @php
                                    $product = $item->product;
                                    $image = $product->thumbnail ?? (is_array($product->images) ? ($product->images[0] ?? null) : (json_decode($product->images, true)[0] ?? null));
                                @endphp
                                @if($image)
                                    <img src="{{ asset('storage/' . $image) }}" alt="" class="w-full h-full object-cover">
                                @else
                                    <div class="w-full h-full flex items-center justify-center text-2xl opacity-20">📦</div>
                                @endif
                            </div>
                            <div class="flex-1 text-center md:text-left">
                                <h4 class="text-sm font-black text-slate-800 mb-1">{{ $item->product->name }}</h4>
                                <p class="text-[10px] font-black text-sky-500 uppercase tracking-widest">Merchant: {{ $item->product->merchant->business_name }}</p>
                                <div class="mt-4 flex items-center justify-center md:justify-start gap-4">
                                    <div class="bg-white px-3 py-1.5 rounded-lg border border-slate-100 text-[10px] font-black text-slate-400">QTY: {{ $item->quantity }}</div>
                                    <div class="text-[11px] font-black text-slate-800">৳{{ number_format($item->price, 2) }} / unit</div>
                                </div>
                            </div>
                            <div class="text-center md:text-right">
                                <p class="text-lg font-black text-slate-800 leading-none mb-1">৳{{ number_format($item->subtotal, 2) }}</p>
                                <p class="text-[9px] font-black text-slate-400 uppercase tracking-widest">Subtotal Segment</p>
                            </div>
                        </div>
                    @endforeach
                </div>

                <!-- Financial Resolution -->
                <div class="mt-10 p-8 rounded-[2rem] bg-slate-900 text-white shadow-2xl shadow-slate-900/10">
                    <div class="space-y-4">
                        <div class="flex justify-between items-center opacity-60">
                            <span class="text-[10px] font-black uppercase tracking-widest">Asset Subtotal</span>
                            <span class="text-sm font-bold">৳{{ number_format($order->subtotal, 2) }}</span>
                        </div>
                        <div class="flex justify-between items-center text-rose-400">
                            <span class="text-[10px] font-black uppercase tracking-widest">Applied Discount</span>
                            <span class="text-sm font-bold">-৳{{ number_format($order->discount ?? 0, 2) }}</span>
                        </div>
                        <div class="flex justify-between items-center opacity-60">
                            <span class="text-[10px] font-black uppercase tracking-widest">Logistics Variable</span>
                            <span class="text-sm font-bold">৳0.00</span>
                        </div>
                        <div class="h-[1px] bg-white/10 my-4"></div>
                        <div class="flex justify-between items-center">
                            <span class="text-xs font-black uppercase tracking-[0.2em] text-sky-400">Aggregate Settlement</span>
                            <span class="text-2xl font-black italic tracking-tighter">৳{{ number_format($order->total_amount, 2) }}</span>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Status Authorization -->
            @if($order->status != 'delivered' && $order->status != 'cancelled')
                <div class="bg-white rounded-[2.5rem] p-8 border border-slate-100 shadow-sm relative overflow-hidden group">
                    <h3 class="text-sm font-black text-slate-800 uppercase tracking-widest mb-8 flex items-center gap-3">
                        Status Authorization <span class="bg-slate-100 text-[10px] p-1.5 rounded-lg">Admin Override</span>
                    </h3>
                    
                    <form action="{{ route('admin.orders.update-status', $order) }}" method="POST">
                        @csrf
                        <div class="flex flex-col md:flex-row gap-4">
                            <div class="flex-1">
                                <select name="status" class="w-full h-16 bg-slate-50 border-none rounded-2xl px-8 text-sm font-black text-slate-800 focus:bg-white focus:ring-4 focus:ring-slate-900/5 transition-all appearance-none cursor-pointer">
                                    @foreach(['pending', 'paid', 'processing', 'shipped', 'delivered', 'cancelled'] as $status)
                                        <option value="{{ $status }}" {{ $order->status == $status ? 'selected' : '' }}>Move to {{ ucfirst($status) }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <button type="submit" class="h-16 px-12 bg-slate-900 text-white rounded-2xl font-black text-[10px] uppercase tracking-widest hover:bg-black transition-all active:scale-95 shadow-xl shadow-slate-900/10">
                                Confirm State Transition ✨
                            </button>
                        </div>
                    </form>
                </div>
            @endif
        </div>

        <!-- Sidebar Meta Column -->
        <div class="space-y-8">
            <!-- Customer Analytics -->
            <div class="bg-white rounded-[2.5rem] p-8 border border-slate-100 shadow-sm relative overflow-hidden group">
                <h3 class="text-sm font-black text-slate-800 uppercase tracking-widest mb-8">Target Customer</h3>
                <div class="flex items-center gap-4 p-4 rounded-3xl bg-slate-50 border border-slate-100 mb-6">
                    <div class="w-16 h-16 rounded-2xl bg-white flex items-center justify-center text-3xl shadow-sm">👤</div>
                    <div>
                        <p class="text-base font-black text-slate-800">{{ $order->user->name }}</p>
                        <p class="text-[10px] font-black text-sky-500 uppercase tracking-widest">Protocol User</p>
                    </div>
                </div>
                <div class="space-y-4">
                    <div class="p-4 rounded-2xl bg-slate-50/50">
                        <p class="text-[8px] font-black text-slate-400 uppercase tracking-widest mb-1">Communication Channel</p>
                        <p class="text-xs font-bold text-slate-800">{{ $order->user->phone }}</p>
                        <p class="text-xs font-bold text-slate-800">{{ $order->user->email }}</p>
                    </div>
                </div>
            </div>

            <!-- Logistics Vector -->
            <div class="bg-white rounded-[2.5rem] p-8 border border-slate-100 shadow-sm relative overflow-hidden group">
                <h3 class="text-sm font-black text-slate-800 uppercase tracking-widest mb-8 flex items-center gap-2">
                    Logistics Vector 🚚
                </h3>
                <div class="p-6 rounded-3xl bg-slate-50 border border-slate-100">
                    <p class="text-[8px] font-black text-slate-400 uppercase tracking-widest mb-2">Destination Node</p>
                    <p class="text-xs font-bold text-slate-800 leading-relaxed italic">{{ $order->shipping_address }}</p>
                    <div class="mt-4 pt-4 border-t border-slate-100 flex items-center gap-3">
                        <div class="w-2 h-2 rounded-full bg-emerald-500 animate-pulse"></div>
                        <p class="text-[10px] font-black text-slate-400 uppercase tracking-widest">Ready for Deployment</p>
                    </div>
                </div>
            </div>

            <!-- Payment Protocol -->
            <div class="bg-white rounded-[2.5rem] p-8 border border-slate-100 shadow-sm relative overflow-hidden group">
                <h3 class="text-sm font-black text-slate-800 uppercase tracking-widest mb-8">Asset Liquidation</h3>
                <div class="flex justify-between items-center mb-6">
                    <div>
                        <p class="text-[8px] font-black text-slate-400 uppercase tracking-widest">Method</p>
                        <p class="text-sm font-black text-slate-800 uppercase">{{ $order->payment_method }}</p>
                    </div>
                    @if($order->status == 'paid' || $order->status == 'delivered')
                        <span class="bg-emerald-100 text-emerald-600 px-3 py-1.5 rounded-lg text-[9px] font-black uppercase tracking-widest italic">RESOLVED</span>
                    @else
                        <span class="bg-amber-100 text-amber-600 px-3 py-1.5 rounded-lg text-[9px] font-black uppercase tracking-widest italic">AWAITING</span>
                    @endif
                </div>
                <div class="p-4 rounded-2xl bg-slate-900 text-white text-center">
                    <p class="text-[8px] font-black text-slate-400 uppercase tracking-widest mb-1">Final Amount</p>
                    <p class="text-xl font-black tracking-tighter">৳{{ number_format($order->total_amount, 2) }}</p>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

