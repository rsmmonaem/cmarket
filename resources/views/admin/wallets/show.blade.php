@extends('layouts.admin')

@section('content')
<div class="p-6">
    <div class="max-w-5xl mx-auto">
        <!-- Header -->
        <div class="mb-6">
            <h1 class="text-2xl font-bold text-gray-800">Wallet Details</h1>
            <p class="text-gray-600 mt-1">{{ $wallet->user->name }} - {{ ucfirst($wallet->wallet_type) }} Wallet</p>
        </div>

        <!-- Wallet Info Card -->
        <div class="bg-gradient-to-r from-indigo-500 to-purple-600 rounded-lg shadow-lg p-8 text-white mb-6">
            <div class="flex justify-between items-center">
                <div>
                    <p class="text-indigo-100 text-sm mb-2">{{ ucfirst($wallet->wallet_type) }} Wallet Balance</p>
                    <p class="text-4xl font-bold">৳{{ number_format($wallet->balance, 2) }}</p>
                    <p class="text-indigo-100 text-sm mt-2">
                        {{ $wallet->is_locked ? '🔒 Locked' : '🔓 Active' }}
                    </p>
                </div>
                <div class="text-right">
                    <p class="text-indigo-100 text-sm">User</p>
                    <p class="text-xl font-semibold">{{ $wallet->user->name }}</p>
                    <p class="text-indigo-100 text-sm">{{ $wallet->user->phone }}</p>
                </div>
            </div>
        </div>

        <!-- Actions -->
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
            <!-- Credit Wallet -->
            <div class="bg-white rounded-lg shadow p-6">
                <h2 class="text-lg font-semibold text-gray-800 mb-4">Credit Wallet</h2>
                <form action="{{ route('admin.wallets.credit', $wallet) }}" method="POST">
                    @csrf
                    <x-input 
                        label="Amount" 
                        name="amount" 
                        type="number" 
                        step="0.01"
                        :required="true"
                        placeholder="0.00"
                    />
                    <x-input 
                        label="Description" 
                        name="description" 
                        type="text" 
                        :required="true"
                        placeholder="Reason for credit"
                    />
                    <x-button variant="success" type="submit" class="w-full">Credit Amount</x-button>
                </form>
            </div>

            <!-- Debit Wallet -->
            <div class="bg-white rounded-lg shadow p-6">
                <h2 class="text-lg font-semibold text-gray-800 mb-4">Debit Wallet</h2>
                <form action="{{ route('admin.wallets.debit', $wallet) }}" method="POST">
                    @csrf
                    <x-input 
                        label="Amount" 
                        name="amount" 
                        type="number" 
                        step="0.01"
                        :required="true"
                        placeholder="0.00"
                    />
                    <x-input 
                        label="Description" 
                        name="description" 
                        type="text" 
                        :required="true"
                        placeholder="Reason for debit"
                    />
                    <x-button variant="danger" type="submit" class="w-full">Debit Amount</x-button>
                </form>
            </div>
        </div>

        <!-- Lock/Unlock -->
        <div class="bg-white rounded-lg shadow p-6 mb-6">
            <h2 class="text-lg font-semibold text-gray-800 mb-4">Wallet Control</h2>
            <div class="flex gap-3">
                @if($wallet->is_locked)
                    <form action="{{ route('admin.wallets.unlock', $wallet) }}" method="POST">
                        @csrf
                        <x-button variant="success" type="submit">🔓 Unlock Wallet</x-button>
                    </form>
                @else
                    <form action="{{ route('admin.wallets.lock', $wallet) }}" method="POST">
                        @csrf
                        <x-button variant="danger" type="submit">🔒 Lock Wallet</x-button>
                    </form>
                @endif
            </div>
        </div>

        <!-- Transaction History -->
        <div class="bg-white rounded-lg shadow p-6">
            <h2 class="text-lg font-semibold text-gray-800 mb-4">Transaction History</h2>
            <x-table :headers="['Date', 'Type', 'Amount', 'Balance', 'Description']" :actions="false">
                @forelse($wallet->ledgers as $ledger)
                    <tr>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                            {{ $ledger->created_at->format('M d, Y H:i') }}
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <x-badge :variant="$ledger->type == 'credit' ? 'success' : 'danger'">
                                {{ ucfirst($ledger->type) }}
                            </x-badge>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <span class="{{ $ledger->type == 'credit' ? 'text-green-600' : 'text-red-600' }} font-semibold">
                                {{ $ledger->type == 'credit' ? '+' : '-' }}৳{{ number_format($ledger->amount, 2) }}
                            </span>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">
                            ৳{{ number_format($ledger->balance_after, 2) }}
                        </td>
                        <td class="px-6 py-4 text-sm text-gray-600">
                            {{ $ledger->description }}
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="5" class="px-6 py-4 text-center text-gray-500">No transactions yet</td>
                    </tr>
                @endforelse
            </x-table>
        </div>
    </div>
</div>
@endsection
