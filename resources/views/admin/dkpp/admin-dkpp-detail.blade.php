{{-- @dd($periods) --}}

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
                    <form action="" method="get">
                        <select class="border p-2 rounded bg-white">
                            <option value="" disabled selected>Urutkan</option>
                            <option>Ascending</option>
                            <option>Descending</option>
                        </select>
                        <select class="border p-2 rounded bg-white">
                            {{-- <option value="" disabled selected>Pilih Periode</option> --}}
                            @foreach ($periods as $period)
                                <option value="{{ $period }}">{{ $period }}</option>
                            @endforeach
                        </select>
                        <select class="border p-2 rounded bg-white">
                            <option value="" disabled>Minggu Ke</option>
                            <option>1</option>
                            <option selected>2</option>
                            <option>3</option>
                            <option>4</option>
                        </select>
                    </form>
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
                        @foreach ($data as $item)               
                            @php
                                $keterangan = $item->keterangan;
                            @endphp             
                            <tr class="border">
                                <td class="border p-2">{{ $loop->iteration }}</td>
                                <td class="border p-2">{{ $item->jenis_komoditas }}</td>
                                <td class="border p-2">{{ $item->ton_ketersediaan }}</td>
                                <td class="border p-2">{{ $item->ton_kebutuhan_perminggu }}</td>
                                <td class="border p-2">{{ $item->ton_neraca_mingguan }}</td>
                                <td class="border p-2 font-bold {{ $keterangan == 'Surplus' ? 'text-green-500' : ($keterangan == 'Defisit' ? 'text-red-500' : 'text-slate-600') }}">
                                    {{ $keterangan }}
                                </td>
                                <td class="border p-2 flex justify-center gap-2">
                                    <a href="{{ route('dkpp.edit', $item->id) }}">
                                        <button class="bg-yellow-400 text-center text-white rounded-md w-10 h-10">
                                            <i class="bi bi-pencil-square"></i>
                                        </button>
                                        </a>
                                        <button class="deleteBtn bg-red-500 text-center text-white rounded-md w-10 h-10" data-id="{{ $item->id }}">
                                            <i class="bi bi-trash-fill"></i>
                                        </button>
                                    </button>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
    
            <!-- Button Kembali & Tambah Data -->
            <div class="flex justify-between mt-4">
                <a href="{{ route('dkpp.index') }}">
                <button class="bg-green-700 text-white px-6 py-2 rounded hover:bg-green-800">Kembali</button>
                </a>
            </div>
        </div>

            {{-- Modal --}}
            <div id="modal" class="hidden w-full h-full">
                <div class="fixed inset-0 bg-black bg-opacity-50 flex justify-center items-center z-40">
                    <div class="bg-white p-6 rounded-lg w-[25%] max-w-2xl shadow-lg relative">
                        <h2 class="text-xl font-semibold mb-8 text-center">Yakin menghapus data?</h2>
    
                        <div class="flex justify-evenly">
                            <!-- Tombol Batal -->
                            <div class="text-right" id="closeBtn">
                                <button class="bg-green-800 hover:bg-green-900 text-white px-4 py-2 rounded">Tutup</button>
                            </div>
                            <!-- Tombol Yakin -->
                            <div class="text-right">
                                <button class="bg-green-800 hover:bg-green-900 text-white px-4 py-2 rounded" id="yesBtn">Yakin</button>
                            </div>
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
                url: `api/dkpp/${id}`,
                data: {
                    _token: '{{ csrf_token() }}',
                },
                success: function(data) {                    
                    Swal.fire({
                        title: 'Berhasil!',
                        text: `Data ${data.data.jenis_komoditas} telah dihapus.`,
                        icon: 'success',
                        confirmButtonText: 'OK'
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

