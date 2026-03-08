@extends('layouts.admin')
@section('title', 'Flash Deals')
@section('page-title', 'Flash Deals & Promotions')

@section('content')
<div class="space-y-6">
    <div class="flex items-center justify-between">
        <div class="flex items-center gap-4">
            <h2 class="text-2xl font-black text-slate-800 dark:text-white uppercase tracking-tighter">{{ ucfirst($type) }} Deals</h2>
            <div class="flex items-center gap-2">
                <a href="{{ route('admin.flash-deals.index', ['type' => 'flash']) }}" class="px-4 py-2 rounded-2xl text-[10px] font-black uppercase tracking-widest {{ $type === 'flash' ? 'bg-primary text-white' : 'bg-slate-100 text-slate-500 hover:bg-slate-200' }} transition-all">⚡ Flash</a>
                <a href="{{ route('admin.flash-deals.index', ['type' => 'daily']) }}" class="px-4 py-2 rounded-2xl text-[10px] font-black uppercase tracking-widest {{ $type === 'daily' ? 'bg-primary text-white' : 'bg-slate-100 text-slate-500 hover:bg-slate-200' }} transition-all">📅 Daily</a>
                <a href="{{ route('admin.flash-deals.index', ['type' => 'featured']) }}" class="px-4 py-2 rounded-2xl text-[10px] font-black uppercase tracking-widest {{ $type === 'featured' ? 'bg-primary text-white' : 'bg-slate-100 text-slate-500 hover:bg-slate-200' }} transition-all">⭐ Featured</a>
            </div>
        </div>
        <a href="{{ route('admin.flash-deals.create') }}" class="px-6 py-3 bg-slate-900 text-white rounded-2xl text-xs font-black uppercase tracking-widest hover:bg-primary transition-all">+ Create Deal</a>
    </div>
    <div class="bg-white dark:bg-slate-900 rounded-3xl border border-slate-100 dark:border-slate-800 overflow-hidden shadow-sm">
        <table class="w-full text-left">
            <thead><tr class="bg-slate-50 dark:bg-slate-800/50">
                <th class="px-8 py-5 text-[10px] font-black uppercase tracking-widest text-slate-400">Title</th>
                <th class="px-8 py-5 text-[10px] font-black uppercase tracking-widest text-slate-400">Discount</th>
                <th class="px-8 py-5 text-[10px] font-black uppercase tracking-widest text-slate-400">Duration</th>
                <th class="px-8 py-5 text-[10px] font-black uppercase tracking-widest text-slate-400">Status</th>
                <th class="px-8 py-5 text-right text-[10px] font-black uppercase tracking-widest text-slate-400">Actions</th>
            </tr></thead>
            <tbody class="divide-y divide-slate-50 dark:divide-slate-800">
                @forelse($deals as $deal)
                <tr class="hover:bg-slate-50/50 dark:hover:bg-slate-800/30 transition-colors">
                    <td class="px-8 py-4 text-sm font-black text-slate-800 dark:text-white uppercase">{{ $deal->title }}</td>
                    <td class="px-8 py-4 text-sm font-black text-primary">{{ $deal->discount_percentage }}%</td>
                    <td class="px-8 py-4 text-[10px] font-bold text-slate-400 uppercase">
                        {{ $deal->start_date->format('d M') }} → {{ $deal->end_date->format('d M Y') }}
                    </td>
                    <td class="px-8 py-4">
                        <span class="px-3 py-1 rounded-full text-[10px] font-black {{ $deal->is_active ? 'bg-emerald-50 text-emerald-600' : 'bg-slate-100 text-slate-400' }}">{{ $deal->is_active ? 'Active' : 'Inactive' }}</span>
                    </td>
                    <td class="px-8 py-4 text-right">
                        <div class="flex items-center justify-end gap-2">
                            <a href="{{ route('admin.flash-deals.edit', $deal) }}" class="px-4 py-2 text-[10px] font-black uppercase bg-slate-100 hover:bg-primary hover:text-white rounded-xl transition-all">Edit</a>
                            <form action="{{ route('admin.flash-deals.destroy', $deal) }}" method="POST" onsubmit="return confirm('Delete deal?')">
                                @csrf @method('DELETE')
                                <button class="px-4 py-2 text-[10px] font-black uppercase bg-rose-50 text-rose-500 hover:bg-rose-500 hover:text-white rounded-xl transition-all">Delete</button>
                            </form>
                        </div>
                    </td>
                </tr>
                @empty
                <tr><td colspan="5" class="px-8 py-16 text-center text-sm text-slate-400 font-bold">No {{ $type }} deals. <a href="{{ route('admin.flash-deals.create') }}" class="text-primary underline">Create one.</a></td></tr>
                @endforelse
            </tbody>
        </table>
        <div class="p-8 border-t border-slate-50 dark:border-slate-800">{{ $deals->links() }}</div>
    </div>
</div>
@endsection
