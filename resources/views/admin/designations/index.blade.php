@extends('layouts.admin')

@section('title', 'Designation Management')
@section('page-title', 'Platform Hierarchies')

@section('content')
<x-admin.card>
    <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4 mb-8">
        <div>
            <h2 class="text-xl font-black text-light">Company Designations</h2>
            <p class="text-xs text-muted-light font-bold uppercase tracking-widest">Define roles and achievement ranks</p>
        </div>
        <a href="{{ route('admin.designations.create') }}">
            <x-admin.button>
                <span class="text-lg">➕</span> Add New Rank
            </x-admin.button>
        </a>
    </div>

    <div class="overflow-x-auto -mx-6">
        <table class="w-full text-left border-collapse">
            <thead>
                <tr class="border-b border-light">
                    <th class="px-6 py-4 text-[10px] font-black uppercase tracking-widest text-muted-light">Rank Title</th>
                    <th class="px-6 py-4 text-[10px] font-black uppercase tracking-widest text-muted-light">Required Sales</th>
                    <th class="px-6 py-4 text-[10px] font-black uppercase tracking-widest text-muted-light">Required Team</th>
                    <th class="px-6 py-4 text-[10px] font-black uppercase tracking-widest text-muted-light">Benefit %</th>
                    <th class="px-6 py-4 text-[10px] font-black uppercase tracking-widest text-muted-light text-right">Action</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-light">
                @forelse($designations as $designation)
                    <tr class="group hover:bg-slate-50 dark:hover:bg-slate-800/50 transition-colors">
                        <td class="px-6 py-4">
                            <div class="flex items-center gap-3">
                                <div class="w-10 h-10 rounded-xl bg-slate-900 flex items-center justify-center text-white font-black text-lg">
                                    {{ substr($designation->name, 0, 1) }}
                                </div>
                                <div>
                                    <div class="text-sm font-black text-light">{{ $designation->name }}</div>
                                    <div class="text-[10px] text-muted-light font-bold">LVL: {{ $designation->level ?? 1 }}</div>
                                </div>
                            </div>
                        </td>
                        <td class="px-6 py-4 text-sm font-bold text-light">
                            ৳{{ number_format($designation->min_sales ?? 0, 0) }}
                        </td>
                        <td class="px-6 py-4 text-sm font-bold text-light">
                             {{ $designation->min_team_size ?? 0 }} MEMBERS
                        </td>
                        <td class="px-6 py-4">
                            <span class="px-2 py-1 rounded-lg bg-sky-50 dark:bg-sky-900/20 text-sky-600 dark:text-sky-400 font-black text-xs">
                                {{ $designation->commission_rate ?? 0 }}%
                            </span>
                        </td>
                        <td class="px-6 py-4 text-right">
                            <div class="flex justify-end gap-2">
                                <a href="{{ route('admin.designations.edit', $designation) }}" class="p-2 rounded-xl bg-slate-100 dark:bg-slate-800 text-light hover:bg-sky-500 hover:text-white transition shadow-sm">
                                    ✏️
                                </a>
                                <form action="{{ route('admin.designations.destroy', $designation) }}" method="POST" class="inline" onsubmit="return confirm('Delete this rank?');">
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
                    <tr><td colspan="5" class="px-6 py-12 text-center text-muted-light italic">No designations defined yet.</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
</x-admin.card>
@endsection
