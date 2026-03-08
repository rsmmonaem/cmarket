@extends('layouts.admin')
@section('title', 'Edit Designation')
@section('page-title', 'Edit Designation Tier')

@section('content')
<div class="max-w-2xl mx-auto">
    <div class="bg-white dark:bg-slate-900 rounded-3xl border border-slate-100 dark:border-slate-800 p-8 shadow-sm">
        <form action="{{ route('admin.designations.update', $designation) }}" method="POST" class="space-y-6">
            @csrf @method('PUT')
            <div class="grid grid-cols-2 gap-6">
                <div>
                    <label class="block text-[10px] font-black uppercase tracking-widest text-slate-400 mb-2">Tier Name *</label>
                    <input type="text" name="name" value="{{ old('name', $designation->name) }}" required class="w-full px-5 py-4 rounded-2xl bg-slate-50 dark:bg-slate-800 border-transparent focus:border-primary/30 focus:ring-4 focus:ring-primary/5 text-sm font-bold transition-all">
                </div>
                <div>
                    <label class="block text-[10px] font-black uppercase tracking-widest text-slate-400 mb-2">Commission Rate (%) *</label>
                    <input type="number" name="commission_rate" value="{{ old('commission_rate', $designation->commission_rate) }}" step="0.01" min="0" max="100" required class="w-full px-5 py-4 rounded-2xl bg-slate-50 dark:bg-slate-800 border-transparent focus:border-primary/30 text-sm font-bold transition-all">
                </div>
            </div>
            <div>
                <label class="block text-[10px] font-black uppercase tracking-widest text-slate-400 mb-2">Description</label>
                <textarea name="description" rows="2" class="w-full px-5 py-4 rounded-2xl bg-slate-50 dark:bg-slate-800 border-transparent text-sm font-bold transition-all">{{ old('description', $designation->description) }}</textarea>
            </div>
            <div class="grid grid-cols-3 gap-4">
                <div>
                    <label class="block text-[10px] font-black uppercase tracking-widest text-slate-400 mb-2">Sales Count</label>
                    <input type="number" name="criteria[sales_count]" value="{{ old('criteria.sales_count', $designation->criteria['sales_count'] ?? 0) }}" min="0" class="w-full px-4 py-4 rounded-2xl bg-slate-50 dark:bg-slate-800 border-transparent text-sm font-bold transition-all">
                </div>
                <div>
                    <label class="block text-[10px] font-black uppercase tracking-widest text-slate-400 mb-2">Referral Count</label>
                    <input type="number" name="criteria[referral_count]" value="{{ old('criteria.referral_count', $designation->criteria['referral_count'] ?? 0) }}" min="0" class="w-full px-4 py-4 rounded-2xl bg-slate-50 dark:bg-slate-800 border-transparent text-sm font-bold transition-all">
                </div>
                <div>
                    <label class="block text-[10px] font-black uppercase tracking-widest text-slate-400 mb-2">Sort Order</label>
                    <input type="number" name="sort_order" value="{{ old('sort_order', $designation->sort_order) }}" min="0" class="w-full px-4 py-4 rounded-2xl bg-slate-50 dark:bg-slate-800 border-transparent text-sm font-bold transition-all">
                </div>
            </div>
            <div class="flex items-center gap-3">
                <input type="checkbox" name="is_active" id="is_active" value="1" {{ $designation->is_active ? 'checked' : '' }} class="w-5 h-5 rounded-lg accent-primary">
                <label for="is_active" class="text-sm font-black text-slate-700 dark:text-slate-300 uppercase tracking-widest">Active</label>
            </div>
            <div class="flex items-center gap-4 pt-4 border-t border-slate-50 dark:border-slate-800">
                <button type="submit" class="px-8 py-4 bg-slate-900 hover:bg-primary text-white rounded-2xl text-xs font-black uppercase tracking-widest transition-all">Update Tier</button>
                <a href="{{ route('admin.designations.index') }}" class="px-8 py-4 bg-slate-100 text-slate-600 rounded-2xl text-xs font-black uppercase tracking-widest hover:bg-slate-200 transition-all">Cancel</a>
            </div>
        </form>
    </div>
</div>
@endsection
