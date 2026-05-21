@props(['name', 'options' => [], 'selected' => '', 'placeholder' => '', 'label' => ''])

<div
    x-data="{
        open: false,
        query: '',
        selectedLabel: '{{ $selected ? (collect($options)->firstWhere('value', $selected)['label'] ?? '') : '' }}',
        selectedValue: '{{ $selected }}',
        highlightedIndex: -1,

        get filtered() {
            if (!this.query) return {{ json_encode(array_values($options)) }};
            const q = this.query.toLowerCase();
            return {{ json_encode(array_values($options)) }}.filter(o => o.label.toLowerCase().includes(q));
        },

        select(option) {
            this.selectedLabel = option.label;
            this.selectedValue = option.value;
            this.query = '';
            this.open = false;
            this.highlightedIndex = -1;
        },

        highlightNext() {
            if (this.highlightedIndex < this.filtered.length - 1) {
                this.highlightedIndex++;
                this.$refs.list.children[this.highlightedIndex]?.scrollIntoView({ block: 'nearest' });
            }
        },

        highlightPrev() {
            if (this.highlightedIndex > 0) {
                this.highlightedIndex--;
                this.$refs.list.children[this.highlightedIndex]?.scrollIntoView({ block: 'nearest' });
            }
        },

        selectHighlighted() {
            if (this.highlightedIndex >= 0 && this.filtered[this.highlightedIndex]) {
                this.select(this.filtered[this.highlightedIndex]);
            }
        }
    }"
    x-on:keydown.down.prevent="highlightNext"
    x-on:keydown.up.prevent="highlightPrev"
    x-on:keydown.enter.prevent="selectHighlighted"
    x-on:keydown.escape.prevent="open = false"
    @click.outside="open = false"
    class="relative"
>
    @if ($label)
        <label class="input-label">{{ $label }}</label>
    @endif

    <input type="hidden" name="{{ $name }}" :value="selectedValue">

    <div class="relative">
        <input
            type="text"
            x-model="query"
            x-on:focus="open = true"
            x-on:input="highlightedIndex = -1; open = true"
            :placeholder="selectedLabel || '{{ $placeholder }}'"
            class="input-field input-field-lg pr-10"
            autocomplete="off"
        >
        <svg class="absolute right-4 top-1/2 -translate-y-1/2 w-4 h-4 text-secondary/50 pointer-events-none" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
        </svg>
    </div>

    <div
        x-show="open && filtered.length > 0"
        x-cloak
        x-transition:enter="ease-out duration-150"
        x-transition:enter-start="opacity-0 -translate-y-1"
        x-transition:enter-end="opacity-100 translate-y-0"
        x-transition:leave="ease-in duration-100"
        x-transition:leave-start="opacity-100 translate-y-0"
        x-transition:leave-end="opacity-0 -translate-y-1"
        class="absolute z-50 mt-1 w-full bg-surface border border-secondary/15 rounded-lg shadow-lg max-h-60 overflow-y-auto"
        x-ref="list"
    >
        <template x-for="(option, index) in filtered" :key="option.value">
            <div
                x-on:mousedown.prevent="select(option)"
                x-on:mouseenter="highlightedIndex = index"
                :class="{
                    'bg-tertiary/10 text-tertiary': selectedValue === option.value,
                    'bg-neutral/60': highlightedIndex === index && selectedValue !== option.value,
                    'hover:bg-neutral/60': selectedValue !== option.value
                }"
                class="px-4 py-2.5 text-sm text-primary cursor-pointer transition-colors flex items-center justify-between"
            >
                <span x-text="option.label"></span>
                <svg x-show="selectedValue === option.value" class="w-4 h-4 text-tertiary shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                </svg>
            </div>
        </template>
    </div>

    <div x-show="open && query && filtered.length === 0" x-cloak
         class="absolute z-50 mt-1 w-full bg-surface border border-secondary/15 rounded-lg shadow-lg p-4 text-sm text-secondary/60 text-center">
        {{ __('messages.no_results') }}
    </div>
</div>
