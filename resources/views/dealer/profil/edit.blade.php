@extends('dealer.layout')
@section('dealer_content')
<h3 class="fw-bold mb-3">Profil Toko & Alamat</h3>

<div class="card shadow-sm border-0 mb-4">
    <div class="card-header bg-white py-3">
        <h5 class="mb-0 fw-semibold">Edit Informasi Toko</h5>
    </div>
    <div class="card-body p-4">
        @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
        @endif
        <form action="{{ route('dealer.profil.update') }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')
            <div class="mb-3">
                <label for="store_name" class="form-label">Nama Toko</label>
                <input type="text" name="store_name" id="store_name" class="form-control" value="{{ old('store_name', $user->dealerProfile->store_name ?? '') }}" required>
            </div>
            <div class="mb-3">
                <label for="store_description" class="form-label">Deskripsi Toko</label>
                <textarea name="store_description" id="store_description" class="form-control" rows="5">{{ old('store_description', $user->dealerProfile->store_description ?? '') }}</textarea>
            </div>
            <div class="mb-3">
                <label for="store_logo" class="form-label">Logo Toko</label>
                <input type="file" name="store_logo" id="store_logo" class="form-control">
                <small class="form-text text-muted">Unggah logo baru untuk mengganti yang lama.</small>
            </div>
            @if($user->dealerProfile && $user->dealerProfile->store_logo)
            <div class="mb-4">
                <p class="form-label mb-1">Logo Saat Ini:</p>
                <img src="{{ asset('storage/' . $user->dealerProfile->store_logo) }}" alt="Logo" class="img-thumbnail" width="150">
            </div>
            @endif
            <div class="mb-3">
                <label for="store_image" class="form-label">Gambar Header Toko</label>
                <input type="file" name="store_image" id="store_image" class="form-control">
                <small class="form-text text-muted">Gambar ini akan tampil di halaman daftar dealer.</small>
            </div>
            @if($user->dealerProfile && $user->dealerProfile->store_image)
            <div class="mb-4">
                <p class="form-label mb-1">Gambar Header Saat Ini:</p>
                <img src="{{ asset('storage/' . $user->dealerProfile->store_image) }}" alt="Gambar Toko" class="img-thumbnail" width="300">
            </div>
            @endif
            <button type="submit" class="btn btn-primary px-4">Simpan Informasi Toko</button>
        </form>
    </div>
</div>

<div class="card shadow-sm border-0">
    <div class="card-header bg-white py-3 d-flex justify-content-between align-items-center">
        <h5 class="mb-0 fw-semibold">Manajemen Alamat Pengiriman</h5>
        <button type="button" class="btn btn-sm btn-outline-primary" data-bs-toggle="modal" data-bs-target="#addAddressModal">Tambah Alamat Baru</button>
    </div>
    <div class="card-body p-4">
        @if(session('success_address'))
        <div class="alert alert-success">{{ session('success_address') }}</div>
        @endif
        @forelse($user->addresses as $address)
        <div class="d-flex justify-content-between align-items-center mb-2 pb-2 @if(!$loop->last) border-bottom @endif">
            <div>
                <strong>{{ $address->receiver_name }}</strong> ({{ $address->receiver_phone }})<br>
                <small class="text-muted">{{ $address->address }}, {{ $address->city }}</small>
            </div>
            <form action="{{ route('dealer.profil.address.destroy', $address) }}" method="POST" onsubmit="return confirm('Yakin ingin hapus alamat ini?');">
                @csrf
                @method('DELETE')
                <button type="submit" class="btn btn-sm btn-light text-danger">&times;</button>
            </form>
        </div>
        @empty
        <p class="text-muted">Belum ada alamat tersimpan.</p>
        @endforelse
    </div>
</div>

<div class="modal fade" id="addAddressModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Tambah Alamat Baru</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <form action="{{ route('dealer.profil.address.store') }}" method="POST">
                @csrf
                <div class="modal-body">
                    <div class="mb-3"><label class="form-label">Nama Penerima</label><input type="text" name="receiver_name" class="form-control" required></div>
                    <div class="mb-3"><label class="form-label">No. Telepon Penerima</label><input type="text" name="receiver_phone" class="form-control" required></div>
                    <div class="mb-3"><label class="form-label">Alamat Lengkap</label><textarea name="address" class="form-control" required></textarea></div>
                    <div class="row">
                        <div class="col-md-6 mb-3"><label class="form-label">Provinsi</label><input type="text" name="province" class="form-control" required></div>
                        <div class="col-md-6 mb-3"><label class="form-label">Kota</label><input type="text" name="city" class="form-control" required></div>
                    </div>
                    <div class="mb-3"><label class="form-label">Kode Pos</label><input type="text" name="postal_code" class="form-control" required></div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-primary">Simpan Alamat</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection