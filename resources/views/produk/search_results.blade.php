@extends('layouts.app')

@section('content')
<div class="container">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2 class="mb-0">Hasil pencarian untuk: <span class="text-primary">"{{ $query }}"</span></h2>
        <span class="text-muted">{{ $produks->total() }} produk ditemukan</span>
    </div>

    <div class="row row-cols-2 row-cols-md-4 row-cols-lg-6 g-3">
        @forelse ($produks as $produk)
        @include('partials.product_card', ['produk' => $produk])
        @empty
        <div class="col-12">
            <div class="alert alert-warning text-center">
                Produk yang cocok dengan pencarian Anda tidak ditemukan. Coba gunakan kata kunci lain.
            </div>
        </div>
        @endforelse
    </div>

    <div class="d-flex justify-content-center mt-5">
        {{ $produks->appends(request()->input())->links() }}
    </div>
</div>
@endsection