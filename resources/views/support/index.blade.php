@extends('layouts.app')

@section('content')
<div class="bg-primary text-white">
    <div class="container text-center py-5">
        <h1 class="display-4 fw-bold">Pusat Bantuan Loewix</h1>
        <p class="lead col-md-8 mx-auto">Apa yang bisa kami bantu hari ini?</p>
        <div class="mt-4">
            <a href="{{ route('support.tutorials') }}" class="btn btn-light btn-lg mx-2">Cari Panduan</a>
            <a href="{{ route('support.contact') }}" class="btn btn-outline-light btn-lg mx-2">Hubungi Kami</a>
        </div>
    </div>
</div>

<div class="container my-5">
    <div class="row g-4">
        <div class="col-md-6">
            <a href="{{ route('support.tutorials') }}" class="card text-decoration-none shadow-sm h-100">
                <div class="card-body text-center p-4">
                    <i class="fas fa-book-open fa-3x text-primary mb-3"></i>
                    <h4 class="card-title">Panduan & Tutorial</h4>
                    <p class="card-text text-muted">Temukan panduan instalasi, konfigurasi, dan pemecahan masalah produk Loewix.</p>
                </div>
            </a>
        </div>
        <div class="col-md-6">
            <a href="{{ route('support.faq') }}" class="card text-decoration-none shadow-sm h-100">
                <div class="card-body text-center p-4">
                    <i class="fas fa-question-circle fa-3x text-primary mb-3"></i>
                    <h4 class="card-title">FAQ</h4>
                    <p class="card-text text-muted">Dapatkan jawaban cepat untuk pertanyaan yang paling sering diajukan.</p>
                </div>
            </a>
        </div>
        <div class="col-md-6">
            <a href="{{ route('support.dealers') }}" class="card text-decoration-none shadow-sm h-100">
                <div class="card-body text-center p-4">
                    <i class="fas fa-store fa-3x text-primary mb-3"></i>
                    <h4 class="card-title">Cari Dealer Resmi</h4>
                    <p class="card-text text-muted">Temukan dealer resmi Loewix terdekat di kota Anda untuk pembelian langsung.</p>
                </div>
            </a>
        </div>
        <div class="col-md-6">
            <a href="{{ route('support.contact') }}" class="card text-decoration-none shadow-sm h-100">
                <div class="card-body text-center p-4">
                    <i class="fas fa-headset fa-3x text-primary mb-3"></i>
                    <h4 class="card-title">Kontak & Sosial Media</h4>
                    <p class="card-text text-muted">Terhubung dengan kami melalui berbagai kanal untuk mendapatkan bantuan.</p>
                </div>
            </a>
        </div>
    </div>
</div>
@endsection