@extends('layouts.admin')
@section('title', 'Brands')
@section('page-title', 'Brands')

@section('content')
<div class="space-y-6">
    <div class="flex items-center justify-between">
        <h2 class="text-2xl font-black text-slate-800 dark:text-white uppercase tracking-tighter">Brands <span class="text-primary">({{ $brands->total() }})</span></h2>
        <a href="{{ route('admin.brands.create') }}" class="px-6 py-3 bg-slate-900 text-white rounded-2xl text-xs font-black uppercase tracking-widest hover:bg-primary transition-all">+ Add Brand</a>
    </div>
    <div class="bg-white dark:bg-slate-900 rounded-3xl border border-slate-100 dark:border-slate-800 overflow-hidden shadow-sm">
        <table class="w-full text-left">
            <thead><tr class="bg-slate-50 dark:bg-slate-800/50">
                <th class="px-8 py-5 text-[10px] font-black uppercase tracking-widest text-slate-400">Logo</th>
                <th class="px-8 py-5 text-[10px] font-black uppercase tracking-widest text-slate-400">Brand</th>
                <th class="px-8 py-5 text-[10px] font-black uppercase tracking-widest text-slate-400">Status</th>
                <th class="px-8 py-5 text-[10px] font-black uppercase tracking-widest text-slate-400 text-right">Actions</th>
            </tr></thead>
            <tbody class="divide-y divide-slate-50 dark:divide-slate-800">
                @forelse($brands as $brand)
                <tr class="hover:bg-slate-50/50 dark:hover:bg-slate-800/30 transition-colors">
                    <td class="px-8 py-4">
                        @if($brand->logo)
                            <img src="{{ Storage::url($brand->logo) }}" class="w-10 h-10 rounded-xl object-cover">
                        @else
                            <div class="w-10 h-10 rounded-xl bg-slate-100 flex items-center justify-center text-lg">🏷️</div>
                        @endif
                    </td>
                    <td class="px-8 py-4">
                        <div class="text-sm font-black text-slate-800 dark:text-white uppercase">{{ $brand->name }}</div>
                        <div class="text-[10px] text-slate-400">{{ $brand->slug }}</div>
                    </td>
                    <td class="px-8 py-4">
                        <span class="px-3 py-1 rounded-full text-[10px] font-black uppercase {{ $brand->is_active ? 'bg-emerald-50 text-emerald-600' : 'bg-slate-100 text-slate-400' }}">
                            {{ $brand->is_active ? 'Active' : 'Inactive' }}
                        </span>
                    </td>
                    <td class="px-8 py-4 text-right">
                        <div class="flex items-center justify-end gap-2">
                            <a href="{{ route('admin.brands.edit', $brand) }}" class="px-4 py-2 text-[10px] font-black uppercase bg-slate-100 hover:bg-primary hover:text-white rounded-xl transition-all">Edit</a>
                            <form action="{{ route('admin.brands.destroy', $brand) }}" method="POST" onsubmit="return confirm('Delete this brand?')">
                                @csrf @method('DELETE')
                                <button class="px-4 py-2 text-[10px] font-black uppercase bg-rose-50 text-rose-500 hover:bg-rose-500 hover:text-white rounded-xl transition-all">Delete</button>
                            </form>
                        </div>
                    </td>
                </tr>
                @empty
                <tr><td colspan="4" class="px-8 py-16 text-center text-sm text-slate-400 font-bold">No brands yet. <a href="{{ route('admin.brands.create') }}" class="text-primary underline">Add the first one.</a></td></tr>
                @endforelse
            </tbody>
        </table>
        <div class="p-8 border-t border-slate-50 dark:border-slate-800">{{ $brands->links() }}</div>
    </div>
</div>
@endsection
