@extends('layouts.customer')

@section('title', 'Regional Network - ' . ucfirst($role))
@section('page-title', 'Territory Partners')

@section('content')
<div class="space-y-8 animate-fade-in">
    <!-- Filters & Stats Header -->
    <div class="bg-white rounded-[2.5rem] p-8 border border-slate-100 shadow-sm flex flex-col md:flex-row justify-between items-center gap-6">
        <div class="flex items-center gap-5">
            <div class="w-14 h-14 rounded-2xl bg-sky-500 flex items-center justify-center text-white text-2xl shadow-lg shadow-sky-500/20">👥</div>
            <div>
                <h3 class="text-xl font-black text-slate-800 uppercase tracking-tight">Active Partnerships</h3>
                <p class="text-[10px] font-bold text-slate-400 uppercase tracking-widest">Managing {{ $users->total() }} members across {{ $role }}</p>
            </div>
        </div>
        
        <div class="flex gap-4 w-full md:w-auto">
            <div class="relative flex-1 md:w-64">
                <input type="text" placeholder="Search partners..." class="w-full bg-slate-50 border-none rounded-2xl px-6 py-4 text-xs font-bold text-slate-800 focus:ring-2 focus:ring-sky-500/20 transition-all placeholder:text-slate-300">
                <span class="absolute right-5 top-1/2 -translate-y-1/2 opacity-20">🔍</span>
            </div>
        </div>
    </div>

    <!-- Table Section -->
    <div class="bg-white rounded-[2.5rem] border border-slate-100 shadow-sm overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse">
                <thead>
                    <tr class="bg-slate-50/50">
                        <th class="p-6 text-[10px] font-black text-slate-500 uppercase tracking-widest">Partner Identity</th>
                        <th class="p-6 text-[10px] font-black text-slate-500 uppercase tracking-widest">Connect Point</th>
                        <th class="p-6 text-[10px] font-black text-slate-500 uppercase tracking-widest">Territory</th>
                        <th class="p-6 text-[10px] font-black text-slate-500 uppercase tracking-widest">Status</th>
                        <th class="p-6 text-[10px] font-black text-slate-500 uppercase tracking-widest text-right">Acquisition</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-50">
                    @forelse($users as $user)
                        <tr class="hover:bg-slate-50 transition-colors group">
                            <td class="p-6">
                                <div class="flex items-center gap-4">
                                    <div class="w-12 h-12 rounded-2xl bg-slate-900 border border-slate-800 flex items-center justify-center text-white text-[10px] font-black uppercase group-hover:scale-110 transition-transform">
                                        {{ substr($user->name, 0, 1) }}
                                    </div>
                                    <div>
                                        <p class="text-sm font-black text-slate-800">{{ $user->name }}</p>
                                        <p class="text-[10px] font-bold text-sky-500 uppercase tracking-tighter">ID: CM-{{ str_pad($user->id, 5, '0', STR_PAD_LEFT) }}</p>
                                    </div>
                                </div>
                            </td>
                            <td class="p-6">
                                <p class="text-[11px] font-black text-slate-800 font-mono">{{ $user->phone }}</p>
                                <p class="text-[10px] font-bold text-slate-400 line-clamp-1">{{ $user->email }}</p>
                            </td>
                            <td class="p-6">
                                <div class="flex flex-col">
                                    <span class="text-[11px] font-black text-slate-700 uppercase tracking-tight">{{ $user->upazila }}</span>
                                    <span class="text-[9px] font-bold text-slate-400">{{ $user->district }}</span>
                                </div>
                            </td>
                            <td class="p-6">
                                <span class="px-3 py-1 rounded-lg text-[9px] font-black uppercase tracking-wider
                                    {{ $user->status == 'wallet_verified' ? 'bg-emerald-50 text-emerald-600' : 'bg-slate-100 text-slate-500' }}">
                                    {{ str_replace('_', ' ', $user->status) }}
                                </span>
                            </td>
                            <td class="p-6 text-right">
                                <p class="text-[11px] font-black text-slate-800">{{ $user->created_at->format('M d, Y') }}</p>
                                <p class="text-[9px] font-bold text-slate-400">{{ $user->created_at->diffForHumans() }}</p>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="p-20 text-center">
                                <div class="text-6xl mb-6 opacity-20">🧊</div>
                                <h3 class="text-xl font-black text-slate-300 uppercase tracking-widest">Territory Empty</h3>
                                <p class="text-xs font-bold text-slate-400 mt-2">No users identified within this regional scope.</p>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        
        @if($users->hasPages())
            <div class="p-8 border-t border-slate-50">
                {{ $users->links() }}
            </div>
        @endif
    </div>
</div>
@endsection
