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

    @push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const submitBtn = document.getElementById('submitBtn');
            const form = document.getElementById('agricultureForm');
            
            // Form validation
            function validateForm() {
                let isValid = true;
                
                // Validate Jenis Komoditas
                if (!document.getElementById('jenis_komoditas').value.trim()) {
                    document.getElementById('jenis_komoditas_error').textContent = 'Jenis komoditas harus diisi';
                    document.getElementById('jenis_komoditas_error').classList.remove('hidden');
                    isValid = false;
                } else {
                    document.getElementById('jenis_komoditas_error').classList.add('hidden');
                }
                
                // Validate Volume Produksi
                const volumeProduksi = document.getElementById('ton_volume_produksi');
                if (!volumeProduksi.value || isNaN(volumeProduksi.value) || parseFloat(volumeProduksi.value) <= 0) {
                    document.getElementById('ton_volume_produksi_error').textContent = 'Harus berupa angka positif';
                    document.getElementById('ton_volume_produksi_error').classList.remove('hidden');
                    isValid = false;
                } else {
                    document.getElementById('ton_volume_produksi_error').classList.add('hidden');
                }
                
                // Validate Luas Panen
                const luasPanen = document.getElementById('hektar_luas_panen');
                if (!luasPanen.value || isNaN(luasPanen.value) || parseFloat(luasPanen.value) <= 0) {
                    document.getElementById('hektar_luas_panen_error').textContent = 'Harus berupa angka positif';
                    document.getElementById('hektar_luas_panen_error').classList.remove('hidden');
                    isValid = false;
                } else {
                    document.getElementById('hektar_luas_panen_error').classList.add('hidden');
                }
                
                return isValid;
            }
            
            submitBtn.addEventListener('click', async function() {
                if (!validateForm()) return;
                
                // Disable button during submission
                submitBtn.disabled = true;
                submitBtn.innerHTML = `
                    <svg class="animate-spin -ml-1 mr-2 h-5 w-5 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                        <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                        <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                    </svg>
                    Memproses...
                `;
                
                try {
                    const response = await fetch("{{ route('api.dtphp.store') }}", {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'Accept': 'application/json',
                            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                        },
                        body: JSON.stringify({
                            jenis_komoditas: document.getElementById('jenis_komoditas').value.trim(),
                            ton_volume_produksi: parseFloat(document.getElementById('ton_volume_produksi').value),
                            hektar_luas_panen: parseFloat(document.getElementById('hektar_luas_panen').value)
                        })
                    });

                    const data = await response.json();

                    if (!response.ok) throw data;

                    // Reset form
                    form.reset();

                    await Swal.fire({
                        title: 'Berhasil!',
                        text: `Data ${data.data.jenis_komoditas} telah disimpan.`,
                        icon: 'success',
                        confirmButtonText: 'OK'
                    });

                } catch (error) {
                    let message = 'Terjadi kesalahan saat menyimpan data';
                    
                    if (error.errors) {
                        message = Object.values(error.errors).join('<br>');
                    }

                    await Swal.fire({
                        icon: 'error',
                        title: 'Oops...',
                        html: message
                    });
                    
                    // Re-enable button
                    submitBtn.disabled = false;
                    submitBtn.innerHTML = `
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" viewBox="0 0 20 20" fill="currentColor">
                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm1-11a1 1 0 10-2 0v2H7a1 1 0 100 2h2v2a1 1 0 102 0v-2h2a1 1 0 100-2h-2V7z" clip-rule="evenodd" />
                        </svg>
                        Tambah Data
                    `;
                }
            });
        });
    </script>
    @endpush
</x-pegawai-layout>