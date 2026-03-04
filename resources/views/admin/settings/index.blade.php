@extends('layouts.admin')

@section('title', 'System Core - CMarket')
@section('page-title', 'Global Configurations')

@section('content')
<div class="space-y-12 animate-fade-in max-w-6xl mx-auto">
    <!-- Macro Summary -->
    <div class="bg-slate-900 dark:bg-slate-900 rounded-[2.5rem] md:rounded-[3rem] p-8 md:p-12 lg:p-14 text-white shadow-2xl shadow-slate-900/10 relative overflow-hidden group">
        <div class="relative z-10 lg:w-2/3">
            <h2 class="text-3xl md:text-4xl font-black mb-4 md:mb-6 tracking-tight">System Global Variables</h2>
            <p class="text-slate-400 font-medium leading-relaxed text-sm md:text-base">Modify the fundamental logic of the ecosystem. Adjust commission distributions, payment thresholds, and operational parameters from this central terminal.</p>
        </div>
        <!-- Background Asset -->
        <div class="absolute -right-10 -bottom-10 opacity-5 text-[200px] md:text-[300px] leading-none select-none italic font-black group-hover:scale-110 transition-transform duration-1000">CONFIG</div>
    </div>

    <form action="{{ route('admin.settings.update') }}" method="POST" id="settingsForm">
        @csrf
        
        <div class="space-y-12 md:space-y-16">
            @foreach($settings as $group => $items)
                <div class="space-y-6 md:space-y-8">
                    <div class="flex items-center gap-4 pl-4 border-l-4 border-l-sky-500">
                        <span class="text-2xl">
                            @if($group == 'commission') 💰 @elseif($group == 'payment') 💳 @else ⚙️ @endif
                        </span>
                        <div>
                            <h3 class="text-sm font-black text-slate-800 dark:text-white uppercase tracking-[0.2em]">{{ $group }} Protocol</h3>
                            <p class="text-[9px] font-bold text-slate-400 dark:text-slate-500 uppercase tracking-widest mt-1">Operational Constants</p>
                        </div>
                    </div>
                    
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6 md:gap-8">
                        @foreach($items as $setting)
                            <div class="bg-white dark:bg-slate-900 rounded-[2.5rem] p-6 md:p-8 border border-slate-100 dark:border-slate-800 shadow-sm hover:shadow-xl transition-all duration-500 group">
                                <div class="flex items-start justify-between gap-6 mb-6">
                                    <div class="flex-1">
                                        <label for="{{ $setting->key }}" class="block text-xs font-black text-slate-800 dark:text-white uppercase tracking-widest mb-2">
                                            {{ ucwords(str_replace('_', ' ', $setting->key)) }}
                                        </label>
                                        <p class="text-[10px] text-slate-400 dark:text-slate-500 leading-relaxed font-bold uppercase tracking-tighter">
                                            {{ $setting->description }}
                                        </p>
                                    </div>
                                    <div class="w-10 h-10 rounded-xl bg-slate-50 dark:bg-slate-800 flex items-center justify-center opacity-0 group-hover:opacity-100 transition-opacity">⚡</div>
                                </div>
                                
                                <div class="relative">
                                    <input type="text" 
                                           name="{{ $setting->key }}" 
                                           id="{{ $setting->key }}" 
                                           value="{{ $setting->value }}"
                                           placeholder="Value..."
                                           class="w-full bg-slate-50 dark:bg-slate-800 border-none rounded-2xl px-6 py-4 text-sm font-black text-slate-800 dark:text-white focus:ring-2 focus:ring-sky-500/20 transition-all placeholder:text-slate-300 dark:placeholder:text-slate-600"
                                    >
                                    @if($setting->type == 'float' || $setting->type == 'decimal')
                                        <span class="absolute right-6 top-1/2 -translate-y-1/2 text-slate-300 dark:text-slate-600 font-black text-[9px] uppercase">% Vector</span>
                                    @endif
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            @endforeach
        </div>

        <div class="sticky bottom-10 flex justify-center pt-20">
            <button type="submit" class="px-8 md:px-12 py-5 md:py-6 bg-slate-900 dark:bg-sky-600 text-white rounded-[2rem] font-black text-[10px] md:text-xs uppercase tracking-[0.4em] shadow-2xl shadow-slate-900/40 hover:bg-emerald-600 dark:hover:bg-emerald-500 hover:scale-[1.05] transition-all duration-500 flex items-center gap-4">
                <span>💾</span> Apply Global Update
            </button>
        </div>
    </form>
</div>
@endsection
