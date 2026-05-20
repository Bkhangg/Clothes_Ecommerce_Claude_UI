<x-guest-layout>
    <h1 class="font-display text-h1 text-primary mb-6">{{ __('messages.forgot_password') }}</h1>

    <p class="text-body text-secondary text-sm mb-6 leading-relaxed">
        {{ __('messages.forgot_password_desc') }}
    </p>

    <x-auth-session-status class="mb-4" :status="session('status')" />

    <form method="POST" action="{{ route('password.email') }}">
        @csrf

        <div>
            <label for="email" class="input-label">{{ __('messages.email') }}</label>
            <input id="email" class="input-field" type="email" name="email" :value="old('email')" required autofocus placeholder="{{ __('messages.your_email') }}">
            <x-input-error :messages="$errors->get('email')" />
        </div>

        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4 mt-8">
            <a href="{{ route('login') }}" class="auth-link text-center sm:text-left order-2 sm:order-1">{{ __('messages.log_in') }}</a>
            <button type="submit" class="btn-primary w-full sm:w-auto order-1 sm:order-2">{{ __('messages.email_password_reset_link') }}</button>
        </div>
    </form>
</x-guest-layout>