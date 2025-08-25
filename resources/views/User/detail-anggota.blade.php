<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Detail Anggota - {{ $item->nama }}</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <!-- SweetAlert2 untuk notifikasi -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    <style>
        body {
            font-family: 'Inter', sans-serif;
            background-color: #f7fafc;
        }

        .input-display {
            background-color: transparent;
            border: 1px solid transparent;
            padding-left: 0;
            padding-right: 0;
        }

        .input-edit {
            border: 1px solid #cbd5e1;
            background-color: #ffffff;
            padding-left: 0.75rem;
            padding-right: 0.75rem;
        }
    </style>
</head>

<body class="bg-gray-100 min-h-screen">
    @include('Layout.menu')

    <div class="w-full max-w-6xl mx-auto p-4 sm:p-6 lg:p-8">
        <div class="item-center flex gap-5 mt-20">
            <a href="{{ route('daftar-anggota') }}" class="text-gray-500 hover:text-gray-700 mt-2">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7">
                    </path>
                </svg>
            </a>
            <h2 class="text-3xl font-extrabold text-[#15532E] mb-6">Detail Anggota</h2>
        </div>


        @if (session('success'))
            <script>
                document.addEventListener('DOMContentLoaded', function() {
                    Swal.fire({
                        icon: 'success',
                        title: 'Berhasil',
                        text: '{{ session('success') }}',
                        timer: 2000,
                        showConfirmButton: false
                    });
                });
            </script>
        @endif
        @if (session('error'))
            <script>
                document.addEventListener('DOMContentLoaded', function() {
                    Swal.fire({
                        icon: 'error',
                        title: 'Gagal',
                        text: '{{ session('error') }}',
                    });
                });
            </script>
        @endif

        <div class="mb-6">
            <div class="border-b border-gray-200">
                <nav class="-mb-px flex space-x-8" aria-label="Tabs">
                    <a href="#" id="tab-detail" onclick="switchTab('detail')"
                        class="whitespace-nowrap py-4 px-1 border-b-2 font-medium text-lg text-green-600 border-green-500">Detail
                        Profil</a>
                    <a href="#" id="tab-simpanan" onclick="switchTab('simpanan')"
                        class="whitespace-nowrap py-4 px-1 border-b-2 font-medium text-lg text-gray-500 hover:text-gray-700 hover:border-gray-300 border-transparent">Riwayat
                        Simpanan</a>
                    <a href="#" id="tab-shu" onclick="switchTab('shu')"
                        class="whitespace-nowrap py-4 px-1 border-b-2 font-medium text-lg text-gray-500 hover:text-gray-700 hover:border-gray-300 border-transparent">SHU</a>
                </nav>
            </div>
        </div>

        <div>
            <!-- KONTEN TAB: DETAIL PROFIL -->
            <div id="content-detail">
                <form id="edit-form" action="{{ route('anggota.update', $item->id_user) }}" method="POST"
                    enctype="multipart/form-data">
                    @csrf
                    @method('PUT')
                    <div class="bg-white rounded-2xl shadow-lg overflow-hidden">
                        <div class="h-48 bg-cover bg-center"
                            style="background-image: url('https://bantengputihlamongan.com/images/hero-gotong-royong.jpg');">
                        </div>
                        <div class="p-6 sm:p-8 md:flex md:items-start">
                            <!-- Foto & Tombol Aksi -->
                            <div class="md:w-1/4 md:mr-8 -mt-24 text-center">
                                <img id="profileImagePreview"
                                    class="w-32 h-32 rounded-full ring-4 ring-white mx-auto object-cover"
                                    src="{{ $item->foto ? asset('storage/' . $item->foto) : asset('icon/akun.png') }}"
                                    alt="Foto Profil">
                                <label for="foto" id="changePhotoButton"
                                    class="hidden mt-4 cursor-pointer bg-blue-500 text-white text-sm font-semibold py-2 px-4 rounded-lg hover:bg-blue-600">Ganti
                                    Foto</label>
                                <input type="file" name="foto" id="foto" class="hidden"
                                    onchange="previewImage(event)">

                                <div class="mt-6 space-y-3">
                                    <button type="button" id="editButton" onclick="toggleEdit(true)"
                                        class="w-full bg-green-600 text-white font-semibold py-2 px-4 rounded-lg hover:bg-green-700">Edit
                                        Profil</button>
                                    <button type="submit" id="saveButton"
                                        class="hidden w-full bg-blue-600 text-white font-semibold py-2 px-4 rounded-lg hover:bg-blue-700">Simpan
                                        Perubahan</button>
                                    <button type="button" id="cancelButton" onclick="toggleEdit(false)"
                                        class="hidden w-full bg-gray-500 text-white font-semibold py-2 px-4 rounded-lg hover:bg-gray-600">Batal</button>

                                    <!-- Tombol Ubah Password -->
                                    <button type="button" id="changePasswordBtn"
                                        class="w-full bg-yellow-500 text-white font-semibold py-2 px-4 rounded-lg hover:bg-yellow-600">
                                        Ubah Password
                                    </button>

                                    <button type="button" onclick="confirmDelete('{{ $item->id_user }}')"
                                        class="w-full bg-red-500 text-white font-semibold py-2 px-4 rounded-lg hover:bg-red-600">Hapus
                                        Profil</button>
                                </div>
                            </div>

                            <!-- Detail Pengguna (Input) -->
                            <div class="w-full mt-6 md:mt-0">
                                <div class="text-center md:text-left">
                                    <input type="text" name="nama" id="nama" value="{{ $item->nama }}"
                                        class="text-3xl font-bold text-gray-900 w-full rounded-md input-display"
                                        readonly>
                                    <p class="text-md font-medium text-green-600 mt-1">{{ ucfirst($item->role) }}
                                        Koperasi</p>
                                </div>
                                <div class="mt-8 border-t border-gray-200 pt-6">
                                    <h2 class="text-lg font-semibold text-gray-800 mb-4">Informasi Kontak & Pribadi
                                    </h2>
                                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-y-4 gap-x-6">
                                        <div>
                                            <label class="text-sm font-medium text-gray-500">NIK</label>
                                            <input type="text" value="{{ $item->id_user }}"
                                                class="w-full text-gray-800 font-semibold bg-gray-100 rounded-md p-2 mt-1"
                                                readonly>
                                        </div>
                                        <div>
                                            <label for="username"
                                                class="text-sm font-medium text-gray-500">Username</label>
                                            <input type="text" name="username" id="username"
                                                value="{{ $item->username }}"
                                                class="w-full text-gray-800 font-semibold rounded-md p-2 mt-1 input-display"
                                                readonly>
                                        </div>
                                        <div>
                                            <label for="no_hp" class="text-sm font-medium text-gray-500">No.
                                                HP</label>
                                            <input type="text" name="no_hp" id="no_hp"
                                                value="{{ $item->no_hp }}"
                                                class="w-full text-gray-800 font-semibold rounded-md p-2 mt-1 input-display"
                                                readonly>
                                        </div>
                                        <div class="col-span-1 sm:col-span-2">
                                            <label for="alamat"
                                                class="text-sm font-medium text-gray-500">Alamat</label>
                                            <textarea name="alamat" id="alamat" class="w-full text-gray-800 font-semibold rounded-md p-2 mt-1 input-display"
                                                readonly>{{ $item->alamat }}</textarea>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </form>

                <form id="delete-form-{{ $item->id_user }}" action="{{ route('anggota.destroy', $item->id_user) }}"
                    method="POST" style="display: none;">
                    @csrf
                    @method('DELETE')
                </form>
            </div>

            <!-- KONTEN TAB LAINNYA (SIMPANAN & SHU) -->
            <!-- ... (kode tab simpanan dan shu tidak diubah) ... -->
            <!-- KONTEN TAB: RIWAYAT SIMPANAN (DIKEMBALIKAN) -->
            <div id="content-simpanan" class="hidden">
                <div class="bg-white p-6 rounded-2xl shadow-lg">
                    <h3 class="text-xl font-extrabold text-[#15532E] mb-4">Riwayat Simpanan untuk
                        {{ $item->nama }}</h3>
                    <div class="overflow-x-auto border rounded-lg">
                        <table class="min-w-full divide-y divide-gray-200">
                            <thead class="bg-gray-100">
                                <tr>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">
                                        Tanggal</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">
                                        Jenis Simpanan</th>
                                    <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase">
                                        Jumlah</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">
                                        Status</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">
                                        Keterangan</th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-200 text-sm">
                                @forelse ($item->riwayatSimpanan as $riwayat)
                                    <tr class="{{ $riwayat->status == 'gagal' ? 'bg-red-50' : '' }}">
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            {{ \Carbon\Carbon::parse($riwayat->tanggal_transaksi)->format('d F Y H:i') }}
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap font-medium">
                                            {{ ucfirst($riwayat->jenis_simpanan) }}</td>
                                        <td
                                            class="px-6 py-4 whitespace-nowrap text-right font-semibold {{ $riwayat->status != 'gagal' ? 'text-green-700' : 'text-gray-500' }}">
                                            Rp. {{ number_format($riwayat->jumlah, 0, ',', '.') }}
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            @if ($riwayat->status != 'gagal')
                                                <span
                                                    class="px-2 py-1 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800">Berhasil</span>
                                            @else
                                                <span
                                                    class="px-2 py-1 inline-flex text-xs leading-5 font-semibold rounded-full bg-red-100 text-red-800">Gagal</span>
                                            @endif
                                        </td>
                                        <td class="px-6 py-4 text-gray-600">{{ $riwayat->keterangan }}</td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="5" class="text-center py-6 text-gray-500">Belum ada
                                            riwayat simpanan.</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            <!-- KONTEN TAB: SHU (DIKEMBALIKAN) -->
            <div id="content-shu" class="hidden">
                <div class="bg-white p-6 rounded-2xl shadow-lg">
                    <h3 class="text-xl font-extrabold text-[#15532E] mb-4">Riwayat SHU untuk {{ $item->nama }}
                    </h3>
                    <div class="text-center py-10 border-2 border-dashed rounded-lg">
                        <p class="text-gray-500">Fitur atau data SHU akan ditampilkan di sini.</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
    </div>

    <script>
        // --- FUNGSI-FUNGSI YANG SUDAH ADA ---
        const editableFields = ['nama', 'username', 'no_hp', 'alamat'];
        const editButton = document.getElementById('editButton');
        const saveButton = document.getElementById('saveButton');
        const cancelButton = document.getElementById('cancelButton');
        const changePhotoButton = document.getElementById('changePhotoButton');

        function toggleEdit(isEditing) {
            if (!isEditing) {
                // Cek apakah ada perubahan sebelum reload
                let hasChanged = false;
                editableFields.forEach(id => {
                    const el = document.getElementById(id);
                    if (el.value !== el.defaultValue) hasChanged = true;
                });
                if (hasChanged) {
                    Swal.fire({
                        title: 'Batal mengubah?',
                        text: "Perubahan yang Anda buat tidak akan disimpan.",
                        icon: 'warning',
                        showCancelButton: true,
                        confirmButtonColor: '#3085d6',
                        cancelButtonColor: '#d33',
                        confirmButtonText: 'Ya, batalkan!',
                        cancelButtonText: 'Tidak'
                    }).then((result) => {
                        if (result.isConfirmed) {
                            window.location.reload();
                        }
                    });
                } else {
                    window.location.reload();
                }
                return;
            }

            editableFields.forEach(id => {
                const el = document.getElementById(id);
                el.readOnly = !isEditing;
                el.classList.toggle('input-display', !isEditing);
                el.classList.toggle('input-edit', isEditing);
            });
            editButton.classList.toggle('hidden', isEditing);
            saveButton.classList.toggle('hidden', !isEditing);
            cancelButton.classList.toggle('hidden', !isEditing);
            changePhotoButton.classList.toggle('hidden', !isEditing);
        }

        function previewImage(event) {
            const reader = new FileReader();
            reader.onload = function() {
                document.getElementById('profileImagePreview').src = reader.result;
            };
            reader.readAsDataURL(event.target.files[0]);
        }

        function confirmDelete(userId) {
            Swal.fire({
                title: 'Apakah Anda yakin?',
                text: "Data anggota ini akan dihapus secara permanen!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#d33',
                cancelButtonColor: '#3085d6',
                confirmButtonText: 'Ya, hapus!',
                cancelButtonText: 'Batal'
            }).then((result) => {
                if (result.isConfirmed) {
                    document.getElementById('delete-form-' + userId).submit();
                }
            })
        }

        function switchTab(tab) {
            document.getElementById('content-detail').classList.add('hidden');
            document.getElementById('content-simpanan').classList.add('hidden');
            document.getElementById('content-shu').classList.add('hidden');

            document.getElementById('tab-detail').className =
                'whitespace-nowrap py-4 px-1 border-b-2 font-medium text-lg text-gray-500 hover:text-gray-700 hover:border-gray-300 border-transparent';
            document.getElementById('tab-simpanan').className =
                'whitespace-nowrap py-4 px-1 border-b-2 font-medium text-lg text-gray-500 hover:text-gray-700 hover:border-gray-300 border-transparent';
            document.getElementById('tab-shu').className =
                'whitespace-nowrap py-4 px-1 border-b-2 font-medium text-lg text-gray-500 hover:text-gray-700 hover:border-gray-300 border-transparent';

            if (tab === 'detail') {
                document.getElementById('content-detail').classList.remove('hidden');
                document.getElementById('tab-detail').className =
                    'whitespace-nowrap py-4 px-1 border-b-2 font-medium text-lg text-green-600 border-green-500';
            } else if (tab === 'simpanan') {
                document.getElementById('content-simpanan').classList.remove('hidden');
                document.getElementById('tab-simpanan').className =
                    'whitespace-nowrap py-4 px-1 border-b-2 font-medium text-lg text-green-600 border-green-500';
            } else if (tab === 'shu') {
                document.getElementById('content-shu').classList.remove('hidden');
                document.getElementById('tab-shu').className =
                    'whitespace-nowrap py-4 px-1 border-b-2 font-medium text-lg text-green-600 border-green-500';
            }
        }

        // --- SCRIPT BARU UNTUK UBAH PASSWORD ---
        document.getElementById('changePasswordBtn').addEventListener('click', function() {
            Swal.fire({
                title: 'Ubah Password',
                html: `
                    <form id="formUbahPassword" action="{{ route('password.update') }}" method="POST" class="text-left">
                        @csrf
                        <input type="hidden" name="id_user" value="{{ $item->id_user }}">
                        
                        <div class="mt-4">
                            <label for="no_hp_verification" class="block text-sm font-medium text-gray-700">Verifikasi No. HP</label>
                            <input type="text" name="no_hp" id="no_hp_verification" placeholder="Masukkan nomor HP terdaftar: {{ $item->no_hp }}" class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-green-500 focus:border-green-500 sm:text-sm" required>
                        </div>

                        <div class="mt-4">
                            <label for="old_password" class="block text-sm font-medium text-gray-700">Password Lama</label>
                            <input type="password" name="old_password" id="old_password" class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-green-500 focus:border-green-500 sm:text-sm" required>
                        </div>

                        <div class="mt-4">
                            <label for="new_password" class="block text-sm font-medium text-gray-700">Password Baru</label>
                            <input type="password" name="new_password" id="new_password" class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-green-500 focus:border-green-500 sm:text-sm" required>
                        </div>

                        <div class="mt-4">
                            <label for="new_password_confirmation" class="block text-sm font-medium text-gray-700">Konfirmasi Password Baru</label>
                            <input type="password" name="new_password_confirmation" id="new_password_confirmation" class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-green-500 focus:border-green-500 sm:text-sm" required>
                        </div>
                    </form>
                `,
                showCancelButton: true,
                confirmButtonText: 'Simpan',
                cancelButtonText: 'Batal',
                confirmButtonColor: '#16a34a', // green-600
                cancelButtonColor: '#6b7280', // gray-500
                preConfirm: () => {
                    const form = document.getElementById('formUbahPassword');
                    const noHp = form.no_hp.value;
                    const oldPassword = form.old_password.value;
                    const newPassword = form.new_password.value;
                    const confirmPassword = form.new_password_confirmation.value;

                    if (!noHp || !oldPassword || !newPassword || !confirmPassword) {
                        Swal.showValidationMessage('Semua field wajib diisi');
                        return false;
                    }
                    if (newPassword !== confirmPassword) {
                        Swal.showValidationMessage('Konfirmasi password tidak cocok');
                        return false;
                    }
                    if (newPassword.length < 6) {
                        Swal.showValidationMessage('Password minimal harus 6 karakter');
                        return false;
                    }

                    return new FormData(form);
                }
            }).then((result) => {
                if (result.isConfirmed) {
                    const formData = result.value;

                    // Tampilkan loading
                    Swal.fire({
                        title: 'Menyimpan...',
                        text: 'Mohon tunggu sebentar.',
                        allowOutsideClick: false,
                        didOpen: () => {
                            Swal.showLoading();
                        }
                    });

                    fetch('{{ route('password.update') }}', {
                            method: 'POST',
                            headers: {
                                'X-CSRF-TOKEN': '{{ csrf_token() }}',
                                'Accept': 'application/json',
                            },
                            body: formData
                        })
                        .then(response => response.json())
                        .then(data => {
                            if (data.success) {
                                Swal.fire({
                                    icon: 'success',
                                    title: 'Berhasil!',
                                    text: data.message,
                                });
                            } else {
                                Swal.fire({
                                    icon: 'error',
                                    title: 'Oops...',
                                    text: data.message || 'Terjadi kesalahan!',
                                });
                            }
                        })
                        .catch(error => {
                            console.error('Error:', error);
                            Swal.fire({
                                icon: 'error',
                                title: 'Error!',
                                text: 'Tidak dapat terhubung ke server.',
                            });
                        });
                }
            });
        });
    </script>
</body>

</html>
