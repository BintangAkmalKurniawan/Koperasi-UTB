<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Detail SHU Periode {{ $period->periode }}</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="bg-gray-100">
    @include('Layout.menu')

    <div class="pt-24">
        <div class="w-full max-w-7xl mx-auto py-8 px-4 sm:px-6 lg:px-8">
            <header class="mb-8">
                <div class="flex items-center gap-4">
                    <a href="{{ route('shu.index') }}" class="text-gray-500 hover:text-gray-700">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" />
                        </svg>
                    </a>
                    <div>
                        <h1 class="text-3xl font-bold tracking-tight text-gray-900">
                            Detail SHU Periode {{ $period->periode }}
                        </h1>
                        <p class="text-gray-600 mt-1">Rincian pembagian Sisa Hasil Usaha untuk setiap anggota.</p>
                    </div>
                    <a href="{{ route('shu.cetak', $period->id) }}" target="_blank"
                        class="ml-auto bg-green-600 text-white px-4 py-2 rounded-md hover:bg-green-700">
                        Cetak PDF
                    </a>
                </div>
            </header>

            <!-- Ringkasan Informasi Periode -->
            <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-8">
                <div class="bg-white p-4 rounded-lg shadow-sm">
                    <h3 class="text-sm font-medium text-gray-500">Total SHU Dibagikan</h3>
                    <p class="mt-1 text-2xl font-semibold text-green-600">
                        Rp {{ number_format($period->total_shu, 0, ',', '.') }}
                    </p>
                </div>
                <div class="bg-white p-4 rounded-lg shadow-sm">
                    <h3 class="text-sm font-medium text-gray-500">
                        Alokasi Jasa Modal ({{ $period->persen_jasa_modal }}%)
                    </h3>
                    <p class="mt-1 text-2xl font-semibold text-gray-900">
                        Rp {{ number_format($period->total_shu * ($period->persen_jasa_modal / 100), 0, ',', '.') }}
                    </p>
                </div>
                <div class="bg-white p-4 rounded-lg shadow-sm">
                    <h3 class="text-sm font-medium text-gray-500">
                        Alokasi Jasa Usaha ({{ $period->persen_jasa_usaha }}%)
                    </h3>
                    <p class="mt-1 text-2xl font-semibold text-gray-900">
                        Rp {{ number_format($period->total_shu * ($period->persen_jasa_usaha / 100), 0, ',', '.') }}
                    </p>
                </div>
            </div>

            <main>
                <div class="bg-white shadow-sm ring-1 ring-gray-900/5 sm:rounded-xl">
                    <div class="overflow-x-auto">
                        <table class="min-w-full divide-y divide-gray-200">
                            <thead class="bg-gray-50">
                                <tr>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">NIK</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Nama
                                        Anggota</th>
                                    <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase">Modal
                                        (Total Simpanan)</th>
                                    <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase">
                                        Transaksi (Total Belanja)</th>
                                    <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase">SHU
                                        Modal</th>
                                    <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase">SHU
                                        Usaha</th>
                                    <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase">Total
                                        SHU Diterima</th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-200">
                                @forelse ($distributions as $dist)
                                    <tr>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                            {{ $dist->user->id_user ?? '-' }}
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">
                                            {{ $dist->user->nama ?? '-' }}
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 text-right">
                                            Rp {{ number_format($dist->total_simpanan_anggota, 0, ',', '.') }}
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 text-right">
                                            Rp {{ number_format($dist->total_belanja_anggota, 0, ',', '.') }}
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-green-600 text-right">
                                            Rp {{ number_format($dist->shu_jasa_modal, 0, ',', '.') }}
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-green-600 text-right">
                                            Rp {{ number_format($dist->shu_jasa_usaha, 0, ',', '.') }}
                                        </td>
                                        <td
                                            class="px-6 py-4 whitespace-nowrap text-sm font-bold text-blue-600 text-right">
                                            Rp
                                            {{ number_format($dist->shu_jasa_modal + $dist->shu_jasa_usaha, 0, ',', '.') }}
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="7" class="text-center p-5 text-gray-500">
                                            Tidak ada data distribusi untuk periode ini.
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
</body>

</html>
