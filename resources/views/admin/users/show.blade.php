@extends('layouts.admin')

@section('content')
<div class="p-6">
    <div class="max-w-4xl mx-auto">
        <!-- Header -->
        <div class="flex justify-between items-center mb-6">
            <div>
                <h1 class="text-2xl font-bold text-gray-800">User Details</h1>
                <p class="text-gray-600 mt-1">{{ $user->name }}</p>
            </div>
            <a href="{{ route('admin.users.edit', $user) }}">
                <x-button variant="primary">Edit User</x-button>
            </a>
        </div>

        <!-- User Info Card -->
        <div class="bg-white rounded-lg shadow p-6 mb-6">
            <h2 class="text-lg font-semibold text-gray-800 mb-4">Basic Information</h2>
            <div class="grid grid-cols-2 gap-4">
                <div>
                    <p class="text-sm text-gray-500">Name</p>
                    <p class="text-gray-900 font-medium">{{ $user->name }}</p>
                </div>
                <div>
                    <p class="text-sm text-gray-500">Phone</p>
                    <p class="text-gray-900 font-medium">{{ $user->phone }}</p>
                </div>
                <div>
                    <p class="text-sm text-gray-500">Email</p>
                    <p class="text-gray-900 font-medium">{{ $user->email ?? 'N/A' }}</p>
                </div>
                <div>
                    <p class="text-sm text-gray-500">Status</p>
                    <x-badge :variant="$user->status == 'wallet_verified' ? 'success' : 'default'">
                        {{ ucfirst(str_replace('_', ' ', $user->status)) }}
                    </x-badge>
                </div>
                <div>
                    <p class="text-sm text-gray-500">Role</p>
                    <p class="text-gray-900 font-medium">{{ $user->roles->pluck('name')->join(', ') }}</p>
                </div>
                <div>
                    <p class="text-sm text-gray-500">Joined</p>
                    <p class="text-gray-900 font-medium">{{ $user->created_at->format('M d, Y') }}</p>
                </div>
            </div>
        </div>

        <!-- Wallets -->
        <div class="bg-white rounded-lg shadow p-6 mb-6">
            <h2 class="text-lg font-semibold text-gray-800 mb-4">Wallets</h2>
            <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                @foreach($user->wallets as $wallet)
                    <div class="border border-gray-200 rounded-lg p-4">
                        <p class="text-sm text-gray-500">{{ ucfirst($wallet->wallet_type) }} Wallet</p>
                        <p class="text-2xl font-bold text-gray-900">৳{{ number_format($wallet->balance, 2) }}</p>
                        <p class="text-xs text-gray-500 mt-1">
                            {{ $wallet->is_locked ? '🔒 Locked' : '🔓 Active' }}
                        </p>
                    </div>
                @endforeach
            </div>
        </div>

        <!-- Recent Orders -->
        <div class="bg-white rounded-lg shadow p-6">
            <h2 class="text-lg font-semibold text-gray-800 mb-4">Recent Orders</h2>
            @if($user->orders->count() > 0)
                <x-table :headers="['Order #', 'Date', 'Amount', 'Status']" :actions="false">
                    @foreach($user->orders->take(5) as $order)
                        <tr>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">#{{ $order->order_number }}</td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ $order->created_at->format('M d, Y') }}</td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">৳{{ number_format($order->total_amount, 2) }}</td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <x-badge :variant="$order->status == 'delivered' ? 'success' : 'warning'">
                                    {{ ucfirst($order->status) }}
                                </x-badge>
                            </td>
                        </tr>
                    @endforeach
                </x-table>
            @else
                <p class="text-gray-500 text-center py-4">No orders yet</p>
            @endif
        </div>
    </div>
</div>
@endsection
