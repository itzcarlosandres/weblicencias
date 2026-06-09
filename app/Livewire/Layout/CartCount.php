<?php

namespace App\Livewire\Layout;

use Livewire\Component;
use Illuminate\Support\Facades\Session;

class CartCount extends Component
{
    public int $count = 0;

    protected $listeners = [
        'cartUpdated' => 'refreshCount',
        'cartItemAdded' => 'refreshCount',
    ];

    public function mount(): void
    {
        $this->refreshCount();
    }

    public function refreshCount(): void
    {
        $this->count = array_sum(array_column(Session::get('cart', []), 'quantity'));
    }

    public function render()
    {
        return <<<'HTML'
        <div>
            @if($count > 0)
                <span class="absolute -top-1.5 -right-1.5 w-[16px] h-[16px] bg-[#f48024] text-white text-[9px] font-bold rounded-full flex items-center justify-center border border-[#12141d]">{{ $count }}</span>
            @endif
        </div>
        HTML;
    }
}
