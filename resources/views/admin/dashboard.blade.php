@extends('admin.layout')
@section('admin_content')
<div class="d-flex justify-content-between align-items-center mb-3">
    <h3 class="fw-bold mb-0">Dashboard Ringkasan</h3>
</div>

<div class="row">
    <div class="col-xl-3 col-md-6 mb-4">
        <div class="card kpi-card shadow-sm h-100">
            <div class="card-body">
                <div>
                    <h5 class="mb-0">Total Pendapatan</h5>
                    <span class="text-muted small">Bulan Ini</span><br>
                    <span class="metric-value">Rp {{ number_format($stats['total_revenue'], 0, ',', '.') }}</span>
                </div>
                <div class="icon-wrapper bg-primary-soft">
                    <i class="fas fa-dollar-sign"></i>
                </div>
            </div>
        </div>
    </div>
    <div class="col-xl-3 col-md-6 mb-4">
        <div class="card kpi-card shadow-sm h-100">
            <div class="card-body">
                <div>
                    <h5 class="mb-0">Jumlah Pesanan</h5>
                    <span class="text-muted small">Bulan Ini</span><br>
                    <span class="metric-value">{{ $stats['orders_month'] }}</span>
                </div>
                <div class="icon-wrapper bg-primary-soft">
                    <i class="fas fa-receipt"></i>
                </div>
            </div>
        </div>
    </div>
    <div class="col-xl-3 col-md-6 mb-4">
        <a href="{{ route('admin.orders.pending') }}" class="text-decoration-none">
            <div class="card kpi-card shadow-sm h-100">
                <div class="card-body">
                    <div>
                        <h5 class="mb-0">Perlu di proses</h5>
                        <span class="text-muted small">Pesanan</span><br>
                        <span class="metric-value">{{ $stats['pending_orders'] }}</span>
                    </div>
                    <div class="icon-wrapper bg-primary-soft">
                        <i class="fas fa-box-open"></i>
                    </div>
                </div>
            </div>
        </a>
    </div>
    <div class="col-xl-3 col-md-6 mb-4">
        <div class="card kpi-card shadow-sm h-100">
            <div class="card-body">
                <div>
                    <h5 class="mb-0">Growth</h5>
                    <span class="text-muted small">Pendapatan vs Bulan Lalu</span><br>
                    <span class="metric-value {{ $stats['revenue_comparison'] >= 0 ? 'text-success' : 'text-danger' }}">
                        {{ $stats['revenue_comparison'] >= 0 ? '+' : '' }}{{ number_format($stats['revenue_comparison'], 1) }}%
                    </span>
                </div>
                <div class="icon-wrapper bg-primary-soft">
                    <i class="fas fa-chart-line"></i>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-lg-12">
        <div class="card shadow-sm border-0 mt-2">
            <div class="card-header bg-white py-3">
                <h5 class="mb-0 fw-semibold">Grafik Penjualan (30 Hari Terakhir)</h5>
            </div>
            <div class="card-body" style="height: 350px; background-color:#ffffff;"><canvas id="salesChart" data-chart-data="{{ json_encode($chartData) }}"></canvas></div>
        </div>
    </div>
</div>

<div class="card shadow-sm border-0 mt-4">
    <div class="card-header bg-white py-3">
        <h5 class="mb-0 fw-semibold">Customer Terbaru</h5>
    </div>
    <div class="card-body" style="background-color: #ffffff;">
        <table class="table table-borderless">
            <thead>
                <tr>
                    <th>Nama</th>
                    <th>Email</th>
                    <th>Tanggal Bergabung</th>
                </tr>
            </thead>
            <tbody>
                @foreach($recentCustomers as $customer)
                <tr>
                    <td>{{ $customer->name }}</td>
                    <td>{{ $customer->email }}</td>
                    <td>{{ $customer->created_at->format('d M Y') }}</td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
@endsection

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const ctx = document.getElementById('salesChart');
        if (ctx) {
            const chartData = JSON.parse(ctx.dataset.chartData);
            new Chart(ctx, {
                type: 'line',
                data: {
                    labels: chartData.labels,
                    datasets: [{
                        label: 'Total Penjualan',
                        data: chartData.values,
                        backgroundColor: 'rgba(0, 82, 255, 0.1)',
                        borderColor: 'rgb(0, 82, 255)',
                        borderWidth: 2,
                        fill: true
                    }]
                },
                options: {
                    scales: {
                        y: {
                            beginAtZero: true
                        }
                    },
                    responsive: true,
                    maintainAspectRatio: false
                }
            });
        }
    });
</script>
@endpush