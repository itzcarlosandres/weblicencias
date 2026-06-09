<?php

namespace App\Livewire\Home;

use Livewire\Component;
use App\Models\Product;
use App\Models\Category;

class HeroSection extends Component
{
    public string $search = '';

    public function search()
    {
        if (!empty(trim($this->search))) {
            return redirect()->route('products.index', ['search' => $this->search]);
        }
    }

    public function render()
    {
        return view('livewire.home.hero-section');
    }
}
