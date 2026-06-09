<button wire:click.prevent="toggleWishlist" class="{{ $class }}">
    @if($inWishlist)
        <i class="fa-solid fa-heart text-red-500 text-sm"></i>
    @else
        <i class="fa-regular fa-heart text-gray-400 group-hover:text-red-400 text-sm transition-colors"></i>
    @endif
</button>
