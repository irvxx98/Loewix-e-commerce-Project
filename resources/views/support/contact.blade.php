@extends('layouts.app')

@section('content')
@include('support.header_menu')
<div class="bg-white">
    <div class="container text-center py-5">
        <h1 class="display-4 fw-bold">Get in Touch</h1>
        <p class="lead col-md-8 mx-auto text-muted">Punya pertanyaan atau butuh bantuan? Kami di sini untuk Anda. Hubungi kami melalui form di bawah atau kanal kontak lainnya.</p>
    </div>
</div>

<div class="container my-5">
    <div class="row g-5">
        <div class="col-lg-7">
            <div class="card shadow-sm border-0 h-100">
                <div class="card-body p-4 p-md-5">
                    <h3 class="fw-bold mb-4">Kirim Pesan</h3>
                    @if(session('success'))
                    <div class="alert alert-success">{{ session('success') }}</div>
                    @endif
                    <form action="{{ route('support.contact.send') }}" method="POST">
                        @csrf
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="name" class="form-label">Nama Anda</label>
                                <input type="text" name="name" id="name" class="form-control" required>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="email" class="form-label">Email Anda</label>
                                <input type="email" name="email" id="email" class="form-control" required>
                            </div>
                        </div>
                        <div class="mb-3">
                            <label for="subject" class="form-label">Subjek</label>
                            <input type="text" name="subject" id="subject" class="form-control" required>
                        </div>
                        <div class="mb-3">
                            <label for="message" class="form-label">Pesan</label>
                            <textarea name="message" id="message" class="form-control" rows="5" required></textarea>
                        </div>
                        <button type="submit" class="btn btn-primary btn-lg">Kirim Pesan</button>
                    </form>
                </div>
            </div>
        </div>

        <div class="col-lg-5">
            <div class="p-4 rounded-3" style="background-color: #001f3f; color: white;">
                <h3 class="fw-bold mb-4">Informasi Kontak</h3>
                <div class="d-flex mb-3">
                    <i class="fas fa-map-marker-alt fa-fw mt-1 me-3"></i>
                    <div>
                        <strong>Alamat</strong><br>
                        Jl. Industri No. 1, Kawasan Industri Candi, Semarang, Jawa Tengah 50181
                    </div>
                </div>
                <div class="d-flex mb-3">
                    <i class="fas fa-envelope fa-fw mt-1 me-3"></i>
                    <div>
                        <strong>Email</strong><br>
                        <a href="mailto:support@loewix.com" class="text-white">support@loewix.com</a>
                    </div>
                </div>
                <div class="d-flex mb-3">
                    <i class="fab fa-whatsapp fa-fw mt-1 me-3"></i>
                    <div>
                        <strong>WhatsApp</strong><br>
                        Sales: +62 812-0000-0001<br>
                        Support: <a href="https://wa.me+62 819-7991-818
                    </div>
                </div>
                <hr class="border-white-50">
                <h5 class="fw-bold mb-3">Terhubung dengan kami</h5>
                <div>
                    <a href="#" class="fs-4 text-white me-3"><i class="fab fa-instagram"></i></a>
                    <a href="#" class="fs-4 text-white me-3"><i class="fab fa-facebook-square"></i></a>
                    <a href="#" class="fs-4 text-white me-3"><i class="fab fa-tiktok"></i></a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection