<div> <!-- single root -->
    @if($payment_success)
        <h2 class="text-2xl font-bold">Payment Successful!</h2>
        <p>Your order has been placed.</p>
        <a href="{{ route('home') }}" class="bg-blue-600 text-white px-4 py-2 rounded mt-4 inline-block">Back to Home</a>
    @else
        <h2 class="text-xl font-bold mb-4">Payment Details</h2>
        <form wire:submit.prevent="payNow" class="space-y-2">
            <input type="text" wire:model="card_number" placeholder="Card Number" class="border px-2 py-1 w-full">
            <input type="text" wire:model="expiry" placeholder="Expiry MM/YY" class="border px-2 py-1 w-full">
            <input type="text" wire:model="cvc" placeholder="CVC" class="border px-2 py-1 w-full">

            <button type="submit" class="bg-green-600 text-white px-4 py-2 rounded">Pay Now</button>
        </form>
    @endif
</div>
