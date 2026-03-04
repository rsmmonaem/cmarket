@props(['route', 'icon', 'label'])

<a href="{{ route($route) }}" 
    class="sidebar-link px-4 py-3.5 rounded-2xl flex items-center gap-4 font-bold text-sm tracking-tight transition-all duration-300 group {{ request()->routeIs($route) ? 'active bg-sky-500/10 text-sky-500 border-l-4 border-sky-500 shadow-[4px_0_20px_rgba(59,130,246,0.1)]' : 'text-slate-400 hover:text-white hover:bg-white/[0.03] hover:translate-x-1' }}">
    <span class="text-xl opacity-80 group-hover:scale-125 group-hover:rotate-6 transition-transform duration-300">{{ $icon }}</span>
    <span class="group-hover:tracking-wider transition-all duration-300">{{ $label }}</span>
</a>
