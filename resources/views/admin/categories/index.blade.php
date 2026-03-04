@extends('layouts.admin')

@section('title', 'Category Logic - CMarket')
@section('page-title', 'Taxonomy Architecture')

@section('content')
<div class="space-y-10 animate-fade-in">
    <!-- Macro Summary & Action -->
    <div class="bg-white dark:bg-slate-900 rounded-[2.5rem] md:rounded-[3rem] p-6 md:p-10 lg:p-12 border border-slate-100 dark:border-slate-800 shadow-sm flex flex-col lg:flex-row justify-between items-center gap-8 md:gap-10 overflow-hidden relative group">
        <div class="relative z-10 w-full lg:w-auto text-center lg:text-left">
            <h2 class="text-2xl md:text-3xl font-black text-slate-800 dark:text-white tracking-tight leading-none mb-3 md:mb-4">Taxonomy Engine</h2>
            <p class="text-slate-400 dark:text-slate-500 font-bold text-[9px] md:text-[10px] uppercase tracking-[0.2em] ml-1">Organizing platform logic into {{ $categories->total() }} nodes</p>
        </div>
        <div class="flex items-center gap-4 relative z-10 w-full lg:w-auto">
            <a href="{{ route('admin.categories.create') }}" class="flex-1 lg:flex-none px-6 py-4 md:px-10 md:py-5 bg-slate-900 dark:bg-sky-600 text-white rounded-xl md:rounded-2xl font-black text-[9px] md:text-[10px] uppercase tracking-widest shadow-2xl shadow-slate-900/10 hover:bg-sky-600 dark:hover:bg-sky-500 hover:scale-[1.05] transition-all flex items-center justify-center gap-3">
                <span class="text-base md:text-lg">➕</span> Deploy New Node
            </a>
        </div>
        <!-- Decor -->
        <div class="absolute -right-10 -bottom-10 opacity-[0.03] text-[150px] md:text-[200px] leading-none select-none italic font-black group-hover:scale-110 transition-transform duration-1000 dark:text-white">MAP</div>
    </div>

    <!-- Data Infrastructure Table -->
    <div class="bg-white dark:bg-slate-900 rounded-[2.5rem] md:rounded-[3rem] border border-slate-100 dark:border-slate-800 shadow-sm overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse min-w-[900px]">
                <thead>
                    <tr class="bg-slate-50/50 dark:bg-slate-800/50">
                        <th class="px-10 py-6 text-[10px] font-black uppercase tracking-[0.2em] text-slate-400 dark:text-slate-500">Taxonomy Node</th>
                        <th class="px-10 py-6 text-[10px] font-black uppercase tracking-[0.2em] text-slate-400 dark:text-slate-500">Parent Protocol</th>
                        <th class="px-10 py-6 text-[10px] font-black uppercase tracking-[0.2em] text-slate-400 dark:text-slate-500 text-center">Entity Count</th>
                        <th class="px-10 py-6 text-[10px] font-black uppercase tracking-[0.2em] text-slate-400 dark:text-slate-500 text-center">Protocol Status</th>
                        <th class="px-10 py-6 text-[10px] font-black uppercase tracking-[0.2em] text-slate-400 dark:text-slate-500 text-right">Operations</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-50 dark:divide-slate-800">
                    @forelse($categories as $category)
                        <tr class="group hover:bg-slate-50/80 dark:hover:bg-slate-800/50 transition-all duration-300">
                            <td class="px-10 py-8">
                                <div class="flex items-center gap-6">
                                    <div class="w-12 h-12 rounded-2xl bg-slate-100 dark:bg-slate-800 border border-slate-100 dark:border-slate-700 flex items-center justify-center text-xl shadow-lg group-hover:scale-110 transition-transform overflow-hidden font-black">
                                        @if($category->image)
                                            <img src="{{ asset('storage/' . $category->image) }}" class="w-full h-full object-cover">
                                        @else
                                            📂
                                        @endif
                                    </div>
                                    <div>
                                        <div class="text-sm font-black text-slate-800 dark:text-white mb-1">{{ $category->name }}</div>
                                        <div class="text-[9px] text-slate-400 dark:text-slate-500 font-black uppercase tracking-widest">{{ $category->slug }}</div>
                                    </div>
                                </div>
                            </td>
                            <td class="px-10 py-8">
                                <span class="text-[10px] font-black text-slate-600 dark:text-slate-400 uppercase tracking-widest">
                                    {{ $category->parent->name ?? 'ROOT LEVEL' }}
                                </span>
                            </td>
                            <td class="px-10 py-8 text-center text-sm font-black text-slate-800 dark:text-white">
                                {{ number_format($category->products_count) }}
                            </td>
                            <td class="px-10 py-8 text-center">
                                @if($category->is_active)
                                    <span class="inline-flex items-center gap-1.5 py-1.5 px-3 rounded-lg text-[8px] font-black bg-emerald-50 dark:bg-emerald-900/20 text-emerald-600 dark:text-emerald-400 border border-emerald-100 dark:border-emerald-800">
                                        ACTIVE
                                    </span>
                                @else
                                    <span class="inline-flex items-center gap-1.5 py-1.5 px-3 rounded-lg text-[8px] font-black bg-slate-50 dark:bg-slate-800 text-slate-500 dark:text-slate-400 border border-slate-100 dark:border-slate-800">
                                        DORMANT
                                    </span>
                                @endif
                            </td>
                            <td class="px-10 py-8 text-right">
                                <div class="flex justify-end opacity-0 group-hover:opacity-100 transition-all translate-x-4 group-hover:translate-x-0 duration-300 gap-3">
                                    <a href="{{ route('admin.categories.edit', $category) }}" class="w-10 h-10 rounded-xl bg-slate-900 dark:bg-slate-800 text-white flex items-center justify-center text-lg hover:bg-sky-500 transition-all shadow-xl shadow-slate-900/10">
                                        ✏️
                                    </a>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="px-10 py-32 text-center text-slate-300 flex flex-col items-center">
                                <span class="text-8xl mb-6 opacity-10">🗺️</span>
                                <p class="text-lg font-black uppercase tracking-[0.2em]">Map is Empty</p>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if($categories->hasPages())
            <div class="p-6 md:p-10 border-t border-slate-50 dark:border-slate-800 bg-slate-50/30 dark:bg-slate-800/30">
                {{ $categories->links() }}
            </div>
        @endif
    </div>
</div>
@endsection
