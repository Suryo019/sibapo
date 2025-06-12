<x-pegawai-layout title="Dashboard">

  <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-6">
    <!-- Chart Placeholder -->
    <div class="md:col-span-2 bg-white border rounded-lg p-4">
      <div class="w-full h-64 md:h-80 bg-gray-100 flex items-center justify-center text-gray-400" id="chart">
        {{-- PAKE AJAX YGY --}}
      </div>
    </div>
  
    <!-- Donat Chart Placeholder -->
    <div class="bg-white border rounded-lg p-4">
      @php
          $mingguKe = now()->weekOfMonth > 4 ? 4 : now()->weekOfMonth;
      @endphp

      <div class="text-center font-semibold mb-4 text-sm md:text-base">
          Total komoditas ketahanan pangan<br>minggu ke {{ $mingguKe }}
      </div>
      <div class="w-full flex justify-center" id="donutChart">
        {{-- pake ajax --}}
      </div>
    </div>
  </div>
  
      <!-- table -->
      <div class="md:border bg-white rounded-lg p-4 mb-8 mt-4">
        <!-- DESKTOP -->
        <div class="hidden md:block">
          <table class="w-full text-center text-sm">
            <thead>
              <tr>
                <th class="p-2">No</th>
                <th class="p-2">Bahan Pokok</th>
                <th class="p-2">Ket</th>
                <th class="p-2">Ketersediaan Minggu ini</th>
                <th class="p-2">Ketersediaan Minggu lalu</th>
              </tr>
            </thead>
            <tbody>
              @foreach ($dataSelisih as $item)
              <tr class="border-t">
                <td class="p-2">{{ $loop->iteration }}</td>
                <td class="p-2">{{ $item['komoditas'] }}</td>
                <td class="p-2">
                  @if ($item['status'] == 'Naik')
                    <div class='bg-green-600 rounded flex justify-center items-center w-10 h-10 p-2'>
                      <i class="bi bi-arrow-up-circle-fill text-white"></i>
                    </div>
                  @elseif($item['status'] == 'Turun')
                    <div class='bg-red-500 rounded flex justify-center items-center w-10 h-10 p-2'>
                      <i class="bi bi-arrow-down-circle-fill text-white"></i>
                    </div>
                  @else
                    <div class='bg-blue-500 rounded flex justify-center items-center w-10 h-10 p-2'>
                      <i class="bi bi-dash-circle-fill text-white"></i>
                    </div>
                  @endif
                </td>
                <td class="p-2 {{ $item['keterangan_minggu_sekarang'] == 'Surplus' ?  'text-green-500' : ($item['keterangan_minggu_sekarang'] == 'Defisit' ? 'text-red-500' : ($item['keterangan_minggu_sekarang'] == 'Seimbang' ? 'text-blue-600' : 'text-gray-400')) }}">
                  {{ $item['keterangan_minggu_sekarang'] }}
                </td>
                <td class="p-2 {{ $item['keterangan_minggu_lalu'] == 'Surplus' ?  'text-green-500' : ($item['keterangan_minggu_lalu'] == 'Defisit' ? 'text-red-500' : ($item['keterangan_minggu_lalu'] == 'Seimbang' ? 'text-blue-600' : 'text-gray-400')) }}">
                  {{ $item['keterangan_minggu_lalu'] }}
                </td>
              </tr>
              @endforeach
            </tbody>
          </table>
        </div>
      
        <!-- MOBILE -->
        <div class="md:hidden space-y-4">
          <div class="block md:hidden text-lg font-semibold mb-2">Produk</div>
          @foreach ($dataSelisih as $item)
          <div class="flex items-center justify-between border rounded-lg p-3 shadow-sm">
            <div class="flex items-center space-x-3">
              @php
                  $bg = $item['status'] == 'Naik' ? 'bg-green-600' : ($item['status'] == 'Turun' ? 'bg-red-500' : 'bg-blue-500');
                  $icon = $item['status'] == 'Naik' ? 'bi-arrow-up-circle-fill' : ($item['status'] == 'Turun' ? 'bi-arrow-down-circle-fill' : 'bi-dash-circle-fill');
              @endphp
              <div class="{{ $bg }} rounded-full p-2 text-white">
                <i class="bi {{ $icon }}"></i>
              </div>
              <div>
                <div class="font-medium">{{ $item['komoditas'] }}</div>
                <div class="text-sm">
                  <span class="{{ $item['keterangan_minggu_sekarang'] == 'Surplus' ? 'text-green-500' : ($item['keterangan_minggu_sekarang'] == 'Defisit' ? 'text-red-500' : ($item['keterangan_minggu_sekarang'] == 'Seimbang' ? 'text-blue-600' : 'text-gray-400')) }}">
                    Minggu ini: {{ $item['keterangan_minggu_sekarang'] }}
                  </span><br>
                  <span class="{{ $item['keterangan_minggu_lalu'] == 'Surplus' ? 'text-green-500' : ($item['keterangan_minggu_lalu'] == 'Defisit' ? 'text-red-500' : ($item['keterangan_minggu_lalu'] == 'Seimbang' ? 'text-blue-600' : 'text-gray-400')) }}">
                    Minggu lalu: {{ $item['keterangan_minggu_lalu'] }}
                  </span>
                </div>
              </div>
            </div>
          </div>
          @endforeach
        </div>
      </div>
      
  
    <!-- TABLE -->
    <div class="bg-white md:border border-0 rounded-lg p-4 mb-8">
      <!-- DESKTOP -->
      <div class="hidden md:block ">
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
                  $ikon = $ikonAksi[$item->aksi] ?? 'bi-question-circle-fill';
              @endphp
              <tr class="border-t">
                <td class="p-2">{{ $item->waktu }}</td>
                <td class="p-2 flex justify-center">
                  <div class="bg-red-500 rounded flex justify-center items-center w-10 h-10 p-2">
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
        <div class="text-lg font-semibold mb-2">Riwayat Aktivitas</div>
        @foreach ($aktivitas as $item)
          @php
              $ikonAksi = [
                  'buat' => 'bi-plus-circle-fill',
                  'ubah' => 'bi-pencil-square',
                  'hapus' => 'bi-trash-fill',
              ];
              $ikon = $ikonAksi[$item->aksi] ?? 'bi-question-circle-fill';
          @endphp
          <div class="border rounded-lg p-3 flex items-start justify-between space-x-3">
            <div class="bg-red-500 rounded-full p-2 text-white">
              <i class="bi {{ $ikon }}"></i>
            </div>
            <div class="flex-1">
              <div class="font-medium">{{ $item->aktivitas }}</div>
              <div class="text-sm text-gray-600">
                {{ $item->nama_user }} ({{ $item->dinas }})
              </div>
            </div>
            <div class="text-xs text-gray-500 whitespace-nowrap">
              {{ $item->waktu }}
            </div>
          </div>
        @endforeach
      </div>
    
      <!-- Paginasi -->
      <div class="d-flex justify-content-center mt-4">
        {{ $aktivitas->links() }}
      </div>
    </div>
    
  
  </x-pegawai-layout>

  <script>
$.ajax({type:"GET",url:"/api/grafikdkpp",success:function(e){const t=e.data,a=t.map((e=>"Minggu "+e.minggu)),n={chart:{type:"bar",height:400},series:[{name:"Seimbang",data:t.map((e=>e.Seimbang))},{name:"Surplus",data:t.map((e=>e.Surplus))},{name:"Defisit",data:t.map((e=>e.Defisit))}],xaxis:{categories:a,title:{text:"Minggu ke-"}},yaxis:{title:{text:"Jumlah Komoditas"}},title:{text:"Neraca Komoditas Mingguan bulan {{ now()->month }}",align:"center"},colors:["#00E396","#008FFB","#FF4560"],dataLabels:{enabled:!0}};new ApexCharts(document.querySelector("#chart"),n).render()}}),$.ajax({type:"GET",url:"/api/persendkpp",success:function(e){const t=[],a=[];e.persenKategoriDkpp.forEach((e=>{const n=Object.keys(e)[0],o=e[n];t.push(n),a.push(o)}));var n={chart:{type:"donut"},series:a,labels:t,plotOptions:{pie:{donut:{labels:{show:!0,total:{show:!0}},size:"50%"}}},legend:{position:"bottom",horizontalAlign:"center"},responsive:[{breakpoint:480,options:{chart:{width:300},legend:{position:"bottom"}}}]};new ApexCharts(document.querySelector("#donutChart"),n).render()}});
</script>