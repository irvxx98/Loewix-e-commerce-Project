@extends('admin.layout')
@section('admin_content')
<h3 class="fw-bold mb-3">Edit Produk</h3>
<form action="{{ route('admin.products.update', $product) }}" method="POST" enctype="multipart/form-data">
    @csrf
    @method('PUT')
    @include('admin.products._form')
</form>
@endsection