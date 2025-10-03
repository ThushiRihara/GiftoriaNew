<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Gift;
use Illuminate\Support\Facades\Auth;

class giftDetails extends Component
{
    public $gift;
    public $quantity = 1;

    public function mount($id)
    {
        $this->gift = Gift::findOrFail($id);
    }

    public function addToCart()
    {
        if (!Auth::check()) {
            session()->flash('error', 'Please login to add items to cart.');
            return redirect()->route('login');
        }

        $cart = session()->get('cart', []);
        $cart[$this->gift->id] = [
            'name' => $this->gift->name,
            'price' => $this->gift->price,
            'quantity' => $this->quantity,
            'image' => $this->gift->image,
        ];
        session()->put('cart', $cart);

        session()->flash('success', 'Added to cart!');
    }

    public function render()
    {
        return view('livewire.gift-details');
    }
}
