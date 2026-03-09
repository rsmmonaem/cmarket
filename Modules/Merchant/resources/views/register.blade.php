@extends('layouts.public')

@section('title', 'Become a Seller - C-Market')

@section('content')
<div class="min-h-screen bg-slate-50 dark:bg-slate-950 py-12 md:py-24 px-4 sm:px-6 lg:px-8">
    <div class="max-w-4xl mx-auto">
        <!-- Brand Header -->
        <div class="text-center mb-16 space-y-4 animate-fade-in-down">
            <div class="inline-flex px-4 py-2 bg-primary/10 rounded-2xl text-primary text-[10px] font-black uppercase tracking-[0.2em] mb-4">
                Seller Registration
            </div>
            <h1 class="text-4xl md:text-6xl font-black text-slate-900 dark:text-white tracking-tighter uppercase leading-none">
                Become a <span class="text-primary">C-Market</span> Seller
            </h1>
            <p class="text-slate-500 dark:text-slate-400 font-bold max-w-2xl mx-auto text-sm md:text-base leading-relaxed">
                Open your storefront on our marketplace and reach thousands of daily customers.
            </p>
        </div>

        @guest
            <div class="card-premium p-10 bg-[#0f172a] text-white border-none shadow-2xl text-center space-y-8 max-w-2xl mx-auto">
                <div class="text-6xl mb-6">🔒</div>
                <h3 class="text-2xl font-black uppercase tracking-tight">Login Required</h3>
                <p class="text-slate-400 font-medium">To register as a seller, you must first create or log in to your customer account.</p>
                <div class="flex flex-col sm:flex-row items-center justify-center gap-4 pt-4">
                    <a href="{{ route('login') }}" class="w-full sm:w-auto px-10 py-5 bg-primary text-white rounded-2xl font-black text-[10px] uppercase tracking-widest hover:bg-primary-dark transition-all shadow-xl shadow-primary/20">
                        Log In Now
                    </a>
                    <a href="{{ route('register') }}" class="w-full sm:w-auto px-10 py-5 bg-white/5 border border-white/10 text-white rounded-2xl font-black text-[10px] uppercase tracking-widest hover:bg-white/10 transition-all">
                        Create Account
                    </a>
                </div>
            </div>
        @else
            <div class="grid grid-cols-1 lg:grid-cols-5 gap-10">
                <!-- Registration Form -->
                <div class="lg:col-span-3 space-y-8">
                    <div class="card-premium p-8 md:p-12 bg-white dark:bg-slate-900 border-slate-100 dark:border-slate-800 shadow-2xl shadow-slate-200/50">
                        <form action="{{ route('merchant.register.submit') }}" method="POST" class="space-y-8">
                            @csrf

                            <div class="space-y-6">
                                <h3 class="text-[10px] font-black text-slate-400 uppercase tracking-[0.2em] mb-8 flex items-center gap-2">
                                    <span class="w-2 h-2 bg-primary rounded-full"></span> Business Details
                                </h3>

                                <div class="space-y-2">
                                    <label class="text-[10px] font-black text-slate-400 uppercase tracking-widest ml-1">Store Name *</label>
                                    <input type="text" name="business_name" required value="{{ old('business_name') }}"
                                           placeholder="E.g. Nexus Electronics"
                                           class="w-full px-6 py-4 bg-slate-50 dark:bg-slate-800 border-none rounded-2xl focus:ring-4 focus:ring-primary/10 font-bold text-slate-700 dark:text-white placeholder:text-slate-300">
                                    @error('business_name')
                                        <p class="text-[10px] font-black text-rose-500 uppercase tracking-widest mt-2 ml-1">{{ $message }}</p>
                                    @enderror
                                </div>

                                <div class="space-y-2">
                                    <label class="text-[10px] font-black text-slate-400 uppercase tracking-widest ml-1">Store Type *</label>
                                    <select name="business_type" required
                                            class="w-full px-6 py-4 bg-slate-50 dark:bg-slate-800 border-none rounded-2xl focus:ring-4 focus:ring-primary/10 font-bold text-slate-700 dark:text-white">
                                        <option value="">Select Store Type</option>
                                        <option value="retail">Retail Shop</option>
                                        <option value="wholesale">Wholesale Supply</option>
                                        <option value="manufacturer">Direct Manufacturer</option>
                                        <option value="service">Services</option>
                                        <option value="other">Specialized Sector</option>
                                    </select>
                                    @error('business_type')
                                        <p class="text-[10px] font-black text-rose-500 uppercase tracking-widest mt-2 ml-1">{{ $message }}</p>
                                    @enderror
                                </div>
                            </div>

                            <div class="space-y-6 pt-8">
                                <h3 class="text-[10px] font-black text-slate-400 uppercase tracking-[0.2em] mb-8 flex items-center gap-2">
                                    <span class="w-2 h-2 bg-accent rounded-full"></span> Contact Details
                                </h3>

                                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                    <div class="space-y-2">
                                        <label class="text-[10px] font-black text-slate-400 uppercase tracking-widest ml-1">Primary Phone *</label>
                                        <input type="text" name="phone" value="{{ old('phone', auth()->user()->phone) }}" required
                                               class="w-full px-6 py-4 bg-slate-50 dark:bg-slate-800 border-none rounded-2xl focus:ring-4 focus:ring-primary/10 font-bold text-slate-700 dark:text-white">
                                    </div>

                                    <div class="space-y-2">
                                        <label class="text-[10px] font-black text-slate-400 uppercase tracking-widest ml-1">Contact Email</label>
                                        <input type="email" name="email" value="{{ old('email', auth()->user()->email) }}"
                                               class="w-full px-6 py-4 bg-slate-50 dark:bg-slate-800 border-none rounded-2xl focus:ring-4 focus:ring-primary/10 font-bold text-slate-700 dark:text-white">
                                    </div>
                                </div>

                                <div class="space-y-2">
                                    <label class="text-[10px] font-black text-slate-400 uppercase tracking-widest ml-1">Store Address *</label>
                                    <textarea name="address" rows="3" required
                                              placeholder="Full business location..."
                                              class="w-full px-6 py-4 bg-slate-50 dark:bg-slate-800 border-none rounded-2xl focus:ring-4 focus:ring-primary/10 font-bold text-slate-700 dark:text-white placeholder:text-slate-300">{{ old('address') }}</textarea>
                                </div>
                            </div>

                            <div class="pt-10">
                                <button type="submit" class="w-full btn-matrix btn-primary-matrix py-6 text-[11px] tracking-[0.3em]">
                                    SUBMIT REGISTRATION
                                </button>
                                <p class="text-center text-[9px] font-black text-slate-400 uppercase tracking-widest mt-6 opacity-60">
                                    By deploying, you agree to the C-Market operational standard.
                                </p>
                            </div>
                        </form>
                    </div>
                </div>

                <!-- Benefits Sidebar -->
                <div class="lg:col-span-2 space-y-8">
                    <div class="card-premium p-8 bg-[#0f172a] text-white border-none shadow-2xl relative overflow-hidden group h-full">
                        <div class="relative z-10 space-y-10">
                            <h3 class="text-base font-black uppercase tracking-tight leading-tight">Seller <span class="text-primary">Perks</span></h3>
                            
                            <div class="space-y-8">
                                <div class="flex gap-5">
                                    <div class="w-12 h-12 rounded-xl bg-white/5 border border-white/10 flex items-center justify-center text-xl shadow-lg">🚀</div>
                                    <div class="flex-1">
                                        <h4 class="text-xs font-black uppercase tracking-widest mb-2 text-primary">Easy Setup</h4>
                                        <p class="text-slate-400 text-[10px] font-medium leading-relaxed uppercase tracking-tighter">Get your online shop running in minutes without any technical skills.</p>
                                    </div>
                                </div>

                                <div class="flex gap-5">
                                    <div class="w-12 h-12 rounded-xl bg-white/5 border border-white/10 flex items-center justify-center text-xl shadow-lg">📊</div>
                                    <div class="flex-1">
                                        <h4 class="text-xs font-black uppercase tracking-widest mb-2 text-primary">Sales Analytics</h4>
                                        <p class="text-slate-400 text-[10px] font-medium leading-relaxed uppercase tracking-tighter">Track your sales, popular products, and revenue right from your dashboard.</p>
                                    </div>
                                </div>

                                <div class="flex gap-5">
                                    <div class="w-12 h-12 rounded-xl bg-white/5 border border-white/10 flex items-center justify-center text-xl shadow-lg">🛡️</div>
                                    <div class="flex-1">
                                        <h4 class="text-xs font-black uppercase tracking-widest mb-2 text-primary">Fast Payouts</h4>
                                        <p class="text-slate-400 text-[10px] font-medium leading-relaxed uppercase tracking-tighter">Get paid for your orders securely and directly into your store wallet.</p>
                                    </div>
                                </div>
                            </div>

                            <div class="pt-10 border-t border-white/5">
                                <div class="p-6 rounded-xl bg-primary/10 text-center">
                                    <p class="text-lg font-black tracking-tight uppercase">Start selling today! 💸</p>
                                </div>
                            </div>
                        </div>
                        <div class="absolute -right-10 -top-10 opacity-5 text-[240px] leading-none select-none italic font-black">PROT</div>
                    </div>
                </div>
            </div>
        @endguest
    </div>
</div>
@endsection
