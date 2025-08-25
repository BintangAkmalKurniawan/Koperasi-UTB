<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manajemen SHU Koperasi</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="bg-gray-100">
    @include('Layout.menu')

    <div class="pt-24">
        <div class="w-full max-w-7xl mx-auto py-8 px-4 sm:px-6 lg:px-8">
            <header class="sm:flex justify-between items-center mb-8">
                <h1 class="text-3xl font-bold tracking-tight text-gray-900">Manajemen Sisa Hasil Usaha (SHU)</h1>
                <button type="button" id="btnTambahPeriode"
                    class="mt-4 sm:mt-0 inline-flex items-center gap-x-2 rounded-md bg-green-600 px-4 py-3 text-base font-semibold text-white shadow-sm hover:bg-green-700">
                    <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                        <path
                            d="M10.75 4.75a.75.75 0 0 0-1.5 0v4.5h-4.5a.75.75 0 0 0 0 1.5h4.5v4.5a.75.75 0 0 0 1.5 0v-4.5h4.5a.75.75 0 0 0 0-1.5h-4.5v-4.5Z" />
                    </svg>
                    Tambah Periode SHU
                </button>
            </header>

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
                <div class="bg-white shadow-sm ring-1 ring-gray-900/5 sm:rounded-xl">
                    <div class="px-4 sm:px-6 lg:px-8 py-5 border-b">
                        <h2 class="text-xl font-semibold leading-6 text-gray-900">Riwayat Periode SHU</h2>
                    </div>
                    <div class="overflow-x-auto">
                        <table class="min-w-full divide-y divide-gray-200">
                            <thead class="bg-gray-50">
                                <tr>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Periode
                                    </th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Total
                                        SHU</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Jasa
                                        Modal</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Jasa
                                        Usaha</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Status
                                    </th>
                                    <th class="relative px-6 py-3"><span class="sr-only">Aksi</span></th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-200">
                                @forelse ($periods as $period)
                                    <tr>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">Tahun
                                            {{ $period->periode }}</td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">Rp
                                            {{ number_format($period->total_shu, 0, ',', '.') }}</td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                            {{ $period->persen_jasa_modal }}%</td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                            {{ $period->persen_jasa_usaha }}%</td>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            @if ($period->status == 'proses')
                                                <span
                                                    class="inline-flex items-center rounded-md bg-yellow-50 px-2 py-1 text-xs font-medium text-yellow-800 ring-1 ring-inset ring-yellow-600/20">Proses</span>
                                            @else
                                                <span
                                                    class="inline-flex items-center rounded-md bg-green-50 px-2 py-1 text-xs font-medium text-green-700 ring-1 ring-inset ring-green-600/20">Dibagikan</span>
                                            @endif
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                            <a href="{{ route('shu.show', $period->id) }}"
                                                class="text-indigo-600 hover:text-indigo-900">Lihat Detail</a>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="6" class="text-center p-5 text-gray-500">Belum ada periode SHU
                                            yang dibuat.</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </main>
        </div>
    </div>

    <!-- Modal Tambah Periode SHU -->
    <div id="shuModal" class="fixed inset-0 bg-black bg-opacity-40 flex items-center justify-center hidden z-50">
        <div class="bg-white p-6 rounded-lg shadow-xl w-full max-w-lg">
            <h2 class="text-xl font-bold mb-4">Tambah Periode SHU Baru</h2>
            <form action="{{ route('shu.store') }}" method="POST">
                @csrf
                <div class="space-y-6">
                    <div>
                        <label for="periode" class="block text-sm font-medium text-gray-700">Periode (Tahun)</label>
                        <input type="number" name="periode" id="periode"
                            class="w-full border-gray-300 border-2 rounded-md mt-1 shadow-sm py-2 px-2"
                            placeholder="Contoh: 2025" required>
                    </div>
                    <div>
                        <label for="total_shu" class="block text-sm font-medium text-gray-700">Total SHU yang Akan
                            Dibagikan</label>
                        <input type="number" name="total_shu" id="total_shu"
                            class="w-full border-gray-300 border-2 rounded-md mt-1 shadow-sm py-2 px-2"
                            placeholder="Contoh: 150000000" required>
                    </div>
                    <div class="grid grid-cols-2 gap-4">
                        <div>
                            <label for="persen_jasa_modal" class="block text-sm font-medium text-gray-700">Persentase
                                Jasa Modal (%)</label>
                            <input type="number" name="persen_jasa_modal" id="persen_jasa_modal"
                                class="w-full border-gray-300 border-2 rounded-md mt-1 shadow-sm py-2 px-2"
                                placeholder="Contoh: 25" required>
                        </div>
                        <div>
                            <label for="persen_jasa_usaha" class="block text-sm font-medium text-gray-700">Persentase
                                Jasa Usaha (%)</label>
                            <input type="number" name="persen_jasa_usaha" id="persen_jasa_usaha"
                                class="w-full border-gray-300 border-2 rounded-md mt-1 shadow-sm py-2 px-2"
                                placeholder="Contoh: 45" required>
                        </div>
                    </div>
                    <p class="text-xs text-gray-500">Sisa persentase akan dialokasikan untuk dana cadangan, sosial, dll.
                    </p>
                </div>
                <div class="flex justify-end gap-3 mt-6">
                    <button type="button" id="cancelBtn"
                        class="bg-gray-200 px-4 py-2 rounded-md hover:bg-gray-300 text-sm font-medium">Batal</button>
                    <button type="submit"
                        class="bg-green-600 text-white px-4 py-2 rounded-md hover:bg-green-700 text-sm font-medium">Hitung
                        & Simpan</button>
                </div>
            </form>
        </div>
    </div>

    <script>
        const shuModal = document.getElementById('shuModal');
        const btnTambahPeriode = document.getElementById('btnTambahPeriode');
        const cancelBtn = document.getElementById('cancelBtn');

        btnTambahPeriode.addEventListener('click', () => shuModal.classList.remove('hidden'));
        cancelBtn.addEventListener('click', () => shuModal.classList.add('hidden'));
        shuModal.addEventListener('click', (e) => {
            if (e.target === shuModal) shuModal.classList.add('hidden');
        });
    </script>
</body>

</html>
