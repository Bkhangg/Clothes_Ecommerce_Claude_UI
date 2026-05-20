@props(['active', 'href'])

@php
$isActive = $active ?? false;
$classes = $isActive
    ? 'flex items-center gap-3 px-3 py-2 rounded-sm text-sm font-body text-primary bg-neutral border-l-2 border-tertiary -ml-[1px]'
    : 'flex items-center gap-3 px-3 py-2 rounded-sm text-sm font-body text-secondary hover:text-primary hover:bg-neutral transition-colors';
@endphp

<a href="{{ $href }}" {{ $attributes->merge(['class' => $classes]) }}>
    {{ $slot }}
</a>