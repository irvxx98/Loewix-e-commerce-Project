@extends('layouts.app')
@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-6 text-center">
            <div class="card border-0 shadow-sm">
                <div class="card-body p-5">
                    <i class="fa-solid fa-circle-check text-success fa-4x mb-4"></i>
                    <h2 class="fw-bold">Pesanan Berhasil!</h2>
                    <p class="text-muted">Terima kasih. Pesanan Anda telah kami teruskan ke dealer. Silakan tunggu konfirmasi selanjutnya. Anda bisa melihat status pesanan di halaman Akun Saya.</p>
                    <a href="{{ route('account.orders') }}" class="btn btn-primary mt-3">Lihat Riwayat Pesanan</a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection