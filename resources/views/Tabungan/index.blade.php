<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manajemen Tabungan Anggota</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</head>

<body class="bg-gray-50">
    @include('Layout.menu')
    <div class="pt-24">
        <div class="w-full max-w-7xl mx-auto py-8 px-4 sm:px-6 lg:px-8">
            <header class="mb-8">
                <h1 class="text-3xl font-bold tracking-tight text-gray-900">Manajemen Tabungan Anggota</h1>
                <p class="text-gray-600 mt-1">Lakukan transaksi menabung atau menarik saldo untuk anggota.</p>
            </header>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-8">
                <div class="bg-white border-2 border-black p-4 rounded-lg shadow-sm">
                    <h3 class="text-sm font-medium text-gray-500">Total Seluruh Tabungan</h3>
                    <p class="mt-1 text-2xl font-semibold text-green-600">Rp
                        {{ number_format($totalSeluruhTabungan, 0, ',', '.') }}</p>
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

            <main>
                <div class="bg-white shadow-sm ring-1 ring-gray-900/5 sm:rounded-xl ">
                    <div class="overflow-x-auto">
                        <table class="min-w-full divide-y divide-gray-300 ">
                            <thead class="bg-gray-100">
                                <tr>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">NIK</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Nama
                                        Anggota</th>
                                    <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase">Total
                                        Tabungan</th>
                                    <th class="px-6 py-3 text-center text-xs font-medium text-gray-500 uppercase">Aksi
                                    </th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-200 ">
                                @forelse ($tabunganData as $tabungan)
                                    <tr>
                                        <td class="px-6 py-4 whitespace-nowrap text-l text-gray-500">
                                            {{ $tabungan->id_user }}</td>
                                        <td class="px-6 py-4 whitespace-nowrap text-l font-medium text-gray-900">
                                            {{ $tabungan->user->nama }}</td>
                                        <td
                                            class="px-6 py-4 whitespace-nowrap text-l font-semibold text-gray-700 text-right">
                                            Rp {{ number_format($tabungan->total_tabungan, 0, ',', '.') }}</td>
                                        <td class="px-6 py-4 whitespace-nowrap text-l font-medium text-center">
                                            <button
                                                class="bg-blue-500 text-white px-3 py-3 rounded text-xs mr-2 hover:bg-blue-600 transition btn-transaksi"
                                                data-id-user="{{ $tabungan->id_user }}"
                                                data-nama-user="{{ $tabungan->user->nama }}">
                                                Nabung / Tarik
                                            </button>
                                            <a href="{{ route('anggota.show', $tabungan->id_user) }}"
                                                class="text-indigo-600 hover:text-indigo-900">Lihat Detail</a>

                                            <a href="{{ route('tabungan.cetakRekap', $tabungan->id_user) }}"
                                                target="_blank"
                                                class="ml-2 bg-green-500 text-white px-3 py-2 rounded text-xs hover:bg-green-600 transition">
                                                Cetak Rekap
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="4" class="text-center p-5 text-gray-500">Tidak ada data
                                            tabungan.</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </main>
        </div>
    </div>

    <!-- Modal Transaksi Tabungan -->
    <div id="transaksiModal" class="fixed inset-0 bg-black bg-opacity-40 flex items-center justify-center hidden z-50">
        <div class="bg-white p-6 rounded-lg shadow-xl w-full max-w-md">
            <h2 class="text-xl font-bold mb-2">Form Transaksi Tabungan</h2>
            <p class="mb-4 text-gray-600">untuk: <strong id="namaUserModal"></strong></p>
            <form action="{{ route('tabungan.store') }}" method="POST">
                @csrf
                <input type="hidden" name="id_user" id="idUserModal">
                <div class="space-y-4">
                    <div>
                        <label for="jenis_transaksi" class="block text-sm font-medium text-gray-700">Jenis
                            Transaksi</label>
                        <select name="jenis_transaksi" id="jenis_transaksi"
                            class="w-full border-gray-300 rounded-md mt-1 shadow-sm py-3 px-2">
                            <option value="menabung">Menabung</option>
                            <option value="menarik">Menarik Tunai</option>
                        </select>
                    </div>
                    <div>
                        <label for="jumlah" class="block text-sm font-medium text-gray-700">Jumlah</label>
                        <input type="text" name="jumlah" id="jumlah"
                            class="w-full border-gray-300 rounded-md mt-1 shadow-sm py-3 px-2"
                            placeholder="Contoh: 50.000" required autocomplete="off">

                    </div>
                </div>
                <div class="flex justify-end gap-3 mt-6">
                    <button type="button" id="cancelBtn"
                        class="bg-gray-200 px-4 py-2 rounded-md hover:bg-gray-300 text-sm font-medium">Batal</button>
                    <button type="submit"
                        class="bg-green-600 text-white px-4 py-2 rounded-md hover:bg-green-700 text-sm font-medium">Simpan
                        Transaksi</button>
                </div>
            </form>
        </div>


    </div>


    <script>
        const transaksiModal = document.getElementById('transaksiModal');
        const btnTransaksi = document.querySelectorAll('.btn-transaksi');
        const cancelBtn = document.getElementById('cancelBtn');
        const namaUserModal = document.getElementById('namaUserModal');
        const idUserModal = document.getElementById('idUserModal');
        const jumlahInput = document.getElementById('jumlah');
        const formTransaksi = document.getElementById('formTransaksi');

        btnTransaksi.forEach(btn => {
            btn.addEventListener('click', () => {
                namaUserModal.textContent = btn.dataset.namaUser;
                idUserModal.value = btn.dataset.idUser;
                transaksiModal.classList.remove('hidden');
            });
        });

        cancelBtn.addEventListener('click', () => transaksiModal.classList.add('hidden'));
        transaksiModal.addEventListener('click', (e) => {
            if (e.target === transaksiModal) transaksiModal.classList.add('hidden');
        });



        function formatRupiah(angka) {
            let number_string = angka.replace(/[^,\d]/g, '').toString(),
                split = number_string.split(','),
                sisa = split[0].length % 3,
                rupiah = split[0].substr(0, sisa),
                ribuan = split[0].substr(sisa).match(/\d{3}/gi);

            if (ribuan) {
                let separator = sisa ? '.' : '';
                rupiah += separator + ribuan.join('.');
            }

            rupiah = split[1] != undefined ? rupiah + ',' + split[1] : rupiah;
            return rupiah;
        }
        jumlahInput.addEventListener('input', function(e) {
            e.target.value = formatRupiah(e.target.value);
        });

        formTransaksi.addEventListener('submit', function(e) {
            let formattedValue = jumlahInput.value;
            let rawValue = formattedValue.replace(/\./g, '');
            jumlahInput.value = rawValue;
        });
    </script>

    <footer class="bg-white text-gray-600 text-center py-6 mt-[200px] border-t">
        <p>&copy; {{ date('Y') }} Koperasi Banteng Putih.</p>
    </footer>


</body>

</html>
