<div
    x-data="{
        toasts: [],
        add(type, message) {
            const id = Date.now() + Math.random();
            this.toasts.push({ id, type, message });
            setTimeout(() => { this.remove(id); }, 4500);
        },
        remove(id) {
            this.toasts = this.toasts.filter(t => t.id !== id);
        }
    }"
    x-on:toast.window="add($event.detail.type, $event.detail.message)"
    class="fixed top-5 right-5 z-[100] flex flex-col-reverse gap-3 max-w-sm w-full pointer-events-none"
>
    <template x-for="(toast, index) in toasts" :key="toast.id">
        <div
            x-show="toast"
            x-transition:enter="transition ease-out duration-400"
            x-transition:enter-start="opacity-0 translate-x-8 scale-95"
            x-transition:enter-end="opacity-100 translate-x-0 scale-100"
            x-transition:leave="transition ease-in duration-300"
            x-transition:leave-start="opacity-100 translate-x-0 scale-100"
            x-transition:leave-end="opacity-0 translate-x-8 scale-95"
            class="pointer-events-auto flex items-start gap-3 px-5 py-4 rounded-lg shadow-xl border-l-4 relative overflow-hidden"
            :class="toast.type === 'success' ? 'bg-surface border-l-tertiary' : 'bg-surface border-l-secondary'"
            :style="'transform: translateY(' + (index * -8) + 'px)'"
        >
            <template x-if="toast.type === 'success'">
                <svg class="w-5 h-5 shrink-0 mt-0.5 text-tertiary animate-bounce" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                </svg>
            </template>
            <template x-if="toast.type === 'error'">
                <svg class="w-5 h-5 shrink-0 mt-0.5 text-secondary" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                </svg>
            </template>
            <p class="text-sm text-primary flex-1" x-text="toast.message"></p>
            <button @click="remove(toast.id)" class="shrink-0 text-secondary hover:text-primary transition-colors">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                </svg>
            </button>

            <span
                class="absolute bottom-0 left-0 h-0.5 bg-tertiary/30"
                style="animation: toast-shrink 4.5s linear forwards"
            ></span>
        </div>
    </template>
</div>