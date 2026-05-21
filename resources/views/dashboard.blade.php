<x-app-layout>
    <x-breadcrumbs :items="[['label' => __('messages.dashboard')]]" />
    <div class="mb-8">
        <h1 class="font-display text-h1 text-primary">{{ __('messages.dashboard') }}</h1>
        <p class="text-body text-secondary mt-1">{{ __('messages.welcome_back', ['name' => Auth::user()->name]) }}</p>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
        <div class="card group hover:-translate-y-0.5 hover:shadow-sm transition-all duration-300">
            <div class="flex items-start justify-between">
                <div>
                    <p class="font-label text-xs uppercase tracking-[0.08em] text-secondary mb-2">{{ __('messages.users') }}</p>
                    <p class="font-display text-display text-primary">1</p>
                </div>
                <span class="w-10 h-10 rounded-md bg-neutral flex items-center justify-center text-secondary/40 group-hover:bg-tertiary/5 group-hover:text-tertiary transition-colors duration-300">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"/>
                    </svg>
                </span>
            </div>
        </div>

        <div class="card group hover:-translate-y-0.5 hover:shadow-sm transition-all duration-300">
            <div class="flex items-start justify-between">
                <div>
                    <p class="font-label text-xs uppercase tracking-[0.08em] text-secondary mb-2">{{ __('messages.sessions') }}</p>
                    <p class="font-display text-display text-primary">—</p>
                </div>
                <span class="w-10 h-10 rounded-md bg-neutral flex items-center justify-center text-secondary/40 group-hover:bg-tertiary/5 group-hover:text-tertiary transition-colors duration-300">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"/>
                    </svg>
                </span>
            </div>
        </div>

        <div class="card group hover:-translate-y-0.5 hover:shadow-sm transition-all duration-300">
            <div class="flex items-start justify-between">
                <div>
                    <p class="font-label text-xs uppercase tracking-[0.08em] text-secondary mb-2">{{ __('messages.products') }}</p>
                    <p class="font-display text-display text-primary">{{ \App\Models\Product::count() }}</p>
                </div>
                <span class="w-10 h-10 rounded-md bg-neutral flex items-center justify-center text-secondary/40 group-hover:bg-tertiary/5 group-hover:text-tertiary transition-colors duration-300">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"/>
                    </svg>
                </span>
            </div>
        </div>

        <div class="card group hover:-translate-y-0.5 hover:shadow-sm transition-all duration-300">
            <div class="flex items-start justify-between">
                <div>
                    <p class="font-label text-xs uppercase tracking-[0.08em] text-secondary mb-2">{{ __('messages.categories') }}</p>
                    <p class="font-display text-display text-primary">{{ \App\Models\Category::count() }}</p>
                </div>
                <span class="w-10 h-10 rounded-md bg-neutral flex items-center justify-center text-secondary/40 group-hover:bg-tertiary/5 group-hover:text-tertiary transition-colors duration-300">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M4 6h16M4 10h16M4 14h16M4 18h16"/>
                    </svg>
                </span>
            </div>
        </div>
    </div>

    <div class="card hover:-translate-y-0.5 hover:shadow-sm transition-all duration-300">
        <div class="flex items-center gap-3 mb-4">
            <span class="w-8 h-8 rounded-md bg-tertiary/5 flex items-center justify-center text-tertiary">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                </svg>
            </span>
            <h2 class="font-display text-lg text-primary">{{ __('messages.getting_started') }}</h2>
        </div>
        <p class="text-body text-secondary leading-relaxed">
            {{ __('messages.getting_started_desc', ['path' => '/resources/views']) }}
        </p>
        <div class="mt-6 pt-6 border-t border-secondary/10 flex items-center gap-4">
            <a href="{{ route('profile.edit') }}" class="btn-primary text-xs">
                {{ __('messages.profile') }}
            </a>
            <a href="{{ route('categories.index') }}" class="btn-secondary">
                {{ __('messages.categories') }}
            </a>
            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit" class="text-sm text-secondary hover:text-primary transition-colors font-body">
                    {{ __('messages.logout') }}
                </button>
            </form>
        </div>
    </div>
</x-app-layout>