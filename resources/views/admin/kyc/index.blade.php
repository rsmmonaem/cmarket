@extends('layouts.admin')

@section('content')
<div class="p-6">
    <!-- Header -->
    <div class="mb-6">
        <h1 class="text-2xl font-bold text-gray-800">KYC Verification</h1>
        <p class="text-gray-600 mt-1">Review and approve user KYC documents</p>
    </div>

    <!-- Stats -->
    <div class="grid grid-cols-1 md:grid-cols-4 gap-4 mb-6">
        <div class="bg-white p-4 rounded-lg shadow">
            <p class="text-sm text-gray-500">Pending</p>
            <p class="text-2xl font-bold text-yellow-600">{{ $kycs->where('status', 'pending')->count() }}</p>
        </div>
        <div class="bg-white p-4 rounded-lg shadow">
            <p class="text-sm text-gray-500">Approved</p>
            <p class="text-2xl font-bold text-green-600">{{ $kycs->where('status', 'approved')->count() }}</p>
        </div>
        <div class="bg-white p-4 rounded-lg shadow">
            <p class="text-sm text-gray-500">Rejected</p>
            <p class="text-2xl font-bold text-red-600">{{ $kycs->where('status', 'rejected')->count() }}</p>
        </div>
        <div class="bg-white p-4 rounded-lg shadow">
            <p class="text-sm text-gray-500">Total</p>
            <p class="text-2xl font-bold text-gray-900">{{ $kycs->total() }}</p>
        </div>
    </div>

    <!-- KYC Table -->
    <x-table :headers="['User', 'ID Type', 'ID Number', 'Submitted', 'Status']">
        @forelse($kycs as $kyc)
            <tr class="hover:bg-gray-50">
                <td class="px-6 py-4 whitespace-nowrap">
                    <div class="text-sm font-medium text-gray-900">{{ $kyc->user->name }}</div>
                    <div class="text-sm text-gray-500">{{ $kyc->user->phone }}</div>
                </td>
                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                    {{ ucfirst($kyc->id_type) }}
                </td>
                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                    {{ $kyc->id_number }}
                </td>
                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                    {{ $kyc->created_at->format('M d, Y') }}
                </td>
                <td class="px-6 py-4 whitespace-nowrap">
                    @php
                        $statusVariants = [
                            'pending' => 'warning',
                            'approved' => 'success',
                            'rejected' => 'danger',
                        ];
                    @endphp
                    <x-badge :variant="$statusVariants[$kyc->status] ?? 'default'">
                        {{ ucfirst($kyc->status) }}
                    </x-badge>
                </td>
                <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                    <a href="{{ route('admin.kyc.show', $kyc) }}" class="text-indigo-600 hover:text-indigo-900">
                        Review
                    </a>
                </td>
            </tr>
        @empty
            <tr>
                <td colspan="6" class="px-6 py-4 text-center text-gray-500">No KYC submissions found</td>
            </tr>
        @endforelse
    </x-table>

    <!-- Pagination -->
    <div class="mt-6">
        {{ $kycs->links() }}
    </div>
</div>
@endsection
