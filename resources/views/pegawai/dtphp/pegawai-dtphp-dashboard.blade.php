<x-pegawai-layout>
    <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-4 gap-6 p-4">
        <!-- Bahan Pokok -->
        <div class="flex w-full h-full bg-white border-[3px] border-gray-200 rounded-lg ">
          <div class="w-32 h-40 bg-pink-500 flex items-center justify-center rounded-lg">
            <iconify-icon icon="healthicons:vegetables" class="text-white text-8xl"></iconify-icon>
          </div>
          <div class="flex flex-col justify-center pl-5">
            <p class="text-xl text-black font-bold mb-1 ">Jumlah Bahan Pokok</p>
            <p class="text-3xl text-gray-900 font-bold text-center">30</p>
          </div>
        </div>
      
        <!-- Komoditas -->
        <div class="flex w-full h-full bg-white border-[3px] border-gray-200 rounded-lg ">
          <div class="w-32 h-40 bg-pink-500 flex items-center justify-center rounded-lg">
            <iconify-icon icon="carbon:agriculture-analytics" class="text-white text-8xl"></iconify-icon>
          </div>
          <div class="flex flex-col justify-center pl-5">
            <p class="text-xl text-black font-bold mb-1">Jumlah Komoditas</p>
            <p class="text-3xl text-gray-900 font-bold text-center">30</p>
          </div>
        </div>
      
        <!-- Ikan -->
        <div class="flex w-full h-full bg-white border-[3px] border-gray-200 rounded-lg ">
          <div class="w-32 h-40 bg-pink-500 flex items-center justify-center rounded-lg">
            <iconify-icon icon="majesticons:fish" class="text-white text-8xl"></iconify-icon>
          </div>
          <div class="flex flex-col justify-center pl-5">
            <p class="text-xl text-black font-bold mb-1">Jumlah Ikan</p>
            <p class="text-3xl text-gray-900 font-bold text-center">30</p>
          </div>
        </div>
      
        <!-- Pegawai Dinas -->
        <div class="flex w-full h-full bg-white border-[3px] border-gray-200 rounded-lg ">
          <div class="w-32 h-40 bg-pink-500 flex items-center justify-center rounded-lg">
            <iconify-icon icon="material-symbols:group" class="text-white text-8xl"></iconify-icon>
          </div>
          <div class="flex flex-col justify-center pl-5">
            <p class="text-xl text-black font-bold mb-1">Jumlah Pegawai Dinas</p>
            <p class="text-3xl text-gray-900 font-bold text-center">30</p>
          </div>
        </div>
      </div>


      <!-- Tombol Switch -->
      <div class="flex w-full overflow-x-auto ml-4">
        <a href="{{ route('pegawai.dtphp.dashboard') }}">
            <button class="text-pink-500 rounded-t-xl bg-white px-4 py-3 shadow-md text-sm border bg-gray-10 border-gray-20 {{ request()->routeIs('dtphp.detail.produksi') ? 'font-bold' : '' }} max-md:text-xs max-md:px-3 max-md:py-2">
                Volume Produksi
            </button>
        </a>
        <a href="{{ route('pegawai.dtphp.dashboard') }}">
            <button class="text-gray-400 rounded-t-xl bg-gray-100 px-4 py-3 shadow-md text-sm border bg-gray-10 border-gray-20 {{ request()->routeIs('dtphp.detail.panen') ? 'font-bold' : '' }} max-md:text-xs max-md:px-3 max-md:py-2">
                Luas Panen
            </button>
        </a>
    </div>
      <!-- table -->
      <div class="bg-white border rounded-lg p-4 mb-8 ">
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