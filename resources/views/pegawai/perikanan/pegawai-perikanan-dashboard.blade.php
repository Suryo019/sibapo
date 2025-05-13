<x-pegawai-layout>

    <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-6 p-2">
        <!-- Bahan Pokok -->
        <div class="flex w-full h-full bg-white border-[3px] border-gray-200 rounded-lg">
          <div class="w-32 h-40 bg-pink-500 flex items-center justify-center rounded-lg ">
            <iconify-icon icon="majesticons:fish" class="text-white text-8xl"></iconify-icon>
          </div>
          <div class="flex flex-col justify-center px-4">
            <p class="text-xl text-black font-bold mb-1">Jumlah Ikan</p>
            <p class="text-3xl text-gray-900 font-bold text-center">30</p>
          </div>
        </div>
      
        <!-- jumlah pasar -->
        <div class="flex w-full h-full bg-white border-[3px] border-gray-200 rounded-lg">
          <div class="w-32 h-40 bg-pink-500 flex items-center justify-center rounded-lg ">
            <iconify-icon icon="lsicon:marketplace-filled" class="text-white text-8xl"></iconify-icon>
          </div>
          <div class="flex flex-col justify-center px-4">
            <p class="text-xl text-black font-bold mb-1">Total Volume Produksi</p>
            <p class="text-3xl text-gray-900 font-bold text-center">1000 TON</p>
          </div>
        </div>
      
        <!-- jumlah pegawai dinas disperindag -->
        <div class="flex w-full h-full bg-white border-[3px] border-gray-200 rounded-lg">
          <div class="w-32 h-40 bg-pink-500 flex items-center justify-center rounded-lg ">
            <iconify-icon icon="material-symbols:group" class="text-white text-8xl"></iconify-icon>
          </div>
          <div class="flex flex-col justify-center px-4">
            <p class="text-xl text-black font-bold mb-1">Jumlah Pegawai Dinas Perikanan</p>
            <p class="text-3xl text-gray-900 font-bold text-center">30</p>
          </div>
        </div>
      </div>


      <!-- table -->
      <div class="bg-white border rounded-lg p-4 mb-8 mt-4">
        <table class="w-full text-center text-sm">
          <thead >
            <tr>
              <th class="p-2">No</th>
              <th class="p-2">Bahan Pokok</th>
              <th class="p-2">Ket</th>
              <th class="p-2">Volume produksi bulan ini</th>
              <th class="p-2">perubahan produksi</th>
            </tr>
          </thead>
          <tbody>
            <tr class="border-t">
              <td class="p-2">1</td>
              <td class="p-2">beras</td>
              <td class="p-2"><iconify-icon icon="twemoji:up-arrow" class=" text-xl"></iconify-icon></td>
              <td class="p-2 ">1000 TON</td>
              <td class="p-2 ">+ 10 TON</td>
            </tr>
            <tr class="border-t">
              <td class="p-2">2</td>
              <td class="p-2">beras</td>
              <td class="p-2"><iconify-icon icon="twemoji:up-arrow" class=" text-xl"></iconify-icon></td>
              <td class="p-2">1000 TON</td>
              <td class="p-2">- 10 TON</td>
            </tr>
          </tbody>
        </table>
      </div>


      <!-- TABLE -->
    <div class="bg-white border rounded-lg p-4">
        <table class="w-full text-center text-sm">
          <thead >
            <tr>
              <th class="p-2">Waktu</th>
              <th class="p-2">Ikon</th>
              <th class="p-2">Aktivitas</th>
              <th class="p-2">User</th>
              <th class="p-2">Role</th>
            </tr>
          </thead>
          <tbody>
            <tr class="border-t">
              <td class="p-2">3 Minggu yang lalu</td>
              <td class="p-2"><iconify-icon icon="flat-color-icons:plus" class=" text-xl"></iconify-icon></td>
              <td class="p-2">Menambah komoditas tanaman</td>
              <td class="p-2">Ismail bin Mail</td>
              <td class="p-2">Disperindag</td>
            </tr>
            <tr class="border-t">
              <td class="p-2">3 Minggu yang lalu</td>
              <td class="p-2"><iconify-icon icon="flat-color-icons:plus" class=" text-xl"></iconify-icon></td>
              <td class="p-2">Menambah komoditas tanaman</td>
              <td class="p-2">Ismail bin Mail</td>
              <td class="p-2">Disperindag</td>
            </tr>
            <tr class="border-t">
              <td class="p-2">3 Minggu yang lalu</td>
              <td class="p-2"><iconify-icon icon="flat-color-icons:plus" class=" text-xl"></iconify-icon></td>
              <td class="p-2">Menambah komoditas tanaman</td>
              <td class="p-2">Ismail bin Mail</td>
              <td class="p-2">Disperindag</td>
            </tr>
            <tr class="border-t">
              <td class="p-2">3 Minggu yang lalu</td>
              <td class="p-2"><iconify-icon icon="flat-color-icons:plus" class=" text-xl"></iconify-icon></td>
              <td class="p-2">Menambah komoditas tanaman</td>
              <td class="p-2">Ismail bin Mail</td>
              <td class="p-2">Disperindag</td>
            </tr>
          </tbody>
        </table>
      </div>
      
</x-pegawai-layout>