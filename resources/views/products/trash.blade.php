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
            <h6 class="m-0 font-weight-bold text-primary">List Trash Data Products</h6>
            <a href="{{ route('products.index') }}" class="btn btn-outline-primary">List Products</a>
        </div>
        <div class="card-body">
            {{-- table --}}
            <table class="table table-responsive-sm">
                <thead>
                    <tr>
                        <th scope="col" class="align-middle">#</th>
                        <th scope="col" class="align-middle">Image</th>
                        <th scope="col" class="align-middle">Name Product</th>
                        <th scope="col" class="align-middle">Deleted At</th>
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
                                <td class="align-middle">{{ $item->deleted_at }}</td>
                                <td class="align-middle">
                                    {{-- tombol restore --}}
                                    <a href="{{ route('products.restore', $item->id) }}" class="btn btn-success">
                                        <i class="fas fa-undo"></i>
                                    </a>
                                    {{-- force Delete --}}
                                    <form action="{{ route('products.force-delete', $item->id) }}" class="d-inline"
                                        method="POST">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-danger"
                                            onclick="return confirm('Apakah anda yakin ingin menghapus secara permanent?')">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </form>

                                </td>
                            </tr>
                        @endforeach
                    @else
                        <tr>
                            <td colspan="5" class="text-center">Data sampah produk kosong</td>
                        </tr>
                    @endif
                </tbody>
            </table>
            {{-- untuk pagination --}}
            {{ $products->links() }}
        </div>
    </div>
@endsection
