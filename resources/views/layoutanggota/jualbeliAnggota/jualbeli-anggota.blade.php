<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Transaksi Anggota</title>

    <link rel="preconnect" href="https://fonts.googleapis.com" />
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap"
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
            <h1 class="text-4xl font-bold tracking-wider">TRANSAKSI ANGGOTA</h1>
        </section>

        <section class="py-8 px-4">
            <div class="max-w-6xl mx-auto">
                <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">

                    @forelse ($transaksis as $transaksi)
                        <div class="bg-white rounded-lg shadow-md flex flex-col">
                            {{-- Header Transaksi --}}
                            <div class="p-4 border-b border-gray-200 flex justify-between items-center">
                                <div>
                                    <p class="font-semibold text-gray-800">
                                        No. Transaksi: {{ $transaksi->no_transaksi }}
                                    </p>
                                    <p class="text-sm text-gray-500">
                                        {{ \Carbon\Carbon::parse($transaksi->tanggal_transaksi)->translatedFormat('l, d F Y') }}
                                    </p>
                                </div>
                                <div class="text-right">
                                    <p class="text-gray-600">Total Belanja</p>
                                    <p class="font-bold text-xl text-green-600">
                                        Rp {{ number_format($transaksi->total_harga, 0, ',', '.') }}
                                    </p>
                                </div>
                            </div>

                            {{-- Detail Produk --}}
                            @foreach ($transaksi->detailTransaksis as $detail)
                                <div class="p-6 flex gap-6 border-b border-gray-100 last:border-b-0">
                                    <img src="{{ $detail->produk->image ?? 'https://placehold.co/100x100/e2e8f0/475569?text=Gambar' }}"
                                        alt="Gambar Produk" class="w-24 h-24 object-cover rounded-md flex-shrink-0">

                                    <div>
                                        <p class="text-lg font-semibold mb-1">
                                            {{ $detail->produk->name ?? 'Produk Telah Dihapus' }}
                                        </p>
                                        <p class="text-base text-gray-600 mb-2">
                                            {{ $detail->jumlah }} x
                                            Rp.{{ number_format($detail->harga_satuan, 0, ',', '.') }}
                                        </p>
                                        <p class="text-lg font-bold text-gray-800">
                                            Subtotal Rp.{{ number_format($detail->subtotal, 0, ',', '.') }}
                                        </p>

                                        {{-- Status sebagai pembeli atau penjual --}}
                                        @if ($transaksi->id_user == Auth::user()->id_user)
                                            <span class="text-sm text-green-600 font-semibold">Sebagai Pembeli</span>
                                        @elseif ($detail->produk && $detail->produk->id_user == Auth::user()->id_user)
                                            <span class="text-sm text-blue-600 font-semibold">Sebagai Penjual</span>
                                        @endif
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    @empty
                        <div class="col-span-2 text-center text-gray-600">
                            <p>Tidak ada transaksi ditemukan.</p>
                        </div>
                    @endforelse

                </div>
            </div>
        </section>
    </main>

    <footer class="bg-green-900 text-white">
        @include('layoutanggota.a.footer-anggota')
    </footer>

    <script>
        feather.replace();

        const navbarNav = document.querySelector('#navbarNav');
        const hamburgerMenu = document.querySelector('#hamburger-menu');

        hamburgerMenu.onclick = (e) => {
            navbarNav.classList.toggle('-right-full');
            navbarNav.classList.toggle('right-0');
            e.preventDefault();
        };

        document.addEventListener('click', function(e) {
            if (!hamburgerMenu.contains(e.target) && !navbarNav.contains(e.target)) {
                navbarNav.classList.remove('right-0');
                navbarNav.classList.add('-right-full');
            }
        });
    </script>
</body>

</html>
