{{-- @dd($jmlPegawai) --}}

<x-pegawai-layout>
  <h1 class="block md:hidden text-center text-xl font-bold text-black px-4 py-2">
    DASHBOARD
  </h1>
  <div class="grid grid-cols-3 gap-6 p-2">
    <!-- Bahan Pokok -->
    <div class="flex flex-col md:flex-row w-full bg-white border-[3px] border-gray-200 rounded-lg">
      <div class="w-full md:w-32 h-32 md:h-40 bg-pink-500 flex items-center justify-center rounded-lg ">
        <iconify-icon icon="healthicons:vegetables" class="text-white text-3xl md:text-6xl"></iconify-icon>
      </div>
      <div class="flex flex-col justify-center items-center md:items-start px-4 py-2 text-center md:text-left">
        <p class="text-base md:text-xl text-black font-bold mb-1">Jumlah Bahan Pokok</p>
        <p class="text-lg md:text-3xl text-gray-900 font-bold">{{ $jmlBahanPokok }}</p>
      </div>
    </div>
  
    <!-- Jumlah Pasar -->
    <div class="flex flex-col md:flex-row w-full bg-white border-[3px] border-gray-200 rounded-lg">
      <div class="w-full md:w-32 h-32 md:h-40 bg-pink-500 flex items-center justify-center rounded-lg ">
        <iconify-icon icon="carbon:agriculture-analytics" class="text-white text-3xl md:text-6xl"></iconify-icon>
      </div>
      <div class="flex flex-col justify-center items-center md:items-start px-4 py-2 text-center md:text-left">
        <p class="text-base md:text-xl text-black font-bold mb-1">Jumlah Pasar</p>
        <p class="text-lg md:text-3xl text-gray-900 font-bold">{{ $jmlPasar }}</p>
      </div>
    </div>
  
    <!-- Pegawai Disperindag -->
    <div class="flex flex-col md:flex-row w-full bg-white border-[3px] border-gray-200 rounded-lg">
      <div class="w-full md:w-32 h-32 md:h-40 bg-pink-500 flex items-center justify-center rounded-lg ">
        <iconify-icon icon="material-symbols:group" class="text-white text-3xl md:text-6xl"></iconify-icon>
      </div>
      <div class="flex flex-col justify-center items-center md:items-start px-4 py-2 text-center md:text-left">
        <p class="text-base md:text-xl text-black font-bold mb-1">Jumlah Pegawai Dinas Disperindag</p>
        <p class="text-lg md:text-3xl text-gray-900 font-bold">{{ $jmlPegawai }}</p>
      </div>
    </div>
  </div>
  
      <!-- table -->
      <div class="bg-white md:border rounded-lg p-4 mb-8 mt-4">
        <div class="hidden md:block">
          <table class="w-full text-center text-sm">
            <thead>
              <tr>
                <th class="p-2">No</th>
                <th class="p-2">Bahan Pokok</th>
                <th class="p-2">Ket</th>
                <th class="p-2">Harga Rata-rata hari ini</th>
                <th class="p-2">Perubahan harga</th>
              </tr>
            </thead>
            <tbody id="tabel-komoditas">
              {{-- PAKE AJAAAXX --}}
            </tbody>
          </table>
        </div>
      
        <!-- MOBILE -->
        <div class="md:hidden space-y-4" id="kartu-komoditas">
          <div class="block md:hidden text-lg font-semibold mb-2">Produk</div>
          <div class="flex items-center justify-between border rounded-lg p-3 shadow-sm">
            <div class="flex items-center space-x-3">
              <div class="rounded-full p-1 bg-green-100 text-green-600">
                <!-- Panah naik -->
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 10l7-7m0 0l7 7m-7-7v18" />
                </svg>
              </div>
              <div>
                <div class="font-semibold">Beras</div>
                <div class="text-gray-500 text-sm">Harga rata-rata Rp. 10.000</div>
              </div>
            </div>
            <div class="text-green-600 font-semibold text-sm">+ Rp. 1.500</div>
          </div>
          {{-- PAKE AJAAAXX --}}
        </div>
      </div>
      

  
    <!-- table -->
    <div class="bg-white md:border rounded-lg p-4">
      <!-- DESKTOP -->
      <div class="hidden md:block">
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
      </div>
    
      <!-- MOBILE -->
      <div class="md:hidden space-y-4">
        <div class="block md:hidden text-lg font-semibold mb-2">Riwayat Aktivitas</div>
        @foreach ($aktivitas as $item)
          @php
              $ikonAksi = [
                  'buat' => 'bi-plus-circle-fill',
                  'ubah' => 'bi-pencil-square',
                  'hapus' => 'bi-trash-fill',
              ];
              $ikon = $ikonAksi[$item->aksi] ?? 'bi-question-circle-fill'
          @endphp
          <div class="flex items-center justify-between border rounded-lg p-3 shadow-sm">
            <div class="flex items-center space-x-3">
              <div class="rounded-full p-2 bg-yellow-400 text-white">
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
    
  
  </x-pegawai-layout>>

<script>

$.ajax({
  type: 'GET',
  url: "{{ route('api.beranda.index') }}",
  success: function(response) {
    const data = response.data;
    const tbody = document.getElementById("tabel-komoditas");

    data.forEach((item, index) => {
      let ikon = '';
      if (item.selisih > 0) {
        ikon = `<div class='bg-green-600 rounded flex justify-center items-center w-10 h-10 p-2'><i class="bi bi-arrow-up-circle-fill text-white"></i></div>`;
      } else if (item.selisih < 0) {
        ikon = `<div class='bg-red-500 rounded flex justify-center items-center w-10 h-10 p-2'><i class="bi bi-arrow-down-circle-fill text-white"></i></div>`;
      } else {
        ikon = `<div class='bg-gray-400 rounded flex justify-center items-center w-10 h-10 p-2'><i class="bi bi-dash-circle-fill text-white"></i></div>`
      }

      const hargaHariIni = item.rata_rata_hari_ini ? `Rp. ${item.rata_rata_hari_ini.toLocaleString()}` : '-';
      const selisih = item.selisih > 0 
        ? `+ Rp. ${item.selisih.toLocaleString()}`
        : item.selisih < 0
          ? `- Rp. ${Math.abs(item.selisih).toLocaleString()}`
          : 'Rp. 0';

      const tr = `
        <tr class="border-t">
          <td class="p-2">${index + 1}</td>
          <td class="p-2">${item.komoditas}</td>
          <td class="p-2">${ikon}</td>
          <td class="p-2">${hargaHariIni}</td>
          <td class="p-2">${selisih}</td>
        </tr>
      `;
      tbody.innerHTML += tr;
    });
  }
});

</script>