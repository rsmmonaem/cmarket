@section('title', 'Payout Request #' . $withdrawal->id)
@section('page-title', 'Withdrawal Request #' . $withdrawal->id)

@section('content')
<div class="max-w-4xl mx-auto">
    <!-- Header Summary Card -->
    <div class="card-solid mb-8 text-center" style="background: linear-gradient(135deg, #1e293b 0%, #0f172a 100%); border: none;">
        <p class="text-[10px] font-black uppercase tracking-widest text-slate-400 mb-2">Requested Withdrawal Amount</p>
        <div class="text-5xl font-black text-white mb-6">৳{{ number_format($withdrawal->amount, 2) }}</div>
        
        <div class="flex items-center justify-center gap-4">
            @if($withdrawal->status === 'pending')
                <span class="px-4 py-2 rounded-2xl bg-amber-500/10 text-amber-500 border border-amber-500/20 text-[10px] font-black uppercase tracking-widest">
                    <span class="w-1.5 h-1.5 rounded-full bg-amber-500 inline-block mr-2 animate-pulse"></span> Queued for Approval
                </span>
            @elseif($withdrawal->status === 'approved')
                <span class="px-4 py-2 rounded-2xl bg-emerald-500/10 text-emerald-500 border border-emerald-500/20 text-[10px] font-black uppercase tracking-widest">
                    <span class="w-1.5 h-1.5 rounded-full bg-emerald-500 inline-block mr-2"></span> Disbursed Successfully
                </span>
            @else
                <span class="px-4 py-2 rounded-2xl bg-red-500/10 text-red-500 border border-red-500/20 text-[10px] font-black uppercase tracking-widest">
                    <span class="w-1.5 h-1.5 rounded-full bg-red-500 inline-block mr-2"></span> Request Declined
                </span>
            @endif
        </div>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-2 gap-8 mb-8">
        <!-- Beneficiary Info -->
        <x-admin.card title="Beneficiary Details">
            <div class="flex items-center gap-4 mb-6">
                <div class="w-14 h-14 rounded-2xl bg-primary text-white flex items-center justify-center text-2xl font-black shadow-xl shadow-primary/20">
                    {{ substr($withdrawal->wallet->user->name, 0, 1) }}
                </div>
                <div>
                    <div class="text-xl font-black text-light">{{ $withdrawal->wallet->user->name }}</div>
                    <div class="text-xs font-bold text-muted-light uppercase tracking-widest">{{ $withdrawal->wallet->user->phone }}</div>
                </div>
            </div>

            <div class="space-y-4">
                <div class="flex justify-between items-center p-3 rounded-xl bg-slate-50 dark:bg-slate-900/50">
                    <span class="text-[10px] font-black uppercase tracking-widest text-muted-light">Source Wallet</span>
                    <span class="px-3 py-1 rounded-lg bg-primary text-white text-[10px] font-black uppercase tracking-widest">
                        {{ $withdrawal->wallet->wallet_type }}
                    </span>
                </div>
                <div class="flex justify-between items-center p-3 rounded-xl bg-slate-50 dark:bg-slate-900/50">
                    <span class="text-[10px] font-black uppercase tracking-widest text-muted-light">Transfer via</span>
                    <span class="text-sm font-black text-light uppercase tracking-tighter">{{ str_replace('_', ' ', $withdrawal->payment_method) }}</span>
                </div>
                <div class="flex justify-between items-center p-3 rounded-xl bg-slate-50 dark:bg-slate-900/50">
                    <span class="text-[10px] font-black uppercase tracking-widest text-muted-light">Current Balance</span>
                    <span class="text-sm font-black text-emerald-600 dark:text-emerald-400">৳{{ number_format($withdrawal->wallet->balance, 2) }}</span>
                </div>
            </div>
        </x-admin.card>

        <!-- Payout Destination -->
        <x-admin.card title="Payment Account Details">
            <div class="bg-slate-900 text-slate-300 p-6 rounded-2xl font-mono text-sm leading-relaxed border border-slate-800 shadow-inner">
                <div class="text-xs font-black text-slate-500 uppercase tracking-widest mb-4 border-b border-slate-800 pb-2">Verified Destination Address</div>
                {{ $withdrawal->account_details }}
            </div>
        </x-admin.card>
    </div>

    <!-- Processing Actions -->
    @if($withdrawal->status === 'pending')
        <x-admin.card title="Review & Processing">
            <p class="text-sm text-muted-light mb-8 font-medium">Please verify the payout destination before proceeding with the disbursement. Once approved, funds will be deducted from the user's wallet immediately.</p>
            
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                <!-- Approve -->
                <form action="{{ route('admin.withdrawals.approve', $withdrawal) }}" method="POST">
                    @csrf
                    <button type="submit" class="w-full h-14 flex items-center justify-center gap-2 rounded-2xl bg-emerald-600 text-white font-black uppercase tracking-widest text-xs hover:bg-emerald-700 transition shadow-lg shadow-emerald-500/20">
                        ✨ Approve & Disburse
                    </button>
                </form>

                <!-- Reject -->
                <button type="button" onclick="showRejectModal()" class="w-full h-14 flex items-center justify-center gap-2 rounded-2xl bg-red-600 text-white font-black uppercase tracking-widest text-xs hover:bg-red-700 transition shadow-lg shadow-red-500/20">
                    ✕ Decline Request
                </button>
            </div>
        </x-admin.card>

        <!-- Premium Reject Modal -->
        <div id="rejectModal" class="hidden fixed inset-0 bg-slate-950/80 backdrop-blur-sm flex items-center justify-center z-[100] p-4">
            <div class="card-solid max-w-md w-full animate-in fade-in zoom-in duration-200 shadow-2xl">
                <div class="flex items-center gap-3 mb-6">
                    <div class="w-10 h-10 rounded-xl bg-red-100 text-red-600 flex items-center justify-center text-xl">⚠️</div>
                    <h3 class="text-xl font-black text-light">Decline Payout</h3>
                </div>
                
                <form action="{{ route('admin.withdrawals.reject', $withdrawal) }}" method="POST" id="rejectForm">
                    @csrf
                    <label class="text-[10px] font-black uppercase tracking-widest text-muted-light block mb-2">Reason for rejection *</label>
                    <textarea name="rejection_reason" rows="4" 
                              class="w-full px-4 py-3 rounded-xl border border-light bg-slate-50 dark:bg-slate-900 border-border-light focus:ring-2 focus:ring-primary outline-none transition text-sm font-medium"
                              placeholder="e.g. Invalid account details, insufficient funds..." required></textarea>
                    
                    <div class="flex justify-end gap-3 mt-8">
                        <button type="button" onclick="hideRejectModal()" class="px-6 py-3 rounded-xl font-bold text-sm text-muted-light hover:text-light transition">Cancel</button>
                        <button type="submit" class="px-6 py-3 rounded-xl bg-red-600 text-white font-black text-xs uppercase tracking-widest shadow-lg shadow-red-500/20">Confirm Decline</button>
                    </div>
                </form>
            </div>
        </div>

        <script>
            function showRejectModal() {
                document.getElementById('rejectModal').classList.remove('hidden');
            }
            function hideRejectModal() {
                document.getElementById('rejectModal').classList.add('hidden');
            }
        </script>
    @else
        <x-admin.card title="Audit History">
            <div class="flex items-center gap-4 p-6 rounded-2xl bg-slate-50 dark:bg-slate-900/50 border border-light/50">
                <div class="text-4xl">🧾</div>
                <div>
                    @if($withdrawal->status === 'approved')
                        <div class="text-sm font-black text-light uppercase tracking-widest mb-1">Transaction Completed</div>
                        <p class="text-xs font-medium text-muted-light">This request was approved and processed on <strong>{{ $withdrawal->updated_at->format('M d, Y • h:i A') }}</strong>.</p>
                    @else
                        <div class="text-sm font-black text-red-600 uppercase tracking-widest mb-1">Transaction Declined</div>
                        <p class="text-xs font-medium text-muted-light mb-2">Declined on <strong>{{ $withdrawal->updated_at->format('M d, Y • h:i A') }}</strong>.</p>
                        <div class="px-4 py-2 rounded-lg bg-red-50 dark:bg-red-900/10 border border-red-100 dark:border-red-900/20 text-xs font-bold text-red-700 dark:text-red-400">
                            Reason: {{ $withdrawal->rejection_reason }}
                        </div>
                    @endif
                </div>
            </div>
        </x-admin.card>
    @endif
    
    <div class="mt-8 text-center">
        <a href="{{ route('admin.withdrawals.index') }}" class="text-[10px] font-black uppercase tracking-widest text-muted-light hover:text-primary transition">
            ← Back to Payout Queue
        </a>
    </div>
</div>
@endsection
