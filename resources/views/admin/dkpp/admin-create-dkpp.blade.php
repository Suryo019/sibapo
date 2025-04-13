<x-admin-layout>
    <main class="flex-1 p-6">
        <h2 class="text-2xl font-semibold text-green-900">{{ $title }}</h2>
    
        <div class="bg-white p-6 rounded shadow-md mt-4">
            <form>
                <div class="mb-4">
                    <label class="block text-gray-700">Jenis Komoditas</label>
                    <input type="text" placeholder="Contoh: Daging" 
                           class="border p-2 w-full rounded">
                </div>
    
                <div class="mb-4">
                    <label class="block text-gray-700">Ketersediaan (Ton)</label>
                    <input type="text" placeholder="Contoh: 100" 
                           class="border p-2 w-full rounded">
                </div>

                <div class="mb-4">
                    <label class="block text-gray-700">Kebutuhan Perminggu (Ton)</label>
                    <input type="text" placeholder="Contoh: 100" 
                           class="border p-2 w-full rounded">
                </div>

                <div class="mb-4"></div>
                    <label class="block text-gray-700">Neraca Mingguan (Ton)</label>
                    <input type="text" placeholder="Contoh: 100" 
                           class="border p-2 w-full rounded">
                </div>
    
                <!-- Tombol -->
                <div class="flex justify-between mt-4">
                    <a href="Detail.html">
                    <button type="button" class="bg-green-700 text-white px-6 py-2 rounded-full hover:bg-green-800">Kembali</button>
                    </a>
                    <button type="submit" class="bg-green-700 text-white px-6 py-2 rounded-full hover:bg-green-800">Tambah</button>
                </div>
            </form>
        </div>
    </main>
</x-admin-layout>