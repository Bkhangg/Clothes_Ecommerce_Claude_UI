<x-app-layout>
    <div x-data="{
        selected: [],
        deleting: null,
        previewImages: [],
        previewIndex: 0,
        previewImage: false,
        password: '',
        passwordVerified: {{ session('password_verified') ? 'true' : 'false' }},
        get previewImageSrc() {
            return this.previewImages[this.previewIndex] || '';
        },
        openPreview(images, index) {
            this.previewImages = images;
            this.previewIndex = index;
            this.previewImage = true;
        },
        prevImage() {
            this.previewIndex = (this.previewIndex - 1 + this.previewImages.length) % this.previewImages.length;
        },
        nextImage() {
            this.previewIndex = (this.previewIndex + 1) % this.previewImages.length;
        },
        toggleAll() {
            let ids = {{ $products->pluck('id') }};
            this.selected = this.selected.length === ids.length ? [] : ids;
        },
        confirmDelete(product) {
            this.deleting = product;
            $dispatch('open-modal', 'confirm-delete');
        },
        confirmBulkDelete() {
            this.deleting = 'bulk';
            $dispatch('open-modal', 'confirm-delete');
        }
    }" @close-modal.window="if ($event.detail == 'confirm-delete') password = ''">
    <x-breadcrumbs :items="[['label' => __('messages.products')]]" />
    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 mb-8">
        <div>
            <h1 class="font-display text-h1 text-primary">{{ __('messages.products') }}</h1>
            <p class="text-body text-secondary mt-1">{{ __('messages.manage_products') }}</p>
        </div>
        <a href="{{ route('products.create') }}" class="btn-primary self-start">
            {{ __('messages.add_product') }}
        </a>
    </div>

    {{-- Search & Filter --}}
    <form method="GET" action="{{ route('products.index') }}" class="flex flex-col sm:flex-row gap-3 mb-6">
        <div class="flex-1">
            <input type="text" name="search" value="{{ request('search') }}" placeholder="{{ __('messages.search_products_placeholder') }}" class="input-field">
        </div>
        <select name="category_id" class="input-field sm:w-44">
            <option value="">{{ __('messages.all_categories') }}</option>
            @foreach ($categories as $category)
                <option value="{{ $category->id }}" {{ request('category_id') == $category->id ? 'selected' : '' }}>{{ $category->name }}</option>
            @endforeach
        </select>
        <select name="brand_id" class="input-field sm:w-48 pr-8">
            <option value="">{{ __('messages.all_brands') }}</option>
            @foreach ($brands as $brand)
                <option value="{{ $brand->id }}" {{ request('brand_id') == $brand->id ? 'selected' : '' }}>{{ $brand->name }}</option>
            @endforeach
        </select>
        <select name="status" class="input-field sm:w-36">
            <option value="">{{ __('messages.all_status') }}</option>
            <option value="active" {{ request('status') === 'active' ? 'selected' : '' }}>{{ __('messages.active') }}</option>
            <option value="inactive" {{ request('status') === 'inactive' ? 'selected' : '' }}>{{ __('messages.inactive') }}</option>
        </select>
        <select name="sort" class="input-field sm:w-44">
            <option value="latest" {{ request('sort', 'latest') === 'latest' ? 'selected' : '' }}>{{ __('messages.sort_latest') }}</option>
            <option value="oldest" {{ request('sort') === 'oldest' ? 'selected' : '' }}>{{ __('messages.sort_oldest') }}</option>
            <option value="updated" {{ request('sort') === 'updated' ? 'selected' : '' }}>{{ __('messages.sort_updated') }}</option>
            <option value="oldest_updated" {{ request('sort') === 'oldest_updated' ? 'selected' : '' }}>{{ __('messages.sort_oldest_updated') }}</option>
            <option value="price_asc" {{ request('sort') === 'price_asc' ? 'selected' : '' }}>{{ __('messages.sort_price_asc') }}</option>
            <option value="price_desc" {{ request('sort') === 'price_desc' ? 'selected' : '' }}>{{ __('messages.sort_price_desc') }}</option>
            <option value="name_asc" {{ request('sort') === 'name_asc' ? 'selected' : '' }}>{{ __('messages.sort_name_asc') }}</option>
            <option value="name_desc" {{ request('sort') === 'name_desc' ? 'selected' : '' }}>{{ __('messages.sort_name_desc') }}</option>
        </select>
        <button type="submit" class="btn-primary">{{ __('messages.filter') }}</button>
        @if (request('search') || request('status') || request('category_id') || request('brand_id') || (request('sort') && request('sort') !== 'latest'))
            <a href="{{ route('products.index') }}" class="inline-flex items-center px-3 text-sm text-secondary hover:text-primary transition-colors">{{ __('messages.clear') }}</a>
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
                        <input type="checkbox" @change="toggleAll()" :checked="selected.length === {{ $products->count() }} && {{ $products->count() }} > 0"
                               class="w-4 h-4 rounded-sm border-secondary/30 text-tertiary focus:ring-tertiary">
                    </th>
                    <th class="font-label text-xs uppercase tracking-[0.08em] text-secondary pb-3 pr-4 w-[2%]">#</th>
                    <th class="font-label text-xs uppercase tracking-[0.08em] text-secondary pb-3 pr-4 w-[18%]">{{ __('messages.image') }}</th>
                    <th class="font-label text-xs uppercase tracking-[0.08em] text-secondary pb-3 pr-4 w-[18%]">{{ __('messages.product_name') }}</th>
                    <th class="font-label text-xs uppercase tracking-[0.08em] text-secondary pb-3 pr-4 w-[10%]">{{ __('messages.sku') }}</th>
                    <th class="font-label text-xs uppercase tracking-[0.08em] text-secondary pb-3 pr-4 w-[10%]">{{ __('messages.category') }}</th>
                    <th class="font-label text-xs uppercase tracking-[0.08em] text-secondary pb-3 pr-4 w-[10%]">{{ __('messages.price') }}</th>
                    <th class="font-label text-xs uppercase tracking-[0.08em] text-secondary pb-3 pr-4 w-[8%]">{{ __('messages.stock') }}</th>
                    <th class="font-label text-xs uppercase tracking-[0.08em] text-secondary pb-3 pr-4 w-[8%]">{{ __('messages.status') }}</th>
                    <th class="font-label text-xs uppercase tracking-[0.08em] text-secondary pb-3 w-[16%]">{{ __('messages.actions') }}</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($products as $product)
                    <tr class="border-b border-secondary/5 last:border-0 even:bg-neutral/40 hover:bg-neutral/60 transition-colors"
                        :class="selected.includes({{ $product->id }}) ? 'bg-tertiary/[0.04] even:bg-tertiary/[0.04]' : ''">
                        <td class="py-3 pr-3 align-middle">
                            <input type="checkbox" value="{{ $product->id }}" x-model="selected"
                                   class="w-4 h-4 rounded-sm border-secondary/30 text-tertiary focus:ring-tertiary">
                        </td>
                        <td class="py-3 pr-4 text-sm text-secondary align-middle">{{ $loop->iteration + ($products->currentPage() - 1) * $products->perPage() }}</td>
                        <td class="py-3 pr-4 align-middle">
                            <div class="flex items-start gap-2">
                                @if ($product->image)
                                    <img src="{{ Storage::url($product->image) }}" alt="{{ $product->name }}" class="w-14 h-14 rounded-sm object-cover border border-secondary/10 cursor-pointer shrink-0" @click="openPreview(@js(array_values(array_filter([$product->image ? Storage::url($product->image) : null, ...$product->images->map(fn($i) => Storage::url($i->image))->toArray()]))), 0)">
                                @else
                                    <span class="w-14 h-14 rounded-sm bg-neutral flex items-center justify-center text-secondary/30 shrink-0">
                                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                                        </svg>
                                    </span>
                                @endif
                                @if ($product->images->count() > 0)
                                    <div class="flex gap-1 flex-wrap max-w-[180px]">
                                        @foreach ($product->images as $idx => $img)
                                            <img src="{{ Storage::url($img->image) }}" alt="" class="w-[26px] h-[26px] rounded-sm object-cover border border-secondary/10 cursor-pointer hover:ring-1 hover:ring-tertiary transition-all" @click="openPreview(@js(array_values(array_filter([$product->image ? Storage::url($product->image) : null, ...$product->images->map(fn($i) => Storage::url($i->image))->toArray()]))), {{ $idx + 1 }})">
                                        @endforeach
                                    </div>
                                @endif
                            </div>
                        </td>
                        <td class="py-3 pr-4 text-sm text-primary font-medium align-middle max-w-[200px] truncate">{{ $product->name }}</td>
                        <td class="py-3 pr-4 text-sm text-secondary align-middle font-mono">{{ $product->sku }}</td>
                        <td class="py-3 pr-4 text-sm text-secondary align-middle">{{ $product->category?->name ?? '—' }}</td>
                        <td class="py-3 pr-4 text-sm align-middle">
                            @if ($product->sale_price)
                                <span class="text-tertiary font-medium">{{ \App\Helpers\Currency::format($product->sale_price) }}</span>
                                <span class="text-xs text-secondary/50 line-through ml-1">{{ \App\Helpers\Currency::format($product->price) }}</span>
                            @else
                                <span class="text-primary font-medium">{{ \App\Helpers\Currency::format($product->price) }}</span>
                            @endif
                        </td>
                        <td class="py-3 pr-4 align-middle">
                            <span class="text-sm {{ $product->stock > 0 ? 'text-primary' : 'text-secondary' }}">
                                {{ $product->stock }}
                            </span>
                        </td>
                        <td class="py-3 pr-4 align-middle">
                            <span class="font-label text-xs uppercase tracking-[0.08em] {{ $product->is_active ? 'text-tertiary' : 'text-secondary' }}">
                                {{ $product->is_active ? __('messages.active') : __('messages.inactive') }}
                            </span>
                        </td>
                        <td class="py-3 align-middle">
                            <div class="flex items-center gap-1">
                                <x-tooltip text="{{ __('messages.edit_product') }}" position="top">
                                    <a href="{{ route('products.edit', $product) }}" class="inline-flex items-center gap-1.5 px-3 py-1.5 text-sm text-secondary hover:text-primary hover:bg-neutral rounded-sm transition-colors">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/></svg>
                                        <span>{{ __('messages.edit') }}</span>
                                    </a>
                                </x-tooltip>
                                <x-tooltip text="{{ __('messages.delete') }}" position="top">
                                    <button @click="confirmDelete({{ $product->id }})" class="inline-flex items-center gap-1.5 px-3 py-1.5 text-sm text-tertiary hover:opacity-80 hover:bg-neutral rounded-sm transition-colors">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
                                        <span>{{ __('messages.delete') }}</span>
                                    </button>
                                </x-tooltip>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="10" class="py-0">
                            @include('products.partials.empty-state')
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    {{-- Mobile cards --}}
    <div class="sm:hidden space-y-3">
        @forelse ($products as $product)
            <div class="card-hover" :class="selected.includes({{ $product->id }}) ? 'ring-1 ring-tertiary' : ''">
                <div class="flex items-start gap-3 mb-2">
                    <input type="checkbox" value="{{ $product->id }}" x-model="selected"
                           class="w-4 h-4 rounded-sm border-secondary/30 text-tertiary focus:ring-tertiary mt-1">
                    <div class="flex gap-2 shrink-0">
                        @if ($product->image)
                            <img src="{{ Storage::url($product->image) }}" alt="{{ $product->name }}" class="w-14 h-14 rounded-sm object-cover border border-secondary/10 cursor-pointer" @click="openPreview(@js(array_values(array_filter([$product->image ? Storage::url($product->image) : null, ...$product->images->map(fn($i) => Storage::url($i->image))->toArray()]))), 0)">
                        @else
                            <span class="w-14 h-14 rounded-sm bg-neutral flex items-center justify-center text-secondary/30">
                                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                                </svg>
                            </span>
                        @endif
                        @if ($product->images->count() > 0)
                            <div class="flex flex-col gap-1">
                                @foreach ($product->images as $idx => $img)
                                    <img src="{{ Storage::url($img->image) }}" alt="" class="w-[26px] h-[26px] rounded-sm object-cover border border-secondary/10 cursor-pointer hover:ring-1 hover:ring-tertiary transition-all" @click="openPreview(@js(array_values(array_filter([$product->image ? Storage::url($product->image) : null, ...$product->images->map(fn($i) => Storage::url($i->image))->toArray()]))), {{ $idx + 1 }})">
                                @endforeach
                            </div>
                        @endif
                    </div>
                    <div class="flex-1 min-w-0">
                        <div class="flex items-start justify-between gap-2">
                            <h3 class="text-sm font-medium text-primary truncate">{{ $product->name }}</h3>
                            <span class="font-label text-xs uppercase tracking-[0.08em] shrink-0 {{ $product->is_active ? 'text-tertiary' : 'text-secondary' }}">
                                {{ $product->is_active ? __('messages.active') : __('messages.inactive') }}
                            </span>
                        </div>
                        <p class="text-xs text-secondary font-mono mt-0.5">{{ $product->sku }}</p>
                        <div class="flex items-center gap-3 mt-1">
                            <span class="text-sm font-medium text-primary">{{ \App\Helpers\Currency::format($product->price) }}</span>
                            @if ($product->sale_price)
                                <span class="text-xs text-tertiary font-medium">{{ \App\Helpers\Currency::format($product->sale_price) }}</span>
                            @endif
                            <span class="text-xs text-secondary">{{ __('messages.stock') }}: {{ $product->stock }}</span>
                        </div>
                        @if ($product->category)
                            <span class="inline-block mt-1 text-[10px] font-label uppercase tracking-[0.08em] text-secondary bg-neutral px-2 py-0.5 rounded-sm">{{ $product->category->name }}</span>
                        @endif
                    </div>
                </div>
                @if ($product->description)
                    <p class="text-xs text-secondary mb-3 ml-2">{{ Str::limit($product->description, 80) }}</p>
                @endif
                <div class="flex items-center gap-2 pt-3 border-t border-secondary/10 ml-2">
                    <a href="{{ route('products.edit', $product) }}" title="{{ __('messages.edit_product') }}" class="inline-flex items-center gap-1.5 px-3 py-1.5 text-xs text-secondary hover:text-primary hover:bg-neutral rounded-sm transition-colors">
                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/></svg>
                        <span>{{ __('messages.edit') }}</span>
                    </a>
                    <button @click="confirmDelete({{ $product->id }})" title="{{ __('messages.delete') }}" class="inline-flex items-center gap-1.5 px-3 py-1.5 text-xs text-tertiary hover:opacity-80 hover:bg-neutral rounded-sm transition-colors">
                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
                        <span>{{ __('messages.delete') }}</span>
                    </button>
                </div>
            </div>
        @empty
            <div class="card">
                @include('products.partials.empty-state')
            </div>
        @endforelse
    </div>

    <div class="mt-6 flex flex-col sm:flex-row sm:items-center justify-between gap-4">
        <div class="flex items-center gap-2 text-sm text-secondary">
            <span>{{ __('messages.show') }}</span>
            <form method="GET" action="{{ route('products.index') }}">
                @foreach (['search', 'status', 'category_id', 'brand_id', 'sort'] as $param)
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
            {{ $products->links() }}
        </div>
    </div>

    {{-- Delete confirmation modal --}}
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
                        {{ __('messages.confirm_bulk_delete_product_title') }}
                    </h2>
                    <h2 class="font-display text-lg text-primary" x-show="deleting !== 'bulk'">
                        {{ __('messages.confirm_delete_product_title') }}
                    </h2>
                    <p class="text-sm text-secondary mt-0.5" x-show="deleting === 'bulk'" x-cloak>
                        <span x-text="selected.length"></span> {{ __('messages.confirm_bulk_delete_product_desc') }}
                    </p>
                    <p class="text-sm text-secondary mt-0.5" x-show="deleting !== 'bulk'">
                        {{ __('messages.confirm_delete_product_desc') }}
                    </p>
                </div>
            </div>

            {{-- Password input — only on first delete of the session --}}
            <div x-show="!passwordVerified" class="mt-4 mb-1">
                <label class="block text-sm font-label text-secondary uppercase tracking-[0.08em] mb-1.5">{{ __('messages.password') }}</label>
                <input type="password" x-model="password" required
                       class="input-field w-full text-sm"
                       placeholder="{{ __('messages.enter_password') }}">
                <p class="text-xs text-tertiary mt-1">{{ __('messages.confirm_password_delete') }}</p>
            </div>

            {{-- Verified badge --}}
            <div x-show="passwordVerified" class="mt-4 mb-1 flex items-center gap-2 text-sm text-secondary/60">
                <svg class="w-4 h-4 text-tertiary" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"/>
                </svg>
                <span>{{ __('messages.password_verified') }}</span>
            </div>

            {{-- Single delete form --}}
            <form x-show="deleting !== 'bulk'" method="POST" x-bind:action="deleting ? '/products/' + deleting : '#'">
                @csrf
                @method('DELETE')
                <input type="hidden" name="current_password" :value="password" x-show="!passwordVerified">
                <div class="flex justify-end gap-3 pt-4 border-t border-secondary/10">
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
            <form x-show="deleting === 'bulk'" method="POST" action="{{ route('products.bulk-destroy') }}">
                @csrf
                @method('DELETE')
                <template x-for="id in selected" :key="id">
                    <input type="hidden" name="ids[]" :value="id">
                </template>
                <input type="hidden" name="current_password" :value="password" x-show="!passwordVerified">
                <div class="flex justify-end gap-3 pt-4 border-t border-secondary/10">
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

    {{-- Image gallery lightbox --}}
    <div x-show="previewImage" x-cloak
         @keydown.escape.window="previewImage = false"
         @keydown.left.window="prevImage"
         @keydown.right.window="nextImage"
         @click.self="previewImage = false"
         class="fixed inset-0 z-[200] flex items-center justify-center bg-primary/85 backdrop-blur-sm p-4"
         x-transition:enter="ease-out duration-300"
         x-transition:enter-start="opacity-0"
         x-transition:enter-end="opacity-100"
         x-transition:leave="ease-in duration-200"
         x-transition:leave-start="opacity-100"
         x-transition:leave-end="opacity-0">
        <div class="relative max-w-3xl w-full max-h-[90vh] flex items-center justify-center">
            {{-- Close --}}
            <button @click="previewImage = false" class="absolute -top-12 right-0 text-surface/70 hover:text-surface transition-colors z-10">
                <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                </svg>
            </button>

            {{-- Counter --}}
            <div class="absolute -top-12 left-0 text-sm text-surface/70 font-medium font-mono" x-text="(previewIndex + 1) + ' / ' + previewImages.length"></div>

            {{-- Prev --}}
            <button x-show="previewImages.length > 1" @click="prevImage" class="absolute left-0 top-1/2 -translate-y-1/2 -translate-x-4 w-10 h-10 flex items-center justify-center bg-surface/10 hover:bg-surface/20 text-surface rounded-full backdrop-blur-sm transition-all">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/>
                </svg>
            </button>

            {{-- Image --}}
            <img :src="previewImageSrc" alt="" class="max-w-full max-h-[85vh] rounded-lg shadow-2xl object-contain bg-surface/5">

            {{-- Next --}}
            <button x-show="previewImages.length > 1" @click="nextImage" class="absolute right-0 top-1/2 -translate-y-1/2 translate-x-4 w-10 h-10 flex items-center justify-center bg-surface/10 hover:bg-surface/20 text-surface rounded-full backdrop-blur-sm transition-all">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                </svg>
            </button>

            {{-- Thumbnail strip --}}
            <div x-show="previewImages.length > 1" class="absolute -bottom-16 left-1/2 -translate-x-1/2 flex gap-2 max-w-full overflow-x-auto px-2 py-1.5">
                <template x-for="(img, i) in previewImages" :key="i">
                    <img :src="img" alt="" @click="previewIndex = i"
                         class="w-10 h-10 rounded object-cover border-2 cursor-pointer transition-all shrink-0"
                         :class="i === previewIndex ? 'border-tertiary opacity-100' : 'border-transparent opacity-50 hover:opacity-80'">
                </template>
            </div>
        </div>
    </div>
    </div>
</x-app-layout>
