{{-- @dd($data) --}}
<x-admin-layout>
    <div class="w-full flex justify-between">
        <!-- Search bar -->
        <x-search></x-search>

        {{-- Filter --}}
        <div class="flex justify-end">
            <x-filter></x-filter>
    
            <!-- Modal Background -->
            <div id="filterModal" class="mt-10 absolute hidden items-center justify-center z-50">
                <!-- Modal Content -->
                <div class="bg-white w-96 max-md:w-80 rounded-lg shadow-black-custom p-6 relative">
                <!-- Close Button -->
                <button onclick="toggleModal()" class="absolute top-2 right-2 text-gray-500 hover:text-gray-700">
                    <i class="bi bi-x text-4xl"></i> 
                </button>
                
                <h2 class="text-center text-pink-500 font-semibold text-lg mb-4">
                    Filter
                </h2>

                <form action="" method="get">
                    <div class="space-y-4">
                        <!-- Nama Pasar -->
                        <div class= "flex flex-col">
                            <label for="pilih_urutan" class="block text-sm font-medium text-gray-700 mb-1">Urutkan</label>
                                <select name="urutkan" class="border border-black p-2 rounded-full bg-white w-full select2" id="pilih_urutan">
                                    <option value="az" {{ old('urutkan') == 'az' ? 'selected' : '' }}>A - Z</option>
                                    <option value="za" {{ old('urutkan') == 'za' ? 'selected' : '' }}>Z - A</option>
                                </select>
                        </div>
        
                        <!-- Periode -->
                        <div class= "flex flex-col">
                            <label for="pilih_pasar" class="block text-sm font-medium text-gray-700 mb-1">Pilih Pasar</label>
                                <select name="pasar" class="border border-black p-2 rounded-full bg-white w-full select2" id="pilih_pasar">
                                    <option value="" disabled {{ old('pasar') ? '' : 'selected' }}>Pilih Pasar</option>
                                    @foreach ($markets as $market)
                                        <option value="{{ $market }}" {{ old('pasar') == $market ? 'selected' : '' }}>{{ $market }}</option>
                                    @endforeach
                                </select>
                        </div>
        
                        <!-- Bahan Pokok -->
                        <div class= "flex flex-col">
                            <label for="pilih_periode" class="block text-sm font-medium text-gray-700 mb-1">Pilih Periode</label>
                                <select name="periode" class="border border-black p-2 rounded-full bg-white w-full select2" id="pilih_periode">
                                    <option value="" disabled {{ old('periode') ? '' : 'selected' }}>Pilih Periode</option>
                                    @foreach ($periods as $period)
                                        <option value="{{ $period }}" {{ old('periode') == $period ? 'selected' : '' }}>{{ $period }}</option>
                                    @endforeach
                                </select>
                        </div>
                    </div>
                    <div class="w-full flex justify-center gap-3 mt-10">
                        {{-- <button type="reset" class="bg-yellow-550 text-white rounded-lg w-20 p-1">Reset</button> --}}
                        <button type="Submit" class="bg-yellow-550 text-white rounded-lg w-20 p-1">Filter</button>
                    </div>
                </form>
                </div>
            </div>
        </div>
    </div>

    {{-- Main Content --}}
    <main class="flex-1">
        {{-- <h2 class="text-xl md:text-2xl font-semibold text-green-900">{{ $title }}</h2> --}}
        <main class="flex-1 p-6 max-md:p-4 bg-gray-10 border-gray-20 border-[3px] rounded-[20px]">

            <div class="w-full flex items-center gap-2 mb-4">
                <a href="{{ route('disperindag.index') }}" class="text-decoration-none text-dark flex-shrink-0">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="4" stroke="currentColor" class="w-6 h-6">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 19.5L8.25 12l7.5-7.5" />
                    </svg>                      
                </a>
                <h3 class="text-lg font-semibold ">Data Harga {{ $market }} Bulan {{ $period }}</h3>
                </div>
                
        <div class="bg-white p-6 rounded shadow-md mt-4">
            <!-- Tabel -->
            @if (isset($data) && count($data) != 0) 
                <div class="overflow-x-auto">
                    <div class="min-w-full inline-block align-middle">
                        <div class="overflow-hidden">
                            <table class="min-w-full divide-y border">
                                <thead>
                                    <tr>
                                        <th rowspan="2" class="px-3 py-2 text-xs md:text-sm font-medium text-center border">No</th>
                                        <th rowspan="2" class="px-3 py-2 text-xs md:text-sm font-medium text-center border">Aksi</th>
                                        <th rowspan="2" class="px-3 py-2 text-xs md:text-sm font-medium text-center border whitespace-nowrap">Jenis Bahan Pokok</th>
                                        <th colspan="{{ $daysInMonth }}" class="px-3 py-2 text-xs md:text-sm font-medium text-center border">Harga {{ $period }}</th>
                                    </tr>
                                    <tr>
                                        @for ($i = 1; $i <= $daysInMonth; $i++)
                                            <th class="px-2 py-1 text-xs md:text-sm font-medium text-center border">{{ $i }}</th>
                                        @endfor
                                    </tr>
                                </thead>
                                <tbody class="divide-y">
                                    @foreach ($data as $item)
                                        <tr class="hover:bg-gray-50">
                                            <td class="px-3 py-2 text-xs md:text-sm text-center border">{{ $loop->iteration }}</td>
                                            <td class="px-3 py-2 text-center border">
                                                <div class="flex justify-center gap-1 md:gap-2">
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
                                            <td class="px-3 py-2 text-xs md:text-sm border">{{ $item['jenis_bahan_pokok'] }}</td>
                                            @for ($kolom = 1; $kolom <= $daysInMonth; $kolom++)
                                                <td class="px-2 py-1 text-xs md:text-sm text-center border whitespace-nowrap">
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
        
        {{-- Modal Delete --}}
        <div id="deleteModal" class="hidden w-full h-full">
            <div class="fixed inset-0 bg-black bg-opacity-50 flex justify-center items-center z-40 p-4">
                <div class="bg-white rounded-lg w-full max-w-md shadow-lg relative">
                    <div class="p-4 md:p-6">
                        <h2 class="text-lg md:text-xl font-semibold mb-6 text-center">Yakin menghapus data?</h2>
                        <div class="flex flex-col sm:flex-row justify-center gap-4">
                            <button class="bg-pink-500 hover:bg-pink-400 text-white px-4 py-2 rounded-full text-sm md:text-base" id="closeBtn">Batal</button>
                            <button class="bg-pink-500 hover:bg-pink-400 text-white px-4 py-2 rounded-full text-sm md:text-base" id="yesBtn">Ya</button>
                        </div>
                    </div>
                </div>
            </div>
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