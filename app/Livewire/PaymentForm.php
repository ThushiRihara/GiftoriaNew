<?php

namespace App\Livewire;

use Livewire\Component;
use Illuminate\Support\Facades\Auth;
use App\Models\Order;
use App\Models\Payment;

class PaymentForm extends Component
{
    public $card_number, $cvv, $expiry_date;

    public function submit()
    {
        $orderId = session()->get('order_id');
        $order = Order::findOrFail($orderId);

        Payment::create([
            'order_id' => $order->id,
            'payment_method' => 'card',
            'total_amount' => $order->orderItems->sum(fn($item) => $item->price * $item->quantity),
            'payment_date' => now(),
            'card_number' => $this->card_number,
            'cvv' => $this->cvv,
            'expiry_date' => $this->expiry_date,
        ]);

        $order->update(['status' => 'paid']);

        session()->forget('cart');
        return redirect()->route('order.success');
    }

    public function render()
    {
        return view('livewire.payment-form');
    }
}
