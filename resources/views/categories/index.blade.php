<x-app-layout>
    <div x-data="{
        selected: [],
        deleting: null,
        toggleAll() {
            let ids = {{ $categories->pluck('id') }};
            this.selected = this.selected.length === ids.length ? [] : ids;
        },
        confirmDelete(category) {
            this.deleting = category;
            $dispatch('open-modal', 'confirm-delete');
        },
        confirmBulkDelete() {
            this.deleting = 'bulk';
            $dispatch('open-modal', 'confirm-delete');
        }
    }">
    <x-breadcrumbs :items="[['label' => __('messages.categories')]]" />
    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 mb-8">
        <div>
            <h1 class="font-display text-h1 text-primary">{{ __('messages.categories') }}</h1>
            <p class="text-body text-secondary mt-1">{{ __('messages.manage_categories') }}</p>
        </div>
        <a href="{{ route('categories.create') }}" class="btn-primary self-start">
            {{ __('messages.add_category') }}
        </a>
    </div>

    {{-- Search & Filter --}}
    <form method="GET" action="{{ route('categories.index') }}" class="flex flex-col sm:flex-row gap-3 mb-6">
        <div class="flex-1">
            <input type="text" name="search" value="{{ request('search') }}" placeholder="{{ __('messages.search_placeholder') }}" class="input-field">
        </div>
        <select name="status" class="input-field sm:w-40">
            <option value="">{{ __('messages.all_status') }}</option>
            <option value="active" {{ request('status') === 'active' ? 'selected' : '' }}>{{ __('messages.active') }}</option>
            <option value="inactive" {{ request('status') === 'inactive' ? 'selected' : '' }}>{{ __('messages.inactive') }}</option>
        </select>
        <select name="sort" class="input-field sm:w-48">
            <option value="latest" {{ request('sort', 'latest') === 'latest' ? 'selected' : '' }}>{{ __('messages.sort_latest') }}</option>
            <option value="oldest" {{ request('sort') === 'oldest' ? 'selected' : '' }}>{{ __('messages.sort_oldest') }}</option>
            <option value="updated" {{ request('sort') === 'updated' ? 'selected' : '' }}>{{ __('messages.sort_updated') }}</option>
            <option value="oldest_updated" {{ request('sort') === 'oldest_updated' ? 'selected' : '' }}>{{ __('messages.sort_oldest_updated') }}</option>
        </select>
        <button type="submit" class="btn-primary">{{ __('messages.filter') }}</button>
        @if (request('search') || request('status') || request('sort') && request('sort') !== 'latest')
            <a href="{{ route('categories.index') }}" class="inline-flex items-center px-3 text-sm text-secondary hover:text-primary transition-colors">{{ __('messages.clear') }}</a>
        @endif
    </form>

    {{-- Bulk action bar --}}
    <div x-show="selected.length > 0" x-cloak
         class="flex items-center justify-between px-4 py-3 mb-4 bg-tertiary/5 border border-tertiary/20 rounded-md">
        <p class="text-sm text-primary">
            <span class="font-medium" x-text="selected.length"></span>
            {{ __('messages.selected') }}
        </p>
        <div class="flex items-center gap-3">
            <button @click="selected = []" class="text-sm text-secondary hover:text-primary transition-colors">
                {{ __('messages.deselect_all') }}
            </button>
            <button @click="confirmBulkDelete()" class="inline-flex items-center gap-1.5 px-3 py-1.5 text-sm text-tertiary hover:opacity-80 transition-opacity">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                </svg>
                {{ __('messages.delete_selected') }}
            </button>
        </div>
    </div>

    {{-- Desktop table --}}
    <div class="hidden sm:block card overflow-hidden">
        <table class="w-full text-left">
            <thead>
                <tr class="border-b border-secondary/10">
                    <th class="pb-3 pr-3 w-[3%]">
                        <input type="checkbox" @change="toggleAll()" :checked="selected.length === {{ $categories->count() }} && {{ $categories->count() }} > 0"
                               class="w-4 h-4 rounded-sm border-secondary/30 text-tertiary focus:ring-tertiary">
                    </th>
                    <th class="font-label text-xs uppercase tracking-[0.08em] text-secondary pb-3 pr-4 w-[2%]">#</th>
                    <th class="font-label text-xs uppercase tracking-[0.08em] text-secondary pb-3 pr-4 w-[25%]">{{ __('messages.category_name') }}</th>
                    <th class="font-label text-xs uppercase tracking-[0.08em] text-secondary pb-3 pr-4 w-[35%]">{{ __('messages.description') }}</th>
                    <th class="font-label text-xs uppercase tracking-[0.08em] text-secondary pb-3 pr-4 w-[15%]">{{ __('messages.status') }}</th>
                    <th class="font-label text-xs uppercase tracking-[0.08em] text-secondary pb-3 w-[20%]">{{ __('messages.actions') }}</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($categories as $category)
                    <tr class="border-b border-secondary/5 last:border-0 even:bg-neutral/40 hover:bg-neutral/60 transition-colors"
                        :class="selected.includes({{ $category->id }}) ? 'bg-tertiary/[0.04] even:bg-tertiary/[0.04]' : ''">
                        <td class="py-3 pr-3 align-middle">
                            <input type="checkbox" value="{{ $category->id }}" x-model="selected"
                                   class="w-4 h-4 rounded-sm border-secondary/30 text-tertiary focus:ring-tertiary">
                        </td>
                        <td class="py-3 pr-4 text-sm text-secondary align-middle">{{ $loop->iteration + ($categories->currentPage() - 1) * $categories->perPage() }}</td>
                        <td class="py-3 pr-4 text-sm text-primary font-medium align-middle">{{ $category->name }}</td>
                        <td class="py-3 pr-4 text-sm text-secondary align-middle">{{ $category->description ?: '—' }}</td>
                        <td class="py-3 pr-4 align-middle">
                            <span class="font-label text-xs uppercase tracking-[0.08em] {{ $category->is_active ? 'text-tertiary' : 'text-secondary' }}">
                                {{ $category->is_active ? __('messages.active') : __('messages.inactive') }}
                            </span>
                        </td>
                        <td class="py-3 align-middle">
                            <div class="flex items-center gap-1">
                                <x-tooltip text="{{ __('messages.edit_category') }}" position="top">
                                    <a href="{{ route('categories.edit', $category) }}" class="inline-flex items-center gap-1.5 px-3 py-1.5 text-sm text-secondary hover:text-primary hover:bg-neutral rounded-sm transition-colors">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/></svg>
                                        <span>{{ __('messages.edit') }}</span>
                                    </a>
                                </x-tooltip>
                                <x-tooltip text="{{ __('messages.delete') }}" position="top">
                                    <button @click="confirmDelete({{ $category->id }})" class="inline-flex items-center gap-1.5 px-3 py-1.5 text-sm text-tertiary hover:opacity-80 hover:bg-neutral rounded-sm transition-colors">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
                                        <span>{{ __('messages.delete') }}</span>
                                    </button>
                                </x-tooltip>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="6" class="py-0">
                            @include('categories.partials.empty-state')
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    {{-- Mobile cards --}}
    <div class="sm:hidden space-y-3">
        @forelse ($categories as $category)
            <div class="card-hover" :class="selected.includes({{ $category->id }}) ? 'ring-1 ring-tertiary' : ''">
                <div class="flex items-start justify-between mb-2">
                    <div class="flex items-center gap-2">
                        <input type="checkbox" value="{{ $category->id }}" x-model="selected"
                               class="w-4 h-4 rounded-sm border-secondary/30 text-tertiary focus:ring-tertiary">
                        <h3 class="text-sm font-medium text-primary">{{ $category->name }}</h3>
                    </div>
                    <span class="font-label text-xs uppercase tracking-[0.08em] {{ $category->is_active ? 'text-tertiary' : 'text-secondary' }}">
                        {{ $category->is_active ? __('messages.active') : __('messages.inactive') }}
                    </span>
                </div>
                @if ($category->description)
                    <p class="text-xs text-secondary mb-3 ml-6">{{ $category->description }}</p>
                @endif
                <div class="flex items-center gap-2 pt-3 border-t border-secondary/10 ml-6">
                    <a href="{{ route('categories.edit', $category) }}" title="{{ __('messages.edit_category') }}" class="inline-flex items-center gap-1.5 px-3 py-1.5 text-xs text-secondary hover:text-primary hover:bg-neutral rounded-sm transition-colors">
                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/></svg>
                        <span>{{ __('messages.edit') }}</span>
                    </a>
                    <button @click="confirmDelete({{ $category->id }})" title="{{ __('messages.delete') }}" class="inline-flex items-center gap-1.5 px-3 py-1.5 text-xs text-tertiary hover:opacity-80 hover:bg-neutral rounded-sm transition-colors">
                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
                        <span>{{ __('messages.delete') }}</span>
                    </button>
                </div>
            </div>
        @empty
            <div class="card">
                @include('categories.partials.empty-state')
            </div>
        @endforelse
    </div>

    <div class="mt-6 flex flex-col sm:flex-row sm:items-center justify-between gap-4">
        <div class="flex items-center gap-2 text-sm text-secondary">
            <span>{{ __('messages.show') }}</span>
            <form method="GET" action="{{ route('categories.index') }}">
                @foreach (['search', 'status', 'sort'] as $param)
                    @if (request($param))
                        <input type="hidden" name="{{ $param }}" value="{{ request($param) }}">
                    @endif
                @endforeach
                <select name="per_page" onchange="this.form.submit()" class="input-field w-20 text-sm py-1.5 px-2">
                    <option value="5" {{ request('per_page', 5) == 5 ? 'selected' : '' }}>5</option>
                    <option value="10" {{ request('per_page') == 10 ? 'selected' : '' }}>10</option>
                    <option value="15" {{ request('per_page') == 15 ? 'selected' : '' }}>15</option>
                </select>
            </form>
            <span>{{ __('messages.per_page') }}</span>
        </div>

        <div>
            {{ $categories->links() }}
        </div>
    </div>

    {{-- Delete confirmation modal (single & bulk) --}}
    <x-modal name="confirm-delete" maxWidth="sm">
        <div class="p-6">
            <div class="flex items-center gap-3 mb-4">
                <span class="w-10 h-10 rounded-full bg-tertiary/10 flex items-center justify-center">
                    <svg class="w-5 h-5 text-tertiary" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-2.5L13.732 4.5c-.77-.833-2.694-.833-3.464 0L3.34 16.5c-.77.833.192 2.5 1.732 2.5z"/>
                    </svg>
                </span>
                <div>
                    <h2 class="font-display text-lg text-primary" x-show="deleting === 'bulk'" x-cloak>
                        {{ __('messages.confirm_bulk_delete_title') }}
                    </h2>
                    <h2 class="font-display text-lg text-primary" x-show="deleting !== 'bulk'">
                        {{ __('messages.confirm_delete_title') }}
                    </h2>
                    <p class="text-sm text-secondary mt-0.5" x-show="deleting === 'bulk'" x-cloak>
                        <span x-text="selected.length"></span> {{ __('messages.confirm_bulk_delete_desc') }}
                    </p>
                    <p class="text-sm text-secondary mt-0.5" x-show="deleting !== 'bulk'">
                        {{ __('messages.confirm_delete_desc') }}
                    </p>
                </div>
            </div>

            {{-- Single delete form --}}
            <form x-show="deleting !== 'bulk'" method="POST" x-bind:action="deleting ? '/categories/' + deleting : '#'">
                @csrf
                @method('DELETE')
                <div class="mt-4">
                    <label class="block text-sm font-label text-secondary uppercase tracking-[0.08em] mb-1.5">{{ __('messages.password') }}</label>
                    <input type="password" name="current_password" required
                           class="input-field w-full text-sm"
                           placeholder="{{ __('messages.enter_password') }}">
                    <p class="text-xs text-tertiary mt-1">{{ __('messages.confirm_password_delete') }}</p>
                </div>
                <div class="flex justify-end gap-3 mt-4 pt-4 border-t border-secondary/10">
                    <button type="button" @click="$dispatch('close-modal', 'confirm-delete')" class="text-sm text-secondary hover:text-primary transition-colors px-4 py-2">
                        {{ __('messages.cancel') }}
                    </button>
                    <button type="submit" class="inline-flex items-center gap-2 px-5 py-2.5 bg-tertiary text-surface rounded-md font-label text-xs uppercase tracking-[0.08em] font-medium hover:opacity-90 transition-opacity">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                        </svg>
                        {{ __('messages.delete') }}
                    </button>
                </div>
            </form>

            {{-- Bulk delete form --}}
            <form x-show="deleting === 'bulk'" method="POST" action="{{ route('categories.bulk-destroy') }}">
                @csrf
                @method('DELETE')
                <template x-for="id in selected" :key="id">
                    <input type="hidden" name="ids[]" :value="id">
                </template>
                <div class="flex justify-end gap-3 mt-6 pt-4 border-t border-secondary/10">
                    <button type="button" @click="$dispatch('close-modal', 'confirm-delete')" class="text-sm text-secondary hover:text-primary transition-colors px-4 py-2">
                        {{ __('messages.cancel') }}
                    </button>
                    <button type="submit" class="inline-flex items-center gap-2 px-5 py-2.5 bg-tertiary text-surface rounded-md font-label text-xs uppercase tracking-[0.08em] font-medium hover:opacity-90 transition-opacity">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                        </svg>
                        {{ __('messages.delete') }}
                    </button>
                </div>
            </form>
        </div>
        <div class="px-6 pb-4 -mt-2">
            <p class="text-xs text-secondary/50 text-center font-label uppercase tracking-[0.08em]">
                <kbd class="px-1.5 py-0.5 bg-neutral rounded text-[10px] font-label">Esc</kbd>
                <span class="ml-1">{{ __('messages.press_esc_to_close') }}</span>
            </p>
        </div>
    </x-modal>
    </div>
</x-app-layout>