@props(['route', 'icon', 'label', 'params' => []])

@php
    $routeName = is_string($route) ? $route : '#';
    $generatedUrl = $routeName !== '#' ? route($routeName, $params) : '#';
    
    // Exact match for parameters if present, otherwise base URL match
    if (!empty($params)) {
        $isActive = request()->fullUrl() === $generatedUrl;
    } else {
        $isActive = request()->url() === $generatedUrl && empty(request()->query());
    }
@endphp

<a href="{{ $generatedUrl }}" 
   class="flex items-center gap-3 px-6 py-2.5 transition-all duration-200 group {{ $isActive ? 'text-white bg-slate-800/50 border-r-4 border-primary' : 'text-slate-400 hover:text-slate-200 hover:bg-slate-800/30' }}">
    @if(isset($icon))
        <span class="text-lg opacity-70 group-hover:opacity-100 transition-opacity">{{ $icon }}</span>
    @endif
    <span class="text-[13px] font-semibold tracking-tight">{{ $label }}</span>
</a>
