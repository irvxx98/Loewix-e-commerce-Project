@extends('admin.layout')
@section('admin_content')
<div class="d-flex justify-content-between align-items-center mb-3">
    <h3 class="fw-bold mb-0">Pengelolaan Voucher</h3>
    <a href="{{ route('admin.vouchers.create') }}" class="btn btn-primary">Buat Voucher Baru</a>
</div>
@if(session('success')) <div class="alert alert-success">{{ session('success') }}</div> @endif
<div class="card shadow-sm border-0">
    <div class="card-body">
        <table class="table">
            <thead>
                <tr>
                    <th>Kode</th>
                    <th>Tipe</th>
                    <th>Nilai</th>
                    <th>Pemakaian</th>
                    <th>Status</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($vouchers as $voucher)
                <tr>
                    <td>{{ $voucher->code }}</td>
                    <td>{{ $voucher->type }}</td>
                    <td>{{ $voucher->type == 'fixed' ? 'Rp '.number_format($voucher->value) : $voucher->value.'%' }}</td>
                    <td>{{ $voucher->usage_count }} / {{ $voucher->usage_limit ?? '∞' }}</td>
                    <td>{{ $voucher->is_active ? 'Aktif' : 'Nonaktif' }}</td>
                </tr>
                @empty
                <tr>
                    <td colspan="5" class="text-center">Belum ada voucher.</td>
                </tr>
                @endforelse
            </tbody>
        </table>
        <div class="d-flex justify-content-center">{{ $vouchers->links() }}</div>
    </div>
</div>
@endsection