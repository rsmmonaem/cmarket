@extends('layouts.public')

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
    <h1 class="text-3xl font-bold mb-8">My Referrals</h1>

    <!-- Stats -->
    <div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-8">
        <div class="bg-white rounded-lg shadow p-6">
            <p class="text-gray-600 text-sm">Direct Referrals</p>
            <p class="text-3xl font-bold text-indigo-600">{{ $directReferrals->count() }}</p>
        </div>
        <div class="bg-white rounded-lg shadow p-6">
            <p class="text-gray-600 text-sm">Total Network</p>
            <p class="text-3xl font-bold text-purple-600">{{ $allReferrals->count() }}</p>
        </div>
        <div class="bg-white rounded-lg shadow p-6">
            <p class="text-gray-600 text-sm">Total Earnings</p>
            <p class="text-3xl font-bold text-green-600">৳{{ number_format($totalCommissions, 2) }}</p>
        </div>
        <div class="bg-white rounded-lg shadow p-6">
            <p class="text-gray-600 text-sm">Pending</p>
            <p class="text-3xl font-bold text-yellow-600">৳{{ number_format($pendingCommissions, 2) }}</p>
        </div>
    </div>

    <!-- Referral Code -->
    <div class="bg-gradient-to-r from-indigo-500 to-purple-600 rounded-lg shadow-lg p-8 text-white mb-8">
        <h2 class="text-2xl font-bold mb-4">Your Referral Code</h2>
        <div class="bg-white bg-opacity-20 rounded-lg p-4 mb-4">
            <div class="flex items-center justify-between">
                <code class="text-3xl font-bold">{{ auth()->user()->referral_code ?? 'Not Generated' }}</code>
                @if(auth()->user()->referral_code)
                    <button onclick="copyReferralCode()" class="bg-white text-indigo-600 px-6 py-3 rounded-lg font-semibold hover:bg-gray-100">
                        Copy Code
                    </button>
                @endif
            </div>
        </div>
        
        @if(auth()->user()->referral_code)
            <div class="bg-white bg-opacity-20 rounded-lg p-4">
                <p class="text-sm opacity-90 mb-2">Share this link:</p>
                <div class="flex items-center gap-2">
                    <input type="text" readonly value="{{ url('/register?ref=' . auth()->user()->referral_code) }}"
                           class="flex-1 px-4 py-2 rounded-lg bg-white bg-opacity-30 text-white">
                    <button onclick="copyReferralLink()" class="bg-white text-indigo-600 px-6 py-2 rounded-lg font-semibold hover:bg-gray-100">
                        Copy Link
                    </button>
                </div>
            </div>
        @else
            <form action="{{ route('referral.generate') }}" method="POST">
                @csrf
                <button type="submit" class="bg-white text-indigo-600 px-6 py-3 rounded-lg font-semibold hover:bg-gray-100">
                    Generate Referral Code
                </button>
            </form>
        @endif
    </div>

    <!-- Direct Referrals -->
    <div class="bg-white rounded-lg shadow mb-8">
        <div class="p-6 border-b">
            <h2 class="text-xl font-semibold">Direct Referrals (Level 1)</h2>
        </div>
        <div class="overflow-x-auto">
            <table class="w-full">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Name</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Phone</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Designation</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Joined</th>
                    </tr>
                </thead>
                <tbody class="divide-y">
                    @forelse($directReferrals as $referral)
                        <tr>
                            <td class="px-6 py-4">{{ $referral->name }}</td>
                            <td class="px-6 py-4">{{ $referral->phone }}</td>
                            <td class="px-6 py-4">
                                <span class="px-2 py-1 bg-indigo-100 text-indigo-800 rounded text-sm">
                                    {{ $referral->designation->name ?? 'None' }}
                                </span>
                            </td>
                            <td class="px-6 py-4 text-sm text-gray-600">{{ $referral->created_at->format('M d, Y') }}</td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="4" class="px-6 py-12 text-center text-gray-500">
                                No direct referrals yet. Start sharing your code!
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <!-- Referral Tree -->
    @if($allReferrals->count() > 0)
        <div class="bg-white rounded-lg shadow">
            <div class="p-6 border-b">
                <h2 class="text-xl font-semibold">Complete Referral Network</h2>
            </div>
            <div class="overflow-x-auto">
                <table class="w-full">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Level</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Name</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Phone</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Designation</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Joined</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y">
                        @foreach($allReferrals as $referral)
                            <tr class="hover:bg-gray-50">
                                <td class="px-6 py-4">
                                    <span class="px-2 py-1 bg-purple-100 text-purple-800 rounded text-sm font-semibold">
                                        Level {{ $referral->level }}
                                    </span>
                                </td>
                                <td class="px-6 py-4">
                                    <span style="margin-left: {{ ($referral->level - 1) * 20 }}px;">
                                        {{ $referral->level > 1 ? '└─ ' : '' }}{{ $referral->name }}
                                    </span>
                                </td>
                                <td class="px-6 py-4">{{ $referral->phone }}</td>
                                <td class="px-6 py-4">
                                    <span class="px-2 py-1 bg-indigo-100 text-indigo-800 rounded text-sm">
                                        {{ $referral->designation->name ?? 'None' }}
                                    </span>
                                </td>
                                <td class="px-6 py-4 text-sm text-gray-600">{{ $referral->created_at->format('M d, Y') }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    @endif
</div>

<script>
function copyReferralCode() {
    const code = '{{ auth()->user()->referral_code }}';
    navigator.clipboard.writeText(code).then(() => {
        alert('Referral code copied to clipboard!');
    });
}

function copyReferralLink() {
    const link = '{{ url("/register?ref=" . auth()->user()->referral_code) }}';
    navigator.clipboard.writeText(link).then(() => {
        alert('Referral link copied to clipboard!');
    });
}
</script>
@endsection
