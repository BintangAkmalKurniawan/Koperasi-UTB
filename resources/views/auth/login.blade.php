<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Login Koperasi</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <style>
        body {
            /* Ganti 'url-gambar-anda.jpg' dengan path ke gambar Anda di folder public */
            /* Contoh: background-image: url('{{ asset('img/background-koperasi.jpg') }}'); */
            background-image: url('{{ asset('icon/bg.png') }}');
            background-size: cover;
            background-position: center;
            background-repeat: no-repeat;
        }
    </style>
</head>

<body class="font-sans antialiased text-gray-900">

    <div class="relative min-h-screen flex flex-col justify-center items-center p-4">

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
                </div>
            </div>
        </nav>

        <div class="relative z-10 w-full max-w-md bg-white rounded-2xl shadow-2x1 p-8 space-y-6">

            <div class="text-center">
                <h1 class="text-3xl font-bold text-gray-800">Selamat Datang</h1>
                <p class="text-gray-500 mt-2">Silakan masuk ke akun Anda</p>
            </div>

            @if (session('error'))
                <div class="bg-red-100 border-l-4 border-red-500 text-red-700 p-4 rounded-md" role="alert">
                    <p class="font-bold">Login Gagal!</p>
                    <p>{{ session('error') }}</p>
                </div>
            @endif

            <form class="space-y-6" action="{{ route('loginCheck') }}" method="POST">
                @csrf
                <div>
                    <label for="username" class="text-sm font-medium text-gray-700">Username</label>
                    <input type="text" placeholder="Masukkan username Anda" name="username" id="username"
                        class="mt-1 block w-full px-4 py-3 border border-gray-300 rounded-lg shadow-sm placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-green-500 focus:border-green-500"
                        required />
                </div>

                <div>
                    <label for="password" class="text-sm font-medium text-gray-700">Password</label>

                    <input type="password" placeholder="Masukkan password Anda" name="password" id="password"
                        class="mt-1 block w-full px-4 py-3 border border-gray-300 rounded-lg shadow-sm placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-green-500 focus:border-green-500"
                        required />
                    <button type="button" id="togglePwd"
                        class="absolute top-[150px] inset-y-0 right-10 flex items-center text-gray-500 hover:text-green-600 focus:outline-none">
                        👁️
                    </button>
                </div>

                <button type="submit"
                    class="w-full py-3 px-4 bg-green-600 hover:bg-green-700 text-white font-semibold rounded-lg shadow-md transition duration-300 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500">
                    Masuk
                </button>
            </form>
        </div>

        <footer class="absolute bottom-4 z-10 text-center text-white text-sm">
            <p>&copy; {{ date('Y') }} Koperasi BANTENGPUTIH LAMONGAN</p>
        </footer>

    </div>
    <script>
        const password = document.getElementById('password');
        const togelBtn = document.getElementById('togglePwd');

        togelBtn.addEventListener('click', () => {
            const isHidden = password.type === 'password';
            password.type = isHidden ? 'text' : 'password';
        })
    </script>
</body>

</html>
