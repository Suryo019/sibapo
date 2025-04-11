<x-admin-layout>
    <main class="flex-1 p-6">
        <h2 class="text-2xl font-semibold text-green-900">Data Produksi Tanaman</h2>
    
        <!-- Dropdown -->
        <div class="flex justify-between my-4">
            <div class="relative"> <!--tambahan ben opsi bisa dikanan-->
            </div>
            <div class="flex gap-4">
                <select class="border p-2 rounded bg-white">
                    <option>Pilih Pasar</option>
                    <option>Pasar Tanjung</option>
                </select>
                <select class="border p-2 rounded bg-white">
                    <option>Pilih Periode</option>
                    <option>Januari 2025</option>
                </select>
            </div>
        </div>
        
        <!-- Chart Placeholder -->
        <div class="w-full h-64 bg-white rounded shadow-md flex items-center justify-center">
            <p class="text-gray-400">[Chart Placeholder]</p>
        </div>
    
        <!-- Button -->
        <div class="flex justify-center mt-4">
            <a href="/Public/DTPHP/">
                <button class="bg-green-700 text-white px-6 py-2 rounded hover:bg-green-800">
                    Lihat Detail Data
                </button>
            </a>
        </div>
    </main>
</x-admin-layout>