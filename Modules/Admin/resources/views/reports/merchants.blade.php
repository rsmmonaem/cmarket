@extends('layouts.admin')
@section('title', 'Merchant Performance')
@section('page-title', 'Merchant Stats')

@section('content')
<div class="space-y-6">
    <div class="bg-white dark:bg-slate-900 rounded-3xl border border-slate-100 dark:border-slate-800 overflow-hidden shadow-sm">
        <div class="px-8 py-5 border-b border-slate-50 dark:border-slate-800 flex items-center justify-between">
            <h4 class="text-[10px] font-black uppercase tracking-[0.2em] text-slate-400">Merchant Performance Matrix</h4>
            <span class="text-[10px] font-black text-slate-400 uppercase">{{ $merchants->total() }} total</span>
        </div>
        <table class="w-full text-left">
            <thead><tr class="bg-slate-50 dark:bg-slate-800/50">
                <th class="px-8 py-4 text-[10px] font-black uppercase tracking-widest text-slate-400">Merchant</th>
                <th class="px-8 py-4 text-[10px] font-black uppercase tracking-widest text-slate-400">Products</th>
                <th class="px-8 py-4 text-[10px] font-black uppercase tracking-widest text-slate-400">Status</th>
                <th class="px-8 py-4 text-[10px] font-black uppercase tracking-widest text-slate-400">Joined</th>
                <th class="px-8 py-4 text-right text-[10px] font-black uppercase tracking-widest text-slate-400">Action</th>
            </tr></thead>
            <tbody class="divide-y divide-slate-50 dark:divide-slate-800">
                @forelse($merchants as $merchant)
                <tr class="hover:bg-slate-50/50 dark:hover:bg-slate-800/30 transition-colors">
                    <td class="px-8 py-4">
                        <div class="text-sm font-black text-slate-800 dark:text-white uppercase">{{ $merchant->business_name }}</div>
                        <div class="text-[10px] text-slate-400">{{ $merchant->user->email ?? '—' }}</div>
                    </td>
                    <td class="px-8 py-4">
                        <span class="px-3 py-1 bg-primary/10 text-primary rounded-full text-[10px] font-black">{{ $merchant->products_count }}</span>
                    </td>
                    <td class="px-8 py-4">
                        @php $color = match($merchant->status) { 'approved' => 'emerald', 'pending' => 'amber', 'rejected' => 'rose', default => 'slate' }; @endphp
                        <span class="px-3 py-1 rounded-full text-[10px] font-black bg-{{ $color }}-50 text-{{ $color }}-600 uppercase">{{ $merchant->status }}</span>
                    </td>
                    <td class="px-8 py-4 text-[10px] font-bold text-slate-400 uppercase">{{ $merchant->created_at->format('d M Y') }}</td>
                    <td class="px-8 py-4 text-right">
                        <a href="{{ route('admin.merchants.show', $merchant) }}" class="px-4 py-2 text-[10px] font-black uppercase bg-slate-100 hover:bg-primary hover:text-white rounded-xl transition-all">View</a>
                    </td>
                </tr>
                @empty
                <tr><td colspan="5" class="px-8 py-16 text-center text-sm text-slate-400 font-bold">No merchant data available.</td></tr>
                @endforelse
            </tbody>
        </table>
        <div class="p-8 border-t border-slate-50 dark:border-slate-800">{{ $merchants->links() }}</div>
    </div>
</div>
@endsection
