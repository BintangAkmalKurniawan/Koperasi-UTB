    <footer class="mt-auto bg-green-900 text-white">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-8">
                <div>
                    <h3 class="text-xl font-bold text-green-400 mb-4">Desa Bantengputih</h3>
                    <p class="text-gray-300 mb-4">
                        Desa Bantengputih adalah desa yang terletak di Kecamatan Karanggeneng, Kabupaten Lamongan,
                        Provinsi Jawa Timur. Desa ini memiliki visi untuk menjadi desa yang maju, mandiri, dan sejahtera
                        untuk seluruh warga.
                    </p>
                    <div class="flex space-x-4">
                        <a href="https://wa.me/6281331931077" target="_blank"
                            class="text-gray-300 hover:text-green-400 transition-colors duration-200">
                            <i class="fab fa-whatsapp text-2xl"></i>
                        </a>
                        <a href="https://facebook.com/#" target="_blank"
                            class="text-gray-300 hover:text-green-400 transition-colors duration-200">
                            <i class="fab fa-facebook text-2xl"></i>
                        </a>
                        <a href="mailto:admin@bantengputihlamongan.com"
                            class="text-gray-300 hover:text-green-400 transition-colors duration-200">
                            <i class="fas fa-envelope text-2xl"></i>
                        </a>
                    </div>
                </div>
                <div>
                    <h4 class="text-lg font-semibold text-green-400 mb-4">Menu Utama</h4>
                    <ul class="space-y-2">
                        <li><a href="/dashboard"
                                class="text-gray-300 hover:text-green-400 transition-colors duration-200">Beranda</a>
                        </li>
                        <li><a href="{{ route('daftar-anggota') }}"
                                class="text-gray-300 hover:text-green-400 transition-colors duration-200">Akun</a></li>
                        <li><a href="/products"
                                class="text-gray-300 hover:text-green-400 transition-colors duration-200">Produk</a>
                        </li>
                        <li><a href="/profil"
                                class="text-gray-300 hover:text-green-400 transition-colors duration-200">Profil</a>
                        </li>
                    </ul>
                </div>
                <div>
                    <h4 class="text-lg font-semibold text-green-400 mb-4">Layanan</h4>
                    <ul class="space-y-2">
                        <li><a href="{{ route('tabungan.index') }}"
                                class="text-gray-300 hover:text-green-400 transition-colors duration-200">Tabungan</a>
                        </li>
                        <li><a href="{{ route('simpanan') }}"
                                class="text-gray-300 hover:text-green-400 transition-colors duration-200">Simpanan</a>
                        </li>
                        <li><a href="/transaksi"
                                class="text-gray-300 hover:text-green-400 transition-colors duration-200">Transaksi</a>
                        </li>
                        <li><a href="{{ route('shu.index') }}"
                                class="text-gray-300 hover:text-green-400 transition-colors duration-200">SHU</a></li>
                    </ul>
                </div>
                <div>
                    <h4 class="text-lg font-semibold text-green-400 mb-4">Kontak</h4>
                    <div class="space-y-3 text-gray-300">
                        <p class="flex items-start space-x-2">
                            <i class="fas fa-map-marker-alt mt-1"></i>
                            <span>Desa Bantengputih, Kecamatan Karanggeneng, Kabupaten Lamongan, Provinsi Jawa
                                Timur</span>
                        </p>
                        <p class="flex items-center space-x-2">
                            <i class="fas fa-phone"></i>
                            <span>+62 813 3193 1077</span>
                        </p>
                        <p class="flex items-center space-x-2">
                            <i class="fas fa-envelope"></i>
                            <span>admin@bantengputihlamongan.com</span>
                        </p>
                    </div>
                </div>
            </div>
            <div class="border-t border-green-700 mt-8 pt-8 text-center text-gray-300">
                <p>© 2025 Desa Bantengputih. Semua hak cipta dilindungi.</p>
            </div>
        </div>
    </footer>
