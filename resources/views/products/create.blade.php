<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Tambah Produk</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>

    <style>
        @keyframes stroke {
            to {
                stroke-dashoffset: 0;
            }
        }

        @keyframes scaleIn {
            0% {
                transform: scale(.9);
                opacity: 0;
            }

            100% {
                transform: scale(1);
                opacity: 1;
            }
        }

        .circle-path {
            stroke-dasharray: 165;
            stroke-dashoffset: 165;
            animation: stroke .7s ease forwards;
        }

        .check-path {
            stroke-dasharray: 48;
            stroke-dashoffset: 48;
            animation: stroke .5s ease .2s forwards;
        }

        .overlay-card {
            animation: scaleIn .25s ease-out forwards;
        }
    </style>
</head>

<body class="bg-gray-200 min-h-screen flex flex-col">

    @include('Layout.menu')

    <header class="bg-[#49A84E] text-white py-10 mt-[70px] shadow">
        <div class="max-w-6xl mx-auto px-4 text-center">
            <h1 class="text-4xl font-extrabold">Tambah Produk</h1>
        </div>
    </header>

    <main class="w-full px-4 sm:px-6 lg:px-8 xl:px-16 mt-8 flex-grow">
        <form id="product-form" action="{{ route('products.store') }}" method="POST" enctype="multipart/form-data"
            class="mx-auto w-full max-w-screen-lg bg-white p-6 sm:p-8 rounded-2xl shadow-xl border border-gray-200 space-y-6">
            @csrf

            <div>
                <label for="name" class="block font-semibold mb-1">Nama Produk</label>
                <input id="name" type="text" name="name" placeholder="Masukkan nama produk" required
                    value="{{ old('name') }}"
                    class="border p-2 w-full rounded focus:ring focus:ring-green-300 @error('name') border-red-500 ring-1 ring-red-400 @enderror" />
                @error('name')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
                <p class="mt-1 text-sm text-red-600 hidden" data-error-for="name"></p>
            </div>

            <div>
                <label for="description" class="block font-semibold mb-1">Deskripsi</label>
                <textarea id="description" name="description" rows="3" placeholder="Masukkan deskripsi produk" required
                    class="border p-2 w-full rounded focus:ring focus:ring-green-300 @error('description') border-red-500 ring-1 ring-red-400 @enderror">{{ old('description') }}</textarea>
                @error('description')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
                <p class="mt-1 text-sm text-red-600 hidden" data-error-for="description"></p>
            </div>

            <!-- Harga & Stok -->
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                <!-- Harga dengan format Rp dan pemisah ribuan -->
                <div>
                    <label for="price_display" class="block font-semibold mb-1">Harga</label>

                    <input id="price_display" type="text" inputmode="numeric" placeholder="Rp 0"
                        class="border p-2 w-full rounded focus:ring focus:ring-green-300 @error('price') border-red-500 ring-1 ring-red-400 @enderror"
                        autocomplete="off" value="" />
                    <input id="price" type="hidden" name="price" value="{{ old('price') }}" />
                    @error('price')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                    <p class="mt-1 text-sm text-red-600 hidden" data-error-for="price"></p>
                </div>
                <div>
                    <label for="stock" class="block font-semibold mb-1">Stok</label>
                    <input id="stock" type="number" min="0" step="1" name="stock"
                        placeholder="Masukkan Stok" required value="{{ old('stock') }}"
                        class="border p-2 w-full rounded focus:ring focus:ring-green-300 @error('stock') border-red-500 ring-1 ring-red-400 @enderror" />
                    @error('stock')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                    <p class="mt-1 text-sm text-red-600 hidden" data-error-for="stock"></p>
                </div>
            </div>

            <!-- Pilih Kategori Produk -->
            <div>
                <label for="category" class="block font-semibold mb-1">Kategori Produk</label>
                <select id="category" name="category" required
                    class="border p-2 w-full rounded focus:ring focus:ring-green-300 @error('category') border-red-500 ring-1 ring-red-400 @enderror">
                    <option value="" disabled {{ old('category') ? '' : 'selected' }}>-- Pilih Kategori --
                    </option>
                    <option value="pertanian" {{ old('category') === 'pertanian' ? 'selected' : '' }}>Produk Pertanian
                    </option>
                    <option value="sarana" {{ old('category') === 'sarana' ? 'selected' : '' }}>Sarana Pertanian
                    </option>
                    <option value="UMKM" {{ old('category') === 'UMKM' ? 'selected' : '' }}>Produk UMKM</option>
                </select>
                @error('category')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
                <p class="mt-1 text-sm text-red-600 hidden" data-error-for="category"></p>
            </div>


            <div>
                <label for="images" class="block font-semibold mb-1">Gambar Produk</label>
                <input type="file" name="images[]" id="images" class="border p-2 w-full rounded" multiple
                    accept="image/*" />
                <div id="preview" class="flex flex-wrap gap-3 mt-3"></div>
                @error('images.*')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label for="id_user" class="block font-semibold mb-1">NIK Penjual</label>
                <div class="flex flex-col sm:flex-row gap-2">
                    <input type="text" id="id_user" name="id_user" required
                        class="border p-2 flex-1 rounded focus:ring focus:ring-green-300 @error('id_user') border-red-500 ring-1 ring-red-400 @enderror"
                        placeholder="Masukkan NIK" value="{{ old('id_user') }}" />
                    <button type="button" onclick="cariAnggota()"
                        class="bg-[#49A84E] hover:bg-green-700 text-white px-4 py-2 rounded">
                        Cari
                    </button>
                </div>
                @error('id_user')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
                <p class="mt-1 text-sm text-red-600 hidden" data-error-for="id_user"></p>
            </div>

            <div class="grid grid-cols-1 gap-2">
                <input type="text" id="nama_penjual" placeholder="Nama Penjual"
                    class="border p-2 w-full rounded bg-gray-100" value="{{ old('nama_penjual') }}" readonly />
                <input type="text" id="alamat_penjual" placeholder="Alamat Penjual"
                    class="border p-2 w-full rounded bg-gray-100" value="{{ old('alamat_penjual') }}" readonly />
                <input type="text" id="hp_penjual" placeholder="Nomor HP Penjual"
                    class="border p-2 w-full rounded bg-gray-100" value="{{ old('hp_penjual') }}" readonly />
            </div>

            <button type="submit"
                class="bg-[#49A84E] hover:bg-green-700 text-white px-6 py-2 rounded font-bold w-full">
                Simpan
            </button>
        </form>
    </main>

    <div id="success-overlay" class="fixed inset-0 z-50 hidden items-center justify-center bg-black/50">
        <div class="overlay-card bg-white rounded-2xl p-8 shadow-xl text-center w-[90%] max-w-sm">
            <svg class="mx-auto mb-4 w-20 h-20 text-[#49A84E]" viewBox="0 0 72 72" fill="none"
                xmlns="http://www.w3.org/2000/svg" aria-hidden="true">
                <circle class="circle-path" cx="36" cy="36" r="30" stroke="currentColor"
                    stroke-width="4" fill="none" />
                <path class="check-path" d="M22 36 L32 46 L52 26" stroke="currentColor" stroke-width="4"
                    fill="none" stroke-linecap="round" stroke-linejoin="round" />
            </svg>
            <h3 class="text-xl font-bold text-gray-800">Berhasil!</h3>
            <p class="text-gray-600 mt-1">Produk berhasil ditambahkan.</p>
        </div>
    </div>

    @if (session('success'))
        <script>
            document.addEventListener('DOMContentLoaded', () => showSuccessOverlay());
        </script>
    @endif

    <script>
        const priceHidden = document.getElementById('price');
        const priceDisplay = document.getElementById('price_display');

        function onlyDigits(str) {
            return (str || '').toString().replace(/\D+/g, '');
        }

        function formatRupiahFromDigits(digits) {
            if (!digits) return '';
            const n = Number(digits);
            if (!Number.isFinite(n)) return '';
            return 'Rp ' + n.toLocaleString('id-ID');
        }

        function syncPriceFromDisplay() {
            const digits = onlyDigits(priceDisplay.value);
            priceHidden.value = digits;
            priceDisplay.value = digits ? formatRupiahFromDigits(digits) : '';
        }

        document.addEventListener('DOMContentLoaded', () => {
            const initial = onlyDigits(priceHidden.value || '');
            priceHidden.value = initial;
            priceDisplay.value = initial ? formatRupiahFromDigits(initial) : '';
        });

        // Format saat user mengetik/menempel
        priceDisplay.addEventListener('input', syncPriceFromDisplay);
        priceDisplay.addEventListener('blur', syncPriceFromDisplay);

        document.getElementById('images').addEventListener('change', function(event) {
            const preview = document.getElementById('preview');
            preview.innerHTML = "";
            Array.from(event.target.files).forEach(file => {
                if (!file.type.startsWith('image/')) return;
                const reader = new FileReader();
                reader.onload = e => {
                    const img = document.createElement('img');
                    img.src = e.target.result;
                    img.className = "h-24 w-24 object-cover rounded shadow";
                    img.alt = file.name;
                    preview.appendChild(img);
                };
                reader.readAsDataURL(file);
            });
        });

        function cariAnggota() {
            const id_user = document.getElementById('id_user').value.trim();
            if (!id_user) {
                markInvalid('id_user', 'NIK penjual wajib diisi sebelum mencari.');
                return;
            }

            axios.get(`/anggota/search/${encodeURIComponent(id_user)}`)
                .then(res => {
                    const data = res.data || {};
                    if (!data.nama) {
                        markInvalid('id_user', 'Data anggota tidak ditemukan.');
                        document.getElementById('nama_penjual').value = '';
                        document.getElementById('alamat_penjual').value = '';
                        document.getElementById('hp_penjual').value = '';
                        return;
                    }

                    document.getElementById('nama_penjual').value = data.nama || '';
                    document.getElementById('alamat_penjual').value = data.alamat || '';
                    document.getElementById('hp_penjual').value = data.no_hp || '';
                    clearInvalid('id_user');
                })
                .catch(() => {
                    markInvalid('id_user', 'Data anggota tidak ditemukan.');
                    document.getElementById('nama_penjual').value = '';
                    document.getElementById('alamat_penjual').value = '';
                    document.getElementById('hp_penjual').value = '';
                });
        }

        const form = document.getElementById('product-form');
        form.addEventListener('submit', function(e) {
            syncPriceFromDisplay();

            const requiredNames = ['name', 'description', 'price', 'stock', 'id_user'];
            let valid = true;
            requiredNames.forEach((name) => {
                const input = form.querySelector(`[name="${name}"]`);
                if (!input) return;
                const value = (input.value || '').toString().trim();

                if (!value) {
                    valid = false;
                    markInvalid(name, 'Wajib diisi.');
                    return;
                }
                if (name === 'price') {
                    const n = Number(value);
                    if (!Number.isFinite(n) || n < 0) {
                        valid = false;
                        markInvalid(name, 'Harga tidak valid atau negatif.');
                        return;
                    }
                }

                if (name === 'stock') {
                    const n = Number(value);
                    if (!Number.isFinite(n) || n < 0) {
                        valid = false;
                        markInvalid(name, 'Stok tidak boleh negatif.');
                        return;
                    }
                }
                clearInvalid(name);
            });
            if (!valid) {
                e.preventDefault();
                window.scrollTo({
                    top: form.offsetTop - 80,
                    behavior: 'smooth'
                });
            }
        });

        function markInvalid(fieldName, message) {
            const input = fieldName === 'price' ?
                document.getElementById('price_display') :
                document.querySelector(`[name="${fieldName}"]`);

            const error = document.querySelector(`[data-error-for="${fieldName}"]`);
            if (input) {
                input.classList.add('border-red-500', 'ring-1', 'ring-red-400');
            }
            if (error) {
                error.textContent = message || 'Field tidak valid.';
                error.classList.remove('hidden');
            }
        }

        function clearInvalid(fieldName) {
            const input = fieldName === 'price' ?
                document.getElementById('price_display') :
                document.querySelector(`[name="${fieldName}"]`);

            const error = document.querySelector(`[data-error-for="${fieldName}"]`);
            if (input) {
                input.classList.remove('border-red-500', 'ring-1', 'ring-red-400');
            }
            if (error) {
                error.textContent = '';
                error.classList.add('hidden');
            }
        }

        function showSuccessOverlay() {
            const overlay = document.getElementById('success-overlay');
            overlay.classList.remove('hidden');
            overlay.classList.add('flex');
            setTimeout(() => {
                overlay.classList.add('hidden');
                overlay.classList.remove('flex');
            }, 1800);
        }
    </script>
</body>
