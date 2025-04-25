{{-- @dd($data) --}}

<x-admin-layout>
    <main class="flex-1 p-4 sm:p-6">
        {{-- <h2 class="text-2xl font-semibold text-green-900 text-center sm:text-left mb-4">Lihat Detail Data</h2> --}}
        <div class="flex flex-col lg:flex-row justify-between gap-4 mb-6">
            <!-- Search -->
            <div class="w-full flex justify-between">
                <div class="flex items-center border bg-gray-100 rounded w-full lg:w-64 h-9 px-3">
                    <input type="text" placeholder="Cari..." class="flex-grow outline-none rounded-full bg-gray-100">
                    <span class="bi bi-search pr-2 bg-gray-100"></span>
                </div>

                <!-- Button -->
                <button onclick="toggleModal()" class="px-4 py-2 bg-pink-500 text-white rounded-lg shadow hover:bg-pink-600">
                    <i class="bi bi-funnel-fill text-xl"></i>
                    Filter
                    <i class="bi bi-chevron-down text-xs"></i>
                </button>

                <!-- Modal Background -->
                <div id="filterModal" class="fixed inset-0 bg-black bg-opacity-30 hidden items-center justify-center z-50">
                    <!-- Modal Content -->
                    <div class="bg-white w-96 rounded-lg shadow-lg p-6 relative">
                        <!-- Close Button -->
                        <button onclick="toggleModal()" class="absolute top-2 right-2 text-gray-500 hover:text-gray-700">
                            <i class="bi bi-x text-4xl"></i> 
                        </button>
                        
                        <h2 class="text-center text-pink-500 font-semibold text-lg mb-4">
                            <i class="bi bi-funnel-fill text-xl"></i>
                            Filter
                            <i class="bi bi-chevron-down text-xs"></i>
                        </h2>

                        <div class="space-y-4">
                            <!-- Urutan -->
                            <div class="flex flex-col">
                                <label for="pilih_urutan" class="block text-sm font-medium text-gray-700 mb-1">Urutkan</label>
                                <select class="border border-black p-2 rounded-full bg-white w-full" id="pilih_urutan">
                                    <option>Ascending</option>
                                    <option>Descending</option>
                                </select>
                            </div>

                            <!-- Periode -->
                            <div class="flex flex-col">
                                <label for="pilih_periode" class="block text-sm font-medium text-gray-700 mb-1">Pilih Periode</label>
                                <select class="border border-black p-2 rounded-full bg-white w-full" id="pilih_periode">
                                    @foreach ($periods as $period)
                                        <option value="{{ $period }}">{{ $period }}</option>
                                    @endforeach
                                </select>
                            </div>

                            <!-- pilih minggu -->
                            <div class="flex flex-col">
                                <label for="pilih_minggu" class="block text-sm font-medium text-gray-700 mb-1">Minggu ke</label>
                                <select class="border border-black p-2 rounded-full bg-white w-full" id="pilih_minggu">
                                    <option>1</option>
                                    <option selected>2</option>
                                    <option>3</option>
                                    <option>4</option>
                                </select>
                            </div>
                        </div>
                    </div>
                </div>

                <script>
                    function toggleModal() {
                        const modal = document.getElementById("filterModal");
                        modal.classList.toggle("hidden");
                        modal.classList.toggle("flex");
                    }
                </script>
            </div>
        </div>
        

        <main class="flex-1 p-6 max-md:p-4 bg-gray-10 border-gray-20 border-[3px] rounded-[20px]">

            <div class="w-full flex items-center gap-2 mb-4">
                <a href="{{ route('disperindag.index') }}" class="text-decoration-none text-dark flex-shrink-0">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="4" stroke="currentColor" class="w-6 h-6">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 19.5L8.25 12l7.5-7.5" />
                    </svg>                      
                </a>
                <h2 class="text-lg font-semibold ">Neraca Ketersediaan </h2>
            </div>

        <div class="bg-white p-4 sm:p-6 rounded shadow-md">
            {{-- <h3 class="text-lg font-semibold text-center">Data Minggu 4 Per Januari 2025</h3>
            <h3 class="text-lg font-semibold text-center mb-4">Kabupaten Jember</h3> --}}
    
            <!-- Search dan Dropdown -->
    
                <!-- Dropdowns -->
                {{-- <form class="flex flex-col sm:flex-row gap-4 w-full lg:w-auto">
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
                </form> --}}
    
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

