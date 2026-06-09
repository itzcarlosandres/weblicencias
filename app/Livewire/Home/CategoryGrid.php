<?php

namespace App\Livewire\Home;

use Livewire\Component;
use App\Models\Category;

class CategoryGrid extends Component
{
    public function render()
    {
        $categories = Category::where('is_active', true)
            ->whereNull('parent_id')
            ->withCount(['products as products_count' => function ($q) {
                $q->where('is_active', true);
            }])
            ->orderBy('order')
            ->limit(10)
            ->get();

        return view('livewire.home.category-grid', compact('categories'));
    }
}
