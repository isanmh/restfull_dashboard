@extends('layouts.backend')

@section('content')
    <section id="Detail" class="card">
        <div class="card-header d-flex justify-content-between align-item">
            <h5 class="mt-3 text-primary">Detail Product</h5>
            <a href="{{ route('products.index') }}" class="btn btn-primary">Back</a>
        </div>
        <div class="col-md-8">
            <div class="card-body" style="width: 18rem;">
                <img src="{{ asset('assets/images/' . $product->image) }}" class="card-img-top" alt="detail">
                <div class="card-body">
                    <h5 class="card-title">{{ $product->name }}</h5>
                    <p class="card-text">{{ $product->description }}</p>
                    <small>$. {{ $product->price }}</small>
                </div>
            </div>
        </div>
    </section>
@endsection
