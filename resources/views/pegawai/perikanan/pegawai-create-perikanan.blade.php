<x-pegawai-layout>
    <main class="relative flex-1 p-4 sm:p-6">
        <h2 class="text-2xl font-semibold text-green-900">{{ $title }}</h2>
    
        <div class="relative bg-green-50 p-4 sm:p-6 rounded-lg shadow-md mt-4">
            <form id="fishForm">
                @csrf

                <div class="mb-4">
                    <label for="jenis_ikan" class="block text-sm font-medium text-gray-700 mb-1">Jenis Ikan</label>
                    <input 
                        type="text" 
                        name="jenis_ikan" 
                        id="jenis_ikan"
                        placeholder="Contoh: Lele" 
                        class="w-full border border-gray-300 p-2 rounded-full focus:ring-2 focus:ring-green-500 focus:border-green-500 transition-colors">
                </div>
    
                <div class="mb-4">
                    <label for="ton_produksi" class="block text-sm font-medium text-gray-700 mb-1">Volume Produksi (Ton)</label>
                    <input 
                        type="text" 
                        name="ton_produksi" 
                        id="ton_produksi"
                        placeholder="Contoh: 100" 
                        class="w-full border border-gray-300 p-2 rounded-full focus:ring-2 focus:ring-green-500 focus:border-green-500 transition-colors">
                </div>
            </form>
        </div>
        
        <div class="flex justify-between mt-6">
            <a href="{{ route('pegawai.perikanan.detail') }}" class="inline-flex items-center px-6 py-2 bg-green-700 hover:bg-green-800 text-white rounded-full shadow-sm transition-colors duration-200 focus:outline-none focus:ring-2 focus:ring-green-500 focus:ring-offset-2">
                Kembali
            </a>
            <button id="submitBtn" class="inline-flex items-center px-6 py-2 bg-green-700 hover:bg-green-800 text-white rounded-full shadow-sm transition-colors duration-200 focus:outline-none focus:ring-2 focus:ring-green-500 focus:ring-offset-2">
                Tambah
            </button>
        </div>
    </main>

    @push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const submitBtn = document.getElementById('submitBtn');
            const fishForm = document.getElementById('fishForm');
            
            submitBtn.addEventListener('click', async function() {
                try {
                    const response = await fetch("{{ route('api.dp.store') }}", {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'Accept': 'application/json',
                            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                        },
                        body: JSON.stringify({
                            jenis_ikan: document.getElementById('jenis_ikan').value,
                            ton_produksi: document.getElementById('ton_produksi').value
                        })
                    });

                    const data = await response.json();

                    if (!response.ok) {
                        throw data;
                    }

                    fishForm.reset();

                    await Swal.fire({
                        title: 'Berhasil!',
                        text: `Data ${data.data.jenis_ikan} telah disimpan.`,
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
                }
            });
        });
    </script>
    @endpush
</x-pegawai-layout>
