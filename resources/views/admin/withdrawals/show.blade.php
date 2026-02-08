@extends('layouts.admin')

@section('content')
<div class="p-6">
    <div class="max-w-3xl mx-auto">
        <!-- Header -->
        <div class="mb-6">
            <h1 class="text-2xl font-bold text-gray-800">Withdrawal Request Details</h1>
            <p class="text-gray-600 mt-1">Review and process withdrawal</p>
        </div>

        <!-- Withdrawal Info -->
        <div class="bg-white rounded-lg shadow p-6 mb-6">
            <div class="text-center mb-6">
                <p class="text-sm text-gray-500 mb-2">Withdrawal Amount</p>
                <p class="text-4xl font-bold text-gray-900">৳{{ number_format($withdrawal->amount, 2) }}</p>
                <x-badge :variant="$withdrawal->status == 'approved' ? 'success' : ($withdrawal->status == 'pending' ? 'warning' : 'danger')" class="mt-3">
                    {{ ucfirst($withdrawal->status) }}
                </x-badge>
            </div>

            <div class="grid grid-cols-2 gap-4 pt-6 border-t border-gray-200">
                <div>
                    <p class="text-sm text-gray-500">User</p>
                    <p class="text-gray-900 font-medium">{{ $withdrawal->wallet->user->name }}</p>
                    <p class="text-sm text-gray-500">{{ $withdrawal->wallet->user->phone }}</p>
                </div>
                <div>
                    <p class="text-sm text-gray-500">Wallet</p>
                    <x-badge variant="primary">
                        {{ ucfirst($withdrawal->wallet->wallet_type) }}
                    </x-badge>
                    <p class="text-sm text-gray-500 mt-1">Balance: ৳{{ number_format($withdrawal->wallet->balance, 2) }}</p>
                </div>
                <div>
                    <p class="text-sm text-gray-500">Payment Method</p>
                    <p class="text-gray-900 font-medium">{{ ucfirst($withdrawal->payment_method) }}</p>
                </div>
                <div>
                    <p class="text-sm text-gray-500">Requested</p>
                    <p class="text-gray-900 font-medium">{{ $withdrawal->created_at->format('M d, Y H:i') }}</p>
                </div>
            </div>
        </div>

        <!-- Account Details -->
        <div class="bg-white rounded-lg shadow p-6 mb-6">
            <h2 class="text-lg font-semibold text-gray-800 mb-4">Account Details</h2>
            <div class="bg-gray-50 rounded p-4">
                <pre class="text-sm text-gray-700 whitespace-pre-wrap">{{ $withdrawal->account_details }}</pre>
            </div>
        </div>

        <!-- Actions -->
        @if($withdrawal->status == 'pending')
            <div class="bg-white rounded-lg shadow p-6">
                <h2 class="text-lg font-semibold text-gray-800 mb-4">Actions</h2>
                
                <div class="grid grid-cols-2 gap-4">
                    <!-- Approve -->
                    <form action="{{ route('admin.withdrawals.approve', $withdrawal) }}" method="POST">
                        @csrf
                        <x-button variant="success" type="submit" class="w-full">
                            ✓ Approve & Process
                        </x-button>
                    </form>

                    <!-- Reject -->
                    <form action="{{ route('admin.withdrawals.reject', $withdrawal) }}" method="POST" id="rejectForm">
                        @csrf
                        <x-button variant="danger" type="button" onclick="showRejectModal()" class="w-full">
                            ✗ Reject Request
                        </x-button>
                    </form>
                </div>
            </div>

            <!-- Reject Modal -->
            <div id="rejectModal" class="hidden fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50">
                <div class="bg-white rounded-lg p-6 max-w-md w-full mx-4">
                    <h3 class="text-lg font-semibold mb-4">Reject Withdrawal</h3>
                    <textarea name="rejection_reason" form="rejectForm" rows="4" 
                              class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-red-500"
                              placeholder="Enter rejection reason..." required></textarea>
                    <div class="flex justify-end gap-3 mt-4">
                        <x-button variant="outline" type="button" onclick="hideRejectModal()">Cancel</x-button>
                        <x-button variant="danger" type="submit" form="rejectForm">Confirm Reject</x-button>
                    </div>
                </div>
            </div>

            <script>
                function showRejectModal() {
                    document.getElementById('rejectModal').classList.remove('hidden');
                }
                function hideRejectModal() {
                    document.getElementById('rejectModal').classList.add('hidden');
                }
            </script>
        @else
            <div class="bg-white rounded-lg shadow p-6">
                <div class="text-center">
                    <p class="text-gray-600">
                        @if($withdrawal->status == 'approved')
                            Approved on {{ $withdrawal->updated_at->format('M d, Y H:i') }}
                        @else
                            Rejected: {{ $withdrawal->rejection_reason }}
                        @endif
                    </p>
                </div>
            </div>
        @endif
    </div>
</div>
@endsection
