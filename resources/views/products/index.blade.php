<!-- resources/views/products/index.blade.php -->

@extends('layouts.app')

@section('content')
    <div class="container">
        <h1>All Products</h1>
        <a href="{{ route('products.create') }}" class="btn btn-primary">Create New Product</a>
        
        @if ($message = Session::get('success'))
            <div class="alert alert-success mt-3">
                {{ $message }}
            </div>
        @endif

        <table class="table table-bordered mt-3">
            <thead>
                <tr>
                    <th>Name</th>
                    <th>Description</th>
                    <th>Price</th>
                    <th width="200px">Action</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($products as $product)
                    <tr>
                        <td>{{ $product->name }}</td>
                        <td>{{ $product->description }}</td>
                        <td>{{ $product->price }}</td>
                        <td>
                            <a href="{{ route('products.show', $product->id) }}" class="btn btn-info">View</a>
                            <a href="{{ route('products.edit', $product->id) }}" class="btn btn-primary">Edit</a>
                            <form action="{{ route('products.destroy', $product->id) }}" method="POST" style="display:inline;" dusk="delete-product-{{ $product->id }}" class="delete-form">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger">Delete</button>
                            </form>                            
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
@endsection
