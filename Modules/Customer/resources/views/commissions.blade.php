@extends('layouts.customer')

@section('title', 'Commission History - CMarket')
@section('page-title', 'My Earnings')

@section('content')
<div class="space-y-8 animate-fade-in">
    <!-- Earnings Overview -->
    <div class="bg-gradient-to-br from-emerald-600 to-emerald-800 rounded-[2.5rem] p-8 md:p-12 text-white shadow-2xl shadow-emerald-600/20 relative overflow-hidden group">
        <div class="relative z-10 flex flex-col md:flex-row justify-between items-center gap-8">
            <div class="text-center md:text-left">
                <p class="text-[10px] font-black uppercase tracking-[0.2em] opacity-60 mb-3">Withdrawable Balance</p>
                <h2 class="text-5xl font-black tracking-tight">৳{{ number_format(auth()->user()->getWallet('commission')->balance ?? 0, 2) }}</h2>
                <p class="text-emerald-100/50 text-xs font-bold mt-4">Total team and referral earnings since joining.</p>
            </div>
            <div class="flex gap-4">
                <button class="bg-white/10 hover:bg-white/20 backdrop-blur-xl px-10 py-5 rounded-2xl font-black text-xs uppercase tracking-widest transition-all">Withdraw Funds</button>
            </div>
        </div>
        <div class="absolute -right-10 -bottom-10 opacity-10 text-[250px] leading-none select-none italic font-black group-hover:scale-110 transition-transform duration-700">💰</div>
    </div>

    <!-- History Table -->
    <div class="bg-white rounded-[2.5rem] border border-slate-100 shadow-sm overflow-hidden">
        <div class="p-8 border-b border-slate-50 flex items-center justify-between">
            <h3 class="text-sm font-black text-slate-800 uppercase tracking-widest">Commission Log</h3>
            <span class="text-[10px] font-bold text-slate-400 uppercase tracking-widest">Showing {{ $commissions->count() }} Entries</span>
        </div>
        
        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse">
                <thead>
                    <tr class="bg-slate-50/50">
                        <th class="p-6 text-[10px] font-black text-slate-500 uppercase tracking-widest">Source</th>
                        <th class="p-6 text-[10px] font-black text-slate-500 uppercase tracking-widest text-center">Level</th>
                        <th class="p-6 text-[10px] font-black text-slate-500 uppercase tracking-widest">Amount</th>
                        <th class="p-6 text-[10px] font-black text-slate-500 uppercase tracking-widest">Status</th>
                        <th class="p-6 text-[10px] font-black text-slate-500 uppercase tracking-widest text-right">Date</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-50">
                    @forelse($commissions as $comm)
                        <tr class="hover:bg-slate-50/50 transition-colors group">
                            <td class="p-6">
                                <div class="flex items-center gap-4">
                                    <div class="w-10 h-10 rounded-xl bg-white border border-slate-100 flex items-center justify-center text-lg group-hover:shadow-lg transition-all">💸</div>
                                    <div>
                                        <p class="text-sm font-black text-slate-800 group-hover:text-emerald-600 transition-colors">Order #{{ $comm->order->order_number ?? 'N/A' }}</p>
                                        <p class="text-[10px] font-bold text-slate-400">Team Referral Payout</p>
                                    </div>
                                </div>
                            </td>
                            <td class="p-6 text-center">
                                <span class="px-2.5 py-1 rounded-lg bg-slate-900 text-white text-[9px] font-black">Level {{ $comm->level ?? '1' }}</span>
                            </td>
                            <td class="p-6">
                                <p class="text-lg font-black text-slate-800">৳{{ number_format($comm->amount, 2) }}</p>
                            </td>
                            <td class="p-6">
                                <span class="px-3 py-1 rounded-full bg-emerald-100 text-emerald-600 text-[9px] font-black uppercase tracking-wider">Approved</span>
                            </td>
                            <td class="p-6 text-right">
                                <p class="text-[11px] font-black text-slate-800">{{ $comm->created_at->format('M d, Y') }}</p>
                                <p class="text-[9px] font-bold text-slate-400">{{ $comm->created_at->format('h:i A') }}</p>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="p-20 text-center flex flex-col items-center">
                                <div class="text-6xl mb-6 opacity-20">🧊</div>
                                <h3 class="text-xl font-black text-slate-300 uppercase tracking-widest">No Earnings Recorded</h3>
                                <p class="text-xs font-bold text-slate-400 mt-2">Generate sales or help your team grow to earn commissions.</p>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if($commissions->hasPages())
            <div class="p-8 border-t border-slate-50">
                {{ $commissions->links() }}
            </div>
        @endif
    </div>
</div>
@endsection
