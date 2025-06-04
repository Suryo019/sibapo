{{-- @dd($data) --}}
<x-admin-layout>
    <div class="w-full flex justify-between gap-4">
        <!-- Search bar -->
        <x-search></x-search>
    
        {{-- Filter --}}
        <div class="flex justify-end max-md:w-full">
            <x-filter></x-filter>
    
            <!-- Modal Background -->
            <x-filter-modal>
                <form action="" method="get" class="space-y-4">
                    <!-- Urutan -->
                    <div class="flex flex-col">
                        <label for="pilih_urutan" class="block text-sm font-medium text-gray-700 mb-1">Urutkan</label>
                        <select name="urutkan" class="border border-black p-2 rounded-full bg-white w-full select2" id="pilih_urutan">
                            <option value="az" {{ old('urutkan') == 'az' ? 'selected' : '' }}>A - Z</option>
                            <option value="za" {{ old('urutkan') == 'za' ? 'selected' : '' }}>Z - A</option>
                        </select>
                    </div>

                    <!-- Pilih Pasar -->
                    <div class="flex flex-col">
                        <label for="pilih_pasar" class="block text-sm font-medium text-gray-700 mb-1">Pilih Pasar</label>
                        <select name="pasar" class="border border-black p-2 rounded-full bg-white w-full select2" id="pilih_pasar">
                            <option value="" disabled {{ old('pasar') ? '' : 'selected' }}>Pilih Pasar</option>
                            @foreach ($markets as $market)
                                <option value="{{ $market }}" {{ old('pasar') == $market ? 'selected' : '' }}>{{ $market }}</option>
                            @endforeach
                        </select>
                    </div>

                    <!-- Pilih Periode -->
                    <div class="flex flex-col">
                        <label for="pilih_periode" class="block text-sm font-medium text-gray-700 mb-1">Pilih Periode</label>
                        <select name="periode" class="border border-black p-2 rounded-full bg-white w-full select2" id="pilih_periode">
                            <option value="" disabled {{ old('periode') ? '' : 'selected' }}>Pilih Periode</option>
                            @foreach ($periods as $period)
                                <option value="{{ $period }}" {{ old('periode') == $period ? 'selected' : '' }}>{{ $period }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="w-full flex justify-end gap-3 mt-10">
                        <button type="reset" class="bg-yellow-550 text-white rounded-lg w-20 p-1">Reset</button>
                        <button type="Submit" class="bg-pink-650 text-white rounded-lg w-20 p-1">Cari</button>
                    </div>
                </form>
            </x-filter-modal>
        </div>
    </div>
    
    {{-- Main Content --}}
    <main class="flex-1 p-6 max-md:p-4 bg-gray-10 border-gray-20 border-[3px] rounded-[20px]">
    
        <div class="w-full flex items-center gap-2 mb-4 flex-wrap">
            <a href="{{ route('disperindag.index') }}" class="text-dark flex-shrink-0">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="4" stroke="currentColor" class="w-6 h-6">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 19.5L8.25 12l7.5-7.5" />
                </svg>                      
            </a>
            <h3 class="text-lg md:text-xl font-semibold text-black">{{ $marketFiltered }} - Bulan {{ $period }}</h3>
        </div>
    
        <div class="bg-white p-4 md:p-6 rounded shadow-md mt-4">
            @if (isset($data) && count($data) != 0)
            <div class="overflow-x-auto">
                <table class="min-w-full text-xs md:text-sm divide-y">
                    <thead class="bg-gray-100">
                        <tr>
                            <th rowspan="2" class="px-2 py-2 text-center">No</th>
                            <th rowspan="2" class="px-2 py-2 text-center">Aksi</th>
                            <th rowspan="2" class="px-2 py-2 text-center">Jenis Komoditas</th>
                            <th rowspan="2" class="px-2 py-2 text-center">Gambar</th>
                            @for ($i = 1; $i <= $daysInMonth; $i++)
                                <th class="px-2 py-1 text-center">{{ $i }}</th>
                            @endfor
                        </tr>
                    </thead>
                    <tbody class="divide-y">
                        @foreach ($data as $item)
                        <tr class="hover:bg-gray-50">
                            <td class="px-2 py-2 text-center">{{ $loop->iteration }}</td>
                            <td class="px-2 py-2 text-center">
                                <div class="flex justify-center gap-1">
                                    <button class="editBtn bg-yellow-400 text-white rounded-md w-8 h-8 md:w-10 md:h-10 flex items-center justify-center"
                                        data-bahan-pokok="{{ $item['jenis_bahan_pokok'] }}"
                                        data-periode-bulan="{{ $splitNumberPeriod[1] }}"
                                        data-periode-tahun="{{ $splitNumberPeriod[0] }}">
                                        <i class="bi bi-pencil-square text-xs md:text-base"></i>
                                    </button>
                                    <button class="deleteBtn bg-red-500 text-white rounded-md w-8 h-8 md:w-10 md:h-10 flex items-center justify-center"
                                        data-bahan-pokok="{{ $item['jenis_bahan_pokok'] }}"
                                        data-periode-bulan="{{ $splitNumberPeriod[1] }}"
                                        data-periode-tahun="{{ $splitNumberPeriod[0] }}">
                                        <i class="bi bi-trash-fill text-xs md:text-base"></i>
                                    </button>
                                </div>
                            </td>
                            <td class="px-2 py-2 text-center">{{ $item['jenis_bahan_pokok'] }}</td>
                            <td class="px-2 py-2">
                                @if ($item['gambar_bahan_pokok'])
                                    <img src="{{ asset('storage/' . $item['gambar_bahan_pokok']) }}" 
                                         alt="Gambar Bahan Pokok" 
                                         class="w-32 h-auto rounded object-cover aspect-square">
                                @else
                                    <span class="text-gray-400 italic">Tidak ada gambar</span>
                                @endif
                            </td>                            
    
                            @for ($kolom = 1; $kolom <= $daysInMonth; $kolom++)
                                <td class="px-2 py-1 text-center whitespace-nowrap">
                                    @if (isset($item['harga_per_tanggal'][$kolom]))
                                        Rp. {{ number_format($item['harga_per_tanggal'][$kolom], 0, ',', '.') }}
                                    @else
                                        -
                                    @endif
                                </td>
                            @endfor
                        </tr>
                        <script src="{{ asset('js/admin-disperindag-detail-modal.js') }}"></script>
                        @endforeach
                    </tbody>
                </table>
            </div>
    
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
     
</x-admin-layout>

<script>

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


    $('#closeListModal').on('click', function() {
        $(this).closest('#modal').removeClass("flex").addClass("hidden");
    });
                                        
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
        $('#submitBtn').on('click', function() {
            document.querySelector("#filterForm").submit();
        });

    });
</script>