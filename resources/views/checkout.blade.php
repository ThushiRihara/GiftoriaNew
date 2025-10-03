<!-- @extends('layouts.app')

@section('content')
<div class="container mx-auto py-8">
    <h1 class="text-2xl font-bold mb-6">Checkout</h1>

    {{-- Mount the CheckoutForm Livewire component --}}
    @livewire('checkout-form')
</div>
@endsection -->


@extends('layouts.customer')

@section('content')
    <h1 class="text-2xl font-bold mb-4">Checkout</h1>
    @livewire('checkout-form')
@endsection
