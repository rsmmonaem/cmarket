@extends('layouts.merchant')

@section('title', 'Intelligence Terminal')
@section('page-title', 'Business Intelligence Dashboard')

@section('content')
<div class="space-y-10 animate-fade-in pb-10">
    <!-- Section: Business Operational Analytics -->
    <div class="space-y-6">
        <div class="flex items-center justify-between">
            <h3 class="text-sm font-black text-slate-400 uppercase tracking-[0.2em] flex items-center gap-2">
                <span class="w-2 h-2 bg-primary rounded-full animate-pulse"></span> Order Stream
            </h3>
            <span class="text-[10px] font-black text-slate-400 uppercase tracking-widest bg-white px-3 py-1 rounded-lg border border-slate-100">Live Telemetry</span>
        </div>

        <div class="grid grid-cols-2 md:grid-cols-4 lg:grid-cols-9 gap-4">
            @php
                $statuses = [
                    ['label' => 'Pending', 'icon' => '🕒', 'color' => 'amber', 'count' => $merchant->orders()->where('status', 'pending')->count(), 'slug' => 'pending'],
                    ['label' => 'Confirmed', 'icon' => '✅', 'color' => 'sky', 'count' => $merchant->orders()->where('status', 'confirmed')->count(), 'slug' => 'confirmed'],
                    ['label' => 'Packaging', 'icon' => '📦', 'color' => 'indigo', 'count' => $merchant->orders()->where('status', 'packaging')->count(), 'slug' => 'packaging'],
                    ['label' => 'Transit', 'icon' => '🚚', 'color' => 'blue', 'count' => $merchant->orders()->where('status', 'out_for_delivery')->count(), 'slug' => 'out_for_delivery'],
                    ['label' => 'Delivered', 'icon' => '✨', 'color' => 'emerald', 'count' => $merchant->orders()->where('status', 'delivered')->count(), 'slug' => 'delivered'],
                    ['label' => 'Canceled', 'icon' => '🚫', 'color' => 'rose', 'count' => $merchant->orders()->where('status', 'canceled')->count(), 'slug' => 'canceled'],
                    ['label' => 'Returned', 'icon' => '↩️', 'color' => 'orange', 'count' => $merchant->orders()->where('status', 'returned')->count(), 'slug' => 'returned'],
                    ['label' => 'Failed', 'icon' => '❌', 'color' => 'red', 'count' => $merchant->orders()->where('status', 'failed')->count(), 'slug' => 'failed'],
                    ['label' => 'All', 'icon' => '📊', 'color' => 'slate', 'count' => $merchant->orders()->count(), 'slug' => ''],
                ];
            @endphp

            @foreach($statuses as $s)
                <a href="{{ route('merchant.orders.index', ['status' => $s['slug']]) }}" class="card-premium p-4 md:p-6 text-center group cursor-pointer hover:bg-{{ $s['color'] }}-500 hover:text-white transition-all duration-500">
                    <div class="text-2xl mb-2 group-hover:scale-125 transition-transform duration-500">{{ $s['icon'] }}</div>
                    <div class="text-[9px] font-black text-slate-400 group-hover:text-white/80 uppercase tracking-tighter truncate">{{ $s['label'] }}</div>
                    <div class="text-xl font-black mt-1 tracking-tighter">{{ $s['count'] }}</div>
                </a>
            @endforeach
        </div>
    </div>

    <!-- Section: Economic Matrix & Analytics -->
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-10">
        <!-- Merchant Wallet Cluster -->
        <div class="lg:col-span-1 space-y-8">
            <div class="card-premium p-8 bg-slate-950 text-white border-none shadow-2xl relative overflow-hidden group">
                <div class="relative z-10 space-y-8">
                    <h3 class="text-[10px] font-black text-sky-400 uppercase tracking-[0.2em]">Wallet Node</h3>
                    
                    <div class="space-y-6">
                        <div class="p-6 bg-white/5 border border-white/10 rounded-2xl backdrop-blur-md">
                            <p class="text-[9px] font-black text-slate-400 uppercase tracking-widest mb-2">Withdrawable Balance</p>
                            <div class="flex items-baseline gap-2">
                                <span class="text-4xl font-black tracking-tighter text-sky-400">৳{{ number_format(Auth::user()->getWallet('shop')?->balance ?? 0, 2) }}</span>
                                <span class="text-[10px] font-black uppercase text-slate-500">BDT</span>
                            </div>
                        </div>

                        <div class="grid grid-cols-2 gap-4">
                            <div class="p-4 bg-white/5 border border-white/10 rounded-2xl">
                                <p class="text-[8px] font-black text-slate-500 uppercase tracking-widest mb-1">Pending Withdraw</p>
                                <p class="text-sm font-black tracking-tight text-amber-400">৳0.00</p>
                            </div>
                            <div class="p-4 bg-white/5 border border-white/10 rounded-2xl">
                                <p class="text-[8px] font-black text-slate-500 uppercase tracking-widest mb-1">Total Commission</p>
                                <p class="text-sm font-black tracking-tight text-emerald-400">৳0.00</p>
                            </div>
                            <div class="p-4 bg-white/5 border border-white/10 rounded-2xl">
                                <p class="text-[8px] font-black text-slate-500 uppercase tracking-widest mb-1">Already Withdrawn</p>
                                <p class="text-sm font-black tracking-tight text-slate-300">৳0.00</p>
                            </div>
                            <div class="p-4 bg-white/5 border border-white/10 rounded-2xl">
                                <p class="text-[8px] font-black text-slate-500 uppercase tracking-widest mb-1">Collected Cash</p>
                                <p class="text-sm font-black tracking-tight text-blue-400">৳0.00</p>
                            </div>
                        </div>

                        <div class="pt-4 border-t border-white/5 space-y-3">
                            <div class="flex justify-between text-[9px] font-black uppercase tracking-widest text-slate-500">
                                <span>Delivery Charge Earned</span>
                                <span class="text-white">৳0.00</span>
                            </div>
                            <div class="flex justify-between text-[9px] font-black uppercase tracking-widest text-slate-500">
                                <span>Total Tax Given</span>
                                <span class="text-rose-400">৳0.00</span>
                            </div>
                        </div>

                        <button class="w-full py-4 bg-primary text-white rounded-2xl font-black text-[10px] uppercase tracking-widest shadow-xl shadow-primary/20 hover:scale-[1.02] active:scale-95 transition-all">
                            Request Payout
                        </button>
                    </div>
                </div>
                <div class="absolute -right-4 -bottom-4 opacity-10 text-6xl italic font-black select-none pointer-events-none">NODE</div>
            </div>
        </div>

        <!-- Performance Chart Cluster -->
        <div class="lg:col-span-2 card-premium p-8 bg-white border-slate-100 flex flex-col">
            <div class="flex items-center justify-between mb-10">
                <div>
                    <h3 class="text-sm font-black text-slate-800 uppercase tracking-widest">Revenue Analytics</h3>
                    <p class="text-[10px] font-bold text-slate-400 uppercase tracking-widest mt-1">Live Performance</p>
                </div>
                <div class="flex bg-slate-50 p-1 rounded-xl">
                    <button class="px-4 py-1.5 text-[9px] font-black uppercase tracking-widest bg-white shadow-sm rounded-lg text-primary">Year</button>
                    <button class="px-4 py-1.5 text-[9px] font-black uppercase tracking-widest text-slate-400">Month</button>
                    <button class="px-4 py-1.5 text-[9px] font-black uppercase tracking-widest text-slate-400">Week</button>
                </div>
            </div>

            <div class="flex-1 min-h-[300px] relative">
                <canvas id="earningChart"></canvas>
            </div>
        </div>
    </div>

    <!-- Section: Market Intelligence Tables -->
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-10">
        <!-- Top Selling Products -->
        <div class="card-premium p-8 bg-white border-slate-100">
            <h3 class="text-[10px] font-black text-slate-400 uppercase tracking-[0.2em] mb-8">Top Selling Assets</h3>
            <div class="space-y-6">
                @forelse($merchant->products()->orderBy('orders_count', 'desc')->take(5)->get() as $product)
                    <div class="flex items-center gap-4 group cursor-pointer">
                        <div class="w-12 h-12 rounded-xl bg-slate-50 overflow-hidden flex-shrink-0 border border-slate-100 group-hover:scale-110 transition-transform">
                            <img src="{{ asset('storage/' . $product->image) }}" class="w-full h-full object-cover">
                        </div>
                        <div class="flex-1 min-w-0">
                            <p class="text-[11px] font-black text-slate-800 truncate uppercase">{{ $product->name }}</p>
                            <p class="text-[9px] font-bold text-slate-400 tracking-tighter">{{ $product->orders_count ?? 0 }} Deployments</p>
                        </div>
                        <div class="text-right">
                            <p class="text-xs font-black text-emerald-500 tracking-tighter">৳{{ number_format($product->price, 2) }}</p>
                        </div>
                    </div>
                @empty
                    <p class="text-center py-10 text-[10px] font-black text-slate-300 uppercase tracking-widest">No Sales Data</p>
                @endforelse
            </div>
        </div>

        <!-- Most Rated Products -->
        <div class="card-premium p-8 bg-white border-slate-100">
            <h3 class="text-[10px] font-black text-slate-400 uppercase tracking-[0.2em] mb-8">Asset Rating Matrix</h3>
            <div class="space-y-6 text-center py-20 opacity-30">
                <span class="text-5xl mb-4 block">⭐</span>
                <p class="text-[10px] font-black uppercase tracking-widest">Reviews Signal Offline</p>
            </div>
        </div>

        <!-- Top Delivery Personnel (assigned to merchant) -->
        <div class="card-premium p-8 bg-white border-slate-100">
            <h3 class="text-[10px] font-black text-slate-400 uppercase tracking-[0.2em] mb-8">Dispatchers</h3>
            <div class="space-y-6 text-center py-20 opacity-30">
                <span class="text-5xl mb-4 block">🏍️</span>
                <p class="text-[10px] font-black uppercase tracking-widest">Logistics Data Latency</p>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const ctx = document.getElementById('earningChart').getContext('2d');
        const gradient = ctx.createLinearGradient(0, 0, 0, 400);
        gradient.addColorStop(0, 'rgba(37, 99, 235, 0.2)');
        gradient.addColorStop(1, 'rgba(37, 99, 235, 0)');

        new Chart(ctx, {
            type: 'line',
            data: {
                labels: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'],
                datasets: [{
                    label: 'Revenue Protocol',
                    data: [30, 45, 35, 60, 50, 75, 90, 85, 110, 105, 130, 150],
                    borderColor: '#2563eb',
                    borderWidth: 4,
                    pointBackgroundColor: '#ffffff',
                    pointBorderColor: '#2563eb',
                    pointBorderWidth: 2,
                    pointRadius: 4,
                    pointHoverRadius: 6,
                    tension: 0.4,
                    fill: true,
                    backgroundColor: gradient
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: { display: false },
                    tooltip: {
                        backgroundColor: '#0f172a',
                        titleFont: { family: 'Outfit', size: 12, weight: 'bold' },
                        bodyFont: { family: 'Outfit', size: 10 },
                        padding: 12,
                        cornerRadius: 12,
                        displayColors: false
                    }
                },
                scales: {
                    x: {
                        grid: { display: false },
                        ticks: { font: { family: 'Outfit', size: 10, weight: '600' }, color: '#94a3b8' }
                    },
                    y: {
                        grid: { borderDash: [5, 5], color: '#f1f5f9' },
                        ticks: { font: { family: 'Outfit', size: 10, weight: '600' }, color: '#94a3b8' }
                    }
                }
            }
        });
    });
</script>
@endpush
@endsection
