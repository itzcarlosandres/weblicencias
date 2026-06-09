@props(['product', 'badge' => null])

<a href="{{ route('products.show', $product->slug) }}" class="bg-white rounded-[16px] shadow-[0_2px_10px_-4px_rgba(0,0,0,0.05)] hover:shadow-[0_10px_20px_-10px_rgba(0,0,0,0.1)] hover:-translate-y-1 border border-gray-100 p-2.5 sm:p-3 group flex flex-col h-full transition-all duration-300 relative overflow-hidden">
    @php
        $badgeColorClass = 'bg-blue-600 text-white';
        $badgeIcon = '';
        $badgeText = '';

        if ($product->badge) {
            $badgeColorClass = match($product->badge->color) {
                'red' => 'bg-red-600 text-white',
                'green' => 'bg-emerald-600 text-white',
                'blue' => 'bg-blue-600 text-white',
                'yellow' => 'bg-amber-500 text-white',
                'purple' => 'bg-purple-600 text-white',
                'orange' => 'bg-orange-500 text-white',
                default => 'bg-blue-600 text-white',
            };
            $badgeIcon = $product->badge->icon;
            $badgeText = $product->badge->name;
        }
    @endphp

    @if($badge)
    <div class="absolute top-0 right-0 bg-red-600 text-white text-[9px] sm:text-[10px] font-bold px-2 py-1 rounded-bl-xl z-10 shadow-sm">{{ $badge }}</div>
    @elseif($product->badge)
    <div class="absolute top-2 left-2 {{ $badgeColorClass }} text-[9px] sm:text-[10px] font-black tracking-wider px-1.5 sm:px-2 py-0.5 sm:py-1 rounded-md sm:rounded-lg z-10 shadow-md flex items-center gap-1 sm:gap-1.5 uppercase">
        @if($badgeIcon)<i class="{{ $badgeIcon }}"></i>@endif
        <span>{{ $badgeText }}</span>
    </div>
    @endif
    
    <div class="aspect-[4/5] sm:aspect-[3/4] rounded-xl overflow-hidden mb-2.5 sm:mb-3 relative bg-gray-50/50">
        @if($product->image) 
            <img src="{{ asset('storage/' . $product->image) }}" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500"> 
        @else 
            <div class="w-full h-full flex items-center justify-center text-3xl sm:text-4xl">📦</div> 
        @endif
        <div class="absolute inset-0 bg-gradient-to-t from-black/10 to-transparent opacity-0 group-hover:opacity-100 transition-opacity duration-300"></div>
        <livewire:wishlist-button :product="$product" :key="'wishlist-'.$product->id" />
    </div>
    
    <div class="flex-1 flex flex-col px-0.5 sm:px-0">
        <h3 class="text-[13px] sm:text-sm font-bold text-gray-800 line-clamp-2 mb-1.5 group-hover:text-blue-600 transition-colors leading-snug">{{ $product->name }}</h3>
        <div class="text-[9px] sm:text-[10px] text-gray-400 mb-2.5 flex items-center gap-1 uppercase tracking-wider font-semibold">
            <span class="w-1.5 h-1.5 rounded-full bg-emerald-500 shadow-[0_0_8px_rgba(16,185,129,0.8)]"></span> Global
        </div>
        
        <div class="mt-auto">
            @if($product->has_discount)
            <div class="flex items-center gap-1.5 mb-0.5">
                <span class="bg-red-50 text-red-600 text-[9px] sm:text-[10px] font-bold px-1.5 py-0.5 rounded-md border border-red-100">-{{ $product->discount }}%</span>
                <span class="text-[11px] sm:text-xs text-gray-400 line-through font-medium">{{ currency_format($product->compare_price) }}</span>
            </div>
            @endif
            <div class="text-base sm:text-lg font-black text-gray-900 tracking-tight">{{ currency_format($product->discounted_price) }}</div>
        </div>
    </div>
</a>
