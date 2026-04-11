@extends('layouts.customer')

@section('title', 'Recharge Wallet')
@section('page-title', 'Wallet Top-up')

@section('content')
<div class="max-w-4xl mx-auto space-y-8 animate-fade-in">
    <!-- Header -->
    <div class="flex items-center justify-between">
        <div>
            <h2 class="text-2xl font-black text-slate-800 tracking-tight">Add Funds 💰</h2>
            <p class="text-sm font-bold text-slate-400">Submit your transaction details for admin verification.</p>
        </div>
        <a href="{{ route('customer.topup.index') }}" class="px-6 py-3 rounded-xl bg-slate-100 text-slate-600 text-xs font-black uppercase tracking-widest hover:bg-slate-200 transition">History</a>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
        <!-- Form -->
        <div class="lg:col-span-2">
            <div class="bg-white rounded-[2.5rem] p-8 border border-slate-100 shadow-sm">
                <form action="{{ route('customer.topup.store') }}" method="POST" class="space-y-6">
                    @csrf
                    
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <label class="text-[10px] font-black uppercase tracking-widest text-slate-500 mb-2 block">Payment Method</label>
                            <select name="method" class="w-full bg-slate-50 border-2 border-slate-100 rounded-2xl px-5 py-4 text-sm font-bold focus:border-sky-500 focus:bg-white transition-all outline-none" required>
                                @foreach($methods as $method)
                                    <option value="{{ $method }}">{{ $method }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div>
                            <label class="text-[10px] font-black uppercase tracking-widest text-slate-500 mb-2 block">Amount (৳)</label>
                            <input type="number" name="amount" min="{{ $min_amount }}" step="0.01" placeholder="Min {{ number_format($min_amount, 2) }}" class="w-full bg-slate-50 border-2 border-slate-100 rounded-2xl px-5 py-4 text-sm font-bold focus:border-sky-500 focus:bg-white transition-all outline-none" required>
                        </div>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <label class="text-[10px] font-black uppercase tracking-widest text-slate-500 mb-2 block">Transaction ID</label>
                            <input type="text" name="transaction_id" placeholder="TRX123456789" class="w-full bg-slate-50 border-2 border-slate-100 rounded-2xl px-5 py-4 text-sm font-bold focus:border-sky-500 focus:bg-white transition-all outline-none" required>
                        </div>
                        <div>
                            <label class="text-[10px] font-black uppercase tracking-widest text-slate-500 mb-2 block">Your Number (Sender)</label>
                            <input type="text" name="sender_number" placeholder="01XXXXXXXXX" class="w-full bg-slate-50 border-2 border-slate-100 rounded-2xl px-5 py-4 text-sm font-bold focus:border-sky-500 focus:bg-white transition-all outline-none" required>
                        </div>
                    </div>

                    <div class="pt-4">
                        <button type="submit" class="w-full py-5 rounded-2xl bg-slate-900 text-white font-black text-xs uppercase tracking-widest hover:bg-sky-600 transition shadow-xl shadow-slate-900/10 active:scale-95">Submit Request 🚀</button>
                    </div>
                </form>
            </div>
        </div>

        <!-- Instructions -->
        <aside class="space-y-6">
            <div class="bg-indigo-900 rounded-[2.5rem] p-8 text-white relative overflow-hidden group">
                <h4 class="text-sm font-black uppercase tracking-widest mb-4">Payment Instructions</h4>
                <div class="space-y-4 relative z-10">
                    <div class="flex gap-4">
                        <div class="w-8 h-8 rounded-lg bg-white/10 flex items-center justify-center text-xs font-black">1</div>
                        <p class="text-xs text-indigo-100 font-bold leading-relaxed">Send money to our official Merchant numbers.</p>
                    </div>
                    <div class="flex gap-4">
                        <div class="w-8 h-8 rounded-lg bg-white/10 flex items-center justify-center text-xs font-black">2</div>
                        <p class="text-xs text-indigo-100 font-bold leading-relaxed">Copy the Transaction ID from your SMS.</p>
                    </div>
                    <div class="flex gap-4">
                        <div class="w-8 h-8 rounded-lg bg-white/10 flex items-center justify-center text-xs font-black">3</div>
                        <p class="text-xs text-indigo-100 font-bold leading-relaxed">Fill the form and wait for approval (5-30 mins).</p>
                    </div>
                </div>
                <div class="absolute -right-10 -bottom-10 opacity-10 text-[10rem] group-hover:rotate-12 transition-transform">🏦</div>
            </div>

            <div class="bg-amber-50 rounded-[2.5rem] p-8 border border-amber-100">
                <h4 class="text-[10px] font-black uppercase tracking-widest text-amber-800 mb-2">Help Center</h4>
                <p class="text-xs font-bold text-amber-900/60 leading-relaxed mb-4">Facing issues with your recharge? Contact our 24/7 support team.</p>
                <a href="#" class="text-xs font-black text-amber-600 hover:text-amber-700">Open Ticket →</a>
            </div>
        </aside>
    </div>
</div>
@endsection
