<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Trash Produk</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</head>

<body class="bg-white min-h-screen flex flex-col">

    @include('Layout.menu')

    <!-- Header -->
    <header class="bg-[#49A84E] text-white py-10 mt-20">
        <div class="max-w-6xl mx-auto px-4 text-center">
            <h1 class="text-4xl font-extrabold">Trash Produk</h1>
        </div>
    </header>

    <div class="max-w-6xl mx-auto px-4 mt-6">
        <a href="{{ route('products.index') }}"
            class="inline-block bg-[#49A84E] text-white font-semibold px-4 py-2 rounded-lg shadow hover:bg-green-700 transition">
            ← Kembali ke Produk
        </a>
    </div>

    @if (session('success'))
        <script>
            document.addEventListener("DOMContentLoaded", () => {
                Swal.fire({
                    icon: 'success',
                    title: 'Berhasil!',
                    text: '{{ session('success') }}',
                    showConfirmButton: false,
                    timer: 2000,
                    timerProgressBar: true
                });
            });
        </script>
    @endif

    <main class="max-w-6xl mx-auto px-4 mt-8 grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6 flex-grow">
        @forelse($products as $product)
            <div class="bg-white rounded-lg shadow-lg p-4 flex flex-col">
                @if ($product->images->first())
                    <img src="{{ asset('storage/' . $product->images->first()->path) }}"
                        class="w-full h-40 object-cover rounded mb-2" />
                @endif
                <h2 class="text-lg font-semibold">{{ $product->name }}</h2>
                <p class="text-gray-600 text-sm mb-2">
                    {{ \Illuminate\Support\Str::limit($product->description, 100, '...') }}
                </p>
                <p class="text-gray-800 font-bold">Rp {{ number_format($product->price, 0, ',', '.') }}</p>

                <div class="mt-3 flex flex-wrap gap-2">
                    <form action="{{ route('products.restore', $product->id_product) }}" method="POST">
                        @csrf
                        <button type="submit"
                            class="bg-green-500 hover:bg-green-700 text-white px-3 py-1 rounded text-sm">
                            Pulihkan
                        </button>
                    </form>

                    <form id="delete-form-{{ $product->id_product }}"
                        action="{{ route('products.forceDelete', $product->id_product) }}" method="POST">
                        @csrf
                        @method('DELETE')
                        <button type="button" onclick="confirmDelete({{ $product->id_product }})"
                            class="bg-red-500 hover:bg-red-700 text-white px-3 py-1 rounded text-sm">
                            Hapus Permanen
                        </button>
                    </form>
                </div>
            </div>
        @empty
            <p class="text-gray-600 col-span-full text-center">Tidak ada produk di Trash.</p>
        @endforelse
    </main>

    <script>
        function confirmDelete(id_product) {
            Swal.fire({
                title: 'Yakin hapus permanen?',
                text: "Data ini tidak bisa dikembalikan!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#d33',
                cancelButtonColor: '#3085d6',
                confirmButtonText: 'Ya, hapus!',
                cancelButtonText: 'Batal'
            }).then((result) => {
                if (result.isConfirmed) {
                    document.getElementById(`delete-form-${id_product}`).submit();
                }
            })
        }
    </script>
</body>

</html>
