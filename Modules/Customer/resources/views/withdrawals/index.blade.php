@extends('layouts.customer')

@section('title', 'Withdraw Funds - CMarket')
@section('page-title', 'Financial Withdrawals')

@section('content')
<div class="space-y-10 animate-fade-in">
    <!-- Header Summary -->
    <div class="bg-slate-900 rounded-[2.5rem] p-10 text-white shadow-2xl shadow-slate-900/10 relative overflow-hidden group">
        <div class="relative z-10 flex flex-col md:flex-row justify-between items-center gap-8">
            <div>
                <h2 class="text-3xl font-black mb-2 tracking-tight">Withdrawal Hub</h2>
                <p class="text-slate-400 text-xs font-bold uppercase tracking-widest pl-1">Stable & Secure Payouts</p>
            </div>
            <div class="flex gap-4">
                <div class="bg-white/5 backdrop-blur-xl border border-white/10 p-6 rounded-3xl text-center min-w-[160px]">
                    <p class="text-[9px] font-black uppercase tracking-tighter opacity-40 mb-1">Withdrawable Balance</p>
                    <p class="text-2xl font-black">৳{{ number_format(auth()->user()->getWallet('main')->balance ?? 0, 2) }}</p>
                </div>
                <div class="bg-white/5 backdrop-blur-xl border border-white/10 p-6 rounded-3xl text-center min-w-[160px]">
                    <p class="text-[9px] font-black uppercase tracking-tighter opacity-40 mb-1">Commission Earned</p>
                    <p class="text-2xl font-black text-emerald-400">৳{{ number_format(auth()->user()->getWallet('commission')->balance ?? 0, 2) }}</p>
                </div>
            </div>
        </div>
        <div class="absolute -right-10 -bottom-10 opacity-5 text-[250px] leading-none select-none italic group-hover:scale-110 transition-transform duration-700">🏧</div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-10">
        <!-- Withdrawal Form -->
        <div class="lg:col-span-1">
            <div class="bg-white rounded-[2.5rem] p-8 border border-slate-100 shadow-xl relative overflow-hidden group">
                <h3 class="text-lg font-black text-slate-800 mb-8 flex items-center gap-3">
                    New Request <span class="bg-emerald-100 text-emerald-600 text-[10px] p-1.5 rounded-lg">📤</span>
                </h3>

                <form action="{{ route('customer.withdrawals.request') }}" method="POST" class="space-y-6" id="withdrawalForm">
                    @csrf
                    <div>
                        <label class="block text-[10px] font-black text-slate-400 uppercase tracking-widest mb-3 pl-1">Source Wallet</label>
                        <select name="wallet_type" class="w-full bg-slate-50 border-none rounded-2xl p-4 text-sm font-bold text-slate-800 focus:ring-2 focus:ring-emerald-500/20 transition-all" required>
                            @foreach($wallets as $wallet)
                                <option value="{{ $wallet->wallet_type }}">{{ ucfirst($wallet->wallet_type) }} (৳{{ number_format($wallet->balance, 2) }})</option>
                            @endforeach
                        </select>
                    </div>

                    <div>
                        <label class="block text-[10px] font-black text-slate-400 uppercase tracking-widest mb-3 pl-1">Amount to Withdraw</label>
                        <input type="number" name="amount" min="500" step="0.01" placeholder="Min. ৳500" class="w-full bg-slate-50 border-none rounded-2xl p-4 text-sm font-black text-slate-800 focus:ring-2 focus:ring-emerald-500/20 transition-all placeholder:text-slate-300" required>
                    </div>

                    <div>
                        <label class="block text-[10px] font-black text-slate-400 uppercase tracking-widest mb-3 pl-1">Payout Method</label>
                        <div class="grid grid-cols-2 gap-3">
                            @foreach(['bkash', 'nagad', 'rocket', 'bank'] as $method)
                                <label class="cursor-pointer group/method">
                                    <input type="radio" name="method" value="{{ $method }}" class="hidden peer" required @if($loop->first) checked @endif>
                                    <div class="p-4 rounded-2xl border-2 border-slate-50 bg-slate-50 text-center peer-checked:border-emerald-500 peer-checked:bg-emerald-50 transition-all">
                                        <p class="text-[10px] font-black uppercase text-slate-500 peer-checked:text-emerald-600">{{ ucfirst($method) }}</p>
                                    </div>
                                </label>
                            @endforeach
                        </div>
                    </div>

                    <!-- Dynamic Account Detail Input -->
                    <div id="method-fields" class="space-y-4">
                        <div id="field-number">
                            <label class="block text-[10px] font-black text-slate-400 uppercase tracking-widest mb-3 pl-1">Mobile Number</label>
                            <input type="text" name="account_details[number]" placeholder="01XXXXXXXXX" class="w-full bg-slate-50 border-none rounded-2xl p-4 text-sm font-bold text-slate-800 focus:ring-2 focus:ring-emerald-500/20 transition-all placeholder:text-slate-300">
                        </div>
                        
                        <div id="field-bank" class="hidden space-y-4">
                            <div>
                                <label class="block text-[10px] font-black text-slate-400 uppercase tracking-widest mb-3 pl-1">Bank Name</label>
                                <input type="text" name="account_details[bank_name]" class="w-full bg-slate-50 border-none rounded-2xl p-4 text-sm font-bold text-slate-800 focus:ring-2 focus:ring-emerald-500/20 transition-all">
                            </div>
                            <div>
                                <label class="block text-[10px] font-black text-slate-400 uppercase tracking-widest mb-3 pl-1">Account Holder Name</label>
                                <input type="text" name="account_details[account_name]" class="w-full bg-slate-50 border-none rounded-2xl p-4 text-sm font-bold text-slate-800 focus:ring-2 focus:ring-emerald-500/20 transition-all">
                            </div>
                            <div class="grid grid-cols-2 gap-3">
                                <div>
                                    <label class="block text-[10px] font-black text-slate-400 uppercase tracking-widest mb-3 pl-1">A/C Number</label>
                                    <input type="text" name="account_details[account_number]" class="w-full bg-slate-50 border-none rounded-2xl p-4 text-sm font-bold text-slate-800 focus:ring-2 focus:ring-emerald-500/20 transition-all">
                                </div>
                                <div>
                                    <label class="block text-[10px] font-black text-slate-400 uppercase tracking-widest mb-3 pl-1">Branch</label>
                                    <input type="text" name="account_details[branch]" class="w-full bg-slate-50 border-none rounded-2xl p-4 text-sm font-bold text-slate-800 focus:ring-2 focus:ring-emerald-500/20 transition-all">
                                </div>
                            </div>
                        </div>
                    </div>

                    <button type="submit" class="w-full py-5 bg-emerald-600 text-white rounded-2xl font-black text-xs uppercase tracking-widest shadow-xl shadow-emerald-600/20 hover:bg-emerald-700 hover:scale-[1.02] transition-all duration-300">
                        Submit Request 🏧
                    </button>
                    <p class="text-[9px] text-center text-slate-400 font-bold uppercase tracking-widest">Processing typically takes 24-48 business hours.</p>
                </form>
            </div>
        </div>

        <!-- Withdrawal History -->
        <div class="lg:col-span-2">
            <div class="bg-white rounded-[2.5rem] border border-slate-100 shadow-sm overflow-hidden min-h-[600px]">
                <div class="p-8 border-b border-slate-50 flex items-center justify-between">
                    <div>
                        <h3 class="text-sm font-black text-slate-800 uppercase tracking-widest">Withdrawal Log</h3>
                        <p class="text-[9px] font-bold text-slate-400 uppercase mt-1">Audit trail of payout requests</p>
                    </div>
                </div>

                <div class="overflow-x-auto">
                    <table class="w-full text-left border-collapse">
                        <thead>
                            <tr class="bg-slate-50/50">
                                <th class="p-6 text-[10px] font-black text-slate-500 uppercase tracking-widest">Payout Asset</th>
                                <th class="p-6 text-[10px] font-black text-slate-500 uppercase tracking-widest">Method & Details</th>
                                <th class="p-6 text-[10px] font-black text-slate-500 uppercase tracking-widest">Volume</th>
                                <th class="p-6 text-[10px] font-black text-slate-500 uppercase tracking-widest">Status</th>
                                <th class="p-6 text-[10px] font-black text-slate-500 uppercase tracking-widest text-right">Request Date</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-slate-50">
                            @forelse($withdrawals as $w)
                                <tr class="hover:bg-slate-50 transition-colors group">
                                    <td class="p-6">
                                        <div class="flex items-center gap-4">
                                            <div class="w-10 h-10 rounded-xl bg-slate-900 flex items-center justify-center text-white text-xs font-black uppercase">
                                                ID
                                            </div>
                                            <div>
                                                <p class="text-[10px] font-black text-slate-800">REQ-{{ str_pad($w->id, 5, '0', STR_PAD_LEFT) }}</p>
                                                <p class="text-[9px] font-bold text-slate-400 uppercase">{{ $w->wallet->wallet_type }} Wallet</p>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="p-6">
                                        <p class="text-xs font-black text-slate-800 uppercase">{{ $w->method }}</p>
                                        <p class="text-[9px] font-bold text-slate-400">
                                            @if($w->method == 'bank')
                                                {{ $w->account_details['bank_name'] }} • {{ $w->account_details['account_number'] }}
                                            @else
                                                {{ $w->account_details['number'] }}
                                            @endif
                                        </p>
                                    </td>
                                    <td class="p-6">
                                        <p class="text-sm font-black text-slate-800">৳{{ number_format($w->amount, 2) }}</p>
                                    </td>
                                    <td class="p-6">
                                        <span class="px-2.5 py-1 rounded-lg text-[8px] font-black uppercase tracking-wider
                                            @if($w->status == 'pending') bg-amber-50 text-amber-600
                                            @elseif($w->status == 'completed') bg-emerald-50 text-emerald-600
                                            @elseif($w->status == 'rejected') bg-rose-50 text-rose-600
                                            @else bg-slate-50 text-slate-500 @endif">
                                            {{ $w->status }}
                                        </span>
                                    </td>
                                    <td class="p-6 text-right">
                                        <p class="text-[10px] font-black text-slate-800">{{ $w->created_at->format('M d, Y') }}</p>
                                        <p class="text-[9px] font-bold text-slate-400">{{ $w->created_at->format('h:i A') }}</p>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="5" class="p-20 text-center flex flex-col items-center">
                                        <div class="text-6xl mb-6 opacity-20">🧊</div>
                                        <h3 class="text-xl font-black text-slate-300 uppercase tracking-widest">No Payout Requests</h3>
                                        <p class="text-xs font-bold text-slate-400 mt-2">Your withdrawal history will appear here once you make a request.</p>
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                @if($withdrawals->hasPages())
                    <div class="p-8 border-t border-slate-50">
                        {{ $withdrawals->links() }}
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>

<script>
document.querySelectorAll('input[name="method"]').forEach(radio => {
    radio.addEventListener('change', (e) => {
        const fieldNumber = document.getElementById('field-number');
        const fieldBank = document.getElementById('field-bank');
        
        if(e.target.value === 'bank') {
            fieldNumber.classList.add('hidden');
            fieldBank.classList.remove('hidden');
        } else {
            fieldNumber.classList.remove('hidden');
            fieldBank.classList.add('hidden');
        }
    });
});
</script>
@endsection
