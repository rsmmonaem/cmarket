@extends('layouts.admin')
@section('title', 'Rider Profile')
@section('page-title', 'Rider Profile')

@section('content')
<div class="max-w-4xl mx-auto space-y-6">
    {{-- Profile Card --}}
    <div class="bg-white dark:bg-slate-900 rounded-3xl border border-slate-100 dark:border-slate-800 p-8 shadow-sm">
        <div class="flex items-center justify-between mb-8">
            <div class="flex items-center gap-6">
                <div class="w-20 h-20 rounded-3xl bg-primary/10 flex items-center justify-center text-4xl">🚴</div>
                <div>
                    <h3 class="text-2xl font-black text-slate-800 dark:text-white uppercase tracking-tighter">{{ $rider->user->name }}</h3>
                    <p class="text-[10px] font-black text-slate-400 uppercase tracking-[0.2em] mt-1">{{ $rider->user->email }} • {{ $rider->user->phone }}</p>
                </div>
            </div>
            <div>
                @if($rider->status === 'pending')
                <div class="flex gap-2">
                    <form action="{{ route('admin.riders.approve', $rider) }}" method="POST">
                        @csrf
                        <button class="px-6 py-3 bg-emerald-500 text-white rounded-2xl text-[10px] font-black uppercase tracking-widest hover:bg-emerald-600 transition-all">✓ Approve</button>
                    </form>
                    <form action="{{ route('admin.riders.reject', $rider) }}" method="POST">
                        @csrf
                        <button class="px-6 py-3 bg-rose-500 text-white rounded-2xl text-[10px] font-black uppercase tracking-widest hover:bg-rose-600 transition-all">✗ Reject</button>
                    </form>
                </div>
                @elseif($rider->status === 'approved')
                <form action="{{ route('admin.riders.suspend', $rider) }}" method="POST">
                    @csrf
                    <button class="px-6 py-3 bg-amber-500 text-white rounded-2xl text-[10px] font-black uppercase tracking-widest hover:bg-amber-600 transition-all">⏸ Suspend</button>
                </form>
                @endif
            </div>
        </div>
        <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
            @php
                $totalDeliveries = $rider->deliveries->count();
                $statusBadge = match($rider->status) {
                    'approved' => 'bg-emerald-50 text-emerald-700',
                    'pending'  => 'bg-amber-50 text-amber-700',
                    'rejected' => 'bg-rose-50 text-rose-700',
                    'suspended'=> 'bg-slate-100 text-slate-500',
                    default    => 'bg-slate-100 text-slate-500'
                };
            @endphp
            <div class="bg-slate-50 dark:bg-slate-800 rounded-2xl p-4 text-center">
                <div class="text-2xl font-black text-slate-800 dark:text-white">{{ $totalDeliveries }}</div>
                <div class="text-[9px] font-black text-slate-400 uppercase tracking-widest mt-1">Total Deliveries</div>
            </div>
            <div class="bg-slate-50 dark:bg-slate-800 rounded-2xl p-4 text-center">
                <span class="px-3 py-1.5 rounded-full text-[10px] font-black uppercase {{ $statusBadge }}">{{ $rider->status }}</span>
                <div class="text-[9px] font-black text-slate-400 uppercase tracking-widest mt-2">Status</div>
            </div>
            <div class="bg-slate-50 dark:bg-slate-800 rounded-2xl p-4 text-center">
                <div class="text-sm font-black text-slate-800 dark:text-white">{{ $rider->vehicle_type ?? 'N/A' }}</div>
                <div class="text-[9px] font-black text-slate-400 uppercase tracking-widest mt-1">Vehicle</div>
            </div>
            <div class="bg-slate-50 dark:bg-slate-800 rounded-2xl p-4 text-center">
                <div class="text-sm font-black text-slate-800 dark:text-white">{{ $rider->created_at->format('d M Y') }}</div>
                <div class="text-[9px] font-black text-slate-400 uppercase tracking-widest mt-1">Joined</div>
            </div>
        </div>
    </div>

    {{-- Deliveries --}}
    <div class="bg-white dark:bg-slate-900 rounded-3xl border border-slate-100 dark:border-slate-800 overflow-hidden shadow-sm">
        <div class="px-8 py-5 border-b border-slate-50 dark:border-slate-800">
            <h4 class="text-[10px] font-black uppercase tracking-[0.2em] text-slate-400">Delivery History</h4>
        </div>
        <table class="w-full text-left">
            <thead><tr class="bg-slate-50 dark:bg-slate-800/50">
                <th class="px-8 py-4 text-[10px] font-black uppercase tracking-widest text-slate-400">Order</th>
                <th class="px-8 py-4 text-[10px] font-black uppercase tracking-widest text-slate-400">Status</th>
                <th class="px-8 py-4 text-[10px] font-black uppercase tracking-widest text-slate-400">Date</th>
            </tr></thead>
            <tbody class="divide-y divide-slate-50 dark:divide-slate-800">
                @forelse($rider->deliveries ?? [] as $delivery)
                <tr class="hover:bg-slate-50/50 transition-colors">
                    <td class="px-8 py-4 text-sm font-black text-primary">#{{ $delivery->order_id }}</td>
                    <td class="px-8 py-4">
                        <span class="px-3 py-1 rounded-full text-[10px] font-black bg-emerald-50 text-emerald-600 uppercase">{{ $delivery->status }}</span>
                    </td>
                    <td class="px-8 py-4 text-[10px] font-bold text-slate-400 uppercase">{{ $delivery->created_at->format('d M Y') }}</td>
                </tr>
                @empty
                <tr><td colspan="3" class="px-8 py-10 text-center text-sm text-slate-400 font-bold">No deliveries yet.</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div class="flex justify-end">
        <a href="{{ route('admin.riders.index') }}" class="px-6 py-3 bg-slate-100 text-slate-600 rounded-2xl text-xs font-black uppercase tracking-widest hover:bg-slate-200 transition-all">← Back to Riders</a>
    </div>
</div>
@endsection
