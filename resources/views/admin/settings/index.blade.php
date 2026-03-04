@extends('layouts.admin')

@section('title', 'System Settings')
@section('page-title', 'Global Configurations')

@section('content')
<div class="max-w-4xl mx-auto">
    @if(session('success'))
        <div class="bg-emerald-500/10 border border-emerald-500/20 text-emerald-400 p-4 rounded-2xl mb-6 flex items-center gap-3">
            <span>✅</span>
            <p class="font-medium">{{ session('success') }}</p>
        </div>
    @endif

    <form action="{{ route('admin.settings.update') }}" method="POST">
        @csrf
        
        @foreach($settings as $group => $items)
            <div class="mb-10">
                <h2 class="text-lg font-black text-light uppercase tracking-widest mb-4 flex items-center gap-2">
                    <span class="w-8 h-8 rounded-lg bg-slate-800 flex items-center justify-center text-sm">
                        @if($group == 'commission') 💰 @elseif($group == 'payment') 💳 @else ⚙️ @endif
                    </span>
                    {{ ucfirst($group) }} Settings
                </h2>
                
                <div class="grid grid-cols-1 gap-4">
                    @foreach($items as $setting)
                        <x-admin.card class="hover:border-slate-700 transition-all group">
                            <div class="flex flex-col md:flex-row md:items-center justify-between gap-4">
                                <div class="flex-1">
                                    <label for="{{ $setting->key }}" class="block text-sm font-bold text-light mb-1">
                                        {{ ucwords(str_replace('_', ' ', $setting->key)) }}
                                    </label>
                                    <p class="text-xs text-muted-light leading-relaxed max-w-md">
                                        {{ $setting->description }}
                                    </p>
                                </div>
                                <div class="w-full md:w-48">
                                    <div class="relative">
                                        <input type="text" 
                                               name="{{ $setting->key }}" 
                                               id="{{ $setting->key }}" 
                                               value="{{ $setting->value }}"
                                               class="w-full bg-slate-800 border-2 border-slate-700 rounded-xl px-4 py-2.5 text-light font-black focus:border-sky-500 focus:outline-none transition-colors"
                                        >
                                        @if($setting->type == 'float' || $setting->type == 'decimal')
                                            <span class="absolute right-4 top-1/2 -translate-y-1/2 text-muted-light font-bold">%</span>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </x-admin.card>
                    @endforeach
                </div>
            </div>
        @endforeach

        <div class="flex justify-end sticky bottom-6 z-10">
            <button type="submit" class="bg-sky-500 hover:bg-sky-400 text-white font-black px-10 py-4 rounded-2xl shadow-xl shadow-sky-500/20 transition-all hover:scale-105 flex items-center gap-3">
                <span>💾</span>
                Save Changes
            </button>
        </div>
    </form>
</div>
@endsection
