@extends('layouts.admin')

@section('title', 'Participant Directory - CMarket')
@section('page-title', 'Global Participant Management')

@section('content')
<div class="space-y-10 animate-fade-in">
    <!-- Macro Summary & Action -->
    <div class="bg-white dark:bg-slate-900 rounded-[2.5rem] md:rounded-[3rem] p-6 md:p-10 lg:p-12 border border-slate-100 dark:border-slate-800 shadow-sm flex flex-col lg:flex-row justify-between items-center gap-8 md:gap-10 overflow-hidden relative group">
        <div class="relative z-10 w-full lg:w-auto text-center lg:text-left">
            <h2 class="text-2xl md:text-3xl font-black text-slate-800 dark:text-white tracking-tight leading-none mb-3 md:mb-4">Participant Inventory</h2>
            <p class="text-slate-400 dark:text-slate-500 font-bold text-[9px] md:text-[10px] uppercase tracking-[0.2em] ml-1">Managing {{ number_format($users->total()) }} platform nodes</p>
        </div>
        <div class="flex items-center gap-4 relative z-10 w-full lg:w-auto">
            <a href="{{ route('admin.users.create') }}" class="flex-1 lg:flex-none px-6 py-4 md:px-10 md:py-5 bg-slate-900 dark:bg-sky-600 text-white rounded-xl md:rounded-2xl font-black text-[9px] md:text-[10px] uppercase tracking-widest shadow-2xl shadow-slate-900/10 hover:bg-sky-600 dark:hover:bg-sky-500 hover:scale-[1.05] transition-all flex items-center justify-center gap-3">
                <span class="text-base md:text-lg">➕</span> Register New Node
            </a>
        </div>
        <!-- Decor -->
        <div class="absolute -right-10 -bottom-10 opacity-[0.03] text-[150px] md:text-[200px] leading-none select-none italic font-black group-hover:scale-110 transition-transform duration-1000 dark:text-white">INDEX</div>
    </div>

    <!-- Intelligent Filtering Terminal -->
    <div class="bg-white dark:bg-slate-900 rounded-[2.5rem] md:rounded-[3rem] p-6 md:p-10 border border-slate-100 dark:border-slate-800 shadow-sm">
        <form method="GET" class="flex flex-col lg:flex-row gap-4 md:gap-6">
            <div class="flex-1 relative">
                <span class="absolute left-6 top-1/2 -translate-y-1/2 opacity-20 text-lg">🔍</span>
                <input type="text" name="search" placeholder="Search parameters..." 
                       value="{{ request('search') }}"
                       class="w-full h-14 md:h-16 bg-slate-50 dark:bg-slate-800 border-none rounded-2xl pl-16 pr-6 text-xs font-black text-slate-800 dark:text-white focus:ring-2 focus:ring-sky-500/20 transition-all placeholder:text-slate-300 dark:placeholder:text-slate-600">
            </div>
            
            <div class="lg:w-64">
                <select name="status" class="w-full h-14 md:h-16 bg-slate-50 dark:bg-slate-800 border-none rounded-2xl px-6 text-xs font-black text-slate-800 dark:text-white focus:ring-2 focus:ring-sky-500/20 transition-all">
                    <option value="">All Tiers</option>
                    <option value="free" {{ request('status') == 'free' ? 'selected' : '' }}>Free</option>
                    <option value="wallet_verified" {{ request('status') == 'wallet_verified' ? 'selected' : '' }}>Verified</option>
                    <option value="suspended" {{ request('status') == 'suspended' ? 'selected' : '' }}>Suspended</option>
                </select>
            </div>
            
            <div class="flex gap-3">
                <button type="submit" class="flex-1 lg:flex-none h-14 md:h-16 px-10 bg-slate-900 dark:bg-sky-600 text-white rounded-2xl font-black text-[10px] uppercase tracking-widest hover:bg-sky-600 dark:hover:bg-sky-500 transition-all flex items-center justify-center gap-3 active:scale-95 shadow-lg shadow-slate-900/10 dark:shadow-sky-500/10">
                    Filter
                </button>
                <a href="{{ route('admin.users.index') }}" class="h-14 md:h-16 px-6 bg-slate-50 dark:bg-slate-800 text-slate-400 dark:text-slate-500 rounded-2xl font-black text-[10px] uppercase tracking-widest hover:text-rose-500 transition-all flex items-center justify-center border border-transparent hover:border-rose-100 dark:hover:border-rose-900/30">↺</a>
            </div>
        </form>
    </div>

    <!-- Data Infrastructure Table -->
    <div class="bg-white dark:bg-slate-900 rounded-[2.5rem] md:rounded-[3rem] border border-slate-100 dark:border-slate-800 shadow-sm overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse min-w-[900px]">
                <thead>
                    <tr class="bg-slate-50/50 dark:bg-slate-800/50">
                        <th class="px-10 py-6 text-[10px] font-black uppercase tracking-[0.2em] text-slate-400 dark:text-slate-500">Node Identity</th>
                        <th class="px-10 py-6 text-[10px] font-black uppercase tracking-[0.2em] text-slate-400 dark:text-slate-500">Communication</th>
                        <th class="px-10 py-6 text-[10px] font-black uppercase tracking-[0.2em] text-slate-400 dark:text-slate-500">Role Matrix</th>
                        <th class="px-10 py-6 text-[10px] font-black uppercase tracking-[0.2em] text-slate-400 dark:text-slate-500 text-center">Validation</th>
                        <th class="px-10 py-6 text-[10px] font-black uppercase tracking-[0.2em] text-slate-400 dark:text-slate-500 text-right">Operations</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-50 dark:divide-slate-800">
                    @forelse($users as $user)
                        <tr class="group hover:bg-slate-50/80 transition-all duration-300">
                            <td class="px-10 py-8">
                                <div class="flex items-center gap-6">
                                    <div class="w-14 h-14 rounded-2xl bg-slate-900 flex items-center justify-center text-white font-black text-xl shadow-lg shadow-slate-900/10 group-hover:scale-110 transition-transform">
                                        {{ substr($user->name, 0, 1) }}
                                    </div>
                                    <div>
                                        <div class="text-sm font-black text-slate-800 mb-1">{{ $user->name }}</div>
                                        <div class="text-[9px] text-slate-400 font-black uppercase tracking-widest">UID: {{ str_pad($user->id, 5, '0', STR_PAD_LEFT) }}</div>
                                    </div>
                                </div>
                            </td>
                            <td class="px-10 py-8">
                                <div class="text-xs font-black text-slate-800 mb-1">{{ $user->phone }}</div>
                                <div class="text-[10px] font-bold text-slate-400 truncate max-w-[180px]">{{ $user->email ?? 'N/A' }}</div>
                            </td>
                            <td class="px-10 py-8">
                                <div class="flex flex-wrap gap-2">
                                    @foreach($user->roles as $role)
                                        <span class="px-3 py-1 rounded-lg bg-white border border-slate-100 text-[8px] font-black text-slate-600 uppercase tracking-widest shadow-sm">
                                            {{ $role->name }}
                                        </span>
                                    @endforeach
                                </div>
                            </td>
                            <td class="px-10 py-8 text-center">
                                @if($user->status === 'wallet_verified')
                                    <span class="inline-flex items-center gap-2 py-2 px-4 rounded-xl text-[9px] font-black bg-emerald-50 text-emerald-600 border border-emerald-100">
                                        <span class="w-1.5 h-1.5 rounded-full bg-emerald-500 animate-pulse"></span> VERIFIED
                                    </span>
                                @elseif($user->status === 'suspended')
                                    <span class="inline-flex items-center gap-2 py-2 px-4 rounded-xl text-[9px] font-black bg-rose-50 text-rose-600 border border-rose-100">
                                        🚫 SUSPENDED
                                    </span>
                                @else
                                    <span class="inline-flex items-center gap-2 py-2 px-4 rounded-xl text-[9px] font-black bg-slate-50 text-slate-400 border border-slate-100">
                                         FREE TIER
                                    </span>
                                @endif
                            </td>
                            <td class="px-10 py-8 text-right">
                                <div class="flex justify-end gap-3 opacity-0 group-hover:opacity-100 transition-opacity translate-x-4 group-hover:translate-x-0 duration-300">
                                    <a href="{{ route('admin.users.show', $user) }}" class="w-10 h-10 rounded-xl bg-white dark:bg-slate-800 border border-slate-100 dark:border-slate-700 flex items-center justify-center text-lg hover:bg-sky-500 hover:text-white hover:border-sky-500 transition-all shadow-sm">
                                        ⚖️
                                    </a>
                                    <a href="{{ route('admin.users.edit', $user) }}" class="w-10 h-10 rounded-xl bg-white dark:bg-slate-800 border border-slate-100 dark:border-slate-700 flex items-center justify-center text-lg hover:bg-sky-500 hover:text-white hover:border-sky-500 transition-all shadow-sm">
                                        ✏️
                                    </a>
                                    <form action="{{ route('admin.users.destroy', $user) }}" method="POST" class="inline" onsubmit="return confirm('Permanent node deletion confirmation?');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="w-10 h-10 rounded-xl bg-white dark:bg-slate-800 border border-slate-100 dark:border-slate-700 flex items-center justify-center text-lg hover:bg-rose-500 hover:text-white hover:border-rose-500 transition-all shadow-sm">
                                            🗑️
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="px-10 py-32 text-center text-slate-300 flex flex-col items-center">
                                <span class="text-8xl mb-6 opacity-10">🧊</span>
                                <p class="text-lg font-black uppercase tracking-[0.2em]">Zero Participants Located</p>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if($users->hasPages())
            <div class="p-6 md:p-10 border-t border-slate-50 dark:border-slate-800 bg-slate-50/30 dark:bg-slate-800/30">
                {{ $users->links() }}
            </div>
        @endif
    </div>
</div>
@endsection
