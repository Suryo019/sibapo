<x-admin-layout>
    <main class="flex-1 p-6">
        <h2 class="text-2xl font-semibold text-green-900">{{ $title }}</h2>
    
        <div class="bg-white p-6 rounded shadow-md mt-4">
            <form action="{{ route('api.dtphp.store') }}" method="post">
                @csrf
                <div class="mb-4">
                    <label class="block text-gray-700">Jenis Komoditas</label>
                    <input type="text" placeholder="Contoh: Padi" 
                           class="border p-2 w-full rounded" id="jenis_komoditas">
                </div>
    
                <div class="mb-4">
                    <label class="block text-gray-700">Volume Produksi (Ton)</label>
                    <input type="text" placeholder="Contoh: 100" 
                           class="border p-2 w-full rounded" id="ton_volume_produksi">
                </div>

                <div class="mb-4">
                    <label class="block text-gray-700">Luas Panen (Hektar)</label>
                    <input type="text" placeholder="Contoh: 7" 
                           class="border p-2 w-full rounded" id="hektar_luas_panen">
                </div>

                <!-- Terakhir Diubah -->
                <div class="mb-4">
                    <label class="block text-gray-700">Terakhir Diubah</label>
                    <div class="relative">
                        <input type="date" class="border p-2 w-full rounded">
                    </div>
                </div>                

                <!-- Tombol -->
                <div class="flex justify-between mt-4">
                    <a href="Detail.html">
                    <button type="button" class="bg-green-700 text-white px-6 py-2 rounded hover:bg-green-800">Kembali</button>
                    </a>
                    <button type="submit" id="submitBtn" class="bg-green-700 text-white px-6 py-2 rounded hover:bg-green-800">Tambah</button>
                </div>
            </form>
        </div>
    </main>
</x-admin-layout>