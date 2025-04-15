{{-- @dd($data) --}}

<x-admin-layout>
    <main class="flex-1 p-6">
        <h2 class="text-2xl font-semibold text-green-900">{{ $title }}</h2>
    
        <div class="bg-white p-6 rounded shadow-md mt-4">
            <h3 class="text-lg font-semibold text-center">Data Volume Produksi Ikan Tahun 2025</h3>
            
            <!-- Search dan Dropdown -->
            <div class="flex justify-between my-4">
                <div class="flex items-center  border bg-white rounded-full w-64 flex-row h-9">
                    <span class="bi bi-search pl-5 pr-4"></span>
                    <input type="text" placeholder="Cari..." class="w-5/6 outline-none rounded-full">
                </div>
                <div class="flex gap-4">
                    <form class="flex gap-4" action="" method="get">
                        <div>
                            <label for="pilih_urutan" class="block text-sm font-medium text-gray-700 mb-1">Pilih Urutan</label>
                            <select class="border p-2 rounded bg-white select2" id="pilih_urutan">
                                {{-- <option value="" disabled selected>Pilih Ikan</option> --}}
                                <option value="" selected>Ascending</option>
                                {{-- @foreach ($fishes as $fish)
                                    <option value="{{ $fish }}">{{ $fish }}</option>
                                @endforeach --}}
                            </select>
                        </div>

                        <div>
                            <label for="pilih_ikan" class="block text-sm font-medium text-gray-700 mb-1">Pilih Ikan</label>
                            <select class="border p-2 rounded bg-white select2" id="pilih_ikan">
                                {{-- <option value="" disabled selected>Pilih Ikan</option> --}}
                                <option value="" selected>Teri</option>
                                @foreach ($fishes as $fish)
                                    <option value="{{ $fish }}">{{ $fish }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div>
                            <label for="pilih_periode" class="block text-sm font-medium text-gray-700 mb-1">Pilih Periode</label>
                            <select class="border p-2 rounded bg-white select2" id="pilih_periode">
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
                                <th rowspan="2" class="border px-16 py-2 whitespace-nowrap">Jenis Ikan</th>
                                <th colspan="12" class="border px-5 py-2">Produksi</th>
                                <th rowspan="2" class="border px-5 py-2">Aksi</th>
                            </tr>
                            <tr>
                                {{-- @for ($i = 1; $i <= $daysInMonth; $i++)
                                    <th class="border px-4 py-2">{{ $i }}</th>
                                @endfor --}}
                                
                                @php
                                    $namaBulan = [
                                        1 => 'Jan', 2 => 'Feb', 3 => 'Mar', 4 => 'Apr',
                                        5 => 'Mei', 6 => 'Jun', 7 => 'Jul', 8 => 'Agu',
                                        9 => 'Sep', 10 => 'Okt', 11 => 'Nov', 12 => 'Des'
                                    ];
                                @endphp
                                
                                @foreach ($namaBulan as $bulan)
                                    <th class="border px-4 py-2 text-center whitespace-nowrap">{{ $bulan }}</th>
                                @endforeach
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
                                    <td class="border p-2">{{ $item['jenis_ikan'] }}</td>
                                    
                                    {{-- per hari --}}
                                    {{-- @for ($kolom = 1; $kolom <= $daysInMonth; $kolom++)
                                    <td class="border px-4 py-2 text-center whitespace-nowrap">
                                        @if (isset($item['produksi_per_tanggal'][$kolom]))
                                        {{ number_format($item['produksi_per_tanggal'][$kolom], 0, ',', '.') }}
                                        @else
                                        -
                                        @endif
                                    </td>
                                    @endfor --}}

                                    {{-- per bulan --}}
                                    @for ($bulan = 1; $bulan <= 12; $bulan++)
                                    <td class="border px-8 py-2 text-center whitespace-nowrap">
                                        @if (isset($item['produksi_per_bulan'][$bulan]))
                                            {{ number_format($item['produksi_per_bulan'][$bulan], 0, ',', '.') }}
                                        @else
                                            -
                                        @endif
                                    </td>
                                    @endfor

                                    <td class="p-2 flex justify-center gap-2 whitespace-nowrap">
                                        {{-- <a href="{{ route('perikanan.edit', $item['id']) }}">
                                            <button class="bg-yellow-400 text-center text-white rounded-md w-10 h-10">
                                                <i class="bi bi-pencil-square"></i>
                                            </button>
                                        </a> --}}
                                        <button
                                            class="editBtn bg-yellow-400 text-center text-white rounded-md w-10 h-10"
                                            data-ikan="{{ $item['jenis_ikan'] }}">
                                            <i class="bi bi-pencil-square"></i>
                                        </button>
                                    
                                        <button class="deleteBtn bg-red-500 text-center text-white rounded-md w-10 h-10" data-ikan="{{ $item['jenis_ikan'] }}">
                                            <i class="bi bi-trash-fill"></i>
                                        </button>
                                    </td>
                                </tr>
                                <script>
                                    $('#closeBtn').on('click', function() {
                                        $(this).closest('#modal').removeClass("flex").addClass("hidden");
                                    });
                                
                                    $('.editBtn').on('click', function() {
                                        const modal = $("#modal");
                                        modal.removeClass("hidden").addClass("flex");
                                
                                        const jenisIkan = $(this).data('ikan');
                                
                                        $.ajax({
                                            type: "GET",
                                            url: `api/dp/${jenisIkan}`,
                                            success: function(response) {
                                                const data = response.data;
                                                $('#editDataList').empty();
                                
                                                data.forEach(element => {
                                                    let listCard = `
                                                        <div class="border rounded-md p-4 shadow-sm flex items-center justify-between">
                                                            <div>
                                                                <p class="text-sm text-gray-500">Jenis Ikan: <span class="font-medium">${element.jenis_ikan}</span></p>
                                                                <p class="text-sm text-gray-500">Produksi: <span class="font-medium">${element.ton_produksi}</span></p>
                                                                <p class="text-sm text-gray-500">Tanggal: <span class="font-medium">${element.tanggal_input}</span></p>
                                                            </div>
                                                            <a href="perikanan/${element.id}/edit" class="bg-yellow-500 text-white px-3 py-1 rounded text-sm hover:bg-yellow-600">Ubah</a>
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
                                
                                        const jenisIkan = $(this).data('ikan');
                                
                                        $.ajax({
                                            type: "GET",
                                            url: `api/dp/${jenisIkan}`,
                                            success: function(response) {
                                                const data = response.data;
                                                $('#editDataList').empty();
                                
                                                data.forEach(element => {
                                                    let listCard = `
                                                        <div class="border rounded-md p-4 shadow-sm flex items-center justify-between">
                                                            <div>
                                                                <p class="text-sm text-gray-500">Jenis Ikan: <span class="font-medium">${element.jenis_ikan}</span></p>
                                                                <p class="text-sm text-gray-500">Produksi: <span class="font-medium">${element.ton_produksi}</span></p>
                                                                <p class="text-sm text-gray-500">Tanggal: <span class="font-medium">${element.tanggal_input}</span></p>
                                                                
                                                            </div>
                                                            
                                                            <button data-id="${element.id}" class="btnConfirm btnDelete bg-red-500 text-white px-3 py-1 rounded text-sm hover:bg-red-600">Hapus</button>
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

                            @php
                            $totalPerBulan = [];
                            foreach ($data as $item) {
                                for ($bulan = 1; $bulan <= 12; $bulan++) {
                                    if (isset($item['produksi_per_bulan'][$bulan])) {
                                        if (!isset($totalPerBulan[$bulan])) {
                                            $totalPerBulan[$bulan] = 0;
                                        }
                                        $totalPerBulan[$bulan] += $item['produksi_per_bulan'][$bulan];
                                    }
                                }
                            }
                        @endphp
                        
                        <tr class="border font-bold">
                            <td class="border p-2">Jumlah</td>
                            @for ($bulan = 1; $bulan <= 12; $bulan++)
                                <td class="border px-8 py-2 text-center whitespace-nowrap">
                                    {{ isset($totalPerBulan[$bulan]) ? number_format($totalPerBulan[$bulan], 0, ',', '.') : '-' }}
                                </td>
                            @endfor
                            <td class="border p-2"></td>
                        </tr>
                        
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
    
        </div>
    </main> 

    <!-- Button Kembali & Tambah Data -->
    <div class="flex justify-between mt-4">
        <a href="{{ route('perikanan.index') }}">
        <button class="bg-green-700 text-white px-6 py-2 rounded hover:bg-green-800">Kembali</button>
        </a>
        <a href="{{ route('perikanan.create') }}">
        <button class="bg-green-700 text-white px-6 py-2 rounded hover:bg-green-800">Tambah Data</button>
        </a>
    </div>

</x-admin-layout>

<script>
    $(document).on('click', '.btnConfirm', function(e) {
        const confirmed = confirm('Yakin ingin mengubah data ini?');
        if (!confirmed) {
            e.preventDefault();
            return;
        }

        let dataId = $(this).data('id');

        $.ajax({
            type: 'DELETE',
            url: `/api/dp/${dataId}`,
            success: function() {
                window.location.reload();
            },
            error: function(xhr) {
                console.log(xhr.responseText);
            }
        });
    });

    
    $(document).ready(function() {
        $('.select2').select2();

        // Filter Value
        $('#pilih_ikan').on('change', function() {
            $('#pilih_periode').removeAttr('disabled');
        });

        $('#pilih_periode').on('change', function() {
            let pasar = $('#pilih_ikan').val();
            let periode = $('#pilih_periode').val();

            console.log(pasar);
            console.log(periode);
        });
    });
</script>