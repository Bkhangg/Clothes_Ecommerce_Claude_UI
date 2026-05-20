<section>
    <header class="mb-6">
        <h2 class="font-display text-xl text-primary">{{ __('messages.update_password') }}</h2>
        <p class="text-body text-secondary text-sm mt-1">{{ __('messages.update_password_desc') }}</p>
    </header>

    <form method="post" action="{{ route('password.update') }}" class="space-y-5" x-data="{ loading: false }" x-on:submit="loading = true">
        @csrf
        @method('put')

        <div>
            <label for="update_password_current_password" class="input-label">{{ __('messages.current_password') }}</label>
            <input id="update_password_current_password" name="current_password" type="password" class="input-field" autocomplete="current-password" placeholder="········">
            <x-input-error :messages="$errors->updatePassword->get('current_password')" />
        </div>

        <div>
            <label for="update_password_password" class="input-label">{{ __('messages.new_password') }}</label>
            <input id="update_password_password" name="password" type="password" class="input-field" autocomplete="new-password" placeholder="········">
            <x-input-error :messages="$errors->updatePassword->get('password')" />
        </div>

        <div>
            <label for="update_password_password_confirmation" class="input-label">{{ __('messages.confirm_password') }}</label>
            <input id="update_password_password_confirmation" name="password_confirmation" type="password" class="input-field" autocomplete="new-password" placeholder="········">
            <x-input-error :messages="$errors->updatePassword->get('password_confirmation')" />
        </div>

        <div class="flex items-center gap-4 pt-2">
            <button type="submit" class="btn-primary" :disabled="loading">
                <span x-show="!loading">{{ __('messages.save') }}</span>
                <span x-show="loading" class="flex items-center gap-2">
                    <svg class="w-4 h-4 animate-spin" fill="none" viewBox="0 0 24 24">
                        <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"/>
                        <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4z"/>
                    </svg>
                    {{ __('messages.saving') }}
                </span>
            </button>

            @if (session('status') === 'password-updated')
                <p x-data="{ show: true }" x-show="show" x-transition x-init="setTimeout(() => show = false, 2000)" class="text-sm text-secondary">
                    {{ __('messages.saved') }}
                </p>
            @endif
        </div>
    </form>
</section>
