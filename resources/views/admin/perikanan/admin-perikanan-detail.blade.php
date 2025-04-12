{{-- @dd($data) --}}
<x-admin-layout>
    <main class="flex-1 p-6">
        <h2 class="text-2xl font-semibold text-green-900">Lihat Detail Data</h2>
    
        <div class="bg-white p-6 rounded shadow-md mt-4">
            <h3 class="text-lg font-semibold text-center">Data Volume dan Harga Ikan Lele Tahun 2025</h3>
            
            <!-- Search dan Dropdown -->
            <div class="flex justify-between my-4">
                <div class="relative">
                    <input type="text" placeholder="Cari..." class="border p-2 rounded pl-8 w-64">
                    <span class="absolute left-2 top-2 text-gray-400">
                      <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-search" viewBox="0 0 16 16">
                        <path d="M11.742 10.344a6.5 6.5 0 1 0-1.397 1.398h-.001q.044.06.098.115l3.85 3.85a1 1 0 0 0 1.415-1.414l-3.85-3.85a1 1 0 0 0-.115-.1zM12 6.5a5.5 5.5 0 1 1-11 0 5.5 5.5 0 0 1 11 0"/>
                      </svg>
                    </span>
                </div>
                <div class="flex gap-4">
                    <select class="border p-2 rounded bg-white">
                        <option>Urutan</option>
                        <option>Ascending</option>
                    </select>
                    <select class="border p-2 rounded bg-white">
                        <option>Pilih Jenis Ikan</option>
                        <option>Lele</option>
                    </select>
                    <select class="border p-2 rounded bg-white">
                        <option>Periode</option>
                        <option>2025</option>
                    </select>
                </div>
            </div>
    
            <!-- Tabel -->
            <div class="overflow-x-auto">
                <table class="min-w-full border border-gray-300 text-left table-fixed ">
                    <thead class="bg-gray-100">
                        <tr>
                            <th class="border p-2" rowspan="2">Ikan di TPI Puger</th>
                            <th class="border p-2 text-center" colspan="3">Produksi</th>
                            {{-- <th class="border p-2" rowspan="2">Harga Ikan/Kg</th> --}}
                            <th class="border p-2" rowspan="2">Aksi</th>
                        </tr>
                        <tr class="bg-gray-50">
                            <th class="border p-2">Jan</th>
                            <th class="border p-2">...</th>
                            <th class="border p-2">Des</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr class="border">
                            <td class="border p-2">Lele</td>
                            <td class="border p-2 text-center">1000</td>
                            <td class="border p-2 text-center">...</td>
                            <td class="border p-2 text-center">1000</td>
                            {{-- <td class="border p-2">Rp. 12.000</td> --}}
                            <td class="border p-2 flex justify-center gap-2">
                                <a href="{{ route('perikanan.edit', 1) }}">
                                <button class="bg-yellow-400 p-1 rounded">
                                  <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-pencil-square" viewBox="0 0 16 16">
                                    <path d="M15.502 1.94a.5.5 0 0 1 0 .706L14.459 3.69l-2-2L13.502.646a.5.5 0 0 1 .707 0l1.293 1.293zm-1.75 2.456-2-2L4.939 9.21a.5.5 0 0 0-.121.196l-.805 2.414a.25.25 0 0 0 .316.316l2.414-.805a.5.5 0 0 0 .196-.12l6.813-6.814z"/>
                                    <path fill-rule="evenodd" d="M1 13.5A1.5 1.5 0 0 0 2.5 15h11a1.5 1.5 0 0 0 1.5-1.5v-6a.5.5 0 0 0-1 0v6a.5.5 0 0 1-.5.5h-11a.5.5 0 0 1-.5-.5v-11a.5.5 0 0 1 .5-.5H9a.5.5 0 0 0 0-1H2.5A1.5 1.5 0 0 0 1 2.5z"/>
                                  </svg>
                                </button>
                                </a>
                                <button class="bg-red-500 text-white p-1 rounded">
                                  <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-trash" viewBox="0 0 16 16">
                                    <path d="M5.5 5.5A.5.5 0 0 1 6 6v6a.5.5 0 0 1-1 0V6a.5.5 0 0 1 .5-.5m2.5 0a.5.5 0 0 1 .5.5v6a.5.5 0 0 1-1 0V6a.5.5 0 0 1 .5-.5m3 .5a.5.5 0 0 0-1 0v6a.5.5 0 0 0 1 0z"/>
                                    <path d="M14.5 3a1 1 0 0 1-1 1H13v9a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V4h-.5a1 1 0 0 1-1-1V2a1 1 0 0 1 1-1H6a1 1 0 0 1 1-1h2a1 1 0 0 1 1 1h3.5a1 1 0 0 1 1 1zM4.118 4 4 4.059V13a1 1 0 0 0 1 1h6a1 1 0 0 0 1-1V4.059L11.882 4zM2.5 3h11V2h-11z"/>
                                  </svg>
                                </button>
                            </td>
                        </tr>
                    </tbody>
                </table>                                    
            </div>
    
            <!-- Button Kembali & Tambah Data -->
            <div class="flex justify-between mt-4">
                <a href="/sprint-1-admin/Public/Perikanan.html">
                <button class="bg-green-700 text-white px-6 py-2 rounded hover:bg-green-800">Kembali</button>
                </a>
                <a href="Tambah.html">
                <button class="bg-green-700 text-white px-6 py-2 rounded hover:bg-green-800">Tambah Data</button>
                </a>
            </div>
        </div>
    </main>
</x-admin-layout>

<script>
    // $(document).ready(function() {
    //     $('.select2').select2();

    //     // Filter Value
    //     $('#pilih_pasar').on('change', function() {
    //         $('#pilih_periode').removeAttr('disabled');
    //     });

    //     $('#pilih_periode').on('change', function() {
    //         let pasar = $('#pilih_pasar').val();
    //         let periode = $('#pilih_periode').val();

    //         console.log(pasar);
    //         console.log(periode);
            
            
    //     })

    // });
</script>