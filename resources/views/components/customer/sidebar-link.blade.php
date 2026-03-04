@props(['route', 'icon', 'label'])

<a href="{{ route($route) }}" 
   class="sidebar-link px-4 py-3 rounded-xl flex items-center gap-4 font-bold text-sm tracking-tight transition-all duration-200 {{ request()->routeIs($route) ? 'active bg-sky-500/10 text-sky-500 border-l-4 border-sky-500 shadow-[4px_0_15px_rgba(59,130,246,0.1)]' : 'text-slate-400 hover:text-white hover:bg-white/5' }}">
    <span class="text-lg opacity-80 group-hover:scale-110 transition-transform">{{ $icon }}</span>
    <span>{{ $label }}</span>
</a>
