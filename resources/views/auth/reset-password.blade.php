<x-guest-layout>
    <h1 class="font-display text-h1 text-primary mb-8">{{ __('messages.reset_password') }}</h1>

    <form method="POST" action="{{ route('password.store') }}">
        @csrf

        <input type="hidden" name="token" value="{{ $request->route('token') }}">

        <div>
            <label for="email" class="input-label">{{ __('messages.email') }}</label>
            <input id="email" class="input-field" type="email" name="email" :value="old('email', $request->email)" required autofocus autocomplete="username" placeholder="{{ __('messages.your_email') }}">
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

        <div class="flex justify-end mt-8">
            <button type="submit" class="btn-primary w-full sm:w-auto">{{ __('messages.reset_password') }}</button>
        </div>
    </form>
</x-guest-layout>