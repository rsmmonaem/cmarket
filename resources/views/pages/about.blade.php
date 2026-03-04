@extends('layouts.public')

@section('title', 'About Us - CMarket')

@section('content')
<div class="bg-indigo-900 py-24 text-white">
    <div class="max-w-7xl mx-auto px-4 text-center">
        <h1 class="text-5xl font-extrabold mb-6">Empowering Digital Commerce</h1>
        <p class="text-xl text-indigo-100 max-w-2xl mx-auto">CMarket is a next-generation ecosystem connecting quality merchants with valued customers through transparency and shared rewards.</p>
    </div>
</div>

<div class="max-w-7xl mx-auto px-4 py-24">
    <div class="grid grid-cols-1 md:grid-cols-2 gap-16 items-center">
        <div>
            <h2 class="text-3xl font-bold text-gray-900 mb-6">Our Mission</h2>
            <p class="text-gray-600 text-lg leading-relaxed mb-6">
                Founded in 2024, CMarket was built on the principle that e-commerce should benefit everyone. We've created a unique multi-layer ecosystem that rewards loyalty, encourages entrepreneurship, and ensures security at every step.
            </p>
            <p class="text-gray-600 text-lg leading-relaxed">
                Whether you're a customer looking for the best deals, a merchant aiming to scale your business, or a partner building an affiliate network, CMarket provides the tools and infrastructure you need to succeed.
            </p>
        </div>
        <div class="bg-white rounded-[3rem] p-12 shadow-2xl shadow-indigo-900/5 border border-indigo-50">
            <div class="grid grid-cols-2 gap-8">
                <div class="text-center">
                    <span class="block text-4xl font-black text-indigo-600 mb-2">100%</span>
                    <span class="text-gray-500 font-medium">Secure Payments</span>
                </div>
                <div class="text-center">
                    <span class="block text-4xl font-black text-indigo-600 mb-2">24/7</span>
                    <span class="text-gray-500 font-medium">Customer Support</span>
                </div>
                <div class="text-center">
                    <span class="block text-4xl font-black text-indigo-600 mb-2">5+</span>
                    <span class="text-gray-500 font-medium">Core Modules</span>
                </div>
                <div class="text-center">
                    <span class="block text-4xl font-black text-indigo-600 mb-2">৳1M+</span>
                    <span class="text-gray-500 font-medium">Monthly Payouts</span>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="bg-gray-50 py-24">
    <div class="max-w-7xl mx-auto px-4 text-center">
        <h2 class="text-3xl font-bold text-gray-900 mb-16">The CMarket Advantage</h2>
        <div class="grid grid-cols-1 md:grid-cols-3 gap-12">
            <div class="bg-white p-10 rounded-3xl shadow-sm border border-gray-100">
                <div class="w-16 h-16 bg-indigo-100 text-indigo-600 rounded-2xl flex items-center justify-center mx-auto mb-6 text-2xl">💰</div>
                <h3 class="text-xl font-bold mb-4">Cashback System</h3>
                <p class="text-gray-500">Earn automated cashback on every purchase, credited directly to your digital wallet.</p>
            </div>
            <div class="bg-white p-10 rounded-3xl shadow-sm border border-gray-100">
                <div class="w-16 h-16 bg-green-100 text-green-600 rounded-2xl flex items-center justify-center mx-auto mb-6 text-2xl">🤝</div>
                <h3 class="text-xl font-bold mb-4">Affiliate Rewards</h3>
                <p class="text-gray-500">Build your network and earn commissions across multiple layers of referrals.</p>
            </div>
            <div class="bg-white p-10 rounded-3xl shadow-sm border border-gray-100">
                <div class="w-16 h-16 bg-blue-100 text-blue-600 rounded-2xl flex items-center justify-center mx-auto mb-6 text-2xl">🔒</div>
                <h3 class="text-xl font-bold mb-4">Bank-Grade Security</h3>
                <p class="text-gray-500">Multi-layer authentication and OTP verification keep your funds and data safe.</p>
            </div>
        </div>
    </div>
</div>
@endsection
