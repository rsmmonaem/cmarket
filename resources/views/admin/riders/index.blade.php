@extends('layouts.admin')

@section('title', 'Rider Management')
@section('page-title', 'Delivery Partners')

@section('content')
<div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-10">
    <x-admin.card class="border-l-4 border-l-amber-500">
        <p class="text-[10px] font-black uppercase tracking-widest text-muted-light">Pending Approval</p>
        <h3 class="text-3xl font-black text-light">{{ $riders->where('status', 'pending')->count() }}</h3>
    </x-admin.card>
    <x-admin.card class="border-l-4 border-l-emerald-500">
        <p class="text-[10px] font-black uppercase tracking-widest text-muted-light">Active Riders</p>
        <h3 class="text-3xl font-black text-light">{{ $riders->where('status', 'approved')->count() }}</h3>
    </x-admin.card>
    <x-admin.card class="border-l-4 border-l-slate-900 dark:border-l-slate-700">
        <p class="text-[10px] font-black uppercase tracking-widest text-muted-light">Total partners</p>
        <h3 class="text-3xl font-black text-light">{{ $riders->total() }}</h3>
    </x-admin.card>
</div>

<x-admin.card title="Rider Directory">
    <div class="overflow-x-auto -mx-6">
        <table class="w-full text-left border-collapse">
            <thead>
                <tr class="border-b border-light">
                    <th class="px-6 py-4 text-[10px] font-black uppercase tracking-widest text-muted-light">Partner Detail</th>
                    <th class="px-6 py-4 text-[10px] font-black uppercase tracking-widest text-muted-light">Vehicle Type</th>
                    <th class="px-6 py-4 text-[10px] font-black uppercase tracking-widest text-muted-light">Phone</th>
                    <th class="px-6 py-4 text-[10px] font-black uppercase tracking-widest text-muted-light">Account Status</th>
                    <th class="px-6 py-4 text-[10px] font-black uppercase tracking-widest text-muted-light text-right">Action</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-light">
                @forelse($riders as $rider)
                    <tr class="group hover:bg-slate-50 dark:hover:bg-slate-800/50 transition-colors">
                        <td class="px-6 py-4">
                            <div class="text-sm font-black text-light">{{ $rider->user->name }}</div>
                            <div class="text-[10px] text-muted-light font-bold uppercase tracking-wider">ZONE: {{ $rider->zone ?? 'Dhaka' }}</div>
                        </td>
                        <td class="px-6 py-4">
                            <div class="text-sm font-bold text-light uppercase tracking-tighter">{{ $rider->vehicle_type }}</div>
                            <div class="text-[10px] text-muted-light font-black">{{ $rider->vehicle_number ?? 'N/A' }}</div>
                        </td>
                        <td class="px-6 py-4">
                             <div class="text-sm font-bold text-light">{{ $rider->phone }}</div>
                        </td>
                        <td class="px-6 py-4">
                            @if($rider->status === 'approved')
                                <span class="inline-flex items-center gap-1.5 py-1.5 px-3 rounded-full text-[10px] font-black bg-emerald-100 text-emerald-700 dark:bg-emerald-900/40 dark:text-emerald-400">
                                    <span class="w-1.5 h-1.5 rounded-full bg-emerald-500"></span> ACTIVE DELIVERY
                                </span>
                            @elseif($rider->status === 'pending')
                                <span class="inline-flex items-center gap-1.5 py-1.5 px-3 rounded-full text-[10px] font-black bg-amber-100 text-amber-700 dark:bg-amber-900/40 dark:text-amber-400">
                                    <span class="w-1.5 h-1.5 rounded-full bg-amber-500"></span> PENDING REVIEW
                                </span>
                            @else
                                <span class="inline-flex items-center gap-1.5 py-1.5 px-3 rounded-full text-[10px] font-black bg-red-100 text-red-700 dark:bg-red-900/40 dark:text-red-400">
                                    <span class="w-1.5 h-1.5 rounded-full bg-red-500"></span> SUSPENDED
                                </span>
                            @endif
                        </td>
                        <td class="px-6 py-4 text-right">
                            <a href="{{ route('admin.riders.show', $rider) }}" class="px-4 py-2 rounded-xl bg-slate-100 dark:bg-slate-800 text-light text-[10px] font-black hover:bg-sky-500 hover:text-white transition uppercase tracking-widest shadow-sm inline-block">
                                Review Profile
                            </a>
                        </td>
                    </tr>
                @empty
                    <tr><td colspan="5" class="px-6 py-12 text-center text-muted-light italic">No delivery partners registered.</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>

    @if($riders->hasPages())
        <div class="mt-8">{{ $riders->links() }}</div>
    @endif
</x-admin.card>
@endsection
