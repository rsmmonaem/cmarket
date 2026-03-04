@props(['route', 'icon', 'label'])

@php
    $isActive = request()->routeIs($route) || (strpos($route, '.') !== false && request()->routeIs(explode('.', $route)[0] . '.*'));
@endphp

<a href="{{ route($route) }}" 
   class="sidebar-link {{ $isActive ? 'active' : '' }}">
    <span class="text-lg opacity-80">{{ $icon }}</span>
    <span class="font-bold text-sm">{{ $label }}</span>
</a>
