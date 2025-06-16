<x-pegawai-layout title="Dashboard">

  <h1 class="block md:hidden text-center text-2xl font-bold text-black px-4 py-2">
    DASHBOARD
  </h1>
  <div class="grid grid-cols-3 gap-4 p-2 md:grid-cols-3">
    <!-- Jumlah Ikan -->
    <div class="flex flex-col md:flex-row w-full bg-white border-[3px] border-gray-200 rounded-lg overflow-hidden">
      <div class="w-full h-24 md:w-32 md:h-40 bg-pink-500 flex items-center justify-center rounded-lg">
        <iconify-icon icon="majesticons:fish" class="text-white text-3xl md:text-6xl"></iconify-icon>
      </div>
      <div class="flex flex-col justify-center items-center md:items-start px-2 py-2 text-center md:text-left">
        <p class="text-xs md:text-xl font-bold text-black mb-1">Jumlah Ikan</p>
        <p class="text-lg md:text-3xl font-bold text-gray-900">{{ $jmlIkan }}</p>
      </div>
    </div>
  
    <!-- Total Volume Produksi -->
    <div class="flex flex-col md:flex-row w-full bg-white border-[3px] border-gray-200 rounded-lg overflow-hidden">
      <div class="w-full h-24 md:w-32 md:h-40 bg-pink-500 flex items-center justify-center rounded-lg">
        <iconify-icon icon="lsicon:marketplace-filled" class="text-white text-3xl md:text-6xl"></iconify-icon>
      </div>
      <div class="flex flex-col justify-center items-center md:items-start px-2 py-2 text-center md:text-left">
        <p class="text-xs md:text-xl font-bold text-black mb-1">Total Volume Produksi</p>
        <p class="text-lg md:text-3xl font-bold text-gray-900">{{ $jmlProduksi }}</p>
      </div>
    </div>
  
    <!-- Jumlah Pegawai Dinas -->
    <div class="flex flex-col md:flex-row w-full bg-white border-[3px] border-gray-200 rounded-lg overflow-hidden">
      <div class="w-full h-24 md:w-32 md:h-40 bg-pink-500 flex items-center justify-center rounded-lg">
        <iconify-icon icon="material-symbols:group" class="text-white text-3xl md:text-6xl"></iconify-icon>
      </div>
      <div class="flex flex-col justify-center items-center md:items-start px-2 py-2 text-center md:text-left">
        <p class="text-xs md:text-xl font-bold text-black mb-1">Jumlah Pegawai Dinas</p>
        <p class="text-lg md:text-3xl font-bold text-gray-900">{{ $jmlPegawai }}</p>
      </div>
    </div>
  </div>

      <!-- table -->
      <div class="bg-white md:border rounded-lg p-4 mb-8 mt-4">
        <!-- DEKSTOP -->
        <div class="hidden md:block">
          <table class="w-full text-center text-sm">
            <thead>
              <tr>
                <th class="p-2">No</th>
                <th class="p-2">Jenis Ikan</th>
                <th class="p-2">Ket</th>
                <th class="p-2">Volume produksi bulan ini</th>
                <th class="p-2">perubahan produksi</th>
              </tr>
            </thead>
            <tbody>
              @foreach ($dataTabel ?? [] as $item)
                <tr class="border-t">
                  <td class="p-2">{{ $item['no'] }}</td>
                  <td class="p-2">{{ ucfirst($item['jenisIkan']) }}</td>
                  <td class="p-2">
                    <iconify-icon icon="{{ $item['icon'] }}" class="text-xl"></iconify-icon>
                  </td>
                  <td class="p-2">{{ number_format($item['volume']) }} TON</td>
                  <td class="p-2">
                    {{ $item['perubahan'] > 0 ? '+' : '' }}{{ number_format($item['perubahan']) }} TON
                  </td>
                </tr>
              @endforeach
            </tbody>
          </table>
        </div>
      
        <!-- MOBILE -->
        <div class="md:hidden space-y-4">
          <div class="block md:hidden text-lg font-semibold mb-2">Produk Ikan</div>
          @foreach ($dataTabel ?? [] as $item)
            <div class="flex items-center justify-between border rounded-lg p-3 shadow-sm">
              <div class="flex items-center space-x-3">
                <div class="rounded-full p-2 bg-blue-100 text-blue-600">
                  <iconify-icon icon="{{ $item['icon'] }}" class="text-xl"></iconify-icon>
                </div>
                <div>
                  <div class="font-medium">{{ ucfirst($item['jenisIkan']) }}</div>
                  <div class="text-gray-500 text-sm">Volume: {{ number_format($item['volume']) }} TON</div>
                </div>
              </div>
              <div class="{{ $item['perubahan'] >= 0 ? 'text-green-600' : 'text-red-600' }} font-semibold text-sm whitespace-nowrap">
                {{ $item['perubahan'] > 0 ? '+' : '' }}{{ number_format($item['perubahan']) }} TON
              </div>
            </div>
          @endforeach
        </div>
      
        <!-- Link Paginasi -->
        <div class="d-flex justify-content-center mt-4">
          {{ $dataTabel->links() }}
        </div>
      </div>
      


      <!-- TABLE -->
      <div class="bg-white md:border rounded-lg p-4">
        <!-- DESKTOP: Tabel Riwayat -->
        <div class="hidden md:block">
          <table class="w-full text-center text-sm mb-4">
            <thead>
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
                $warnaDinas = [
                  'DTPHP'     => 'bg-green-600',
                  'DKPP'      => 'bg-red-500',
                  'DISPERINDAG'=> 'bg-yellow-500',
                  'PERIKANAN' => 'bg-teal-500',
                ];

                $ikonAksi = [
                  'buat' => 'bi-plus-circle-fill',
                  'ubah' => 'bi-pencil-square',
                  'hapus' => 'bi-trash-fill',
                ];

                $bgColor = $warnaDinas[$item->dinas] ?? 'bg-gray-400';
                $ikon = $ikonAksi[$item->aksi] ?? 'bi-question-circle-fill';
              @endphp
      
                <tr class="border-t">
                  <td class="p-2">{{ $item->waktu }}</td>
                  <td class="p-2 flex justify-center">
                    <div class="{{ $bgColor }} rounded flex justify-center items-center w-10 h-10 p-2">
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
        </div>
      
        <!-- MOBILE: Card Riwayat -->
        <div class="md:hidden space-y-4 bg-white">
          <div class="block md:hidden text-lg font-semibold mb-2">Riwayat Aktivitas</div>
          @foreach ($aktivitas as $item)
          @php
            $warnaDinas = [
              'DTPHP'     => 'bg-green-600',
              'DKPP'      => 'bg-red-500',
              'DISPERINDAG'=> 'bg-yellow-500',
              'PERIKANAN' => 'bg-teal-500',
            ];

            $ikonAksi = [
              'buat' => 'bi-plus-circle-fill',
              'ubah' => 'bi-pencil-square',
              'hapus' => 'bi-trash-fill',
            ];

            $bgColor = $warnaDinas[$item->dinas] ?? 'bg-gray-400';
            $ikon = $ikonAksi[$item->aksi] ?? 'bi-question-circle-fill';
          @endphp
      
            <div class="flex items-center justify-between border rounded-lg p-3 shadow-sm">
              <div class="flex items-center space-x-3">
                <div class="{{ $bgColor }} rounded-full p-2 text-white">
                  <i class="bi {{ $ikon }}"></i>
                </div>
                <div>
                  <div class="font-medium">{{ $item->aktivitas }}</div>
                  <div class="text-gray-600 text-sm">
                    {{ $item->nama_user }} ({{ $item->dinas }})
                  </div>
                </div>
              </div>
              <div class="text-gray-500 text-sm whitespace-nowrap">{{ $item->waktu }}</div>
            </div>
          @endforeach
        </div>
      
        <!-- Link Paginasi -->
        <div class="d-flex justify-content-center mt-4">
          {{ $aktivitas->links() }}
        </div>
      </div>
      

</x-pegawai-layout>