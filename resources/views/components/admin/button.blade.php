@props(['variant' => 'primary'])

@php
    $variants = [
        'primary' => 'bg-slate-900 text-white hover:bg-slate-800 dark:bg-sky-500 dark:hover:bg-sky-400',
        'secondary' => 'bg-slate-200 text-slate-800 hover:bg-slate-300 dark:bg-slate-700 dark:text-slate-200',
        'danger' => 'bg-red-600 text-white hover:bg-red-700',
        'success' => 'bg-emerald-600 text-white hover:bg-emerald-700',
    ];
    $variantClass = $variants[$variant] ?? $variants['primary'];
@endphp

<button {{ $attributes->merge(['class' => 'px-4 py-2 rounded-xl font-bold transition-all transform active:scale-95 flex items-center gap-2 ' . $variantClass]) }}>
    {{ $slot }}
</button>
