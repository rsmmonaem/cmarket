@extends('layouts.public')

@section('content')
<div class="min-h-screen py-20 bg-slate-50 flex items-center justify-center p-6">
    <div class="max-w-2xl w-full bg-white rounded-[3rem] p-12 md:p-16 border border-slate-100 shadow-2xl text-center relative overflow-hidden group">
        <!-- Background Decoration -->
        <div class="absolute -right-10 -top-10 opacity-[0.03] text-[200px] leading-none select-none italic font-black group-hover:scale-110 transition-transform duration-1000 uppercase">WAIT</div>
        
        <div class="relative z-10 space-y-10">
            <div class="w-32 h-32 bg-primary/10 rounded-full flex items-center justify-center text-5xl mx-auto shadow-inner group-hover:scale-110 transition-transform duration-500">
                ⌛
            </div>
            
            <div class="space-y-4">
                <h1 class="text-4xl font-black text-slate-800 tracking-tight leading-none uppercase">Identity Verification in Progress</h1>
                <p class="text-slate-500 font-bold text-[10px] uppercase tracking-[0.25em]">Node Identity: {{ $merchant->business_name }} • Protocol Status: Awaiting Validation</p>
            </div>

            <div class="p-8 bg-slate-50 rounded-2xl border border-slate-100 text-left space-y-4">
                <div class="flex items-start gap-4">
                    <div class="w-6 h-6 bg-emerald-500 rounded-full flex-shrink-0 flex items-center justify-center text-white text-[10px]">✓</div>
                    <p class="text-xs font-bold text-slate-600 uppercase tracking-widest leading-loose">Core Metadata successfully ingested into EcomMatrix registry.</p>
                </div>
                <div class="flex items-start gap-4">
                    <div class="w-6 h-6 bg-emerald-500 rounded-full flex-shrink-0 flex items-center justify-center text-white text-[10px]">✓</div>
                    <p class="text-xs font-bold text-slate-600 uppercase tracking-widest leading-loose">Business credentials queued for manual audit by Sector Administrators.</p>
                </div>
                <div class="flex items-start gap-4">
                    <div class="w-6 h-6 bg-slate-300 rounded-full flex-shrink-0 flex items-center justify-center text-white text-[10px]">3</div>
                    <p class="text-xs font-bold text-slate-400 uppercase tracking-widest leading-loose">Activation Signal awaiting broadcast. Usually completes within 24-48 cycles.</p>
                </div>
            </div>

            <div class="pt-6">
                <a href="{{ route('home') }}" class="inline-flex items-center gap-4 px-10 py-5 bg-slate-900 text-white rounded-2xl font-black text-[10px] uppercase tracking-widest shadow-2xl shadow-slate-900/10 hover:bg-primary transition-all scale-100 hover:scale-105 active:scale-95">
                    Return to Public Network 🌐
                </a>
            </div>

            <p class="text-[9px] font-black text-slate-300 uppercase tracking-[0.3em] pt-10">System Architecture: EcomMatrix v2.0 • Protocol: MERCHANT_NODE_WAITLIST</p>
        </div>
    </div>
</div>
@endsection
