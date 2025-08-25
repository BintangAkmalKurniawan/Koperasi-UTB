<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Daftar Anggota</title>
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
                        'brand-green-light': '#69b881',
                        'brand-green-icon': '#E6F4EA',
                        'brand-green': '#4CAF50',
                        'brand-green-dark': '#388E3C',
                        'brand-text': '#1E40AF',
                    }
                },
            },
        };
    </script>
    <style>
        .card-hover-effect {
            transition: transform 0.3s ease-in-out, box-shadow 0.3s ease-in-out;
        }

        .card-hover-effect:hover {
            transform: translateY(-8px);
            box-shadow: 0 20px 25px -5px rgb(0 0 0 / 0.1), 0 8px 10px -6px rgb(0 0 0 / 0.1);
        }
    </style>
</head>

<body class="font-poppins bg-gray-100 text-gray-800 flex flex-col min-h-screen">

    <header>
        @include('Layout.menu')
    </header>

    <main class="flex-grow">
        <div class="relative bg-brand-green-light pt-20 pb-32 text-center">
            <div class="relative z-10 mt-20">
                <h1 class="text-white text-4xl md:text-5xl font-extrabold tracking-tight">
                    Daftar Anggota Koperasi
                </h1>
                <p class="mt-4 text-white max-w-2xl mx-auto">Cari dan kelola data anggota koperasi.</p>

                <form action="{{ route('daftar-anggota') }}" method="GET" class="mt-8 max-w-xl mx-auto px-4">
                    <div class="relative">
                        <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                            <svg class="h-5 w-5 text-gray-400" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20"
                                fill="currentColor">
                                <path fill-rule="evenodd"
                                    d="M9 3.5a5.5 5.5 0 100 11 5.5 5.5 0 000-11zM2 9a7 7 0 1112.452 4.391l3.328 3.329a.75.75 0 11-1.06 1.06l-3.329-3.328A7 7 0 012 9z"
                                    clip-rule="evenodd" />
                            </svg>
                        </div>
                        <input type="text" name="search" id="searchInput"
                            placeholder="Cari berdasarkan nama anggota..."
                            class="w-full px-4 py-3 pl-11 rounded-full shadow-lg border-2 border-transparent focus:outline-none focus:ring-2 focus:ring-brand-green focus:border-transparent"
                            value="{{ request('search') }}" />
                    </div>
                </form>
            </div>
        </div>

        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 mt-10">
            <div class="mb-8 text-right">
                <a class="bg-brand-green hover:bg-brand-green-dark text-white font-bold py-3 px-6 rounded-lg shadow-md inline-flex items-center gap-2 transition-colors duration-300"
                    href="/tambah-anggota">
                    <svg class="w-5 h-5" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                        <path
                            d="M10.75 4.75a.75.75 0 00-1.5 0v4.5h-4.5a.75.75 0 000 1.5h4.5v4.5a.75.75 0 001.5 0v-4.5h4.5a.75.75 0 000-1.5h-4.5v-4.5z" />
                    </svg>
                    Tambah Anggota
                </a>
            </div>

            <div id="anggotaGrid"
                class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-8 mt-20 mb-32">
                @forelse ($anggota as $item)
                    <div class="anggota-card">
                        <a href="{{ route('anggota.show', ['id' => $item->id_user]) }}"
                            class="bg-white rounded-xl shadow-md flex flex-col items-center p-6 text-center card-hover-effect">
                            <img src="{{ $item->foto ? asset('storage/' . $item->foto) : 'https://ui-avatars.com/api/?name=' . urlencode($item->nama) . '&background=E6F4EA&color=388E3C&bold=true' }}"
                                alt="Foto Profil {{ $item->nama }}"
                                class="w-32 h-32 rounded-full object-cover border-4 border-white shadow-sm mb-4" />
                            <p class=" py-2 font-bold text-lg text-gray-800 leading-tight">{{ $item->nama }}</p>
                            <span
                                class="mt-auto bg-brand-green-icon w-full py-2 px-4 rounded-lg text-brand-green-dark font-semibold">
                                Lihat Detail
                            </span>
                        </a>
                    </div>
                @empty
                    <div class="text-center py-16 text-gray-500 col-span-full">
                        <p class="text-xl">Tidak ada data anggota yang ditemukan.</p>
                    </div>
                @endforelse
            </div>
        </div>
    </main>
    {{-- 
    <footer class="bg-white text-gray-600 text-center py-6 mt-10 border-t">
        <p>&copy; {{ date('Y') }} Koperasi Banteng Putih.</p>
    </footer> --}}

    <footer>
        @include('Layout.footer')
    </footer>
    <script>
        // Script untuk fungsionalitas pencarian real-time
        document.getElementById('searchInput').addEventListener('keyup', function() {
            const filter = this.value.toLowerCase();
            const cards = document.querySelectorAll('.anggota-card');

            cards.forEach(card => {
                const name = card.querySelector('p.font-bold').textContent.toLowerCase();
                if (name.includes(filter)) {
                    card.style.display = '';
                } else {
                    card.style.display = 'none';
                }
            });
        });
    </script>
</body>

</html>
