<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <title>Invoice {{ $stockOrder->order_code }}</title>
    <style>
        body {
            font-family: sans-serif;
            font-size: 14px;
        }

        .container {
            width: 100%;
            margin: 0 auto;
        }

        .header {
            text-align: center;
            margin-bottom: 20px;
        }

        .header h1 {
            margin: 0;
        }

        .details,
        .items,
        .summary {
            width: 100%;
            margin-bottom: 20px;
        }

        .details td {
            padding: 5px;
        }

        .items {
            border-collapse: collapse;
        }

        .items th,
        .items td {
            border: 1px solid #ccc;
            padding: 8px;
            text-align: left;
        }

        .items th {
            background-color: #f2f2f2;
        }

        .summary {
            float: right;
            width: 40%;
        }

        .summary td {
            padding: 5px;
        }
    </style>
</head>

<body>
    <div class="container">
        <div class="header">
            <h1>NOTA PEMBELIAN STOK</h1>
            <p><strong>Loewix</strong></p>
        </div>
        <table class="details">
            <tr>
                <td><strong>Kode:</strong> {{ $stockOrder->order_code }}</td>
                <td><strong>Tanggal:</strong> {{ $stockOrder->created_at->format('d M Y') }}</td>
            </tr>
            <tr>
                <td><strong>Kepada:</strong> {{ $stockOrder->dealer->name }}</td>
                <td><strong>Dikirim ke:</strong> {{ $stockOrder->shippingAddress->receiver_name }}</td>
            </tr>
        </table>
        <table class="items">
            <thead>
                <tr>
                    <th>Produk</th>
                    <th>Jumlah</th>
                    <th>Harga</th>
                    <th>Subtotal</th>
                </tr>
            </thead>
            <tbody>
                @foreach($stockOrder->items as $item)
                <tr>
                    <td>{{ $item->produk->name }}</td>
                    <td>{{ $item->quantity }}</td>
                    <td>Rp {{ number_format($item->price) }}</td>
                    <td>Rp {{ number_format($item->price * $item->quantity) }}</td>
                </tr>
                @endforeach
            </tbody>
        </table>
        <table class="summary">
            <tr>
                <td>Subtotal Produk</td>
                <td style="text-align: right;">Rp {{ number_format($subtotal) }}</td>
            </tr>
            <tr>
                <td>Ongkos Kirim</td>
                <td style="text-align: right;">Rp {{ number_format($stockOrder->shipping_cost) }}</td>
            </tr>
            @if($stockOrder->shipping_discount_amount > 0)
            <tr>
                <td>Potongan Ongkir</td>
                <td style="text-align: right;">- Rp {{ number_format($stockOrder->shipping_discount_amount) }}</td>
            </tr>
            @endif
            @if($stockOrder->discount_amount > 0)
            <tr>
                <td>Diskon</td>
                <td style="text-align: right;">- Rp {{ number_format($stockOrder->discount_amount) }}</td>
            </tr>
            @endif
            <tr>
                <td><strong>Grand Total</strong></td>
                <td style="text-align: right;"><strong>Rp {{ number_format($stockOrder->total_amount) }}</strong></td>
            </tr>
        </table>
    </div>
</body>

</html>