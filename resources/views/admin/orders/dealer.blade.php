@extends('admin.layout')
@section('admin_content')
<div class="card shadow-sm border-0">
    <div class="card-header bg-white d-flex justify-content-between align-items-center py-3">
        <h5 class="mb-0 fw-semibold">Pesanan Antar Dealer & Customer</h5>
        <div style="width: 300px;"><input type="text" id="searchDealerOrder" class="form-control" placeholder="Cari pesanan..."></div>
    </div>
    <div class="card-body">
        <table class="table table-hover align-middle">
            <thead>
                <tr>
                    <th>Kode Order</th>
                    <th>Customer</th>
                    <th>Dealer</th>
                    <th>Total</th>
                    <th>Status</th>
                </tr>
            </thead>
            <tbody id="dealerOrderTable">
                @forelse($dealerOrders as $order)
                <tr>
                    <td>{{$order->order_code}}</td>
                    <td>{{$order->customer->name}}</td>
                    <td>{{$order->dealer->name}}</td>
                    <td>Rp {{number_format($order->total_amount,0,',','.')}}</td>
                    <td><span class="badge bg-secondary">{{$order->status->value}}</span></td>
                </tr>
                @empty
                <tr>
                    <td colspan="5" class="text-center">Tidak ada pesanan.</td>
                </tr>
                @endforelse
            </tbody>
        </table>
        <div class="d-flex justify-content-center">{{ $dealerOrders->links() }}</div>
    </div>
</div>
<script>
    document.getElementById('searchDealerOrder').addEventListener('keyup', function() {
        let filter = this.value.toLowerCase();
        let rows = document.querySelectorAll('#dealerOrderTable tr');
        rows.forEach(row => {
            row.style.display = row.innerText.toLowerCase().includes(filter) ? '' : 'none';
        });
    });
</script>
@endsection