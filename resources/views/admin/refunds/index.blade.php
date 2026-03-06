@extends('layouts.admin')

@section('title', 'Refunds - EcomMatrix')
@section('page-title', 'Refund Reconciliation')

@section('content')
<div class="max-w-4xl mx-auto space-y-12 animate-fade-in">
    <div class="card-premium bg-rose-900/10 p-10 md:p-14 border-rose-500/20 shadow-2xl relative overflow-hidden group">
        <div class="relative z-10 lg:w-2/3">
            <h2 class="text-3xl md:text-4xl font-black mb-4 md:mb-6 tracking-tight text-rose-500">Refund Requests</h2>
            <p class="text-slate-500 font-medium leading-relaxed text-sm md:text-base">Financial reversal protocols for marketplace transactions. Currently awaiting data stream.</p>
        </div>
        <div class="absolute -right-10 -bottom-10 opacity-5 text-[200px] leading-none select-none italic font-black text-rose-500">REFUND</div>
    </div>
</div>
@endsection
