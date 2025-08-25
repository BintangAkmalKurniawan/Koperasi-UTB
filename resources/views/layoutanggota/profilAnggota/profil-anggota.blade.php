<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- Judul Halaman Dinamis -->
    <title>Profil Saya - {{ $user->nama }}</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    <style>
        body {
            font-family: 'Inter', sans-serif;
        }
    </style>
</head>

<body class="bg-gray-100 min-h-screen">
    @include('layoutanggota.a.navbar-anggota');
    {{-- <header class="mb-8">
        <div class="flex items-center gap-4">
            <a href="{{ route('shu.index') }}" class="text-gray-500 hover:text-gray-700">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7">
                    </path>
                </svg>
            </a>
            <div>
                <h1 class="text-3xl font-bold tracking-tight text-gray-900">Profil
                    {{ $user->nama }}</h1>
            </div>
        </div>
    </header> --}}
    <div class="w-full max-w-6xl mx-auto p-4 sm:p-6 lg:p-8">
        <div class="bg-white rounded-2xl shadow-lg overflow-hidden mt-[100px]">
            <div class="h-48 bg-cover bg-center"
                style="background-image: url('https://bantengputihlamongan.com/images/hero-gotong-royong.jpg');">
            </div>

            <div class="p-6 sm:p-8 md:flex md:items-start">
                <div class="md:w-1/4 md:mr-8 -mt-24 text-center md:text-left">
                    <img class="w-32 h-32 rounded-full ring-4 ring-white mx-auto md:mx-0 object-cover"
                        src="{{ $user->foto ? asset('storage/' . $user->foto) : asset('icon/akun.png') }}"
                        alt="Foto Profil {{ $user->nama }}">
                </div>

                <div class="w-full mt-4 md:mt-0">
                    <div class="text-center md:text-left">
                        <h1 class="text-3xl font-bold text-gray-900">{{ $user->nama }}</h1>
                        <p class="text-md font-medium text-green-600 mt-1">{{ ucfirst($user->role) }} Koperasi</p>
                        <p class="text-sm text-gray-500 mt-2">
                            Bergabung sejak: {{ \Carbon\Carbon::parse($user->tanggal_gabung)->format('d F Y') }}
                        </p>
                    </div>

                    <!-- Informasi Kontak Dinamis -->
                    <div class="mt-8 border-t border-gray-200 pt-6">
                        <h2 class="text-lg font-semibold text-gray-800 mb-4">Informasi Kontak & Akun</h2>
                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-y-4 gap-x-6 text-gray-700">
                            <div class="flex items-center space-x-3">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-gray-400"
                                    viewBox="0 0 20 20" fill="currentColor">
                                    <path fill-rule="evenodd" d="M10 9a3 3 0 100-6 3 3 0 000 6zm-7 9a7 7 0 1114 0H3z"
                                        clip-rule="evenodd" />
                                </svg>
                                <span class="text-sm font-medium">Username:</span>
                                <span class="text-sm">{{ $user->username }}</span>
                            </div>
                            <div class="flex items-center space-x-3">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-gray-400"
                                    viewBox="0 0 20 20" fill="currentColor">
                                    <path fill-rule="evenodd" d="M10 9a3 3 0 100-6 3 3 0 000 6zm-7 9a7 7 0 1114 0H3z"
                                        clip-rule="evenodd" />
                                </svg>
                                <span class="text-sm font-medium">NIK:</span>
                                <span class="text-sm">{{ $user->id_user }}</span>
                            </div>
                            <div class="flex items-center space-x-3">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-gray-400"
                                    viewBox="0 0 20 20" fill="currentColor">
                                    <path
                                        d="M2 3a1 1 0 011-1h2.153a1 1 0 01.986.836l.74 4.435a1 1 0 01-.54 1.06l-1.518.758a10.97 10.97 0 005.466 5.466l.758-1.518a1 1 0 011.06-.54l4.435.74a1 1 0 01.836.986V17a1 1 0 01-1 1h-2C7.82 18 2 12.18 2 5V3z" />
                                </svg>
                                <span class="text-sm font-medium">No. HP:</span>
                                <span class="text-sm">{{ $user->no_hp }}</span>
                            </div>
                            <div class="flex items-start space-x-3 col-span-1 sm:col-span-2">
                                <svg xmlns="http://www.w3.org/2000/svg"
                                    class="h-5 w-5 text-gray-400 mt-0.5 flex-shrink-0" viewBox="0 0 20 20"
                                    fill="currentColor">
                                    <path fill-rule="evenodd"
                                        d="M5.05 4.05a7 7 0 119.9 9.9L10 18.9l-4.95-4.95a7 7 0 010-9.9zM10 11a2 2 0 100-4 2 2 0 000 4z"
                                        clip-rule="evenodd" />
                                </svg>
                                <div class="text-sm">
                                    <span class="font-medium">Alamat:</span>
                                    <p class="text-gray-600">{{ $user->alamat }}</p>
                                </div>
                            </div>
                        </div>
                    </div>

                    {{-- <div class="mt-8 flex justify-center md:justify-end space-x-4">
                        <button
                            class="bg-gray-200 text-gray-700 font-semibold py-2 px-6 rounded-lg hover:bg-gray-300 transition-colors duration-200">
                            Ganti Password
                        </button>
                        <button
                            class="bg-green-600 text-white font-semibold py-2 px-6 rounded-lg hover:bg-green-700 transition-colors duration-200">
                            Edit Profil
                        </button>
                    </div> --}}
                </div>
            </div>
        </div>
    </div>

</body>

</html>
