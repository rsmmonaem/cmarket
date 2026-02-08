@extends('layouts.admin')

@section('content')
<div class="p-6">
    <!-- Header -->
    <div class="mb-6">
        <h1 class="text-2xl font-bold text-gray-800">Withdrawal Requests</h1>
        <p class="text-gray-600 mt-1">Review and process withdrawal requests</p>
    </div>

    <!-- Stats -->
    <div class="grid grid-cols-1 md:grid-cols-4 gap-4 mb-6">
        <div class="bg-white p-4 rounded-lg shadow">
            <p class="text-sm text-gray-500">Pending</p>
            <p class="text-2xl font-bold text-yellow-600">{{ $withdrawals->where('status', 'pending')->count() }}</p>
        </div>
        <div class="bg-white p-4 rounded-lg shadow">
            <p class="text-sm text-gray-500">Approved</p>
            <p class="text-2xl font-bold text-green-600">{{ $withdrawals->where('status', 'approved')->count() }}</p>
        </div>
        <div class="bg-white p-4 rounded-lg shadow">
            <p class="text-sm text-gray-500">Rejected</p>
            <p class="text-2xl font-bold text-red-600">{{ $withdrawals->where('status', 'rejected')->count() }}</p>
        </div>
        <div class="bg-white p-4 rounded-lg shadow">
            <p class="text-sm text-gray-500">Total Amount</p>
            <p class="text-2xl font-bold text-gray-900">৳{{ number_format($withdrawals->where('status', 'approved')->sum('amount'), 2) }}</p>
        </div>
    </div>

    <!-- Withdrawals Table -->
    <x-table :headers="['User', 'Wallet', 'Amount', 'Method', 'Status', 'Requested']">
        @forelse($withdrawals as $withdrawal)
            <tr class="hover:bg-gray-50">
                <td class="px-6 py-4 whitespace-nowrap">
                    <div class="text-sm font-medium text-gray-900">{{ $withdrawal->wallet->user->name }}</div>
                    <div class="text-sm text-gray-500">{{ $withdrawal->wallet->user->phone }}</div>
                </td>
                <td class="px-6 py-4 whitespace-nowrap">
                    <x-badge variant="primary">
                        {{ ucfirst($withdrawal->wallet->wallet_type) }}
                    </x-badge>
                </td>
                <td class="px-6 py-4 whitespace-nowrap">
                    <div class="text-lg font-semibold text-gray-900">৳{{ number_format($withdrawal->amount, 2) }}</div>
                </td>
                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                    {{ ucfirst($withdrawal->payment_method) }}
                </td>
                <td class="px-6 py-4 whitespace-nowrap">
                    @php
                        $statusVariants = [
                            'pending' => 'warning',
                            'approved' => 'success',
                            'rejected' => 'danger',
                        ];
                    @endphp
                    <x-badge :variant="$statusVariants[$withdrawal->status] ?? 'default'">
                        {{ ucfirst($withdrawal->status) }}
                    </x-badge>
                </td>
                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                    {{ $withdrawal->created_at->format('M d, Y H:i') }}
                </td>
                <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                    <a href="{{ route('admin.withdrawals.show', $withdrawal) }}" class="text-indigo-600 hover:text-indigo-900">
                        Review
                    </a>
                </td>
            </tr>
        @empty
            <tr>
                <td colspan="7" class="px-6 py-4 text-center text-gray-500">No withdrawal requests found</td>
            </tr>
        @endforelse
    </x-table>

    <!-- Pagination -->
    <div class="mt-6">
        {{ $withdrawals->links() }}
    </div>
</div>
@endsection
