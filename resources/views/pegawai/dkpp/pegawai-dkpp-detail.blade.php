{{-- @dd($data) --}}

<x-pegawai-layout>

    <div class="w-full flex justify-between items-center gap-4 flex-wrap">
        <!-- Search bar -->
        <x-search></x-search>
      
        {{-- Filter --}}
        <div class="flex justify-end w-full sm:w-auto">
          <div class="relative flex justify-end w-full">
            <x-filter></x-filter>
      
            <!-- Modal Background -->
            <div id="filterModal" class="mt-10 absolute hidden items-center justify-center z-50 w-full">
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
                    <!-- pilih urutan -->
                    <div class="flex flex-col">
                      <label for="pilih_urutan" class="block text-sm font-medium text-gray-700 mb-1">Urutkan</label>
                      <select class="border border-black p-2 rounded bg-white w-full" id="pilih_urutan">
                        <option>Ascending</option>
                        <option>Descending</option>
                      </select>
                    </div>
      
                    <!-- pilih periode -->
                    <div class="flex flex-col">
                      <label for="pilih_periode" class="block text-sm font-medium text-gray-700 mb-1">Pilih Periode</label>
                      <select class="border border-black p-2 rounded bg-white w-full" id="pilih_periode">
                        @foreach ($periods as $period)
                        <option value="{{ $period }}">{{ $period }}</option>
                        @endforeach
                      </select>
                    </div>
      
                    <!-- pilih minggu -->
                    <div class="flex flex-col">
                      <label for="pilih_minggu" class="block text-sm font-medium text-gray-700 mb-1">Minggu ke</label>
                      <select class="border border-black p-2 rounded bg-white w-full" id="pilih_minggu">
                        <option>1</option>
                        <option selected>2</option>
                        <option>3</option>
                        <option>4</option>
                      </select>
                    </div>
                  </div>
      
                  <div class="w-full flex justify-end gap-3 mt-10">
                    <button type="reset"
                      class="bg-yellow-550 text-white rounded-lg w-20 p-2 text-sm hover:bg-yellow-600">Reset</button>
                    <button type="submit"
                      class="bg-pink-650 text-white rounded-lg w-20 p-2 text-sm hover:bg-pink-700">Cari</button>
                  </div>
                </form>
              </div>
            </div>
          </div>
        </div>
      </div>
      
      <main class="flex-1 p-6 max-md:p-4 bg-gray-10 border-gray-20 border-[3px] rounded-[20px]">
        <div class="w-full flex items-center gap-2 mb-4">
          <a href="{{ route('pegawai.dkpp.index') }}" class="text-decoration-none text-dark flex-shrink-0">
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="4"
              stroke="currentColor" class="w-6 h-6">
              <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 19.5L8.25 12l7.5-7.5" />
            </svg>
          </a>
          <h3 class="text-xl font-extrabold text-center max-md:text-base">Neraca Ketersediaan</h3>
        </div>
      
        <div class="bg-white p-4 sm:p-6 rounded shadow-md border bg-gray-10 border-gray-20">
          <!-- Tabel Responsif -->
          <div class="overflow-x-auto">
            <table class="min-w-[1000px] w-full table-auto">
              <thead>
                <tr>
                  <th class="p-2 text-xs sm:text-sm">No</th>
                  <th class="p-2 text-xs sm:text-sm">Jenis Komoditas</th>
                  <th class="p-2 text-xs sm:text-sm">Ketersediaan (ton)</th>
                  <th class="p-2 text-xs sm:text-sm">Kebutuhan / Minggu</th>
                  <th class="p-2 text-xs sm:text-sm">Neraca Mingguan</th>
                  <th class="p-2 text-xs sm:text-sm">Keterangan</th>
                  <th class="p-2 text-xs sm:text-sm">Aksi</th>
                </tr>
              </thead>
              <tbody>
                @foreach ($data as $item)
                @php $keterangan = $item->keterangan; @endphp
                <tr class="border-b text-sm text-center">
                  <td class="p-2">{{ $loop->iteration }}</td>
                  <td class="p-2">{{ $item->jenis_komoditas }}</td>
                  <td class="p-2">{{ $item->ton_ketersediaan }}</td>
                  <td class="p-2">{{ $item->ton_kebutuhan_perminggu }}</td>
                  <td class="p-2">{{ $item->ton_neraca_mingguan }}</td>
                  <td
                    class="p-2 font-bold {{ $keterangan == 'Surplus' ? 'text-green-500' : ($keterangan == 'Defisit' ? 'text-red-500' : 'text-slate-600') }}">
                    {{ $keterangan }}
                  </td>
                  <td class="border p-2">
                    <div class="flex justify-center gap-2">
                      <a href="{{ route('pegawai.dkpp.edit', $item->id) }}">
                        <button class="bg-yellow-400 text-white rounded-md w-10 h-10 hover:bg-yellow-500">
                          <i class="bi bi-pencil-square"></i>
                        </button>
                      </a>
                      <button class="deleteBtn bg-red-500 text-white rounded-md w-10 h-10 hover:bg-red-600"
                        data-id="{{ $item->id }}">
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
         
</x-pegawai-layout>

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
</script>

