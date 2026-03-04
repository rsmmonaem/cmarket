@extends('layouts.public')

@section('title', 'Contact Us - CMarket')

@section('content')
<div class="bg-indigo-900 py-16 text-white text-center">
    <div class="max-w-7xl mx-auto px-4">
        <h1 class="text-4xl lg:text-5xl font-extrabold mb-4">Contact Our Team</h1>
        <p class="text-indigo-200 text-lg">We're here to help you scaling your business or resolve any issues.</p>
    </div>
</div>

<div class="max-w-7xl mx-auto px-4 py-24">
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-16">
        <div class="lg:col-span-2">
            <div class="bg-white rounded-[2.5rem] p-12 shadow-xl shadow-indigo-900/5 border border-indigo-50">
                <h2 class="text-2xl font-bold text-gray-900 mb-8">Send Us a Message</h2>
                <form action="#" method="POST" class="space-y-6">
                    @csrf
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <label class="block text-sm font-bold text-gray-700 mb-2">Full Name</label>
                            <input type="text" name="name" class="w-full px-5 py-4 bg-gray-50 border border-gray-200 rounded-2xl focus:outline-none focus:ring-2 focus:ring-indigo-500" placeholder="John Doe">
                        </div>
                        <div>
                            <label class="block text-sm font-bold text-gray-700 mb-2">Email Address</label>
                            <input type="email" name="email" class="w-full px-5 py-4 bg-gray-50 border border-gray-200 rounded-2xl focus:outline-none focus:ring-2 focus:ring-indigo-500" placeholder="john@example.com">
                        </div>
                    </div>
                    <div>
                        <label class="block text-sm font-bold text-gray-700 mb-2">Subject</label>
                        <select name="subject" class="w-full px-5 py-4 bg-gray-50 border border-gray-200 rounded-2xl focus:outline-none focus:ring-2 focus:ring-indigo-500">
                            <option value="general">General Inquiry</option>
                            <option value="merchant">Merchant Support</option>
                            <option value="rider">Rider Support</option>
                            <option value="payment">Payment & Wallet Issues</option>
                            <option value="abuse">Report Abuse</option>
                        </select>
                    </div>
                    <div>
                        <label class="block text-sm font-bold text-gray-700 mb-2">Message</label>
                        <textarea name="message" rows="6" class="w-full px-5 py-4 bg-gray-50 border border-gray-200 rounded-2xl focus:outline-none focus:ring-2 focus:ring-indigo-500" placeholder="How can we help?"></textarea>
                    </div>
                    <button type="submit" class="w-full bg-indigo-600 text-white font-bold py-5 rounded-2xl hover:bg-indigo-700 transition transform hover:scale-[1.02] shadow-xl shadow-indigo-600/20">
                        Send Message
                    </button>
                </form>
            </div>
        </div>
        
        <div class="space-y-8">
            <div class="bg-indigo-50 p-10 rounded-[2.5rem] border border-indigo-100">
                <h3 class="text-xl font-bold text-indigo-900 mb-6">Corporate Office</h3>
                <div class="space-y-6">
                    <div class="flex items-start gap-4">
                        <div class="w-10 h-10 bg-white rounded-xl flex items-center justify-center text-xl shrink-0">📍</div>
                        <div>
                            <p class="font-bold text-gray-900">Address</p>
                            <p class="text-gray-600">Level 4, Nibiz Tower, Motijheel, Dhaka-1000, Bangladesh</p>
                        </div>
                    </div>
                    <div class="flex items-start gap-4">
                        <div class="w-10 h-10 bg-white rounded-xl flex items-center justify-center text-xl shrink-0">📧</div>
                        <div>
                            <p class="font-bold text-gray-900">Email</p>
                            <p class="text-gray-600">support@cmarket.com</p>
                            <p class="text-gray-600">admin@cmarket.com</p>
                        </div>
                    </div>
                    <div class="flex items-start gap-4">
                        <div class="w-10 h-10 bg-white rounded-xl flex items-center justify-center text-xl shrink-0">📞</div>
                        <div>
                            <p class="font-bold text-gray-900">Phone</p>
                            <p class="text-gray-600">+880 1700-000000</p>
                            <p class="text-gray-600">+880 1800-000000</p>
                        </div>
                    </div>
                </div>
            </div>
            
            <div class="bg-gray-900 p-10 rounded-[2.5rem] text-white">
                <h3 class="text-xl font-bold mb-6">Support Hours</h3>
                <ul class="space-y-4 text-gray-400">
                    <li class="flex justify-between"><span>Mon - Thu:</span> <span class="text-white">9AM - 8PM</span></li>
                    <li class="flex justify-between"><span>Friday:</span> <span class="text-white">OFFLINE</span></li>
                    <li class="flex justify-between"><span>Sat - Sun:</span> <span class="text-white">10AM - 6PM</span></li>
                </ul>
            </div>
        </div>
    </div>
</div>
@endsection
