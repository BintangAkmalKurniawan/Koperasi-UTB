<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css">

<nav class="fixed flex w-full h-[74px] bg-white z-20 shadow-lg justify-between items-center px-4 sm:px-6 lg:px-64">
    <!-- Logo & Nama Koperasi -->
    <div class="flex items-center gap-4 text-[#15532E] font-extrabold text-lg cursor-pointer"
        onclick="window.location.href='{{ route('dashboard') }}'">
        <img src="https://bantengputihlamongan.com/storage/village/01JZ3H04BP885GBKSF3Y8D9MBE.png" alt="Logo Koperasi"
            class="h-10 w-10 rounded-full object-cover" />
        <span class="hidden sm:inline">BANTENGPUTIH</span>
    </div>

    <!-- Menu Navigasi Desktop -->
    {{-- <div class="hidden lg:flex items-center space-x-8"> --}}
    <div class="hidden lg:flex items-center gap-x-8 sm:pl-[340px] text-green-900 text-base font-medium">
        <a href="{{ route('dashboard') }}"
            class="flex items-center gap-2 hover:text-[#49A84E] transition-colors duration-200">
            <i class="fas fa-home text-green-600"></i>
            <span>Beranda</span>
        </a>
        <a href="{{ route('daftar-anggota') }}"
            class="flex items-center gap-2 hover:text-[#49A84E] transition-colors duration-200">
            <img class="w-5 h-5" src="/icon/akun.png" alt="Akun Icon">
            <span>Akun</span>
        </a>
        <a href="/products" class="flex items-center gap-2 hover:text-[#49A84E] transition-colors duration-200">
            <img class="w-5 h-5" src="/icon/produk.png" alt="Produk Icon">
            <span>Produk</span>
        </a>

        <!-- Dropdown Layanan -->
        <div class="relative group">
            <button
                class="flex items-center gap-2 hover:text-[#49A84E] transition-colors duration-200 focus:outline-none">
                <img class="w-5 h-5" src="/icon/tabungan.png" alt="Tabungan Icon">
                <span>Layanan</span>
                <svg class="w-4 h-4 ml-1 transition-transform duration-200 group-hover:rotate-180" fill="none"
                    stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                </svg>
            </button>
            <div
                class="absolute invisible opacity-0 group-hover:visible group-hover:opacity-100 bg-white shadow-lg rounded-lg mt-2 w-48 py-1 z-30 right-0 ring-1 ring-black ring-opacity-5 transition-all duration-200">
                <a href="{{ route('tabungan.index') }}"
                    class="flex items-center gap-3 px-4 py-3 text-sm text-gray-700 hover:bg-gray-100 hover:text-green-700"><img
                        class="w-5 h-5" src="/icon/tabungan.png" alt="Akun Icon">Tabungan</a>
                <a href="{{ route('simpanan') }}"
                    class="flex items-center gap-3 px-4 py-3 text-sm text-gray-700 hover:bg-gray-100 hover:text-green-700"><img
                        class="w-5 h-5" src="/icon/simpanan.png" alt="Akun Icon">Simpanan</a>
                <a href="/transaksi"
                    class="flex items-center gap-3 px-4 py-3 text-sm text-gray-700 hover:bg-gray-100 hover:text-green-700"><img
                        class="w-5 h-5" src="/icon/jual-beli.png" alt="Akun Icon">Jual
                    Beli</a>
                <a href="{{ route('shu.index') }}"
                    class="flex items-center gap-3 px-4 py-3 text-sm text-gray-700 hover:bg-gray-100 hover:text-green-700"><img
                        class="w-5 h-5" src="/icon/shu.png" alt="Akun Icon">SHU</a>
            </div>
        </div>
    </div>

    <!-- Profile & Hamburger Menu -->
    <div class="flex items-center gap-4">
        <div class="relative group">
            <button class="flex items-center focus:outline-none">
                <img class="w-10 h-10 rounded-full object-cover ring-2 ring-offset-2 ring-green-500 hidden sm:block"
                    src="{{ Auth::user()->foto ? asset('storage/' . Auth::user()->foto) : asset('icon/akun.png') }}"
                    alt="Foto Profil">
            </button>
            <div
                class="absolute invisible opacity-0 group-hover:visible group-hover:opacity-100 bg-white shadow-lg rounded-lg mt-2 w-64 py-3 z-30 right-0 ring-1 ring-black ring-opacity-5 transition-all duration-200">
                <div class="px-4 py-2 border-b">
                    <p class="text-sm font-semibold text-gray-800">{{ Auth::user()->nama }}</p>
                    <p class="text-xs text-gray-500">{{ Auth::user()->role }}</p>
                </div>
                <a href="{{ route('profil') }}" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">Profil
                    Saya</a>
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit"
                        class="w-full text-left flex items-center gap-2 px-4 py-2 text-sm text-red-600 hover:bg-red-50">
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
        <!-- Hamburger Button -->
        <div class="lg:hidden">
            <button id="menu-toggle" class="text-gray-700 hover:text-brand-green focus:outline-none">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16m-7 6h7">
                    </path>
                </svg>
            </button>
        </div>
    </div>
</nav>

<!-- Mobile Menu -->
<div id="mobile-menu" class="lg:hidden hidden bg-white shadow-lg pt-20">
    <div class="px-2 pt-2 pb-3 space-y-1 sm:px-3">
        <a href="{{ route('dashboard') }}"
            class="block px-3 py-2 rounded-md text-base font-medium text-gray-700 hover:text-white hover:bg-brand-green">Dashboard</a>
        <a href="{{ route('daftar-anggota') }}"
            class="block px-3 py-2 rounded-md text-base font-medium text-gray-700 hover:text-white hover:bg-brand-green">Akun</a>
        <a href="/products"
            class="block px-3 py-2 rounded-md text-base font-medium text-gray-700 hover:text-white hover:bg-brand-green">Produk</a>
        <a href="{{ route('tabungan.index') }}"
            class="block px-3 py-2 rounded-md text-base font-medium text-gray-700 hover:text-white hover:bg-brand-green">Tabungan</a>
        <a href="{{ route('simpanan') }}"
            class="block px-3 py-2 rounded-md text-base font-medium text-gray-700 hover:text-white hover:bg-brand-green">Simpanan</a>
        <a href="/transaksi"
            class="block px-3 py-2 rounded-md text-base font-medium text-gray-700 hover:text-white hover:bg-brand-green">Jual
            Beli</a>
        <a href="{{ route('shu.index') }}"
            class="block px-3 py-2 rounded-md text-base font-medium text-gray-700 hover:text-white hover:bg-brand-green">SHU</a>
    </div>
</div>

<script>
    document.addEventListener("DOMContentLoaded", function() {
        const menuToggle = document.getElementById('menu-toggle');
        const mobileMenu = document.getElementById('mobile-menu');
        if (menuToggle) {
            menuToggle.addEventListener('click', function() {
                mobileMenu.classList.toggle('hidden');
            });
        }
    })
</script>
