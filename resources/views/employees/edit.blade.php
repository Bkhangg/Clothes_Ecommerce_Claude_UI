<x-app-layout>
    <x-breadcrumbs :items="[['label' => __('messages.employees'), 'url' => route('employees.index')], ['label' => __('messages.edit_employee')]]" />
    <div class="mb-8">
        <h1 class="font-display text-h1 text-primary">{{ __('messages.edit_employee') }}</h1>
    </div>

    <div class="card-hover max-w-lg">
        <form method="POST" action="{{ route('employees.update', $employee) }}" x-data="{ loading: false }" x-on:submit="loading = true">
            @csrf
            @method('PUT')

            <div>
                <label for="name" class="input-label">{{ __('messages.name') }}</label>
                <input id="name" class="input-field" type="text" name="name" value="{{ old('name', $employee->name) }}" required autofocus>
                <x-input-error :messages="$errors->get('name')" />
            </div>

            <div class="mt-5">
                <label for="email" class="input-label">{{ __('messages.email') }}</label>
                <input id="email" class="input-field" type="email" name="email" value="{{ old('email', $employee->email) }}" required>
                <x-input-error :messages="$errors->get('email')" />
            </div>

            <div class="mt-5">
                <label for="password" class="input-label">{{ __('messages.new_password') }} <span class="text-secondary/50">({{ __('messages.leave_blank') }})</span></label>
                <input id="password" class="input-field" type="password" name="password" autocomplete="new-password" placeholder="{{ __('messages.create_password') }}">
                <x-input-error :messages="$errors->get('password')" />
            </div>

            <div class="mt-5">
                <label for="password_confirmation" class="input-label">{{ __('messages.confirm_password') }}</label>
                <input id="password_confirmation" class="input-field" type="password" name="password_confirmation" placeholder="{{ __('messages.confirm_your_password') }}">
                <x-input-error :messages="$errors->get('password_confirmation')" />
            </div>

            <div class="mt-6 pt-5 border-t border-secondary/10">
                <p class="font-label text-xs uppercase tracking-[0.08em] text-secondary mb-3">{{ __('messages.permissions') }}</p>
                <div class="space-y-2.5">
                    @foreach ($availablePermissions as $perm)
                    <label class="flex items-center gap-3 cursor-pointer group">
                        <input type="checkbox" name="permissions[]" value="{{ $perm }}"
                               {{ in_array($perm, old('permissions', $employee->permissions ?? [])) ? 'checked' : '' }}
                               class="w-4 h-4 rounded-sm border-secondary/30 text-tertiary focus:ring-tertiary">
                        <span class="text-sm text-primary group-hover:text-tertiary transition-colors">{{ __("messages.perm_$perm") }}</span>
                    </label>
                    @endforeach
                </div>
                <x-input-error :messages="$errors->get('permissions')" />
            </div>

            <div class="mt-5">
                <label class="inline-flex items-center gap-3">
                    <input type="checkbox" name="is_active" value="1" {{ $employee->is_active ? 'checked' : '' }} class="w-4 h-4 rounded-sm border-secondary/30 text-tertiary focus:ring-tertiary">
                    <span class="text-sm text-primary">{{ __('messages.active') }}</span>
                </label>
            </div>

            <div class="flex items-center gap-4 mt-8 pt-6 border-t border-secondary/10">
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
                <a href="{{ route('employees.index') }}" class="text-sm text-secondary hover:text-primary transition-colors">{{ __('messages.cancel') }}</a>
            </div>
        </form>
    </div>
</x-app-layout>
