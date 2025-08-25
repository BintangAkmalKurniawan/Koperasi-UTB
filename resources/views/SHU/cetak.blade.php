<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <title>Detail SHU Periode {{ $period->periode }}</title>
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
            padding: 6px;
            text-align: right;
        }

        th {
            background: #f3f3f3;
            text-align: center;
        }

        td:first-child,
        td:nth-child(2) {
            text-align: left;
        }

        h2 {
            text-align: center;
            margin-bottom: 5px;
        }
    </style>
</head>

<body>
    <h2>Detail SHU Periode {{ $period->periode }}</h2>
    <p><b>Total SHU Dibagikan:</b> Rp {{ number_format($period->total_shu, 0, ',', '.') }}</p>
    <p><b>Alokasi Jasa Modal:</b> {{ $period->persen_jasa_modal }}% |
        <b>Alokasi Jasa Usaha:</b> {{ $period->persen_jasa_usaha }}%
    </p>

    <table>
        <thead>
            <tr>
                <th>NIK</th>
                <th>Nama Anggota</th>
                <th>Modal (Simpanan)</th>
                <th>Transaksi (Belanja)</th>
                <th>SHU Modal</th>
                <th>SHU Usaha</th>
                <th>Total SHU Diterima</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($distributions as $dist)
                <tr>
                    <td>{{ $dist->user->id_user }}</td>
                    <td>{{ $dist->user->nama }}</td>
                    <td>Rp {{ number_format($dist->total_simpanan_anggota, 0, ',', '.') }}</td>
                    <td>Rp {{ number_format($dist->total_belanja_anggota, 0, ',', '.') }}</td>
                    <td>Rp {{ number_format($dist->shu_jasa_modal, 0, ',', '.') }}</td>
                    <td>Rp {{ number_format($dist->shu_jasa_usaha, 0, ',', '.') }}</td>
                    <td><b>Rp {{ number_format($dist->shu_jasa_modal + $dist->shu_jasa_usaha, 0, ',', '.') }}</b></td>
                </tr>
            @endforeach
        </tbody>
    </table>
</body>

</html>
