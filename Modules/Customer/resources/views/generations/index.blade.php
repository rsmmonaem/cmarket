@extends('layouts.customer')

@section('title', 'Team Analytics - CMarket')
@section('page-title', 'My Team Levels')

@section('content')
<div class="space-y-10 animate-fade-in">
    <!-- Macro Network Overview -->
    <div class="bg-white rounded-[2.5rem] p-8 border border-slate-100 shadow-sm overflow-hidden relative">
        <div class="flex items-center gap-5 mb-10">
            <div class="w-16 h-16 rounded-2xl bg-slate-900 flex items-center justify-center text-3xl shadow-xl shadow-slate-900/10">🌍</div>
            <div>
                <h3 class="text-xl font-black text-slate-800 uppercase tracking-tight">Team Hierarchy</h3>
                <p class="text-[10px] font-bold text-slate-400 uppercase tracking-widest">Real-time tracking of your 9-level team network</p>
            </div>
        </div>

        <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-5 gap-6">
            @foreach($generations as $level => $data)
            <div class="p-6 rounded-3xl {{ $data['count'] > 0 ? 'bg-sky-500 text-white shadow-lg shadow-sky-500/20' : 'bg-slate-50 text-slate-400' }} border border-transparent transition-all duration-300 hover:scale-[1.05]">
                <div class="text-[10px] font-black uppercase tracking-widest {{ $data['count'] > 0 ? 'text-sky-100' : 'text-slate-400' }} mb-2">Level {{ $level }}</div>
                <div class="text-3xl font-black">{{ number_format($data['count']) }}</div>
                <p class="text-[9px] font-black uppercase mt-2 tracking-tighter">Members</p>
            </div>
            @endforeach
        </div>
    </div>

    <!-- Recursive List Section -->
    <div class="space-y-8">
        @foreach($generations as $level => $data)
            @if($data['count'] > 0)
            <div class="bg-white rounded-[2.5rem] border border-slate-100 shadow-sm overflow-hidden group">
                <div class="p-8 border-b border-slate-50 flex items-center justify-between">
                    <div class="flex items-center gap-4">
                        <span class="w-12 h-12 rounded-2xl bg-slate-900 text-white flex items-center justify-center font-black text-sm">L{{ $level }}</span>
                        <div>
                            <h4 class="text-sm font-black text-slate-800 uppercase tracking-widest">Level {{ $level }} Members</h4>
                            <p class="text-[10px] font-bold text-slate-400 uppercase tracking-widest">{{ $data['count'] }} Members Found</p>
                        </div>
                    </div>
                </div>

                <div class="overflow-x-auto">
                    <table class="w-full text-left border-collapse">
                        <thead>
                            <tr class="bg-slate-50/50">
                                <th class="p-6 text-[10px] font-black text-slate-500 uppercase tracking-widest">Member</th>
                                <th class="p-6 text-[10px] font-black text-slate-500 uppercase tracking-widest">Phone</th>
                                <th class="p-6 text-[10px] font-black text-slate-500 uppercase tracking-widest">Account Level</th>
                                <th class="p-6 text-[10px] font-black text-slate-500 uppercase tracking-widest text-right">Joined Date</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-slate-50">
                            @foreach($data['users'] as $member)
                            <tr class="hover:bg-slate-50 transition-colors">
                                <td class="p-6">
                                    <div class="flex items-center gap-4">
                                        <div class="w-10 h-10 rounded-xl bg-white border border-slate-100 flex items-center justify-center text-[10px] font-black text-slate-800">
                                            {{ substr($member->name, 0, 1) }}
                                        </div>
                                        <div>
                                            <p class="text-sm font-black text-slate-800">{{ $member->name }}</p>
                                            <p class="text-[9px] font-bold text-slate-400">ID: CM-{{ str_pad($member->id, 5, '0', STR_PAD_LEFT) }}</p>
                                        </div>
                                    </div>
                                </td>
                                <td class="p-6 text-sm font-bold text-slate-500 font-mono">{{ $member->phone }}</td>
                                <td class="p-6">
                                    <span class="px-3 py-1 rounded bg-emerald-50 text-emerald-600 text-[9px] font-black uppercase tracking-wider">
                                        {{ $member->currentDesignation?->designation->name ?? 'STANDARD' }}
                                    </span>
                                </td>
                                <td class="p-6 text-right text-[11px] font-black text-slate-400">
                                    {{ $member->created_at->format('M d, Y') }}
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
            @endif
        @endforeach
    </div>
</div>
@endsection
