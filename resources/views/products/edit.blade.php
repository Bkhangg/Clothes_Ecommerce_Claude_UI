<x-app-layout>
    <x-breadcrumbs :items="[['label' => __('messages.products'), 'url' => route('products.index')], ['label' => __('messages.edit_product')]]" />
    <div class="mb-8">
        <h1 class="font-display text-h1 text-primary">{{ __('messages.edit_product') }}</h1>
    </div>

    <form method="POST" action="{{ route('products.update', $product) }}" enctype="multipart/form-data" x-data="{ loading: false, editor: null }" x-on:submit="if (editor) editor.updateSourceElement(); loading = true" class="space-y-8 max-w-4xl">
        @csrf
        @method('PUT')

        {{-- Basic Information --}}
        <div class="card-hover">
            <div class="border-b border-secondary/10 pb-4 mb-6">
                <h2 class="font-display text-xl text-primary">{{ __('messages.basic_info') }}</h2>
                <p class="text-sm text-secondary/60 mt-1">{{ __('messages.basic_info_desc') }}</p>
            </div>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div class="md:col-span-2">
                    <label for="name" class="input-label">{{ __('messages.product_name') }}</label>
                    <input id="name" class="input-field input-field-lg" type="text" name="name" value="{{ old('name', $product->name) }}" required autofocus placeholder="{{ __('messages.product_name_placeholder') }}">
                    <x-input-error :messages="$errors->get('name')" />
                </div>
                <div>
                    <label for="sku" class="input-label">{{ __('messages.sku') }}</label>
                    <input id="sku" class="input-field input-field-lg" type="text" name="sku" value="{{ old('sku', $product->sku) }}" required placeholder="e.g. PROD-001">
                    <x-input-error :messages="$errors->get('sku')" />
                </div>
                <div>
                    <x-searchable-select
                        name="category_id"
                        :options="$categories->map(fn($c) => ['value' => (string) $c->id, 'label' => $c->name])->values()->all()"
                        :selected="old('category_id', (string) $product->category_id)"
                        :placeholder="__('messages.select_category')"
                        :label="__('messages.category')"
                    />
                    <x-input-error :messages="$errors->get('category_id')" />
                </div>
                <div>
                    <x-searchable-select
                        name="brand_id"
                        :options="$brands->map(fn($b) => ['value' => (string) $b->id, 'label' => $b->name])->values()->all()"
                        :selected="old('brand_id', (string) $product->brand_id)"
                        :placeholder="__('messages.select_brand')"
                        :label="__('messages.brand')"
                    />
                    <x-input-error :messages="$errors->get('brand_id')" />
                </div>
            </div>
        </div>

        {{-- Pricing & Stock --}}
        <div class="card-hover">
            <div class="border-b border-secondary/10 pb-4 mb-6">
                <h2 class="font-display text-xl text-primary">{{ __('messages.pricing_stock') }}</h2>
                <p class="text-sm text-secondary/60 mt-1">{{ __('messages.pricing_stock_desc') }}</p>
            </div>
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                <div x-data="{ formatted: '{{ old('price', $product->price) ? number_format((int) old('price', $product->price), 0, ',', '.') : '' }}' }">
                    <label for="price" class="input-label">{{ __('messages.price') }}</label>
                    <div class="relative">
                        <span class="absolute left-4 top-1/2 -translate-y-1/2 text-sm text-secondary/60 font-medium">₫</span>
                        <input id="price" class="input-field input-field-lg pl-10" type="text" inputmode="numeric" name="price" value="{{ old('price', $product->price) }}" required placeholder="0" @input="formatted = $event.target.value.replace(/[^0-9]/g, '').replace(/\B(?=(\d{3})+(?!\d))/g, '.')">
                    </div>
                    <span class="text-xs text-secondary/50 mt-1.5 block font-medium" x-text="formatted ? '{{ __('messages.formatted') }}: ' + formatted + ' ₫' : ''"></span>
                    <x-input-error :messages="$errors->get('price')" />
                </div>
                <div x-data="{ formatted: '{{ old('sale_price', $product->sale_price) ? number_format((int) old('sale_price', $product->sale_price), 0, ',', '.') : '' }}' }">
                    <label for="sale_price" class="input-label">{{ __('messages.sale_price') }}</label>
                    <div class="relative">
                        <span class="absolute left-4 top-1/2 -translate-y-1/2 text-sm text-secondary/60 font-medium">₫</span>
                        <input id="sale_price" class="input-field input-field-lg pl-10" type="text" inputmode="numeric" name="sale_price" value="{{ old('sale_price', $product->sale_price) }}" placeholder="0" @input="formatted = $event.target.value.replace(/[^0-9]/g, '').replace(/\B(?=(\d{3})+(?!\d))/g, '.')">
                    </div>
                    <span class="text-xs text-secondary/50 mt-1.5 block font-medium" x-text="formatted ? '{{ __('messages.formatted') }}: ' + formatted + ' ₫' : ''"></span>
                    <x-input-error :messages="$errors->get('sale_price')" />
                </div>
                <div>
                    <label for="stock" class="input-label">{{ __('messages.stock') }}</label>
                    <input id="stock" class="input-field input-field-lg" type="number" min="0" name="stock" value="{{ old('stock', $product->stock) }}" required placeholder="0">
                    <x-input-error :messages="$errors->get('stock')" />
                </div>
            </div>
        </div>

        {{-- Attributes --}}
        <div class="card-hover">
            <div class="border-b border-secondary/10 pb-4 mb-6">
                <h2 class="font-display text-xl text-primary">{{ __('messages.attributes') }}</h2>
                <p class="text-sm text-secondary/60 mt-1">{{ __('messages.attributes_desc') }}</p>
            </div>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <label for="size" class="input-label">{{ __('messages.size') }}</label>
                    <input id="size" class="input-field input-field-lg" type="text" name="size" value="{{ old('size', $product->size) }}" placeholder="e.g. S, M, L, XL">
                    <x-input-error :messages="$errors->get('size')" />
                </div>
                <div>
                    <label for="color" class="input-label">{{ __('messages.color') }}</label>
                    <input id="color" class="input-field input-field-lg" type="text" name="color" value="{{ old('color', $product->color) }}" placeholder="e.g. Red, Navy, Black">
                    <x-input-error :messages="$errors->get('color')" />
                </div>
            </div>
        </div>

        {{-- Media --}}
        <div class="card-hover">
            <div class="border-b border-secondary/10 pb-4 mb-6">
                <h2 class="font-display text-xl text-primary">{{ __('messages.media') }}</h2>
                <p class="text-sm text-secondary/60 mt-1">{{ __('messages.media_desc') }}</p>
            </div>
            <div x-data="{
                previewUrl: '{{ $product->image ? Storage::url($product->image) : '' }}',
                zoomImage: false,
                zoomSrc: '',
                gallery: [],
                existingImages: @js($product->images->map(fn($i) => ['id' => $i->id, 'url' => Storage::url($i->image)])->values()->all()),
                allImages() {
                    let urls = [];
                    if (this.previewUrl) urls.push({ type: 'main', url: this.previewUrl });
                    this.existingImages.forEach(i => urls.push({ type: 'gallery', url: i.url }));
                    return urls;
                },
                openZoom(url) {
                    this.zoomSrc = url;
                    this.zoomImage = true;
                },
                previewFile(event) {
                    const file = event.target.files[0];
                    if (file) {
                        const reader = new FileReader();
                        reader.onload = (e) => this.previewUrl = e.target.result;
                        reader.readAsDataURL(file);
                    }
                },
                addGallery(event) {
                    Array.from(event.target.files).forEach(file => {
                        const reader = new FileReader();
                        reader.onload = (e) => this.gallery.push({ file, url: e.target.result });
                        reader.readAsDataURL(file);
                    });
                },
                removeNewGallery(index) {
                    this.gallery.splice(index, 1);
                },
                markExistingForDelete(id) {
                    let input = document.createElement('input');
                    input.type = 'hidden';
                    input.name = 'delete_images[]';
                    input.value = id;
                    this.$el.appendChild(input);
                    this.existingImages = this.existingImages.filter(i => i.id !== id);
                }
            }">
                {{-- All images grid --}}
                <div class="mb-6">
                    <div class="flex items-center justify-between mb-3">
                        <label class="input-label mb-0">{{ __('messages.product_images') }}</label>
                        <span class="text-xs text-secondary/50" x-text="'(' + allImages().length + ' {{ __('messages.images') }})'"></span>
                    </div>

                    {{-- Main image upload + preview --}}
                    <div class="flex items-start gap-6 mb-6 pb-6 border-b border-secondary/10">
                        <div class="flex-1">
                            <label for="image" class="cursor-pointer inline-flex items-center gap-2.5 px-5 py-3 border-2 border-dashed border-secondary/20 hover:border-tertiary/40 rounded-lg text-secondary hover:text-tertiary transition-all duration-200 group">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                                </svg>
                                <span class="text-sm font-medium">{{ __('messages.choose_image') }}</span>
                            </label>
                            <input id="image" class="hidden" type="file" name="image" accept="image/*" @change="previewFile">
                            <p class="text-xs text-secondary/40 mt-2">{{ __('messages.image_help') }}</p>
                            <x-input-error :messages="$errors->get('image')" />
                        </div>
                        <template x-if="previewUrl">
                            <div class="shrink-0 text-center">
                                <img :src="previewUrl" alt="{{ $product->name }}" class="w-32 h-32 object-cover rounded-lg border border-secondary/10 cursor-pointer shadow-sm hover:shadow-md transition-shadow" @click="openZoom(previewUrl)">
                                <p class="text-xs text-center text-secondary/40 mt-1.5">{{ __('messages.click_to_zoom') }}</p>
                                <span class="inline-block mt-1 text-[10px] font-label uppercase tracking-[0.08em] text-secondary bg-neutral px-2 py-0.5 rounded-sm">{{ __('messages.main_image') }}</span>
                            </div>
                        </template>
                    </div>

                    {{-- Existing gallery grid --}}
                    <template x-if="existingImages.length > 0">
                        <div class="mb-4">
                            <label class="input-label mb-3">{{ __('messages.gallery') }}</label>
                            <div class="grid grid-cols-4 sm:grid-cols-5 md:grid-cols-6 gap-3">
                                <template x-for="img in existingImages" :key="img.id">
                                    <div class="relative group aspect-square rounded-lg overflow-hidden border border-secondary/10 bg-neutral">
                                        <img :src="img.url" alt="" class="w-full h-full object-cover cursor-pointer" @click="openZoom(img.url)">
                                        <div class="absolute inset-x-0 bottom-0 h-8 bg-gradient-to-t from-primary/60 to-transparent opacity-0 group-hover:opacity-100 transition-opacity"></div>
                                        <button type="button" @click="markExistingForDelete(img.id)" class="absolute top-1.5 right-1.5 w-6 h-6 flex items-center justify-center bg-primary/70 text-surface rounded-full opacity-0 group-hover:opacity-100 transition-opacity hover:bg-tertiary z-10">
                                            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                                            </svg>
                                        </button>
                                        <span class="absolute bottom-1 left-1.5 text-[10px] text-surface/80 font-medium opacity-0 group-hover:opacity-100 transition-opacity z-10" x-text="'#' + (1 + existingImages.indexOf(img))"></span>
                                    </div>
                                </template>
                            </div>
                        </div>
                    </template>

                    {{-- Add new + new gallery previews --}}
                    <div>
                        <label for="gallery" class="cursor-pointer inline-flex items-center gap-2.5 px-5 py-3 border-2 border-dashed border-secondary/20 hover:border-tertiary/40 rounded-lg text-secondary hover:text-tertiary transition-all duration-200 group">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                            </svg>
                            <span class="text-sm font-medium">{{ __('messages.add_gallery') }}</span>
                        </label>
                        <input id="gallery" class="hidden" type="file" name="images[]" accept="image/*" multiple @change="addGallery">
                        <p class="text-xs text-secondary/40 mt-2">{{ __('messages.gallery_help') }}</p>
                        <x-input-error :messages="$errors->get('images')" />
                        <x-input-error :messages="$errors->get('images.*')" />

                        <template x-if="gallery.length > 0">
                            <div class="mt-4 grid grid-cols-4 sm:grid-cols-5 md:grid-cols-6 gap-3">
                                <template x-for="(item, index) in gallery" :key="index">
                                    <div class="relative group aspect-square rounded-lg overflow-hidden border border-secondary/10 bg-neutral">
                                        <img :src="item.url" alt="" class="w-full h-full object-cover">
                                        <button type="button" @click="removeNewGallery(index)" class="absolute top-1.5 right-1.5 w-6 h-6 flex items-center justify-center bg-primary/70 text-surface rounded-full opacity-0 group-hover:opacity-100 transition-opacity hover:bg-tertiary">
                                            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                                            </svg>
                                        </button>
                                    </div>
                                </template>
                            </div>
                        </template>
                    </div>
                </div>

                {{-- Zoom lightbox --}}
                <div x-show="zoomImage" x-cloak
                     @keydown.escape.window="zoomImage = false"
                     @click.self="zoomImage = false"
                     class="fixed inset-0 z-[200] flex items-center justify-center bg-primary/80 backdrop-blur-sm p-4"
                     x-transition:enter="ease-out duration-300"
                     x-transition:enter-start="opacity-0"
                     x-transition:enter-end="opacity-100"
                     x-transition:leave="ease-in duration-200"
                     x-transition:leave-start="opacity-100"
                     x-transition:leave-end="opacity-0">
                    <div class="relative max-w-2xl w-full max-h-[90vh] flex items-center justify-center">
                        <button @click="zoomImage = false" class="absolute -top-10 right-0 text-surface/70 hover:text-surface transition-colors">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                            </svg>
                        </button>
                        <img :src="zoomSrc" alt="" class="max-w-full max-h-[85vh] rounded-lg shadow-2xl object-contain bg-surface">
                    </div>
                </div>
            </div>
        </div>

        {{-- Description --}}
        <div class="card-hover">
            <div class="border-b border-secondary/10 pb-4 mb-6">
                <h2 class="font-display text-xl text-primary">{{ __('messages.description') }}</h2>
                <p class="text-sm text-secondary/60 mt-1">{{ __('messages.description_desc') }}</p>
            </div>
            <div x-init="ClassicEditor.create($refs.textarea, { toolbar: ['heading', '|', 'bold', 'italic', 'link', 'bulletedList', 'numberedList', '|', 'blockQuote', 'insertTable', '|', 'undo', 'redo'] }).then(e => editor = e).catch(e => console.error(e))">
                <textarea x-ref="textarea" id="description" class="input-field input-field-lg" name="description" rows="5" placeholder="{{ __('messages.product_desc_placeholder') }}">{{ old('description', $product->description) }}</textarea>
                <x-input-error :messages="$errors->get('description')" />
            </div>
        </div>

        {{-- Status & Submit --}}
        <div class="flex items-center justify-between">
            <div>
                <label class="inline-flex items-center gap-3 cursor-pointer select-none group">
                    <div class="relative">
                        <input type="checkbox" name="is_active" value="1" {{ $product->is_active ? 'checked' : '' }} class="peer sr-only">
                        <div class="w-11 h-6 rounded-full bg-secondary/20 peer-checked:bg-tertiary transition-colors duration-200"></div>
                        <div class="absolute left-0.5 top-0.5 w-5 h-5 rounded-full bg-surface shadow-sm peer-checked:translate-x-5 transition-transform duration-200"></div>
                    </div>
                    <span class="text-sm font-medium text-primary group-hover:text-tertiary transition-colors">{{ __('messages.active_product') }}</span>
                </label>
            </div>
            <div class="flex items-center gap-4">
                <a href="{{ route('products.index') }}" class="px-5 py-2.5 text-sm font-medium text-secondary hover:text-primary transition-colors">{{ __('messages.cancel') }}</a>
                <button type="submit" class="btn-primary px-6 py-2.5" :disabled="loading">
                    <span x-show="!loading">{{ __('messages.save_changes') }}</span>
                    <span x-show="loading" class="flex items-center gap-2">
                        <svg class="w-4 h-4 animate-spin" fill="none" viewBox="0 0 24 24">
                            <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"/>
                            <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4z"/>
                        </svg>
                        {{ __('messages.saving') }}
                    </span>
                </button>
            </div>
        </div>
    </form>
</x-app-layout>
