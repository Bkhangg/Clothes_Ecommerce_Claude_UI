<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <title>{{ config('app.name', 'Laravel') }} — {{ __('messages.brand') }}</title>
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="bg-neutral">
        <div class="min-h-screen flex flex-col items-center justify-center px-4 py-12">
            {{-- Brand --}}
            <a href="/" class="mb-8 font-display text-2xl text-primary no-underline select-none">
                {{ __('messages.brand') }}
            </a>

            {{-- Card --}}
            <div class="w-full max-w-md bg-surface rounded-lg p-8 shadow-sm border border-secondary/5">
                {{ $slot }}
            </div>

            {{-- Language switch --}}
            <div class="mt-8 flex justify-center">
                <x-lang-switcher position="top" class="!text-secondary/40 hover:!text-primary" />
            </div>
        </div>

        <x-toast />

        @if (session('toast'))
            <div x-data x-init="$nextTick(() => $dispatch('toast', { type: 'success', message: @js(session('toast')) }))"></div>
        @endif
        @if (session('error'))
            <div x-data x-init="$nextTick(() => $dispatch('toast', { type: 'error', message: @js(session('error')) }))"></div>
        @endif
        @if (session('toast_error'))
            <div x-data x-init="$nextTick(() => $dispatch('toast', { type: 'error', message: @js(session('toast_error')) }))"></div>
        @endif
    </body>
</html>