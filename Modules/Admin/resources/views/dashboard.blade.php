@extends('layouts.admin')

@section('title', 'Matrix Admin Hub')
@section('page-title', 'Administrative Hub')

@section('content')
<div class="space-y-12 animate-fade-in">
    <!-- Global Statistics -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-8">
        <!-- Sales Velocity -->
        <div class="card-premium bg-gradient-to-br from-primary to-primary-dark text-white border-none shadow-2xl shadow-primary/20 relative overflow-hidden group">
            <div class="relative z-10">
                <div class="flex items-center justify-between mb-8">
                    <span class="text-[10px] font-black uppercase tracking-[0.2em] opacity-60">Revenue Performance</span>
                    <span class="text-2xl">💰</span>
                </div>
                <h3 class="text-4xl font-black mb-2 tracking-tighter">৳{{ number_format(\App\Models\Order::where('status', 'paid')->sum('total_amount'), 0) }}</h3>
                <p class="text-[10px] font-black text-primary-light uppercase tracking-widest">+12.5% vs last cycle</p>
            </div>
            <div class="absolute -right-4 -bottom-4 opacity-10 text-8xl font-black italic select-none">SALES</div>
        </div>

        <!-- Store Network -->
        <div class="card-premium relative overflow-hidden group">
            <div class="relative z-10">
                <div class="flex items-center justify-between mb-8">
                    <span class="text-[10px] font-black text-slate-400 uppercase tracking-[0.2em]">Active Merchants</span>
                    <span class="text-2xl">🏪</span>
                </div>
                <h3 class="text-4xl font-black text-slate-800 dark:text-white mb-2 tracking-tighter">{{ \App\Models\Merchant::count() }}</h3>
                <p class="text-[10px] font-black text-accent uppercase tracking-widest">Across all territories</p>
            </div>
            <div class="absolute -right-4 -bottom-4 opacity-[0.03] text-8xl font-black italic select-none dark:text-white">STORES</div>
        </div>

        <!-- Product Catalog -->
        <div class="card-premium relative overflow-hidden group">
            <div class="relative z-10">
                <div class="flex items-center justify-between mb-8">
                    <span class="text-[10px] font-black text-slate-400 uppercase tracking-[0.2em]">Global Catalog</span>
                    <span class="text-2xl">📦</span>
                </div>
                <h3 class="text-4xl font-black text-slate-800 dark:text-white mb-2 tracking-tighter">{{ \App\Models\Product::count() }}</h3>
                <p class="text-[10px] font-black text-sky-500 uppercase tracking-widest">Global Inventory</p>
            </div>
            <div class="absolute -right-4 -bottom-4 opacity-[0.03] text-8xl font-black italic select-none dark:text-white">ASSETS</div>
        </div>

        <!-- Customer Base -->
        <div class="card-premium relative overflow-hidden group">
            <div class="relative z-10">
                <div class="flex items-center justify-between mb-8">
                    <span class="text-[10px] font-black text-slate-400 uppercase tracking-[0.2em]">Total Customers</span>
                    <span class="text-2xl">👥</span>
                </div>
                <h3 class="text-4xl font-black text-slate-800 dark:text-white mb-2 tracking-tighter">{{ \App\Models\User::count() }}</h3>
                <p class="text-[10px] font-black text-emerald-500 uppercase tracking-widest">Verified Consumers</p>
            </div>
            <div class="absolute -right-4 -bottom-4 opacity-[0.03] text-8xl font-black italic select-none dark:text-white">USERS</div>
        </div>
    </div>

    <!-- Order Operations -->
    <div class="space-y-6">
        <div class="flex items-center justify-between px-2">
            <h3 class="text-xs font-black text-slate-800 dark:text-white uppercase tracking-[0.3em]">Order Pipeline</h3>
            <a href="{{ route('admin.orders.index') }}" class="text-[10px] font-black text-primary uppercase tracking-widest hover:underline">View All Orders →</a>
        </div>
        <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-6 gap-6">
            @php
                $statuses = [
                    ['label' => 'Pending', 'icon' => '⏳', 'color' => 'amber', 'count' => \App\Models\Order::where('status', 'pending')->count(), 'slug' => 'pending'],
                    ['label' => 'Confirmed', 'icon' => '✅', 'color' => 'sky', 'count' => \App\Models\Order::where('status', 'confirmed')->count(), 'slug' => 'confirmed'],
                    ['label' => 'Packaging', 'icon' => '📦', 'color' => 'indigo', 'count' => \App\Models\Order::where('status', 'packaging')->count(), 'slug' => 'packaging'],
                    ['label' => 'In Transit', 'icon' => '🚚', 'color' => 'orange', 'count' => \App\Models\Order::where('status', 'out_for_delivery')->count(), 'slug' => 'out_for_delivery'],
                    ['label' => 'Delivered', 'icon' => '🏁', 'color' => 'emerald', 'count' => \App\Models\Order::where('status', 'delivered')->count(), 'slug' => 'delivered'],
                    ['label' => 'Cancelled', 'icon' => '🚫', 'color' => 'rose', 'count' => \App\Models\Order::where('status', 'cancelled')->count(), 'slug' => 'cancelled'],
                ];
            @endphp

            @foreach($statuses as $status)
                <a href="{{ route('admin.orders.index', ['status' => $status['slug']]) }}" class="card-premium flex flex-col items-center text-center p-6 group hover:scale-105 transition-all">
                    <div class="w-12 h-12 rounded-2xl bg-{{ $status['color'] }}-50 dark:bg-{{ $status['color'] }}-900/20 text-{{ $status['color'] }}-600 dark:text-{{ $status['color'] }}-400 flex items-center justify-center text-2xl mb-4 group-hover:rotate-12 transition-transform">
                        {{ $status['icon'] }}
                    </div>
                    <div class="text-2xl font-black text-slate-800 dark:text-white mb-1">{{ number_format($status['count']) }}</div>
                    <div class="text-[9px] font-black text-slate-400 uppercase tracking-widest">{{ $status['label'] }}</div>
                </a>
            @endforeach
        </div>
    </div>

    <!-- Analytics & Intelligence -->
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-10">
        <!-- Sales Velocity Chart -->
        <div class="lg:col-span-2 card-premium space-y-8">
            <div class="flex items-center justify-between">
                <div>
                    <h3 class="text-sm font-black text-slate-800 dark:text-white uppercase tracking-widest">Revenue Growth</h3>
                    <p class="text-[10px] font-bold text-slate-400 uppercase mt-1">Sales Performance</p>
                </div>
                <div class="flex items-center gap-3">
                    <button class="px-4 py-1.5 rounded-lg bg-slate-50 dark:bg-slate-800 text-[9px] font-black text-slate-500 uppercase tracking-widest hover:text-primary transition-all">Weekly</button>
                    <button class="px-4 py-1.5 rounded-lg bg-primary text-[9px] font-black text-white uppercase tracking-widest shadow-lg shadow-primary/20">Monthly</button>
                </div>
            </div>
            
            <div class="h-[400px] w-full bg-slate-50 dark:bg-slate-800/50 rounded-[2rem] flex items-center justify-center overflow-hidden relative">
                <canvas id="salesChart" class="w-full h-full p-8"></canvas>
                {{-- Mock data indicator if no real chart --}}
                <div id="chartPlaceholder" class="absolute inset-0 flex flex-col items-center justify-center pointer-events-none opacity-20">
                    <span class="text-6xl mb-4">📈</span>
                    <span class="text-xs font-black uppercase tracking-[0.2em]">Generating Data Insights...</span>
                </div>
            </div>

            <div class="grid grid-cols-2 lg:grid-cols-3 gap-8 pt-4">
                <div class="space-y-1">
                    <p class="text-[9px] font-black text-slate-400 uppercase tracking-widest">Net Revenue</p>
                    <p class="text-xl font-black text-slate-800 dark:text-white">৳1.2M</p>
                    <div class="w-full h-1 bg-slate-100 dark:bg-slate-800 rounded-full">
                        <div class="w-2/3 h-full bg-primary rounded-full"></div>
                    </div>
                </div>
                <div class="space-y-1">
                    <p class="text-[9px] font-black text-slate-400 uppercase tracking-widest">Admin Wallet</p>
                    <p class="text-xl font-black text-accent">৳245K</p>
                    <div class="w-full h-1 bg-slate-100 dark:bg-slate-800 rounded-full">
                        <div class="w-1/2 h-full bg-accent rounded-full"></div>
                    </div>
                </div>
                <div class="space-y-1 hidden lg:block">
                    <p class="text-[9px] font-black text-slate-400 uppercase tracking-widest">Avg Order Value</p>
                    <p class="text-xl font-black text-slate-800 dark:text-white">৳2,450</p>
                    <div class="w-full h-1 bg-slate-100 dark:bg-slate-800 rounded-full">
                        <div class="w-3/4 h-full bg-emerald-500 rounded-full"></div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Insight Panels -->
        <div class="space-y-8">
            <!-- Top Performers -->
            <div class="card-premium space-y-8">
                <h3 class="text-xs font-black text-slate-800 dark:text-white uppercase tracking-widest pl-1">Top Customers</h3>
                <div class="space-y-6">
                    @php
                        $topCustomers = \App\Models\User::take(4)->get(); // Mock logic
                    @endphp
                    @foreach($topCustomers as $customer)
                        <div class="flex items-center justify-between group">
                            <div class="flex items-center gap-4">
                                <div class="w-10 h-10 rounded-xl bg-slate-100 dark:bg-slate-800 flex items-center justify-center text-sm font-black border border-slate-200 dark:border-slate-700 group-hover:bg-primary group-hover:text-white transition-all">
                                    {{ substr($customer->name, 0, 1) }}
                                </div>
                                <div>
                                    <h4 class="text-xs font-black text-slate-800 dark:text-white">{{ $customer->name }}</h4>
                                    <p class="text-[9px] font-bold text-slate-400 uppercase tracking-tighter">74 Order Lifetime</p>
                                </div>
                            </div>
                            <div class="text-right">
                                <span class="text-[10px] font-black text-primary">৳14,200</span>
                            </div>
                        </div>
                    @endforeach
                </div>
                <button class="w-full py-4 bg-slate-50 dark:bg-slate-800 rounded-2xl text-[9px] font-black text-slate-500 uppercase tracking-widest hover:text-primary transition-all">
                    Expand Insights Log →
                </button>
            </div>

            <!-- Operational Insights -->
            <div class="card-premium bg-[#1e293b] text-white border-none relative overflow-hidden group">
                <h3 class="text-[10px] font-black uppercase tracking-widest opacity-60 mb-6">Best Performers</h3>
                <div class="space-y-5 relative z-10">
                    <div class="flex items-center justify-between">
                        <span class="text-xs font-bold text-slate-400">Top Selling</span>
                        <span class="text-xs font-black text-sky-400">High Performance Series</span>
                    </div>
                    <div class="flex items-center justify-between">
                        <span class="text-xs font-bold text-slate-400">Most Popular Store</span>
                        <span class="text-xs font-black text-accent">Matrix Tech Hub</span>
                    </div>
                    <div class="flex items-center justify-between">
                        <span class="text-xs font-bold text-slate-400">Top Delivery Rider</span>
                        <span class="text-xs font-black text-emerald-400">Rider #2841</span>
                    </div>
                </div>
                <div class="absolute -right-4 -bottom-4 opacity-[0.05] text-7xl font-black italic select-none">INTEL</div>
            </div>
        </div>
    </div>
</div>

{{-- Add Chart.js to layout for analytics --}}
@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const ctx = document.getElementById('salesChart');
        if (ctx) {
            document.getElementById('chartPlaceholder').style.display = 'none';
            new Chart(ctx, {
                type: 'line',
                data: {
                    labels: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul'],
                    datasets: [{
                        label: 'Gross Revenue',
                        data: [12000, 19000, 15000, 25000, 22000, 30000, 35000],
                        borderColor: '#2563eb',
                        borderWidth: 4,
                        tension: 0.4,
                        fill: true,
                        backgroundColor: (context) => {
                            const ctx = context.chart.ctx;
                            const gradient = ctx.createLinearGradient(0, 0, 0, 400);
                            gradient.addColorStop(0, 'rgba(37, 99, 235, 0.1)');
                            gradient.addColorStop(1, 'rgba(37, 99, 235, 0)');
                            return gradient;
                        },
                        pointRadius: 0,
                        pointHoverRadius: 6,
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: { legend: { display: false } },
                    scales: {
                        y: { display: false },
                        x: { 
                            grid: { display: false },
                            ticks: { 
                                color: '#94a3b8',
                                font: { weight: '800', size: 10 }
                            }
                        }
                    }
                }
            });
        }
    });
</script>
@endpush
@endsection
