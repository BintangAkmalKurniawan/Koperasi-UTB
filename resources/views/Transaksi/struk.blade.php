<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <title>Struk Transaksi</title>
    <style>
        body {
            font-family: sans-serif;
            font-size: 12px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 10px;
        }

        th,
        td {
            border: 2px solid #ddd;
            padding: 5px;
            text-align: left;
        }

        .total {
            font-weight: bold;
        }
    </style>
</head>

<body>
    <h3 style="text-align: center;">Struk Transaksi</h3>
    <p><b>No. Transaksi:</b> {{ $transaksi->no_transaksi }}</p>
    <p><b>Tanggal:</b> {{ $transaksi->tanggal_transaksi }}</p>
    <p><b>Pembeli:</b> {{ $transaksi->user->nama }}</p>
    <table>
        <thead>
            <tr>
                <th>Produk</th>
                <th>Penjual</th>
                <th>Harga</th>
                <th>Jumlah</th>
                <th>Subtotal</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($transaksi->detailTransaksis as $detail)
                <tr>
                    <td>{{ $detail->produk->name }}</td>
                    <td>{{ $detail->produk->anggota->nama }}</td>
                    <td>Rp {{ number_format($detail->harga_satuan, 0, ',', '.') }}</td>
                    <td>{{ $detail->jumlah }}</td>
                    <td>Rp {{ number_format($detail->subtotal, 0, ',', '.') }}</td>
                </tr>
            @endforeach
            <tr class="total">
                <td colspan="4">Total</td>
                <td>Rp {{ number_format($transaksi->total_harga, 0, ',', '.') }}</td>
            </tr>
        </tbody>
    </table>

    <p style="text-align: center; margin-top: 20px;">Terima kasih sudah berbelanja!</p>
</body>

</html>
