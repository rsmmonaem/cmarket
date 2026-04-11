@extends('layouts.customer')

@section('title', 'Referral Network - CMarket')
@section('page-title', 'My Referrals')

@section('content')
<div class="space-y-8 animate-fade-in">
    <!-- Network Hub -->
    <div class="bg-slate-900 rounded-[2.5rem] p-10 text-white shadow-2xl shadow-slate-900/10 relative overflow-hidden group">
        <div class="relative z-10">
            <h2 class="text-3xl font-black mb-10 tracking-tight">Your Referral Hub</h2>
            
            <div class="grid grid-cols-1 md:grid-cols-2 gap-10">
                <div class="space-y-4">
                    <p class="text-[10px] font-black uppercase tracking-widest text-slate-400 pl-1">Unique Referral Code</p>
                    <div class="bg-white/5 backdrop-blur-xl border border-white/10 rounded-3xl p-6 flex items-center justify-between group/code hover:border-sky-500/50 transition-all">
                        <code class="text-3xl font-black text-white tracking-widest">{{ auth()->user()->referral_code ?? '---' }}</code>
                        @if(auth()->user()->referral_code)
                            <button onclick="copyToClipboard('{{ auth()->user()->referral_code }}')" class="p-3 bg-white text-slate-900 rounded-2xl hover:bg-sky-500 hover:text-white transition-all shadow-lg active:scale-95">
                                📋
                            </button>
                        @else
                            <form action="{{ route('referral.generate') }}" method="POST">
                                @csrf
                                <button type="submit" class="px-6 py-3 bg-sky-500 text-white rounded-2xl font-black text-[10px] uppercase tracking-widest hover:bg-sky-400 transition shadow-lg shadow-sky-500/20">Generate</button>
                            </form>
                        @endif
                    </div>
                </div>

                <div class="space-y-4">
                    <p class="text-[10px] font-black uppercase tracking-widest text-slate-400 pl-1">Invite Share Link</p>
                    <div class="bg-white/5 backdrop-blur-xl border border-white/10 rounded-3xl p-6 flex items-center justify-between group/link hover:border-emerald-500/50 transition-all overflow-hidden">
                        @if(auth()->user()->referral_code)
                            <input type="text" readonly value="{{ url('/register?ref=' . auth()->user()->referral_code) }}" class="bg-transparent border-none text-xs font-bold text-slate-300 focus:ring-0 flex-1 truncate">
                            <button onclick="copyToClipboard('{{ url('/register?ref=' . auth()->user()->referral_code) }}')" class="p-3 bg-white/10 text-white rounded-2xl hover:bg-emerald-500 transition-all ml-4">
                                🔗
                            </button>
                        @else
                            <p class="text-[10px] font-bold text-slate-500 italic">Generate your code first to get a sharing link.</p>
                        @endif
                    </div>
                </div>
            </div>
        </div>
        <div class="absolute -right-10 -bottom-10 opacity-5 text-[250px] leading-none select-none italic group-hover:scale-110 transition-transform duration-700">🤝</div>
    </div>

    <!-- Quick Stats Hub -->
    <div class="grid grid-cols-2 lg:grid-cols-4 gap-6">
        <div class="bg-white rounded-3xl p-6 border border-slate-100 shadow-sm text-center">
            <p class="text-[10px] font-black uppercase tracking-widest text-slate-400 mb-2">Direct Team</p>
            <h3 class="text-3xl font-black text-slate-800">{{ $directReferrals->count() }}</h3>
        </div>
        <div class="bg-white rounded-3xl p-6 border border-slate-100 shadow-sm text-center">
            <p class="text-[10px] font-black uppercase tracking-widest text-slate-400 mb-2">Total Network</p>
            <h3 class="text-3xl font-black text-slate-800">{{ $allReferrals->count() }}</h3>
        </div>
        <div class="bg-white rounded-3xl p-6 border border-slate-100 shadow-sm text-center">
            <p class="text-[10px] font-black uppercase tracking-widest text-slate-400 mb-2">Total Earnings</p>
            <h3 class="text-3xl font-black text-emerald-600">৳{{ number_format($totalCommissions, 2) }}</h3>
        </div>
        <div class="bg-white rounded-3xl p-6 border border-slate-100 shadow-sm text-center">
            <p class="text-[10px] font-black uppercase tracking-widest text-slate-400 mb-2">Pending</p>
            <h3 class="text-3xl font-black text-amber-500">৳{{ number_format($pendingCommissions, 2) }}</h3>
        </div>
    </div>

    <!-- Direct Referrals Table -->
    <div class="bg-white rounded-[2.5rem] border border-slate-100 shadow-sm overflow-hidden">
        <div class="p-8 border-b border-slate-50 flex items-center justify-between">
            <h3 class="text-sm font-black text-slate-800 uppercase tracking-widest">Level 1 Members</h3>
            <span class="text-[10px] font-bold text-slate-400 uppercase tracking-widest">{{ $directReferrals->count() }} Active Partners</span>
        </div>
        
        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse">
                <thead>
                    <tr class="bg-slate-50/50">
                        <th class="p-6 text-[10px] font-black text-slate-500 uppercase tracking-widest">Partner</th>
                        <th class="p-6 text-[10px] font-black text-slate-500 uppercase tracking-widest">Contact</th>
                        <th class="p-6 text-[10px] font-black text-slate-500 uppercase tracking-widest">Designation</th>
                        <th class="p-6 text-[10px] font-black text-slate-500 uppercase tracking-widest text-right">Joined</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-50">
                    @forelse($directReferrals as $referral)
                        <tr class="hover:bg-slate-50 transition-colors">
                            <td class="p-6">
                                <div class="flex items-center gap-4">
                                    <div class="w-10 h-10 rounded-xl bg-slate-100 flex items-center justify-center text-xs font-black text-slate-800">
                                        {{ substr($referral->name, 0, 1) }}
                                    </div>
                                    <p class="text-sm font-black text-slate-800">{{ $referral->name }}</p>
                                </div>
                            </td>
                            <td class="p-6 text-sm font-bold text-slate-500">{{ $referral->phone }}</td>
                            <td class="p-6">
                                <span class="px-3 py-1 rounded bg-sky-50 text-sky-600 text-[9px] font-black uppercase tracking-wider">
                                    {{ $referral->designation->name ?? 'None' }}
                                </span>
                            </td>
                            <td class="p-6 text-right text-[11px] font-black text-slate-400">
                                {{ $referral->created_at->format('M d, Y') }}
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="4" class="p-20 text-center opacity-30">
                                <p class="text-sm font-black uppercase tracking-widest">No direct referrals yet</p>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>

<script>
function copyToClipboard(text) {
    navigator.clipboard.writeText(text).then(() => {
        Toast.fire({
            icon: 'success',
            title: 'Copied to clipboard! 📋'
        });
    });
}
</script>
@endsection
