<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Daftar Produk</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</head>

<body class="bg-gray-50 min-h-screen flex flex-col">

    @include('Layout.menu')

    <header class="bg-[#49A84E] text-white py-6 mt-[70px] shadow">
        <div class="max-w-6xl mx-auto px-4 flex items-center justify-between">
            <!-- Judul -->
            <h1 class="text-3xl font-extrabold">Daftar Produk</h1>

            <!-- Tombol Aksi -->
            <div class="flex items-center gap-3">
                <a href="{{ route('products.create') }}"
                    class="bg-white text-[#49A84E] font-semibold py-2 px-5 rounded-md shadow hover:bg-gray-100 transition">
                    + Tambah Produk
                </a>
                <a href="{{ route('products.trash') }}"
                    class="bg-red-500 hover:bg-red-600 text-white font-semibold py-2 px-5 rounded-md shadow transition">
                    Trash Produk
                </a>
            </div>
        </div>
    </header>


    @if (session('success'))
        <script>
            document.addEventListener("DOMContentLoaded", function() {
                Swal.fire({
                    icon: 'success',
                    title: 'Berhasil',
                    text: "{{ session('success') }}",
                    confirmButtonColor: '#49A84E'
                });
            });
        </script>
    @endif

    {{-- <div class="max-w-6xl mx-auto px-4 mt-6 w-full flex items-center gap-4 justify-end">
    <a href="{{ route('products.create') }}"
        class="bg-[#49A84E] hover:bg-green-700 text-white font-semibold py-2 px-5 rounded-md shadow transition">
        + Tambah Produk
    </a>
    <a href="{{ route('products.trash') }}"
        class="bg-gray-600 hover:bg-gray-700 text-white font-semibold py-2 px-5 rounded-md shadow transition">
        Trash Produk
    </a>
</div> --}}


    <main class="max-w-6xl mx-auto px-4 mt-6 mb-10 flex-grow">

        <!-- Filter Kategori -->
        <div class="flex flex-wrap gap-3 mb-6 justify-center">
            <a href="{{ route('products.index') }}"
                class="px-4 py-2 rounded-full font-semibold text-sm 
                      {{ request('category') ? 'bg-gray-200 text-gray-700 hover:bg-gray-300' : 'bg-[#49A84E] text-white' }}">
                Semua
            </a>
            <a href="{{ route('products.index', ['category' => 'pertanian']) }}"
                class="px-4 py-2 rounded-full font-semibold text-sm 
                      {{ request('category') === 'pertanian' ? 'bg-[#49A84E] text-white' : 'bg-gray-200 text-gray-700 hover:bg-gray-300' }}">
                Pertanian
            </a>
            <a href="{{ route('products.index', ['category' => 'sarana']) }}"
                class="px-4 py-2 rounded-full font-semibold text-sm 
                      {{ request('category') === 'sarana' ? 'bg-[#49A84E] text-white' : 'bg-gray-200 text-gray-700 hover:bg-gray-300' }}">
                Sarana & Prasarana
            </a>
            <a href="{{ route('products.index', ['category' => 'umkm']) }}"
                class="px-4 py-2 rounded-full font-semibold text-sm 
                      {{ request('category') === 'umkm' ? 'bg-[#49A84E] text-white' : 'bg-gray-200 text-gray-700 hover:bg-gray-300' }}">
                UMKM
            </a>
        </div>

        <!-- Grid Produk -->
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6">
            @forelse ($products as $product)
                <div
                    class="bg-white rounded-lg border-2 border-gray-300 shadow-md p-4 flex flex-col h-full transition hover:shadow-lg">

                    <!-- Gambar Produk + Label Kategori -->
                    <div class="relative mb-3">
                        @if ($product->images->first())
                            <img src="{{ asset('storage/' . $product->images->first()->path) }}"
                                alt="{{ $product->name }}" class="w-full h-44 object-cover rounded" />
                        @else
                            <div class="w-full h-44 bg-gray-200 flex items-center justify-center rounded text-gray-500">
                                Tidak ada gambar
                            </div>
                        @endif

                        <!-- Label kategori -->
                        <span
                            class="absolute top-2 left-2 bg-green-600 text-white text-xs font-semibold px-2 py-1 rounded">
                            @if ($product->category === 'pertanian')
                                Produk Pertanian
                            @elseif($product->category === 'sarana')
                                Sarana Pertanian
                            @else
                                Produk UMKM
                            @endif
                        </span>
                    </div>

                    <!-- Nama -->
                    <h2 class="text-base sm:text-lg font-bold mb-1">
                        {{ $product->name }}
                    </h2>

                    <!-- Deskripsi dibatasi 3 baris -->
                    <p class="text-gray-600 text-sm mb-3 line-clamp-3">
                        {{ $product->description }}
                    </p>

                    <!-- Harga & stok, selalu di bawah -->
                    <div class="mt-auto">
                        <p class="text-green-700 font-bold">
                            Rp {{ number_format($product->price, 0, ',', '.') }}
                        </p>
                        <p class="text-sm text-gray-500">
                            Stok: {{ $product->stock }}
                        </p>
                    </div>

                    <!-- Tombol Aksi -->
                    <div class="flex justify-center gap-3 px-3 ">
                        <a href="{{ route('products.show', $product->id_product) }}"
                            class="bg-green-600 hover:bg-green-700 text-white font-semibold py-2 px-4 rounded-lg shadow transition inline-block">
                            Detail
                        </a>
                        <a href="{{ route('products.edit', $product->id_product) }}"
                            class="bg-yellow-500 hover:bg-yellow-600 text-white font-semibold py-2 px-4 rounded-lg shadow transition inline-block">
                            Edit
                        </a>
                        <form action="{{ route('products.destroy', $product->id_product) }}" method="POST"
                            onsubmit="return confirm('Yakin hapus produk ini?')" class="inline-block">
                            @csrf
                            @method('DELETE')
                            <button type="submit"
                                class="bg-red-500 hover:bg-red-600 text-white font-semibold py-2 px-4 rounded-lg shadow transition">
                                Hapus
                            </button>
                        </form>
                    </div>

                </div>
            @empty
                <p class="text-gray-600 col-span-full text-center py-10">
                    Belum ada produk.
                </p>
            @endforelse
        </div>
    </main>

    <script>
        document.addEventListener("DOMContentLoaded", function() {
            const deleteForms = document.querySelectorAll(".delete-form");

            deleteForms.forEach(form => {
                form.addEventListener("submit", function(e) {
                    e.preventDefault();
                    Swal.fire({
                        title: 'Yakin hapus produk ini?',
                        text: "Produk akan dipindahkan ke trash",
                        icon: 'warning',
                        showCancelButton: true,
                        confirmButtonColor: '#d33',
                        cancelButtonColor: '#6c757d',
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
