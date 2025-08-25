<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Detail Produk Anggota</title>

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

    <!-- Header hijau -->
    <header>
        @include('layoutanggota.a.navbar-anggota')
    </header>

    <main class="pt-16">
        <section class="bg-[#4caf50] text-white text-center py-10 px-4">
            <h1 class="text-4xl font-bold tracking-wider">DETAIL PRODUK</h1>
        </section>


        <div class="bg-white p-6 md:p-8 rounded-2xl shadow-lg">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-8 items-start">

                <div class="space-y-4">
                    @if ($product->images->count())
                        @php $first = $product->images->first(); @endphp
                        <div class="w-full bg-gray-100 rounded-2xl overflow-hidden border border-gray-200 shadow-md">
                            <img id="mainImage" src="{{ asset('storage/' . $first->path) }}"
                                alt="Gambar produk {{ $product->name }}"
                                class="w-full h-96 md:h-[520px] object-cover transition duration-300" loading="lazy" />
                        </div>
                        @if ($product->images->count() > 1)
                            <div class="flex gap-3 overflow-x-auto pb-1">
                                @foreach ($product->images as $img)
                                    <img src="{{ asset('storage/' . $img->path) }}" alt="Thumbnail {{ $product->name }}"
                                        class="w-20 h-20 object-cover rounded-lg border border-gray-200 shadow-sm cursor-pointer hover:opacity-80"
                                        loading="lazy" onclick="document.getElementById('mainImage').src = this.src" />
                                @endforeach
                            </div>
                        @endif
                    @else
                        <div
                            class="w-full h-96 md:h-[520px] bg-gradient-to-br from-gray-100 to-gray-200 rounded-2xl border border-gray-200 grid place-items-center text-gray-500">
                            Tidak ada gambar produk
                        </div>
                    @endif
                </div>

                <div class="space-y-6">
                    <h2 class="text-3xl font-bold text-gray-900">{{ $product->name }}</h2>
                    <section>
                        <h3 class="text-xs font-semibold uppercase tracking-wider text-gray-500">Deskripsi</h3>
                        <p class="mt-2 text-gray-700 leading-relaxed text-justify">
                            {{ $product->description }}
                        </p>
                    </section>
                    <section class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                        <div class="bg-gray-50 border border-gray-200 rounded-xl p-4">
                            <div class="text-xs font-semibold uppercase tracking-wider text-gray-500">Harga</div>
                            <div class="mt-1 text-2xl font-bold text-green-700">
                                Rp {{ number_format($product->price, 0, ',', '.') }}
                            </div>
                        </div>
                        <div class="bg-gray-50 border border-gray-200 rounded-xl p-4">
                            <div class="text-xs font-semibold uppercase tracking-wider text-gray-500">Stok</div>
                            <div class="mt-1 text-xl font-semibold text-gray-900">
                                {{ $product->stock }}
                            </div>
                        </div>
                    </section>
                    <section>
                        <h3 class="text-xs font-semibold uppercase tracking-wider text-gray-500 mb-3">Data Penjual</h3>
                        <table class="w-full border border-gray-200 rounded-lg overflow-hidden">
                            <tbody class="divide-y divide-gray-200">
                                <tr>
                                    <td class="bg-gray-50 font-semibold text-gray-700 p-3 w-28">Nama</td>
                                    <td class="p-3">{{ $product->anggota->nama }}</td>
                                </tr>
                                <tr>
                                    <td class="bg-gray-50 font-semibold text-gray-700 p-3 w-28">Alamat</td>
                                    <td class="p-3">{{ $product->anggota->alamat }}</td>
                                </tr>
                                <tr>
                                    <td class="bg-gray-50 font-semibold text-gray-700 p-3 w-28">Kontak</td>
                                    <td class="p-3">{{ $product->anggota->no_hp }}</td>
                                </tr>
                            </tbody>
                        </table>
                    </section>

                    <div class="pt-4">
                        <div class="flex flex-wrap items-center gap-3">
                            <a href="{{ route('anggota.produk.index') }}"
                                class="inline-flex items-center gap-2 bg-gray-200 hover:bg-gray-300 text-gray-800 px-6 py-3 rounded-lg font-semibold border border-gray-300 shadow-sm transition">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none"
                                    viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                                </svg>
                                Kembali ke Daftar Produk
                            </a>

                            @php
                                $raw = preg_replace('/\D+/', '', (string) ($product->anggota->no_hp ?? ''));
                                $normalized = $raw ? '62' . ltrim($raw, '0') : null;
                                $waText = urlencode('Halo, saya tertarik dengan produk ' . $product->name);
                            @endphp

                            @if ($normalized)
                                <a href="https://wa.me/{{ $normalized }}?text={{ $waText }}" target="_blank"
                                    rel="noopener"
                                    class="inline-flex items-center gap-2 bg-green-500 hover:bg-green-600 text-white px-6 py-3 rounded-lg font-semibold shadow transition">
                                    <img src="https://upload.wikimedia.org/wikipedia/commons/6/6b/WhatsApp.svg"
                                        alt="WhatsApp" class="h-5 w-5" />
                                    Hubungi via WhatsApp
                                </a>
                            @else
                                <button type="button"
                                    class="inline-flex items-center gap-2 bg-gray-100 text-gray-400 px-6 py-3 rounded-lg font-semibold border border-gray-200 cursor-not-allowed"
                                    title="Nomor WhatsApp belum tersedia">
                                    <img src="https://upload.wikimedia.org/wikipedia/commons/6/6b/WhatsApp.svg"
                                        alt="WhatsApp" class="h-5 w-5 opacity-40" />
                                    Hubungi via WhatsApp
                                </button>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>
    @include('layoutanggota.a.footer-anggota')
</body>

</html>
