<section class="space-y-6">
    <header class="mb-6">
        <h2 class="font-display text-xl text-primary">{{ __('messages.delete_account') }}</h2>
        <p class="text-body text-secondary text-sm mt-1">
            {{ __('Once your account is deleted, all of its resources and data will be permanently deleted. Before deleting your account, please download any data or information that you wish to retain.') }}
        </p>
    </header>

    <button type="button"
        x-data=""
        x-on:click.prevent="$dispatch('open-modal', 'confirm-user-deletion')"
        class="inline-flex items-center px-5 py-3 bg-tertiary text-surface rounded-md font-label text-xs uppercase tracking-[0.08em] font-medium transition-opacity hover:opacity-90 focus:outline-none focus:ring-2 focus:ring-tertiary focus:ring-offset-2">
        {{ __('messages.delete_account') }}
    </button>

    <x-modal name="confirm-user-deletion" :show="$errors->userDeletion->isNotEmpty()" focusable>
        <form method="post" action="{{ route('profile.destroy') }}" class="p-6">
            @csrf
            @method('delete')

            <h2 class="font-display text-xl text-primary mb-2">
                {{ __('Are you sure you want to delete your account?') }}
            </h2>

            <p class="text-sm text-secondary mb-6">
                {{ __('Once your account is deleted, all of its resources and data will be permanently deleted. Please enter your password to confirm you would like to permanently delete your account.') }}
            </p>

            <div class="mb-6">
                <label for="password" class="input-label">{{ __('messages.password') }}</label>
                <input id="password" name="password" type="password" class="input-field" placeholder="{{ __('messages.password') }}">
                <x-input-error :messages="$errors->userDeletion->get('password')" />
            </div>

            <div class="flex justify-end gap-3">
                <button type="button" x-on:click="$dispatch('close')" class="text-sm text-secondary hover:text-primary transition-colors font-body px-4 py-2">
                    {{ __('messages.cancel') }}
                </button>

                <button type="submit" class="inline-flex items-center px-5 py-3 bg-tertiary text-surface rounded-md font-label text-xs uppercase tracking-[0.08em] font-medium transition-opacity hover:opacity-90 focus:outline-none focus:ring-2 focus:ring-tertiary focus:ring-offset-2">
                    {{ __('messages.delete_account') }}
                </button>
            </div>
        </form>
    </x-modal>
</section>
