@extends('layouts.backend')

@section('content')
    <section id="Edit">
        <div class="row">
            <div class="col">
                <div class="card">
                    <div class="card-header text-primary d-flex justify-content-between align-items-center">
                        <h5>Dashboard | Form Edit Product</h5>
                        <a href="{{ route('products.index') }}" class="btn btn-success">List Products</a>
                    </div>
                    <div class="card-body">
                        <form action="{{ route('products.update', $product->id) }}" method="POST"
                            enctype="multipart/form-data">
                            @csrf
                            @method('PUT')
                            <div class="col-md-6">
                                <label for="name">Product Name</label>
                                <input type="text" class="form-control @error('name') is-invalid @enderror"
                                    id="name" name="name" value="{{ $product->name }}">
                                @error('name')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>
                            <div class="col-md-6">
                                <label for="price">Price</label>
                                <input type="number" class="form-control @error('price') is-invalid @enderror"
                                    id="price" name="price" value="{{ $product->price }}">
                                @error('price')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>
                            <div class="col-md-6">
                                <label for="description">Description</label>
                                <textarea name="description" id="description" cols="20" rows="5"
                                    class="form-control @error('description') is-invalid @enderror">{{ $product->description }}</textarea>
                                @error('description')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>
                            <div class="col-md-6">
                                <label for="image">Image</label>
                                <br>
                                <img src="{{ asset('assets/images/' . $product->image) }}" alt="{{ $product->image }}"
                                    width="100">
                                <input type="file" class="form-control @error('image') is-invalid @enderror"
                                    id="image" name="image" value="{{ $product->image }}">
                                @error('image')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>
                            <div class="col-md-6 mt-3">
                                <button class="btn btn-primary">Submit</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
