@extends('layouts.app')

@section('content')
@include('support.header_menu')
<div class="bg-white">
    <div class="container text-center py-5">
        <h1 class="display-4 fw-bold">Pusat Panduan & Tutorial</h1>
        <p class="lead col-md-8 mx-auto text-muted">Temukan panduan lengkap, video tutorial, dan jawaban untuk semua produk Loewix.</p>
    </div>
</div>

<div class="container my-5">
    <div class="row g-5">
        <div class="col-lg-3">
            <div class="sticky-top" style="top: 100px;">
                <h5 class="fw-bold mb-3">Cari Panduan</h5>
                <input type="text" id="tutorialSearch" class="form-control form-control-lg mb-4" placeholder="Ketik judul...">

                <h5 class="fw-bold mb-3">Kategori</h5>
                <div class="nav flex-column nav-pills" id="pills-tab" role="tablist" aria-orientation="vertical">
                    @foreach($tutorials as $category => $items)
                    <button class="nav-link text-start {{ $loop->first ? 'active' : '' }}" id="pills-{{ Str::slug($category) }}-tab" data-bs-toggle="pill" data-bs-target="#pills-{{ Str::slug($category) }}" type="button" role="tab">
                        {{ $category }}
                        <span class="badge bg-secondary float-end mt-1">{{ count($items) }}</span>
                    </button>
                    @endforeach
                </div>
            </div>
        </div>
        <div class="col-lg-9">
            <section id="video-tutorials" class="mb-5">
                <h3 class="fw-bold mb-4">Video Tutorial Unggulan</h3>
                <div class="row g-4">
                    <div class="col-md-6 col-lg-4">
                        <div class="ratio ratio-16x9 shadow-sm rounded">
                            <iframe src="https://www.youtube.com/embed/oLyzjKZMMFA?si=8JtJNvLeBxA-q00A" title="YouTube video player" frameborder="0" allowfullscreen></iframe>
                        </div>
                    </div>
                    <div class="col-md-6 col-lg-4">
                        <div class="ratio ratio-16x9 shadow-sm rounded">
                            <iframe src="https://www.youtube.com/embed/mDqX2XDIr-Q?si=kgIQnOaNQ1QuB4gg" title="YouTube video player" frameborder="0" allowfullscreen></iframe>
                        </div>
                    </div>
                    <div class="col-md-6 col-lg-4">
                        <div class="ratio ratio-16x9 shadow-sm rounded">
                            <iframe src="https://www.youtube.com/embed/0LnqS7aqNik?si=h6wK2oECh1JFLUh1" title="YouTube video player" frameborder="0" allowfullscreen></iframe>
                        </div>
                    </div>
                </div>
            </section>

            <hr class="my-5">

            <section id="pdf-tutorials">
                <h3 class="fw-bold mb-4">Panduan Dokumen (PDF)</h3>
                <div class="tab-content" id="pills-tabContent">
                    @foreach($tutorials as $category => $items)
                    <div class="tab-pane fade {{ $loop->first ? 'show active' : '' }}" id="pills-{{ Str::slug($category) }}" role="tabpanel">
                        <div class="list-group list-group-flush tutorial-list">
                            @foreach($items as $tutorial)
                            <a href="#" class="list-group-item list-group-item-action d-flex align-items-center py-3 px-0">
                                <i class="fas fa-file-pdf fa-2x text-danger me-3 ms-4"></i>
                                <div>
                                    <strong class="tutorial-title d-block">{{ $tutorial->title }}</strong>
                                    <p class="mb-0 text-muted small">{{ $tutorial->description }}</p>
                                </div>
                                <i class="fas fa-download ms-auto text-muted me-4"></i>
                            </a>
                            @endforeach
                        </div>
                    </div>
                    @endforeach
                </div>
            </section>
        </div>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const searchInput = document.getElementById('tutorialSearch');
        const tabButtons = document.querySelectorAll('#pills-tab button');

        function filterTutorials() {
            let filter = searchInput.value.toLowerCase();
            const allListItems = document.querySelectorAll('.tab-content .list-group-item');

            allListItems.forEach(item => {
                const title = item.querySelector('.tutorial-title').innerText.toLowerCase();
                const isMatch = title.includes(filter);
                item.classList.toggle('item-hidden', !isMatch);
            });

            updateTabBadges(filter);
        }

        function updateTabBadges(filter) {
            tabButtons.forEach(button => {
                const paneId = button.getAttribute('data-bs-target');
                const pane = document.querySelector(paneId);
                if (pane) {
                    const visibleItemsCount = pane.querySelectorAll('.list-group-item:not(.item-hidden)').length;
                    let badge = button.querySelector('.badge');
                    if (badge) {
                        badge.innerText = visibleItemsCount;
                        button.style.display = (visibleItemsCount > 0) ? '' : 'none';
                    }
                }
            });
            if (!filter) {
                tabButtons.forEach(button => button.style.display = '');
            }
        }
        searchInput.addEventListener('keyup', filterTutorials);
        tabButtons.forEach(button => {
            button.addEventListener('shown.bs.tab', () => {
                searchInput.value = '';
                filterTutorials();
            });
        });
    });
</script>
@endsection