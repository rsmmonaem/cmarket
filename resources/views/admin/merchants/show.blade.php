@extends('layouts.admin')

@section('content')
<div class="p-6">
    <div class="max-w-4xl mx-auto">
        <!-- Header -->
        <div class="mb-6">
            <h1 class="text-2xl font-bold text-gray-800">Merchant Details</h1>
            <p class="text-gray-600 mt-1">Review merchant application</p>
        </div>

        <!-- Business Info -->
        <div class="bg-white rounded-lg shadow p-6 mb-6">
            <h2 class="text-lg font-semibold text-gray-800 mb-4">Business Information</h2>
            <div class="grid grid-cols-2 gap-4">
                <div>
                    <p class="text-sm text-gray-500">Business Name</p>
                    <p class="text-gray-900 font-medium">{{ $merchant->business_name }}</p>
                </div>
                <div>
                    <p class="text-sm text-gray-500">Business Type</p>
                    <p class="text-gray-900 font-medium">{{ $merchant->business_type }}</p>
                </div>
                <div>
                    <p class="text-sm text-gray-500">Phone</p>
                    <p class="text-gray-900 font-medium">{{ $merchant->phone }}</p>
                </div>
                <div>
                    <p class="text-sm text-gray-500">Email</p>
                    <p class="text-gray-900 font-medium">{{ $merchant->email ?? 'N/A' }}</p>
                </div>
                <div class="col-span-2">
                    <p class="text-sm text-gray-500">Address</p>
                    <p class="text-gray-900 font-medium">{{ $merchant->address }}</p>
                </div>
            </div>
        </div>

        <!-- Owner Info -->
        <div class="bg-white rounded-lg shadow p-6 mb-6">
            <h2 class="text-lg font-semibold text-gray-800 mb-4">Owner Information</h2>
            <div class="grid grid-cols-2 gap-4">
                <div>
                    <p class="text-sm text-gray-500">Name</p>
                    <p class="text-gray-900 font-medium">{{ $merchant->user->name }}</p>
                </div>
                <div>
                    <p class="text-sm text-gray-500">Phone</p>
                    <p class="text-gray-900 font-medium">{{ $merchant->user->phone }}</p>
                </div>
                <div>
                    <p class="text-sm text-gray-500">Email</p>
                    <p class="text-gray-900 font-medium">{{ $merchant->user->email ?? 'N/A' }}</p>
                </div>
                <div>
                    <p class="text-sm text-gray-500">Status</p>
                    <x-badge :variant="$merchant->user->status == 'vendor' ? 'success' : 'default'">
                        {{ ucfirst(str_replace('_', ' ', $merchant->user->status)) }}
                    </x-badge>
                </div>
            </div>
        </div>

        <!-- Actions -->
        @if($merchant->status == 'pending')
            <div class="bg-white rounded-lg shadow p-6">
                <h2 class="text-lg font-semibold text-gray-800 mb-4">Actions</h2>
                
                <div class="grid grid-cols-2 gap-4">
                    <!-- Approve -->
                    <form action="{{ route('admin.merchants.approve', $merchant) }}" method="POST">
                        @csrf
                        <x-button variant="success" type="submit" class="w-full">
                            ✓ Approve Merchant
                        </x-button>
                    </form>

                    <!-- Reject -->
                    <form action="{{ route('admin.merchants.reject', $merchant) }}" method="POST">
                        @csrf
                        <x-button variant="danger" type="submit" class="w-full">
                            ✗ Reject Application
                        </x-button>
                    </form>
                </div>
            </div>
        @elseif($merchant->status == 'approved')
            <div class="bg-white rounded-lg shadow p-6">
                <h2 class="text-lg font-semibold text-gray-800 mb-4">Actions</h2>
                <form action="{{ route('admin.merchants.suspend', $merchant) }}" method="POST">
                    @csrf
                    <x-button variant="warning" type="submit">
                        🚫 Suspend Merchant
                    </x-button>
                </form>
            </div>
        @else
            <div class="bg-white rounded-lg shadow p-6">
                <div class="text-center">
                    <x-badge :variant="$merchant->status == 'approved' ? 'success' : 'danger'" class="text-lg px-4 py-2">
                        {{ ucfirst($merchant->status) }}
                    </x-badge>
                </div>
            </div>
        @endif
    </div>
</div>
@endsection
