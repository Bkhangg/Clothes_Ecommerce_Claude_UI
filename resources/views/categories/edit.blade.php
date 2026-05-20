<x-app-layout>
    <x-breadcrumbs :items="[['label' => __('messages.categories'), 'url' => route('categories.index')], ['label' => __('messages.edit_category')]]" />
    <div class="mb-8">
        <h1 class="font-display text-h1 text-primary">{{ __('messages.edit_category') }}</h1>
    </div>

    <div class="card-hover max-w-lg">
        <form method="POST" action="{{ route('categories.update', $category) }}" x-data="{ loading: false }" x-on:submit="loading = true">
            @csrf
            @method('PUT')

            <div>
                <label for="name" class="input-label">{{ __('messages.name') }}</label>
                <input id="name" class="input-field" type="text" name="name" value="{{ old('name', $category->name) }}" required autofocus placeholder="{{ __('messages.category_name_placeholder') }}">
                <x-input-error :messages="$errors->get('name')" />
            </div>

            <div class="mt-5">
                <label for="description" class="input-label">{{ __('messages.description') }}</label>
                <textarea id="description" class="input-field" name="description" rows="3" placeholder="{{ __('messages.category_desc_placeholder') }}" x-data x-init="$el.style.height = $el.scrollHeight + 'px'" @input="$el.style.height = 'auto'; $el.style.height = $el.scrollHeight + 'px'">{{ old('description', $category->description) }}</textarea>
                <x-input-error :messages="$errors->get('description')" />
            </div>

            <div class="mt-5">
                <label class="inline-flex items-center gap-3">
                    <input type="checkbox" name="is_active" value="1" {{ $category->is_active ? 'checked' : '' }} class="w-4 h-4 rounded-sm border-secondary/30 text-tertiary focus:ring-tertiary">
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
                <a href="{{ route('categories.index') }}" class="text-sm text-secondary hover:text-primary transition-colors">{{ __('messages.cancel') }}</a>
            </div>
        </form>
    </div>
</x-app-layout>