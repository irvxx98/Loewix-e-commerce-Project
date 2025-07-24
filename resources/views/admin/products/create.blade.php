@extends('admin.layout')
@section('admin_content')
<h3 class="fw-bold mb-3">Tambah Produk Baru</h3>
<form action="{{ route('admin.products.store') }}" method="POST" enctype="multipart/form-data">
    @csrf
    @include('admin.products._form')
</form>
@endsection