@extends('admin.layout')
@section('admin_content')
<h3 class="fw-bold mb-3">Buat Voucher Baru</h3>
<form action="{{ route('admin.vouchers.store') }}" method="POST">
    @csrf
    <div class="card shadow-sm border-0">
        <div class="card-body p-4">
            <div class="row">
                <div class="col-md-6 mb-3"><label class="form-label">Kode Voucher</label><input type="text" name="code" class="form-control" required></div>
                <div class="col-md-6 mb-3"><label class="form-label">Tipe</label><select name="type" class="form-select">
                        <option value="fixed">Fixed</option>
                        <option value="percentage">Percentage</option>
                    </select></div>
                <div class="col-md-6 mb-3"><label class="form-label">Nilai (Rp atau %)</label><input type="number" name="value" class="form-control" required></div>
                <div class="col-md-6 mb-3"><label class="form-label">Maks. Diskon (Rp)</label><input type="number" name="max_discount" class="form-control" placeholder="Kosongkan jika tidak ada"></div>
                <div class="col-md-6 mb-3"><label class="form-label">Min. Belanja (Rp)</label><input type="number" name="min_purchase" class="form-control" placeholder="0"></div>
                <div class="col-md-6 mb-3"><label class="form-label">Batas Pemakaian</label><input type="number" name="usage_limit" class="form-control" placeholder="Kosongkan jika tak terbatas"></div>
                <div class="col-md-6 mb-3"><label class="form-label">Berlaku Sampai</label><input type="date" name="valid_to" class="form-control"></div>
                <div class="col-md-6 mb-3 d-flex align-items-end">
                    <div class="form-check form-switch me-4"><input class="form-check-input" type="checkbox" name="is_active" value="1" id="is_active" checked><label class="form-check-label" for="is_active">Aktif</label></div>
                    <div class="form-check form-switch"><input class="form-check-input" type="checkbox" name="for_dealer" value="1" id="for_dealer"><label class="form-check-label" for="for_dealer">Khusus Dealer</label></div>
                </div>
                <div class="col-12"><label class="form-label">Deskripsi</label><textarea name="description" class="form-control" rows="3"></textarea></div>
            </div>
        </div>
        <div class="card-footer text-end"><button type="submit" class="btn btn-primary">Buat Voucher</button></div>
    </div>
</form>
@endsection