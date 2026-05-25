<div x-data="{ open: false }">
    {{-- Mobile overlay --}}
    <div x-show="open" @click="open = false"
         class="fixed inset-0 z-30 bg-primary/60 backdrop-blur-sm sm:hidden"
         x-transition:enter="ease-out duration-300"
         x-transition:enter-start="opacity-0"
         x-transition:enter-end="opacity-100"
         x-transition:leave="ease-in duration-200"
         x-transition:leave-start="opacity-100"
         x-transition:leave-end="opacity-0"></div>

    {{-- Sidebar --}}
    <nav class="fixed inset-y-0 left-0 z-40 w-60 bg-surface border-r border-secondary/10 flex flex-col
                transition-all duration-300 ease-out sm:translate-x-0"
         :class="open ? 'translate-x-0 shadow-xl' : '-translate-x-full'">

        {{-- Brand --}}
        <div class="h-14 flex items-center px-6 border-b border-secondary/10 shrink-0">
            <a href="{{ route('dashboard') }}" class="font-display text-lg text-primary no-underline select-none">
                {{ __('messages.brand') }}
            </a>
        </div>

        {{-- Navigation --}}
        <div class="flex-1 py-4 px-3 space-y-0.5">
            <x-nav-link href="{{ route('dashboard') }}" :active="request()->routeIs('dashboard')">
                <svg class="w-5 h-5 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/>
                </svg>
                <span>{{ __('messages.dashboard') }}</span>
            </x-nav-link>

            <x-nav-link href="{{ route('products.index') }}" :active="request()->routeIs('products.*')">
                <svg class="w-5 h-5 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"/>
                </svg>
                <span class="flex-1">{{ __('messages.products') }}</span>
                <span class="px-2 py-0.5 text-[10px] font-label uppercase tracking-[0.08em] rounded-full bg-neutral text-secondary/60">{{ \App\Models\Product::count() }}</span>
            </x-nav-link>

            <x-nav-link href="{{ route('employees.index') }}" :active="request()->routeIs('employees.*')">
                <svg class="w-5 h-5 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"/>
                </svg>
                <span class="flex-1">{{ __('messages.employees') }}</span>
                <span class="px-2 py-0.5 text-[10px] font-label uppercase tracking-[0.08em] rounded-full bg-neutral text-secondary/60">{{ \App\Models\User::where('role', 'employee')->count() }}</span>
            </x-nav-link>

            <x-nav-link href="{{ route('categories.index') }}" :active="request()->routeIs('categories.*')">
                <svg class="w-5 h-5 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M4 6h16M4 10h16M4 14h16M4 18h16"/>
                </svg>
                <span class="flex-1">{{ __('messages.categories') }}</span>
                <span class="px-2 py-0.5 text-[10px] font-label uppercase tracking-[0.08em] rounded-full bg-neutral text-secondary/60">{{ \App\Models\Category::count() }}</span>
            </x-nav-link>
        </div>

        {{-- Profile + Language + Logout --}}
        <div class="border-t border-secondary/10 py-3 px-3 space-y-2 shrink-0">
            <a href="{{ route('profile.edit') }}" class="flex items-center gap-3 px-3 py-2 rounded-sm text-sm text-secondary hover:text-primary hover:bg-neutral transition-colors group">
                <span class="w-8 h-8 rounded-full bg-primary/5 text-primary flex items-center justify-center text-xs font-label shrink-0 group-hover:bg-primary/10 transition-colors">
                    {{ substr(Auth::user()->name, 0, 1) }}
                </span>
                <div class="min-w-0">
                    <div class="text-sm text-primary truncate">{{ Auth::user()->name }}</div>
                    <div class="text-[11px] text-secondary truncate">{{ Auth::user()->email }}</div>
                </div>
            </a>

            <div class="px-3">
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit" class="w-full flex items-center gap-2.5 px-3 py-2.5 rounded-sm text-sm text-secondary/60 hover:text-tertiary hover:bg-neutral transition-colors" title="{{ __('messages.logout') }}">
                        <svg class="w-4 h-4 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"/>
                        </svg>
                        <span>{{ __('messages.logout') }}</span>
                    </button>
                </form>
            </div>
        </div>
    </nav>

    {{-- Top bar --}}
    <div class="fixed top-0 left-0 right-0 sm:left-60 bg-surface/95 backdrop-blur-sm border-b border-secondary/10 h-14 flex items-center px-4 sm:px-6 z-20">
        <button @click="open = ! open" class="sm:hidden inline-flex items-center justify-center p-2 -ml-2 text-secondary hover:text-primary transition-colors" aria-label="Toggle navigation">
            <svg x-show="!open" class="h-5 w-5" stroke="currentColor" fill="none" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"/>
            </svg>
            <svg x-show="open" x-cloak class="h-5 w-5" stroke="currentColor" fill="none" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
            </svg>
        </button>

        {{-- Breadcrumbs in top bar --}}
        <div class="hidden sm:flex items-center text-xs text-secondary/60 font-label uppercase tracking-[0.08em]">
            {{ __('messages.brand') }}
        </div>

        <div class="flex-1"></div>

        <div class="hidden sm:flex items-center">
            <x-lang-switcher position="bottom" class="!text-secondary/60 hover:!text-primary" />
        </div>
        <div class="sm:hidden">
            <x-lang-switcher position="bottom" class="!text-secondary/60 hover:!text-primary" />
        </div>
    </div>
</div>