@extends('layouts.admin')
@section('title', 'Create Coupon')
@section('page-title', 'Create Coupon')

@section('content')
<div class="max-w-2xl mx-auto">
    <div class="bg-white dark:bg-slate-900 rounded-3xl border border-slate-100 dark:border-slate-800 p-8 shadow-sm">
        <form action="{{ route('admin.coupons.store') }}" method="POST" class="space-y-6">
            @csrf
            <div class="grid grid-cols-2 gap-6">
                <div>
                    <label class="block text-[10px] font-black uppercase tracking-widest text-slate-400 mb-2">Coupon Code *</label>
                    <input type="text" name="code" value="{{ old('code', strtoupper(Str::random(8))) }}" required class="w-full px-5 py-4 rounded-2xl bg-slate-50 dark:bg-slate-800 border-transparent focus:border-primary/30 focus:ring-4 focus:ring-primary/5 text-sm font-black uppercase tracking-widest transition-all">
                    @error('code')<p class="text-rose-500 text-xs mt-1 font-bold">{{ $message }}</p>@enderror
                </div>
                <div>
                    <label class="block text-[10px] font-black uppercase tracking-widest text-slate-400 mb-2">Type *</label>
                    <select name="type" class="w-full px-5 py-4 rounded-2xl bg-slate-50 dark:bg-slate-800 border-transparent focus:border-primary/30 text-sm font-bold">
                        <option value="percentage" {{ old('type') === 'percentage' ? 'selected' : '' }}>Percentage (%)</option>
                        <option value="fixed" {{ old('type') === 'fixed' ? 'selected' : '' }}>Fixed Amount (৳)</option>
                    </select>
                </div>
            </div>
            <div class="grid grid-cols-2 gap-6">
                <div>
                    <label class="block text-[10px] font-black uppercase tracking-widest text-slate-400 mb-2">Discount Value *</label>
                    <input type="number" name="value" value="{{ old('value') }}" step="0.01" min="0" required class="w-full px-5 py-4 rounded-2xl bg-slate-50 dark:bg-slate-800 border-transparent focus:border-primary/30 focus:ring-4 focus:ring-primary/5 text-sm font-bold transition-all">
                </div>
                <div>
                    <label class="block text-[10px] font-black uppercase tracking-widest text-slate-400 mb-2">Min. Order Amount</label>
                    <input type="number" name="min_order_amount" value="{{ old('min_order_amount') }}" step="0.01" min="0" class="w-full px-5 py-4 rounded-2xl bg-slate-50 dark:bg-slate-800 border-transparent focus:border-primary/30 focus:ring-4 focus:ring-primary/5 text-sm font-bold transition-all">
                </div>
            </div>
            <div class="grid grid-cols-2 gap-6">
                <div>
                    <label class="block text-[10px] font-black uppercase tracking-widest text-slate-400 mb-2">Max Discount (৳)</label>
                    <input type="number" name="max_discount" value="{{ old('max_discount') }}" step="0.01" min="0" class="w-full px-5 py-4 rounded-2xl bg-slate-50 dark:bg-slate-800 border-transparent focus:border-primary/30 text-sm font-bold transition-all">
                </div>
                <div>
                    <label class="block text-[10px] font-black uppercase tracking-widest text-slate-400 mb-2">Usage Limit</label>
                    <input type="number" name="usage_limit" value="{{ old('usage_limit') }}" min="1" class="w-full px-5 py-4 rounded-2xl bg-slate-50 dark:bg-slate-800 border-transparent focus:border-primary/30 text-sm font-bold transition-all" placeholder="Leave blank for unlimited">
                </div>
            </div>
            <div class="grid grid-cols-2 gap-6">
                <div>
                    <label class="block text-[10px] font-black uppercase tracking-widest text-slate-400 mb-2">Start Date</label>
                    <input type="date" name="start_date" value="{{ old('start_date') }}" class="w-full px-5 py-4 rounded-2xl bg-slate-50 dark:bg-slate-800 border-transparent text-sm font-bold transition-all">
                </div>
                <div>
                    <label class="block text-[10px] font-black uppercase tracking-widest text-slate-400 mb-2">End Date</label>
                    <input type="date" name="end_date" value="{{ old('end_date') }}" class="w-full px-5 py-4 rounded-2xl bg-slate-50 dark:bg-slate-800 border-transparent text-sm font-bold transition-all">
                </div>
            </div>
            <div class="flex items-center gap-3">
                <input type="checkbox" name="is_active" id="is_active" value="1" checked class="w-5 h-5 rounded-lg accent-primary">
                <label for="is_active" class="text-sm font-black text-slate-700 dark:text-slate-300 uppercase tracking-widest">Active</label>
            </div>
            <div class="flex items-center gap-4 pt-4 border-t border-slate-50 dark:border-slate-800">
                <button type="submit" class="px-8 py-4 bg-slate-900 hover:bg-primary text-white rounded-2xl text-xs font-black uppercase tracking-widest transition-all">Create Coupon</button>
                <a href="{{ route('admin.coupons.index') }}" class="px-8 py-4 bg-slate-100 text-slate-600 rounded-2xl text-xs font-black uppercase tracking-widest hover:bg-slate-200 transition-all">Cancel</a>
            </div>
        </form>
    </div>
</div>
@endsection
@php use Illuminate\Support\Str; @endphp
