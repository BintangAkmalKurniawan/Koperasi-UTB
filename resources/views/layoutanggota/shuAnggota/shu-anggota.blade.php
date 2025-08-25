<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>SHU Anggota</title>

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

    <main class="pt-16">
        <section class="bg-[#4caf50] text-white text-center py-10 px-4">
            <h1 class="text-4xl font-bold tracking-wider">SHU ANGGOTA</h1>
        </section>

        <section class="py-16">
            <div class="max-w-7xl mx-auto px-4">
                {{-- Cek jika ada data SHU --}}
                @if ($shu->count() > 0)
                    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-8">
                        {{-- Lakukan perulangan untuk setiap data SHU --}}
                        @foreach ($shu as $item)
                            <div
                                class="bg-white rounded-lg shadow-md p-6 flex flex-col transition-transform duration-300 hover:-translate-y-1.5 hover:shadow-lg">
                                <div
                                    class="bg-blue-100 text-blue-600 w-12 h-12 rounded-lg flex items-center justify-center mb-4">
                                    <i data-feather="file-text" class="w-7 h-7"></i>
                                </div>
                                <div class="flex-grow">
                                    @php
                                        $totalShuDiterima = $item->shu_jasa_modal + $item->shu_jasa_usaha;
                                    @endphp
                                    <h3 class="text-xl font-semibold mb-2 text-[#2e7d32]">SHU Tahun
                                        {{ $item->shuPeriod->periode ?? 'N/A' }}</h3>
                                    <p class="text-gray-600 text-sm mb-6">Laporan Sisa Hasil Usaha (SHU) Anda untuk
                                        periode
                                        tahun {{ $item->shuPeriod->periode ?? 'N/A' }}.</p>
                                    <p class="text-gray-600 text-sm mb-6">Nominal yang didapat:
                                        Rp. {{ number_format($totalShuDiterima, 0, ',', '.' ?? 'N/A') }}.</p>
                                </div>
                                {{-- <div class="flex gap-3 mt-auto">
                                    <a href="#"
                                        class="flex-1 text-center bg-[#4caf50] text-white font-semibold py-2 px-4 rounded-md transition-colors duration-200 hover:bg-[#218838] flex items-center justify-center gap-2">
                                        <i data-feather="download" class="w-4 h-4"></i>Unduh
                                    </a>
                                    <a href="#"
                                        class="flex-1 text-center bg-gray-100 text-gray-800 font-semibold py-2 px-4 rounded-md transition-colors duration-200 hover:bg-gray-200 flex items-center justify-center gap-2">
                                        <i data-feather="eye" class="w-4 h-4"></i>Lihat
                                    </a>
                                </div> --}}
                            </div>
                        @endforeach
                    </div>
                @else
                    {{-- Tampilkan pesan jika tidak ada data --}}
                    <div class="text-center bg-white p-8 rounded-lg shadow-md">
                        <p class="text-gray-500">Belum ada data Sisa Hasil Usaha (SHU) untuk Anda.</p>
                    </div>
                @endif
            </div>
        </section>
    </main>

    <footer class="mt-auto">
        @include('layoutanggota.a.footer-anggota')
    </footer>

    <script>
        feather.replace();
    </script>
</body>

</html>
