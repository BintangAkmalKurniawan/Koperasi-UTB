<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Beranda Anggota</title>

    <link rel="preconnect" href="https://fonts.googleapis.com" />
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
    <link
        href="https://fonts.googleapis.com/css2?family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900&display=swap"
        rel="stylesheet" />

    <script src="https://unpkg.com/feather-icons"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css">

    <script src="https://cdn.tailwindcss.com"></script>

    <script>
        tailwind.config = {
            theme: {
                extend: {
                    fontFamily: {
                        poppins: ['Poppins', 'sans-serif'],
                    },
                },
            },
        };
    </script>
</head>

<body class="font-poppins bg-gray-100 text-gray-800">

    <header>
        @include('layoutanggota.a.navbar-anggota')
    </header>

    <main class="pt-16 mb-[150px]">
        <section class="bg-[#4caf50] text-white text-center py-10 px-4">
            <h1 class="text-4xl font-bold tracking-wider">SELAMAT DATANG</h1>
        </section>

        <section class="py-16">
            <div class="max-w-7xl mx-auto px-4">
                <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">

                    <div class="bg-white rounded-lg shadow-md p-6 flex flex-col">
                        <div class="flex items-center justify-between gap-4 mb-4">
                            <div class="bg-blue-100 text-blue-600 p-3 rounded-lg">
                                <i data-feather="dollar-sign" class="w-7 h-7"></i>
                            </div>
                            <h3 class="text-2xl font-semibold text-gray-800">Tabungan Anda</h3>
                        </div>
                        <div class="flex-grow">
                            <p class="text-sm text-gray-500 mb-2">Total Saldo Saat Ini:</p>
                            @forelse ($tabungan as $totalTabungan)
                                <p class="text-4xl font-bold text-gray-900 mb-4">Rp.
                                    {{ number_format($totalTabungan->total_tabungan, 0, ',', '.') }}
                                </p>
                            @empty
                                <p class="text-4xl font-bold text-gray-900 mb-4">Belum Menabung
                                </p>
                            @endforelse

                        </div>
                        <a href="{{ route('tabunganAnggota') }}"
                            class="block text-green-700 font-semibold mt-6 self-start hover:underline">
                            Lihat Selengkapnya &rarr;
                        </a>
                    </div>

                    <div class="bg-white rounded-lg shadow-md p-6 flex flex-col">
                        <div class="flex items-center gap-4 mb-4">
                            <div class="bg-purple-100 text-purple-600 p-3 rounded-lg">
                                <i data-feather="pie-chart" class="w-7 h-7"></i>
                            </div>
                            <h3 class="text-2xl font-semibold text-gray-800">SHU Anggota</h3>
                        </div>
                        <div class="flex-grow">
                            @if ($shu)
                                <p class="text-sm text-gray-500 mb-2">
                                    Sisa Hasil Usaha Tahun {{ $shu->shuPeriod->periode ?? 'N/A' }}:
                                </p>

                                @php
                                    $totalShuDiterima = $shu->shu_jasa_modal + $shu->shu_jasa_usaha;
                                @endphp

                                <p class="text-4xl font-bold text-gray-900 mb-4">
                                    Rp {{ number_format($totalShuDiterima, 0, ',', '.') }}
                                </p>

                                <p class="text-sm text-gray-500">Unduh laporan Sisa Hasil Usaha (SHU) tahunan Anda di
                                    sini.</p>
                                <a href="{{ route('shuAnggota') }}"
                                    class="block text-green-700 font-semibold mt-6 self-start hover:underline">
                                    Lihat Selengkapnya &rarr;
                                </a>
                            @else
                                <p class="text-sm text-gray-500 mb-2">Sisa Hasil Usaha Tahun Terakhir:</p>
                                <p class="text-4xl font-bold text-gray-900 mb-4">Rp 0</p>
                                <p class="text-sm text-gray-500">Belum ada data SHU yang dibagikan.</p>
                            @endif


                        </div>

                    </div>

                </div>
                <div class="bg-white rounded-lg shadow-md p-6 mt-20 flex flex-col">
                    <div class="flex items-center gap-4 mb-4">
                        <div class="bg-green-100 text-green-600 p-3 rounded-lg">
                            <i data-feather="shopping-cart" class="w-7 h-7"></i>
                        </div>
                        <h3 class="text-2xl font-semibold text-gray-800">Produk Koperasi</h3>
                    </div>
                    <div class="flex-grow">
                        <p class="text-sm text-gray-500 mb-4">Lihat dan beli berbagai produk unggulan dari anggota
                            koperasi.</p>
                        <p class="text-sm text-gray-500 mb-4">Jumlah Produk anda:</p>
                        <div class="flex -space-x-4">
                            <p class="text-3xl font-bold text-brand-green-dark mt-1">{{ $product }}
                            </p>
                        </div>
                    </div>
                    <a href="{{ route('anggota.produk.index') }}"
                        class="block text-green-700 font-semibold mt-6 self-start hover:underline">
                        Lihat Selengkapnya &rarr;
                    </a>
                </div>
            </div>
        </section>
    </main>

    @include('layoutanggota.a.footer-anggota')

</body>

</html>
