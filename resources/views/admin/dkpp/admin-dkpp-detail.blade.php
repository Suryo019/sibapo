{{-- @dd($data) --}}

<x-admin-layout>
    <main class="flex-1 p-4 sm:p-6">
        <div class="flex flex-col gap-4 mb-6 lg:flex-row lg:justify-between">
            <!-- Search and Filter -->
            <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between w-full gap-4">
                <x-search>Cari komoditas...</x-search>
    
                <div class="flex justify-end max-md:w-full">
                        <x-filter></x-filter>
    
                        <!-- Modal Background -->
                        <x-filter-modal>
                            <form action="" method="get" class="space-y-4">
                                <div class="flex flex-col">
                                    <label for="ururtkan" class="block text-sm font-medium text-gray-700 mb-1">Urutkan</label>
                                    <select class="border border-black p-2 rounded bg-white w-full" name="urutkan" id="ururtkan">
                                        <option value="asc" {{ old('urutkan') == 'asc' ? 'selected' : '' }}>A - Z</option>
                                        <option value="desc" {{ old('urutkan') == 'desc' ? 'selected' : '' }}>Z - A</option>
                                    </select>
                                </div>

                                <div class="flex flex-col">
                                    <label for="periode" class="block text-sm font-medium text-gray-700 mb-1">Pilih Periode</label>
                                    <input type="month" value="{{ date('Y-m') }}" name="periode" id="periode" class="border border-black p-2 rounded bg-white w-full">
                                </div>

                                <div class="flex flex-col">
                                    <label for="minggu" class="block text-sm font-medium text-gray-700 mb-1">Minggu ke</label>
                                    <select class="border border-black p-2 rounded bg-white w-full" id="minggu">
                                        <option {{ $currentWeek == 1 ? 'selected' : '' }}>1</option>
                                        <option {{ $currentWeek == 2 ? 'selected' : '' }}>2</option>
                                        <option {{ $currentWeek == 3 ? 'selected' : '' }}>3</option>
                                        <option {{ $currentWeek == 4 ? 'selected' : '' }}>4</option>
                                    </select>
                                </div>

                                <div class="w-full flex justify-end gap-3 mt-6">
                                    <button type="reset" class="bg-yellow-550 text-white rounded-lg w-20 p-1">Reset</button>
                                    <button type="button" id="submitFilterBtn" class="bg-pink-650 text-white rounded-lg w-20 p-1">Cari</button>
                                </div>
                            </form>
                        </x-filter-modal> 
                    </div> 
                </div> 
            </div>
    
        <!-- Back Button + Title -->
        <main class="flex-1 p-6 max-md:p-4 bg-gray-10 border-gray-20 border-[3px] rounded-[20px]">
        <div class="flex justify-between items-center mb-4 max-md:flex-col">
            <div class="flex items-center gap-2">
                <a href="{{ route('dkpp.index') }}" class="text-decoration-none text-dark flex-shrink-0">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="4" stroke="currentColor" class="w-6 h-6">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 19.5L8.25 12l7.5-7.5" />
                    </svg>                      
                </a>
                <h2 class="text-2xl font-semibold text-black max-md:text-lg max-md:text-center">NERACA KETERSEDIAAN</h2>
            </div>
            <div>
                <span id="periode_placeholder" class="text-lg font-bold max-md:text-base"></span> <span id="minggu_placeholder" class="text-lg font-bold max-md:text-base"></span>
            </div>
        </div>
    
        <!-- Table Section -->
        <div class="bg-white p-4 sm:p-6 rounded shadow-md border bg-gray-10 border-gray-20">
            <div class="overflow-x-auto">
                <table class="min-w-[600px] w-full table-auto text-sm">
                    <thead>
                        <tr>
                            <th class="p-2">No</th>
                            <th class="p-2">Jenis Komoditas</th>
                            <th class="p-2">Ketersediaan</th>
                            <th class="p-2">Kebutuhan</th>
                            <th class="p-2">Neraca</th>
                            <th class="p-2">Keterangan</th>
                            <th class="p-2">Aksi</th>
                        </tr>
                    </thead>
                    <tbody id="tbodyDKPP">
                        {{-- diisi pake ajax --}}
                    </tbody>
                </table>
            </div>
        </div>
    
        <!-- Modal Confirm Delete -->
        <div id="modal" class="hidden">
            <div class="fixed inset-0 bg-black bg-opacity-50 flex justify-center items-center z-40">
                <div class="bg-white p-6 rounded-lg w-[90%] max-w-sm shadow-lg">
                    <h2 class="text-xl font-semibold mb-6 text-center">Yakin menghapus data?</h2>
                    <div class="flex justify-around">
                        <button class="bg-pink-500 hover:bg-pink-400 text-white px-4 py-2 rounded-full" id="closeBtn">Tutup</button>
                        <button class="bg-pink-500 hover:bg-pink-400 text-white px-4 py-2 rounded-full" id="yesBtn">Yakin</button>
                    </div>
                </div>
            </div>
        </div>
    </main>
    
     
</x-admin-layout>

<script>
    const periode = $('#periode');
    const minggu = $('#minggu');
    const search = $('#search');
    const ururtkan = $('#ururtkan');

    // select data
    function filter() {
        $.ajax({
            type: 'GET',
            url: "{{ route('api.dkpp.detail') }}",
            data: {
                periode: periode.val(),
                minggu: minggu.val(),
                sort: ururtkan.val(),
            },
            success: function(response) {
                $('#periode_placeholder').html(`${response.periode.toUpperCase()}, `)
                $('#minggu_placeholder').html(`MINGGU KE-${minggu.val().toUpperCase()}`)
                
                let tbody = $('#tbodyDKPP');
                tbody.empty();

                let data = response.data;

                if (data.length === 0) {
                    let row = `
                        <tr class="bg-white text-center">
                            <td class="py-5 px-8 bg-pink-50 text-gray-500 italic" colspan="7">
                                Data tidak ditemukan.
                            </td>
                        </tr>
                    `;
                    tbody.append(row);
                } else {
                    data.forEach((item, index) => {
                        let keteranganClass = '';
                        if (item.keterangan === 'Surplus') {
                            keteranganClass = 'text-green-500';
                        } else if (item.keterangan === 'Defisit') {
                            keteranganClass = 'text-red-500';
                        } else {
                            keteranganClass = 'text-slate-600';
                        }
    
                        let row = `
                            <tr class="border-b text-center">
                                <td class="p-2">${index + 1}</td>
                                <td class="p-2 nama_komoditas_col">${item.nama_komoditas}</td>
                                <td class="p-2">${item.ton_ketersediaan}</td>
                                <td class="p-2">${item.ton_kebutuhan_perminggu}</td>
                                <td class="p-2">${item.ton_neraca_mingguan}</td>
                                <td class="p-2 font-bold ${keteranganClass}">${item.keterangan}</td>
                                <td class="p-2">
                                    <div class="flex justify-center gap-2">
                                        <a href="/dkpp/${item.dkpp_id}/edit">
                                            <button class="bg-yellow-400 text-white rounded-md w-10 h-10">
                                                <i class="bi bi-pencil-square"></i>
                                            </button>
                                        </a>
                                        <button class="deleteBtn bg-red-500 text-white rounded-md w-10 h-10" data-id="${item.dkpp_id}">
                                            <i class="bi bi-trash-fill"></i>
                                        </button>
                                    </div>
                                </td>
                            </tr>
                        `;
                        tbody.append(row);
                    });
                }
            }
        });
    }

    filter();

    $('#submitFilterBtn').on('click', function() {
        filter();
    });


    // Tombol Delete
    $(document).on('click', '.deleteBtn', function() {
        let id = $(this).data('id');
        console.log(id);
        
        $('#modal').show();

        $('#yesBtn').on('click', function() {
            $('#modal').hide();

            $.ajax({
                type: 'DELETE',
                url: `/api/dkpp/${id}`,
                data: {
                    _token: '{{ csrf_token() }}',
                },
                success: function(response) {                    
                    Swal.fire({
                        title: 'Berhasil!',
                        text: `Data ${response.data.nama_komoditas} telah dihapus.`,
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

    // search
    search.on("input", function () {
        const input_value = $(this).val().toLowerCase();
        let nama_komoditas_col = $(".nama_komoditas_col");

        nama_komoditas_col.each(function () {
            let item_text = $(this).text().toLowerCase();

            if (item_text.includes(input_value)) {
                $(this).parent().removeClass("hidden");
            } else {
                $(this).parent().addClass("hidden");
            }
        });
    });

</script>

