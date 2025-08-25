<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <!-- Tambahkan Flatpickr untuk kalender -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
    <script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>

    <title>Manajemen Simpanan</title>
</head>

<body class="bg-gray-100">
    @include('layout.menu')
    <div class="pt-24 pb-10">
        <div class="w-full max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="sm:flex justify-between items-start mb-6">
                <div>
                    <h1 class="text-3xl font-bold text-green-800">Manajemen Simpanan Anggota</h1>
                    <p class="text-gray-500 mt-1">Sistem penagihan berjalan otomatis setiap 30 hari.</p>
                </div>
            </div>

            <!-- Bagian Info  -->
            <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-6">
                <div class="bg-white p-4 rounded-lg shadow-sm">
                    <h3 class="text-sm font-medium text-gray-500">Siklus Tagihan Berikutnya</h3>
                    <div class="mt-1">
                        <span id="countdown-timer" class="text-2xl font-semibold text-indigo-600">Memuat...</span>
                        <span class="block text-sm text-gray-500">Periode: {{ $periodeTagihan }}</span>
                    </div>
                </div>
                <div class="bg-white p-4 rounded-lg shadow-sm">
                    <h3 class="text-sm font-medium text-gray-500">Simpanan Wajib</h3>
                    <p class="mt-1 text-2xl font-semibold text-gray-900">Rp
                        {{ number_format($wajibPerBulan, 0, ',', '.') }}/Bulan</p>
                </div>
                <div class="bg-white p-4 rounded-lg shadow-sm">
                    <h3 class="text-sm font-medium text-gray-500">Total Tunggakan Wajib</h3>
                    <p class="mt-1 text-2xl font-semibold text-red-600">Rp
                        {{ number_format($totalTagihanWajib, 0, ',', '.') }}</p>
                </div>
            </div>

            @if (session('success'))
                <div class="bg-green-100 border-l-4 border-green-500 text-green-700 p-4 mb-6 rounded-md" role="alert">
                    <p>{{ session('success') }}</p>
                </div>
            @endif
            @if (session('error'))
                <div class="bg-red-100 border-l-4 border-red-500 text-red-700 p-4 mb-6 rounded-md" role="alert">
                    <p>{{ session('error') }}</p>
                </div>
            @endif

            <!-- Tabel Data (Tidak ada perubahan) -->
            <div class="overflow-x-auto bg-white shadow-lg rounded-lg">
                <table class="min-w-full text-sm">
                    <thead class="bg-green-600 text-white">
                        <tr class="text-left">
                            <th class="p-3">No</th>
                            <th class="p-3">Nama Anggota</th>
                            <th class="p-3 text-center">Simpanan Pokok</th>
                            <th class="p-3 text-center">Simpanan Wajib</th>
                            <th class="p-3 text-center">Simpanan Sukarela</th>
                            <th class="p-3 text-center">Aksi</th>
                        </tr>
                    </thead>
                    <tbody id="anggotaTable">
                        @forelse ($simpananData as $data)
                            <tr class="border-b border-gray-200 hover:bg-green-50 transition">
                                <td class="p-3 text-center">{{ $loop->iteration }}</td>
                                <td class="p-3 font-medium text-gray-800">{{ $data->user->nama }}</td>
                                <td
                                    class="p-3 text-center font-semibold {{ $data->status_pokok == 'Lunas' ? 'text-green-600' : 'text-red-600' }}">
                                    {{ $data->status_pokok }}
                                    @if ($data->sisa_pokok > 0)
                                        <span class="block text-xs font-normal text-gray-500">(Kurang:
                                            {{ number_format($data->sisa_pokok, 0, ',', '.') }})</span>
                                    @endif
                                </td>
                                <td
                                    class="p-3 text-center font-semibold {{ $data->status_wajib == 'Lunas' ? 'text-green-600' : 'text-red-600' }}">
                                    {{ $data->status_wajib }}
                                    @if ($data->tagihan_wajib > 0)
                                        <span class="block text-xs font-normal text-gray-500">(Tagihan:
                                            {{ number_format($data->tagihan_wajib, 0, ',', '.') }})</span>
                                    @endif
                                </td>
                                <td class="p-3 text-center">Rp {{ number_format($data->total_sukarela, 0, ',', '.') }}
                                </td>
                                <td class="p-3 text-center">
                                    <button
                                        class="bg-cyan-500 text-white px-3 py-1 rounded text-xs mr-2 hover:bg-cyan-600 transition btn-bayar"
                                        data-id-user="{{ $data->id_user }}"
                                        data-nama-user="{{ $data->user->nama }}">Bayar</button>
                                    <a href="{{ route('anggota.show', ['id' => $data->id_user]) }}"
                                        class="bg-gray-300 px-3 py-1 rounded text-xs hover:bg-gray-400 transition">Detail</a>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="text-center p-5 text-gray-500">Tidak ada data simpanan.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <!-- Modal Pembayaran -->
    <div id="paymentModal" class="fixed inset-0 bg-black bg-opacity-40 flex items-center justify-center hidden z-50">
        <div class="bg-white p-6 rounded-lg shadow-xl w-full max-w-md">
            <h2 class="text-xl font-bold mb-2">Form Pembayaran Gabungan</h2>
            <p class="mb-4 text-gray-600">untuk: <strong id="namaUserModal"></strong></p>
            <form id="paymentForm" action="{{ route('simpanan.store') }}" method="POST">
                @csrf
                <input type="hidden" name="id_user" id="idUserModal">

                <!-- Input tersembunyi untuk menyimpan nilai numerik -->
                <input type="hidden" name="jumlah_pokok" id="jumlah_pokok_hidden">
                <input type="hidden" name="jumlah_wajib" id="jumlah_wajib_hidden">
                <input type="hidden" name="jumlah_sukarela" id="jumlah_sukarela_hidden">

                <div class="space-y-4">
                    <div>
                        <label for="jumlah_pokok_display" class="block text-sm font-medium text-gray-700">Bayar Simpanan
                            Pokok</label>
                        <!-- Input yang dilihat pengguna -->
                        <input type="text" id="jumlah_pokok_display"
                            class="w-full border-gray-300 rounded-md mt-1 px-3 py-3 shadow-sm" placeholder="0" />
                        <p id="info_pokok" class="mt-1 text-xs text-gray-500">Sisa tagihan: Rp 0</p>
                    </div>
                    <div>
                        <label for="jumlah_wajib_display" class="block text-sm font-medium text-gray-700">Bayar Simpanan
                            Wajib</label>
                        <input type="text" id="jumlah_wajib_display"
                            class="w-full border-gray-300 rounded-md mt-1 px-3 py-3 shadow-sm" placeholder="0" />
                        <p id="info_wajib" class="mt-1 text-xs text-gray-500">Total tagihan: Rp 0</p>
                    </div>
                    <div>
                        <label for="jumlah_sukarela_display" class="block text-sm font-medium text-gray-700">Tambah
                            Simpanan
                            Sukarela (Opsional)</label>
                        <input type="text" id="jumlah_sukarela_display"
                            class="w-full border-gray-300 rounded-md mt-1 px-3 py-3 shadow-sm" placeholder="0" />
                        <p class="mt-1 text-xs text-gray-500">Masukkan jumlah simpanan sukarela.</p>
                    </div>
                </div>
                <div class="flex justify-end gap-3 mt-6">
                    <button type="button" id="cancelBtn"
                        class="bg-gray-200 px-4 py-2 rounded-md hover:bg-gray-300 text-sm font-medium">Batal</button>
                    <button type="submit"
                        class="bg-green-600 text-white px-4 py-2 rounded-md hover:bg-green-700 text-sm font-medium">Konfirmasi
                        Bayar</button>
                </div>
            </form>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // --- FUNGSI UNTUK FORMAT RUPIAH ---
            function formatRupiah(angka) {
                let number_string = angka.replace(/[^,\d]/g, '').toString(),
                    split = number_string.split(','),
                    sisa = split[0].length % 3,
                    rupiah = split[0].substr(0, sisa),
                    ribuan = split[0].substr(sisa).match(/\d{3}/gi);

                if (ribuan) {
                    separator = sisa ? '.' : '';
                    rupiah += separator + ribuan.join('.');
                }

                rupiah = split[1] != undefined ? rupiah + ',' + split[1] : rupiah;
                return rupiah;
            }

            // --- FUNGSI UNTUK MENGHUBUNGKAN INPUT DISPLAY DAN HIDDEN ---
            function setupCurrencyInput(displayId, hiddenId) {
                const displayInput = document.getElementById(displayId);
                const hiddenInput = document.getElementById(hiddenId);

                displayInput.addEventListener('keyup', function(e) {
                    // Ambil nilai dari input display dan bersihkan dari titik
                    let unformattedValue = this.value.replace(/\./g, '');

                    // Update nilai input hidden dengan angka murni
                    hiddenInput.value = unformattedValue;

                    // Format nilai di input display dengan titik
                    this.value = formatRupiah(this.value);
                });
            }

            // Terapkan fungsi ke setiap input nominal
            setupCurrencyInput('jumlah_pokok_display', 'jumlah_pokok_hidden');
            setupCurrencyInput('jumlah_wajib_display', 'jumlah_wajib_hidden');
            setupCurrencyInput('jumlah_sukarela_display', 'jumlah_sukarela_hidden');


            // --- KODE MODAL YANG SUDAH ADA (DENGAN SEDIKIT PENYESUAIAN) ---
            const paymentModal = document.getElementById("paymentModal");
            const cancelBtn = document.getElementById("cancelBtn");
            const bayarButtons = document.querySelectorAll(".btn-bayar");
            const namaUserModal = document.getElementById("namaUserModal");
            const idUserModal = document.getElementById("idUserModal");

            // Mengacu pada input display
            const jumlahPokokInput = document.getElementById("jumlah_pokok_display");
            const jumlahWajibInput = document.getElementById("jumlah_wajib_display");
            const jumlahSukarelaInput = document.getElementById("jumlah_sukarela_display");

            // Mengacu pada input hidden
            const jumlahPokokHidden = document.getElementById("jumlah_pokok_hidden");
            const jumlahWajibHidden = document.getElementById("jumlah_wajib_hidden");
            const jumlahSukarelaHidden = document.getElementById("jumlah_sukarela_hidden");


            const infoPokok = document.getElementById("info_pokok");
            const infoWajib = document.getElementById("info_wajib");

            async function updateModalInfo(idUser) {
                infoPokok.textContent = 'Memuat...';
                infoWajib.textContent = 'Memuat...';

                // Reset semua input
                jumlahPokokInput.value = '';
                jumlahWajibInput.value = '';
                jumlahSukarelaInput.value = '';
                jumlahPokokHidden.value = '';
                jumlahWajibHidden.value = '';
                jumlahSukarelaHidden.value = '';

                jumlahPokokInput.readOnly = true;
                jumlahWajibInput.readOnly = true;

                try {
                    const response = await fetch(`/simpanan/info/${idUser}`);
                    if (!response.ok) throw new Error('Gagal memuat data');
                    const data = await response.json();

                    if (data.sisa_pokok > 0) {
                        infoPokok.textContent = `Sisa tagihan: Rp ${data.sisa_pokok.toLocaleString('id-ID')}`;
                        jumlahPokokInput.placeholder = `Maks. ${data.sisa_pokok.toLocaleString('id-ID')}`;
                        jumlahPokokInput.readOnly = false;
                    } else {
                        infoPokok.innerHTML = `<span class="text-green-600 font-semibold">LUNAS</span>`;
                    }

                    if (data.tagihan_wajib > 0) {
                        infoWajib.textContent =
                            `Total tagihan: Rp ${data.tagihan_wajib.toLocaleString('id-ID')}`;
                        jumlahWajibInput.placeholder = `Maks. ${data.tagihan_wajib.toLocaleString('id-ID')}`;
                        jumlahWajibInput.readOnly = false;
                    } else {
                        infoWajib.innerHTML = `<span class="text-green-600 font-semibold">LUNAS</span>`;
                    }
                } catch (error) {
                    infoPokok.innerHTML = `<span class="text-red-600">${error.message}</span>`;
                    infoWajib.innerHTML = `<span class="text-red-600">${error.message}</span>`;
                }
            }

            bayarButtons.forEach(btn => {
                btn.addEventListener("click", () => {
                    const idUser = btn.dataset.idUser;
                    const namaUser = btn.dataset.namaUser;
                    namaUserModal.textContent = namaUser;
                    idUserModal.value = idUser;
                    updateModalInfo(idUser);
                    paymentModal.classList.remove("hidden");
                });
            });

            cancelBtn.addEventListener("click", () => paymentModal.classList.add("hidden"));
            paymentModal.addEventListener("click", (e) => {
                if (e.target === paymentModal) paymentModal.classList.add("hidden");
            });

            const countdownElement = document.getElementById('countdown-timer');
            const countdownDate = new Date("{{ $tanggalTagihanBerikutnya->toIso8601String() }}").getTime();

            if (countdownDate) {
                const interval = setInterval(function() {
                    const now = new Date().getTime();
                    const distance = countdownDate - now;

                    const days = Math.floor(distance / (1000 * 60 * 60 * 24));
                    const hours = Math.floor((distance % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
                    const minutes = Math.floor((distance % (1000 * 60 * 60)) / (1000 * 60));
                    const seconds = Math.floor((distance % (1000 * 60)) / 1000);

                    if (distance < 0) {
                        clearInterval(interval);
                        countdownElement.innerHTML = "Siklus Baru Dimulai";
                        setTimeout(() => window.location.reload(), 2000);
                    } else {
                        countdownElement.innerHTML =
                            `${days} hari ${hours}:${minutes < 10 ? '0' : ''}${minutes}:${seconds < 10 ? '0' : ''}${seconds}`;
                    }
                }, 1000);
            } else {
                countdownElement.innerHTML = "Belum diatur";
            }
        });
    </script>
</body>

</html>
