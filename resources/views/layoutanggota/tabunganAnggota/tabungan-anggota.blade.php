<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Tabungan Anggota</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
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
            <h1 class="text-4xl font-bold tracking-wider">TABUNGAN ANGGOTA</h1>
        </section>

        <section class="py-8 px-4">
            <div class="max-w-4xl mx-auto">
                <div class="bg-white rounded-lg shadow-md p-6 mb-8">
                    @forelse ($tabungan as $item)
                        <h2 class="text-2xl font-semibold mb-2">Saldo</h2>
                        <p class="text-4xl font-bold text-gray-800">
                            {{ number_format($item->total_tabungan, 0, ',', '.') }}</p>
                </div>
                <div class="bg-white rounded-lg shadow-md p-6">
                    <h2 class="text-2xl font-semibold mb-2">Riwayat</h2>
                    <ul class="list-none">
                        @foreach ($item->riwayat as $riwayat)
                            <li
                                class="flex flex-col sm:flex-row justify-between items-start sm:items-center py-4 border-b border-gray-200 gap-2">
                                <div class="text-gray-600">
                                    <span class="block sm:inline">{{ $riwayat->tanggal_transaksi }}</span>
                                </div>
                                <div class="w-full sm:w-auto flex justify-between sm:text-right">

                                    @if ($riwayat->jenis_transaksi === 'menabung')
                                        <span class="font-semibold text-green-600">+
                                            {{ $riwayat->jenis_transaksi }}</span>
                                        <span class="font-semibold text-green-600 ml-4">{{ $riwayat->jumlah }}</span>
                                    @else
                                        <span class="font-semibold text-red-600">-
                                            {{ $riwayat->jenis_transaksi }}</span>
                                        <span class="font-semibold text-red-600 ml-4">{{ $riwayat->jumlah }}</span>
                                    @endif
                                </div>
                            </li>
                        @endforeach

                    </ul>



                    {{-- <li
                        class="flex flex-col sm:flex-row justify-between items-start sm:items-center py-4 border-b border-gray-200 gap-2">
                        <div class="text-gray-600">
                            <span class="block sm:inline">Jum'at, 8 Agustus 2025</span>
                            <span class="block sm:inline ml-0 sm:ml-4">13:00 WIB</span>
                        </div>
                        <div class="w-full sm:w-auto flex justify-between sm:text-right">
                            <span class="font-semibold text-red-600">Keluar</span>
                            <span class="font-semibold text-red-600 ml-4">-Rp.50.000</span>
                        </div>
                    </li>
                    <li class="flex flex-col sm:flex-row justify-between items-start sm:items-center py-4 gap-2">
                        <div class="text-gray-600">
                            <span class="block sm:inline">Jum'at, 8 Agustus 2025</span>
                            <span class="block sm:inline ml-0 sm:ml-4">13:00 WIB</span>
                        </div>
                        <div class="w-full sm:w-auto flex justify-between sm:text-right">
                            <span class="font-semibold text-green-600">Masuk</span>
                            <span class="font-semibold text-green-600 ml-4">+Rp.50.000</span>
                        </div>
                    </li> --}}

                </div>
            @empty
                @endforelse




            </div>
        </section>
    </main>

    @include('layoutanggota.a.footer-anggota')
</body>

</html>
