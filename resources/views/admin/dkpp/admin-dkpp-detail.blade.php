<x-admin-layout>
    <main class="flex-1 p-6">
        <h2 class="text-2xl font-semibold text-green-900">Lihat Detail Data</h2>
    
        <div class="bg-white p-6 rounded shadow-md mt-4">
            <h3 class="text-lg font-semibold text-center">Data Minggu 4 Per Januari 2025</h3>
            <h3 class="text-lg font-semibold text-center">Kabupaten Jember</h3>
            
            <!-- Search dan Dropdown -->
            <div class="flex justify-between my-4">
                <div class="relative">
                    {{-- Search --}}
                    <div class="flex items-center  border bg-white rounded-full w-64 flex-row h-9">
                        <span class="bi bi-search pl-5 pr-4"></span>
                        <input type="text" placeholder="Cari..." class="w-5/6 outline-none rounded-full">
                    </div>
                </div>
                <div class="flex gap-4">
                    <select class="border p-2 rounded bg-white">
                        <option>Pilih Pasar</option>
                        <option>Pasar Tanjung</option>
                    </select>
                    <select class="border p-2 rounded bg-white">
                        <option>Pilih Periode</option>
                        <option>Januari 2025</option>
                    </select>
                    <select class="border p-2 rounded bg-white">
                        <option>Minggu Ke</option>
                        <option>4</option>
                    </select>
                </div>
            </div>
    
            <!-- Tabel -->
            <div class="overflow-x-auto">
                <table class="min-w-full border border-gray-300 table-fixed ">
                    <thead>
                        <tr>
                            <th rowspan="2" class="border p-2">No</th>
                            <th rowspan="2" class="border p-2">Jenis Komoditas</th>
                            <th rowspan="1" class="border p-2">Ketersediaan (ton)</th>
                            <th colspan="1" class="border p-2">Kebutuhan Per Minggu</th>
                            <th colspan="1" class="border p-2">Neraca Mingguan</th>
                            <th colspan="1" class="border p-2">Keterangan</th>
                            <th colspan="1" class="border p-2">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr class="border">
                            <td class="border p-2">1</td>
                            <td class="border p-2">Beras</td>
                            <td class="border p-2">1000</td>
                            <td class="border p-2">1100</td>
                            <td class="border p-2">-100</td>
                            <td class="border p-2 font-bold"style="color: red;">Defisit</td>
                            <td class="border p-2 flex justify-center gap-2">
                                <a href="{{ route('dkpp.edit', 1) }}">
                                    <button class="bg-yellow-400 text-center text-white rounded-md w-10 h-10">
                                        <i class="bi bi-pencil-square"></i>
                                    </button>
                                    </a>
                                    <button class="bg-red-500 text-center text-white rounded-md w-10 h-10">
                                        <i class="bi bi-trash-fill"></i>
                                    </button>
                                </button>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
    
            <!-- Button Kembali & Tambah Data -->
            <div class="flex justify-between mt-4">
                <a href="/Public/DKPP.html">
                <button class="bg-green-700 text-white px-6 py-2 rounded-full hover:bg-green-800">Kembali</button>
                </a>
                <a href="Tambah.html">
                <button class="bg-green-700 text-white px-6 py-2 rounded-full hover:bg-green-800">Tambah Data</button>
                </a>
            </div>
        </div>
    </main>    
</x-admin-layout>