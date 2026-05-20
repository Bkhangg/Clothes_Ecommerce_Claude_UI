@props(['position' => 'bottom'])

<div x-data="{ open: false }" @click.outside="open = false" class="relative">
    <button @click="open = ! open"
            class="flex items-center gap-1.5 text-secondary/60 hover:text-primary transition-colors {{ $attributes->get('class') }}"
            :class="open ? 'text-primary' : ''"
            aria-label="{{ __('messages.language') }}">
        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 2a10 10 0 110 20 10 10 0 010-20z M2 12h20 M12 2a15.3 15.3 0 014 10 15.3 15.3 0 01-4 10 15.3 15.3 0 01-4-10 15.3 15.3 0 014-10z"/>
        </svg>
        <span class="font-label text-xs uppercase tracking-[0.08em]">{{ app()->getLocale() }}</span>
    </button>

    <div x-show="open" x-cloak
         @click="open = false"
         x-transition:enter="transition ease-out duration-150"
         x-transition:enter-start="opacity-0 scale-95 -translate-y-1"
         x-transition:enter-end="opacity-100 scale-100 translate-y-0"
         x-transition:leave="transition ease-in duration-100"
         x-transition:leave-start="opacity-100 scale-100"
         x-transition:leave-end="opacity-0 scale-95"
         class="absolute {{ $position === 'top' ? 'bottom-full mb-1.5' : 'top-full mt-1.5' }} right-0 w-40 py-1.5 bg-surface rounded-md border border-secondary/10 shadow-lg z-50">
        <a href="{{ route('language.switch', 'en') }}"
           class="flex items-center gap-2.5 px-3.5 py-2 text-sm {{ app()->getLocale() === 'en' ? 'text-primary bg-neutral font-medium' : 'text-secondary hover:text-primary hover:bg-neutral' }} transition-colors">
            <span class="text-base leading-none">🇬🇧</span>
            <span>English</span>
            @if (app()->getLocale() === 'en')
                <svg class="w-3.5 h-3.5 ml-auto text-tertiary" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"/>
                </svg>
            @endif
        </a>
        <a href="{{ route('language.switch', 'vi') }}"
           class="flex items-center gap-2.5 px-3.5 py-2 text-sm {{ app()->getLocale() === 'vi' ? 'text-primary bg-neutral font-medium' : 'text-secondary hover:text-primary hover:bg-neutral' }} transition-colors">
            <span class="text-base leading-none">🇻🇳</span>
            <span>Tiếng Việt</span>
            @if (app()->getLocale() === 'vi')
                <svg class="w-3.5 h-3.5 ml-auto text-tertiary" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"/>
                </svg>
            @endif
        </a>
    </div>
</div>