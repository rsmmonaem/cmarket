@extends('layouts.admin')

@section('content')
<div class="p-6">
    <div class="max-w-2xl mx-auto">
        <!-- Header -->
        <div class="mb-6">
            <h1 class="text-2xl font-bold text-gray-800">Create New User</h1>
            <p class="text-gray-600 mt-1">Add a new user to the system</p>
        </div>

        <!-- Form -->
        <div class="bg-white rounded-lg shadow p-6">
            <form action="{{ route('admin.users.store') }}" method="POST">
                @csrf

                <x-input 
                    label="Full Name" 
                    name="name" 
                    type="text" 
                    :required="true"
                    placeholder="Enter full name"
                />

                <x-input 
                    label="Phone Number" 
                    name="phone" 
                    type="text" 
                    :required="true"
                    placeholder="01XXXXXXXXX"
                />

                <x-input 
                    label="Email Address" 
                    name="email" 
                    type="email" 
                    placeholder="user@example.com (optional)"
                />

                <x-input 
                    label="Password" 
                    name="password" 
                    type="password" 
                    :required="true"
                    placeholder="Minimum 6 characters"
                />

                <x-select 
                    label="Status" 
                    name="status" 
                    :required="true"
                    :options="[
                        'free' => 'Free',
                        'wallet_verified' => 'Wallet Verified',
                        'vendor' => 'Vendor',
                        'rider' => 'Rider',
                    ]"
                />

                <x-select 
                    label="Role" 
                    name="role" 
                    :required="true"
                    :options="[
                        'customer' => 'Customer',
                        'merchant' => 'Merchant',
                        'rider' => 'Rider',
                        'admin' => 'Admin',
                        'super-admin' => 'Super Admin',
                    ]"
                />

                <div class="flex justify-end gap-3 mt-6">
                    <a href="{{ route('admin.users.index') }}">
                        <x-button variant="outline" type="button">Cancel</x-button>
                    </a>
                    <x-button variant="primary" type="submit">Create User</x-button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
