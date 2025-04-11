<x-admin-layout>
    <main class="flex-1 p-6">
        <h2 class="text-2xl font-semibold text-green-900">{{ $title }}</h2>
    
        <div class="bg-white p-6 rounded shadow-md mt-4">
            <form>
                <!-- Nama Pasar -->
                <div class="mb-4">
                    <label class="block text-gray-700">Nama Pasar</label>
                    <input type="text" placeholder="Contoh: Pasar Tanjung" 
                           class="border p-2 w-full rounded">
                </div>
    
                <!-- Jenis Bahan Pokok -->
                <div class="mb-4">
                    <label class="block text-gray-700">Jenis Bahan Pokok</label>
                    <input type="text" placeholder="Contoh: Daging" 
                           class="border p-2 w-full rounded">
                </div>
    
                <!-- Harga Barang -->
                <div class="mb-4">
                    <label class="block text-gray-700">Harga Barang</label>
                    <input type="text" placeholder="Contoh: Rp. 100.000,-" 
                           class="border p-2 w-full rounded">
                </div>
    
                <!-- Tombol -->
                <div class="flex justify-between mt-4">
                    <a href="Detail.html">
                    <button type="button" class="bg-green-700 text-white px-6 py-2 rounded hover:bg-green-800">Kembali</button>
                    </a>
                    <button type="submit" class="bg-green-700 text-white px-6 py-2 rounded hover:bg-green-800">Tambah</button>
                </div>
            </form>
        </div>
    </main>
</x-admin-layout>