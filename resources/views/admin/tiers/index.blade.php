@extends('admin.layout')
@section('admin_content')
<h3 class="fw-bold">Pengaturan Tingkatan Dealer</h3>
@if(session('success')) <div class="alert alert-success">{{ session('success') }}</div> @endif
<form action="{{ route('admin.tiers.update') }}" method="POST">
    @csrf
    <div class="card shadow-sm border-0">
        <div class="card-body">
            @foreach($tiers as $tier)
            <fieldset class="mb-4">
                <legend class="fs-5 fw-semibold">{{$tier->name}}</legend>
                <div class="row">
                    <div class="col-md-4"><label class="form-label">Min. Belanja/Bulan</label><input type="number" name="tiers[{{$tier->id}}][min_monthly_purchase]" class="form-control" value="{{$tier->min_monthly_purchase}}"></div>
                    <div class="col-md-4"><label class="form-label">Diskon Produk (%)</label><input type="number" name="tiers[{{$tier->id}}][product_discount_percentage]" class="form-control" value="{{$tier->product_discount_percentage}}"></div>
                    <div class="col-md-4"><label class="form-label">Potongan Ongkir (Rp)</label><input type="number" name="tiers[{{$tier->id}}][shipping_discount_amount]" class="form-control" value="{{$tier->shipping_discount_amount}}"></div>
                </div>
            </fieldset>
            @endforeach
        </div>
        <div class="card-footer text-end"><button type="submit" class="btn btn-primary">Simpan Pengaturan</button></div>
    </div>
</form>
@endsection