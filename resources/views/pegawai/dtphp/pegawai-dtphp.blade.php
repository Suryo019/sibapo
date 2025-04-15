<x-pegawai-layout>
    <main class="flex-1 p-6">
        <h2 class="text-2xl font-semibold text-green-900">Data Produksi Tanaman</h2>
    
        <!-- Dropdown -->
        <div class="flex justify-between my-4">
            <div class="relative"> <!--tambahan ben opsi bisa dikanan-->
            </div>
            <div class="flex gap-4">
                <div>
                    <label for="pilih_komoditas" class="block text-sm font-medium text-gray-700 mb-1">Pilih Komoditas</label>
                    <select class="border p-2 rounded bg-white" id="pilih_komoditas">
                        <option>Suket Teki</option>
                    </select>
                </div>
                <div>
                    <label for="pilih_periode" class="block text-sm font-medium text-gray-700 mb-1">Pilih Periode</label>
                    <select class="border p-2 rounded bg-white" id="pilih_periode">
                        <option>Januari 2025</option>
                    </select>
                </div>
            </div>
        </div>
        
        <!-- Chart Placeholder -->
        <div class="w-full h-64 bg-white rounded shadow-md flex items-center justify-center">
            <p class="text-gray-400">[Chart Placeholder]</p>
        </div>
    
        <!-- Button -->
        <div class="flex justify-center mt-4">
            <a href="{{ route('pegawai.dtphp.produksi') }}">
                <button class="bg-green-700 text-white px-6 py-2 rounded-full hover:bg-green-800">
                    Lihat Detail Data
                </button>
            </a>
        </div>
    </main>
</x-pegawai-layout>