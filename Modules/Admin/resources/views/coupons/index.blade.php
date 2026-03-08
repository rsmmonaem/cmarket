@extends('layouts.admin')
@section('title', 'Coupons')
@section('page-title', 'Coupons')

@section('content')
<div class="space-y-6">
    <div class="flex items-center justify-between">
        <h2 class="text-2xl font-black text-slate-800 dark:text-white uppercase tracking-tighter">Coupons <span class="text-primary">({{ $coupons->total() }})</span></h2>
        <a href="{{ route('admin.coupons.create') }}" class="px-6 py-3 bg-slate-900 text-white rounded-2xl text-xs font-black uppercase tracking-widest hover:bg-primary transition-all">+ Create Coupon</a>
    </div>
    <div class="bg-white dark:bg-slate-900 rounded-3xl border border-slate-100 dark:border-slate-800 overflow-hidden shadow-sm">
        <table class="w-full text-left">
            <thead><tr class="bg-slate-50 dark:bg-slate-800/50">
                <th class="px-8 py-5 text-[10px] font-black uppercase tracking-widest text-slate-400">Code</th>
                <th class="px-8 py-5 text-[10px] font-black uppercase tracking-widest text-slate-400">Type / Value</th>
                <th class="px-8 py-5 text-[10px] font-black uppercase tracking-widest text-slate-400">Usage</th>
                <th class="px-8 py-5 text-[10px] font-black uppercase tracking-widest text-slate-400">Validity</th>
                <th class="px-8 py-5 text-[10px] font-black uppercase tracking-widest text-slate-400">Status</th>
                <th class="px-8 py-5 text-right text-[10px] font-black uppercase tracking-widest text-slate-400">Actions</th>
            </tr></thead>
            <tbody class="divide-y divide-slate-50 dark:divide-slate-800">
                @forelse($coupons as $coupon)
                <tr class="hover:bg-slate-50/50 dark:hover:bg-slate-800/30 transition-colors">
                    <td class="px-8 py-4">
                        <span class="font-black text-primary text-sm tracking-widest bg-primary/5 px-3 py-1.5 rounded-xl">{{ $coupon->code }}</span>
                    </td>
                    <td class="px-8 py-4">
                        <div class="text-xs font-black text-slate-800 dark:text-white uppercase">{{ $coupon->type }}</div>
                        <div class="text-sm font-black text-emerald-600">{{ $coupon->type === 'percentage' ? $coupon->value . '%' : '৳' . number_format($coupon->value, 2) }}</div>
                    </td>
                    <td class="px-8 py-4 text-sm font-bold text-slate-600 dark:text-slate-300">{{ $coupon->used_count }} / {{ $coupon->usage_limit ?? '∞' }}</td>
                    <td class="px-8 py-4 text-[10px] font-bold text-slate-400 uppercase">
                        {{ $coupon->start_date?->format('d M') ?? '—' }} → {{ $coupon->end_date?->format('d M Y') ?? 'No expiry' }}
                    </td>
                    <td class="px-8 py-4">
                        <span class="px-3 py-1 rounded-full text-[10px] font-black {{ $coupon->is_active ? 'bg-emerald-50 text-emerald-600' : 'bg-slate-100 text-slate-400' }}">{{ $coupon->is_active ? 'Active' : 'Inactive' }}</span>
                    </td>
                    <td class="px-8 py-4 text-right">
                        <div class="flex items-center justify-end gap-2">
                            <a href="{{ route('admin.coupons.edit', $coupon) }}" class="px-4 py-2 text-[10px] font-black uppercase bg-slate-100 hover:bg-primary hover:text-white rounded-xl transition-all">Edit</a>
                            <form action="{{ route('admin.coupons.destroy', $coupon) }}" method="POST" onsubmit="return confirm('Delete coupon?')">
                                @csrf @method('DELETE')
                                <button class="px-4 py-2 text-[10px] font-black uppercase bg-rose-50 text-rose-500 hover:bg-rose-500 hover:text-white rounded-xl transition-all">Delete</button>
                            </form>
                        </div>
                    </td>
                </tr>
                @empty
                <tr><td colspan="6" class="px-8 py-16 text-center text-sm text-slate-400 font-bold">No coupons yet. <a href="{{ route('admin.coupons.create') }}" class="text-primary underline">Create first coupon.</a></td></tr>
                @endforelse
            </tbody>
        </table>
        <div class="p-8 border-t border-slate-50 dark:border-slate-800">{{ $coupons->links() }}</div>
    </div>
</div>
@endsection
