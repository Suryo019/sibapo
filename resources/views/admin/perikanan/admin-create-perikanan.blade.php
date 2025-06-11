<x-admin-layout>
    
        <main class="flex-1 p-6 max-md:p-4 bg-gray-10 border-gray-20 border-[3px] rounded-[20px]">
            <div class="w-full flex items-center gap-2 mb-4">
                <a href="{{ route('perikanan.detail') }}" class="text-decoration-none text-dark flex-shrink-0">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="4" stroke="currentColor" class="w-6 h-6">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 19.5L8.25 12l7.5-7.5" />
                    </svg>                      
                </a>
                <h3 class="text-lg font-semibold text-center max-md:text-base">Tambah Data</h3>
            </div>
        <div class="bg-white p-4 sm:p-6 rounded-lg shadow-md mt-4 border bg-gray-10 border-gray-20">
            <form action="{{ route('api.dp.store') }}" method="post" onkeydown="return event.key != 'Enter';">
                @csrf
                <!-- Nama Ikan -->
                <div class="mb-4">
                    <label class="block text-pink-500">Nama Ikan</label>
                    <select id="jenis_ikan_id" name="jenis_ikan_id" class="border p-2 w-full rounded-xl bg-white text-black dark:text-black dark:bg-white">
                        <option value="" selected disabled>Pilih Ikan</option>
                        @foreach ($fishes as $fish)
                            <option value="{{ $fish->id }}">
                                {{ $fish->nama_ikan }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div class="mb-4">
                    <label class="block text-gray-700">Volume Produksi (Ton)</label>
                    <input type="text" placeholder="Contoh: 100" 
                           class="border p-2 w-full rounded-xl" id="ton_produksi">
                </div>
    
            </form>
        </div>
        
        <!-- Tombol -->
        <div class="flex justify-between mt-6">
            <button id="submitBtn" class="inline-flex items-center px-6 py-2 bg-yellow-550 hover:bg-yellow-500 text-white rounded-xl shadow-sm transition-colors duration-200 ">
                Simpan
            </button>
        </div>
    </main>
</x-admin-layout>

<script>
    $('#submitBtn').on('click', function() {
        $.ajax({
            type: "POST",
            url: "{{ route('api.dp.store') }}",
            data: {
                _token: "{{ csrf_token() }}",
                jenis_ikan_id: $('#jenis_ikan_id').val(),
                ton_produksi: $('#ton_produksi').val(),
                },
                success: function(data) {
                $('#jenis_ikan').val('');
                $('#ton_produksi').val('');

                Swal.fire({
                    title: 'Berhasil!',
                    text: `Data ikan ${data.nama_ikan} telah disimpan.`,
                    icon: 'success',
                    confirmButtonText: 'OK'
                });
            },
            error: function(xhr, status, error) {
                let errors = xhr.responseJSON.errors;
                let message = '';

                $.each(errors, function(key, value) {
                    message += value + '<br>';
                });

                Swal.fire({
                    icon: 'error',
                    title: 'Oops...',
                    html: message
                });
            }
        });
    });
</script>