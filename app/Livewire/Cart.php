<?php

namespace App\Livewire;

use Livewire\Component;

class Cart extends Component
{
    public $cart = [];
    public $total = 0;

    protected $listeners = ['cartUpdated' => 'loadCart'];

    public function mount()
    {
        $this->loadCart();
    }

    public function loadCart()
    {
        $this->cart = session()->get('cart', []);
        $this->total = collect($this->cart)->sum(fn($item) => $item['price'] * $item['quantity']);
    }

    public function removeItem($giftId)
    {
        $cart = session()->get('cart', []);
        unset($cart[$giftId]);
        session()->put('cart', $cart);
        $this->loadCart();
    }

    public function render()
    {
        return view('livewire.cart');
    }
}
