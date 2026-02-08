@extends('layouts.admin')

@section('content')
<div class="p-6">
    <!-- Header -->
    <div class="mb-6">
        <h1 class="text-2xl font-bold text-gray-800">Wallet Management</h1>
        <p class="text-gray-600 mt-1">Manage user wallets and transactions</p>
    </div>

    <!-- Filters -->
    <div class="bg-white p-4 rounded-lg shadow mb-6">
        <form method="GET" class="grid grid-cols-1 md:grid-cols-4 gap-4">
            <input type="text" name="search" placeholder="Search by user name or phone..." 
                   value="{{ request('search') }}"
                   class="px-3 py-2 border border-gray-300 rounded-lg">
            
            <select name="wallet_type" class="px-3 py-2 border border-gray-300 rounded-lg">
                <option value="">All Wallet Types</option>
                <option value="main">Main</option>
                <option value="cashback">Cashback</option>
                <option value="commission">Commission</option>
                <option value="shop">Shop</option>
                <option value="share">Share</option>
                <option value="rider">Rider</option>
            </select>
            
            <select name="status" class="px-3 py-2 border border-gray-300 rounded-lg">
                <option value="">All Status</option>
                <option value="active">Active</option>
                <option value="locked">Locked</option>
            </select>
            
            <x-button type="submit" variant="primary">Filter</x-button>
        </form>
    </div>

    <!-- Wallets Table -->
    <x-table :headers="['User', 'Wallet Type', 'Balance', 'Status', 'Last Transaction']">
        @forelse($wallets as $wallet)
            <tr class="hover:bg-gray-50">
                <td class="px-6 py-4 whitespace-nowrap">
                    <div class="text-sm font-medium text-gray-900">{{ $wallet->user->name }}</div>
                    <div class="text-sm text-gray-500">{{ $wallet->user->phone }}</div>
                </td>
                <td class="px-6 py-4 whitespace-nowrap">
                    <x-badge variant="primary">
                        {{ ucfirst($wallet->wallet_type) }}
                    </x-badge>
                </td>
                <td class="px-6 py-4 whitespace-nowrap">
                    <div class="text-lg font-semibold text-gray-900">৳{{ number_format($wallet->balance, 2) }}</div>
                </td>
                <td class="px-6 py-4 whitespace-nowrap">
                    <x-badge :variant="$wallet->is_locked ? 'danger' : 'success'">
                        {{ $wallet->is_locked ? 'Locked' : 'Active' }}
                    </x-badge>
                </td>
                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                    {{ $wallet->updated_at->format('M d, Y H:i') }}
                </td>
                <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                    <a href="{{ route('admin.wallets.show', $wallet) }}" class="text-indigo-600 hover:text-indigo-900">
                        View Details
                    </a>
                </td>
            </tr>
        @empty
            <tr>
                <td colspan="6" class="px-6 py-4 text-center text-gray-500">No wallets found</td>
            </tr>
        @endforelse
    </x-table>

    <!-- Pagination -->
    <div class="mt-6">
        {{ $wallets->links() }}
    </div>
</div>
@endsection
