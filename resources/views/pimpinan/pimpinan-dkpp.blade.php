<x-pimpinan-layout>

    <!-- Dropdown -->
    <div class="flex justify-end my-4">
      <div class="flex items-center justify-between w-full gap-6 max-md:flex-wrap max-md:gap-4">
        
        <!-- Search Component -->
        <x-search>Cari minggu...</x-search>

        <!-- Filter -->
        <div class="flex justify-end max-md:w-full">
          <x-filter />

          <!-- Modal Background -->
          <x-filter-modal>
            <form action="" method="get">
              <div class="space-y-4">
                
                <!-- Pilih Periode -->
                <div class="flex flex-col">
                  <label for="periode" class="block text-sm font-medium text-gray-700 mb-1">Pilih Periode</label>
                  <input type="month" value="{{ date('Y-m') }}" name="periode" id="periode" class="border border-black p-2 rounded bg-white w-full">
                </div>
              </div>
  
              <!-- Buttons -->
              <div class="w-full flex justify-end gap-3 mt-10">
                <button type="reset" class="bg-yellow-550 text-white rounded-lg w-20 p-1">
                  Reset
                </button>
                <button type="button" id="filterSubmitBtn" class="bg-pink-650 text-white rounded-lg w-20 p-1">
                  Cari
                </button>
              </div>
            </form></x-filter-modal> 
        </div> 
      </div> 
    </div>

    <!-- Chart Placeholder -->
    <main class="flex-1 p-6 max-md:p-4 bg-gray-10 border-gray-20 border-[3px] rounded-[20px] relative">
      <div class="w-full flex items-center justify-between gap-2 mb-5 max-md:flex-col max-md:items-start max-md:gap-1">
        <div class="flex items-center justify-start max-md:gap-3">
          <a href="javascript:history.back()" class="text-decoration-none text-dark flex-shrink-0">
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="4" stroke="currentColor" class="w-6 h-6">
              <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 19.5L8.25 12l7.5-7.5" />
            </svg>
          </a>
          <h2 class="text-2xl font-semibold text-black max-md:text-xl max-md:text-center">
            DATA KETERSEDIAAN <span id="periode_placeholder"></span>
          </h2>
        </div>
      </div>

      <!-- Chart Card -->
      <div class="w-full flex items-center justify-center flex-col" id="chart_container">
            {{-- Diisi pake ajax --}}
      </div>
    </main>

</x-pimpinan-layout>

<script>
  const periode = $('#periode');
  const search = $('#search');

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

  let charts = [];

  // Fungsi Render Chart dari Response
  function renderChartFromData(response) {
    const dataset = response.data;
    $('#chart_container').empty();
    charts.forEach(c => c.destroy());
    charts = [];

    const allWeeks = [1, 2, 3, 4];

    allWeeks.forEach((mingguKe) => {
      const dataPerMinggu = dataset[mingguKe] || [];
      const labels = dataPerMinggu.map(item => item.nama_komoditas);
      const ketersediaan = dataPerMinggu.map(item => item.ton_ketersediaan);
      const kebutuhan = dataPerMinggu.map(item => item.ton_kebutuhan_perminggu);

      const chartId = `chart-minggu-${mingguKe}`;
      $('#chart_container').append(`
        <div class="mb-5 w-full rounded-2xl bg-white shadow-md p-4 border">
          <h2 class="text-center text-lg font-semibold text-gray-700 mb-2 keterangan_minggu">Minggu ke-${mingguKe}</h2>
          <div id="${chartId}" class="shadow border rounded-md p-2 bg-white"></div>
        </div>
      `);

      const options = {
        chart: {
          type: 'line',
          height: 350
        },
        series: [
          {
            name: 'Ketersediaan (ton)',
            data: ketersediaan.length ? ketersediaan : [0]
          },
          {
            name: 'Kebutuhan (ton)',
            data: kebutuhan.length ? kebutuhan : [0]
          }
        ],
        xaxis: {
          categories: labels.length ? labels : ['Tidak ada data'],
          labels: { style: { fontSize: '12px' } }
        },
        yaxis: {
          title: { text: 'Ton' }
        },
        tooltip: {
          y: {
            formatter: value => `${value} ton`
          }
        }
      };

      const newChart = new ApexCharts(document.querySelector(`#${chartId}`), options);
      newChart.render();
      charts.push(newChart);
    });
  }


  function fetchDataAndRenderChart() {
    $.ajax({
      type: 'GET',
      url: `{{ route('api.dkpp.index') }}`,
      data: {
        _token: "{{ csrf_token() }}",
        periode: periode.val()
      },
      success: function (response) {
        console.log(response);
        
        $('#periode_placeholder').html(`- ${response.periode.toUpperCase()}`)
        renderChartFromData(response);
      },
      error: function (xhr) {
        $('#chart_container').html(`
          <div class="text-center p-4 border-2 border-dashed border-red-200 rounded-lg shadow-md bg-red-50">
            <h3 class="text-lg font-semibold text-red-500">Error</h3>
            <p class="text-red-400">Gagal memuat data. Silakan coba lagi.</p>
          </div>
        `);
        console.error("AJAX Error:", xhr.responseText);
      }
    });
  }

  $(document).ready(function () {
    fetchDataAndRenderChart();
  });

  $('#filterSubmitBtn').on('click', function () {
    fetchDataAndRenderChart();
  });

  // Search
  search.on("input", function () {
        const input_value = $(this).val().toLowerCase();
        let keterangan_minggu = $(".keterangan_minggu");

        keterangan_minggu.each(function () {
            let item_text = $(this).text().toLowerCase();

            if (item_text.includes(input_value)) {
                $(this).parent().removeClass("hidden");
            } else {
                $(this).parent().addClass("hidden");
            }
        });
    });
</script>


