@props(['icon', 'label', 'active' => false])

<div class="sidebar-dropdown" x-data="{ open: {{ $active ? 'true' : 'false' }} }">
    <button @click="open = !open" 
            class="flex items-center justify-between w-full px-6 py-2.5 text-slate-400 hover:text-slate-200 hover:bg-slate-800/30 transition-all group {{ $active ? 'text-slate-200' : '' }}">
        <div class="flex items-center gap-3">
            <span class="text-lg opacity-70 group-hover:opacity-100 transition-opacity">{{ $icon }}</span>
            <span class="text-[13px] font-semibold tracking-tight">{{ $label }}</span>
        </div>
        <span class="text-[10px] transition-transform duration-300 opacity-40 group-hover:opacity-100" :class="open ? 'rotate-180' : ''">▼</span>
    </button>
    
    <div x-show="open" 
         x-cloak
         x-collapse 
         class="bg-slate-900/40">
        <div class="py-1">
            {{ $slot }}
        </div>
    </div>
</div>
