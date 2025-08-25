<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tambah Anggota Baru</title>
    <link rel="preconnect" href="https://fonts.googleapis.com" />
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
    <link
        href="https://fonts.googleapis.com/css2?family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900&display=swap"
        rel="stylesheet" />
    <script src="https://unpkg.com/feather-icons"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css">
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    fontFamily: {
                        poppins: ['Poppins', 'sans-serif'],
                    },
                },
            },
        };
    </script>
</head>

<body class="font-poppins bg-gray-100 text-gray-800 flex flex-col min-h-screen">

    <header>
        @include('Layout.menuw')
    </header>

    <main class="flex-grow pt-16">
        <div class="bg-[#69b881] py-12">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
                <h1 class="text-white text-4xl font-extrabold tracking-wider">TAMBAH ANGGOTA BARU</h1>
            </div>
        </div>

        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
            <form id="form-anggota" action="{{ route('anggota.store') }}" method="POST" enctype="multipart/form-data"
                class="grid grid-cols-1 lg:grid-cols-3 gap-8">
                @csrf

                <div class="lg:col-span-1">
                    <div class="bg-white p-6 rounded-xl shadow-lg flex flex-col items-center">
                        <div
                            class="w-full h-64 border-2 border-dashed border-gray-300 rounded-lg flex items-center justify-center mb-4">
                            <img id="preview-profil" src="/icon/akun.png" alt="Foto Profil"
                                class="max-w-full max-h-full object-contain rounded-lg" />
                        </div>
                        <label for="foto-profil" class="cursor-pointer w-full">
                            <div
                                class="bg-[#49A84E] w-full py-3 rounded-lg flex items-center justify-center gap-2 hover:bg-green-700 transition">
                                <i data-feather="upload" class="text-white w-5 h-5"></i>
                                <span class="text-white font-bold text-lg">Upload Foto</span>
                            </div>
                        </label>
                        <input type="file" name="foto" id="foto-profil" accept="image/*" class="hidden"
                            onchange="previewFoto(event, 'preview-profil')" />
                    </div>
                </div>

                <div class="lg:col-span-2">
                    <div class="bg-white p-8 rounded-xl shadow-lg">
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-x-6 gap-y-6">

                            <div class="md:col-span-2">
                                <label class="font-bold text-base text-green-800" for="id_user">Nomor Induk
                                    Kependudukan (NIK)</label>
                                <input type="text" id="id_user" name="id_user" placeholder="NIK 16 Digit"
                                    value="{{ old('id_user') }}"
                                    class="w-full mt-1 px-4 py-2 border rounded-lg font-medium focus:outline-none focus:ring-2 focus:ring-[#49A84E] @error('id_user') border-red-500 @enderror" />
                                @error('id_user')
                                    <div class="text-red-500 mt-1 text-sm">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="md:col-span-2">
                                <label class="font-bold text-base text-green-800" for="nama">Nama Lengkap</label>
                                <input type="text" id="nama" name="nama" placeholder="Nama Lengkap"
                                    value="{{ old('nama') }}"
                                    class="w-full mt-1 px-4 py-2 border rounded-lg font-medium focus:outline-none focus:ring-2 focus:ring-[#49A84E] @error('nama') border-red-500 @enderror" />
                                @error('nama')
                                    <div class="text-red-500 mt-1 text-sm">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="md:col-span-2">
                                <label class="font-bold text-base text-green-800" for="alamat">Alamat Lengkap</label>
                                <input type="text" id="alamat" name="alamat" placeholder="Alamat Lengkap"
                                    value="{{ old('alamat') }}"
                                    class="w-full mt-1 px-4 py-2 border rounded-lg font-medium focus:outline-none focus:ring-2 focus:ring-[#49A84E] @error('alamat') border-red-500 @enderror" />
                                @error('alamat')
                                    <div class="text-red-500 mt-1 text-sm">{{ $message }}</div>
                                @enderror
                            </div>

                            <div>
                                <label class="font-bold text-base text-green-800" for="no_hp">No HP</label>
                                <input type="tel" id="no_hp" name="no_hp" placeholder="No HP"
                                    value="{{ old('no_hp') }}"
                                    class="w-full mt-1 px-4 py-2 border rounded-lg font-medium focus:outline-none focus:ring-2 focus:ring-[#49A84E] @error('no_hp') border-red-500 @enderror" />
                                @error('no_hp')
                                    <div class="text-red-500 mt-1 text-sm">{{ $message }}</div>
                                @enderror
                            </div>

                            <div>
                                <label class="font-bold text-base text-green-800" for="username">Username</label>
                                <input type="text" id="username" name="username" placeholder="Username"
                                    value="{{ old('username') }}"
                                    class="w-full mt-1 px-4 py-2 border rounded-lg font-medium focus:outline-none focus:ring-2 focus:ring-[#49A84E] @error('username') border-red-500 @enderror" />
                                @error('username')
                                    <div class="text-red-500 mt-1 text-sm">{{ $message }}</div>
                                @enderror
                            </div>

                            <div>
                                <label class="font-bold text-base text-green-800" for="password">Password</label>
                                <input type="password" id="password" name="password" placeholder="Password"
                                    class="w-full mt-1 px-4 py-2 border rounded-lg font-medium focus:outline-none focus:ring-2 focus:ring-[#49A84E] @error('password') border-red-500 @enderror" />
                                @error('password')
                                    <div class="text-red-500 mt-1 text-sm">{{ $message }}</div>
                                @enderror
                            </div>

                            <div>
                                <label class="font-bold text-base text-green-800"
                                    for="password_confirmation">Konfirmasi Password</label>
                                <input type="password" id="password_confirmation" name="password_confirmation"
                                    placeholder="Konfirmasi Password"
                                    class="w-full mt-1 px-4 py-2 border rounded-lg font-medium focus:outline-none focus:ring-2 focus:ring-[#49A84E]" />
                                <p id="infoPassword" class="text-sm mt-1 h-3"></p>
                            </div>

                            <div class="md:col-span-2 mt-4">
                                <button id="btn-submit" type="submit"
                                    class="w-full bg-[#49A84E] py-3 rounded-lg font-bold text-lg text-white hover:bg-green-700 transition">
                                    Daftar
                                </button>
                            </div>

                        </div>
                    </div>
                </div>
            </form>
        </div>
    </main>

    <footer class="bg-white text-gray-600 text-center py-6 mt-10 border-t">
        <p>&copy; {{ date('Y') }} Koperasi Banteng Putih.</p>
    </footer>

    <script>
        feather.replace(); // Untuk ikon feather

        function previewFoto(event, previewId) {
            const input = event.target;
            const preview = document.getElementById(previewId);
            if (input.files && input.files[0]) {
                const reader = new FileReader();
                reader.onload = function(e) {
                    preview.src = e.target.result;
                };
                reader.readAsDataURL(input.files[0]);
            }
        }

        const passwordInput = document.getElementById('password');
        const konfirmasiPasswordInput = document.getElementById('password_confirmation');
        const infoPassword = document.getElementById('infoPassword');

        function periksaKecocokanPassword() {
            const passwordValue = passwordInput.value;
            const konfirmasiPasswordValue = konfirmasiPasswordInput.value;
            if (konfirmasiPasswordValue.length === 0) {
                infoPassword.textContent = '';
                return;
            }
            if (passwordValue === konfirmasiPasswordValue) {
                infoPassword.textContent = '✅ Password cocok';
                infoPassword.style.color = 'green';
            } else {
                infoPassword.textContent = '❌ Password tidak cocok';
                infoPassword.style.color = 'red';
            }
        }
        passwordInput.addEventListener('input', periksaKecocokanPassword);
        konfirmasiPasswordInput.addEventListener('input', periksaKecocokanPassword);
    </script>
</body>

</html>
