@extends('layouts.app')
@section('content')
<div class="container my-5">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <h1 class="fw-bold mb-4">Notifikasi</h1>
            <div class="card shadow-sm border-0">
                <div class="list-group list-group-flush">
                    @forelse($notifications as $notification)
                    <a href="{{ $notification->data['link'] ?? '#' }}" class="list-group-item list-group-item-action py-3">
                        <div class="d-flex w-100 justify-content-between">
                            <p class="mb-1">{{ $notification->data['message'] ?? $notification->data['title'] }}</p>
                            <small class="text-muted">{{ $notification->created_at->diffForHumans() }}</small>
                        </div>
                    </a>
                    @empty
                    <div class="list-group-item text-center text-muted">Tidak ada notifikasi.</div>
                    @endforelse
                </div>
            </div>
            <div class="d-flex justify-content-center mt-4">{{ $notifications->links() }}</div>
        </div>
    </div>
</div>
@endsection