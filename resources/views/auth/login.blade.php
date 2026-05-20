<x-guest-layout>
    <x-auth-session-status class="mb-6" :status="session('status')" />

    <h1 class="font-display text-h1 text-primary mb-8">{{ __('messages.sign_in') }}</h1>

    <form method="POST" action="{{ route('login') }}">
        @csrf

        <div>
            <label for="email" class="input-label">{{ __('messages.email') }}</label>
            <input id="email" class="input-field" type="email" name="email" :value="old('email')" required autofocus autocomplete="username" placeholder="{{ __('messages.your_email') }}">
            <x-input-error :messages="$errors->get('email')" />
        </div>

        <div class="mt-5">
            <label for="password" class="input-label">{{ __('messages.password') }}</label>
            <input id="password" class="input-field" type="password" name="password" required autocomplete="current-password" placeholder="{{ __('messages.enter_password') }}">
            <x-input-error :messages="$errors->get('password')" />
        </div>

        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4 mt-8">
            @if (Route::has('password.request'))
                <a class="auth-link text-center sm:text-left order-2 sm:order-1" href="{{ route('password.request') }}">
                    {{ __('messages.forgot_password') }}
                </a>
            @endif

            <button type="submit" class="btn-primary w-full sm:w-auto order-1 sm:order-2">
                {{ __('messages.log_in') }}
            </button>
        </div>
    </form>

    <p class="text-center mt-8 text-sm text-secondary">
        {{ __('messages.dont_have_account') }}
        <a href="{{ route('register') }}" class="text-sm text-primary font-medium hover:opacity-80 transition-opacity">{{ __('messages.sign_up') }}</a>
    </p>
</x-guest-layout>