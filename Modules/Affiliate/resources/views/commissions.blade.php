@extends('layouts.customer')
@section('title', 'Affiliate Commissions')
@section('page-title', 'Commissions')

@section('content')
<div class="space-y-8">
    {{-- Nav --}}
    <div class="flex flex-wrap gap-2">
        @foreach([['affiliate.dashboard','🏠 Dashboard'],['affiliate.links','🔗 Links'],['affiliate.commissions','💰 Commissions'],['affiliate.analytics','📊 Analytics'],['affiliate.withdraw','🏦 Withdraw']] as [$r,$l])
        <a href="{{ route($r) }}" class="px-4 py-2 rounded-2xl text-[10px] font-black uppercase tracking-widest {{ request()->routeIs($r) ? 'bg-indigo-600 text-white' : 'bg-slate-100 text-slate-500 hover:bg-slate-200 dark:bg-slate-800 dark:text-slate-300' }} transition-all">{{ $l }}</a>
        @endforeach
    </div>

    {{-- Summary --}}
    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
        <div class="bg-emerald-50 dark:bg-emerald-900/10 border border-emerald-100 dark:border-emerald-800 rounded-3xl p-6">
            <div class="text-2xl font-black text-emerald-700">৳{{ number_format($totalApproved, 2) }}</div>
            <div class="text-[10px] font-black text-emerald-500 uppercase tracking-widest mt-1">Total Approved</div>
        </div>
        <div class="bg-amber-50 dark:bg-amber-900/10 border border-amber-100 dark:border-amber-800 rounded-3xl p-6">
            <div class="text-2xl font-black text-amber-700">৳{{ number_format($totalPending, 2) }}</div>
            <div class="text-[10px] font-black text-amber-500 uppercase tracking-widest mt-1">Pending Review</div>
        </div>
    </div>

    {{-- Status Filter --}}
    <div class="flex gap-2 flex-wrap">
        @foreach(['all' => 'All', 'pending' => 'Pending', 'approved' => 'Approved', 'rejected' => 'Rejected'] as $s => $label)
        <a href="{{ route('affiliate.commissions', ['status' => $s]) }}" class="px-4 py-2 rounded-2xl text-[10px] font-black uppercase tracking-widest {{ $status === $s ? 'bg-indigo-600 text-white' : 'bg-slate-100 text-slate-500 dark:bg-slate-800 dark:text-slate-300 hover:bg-slate-200' }} transition-all">{{ $label }}</a>
        @endforeach
    </div>

    {{-- Commissions Table --}}
    <div class="bg-white dark:bg-slate-900 rounded-3xl border border-slate-100 dark:border-slate-800 overflow-hidden shadow-sm">
        <table class="w-full text-left">
            <thead><tr class="bg-slate-50 dark:bg-slate-800/50">
                <th class="px-8 py-4 text-[10px] font-black uppercase tracking-widest text-slate-400">Order</th>
                <th class="px-8 py-4 text-[10px] font-black uppercase tracking-widest text-slate-400">Order Amount</th>
                <th class="px-8 py-4 text-[10px] font-black uppercase tracking-widest text-slate-400">Commission</th>
                <th class="px-8 py-4 text-[10px] font-black uppercase tracking-widest text-slate-400">Status</th>
                <th class="px-8 py-4 text-[10px] font-black uppercase tracking-widest text-slate-400">Date</th>
            </tr></thead>
            <tbody class="divide-y divide-slate-50 dark:divide-slate-800">
                @forelse($commissions as $c)
                <tr class="hover:bg-slate-50/50 dark:hover:bg-slate-800/30 transition-colors">
                    <td class="px-8 py-4 text-sm font-black text-indigo-600">#{{ $c->order_id }}</td>
                    <td class="px-8 py-4 text-sm font-bold text-slate-600 dark:text-slate-300">৳{{ number_format($c->order_amount, 2) }}</td>
                    <td class="px-8 py-4 text-sm font-black text-emerald-600">+৳{{ number_format($c->commission_amount, 2) }} <span class="text-[9px] text-slate-400">({{ $c->commission_percentage }}%)</span></td>
                    <td class="px-8 py-4">
                        @php $cColor = match($c->status) { 'approved' => 'emerald', 'pending' => 'amber', 'rejected' => 'rose', default => 'slate' }; @endphp
                        <span class="px-3 py-1 rounded-full text-[9px] font-black uppercase bg-{{ $cColor }}-50 text-{{ $cColor }}-600">{{ $c->status }}</span>
                    </td>
                    <td class="px-8 py-4 text-[10px] font-bold text-slate-400 uppercase">{{ $c->created_at->format('d M Y') }}</td>
                </tr>
                @empty
                <tr><td colspan="5" class="px-8 py-16 text-center text-sm text-slate-400 font-bold">No commissions yet. Share your affiliate links!</td></tr>
                @endforelse
            </tbody>
        </table>
        <div class="p-8 border-t border-slate-50 dark:border-slate-800">{{ $commissions->links() }}</div>
    </div>
</div>
@endsection
