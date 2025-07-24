@extends('dealer.layout')
@section('dealer_content')
<div class="row">
    <div class="col-md-5">
        <h3 class="fw-bold">Tambah Banner Baru</h3>
        <div class="card shadow-sm border-0">
            <div class="card-body">
                <form action="{{ route('dealer.banners.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="mb-3"><label class="form-label">Judul</label><input type="text" name="title" class="form-control" required></div>
                    <div class="mb-3"><label class="form-label">Gambar</label><input type="file" name="image" class="form-control" required></div>
                    <button type="submit" class="btn btn-primary">Tambah</button>
                </form>
            </div>
        </div>
    </div>
    <div class="col-md-7">
        <h3 class="fw-bold">Banner Aktif</h3>
        @forelse($banners as $banner)
        <div class="card mb-3">
            <div class="card-body d-flex justify-content-between align-items-center">
                <img src="{{ asset('storage/' . $banner->image) }}" height="50">
                <span>{{ $banner->title }}</span>
                <form action="{{ route('dealer.banners.destroy', $banner) }}" method="POST">
                    @csrf @method('DELETE')
                    <button type="submit" class="btn btn-sm btn-danger">&times;</button>
                </form>
            </div>
        </div>
        @empty
        <p>Belum ada banner.</p>
        @endforelse
    </div>
</div>
@endsection