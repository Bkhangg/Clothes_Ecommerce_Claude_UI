<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <title>404 — {{ __('messages.brand') }}</title>
        @vite(['resources/css/app.css'])
    </head>
    <body class="bg-neutral">
        <div class="min-h-screen flex flex-col items-center justify-center px-4">
            <div class="text-center max-w-md">
                <span class="font-display text-[8rem] sm:text-[10rem] leading-none text-primary/5 select-none">404</span>
                <h1 class="font-display text-2xl text-primary -mt-8 mb-3">{{ __('Page not found') }}</h1>
                <p class="text-secondary text-sm mb-8 leading-relaxed">
                    {{ __('The page you are looking for does not exist or has been moved.') }}
                </p>
                <div class="flex items-center justify-center gap-4">
                    <a href="{{ route('dashboard') }}" class="btn-primary">
                        {{ __('messages.dashboard') }}
                    </a>
                    <a href="javascript:history.back()" class="text-sm text-secondary hover:text-primary transition-colors">
                        {{ __('Go back') }}
                    </a>
                </div>
            </div>

            <div class="mt-12">
                <a href="{{ route('language.switch', 'en') }}" class="font-label text-xs uppercase tracking-[0.08em] {{ app()->getLocale() === 'en' ? 'text-tertiary font-medium' : 'text-secondary/40 hover:text-primary' }} transition-colors">EN</a>
                <span class="text-secondary/20 mx-2 select-none">/</span>
                <a href="{{ route('language.switch', 'vi') }}" class="font-label text-xs uppercase tracking-[0.08em] {{ app()->getLocale() === 'vi' ? 'text-tertiary font-medium' : 'text-secondary/40 hover:text-primary' }} transition-colors">VI</a>
            </div>
        </div>
    </body>
</html>