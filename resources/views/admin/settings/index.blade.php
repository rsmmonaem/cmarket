@extends('layouts.admin')

@section('title', 'System Variables - EcomMatrix')
@section('page-title', 'Core Protocol Configuration')

@section('content')
<div class="space-y-10 animate-fade-in">
    <!-- Macro Summary -->
    <div class="card-premium flex flex-col lg:flex-row justify-between items-center gap-8 relative overflow-hidden group">
        <div class="relative z-10 w-full lg:w-auto text-center lg:text-left">
            <h2 class="text-2xl md:text-3xl font-black text-slate-800 dark:text-white tracking-tight leading-none mb-3 md:mb-4">System Core Hub</h2>
            <p class="text-slate-400 dark:text-slate-500 font-bold text-[10px] uppercase tracking-[0.2em] ml-1">Configuring global operational parameters</p>
        </div>
        <!-- Decor -->
        <div class="absolute -right-10 -bottom-10 opacity-[0.03] text-[150px] md:text-[200px] leading-none select-none italic font-black group-hover:scale-110 transition-transform duration-1000 dark:text-white">CORE</div>
    </div>

    <form action="{{ route('admin.settings.update') }}" method="POST">
        @csrf
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-10">
            <!-- General Configuration -->
            <div class="card-premium space-y-8">
                <h3 class="text-xs font-black text-slate-800 dark:text-white uppercase tracking-[0.3em] flex items-center gap-3">
                    <span class="text-lg">⚙️</span> General Protocols
                </h3>
                
                <div class="space-y-6">
                    @foreach($settings as $setting)
                        @if($setting->type !== 'boolean')
                            <div class="space-y-2">
                                <label for="setting_{{ $setting->id }}" class="text-[10px] font-black text-slate-400 uppercase tracking-widest pl-1">{{ str_replace('_', ' ', $setting->key) }}</label>
                                <input type="{{ $setting->type === 'number' ? 'number' : 'text' }}" 
                                       name="settings[{{ $setting->key }}]" 
                                       id="setting_{{ $setting->id }}"
                                       value="{{ $setting->value }}"
                                       class="w-full px-5 py-4 bg-slate-50 dark:bg-slate-800 border border-slate-100 dark:border-slate-700 rounded-2xl text-sm font-bold text-slate-700 dark:text-slate-200 focus:ring-4 focus:ring-primary/10 focus:border-primary transition-all shadow-sm">
                            </div>
                        @endif
                    @endforeach
                </div>
            </div>

            <!-- Intelligent Toggles -->
            <div class="card-premium space-y-8">
                <h3 class="text-xs font-black text-slate-800 dark:text-white uppercase tracking-[0.3em] flex items-center gap-3">
                    <span class="text-lg">⚡</span> Logic Switches
                </h3>

                <div class="space-y-4 divide-y divide-slate-50 dark:divide-slate-800">
                    @foreach($settings as $setting)
                        @if($setting->type === 'boolean')
                            <div class="flex items-center justify-between py-6 group" x-data="{ active: {{ $setting->value ? 'true' : 'false' }} }">
                                <div class="space-y-1">
                                    <h4 class="text-sm font-black text-slate-800 dark:text-white uppercase group-hover:text-primary transition-colors">{{ str_replace('_', ' ', $setting->key) }}</h4>
                                    <p class="text-[9px] font-bold text-slate-400 uppercase tracking-tighter">Toggle operational state for this protocol</p>
                                </div>
                                <label class="relative inline-flex items-center cursor-pointer">
                                    <input type="checkbox" name="settings[{{ $setting->key }}]" class="sr-only peer" :checked="active" @change="active = !active">
                                    <div class="w-14 h-7 bg-slate-200 dark:bg-slate-800 peer-focus:outline-none rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-slate-300 after:border after:rounded-full after:h-6 after:w-6 after:transition-all peer-checked:bg-primary shadow-inner"></div>
                                </label>
                            </div>
                        @endif
                    @endforeach
                </div>

                <div class="pt-10">
                    <button type="submit" class="btn-matrix btn-primary-matrix w-full py-5 text-base">
                        Synchronize Global Variables 💾
                    </button>
                    <p class="text-center text-[9px] font-black text-slate-400 uppercase tracking-widest mt-6">Protocol synchronization requires administrative clearance</p>
                </div>
            </div>
        </div>
    </form>
</div>
@endsection
