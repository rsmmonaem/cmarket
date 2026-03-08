@extends('layouts.admin')
@section('title', 'Add Attribute')
@section('page-title', 'Add Attribute')

@section('content')
<div class="max-w-2xl mx-auto">
    <div class="bg-white dark:bg-slate-900 rounded-3xl border border-slate-100 dark:border-slate-800 p-8 shadow-sm">
        <form action="{{ route('admin.attributes.store') }}" method="POST" class="space-y-6">
            @csrf
            <div>
                <label class="block text-[10px] font-black uppercase tracking-widest text-slate-400 mb-2">Attribute Name *</label>
                <input type="text" name="name" value="{{ old('name') }}" required class="w-full px-5 py-4 rounded-2xl bg-slate-50 dark:bg-slate-800 border-transparent focus:border-primary/30 focus:ring-4 focus:ring-primary/5 text-sm font-bold transition-all" placeholder="e.g. Color">
                @error('name')<p class="text-rose-500 text-xs mt-1 font-bold">{{ $message }}</p>@enderror
            </div>
            <div>
                <label class="block text-[10px] font-black uppercase tracking-widest text-slate-400 mb-2">Values * <span class="text-slate-300 normal-case font-bold tracking-normal">(comma-separated)</span></label>
                <textarea name="values" rows="3" class="w-full px-5 py-4 rounded-2xl bg-slate-50 dark:bg-slate-800 border-transparent focus:border-primary/30 focus:ring-4 focus:ring-primary/5 text-sm font-bold transition-all" placeholder="Red, Blue, Green, Black">{{ old('values') }}</textarea>
                @error('values')<p class="text-rose-500 text-xs mt-1 font-bold">{{ $message }}</p>@enderror
            </div>
            <div class="flex items-center gap-4 pt-4 border-t border-slate-50 dark:border-slate-800">
                <button type="submit" class="px-8 py-4 bg-slate-900 hover:bg-primary text-white rounded-2xl text-xs font-black uppercase tracking-widest transition-all">Save Attribute</button>
                <a href="{{ route('admin.attributes.index') }}" class="px-8 py-4 bg-slate-100 text-slate-600 rounded-2xl text-xs font-black uppercase tracking-widest hover:bg-slate-200 transition-all">Cancel</a>
            </div>
        </form>
    </div>
</div>
@endsection
