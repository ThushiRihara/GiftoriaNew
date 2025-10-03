@extends('layouts.customer')

@section('content')
    @livewire('product-details', ['id' => $gift->id])
@endsection
