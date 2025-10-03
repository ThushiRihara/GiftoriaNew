<div> <!-- single root -->
    <h2 class="text-xl font-bold mb-4">Shipping Details</h2>

    <form wire:submit.prevent="proceedToPayment" class="space-y-2">
        <input type="text" wire:model="shipping_address" placeholder="Address" class="border px-2 py-1 w-full">
        <input type="text" wire:model="city" placeholder="City" class="border px-2 py-1 w-full">
        <input type="text" wire:model="postal_code" placeholder="Postal Code" class="border px-2 py-1 w-full">
        <input type="text" wire:model="country" placeholder="Country" class="border px-2 py-1 w-full">

        @error('shipping') <span class="text-red-500">{{ $message }}</span> @enderror

        <p class="mt-2 font-bold">Total: Rs {{ $total }}</p>
        <button type="submit" class="bg-green-600 text-white px-4 py-2 rounded">Proceed to Payment</button>
    </form>
</div>
