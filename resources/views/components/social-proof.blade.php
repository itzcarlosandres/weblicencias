<div x-data="socialProof()" 
     x-show="show" 
     x-transition:enter="transition ease-out duration-300 transform"
     x-transition:enter-start="opacity-0 translate-y-10"
     x-transition:enter-end="opacity-100 translate-y-0"
     x-transition:leave="transition ease-in duration-300 transform"
     x-transition:leave-start="opacity-100 translate-y-0"
     x-transition:leave-end="opacity-0 translate-y-10"
     class="fixed bottom-4 left-4 z-50 w-[calc(100%-2rem)] bg-white rounded-2xl shadow-xl border border-gray-100 overflow-hidden"
     style="display: none; max-width: 320px;">
    <div class="p-3 flex items-start gap-3 relative">
        <button @click="close()" class="absolute top-2 right-2 text-gray-400 hover:text-gray-600 transition-colors">
            <i class="fa-solid fa-xmark"></i>
        </button>
        <div class="w-12 h-12 rounded-xl bg-gray-50 flex items-center justify-center shrink-0 border border-gray-100 overflow-hidden">
            <template x-if="data.product_image">
                <img :src="data.product_image" class="w-full h-full object-cover">
            </template>
            <template x-if="!data.product_image">
                <div class="text-xl">📦</div>
            </template>
        </div>
        <div class="flex-1 min-w-0 pr-4">
            <div class="text-[12px] text-gray-500 mb-0.5">
                <strong x-text="data.name" class="text-gray-900"></strong> de <span x-text="data.country"></span> acaba de comprar:
            </div>
            <a :href="data.product_url" class="text-[13px] font-bold text-blue-600 hover:underline line-clamp-1 leading-snug" x-text="data.product_name"></a>
            <div class="text-[11px] text-gray-400 flex items-center gap-1 mt-1">
                <i class="fa-regular fa-clock"></i> Hace <span x-text="data.time_ago"></span>
            </div>
        </div>
    </div>
</div>

<script>
document.addEventListener('alpine:init', () => {
    Alpine.data('socialProof', () => ({
        show: false,
        data: {},
        interval: null,
        
        init() {
            // Esperar un poco antes de mostrar la primera (5 a 15 segundos)
            setTimeout(() => {
                this.fetchData();
            }, Math.floor(Math.random() * 10000) + 5000);
            
            // Luego mostrar una cada 30 a 60 segundos
            this.interval = setInterval(() => {
                if(!this.show) {
                    this.fetchData();
                }
            }, Math.floor(Math.random() * 30000) + 30000);
        },
        
        fetchData() {
            fetch('{{ route('api.social-proof') }}')
                .then(res => res.json())
                .then(res => {
                    if (res.success) {
                        this.data = res;
                        this.show = true;
                        
                        // Ocultar automáticamente después de 6 segundos
                        setTimeout(() => {
                            this.show = false;
                        }, 6000);
                    }
                })
                .catch(err => console.log('Social proof error', err));
        },
        
        close() {
            this.show = false;
        }
    }));
});
</script>
