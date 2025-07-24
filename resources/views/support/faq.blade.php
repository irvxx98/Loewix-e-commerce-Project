@extends('layouts.app')

@section('content')
@include('support.header_menu')
<div class="bg-white">
    <div class="container text-center py-5">
        <h1 class="display-4 fw-bold">Frequently Asked Questions (FAQ)</h1>
        <p class="lead col-md-8 mx-auto text-muted">Temukan jawaban cepat untuk pertanyaan umum seputar produk dan layanan kami.</p>
    </div>
</div>

<div class="container my-5">
    <div class="row justify-content-center">
        <div class="col-md-9">
            @foreach($faqs as $category => $items)
            <h3 class="fw-bold mt-4 mb-3">{{ $category }}</h3>
            <div class="accordion" id="faqAccordion-{{ Str::slug($category) }}">
                @foreach($items as $question => $answer)
                <div class="accordion-item">
                    <h2 class="accordion-header">
                        <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapse-{{ Str::slug($question) }}">{{ $question }}</button>
                    </h2>
                    <div id="collapse-{{ Str::slug($question) }}" class="accordion-collapse collapse" data-bs-parent="#faqAccordion-{{ Str::slug($category) }}">
                        <div class="accordion-body">{{ $answer }}</div>
                    </div>
                </div>
                @endforeach
            </div>
            @endforeach
        </div>
    </div>
</div>
@endsection