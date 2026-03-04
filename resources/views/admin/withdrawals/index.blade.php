@extends('layouts.admin')

@section('title', 'Withdrawal Requests')
@section('page-title', 'Withdrawal Processing')

@section('content')
<div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-10">
    <x-admin.card class="border-l-4 border-l-amber-500">
        <p class="text-[10px] font-black uppercase tracking-widest text-muted-light">Pending Requests</p>
        <h3 class="text-3xl font-black text-light">{{ $withdrawals->where('status', 'pending')->count() }}</h3>
    </x-admin.card>
    <x-admin.card class="border-l-4 border-l-emerald-500">
        <p class="text-[10px] font-black uppercase tracking-widest text-muted-light">Processed</p>
        <h3 class="text-3xl font-black text-light">{{ $withdrawals->where('status', 'approved')->count() }}</h3>
    </h3</x-admin.card>
    <x-admin.card class="border-l-4 border-l-red-500">
        <p class="text-[10px] font-black uppercase tracking-widest text-muted-light">Declined</p>
        <h3 class="text-3xl font-black text-light">{{ $withdrawals->where('status', 'rejected')->count() }}</h3>
    </x-admin.card>
    <x-admin.card class="border-l-4 border-l-slate-900 dark:border-l-slate-700">
        <p class="text-[10px] font-black uppercase tracking-widest text-muted-light">Total Disbursed</p>
        <h3 class="text-3xl font-black text-light">৳{{ number_format($withdrawals->where('status', 'approved')->sum('amount'), 0) }}</h3>
    </x-admin.card>
</div>

<x-admin.card title="Payout Queue">
    <div class="overflow-x-auto -mx-6">
        <table class="w-full text-left border-collapse">
            <thead>
                <tr class="border-b border-light">
                    <th class="px-6 py-4 text-[10px] font-black uppercase tracking-widest text-muted-light">Beneficiary</th>
                    <th class="px-6 py-4 text-[10px] font-black uppercase tracking-widest text-muted-light">Amount</th>
                    <th class="px-6 py-4 text-[10px] font-black uppercase tracking-widest text-muted-light text-center">Transfer Method</th>
                    <th class="px-6 py-4 text-[10px] font-black uppercase tracking-widest text-muted-light">Process Status</th>
                    <th class="px-6 py-4 text-[10px] font-black uppercase tracking-widest text-muted-light">Request Date</th>
                    <th class="px-6 py-4 text-[10px] font-black uppercase tracking-widest text-muted-light text-right">Action</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-light">
                @forelse($withdrawals as $withdrawal)
                    <tr class="group hover:bg-slate-50 dark:hover:bg-slate-800/50 transition-colors">
                        <td class="px-6 py-4">
                            <div class="text-sm font-black text-light">{{ $withdrawal->wallet->user->name }}</div>
                            <div class="text-[10px] text-muted-light font-bold uppercase tracking-tighter">{{ $withdrawal->wallet->user->phone }}</div>
                        </td>
                        <td class="px-6 py-4">
                            <div class="text-lg font-black text-light">৳{{ number_format($withdrawal->amount, 2) }}</div>
                            <div class="text-[10px] text-muted-light font-bold uppercase tracking-widest">{{ $withdrawal->wallet->wallet_type }} FEE: ৳0.00</div>
                        </td>
                        <td class="px-6 py-4 text-center">
                            <span class="px-3 py-1 rounded-xl bg-slate-100 dark:bg-slate-800 text-[10px] font-black text-light border border-light uppercase">
                                {{ $withdrawal->payment_method }}
                            </span>
                        </td>
                        <td class="px-6 py-4">
                            @if($withdrawal->status === 'pending')
                                <span class="inline-flex items-center gap-1.5 py-1.5 px-3 rounded-full text-[10px] font-black bg-amber-100 text-amber-700 dark:bg-amber-900/40 dark:text-amber-400">
                                    <span class="w-1.5 h-1.5 rounded-full bg-amber-500"></span> PENDING APPROVAL
                                </span>
                            @elseif($withdrawal->status === 'approved')
                                <span class="inline-flex items-center gap-1.5 py-1.5 px-3 rounded-full text-[10px] font-black bg-emerald-100 text-emerald-700 dark:bg-emerald-900/40 dark:text-emerald-400">
                                    <span class="w-1.5 h-1.5 rounded-full bg-emerald-500"></span> DISBURSED
                                </span>
                            @else
                                <span class="inline-flex items-center gap-1.5 py-1.5 px-3 rounded-full text-[10px] font-black bg-red-100 text-red-700 dark:bg-red-900/40 dark:text-red-400">
                                    <span class="w-1.5 h-1.5 rounded-full bg-red-500"></span> REJECTED
                                </span>
                            @endif
                        </td>
                        <td class="px-6 py-4 text-sm font-bold text-muted-light">
                            {{ $withdrawal->created_at->format('M d, Y') }}
                        </td>
                        <td class="px-6 py-4 text-right">
                            <a href="{{ route('admin.withdrawals.show', $withdrawal) }}" class="px-4 py-2 rounded-xl bg-slate-900 text-white text-[10px] font-black hover:bg-slate-800 transition uppercase tracking-widest shadow-xl shadow-slate-900/10 inline-block">
                                Process
                            </a>
                        </td>
                    </tr>
                @empty
                    <tr><td colspan="6" class="px-6 py-12 text-center text-muted-light italic">No payout requests in queue.</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
    
    @if($withdrawals->hasPages())
        <div class="mt-8">{{ $withdrawals->links() }}</div>
    @endif
</x-admin.card>
@endsection
