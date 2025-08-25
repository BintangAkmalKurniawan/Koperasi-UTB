      <nav class="bg-white shadow-lg fixed top-0 w-full z-50 transition-all duration-300" id="navbar">
          <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
              <div class="flex justify-between items-center h-16">
                  <!-- Logo -->
                  <div class="flex items-center space-x-3">
                      <img src="https://bantengputihlamongan.com/storage/village/01JZ3H04BP885GBKSF3Y8D9MBE.png"
                          alt="Logo Desa" class="w-10 h-10 rounded-full"
                          onerror="this.src='https://placehold.co/40x40/4CAF50/FFFFFF?text=LOGO'" />
                      <span class="text-xl font-bold text-green-800">BANTENGPUTIH</span>
                  </div>

                  <!-- Desktop Navigation -->

                  <div class="hidden lg:flex items-center space-x-8">
                      <a class="nav-link text-green-800 hover:text-green-600 font-medium transition-colors duration-300 flex items-center space-x-2"
                          href="/dashboard">
                          <i class="fas fa-home"></i>
                          <span>Beranda</span>
                      </a>
                      <a class="nav-link text-green-800 hover:text-green-600 font-medium transition-colors duration-300 flex items-center space-x-2"
                          href="">
                          <i class="fas fa-user"></i>
                          <span>Akun</span>
                      </a>

                      <a class="nav-link text-green-800 hover:text-green-600 font-medium transition-colors duration-300 flex items-center space-x-2"
                          href="/products">
                          <i class="fas fa-box"></i>
                          <span>Produk</span>
                      </a>
                      <div class="relative group">
                          <button
                              class="nav-link text-green-800 hover:text-green-600 font-medium transition-colors duration-300 flex items-center space-x-2">
                              <i class="fas fa-cogs"></i>
                              <span>Layanan</span>
                              <i
                                  class="fas fa-chevron-down text-xs transform group-hover:rotate-180 transition-transform duration-300"></i>
                          </button>
                          <div
                              class="absolute top-full left-0 w-50 bg-white shadow-xl rounded-lg border border-gray-100 opacity-0 invisible group-hover:opacity-100 group-hover:visible transform translate-y-2 group-hover:translate-y-0 transition-all duration-300">
                              <a class="flex items-center space-x-3 px-4 py-3 text-green-800 hover:bg-gray-50 hover:text-green-600 transition-colors duration-200"
                                  href="/tabungan-anggota">
                                  <i class="fas fa-building-columns"></i>
                                  <span>Tabungan</span>
                              </a>
                              <a class="flex items-center space-x-3 px-4 py-3 text-green-800 hover:bg-gray-50 hover:text-green-600 transition-colors duration-200"
                                  href="{{ route('simpanan') }}">
                                  <i class="fas fa-money-bill-transfer"></i>
                                  <span>Simpanan</span>
                              </a>
                              <a class="flex items-center space-x-3 px-4 py-3 text-green-800 hover:bg-gray-50 hover:text-green-600 transition-colors duration-200"
                                  href="/jualbeli-anggota">
                                  <i class="fas fa-arrows-rotate text-green-700 w-4"></i>
                                  <span>Transaksi</span>
                              </a>
                              <a class="flex items-center space-x-3 px-4 py-3 text-green-800 hover:bg-gray-50 hover:text-green-600 transition-colors duration-200"
                                  href="#">
                                  <i class="fas fa-chart-line text-green-700 w-4"></i>
                                  <span>SHU</span>
                              </a>
                          </div>
                      </div>

                      <div class="relative group">
                          <button
                              class="nav-link text-green-800 hover:text-green-600 font-medium transition-colors duration-300 flex items-center space-x-2">
                              <img class="w-10 h-10 rounded-full object-cover ring-2 ring-offset-2 ring-green-500"
                                  src="{{ Auth::user()->foto ? asset('storage/' . Auth::user()->foto) : asset('icon/akun.png') }}"
                                  alt="Foto Profil">
                          </button>

                          {{-- LOGOUT --}}
                          <div
                              class="absolute invisible opacity-0 group-hover:visible group-hover:opacity-100 bg-white shadow-lg rounded-lg mt-2 w-64 py-3 z-30 right-0 ring-1 ring-black ring-opacity-5 transition-all duration-200">
                              <div class="px-4 py-2 border-b">
                                  <p class="text-sm font-semibold text-gray-800">{{ Auth::user()->nama }}</p>
                                  <p class="text-xs text-gray-500">{{ Auth::user()->role }}</p>
                              </div>
                              <a href="{{ route('profil') }}"
                                  class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">Profil
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
                  </div>

                  <!-- Mobile menu button -->
                  <div class="lg:hidden">
                      <button id="mobile-menu-button"
                          class="text-gray-700 hover:text-green-600 focus:outline-none focus:text-green-600 transition-colors duration-200">
                          <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                  d="M4 6h16M4 12h16M4 18h16"></path>
                          </svg>
                      </button>
                  </div>
              </div>

              <!-- Mobile Navigation Menu -->
              <div id="mobile-menu" class="lg:hidden hidden fixed inset-0 bg-white z-50 overflow-y-auto">
                  <!-- Close button -->
                  <div class="flex justify-end p-4">
                      <button id="mobile-menu-close" class="text-gray-500 hover:text-gray-700">
                          <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                  d="M6 18L18 6M6 6l12 12"></path>
                          </svg>
                      </button>
                  </div>

                  <div class="px-6 py-4 space-y-4">
                      <!-BERANDA- -->
                          <a href="/dashboard-anggota"
                              class="block px-4 py-3 text-lg font-medium text-gray-700 hover:text-green-600 hover:bg-gray-50 rounded-lg transition-colors duration-200">
                              <i class="fas fa-home w-6 mr-4"></i>Beranda
                          </a>
                          <!-BERANDA- -->
                              <a href="{{ route('daftar-anggota') }}"
                                  class="block px-4 py-3 text-lg font-medium text-gray-700 hover:text-green-600 hover:bg-gray-50 rounded-lg transition-colors duration-200">
                                  <i class="fas fa-home w-6 mr-4"></i>Beranda
                              </a>
                              <!-- PRODUK -->
                              <a href="{{ route('anggota.produk.index') }}"
                                  class="block px-4 py-3 text-lg font-medium text-gray-700 hover:text-green-600 hover:bg-gray-50 rounded-lg transition-colors duration-200">
                                  <i class="fas fa-box w-6 mr-4"></i>Produk
                              </a>

                              <!-- Mobile Layanan Dropdown -->
                              <div class="mobile-dropdown">
                                  <button
                                      class="mobile-dropdown-btn w-full flex items-center justify-between px-4 py-3 text-lg font-medium text-gray-700 hover:text-green-600 hover:bg-gray-50 rounded-lg transition-colors duration-200">
                                      <span><i class="fas fa-cogs w-6 mr-4"></i>Layanan</span>
                                      <i class="fas fa-chevron-down transform transition-transform duration-200"></i>
                                  </button>
                                  <div class="mobile-dropdown-content hidden bg-gray-50 ml-6 mt-2 rounded-lg">
                                      <a href="/tabungan-anggota"
                                          class="block px-4 py-3 text-gray-600 hover:text-green-600 hover:bg-gray-100 rounded-lg transition-colors duration-200">
                                          <i class="fas fa-building-columns w-5 mr-4"></i>Tabungan
                                      </a>
                                      <a href="/simpanan-anggota"
                                          class="block px-4 py-3 text-gray-600 hover:text-green-600 hover:bg-gray-100 rounded-lg transition-colors duration-200">
                                          <i class="fas fa-money-bill w-5 mr-4"></i>Simpanan
                                      </a>
                                      <a href="/jualbeli-anggota"
                                          class="block px-4 py-3 text-gray-600 hover:text-green-600 hover:bg-gray-100 rounded-lg transition-colors duration-200">
                                          <i class="fas fa-arrows-rotate w-5 mr-4"></i>Transaksi
                                      </a>
                                      <a href="/shu-anggota"
                                          class="block px-4 py-3 text-gray-600 hover:text-green-600 hover:bg-gray-100 rounded-lg transition-colors duration-200">
                                          <i class="fas fa-chart-line w-5 mr-4"></i>SHU
                                      </a>
                                  </div>
                              </div>

                              <!-- Mobile Akun Dropdown -->
                              <div class="mobile-dropdown">
                                  <button
                                      class="mobile-dropdown-btn w-full flex items-center justify-between px-4 py-3 text-lg font-medium text-gray-700 hover:text-green-600 hover:bg-gray-50 rounded-lg transition-colors duration-200">
                                      <span><i class="fas fa-info-circle w-6 mr-4"></i>Akun
                                      </span>
                                      <i class="fas fa-chevron-down transform transition-transform duration-200"></i>
                                  </button>
                                  <div class="mobile-dropdown-content hidden bg-gray-50 ml-6 mt-2 rounded-lg">
                                      <a href="/profil-anggota"
                                          class="block px-4 py-3 text-gray-600 hover:text-green-600 hover:bg-gray-100 rounded-lg transition-colors duration-200">
                                          <i class="fas fa-user w-5 mr-4"></i>Profil
                                      </a>

                                      <form
                                          class="block px-4 py-3 text-gray-600 hover:text-red-600 hover:bg-gray-100 rounded-lg transition-colors duration-200"
                                          method="POST" action="{{ route('logout') }}">
                                          @csrf

                                          <button href="https://bantengputihlamongan.com/galeri">

                                              <i class="fa-solid fa-right-from-bracket w-5 mr-4"></i>Logout
                                          </button>
                                      </form>

                                  </div>
                              </div>


                  </div>
              </div>

              <script>
                  document.addEventListener("DOMContentLoaded", function() {
                      const mobileMenuButton =
                          document.getElementById("mobile-menu-button");
                      const mobileMenu = document.getElementById("mobile-menu");
                      const mobileMenuClose =
                          document.getElementById("mobile-menu-close");

                      if (mobileMenuButton && mobileMenu && mobileMenuClose) {
                          mobileMenuButton.addEventListener("click", function() {
                              mobileMenu.classList.remove("hidden");
                              document.body.style.overflow = "hidden";
                          });

                          mobileMenuClose.addEventListener("click", function() {
                              mobileMenu.classList.add("hidden");
                              document.body.style.overflow = "auto";
                          });

                          // Close mobile menu when clicking outside
                          mobileMenu.addEventListener("click", function(e) {
                              if (e.target === mobileMenu) {
                                  mobileMenu.classList.add("hidden");
                                  document.body.style.overflow = "auto";
                              }
                          });
                      }

                      // Mobile dropdown functionality
                      document
                          .querySelectorAll(".mobile-dropdown-btn")
                          .forEach((btn) => {
                              btn.addEventListener("click", function() {
                                  const content = this.nextElementSibling;
                                  const chevron = this.querySelector(".fa-chevron-down");

                                  if (content && chevron) {
                                      content.classList.toggle("hidden");
                                      chevron.classList.toggle("rotate-180");
                                  }
                              });
                          });
                  });
              </script>
          </div>
      </nav>
