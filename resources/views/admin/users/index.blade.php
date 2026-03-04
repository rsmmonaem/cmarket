@extends('layouts.admin')

@section('title', 'User Management')
@section('page-title', 'User Management')

@section('content')
<x-admin.card>
    <div class="flex flex-col lg:flex-row justify-between items-start lg:items-center gap-6 mb-8">
        <div>
            <h2 class="text-xl font-black text-light">User Directory</h2>
            <p class="text-xs text-muted-light font-bold uppercase tracking-widest">Manage platform participants and roles</p>
        </div>
        <div class="flex flex-wrap gap-3">
            <a href="{{ route('admin.users.create') }}">
                <x-admin.button>
                    <span class="text-lg">➕</span> Add User
                </x-admin.button>
            </a>
        </div>
    </div>

    <!-- Filters -->
    <div class="p-6 rounded-3xl bg-slate-50 dark:bg-slate-800/50 border border-slate-100 dark:border-slate-800 mb-8">
        <form method="GET" class="grid grid-cols-1 md:grid-cols-4 gap-4">
            <input type="text" name="search" placeholder="Name, Phone, Email..." 
                   value="{{ request('search') }}"
                   class="px-4 py-3 bg-white dark:bg-slate-900 border border-slate-200 dark:border-slate-700 rounded-2xl text-sm focus:outline-none focus:ring-2 focus:ring-sky-500 transition col-span-1 md:col-span-2">
            
            <select name="status" class="px-4 py-3 bg-white dark:bg-slate-900 border border-slate-200 dark:border-slate-700 rounded-2xl text-sm focus:outline-none focus:ring-2 focus:ring-sky-500 transition">
                <option value="">All Status</option>
                <option value="free" {{ request('status') == 'free' ? 'selected' : '' }}>Free</option>
                <option value="wallet_verified" {{ request('status') == 'wallet_verified' ? 'selected' : '' }}>Verified</option>
                <option value="suspended" {{ request('status') == 'suspended' ? 'selected' : '' }}>Suspended</option>
            </select>
            
            <x-admin.button type="submit" variant="secondary" class="w-full">
                🔍 Filter
            </x-admin.button>
        </form>
    </div>

    <div class="overflow-x-auto -mx-6">
        <table class="w-full text-left border-collapse">
            <thead>
                <tr class="border-b border-light">
                    <th class="px-6 py-4 text-[10px] font-black uppercase tracking-widest text-muted-light">User Info</th>
                    <th class="px-6 py-4 text-[10px] font-black uppercase tracking-widest text-muted-light">Contact</th>
                    <th class="px-6 py-4 text-[10px] font-black uppercase tracking-widest text-muted-light">Role</th>
                    <th class="px-6 py-4 text-[10px] font-black uppercase tracking-widest text-muted-light text-center">Wallet Status</th>
                    <th class="px-6 py-4 text-[10px] font-black uppercase tracking-widest text-muted-light">Registration</th>
                    <th class="px-6 py-4 text-[10px] font-black uppercase tracking-widest text-muted-light text-right">Actions</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-light">
                @forelse($users as $user)
                    <tr class="group hover:bg-slate-50 dark:hover:bg-slate-800/50 transition-colors">
                        <td class="px-6 py-4">
                            <div class="flex items-center gap-4">
                                <div class="w-12 h-12 rounded-2xl bg-slate-900 flex items-center justify-center text-white font-black text-lg">
                                    {{ substr($user->name, 0, 1) }}
                                </div>
                                <div>
                                    <div class="text-sm font-black text-light">{{ $user->name }}</div>
                                    <div class="text-[10px] text-muted-light font-bold">UID: {{ $user->id }}</div>
                                </div>
                            </div>
                        </td>
                        <td class="px-6 py-4">
                            <div class="text-sm font-bold text-light">{{ $user->phone }}</div>
                            <div class="text-xs text-muted-light">{{ $user->email ?? 'no-email@cmarket.com' }}</div>
                        </td>
                        <td class="px-6 py-4">
                            <div class="flex flex-wrap gap-1">
                                @foreach($user->roles as $role)
                                    <span class="px-2 py-0.5 rounded-lg bg-slate-100 dark:bg-slate-800 text-[10px] font-black text-light border border-light">
                                        {{ strtoupper($role->name) }}
                                    </span>
                                @endforeach
                            </div>
                        </td>
                        <td class="px-6 py-4 text-center">
                            @if($user->status === 'wallet_verified')
                                <span class="inline-flex items-center gap-1.5 py-1.5 px-3 rounded-full text-[10px] font-black bg-emerald-100 text-emerald-700 dark:bg-emerald-900/40 dark:text-emerald-400">
                                    <span class="w-1.5 h-1.5 rounded-full bg-emerald-500"></span> VERIFIED
                                </span>
                            @elseif($user->status === 'suspended')
                                <span class="inline-flex items-center gap-1.5 py-1.5 px-3 rounded-full text-[10px] font-black bg-red-100 text-red-700 dark:bg-red-900/40 dark:text-red-400">
                                    <span class="w-1.5 h-1.5 rounded-full bg-red-500"></span> SUSPENDED
                                </span>
                            @else
                                <span class="inline-flex items-center gap-1.5 py-1.5 px-3 rounded-full text-[10px] font-black bg-slate-100 text-slate-500 dark:bg-slate-800 dark:text-slate-400">
                                    <span class="w-1.5 h-1.5 rounded-full bg-slate-400"></span> FREE
                                </span>
                            @endif
                        </td>
                        <td class="px-6 py-4 text-sm font-bold text-muted-light">
                            {{ $user->created_at->format('M d, Y') }}
                        </td>
                        <td class="px-6 py-4 text-right">
                            <div class="flex justify-end gap-2">
                                <a href="{{ route('admin.users.generations', $user) }}" class="p-2 rounded-xl bg-slate-100 dark:bg-slate-800 text-light hover:bg-emerald-500 hover:text-white transition shadow-sm" title="View Generations">
                                    🌍
                                </a>
                                <a href="{{ route('admin.users.edit', $user) }}" class="p-2 rounded-xl bg-slate-100 dark:bg-slate-800 text-light hover:bg-sky-500 hover:text-white transition shadow-sm">
                                    ✏️
                                </a>
                                <form action="{{ route('admin.users.destroy', $user) }}" method="POST" class="inline" onsubmit="return confirm('Delete this user?');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="p-2 rounded-xl bg-slate-100 dark:bg-slate-800 text-light hover:bg-red-500 hover:text-white transition shadow-sm">
                                        🗑️
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="6" class="px-6 py-12 text-center text-muted-light italic">No users found.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    @if($users->hasPages())
        <div class="mt-8">
            {{ $users->links() }}
        </div>
    @endif
</x-admin.card>
@endsection
