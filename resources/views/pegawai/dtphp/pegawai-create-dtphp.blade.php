<x-pegawai-layout>

        <main class="flex-1 p-6 max-md:p-4 bg-gray-10 border-gray-20 border-[3px] rounded-[20px]">
        <div class="w-full flex items-center gap-2 mb-4">
            <a href="{{ route('pegawai.dtphp.detail.produksi') }}" class="text-decoration-none text-dark flex-shrink-0">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="4" stroke="currentColor" class="w-6 h-6">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 19.5L8.25 12l7.5-7.5" />
                </svg>                      
            </a>
            <h3 class="text-lg font-semibold text-center max-md:text-base">Tambah Data</h3>
        </div>
    
        <div class="bg-bg-white p-4 sm:p-6 rounded-lg shadow-md mt-4">
            <form id="agricultureForm">
                @csrf

                <!-- Jenis Komoditas -->
                <div class="mb-4">
                    <label for="jenis_komoditas" class="block text-sm sm:text-base font-medium text-pink-500 mb-1">Jenis Komoditas</label>
                    <input 
                        type="text" 
                        name="jenis_komoditas" 
                        id="jenis_komoditas"
                        placeholder="Contoh: Padi" 
                        class="w-full border border-gray-300 p-2 rounded-xl focus:ring-2 focus:ring-green-500 focus:border-green-500 transition-colors text-sm sm:text-base"
                        required>
                    <p id="jenis_komoditas_error" class="mt-1 text-xs sm:text-sm text-red-600 hidden"></p>
                </div>
    
                <!-- Volume Produksi -->
                <div class="mb-4">
                    <label for="ton_volume_produksi" class="block text-sm sm:text-base font-medium text-pink-500 mb-1">Volume Produksi (Ton)</label>
                    <input 
                        type="number" 
                        name="ton_volume_produksi" 
                        id="ton_volume_produksi"
                        placeholder="Contoh: 100" 
                        class="w-full border border-gray-300 p-2 rounded-xl focus:ring-2 focus:ring-green-500 focus:border-green-500 transition-colors text-sm sm:text-base"
                        required
                        min="0"
                        step="0.01">
                    <p id="ton_volume_produksi_error" class="mt-1 text-xs sm:text-sm text-red-600 hidden"></p>
                </div>

                <!-- Luas Panen -->
                <div class="mb-4">
                    <label for="hektar_luas_panen" class="block text-sm sm:text-base font-medium text-pink-500 mb-1">Luas Panen (Hektar)</label>
                    <input 
                        type="number" 
                        name="hektar_luas_panen" 
                        id="hektar_luas_panen"
                        placeholder="Contoh: 7" 
                        class="w-full border border-gray-300 p-2 rounded-xl  text-sm sm:text-base"
                        required
                        min="0"
                        step="0.01">
                    <p id="hektar_luas_panen_error" class="mt-1 text-xs sm:text-sm text-red-600 hidden"></p>
                </div>
            </form>
            <!-- Action Buttons -->
            <div class="flex flex-col sm:flex-row justify-between gap-3 mt-6">
                <button id="submitBtn" class="order-1 sm:order-2 w-full sm:w-auto flex items-center justify-center px-4 sm:px-6 py-2 bg-yellow-550 hover:bg-yellow-500 text-white rounded-xl shadow-sm transition-colors duration-200">
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
            url: "{{ route('api.dtphp.store') }}",
            data: {
                _token: "{{ csrf_token() }}",
                jenis_komoditas: $('#jenis_komoditas').val(),
                ton_volume_produksi: $('#ton_volume_produksi').val(),
                hektar_luas_panen: $('#hektar_luas_panen').val(),
                },
            success: function(data) {   
                $('#jenis_komoditas').val('');
                $('#ton_volume_produksi').val('');
                $('#hektar_luas_panen').val('');

                Swal.fire({
                    title: 'Berhasil!',
                    text: `Data ${data.data.jenis_komoditas} telah disimpan.`,
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