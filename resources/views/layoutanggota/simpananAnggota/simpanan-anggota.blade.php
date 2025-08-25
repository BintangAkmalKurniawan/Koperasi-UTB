<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Simpanan Anggota</title>

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
            <h1 class="text-4xl font-bold tracking-wider">SIMPANAN ANGGOTA</h1>
        </section>

        <section class="py-8 px-4">
            <div class="max-w-4xl mx-auto space-y-8">

                {{-- Lakukan perulangan untuk setiap bulan dari data $simpananPerBulan --}}
                @forelse ($simpananPerBulan as $bulan => $simpanan)
                    <div class="bg-white rounded-lg shadow-md p-6 sm:p-8">
                        <h2 class="text-3xl font-bold mb-4 pb-4 border-b border-gray-200">{{ $bulan }}</h2>
                        <ul class="space-y-3">
                            {{-- Lakukan perulangan untuk setiap item simpanan di bulan tersebut --}}
                            @foreach ($simpanan as $item)
                                <li class="flex justify-between items-center text-lg">
                                    {{-- Mengubah format nama simpanan agar lebih rapi --}}
                                    <span
                                        class="text-gray-600 capitalize">{{ str_replace('_', ' ', $item->jenis_simpanan) }}</span>
                                    {{-- Format angka menjadi format Rupiah --}}
                                    <span
                                        class="font-semibold text-gray-800">Rp.{{ number_format($item->jumlah, 0, ',', '.') }}</span>
                                </li>
                            @endforeach
                        </ul>
                    </div>
                @empty
                    {{-- Tampilkan pesan ini jika tidak ada riwayat simpanan sama sekali --}}
                    <div class="bg-white rounded-lg shadow-md p-8 text-center">
                        <p class="text-gray-500">Belum ada riwayat simpanan yang tercatat.</p>
                    </div>
                @endforelse

            </div>
        </section>
    </main>

    @include('layoutanggota.a.footer-anggota')
</body>

</html>
