@extends('layouts.admin')

@section('content')
<div class="p-6">
    <div class="max-w-4xl mx-auto">
        <!-- Header -->
        <div class="mb-6">
            <h1 class="text-2xl font-bold text-gray-800">KYC Verification Details</h1>
            <p class="text-gray-600 mt-1">Review and verify user documents</p>
        </div>

        <!-- User Info -->
        <div class="bg-white rounded-lg shadow p-6 mb-6">
            <h2 class="text-lg font-semibold text-gray-800 mb-4">User Information</h2>
            <div class="grid grid-cols-2 gap-4">
                <div>
                    <p class="text-sm text-gray-500">Name</p>
                    <p class="text-gray-900 font-medium">{{ $kyc->user->name }}</p>
                </div>
                <div>
                    <p class="text-sm text-gray-500">Phone</p>
                    <p class="text-gray-900 font-medium">{{ $kyc->user->phone }}</p>
                </div>
                <div>
                    <p class="text-sm text-gray-500">Email</p>
                    <p class="text-gray-900 font-medium">{{ $kyc->user->email ?? 'N/A' }}</p>
                </div>
                <div>
                    <p class="text-sm text-gray-500">Current Status</p>
                    <x-badge :variant="$kyc->user->status == 'wallet_verified' ? 'success' : 'default'">
                        {{ ucfirst(str_replace('_', ' ', $kyc->user->status)) }}
                    </x-badge>
                </div>
            </div>
        </div>

        <!-- KYC Details -->
        <div class="bg-white rounded-lg shadow p-6 mb-6">
            <h2 class="text-lg font-semibold text-gray-800 mb-4">KYC Details</h2>
            <div class="grid grid-cols-2 gap-4 mb-6">
                <div>
                    <label class="text-sm font-bold text-slate-400 uppercase tracking-widest block mb-1">ID Type</label>
                    <p class="text-slate-800 dark:text-white font-black uppercase text-sm">{{ $kyc->document_type }}</p>
                </div>
                <div>
                    <label class="text-sm font-bold text-slate-400 uppercase tracking-widest block mb-1">ID Number</label>
                    <p class="text-slate-800 dark:text-white font-black text-sm">{{ $kyc->document_number }}</p>
                </div>
                <div>
                    <p class="text-sm text-gray-500">Date of Birth</p>
                    <p class="text-gray-900 font-medium">{{ $kyc->date_of_birth ? \Carbon\Carbon::parse($kyc->date_of_birth)->format('M d, Y') : 'N/A' }}</p>
                </div>
                <div>
                    <p class="text-sm text-gray-500">Submitted</p>
                    <p class="text-gray-900 font-medium">{{ $kyc->created_at->format('M d, Y H:i') }}</p>
                </div>
            </div>

            <!-- Documents -->
            <div>
                <p class="text-[10px] font-black uppercase tracking-widest text-slate-400 mb-4 pb-2 border-b border-slate-50 dark:border-slate-800">Verification Documents</p>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    @if($kyc->document_front)
                        <div class="bg-slate-50 dark:bg-slate-800 rounded-3xl p-4 border border-slate-100 dark:border-slate-700">
                            <p class="text-[10px] font-black uppercase tracking-widest text-primary mb-3 text-center">ID FRONT PART</p>
                            <a href="{{ asset('storage/' . $kyc->document_front) }}" target="_blank" class="block group cursor-zoom-in">
                                <img src="{{ asset('storage/' . $kyc->document_front) }}" alt="Front" class="w-full h-64 object-cover rounded-2xl shadow-sm group-hover:opacity-90 transition-all border border-slate-200 dark:border-slate-600">
                            </a>
                        </div>
                    @endif
                    @if($kyc->document_back)
                        <div class="bg-slate-50 dark:bg-slate-800 rounded-3xl p-4 border border-slate-100 dark:border-slate-700">
                            <p class="text-[10px] font-black uppercase tracking-widest text-primary mb-3 text-center">ID BACK PART</p>
                            <a href="{{ asset('storage/' . $kyc->document_back) }}" target="_blank" class="block group cursor-zoom-in">
                                <img src="{{ asset('storage/' . $kyc->document_back) }}" alt="Back" class="w-full h-64 object-cover rounded-2xl shadow-sm group-hover:opacity-90 transition-all border border-slate-200 dark:border-slate-600">
                            </a>
                        </div>
                    @endif
                </div>
            </div>
        </div>

        <!-- Actions -->
        @if($kyc->status == 'pending')
            <div class="bg-white rounded-lg shadow p-6">
                <h2 class="text-lg font-semibold text-gray-800 mb-4">Actions</h2>
                
                <div class="grid grid-cols-2 gap-4">
                    <!-- Approve -->
                    <form action="{{ route('admin.kyc.approve', $kyc) }}" method="POST">
                        @csrf
                        <x-button variant="success" type="submit" class="w-full">
                            ✓ Approve KYC
                        </x-button>
                    </form>

                    <!-- Reject -->
                    <form action="{{ route('admin.kyc.reject', $kyc) }}" method="POST" id="rejectForm">
                        @csrf
                        <x-button variant="danger" type="button" onclick="showRejectModal()" class="w-full">
                            ✗ Reject KYC
                        </x-button>
                    </form>
                </div>
            </div>

            <!-- Reject Modal (Simple) -->
            <div id="rejectModal" class="hidden fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50">
                <div class="bg-white rounded-lg p-6 max-w-md w-full mx-4">
                    <h3 class="text-lg font-semibold mb-4">Reject KYC</h3>
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
                    <x-badge :variant="$kyc->status == 'approved' ? 'success' : 'danger'" class="text-lg px-4 py-2">
                        {{ ucfirst($kyc->status) }}
                    </x-badge>
                    @if($kyc->rejection_reason)
                        <p class="text-gray-600 mt-2">Reason: {{ $kyc->rejection_reason }}</p>
                    @endif
                </div>
            </div>
        @endif
    </div>
</div>
@endsection
