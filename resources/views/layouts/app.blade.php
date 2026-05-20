<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <title>{{ config('app.name', 'Laravel') }} — {{ __('messages.brand') }}</title>
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body>
        @include('layouts.navigation')

        <div class="min-h-screen bg-neutral sm:ml-60">
            <div class="pt-14">
                <main class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-6 sm:py-8 page-enter">
                    {{ $slot }}
                </main>
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