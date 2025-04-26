<x-pegawai-layout>
    <main class="flex-1 p-6 max-md:p-4">
        {{-- <h2 class="text-2xl font-semibold text-green-900 mb-4 max-md:mb-10 max-md:text-xl max-md:text-center">{{ $title }}</h2> --}}
        <div class="w-full flex justify-between">  
            <!-- Search bar -->
            <x-search></x-search>
            
            {{-- Filter --}}
            <x-filter></x-filter>
        </div>

        <main class="flex-1 p-6 max-md:p-4 bg-gray-10 border-gray-20 border-[3px] rounded-[20px]">
            <div class="w-full flex items-center gap-2 mb-4">
                <a href="{{ route('pegawai.dtphp.produksi') }}" class="text-decoration-none text-dark flex-shrink-0">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="4" stroke="currentColor" class="w-6 h-6">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 19.5L8.25 12l7.5-7.5" />
                    </svg>                      
                </a>
                <h3 class="text-xl font-extrabold text-center max-md:text-base">Volume Produksi</h3>
            </div>

            <!-- Tombol Switch Produksi / Panen -->
           <div class="flex w-auto ">
            <a href="{{ route('dtphp.detail.produksi') }}">
                <button class="text-pink-500 rounded-t-xl bg-white px-4 py-3 shadow-md text-sm border bg-gray-10 border-gray-20 {{ request()->routeIs('dtphp.detail.produksi') ? 'font-bold' : '' }} max-md:text-xs max-md:px-3 max-md:py-2 max-md:left-2">
                    Volume Produksi
                </button>
            </a>
            <a href="{{ route('dtphp.detail.panen') }}">
                <button class="text-gray-400 rounded-t-xl bg-gray-100 px-4 py-3 shadow-md text-sm border bg-gray-10 border-gray-20 {{ request()->routeIs('dtphp.detail.panen') ? 'font-bold' : '' }} max-md:text-xs max-md:px-3 max-md:py-2 ">
                    Luas Panen
                </button>
            </a>
        </div>

        <div class="bg-white p-6 max-md:p-4 rounded shadow-md  relative z-10 border bg-gray-10 border-gray-20"> 
            <!-- Tabel -->
            @if (isset($data_produksi))
                <div class="overflow-x-auto max-md:overflow-x-scroll">
                    <table class="table-auto w-full">
                        <thead>
                            <tr class="bg-gray-50">
                                <th rowspan="2" class="border px-9 max-md:px-2 py-2 whitespace-nowrap text-sm max-md:text-xs">Jenis Komoditas</th>
                                <th colspan="12" class="border px-5 max-md:px-1 py-2 text-sm max-md:text-xs">Tahun 2025</th>
                                <th rowspan="2" class="border px-5 max-md:px-1 py-2 text-sm max-md:text-xs">Total</th>
                                <th rowspan="2" class="border px-5 max-md:px-1 py-2 text-sm max-md:text-xs">Aksi</th>
                            </tr>
                            <tr class="bg-gray-50">
                                @php
                                    $namaBulan = [
                                        1 => 'Jan', 2 => 'Feb', 3 => 'Mar', 4 => 'Apr',
                                        5 => 'Mei', 6 => 'Jun', 7 => 'Jul', 8 => 'Agu',
                                        9 => 'Sep', 10 => 'Okt', 11 => 'Nov', 12 => 'Des'
                                    ];
                                @endphp
                                @foreach ($namaBulan as $bulan)
                                    <th class="border px-4 max-md:px-1 py-2 text-center whitespace-nowrap text-sm max-md:text-xs">{{ $bulan }}</th>
                                @endforeach
                            </tr>
                        </thead>
                        <tbody>
                            {{-- Edit Modal --}}
                            <div id="modal" class="fixed inset-0 bg-black bg-opacity-50 hidden justify-center items-center z-50">
                                <div class="bg-white p-6 rounded-lg w-[90%] max-w-2xl shadow-lg relative max-md:p-4">
                                    <h2 class="text-xl font-semibold mb-4 max-md:text-lg">Pilih Data untuk Diedit</h2>
                            
                                    <div id="editDataList" class="space-y-4 max-h-96 overflow-y-auto mb-4 max-md:max-h-64">
                                        {{-- Diisi pake ajax --}}
                                    </div>
                            
                                    <div class="text-right" id="closeBtn">
                                        <button class="bg-red-500 hover:bg-red-600 text-white px-4 py-2 rounded max-md:text-sm">Tutup</button>
                                    </div>
                                </div>
                            </div>
                            
                            @foreach ($data_produksi as $item)
                                <tr class="border hover:bg-gray-50">
                                    <td class="border p-2 max-md:p-1 text-sm max-md:text-xs">{{ $item['jenis_komoditas'] }}</td>
                                    
                                    @for ($bulan = 1; $bulan <= 12; $bulan++)
                                    <td class="border px-5 max-md:px-1 py-2 text-center whitespace-nowrap text-sm max-md:text-xs">
                                        @if (isset($item['produksi_per_bulan'][$bulan]))
                                            {{ number_format($item['produksi_per_bulan'][$bulan], 1, ',', '.') }}
                                        @else
                                            -
                                        @endif
                                    </td>
                                    @endfor

                                    <td class="border px-8 max-md:px-2 py-2 text-center font-semibold whitespace-nowrap text-sm max-md:text-xs">
                                        {{ number_format(array_sum($item['produksi_per_bulan'] ?? []), 1, ',', '.') }}
                                    </td>

                                    <td class="p-2 max-md:p-1 flex justify-center gap-2 whitespace-nowrap">
                                        <button class="editBtn bg-yellow-400 text-center text-white rounded-md w-10 h-10 max-md:w-8 max-md:h-8" data-komoditas="{{ $item['jenis_komoditas'] }}">
                                            <i class="bi bi-pencil-square text-sm max-md:text-xs"></i>
                                        </button>
                                    
                                        <button class="deleteBtn bg-red-500 text-center text-white rounded-md w-10 h-10 max-md:w-8 max-md:h-8" data-komoditas="{{ $item['jenis_komoditas'] }}">
                                            <i class="bi bi-trash-fill text-sm max-md:text-xs"></i>
                                        </button>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @else
            <div class="flex items-center justify-center h-64">
                <div class="text-center p-4 border-2 border-dashed border-gray-300 rounded-lg shadow-md bg-gray-50 max-md:p-3">
                    <h3 class="text-lg font-semibold text-gray-500 max-md:text-base">Data Not Found</h3>
                    <p class="text-gray-400 max-md:text-sm">We couldn't find any data matching your request.</p>
                </div>
            </div>
            @endif
        </div>

        {{-- Modal Delete --}}
        <div id="deleteModal" class="hidden fixed inset-0 bg-black bg-opacity-50 justify-center items-center z-50">
            <div class="bg-white p-6 rounded-lg w-[90%] max-w-md shadow-lg relative max-md:p-4">
                <h2 class="text-xl font-semibold mb-8 text-center max-md:text-lg">Yakin menghapus data?</h2>
                <div class="flex justify-evenly">
                    <div class="text-right">
                        <button class="bg-green-800 hover:bg-green-900 text-white px-4 py-2 rounded-full max-md:text-sm" id="closeBtn">Tutup</button>
                    </div>
                    <div class="text-right">
                        <button class="bg-green-800 hover:bg-green-900 text-white px-4 py-2 rounded-full max-md:text-sm" id="yesBtn">Yakin</button>
                    </div>
                </div>
            </div>
        </div>
    </main> 
</x-pegawai-layout>

<script>
    $(document).ready(function() {
        $('.select2').select2({
            width: '100%'
        });

        $('#pilih_komoditas').on('change', function() {
            $('#pilih_periode').prop('disabled', false);
        });

        $('#closeBtn').on('click', function() {
            $('#modal').removeClass("flex").addClass("hidden");
        });
    
        $('.editBtn').on('click', function() {
            const modal = $("#modal");
            modal.removeClass("hidden").addClass("flex");
    
            const jenisKomoditas = $(this).data('komoditas');
    
            $.ajax({
                type: "GET",
                url: `/api/dtphp/${jenisKomoditas}`,
                success: function(response) {
                    const data = response.data;
                    $('#editDataList').empty();
    
                    data.forEach(element => {
                        let listCard = `
                            <div class="border rounded-md p-4 shadow-sm flex items-center justify-between max-md:flex-col max-md:items-start max-md:gap-2">
                                <div class="max-md:w-full">
                                    <p class="text-sm text-gray-500 max-md:text-xs">Jenis Komoditas: <span class="font-medium">${element.jenis_komoditas}</span></p>
                                    <p class="text-sm text-gray-500 max-md:text-xs">Volume Produksi: <span class="font-medium">${element.ton_volume_produksi} ton</span></p>
                                    <p class="text-sm text-gray-500 max-md:text-xs">Tanggal: <span class="font-medium">${element.tanggal_input}</span></p>
                                </div>
                                <a href="dtphp/${element.id}/edit" class="bg-yellow-500 text-white px-3 py-1 rounded text-sm hover:bg-yellow-600 max-md:w-full max-md:text-center max-md:text-xs">Ubah</a>
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
            const modal = $("#deleteModal");
            modal.removeClass("hidden").addClass("flex");
    
            const jenisKomoditas = $(this).data('komoditas');
    
            $.ajax({
                type: "GET",
                url: `/api/dtphp/${jenisKomoditas}`,
                success: function(response) {
                    const data = response.data;
                    $('#editDataList').empty();
    
                    data.forEach(element => {
                        let listCard = `
                            <div class="border rounded-md p-4 shadow-sm flex items-center justify-between max-md:flex-col max-md:items-start max-md:gap-2">
                                <div class="max-md:w-full">
                                    <p class="text-sm text-gray-500 max-md:text-xs">Jenis Komoditas: <span class="font-medium">${element.jenis_komoditas}</span></p>
                                    <p class="text-sm text-gray-500 max-md:text-xs">Volume Produksi: <span class="font-medium">${element.ton_volume_produksi} ton</span></p>
                                    <p class="text-sm text-gray-500 max-md:text-xs">Tanggal: <span class="font-medium">${element.tanggal_input}</span></p>
                                </div>
                                <button data-id="${element.id}" class="btnConfirm bg-red-500 text-white px-3 py-1 rounded text-sm hover:bg-red-600 max-md:w-full max-md:text-center max-md:text-xs">Hapus</button>
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

        $(document).on('click', '.btnConfirm', function() { 
            let dataId = $(this).data('id');
            
            $('#yesBtn').off('click').on('click', function() {
                $.ajax({
                    type: 'DELETE',
                    url: `/api/dtphp/${dataId}`,
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
                $('#deleteModal').hide();
            });
        });

        $(document).on('click', '#closeBtn', function() {
            $('#deleteModal').hide();  
        });
    });
</script>