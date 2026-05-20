@props(['text' => '', 'position' => 'top'])

@php
$positionClasses = [
    'top' => 'bottom-full left-1/2 -translate-x-1/2 mb-2',
    'bottom' => 'top-full left-1/2 -translate-x-1/2 mt-2',
    'left' => 'right-full top-1/2 -translate-y-1/2 mr-2',
    'right' => 'left-full top-1/2 -translate-y-1/2 ml-2',
][$position];

$arrowClasses = [
    'top' => 'top-full left-1/2 -translate-x-1/2 border-l-4 border-r-4 border-t-4 border-transparent border-t-primary',
    'bottom' => 'bottom-full left-1/2 -translate-x-1/2 border-l-4 border-r-4 border-b-4 border-transparent border-b-primary',
    'left' => 'left-full top-1/2 -translate-y-1/2 border-t-4 border-b-4 border-l-4 border-transparent border-l-primary',
    'right' => 'right-full top-1/2 -translate-y-1/2 border-t-4 border-b-4 border-r-4 border-transparent border-r-primary',
][$position];
@endphp

<div x-data="{ show: false }" class="relative inline-flex">
    <div @mouseenter="show = true" @mouseleave="show = false" @focusin="show = true" @focusout="show = false">
        {{ $slot }}
    </div>
    <div x-show="show" x-cloak
         x-transition:enter="transition ease-out duration-150"
         x-transition:enter-start="opacity-0 scale-95"
         x-transition:enter-end="opacity-100 scale-100"
         x-transition:leave="transition ease-in duration-100"
         x-transition:leave-start="opacity-100 scale-100"
         x-transition:leave-end="opacity-0 scale-95"
         class="absolute {{ $positionClasses }} z-50 px-2 py-1 text-xs font-label uppercase tracking-[0.08em] text-surface bg-primary rounded-sm whitespace-nowrap pointer-events-none">
        {{ $text }}
        <span class="absolute {{ $arrowClasses }}"></span>
    </div>
</div>