@extends('layouts.admin')

@section('title', 'User Referrals')
@section('page-title')
    Downline for <span class="text-primary">{{ $user->name }}</span>
@endsection

@section('content')
<div class="card-solid mb-8">
    <div class="flex items-center gap-4 mb-8">
        <div class="w-16 h-16 rounded-2xl bg-primary/10 flex items-center justify-center text-3xl">🪪</div>
        <div>
            <h3 class="text-2xl font-black text-light uppercase tracking-tighter">{{ $user->name }}</h3>
            <div class="flex items-center gap-2 mt-1">
                <span class="px-2 py-0.5 rounded bg-slate-900 text-white text-[8px] font-black uppercase">ID: {{ $user->id }}</span>
                <span class="px-2 py-0.5 rounded bg-emerald-500 text-white text-[8px] font-black uppercase">{{ $user->currentDesignation?->designation->name ?? 'Free member' }}</span>
            </div>
        </div>
    </div>

    <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-9 gap-4">
        @foreach($generations as $level => $data)
        <div class="p-4 rounded-2xl bg-slate-50 dark:bg-slate-900/50 border border-slate-100 dark:border-slate-800/50 text-center">
            <div class="text-[8px] font-black text-muted-light uppercase mb-1">LVL {{ $level }}</div>
            <div class="text-xl font-black text-light">{{ number_format($data['count']) }}</div>
        </div>
        @endforeach
    </div>
</div>

<div class="space-y-6">
    @foreach($generations as $level => $data)
    <div class="card-solid">
        <button class="w-full flex items-center justify-between group" onclick="document.getElementById('level-{{ $level }}').classList.toggle('hidden')">
            <div class="flex items-center gap-4">
                <span class="w-10 h-10 rounded-xl bg-slate-900 text-white flex items-center justify-center text-xs font-black">L{{ $level }}</span>
                <h4 class="text-sm font-black text-light uppercase tracking-widest text-left">Level {{ $level }} Members</h4>
            </div>
            <div class="flex items-center gap-4">
                <span class="px-3 py-1 rounded-full bg-slate-100 dark:bg-slate-800 text-[10px] font-black text-muted-light group-hover:bg-primary group-hover:text-white transition">{{ $data['count'] }} users</span>
                <span class="text-muted-light text-xl opacity-50">↓</span>
            </div>
        </button>

        <div id="level-{{ $level }}" class="{{ $data['count'] > 0 ? '' : 'hidden' }} mt-8">
            @if($data['count'] > 0)
            <div class="overflow-x-auto">
                <table class="w-full text-left">
                    <thead>
                        <tr class="border-b border-slate-100 dark:border-slate-800">
                            <th class="pb-4 text-[10px] font-black uppercase tracking-widest text-muted-light">User ID</th>
                            <th class="pb-4 text-[10px] font-black uppercase tracking-widest text-muted-light">Name</th>
                            <th class="pb-4 text-[10px] font-black uppercase tracking-widest text-muted-light">Phone</th>
                            <th class="pb-4 text-[10px] font-black uppercase tracking-widest text-muted-light">Current Rank</th>
                            <th class="pb-4 text-[10px] font-black uppercase tracking-widest text-muted-light">Join Date</th>
                            <th class="pb-4 text-right text-[10px] font-black uppercase tracking-widest text-muted-light">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-50 dark:divide-slate-800/50">
                        @foreach($data['users'] as $member)
                        <tr>
                            <td class="py-4 text-[10px] font-black">#{{ $member->id }}</td>
                            <td class="py-4">
                                <div class="text-[11px] font-black text-light">{{ $member->name }}</div>
                            </td>
                            <td class="py-4 text-[10px] font-mono text-muted-light">{{ $member->phone }}</td>
                            <td class="py-4">
                                <span class="px-2 py-0.5 rounded text-[8px] font-black uppercase bg-primary/10 text-primary border border-primary/20">
                                    {{ $member->currentDesignation?->designation->name ?? 'Customer' }}
                                </span>
                            </td>
                            <td class="py-4 text-[10px] text-muted-light font-medium">{{ $member->created_at->format('d M Y') }}</td>
                            <td class="py-4 text-right">
                                <a href="{{ route('admin.users.show', $member->id) }}" class="inline-flex items-center px-3 py-1.5 rounded-lg bg-slate-900 text-white text-[8px] font-black uppercase hover:bg-primary transition">View Profile</a>
                                <a href="{{ route('admin.users.generations', $member->id) }}" class="inline-flex items-center px-3 py-1.5 rounded-lg bg-slate-100 dark:bg-slate-800 text-light text-[8px] font-black uppercase hover:bg-slate-200 transition">View Referrals</a>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            @else
            <div class="py-12 text-center">
                <div class="text-4xl mb-4 opacity-20">🧊</div>
                <p class="text-[10px] font-black text-muted-light uppercase tracking-widest">No members found at this level</p>
            </div>
            @endif
        </div>
    </div>
    @endforeach
</div>
@endsection
