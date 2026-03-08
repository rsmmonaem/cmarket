@extends('layouts.admin')

@section('content')
<div class="p-6">
    <div class="max-w-2xl mx-auto">
        <!-- Header -->
        <div class="mb-6">
            <h1 class="text-2xl font-bold text-gray-800">Edit User</h1>
            <p class="text-gray-600 mt-1">Update user information</p>
        </div>

        <!-- Form -->
        <div class="bg-white rounded-lg shadow p-6">
            <form action="{{ route('admin.users.update', $user) }}" method="POST">
                @csrf
                @method('PUT')

                <x-input 
                    label="Full Name" 
                    name="name" 
                    type="text" 
                    :required="true"
                    :value="$user->name"
                />

                <x-input 
                    label="Phone Number" 
                    name="phone" 
                    type="text" 
                    :required="true"
                    :value="$user->phone"
                />

                <x-input 
                    label="Email Address" 
                    name="email" 
                    type="email" 
                    :value="$user->email"
                />

                <x-input 
                    label="New Password" 
                    name="password" 
                    type="password" 
                    placeholder="Leave blank to keep current password"
                />

                <x-select 
                    label="Status" 
                    name="status" 
                    :required="true"
                    :selected="$user->status"
                    :options="[
                        'free' => 'Free',
                        'wallet_verified' => 'Wallet Verified',
                        'merchant' => 'Merchant',
                        'rider' => 'Rider',
                        'suspended' => 'Suspended',
                    ]"
                />

                <div class="flex justify-end gap-3 mt-6">
                    <a href="{{ route('admin.users.index') }}">
                        <x-button variant="outline" type="button">Cancel</x-button>
                    </a>
                    <x-button variant="primary" type="submit">Update User</x-button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
