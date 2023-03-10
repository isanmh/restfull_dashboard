@extends('layouts.backend')

@section('content')
    {{-- flash message session --}}
    @if (session()->has('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    <div class="card shadow mb-4">
        <div class="card-header py-3 d-flex justify-content-between align-items-center">
            <h6 class="m-0 font-weight-bold text-primary">List Data Products</h6>
            <a href="{{ route('products.create') }}" class="btn btn-outline-primary">Add</a>
        </div>
        <div class="card-body">
            {{-- search form --}}
            <form action="{{ route('products.index') }}" method="get">
                <input type="search" name="search" placeholder="Search Prduct..." value="{{ request()->search }}"
                    class="form-control mb-2">
            </form>
            {{-- table --}}
            <table class="table table-responsive-sm">
                <thead>
                    <tr>
                        <th scope="col" class="align-middle">#</th>
                        <th scope="col" class="align-middle">Image</th>
                        <th scope="col" class="align-middle">Name Product</th>
                        <th scope="col" class="align-middle">Price</th>
                        <th scope="col" class="align-middle">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    {{-- logika jika data kosong --}}
                    {{-- @if ($products->count() > 0) --}}
                    @if ($products->isEmpty() == false)
                        {{-- looping data --}}
                        @foreach ($products as $item)
                            <tr>
                                {{-- <th class="align-middle">{{ $loop->iteration }}</th> --}}
                                <th class="align-middle">{{ $products->firstItem() + $loop->index }}</th>
                                <td class="align-middle">
                                    <img src="{{ asset('assets/images/' . $item->image) }}" alt="{{ $item->image }}"
                                        height="50">
                                </td>
                                <td class="align-middle">{{ $item->name }}</td>
                                <td class="align-middle">$. {{ $item->price }}</td>
                                <td class="align-middle">
                                    <a href="{{ route('products.show', $item->id) }}" class="btn btn-success">
                                        <i class="fas fa-eye"></i>
                                    </a>
                                    <a href="{{ route('products.edit', $item->id) }}" class="btn btn-warning">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                    {{-- form delete  --}}
                                    <form action="{{ route('products.destroy', $item->id) }}" class="d-inline"
                                        method="POST">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-danger"
                                            onclick="return confirm('Apakah anda yakin ingin menghapus?')">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </form>

                                </td>
                            </tr>
                        @endforeach
                    @else
                        <tr>
                            <td colspan="5" class="text-center">Data produk kosong</td>
                        </tr>
                    @endif
                </tbody>
            </table>
            {{-- untuk pagination --}}
            {{ $products->links() }}
        </div>
    </div>
@endsection
