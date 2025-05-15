{{-- @dd($jmlPegawai) --}}

<x-pegawai-layout>
    <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-6 p-2">
        <!-- Bahan Pokok -->
        <div class="flex w-full h-full bg-white border-[3px] border-gray-200 rounded-lg">
          <div class="w-32 h-40 bg-pink-500 flex items-center justify-center rounded-lg ">
            <iconify-icon icon="healthicons:vegetables" class="text-white text-8xl"></iconify-icon>
          </div>
          <div class="flex flex-col justify-center px-4">
            <p class="text-xl text-black font-bold mb-1">Jumlah Bahan Pokok</p>
            <p class="text-3xl text-gray-900 font-bold text-center">{{ $jmlBahanPokok }}</p>
          </div>
        </div>
      
        <!-- jumlah pasar -->
        <div class="flex w-full h-full bg-white border-[3px] border-gray-200 rounded-lg">
          <div class="w-32 h-40 bg-pink-500 flex items-center justify-center rounded-lg ">
            <iconify-icon icon="carbon:agriculture-analytics" class="text-white text-8xl"></iconify-icon>
          </div>
          <div class="flex flex-col justify-center px-4">
            <p class="text-xl text-black font-bold mb-1">Jumlah Pasar</p>
            <p class="text-3xl text-gray-900 font-bold text-center">{{ $jmlPasar }}</p>
          </div>
        </div>
      
        <!-- jumlah pegawai dinas disperindag -->
        <div class="flex w-full h-full bg-white border-[3px] border-gray-200 rounded-lg">
          <div class="w-32 h-40 bg-pink-500 flex items-center justify-center rounded-lg ">
            <iconify-icon icon="material-symbols:group" class="text-white text-8xl"></iconify-icon>
          </div>
          <div class="flex flex-col justify-center px-4">
            <p class="text-xl text-black font-bold mb-1">Jumlah Pegawai Dinas Disperindag</p>
            <p class="text-3xl text-gray-900 font-bold text-center">{{ $jmlPegawai }}</p>
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
              <th class="p-2">Harga Rata-rata hari ini</th>
              <th class="p-2">Perubahan harga</th>
            </tr>
          </thead>
          <tbody>
            <tr class="border-t">
              <td class="p-2">1</td>
              <td class="p-2">beras</td>
              <td class="p-2"><iconify-icon icon="twemoji:up-arrow" class=" text-xl"></iconify-icon></td>
              <td class="p-2">Rp. 10.000</td>
              <td class="p-2">+ Rp. 10.000</td>
            </tr>
            <tr class="border-t">
              <td class="p-2">4</td>
              <td class="p-2">beras</td>
              <td class="p-2"><iconify-icon icon="flat-color-icons:plus" class=" text-xl"></iconify-icon></td>
              <td class="p-2">Rp. 10.000</td>
              <td class="p-2">-Rp. 1.500</td>
            </tr>
          </tbody>
        </table>
      </div>
  
    <!-- table -->
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
          @foreach ($aktivitas as $item)
            @php
                $ikonAksi = [
                    'buat' => 'bi-plus-circle-fill',
                    'ubah' => 'bi-pencil-square',
                    'hapus' => 'bi-trash-fill',
                ];
                $ikon = $ikonAksi[$item->aksi] ?? 'bi-question-circle-fill'
            @endphp
              
              <tr class="border-t">
                <td class="p-2">{{ $item->waktu }}</td>
                <td class="p-2 flex justify-center">
                    <div class="bg-yellow-500 rounded flex justify-center items-center w-10 h-10 p-2">
                        <i class="bi {{ $ikon }} text-white"></i>
                    </div>
                </td>
                <td class="p-2">{{ $item->aktivitas }}</td>
                <td class="p-2">{{ $item->nama_user }}</td>
                <td class="p-2">{{ $item->dinas }}</td>
            </tr>
          @endforeach
        </tbody>
      </table>

      <!-- Link Paginasi -->
      <div class="d-flex justify-content-center">
          {{ $aktivitas->links() }}
      </div>
    </div>
  
  </x-pegawai-layout>>