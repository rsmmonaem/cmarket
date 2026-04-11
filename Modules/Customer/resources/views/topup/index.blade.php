@extends('layouts.customer')

@section('title', 'Top-up History')
@section('page-title', 'Recent Recharges')

@section('content')
<div class="max-w-6xl mx-auto space-y-8 animate-fade-in">
    <!-- Action Bar -->
    <div class="flex items-center justify-between bg-white px-8 py-6 rounded-[2.5rem] border border-slate-100 shadow-sm">
        <div>
            <h2 class="text-xl font-black text-slate-800 tracking-tight">Recharge History 📊</h2>
            <p class="text-xs font-bold text-slate-400">Track and manage your wallet funds.</p>
        </div>
        <a href="{{ route('customer.topup.create') }}" class="px-6 py-4 rounded-2xl bg-sky-500 text-white text-[10px] font-black uppercase tracking-widest hover:scale-105 transition-all shadow-lg shadow-sky-500/20 active:scale-95 text-center">New Recharge ➕</a>
    </div>

    <!-- History Table -->
    <div class="bg-white rounded-[2.5rem] border border-slate-100 shadow-sm overflow-hidden">
        <div class="p-8 border-b border-slate-100 flex items-center justify-between">
            <h3 class="text-sm font-black uppercase tracking-widest text-slate-500">Transaction Log</h3>
            <span class="px-4 py-1.5 rounded-full bg-slate-100 text-slate-500 text-[10px] font-black uppercase tracking-wider">Total: {{ $topups->total() }}</span>
        </div>
        <div class="overflow-x-auto">
            <table class="w-full text-left">
                <thead>
                    <tr class="bg-slate-50">
                        <th class="px-8 py-5 text-[10px] font-black uppercase tracking-widest text-slate-400">ID / Date</th>
                        <th class="px-8 py-5 text-[10px] font-black uppercase tracking-widest text-slate-400">Method / Number</th>
                        <th class="px-8 py-5 text-[10px] font-black uppercase tracking-widest text-slate-400">Amount (৳)</th>
                        <th class="px-8 py-5 text-[10px] font-black uppercase tracking-widest text-slate-400">Status</th>
                        <th class="px-8 py-5 text-[10px] font-black uppercase tracking-widest text-slate-400">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100 font-bold text-sm text-slate-700">
                    @forelse($topups as $topup)
                        <tr class="hover:bg-slate-50/50 transition-colors">
                            <td class="px-8 py-5">
                                <span class="text-slate-800">#{{ $topup->id }}</span>
                                <div class="text-[10px] text-slate-400 mt-0.5 tracking-tight">{{ $topup->created_at->format('M d, Y • h:i A') }}</div>
                            </td>
                            <td class="px-8 py-5">
                                <div class="flex items-center gap-2">
                                    <span class="w-6 h-6 rounded bg-slate-100 text-[9px] flex items-center justify-center">💳</span>
                                    <span class="text-slate-800 uppercase text-xs">{{ $topup->method }}</span>
                                </div>
                                <div class="text-[10px] text-slate-400 mt-0.5">{{ $topup->sender_number }}</div>
                            </td>
                            <td class="px-8 py-5 text-slate-800">৳{{ number_format($topup->amount, 2) }}</td>
                            <td class="px-8 py-5">
                                @if($topup->status === 'pending')
                                    <span class="px-3 py-1 rounded-full bg-amber-100 text-amber-600 text-[9px] font-black uppercase tracking-widest">Pending</span>
                                @elseif($topup->status === 'approved')
                                    <span class="px-3 py-1 rounded-full bg-emerald-100 text-emerald-600 text-[9px] font-black uppercase tracking-widest">Approved</span>
                                @else
                                    <span class="px-3 py-1 rounded-full bg-rose-100 text-rose-600 text-[9px] font-black uppercase tracking-widest">Rejected</span>
                                @endif
                            </td>
                            <td class="px-8 py-5">
                                <button onclick="showDetails('{{ $topup->transaction_id }}', '{{ $topup->admin_note ?? 'None' }}')" class="px-4 py-2 rounded-lg bg-slate-100 text-slate-500 text-[10px] font-black tracking-widest hover:bg-slate-200 transition">INFO</button>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="px-8 py-20 text-center text-slate-400 font-black uppercase tracking-widest opacity-30">No transactions recorded</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        <div class="px-8 py-6 bg-slate-50 border-t border-slate-100">
            {{ $topups->links() }}
        </div>
    </div>
</div>

<script>
    function showDetails(txid, note) {
        Swal.fire({
            title: '<span class="text-lg font-black uppercase tracking-widest">Transaction Details</span>',
            html: `
                <div class="text-left space-y-4 p-4 bg-slate-50 rounded-2xl border border-slate-100">
                    <div>
                        <label class="text-[9px] font-black uppercase text-slate-400 block mb-1">Transaction ID</label>
                        <div class="text-sm font-black text-slate-800 break-all">${txid}</div>
                    </div>
                    <div>
                        <label class="text-[9px] font-black uppercase text-slate-400 block mb-1">Admin Feedback</label>
                        <div class="text-sm font-bold text-slate-600 leading-relaxed">${note}</div>
                    </div>
                </div>
            `,
            confirmButtonText: 'CLOSE',
            confirmButtonColor: '#0f172a',
            customClass: {
                popup: 'rounded-[2rem] border border-slate-100 p-8',
                confirmButton: 'px-8 py-4 rounded-xl text-[10px] font-black uppercase tracking-widest shadow-xl shadow-slate-900/10'
            },
            showClass: { popup: 'animate__animated animate__fadeInUp' },
            hideClass: { popup: 'animate__animated animate__fadeOutDown' }
        });
    }
</script>
@endsection
