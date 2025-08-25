<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Buat Transaksi Baru</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <link rel="preconnect" href="https://fonts.googleapis.com" />
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700&display=swap" rel="stylesheet" />
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    fontFamily: {
                        poppins: ['Poppins', 'sans-serif'],
                    },
                    colors: {
                        'brand-green': '#4CAF50',
                        'brand-green-dark': '#388E3C',
                    }
                },
            },
        };
    </script>
    <style>
        .custom-scrollbar::-webkit-scrollbar {
            width: 6px;
        }

        .custom-scrollbar::-webkit-scrollbar-track {
            background: #f1f1f1;
        }

        .custom-scrollbar::-webkit-scrollbar-thumb {
            background: #d1d5db;
            border-radius: 3px;
        }

        .custom-scrollbar::-webkit-scrollbar-thumb:hover {
            background: #a1a1aa;
        }
    </style>
</head>

<body class="font-poppins bg-gray-100">
    @include('Layout.menu')
    <div class="pt-24 px-4 sm:px-6 lg:px-8 xl:mx-64">
        <header class="mb-6">
            <h1 class="text-3xl font-bold tracking-tight text-gray-900">Point of Sale (POS)</h1>
            <p class="text-gray-600 mt-1">Pilih produk dari daftar untuk memulai transaksi.</p>
        </header>

        @if ($errors->any())
            <div class="bg-red-100 border-l-4 border-red-500 text-red-700 p-4 mb-6 rounded-md" role="alert">
                <p class="font-bold">Terjadi Kesalahan</p>
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>- {{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="{{ route('transaksi.store') }}" method="POST">
            @csrf
            <div class="flex flex-col lg:flex-row gap-8">

                <!-- Kolom Kiri: Daftar Produk -->
                <div class="w-full lg:w-2/3">
                    <div class="bg-white rounded-xl shadow-sm p-4">
                        <div id="product-list"
                            class="grid grid-cols-2 md:grid-cols-3 xl:grid-cols-4 gap-4 max-h-[70vh] overflow-y-auto custom-scrollbar pr-2">
                            @foreach ($Product as $p)
                                @php
                                    $imagePath = $p->images->first()
                                        ? asset('storage/' . $p->images->first()->path)
                                        : 'https://placehold.co/300x300/e2e8f0/475569?text=Produk';
                                @endphp
                                <div class="product-card border rounded-lg p-3 flex flex-col text-center transition-shadow duration-300 hover:shadow-md"
                                    data-id="{{ $p->id_product }}" data-name="{{ $p->name }}"
                                    data-price="{{ $p->price }}" data-stock="{{ $p->stock }}"
                                    data-image="{{ $imagePath }}">

                                    <img src="{{ $imagePath }}" alt="{{ $p->name }}"
                                        class="w-full h-32 object-cover rounded-md mb-3">
                                    <p class="font-semibold text-gray-800 text-sm flex-grow">{{ $p->name }}</p>
                                    <p class="text-brand-green-dark font-bold my-2">Rp
                                        {{ number_format($p->price, 0, ',', '.') }}</p>

                                    <div class="action-buttons mt-2">
                                        <button type="button"
                                            class="btn-buy w-full bg-brand-green text-white font-semibold py-2 rounded-md hover:bg-brand-green-dark transition">Beli</button>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>

                <!-- Kolom Kanan: Keranjang & Detail Transaksi -->
                <div class="w-full lg:w-1/3">
                    <div class="bg-white rounded-xl shadow-sm p-6 sticky top-28">
                        <h2 class="text-xl font-bold text-gray-900 border-b pb-3 mb-4">Detail Transaksi</h2>
                        <div>
                            <label for="id_user" class="block text-sm font-medium text-gray-700 mb-1">Pilih
                                Pembeli</label>
                            <select name="id_user" id="id_user"
                                class="w-full px-3 py-3 border-gray-300 rounded-md shadow-sm focus:ring-brand-green focus:border-brand-green"
                                required>
                                <option value="">-- Pilih Anggota --</option>
                                @foreach ($users as $user)
                                    <option value="{{ $user->id_user }}"
                                        {{ old('id_user') == $user->id_user ? 'selected' : '' }}>{{ $user->nama }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        <div id="cart-items" class="mt-6 space-y-3 max-h-64 overflow-y-auto custom-scrollbar pr-2">
                            <p id="cart-empty-msg" class="text-center text-gray-500 py-8">Keranjang masih kosong.</p>
                        </div>
                        <div class="mt-6 pt-4 border-t">
                            <div class="flex justify-between items-center">
                                <span class="text-lg font-semibold text-gray-800">Total</span>
                                <span id="total-price" class="text-2xl font-bold text-brand-green-dark">Rp 0</span>
                            </div>
                        </div>
                        <div class="mt-6">
                            <button type="submit"
                                class="w-full bg-brand-green-dark text-white font-bold py-3 rounded-lg hover:bg-green-800 transition shadow-lg">
                                Simpan Transaksi
                            </button>
                        </div>
                    </div>
                </div>
            </div>
            <div id="hidden-cart-inputs"></div>
        </form>
    </div>

    <script>
        document.addEventListener("DOMContentLoaded", function() {
            const productList = document.getElementById('product-list');
            const cartItemsContainer = document.getElementById('cart-items');
            const cartEmptyMsg = document.getElementById('cart-empty-msg');
            const totalPriceEl = document.getElementById('total-price');
            const hiddenCartInputsContainer = document.getElementById('hidden-cart-inputs');

            let cart = {};

            productList.addEventListener('click', (e) => {
                const button = e.target.closest('button');
                if (!button) return;
                const card = button.closest('.product-card');
                const productId = card.dataset.id;
                if (button.classList.contains('btn-buy')) addToCart(productId, card.dataset);
                else if (button.classList.contains('btn-increase')) updateQuantity(productId, 1);
                else if (button.classList.contains('btn-decrease')) updateQuantity(productId, -1);
                else if (button.classList.contains('btn-cancel')) removeFromCart(productId);
            });

            cartItemsContainer.addEventListener('click', (e) => {
                const removeButton = e.target.closest('.btn-remove-cart-item');
                if (removeButton) removeFromCart(removeButton.dataset.id);
            });

            function addToCart(productId, productData) {
                if (cart[productId]) return;
                cart[productId] = {
                    name: productData.name,
                    price: parseFloat(productData.price),
                    quantity: 1,
                    image: productData.image,
                    stock: parseInt(productData.stock)
                };
                updateUI();
            }

            function updateQuantity(productId, change) {
                if (!cart[productId]) return;
                const newQuantity = cart[productId].quantity + change;
                if (newQuantity > 0 && newQuantity <= cart[productId].stock) {
                    cart[productId].quantity = newQuantity;
                } else if (newQuantity <= 0) {
                    removeFromCart(productId);
                }
                updateUI();
            }

            function removeFromCart(productId) {
                if (!cart[productId]) return;
                delete cart[productId];
                updateUI();
            }

            function updateUI() {
                updateProductCards();
                updateCartView();
                updateTotalPrice();
                updateHiddenInputs();
            }

            function updateProductCards() {
                document.querySelectorAll('.product-card').forEach(card => {
                    const productId = card.dataset.id;
                    const actionContainer = card.querySelector('.action-buttons');
                    if (cart[productId]) {
                        actionContainer.innerHTML =
                            `
                            <div class="flex items-center justify-center gap-2">
                                <button type="button" class="btn-decrease bg-gray-200 text-gray-700 w-8 h-8 rounded-full font-bold hover:bg-gray-300">-</button>
                                <input type="number" value="${cart[productId].quantity}" class="w-16 text-center border-gray-300 rounded-md" readonly>
                                <button type="button" class="btn-increase bg-gray-200 text-gray-700 w-8 h-8 rounded-full font-bold hover:bg-gray-300">+</button>
                            </div>
                            <button type="button" class="btn-cancel text-red-500 hover:text-red-700 text-xs mt-2">Batal</button>`;
                    } else {
                        actionContainer.innerHTML =
                            `<button type="button" class="btn-buy w-full bg-brand-green text-white font-semibold py-2 rounded-md hover:bg-brand-green-dark transition">Beli</button>`;
                    }
                });
            }

            function updateCartView() {
                if (Object.keys(cart).length === 0) {
                    cartItemsContainer.innerHTML = '';
                    cartEmptyMsg.style.display = 'block';
                } else {
                    cartEmptyMsg.style.display = 'none';
                    cartItemsContainer.innerHTML = Object.entries(cart).map(([id, item]) => `
                        <div class="flex items-center gap-3">
                            <img src="${item.image}" alt="${item.name}" class="w-12 h-12 rounded-md object-cover">
                            <div class="flex-grow">
                                <p class="font-semibold text-sm text-gray-800">${item.name}</p>
                                <p class="text-xs text-gray-500">${item.quantity} x Rp ${item.price.toLocaleString('id-ID')}</p>
                            </div>
                            <p class="font-bold text-gray-900">Rp ${(item.quantity * item.price).toLocaleString('id-ID')}</p>
                            <button type="button" class="btn-remove-cart-item text-gray-400 hover:text-red-500" data-id="${id}">
                                <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M9 2a1 1 0 00-.894.553L7.382 4H4a1 1 0 000 2v10a2 2 0 002 2h8a2 2 0 002-2V6a1 1 0 100-2h-3.382l-.724-1.447A1 1 0 0011 2H9zM7 8a1 1 0 012 0v6a1 1 0 11-2 0V8zm5-1a1 1 0 00-1 1v6a1 1 0 102 0V8a1 1 0 00-1-1z" clip-rule="evenodd"></path></svg>
                            </button>
                        </div>`).join('');
                }
            }

            function updateTotalPrice() {
                const total = Object.values(cart).reduce((sum, item) => sum + (item.quantity * item.price), 0);
                totalPriceEl.textContent = `Rp ${total.toLocaleString('id-ID')}`;
            }

            function updateHiddenInputs() {
                hiddenCartInputsContainer.innerHTML = Object.entries(cart).map(([id, item], index) => `
                    <input type="hidden" name="produk[${index}][id_product]" value="${id}">
                    <input type="hidden" name="produk[${index}][jumlah]" value="${item.quantity}">
                `).join('');
            }
        });
    </script>
</body>

</html>
