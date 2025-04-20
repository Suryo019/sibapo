{{-- @dd($data) --}}
<x-pegawai-layout>
  <main class="flex-1 p-6">
      <h2 class="text-2xl font-semibold text-green-900">{{ $title }}</h2>
  
      <!-- Dropdown -->
      <div class="flex justify-end my-4">
        <!-- Dropdown Items -->
        <div class="flex gap-6 items-end">
          <!-- Pilih Pasar -->
          <div>
            <label for="pilih_periode" class="block text-sm font-medium text-gray-700 mb-1">
              Pilih Periode
            </label>
            <select id="pilih_periode" class="select2 w-36 rounded-full border border-gray-300 p-2 bg-white text-sm">
              <option value="" disabled selected>Pilih Periode</option>
              @foreach ($periods as $period)
                <option value="{{ $period }}">{{ $period }}</option>
              @endforeach
            </select>
          </div>

          <!-- Minggu ke -->
          <div>
            <label for="pilih_minggu" class="block text-sm font-medium text-gray-700 mb-1">
              Minggu ke
            </label>
            <select id="pilih_minggu" class="select2 w-36 rounded-full border border-gray-300 p-2 bg-white text-sm" disabled>
              <option value="" disabled selected>Pilih Minggu</option>
              <option value="1">Minggu 1</option>
              <option value="2">Minggu 2</option>
              <option value="3">Minggu 3</option>
              <option value="4">Minggu 4</option>
            </select>
          </div>
        </div>
      </div>

        
      
      <!-- Chart Placeholder -->
      <div class="w-full bg-white rounded shadow-md flex items-center justify-center flex-col p-8">
        <div class="flex items-center flex-col mb-3 font-bold text-green-910">
          <h3>Neraca Ketersediaan dan Kebutuhan Bahan Pangan Pokok</h3>
          <h3><b id="minggu"></b> <b id="periode"></b></h3>
          {{-- <h3>Minggu ke 2 Bulan April 2025</h3> --}}
        </div>

        <!-- Placeholder saat chart belum tersedia -->
        <div id="chart_placeholder" class="text-gray-500 text-center">
            Silakan pilih pasar, periode, dan bahan pokok untuk menampilkan data grafik.
        </div>

        <div id="chart" class="w-full hidden">
          {{-- Chartt --}}
        </div>
      </div>
  
      <!-- Button -->
      <div class="flex justify-center mt-4">
          <a href="{{ route('pegawai.dkpp.detail') }}">
              <button class="bg-green-700 text-white px-6 py-2 rounded-full hover:bg-green-800">
                  Lihat Detail Data
              </button>
          </a>
      </div>
  </main>
</x-pegawai-layout>

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


