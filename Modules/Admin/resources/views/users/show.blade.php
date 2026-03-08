@extends('layouts.admin')

@section('title', 'Participant File - CMarket')
@section('page-title', 'Participant Audit')

@section('content')
<div class="max-w-6xl mx-auto animate-fade-in space-y-10 pb-20">
    <!-- Header Node -->
    <div class="bg-slate-900 rounded-[3rem] p-8 md:p-12 text-white shadow-2xl shadow-slate-900/10 flex flex-col md:flex-row justify-between items-center gap-8 relative overflow-hidden group">
        <div class="relative z-10 flex items-center gap-6">
            <div class="w-20 h-20 rounded-[2rem] bg-white/10 backdrop-blur-xl border border-white/20 flex items-center justify-center text-4xl shadow-2xl">
                {{ substr($user->name, 0, 1) }}
            </div>
            <div>
                <h2 class="text-2xl md:text-3xl font-black tracking-tight mb-2">{{ $user->name }}</h2>
                <div class="flex flex-wrap gap-2">
                    <span class="px-3 py-1 bg-sky-500 rounded-lg text-[8px] font-black uppercase tracking-widest">UID: #{{ str_pad($user->id, 5, '0', STR_PAD_LEFT) }}</span>
                    <span class="px-3 py-1 bg-white/10 rounded-lg text-[8px] font-black uppercase tracking-widest">{{ $user->roles->pluck('name')->join(' • ') }}</span>
                </div>
            </div>
        </div>
        <div class="relative z-10 w-full md:w-auto">
            <a href="{{ route('admin.users.edit', $user) }}" class="block text-center px-10 py-5 bg-white text-slate-900 rounded-2xl font-black text-[10px] uppercase tracking-widest hover:bg-sky-500 hover:text-white transition-all shadow-xl">
                ✏️ Reconfigure Node
            </a>
        </div>
        <div class="absolute -right-10 -bottom-10 opacity-5 text-[150px] leading-none select-none italic font-black">USER</div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-10">
        <!-- Core Metadata -->
        <div class="lg:col-span-2 space-y-10">
            <div class="bg-white rounded-[2.5rem] p-8 md:p-10 border border-slate-100 shadow-sm space-y-10">
                <div class="flex items-center gap-4">
                    <span class="w-10 h-10 rounded-xl bg-slate-900 text-white flex items-center justify-center text-lg">🪪</span>
                    <h3 class="text-sm font-black text-slate-800 uppercase tracking-widest">Identity Matrix</h3>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-8 md:gap-12">
                    <div class="space-y-1.5">
                        <p class="text-[9px] font-black text-slate-400 uppercase tracking-[0.2em] ml-0.5">Communication Line</p>
                        <p class="text-sm font-black text-slate-800">{{ $user->phone }}</p>
                    </div>
                    <div class="space-y-1.5">
                        <p class="text-[9px] font-black text-slate-400 uppercase tracking-[0.2em] ml-0.5">Identification Email</p>
                        <p class="text-sm font-black text-slate-800">{{ $user->email ?? 'N/A' }}</p>
                    </div>
                    <div class="space-y-1.5">
                        <p class="text-[9px] font-black text-slate-400 uppercase tracking-[0.2em] ml-0.5">Validation Status</p>
                        <div>
                            @if($user->status === 'wallet_verified')
                                <span class="inline-flex items-center gap-2 py-2 px-4 rounded-xl text-[9px] font-black bg-emerald-50 text-emerald-600 border border-emerald-100">VERIFIED NODE</span>
                            @else
                                <span class="inline-flex items-center gap-2 py-2 px-4 rounded-xl text-[9px] font-black bg-slate-50 text-slate-400 border border-slate-100">{{ strtoupper(str_replace('_', ' ', $user->status)) }}</span>
                            @endif
                        </div>
                    </div>
                    <div class="space-y-1.5">
                        <p class="text-[9px] font-black text-slate-400 uppercase tracking-[0.2em] ml-0.5">Protocol Entry Date</p>
                        <p class="text-sm font-black text-slate-800">{{ $user->created_at->format('M d, Y') }} <span class="text-[10px] text-slate-400 opacity-60">({{ $user->created_at->diffForHumans() }})</span></p>
                    </div>
                </div>
            </div>

            <!-- Operational Activity -->
            <div class="bg-white rounded-[2.5rem] border border-slate-100 shadow-sm overflow-hidden">
                <div class="px-10 py-8 border-b border-slate-50 flex items-center justify-between bg-slate-50/30">
                    <h3 class="text-xs font-black text-slate-800 uppercase tracking-widest">Recent Commerce Stream</h3>
                    <span class="text-[10px] font-black text-slate-400">{{ $user->orders->count() }} Orders Detected</span>
                </div>
                <div class="overflow-x-auto">
                    <table class="w-full text-left">
                        <tbody class="divide-y divide-slate-50">
                            @forelse($user->orders->take(5) as $order)
                                <tr class="hover:bg-slate-50 transition-colors">
                                    <td class="px-10 py-6 text-[10px] font-black text-slate-800">#{{ $order->order_number }}</td>
                                    <td class="px-10 py-6 text-[10px] font-bold text-slate-400">{{ $order->created_at->format('d M Y') }}</td>
                                    <td class="px-10 py-6 text-xs font-black text-slate-800">৳{{ number_format($order->total_amount, 2) }}</td>
                                    <td class="px-10 py-6 text-right">
                                        <span class="px-3 py-1 rounded-lg text-[8px] font-black uppercase {{ $order->status == 'delivered' ? 'bg-emerald-50 text-emerald-600' : 'bg-amber-50 text-amber-600' }}">
                                            {{ $order->status }}
                                        </span>
                                    </td>
                                </tr>
                            @empty
                                <tr><td class="px-10 py-20 text-center text-[10px] font-black text-slate-300 uppercase italic">Commerce stream empty</td></tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <!-- Wallet Infrastructure -->
        <div class="space-y-10">
            <div class="bg-white rounded-[2.5rem] p-10 border border-slate-100 shadow-sm space-y-8">
                <h3 class="text-xs font-black text-slate-800 uppercase tracking-widest text-center">Liquidity Reservoirs</h3>
                <div class="space-y-4">
                    @foreach($user->wallets as $wallet)
                        <div class="p-6 rounded-3xl {{ $wallet->wallet_type == 'main' ? 'bg-slate-900 text-white' : 'bg-slate-50 text-slate-800' }} border border-transparent hover:border-sky-500/20 transition-all group">
                            <p class="text-[8px] font-black uppercase tracking-[0.3em] {{ $wallet->wallet_type == 'main' ? 'text-slate-400' : 'text-slate-500' }} mb-4">{{ $wallet->wallet_type }} Reservoir</p>
                            <div class="flex items-center justify-between">
                                <span class="text-2xl font-black">৳{{ number_format($wallet->balance, 2) }}</span>
                                <span class="text-xl opacity-20 group-hover:opacity-100 transition-opacity">💰</span>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>

            <div class="bg-gradient-to-br from-sky-500 to-indigo-600 rounded-[2.5rem] p-10 text-white text-center shadow-xl shadow-sky-500/20">
                <div class="w-16 h-16 bg-white/20 backdrop-blur-xl rounded-2xl flex items-center justify-center text-3xl mx-auto mb-6">🔑</div>
                <h4 class="text-xs font-black uppercase tracking-widest mb-2">Protocol Access</h4>
                <p class="text-[9px] font-bold text-white/60 leading-relaxed mb-8">This node is verified and operates within standard platform security parameters.</p>
                <a href="{{ route('admin.users.generations', $user) }}" class="inline-block w-full py-4 bg-white text-slate-900 rounded-2xl font-black text-[10px] uppercase tracking-widest hover:scale-105 transition-all shadow-lg">
                    View Network Tree 🌍
                </a>
            </div>
        </div>
    </div>
</div>
@endsection
