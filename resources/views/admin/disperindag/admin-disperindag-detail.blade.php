{{-- @dd($data) --}}
<x-admin-layout>
    <main class="flex-1 p-6">
        <h2 class="text-2xl font-semibold text-green-900">{{ $title }}</h2>
    
        <div class="bg-white p-6 rounded shadow-md mt-4">
            <h3 class="text-lg font-semibold text-center">Data Bulan April 2025</h3>
            
            <!-- Search dan Dropdown -->
            <div class="flex justify-between my-4">
                <div class="flex items-center  border bg-white rounded-full w-64 flex-row h-9">
                    <span class="bi bi-search pl-5 pr-4"></span>
                    <input type="text" placeholder="Cari..." class="w-5/6 outline-none rounded-full">
                </div>
                <div class="flex gap-4">
                    <form class="flex gap-2" action="" method="get">
                        <div>
                            <label for="pilih_urutan" class="block text-sm font-medium text-gray-700 mb-1">Urutkan</label>
                            <select class="border border-black p-2 rounded-ful bg-white select2" id="pilih_urutan">
                                {{-- <option value="" disabled selected>Pilih Periode</option> --}}
                                <option value="" >Ascending</option>
                                <option value="" >Decending</option>
                            </select>
                        </div>
                        <div>
                            <label for="pilih_pasar" class="block text-sm font-medium text-gray-700 mb-1">Pilih Pasar</label>
                            <select class="border border-black p-2 rounded-full bg-white select2" id="pilih_pasar">
                                {{-- <option value="" disabled selected>Pilih Pasar</option> --}}
                                <option value="" selected>Pasar Tanjung</option>
                                @foreach ($markets as $market)
                                    <option value="{{ $market }}">{{ $market }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div>
                            <label for="pilih_periode" class="block text-sm font-medium text-gray-700 mb-1">Pilih periode</label>
                            <select class="border border-black p-2 rounded-full bg-white select2" id="pilih_periode">
                                {{-- <option value="" disabled selected>Pilih Periode</option> --}}
                                <option value="" disabled selected>April 2025</option>
                                @foreach ($periods as $period)
                                    <option value="{{ $period }}">{{ $period }}</option>
                                @endforeach
                            </select>
                        </div>
                    </form>
                </div>
            </div>
    
            <!-- Tabel -->
            @if (isset($data))
                <div class="overflow-x-auto">
                    <table class="table-auto">
                        <thead>
                            <tr>
                                <th rowspan="2" class="border px-5 py-2">No</th>
                                <th rowspan="2" class="border px-5 py-2">Aksi</th>
                                <th rowspan="2" class="border px-5 py-2 whitespace-nowrap">Jenis Bahan Pokok</th>
                                <th colspan="30" class="border px-5 py-2">Harga April 2025</th>
                            </tr>
                            <tr>
                                @for ($i = 1; $i <= $daysInMonth; $i++)
                                    <th class="border px-4 py-2">{{ $i }}</th>
                                @endfor
                            </tr>
                        </thead>
                        <tbody>
                            {{-- Edit Modal --}}
                            <div id="modal" class="fixed inset-0 bg-black bg-opacity-50 hidden justify-center items-center z-40">
                                <div class="bg-white p-6 rounded-lg w-[90%] max-w-2xl shadow-lg relative">
                                    <h2 class="text-xl font-semibold mb-4">Pilih Data untuk Diedit</h2>
                            
                                    <!-- Data List -->
                                    <div id="editDataList" class="space-y-4 max-h-96 overflow-y-auto mb-4">
                                        {{-- Diisi pake ajax --}}
                                    </div>
                            
                                    <!-- Tombol Tutup -->
                                    <div class="text-right" id="closeBtn">
                                        <button class="bg-red-500 hover:bg-red-600 text-white px-4 py-2 rounded">Tutup</button>
                                    </div>
                                </div>
                            </div>
                            
                            @foreach ($data as $item)
                                <tr class="border">
                                    <td class="border p-2">{{ $loop->iteration }}</td>
                                    <td class="p-2 flex justify-center gap-2">
                                        {{-- <a href="{{ route('disperindag.edit', $item['id']) }}">
                                            <button class="bg-yellow-400 text-center text-white rounded-md w-10 h-10">
                                                <i class="bi bi-pencil-square"></i>
                                            </button>
                                        </a> --}}
                                        <button
                                            class="editBtn bg-yellow-400 text-center text-white rounded-md w-10 h-10"
                                            data-bahan-pokok="{{ $item['jenis_bahan_pokok'] }}">
                                            <i class="bi bi-pencil-square"></i>
                                        </button>
                                    
                                        <button class="deleteBtn bg-red-500 text-center text-white rounded-md w-10 h-10" data-bahan-pokok="{{ $item['jenis_bahan_pokok'] }}">
                                            <i class="bi bi-trash-fill"></i>
                                        </button>
                                    </td>
                                    <td class="border p-2">{{ $item['jenis_bahan_pokok'] }}</td>
                                    
                                    @for ($kolom = 1; $kolom <= $daysInMonth; $kolom++)
                                        <td class="border px-4 py-2 text-center whitespace-nowrap">
                                            @if (isset($item['harga_per_tanggal'][$kolom]))
                                                Rp. {{ number_format($item['harga_per_tanggal'][$kolom], 0, ',', '.') }}
                                            @else
                                                -
                                            @endif
                                        </td>
                                    @endfor
                                </tr>
                                <script>
                                    $('#closeBtn').on('click', function() {
                                        $(this).closest('#modal').removeClass("flex").addClass("hidden");
                                    });
                                
                                    $('.editBtn').on('click', function() {
                                        const modal = $("#modal");
                                        modal.removeClass("hidden").addClass("flex");
                                
                                        const bahanPokok = $(this).data('bahan-pokok');
                                
                                        $.ajax({
                                            type: "GET",
                                            url: `/api/dpp/${bahanPokok}`,
                                            success: function(response) {
                                                const data = response.data;
                                                $('#editDataList').empty();
                                
                                                data.forEach(element => {
                                                    let listCard = `
                                                        <div class="border rounded-md p-4 shadow-sm flex items-center justify-between">
                                                            <div>
                                                                <p class="text-sm text-gray-500">Jenis Bahan Pokok: <span class="font-medium">${element.jenis_bahan_pokok}</span></p>
                                                                <p class="text-sm text-gray-500">Tanggal: <span class="font-medium">${element.tanggal_dibuat}</span></p>
                                                                <p class="text-sm text-gray-500">Harga: <span class="font-medium">Rp. ${element.kg_harga}</span></p>
                                                            </div>
                                                            <a href="/disperindag/${element.id}/edit" class="bg-yellow-500 text-white px-3 py-1 rounded text-sm hover:bg-yellow-600">Ubah</a>
                                                        </div>
                                                    `;
                                                    $('#editDataList').append(listCard);
                                                });
                                            },
                                            error: function(xhr) {
                                                console.log(xhr.responseText);
                                            }
                                        });
                                    });
                                
                                    $('.deleteBtn').on('click', function() {
                                        const modal = $("#modal");
                                        modal.removeClass("hidden").addClass("flex");
                                
                                        const bahanPokok = $(this).data('bahan-pokok');
                                
                                        $.ajax({
                                            type: "GET",
                                            url: `/api/dpp/${bahanPokok}`,
                                            success: function(response) {
                                                const data = response.data;
                                                $('#editDataList').empty();
                                
                                                data.forEach(element => {
                                                    let listCard = `
                                                        <div class="border rounded-md p-4 shadow-sm flex items-center justify-between">
                                                            <div>
                                                                <p class="text-sm text-gray-500">Jenis Bahan Pokok: <span class="font-medium">${element.jenis_bahan_pokok}</span></p>
                                                                <p class="text-sm text-gray-500">Tanggal: <span class="font-medium">${element.tanggal_dibuat}</span></p>
                                                                <p class="text-sm text-gray-500">Harga: <span class="font-medium">Rp. ${element.kg_harga}</span></p>
                                                            </div>
                                                            
                                                            <button data-id="${element.id}" class="btnConfirm bg-red-500 text-white px-3 py-1 rounded text-sm hover:bg-red-600">Hapus</button>
                                                        </div>
                                                    `;
                                                    $('#editDataList').append(listCard);
                                                });
                                            },
                                            error: function(xhr) {
                                                console.log(xhr.responseText);
                                            }
                                        });
                                    });
                                </script>
                                
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @else
            <div class="flex items-center justify-center h-64">
                <div class="text-center p-4 border-2 border-dashed border-gray-300 rounded-lg shadow-md bg-gray-50">
                    <h3 class="text-lg font-semibold text-gray-500">Data Not Found</h3>
                    <p class="text-gray-400">We couldn't find any data matching your request. Please try again later.</p>
                </div>
            </div>
            @endif
    
            <!-- Button Kembali & Tambah Data -->
        </div>
        <div class="flex justify-between mt-4">
            <a href="{{ route('disperindag.index') }}">
            <button class="bg-green-700 text-white px-6 py-2 rounded-full hover:bg-green-800">Kembali</button>
            </a>
        </div>

        {{-- Modal Delete --}}
        <div id="deleteModal" class="hidden w-full h-full">
            <div class="fixed inset-0 bg-black bg-opacity-50 flex justify-center items-center z-40">
                <div class="bg-white p-6 rounded-lg w-[25%] max-w-2xl shadow-lg relative">
                    <h2 class="text-xl font-semibold mb-8 text-center">Yakin menghapus data?</h2>

                    <div class="flex justify-evenly">
                        <!-- Tombol Batal -->
                        <div class="text-right">
                            <button class="bg-green-800 hover:bg-green-900 text-white px-4 py-2 rounded-full" id="closeBtn">Tutup</button>
                        </div>
                        <!-- Tombol Yakin -->
                        <div class="text-right">
                            <button class="bg-green-800 hover:bg-green-900 text-white px-4 py-2 rounded-full" id="yesBtn">Yakin</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>  
</x-admin-layout>

<script>
    $(document).on('click', '.btnConfirm', function() { 
        let dataId = $(this).data('id');
        $('#deleteModal').show();

        $('#yesBtn').off('click').on('click', function() {
            $.ajax({
                type: 'DELETE',
                url: `/api/dpp/${dataId}`,
                success: function(data) {
                    Swal.fire({
                        title: 'Berhasil!',
                        text: `Data ${data.data.jenis_bahan_pokok} telah dihapus.`,
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

            $('#deleteModal').hide();
        });
    });

    $(document).on('click', '#closeBtn', function() {
        $('#deleteModal').hide();  
    });



    
    $(document).ready(function() {

        // Filter Value
        $('#pilih_pasar').on('change', function() {
            $('#pilih_periode').removeAttr('disabled');
        });

        $('#pilih_periode').on('change', function() {
            let pasar = $('#pilih_pasar').val();
            let periode = $('#pilih_periode').val();

            console.log(pasar);
            console.log(periode);
        });
    });
</script>