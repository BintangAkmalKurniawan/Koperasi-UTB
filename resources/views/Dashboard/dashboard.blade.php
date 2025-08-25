<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Beranda Admin - Koperasi Banteng Putih</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <link rel="preconnect" href="https://fonts.googleapis.com" />
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
    <link
        href="https://fonts.googleapis.com/css2?family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900&display=swap"
        rel="stylesheet" />

    <script src="https://cdn.tailwindcss.com"></script>

    <script>
        tailwind.config = {
            theme: {
                extend: {
                    fontFamily: {
                        poppins: ['Poppins', 'sans-serif'],
                    },
                    colors: {
                        'brand-green-icon': '#E6F4EA',
                        'brand-green-light': '#69b881',
                        'brand-green': '#4CAF50',
                        'brand-green-dark': '#388E3C',
                    }
                },
            },
        };
    </script>
    <style>
        .menu-card {
            transition: transform 0.3s ease, box-shadow 0.3s ease;
        }

        .menu-card:hover {
            transform: translateY(-8px);
            box-shadow: 0 20px 25px -5px rgb(0 0 0 / 0.1), 0 8px 10px -6px rgb(0 0 0 / 0.1);
        }

        /* .brand-green-light {
            background-color: #69b881;
        } */
    </style>
</head>

<body class="font-poppins bg-gray-100 text-gray-800">

    <header>
        <nav class="bg-white shadow-sm fixed top-0 w-full z-50">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="flex justify-between items-center h-20">
                    <!-- Logo -->
                    <div class="flex items-center space-x-3 ">
                        <img src="https://bantengputihlamongan.com/storage/village/01JZ3H04BP885GBKSF3Y8D9MBE.png"
                            alt="Logo Desa" class="w-12 h-12 rounded-full"
                            onerror="this.src='https://placehold.co/48x48/4CAF50/FFFFFF?text=LOGO'" />
                        <span class="text-xl font-bold text-brand-green-dark tracking-wide">KOPERASI BANTENGPUTIH</span>
                    </div>

                    <!-- Profile Dropdown -->
                    <div class="relative group">
                        <button class="flex items-center space-x-3 focus:outline-none">
                            <span
                                class="hidden md:inline font-semibold text-gray-700">{{ Auth::user()->nama ?? 'Admin' }}</span>
                            <img class="w-12 h-12 rounded-full object-cover ring-2 ring-offset-2 ring-brand-green"
                                src="{{ Auth::user()->foto ? asset('storage/' . Auth::user()->foto) : 'https://ui-avatars.com/api/?name=' . urlencode(Auth::user()->nama ?? 'A') . '&background=E6F4EA&color=388E3C&bold=true' }}"
                                alt="Foto Profil">
                        </button>

                        <!-- Dropdown Menu -->
                        <div
                            class="absolute top-full right-0 mt-2 w-56 bg-white shadow-xl rounded-lg border border-gray-100 opacity-0 invisible group-hover:opacity-100 group-hover:visible transform translate-y-2 group-hover:translate-y-0 transition-all duration-300 z-50">
                            <div class="p-2 border-b">
                                <p class="font-bold text-gray-800">{{ Auth::user()->nama ?? 'Admin Koperasi' }}</p>
                                <p class="text-sm text-gray-500">{{ Auth::user()->role ?? 'Administrator' }}</p>
                            </div>
                            <a class="flex items-center space-x-3 px-4 py-3 text-gray-600 hover:bg-gray-50 hover:text-brand-green-dark transition-colors duration-200"
                                href="/profil">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                                </svg>
                                <span>Profil Saya</span>
                            </a>
                            <form method="POST" action="{{ route('logout') }}">
                                @csrf
                                <button type="submit"
                                    class="w-full text-left flex items-center space-x-3 px-4 py-3 text-red-500 hover:bg-red-50 hover:text-red-700 transition-colors duration-200">

                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1">
                                        </path>
                                    </svg>
                                    <span>Logout</span>
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </nav>
    </header>

    <main class="pt-20">
        <section class="bg-brand-green-light py-12 px-4 sm:px-6 lg:px-8 border-b border-gray-200">
            <div class="mx-[210px]">
                <h1 class="text-3xl font-bold text-gray-800">Selamat Datang, {{ Auth::user()->nama ?? 'Admin' }}!</h1>
                <p class="mt-2 text-gray-600">Ini adalah ringkasan aktivitas koperasi hari ini.</p>
                <div class="mt-8 grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
                    <div class="bg-white p-5 rounded-xl shadow-sm border border-gray-100">
                        <p class="text-sm font-medium text-gray-500">Total Anggota</p>
                        <p class="text-3xl font-bold text-brand-green-dark mt-1">{{ $anggota }}</p>
                    </div>
                    <div class="bg-white p-5 rounded-xl shadow-sm border border-gray-100">
                        <p class="text-sm font-medium text-gray-500">Transaksi Hari Ini</p>
                        <p class="text-3xl font-bold text-brand-green-dark mt-1">{{ $transaksi }}</p>
                    </div>
                    <div class="bg-white p-5 rounded-xl shadow-sm border border-gray-100">
                        <p class="text-sm font-medium text-gray-500">Produk Tersedia</p>
                        <p class="text-3xl font-bold text-brand-green-dark mt-1">{{ $produk }}</p>
                    </div>
                </div>
            </div>
        </section>

        <!-- Main Menu Section -->
        <section class="py-14">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <h2 class="text-2xl font-bold text-gray-800 mb-8">Menu Utama</h2>
                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-8">

                    <a href="/daftar-anggota"
                        class="bg-white rounded-xl shadow-md p-6 flex items-center space-x-6 menu-card">
                        <div class="bg-brand-green-icon p-4 rounded-full">
                            <svg class="w-8 h-8 text-brand-green-dark" fill="none" stroke="currentColor"
                                viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z">
                                </path>
                            </svg>
                        </div>
                        <div>
                            <p class="text-xl font-bold text-gray-800">Akun Anggota</p>
                            <p class="text-gray-500">Kelola data semua anggota.</p>
                        </div>
                    </a>

                    <a href="{{ route('tabungan.index') }}"
                        class="bg-white rounded-xl shadow-md p-6 flex items-center space-x-6 menu-card">
                        <div class="bg-brand-green-icon p-4 rounded-full">
                            <svg class="w-8 h-8 text-brand-green-dark" fill="none" stroke="currentColor"
                                viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z">
                                </path>
                            </svg>
                        </div>
                        <div>
                            <p class="text-xl font-bold text-gray-800">Tabungan</p>
                            <p class="text-gray-500">Manajemen tabungan anggota.</p>
                        </div>
                    </a>

                    <a href="/products" class="bg-white rounded-xl shadow-md p-6 flex items-center space-x-6 menu-card">
                        <div class="bg-brand-green-icon p-4 rounded-full">
                            <svg class="w-8 h-8 text-brand-green-dark" fill="none" stroke="currentColor"
                                viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"></path>
                            </svg>
                        </div>
                        <div>
                            <p class="text-xl font-bold text-gray-800">Produk</p>
                            <p class="text-gray-500">Kelola stok dan harga produk.</p>
                        </div>
                    </a>

                    <a href="/simpanan"
                        class="bg-white rounded-xl shadow-md p-6 flex items-center space-x-6 menu-card">
                        <div class="bg-brand-green-icon p-4 rounded-full">
                            <svg class="w-8 h-8 text-brand-green-dark" fill="none" stroke="currentColor"
                                viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M8 7v8a2 2 0 002 2h4M8 7a2 2 0 012-2h4a2 2 0 012 2v8a2 2 0 01-2 2h-4a2 2 0 01-2-2l-4-4z">
                                </path>
                            </svg>
                        </div>
                        <div>
                            <p class="text-xl font-bold text-gray-800">Simpanan</p>
                            <p class="text-gray-500">Atur simpanan pokok & wajib.</p>
                        </div>
                    </a>

                    <a href="/transaksi"
                        class="bg-white rounded-xl shadow-md p-6 flex items-center space-x-6 menu-card">
                        <div class="bg-brand-green-icon p-4 rounded-full">
                            <svg class="w-8 h-8 text-brand-green-dark" fill="none" stroke="currentColor"
                                viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z">
                                </path>
                            </svg>
                        </div>
                        <div>
                            <p class="text-xl font-bold text-gray-800">Jual Beli</p>
                            <p class="text-gray-500">Catat dan lihat riwayat transaksi.</p>
                        </div>
                    </a>

                    <a href="/shu" class="bg-white rounded-xl shadow-md p-6 flex items-center space-x-6 menu-card">
                        <div class="bg-brand-green-icon p-4 rounded-full">
                            <svg class="w-8 h-8 text-brand-green-dark" fill="none" stroke="currentColor"
                                viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M11 3.055A9.001 9.001 0 1020.945 13H11V3.055z"></path>
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M20.488 9H15V3.512A9.025 9.025 0 0120.488 9z"></path>
                            </svg>
                        </div>
                        <div>
                            <p class="text-xl font-bold text-gray-800">SHU</p>
                            <p class="text-gray-500">Hitung Sisa Hasil Usaha tahunan.</p>
                        </div>
                    </a>

                </div>
            </div>
        </section>
    </main>

    {{-- <footer class="bg-white text-gray-600 text-center py-6 mt-10 border-t">
        <p>&copy; {{ date('Y') }} Koperasi Banteng Putih.</p>
    </footer> --}}

</body>

</html>
