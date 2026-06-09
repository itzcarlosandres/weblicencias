<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Product;
use Illuminate\Support\Facades\Auth;

class WishlistButton extends Component
{
    public $product;
    public $inWishlist = false;
    public $class = "absolute top-2 right-2 w-8 h-8 rounded-full bg-white/90 backdrop-blur-sm shadow-sm flex items-center justify-center transition-all hover:scale-110 z-20 group";

    public function mount(Product $product, $class = null)
    {
        $this->product = $product;
        if ($class) {
            $this->class = $class;
        }
        
        if (Auth::check()) {
            $this->inWishlist = Auth::user()->wishlists()->where('product_id', $this->product->id)->exists();
        }
    }

    public function toggleWishlist()
    {
        if (!Auth::check()) {
            return redirect()->route('login');
        }

        $user = Auth::user();

        if ($this->inWishlist) {
            $user->wishlists()->where('product_id', $this->product->id)->delete();
            $this->inWishlist = false;
        } else {
            $user->wishlists()->create(['product_id' => $this->product->id]);
            $this->inWishlist = true;
        }
    }

    public function render()
    {
        return view('livewire.wishlist-button');
    }
}
