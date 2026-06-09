<?php

namespace App\Livewire\Layout;

use Livewire\Component;
use Illuminate\Support\Facades\Session;

class CartDropdown extends Component
{
    public int $count = 0;
    public float $total = 0;

    protected $listeners = [
        'cartUpdated' => 'refreshCart',
        'cartItemAdded' => 'refreshCart',
    ];

    public function mount(): void
    {
        $this->refreshCart();
    }

    public function refreshCart(): void
    {
        $cart = Session::get('cart', []);
        $this->count = array_sum(array_column($cart, 'quantity'));
        $this->total = array_reduce($cart, fn($sum, $item) => $sum + ($item['price'] * $item['quantity']), 0);
    }

    public function render()
    {
        $cart = Session::get('cart', []);

        return view('livewire.layout.cart-dropdown', [
            'cartItems' => collect($cart),
        ]);
    }
}
