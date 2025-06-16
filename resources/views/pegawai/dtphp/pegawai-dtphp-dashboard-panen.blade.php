<x-pegawai-layout title="Dashboard Panen">
  
  <h1 class="block md:hidden text-center text-2xl font-bold text-black px-4 py-2">
    DASHBOARD
  </h1>
  <div class="grid grid-cols-2 md:grid-cols-4 gap-4 p-4">
    <!-- Komoditas -->
    <div class="flex bg-white border-[3px] border-gray-200 rounded-lg overflow-hidden">
        <div class="w-24 md:w-32 h-32 md:h-40 bg-pink-500 flex items-center justify-center rounded-lg">
            <iconify-icon icon="carbon:agriculture-analytics" class="text-white text-3xl md:text-6xl"></iconify-icon>
        </div>
        <div class="flex flex-col justify-center pl-3 md:pl-5">
            <p class="text-sm md:text-xl text-black font-bold mb-1">Jumlah Komoditas</p>
            <p class="text-xl md:text-3xl text-gray-900 font-bold text-center">{{ $jmlKomoditas }}</p>
        </div>
    </div>

    <!-- Volume Produksi -->
    <div class="flex bg-white border-[3px] border-gray-200 rounded-lg overflow-hidden">
        <div class="w-24 md:w-32 h-32 md:h-40 bg-pink-500 flex items-center justify-center rounded-lg">
            <iconify-icon icon="carbon:agriculture-analytics" class="text-white text-3xl md:text-6xl"></iconify-icon>
        </div>
        <div class="flex flex-col justify-center pl-3 md:pl-5">
            <p class="text-sm md:text-xl text-black font-bold mb-1">Jumlah Volume Produksi</p>
            <p class="text-xl md:text-3xl text-gray-900 font-bold text-center">{{ $jmlProduksi }}</p>
        </div>
    </div>

    <!-- Luas Panen -->
    <div class="flex bg-white border-[3px] border-gray-200 rounded-lg overflow-hidden">
        <div class="w-24 md:w-32 h-32 md:h-40 bg-pink-500 flex items-center justify-center rounded-lg">
            <iconify-icon icon="majesticons:fish" class="text-white text-3xl md:text-6xl"></iconify-icon>
        </div>
        <div class="flex flex-col justify-center pl-3 md:pl-5">
            <p class="text-sm md:text-xl text-black font-bold mb-1">Jumlah Luas Panen</p>
            <p class="text-xl md:text-3xl text-gray-900 font-bold text-center">{{ $jmlPanen }}</p>
        </div>
    </div>

    <!-- Pegawai Dinas -->
    <div class="flex bg-white border-[3px] border-gray-200 rounded-lg overflow-hidden">
        <div class="w-24 md:w-32 h-32 md:h-40 bg-pink-500 flex items-center justify-center rounded-lg">
            <iconify-icon icon="material-symbols:group" class="text-white text-3xl md:text-6xl"></iconify-icon>
        </div>
        <div class="flex flex-col justify-center pl-3 md:pl-5">
            <p class="text-sm md:text-xl text-black font-bold mb-1">Jumlah Pegawai Dinas</p>
            <p class="text-xl md:text-3xl text-gray-900 font-bold text-center">{{ $jmlPegawai }}</p>
        </div>
    </div>
  </div>


      <!-- Tombol Switch -->
      <div class="flex w-full overflow-x-auto ml-4">
        <a href="{{ route('pegawai.dtphp.dashboard') }}">
            <button class="text-gray-400 rounded-t-xl bg-gray-100 px-4 py-3 shadow-md text-sm border bg-gray-10 border-gray-20 {{ request()->routeIs('dtphp.detail.panen') ? 'font-bold' : '' }} max-md:text-xs max-md:px-3 max-md:py-2">
                Volume Produksi
            </button>
        </a>
        <a href="{{ route('pegawai.dtphp.dashboard.panen') }}">
            <button class="text-pink-500 rounded-t-xl bg-white px-4 py-3 shadow-md text-sm border bg-gray-10 border-gray-20 {{ request()->routeIs('dtphp.detail.produksi') ? 'font-bold' : '' }} max-md:text-xs max-md:px-3 max-md:py-2">
                Luas Panen
            </button>
        </a>
      </div>
      <!-- table -->
      <!-- DESKTOP -->
      <div class="bg-white border rounded-lg p-4 mb-8 hidden md:block">
        <h2 class="text-lg font-semibold mb-4">Luas Panen</h2>
        <table class="w-full text-center text-sm">
          <thead>
            <tr>
              <th class="p-2">No</th>
              <th class="p-2">Komoditas</th>
              <th class="p-2">Ket</th>
              <th class="p-2">Luas panen bulan ini</th>
              <th class="p-2">Perubahan luas panen</th>
            </tr>
          </thead>
          <tbody>
            @foreach ($dataTabel ?? [] as $item)
              <tr class="border-t">
                <td class="p-2">{{ $item['no'] }}</td>
                <td class="p-2">{{ ucfirst($item['jenisKomoditas']) }}</td>
                <td class="p-2">
                  <iconify-icon icon="{{ $item['icon'] }}" class="text-xl"></iconify-icon>
                </td>
                <td class="p-2">{{ number_format($item['panen']) }} HA</td>
                <td class="p-2">
                  {{ $item['perubahan'] > 0 ? '+' : '' }}{{ number_format($item['perubahan']) }} HA
                </td>
              </tr>
            @endforeach
          </tbody>
        </table>

        <!-- Paginasi Desktop -->
        <div class="d-flex justify-content-center mt-4">
          {{ $dataTabel->links() }}
        </div>
      </div>

        <!-- MOBILE -->
        <div class="bg-white border rounded-lg p-4 mb-8 space-y-3 md:hidden">
          <h2 class="text-lg font-semibold mb-4">Luas Panen</h2>
          @foreach ($dataTabel ?? [] as $item)
            @php
              $isNaik = $item['perubahan'] > 0;
              $iconColor = $isNaik ? 'bg-green-100 text-green-600' : 'bg-red-100 text-red-600';
              $sign = $isNaik ? '+' : '';
            @endphp

            <div class="flex items-center justify-between border rounded-lg px-3 py-2">
              <div class="flex items-center gap-3">
                <div class="{{ $iconColor }} w-8 h-8 flex items-center justify-center rounded-full">
                  <iconify-icon icon="{{ $item['icon'] }}" class="text-lg"></iconify-icon>
                </div>
                <div class="text-left text-sm">
                  <div class="font-semibold">{{ ucfirst($item['jenisKomoditas']) }}</div>
                  <div class="text-xs text-gray-500">
                    Luas panen bulan ini Rp. {{ number_format($item['panen']) }}
                  </div>
                </div>
              </div>
              <div class="text-sm font-medium {{ $isNaik ? 'text-green-600' : 'text-red-600' }}">
                {{ $sign }}{{ number_format($item['perubahan']) }} ha
              </div>
            </div>
          @endforeach

          <!-- Paginasi Mobile -->
          <div class="d-flex justify-content-center mt-4">
            {{ $dataTabel->links() }}
          </div>
        </div>


       <!-- TABLE -->
    <!-- DESKTOP -->
    <div class="bg-white border rounded-lg p-4 mb-6 hidden md:block">
      <table class="w-full text-center text-sm">
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
                    'DTPHP' => 'bg-green-600',
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

      <!-- Paginasi Desktop -->
      <div class="d-flex justify-content-center mt-4">
        {{ $aktivitas->links() }}
      </div>
    </div>

    <!-- MOBILE -->
    <div class="bg-white border rounded-lg p-4 mb-6 space-y-3 md:hidden">
      @foreach ($aktivitas as $item)
        @php
            $warnaDinas = [
                'DTPHP' => 'bg-green-600',
            ];

            $ikonAksi = [
                'buat' => 'bi-plus-circle-fill',
                'ubah' => 'bi-pencil-square',
                'hapus' => 'bi-trash-fill',
            ];

            $bgColor = $warnaDinas[$item->dinas] ?? 'bg-gray-400';
            $ikon = $ikonAksi[$item->aksi] ?? 'bi-question-circle-fill';
        @endphp

        <div class="flex items-center justify-between border rounded-lg p-3">
          <div class="flex items-center gap-3">
            <div class="{{ $bgColor }} w-10 h-10 flex items-center justify-center rounded">
              <i class="bi {{ $ikon }} text-white text-xl"></i>
            </div>
            <div class="text-left text-sm">
              <div class="font-semibold">{{ $item->aktivitas }}</div>
              <div class="text-xs text-gray-500">Oleh {{ $item->nama_user }} ({{ $item->dinas }})</div>
            </div>
          </div>
          <div class="text-xs text-right text-gray-500 whitespace-nowrap">
            {{ $item->waktu }}
          </div>
        </div>
      @endforeach

      <!-- Paginasi Mobile -->
      <div class="d-flex justify-content-center mt-4">
        {{ $aktivitas->links() }}
      </div>
    </div>


</x-pegawai-layout>