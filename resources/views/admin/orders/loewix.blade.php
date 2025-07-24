@extends('admin.layout')
@section('admin_content')
<h3 class="fw-bold mb-3">Pesanan yang Ditangani Loewix</h3>
<div class="card shadow-sm border-0">
    <div class="card-header bg-white p-0">
        <ul class="nav nav-tabs nav-fill" id="orderTabs" role="tablist">
            <li class="nav-item" role="presentation">
                <button class="nav-link active p-3" id="customer-tab" data-bs-toggle="tab" data-bs-target="#customer-pane" type="button">Pesanan Customer Langsung</button>
            </li>
            <li class="nav-item" role="presentation">
                <button class="nav-link p-3" id="stock-tab" data-bs-toggle="tab" data-bs-target="#stock-pane" type="button">Pesanan Stok Dealer</button>
            </li>
        </ul>
    </div>
    <div class="card-body">
        <div class="tab-content" id="orderTabsContent">
            <div class="tab-pane fade show active" id="customer-pane" role="tabpanel">
                <div class="table-responsive">
                    <table class="table table-hover align-middle">
                        <thead>
                            <tr>
                                <th>Kode Order</th>
                                <th>Customer</th>
                                <th>Total</th>
                                <th>Status</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($customerOrders as $order)
                            <tr>
                                <td><strong>{{$order->order_code}}</strong></td>
                                <td>{{$order->customer->name}}</td>
                                <td>Rp {{number_format($order->total_amount,0,',','.')}}</td>
                                <td><span class="badge bg-info">{{$order->status->value}}</span></td>
                                <td><a href="{{ route('admin.orders.show', $order) }}" class="btn btn-sm btn-outline-primary">Detail</a></td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="5" class="text-center text-muted">Tidak ada pesanan customer.</td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
                <div class="d-flex justify-content-center">{{ $customerOrders->links() }}</div>
            </div>
            <div class="tab-pane fade" id="stock-pane" role="tabpanel">
                <div class="table-responsive">
                    <table class="table table-hover align-middle">
                        <thead>
                            <tr>
                                <th>Kode Order</th>
                                <th>Dealer</th>
                                <th>Total</th>
                                <th>Status</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($stockOrders as $order)
                            <tr>
                                <td><strong>{{$order->order_code}}</strong></td>
                                <td>{{$order->dealer->name}}</td>
                                <td>Rp {{number_format($order->total_amount,0,',','.')}}</td>
                                <td><span class="badge bg-success">{{$order->status}}</span></td>
                                <td>
                                    <a href="{{ route('admin.orders.stock.show', $order) }}" class="btn btn-sm btn-outline-primary">Detail</a>
                                    @if($order->status == 'pending_payment')
                                    <form action="{{ route('admin.orders.stock.process', $order) }}" method="POST">
                                        @csrf
                                        @method('PATCH')
                                        <button type="submit" class="btn btn-sm btn-primary">Proses Pesanan</button>
                                    </form>
                                    @else
                                    <span class="text-muted">-</span>
                                    @endif
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="5" class="text-center text-muted">Tidak ada pesanan stok.</td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
                <div class="d-flex justify-content-center">{{ $stockOrders->links() }}</div>
            </div>
        </div>
    </div>
</div>

<script>
    function setupSearch(inputId, tableId) {
        document.getElementById(inputId).addEventListener('keyup', function() {
            let filter = this.value.toLowerCase();
            let rows = document.querySelectorAll(`#${tableId} tr`);
            rows.forEach(row => {
                row.style.display = row.innerText.toLowerCase().includes(filter) ? '' : 'none';
            });
        });
    }
    setupSearch('searchCustomerOrder', 'customerOrderTable');
    setupSearch('searchStockOrder', 'stockOrderTable');
</script>
@endsection