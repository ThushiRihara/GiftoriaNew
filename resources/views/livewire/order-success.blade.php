@extends('layouts.customer')

@section('content')
<div class="text-center py-20">
    <h1 class="text-3xl font-bold mb-4">Order Successful!</h1>
    <p class="mb-6">Thank you for your purchase. Your order has been placed successfully.</p>
    <a href="{{ route('home') }}" class="bg-blue-600 text-white px-4 py-2 rounded">Return Home</a>
</div>
@endsection
