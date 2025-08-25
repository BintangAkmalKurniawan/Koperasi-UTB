<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <title>Rekap Tabungan</title>
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
            border: 1px solid #ddd;
            padding: 5px;
            text-align: left;
        }

        .total {
            font-weight: bold;
            background: #f3f3f3;
        }
    </style>
</head>

<body>
    <h3 style="text-align: center;">Rekap Tabungan Anggota</h3>

    <p><b>NIK:</b> {{ $user->id_user }}</p>
    <p><b>Nama:</b> {{ $user->nama }}</p>

    <table>
        <thead>
            <tr>
                <th>Tanggal</th>
                <th>Jenis Transaksi</th>
                <th>Nominal</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($user->riwayatTabungan as $riwayat)
                <tr>
                    <td>{{ \Carbon\Carbon::parse($riwayat->tanggal_transaksi)->format('d-m-Y') }}</td>
                    <td>{{ ucfirst($riwayat->jenis_transaksi) }}</td>
                    <td>Rp {{ number_format($riwayat->jumlah, 0, ',', '.') }}</td>
                </tr>
            @empty
                <tr>
                    <td colspan="3" style="text-align:center;">Belum ada transaksi</td>
                </tr>
            @endforelse
            <tr class="total">
                <td colspan="2">Total Tabungan</td>
                <td>Rp {{ number_format($user->tabungan->total_tabungan ?? 0, 0, ',', '.') }}</td>
            </tr>
        </tbody>
    </table>

    <p style="text-align: center; margin-top: 20px;">Terima kasih telah menabung di koperasi kami.</p>
</body>

</html>
