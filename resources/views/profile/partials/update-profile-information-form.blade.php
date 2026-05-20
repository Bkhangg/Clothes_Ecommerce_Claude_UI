<section>
    <header class="mb-6">
        <h2 class="font-display text-xl text-primary">{{ __('messages.profile_information') }}</h2>
        <p class="text-body text-secondary text-sm mt-1">{{ __('messages.update_profile_info') }}</p>
    </header>

    <form id="send-verification" method="post" action="{{ route('verification.send') }}">
        @csrf
    </form>

    <form method="post" action="{{ route('profile.update') }}" class="space-y-5" x-data="{ loading: false }" x-on:submit="loading = true">
        @csrf
        @method('patch')

        <div>
            <label for="name" class="input-label">{{ __('messages.name') }}</label>
            <input id="name" name="name" type="text" class="input-field" :value="old('name', $user->name)" required autofocus autocomplete="name">
            <x-input-error :messages="$errors->get('name')" />
        </div>

        <div>
            <label for="email" class="input-label">{{ __('messages.email') }}</label>
            <input id="email" name="email" type="email" class="input-field" :value="old('email', $user->email)" required autocomplete="username">
            <x-input-error :messages="$errors->get('email')" />

            @if ($user instanceof \Illuminate\Contracts\Auth\MustVerifyEmail && ! $user->hasVerifiedEmail())
                <div class="mt-2">
                    <p class="text-sm text-secondary">
                        {{ __('Your email address is unverified.') }}
                        <button form="send-verification" class="underline text-tertiary hover:opacity-80 transition-opacity">
                            {{ __('Click here to re-send the verification email.') }}
                        </button>
                    </p>

                    @if (session('status') === 'verification-link-sent')
                        <p class="mt-2 text-sm text-tertiary">
                            {{ __('A new verification link has been sent to your email address.') }}
                        </p>
                    @endif
                </div>
            @endif
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

            @if (session('status') === 'profile-updated')
                <p x-data="{ show: true }" x-show="show" x-transition x-init="setTimeout(() => show = false, 2000)" class="text-sm text-secondary">
                    {{ __('messages.saved') }}
                </p>
            @endif
        </div>
    </form>
</section>
