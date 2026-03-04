@props(['type' => 'info'])

@php
    $types = [
        'info' => 'bg-blue-50 text-blue-800 border-blue-200 dark:bg-blue-900/20 dark:text-blue-300 dark:border-blue-800',
        'success' => 'bg-green-50 text-green-800 border-green-200 dark:bg-green-900/20 dark:text-green-300 dark:border-green-800',
        'warning' => 'bg-yellow-50 text-yellow-800 border-yellow-200 dark:bg-yellow-900/20 dark:text-yellow-300 dark:border-yellow-800',
        'danger' => 'bg-red-50 text-red-800 border-red-200 dark:bg-red-900/20 dark:text-red-300 dark:border-red-800',
    ];
    $class = $types[$type] ?? $types['info'];
@endphp

<div {{ $attributes->merge(['class' => 'p-4 rounded-xl border ' . $class]) }} role="alert">
    <div class="flex">
        <div class="flex-shrink-0">
            @if($type === 'success')
                ✅
            @elseif($type === 'danger')
                ❌
            @elseif($type === 'warning')
                ⚠️
            @else
                ℹ️
            @endif
        </div>
        <div class="ml-3">
            <p class="text-sm font-medium">
                {{ $slot }}
            </p>
        </div>
    </div>
</div>
