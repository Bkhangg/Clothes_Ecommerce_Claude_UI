<x-guest-layout>
    <h1 class="font-display text-h1 text-primary mb-6">{{ __('messages.confirm') }}</h1>

    <p class="text-body text-secondary text-sm mb-6 leading-relaxed">
        {{ __('messages.confirm_password_desc') }}
    </p>

    <form method="POST" action="{{ route('password.confirm') }}">
        @csrf

        <div>
            <label for="password" class="input-label">{{ __('messages.password') }}</label>
            <input id="password" class="input-field" type="password" name="password" required autocomplete="current-password" placeholder="········">
            <x-input-error :messages="$errors->get('password')" />
        </div>

        <div class="flex justify-end mt-6">
            <button type="submit" class="btn-primary w-full sm:w-auto">{{ __('messages.confirm') }}</button>
        </div>
    </form>
</x-guest-layout>