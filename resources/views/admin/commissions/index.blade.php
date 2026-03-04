@extends('layouts.admin')

@section('title', 'Commission Management')
@section('page-title', 'System Commissions')

@section('content')
<div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-10">
    <x-admin.card class="border-l-4 border-l-amber-500">
        <p class="text-[10px] font-black uppercase tracking-widest text-muted-light">Pending Payouts</p>
        <h3 class="text-3xl font-black text-light">{{ $commissions->where('status', 'pending')->count() }}</h3>
    </x-admin.card>
    <x-admin.card class="border-l-4 border-l-emerald-500">
        <p class="text-[10px] font-black uppercase tracking-widest text-muted-light">Total Disbursed</p>
        <h3 class="text-3xl font-black text-light">৳{{ number_format($commissions->where('status', 'approved')->sum('amount'), 0) }}</h3>
    </x-admin.card>
    <x-admin.card class="border-l-4 border-l-sky-500">
        <p class="text-[10px] font-black uppercase tracking-widest text-muted-light">Commission rate</p>
        <h3 class="text-3xl font-black text-light">AVG 12%</h3>
    </x-admin.card>
    <x-admin.card class="border-l-4 border-l-slate-900 dark:border-l-slate-700">
        <p class="text-[10px] font-black uppercase tracking-widest text-muted-light">Total Logs</p>
        <h3 class="text-3xl font-black text-light">{{ $commissions->total() }}</h3>
    </x-admin.card>
</div>

<x-admin.card title="Commission Audit Trail">
    <div class="overflow-x-auto -mx-6">
        <table class="w-full text-left border-collapse">
            <thead>
                <tr class="border-b border-light">
                    <th class="px-6 py-4 text-[10px] font-black uppercase tracking-widest text-muted-light">Beneficiary</th>
                    <th class="px-6 py-4 text-[10px] font-black uppercase tracking-widest text-muted-light">Amount</th>
                    <th class="px-6 py-4 text-[10px] font-black uppercase tracking-widest text-muted-light">Trigger Order</th>
                    <th class="px-6 py-4 text-[10px] font-black uppercase tracking-widest text-muted-light">Status</th>
                    <th class="px-6 py-4 text-[10px] font-black uppercase tracking-widest text-muted-light">Date</th>
                    <th class="px-6 py-4 text-[10px] font-black uppercase tracking-widest text-muted-light text-right">Action</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-light">
                @forelse($commissions as $commission)
                    <tr class="group hover:bg-slate-50 dark:hover:bg-slate-800/50 transition-colors">
                        <td class="px-6 py-4">
                            <div class="text-sm font-black text-light">{{ $commission->user->name }}</div>
                            <div class="text-[10px] text-muted-light font-bold uppercase tracking-widest">{{ $commission->commission_type }}</div>
                        </td>
                        <td class="px-6 py-4">
                            <div class="text-lg font-black text-light">৳{{ number_format($commission->amount, 2) }}</div>
                        </td>
                        <td class="px-6 py-4 font-bold text-muted-light uppercase text-xs">
                            #{{ $commission->order->order_number ?? 'SYSTEM' }}
                        </td>
                        <td class="px-6 py-4 text-center">
                            @if($commission->status === 'approved')
                                <span class="inline-flex items-center gap-1.5 py-1.5 px-3 rounded-full text-[10px] font-black bg-emerald-100 text-emerald-700 dark:bg-emerald-900/40 dark:text-emerald-400">
                                    <span class="w-1.5 h-1.5 rounded-full bg-emerald-500"></span> PAID
                                </span>
                            @elseif($commission->status === 'pending')
                                <span class="inline-flex items-center gap-1.5 py-1.5 px-3 rounded-full text-[10px] font-black bg-amber-100 text-amber-700 dark:bg-amber-900/40 dark:text-amber-400">
                                    <span class="w-1.5 h-1.5 rounded-full bg-amber-500"></span> PENDING REVIEW
                                </span>
                            @else
                                <span class="inline-flex items-center gap-1.5 py-1.5 px-3 rounded-full text-[10px] font-black bg-red-100 text-red-700 dark:bg-red-900/40 dark:text-red-400">
                                    <span class="w-1.5 h-1.5 rounded-full bg-red-500"></span> REJECTED
                                </span>
                            @endif
                        </td>
                        <td class="px-6 py-4 text-xs font-bold text-muted-light">
                            {{ $commission->created_at->format('M d, Y') }}
                        </td>
                        <td class="px-6 py-4 text-right">
                            <a href="{{ route('admin.commissions.show', $commission) }}" class="p-2 rounded-xl bg-slate-100 dark:bg-slate-800 text-light hover:bg-sky-500 hover:text-white transition shadow-sm inline-block">
                                ⚖️
                            </a>
                        </td>
                    </tr>
                @empty
                    <tr><td colspan="6" class="px-6 py-12 text-center text-muted-light italic">No commission logs found.</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>

    @if($commissions->hasPages())
        <div class="mt-8">{{ $commissions->links() }}</div>
    @endif
</x-admin.card>
@endsection
