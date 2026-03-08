@extends('layouts.admin')
@section('title', 'Attributes')
@section('page-title', 'Attributes')

@section('content')
<div class="space-y-6">
    <div class="flex items-center justify-between">
        <h2 class="text-2xl font-black text-slate-800 dark:text-white uppercase tracking-tighter">Attributes <span class="text-primary">({{ $attributes->total() }})</span></h2>
        <a href="{{ route('admin.attributes.create') }}" class="px-6 py-3 bg-slate-900 text-white rounded-2xl text-xs font-black uppercase tracking-widest hover:bg-primary transition-all">+ Add Attribute</a>
    </div>
    <div class="bg-white dark:bg-slate-900 rounded-3xl border border-slate-100 dark:border-slate-800 overflow-hidden shadow-sm">
        <table class="w-full text-left">
            <thead><tr class="bg-slate-50 dark:bg-slate-800/50">
                <th class="px-8 py-5 text-[10px] font-black uppercase tracking-widest text-slate-400">Name</th>
                <th class="px-8 py-5 text-[10px] font-black uppercase tracking-widest text-slate-400">Values Count</th>
                <th class="px-8 py-5 text-[10px] font-black uppercase tracking-widest text-slate-400 text-right">Actions</th>
            </tr></thead>
            <tbody class="divide-y divide-slate-50 dark:divide-slate-800">
                @forelse($attributes as $attribute)
                <tr class="hover:bg-slate-50/50 dark:hover:bg-slate-800/30 transition-colors">
                    <td class="px-8 py-4 text-sm font-black text-slate-800 dark:text-white uppercase">{{ $attribute->name }}</td>
                    <td class="px-8 py-4">
                        <span class="px-3 py-1 bg-primary/10 text-primary rounded-full text-[10px] font-black">{{ $attribute->values_count }} values</span>
                    </td>
                    <td class="px-8 py-4 text-right">
                        <div class="flex items-center justify-end gap-2">
                            <a href="{{ route('admin.attributes.edit', $attribute) }}" class="px-4 py-2 text-[10px] font-black uppercase bg-slate-100 hover:bg-primary hover:text-white rounded-xl transition-all">Edit</a>
                            <form action="{{ route('admin.attributes.destroy', $attribute) }}" method="POST" onsubmit="return confirm('Delete?')">
                                @csrf @method('DELETE')
                                <button class="px-4 py-2 text-[10px] font-black uppercase bg-rose-50 text-rose-500 hover:bg-rose-500 hover:text-white rounded-xl transition-all">Delete</button>
                            </form>
                        </div>
                    </td>
                </tr>
                @empty
                <tr><td colspan="3" class="px-8 py-16 text-center text-sm text-slate-400 font-bold">No attributes. <a href="{{ route('admin.attributes.create') }}" class="text-primary underline">Create one.</a></td></tr>
                @endforelse
            </tbody>
        </table>
        <div class="p-8 border-t border-slate-50 dark:border-slate-800">{{ $attributes->links() }}</div>
    </div>
</div>
@endsection
