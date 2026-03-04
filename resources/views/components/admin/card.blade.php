@props(['title' => null, 'footer' => null])

<div {{ $attributes->merge(['class' => 'card-solid']) }}>
    @if($title)
        <div class="mb-4 pb-4 border-b border-light flex items-center justify-between">
            <h3 class="text-lg font-bold text-light">{{ $title }}</h3>
        </div>
    @endif

    <div class="card-body">
        {{ $slot }}
    </div>

    @if($footer)
        <div class="mt-6 pt-4 border-t border-light text-sm text-muted-light">
            {{ $footer }}
        </div>
    @endif
</div>
