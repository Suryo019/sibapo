<x-pegawai-layout>

    <div class="grid grid-cols-3 gap-4 mb-6">
        <!-- Chart Placeholder -->
        <div class="col-span-2 bg-white border rounded-lg p-4">
          <div class="w-full h-64 bg-gray-100 flex items-center justify-center text-gray-400">
            [Grafik Line Chart]
          </div>
          <div class="flex mt-4 justify-center gap-4 text-sm">
            <div class="flex items-center gap-2"><div class="w-4 h-2 bg-green-500"></div>Surplus</div>
            <div class="flex items-center gap-2"><div class="w-4 h-2 bg-red-500"></div>Defisit</div>
            <div class="flex items-center gap-2"><div class="w-4 h-2 bg-blue-500"></div>Seimbang</div>
          </div>
        </div>
    
        <!-- Donatt Chart Placeholder -->
        <div class="bg-white border rounded-lg p-4">
          <div class="text-center font-semibold mb-4">Total komoditas ketahanan pangan</div>
          <div class="w-full flex justify-center mb-2">
            <div class="w-32 h-32 rounded-full bg-gray-100 flex items-center justify-center text-2xl font-bold text-gray-600">
              100
            </div>
          </div>
          <div class="flex justify-center gap-6 text-sm mt-2">
            <div class="flex items-center gap-2"><div class="w-3 h-3 bg-green-500 rounded-full"></div>30% Surplus</div>
            <div class="flex items-center gap-2"><div class="w-3 h-3 bg-red-500 rounded-full"></div>45% Defisit</div>
            <div class="flex items-center gap-2"><div class="w-3 h-3 bg-blue-500 rounded-full"></div>25% Seimbang</div>
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
              <th class="p-2">Ketersediaan Minggu ini</th>
              <th class="p-2">Ketersediaan Minggu lalu</th>
            </tr>
          </thead>
          <tbody>
            <tr class="border-t">
              <td class="p-2">1</td>
              <td class="p-2">beras</td>
              <td class="p-2"><iconify-icon icon="twemoji:up-arrow" class=" text-xl"></iconify-icon></td>
              <td class="p-2 text-green-500">Surplus</td>
              <td class="p-2 text-red-500">Defisit</td>
            </tr>
            <tr class="border-t">
              <td class="p-2">2</td>
              <td class="p-2">beras</td>
              <td class="p-2"><iconify-icon icon="twemoji:up-arrow" class=" text-xl"></iconify-icon></td>
              <td class="p-2 text-red-500">Defisit</td>
              <td class="p-2 text-green-500">Surplus</td>
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
  
  </x-pegawai-layout>>