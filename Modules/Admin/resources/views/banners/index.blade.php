@extends('layouts.admin')

@section('title', 'Banners - C-Market')
@section('page-title', 'Create Coupon')

@section('content')
<div class="space-y-10 animate-fade-in">
    <!-- Summary & Action -->
    <div class="card-premium flex flex-col lg:flex-row justify-between items-center gap-8 md:gap-10 relative overflow-hidden group">
        <div class="relative z-10 w-full lg:w-auto text-center lg:text-left">
            <h2 class="text-2xl md:text-3xl font-black text-slate-800 dark:text-white tracking-tight leading-none mb-3 md:mb-4">Banner Engine</h2>
            <p class="text-slate-400 dark:text-slate-500 font-bold text-[10px] uppercase tracking-[0.2em] ml-1">Managing {{ $banners->total() }} promotional items</p>
        </div>
        <div class="flex items-center gap-4 relative z-10 w-full lg:w-auto">
            <a href="{{ route('admin.banners.create') }}" class="btn-matrix btn-primary-matrix w-full lg:w-auto">
                <span class="text-lg">➕</span> Deploy New Banner
            </a>
        </div>
        <!-- Decor -->
        <div class="absolute -right-10 -bottom-10 opacity-[0.03] text-[150px] md:text-[200px] leading-none select-none italic font-black group-hover:scale-110 transition-transform duration-1000 dark:text-white">PROMO</div>
    </div>

    <!-- Data Table -->
    <div class="card-premium !p-0 overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse min-w-[900px]">
                <thead>
                    <tr class="bg-slate-50/50 dark:bg-slate-800/50">
                        <th class="px-10 py-6 text-[10px] font-black uppercase tracking-[0.2em] text-slate-400 dark:text-slate-500">Banner Asset</th>
                        <th class="px-10 py-6 text-[10px] font-black uppercase tracking-[0.2em] text-slate-400 dark:text-slate-500">Position</th>
                        <th class="px-10 py-6 text-[10px] font-black uppercase tracking-[0.2em] text-slate-400 dark:text-slate-500 text-center">Order</th>
                        <th class="px-10 py-6 text-[10px] font-black uppercase tracking-[0.2em] text-slate-400 dark:text-slate-500 text-center">Status</th>
                        <th class="px-10 py-6 text-[10px] font-black uppercase tracking-[0.2em] text-slate-400 dark:text-slate-500 text-right">Operations</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-50 dark:divide-slate-800">
                    @forelse($banners as $banner)
                        <tr class="group hover:bg-slate-50/80 dark:hover:bg-slate-800/50 transition-all duration-300">
                            <td class="px-10 py-8">
                                <div class="flex items-center gap-6">
                                    <div class="w-24 h-12 rounded-xl bg-slate-100 dark:bg-slate-800 border border-slate-100 dark:border-slate-700 flex items-center justify-center text-xl shadow-lg group-hover:scale-105 transition-transform overflow-hidden font-black">
                                        <img src="{{ asset('storage/' . $banner->image) }}" class="w-full h-full object-cover">
                                    </div>
                                    <div>
                                        <div class="text-sm font-black text-slate-800 dark:text-white mb-1">{{ $banner->title ?? 'Untitled Asset' }}</div>
                                        <div class="text-[9px] text-slate-400 dark:text-slate-500 font-black uppercase tracking-widest truncate max-w-[200px]">{{ $banner->link ?? 'No Link' }}</div>
                                    </div>
                                </div>
                            </td>
                            <td class="px-10 py-8">
                                <span class="text-[10px] font-black text-slate-600 dark:text-slate-400 uppercase tracking-widest bg-slate-50 dark:bg-slate-800 border border-slate-100 dark:border-slate-700 px-3 py-1.5 rounded-lg">
                                    {{ str_replace('_', ' ', $banner->position) }}
                                </span>
                            </td>
                            <td class="px-10 py-8 text-center text-sm font-black text-slate-800 dark:text-white">
                                {{ $banner->sort_order }}
                            </td>
                            <td class="px-10 py-8 text-center">
                                <div x-data="{ active: {{ $banner->is_active ? 'true' : 'false' }}, loading: false }">
                                    <button 
                                        @click="
                                            if(loading) return;
                                            loading = true;
                                            fetch('{{ route('admin.banners.toggle-status', $banner) }}', {
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
                                    <a href="{{ route('admin.banners.edit', $banner) }}" class="w-10 h-10 rounded-xl bg-slate-900 dark:bg-slate-800 text-white flex items-center justify-center text-lg hover:bg-primary transition-all shadow-xl shadow-slate-900/10">
                                        ✏️
                                    </a>
                                    <form action="{{ route('admin.banners.destroy', $banner) }}" method="POST" onsubmit="return confirm('Terminate this asset?');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="w-10 h-10 rounded-xl bg-rose-500 text-white flex items-center justify-center text-lg hover:bg-rose-600 transition-all shadow-xl shadow-rose-900/10">
                                            🗑️
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="px-10 py-32 text-center text-slate-300 flex flex-col items-center">
                                <span class="text-8xl mb-6 opacity-10">🖼️</span>
                                <p class="text-lg font-black uppercase tracking-[0.2em]">No Promotional Assets</p>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if($banners->hasPages())
            <div class="px-10 py-6 border-t border-slate-50 dark:border-slate-800 bg-slate-50/30 dark:bg-slate-800/30">
                {{ $banners->links() }}
            </div>
        @endif
    </div>
</div>
@endsection
