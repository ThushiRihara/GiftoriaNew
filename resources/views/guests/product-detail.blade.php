@extends('layouts.customer')

@section('content')
<div class="max-w-4xl mx-auto py-6 px-4">
    <div class="flex gap-6">
        <img src="{{ asset('storage/'.$gift->image) }}" class="w-96 h-96 object-cover">
        <div>
            <h2 class="text-2xl font-bold">{{ $gift->name }}</h2>
            <p class="text-lg mb-2">Rs {{ $gift->price }}</p>
            <p class="mb-4">{{ $gift->description }}</p>

            @auth
                <form action="{{ route('cart.add', $gift->id) }}" method="POST">
                    @csrf
                    <label>Quantity:</label>
                    <input type="number" name="quantity" value="1" min="1" class="border px-2 py-1 w-16 mb-2">
                    <br>
                    <button type="submit" class="bg-green-600 text-white px-4 py-2 rounded">Add to Cart</button>
                </form>
            @else
                <a href="{{ route('login') }}" class="bg-blue-600 text-white px-4 py-2 rounded">Login to Add to Cart</a>
            @endauth
        </div>
    </div>
</div>
@endsection
