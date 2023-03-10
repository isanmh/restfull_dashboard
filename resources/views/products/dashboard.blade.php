@extends('layouts.backend')

@section('content')
    <div class="card mb-4">
        <div class="card-header">
            Selamat datang di dashboard : {{ Auth::user()->name }}
        </div>
        <div class="card-body">
            ....
        </div>
    </div>
@endsection
