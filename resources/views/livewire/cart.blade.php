<div> <!-- single root -->
    @if(count($cart) > 0)
        <table class="w-full border">
            <thead>
                <tr>
                    <th>Product</th>
                    <th>Price</th>
                    <th>Quantity</th>
                    <th>Subtotal</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                @foreach($cart as $id => $item)
                <tr>
                    <td>{{ $item['name'] }}</td>
                    <td>Rs {{ $item['price'] }}</td>
                    <td>
                        <input type="number" min="1" wire:change="updateQuantity({{ $id }}, $event.target.value)" value="{{ $item['quantity'] }}">
                    </td>
                    <td>Rs {{ $item['price'] * $item['quantity'] }}</td>
                    <td><button wire:click="remove({{ $id }})" class="text-red-600">Remove</button></td>
                </tr>
                @endforeach
            </tbody>
        </table>

        <p class="mt-4 font-bold">Total: Rs {{ $this->total }}</p>
        <a href="{{ route('checkout') }}" class="bg-blue-600 text-white px-4 py-2 rounded">Proceed to Checkout</a>
    @else
        <p>Your cart is empty.</p>
    @endif
</div>
