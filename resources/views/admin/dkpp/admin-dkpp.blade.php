{{-- @dd($data) --}}
<x-admin-layout>
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
            <a href="{{ route('dkpp.detail') }}">
                <button class="bg-green-700 text-white px-6 py-2 rounded-full hover:bg-green-800">
                    Lihat Detail Data
                </button>
            </a>
        </div>
    </main>
</x-admin-layout>

<script>
  var chart;

  $('#pilih_periode').on('change', function() {
    $('#pilih_minggu').removeAttr('disabled');
  });

  // Saat salah satu berubah (periode / minggu)
  $('#pilih_periode, #pilih_minggu').on('change', function () {
    let periode = $('#pilih_periode').val();
    let minggu = $('#pilih_minggu').val();

    // Hanya jalankan kalau dua-duanya dipilih
    if (periode && minggu) {
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
          
          let ketersediaan = [];
          let kebutuhan = [];
          let komoditas = [];

          if (!dataset || dataset.length === 0) {
            $('#chart_placeholder').html("<p>Data tidak tersedia untuk periode dan minggu ini</p>");
            $('#chart').addClass('hidden');
            return;
          }

          $.each(dataset, function(_, value) {
            ketersediaan.push(value.ton_ketersediaan);
            kebutuhan.push(value.ton_kebutuhan_perminggu);
            komoditas.push(value.jenis_komoditas);
          });

          // Hapus chart lama jika ada
          if (chart) {
            chart.destroy();
          }

          var options = {
            chart: {
                type: 'line',
                height: 350
            },
            series: [{
                name: 'Ketersediaan',
                data: ketersediaan
            }, {
                name: 'Kebutuhan',
                data: kebutuhan
            }],
            xaxis: {
                categories: komoditas,
            }
          };

          $('#chart_placeholder').hide();
          $('#chart').removeClass('hidden');

          chart = new ApexCharts(document.querySelector("#chart"), options);
          chart.render();

          // Update label teks periode & minggu
          $('#minggu').text("Minggu ke " + minggu);
          $('#periode').text("Bulan " + periode);

        },
        error: function(xhr) {
          console.log("AJAX Error: ", xhr.responseText);
        }
      });
    }
  });
</script>


