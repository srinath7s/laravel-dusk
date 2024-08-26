<!-- resources/views/products/show.blade.php -->

@extends('layouts.app')

@section('content')
    <div class="container">
        <h1>{{ $product->name }}</h1>
        <p>{{ $product->description }}</p>
        <p><strong>Price:</strong> {{ $product->price }}</p>
        <a href="{{ route('products.index') }}" class="btn btn-secondary">Back to Products</a>
    </div>
@endsection
