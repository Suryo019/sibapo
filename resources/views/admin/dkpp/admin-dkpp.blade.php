{{-- @dd($data) --}}
<x-admin-layout>
  <main class="flex-1 p-6 max-md:p-4">
    {{-- <h2 class="text-2xl font-semibold text-green-900 mb-4 max-md:mb-10 max-md:text-xl max-md:text-center">{{ $title }}</h2> --}}

    <!-- Dropdown -->
    <div class="flex justify-end my-4">
      <div class="flex items-center justify-between w-full gap-6 max-md:flex-wrap max-md:gap-4">
        
        <!-- Search Component -->
        <x-search></x-search>
    
        <!-- Filter Component -->
        <x-filter></x-filter>
    
      </div>
    </div>
    

    <!-- Chart Placeholder -->
    <main class="flex-1 p-6 max-md:p-4 bg-gray-10 border-gray-20 border-[3px] rounded-[20px] relative">

      <div class="w-full flex items-center gap-2 mb-4">
        <a href="javascript:history.back()" class="text-decoration-none text-dark flex-shrink-0">
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="4" stroke="currentColor" class="w-6 h-6">
                <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 19.5L8.25 12l7.5-7.5" />
            </svg>                      
        </a>
        <h2 class="text-2xl font-semibold text-black max-md:text-xl max-md:text-center">
            {{ $title }}
        </h2>
    </div>

      <!-- Chart -->
      <div class="w-full bg-white rounded shadow-md flex flex-col items-center justify-center p-8 max-md:p-4 border bg-gray-10 border-gray-20">
        <div class="flex items-center flex-col mb-3 font-bold text-green-910 text-center max-md:text-[12px]">
          <h3>Neraca Ketersediaan dan Kebutuhan Bahan Pangan Pokok</h3>
          <h3><b id="minggu"></b> <b id="periode"></b></h3>
        </div>
    
        <!-- Placeholder saat chart belum tersedia -->
        <div id="chart_placeholder" class="text-gray-500 text-center text-sm max-md:text-xs">
          Silakan pilih pasar, periode, dan bahan pokok untuk menampilkan data grafik.
        </div>
    
        <div id="chart" class="w-full hidden">
          {{-- Chart --}}
        </div>
      </div>
    
      <!-- Button -->
      <div class="mt-6">
        <a href="{{ route('dkpp.detail') }}">
          <button class="bg-yellow-550 text-white px-6 py-2 rounded-xl hover:bg-yellow-500 text-sm max-md:text-xs max-md:px-4 max-md:py-1">
            Lihat Detail Data
          </button>
        </a>
      </div>
    </main>
    
  

  </main>
</x-admin-layout>

<script>
  var chart;
  var debounceTimer;

  $('#pilih_periode').on('change', function() {
    $('#pilih_minggu').prop('disabled', false);
  });

  $('#pilih_periode, #pilih_minggu').on('change', function() {
    clearTimeout(debounceTimer);
    debounceTimer = setTimeout(() => {
      let periode = $('#pilih_periode').val();
      let minggu = $('#pilih_minggu').val();

      $.ajax({
        type: 'GET',
        url: `{{ route('api.dkpp.index') }}`,
        data: {
          _token: "{{ csrf_token() }}",
          periode: periode,
          minggu: minggu,
        },
        success: function(response) {
          let dataset = response.data;
          
          if (!dataset || dataset.length === 0) {
            if (chart) {
              chart.destroy();
              chart = null;
            }
            
            $('#chart_placeholder').html(`
              <div class="text-center p-4 border-2 border-dashed border-gray-300 rounded-lg shadow-md bg-gray-50">
                <h3 class="text-lg font-semibold text-gray-500">Data Tidak Ditemukan</h3>
                <p class="text-gray-400">Tidak ada data untuk periode yang dipilih.</p>
              </div>
            `);
            return;
          }

          let ketersediaan = dataset.map(item => item.ton_ketersediaan);
          let kebutuhan = dataset.map(item => item.ton_kebutuhan_perminggu);
          let komoditas = dataset.map(item => item.jenis_komoditas);

          // Skip jika data sama
          if (chart && JSON.stringify(chart.w.config.series[0].data) === JSON.stringify(ketersediaan)) {
            return;
          }

          if (chart) {
            chart.destroy();
          }

          var options = {
            chart: {
              type: 'line',
              height: 350,
              animations: {
                enabled: true,
                easing: 'easeinout',
                speed: 800
              }
            },
            series: [{
              name: 'Ketersediaan (ton)',
              data: ketersediaan
            }, {
              name: 'Kebutuhan (ton)',
              data: kebutuhan
            }],
            xaxis: {
              categories: komoditas,
              labels: {
                style: {
                  fontSize: '12px'
                }
              }
            },
            yaxis: {
              title: {
                text: 'Ton'
              }
            },
            tooltip: {
              y: {
                formatter: function(value) {
                  return value + ' ton';
                }
              }
            }
          };

          $('#chart_placeholder').empty();
          $('#chart').removeClass('hidden');
          
          chart = new ApexCharts(document.querySelector("#chart"), options);
          chart.render();

          $('#minggu').text("Minggu ke-" + minggu);
          $('#periode').text(periode);
        },
        error: function(xhr) {
          $('#chart_placeholder').html(`
            <div class="text-center p-4 border-2 border-dashed border-red-200 rounded-lg shadow-md bg-red-50">
              <h3 class="text-lg font-semibold text-red-500">Error</h3>
              <p class="text-red-400">Gagal memuat data. Silakan coba lagi.</p>
            </div>
          `);
          console.error("AJAX Error:", xhr.responseText);
        }
      });
    }, 300);
  });
</script>


