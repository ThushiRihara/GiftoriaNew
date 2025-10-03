@extends('layouts.customer')

@section('content')
<div class="max-w-7xl mx-auto py-6 px-4">
    <h1 class="text-3xl font-bold mb-4">Welcome to Giftoria</h1>
    <p class="mb-4">Discover amazing gifts for your loved ones!</p>

    <a href="{{ route('products') }}" class="bg-blue-600 text-white px-4 py-2 rounded">Browse Products</a>
</div>
@endsection
