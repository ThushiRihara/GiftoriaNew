<!-- @extends('layouts.app')

@section('content')
<div class="container mx-auto py-8">
    <h1 class="text-2xl font-bold mb-6">Payment</h1>

    {{-- Mount the PaymentForm Livewire component --}}
    @livewire('payment-form')
</div>
@endsection -->


@extends('layouts.customer')

@section('content')
    <h1 class="text-2xl font-bold mb-4">Payment</h1>
    @livewire('payment-form')
@endsection
