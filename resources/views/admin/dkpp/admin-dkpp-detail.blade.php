{{-- @dd($data) --}}

<x-admin-layout>
    <main class="flex-1 p-4 sm:p-6">
        <h2 class="text-2xl font-semibold text-green-900 text-center sm:text-left mb-4">Lihat Detail Data</h2>
    
        <div class="bg-white p-4 sm:p-6 rounded shadow-md">
            <h3 class="text-lg font-semibold text-center">Data Minggu 4 Per Januari 2025</h3>
            <h3 class="text-lg font-semibold text-center mb-4">Kabupaten Jember</h3>
    
            <!-- Search dan Dropdown -->
            <div class="flex flex-col lg:flex-row justify-between gap-4 mb-6">
                <!-- Search -->
                <div class="relative">
                    <div class="flex items-center border bg-white rounded-full w-full sm:w-64 h-10">
                        <span class="bi bi-search pl-5 pr-4"></span>
                        <input type="text" placeholder="Cari..." class="w-full outline-none rounded-full text-sm pr-4">
                    </div>
                </div>
    
                <!-- Dropdowns -->
                <form class="flex flex-col sm:flex-row gap-4 w-full lg:w-auto">
                    <div class="w-full sm:w-36">
                        <label for="pilih_urutan" class="block text-sm font-medium text-gray-700 mb-1">Urutkan</label>
                        <select class="border border-black p-2 rounded-full bg-white w-full" id="pilih_urutan">
                            <option>Ascending</option>
                            <option>Descending</option>
                        </select>
                    </div>
                    <div class="w-full sm:w-36">
                        <label for="pilih_periode" class="block text-sm font-medium text-gray-700 mb-1">Pilih Periode</label>
                        <select class="border border-black p-2 rounded-full bg-white w-full" id="pilih_periode">
                            @foreach ($periods as $period)
                                <option value="{{ $period }}">{{ $period }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="w-full sm:w-24">
                        <label for="pilih_minggu" class="block text-sm font-medium text-gray-700 mb-1">Minggu ke</label>
                        <select class="border border-black p-2 rounded-full bg-white w-full" id="pilih_minggu">
                            <option>1</option>
                            <option selected>2</option>
                            <option>3</option>
                            <option>4</option>
                        </select>
                    </div>
                </form>
            </div>
    
            <!-- Tabel Responsif -->
            <div class="overflow-x-auto">
                <table class="min-w-[1000px] w-full border border-gray-300 table-auto">
                    <thead>
                        <tr>
                            <th class="border p-2">No</th>
                            <th class="border p-2">Jenis Komoditas</th>
                            <th class="border p-2">Ketersediaan (ton)</th>
                            <th class="border p-2">Kebutuhan / Minggu</th>
                            <th class="border p-2">Neraca Mingguan</th>
                            <th class="border p-2">Keterangan</th>
                            <th class="border p-2">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($data as $item)  
                            @php $keterangan = $item->keterangan; @endphp         
                            <tr class="border text-sm">
                                <td class="border p-2">{{ $loop->iteration }}</td>
                                <td class="border p-2">{{ $item->jenis_komoditas }}</td>
                                <td class="border p-2">{{ $item->ton_ketersediaan }}</td>
                                <td class="border p-2">{{ $item->ton_kebutuhan_perminggu }}</td>
                                <td class="border p-2">{{ $item->ton_neraca_mingguan }}</td>
                                <td class="border p-2 font-bold {{ $keterangan == 'Surplus' ? 'text-green-500' : ($keterangan == 'Defisit' ? 'text-red-500' : 'text-slate-600') }}">
                                    {{ $keterangan }}
                                </td>
                                <td class="border p-2">
                                    <div class="flex justify-center gap-2">
                                        <a href="{{ route('dkpp.edit', $item->id) }}">
                                            <button class="bg-yellow-400 text-white rounded-md w-10 h-10">
                                                <i class="bi bi-pencil-square"></i>
                                            </button>
                                        </a>
                                        <button class="deleteBtn bg-red-500 text-white rounded-md w-10 h-10" data-id="{{ $item->id }}">
                                            <i class="bi bi-trash-fill"></i>
                                        </button>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
    
            <!-- Tombol -->
            <div class="flex justify-between mt-6">
                <a href="{{ route('dkpp.index') }}">
                    <button class="bg-green-700 text-white px-6 py-2 rounded-full hover:bg-green-800">Kembali</button>
                </a>
            </div>
        </div>
    
        <!-- Modal -->
        <div id="modal" class="hidden w-full h-full">
            <div class="fixed inset-0 bg-black bg-opacity-50 flex justify-center items-center z-40">
                <div class="bg-white p-6 rounded-lg w-[90%] max-w-md shadow-lg">
                    <h2 class="text-xl font-semibold mb-6 text-center">Yakin menghapus data?</h2>
                    <div class="flex justify-around">
                        <button class="bg-green-800 hover:bg-green-900 text-white px-4 py-2 rounded-full" id="closeBtn">Tutup</button>
                        <button class="bg-green-800 hover:bg-green-900 text-white px-4 py-2 rounded-full" id="yesBtn">Yakin</button>
                    </div>
                </div>
            </div>
        </div>
    </main>
     
</x-admin-layout>

<script>
    // Tombol Delete
    $(document).on('click', '.deleteBtn', function() {
        let id = $(this).data('id');
        $('#modal').show();

        $('#yesBtn').on('click', function() {
            $('#modal').hide();

            $.ajax({
                type: 'DELETE',
                url: `/api/dkpp/${id}`,
                data: {
                    _token: '{{ csrf_token() }}',
                },
                success: function(data) {                    
                    Swal.fire({
                        title: 'Berhasil!',
                        text: `Data ${data.data.jenis_komoditas} telah dihapus.`,
                        icon: 'success',
                        confirmButtonText: 'OK'
                    }).then(() => {
                        location.reload();
                    });
                },
                error: function(xhr, status, error) {
                    Swal.fire({
                        icon: 'error',
                        title: 'Oops...',
                        html: error
                    });
                }
            });
        });
    });


    $('#closeBtn').on('click', function() {
        $('#modal').hide();
    });
</script>

