@extends('layouts.customer')

@section('title', 'Membership Card')
@section('page-title', 'Digital Membership')

@section('content')
<div class="max-w-4xl mx-auto space-y-12 animate-fade-in pb-20" x-data="{ revealed: false }">
    <!-- Header -->
    <div class="flex items-center justify-between">
        <div class="space-y-1">
            <h2 class="text-3xl font-black text-slate-900 tracking-tight">Elite Membership 💎</h2>
            <p class="text-sm font-bold text-slate-400">Your exclusive identity within the CMarket ecosystem.</p>
        </div>
        <div class="hidden md:block">
            <span class="px-6 py-3 rounded-2xl bg-slate-900 text-white text-[10px] font-black uppercase tracking-[0.2em] shadow-xl shadow-slate-900/20">Official Virtual ID</span>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-2 gap-12 items-start">
        <!-- Visual MasterCard Style Card -->
        <div class="perspective-1000">
            <div @if($user->has_membership_card) @click="revealed = !revealed" @endif
                 class="relative w-full aspect-[1.58/1] rounded-[2rem] transition-all duration-700 transform-style-3d group shadow-2xl overflow-hidden animate-float {{ $user->has_membership_card ? 'cursor-pointer' : 'cursor-default' }} select-none">
                
                <!-- Front Side -->
                <div class="absolute inset-0 bg-gradient-to-br from-slate-950 via-slate-900 to-indigo-950 p-10 flex flex-col justify-between text-white backface-hidden">
                    <!-- Glassmorphism Overlays -->
                    <div class="absolute top-0 right-0 w-64 h-64 bg-sky-500 rounded-full blur-[100px] opacity-10"></div>
                    <div class="absolute -left-20 -bottom-20 w-80 h-80 bg-indigo-500 rounded-full blur-[120px] opacity-10"></div>
                    
                    <div class="flex justify-between items-start relative z-10">
                        <!-- Card Chip -->
                        <div class="w-14 h-11 rounded-lg bg-gradient-to-br from-amber-200 via-amber-400 to-amber-600 border border-white/20 relative overflow-hidden shadow-inner">
                            <div class="absolute inset-0 opacity-20 bg-[url('https://www.transparenttextures.com/patterns/carbon-fibre.png')]"></div>
                            <div class="grid grid-cols-3 grid-rows-4 h-full border-white/10 opacity-30">
                                @for($i=0; $i<12; $i++) <div class="border-[0.5px]"></div> @endfor
                            </div>
                        </div>
                        <div class="text-right">
                            <div class="text-xl font-black italic tracking-tighter text-white/90">CMARKET</div>
                            <div class="text-[8px] font-black tracking-[0.3em] text-sky-400 uppercase mt-1">Ecosystem Partner</div>
                        </div>
                    </div>

                    <div class="space-y-6 relative z-10">
                        <div>
                            <div class="flex gap-4 items-center">
                                <h3 class="text-3xl font-mono font-bold tracking-[0.15em] text-white transition-all duration-500"
                                    x-text="revealed ? '{{ $user->has_membership_card ? $user->member_id : 'CAB 10001' }}' : 'CAB **** ****'">
                                </h3>
                                @if($user->has_membership_card)
                                <template x-if="revealed">
                                    <span class="w-3 h-3 rounded-full bg-emerald-500 animate-pulse"></span>
                                </template>
                                @endif
                            </div>
                        </div>

                        <div class="flex justify-between items-end">
                            <div>
                                <p class="text-[8px] font-black uppercase tracking-[0.4em] text-slate-500 mb-1.5">Card Member</p>
                                <h4 class="text-lg font-black tracking-wide uppercase truncate max-w-[200px] transition-all duration-500"
                                    x-text="revealed ? '{{ $user->name }}' : '**********'">
                                </h4>
                            </div>
                            <div class="flex flex-col items-end">
                                <!-- Custom C Logo -->
                                <div class="w-12 h-12 rounded-2xl bg-gradient-to-br from-amber-300 via-amber-500 to-amber-700 p-0.5 shadow-lg shadow-amber-900/40 mb-2">
                                    <div class="w-full h-full rounded-[0.9rem] bg-slate-900 flex items-center justify-center border border-white/10">
                                        <span class="text-2xl font-black italic tracking-tighter text-amber-500 transform -skew-x-12">C</span>
                                    </div>
                                </div>
                                <p class="text-[7px] font-black uppercase tracking-widest text-slate-500">Elite Network</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            
            <div class="mt-6 flex justify-center">
                @if($user->has_membership_card)
                <button @click="revealed = !revealed" class="px-6 py-3 rounded-full bg-slate-900 text-white text-[10px] font-black uppercase tracking-[0.2em] shadow-xl shadow-slate-900/40 transition-all hover:bg-sky-600 active:scale-95 group flex items-center gap-3">
                    <span x-show="!revealed">✨ Reveal My Secret Card Details</span>
                    <span x-show="revealed">🔒 Secure & Hide Card Details</span>
                    <span class="transition-transform duration-500" :class="revealed ? 'rotate-180' : ''">⌄</span>
                </button>
                @else
                <button onclick="document.getElementById('purchaseForm').scrollIntoView({behavior: 'smooth'})" 
                        class="px-5 py-2 rounded-full bg-slate-100 text-slate-400 text-[10px] font-black uppercase tracking-widest border border-slate-200 transition-all hover:bg-slate-900 hover:text-white flex items-center gap-2">
                    <span>🔒</span>
                    Purchase Card to Reveal Details 
                </button>
                @endif
            </div>
        </div>

        <!-- Purchase/Status Info -->
        <div class="space-y-6">
            <div class="bg-white rounded-[3rem] p-10 border border-slate-100 shadow-xl shadow-slate-200/50">
                @if(!$user->has_membership_card)
                    <div class="space-y-6">
                        <div class="flex items-center gap-4">
                            <div class="w-12 h-12 rounded-2xl bg-sky-50 flex items-center justify-center text-xl shadow-sm">🚀</div>
                            <h3 class="text-xl font-black text-slate-800 tracking-tight">Activate Full Card</h3>
                        </div>
                        
                        <p class="text-sm font-bold text-slate-500 leading-relaxed">
                            Upgrade to a premium account today. Your card includes a globally unique Member ID used for offline identification and physical benefits.
                        </p>

                        <div class="space-y-3">
                            <div class="flex justify-between items-center p-5 rounded-2xl bg-slate-50 border border-slate-100 transition-all hover:border-sky-200 group">
                                <span class="text-xs font-black uppercase tracking-wider text-slate-400 group-hover:text-slate-600 transition">Price</span>
                                <span class="text-xl font-black text-slate-900 group-hover:text-sky-600 transition">৳{{ number_format($cardPrice, 2) }}</span>
                            </div>
                            <div class="flex justify-between items-center px-5 py-3">
                                <span class="text-[10px] font-black uppercase tracking-widest text-slate-400 italic">Charge Mode</span>
                                <span class="text-[10px] font-black uppercase tracking-widest text-sky-500">Instant Wallet Debit</span>
                            </div>
                        </div>

                        <form action="{{ route('customer.membership.purchase') }}" method="POST" id="purchaseForm">
                            @csrf
                            <button type="button" onclick="confirmPurchase()" class="w-full py-6 rounded-2xl bg-slate-900 text-white font-black text-xs uppercase tracking-[0.2em] hover:bg-sky-600 transition-all shadow-2xl shadow-slate-900/20 active:scale-95 flex items-center justify-center gap-3 group">
                                <span>Get My Digital Card</span>
                                <span class="group-hover:translate-x-1 transition-transform">→</span>
                            </button>
                        </form>
                    </div>
                @else
                    <div class="text-center space-y-6">
                        <div class="w-20 h-20 rounded-full bg-emerald-50 flex items-center justify-center mx-auto ring-8 ring-emerald-50/50 animate-pulse">
                            <span class="text-3xl">🛡️</span>
                        </div>
                        <div>
                            <h3 class="text-2xl font-black text-slate-800 tracking-tight">Verified Member</h3>
                            <p class="text-xs font-bold text-slate-400 mt-2">Active since {{ $user->membership_purchased_at ? $user->membership_purchased_at->format('M d, Y') : 'N/A' }}</p>
                        </div>

                        <div class="grid grid-cols-2 gap-4">
                            <div class="p-4 rounded-2xl bg-slate-50 border border-slate-100 transition-all hover:border-emerald-100">
                                <p class="text-[9px] font-black text-slate-400 uppercase tracking-widest mb-1">ID Number</p>
                                <p class="text-sm font-black text-slate-800">{{ $user->member_id }}</p>
                            </div>
                            <div class="p-4 rounded-2xl bg-slate-50 border border-slate-100 transition-all hover:border-emerald-100">
                                <p class="text-[9px] font-black text-slate-400 uppercase tracking-widest mb-1">Tier</p>
                                <p class="text-sm font-black text-sky-600 uppercase">Premium</p>
                            </div>
                        </div>

                        <div class="pt-6">
                            <button onclick="window.print()" class="w-full py-4 rounded-2xl border-2 border-slate-100 text-[10px] font-black text-slate-600 uppercase tracking-[0.2em] hover:bg-slate-50 transition active:scale-95 flex items-center justify-center gap-2">
                                <span>⎙ Download ID</span>
                            </button>
                        </div>
                    </div>
                @endif
            </div>

            <div x-data="{ showFacilities: false, showPerks: false }">
                <!-- Elite Access Perks (Infrastructure) -->
                <div class="bg-gradient-to-br from-indigo-600 to-indigo-900 rounded-[3rem] p-10 text-white relative overflow-hidden transition-all duration-500 shadow-2xl mb-6">
                    <div class="relative z-10 space-y-6">
                        <div class="flex items-center justify-between">
                            <h4 class="text-xs font-black uppercase tracking-[0.3em] opacity-60 text-sky-300">System Facilities</h4>
                            @if($user->has_membership_card)
                                <button @click="showFacilities = !showFacilities; showPerks = false" 
                                        class="px-4 py-2 rounded-xl bg-sky-400/20 hover:bg-sky-400/40 border border-sky-400/20 text-[9px] font-black uppercase tracking-widest transition-all backdrop-blur-md">
                                    <span x-show="!showFacilities">Explore Facilities ⚡</span>
                                    <span x-show="showFacilities">Hide List ✕</span>
                                </button>
                            @else
                                <div class="px-4 py-2 rounded-xl bg-slate-900/40 border border-white/10 text-[9px] font-black uppercase tracking-widest opacity-50 flex items-center gap-2">
                                    <span>Locked</span>
                                    <span>🔒</span>
                                </div>
                            @endif
                        </div>
                        
                        <!-- Mini List -->
                        <div class="flex gap-6" x-show="!showFacilities" x-collapse>
                             <div class="flex items-center gap-2">
                                <span class="w-2 h-2 rounded-full bg-sky-400"></span>
                                <span class="text-[10px] font-bold opacity-80">Priority Support</span>
                             </div>
                             <div class="flex items-center gap-2">
                                <span class="w-2 h-2 rounded-full bg-sky-400"></span>
                                <span class="text-[10px] font-bold opacity-80">NFC Ready</span>
                             </div>
                        </div>

                        <!-- Expanded Facilities -->
                        <div class="space-y-4 pt-4 border-t border-white/10" x-show="showFacilities" x-collapse>
                            <div class="grid grid-cols-1 gap-3">
                                <div class="flex items-center gap-4 p-4 rounded-2xl bg-white/5 border border-white/5 hover:bg-white/10 transition">
                                    <span class="text-xl">💳</span>
                                    <p class="text-[11px] font-bold">Free Physical Card Delivery anywhere in BD.</p>
                                </div>
                                <div class="flex items-center gap-4 p-4 rounded-2xl bg-white/5 border border-white/5 hover:bg-white/10 transition">
                                    <span class="text-xl">📞</span>
                                    <p class="text-[11px] font-bold">24/7 Dedicated Manager for Business/Wallet help.</p>
                                </div>
                                <div class="flex items-center gap-4 p-4 rounded-2xl bg-white/5 border border-white/5 hover:bg-white/10 transition">
                                    <span class="text-xl">🚀</span>
                                    <p class="text-[11px] font-bold">Instantly processed verified transfers up to 1 Lac.</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Lifestyle & Enjoyment Perks (Merchant Rewards) -->
                <div class="bg-gradient-to-br from-amber-500 to-orange-700 rounded-[3rem] p-10 text-white relative overflow-hidden transition-all duration-500 shadow-2xl">
                    <div class="relative z-10 space-y-6">
                        <div class="flex items-center justify-between">
                            <h4 class="text-xs font-black uppercase tracking-[0.3em] opacity-80 text-amber-100">Enjoyable Benefits</h4>
                            @if($user->has_membership_card)
                                <button @click="showPerks = !showPerks; showFacilities = false" 
                                        class="px-4 py-2 rounded-xl bg-white/20 hover:bg-white/40 border border-white/10 text-[9px] font-black uppercase tracking-widest transition-all backdrop-blur-md text-white">
                                    <span x-show="!showPerks">See What You Enjoy 🎁</span>
                                    <span x-show="showPerks">Hide Rewards ✕</span>
                                </button>
                            @else
                                <div class="px-4 py-2 rounded-xl bg-black/20 border border-white/10 text-[9px] font-black uppercase tracking-widest opacity-50 flex items-center gap-2">
                                    <span>Locked</span>
                                    <span>🔒</span>
                                </div>
                            @endif
                        </div>

                        <p class="text-xs font-bold leading-relaxed opacity-90" x-show="!showPerks">
                            Discover the world of lifestyle rewards, merchant discounts, and exclusive event access designed for our premium tier.
                        </p>

                        <!-- Expanded Perks -->
                        <div class="space-y-4 pt-4 border-t border-white/20" x-show="showPerks" x-collapse>
                            <div class="grid grid-cols-1 gap-3">
                                <div class="flex items-start gap-4 p-4 rounded-2xl bg-black/10 border border-white/10">
                                    <span class="text-xl">🍔</span>
                                    <div>
                                        <p class="text-xs font-black">Food & Dining Rewards</p>
                                        <p class="text-[10px] opacity-70">Up to 25% Cashback at 500+ Partner Restaurants.</p>
                                    </div>
                                </div>
                                <div class="flex items-start gap-4 p-4 rounded-2xl bg-black/10 border border-white/10">
                                    <span class="text-xl">✈️</span>
                                    <div>
                                        <p class="text-xs font-black">Travel & Lounge Access</p>
                                        <p class="text-[10px] opacity-70">Exclusive access to selected airport lounges globally.</p>
                                    </div>
                                </div>
                                <div class="flex items-start gap-4 p-4 rounded-2xl bg-black/10 border border-white/10">
                                    <span class="text-xl">📽️</span>
                                    <div>
                                        <p class="text-xs font-black">Entertainment Pass</p>
                                        <p class="text-[10px] opacity-70">Buy 1 Get 1 Cinema Tickets every weekend.</p>
                                    </div>
                                </div>
                                <div class="flex items-start gap-4 p-4 rounded-2xl bg-black/10 border border-white/10">
                                    <span class="text-xl">🏥</span>
                                    <div>
                                        <p class="text-xs font-black">Health & Wellness</p>
                                        <p class="text-[10px] opacity-70">Special discounts at top hospitals and diagnostic centers.</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="absolute -right-10 -bottom-10 opacity-20 text-[12rem] pointer-events-none transition-transform duration-1000"
                         :class="showPerks ? 'scale-125 rotate-12' : ''">🎁</div>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
    .perspective-1000 { perspective: 1000px; }
    .transform-style-3d { transform-style: preserve-3d; }
    .backface-hidden { backface-visibility: hidden; }
    
    @keyframes float {
        0%, 100% { transform: translateY(0) rotate(-1deg); }
        50% { transform: translateY(-15px) rotate(1deg); }
    }
    .animate-float {
        animation: float 6s ease-in-out infinite;
    }
</style>

<script>
    function confirmPurchase() {
        Swal.fire({
            title: '<h3 class="text-lg font-black uppercase tracking-widest text-slate-800">Confirm Purchase?</h3>',
            html: '<p class="text-xs font-bold text-slate-500">৳{{ number_format($cardPrice, 2) }} will be deducted from your Main Wallet. This action cannot be undone.</p>',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonText: 'ACTIVATE NOW 💳',
            cancelButtonText: 'MAYBE LATER',
            confirmButtonColor: '#0f172a',
            cancelButtonColor: '#94a3b8',
            customClass: {
                popup: 'rounded-[2.5rem] p-10',
                confirmButton: 'px-8 py-4 rounded-xl text-[10px] font-black tracking-widest uppercase shadow-xl shadow-slate-900/20',
                cancelButton: 'px-8 py-4 rounded-xl text-[10px] font-black tracking-widest uppercase'
            }
        }).then((result) => {
            if (result.isConfirmed) {
                document.getElementById('purchaseForm').submit();
            }
        });
    }
</script>
@endsection
