@extends('layouts.admin')

@section('content')
<div class="p-6">
    <!-- Header -->
    <div class="flex justify-between items-center mb-6">
        <h1 class="text-2xl font-bold text-gray-800">User Management</h1>
        <a href="{{ route('admin.users.create') }}">
            <x-button variant="primary">
                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
                </svg>
                Add User
            </x-button>
        </a>
    </div>

    <!-- Filters -->
    <div class="bg-white p-4 rounded-lg shadow mb-6">
        <form method="GET" class="grid grid-cols-1 md:grid-cols-4 gap-4">
            <input type="text" name="search" placeholder="Search by name, phone, email..." 
                   value="{{ request('search') }}"
                   class="px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-indigo-500">
            
            <select name="status" class="px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-indigo-500">
                <option value="">All Status</option>
                <option value="free" {{ request('status') == 'free' ? 'selected' : '' }}>Free</option>
                <option value="wallet_verified" {{ request('status') == 'wallet_verified' ? 'selected' : '' }}>Wallet Verified</option>
                <option value="vendor" {{ request('status') == 'vendor' ? 'selected' : '' }}>Vendor</option>
                <option value="rider" {{ request('status') == 'rider' ? 'selected' : '' }}>Rider</option>
                <option value="suspended" {{ request('status') == 'suspended' ? 'selected' : '' }}>Suspended</option>
            </select>
            
            <select name="role" class="px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-indigo-500">
                <option value="">All Roles</option>
                <option value="customer" {{ request('role') == 'customer' ? 'selected' : '' }}>Customer</option>
                <option value="merchant" {{ request('role') == 'merchant' ? 'selected' : '' }}>Merchant</option>
                <option value="rider" {{ request('role') == 'rider' ? 'selected' : '' }}>Rider</option>
                <option value="admin" {{ request('role') == 'admin' ? 'selected' : '' }}>Admin</option>
            </select>
            
            <x-button type="submit" variant="primary">Filter</x-button>
        </form>
    </div>

    <!-- Users Table -->
    <x-table :headers="['ID', 'Name', 'Phone', 'Email', 'Status', 'Role', 'Created']">
        @forelse($users as $user)
            <tr class="hover:bg-gray-50">
                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">{{ $user->id }}</td>
                <td class="px-6 py-4 whitespace-nowrap">
                    <div class="text-sm font-medium text-gray-900">{{ $user->name }}</div>
                </td>
                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ $user->phone }}</td>
                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ $user->email ?? 'N/A' }}</td>
                <td class="px-6 py-4 whitespace-nowrap">
                    @php
                        $statusVariants = [
                            'free' => 'default',
                            'wallet_verified' => 'success',
                            'vendor' => 'info',
                            'rider' => 'primary',
                            'suspended' => 'danger',
                        ];
                    @endphp
                    <x-badge :variant="$statusVariants[$user->status] ?? 'default'">
                        {{ ucfirst(str_replace('_', ' ', $user->status)) }}
                    </x-badge>
                </td>
                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                    {{ $user->roles->pluck('name')->join(', ') }}
                </td>
                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                    {{ $user->created_at->format('M d, Y') }}
                </td>
                <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                    <a href="{{ route('admin.users.show', $user) }}" class="text-indigo-600 hover:text-indigo-900 mr-3">View</a>
                    <a href="{{ route('admin.users.edit', $user) }}" class="text-blue-600 hover:text-blue-900 mr-3">Edit</a>
                    <form action="{{ route('admin.users.destroy', $user) }}" method="POST" class="inline" 
                          onsubmit="return confirm('Are you sure you want to delete this user?');">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="text-red-600 hover:text-red-900">Delete</button>
                    </form>
                </td>
            </tr>
        @empty
            <tr>
                <td colspan="8" class="px-6 py-4 text-center text-gray-500">No users found</td>
            </tr>
        @endforelse
    </x-table>

    <!-- Pagination -->
    <div class="mt-6">
        {{ $users->links() }}
    </div>
</div>
@endsection
