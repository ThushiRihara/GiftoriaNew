@extends('layouts.customer')

@section('content')
    <h1 class="text-2xl font-bold mb-4 text-green-600">Order Placed Successfully!</h1>
    <p>Thank you for your purchase. Your order has been received.</p>
    <a href="{{ route('home') }}" class="bg-blue-600 text-white px-4 py-2 rounded mt-4 inline-block">Back to Home</a>
@endsection
