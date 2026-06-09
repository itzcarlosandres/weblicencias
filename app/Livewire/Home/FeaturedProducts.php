<?php

namespace App\Livewire\Home;

use Livewire\Component;
use App\Models\Product;

class FeaturedProducts extends Component
{
    public function render()
    {
        $products = Product::where('is_active', true)
            ->where('is_featured', true)
            ->with('category')
            ->limit(8)
            ->get();

        return view('livewire.home.featured-products', compact('products'));
    }
}
