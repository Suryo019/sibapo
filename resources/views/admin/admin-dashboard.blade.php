<x-admin-layout>

  <h1 class="block md:hidden text-center text-2xl font-bold text-black px-4 py-2">
    DASHBOARD
  </h1>
  <div class="grid grid-cols-3 gap-4 p-2 md:grid-cols-3">
    <!-- Card dashboard Anda -->
  </div>
  
  <div class="grid grid-cols-2 md:grid-cols-4 gap-4 p-4">
    <!-- Bahan Pokok -->
    <div class="flex bg-white border-[3px] border-gray-200 rounded-lg overflow-hidden">
      <div class="w-24 md:w-32 h-32 md:h-40 bg-pink-500 flex items-center justify-center rounded-lg">
        <iconify-icon icon="healthicons:vegetables" class="text-white text-3xl md:text-6xl"></iconify-icon>
      </div>
      <div class="flex flex-col justify-center pl-3 md:pl-5">
        <p class="text-sm md:text-xl text-black font-bold mb-1">Jumlah Bahan Pokok</p>
        <p class="text-xl md:text-3xl text-gray-900 font-bold text-center">{{ $jmlBahanPokok }}</p>
      </div>
    </div>
  
    <!-- Komoditas -->
    <div class="flex bg-white border-[3px] border-gray-200 rounded-lg overflow-hidden">
      <div class="w-24 md:w-32 h-32 md:h-40 bg-pink-500 flex items-center justify-center rounded-lg">
        <iconify-icon icon="carbon:agriculture-analytics" class="text-white text-3xl md:text-6xl"></iconify-icon>
      </div>
      <div class="flex flex-col justify-center pl-3 md:pl-5">
        <p class="text-sm md:text-xl text-black font-bold mb-1">Komoditas DTPHP</p>
        <p class="text-xl md:text-3xl text-gray-900 font-bold text-center">{{ $jmlKomoditas }}</p>
      </div>
    </div>
  
    <!-- Ikan -->
    <div class="flex bg-white border-[3px] border-gray-200 rounded-lg overflow-hidden">
      <div class="w-24 md:w-32 h-32 md:h-40 bg-pink-500 flex items-center justify-center rounded-lg">
        <iconify-icon icon="majesticons:fish" class="text-white text-3xl md:text-6xl"></iconify-icon>
      </div>
      <div class="flex flex-col justify-center pl-3 md:pl-5">
        <p class="text-sm md:text-xl text-black font-bold mb-1">Jumlah Ikan</p>
        <p class="text-xl md:text-3xl text-gray-900 font-bold text-center">{{ $jmlIkan }}</p>
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
  
    
        
      
     <!-- MAIN SECTION -->
    <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-6">
      <!-- Chart Placeholder -->
      <div class="md:col-span-2 bg-white border rounded-lg p-4">
        <div class="w-full h-64 bg-gray-100 flex items-center justify-center text-gray-400" id="chart">
          {{-- PAKE AJAX YGY --}}
        </div>
      </div>

      <!-- Donut Chart Placeholder -->
      <div class="bg-white border rounded-lg py-4">
        @php
            $mingguKe = now()->weekOfMonth > 4 ? 4 : now()->weekOfMonth;
        @endphp

        <div class="text-center font-semibold mb-4 text-sm md:text-base">
            Total komoditas ketahanan pangan<br>minggu ke {{ $mingguKe }}
        </div>
        <div class="w-full flex justify-center" id="donutChart">
          {{-- pake ajax --}}
        </div>
        {{-- 
        <div class="flex justify-center gap-6 text-sm mt-2">
          <div class="flex flex-col items-center gap-1">
            <div class="text-3xl font-bold">30%</div>
            <div class="flex gap-2 items-center">
              <div class="w-3 h-3 bg-green-500 rounded-full"></div>
              Surplus
            </div>
          </div>
          <div class="flex items-center gap-2">
            <div class="w-3 h-3 bg-red-500 rounded-full"></div>
            45% Defisit
          </div>
          <div class="flex items-center gap-2">
            <div class="w-3 h-3 bg-blue-500 rounded-full"></div>
            25% Seimbang
          </div>
        </div>
        --}}
      </div>
    </div>

  
    <!-- RIWAYAT AKTIVITAS - DESKTOP -->
    <div class="bg-white border rounded-lg p-4 hidden md:block">
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
                    'DISPERINDAG' => 'bg-yellow-500',
                    'DKPP'        => 'bg-red-500',
                    'DTPHP'       => 'bg-green-600',
                    'PERIKANAN'   => 'bg-teal-500',
                ];

                $ikonAksi = [
                    'buat'  => 'bi-plus-circle-fill',
                    'ubah'  => 'bi-pencil-square',
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
      <div class="flex justify-center">
        {{ $aktivitas->links() }}
      </div>
    </div>

<!-- RIWAYAT AKTIVITAS - MOBILE -->
<div class=" p-4 block md:hidden bg-white">
  <h2 class="text-lg font-semibold mb-4">Riwayat Aktivitas</h2>
  <div class="space-y-3">
    @foreach ($aktivitas as $item)
      @php
          $warnaDinas = [
              'DISPERINDAG' => 'bg-yellow-500',
              'DKPP'        => 'bg-red-500',
              'DTPHP'       => 'bg-green-600',
              'PERIKANAN'   => 'bg-teal-500',
          ];

          $ikonAksi = [
              'buat'  => 'bi-plus-circle-fill',
              'ubah'  => 'bi-pencil-square',
              'hapus' => 'bi-trash-fill',
          ];

          $bgColor = $warnaDinas[$item->dinas] ?? 'bg-gray-400';
          $ikon = $ikonAksi[$item->aksi] ?? 'bi-question-circle-fill';
      @endphp

      <div class="flex items-center justify-between border rounded-lg px-3 py-2">
        <div class="flex items-center gap-3">
          <div class="{{ $bgColor }} rounded flex justify-center items-center w-10 h-10">
            <i class="bi {{ $ikon }} text-white text-lg"></i>
          </div>
          <div>
            <p class="font-semibold leading-tight">{{ $item->aktivitas }}</p>
            <p class="text-xs text-gray-500">{{ $item->nama_user }} ({{ $item->dinas }})</p>
          </div>
        </div>
        <p class="text-sm text-gray-400 whitespace-nowrap">{{ $item->waktu }}</p>
      </div>
    @endforeach
  </div>

  <!-- Paginasi Mobile -->
  <div class="flex justify-center mt-4">
    {{ $aktivitas->links() }}
  </div>
</div>

  
  </x-admin-layout>>

<script>
$.ajax({type:"GET",url:"/api/grafikdkpp",success:function(e){const t=e.data,a=t.map((e=>"Minggu "+e.minggu)),n={chart:{type:"bar",height:400},series:[{name:"Seimbang",data:t.map((e=>e.Seimbang))},{name:"Surplus",data:t.map((e=>e.Surplus))},{name:"Defisit",data:t.map((e=>e.Defisit))}],xaxis:{categories:a,title:{text:"Minggu ke-"}},yaxis:{title:{text:"Jumlah Komoditas"}},title:{text:"Neraca Komoditas Mingguan bulan {{ now()->month }}",align:"center"},colors:["#00E396","#008FFB","#FF4560"],dataLabels:{enabled:!0}};new ApexCharts(document.querySelector("#chart"),n).render()}}),$.ajax({type:"GET",url:"/api/persendkpp",success:function(e){const t=[],a=[];e.persenKategoriDkpp.forEach((e=>{const n=Object.keys(e)[0],o=e[n];t.push(n),a.push(o)}));var n={chart:{type:"donut"},series:a,labels:t,plotOptions:{pie:{donut:{labels:{show:!0,total:{show:!0}},size:"50%"}}},legend:{position:"bottom",horizontalAlign:"center"},responsive:[{breakpoint:480,options:{chart:{width:300},legend:{position:"bottom"}}}]};new ApexCharts(document.querySelector("#donutChart"),n).render()}});
</script>
