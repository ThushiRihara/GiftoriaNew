<div> <!-- single root -->
    <div class="flex gap-6">
        <img src="{{ asset('storage/'.$gift->image) }}" class="w-96 h-96 object-cover">
        <div>
            <h2 class="text-2xl font-bold">{{ $gift->name }}</h2>
            <p class="text-lg mb-2">Rs {{ $gift->price }}</p>
            <p class="mb-4">{{ $gift->description }}</p>

            @if(session()->has('error'))
                <p class="text-red-500">{{ session('error') }}</p>
            @endif

            <input type="number" wire:model="quantity" min="1" class="border px-2 py-1 w-16 mb-2">
            <br>
            <button wire:click="addToCart" class="bg-green-600 text-white px-4 py-2 rounded">Add to Cart</button>
        </div>
    </div>
</div>
