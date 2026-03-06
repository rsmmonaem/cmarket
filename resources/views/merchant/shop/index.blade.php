@extends('layouts.merchant')

@section('title', 'Shop Settings')
@section('page-title', 'Shop Configuration')

@section('content')
<div class="max-w-4xl mx-auto animate-fade-in">
    <div class="card-premium p-8 md:p-12 bg-white border-slate-100 shadow-sm relative overflow-hidden group">
        <div class="relative z-10">
            <h3 class="text-[10px] font-black text-slate-400 uppercase tracking-[0.2em] mb-10 flex items-center gap-2">
                <span class="w-2 h-2 bg-primary rounded-full"></span> Identity Configuration
            </h3>

            <form action="{{ route('merchant.shop.update') }}" method="POST" class="space-y-8">
                @csrf
                <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                    <div class="space-y-2">
                        <label class="text-[10px] font-black text-slate-400 uppercase tracking-widest ml-1">Business Name</label>
                        <input type="text" name="business_name" value="{{ $merchant->business_name }}" class="w-full px-6 py-4 rounded-2xl bg-slate-50 border-transparent focus:bg-white focus:border-primary/20 focus:ring-4 focus:ring-primary/5 transition-all text-sm font-black text-slate-800 uppercase tracking-tight">
                    </div>
                    <div class="space-y-2">
                        <label class="text-[10px] font-black text-slate-400 uppercase tracking-widest ml-1">Trade Sector</label>
                        <input type="text" name="business_type" value="{{ $merchant->business_type }}" class="w-full px-6 py-4 rounded-2xl bg-slate-50 border-transparent focus:bg-white focus:border-primary/20 focus:ring-4 focus:ring-primary/5 transition-all text-sm font-black text-slate-800 uppercase tracking-tight">
                    </div>
                    <div class="md:col-span-2 space-y-2">
                        <label class="text-[10px] font-black text-slate-400 uppercase tracking-widest ml-1">Operational Coordinates</label>
                        <textarea name="address" rows="3" class="w-full px-6 py-4 rounded-2xl bg-slate-50 border-transparent focus:bg-white focus:border-primary/20 focus:ring-4 focus:ring-primary/5 transition-all text-sm font-bold text-slate-800">{{ $merchant->address }}</textarea>
                    </div>
                </div>

                <div class="pt-6 border-t border-slate-50 flex justify-end">
                    <button type="submit" class="px-10 py-4 bg-slate-900 text-white rounded-2xl font-black text-[10px] uppercase tracking-[0.2em] hover:bg-primary transition-all shadow-xl shadow-slate-900/10">
                        ⚡ Update Shop Node
                    </button>
                </div>
            </form>
        </div>
        <div class="absolute -right-6 -bottom-6 opacity-[0.03] text-9xl font-black italic select-none">SHOP</div>
    </div>
</div>
@endsection
