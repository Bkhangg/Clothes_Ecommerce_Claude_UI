@php
    $isSearching = request('search') || request('status');
@endphp

<div class="flex flex-col items-center justify-center py-16 px-6 text-center">
    <svg class="w-20 h-20 text-secondary/20 mb-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"/>
    </svg>

    @if ($isSearching)
        <h3 class="font-display text-xl text-primary mb-2">{{ __('messages.empty_search_title') }}</h3>
        <p class="text-sm text-secondary max-w-xs mb-6">{{ __('messages.empty_search_desc') }}</p>
        <a href="{{ route('categories.index') }}" class="btn-primary">
            {{ __('messages.clear') }}
        </a>
    @else
        <h3 class="font-display text-xl text-primary mb-2">{{ __('messages.empty_categories_title') }}</h3>
        <p class="text-sm text-secondary max-w-xs mb-6">{{ __('messages.empty_categories_desc') }}</p>
        <a href="{{ route('categories.create') }}" class="btn-primary">
            {{ __('messages.add_category') }}
        </a>
    @endif
</div>