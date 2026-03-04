@extends('layouts.admin')

@section('title', 'Withdrawal Requests')
@section('page-title', 'Withdrawal Processing')

@section('content')
<div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-10">
    <div class="stat-card-custom" style="background: linear-gradient(135deg, #f59e0b 0%, #d97706 100%);">
        <h3 class="text-[10px] font-black uppercase tracking-widest opacity-80 mb-2">Pending Requests</h3>
        <div class="value text-3xl font-black text-white">{{ $withdrawals->where('status', 'pending')->count() }}</div>
    </div>
    <div class="stat-card-custom" style="background: linear-gradient(135deg, #10b981 0%, #059669 100%);">
        <h3 class="text-[10px] font-black uppercase tracking-widest opacity-80 mb-2">Processed</h3>
        <div class="value text-3xl font-black text-white">{{ $withdrawals->where('status', 'approved')->count() }}</div>
    </div>
    <div class="stat-card-custom" style="background: linear-gradient(135deg, #ef4444 0%, #dc2626 100%);">
        <h3 class="text-[10px] font-black uppercase tracking-widest opacity-80 mb-2">Declined</h3>
        <div class="value text-3xl font-black text-white">{{ $withdrawals->where('status', 'rejected')->count() }}</div>
    </div>
    <div class="stat-card-custom" style="background: linear-gradient(135deg, #1e293b 0%, #0f172a 100%);">
        <h3 class="text-[10px] font-black uppercase tracking-widest opacity-80 mb-2">Total Disbursed</h3>
        <div class="value text-3xl font-black text-white">৳{{ number_format($withdrawals->where('status', 'approved')->sum('amount'), 0) }}</div>
    </div>
</div>

<x-admin.card title="Payout Queue">
    <div class="overflow-x-auto">
        <table class="w-full text-left border-collapse">
            <thead>
                <tr class="border-b border-light bg-slate-50 dark:bg-slate-900/50">
                    <th class="px-6 py-4 text-[10px] font-black uppercase tracking-widest text-muted-light">Beneficiary</th>
                    <th class="px-6 py-4 text-[10px] font-black uppercase tracking-widest text-muted-light">Amount</th>
                    <th class="px-6 py-4 text-[10px] font-black uppercase tracking-widest text-muted-light">Transfer via</th>
                    <th class="px-6 py-4 text-[10px] font-black uppercase tracking-widest text-muted-light">Process Status</th>
                    <th class="px-6 py-4 text-[10px] font-black uppercase tracking-widest text-muted-light">Request Date</th>
                    <th class="px-6 py-4 text-[10px] font-black uppercase tracking-widest text-muted-light text-right">Action</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-light">
                @forelse($withdrawals as $withdrawal)
                    <tr class="group hover:bg-slate-50 dark:hover:bg-slate-800/50 transition-colors">
                        <td class="px-6 py-4">
                            <div class="flex items-center gap-3">
                                <div class="w-10 h-10 rounded-xl bg-primary text-white flex items-center justify-center font-black text-sm">
                                    {{ substr($withdrawal->wallet->user->name, 0, 1) }}
                                </div>
                                <div>
                                    <div class="text-sm font-black text-light">{{ $withdrawal->wallet->user->name }}</div>
                                    <div class="text-[10px] text-muted-light font-bold uppercase tracking-tighter">{{ $withdrawal->wallet->user->phone }}</div>
                                </div>
                            </div>
                        </td>
                        <td class="px-6 py-4">
                            <div class="text-lg font-black text-light">৳{{ number_format($withdrawal->amount, 2) }}</div>
                            <div class="text-[10px] text-muted-light font-black uppercase tracking-widest">
                                Wallet: <span class="text-primary-dark dark:text-sky-400">{{ $withdrawal->wallet->wallet_type }}</span>
                            </div>
                        </td>
                        <td class="px-6 py-4">
                            <span class="px-3 py-1.5 rounded-xl bg-white dark:bg-slate-800 text-[10px] font-black text-light border border-light shadow-sm uppercase tracking-wider">
                                {{ str_replace('_', ' ', $withdrawal->payment_method) }}
                            </span>
                        </td>
                        <td class="px-6 py-4">
                            @if($withdrawal->status === 'pending')
                                <span class="inline-flex items-center gap-1.5 py-1.5 px-3 rounded-full text-[10px] font-black bg-amber-100/50 text-amber-700 dark:bg-amber-900/30 dark:text-amber-400 border border-amber-200/50 dark:border-amber-primary/30">
                                    <span class="w-2 h-2 rounded-full bg-amber-500 animate-pulse"></span> QUEUED
                                </span>
                            @elseif($withdrawal->status === 'approved')
                                <span class="inline-flex items-center gap-1.5 py-1.5 px-3 rounded-full text-[10px] font-black bg-emerald-100/50 text-emerald-700 dark:bg-emerald-900/30 dark:text-emerald-400 border border-emerald-200/50 dark:border-emerald-primary/30">
                                    <span class="w-2 h-2 rounded-full bg-emerald-500"></span> COMPLETED
                                </span>
                            @else
                                <span class="inline-flex items-center gap-1.5 py-1.5 px-3 rounded-full text-[10px] font-black bg-red-100/50 text-red-700 dark:bg-red-900/30 dark:text-red-400 border border-red-200/50 dark:border-red-primary/30">
                                    <span class="w-2 h-2 rounded-full bg-red-500"></span> DECLINED
                                </span>
                            @endif
                        </td>
                        <td class="px-6 py-4 text-xs font-bold text-muted-light">
                            {{ $withdrawal->created_at->format('M d, Y') }}
                            <div class="text-[10px] opacity-60 font-black">{{ $withdrawal->created_at->format('h:i A') }}</div>
                        </td>
                        <td class="px-6 py-4 text-right">
                            <a href="{{ route('admin.withdrawals.show', $withdrawal) }}" class="inline-flex items-center justify-center px-4 py-2 rounded-xl bg-primary text-white text-[10px] font-black hover:opacity-90 transition uppercase tracking-widest shadow-lg shadow-primary/20">
                                Review Request
                            </a>
                        </td>
                    </tr>
                @empty
                    <tr><td colspan="6" class="px-6 py-20 text-center text-muted-light italic font-medium">No pending payout requests found in your queue.</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
    
    @if($withdrawals->hasPages())
        <div class="mt-8 border-t border-light pt-6">{{ $withdrawals->links() }}</div>
    @endif
</x-admin.card>
@endsection
