@extends('layouts.admin')

@section('title', 'Top-up Verification')
@section('page-title', 'Wallet Fund Requests')

@section('content')
<div class="space-y-8 animate-fade-in">
    <!-- Summary Header -->
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
        <div class="bg-white rounded-[2.5rem] p-8 border border-slate-100 shadow-sm">
            <h3 class="text-[10px] font-black uppercase tracking-widest text-slate-400 mb-2">Pending Requests</h3>
            <p class="text-3xl font-black text-amber-500">{{ \App\Models\Topup::where('status', 'pending')->count() }}</p>
        </div>
        <div class="bg-white rounded-[2.5rem] p-8 border border-slate-100 shadow-sm">
            <h3 class="text-[10px] font-black uppercase tracking-widest text-slate-400 mb-2">Approved Today</h3>
            <p class="text-3xl font-black text-emerald-500">৳{{ number_format(\App\Models\Topup::where('status', 'approved')->whereDate('created_at', today())->sum('amount'), 2) }}</p>
        </div>
        <div class="bg-indigo-900 rounded-[2.5rem] p-8 text-white relative overflow-hidden group">
            <h3 class="text-[10px] font-black uppercase tracking-widest text-indigo-200 mb-2">Total System Recharge</h3>
            <p class="text-3xl font-black">৳{{ number_format(\App\Models\Topup::where('status', 'approved')->sum('amount'), 2) }}</p>
            <div class="absolute -right-6 -bottom-6 opacity-10 text-8xl group-hover:scale-110 transition-transform">💰</div>
        </div>
    </div>

    <!-- Request Table -->
    <div class="bg-white rounded-[2.5rem] border border-slate-100 shadow-sm overflow-hidden">
        <div class="p-8 border-b border-slate-100 flex items-center justify-between">
            <h3 class="text-sm font-black uppercase tracking-widest text-slate-500 font-jakarta">Wallet Recharge Logs</h3>
            <div class="flex items-center gap-4">
                <a href="{{ route('admin.topups.create') }}" class="px-5 py-2.5 rounded-xl bg-slate-900 text-white text-[10px] font-black uppercase tracking-widest hover:bg-indigo-600 transition shadow-lg shadow-slate-900/10 active:scale-95">Direct Top-up 💳</a>
                <span class="px-4 py-1.5 rounded-full bg-slate-100 text-slate-500 text-[10px] font-black uppercase tracking-wider">Total: {{ $topups->total() }}</span>
            </div>
        </div>
        <div class="overflow-x-auto">
            <table class="w-full text-left">
                <thead>
                    <tr class="bg-slate-50">
                        <th class="px-8 py-5 text-[10px] font-black uppercase tracking-widest text-slate-400">User / Date</th>
                        <th class="px-8 py-5 text-[10px] font-black uppercase tracking-widest text-slate-400">Transaction ID</th>
                        <th class="px-8 py-5 text-[10px] font-black uppercase tracking-widest text-slate-400">Method / Number</th>
                        <th class="px-8 py-5 text-[10px] font-black uppercase tracking-widest text-slate-400">Amount (৳)</th>
                        <th class="px-8 py-5 text-[10px] font-black uppercase tracking-widest text-slate-400">Status</th>
                        <th class="px-8 py-5 text-[10px] font-black uppercase tracking-widest text-slate-400 text-right">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100 font-jakarta font-bold text-sm text-slate-700">
                    @forelse($topups as $topup)
                        <tr class="hover:bg-slate-50/50 transition-colors">
                            <td class="px-8 py-5">
                                <span class="text-slate-800">{{ $topup->user->name }}</span>
                                <div class="text-[10px] text-slate-400 mt-0.5 tracking-tight">{{ $topup->created_at->format('M d, Y • h:i A') }}</div>
                            </td>
                            <td class="px-8 py-5">
                                <span class="px-3 py-1 rounded bg-slate-100 text-[9px] font-black uppercase tracking-tighter text-slate-500">{{ $topup->transaction_id }}</span>
                            </td>
                            <td class="px-8 py-5">
                                <div class="flex items-center gap-2">
                                    <span class="text-slate-800 uppercase text-xs">{{ $topup->method }}</span>
                                </div>
                                <div class="text-[10px] text-slate-400 mt-0.5">{{ $topup->sender_number }}</div>
                            </td>
                            <td class="px-8 py-5 text-slate-800">৳{{ number_format($topup->amount, 2) }}</td>
                            <td class="px-8 py-5">
                                @if($topup->status === 'pending')
                                    <span class="px-3 py-1 rounded-full bg-amber-100 text-amber-600 text-[9px] font-black uppercase tracking-widest">Pending Verification</span>
                                @elseif($topup->status === 'approved')
                                    <span class="px-3 py-1 rounded-full bg-emerald-100 text-emerald-600 text-[9px] font-black uppercase tracking-widest">Approved</span>
                                @else
                                    <span class="px-3 py-1 rounded-full bg-rose-100 text-rose-600 text-[9px] font-black uppercase tracking-widest">Rejected</span>
                                @endif
                            </td>
                            <td class="px-8 py-5 text-right">
                                @if($topup->status === 'pending')
                                <div class="flex gap-2 justify-end">
                                    <form action="{{ route('admin.topups.approve', $topup) }}" method="POST">
                                        @csrf
                                        <button type="submit" class="px-4 py-2 rounded-xl bg-emerald-500 text-white text-[9px] font-black uppercase tracking-widest transition hover:scale-105 active:scale-95 shadow-lg shadow-emerald-500/20 shadow-emerald-500/20">Approve</button>
                                    </form>
                                    <button onclick="rejectModal('{{ route('admin.topups.reject', $topup) }}')" class="px-4 py-2 rounded-xl bg-rose-500 text-white text-[9px] font-black uppercase tracking-widest transition hover:scale-105 active:scale-95 shadow-lg shadow-rose-500/20 shadow-rose-500/20">Reject</button>
                                </div>
                                @else
                                    <span class="text-[10px] text-slate-400 uppercase tracking-widest font-black italic">Archived</span>
                                @endif
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="px-8 py-20 text-center text-slate-400 font-black uppercase tracking-widest opacity-30">No top-up requests logs</td>
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
    function rejectModal(route) {
        Swal.fire({
            title: '<span class="text-lg font-black uppercase tracking-widest">Reject Recharge</span>',
            input: 'textarea',
            inputLabel: 'Reason for rejection (Visible to customer)',
            inputPlaceholder: 'Type reason here...',
            inputAttributes: {
                'aria-label': 'Reason for rejection',
                'class': 'rounded-2xl bg-slate-50 border-2 border-slate-200 p-4 text-xs font-bold'
            },
            showCancelButton: true,
            confirmButtonText: 'REJECT NOW',
            confirmButtonColor: '#f43f5e',
            cancelButtonColor: '#0f172a',
            customClass: {
                popup: 'rounded-[2rem] border border-slate-100 p-8',
                confirmButton: 'px-8 py-4 rounded-xl text-[10px] font-black uppercase tracking-widest shadow-xl shadow-rose-500/20',
                cancelButton: 'px-8 py-4 rounded-xl text-[10px] font-black uppercase tracking-widest'
            },
        }).then((result) => {
            if (result.isConfirmed) {
                const form = document.createElement('form');
                form.method = 'POST';
                form.action = route;
                
                const csrf = document.createElement('input');
                csrf.type = 'hidden';
                csrf.name = '_token';
                csrf.value = '{{ csrf_token() }}';
                
                const note = document.createElement('input');
                note.type = 'hidden';
                note.name = 'admin_note';
                note.value = result.value;
                
                form.appendChild(csrf);
                form.appendChild(note);
                document.body.appendChild(form);
                form.submit();
            }
        });
    }
</script>
@endsection
