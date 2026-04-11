@extends('layouts.admin')

@section('title', 'Direct Top-up')
@section('page-title', 'Manual Wallet Deposit')

@section('content')
<div class="max-w-4xl mx-auto space-y-8 animate-fade-in">
    <!-- Header -->
    <div class="flex items-center justify-between">
        <div>
            <h2 class="text-2xl font-black text-slate-800 tracking-tight">Direct Recharge 💳</h2>
            <p class="text-sm font-bold text-slate-400">Instantly credit any customer's main wallet.</p>
        </div>
        <a href="{{ route('admin.topups.index') }}" class="px-6 py-3 rounded-xl bg-slate-100 text-slate-600 text-xs font-black uppercase tracking-widest hover:bg-slate-200 transition">Back to Logs</a>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
        <!-- Form -->
        <div class="lg:col-span-2">
            <div class="bg-white rounded-[2.5rem] p-8 border border-slate-100 shadow-sm">
                <form action="{{ route('admin.topups.direct-store') }}" method="POST" class="space-y-6">
                    @csrf
                    
                    <div class="space-y-6">
                        <div class="space-y-3">
                            <label class="text-[10px] font-black uppercase tracking-widest text-slate-500 pl-1">Target Customer</label>
                            <select name="user_id" class="w-full bg-slate-50 border-2 border-slate-100 rounded-2xl px-5 py-4 text-sm font-bold focus:border-indigo-500 focus:bg-white transition-all outline-none" required>
                                <option value="" disabled selected>Select a customer...</option>
                                @foreach($users as $user)
                                    <option value="{{ $user->id }}">{{ $user->name }} (#{{ $user->id }}) - {{ $user->phone }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div class="space-y-3">
                                <label class="text-[10px] font-black uppercase tracking-widest text-slate-500 pl-1">Method</label>
                                <select name="method" class="w-full bg-slate-50 border-2 border-slate-100 rounded-2xl px-5 py-4 text-sm font-bold focus:border-indigo-500 focus:bg-white transition-all outline-none" required>
                                    <option value="Cash">Cash</option>
                                    <option value="Bank">Bank Transfer</option>
                                    <option value="Adjustment">Balance Adjustment</option>
                                    <option value="Promotion">Promotion/Bonus</option>
                                </select>
                            </div>
                            <div class="space-y-3">
                                <label class="text-[10px] font-black uppercase tracking-widest text-slate-500 pl-1">Amount (৳)</label>
                                <input type="number" name="amount" min="1" step="0.01" placeholder="0.00" class="w-full bg-slate-50 border-2 border-slate-100 rounded-2xl px-5 py-4 text-sm font-bold focus:border-indigo-500 focus:bg-white transition-all outline-none" required>
                            </div>
                        </div>

                        <div class="space-y-3">
                            <label class="text-[10px] font-black uppercase tracking-widest text-slate-500 pl-1">Admin Note (Internal)</label>
                            <textarea name="admin_note" rows="3" placeholder="Reason for direct recharge..." class="w-full bg-slate-50 border-2 border-slate-100 rounded-2xl px-5 py-4 text-sm font-bold focus:border-indigo-500 focus:bg-white transition-all outline-none"></textarea>
                        </div>
                    </div>

                    <div class="pt-4">
                        <button type="submit" class="w-full py-5 rounded-2xl bg-indigo-600 text-white font-black text-xs uppercase tracking-widest hover:bg-slate-900 transition shadow-xl shadow-indigo-500/20 active:scale-95">Confirm Direct Recharge ✅</button>
                    </div>
                </form>
            </div>
        </div>

        <!-- Info -->
        <aside class="space-y-6">
            <div class="bg-indigo-900 rounded-[2.5rem] p-8 text-white relative overflow-hidden group">
                <h4 class="text-sm font-black uppercase tracking-widest mb-4">Admin Security</h4>
                <p class="text-[10px] text-indigo-100 font-bold leading-relaxed opacity-60">
                    Direct top-ups skip the standard verification process and credit the user's wallet immediately. Use this only for cash deposits or internal adjustments.
                </p>
                <div class="absolute -right-10 -bottom-10 opacity-10 text-[10rem] group-hover:rotate-12 transition-transform">🛡️</div>
            </div>
        </aside>
    </div>
</div>
@endsection
