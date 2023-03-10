@extends('layouts.main')

@section('content')
    <section id="About">
        <h1 class="text-center mt-3">About Page</h1>
        <hr>
        <div class="col-md-3 mx-auto">
            <div class="card" style="width: 18rem;">
                <img src={{ $image }} class="card-img-top" alt="about">
                <div class="card-body">
                    <h5 class="card-title">{{ $name }}</h5>
                    <p class="card-text">{{ $alamat }}</p>
                    <small>{{ $job }}</small>
                </div>
            </div>
        </div>
    </section>
@endsection
