@extends('layouts.admin')
@section('title', 'Add Brand')
@section('page-title', 'Add Brand')

@section('content')
<div class="max-w-2xl mx-auto">
    <div class="bg-white dark:bg-slate-900 rounded-3xl border border-slate-100 dark:border-slate-800 p-8 shadow-sm">
        <form action="{{ route('admin.brands.store') }}" method="POST" enctype="multipart/form-data" class="space-y-6">
            @csrf
            <div>
                <label class="block text-[10px] font-black uppercase tracking-widest text-slate-400 mb-2">Brand Name *</label>
                <input type="text" name="name" value="{{ old('name') }}" required class="w-full px-5 py-4 rounded-2xl bg-slate-50 dark:bg-slate-800 border-transparent focus:border-primary/30 focus:ring-4 focus:ring-primary/5 focus:bg-white dark:focus:bg-slate-700 text-sm font-bold transition-all" placeholder="e.g. Samsung">
                @error('name')<p class="text-rose-500 text-xs mt-1 font-bold">{{ $message }}</p>@enderror
            </div>
            <div>
                <label class="block text-[10px] font-black uppercase tracking-widest text-slate-400 mb-2">Logo</label>
                <input type="file" name="logo" accept="image/*" class="w-full px-5 py-4 rounded-2xl bg-slate-50 dark:bg-slate-800 border-transparent text-sm font-bold text-slate-600 dark:text-slate-300">
            </div>
            <div class="flex items-center gap-3">
                <input type="checkbox" name="is_active" id="is_active" value="1" checked class="w-5 h-5 rounded-lg accent-primary">
                <label for="is_active" class="text-sm font-black text-slate-700 dark:text-slate-300 uppercase tracking-widest">Active</label>
            </div>
            <div class="flex items-center gap-4 pt-4 border-t border-slate-50 dark:border-slate-800">
                <button type="submit" class="px-8 py-4 bg-slate-900 hover:bg-primary text-white rounded-2xl text-xs font-black uppercase tracking-widest transition-all">Save Brand</button>
                <a href="{{ route('admin.brands.index') }}" class="px-8 py-4 bg-slate-100 text-slate-600 rounded-2xl text-xs font-black uppercase tracking-widest hover:bg-slate-200 transition-all">Cancel</a>
            </div>
        </form>
    </div>
</div>
@endsection
