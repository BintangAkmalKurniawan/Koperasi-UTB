<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Produk Anggota</title>
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
            <h1 class="text-4xl font-bold tracking-wider">PRODUK ANGGOTA</h1>
        </section>

        <section class="py-0">
            <main class="max-w-6xl mx-auto px-4 mt-6 mb-10 flex-grow">

                {{-- Tab Menu --}}
                <div class="mb-6">
                    <div class="border-b border-gray-200">
                        <nav class="-mb-px flex space-x-8 justify-center" aria-label="Tabs">
                            <a href="#" id="tab-semuaProduk" onclick="switchTab('semuaProduk')"
                                class="whitespace-nowrap py-4 px-1 border-b-2 font-medium text-lg text-green-600 border-green-500">
                                Semua Produk
                            </a>
                            <a href="#" id="tab-produkPribadi" onclick="switchTab('produkPribadi')"
                                class="whitespace-nowrap py-4 px-1 border-b-2 font-medium text-lg text-gray-500 hover:text-gray-700 hover:border-gray-300 border-transparent">
                                Produk Pribadi
                            </a>
                        </nav>
                    </div>
                </div>

                {{-- Konten Semua Produk --}}
                <div id="content-semuaProduk">
                    {{-- Filter Kategori (Hanya di Semua Produk) --}}
                    <div class="flex flex-wrap gap-3 mb-6 justify-center">
                        <a href="{{ route('anggota.produk.index') }}"
                            class="px-4 py-2 rounded-lg text-sm font-semibold 
                                  {{ !$selectedCategory ? 'bg-green-600 text-white' : 'bg-gray-200 text-gray-700 hover:bg-gray-300' }}">
                            Semua Kategori
                        </a>

                        @foreach ($categories as $category)
                            <a href="{{ route('anggota.produk.index', ['category' => $category]) }}"
                                class="px-4 py-2 rounded-lg text-sm font-semibold capitalize
                                      {{ $selectedCategory === $category ? 'bg-green-600 text-white' : 'bg-gray-200 text-gray-700 hover:bg-gray-300' }}">
                                {{ $category }}
                            </a>
                        @endforeach
                    </div>

                    {{-- Grid Produk --}}
                    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6">
                        @forelse ($products as $product)
                            <div
                                class="bg-white rounded-lg shadow-md p-4 flex flex-col h-full transition hover:shadow-lg">
                                {{-- Gambar Produk --}}
                                @if ($product->images->first())
                                    <img src="{{ asset('storage/' . $product->images->first()->path) }}"
                                        alt="{{ $product->name }}" class="w-full h-44 object-cover rounded mb-3" />
                                @else
                                    <div
                                        class="w-full h-44 bg-gray-200 flex items-center justify-center rounded mb-3 text-gray-500">
                                        Tidak ada gambar
                                    </div>
                                @endif

                                <h2 class="text-base sm:text-lg font-bold mb-1">{{ $product->name }}</h2>
                                <p class="text-gray-600 text-sm mb-3 line-clamp-3">{{ $product->description }}</p>

                                <div class="mt-auto">
                                    <p class="text-green-700 font-bold">Rp
                                        {{ number_format($product->price, 0, ',', '.') }}</p>
                                    <p class="text-sm text-gray-500">Stok: {{ $product->stock }}</p>
                                </div>

                                <div class="mt-5 flex justify-center gap-3">
                                    <a href="{{ route('anggota.produk.show', $product->id_product) }}"
                                        class="bg-[#49A84E] hover:bg-green-700 text-white px-5 py-2 rounded text-base font-semibold transition">
                                        Detail
                                    </a>
                                </div>
                            </div>
                        @empty
                            <p class="text-gray-600 col-span-full text-center py-10">
                                Belum ada produk.
                            </p>
                        @endforelse
                    </div>
                </div>

                {{-- Konten Produk Pribadi --}}
                <div id="content-produkPribadi" class="hidden">
                    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6">
                        @forelse ($productSendiri as $product)
                            <div
                                class="bg-white rounded-lg shadow-md p-4 flex flex-col h-full transition hover:shadow-lg">
                                {{-- Gambar Produk --}}
                                @if ($product->images->first())
                                    <img src="{{ asset('storage/' . $product->images->first()->path) }}"
                                        alt="{{ $product->name }}" class="w-full h-44 object-cover rounded mb-3" />
                                @else
                                    <div
                                        class="w-full h-44 bg-gray-200 flex items-center justify-center rounded mb-3 text-gray-500">
                                        Tidak ada gambar
                                    </div>
                                @endif

                                <h2 class="text-base sm:text-lg font-bold mb-1 line-clamp-1">{{ $product->name }}</h2>
                                <p class="text-gray-600 text-sm mb-3 line-clamp-3 flex-grow">
                                    {{ $product->description ?? 'Tidak ada deskripsi.' }}</p>

                                <div class="mt-auto pt-4">
                                    <p class="text-green-700 font-bold text-lg">Rp
                                        {{ number_format($product->price, 0, ',', '.') }}</p>
                                    <p class="text-sm text-gray-500">Stok: {{ $product->stock }}</p>
                                </div>

                                <div class="mt-5 flex justify-center gap-3 border-t pt-4">
                                    <a href="{{ route('anggota.produk.show', $product->id_product) }}"
                                        class="bg-[#49A84E] hover:bg-green-700 text-white px-5 py-2 rounded text-sm font-semibold transition">
                                        Detail
                                    </a>
                                </div>
                            </div>
                        @empty
                            <div class="col-span-full text-center py-20 bg-white rounded-lg shadow-md">
                                <p class="text-gray-500 text-xl">Anda belum menambahkan produk apapun.</p>
                            </div>
                        @endforelse
                    </div>
                </div>

            </main>
        </section>
    </main>

    @include('layoutanggota.a.footer-anggota')

    <script>
        function switchTab(tab) {
            document.getElementById('content-semuaProduk').classList.add('hidden');
            document.getElementById('content-produkPribadi').classList.add('hidden');

            document.getElementById('tab-semuaProduk').className =
                'whitespace-nowrap py-4 px-1 border-b-2 font-medium text-lg text-gray-500 hover:text-gray-700 hover:border-gray-300 border-transparent';
            document.getElementById('tab-produkPribadi').className =
                'whitespace-nowrap py-4 px-1 border-b-2 font-medium text-lg text-gray-500 hover:text-gray-700 hover:border-gray-300 border-transparent';

            if (tab === 'semuaProduk') {
                document.getElementById('content-semuaProduk').classList.remove('hidden');
                document.getElementById('tab-semuaProduk').className =
                    'whitespace-nowrap py-4 px-1 border-b-2 font-medium text-lg text-green-600 border-green-500';
            } else if (tab === 'produkPribadi') {
                document.getElementById('content-produkPribadi').classList.remove('hidden');
                document.getElementById('tab-produkPribadi').className =
                    'whitespace-nowrap py-4 px-1 border-b-2 font-medium text-lg text-green-600 border-green-500';
            }
        }
    </script>
</body>

</html>
