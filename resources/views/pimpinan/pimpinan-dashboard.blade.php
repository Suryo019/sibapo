<x-pimpinan-layout>
    <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-4 gap-6 p-4">
        <!-- Bahan Pokok -->
        <div class="flex w-full h-full bg-white border-[3px] border-gray-200 rounded-lg ">
          <div class="w-32 h-40 bg-pink-500 flex items-center justify-center rounded-lg">
            <iconify-icon icon="healthicons:vegetables" class="text-white text-8xl"></iconify-icon>
          </div>
          <div class="flex flex-col justify-center pl-5">
            <p class="text-xl text-black font-bold mb-1 ">Jumlah Bahan Pokok</p>
            <p class="text-3xl text-gray-900 font-bold text-center">{{ $jmlBahanPokok }}</p>
          </div>
        </div>
      
        <!-- Komoditas -->
        <div class="flex w-full h-full bg-white border-[3px] border-gray-200 rounded-lg ">
          <div class="w-32 h-40 bg-pink-500 flex items-center justify-center rounded-lg">
            <iconify-icon icon="carbon:agriculture-analytics" class="text-white text-8xl"></iconify-icon>
          </div>
          <div class="flex flex-col justify-center pl-5">
            <p class="text-xl text-black font-bold mb-1">Komoditas DTPHP</p>
            <p class="text-3xl text-gray-900 font-bold text-center">{{ $jmlKomoditas }}</p>
          </div>
        </div>
      
        <!-- Ikan -->
        <div class="flex w-full h-full bg-white border-[3px] border-gray-200 rounded-lg ">
          <div class="w-32 h-40 bg-pink-500 flex items-center justify-center rounded-lg">
            <iconify-icon icon="majesticons:fish" class="text-white text-8xl"></iconify-icon>
          </div>
          <div class="flex flex-col justify-center pl-5">
            <p class="text-xl text-black font-bold mb-1">Jumlah Ikan</p>
            <p class="text-3xl text-gray-900 font-bold text-center">{{ $jmlIkan }}</p>
          </div>
        </div>
      
        <!-- Pegawai Dinas -->
        <div class="flex w-full h-full bg-white border-[3px] border-gray-200 rounded-lg ">
          <div class="w-32 h-40 bg-pink-500 flex items-center justify-center rounded-lg">
            <iconify-icon icon="material-symbols:group" class="text-white text-8xl"></iconify-icon>
          </div>
          <div class="flex flex-col justify-center pl-5">
            <p class="text-xl text-black font-bold mb-1">Jumlah Pegawai Dinas</p>
            <p class="text-3xl text-gray-900 font-bold text-center">{{ $jmlPegawai }}</p>
          </div>
        </div>
      </div>
    
        
      
      <!-- MAIN SECTION -->
    <div class="grid grid-cols-3 gap-4 mb-6">
      <!-- Chart Placeholder -->
      <div class="col-span-2 bg-white border rounded-lg p-4">
        <div class="w-full h-64 bg-gray-100 flex items-center justify-center text-gray-400" id="chart">
        </div>
      </div>
  
      <!-- Donat Chart Placeholder -->
      <div class="bg-white border rounded-lg py-4">
        <div class="text-center font-semibold mb-4">Total komoditas ketahanan pangan<br>minggu ke {{ now()->weekOfMonth }}</div>
        <div class="w-full flex justify-center"  id="donutChart">
          {{-- pake ajax --}}
        </div>
      </div>
    </div>
  
    <!-- table -->
    <div class="bg-white border rounded-lg p-4">
      <table class="w-full text-center text-sm mb-4">
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
                $warnaDinas = [
                    'DISPERINDAG' => 'bg-yellow-500',
                    'DKPP'        => 'bg-red-500',
                    'DTPHP'       => 'bg-green-600',
                    'PERIKANAN'   => 'bg-teal-500',
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

      <!-- Link Paginasi -->
      <div class="d-flex justify-content-center">
          {{ $aktivitas->links() }}
      </div>
    </div>
  </x-pimpinan-layout>>

<script>

  $.ajax({
    type: 'GET',
    url: '/api/grafikdkpp',
    success: function(response) {
      const data = response.data;
      const categories = data.map(item => 'Minggu ' + item.minggu);
    
      const seimbang = data.map(item => item.Seimbang);
      const surplus = data.map(item => item.Surplus);
      const defisit = data.map(item => item.Defisit);
    
      const options = {
          chart: {
              type: 'bar',
              height: 400
          },
          series: [
              {
                  name: 'Seimbang',
                  data: seimbang
              },
              {
                  name: 'Surplus',
                  data: surplus
              },
              {
                  name: 'Defisit',
                  data: defisit
              }
          ],
          xaxis: {
              categories: categories,
              title: { text: 'Minggu ke-' }
          },
          yaxis: {
              title: { text: 'Jumlah Komoditas' }
          },
          title: {
              text: 'Neraca Komoditas Mingguan bulan {{ now()->month }}',
              align: 'center'
          },
          colors: ['#00E396', '#008FFB', '#FF4560'],
          dataLabels: {
              enabled: true
          }
      };
    
      const chart = new ApexCharts(document.querySelector("#chart"), options);
      chart.render();
    }
  });

  $.ajax({
    type: 'GET',
    url: '/api/persendkpp',
    success: function(response) {
      const labels = [];
      const values = [];

      response.persenKategoriDkpp.forEach(item => {
        const key = Object.keys(item)[0];
        const value = item[key];
        labels.push(key);
        values.push(value);
      });
      

      var options = {
        chart: {
          type: 'donut'
        },
        series: values,
        labels: labels,
        plotOptions: {
          pie: {
            donut: {
              labels: {
                show: true,
                total: {
                  show: true,
                }
              },
              size: '50%',
            }
          }
        },
        legend: {
          position: 'bottom',
          horizontalAlign: 'center'
        },
        responsive: [{
          breakpoint: 480,
          options: {
            chart: { width: 300 },
            legend: { position: 'bottom' }
          }
        }]
      };

      var chart = new ApexCharts(document.querySelector("#donutChart"), options);
      chart.render();
    }
  });
</script>
