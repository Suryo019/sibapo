<x-admin-layout>
    <main class="flex-1 p-4 sm:p-6">
        {{-- <h2 class="text-2xl font-semibold text-green-900">{{ $title }}</h2> --}}
    
        <main class="flex-1 p-6 max-md:p-4 bg-gray-10 border-gray-20 border-[3px] rounded-[20px]">
            <div class="w-full flex items-center gap-2 mb-4">
                <a href="{{ route('perikanan.detail') }}" class="text-decoration-none text-dark flex-shrink-0">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="4" stroke="currentColor" class="w-6 h-6">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 19.5L8.25 12l7.5-7.5" />
                    </svg>                      
                </a>
                <h3 class="text-lg font-semibold text-center max-md:text-base">Ubah Data</h3>
            </div>
        <div class="bg-white p-4 sm:p-6 rounded-lg shadow-md mt-4">
            <form id="editFishForm">
                @csrf
                @method('PUT')

                <!-- Jenis Ikan -->
                <div class="mb-4">
                    <label for="jenis_ikan" class="block text-sm font-medium text-pink-500 mb-1">Jenis Ikan</label>
                    <input 
                        type="text" 
                        name="jenis_ikan" 
                        id="jenis_ikan"
                        value="{{ old('jenis_ikan', $data->jenis_ikan) }}"
                        placeholder="Contoh: Lele" 
                        class="w-full border border-gray-300 p-2 rounded-full focus:ring-2 focus:ring-green-500 focus:border-green-500 transition-colors"
                        required>
                    <p id="jenis_ikan_error" class="mt-1 text-sm text-red-600 hidden"></p>
                </div>
    
                <!-- Volume Produksi -->
                <div class="mb-4">
                    <label for="ton_produksi" class="block text-sm font-medium text-pink-500 mb-1">Volume Produksi (Ton)</label>
                    <input 
                        type="number" 
                        name="ton_produksi" 
                        id="ton_produksi"
                        value="{{ old('ton_produksi', $data->ton_produksi) }}"
                        placeholder="Contoh: 100" 
                        class="w-full border border-gray-300 p-2 rounded-full focus:ring-2 focus:ring-green-500 focus:border-green-500 transition-colors"
                        required
                        min="0"
                        step="0.01">
                    <p id="ton_produksi_error" class="mt-1 text-sm text-red-600 hidden"></p>
                </div>

                <!-- Tanggal Input -->
                <div class="mb-4">
                    <label for="tanggal_input" class="block text-sm font-medium text-pink-500 mb-1">Tanggal Input</label>
                    <input 
                        type="date" 
                        name="tanggal_input" 
                        id="tanggal_input"
                        value="{{ old('tanggal_input', \Carbon\Carbon::parse($data->tanggal_input)->format('Y-m-d')) }}"
                        class="w-full border border-gray-300 p-2 rounded-full focus:ring-2 focus:ring-green-500 focus:border-green-500 transition-colors"
                        required>
                    <p id="tanggal_input_error" class="mt-1 text-sm text-red-600 hidden"></p>
                </div>
            </form>
        </div>
        
        <!-- Action Buttons -->
        <div class="flex justify-between mt-6">
            <button id="submitBtn" class="inline-flex items-center px-6 py-2 bg-yellow-550 hover:bg-yellow-500 text-white rounded shadow-sm transition-colors duration-200 focus:outline-none focus:ring-2 focus:ring-green-500 focus:ring-offset-2 disabled:opacity-50">
                Simpan 
            </button>
        </div>
    </main>

    @push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const submitBtn = document.getElementById('submitBtn');
            const editFishForm = document.getElementById('editFishForm');
            const jenisIkanInput = document.getElementById('jenis_ikan');
            const tonProduksiInput = document.getElementById('ton_produksi');
            const tanggalInput = document.getElementById('tanggal_input');
            
            // Form validation
            function validateForm() {
                let isValid = true;
                
                // Validate Jenis Ikan
                if (!jenisIkanInput.value.trim()) {
                    document.getElementById('jenis_ikan_error').textContent = 'Jenis ikan harus diisi';
                    document.getElementById('jenis_ikan_error').classList.remove('hidden');
                    isValid = false;
                } else {
                    document.getElementById('jenis_ikan_error').classList.add('hidden');
                }
                
                // Validate Ton Produksi
                if (!tonProduksiInput.value || isNaN(tonProduksiInput.value) || parseFloat(tonProduksiInput.value) <= 0) {
                    document.getElementById('ton_produksi_error').textContent = 'Volume produksi harus berupa angka positif';
                    document.getElementById('ton_produksi_error').classList.remove('hidden');
                    isValid = false;
                } else {
                    document.getElementById('ton_produksi_error').classList.add('hidden');
                }
                
                // Validate Tanggal Input
                if (!tanggalInput.value) {
                    document.getElementById('tanggal_input_error').textContent = 'Tanggal input harus diisi';
                    document.getElementById('tanggal_input_error').classList.remove('hidden');
                    isValid = false;
                } else {
                    document.getElementById('tanggal_input_error').classList.add('hidden');
                }
                
                return isValid;
            }
            
            submitBtn.addEventListener('click', async function() {
                // Validate form first
                if (!validateForm()) {
                    return;
                }
                
                // Disable button during submission
                submitBtn.disabled = true;
                submitBtn.innerHTML = `
                    <svg class="animate-spin -ml-1 mr-2 h-5 w-5 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                        <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                        <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                    </svg>
                    Menyimpan...
                `;
                
                try {
                    const response = await fetch("{{ route('api.dp.update', $data->id) }}", {
                        method: 'PUT',
                        headers: {
                            'Content-Type': 'application/json',
                            'Accept': 'application/json',
                            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                            'X-HTTP-Method-Override': 'PUT'
                        },
                        body: JSON.stringify({
                            jenis_ikan: jenisIkanInput.value.trim(),
                            ton_produksi: parseFloat(tonProduksiInput.value),
                            tanggal_input: tanggalInput.value
                        })
                    });

                    const data = await response.json();

                    if (!response.ok) {
                        throw data;
                    }

                    // Show success message
                    await Swal.fire({
                        title: 'Berhasil!',
                        text: `Data ${data.data.jenis_ikan} berhasil diperbarui!`,
                        icon: 'success',
                        confirmButtonText: 'OK',
                        confirmButtonColor: '#16a34a'
                    });

                    // Redirect to detail page
                    window.location.href = "{{ route('perikanan.detail') }}";

                } catch (error) {
                    let message = 'Terjadi kesalahan saat menyimpan perubahan';
                    
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
                            <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd" />
                        </svg>
                        Simpan Perubahan
                    `;
                }
            });
        });
    </script>
    @endpush
</x-admin-layout>