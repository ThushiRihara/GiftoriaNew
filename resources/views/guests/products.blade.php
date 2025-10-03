@extends('layouts.customer')

@section('content')
<div class="max-w-7xl mx-auto py-6 px-4">
    <h2 class="text-2xl font-bold mb-4">Products</h2>

    @foreach($categories as $category)
        <h3 class="text-xl font-semibold mt-6 mb-2">{{ $category->name }}</h3>
        <div class="grid grid-cols-4 gap-4">
            @foreach($category->gifts as $gift)
            <div class="border p-2 rounded">
                <img src="{{ asset('storage/'.$gift->image) }}" class="w-full h-40 object-cover mb-2">
                <h4 class="font-semibold">{{ $gift->name }}</h4>
                <p>Rs {{ $gift->price }}</p>
                <a href="{{ route('products.show', $gift->id) }}" class="bg-blue-500 text-white px-2 py-1 rounded mt-2 inline-block">View</a>
            </div>
            @endforeach
        </div>
    @endforeach
</div>
@endsection
