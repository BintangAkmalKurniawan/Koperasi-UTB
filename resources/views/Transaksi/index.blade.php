<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Daftar Transaksi</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</head>

<body class="bg-gray-100 font-sans">
    @include('Layout.menu')

    <div class="pt-24">
        <div class="w-full max-w-7xl mx-auto py-8 px-4 sm:px-6 lg:px-8">

            <header class="mb-8 md:flex md:items-center md:justify-between">
                <div>
                    <h1 class="text-3xl font-bold tracking-tight text-gray-900">Riwayat Transaksi</h1>
                    <p class="text-gray-600 mt-1">Lihat semua transaksi yang telah tercatat dalam sistem.</p>
                </div>
                <div class="mt-4 md:mt-0">
                    <a href="{{ route('transaksi.create') }}"
                        class="inline-flex items-center justify-center rounded-md border border-transparent bg-indigo-600 px-4 py-2 text-sm font-medium text-white shadow-sm hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2">
                        + Tambah Transaksi Baru
                    </a>
                </div>
            </header>

            @if (session('success'))
                <div class="bg-green-100 border-l-4 border-green-500 text-green-700 p-4 mb-6 rounded-md" role="alert">
                    <p>{{ session('success') }}</p>
                </div>
            @endif
            @if (session('error'))
                <div class="bg-red-100 border-l-4 border-red-500 text-red-700 p-4 mb-6 rounded-md" role="alert">
                    <p>{{ session('error') }}</p>
                </div>
            @endif

            <main>
                <div class="bg-white shadow-sm ring-1 ring-gray-900/5 sm:rounded-xl">
                    <div class="overflow-x-auto">
                        <table class="min-w-full divide-y divide-gray-200">
                            <thead class="bg-gray-50">
                                <tr>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">No
                                        Transaksi</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Pembeli
                                    </th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Detail
                                        Produk</th>
                                    <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase">Total
                                        Harga</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Tanggal
                                    </th>
                                    <th class="px-6 py-3 text-center text-xs font-medium text-gray-500 uppercase">Aksi
                                    </th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-200">
                                @forelse ($transaksis as $transaksi)
                                    <tr>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                            #{{ $transaksi->no_transaksi }}</td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">
                                            {{-- Perbaikan: Menggunakan relasi singular 'user' --}}
                                            {{ $transaksi->user->nama ?? 'Tidak diketahui' }}</td>
                                        <td class="px-6 py-4 text-sm text-gray-700">
                                            <ul class="list-disc list-inside space-y-1">
                                                @foreach ($transaksi->detailTransaksis as $detail)
                                                    <li>
                                                        {{-- Perbaikan: Menggunakan relasi 'produk' dan kolom 'harga_satuan' --}}
                                                        <span
                                                            class="font-medium">{{ $detail->produk->name ?? 'Produk Dihapus' }}</span>
                                                        <span>({{ $detail->jumlah }} x Rp
                                                            {{ number_format($detail->harga_satuan, 0, ',', '.') }})</span>
                                                    </li>
                                                @endforeach
                                            </ul>
                                        </td>
                                        <td
                                            class="px-6 py-4 whitespace-nowrap text-sm font-semibold text-gray-800 text-right">
                                            Rp {{ number_format($transaksi->total_harga, 0, ',', '.') }}
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                            {{ \Carbon\Carbon::parse($transaksi->created_at)->isoFormat('D MMMM YYYY, HH:mm') }}
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-center">

                                            <a href="{{ route('transaksi.struk', $transaksi->no_transaksi) }}"
                                                target="_blank" class="bg-gray-200 py-2 px-3">
                                                Cetak Struk</a>
                                            {{-- Perbaikan: Menggunakan primary key 'no_transaksi' untuk route --}}
                                            {{-- <a href="{{ route('transaksi.edit', $transaksi->no_transaksi) }}"
                                                class="text-indigo-600 hover:text-indigo-900 mr-3">Edit</a> --}}
                                            <form action="{{ route('transaksi.destroy', $transaksi->no_transaksi) }}"
                                                method="POST" class="inline-block delete-form">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit"
                                                    class="text-red-600 bg-red-200 py-2 px-3 hover:text-red-900">Hapus</button>
                                            </form>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="6" class="text-center p-8 text-gray-500">
                                            Belum ada data transaksi yang tercatat.
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </main>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const deleteForms = document.querySelectorAll('.delete-form');
            deleteForms.forEach(form => {
                form.addEventListener('submit', function(event) {
                    event.preventDefault();
                    Swal.fire({
                        title: 'Apakah Anda yakin?',
                        text: "Data transaksi ini akan dihapus secara permanen!",
                        icon: 'warning',
                        showCancelButton: true,
                        confirmButtonColor: '#d33',
                        cancelButtonColor: '#3085d6',
                        confirmButtonText: 'Ya, hapus!',
                        cancelButtonText: 'Batal'
                    }).then((result) => {
                        if (result.isConfirmed) {
                            form.submit();
                        }
                    });
                });
            });
        });
    </script>
</body>

</html>
