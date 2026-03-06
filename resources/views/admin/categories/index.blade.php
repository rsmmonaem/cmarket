@extends('layouts.admin')

@section('title', 'Category Logic - EcomMatrix')
@section('page-title', 'Taxonomy Architecture')

@section('content')
<div class="space-y-10 animate-fade-in">
    <!-- Macro Summary & Action -->
    <div class="card-premium flex flex-col lg:flex-row justify-between items-center gap-8 md:gap-10 relative overflow-hidden group">
        <div class="relative z-10 w-full lg:w-auto text-center lg:text-left">
            <h2 class="text-2xl md:text-3xl font-black text-slate-800 dark:text-white tracking-tight leading-none mb-3 md:mb-4">Taxonomy Engine</h2>
            <p class="text-slate-400 dark:text-slate-500 font-bold text-[10px] uppercase tracking-[0.2em] ml-1">Organizing platform logic into {{ $categories->total() }} operational nodes</p>
        </div>
        <div class="flex items-center gap-4 relative z-10 w-full lg:w-auto">
            <a href="{{ route('admin.categories.create') }}" class="btn-matrix btn-primary-matrix w-full lg:w-auto">
                <span class="text-lg">➕</span> Deploy New Node
            </a>
        </div>
        <!-- Decor -->
        <div class="absolute -right-10 -bottom-10 opacity-[0.03] text-[150px] md:text-[200px] leading-none select-none italic font-black group-hover:scale-110 transition-transform duration-1000 dark:text-white">MAP</div>
    </div>

    <!-- Data Infrastructure Table -->
    <div class="card-premium !p-0 overflow-hidden">
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
                                <div x-data="{ active: {{ $category->is_active ? 'true' : 'false' }}, loading: false }">
                                    <button 
                                        @click="
                                            if(loading) return;
                                            loading = true;
                                            fetch('{{ route('admin.categories.toggle-status', $category) }}', {
                                                method: 'PATCH',
                                                headers: {
                                                    'X-CSRF-TOKEN': '{{ csrf_token() }}',
                                                    'Content-Type': 'application/json',
                                                    'Accept': 'application/json'
                                                }
                                            })
                                            .then(response => response.json())
                                            .then(data => {
                                                if(data.success) {
                                                    active = data.is_active;
                                                    Toast.fire({ icon: 'success', title: data.message });
                                                }
                                            })
                                            .finally(() => loading = false);
                                        "
                                        :class="active ? 'bg-primary' : 'bg-slate-700'"
                                        class="relative inline-flex h-5 w-10 shrink-0 cursor-pointer rounded-full border-2 border-transparent transition-colors duration-200 ease-in-out focus:outline-none shadow-inner"
                                    >
                                        <span :class="active ? 'translate-x-[20px]' : 'translate-x-0'"
                                              class="pointer-events-none inline-block h-4 w-4 transform rounded-full bg-white shadow ring-0 transition duration-200 ease-in-out"></span>
                                        <div x-show="loading" class="absolute inset-0 flex items-center justify-center bg-white/20 rounded-full">
                                            <svg class="animate-spin h-3 w-3 text-white" viewBox="0 0 24 24">
                                                <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                                                <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                                            </svg>
                                        </div>
                                    </button>
                                </div>
                            </td>
                            <td class="px-10 py-8 text-right">
                                <div class="flex justify-end opacity-0 group-hover:opacity-100 transition-all translate-x-4 group-hover:translate-x-0 duration-300 gap-3">
                                    <a href="{{ route('admin.categories.edit', $category) }}" class="w-10 h-10 rounded-xl bg-slate-900 dark:bg-slate-800 text-white flex items-center justify-center text-lg hover:bg-primary transition-all shadow-xl shadow-slate-900/10">
                                        ✏️
                                    </a>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="px-10 py-32 text-center text-slate-300 flex flex-col items-center">
                                <span class="text-8xl mb-6 opacity-10">🗺️</span>
                                <p class="text-lg font-black uppercase tracking-[0.2em]">Matrix is Empty</p>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if($categories->hasPages())
            <div class="px-10 py-6 border-t border-slate-50 dark:border-slate-800 bg-slate-50/30 dark:bg-slate-800/30">
                {{ $categories->links() }}
            </div>
        @endif
    </div>
</div>
@endsection
