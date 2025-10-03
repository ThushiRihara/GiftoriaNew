<?php

namespace App\Livewire;

use Livewire\Component;
use Illuminate\Support\Facades\Auth;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Shipment;

class CheckoutForm extends Component
{
    public $address_line1, $address_line2, $state, $country;

    public function submit()
    {
        $cart = session()->get('cart', []);
        if(empty($cart)) {
            session()->flash('error', 'Cart is empty!');
            return;
        }

        $order = Order::create([
            'customer_id' => Auth::id(),
            'status' => 'pending',
            'order_date' => now(),
        ]);

        foreach($cart as $giftId => $item) {
            OrderItem::create([
                'order_id' => $order->id,
                'gift_id' => $giftId,
                'quantity' => $item['quantity'],
                'price' => $item['price'],
            ]);
        }

        $order->shipment()->create([
            'address_line1' => $this->address_line1,
            'address_line2' => $this->address_line2,
            'state' => $this->state,
            'country' => $this->country,
        ]);

        session()->put('order_id', $order->id);
        return redirect()->route('payment');
    }

    public function render()
    {
        return view('livewire.checkout-form');
    }
}
