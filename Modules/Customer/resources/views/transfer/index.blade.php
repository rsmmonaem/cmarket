@extends('layouts.customer')

@section('title', 'Fast Fund Transfer')
@section('page-title', 'Fund Transfer')

@section('content')
<div class="max-w-4xl mx-auto space-y-8 animate-fade-in">
    <!-- Header -->
    <div class="flex items-center justify-between">
        <div>
            <h2 class="text-2xl font-black text-slate-800 tracking-tight">Fast Transfer 💸</h2>
            <p class="text-sm font-bold text-slate-400">Transfer funds instantly to any user's main wallet.</p>
        </div>
        <div class="px-6 py-3 rounded-xl bg-slate-100 text-slate-600 text-xs font-black uppercase tracking-widest">Main Wallet to Main Wallet</div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
        <!-- Form -->
        <div class="lg:col-span-2">
            <div class="bg-white rounded-[2.5rem] p-8 border border-slate-100 shadow-sm">
                <form action="{{ route('customer.transfer.submit') }}" method="POST" class="space-y-6">
                    @csrf
                    
                    <div class="space-y-6">
                        <div class="space-y-3">
                            <label class="text-[10px] font-black uppercase tracking-widest text-slate-500 pl-1">Select Recipient</label>
                            <select name="recipient_id" class="w-full bg-slate-50 border-2 border-slate-100 rounded-2xl px-5 py-4 text-sm font-bold focus:border-sky-500 focus:bg-white transition-all outline-none" required>
                                <option value="" disabled selected>Search for a user...</option>
                                @foreach($users as $user)
                                    <option value="{{ $user->id }}">{{ $user->name }} (ID: {{ $user->id }})</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="space-y-3">
                            <label class="text-[10px] font-black uppercase tracking-widest text-slate-500 pl-1">Transfer Amount (৳)</label>
                            <input type="number" name="amount" min="1" step="0.01" placeholder="Enter amount to transfer" class="w-full bg-slate-50 border-2 border-slate-100 rounded-2xl px-5 py-4 text-sm font-bold focus:border-sky-500 focus:bg-white transition-all outline-none" required>
                            <div class="flex items-center gap-2 pl-1">
                                <span class="w-1.5 h-1.5 rounded-full bg-amber-500"></span>
                                <p class="text-[10px] font-bold text-slate-400">You must maintain at least ৳{{ number_format($min_balance, 2) }} balance.</p>
                            </div>
                        </div>
                    </div>

                    <div class="pt-4">
                        <button type="submit" class="w-full py-5 rounded-2xl bg-slate-900 text-white font-black text-xs uppercase tracking-widest hover:bg-sky-600 transition shadow-xl shadow-slate-900/10 active:scale-95">Send Funds Now 🚀</button>
                    </div>
                </form>
            </div>
        </div>

        <!-- Wallet Info -->
        <aside class="space-y-6">
            <div class="bg-sky-600 rounded-[2.5rem] p-8 text-white relative overflow-hidden group">
                <h4 class="text-sm font-black uppercase tracking-widest mb-4">Your Main Wallet</h4>
                <div class="relative z-10">
                    <p class="text-[10px] font-bold text-sky-100 uppercase tracking-widest opacity-60">Current Balance</p>
                    <div class="flex items-baseline gap-2 mb-6">
                        <span class="text-3xl font-black">৳{{ number_format(auth()->user()->getWallet('main')->balance, 2) }}</span>
                    </div>

                    <div class="space-y-3 pt-4 border-t border-white/10">
                        <div class="flex justify-between items-center text-[10px] font-black uppercase tracking-widest">
                            <span class="text-sky-100">Transferable</span>
                            <span class="text-white">৳{{ number_format(max(0, auth()->user()->getWallet('main')->balance - $min_balance), 2) }}</span>
                        </div>
                        <div class="flex justify-between items-center text-[10px] font-black uppercase tracking-widest">
                            <span class="text-sky-100 italic">Locked Base</span>
                            <span class="text-sky-200">৳{{ number_format($min_balance, 2) }}</span>
                        </div>
                    </div>
                </div>
                <div class="absolute -right-10 -bottom-10 opacity-10 text-[10rem] group-hover:rotate-12 transition-transform">💳</div>
            </div>

            <div class="bg-slate-50 rounded-[2.5rem] p-8 border border-slate-100">
                <h4 class="text-[10px] font-black uppercase tracking-widest text-slate-800 mb-2">Transfer Rules</h4>
                <ul class="space-y-3">
                    <li class="flex gap-2">
                        <span class="text-sky-500 text-xs mt-0.5">✔</span>
                        <p class="text-xs font-bold text-slate-600 leading-relaxed">Instant transfer within CMarket ecosystem.</p>
                    </li>
                    <li class="flex gap-2">
                        <span class="text-sky-500 text-xs mt-0.5">✔</span>
                        <p class="text-xs font-bold text-slate-600 leading-relaxed">No additional service charges apply.</p>
                    </li>
                </ul>
            </div>
        </aside>
    </div>
</div>
@endsection
