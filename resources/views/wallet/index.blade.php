@extends('layouts.public')

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
    <h1 class="text-3xl font-bold mb-8">My Wallets</h1>

    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6 mb-8">
        @foreach($wallets as $wallet)
            <div class="bg-gradient-to-br from-indigo-500 to-purple-600 rounded-lg shadow-lg p-6 text-white">
                <div class="flex justify-between items-start mb-4">
                    <div>
                        <p class="text-sm opacity-90">{{ ucfirst($wallet->wallet_type) }} Wallet</p>
                        <h2 class="text-3xl font-bold mt-1">৳{{ number_format($wallet->balance, 2) }}</h2>
                    </div>
                    <div class="text-2xl">
                        @if($wallet->wallet_type === 'main') 💰
                        @elseif($wallet->wallet_type === 'cashback') 🎁
                        @elseif($wallet->wallet_type === 'commission') 💵
                        @elseif($wallet->wallet_type === 'shop') 🏪
                        @elseif($wallet->wallet_type === 'share') 🤝
                        @elseif($wallet->wallet_type === 'rider') 🚴
                        @endif
                    </div>
                </div>
                <div class="flex justify-between items-center text-sm opacity-90">
                    <span>Status: {{ ucfirst($wallet->status) }}</span>
                    <span>{{ $wallet->ledgers->count() }} transactions</span>
                </div>
            </div>
        @endforeach
    </div>

    <!-- Recent Transactions -->
    <div class="bg-white rounded-lg shadow">
        <div class="p-6 border-b">
            <h2 class="text-xl font-semibold">Recent Transactions</h2>
        </div>
        
        <div class="divide-y">
            @php
                $allTransactions = collect();
                foreach($wallets as $wallet) {
                    $allTransactions = $allTransactions->merge($wallet->ledgers);
                }
                $allTransactions = $allTransactions->sortByDesc('created_at')->take(20);
            @endphp

            @forelse($allTransactions as $transaction)
                <div class="p-6 hover:bg-gray-50">
                    <div class="flex justify-between items-start">
                        <div class="flex-1">
                            <div class="flex items-center gap-2 mb-1">
                                <span class="text-2xl">
                                    {{ $transaction->type === 'credit' ? '📥' : '📤' }}
                                </span>
                                <h3 class="font-semibold">{{ $transaction->description }}</h3>
                            </div>
                            <p class="text-sm text-gray-600">
                                {{ ucfirst($transaction->wallet->wallet_type) }} Wallet
                            </p>
                            <p class="text-xs text-gray-500 mt-1">
                                {{ $transaction->created_at->format('M d, Y h:i A') }}
                            </p>
                        </div>
                        <div class="text-right">
                            <p class="text-lg font-bold {{ $transaction->type === 'credit' ? 'text-green-600' : 'text-red-600' }}">
                                {{ $transaction->type === 'credit' ? '+' : '-' }}৳{{ number_format($transaction->amount, 2) }}
                            </p>
                            <p class="text-sm text-gray-600">
                                Balance: ৳{{ number_format($transaction->running_balance, 2) }}
                            </p>
                        </div>
                    </div>
                </div>
            @empty
                <div class="p-12 text-center text-gray-500">
                    <div class="text-6xl mb-4">💳</div>
                    <p>No transactions yet</p>
                </div>
            @endforelse
        </div>
    </div>

    <!-- Referral Section -->
    <div class="mt-8 bg-gradient-to-r from-indigo-500 to-purple-600 rounded-lg shadow-lg p-8 text-white">
        <h2 class="text-2xl font-bold mb-4">Invite Friends & Earn Rewards</h2>
        <p class="mb-6 opacity-90">Share your referral code and earn commissions on their purchases!</p>
        
        <div class="bg-white bg-opacity-20 rounded-lg p-4 mb-4">
            <p class="text-sm opacity-90 mb-1">Your Referral Code</p>
            <div class="flex items-center gap-2">
                <code class="text-2xl font-bold">{{ auth()->user()->referral_code ?? 'Not Generated' }}</code>
                @if(auth()->user()->referral_code)
                    <button onclick="copyReferralCode()" class="bg-white text-indigo-600 px-4 py-2 rounded-lg font-semibold hover:bg-gray-100">
                        Copy
                    </button>
                @endif
            </div>
        </div>

        @if(!auth()->user()->referral_code)
            <form action="{{ route('referral.generate') }}" method="POST">
                @csrf
                <button type="submit" class="bg-white text-indigo-600 px-6 py-3 rounded-lg font-semibold hover:bg-gray-100">
                    Generate Referral Code
                </button>
            </form>
        @endif
    </div>
</div>

<script>
function copyReferralCode() {
    const code = '{{ auth()->user()->referral_code }}';
    navigator.clipboard.writeText(code).then(() => {
        alert('Referral code copied to clipboard!');
    });
}
</script>
@endsection
