<x-pegawai-layout title="Detail Data Panen">

    <!-- Search dan Filter -->
<div class="flex justify-between my-4 max-md:flex-col max-md:gap-4">
<!-- Search Component -->
<x-search>Cari tanaman...</x-search>

<!-- Filter Component -->
<div class="flex justify-end">
<div class="relative flex justify-end">
    <x-filter></x-filter>

    <!-- Filter Modal -->
    <x-filter-modal>
        <form action="" method="get">
            <div class="space-y-4">
                <!-- Pilih urutan -->
                <div class="flex flex-col">
                    <label for="pilih_urutan" class="block text-sm font-medium text-gray-700 mb-1">Pilih Urutan</label>
                    <select name="order" class="w-full border border-gray-300 p-2 rounded-full bg-white shadow-sm focus:ring-2 focus:ring-green-500 focus:border-green-500 transition-colors">
                        <option value="asc" {{ request('order') == 'asc' ? 'selected' : '' }}>A - Z</option>
                        <option value="desc" {{ request('order') == 'desc' ? 'selected' : '' }}>Z - A</option>
                    </select>
                </div>
        
                <!-- Pilih Tanaman -->
                <div class="flex flex-col">
                    <label for="pilih_tanaman" class="block text-sm font-medium text-gray-700 mb-1">Pilih Tanaman</label>
                    <select name="tanaman" id="pilih_tanaman" class="w-full border border-gray-300 p-2 rounded-full bg-white shadow-sm focus:ring-2 focus:ring-green-500 focus:border-green-500 transition-colors">
                        <option value="">Semua Tanaman</option>
                        @foreach ($commodities as $commodity)
                            <option value="{{ $commodity->id }}" {{ request('tanaman') == $commodity->id ? 'selected' : '' }}>
                                {{ $commodity->nama_tanaman }}
                            </option>
                        @endforeach
                    </select>
                </div>
        
                <!-- Pilih periode -->
                <div class="flex flex-col">
                    <label for="pilih_periode" class="block text-sm font-medium text-gray-700 mb-1">Pilih Periode</label>
                    <select name="periode" id="pilih_periode" class="w-full border border-gray-300 p-2 rounded-full bg-white shadow-sm focus:ring-2 focus:ring-green-500 focus:border-green-500 transition-colors">
                        <option value="" disabled selected>Pilih Periode</option>
                        @foreach ($periods as $index => $period)
                            <option value="{{ $numberPeriods[$index] }}"
                                {{ request('periode') == $numberPeriods[$index] ? 'selected' : '' }}>
                                {{ $period }}
                            </option>
                        @endforeach
                    </select>
                </div>
            </div>
        
            <div class="w-full flex justify-end gap-3 mt-10">
                <a href="{{ route('pegawai.dtphp.detail.produksi') }}" class="bg-yellow-550 text-white rounded-lg w-20 p-1 text-center">Reset</a>
                <button type="submit" class="bg-pink-650 text-white rounded-lg w-20 p-1">Cari</button>
            </div>
        </form>
    </x-filter-modal>
</div>
</div>
</div>

<!-- Main Content -->
<main class="flex-1 p-6 max-md:p-4 bg-gray-10 border-gray-20 border-[3px] rounded-[20px]">

<!-- Back Button & Title -->
<div class="flex items-center gap-2 mb-4">
<a href="{{ route('pegawai.dtphp.panen') }}" class="flex-shrink-0">
    <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke-width="4" stroke="currentColor">
        <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 19.5L8.25 12l7.5-7.5" />
    </svg>
</a>
<h3 class="text-lg font-semibold max-md:text-base text-center">Data Luas Panen Tahun 2025 (Hektar)</h3>
</div>

<!-- Switch Button -->
<div class="flex w-auto ">
<a href="{{ route('pegawai.dtphp.detail.produksi') }}">
    <button class="text-gray-400 rounded-t-xl bg-gray-100 px-4 py-3 shadow-md text-sm border bg-gray-10 border-gray-20 {{ request()->routeIs('pegawai.dtphp.detail.produksi') ? 'font-bold' : '' }} max-md:text-xs max-md:px-3 max-md:py-2">
        Volume Produksi
    </button>
</a>
<a href="{{ route('pegawai.dtphp.detail.panen') }}">
    <button class="text-pink-500 rounded-t-xl bg-white px-4 py-3 shadow-md text-sm border bg-gray-10 border-gray-20 {{ request()->routeIs('pegawai.dtphp.detail.panen') ? 'font-bold' : '' }} max-md:text-xs max-md:px-3 max-md:py-2">
        Luas Panen
    </button>
</a>
</div>

<!-- Table or Data Empty -->
<div class="bg-white p-6 max-md:p-4 rounded shadow-md border bg-gray-10 border-gray-20">
@if (isset($data_panen))
    <div class="overflow-x-auto">
        <table class="table-auto w-full">
            <thead>
                <tr>
                    <th class="px-10 py-2 text-sm text-center max-md:px-2 max-md:text-xs">Jenis Tanaman</th>
                    @php
                        $namaBulan = [1 => 'Jan', 2 => 'Feb', 3 => 'Mar', 4 => 'Apr', 5 => 'Mei', 6 => 'Jun', 7 => 'Jul', 8 => 'Agu', 9 => 'Sep', 10 => 'Okt', 11 => 'Nov', 12 => 'Des'];
                    @endphp
                    @foreach ($namaBulan as $bulan)
                        <th class="px-4 py-2 text-sm text-center max-md:px-1 max-md:text-xs">{{ $bulan }}</th>
                    @endforeach
                    <th class="px-5 py-2 text-sm max-md:px-1 max-md:text-xs">Total</th>
                    <th class="px-5 py-2 text-sm max-md:px-1 max-md:text-xs">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($data_panen as $item)
                    <tr>
                        <td class="border-b p-2 text-center text-sm max-md:p-1 max-md:text-xs">{{ $item['nama_tanaman'] }}</td>
                        @for ($bulan = 1; $bulan <= 12; $bulan++)
                            <td class="border-b px-4 py-2 text-center text-sm max-md:px-1 max-md:text-xs">
                                {{ isset($item['panen_per_bulan'][$bulan]) ? number_format($item['panen_per_bulan'][$bulan], 1, ',', '.') : '-' }}
                            </td>
                        @endfor
                        <td class="border-b px-5 py-2 text-center font-semibold text-sm max-md:px-2 max-md:text-xs">
                            {{ number_format(array_sum($item['panen_per_bulan'] ?? []), 1, ',', '.') }}
                        </td>
                        <td class="border-b p-2 flex justify-center gap-2 text-sm max-md:p-1 max-md:text-xs">
                            <button class="editBtn bg-yellow-400 text-white rounded-md w-10 h-10 max-md:w-8 max-md:h-8" data-tanaman="{{ $item['nama_tanaman'] }}">
                                <i class="bi bi-pencil-square"></i>
                            </button>
                            <button class="deleteBtn bg-red-500 text-white rounded-md w-10 h-10 max-md:w-8 max-md:h-8" data-tanaman="{{ $item['nama_tanaman'] }}">
                                <i class="bi bi-trash-fill"></i>
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
    <!-- Empty State -->
    <div class="flex items-center justify-center h-64">
        <div class="text-center p-4 border-2 border-dashed border-gray-300 rounded-lg shadow-md bg-gray-50">
            <h3 class="text-lg font-semibold text-gray-500">Data Not Found</h3>
            <p class="text-gray-400 text-sm">We couldn't find any data matching your request.</p>
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

    $('#pilih_tanaman').on('change', function() {
        $('#pilih_periode').prop('disabled', false);
    });

    $('.editBtn').on('click', function() {
        const modal = $("#modal");
        modal.removeClass("hidden").addClass("flex");

        const jenisTanaman = $(this).data('tanaman');

        $.ajax({
            type: "GET",
            url: `/api/dtphp/${jenisTanaman}`,
            success: function(response) {
                const data = response.data;
                $('#editDataList').empty();

                data.forEach(element => {
                    let listCard = `
                        <div class="border rounded-md p-4 shadow-sm flex items-center justify-between max-md:flex-col max-md:items-start max-md:gap-2">
                            <div class="max-md:w-full">
                                <p class="text-sm text-gray-500 max-md:text-xs">Jenis Tanaman: <span class="font-medium">${element.nama_tanaman}</span></p>
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

        const jenisTanaman = $(this).data('tanaman');

        $.ajax({
            type: "GET",
            url: `/api/dtphp/${jenisTanaman}`,
            success: function(response) {
                const data = response.data;
                $('#editDataList').empty();

                data.forEach(element => {
                    let listCard = `
                        <div class="border rounded-md p-4 shadow-sm flex items-center justify-between max-md:flex-col max-md:items-start max-md:gap-2">
                            <div class="max-md:w-full">
                                <p class="text-sm text-gray-500 max-md:text-xs">Jenis Tanaman: <span class="font-medium">${element.nama_tanaman}</span></p>
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
                    text: `Data tanaman telah dihapus.`,
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


    // Trigger Filter Modal
    function toggleModal() {
    const modal = document.getElementById('filterModal');
    modal.classList.toggle('hidden');
    modal.classList.toggle('flex');
    }

    $("#filterBtn").on("click", function() {
    $("#filterModal").toggleClass("hidden");
    });
    // End Trigger Filter Modal

$(document).ready(function() {
        $('#search').on('input', function() {
            const searchTerm = $(this).val().toLowerCase().trim();
            const tableRows = $('tbody tr');
            
            if (searchTerm === '') {
                tableRows.show();
                updateNoDataMessage(false);
                return;
            }
            
            let visibleRowsCount = 0;
            
            tableRows.each(function() {
                const fishName = $(this).find('td:first').text().toLowerCase();
                
                if (fishName.includes(searchTerm)) {
                    $(this).show();
                    visibleRowsCount++;
                } else {
                    $(this).hide();
                }
            });
            
            updateNoDataMessage(visibleRowsCount === 0);
        });
        
        function updateNoDataMessage(show) {
            const existingMessage = $('#no-search-results');
            
            if (show) {
                if (existingMessage.length === 0) {
                    const noResultsHTML = `
                        <tr id="no-search-results">
                            <td colspan="14" class="text-center py-8">
                                <div class="flex flex-col items-center justify-center">
                                    <svg class="w-12 h-12 text-gray-400 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                                    </svg>
                                    <h3 class="text-lg font-medium text-gray-500 mb-2">Tidak ada hasil ditemukan</h3>
                                    <p class="text-gray-400">Coba gunakan kata kunci yang berbeda</p>
                                </div>
                            </td>
                        </tr>
                    `;
                    $('tbody').append(noResultsHTML);
                } else {
                    existingMessage.show();
                }
            } else {
                existingMessage.hide();
            }
        }
        
        let searchTimeout;
        $('#search').on('input', function() {
            clearTimeout(searchTimeout);
            const searchInput = $(this);
            
            searchTimeout = setTimeout(function() {
                performSearch(searchInput.val());
            }, 200);
        });
        
        function performSearch(searchTerm) {
            const normalizedSearch = searchTerm.toLowerCase().trim();
            const tableRows = $('tbody tr:not(#no-search-results)');
            
            if (normalizedSearch === '') {
                tableRows.show();
                updateNoDataMessage(false);
                return;
            }
            
            let visibleRowsCount = 0;
            
            tableRows.each(function() {
                const fishName = $(this).find('td:first').text().toLowerCase();
                const isMatch = fishName.includes(normalizedSearch);
                
                if (isMatch) {
                    $(this).show();
                    visibleRowsCount++;
                    
                    highlightSearchTerm($(this).find('td:first'), searchTerm, fishName);
                } else {
                    $(this).hide();
                }
            });
            
            updateNoDataMessage(visibleRowsCount === 0);
        }
        
        function highlightSearchTerm(element, searchTerm, originalText) {
            if (searchTerm.trim() === '') {
                element.html(originalText);
                return;
            }
            
            const regex = new RegExp(`(${escapeRegExp(searchTerm)})`, 'gi');
        }
        
        function escapeRegExp(string) {
            return string.replace(/[.*+?^${}()|[\]\\]/g, '\\$&');
        }
        
        function advancedSearch(searchTerm, searchInProduction = false) {
            const normalizedSearch = searchTerm.toLowerCase().trim();
            const tableRows = $('tbody tr:not(#no-search-results)');
            
            if (normalizedSearch === '') {
                tableRows.show();
                updateNoDataMessage(false);
                return;
            }
            
            let visibleRowsCount = 0;
            
            tableRows.each(function() {
                const fishName = $(this).find('td:first').text().toLowerCase();
                let isMatch = fishName.includes(normalizedSearch);
                
                if (!isMatch && searchInProduction) {
                    $(this).find('td').each(function(index) {
                        if (index > 0 && index < 13) {
                            const cellText = $(this).text().toLowerCase();
                            if (cellText.includes(normalizedSearch)) {
                                isMatch = true;
                                return false;
                            }
                        }
                    });
                }
                
                if (isMatch) {
                    $(this).show();
                    visibleRowsCount++;
                } else {
                    $(this).hide();
                }
            });
            
            updateNoDataMessage(visibleRowsCount === 0);
        }
    });
</script>