<x-pegawai-layout>

        <main class="flex-1 p-6 max-md:p-4 bg-gray-10 border-gray-20 border-[3px] rounded-[20px]">
        <div class="w-full flex items-center gap-2 mb-4">
            <a href="{{ route('pegawai.perikanan.detail') }}" class="text-decoration-none text-dark flex-shrink-0">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="4" stroke="currentColor" class="w-6 h-6">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 19.5L8.25 12l7.5-7.5" />
                </svg>                      
            </a>
            <h3 class="text-lg font-semibold text-center max-md:text-base">Tambah Data</h3>
        </div>
    
        <div class="relative bg-white p-4 sm:p-6 rounded-lg shadow-md mt-4">
            <form id="fishForm">
                @csrf

                <div class="mb-4">
                    <label for="jenis_ikan" class="block text-sm font-medium text-pink-500 mb-1">Jenis Ikan</label>
                    <input 
                        type="text" 
                        name="jenis_ikan" 
                        id="jenis_ikan"
                        placeholder="Contoh: Lele" 
                        class="w-full border border-gray-300 p-2 rounded-xl">
                </div>
    
                <div class="mb-4">
                    <label for="ton_produksi" class="block text-sm font-medium text-pink-500 mb-1">Volume Produksi (Ton)</label>
                    <input 
                        type="text" 
                        name="ton_produksi" 
                        id="ton_produksi"
                        placeholder="Contoh: 100" 
                        class="w-full border border-gray-300 p-2 rounded-xl">
                </div>
            </form>
            <div class="flex justify-between mt-6">
                <button id="submitBtn" class="inline-flex items-center px-6 py-2 bg-yellow-550 hover:bg-yellow-500 text-white rounded-xl transition duration-300 ">
                    Simpan
                </button>
            </div>
        </div>
        
    </main>
</x-pegawai-layout>

<script>
    $('#submitBtn').on('click', function() {
        $.ajax({
            type: "POST",
            url: "{{ route('api.dp.store') }}",
            data: {
                _token: "{{ csrf_token() }}",
                jenis_ikan: $('#jenis_ikan').val(),
                ton_produksi: $('#ton_produksi').val(),
                },
                success: function(data) {
                $('#jenis_ikan').val('');
                $('#ton_produksi').val('');

                Swal.fire({
                    title: 'Berhasil!',
                    text: `Data ${data.data.jenis_ikan} telah disimpan.`,
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