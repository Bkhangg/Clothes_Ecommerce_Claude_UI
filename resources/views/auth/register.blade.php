<x-guest-layout>
    <h1 class="font-display text-h1 text-primary mb-8">{{ __('messages.create_account') }}</h1>

    <form method="POST" action="{{ route('register') }}">
        @csrf

        <div>
            <label for="name" class="input-label">{{ __('messages.name') }}</label>
            <input id="name" class="input-field" type="text" name="name" :value="old('name')" required autofocus autocomplete="name" placeholder="{{ __('messages.your_name') }}">
            <x-input-error :messages="$errors->get('name')" />
        </div>

        <div class="mt-5">
            <label for="email" class="input-label">{{ __('messages.email') }}</label>
            <input id="email" class="input-field" type="email" name="email" :value="old('email')" required autocomplete="username" placeholder="{{ __('messages.your_email') }}">
            <x-input-error :messages="$errors->get('email')" />
        </div>

        <div class="mt-5">
            <label for="password" class="input-label">{{ __('messages.password') }}</label>
            <input id="password" class="input-field" type="password" name="password" required autocomplete="new-password" placeholder="{{ __('messages.create_password') }}">
            <x-input-error :messages="$errors->get('password')" />
        </div>

        <div class="mt-5">
            <label for="password_confirmation" class="input-label">{{ __('messages.confirm_password') }}</label>
            <input id="password_confirmation" class="input-field" type="password" name="password_confirmation" required autocomplete="new-password" placeholder="{{ __('messages.confirm_your_password') }}">
            <x-input-error :messages="$errors->get('password_confirmation')" />
        </div>

        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4 mt-8">
            <a href="{{ route('login') }}" class="auth-link text-center sm:text-left order-2 sm:order-1">
                {{ __('messages.already_registered') }}
            </a>

            <button type="submit" class="btn-primary w-full sm:w-auto order-1 sm:order-2">
                {{ __('messages.register') }}
            </button>
        </div>
    </form>
</x-guest-layout>