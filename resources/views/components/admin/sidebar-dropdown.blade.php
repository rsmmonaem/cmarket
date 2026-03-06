@props(['icon', 'label', 'active' => false])

<div class="sidebar-dropdown" x-data="{ open: {{ $active ? 'true' : 'false' }} }">
    <button @click="open = !open" 
            class="flex items-center justify-between w-full px-4 py-3 text-slate-400 hover:text-white hover:bg-white/5 rounded-xl transition-all group {{ $active ? 'text-white' : '' }}">
        <div class="flex items-center gap-3">
            <span class="text-lg opacity-80 group-hover:opacity-100 group-hover:rotate-12 transition-transform">{{ $icon }}</span>
            <span class="font-black text-[11px] uppercase tracking-wider">{{ $label }}</span>
        </div>
        <span class="text-[9px] transition-transform duration-300 opacity-40 group-hover:opacity-100" :class="open ? 'rotate-180' : ''">▼</span>
    </button>
    
    <div x-show="open" 
         x-cloak
         x-collapse 
         class="pl-6 mt-1 space-y-1 overflow-hidden">
        <div class="border-l border-slate-800/50 ml-6 pl-4 space-y-1">
            {{ $slot }}
        </div>
    </div>
</div>
