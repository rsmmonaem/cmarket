@props(['route', 'icon', 'label', 'params' => []])

@php
    $routeName = is_string($route) ? $route : '#';
    $generatedUrl = $routeName !== '#' ? route($routeName, $params) : '#';
    
    // Exact match for parameters if present, otherwise base URL match
    if (!empty($params)) {
        $isActive = request()->fullUrl() === $generatedUrl;
    } else {
        // If no params, ensure the current full URL doesn't have extra params that shouldn't belong here
        $isActive = request()->url() === $generatedUrl && empty(request()->query());
    }
@endphp

<a href="{{ $generatedUrl }}" 
   class="flex items-center justify-between group px-4 py-3 rounded-xl transition-all duration-300 {{ $isActive ? 'bg-primary text-white shadow-xl shadow-primary/30 active-node' : 'text-slate-400 hover:text-white hover:bg-white/5' }}">
    <div class="flex items-center gap-3">
        @if(isset($icon))
            <span class="text-lg opacity-80 group-hover:opacity-100 group-hover:scale-110 transition-transform">{{ $icon }}</span>
        @endif
        <span class="font-black text-[11px] uppercase tracking-wider">{{ $label }}</span>
    </div>
    @if($isActive)
        <div class="w-1.5 h-1.5 rounded-full bg-white shadow-sm"></div>
    @endif
</a>
