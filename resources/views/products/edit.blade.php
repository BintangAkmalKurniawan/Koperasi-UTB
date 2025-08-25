<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Edit Produk</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</head>

<body class="bg-gray-200 min-h-screen flex flex-col">

    {{-- Menu --}}
    @include('Layout.menu')

    <!-- Header -->
    <header class="bg-[#49A84E] text-white py-10 mt-20">
        <div class="max-w-6xl mx-auto px-4 text-center">
            <h1 class="text-4xl font-extrabold">Edit Produk</h1>
        </div>
    </header>

    <!-- Form -->
    <main class="max-w-3xl mx-auto px-4 mt-8 flex-grow">
        <form action="{{ route('products.update', $product) }}" method="POST" enctype="multipart/form-data"
            class="bg-white p-6 rounded shadow-md space-y-4">
            @csrf
            @method('PUT')
            <!-- Nama -->
            <input type="text" name="name" value="{{ $product->name }}" placeholder="Nama Produk"
                class="border p-2 w-full rounded" />
            <!-- Deskripsi -->
            <textarea name="description" class="border p-2 w-full rounded">{{ $product->description }}</textarea>
            <!-- Harga -->
            <input type="number" step="0.01" name="price" value="{{ $product->price }}"
                class="border p-2 w-full rounded" />
            <!-- Stok -->
            <input type="number" name="stock" value="{{ $product->stock }}" class="border p-2 w-full rounded" />

            <!-- Pilih Kategori Produk -->
            <div>
                <label for="category" class="block font-semibold mb-1">Kategori Produk</label>
                <select id="category" name="category" required
                    class="border p-2 w-full rounded focus:ring focus:ring-green-300 @error('category') border-red-500 ring-1 ring-red-400 @enderror">
                    <option value="" disabled>-- Pilih Kategori --</option>
                    <option value="pertanian" {{ $product->category === 'pertanian' ? 'selected' : '' }}>Produk
                        Pertanian</option>
                    <option value="sarana" {{ $product->category === 'sarana' ? 'selected' : '' }}>Sarana Pertanian
                    </option>
                    <option value="UMKM" {{ $product->category === 'UMKM' ? 'selected' : '' }}>Produk UMKM</option>
                </select>
                @error('category')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>


            <!-- Gambar Lama -->
            @if ($product->images->count())
                <div class="flex flex-wrap gap-3">
                    @foreach ($product->images as $img)
                        <div class="relative group" id="img-{{ $img->id_product }}">
                            <img src="{{ asset('storage/' . $img->path) }}"
                                class="w-32 h-32 object-cover rounded shadow-sm" />
                            <button type="button"
                                onclick="hapusGambar({{ $product->id_product }}, {{ $img->id_product }})"
                                class="absolute top-0 right-0 bg-red-500 hover:bg-red-600 text-white px-2 rounded opacity-80 group-hover:opacity-100">
                                ×
                            </button>
                        </div>
                    @endforeach
                </div>
            @endif
            <!-- Tambah Gambar Baru -->
            <input type="file" name="images[]" class="border p-2 w-full rounded" multiple />

            <!-- Info Penjual -->
            <div>
                <label class="font-semibold">NIK Penjual:</label>
                <div class="flex gap-2 mt-1">
                    <input type="text" id="id_user" name="id_user" value="{{ $product->id_user }}"
                        class="border p-2 flex-1 rounded" />
                    <button type="button" onclick="cariAnggota()"
                        class="bg-[#49A84E] hover:bg-green-700 text-white px-4 rounded">
                        Cari
                    </button>
                </div>
            </div>
            <!-- Data Penjual -->
            <input type="text" id="nama_penjual" value="{{ $product->anggota->nama }}"
                class="border p-2 w-full rounded" readonly />
            <input type="text" id="alamat_penjual" value="{{ $product->anggota->alamat }}"
                class="border p-2 w-full rounded" readonly />
            <input type="text" id="hp_penjual" value="{{ $product->anggota->no_hp }}"
                class="border p-2 w-full rounded" readonly />
            <!-- Tombol Update -->
            <button type="submit" class="bg-[#49A84E] hover:bg-green-700 text-white px-6 py-2 rounded font-bold">
                Update
            </button>
        </form>
    </main>

    <script>
        function cariAnggota() {
            const id_user = document.getElementById('id_user').value;
            axios.get(`/anggota/search/${id_user}`)
                .then(res => {
                    document.getElementById('nama_penjual').value = res.data.nama || '';
                    document.getElementById('alamat_penjual').value = res.data.alamat || '';
                    document.getElementById('hp_penjual').value = res.data.no_hp || '';
                })
                .catch(() => {
                    Swal.fire({
                        icon: 'error',
                        title: 'Oops...',
                        text: 'Data anggota tidak ditemukan!'
                    });
                });
        }

        function hapusGambar(id_product, imageId) {
            Swal.fire({
                title: 'Yakin hapus gambar ini?',
                text: "Gambar akan dihapus permanen dari produk!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#d33',
                cancelButtonColor: '#3085d6',
                confirmButtonText: 'Ya, hapus',
                cancelButtonText: 'Batal'
            }).then((result) => {
                if (result.isConfirmed) {
                    axios.delete(`/products/${id_product}/images/${imageId}`, {
                        headers: {
                            'X-CSRF-TOKEN': '{{ csrf_token() }}'
                        }
                    }).then(res => {
                        if (res.data.success) {
                            document.getElementById(`img-${imageId}`).remove();
                            Swal.fire({
                                icon: 'success',
                                title: 'Berhasil!',
                                text: 'Gambar berhasil dihapus.',
                                timer: 1500,
                                showConfirmButton: false
                            });
                        } else {
                            Swal.fire({
                                icon: 'error',
                                title: 'Gagal!',
                                text: res.data.message || 'Gagal menghapus gambar.'
                            });
                        }
                    }).catch(() => {
                        Swal.fire({
                            icon: 'error',
                            title: 'Error!',
                            text: 'Terjadi kesalahan saat menghapus gambar.'
                        });
                    });
                }
            });
        }
    </script>
</body>

</html>
