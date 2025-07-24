@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        @include('user.account.sidebar')
        <div class="col-md-9">

            <div class="card shadow-sm border-0 mb-4">
                <div class="card-header bg-white fw-bold">Informasi Akun</div>
                <div class="card-body">
                    @if(session('success_profile')) <div class="alert alert-success">{{ session('success_profile') }}</div> @endif
                    <form action="{{ route('account.profil.update') }}" method="POST">
                        @csrf
                        @method('PUT')
                        <div class="row">
                            <div class="col-md-6 mb-3"><label class="form-label">Nama Lengkap</label><input type="text" name="name" class="form-control" value="{{ old('name', $user->name) }}"></div>
                            <div class="col-md-6 mb-3"><label class="form-label">Nomor Telepon</label><input type="text" name="phone" class="form-control" value="{{ old('phone', $user->phone) }}"></div>
                        </div>
                        <div class="mb-3"><label class="form-label">Email</label><input type="email" class="form-control" value="{{ $user->email }}" disabled></div>
                        <button type="submit" class="btn btn-primary">Simpan Informasi</button>
                    </form>
                </div>
            </div>

            <div class="card shadow-sm border-0 mb-4">
                <div class="card-header bg-white d-flex justify-content-between align-items-center">
                    <span class="fw-bold">Alamat Pengiriman</span>
                    <button type="button" class="btn btn-sm btn-outline-primary" data-bs-toggle="modal" data-bs-target="#addAddressModal">Tambah Alamat Baru</button>
                </div>
                <div class="card-body">
                    @if(session('success_address')) <div class="alert alert-success">{{ session('success_address') }}</div> @endif
                    @forelse($user->addresses as $address)
                    <div class="d-flex justify-content-between align-items-center mb-2 pb-2 @if(!$loop->last) border-bottom @endif">
                        <div>
                            <strong>{{ $address->receiver_name }}</strong> ({{ $address->receiver_phone }})<br>
                            <small class="text-muted">{{ $address->address }}, {{ $address->city }}, {{ $address->province }}</small>
                        </div>
                        <form action="{{ route('account.address.destroy', $address) }}" method="POST" onsubmit="return confirm('Yakin ingin hapus alamat ini?');">
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

            <div class="card shadow-sm border-0">
                <div class="card-header bg-white fw-bold">Ubah Password</div>
                <div class="card-body">
                    @if(session('success_password')) <div class="alert alert-success">{{ session('success_password') }}</div> @endif
                    @if($errors->has('current_password') || $errors->has('password'))
                    <div class="alert alert-danger">
                        @foreach($errors->all() as $error)
                        <p class="mb-0">{{$error}}</p>
                        @endforeach
                    </div>
                    @endif
                    <form action="{{ route('account.password.change') }}" method="POST">
                        @csrf
                        @method('PATCH')
                        <div class="mb-3"><label class="form-label">Password Saat Ini</label><input type="password" name="current_password" class="form-control"></div>
                        <div class="mb-3"><label class="form-label">Password Baru</label>
                            <div class="input-group"><input type="password" name="password" class="form-control" id="password"><button class="btn btn-outline-secondary" type="button" id="togglePassword"><i class="fa-solid fa-eye"></i></button></div>
                            <small class="form-text text-muted">Minimal 8 karakter, mengandung huruf besar, huruf kecil, angka, dan simbol.</small>
                        </div>
                        <div class="mb-3"><label class="form-label">Konfirmasi Password Baru</label><input type="password" name="password_confirmation" class="form-control"></div>
                        <button type="submit" class="btn btn-primary">Ubah Password</button>
                    </form>
                </div>
            </div>

        </div>
    </div>
</div>

<div class="modal fade" id="addAddressModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Tambah Alamat Baru</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <form action="{{ route('account.address.store') }}" method="POST">
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

<script>
    document.getElementById('togglePassword').addEventListener('click', function(e) {
        const password = document.getElementById('password');
        const type = password.getAttribute('type') === 'password' ? 'text' : 'password';
        password.setAttribute('type', type);
        this.querySelector('i').classList.toggle('fa-eye');
        this.querySelector('i').classList.toggle('fa-eye-slash');
    });
</script>
@endsection