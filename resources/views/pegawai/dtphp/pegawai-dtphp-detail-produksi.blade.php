<x-pegawai-layout>
    <div class="w-full flex flex-col md:flex-row justify-between items-start md:items-center gap-4">  
        <!-- Search bar -->
        <x-search />
    
        <!-- Filter -->
        <div class="flex justify-end w-full md:w-auto">
            <div class="relative w-full md:w-auto">
                <x-filter />
    
                <!-- Modal Background -->
                <x-filter-modal>
                    <form action="" method="get">
                        <div class="space-y-4">
                            <!-- Pilih komoditas -->
                            <div class="flex flex-col">
                                <label for="pilih_komoditas" class="block text-sm font-medium text-gray-700 mb-1 max-md:text-xs">Pilih Komoditas</label>
                                <select class="select2 w-full rounded border border-gray-300 p-2 max-md:p-1 bg-white text-sm max-md:text-xs" id="pilih_komoditas">
                                    <option value="" selected>Suket Teki</option>
                                    @foreach ($commodities as $commodity)
                                        <option value="{{ $commodity }}">{{ $commodity }}</option>
                                    @endforeach
                                </select>
                            </div>

                            <!-- Pilih periode -->
                            <div class="flex flex-col">
                                <label for="pilih_periode" class="block text-sm font-medium text-gray-700 mb-1 max-md:text-xs">Pilih Periode</label>
                                <select class="select2 w-full rounded border border-gray-300 p-2 max-md:p-1 bg-white text-sm max-md:text-xs" disabled id="pilih_periode">
                                    <option value="" disabled selected>April 2025</option>
                                    @foreach ($periods as $period)
                                        <option value="{{ $period }}">{{ $period }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        <div class="w-full flex justify-end gap-3 mt-6">
                            <button type="reset" class="bg-yellow-550 text-white rounded-lg w-20 p-2 text-sm">Reset</button>
                            <button type="submit" class="bg-pink-650 text-white rounded-lg w-20 p-2 text-sm">Cari</button>
                        </div>
                    </form>
                </x-filter-modal> 
            </div> 
        </div>
    </div>
    
    <main class="flex-1 p-6 max-md:p-4 bg-gray-10 border-gray-20 border-[3px] rounded-[20px] mt-4">
        <div class="w-full flex items-center gap-2 mb-4">
            <a href="{{ route('pegawai.dtphp.produksi') }}" class="text-dark flex-shrink-0">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="4" stroke="currentColor" class="w-6 h-6">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 19.5L8.25 12l7.5-7.5" />
                </svg>                      
            </a>
            <h3 class="text-xl font-extrabold text-center max-md:text-base">Volume Produksi</h3>
        </div>
    
        <!-- Tombol Switch -->
        <div class="flex w-full overflow-x-auto">
            <a href="{{ route('pegawai.dtphp.detail.produksi') }}">
                <button class="text-pink-500 rounded-t-xl bg-white px-4 py-3 shadow-md text-sm border bg-gray-10 border-gray-20 {{ request()->routeIs('dtphp.detail.produksi') ? 'font-bold' : '' }} max-md:text-xs max-md:px-3 max-md:py-2">
                    Volume Produksi
                </button>
            </a>
            <a href="{{ route('pegawai.dtphp.detail.panen') }}">
                <button class="text-gray-400 rounded-t-xl bg-gray-100 px-4 py-3 shadow-md text-sm border bg-gray-10 border-gray-20 {{ request()->routeIs('dtphp.detail.panen') ? 'font-bold' : '' }} max-md:text-xs max-md:px-3 max-md:py-2">
                    Luas Panen
                </button>
            </a>
        </div>
    
        <div class="bg-white p-6 max-md:p-4 rounded shadow-md relative z-10 border bg-gray-10 border-gray-20 overflow-x-auto">
            @if (isset($data_produksi))
                <div class="w-full overflow-x-auto">
                    <table class="table-auto w-full text-sm max-md:text-xs">
                        <thead>
                            <tr>
                                <th class="px-4 py-2 whitespace-nowrap">Jenis Komoditas</th>
                                @php
                                    $namaBulan = [
                                        1 => 'Jan', 2 => 'Feb', 3 => 'Mar', 4 => 'Apr',
                                        5 => 'Mei', 6 => 'Jun', 7 => 'Jul', 8 => 'Agu',
                                        9 => 'Sep', 10 => 'Okt', 11 => 'Nov', 12 => 'Des'
                                    ];
                                @endphp
                                @foreach ($namaBulan as $bulan)
                                    <th class="px-4 py-2 text-center whitespace-nowrap">{{ $bulan }}</th>
                                @endforeach
                                <th class="px-4 py-2 whitespace-nowrap">Total</th>
                                <th class="px-4 py-2 whitespace-nowrap">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($data_produksi as $item)
                                <tr class="border-b hover:bg-gray-50">
                                    <td class="px-4 py-2 text-center">{{ $item['jenis_komoditas'] }}</td>
    
                                    @for ($bulan = 1; $bulan <= 12; $bulan++)
                                        <td class="px-4 py-2 text-center">
                                            @if (isset($item['produksi_per_bulan'][$bulan]))
                                                {{ number_format($item['produksi_per_bulan'][$bulan], 1, ',', '.') }}
                                            @else
                                                -
                                            @endif
                                        </td>
                                    @endfor
    
                                    <td class="px-4 py-2 text-center font-semibold">
                                        {{ number_format(array_sum($item['produksi_per_bulan'] ?? []), 1, ',', '.') }}
                                    </td>
    
                                    <td class="px-4 py-2 flex justify-center gap-2">
                                        <button class="editBtn bg-yellow-400 text-white rounded-md w-10 h-10" data-komoditas="{{ $item['jenis_komoditas'] }}">
                                            <i class="bi bi-pencil-square text-sm"></i>
                                        </button>
    
                                        <button class="deleteBtn bg-red-500 text-white rounded-md w-10 h-10" data-komoditas="{{ $item['jenis_komoditas'] }}">
                                            <i class="bi bi-trash-fill text-sm"></i>
                                        </button>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>

                    {{-- Modal --}}
                    <div id="modal" class="fixed inset-0 bg-black bg-opacity-50 hidden justify-center items-center z-40">
                        <div class="bg-white p-6 rounded-lg w-[90%] max-w-2xl shadow-lg relative">
                            <h2 class="text-xl font-semibold mb-4">Pilih Data untuk Di<span id="actionPlaceholder"></span></h2>
                            <div id="editDataList" class="space-y-4 max-h-96 overflow-y-auto mb-4"></div>
                            <div class="text-right" id="closeListModal">
                                <button class="bg-red-500 hover:bg-red-600 text-white px-4 py-2 rounded">Tutup</button>
                            </div>
                        </div>
                    </div>
                    
                    {{-- Modal Delete --}}
                    <div id="deleteModal" class="hidden w-full h-full">
                        <div class="fixed inset-0 bg-black bg-opacity-50 flex justify-center items-center z-40">
                            <div class="bg-white p-6 rounded-lg w-[25%] max-w-2xl shadow-lg relative">
                                <h2 class="text-xl font-semibold mb-6 text-center">Yakin menghapus data?</h2>
                                <div class="flex justify-around">
                                    <button class="bg-pink-500 hover:bg-pink-400 text-white px-4 py-2 rounded-full" id="closeBtn">Tutup</button>
                                    <button class="bg-pink-500 hover:bg-pink-400 text-white px-4 py-2 rounded-full" id="yesBtn">Yakin</button>
                                </div>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>
            @else
                <div class="flex items-center justify-center h-64">
                    <div class="text-center p-4 border-2 border-dashed border-gray-300 rounded-lg shadow-md bg-gray-50">
                        <h3 class="text-lg font-semibold text-gray-500 max-md:text-base">Data Not Found</h3>
                        <p class="text-gray-400 max-md:text-sm">We couldn't find any data matching your request.</p>
                    </div>
                </div>
            @endif
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
    });

    $('#closeListModal').on('click', function() {
        $(this).closest('#modal').removeClass("flex").addClass("hidden");
    });
                                        
    $(document).on('click', '.btnConfirm', function() { 
        let dataId = $(this).data('id');
        $('#deleteModal').show();

        $('#yesBtn').off('click').on('click', function() {
            $.ajax({
                type: 'DELETE',
                url: `/api/dtphp/${dataId}`,
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

</script>