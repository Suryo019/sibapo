{{-- @dd($data) --}}
<x-pimpinan-layout>

    <div class="flex justify-between items-center gap-4 my-4 max-md:justify-center">
    
        <!-- Search Component -->
        <x-search></x-search>
  
    
      {{-- Filter --}}
      <div class="flex justify-end w-96 max-md:w-full">
        <div class="relative flex justify-end w-full">
          <x-filter></x-filter>
    
          <!-- Modal Background -->
          <x-filter-modal>
            <form action="" method="get">
              <div class="space-y-4">
                <!-- pilih periode -->
                <div class="flex flex-col">
                  <label for="pilih_periode" class="block text-sm font-medium text-gray-700 mb-1 max-md:text-xs">
                    Pilih Periode
                  </label>
                  <select id="pilih_periode"
                    class="select2 w-full max-md:w-full rounded-full border border-gray-300 p-2 bg-white text-sm max-md:text-xs">
                    <option value="" disabled selected>Pilih Periode</option>
                    @foreach ($periods as $period)
                    <option value="{{ $period }}">{{ $period }}</option>
                    @endforeach
                  </select>
                </div>
  
                <!-- pilih minggu -->
                <div class="flex flex-col">
                  <label for="pilih_minggu" class="block text-sm font-medium text-gray-700 mb-1 max-md:text-xs">
                    Minggu ke
                  </label>
                  <select id="pilih_minggu"
                    class="select2 w-full max-md:w-full rounded-full border border-gray-300 p-2 bg-white text-sm max-md:text-xs"
                    disabled>
                    <option value="" disabled selected>Pilih Minggu</option>
                    <option value="1">Minggu 1</option>
                    <option value="2">Minggu 2</option>
                    <option value="3">Minggu 3</option>
                    <option value="4">Minggu 4</option>
                  </select>
                </div>
              </div>
  
              <div class="w-full flex justify-end gap-3 mt-10">
                <button type="reset"
                  class="bg-yellow-550 text-white rounded-lg w-20 p-2 text-sm hover:bg-yellow-600">Reset</button>
                <button type="submit"
                  class="bg-pink-650 text-white rounded-lg w-20 p-2 text-sm hover:bg-pink-700">Cari</button>
              </div>
            </form>
  
          </x-filter-modal>
        </div>
      </div>
    </div>
    
    <main class="flex-1 p-6 max-md:p-4 bg-gray-10 border-gray-20 border-[3px] rounded-[20px]">
      <div class="w-full flex items-center gap-2 mb-4">
        <a href="{{ route('pimpinan.dashboard') }}" class="flex-shrink-0 text-dark">
          <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="4" stroke="currentColor" class="w-6 h-6">
              <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 19.5L8.25 12l7.5-7.5" />
          </svg>
      </a>
        <h3 class="text-xl font-extrabold text-center max-md:text-base">Harga Ketersediaan</h3>
      </div>
    
      <!-- Chart Placeholder -->
      <div
        class="w-full bg-white rounded shadow-md flex items-center justify-center flex-col p-8 max-md:p-4 border bg-gray-10 border-gray-20">
        <div class="flex items-center flex-col mb-3 font-bold text-green-910 text-center max-md:text-xs">
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
    
    </main>
    
  </x-pimpinan-layout>
  
  <script>
    // ntar dihapus
   let periode = 'April 2025';
    let minggu = '4';
  
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
    // sampe sini
  
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
  
  // Trigger Filter Modal
  function toggleModal() {
          const modal = document.getElementById('filterModal');
          modal.classList.toggle('hidden');
          modal.classList.toggle('flex');
      }
  
      $("#filterBtn").on("click", function() {
          $("#filterModal").toggleClass("hidden");
      });
      // End Trigger Filter Modal
  </script>
  
  
  