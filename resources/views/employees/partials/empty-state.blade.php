@php
    $isSearching = request('search') || request('status');
@endphp

<div class="flex flex-col items-center justify-center py-16 px-6 text-center">
    <svg class="w-20 h-20 text-secondary/20 mb-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"/>
    </svg>

    @if ($isSearching)
        <h3 class="font-display text-xl text-primary mb-2">{{ __('messages.empty_search_title') }}</h3>
        <p class="text-sm text-secondary max-w-xs mb-6">{{ __('messages.empty_search_desc') }}</p>
        <a href="{{ route('employees.index') }}" class="btn-primary">
            {{ __('messages.clear') }}
        </a>
    @else
        <h3 class="font-display text-xl text-primary mb-2">{{ __('messages.empty_employees_title') }}</h3>
        <p class="text-sm text-secondary max-w-xs mb-6">{{ __('messages.empty_employees_desc') }}</p>
        <a href="{{ route('employees.create') }}" class="btn-primary">
            {{ __('messages.add_employee') }}
        </a>
    @endif
</div>
