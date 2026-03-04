@extends('layouts.public')

@section('title', 'Join Affiliate Program - CMarket')

@section('content')
<div class="bg-gradient-to-br from-indigo-900 via-indigo-800 to-blue-900 py-24 text-white relative overflow-hidden">
    <div class="max-w-7xl mx-auto px-4 text-center relative z-10">
        <h1 class="text-5xl lg:text-7xl font-black mb-8 tracking-tight">Build Your Empire</h1>
        <p class="text-xl lg:text-2xl text-indigo-100 max-w-3xl mx-auto leading-relaxed mb-12">
            Join the most rewarding multi-layer affiliate network in the region. Earn lifetime commissions and scale your income with CMarket.
        </p>
        <div class="flex flex-col sm:flex-row justify-center gap-6">
            <a href="{{ route('register') }}" class="px-10 py-5 bg-white text-indigo-900 rounded-2xl font-black text-lg hover:bg-indigo-50 transition transform hover:scale-105 shadow-2xl shadow-white/10">
                Get Started Now
            </a>
            <a href="#benefits" class="px-10 py-5 bg-indigo-600/30 backdrop-blur-md border border-indigo-400/30 text-white rounded-2xl font-black text-lg hover:bg-indigo-600/50 transition">
                Learn More
            </a>
        </div>
    </div>
    
    <!-- Decorative Elements -->
    <div class="absolute top-0 left-0 w-96 h-96 bg-indigo-500/20 rounded-full blur-3xl -translate-x-1/2 -translate-y-1/2"></div>
    <div class="absolute bottom-0 right-0 w-96 h-96 bg-blue-500/20 rounded-full blur-3xl translate-x-1/2 translate-y-1/2"></div>
</div>

<div id="benefits" class="max-w-7xl mx-auto px-4 py-32">
    <div class="text-center mb-24">
        <span class="text-indigo-600 font-black tracking-widest uppercase text-sm mb-4 block">Why Join Us?</span>
        <h2 class="text-4xl lg:text-5xl font-extrabold text-gray-900">Affiliate Benefits</h2>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-3 gap-16">
        <div class="text-center group">
            <div class="w-24 h-24 bg-indigo-50 text-indigo-600 rounded-[2rem] flex items-center justify-center mx-auto mb-8 text-4xl group-hover:scale-110 group-hover:bg-indigo-600 group-hover:text-white transition duration-500">📈</div>
            <h3 class="text-2xl font-bold mb-4 text-gray-900">Multi-Layer Commissions</h3>
            <p class="text-gray-500 text-lg leading-relaxed">Earn not just from your direct referrals, but from their network too. Up to 5 layers of deep commission structure.</p>
        </div>
        <div class="text-center group">
            <div class="w-24 h-24 bg-green-50 text-green-600 rounded-[2rem] flex items-center justify-center mx-auto mb-8 text-4xl group-hover:scale-110 group-hover:bg-green-600 group-hover:text-white transition duration-500">🕒</div>
            <h3 class="text-2xl font-bold mb-4 text-gray-900">Passive Income</h3>
            <p class="text-gray-500 text-lg leading-relaxed">Once you build your team, you earn while you sleep. Every purchase in your network translates to automated payout.</p>
        </div>
        <div class="text-center group">
            <div class="w-24 h-24 bg-blue-50 text-blue-600 rounded-[2rem] flex items-center justify-center mx-auto mb-8 text-4xl group-hover:scale-110 group-hover:bg-blue-600 group-hover:text-white transition duration-500">🛠️</div>
            <h3 class="text-2xl font-bold mb-4 text-gray-900">Advanced Tools</h3>
            <p class="text-gray-500 text-lg leading-relaxed">Get a dedicated affiliate dashboard with real-time tracking, marketing materials, and deep-link generation.</p>
        </div>
    </div>
</div>

<div class="bg-gray-900 py-32 text-white">
    <div class="max-w-5xl mx-auto px-4 text-center">
        <h2 class="text-4xl font-bold mb-12">Ready to become a partner?</h2>
        <p class="text-xl text-gray-400 mb-16">Creating an account is free and takes less than 2 minutes. Start building your digital business today with CMarket.</p>
        
        <form action="{{ route('register') }}" method="GET">
            <button type="submit" class="bg-indigo-600 hover:bg-indigo-700 text-white font-black px-16 py-6 rounded-3xl text-xl transition transform hover:scale-105 shadow-2xl shadow-indigo-600/30">
                Create Free Account
            </button>
        </form>
        
        <p class="mt-12 text-gray-500 text-sm">Already have an account? <a href="{{ route('login') }}" class="text-indigo-400 font-bold hover:underline">Login here</a></p>
    </div>
</div>
@endsection
