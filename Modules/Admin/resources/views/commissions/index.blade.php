@extends('layouts.admin')
@section('title', 'Commissions')
@section('page-title', 'Commission Management')

@section('content')
<div class="space-y-6">
    <div class="flex items-center justify-between">
        <h2 class="text-2xl font-black text-slate-800 dark:text-white uppercase tracking-tighter">Commissions</h2>
        <div class="flex gap-2">
            <form action="{{ route('admin.commissions.bulk-approve') }}" method="POST">
                @csrf
                <button class="px-6 py-3 bg-emerald-500 hover:bg-emerald-600 text-white rounded-2xl text-xs font-black uppercase tracking-widest transition-all">Bulk Approve</button>
            </form>
        </div>
    </div>
    <div class="bg-white dark:bg-slate-900 rounded-3xl border border-slate-100 dark:border-slate-800 overflow-hidden shadow-sm">
        <table class="w-full text-left">
            <thead><tr class="bg-slate-50 dark:bg-slate-800/50">
                <th class="px-8 py-5 text-[10px] font-black uppercase tracking-widest text-slate-400">User</th>
                <th class="px-8 py-5 text-[10px] font-black uppercase tracking-widest text-slate-400">Type</th>
                <th class="px-8 py-5 text-[10px] font-black uppercase tracking-widest text-slate-400 text-right">Amount</th>
                <th class="px-8 py-5 text-[10px] font-black uppercase tracking-widest text-slate-400">Status</th>
                <th class="px-8 py-5 text-right text-[10px] font-black uppercase tracking-widest text-slate-400">Actions</th>
            </tr></thead>
            <tbody class="divide-y divide-slate-50 dark:divide-slate-800">
                @forelse($commissions as $commission)
                <tr class="hover:bg-slate-50/50 dark:hover:bg-slate-800/30 transition-colors">
                    <td class="px-8 py-4">
                        <div class="text-sm font-black text-slate-800 dark:text-white uppercase">{{ $commission->user->name }}</div>
                        <div class="text-[10px] text-slate-400">{{ $commission->user->phone }}</div>
                    </td>
                    <td class="px-8 py-4 text-[10px] font-black text-slate-500 uppercase tracking-widest">{{ $commission->type ?? 'Referral' }}</td>
                    <td class="px-8 py-4 text-right text-sm font-black text-emerald-600">৳{{ number_format($commission->amount, 2) }}</td>
                    <td class="px-8 py-4">
                        @php $c = match($commission->status) { 'approved' => 'emerald', 'pending' => 'amber', 'rejected' => 'rose', default => 'slate' }; @endphp
                        <span class="px-3 py-1 rounded-full text-[10px] font-black bg-{{ $c }}-50 text-{{ $c }}-600 uppercase">{{ $commission->status }}</span>
                    </td>
                    <td class="px-8 py-4 text-right">
                        <div class="flex items-center justify-end gap-2">
                            @if($commission->status === 'pending')
                            <form action="{{ route('admin.commissions.approve', $commission) }}" method="POST">
                                @csrf
                                <button class="px-3 py-2 text-[10px] font-black uppercase bg-emerald-50 text-emerald-600 hover:bg-emerald-500 hover:text-white rounded-xl transition-all">Approve</button>
                            </form>
                            <form action="{{ route('admin.commissions.reject', $commission) }}" method="POST">
                                @csrf
                                <button class="px-3 py-2 text-[10px] font-black uppercase bg-rose-50 text-rose-500 hover:bg-rose-500 hover:text-white rounded-xl transition-all">Reject</button>
                            </form>
                            @endif
                        </div>
                    </td>
                </tr>
                @empty
                <tr><td colspan="5" class="px-8 py-16 text-center text-sm text-slate-400 font-bold">No commission records found.</td></tr>
                @endforelse
            </tbody>
        </table>
        <div class="p-8 border-t border-slate-50 dark:border-slate-800">{{ $commissions->links() }}</div>
    </div>
</div>
@endsection
