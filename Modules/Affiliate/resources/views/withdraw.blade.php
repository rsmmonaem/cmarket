@extends('layouts.customer')
@section('title', 'Affiliate Withdrawal')
@section('page-title', 'Withdraw Earnings')

@section('content')
<div class="space-y-8">
    {{-- Nav --}}
    <div class="flex flex-wrap gap-2">
        @foreach([['affiliate.dashboard','🏠 Dashboard'],['affiliate.links','🔗 Links'],['affiliate.commissions','💰 Commissions'],['affiliate.analytics','📊 Analytics'],['affiliate.withdraw','🏦 Withdraw']] as [$r,$l])
        <a href="{{ route($r) }}" class="px-4 py-2 rounded-2xl text-[10px] font-black uppercase tracking-widest {{ request()->routeIs($r) ? 'bg-indigo-600 text-white' : 'bg-slate-100 text-slate-500 hover:bg-slate-200 dark:bg-slate-800 dark:text-slate-300' }} transition-all">{{ $l }}</a>
        @endforeach
    </div>

    {{-- Balance Banner --}}
    <div class="relative bg-gradient-to-br from-indigo-600 to-violet-700 rounded-3xl p-8 text-white overflow-hidden">
        <div class="relative z-10">
            <p class="text-indigo-200 text-[10px] font-black uppercase tracking-[0.2em] mb-2">Available to Withdraw</p>
            <h2 class="text-5xl font-black">৳{{ number_format($availableBalance, 2) }}</h2>
            <p class="text-indigo-200 text-xs mt-2 font-bold">Minimum withdrawal: ৳100</p>
        </div>
        <div class="absolute -right-8 -bottom-8 text-[120px] opacity-5 select-none font-black">৳</div>
    </div>

    @if(session('success'))
    <div class="p-5 bg-emerald-50 border border-emerald-100 text-emerald-700 rounded-3xl text-sm font-bold">✅ {{ session('success') }}</div>
    @endif
    @if(session('error'))
    <div class="p-5 bg-rose-50 border border-rose-100 text-rose-600 rounded-3xl text-sm font-bold">❌ {{ session('error') }}</div>
    @endif

    <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
        {{-- Withdrawal Form --}}
        <div class="bg-white dark:bg-slate-900 rounded-3xl border border-slate-100 dark:border-slate-800 p-8 shadow-sm">
            <h4 class="text-[10px] font-black uppercase tracking-[0.2em] text-slate-400 mb-6">Request Withdrawal</h4>
            @if($availableBalance < 100)
            <div class="p-5 bg-amber-50 border border-amber-100 rounded-2xl text-amber-700 text-sm font-bold">
                You need at least <strong>৳100</strong> in approved commissions to request a withdrawal. Keep promoting to earn more!
            </div>
            @else
            <form action="{{ route('affiliate.withdraw.request') }}" method="POST" class="space-y-5">
                @csrf
                <div>
                    <label class="block text-[10px] font-black uppercase tracking-widest text-slate-400 mb-2">Amount (৳) *</label>
                    <input type="number" name="amount" value="{{ old('amount') }}" step="0.01" min="100" max="{{ $availableBalance }}" required
                        class="w-full px-5 py-4 rounded-2xl bg-slate-50 dark:bg-slate-800 border-transparent focus:border-indigo-300 focus:ring-4 focus:ring-indigo-50 text-sm font-bold transition-all"
                        placeholder="Min ৳100">
                    @error('amount')<p class="text-rose-500 text-xs mt-1 font-bold">{{ $message }}</p>@enderror
                </div>
                <div>
                    <label class="block text-[10px] font-black uppercase tracking-widest text-slate-400 mb-2">Bank Name *</label>
                    <input type="text" name="bank_name" value="{{ old('bank_name') }}" required
                        class="w-full px-5 py-4 rounded-2xl bg-slate-50 dark:bg-slate-800 border-transparent focus:border-indigo-300 text-sm font-bold transition-all"
                        placeholder="e.g. Dutch-Bangla Bank">
                    @error('bank_name')<p class="text-rose-500 text-xs mt-1 font-bold">{{ $message }}</p>@enderror
                </div>
                <div>
                    <label class="block text-[10px] font-black uppercase tracking-widest text-slate-400 mb-2">Account Holder Name *</label>
                    <input type="text" name="account_name" value="{{ old('account_name') }}" required
                        class="w-full px-5 py-4 rounded-2xl bg-slate-50 dark:bg-slate-800 border-transparent focus:border-indigo-300 text-sm font-bold transition-all">
                    @error('account_name')<p class="text-rose-500 text-xs mt-1 font-bold">{{ $message }}</p>@enderror
                </div>
                <div>
                    <label class="block text-[10px] font-black uppercase tracking-widest text-slate-400 mb-2">Account Number *</label>
                    <input type="text" name="account_number" value="{{ old('account_number') }}" required
                        class="w-full px-5 py-4 rounded-2xl bg-slate-50 dark:bg-slate-800 border-transparent focus:border-indigo-300 text-sm font-bold transition-all">
                    @error('account_number')<p class="text-rose-500 text-xs mt-1 font-bold">{{ $message }}</p>@enderror
                </div>
                <button type="submit" class="w-full py-4 bg-indigo-600 hover:bg-indigo-700 text-white rounded-2xl text-xs font-black uppercase tracking-widest transition-all">Submit Withdrawal Request</button>
            </form>
            @endif
        </div>

        {{-- History --}}
        <div class="bg-white dark:bg-slate-900 rounded-3xl border border-slate-100 dark:border-slate-800 overflow-hidden shadow-sm">
            <div class="px-8 py-5 border-b border-slate-50 dark:border-slate-800">
                <h4 class="text-[10px] font-black uppercase tracking-[0.2em] text-slate-400">Withdrawal History</h4>
            </div>
            <div class="divide-y divide-slate-50 dark:divide-slate-800">
                @forelse($withdrawals as $w)
                <div class="px-8 py-5 flex items-center justify-between">
                    <div>
                        <p class="text-sm font-black text-slate-800 dark:text-white">৳{{ number_format($w->amount, 2) }}</p>
                        <p class="text-[10px] font-bold text-slate-400 mt-0.5">{{ $w->bank_name }} · {{ $w->created_at->format('d M Y') }}</p>
                    </div>
                    @php $cColor = match($w->status) { 'approved' => 'emerald', 'pending' => 'amber', 'rejected' => 'rose', default => 'slate' }; @endphp
                    <span class="px-3 py-1.5 rounded-full text-[9px] font-black uppercase bg-{{ $cColor }}-50 text-{{ $cColor }}-600">{{ $w->status }}</span>
                </div>
                @empty
                <div class="px-8 py-12 text-center text-sm text-slate-400 font-bold">No withdrawals yet.</div>
                @endforelse
            </div>
            @if($withdrawals->hasPages())
            <div class="p-6 border-t border-slate-50 dark:border-slate-800">{{ $withdrawals->links() }}</div>
            @endif
        </div>
    </div>
</div>
@endsection
