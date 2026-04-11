@extends('layouts.customer')

@section('title', 'Financial Hub - CMarket')
@section('page-title', 'My Wallets')

@section('content')
<div class="space-y-10">
    <!-- Wallets Grid -->
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
        @foreach($wallets as $wallet)
            @php
                $color = 'slate';
                $icon = '💰';
                if($wallet->wallet_type === 'cashback') { $color = 'sky'; $icon = '🎁'; }
                elseif($wallet->wallet_type === 'commission') { $color = 'emerald'; $icon = '💵'; }
                elseif($wallet->wallet_type === 'shop') { $color = 'amber'; $icon = '🏪'; }
                elseif($wallet->wallet_type === 'share') { $color = 'indigo'; $icon = '🤝'; }
                
                $colorClasses = [
                    'slate' => 'bg-slate-900 shadow-slate-900/10 text-white',
                    'sky' => 'bg-white border-sky-100 text-slate-800',
                    'emerald' => 'bg-white border-emerald-100 text-slate-800',
                    'amber' => 'bg-white border-amber-100 text-slate-800',
                    'indigo' => 'bg-indigo-600 shadow-indigo-600/10 text-white',
                ];
                $currentClass = $colorClasses[$color] ?? $colorClasses['slate'];
            @endphp
            
            <div class="{{ $currentClass }} rounded-[2rem] p-8 {{ !str_contains($currentClass, 'bg-white') ? 'shadow-2xl' : 'border border-slate-100 shadow-sm' }} relative overflow-hidden group hover:-translate-y-2 transition-all duration-300">
                <div class="relative z-10">
                    <div class="flex items-center justify-between mb-6">
                        <span class="text-[10px] font-black uppercase tracking-widest opacity-60">{{ ucfirst($wallet->wallet_type) }}</span>
                        <span class="text-2xl">{{ $icon }}</span>
                    </div>
                    <h3 class="text-3xl font-black mb-1">৳{{ number_format($wallet->balance, 2) }}</h3>
                    <p class="text-[10px] font-bold opacity-60">Status: {{ ucfirst($wallet->status) }}</p>
                </div>
                <!-- Abstract Design Elements -->
                <div class="absolute -right-4 -bottom-4 opacity-5 text-8xl rotate-12 group-hover:rotate-0 transition-transform duration-700 select-none">{{ $icon }}</div>
            </div>
        @endforeach
    </div>

    <!-- Main Section -->
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-10">
        <!-- Transaction Ledger -->
        <div class="lg:col-span-2 space-y-6">
            <div class="bg-white rounded-[2.5rem] p-8 border border-slate-100 shadow-sm min-h-[600px]">
                <div class="flex items-center justify-between mb-10">
                    <div>
                        <h3 class="text-lg font-black text-slate-800 uppercase tracking-tight">Recent Transactions</h3>
                        <p class="text-[10px] font-bold text-slate-400 uppercase tracking-widest mt-1">Real-time ledger data</p>
                    </div>
                    <button class="p-3 rounded-2xl bg-slate-50 text-slate-400 hover:text-sky-500 transition-colors">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 4a1 1 0 011-1h16a1 1 0 011 1v2.586a1 1 0 01-.293.707l-6.414 6.414a1 1 0 00-.293.707V17l-4 4v-6.586a1 1 0 00-.293-.707L3.293 7.293A1 1 0 013 6.586V4z"></path></svg>
                    </button>
                </div>

                <div class="space-y-4">
                    @php
                        $allTransactions = collect();
                        foreach($wallets as $wallet) { $allTransactions = $allTransactions->merge($wallet->ledgers); }
                        $allTransactions = $allTransactions->sortByDesc('created_at')->take(15);
                    @endphp

                    @forelse($allTransactions as $tx)
                        <div class="flex items-center justify-between p-5 rounded-3xl bg-slate-50 border border-transparent hover:border-slate-100 hover:bg-white transition-all group">
                            <div class="flex items-center gap-5">
                                <div class="w-12 h-12 rounded-2xl {{ $tx->type == 'credit' ? 'bg-emerald-50 text-emerald-600' : 'bg-rose-50 text-rose-600' }} flex items-center justify-center text-xl shadow-sm group-hover:scale-110 transition-transform">
                                    {{ $tx->type == 'credit' ? '📥' : '📤' }}
                                </div>
                                <div>
                                    <p class="text-sm font-black text-slate-800 leading-tight">{{ $tx->description }}</p>
                                    <p class="text-[10px] font-bold text-slate-400 mt-1 uppercase tracking-widest">{{ $tx->wallet->wallet_type }} • {{ $tx->created_at->diffForHumans() }}</p>
                                </div>
                            </div>
                            <div class="text-right">
                                <p class="text-lg font-black {{ $tx->credit > 0 ? 'text-emerald-600' : 'text-slate-800' }}">
                                    {{ $tx->credit > 0 ? '+' : '-' }}৳{{ number_format($tx->credit > 0 ? $tx->credit : $tx->debit, 2) }}
                                </p>
                                <p class="text-[9px] font-black text-slate-300 uppercase">Balance: ৳{{ number_format($tx->balance_after, 2) }}</p>
                            </div>
                        </div>
                    @empty
                        <div class="flex flex-col items-center justify-center py-20 text-center opacity-20">
                            <span class="text-6xl mb-4">🧊</span>
                            <p class="text-sm font-black uppercase tracking-widest">No transactions discovered</p>
                        </div>
                    @endforelse
                </div>
            </div>
        </div>

        <!-- Right Side: Transfer & Promo -->
        <div class="space-y-8">
            <!-- Promotion Card -->
            <div class="bg-gradient-to-br from-indigo-500 to-purple-600 rounded-[2.5rem] p-8 text-white relative overflow-hidden group shadow-2xl shadow-indigo-500/20">
                <div class="relative z-10">
                    <h4 class="text-xl font-black mb-2 leading-tight">Elite Networking Program</h4>
                    <p class="text-xs font-bold text-indigo-100/70 mb-8 leading-relaxed">Earn up to 15% recurring commission by growing your sales force.</p>
                    
                    <div class="bg-white/10 backdrop-blur-md rounded-2xl p-4 border border-white/20 mb-8">
                        <p class="text-[9px] font-black uppercase tracking-tighter opacity-60 mb-1">Your Exclusive Code</p>
                        <div class="flex items-center justify-between">
                            <span class="text-2xl font-black tracking-widest">{{ auth()->user()->referral_code ?? 'CMARKET' }}</span>
                            <button class="p-2 transition-transform active:scale-95" title="Copy Code">📋</button>
                        </div>
                    </div>

                    <a href="{{ route('referrals.index') }}" class="inline-flex items-center gap-2 text-[10px] font-black uppercase tracking-widest group-hover:gap-4 transition-all hover:text-emerald-400">
                        My Sales Network <span>→</span>
                    </a>
                </div>
                <!-- Background decor -->
                <div class="absolute -right-10 -bottom-10 opacity-10 text-[200px] leading-none select-none font-black italic">🔗</div>
            </div>
        </div>
    </div>
</div>
@endsection
