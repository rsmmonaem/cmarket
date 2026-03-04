@extends('layouts.admin')

@section('title', 'Admin Dashboard')
@section('page-title', 'Dashboard Overview')

@section('content')
<div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-10">
    <x-admin.card class="border-l-4 border-l-slate-900">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-xs font-black uppercase tracking-widest text-muted-light mb-1">Total Users</p>
                <h3 class="text-3xl font-black text-light">{{ \App\Models\User::count() }}</h3>
            </div>
            <div class="w-12 h-12 rounded-2xl bg-slate-100 dark:bg-slate-800 flex items-center justify-center text-2xl">👥</div>
        </div>
    </x-admin.card>

    <x-admin.card class="border-l-4 border-l-sky-500">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-xs font-black uppercase tracking-widest text-muted-light mb-1">Pending KYC</p>
                <h3 class="text-3xl font-black text-light">{{ \App\Models\Kyc::where('status', 'pending')->count() }}</h3>
            </div>
            <div class="w-12 h-12 rounded-2xl bg-sky-50 dark:bg-sky-900/20 flex items-center justify-center text-2xl">✅</div>
        </div>
    </x-admin.card>

    <x-admin.card class="border-l-4 border-l-emerald-500">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-xs font-black uppercase tracking-widest text-muted-light mb-1">Total Orders</p>
                <h3 class="text-3xl font-black text-light">{{ \App\Models\Order::count() }}</h3>
            </div>
            <div class="w-12 h-12 rounded-2xl bg-emerald-50 dark:bg-emerald-900/20 flex items-center justify-center text-2xl">🛍️</div>
        </div>
    </x-admin.card>

    <x-admin.card class="border-l-4 border-l-amber-500">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-xs font-black uppercase tracking-widest text-muted-light mb-1">Pending Withdrawals</p>
                <h3 class="text-3xl font-black text-light">{{ \App\Models\Withdrawal::where('status', 'pending')->count() }}</h3>
            </div>
            <div class="w-12 h-12 rounded-2xl bg-amber-50 dark:bg-amber-900/20 flex items-center justify-center text-2xl">💸</div>
        </div>
    </x-admin.card>
</div>

<div class="grid grid-cols-1 lg:grid-cols-2 gap-8 mb-10">
    <x-admin.card title="Recent Orders">
        <div class="space-y-4">
            @php $recentOrders = \App\Models\Order::with('user')->latest()->take(5)->get(); @endphp
            @forelse($recentOrders as $order)
                <div class="flex items-center justify-between p-4 rounded-2xl bg-slate-50 dark:bg-slate-800/50 border border-slate-100 dark:border-slate-800">
                    <div class="flex items-center gap-4">
                        <div class="w-10 h-10 rounded-xl bg-white dark:bg-slate-700 flex items-center justify-center shadow-sm">
                            📦
                        </div>
                        <div>
                            <div class="text-sm font-bold text-light">#{{ $order->order_number }}</div>
                            <div class="text-[10px] text-muted-light font-bold uppercase tracking-wider">{{ $order->user->name ?? 'Guest' }}</div>
                        </div>
                    </div>
                    <div class="text-right">
                        <div class="text-sm font-black text-light">৳{{ number_format($order->total_amount, 2) }}</div>
                        <div class="text-[10px] font-black uppercase tracking-widest {{ $order->status === 'paid' ? 'text-emerald-500' : 'text-amber-500' }}">
                            {{ strtoupper($order->status) }}
                        </div>
                    </div>
                </div>
            @empty
                <p class="text-center text-muted-light py-10">No recent orders found.</p>
            @endforelse
        </div>
        <x-slot name="footer">
            <a href="{{ route('admin.orders.index') }}" class="text-sky-500 font-bold hover:underline">View all orders →</a>
        </x-slot>
    </x-admin.card>

    <x-admin.card title="Quick Actions">
        <div class="grid grid-cols-2 gap-4">
            <a href="{{ route('admin.kyc.index') }}" class="p-6 rounded-3xl bg-slate-900 text-white hover:bg-slate-800 transition shadow-xl shadow-slate-900/10 flex flex-col items-center text-center">
                <span class="text-3xl mb-3">✅</span>
                <span class="text-xs font-black uppercase tracking-widest">Verify KYC</span>
            </a>
            <a href="{{ route('admin.users.index') }}" class="p-6 rounded-3xl bg-sky-500 text-white hover:bg-sky-400 transition shadow-xl shadow-sky-500/10 flex flex-col items-center text-center">
                <span class="text-3xl mb-3">👥</span>
                <span class="text-xs font-black uppercase tracking-widest">Manage Users</span>
            </a>
            <a href="{{ route('admin.products.index') }}" class="p-6 rounded-3xl border-2 border-slate-100 dark:border-slate-800 hover:bg-slate-50 dark:hover:bg-slate-800/50 transition flex flex-col items-center text-center">
                <span class="text-3xl mb-3">📦</span>
                <span class="text-xs font-black uppercase tracking-widest text-light">Stock Check</span>
            </a>
            <a href="{{ route('admin.wallets.index') }}" class="p-6 rounded-3xl border-2 border-slate-100 dark:border-slate-800 hover:bg-slate-50 dark:hover:bg-slate-800/50 transition flex flex-col items-center text-center">
                <span class="text-3xl mb-3">💰</span>
                <span class="text-xs font-black uppercase tracking-widest text-light">Wallet Audit</span>
            </a>
        </div>
    </x-admin.card>
</div>
@endsection
